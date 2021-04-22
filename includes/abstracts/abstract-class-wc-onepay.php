<?php if ( ! defined( 'ABSPATH' ) ) die;

if ( ! class_exists( 'Wc_OnePay_Gateway' ) ) {

/**
 * Abstract class that will be inherited by all payment methods in gateway.
 *
 * @link       https://github.com/1pay/wc-onepay
 * @author     1Pay <suporte.ti@gmail.com>
 * @since      1.0.0
 * @package    wc-onepay
 * @subpackage wc-onepay/includes/abstracts/
 * 
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 * @link       https://github.com/santanamic/wc-z4money
 */
	abstract class Wc_OnePay_Gateway extends WC_Payment_Gateway 
	{
		use Wc_OnePay_Base_Method_General;
		use Wc_OnePay_Base_Method_CredtCard;
		use Wc_OnePay_Base_Method_Boleto;
		
		public $api;
		public $logger;
	
		/**
		 * Init payment method.
		 *
		 * @param    string    $environment     Environment type, use sandbox or production.
		 * @return   void
		 */
		protected function init_gateway() 
		{
			$this->init_form_fields();
			$this->init_settings();
			
			$this->title       = $this->get_option( 'title' );
			$this->description = $this->get_option( 'description' );
			$this->enabled     = $this->get_option( 'enabled' );
			$this->has_fields  = true;
			$this->supports    = array( 'products', 'refunds', 'cancellation' );

			$this->debug       = 'yes' === $this->get_option( 'debug' );
			$this->is_enabled  = 'yes' === $this->get_option( 'enabled' );
			
			$this->logger      = new Wc_OnePay_Logger();
		
			$this->init_api();
			$this->init_logger();
			$this->init_hooks();
			$this->init_require();
		} 

		/**
		 * Init API.
		 *
		 * @return   void
		 */
		protected function init_api() 
		{	
			$this->api = new Wc_OnePay_Api( $this );
			
			$config_webook = get_option( 'IS_OnePay_URL', 'no' );
			
			if( $config_webook !== 'yes' && $this->is_available() === true && is_admin() ) {
				$return_webhook = $this->api->add_webhook();
				if( $return_webhook['success'] == true ) {
					add_option( 'IS_OnePay_URL', 'yes' );
					update_option( 'IS_OnePay_URL', 'yes' );
				}
			}						
			
		}

		/**
		 * Process a refund if supported.
		 *
		 * @param  int    $order_id Order ID.
		 * @param  float  $amount Refund amount.
		 * @param  string $reason Refund reason.
		 * @return bool|WP_Error
		 */ 
		 
		public function process_refund( $order_id, $amount = null, $reason = '' ) 
		{
			$this->logger->add( sprintf(__('Order refund process: %s', 'wc-onepay'), $order_id ) );
			$this->logger->add( sprintf(__('Order refund process $amount: %s', 'wc-onepay'), $amount ) );
			
			$order            = wc_get_order( $order_id );
			$payment_id       = $order->get_meta( 'ONEPAY_ID' ) ?: $order->get_meta( 'PAYMENT_ID' );
			$order_status     = $this->api->get_status( $payment_id );
			$order_status_id  = $order_status['venda']['status']['id'];
			$real_amount      = $amount ?: $order->order_total;
			$cents_amount     = ( $amount ?: $order->order_total ) * 100;

			switch ( $order_status_id ) {
				case '2': 
				case '5': 
				case '7': 
					$request = $this->api->do_payment_refund( $payment_id, $cents_amount );
					$this->logger->add( sprintf(__('Refund return request: %s', 'wc-onepay'), var_export( $request, true ) ) );

					if( $request['success'] === true ) {
						$order->add_order_note( sprintf(__( 'Refund request sent to the OnePay: value %s. See the OnePay administrative panel for more details.', 'wc-onepay' ), $real_amount ) );
						return true;
					} else {
						return false;
					}
				break;
			}
			
		}
		
		/**
		 *
		 * Notification request. Callback API for status changes
		 * Does not return the new status
		 *
		 * @access public
		 * @return void
		 *
		 */ 

		public function webhook() 
		{ @ob_clean();
		
			global $wpdb;
			
			$_payload =  json_decode( file_get_contents("php://input"), true );
			
			$this->logger->add( sprintf( __('OnePay Gateway received a URL notification: %s', 'wc-onepay'), var_export( $_payload, true ) ) );
			
			if( json_last_error() == JSON_ERROR_NONE ) {
				
				$order_id = absint( $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ONEPAY_ID' AND meta_value = %d", $_payload['data']['id'] ) ) );

				// for old plugin version
				if ( 0 === $order_id ) {
					$order_id = absint( $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'PAYMENT_ID' AND meta_value = %d", $_payload['data']['id'] ) ) );
				}
				
				$status   = $_payload['data']['status_pedido_id'];
				
				switch ( $status ) {
					case '3': 
						$this->update_order_status( ['id' => $order_id, 'update' => 'failed'] );
					break;
					
					case '4': 
						$this->update_order_status( ['id' => $order_id, 'update' => 'cancelled'] );
					break;
					
					case '6': 
						$this->update_order_status( ['id' => $order_id, 'update' => 'refunded'] );
					break;
					
					case '2': 
					case '7': 
					$this->update_order_status( ['id' => $order_id, 'update' => 'processing'] );
					break;
				}
				
			}
			
			exit;
		}
		
		/**
		 * Thank you page message.
		 *
		 * @return string
		 */
		public function thankyou_page( $order_id ) 
		{
			global $woocommerce;

			$order            = new WC_Order( $order_id );
			$payment_id       = $order->get_meta('ONEPAY_ID') ?: $order->get_meta('PAYMENT_ID');
			
			if( $order->has_status( 'on-hold' ) ) {
			
				$order_status     = $this->api->get_status( $payment_id );
				$order_status_id  = $order_status['venda']['status']['id'];	

				switch ( $order_status_id ) {
					case '3': 
					case '4': 
						$msg = '<div class="woocommerce-error">' . __( 'Your payment was not processed.', 'wc-onepay' ) . '</div>';
					break;
					
					case '2': 
					case '7': 
						$this->update_order_status( ['id' => $order_id, 'update' => 'processing'] );
						$msg = '<div class="woocommerce-message">' . __( 'Your payment has been received successfully.', 'wc-onepay' ) . '</div>';
					break;

					default: 
						$msg = '<div class="woocommerce-message">' . __( 'Awaiting payment confirmation.', 'wc-onepay' ) . '</div>';
					break;
				}

				echo $msg;
			
			}
		}

		/**
		 * Init Logger.
		 *
		 * @return   void
		 */
		protected function init_logger() 
		{			
			if ( true === $this->debug ) {
				$this->logger->enable_logger = true; 
			}
		}
		
		/**
		 * Include dependencies for payment method    
		 *
		 * @return   void
		 */
		public function init_require() 
		{
			if ( empty( STATIC::REQUIRE_FILES ) ) {
				return;
			}
	
			foreach ( STATIC::REQUIRE_FILES as $file ) {
				require_once( STATIC::METHOD_PATH . '/' . $file );
			}
		}
	
		/**
		 * Check the requirements for run the gateway in checkout    
		 *
		 * @return   boolean 
		 */
        public function is_available()
        {			
			$is_enabled                 = $this->is_enabled;
			$is_available_currency      = get_woocommerce_currency() == 'BRL';

			if ( $is_enabled && $is_available_currency ) {
				return true;
			}
			
			return false;
        }
		
		
	}	
}