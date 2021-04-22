<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_OnePay' ) ) {

/**
 * The core plugin class.
 *
 * @link       https://github.com/1pay/wc-onepay
 * @author     1Pay <suporte.ti@gmail.com>
 * @since      1.0.0
 * @package    wc-onepay
 * @subpackage wc-onepay/includes/
 * 
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 * @link       https://github.com/santanamic/wc-z4money
 */
	final class Wc_OnePay {

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
	 */
		private static $_instance = NULL;
		
	/**
	 * Main WC_Payment_Gateways Instance.
	 *
	 * Ensures only one instance of WC_Payment_Gateways is loaded or can be loaded.
	 *
	 * @since 2.1
	 * @return WC_Payment_Gateways Main instance
	 */
		public static function instance() 
		{
			if ( is_null( SELF::$_instance ) ) : 

				SELF::$_instance = new SELF();
				SELF::$_instance->init_globals();
				SELF::$_instance->init_hooks();
			
			endif;
			
			return SELF::$_instance;
		}
		
	/**
	 * A dummy constructor to prevent this class from being loaded more than once.
	 *
	 * @since    1.0.0
	 */
		private function __construct() 
		{
		
		}
		
	/**
	 * You cannot clone this class.
	 *
	 * @since    1.0.0
	 * @codeCoverageIgnore
	 */
		public function __clone() 
		{
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wc-onepay' ), '1.0.0' );
		}

	/**
	 * You cannot unserialize instances of this class.
	 *
	 * @since    1.0.0
	 * @codeCoverageIgnore
	 */
		public function __wakeup() 
		{
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'wc-onepay' ), '1.0.0' );
		}
		
	/**
	 * Setup the class globals.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @codeCoverageIgnore
	 */
		public function init_globals() 
		{
			Wc_Checkout_Brazilian_Fields::init();
		}


	/**
	 * Setup the hooks, actions and filters.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
		private function init_hooks() 
		{
			add_filter( 'woocommerce_payment_gateways', array( __CLASS__, 'add_gateway' ) );
			add_filter( 'woocommerce_available_payment_gateways', array( __CLASS__, 'hides_when_is_outside_brazil' ) );
			if( is_admin() ) {
				add_action( 'admin_notices', array( __CLASS__, 'plugins_missing_notice' ) );
				add_action( 'admin_notices', array( __CLASS__, 'credentials_missing_notice' ) );
				add_action( 'admin_notices', array( __CLASS__, 'currency_not_supported_notice' ) );
			}
		}

	/**
	 * The environment data.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
		public function environment() 
		{
			return Wc_OnePay_Environment::instance();
		}

	/**
	 * Gateway add methods function
	 *
	 * @since    1.0.0
	 * @param    array    $payment_methods    Current array of registered payment methods
	 * @return   array    $payment_methods    Updated array of registered payment methods
	 */
		public static function add_gateway( $payment_methods ) 
		{
			$payment_methods[] = 'Wc_OnePay_Gateway_Method_CreditCard';
			$payment_methods[] = 'Wc_OnePay_Gateway_Method_Boleto';
			
			return $payment_methods;
		
		}
		
	/**
	 * Hides the Gateway by country.
	 *
	 * @param   array $available_gateways Default Available Gateways.
	 *
	 * @return  array                     New Available Gateways.
	 */
	public static function hides_when_is_outside_brazil( $available_gateways ) 
	{
		if ( isset( $_REQUEST['country'] ) && 'BR' !== $_REQUEST['country'] ) { // WPCS: input var ok, CSRF ok.
			unset( $available_gateways['Wc_OnePay_Gateway_Method_CreditCard'] );
			unset( $available_gateways['Wc_OnePay_Gateway_Method_Boleto'] );
		}

		return $available_gateways;
	}
	
	/**
	 * Requireds plugins.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
		public static function plugins_missing_notice() 
		{
			include dirname( __FILE__ ) . '/views/html-notice-missing-plugins.php';			
		}
		
	/**
	 * Requireds credentials.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
		public static function credentials_missing_notice() 
		{
			include dirname( __FILE__ ) . '/views/html-notice-credential-missing.php';			
		}
		
	/**
	 * Requireds credentials.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
		public static function currency_not_supported_notice() 
		{
			include dirname( __FILE__ ) . '/views/html-notice-currency-not-supported.php';			
		}

	}

}
