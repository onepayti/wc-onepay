<?php if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Wc_Checkout_Brazilian_Fields' ) ) {

	/**
	 * Adds new checkout fields, field masks and other things necessary to properly work with WooCommerce on Brazil.
	 *
	 * @link       https://github.com/santanamic/class-wc-checkout-brazilian-fields
	 * @since      1.0.0
	 *
	 * @author     WILLIAN SANTANA <williansantanamic@gmail.com>
	 */

	class Wc_Checkout_Brazilian_Fields {

		/**
		 * Setup the hooks, actions and filters.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		public static function init() 
		{			
			add_action( 'wp_enqueue_scripts', array( __CLASS__, 'checkout_scripts' ), 9999 );
			
			add_filter( 'woocommerce_billing_fields', array( __CLASS__, 'add_checkout_billing_fields' ), 9999 );
			add_filter( 'woocommerce_shipping_fields', array( __CLASS__, 'add_checkout_shipping_fields' ), 9999 );
			add_filter( 'woocommerce_rest_prepare_shop_order_object', array( __CLASS__, 'orders_response' ), 100, 2 );
		}


		/**
		 * Checkout scripts.
		 */
		public static function checkout_scripts() 
		{
			if ( is_checkout() ) {
				if ( ! get_query_var( 'order-received' ) ) {
					$suffix     = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

					wp_enqueue_script( 'wc-checkout-brazilian-fields', plugin_dir_url( __FILE__ ) . '/assets/js/frontend/checkout' . $suffix . '.js', array( 'jquery' ), '1.0.0', true );
					wp_enqueue_script( 'jquery-mask', plugin_dir_url( __FILE__ ) . '/assets/js/jquery.mask/jquery.mask' . $suffix . '.js', array( 'jquery' ), '1.14.10', true );

					$fields = WC()->checkout()->checkout_fields;
			
					$fields_is_required['billing_persontype']    = $fields['billing']['billing_persontype']['required'] ?? false;
					$fields_is_required['billing_neighborhood']  = $fields['billing']['billing_neighborhood']['required'] ?? false;
					$fields_is_required['billing_number']        = $fields['billing']['billing_number']['required'] ?? false;
					$fields_is_required['billing_birthdate']     = $fields['billing']['billing_birthdate']['required'] ?? false;
					$fields_is_required['billing_cpf']           = $fields['billing']['billing_cpf']['required'] ?? false;
					$fields_is_required['billing_cnpj']          = $fields['billing']['billing_cnpj']['required'] ?? false;
					$fields_is_required['shipping_neighborhood'] = $fields['shipping']['shipping_neighborhood']['required'] ?? false;
					$fields_is_required['shipping_number']       = $fields['shipping']['shipping_number']['required'] ?? false;
			
					wp_localize_script(
						'wc-checkout-brazilian-fields',
						'wc_checkout_brazilian_fields_params',
							array(
								'required' => $fields_is_required
							)
					);

				}
			}
		}
		
		/**
		 * Add billing neighborhood date field in checkout
		 *
		 * @param    array    $fields    All checkout fields
		 * @return   array    $fields    Updated fields
		 */
		public static function add_checkout_billing_fields( $fields ) {
			
			if( ! isset( $fields['billing_neighborhood'] ) ){
				$priority = $fields['billing_address_2'] ?? $fields['billing_address_1'];
				$aft_priority = $priority['priority'] + 2;
				$fields['billing_neighborhood'] = [
					'priority' => $aft_priority,
					'label' => __('Bairro', 'wc-checkout-brazilian-fields'),
					'required' => false,
					'class' => ['form-row-wide'],
					'clear' => true,
				];
			}

			if( ! isset( $fields['billing_number'] ) ){
				$aft_priority = $fields['billing_address_1']['priority'] + 1;
				$fields['billing_number'] = array(
					'priority' => $aft_priority,
					'label' => __('Número', 'wc-checkout-brazilian-fields'),
					'required' => false,
					'class' => ['form-row-wide'],
					'clear' => true,
				);
			}

			if( ! isset( $fields['billing_cpf'] ) ){
				$aft_priority = $fields['billing_last_name']['priority'] + 1;
				$fields['billing_cpf'] = array(
					'priority' => $aft_priority,
					'label' => __('CPF', 'wc-checkout-brazilian-fields'),
					'required' => false,
					'class' => ['form-row-wide'],
					'clear' => true,
				);
			}

			if( ! isset( $fields['billing_birthdate'] ) ){
				$aft_priority = $fields['billing_cpf']['priority'] + 1;
				$fields['billing_birthdate'] = array(
					'priority' => $aft_priority,
					'label' => __('Data de nascimento', 'wc-checkout-brazilian-fields'),
					'required' => false,
					'class' => ['form-row-wide'],
					'clear' => true,
				);
			}

			if( ! isset( $fields['billing_cnpj'] ) ){
				$priority = $fields['billing_company'] ?? $fields['billing_birthdate'];
				$aft_priority = $priority['priority'] + 1;
				$fields['billing_cnpj'] = array(
					'priority' => $aft_priority,
					'label' => __('CNPJ', 'wc-checkout-brazilian-fields'),
					'required' => false,
					'class' => ['form-row-wide'],
					'clear' => true,
				);
			}
			
			if( ! isset( $fields['billing_persontype'] ) ){
				$aft_priority = $fields['billing_cpf']['priority'] + 1;
				$fields['billing_persontype'] = array(
					'type'        => 'select',
					'label'       => __( 'Tipo de Pessoa', 'wc-checkout-brazilian-fields' ),
					'class'       => array( 'form-row-wide', 'person-type-field' ),
					'input_class' => array( 'wc-ecfb-select' ),
					'required'    => false,
					'options'     => array(
						'1' => __( 'Pessoa Física', 'wc-checkout-brazilian-fields' ),
						'2' => __( 'Pessoa Jurídica ', 'wc-checkout-brazilian-fields' ),
						),
					'priority'    => 1,
				);
			}
			
			return $fields;
		}

		/**
		 * Add shipping neighborhood date field in checkout
		 *
		 * @param    array    $fields    All checkout fields
		 * @return   array    $fields    Updated fields
		 */
		public static function add_checkout_shipping_fields( $fields ) {

			if( ! isset( $fields['shipping_neighborhood'] ) ){
				$priority = $fields['shipping_address_2'] ?? $fields['shipping_address_1'];
				$aft_priority = $priority['priority'] + 2;
				$fields['shipping_neighborhood'] = [
					'priority' => $aft_priority,
					'label' => __('Bairro', 'wc-checkout-brazilian-fields'),
					'required' => false,
					'class' => ['form-row-wide'],
					'clear' => true,
				];
			}

			if( ! isset( $fields['shipping_number'] ) ){
				$aft_priority = $fields['shipping_address_1']['priority'] + 1;
				$fields['shipping_number'] = array(
					'priority' => $aft_priority,
					'label' => __('Número', 'wc-checkout-brazilian-fields'),
					'required' => false,
					'class' => ['form-row-wide'],
					'clear' => true,
				);
			}
			
			return $fields;
		}

		/**
		 * Format number.
		 *
		 * @param  string $string Number to format.
		 * @return string
		 */
		public static function format_number( $string ) {
			return str_replace( array( '.', '-', '/' ), '', $string );
		}
		
		/**
		 * Get formatted birthdate.
		 *
		 * @param  string $date Date for format.
		 * @return string
		 */
		public static function get_formatted_birthdate( $date ) {
			$birthdate = explode( '/', $date );
			if ( isset( $birthdate[1] ) && ! empty( $birthdate[1] ) ) {
				return sprintf( '%s-%s-%sT00:00:00', $birthdate[1], $birthdate[0], $birthdate[2] );
			}
			return '';
		}

		/**
		 * Add extra fields in orders response.
		 *
		 * @param WP_REST_Response $response The response object.
		 * @param WC_Order         $order    Order object.
		 *
		 * @return WP_REST_Response
		 */
		public static function orders_response( $response, $order ) {
			// Billing fields.
			$response->data['billing']['number']       = $order->get_meta( '_billing_number' );
			$response->data['billing']['neighborhood'] = $order->get_meta( '_billing_neighborhood' );
			$response->data['billing']['cpf']          = static::format_number( $order->get_meta( '_billing_cpf' ) );
			$response->data['billing']['birthdate']    = static::get_formatted_birthdate( $order->get_meta( '_billing_birthdate' ) );

			// Shipping fields.
			$response->data['shipping']['number']       = $order->get_meta( '_shipping_number' );
			$response->data['shipping']['neighborhood'] = $order->get_meta( '_shipping_neighborhood' );

			return $response;
		}
	}
}