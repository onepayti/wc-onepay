<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_OnePay_Environment' ) ) {

/**
 * The plugin class for get environment data.
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
	class Wc_OnePay_Environment {
		
	/**
	 * The PHP version.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @var      string
	 */
		private $_php_version;

	/**
	 * The PHP min version.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @var      string
	 */
		private $_php_min_version = '7.0';

	/**
	 * The WordPess version.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @var      string
	 */
		private $_wordpress_version;

	/**
	 * The WordPess min version.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @var      string
	 */
		private $_wordpress_min_version = '4.8';

	/**
	 * Check WooCommerce plugin activated.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @var      string
	 */
		private $_is_woocommerce_activated;

	/**
	 * The WooCommerce version.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @var      string
	 */
		private $_woocommerce_version;

	/**
	 * The WooCommerce min version.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @var      string
	 */
		private $_woocommerce_min_version = '3.3';

	/**
	 * All required active plugins.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @var      string
	 */
		private $_active_required_plugins = [
			'woocommerce/woocommerce.php' => [
				'name' => 'WooCommerce', 
				'url' => 'https://wordpress.org/plugins/woocommerce/'
			]
		];	
		
	/**
	 * All valid currency.
	 *
	 * @access   private
	 * @since    1.0.0
	 * @var      string
	 */
		private $_valid_currencys = ['BRL'];

	/**
	 * The plugin main instance.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of the plugin.
	 */
		private static $_instance = NULL;
		
	/**
	 * Main Wc_Payment_Gateway_Register_Methods Instance.
	 *
	 * Ensures only one instance of Wc_Payment_Gateway_Register_Methods is loaded or can be loaded.
	 *
	 * @since 2.1
	 * @return WC_Payment_Gateways Main instance
	 */
		public static function instance() 
		{
		
		if ( is_null( SELF::$_instance ) ) : 

			SELF::$_instance = new SELF();
			SELF::$_instance->init_globals();
		
		endif;
		
		return SELF::$_instance;
		
		}
		
	/**
	 * A dummy constructor to prevent this class from being loaded more than once.
	 *
	 * @since    1.0.0
	 * @codeCoverageIgnore
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
	 * Setup the hooks, actions and filters.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
		private function init_globals() 
		{

		$this->_php_version              = phpversion();
		$this->_wordpress_version        = get_bloginfo( 'version' );
		$this->_is_woocommerce_activated = class_exists ( 'WC_Payment_Gateway' );
		$this->_woocommerce_version      = Wc_OnePay_Helper::woocommerce_version();
		
		}

	/**
	 * PHP version is valid.
	 *
	 * @since    1.0.0
	 * @return   boolean
	 */
		public function valid_php_version() 
		{

		$php_min_version      = $this->_php_min_version;
		$php_current_version  = $this->_php_version;
		$is_valid_php_version = $php_current_version >= $php_min_version;

		return $is_valid_php_version;
		
		}

	/**
	 * WordPress version is valid.
	 *
	 * @since    1.0.0
	 * @return   boolean
	 */
		public function valid_wordpress_version() 
		{

		$wordpress_min_version      = $this->_wordpress_min_version;
		$wordpress_current_version  = $this->_wordpress_version;
		$is_valid_wordpress_version = $wordpress_current_version >= $wordpress_min_version;

		return $is_valid_wordpress_version;

		}

	/**
	 * WooCommerce plugin is activated.
	 *
	 * @since    1.0.0
	 * @return   boolean
	 */
		public function woocommerce_activated() 
		{

		$_is_woocommerce_activated = $this->_is_woocommerce_activated;
		
		return $_is_woocommerce_activated;
		
		}

	/**
	 * Woocommerce version is valid.
	 *
	 * @since    1.0.0
	 * @return   boolean
	 */
		public function valid_woocommerce_version() 
		{

		$woocommerce_min_version      = $this->_woocommerce_min_version;
		$woocommerce_current_version  = $this->_woocommerce_version;
		$is_valid_woocommerce_version = $woocommerce_current_version >= $woocommerce_min_version;

		return $is_valid_woocommerce_version;
		
		}

	/**
	 * Woocommerce version is valid.
	 *
	 * @since    1.0.0
	 * @return   boolean
	 */
		public function valid_woocommerce_currency() 
		{

		if( $this->woocommerce_activated() ) {
			
			$currency = get_woocommerce_currency();
			
			if( ! empty( $this->_valid_currencys ) && isset( $this->_valid_currencys[$currency] ) ) {
				return true;
			}
			
			return true;
			
		}
		
		return false;
		
		}

	/**
	 * All required plugins is activated.
	 *
	 * @since    1.0.0
	 * @return   boolean|array    Returns true if all required plugins are active or returns array of remaining plugins.
	 */
		public function active_required_plugins() 
		{

		$all_required_plugins       = $this->_active_required_plugins;		
		$all_active_plugins         = Wc_OnePay_Helper::wordpress_plugins();
		$remaining_plugins_required = array_diff_key( $all_required_plugins, $all_active_plugins );

		if ( empty( $all_required_plugins ) ) :

			return TRUE;

		else :

			return $remaining_plugins_required;

		endif;
		
		}

	/**
	 * SSL certificate exists.
	 *
	 * @since    1.0.0
	 * @return   boolean
	 */
		public function ssl_exists() 
		{

		$ssl_exists = is_ssl();
		
		return $ssl_exists;
		
		}

	}
}