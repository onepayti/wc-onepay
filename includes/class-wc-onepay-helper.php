<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_OnePay_Helper' ) ) {

/**
 * The plugin helper class
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
	class Wc_OnePay_Helper 
	{

	/**
	 * Find out if an PHP extension is loaded or return all extensions on the system
	 *
	 * @since    1.0.0
	 * @param    string    $name    The extension name
	 * @return   array|boolean
	 */
		public static function php_extension( $name = NULL ) 
		{

		if ( NULL === $name ) :
			
			$all_loaded_extensions = get_loaded_extensions();
			
			// If the parameter is not passed Returns an array with the names of all modules
			return $all_loaded_extensions;

		else :
			
			$is_extension_loaded = extension_loaded( $name );

			return $is_extension_loaded;

		endif;
		
		}

	/**
	 * Return active plugins data or all installed plugins data
	 *
	 * @since    1.0.0
	 * @param    boolean    $all_plugins   Select all plugins or only those enabled
	 * @return   array      Plugins list
	 */
		public static function wordpress_plugins( $all_plugins = FALSE ) 
		{

		$active_plugins_data     =  [];
		$install_plugins_data    =  get_plugins();
		$active_plugins_key      =  is_multisite() ? get_site_option('active_sitewide_plugins') : get_option( 'active_plugins' );
   
		if ( TRUE === $all_plugins ) :

			// Return all installed plugins in WordPress
			return $install_plugins_data;

		else :
      
			// Filter active plugins in all installed plugins
			foreach ( $active_plugins_key as $key => $index ) :
      
      	$plugin = is_multisite() ? $key : $index;
				
				if ( array_key_exists( $plugin, $install_plugins_data ) ) {
					
					// Array Formatting
					$active_plugins_data[$plugin] = $install_plugins_data[$plugin];
					
				}
			
			endforeach;

			// Return all active plugins in WordPress
			return $active_plugins_data;

		endif;
		
		}

	/**
	 * Return active plugins data or all installed plugins data
	 *
	 * @since    1.0.0
	 * @param    boolean    $all_plugins   Select all plugins or only those enabled
	 * @return   array      Plugins list
	 */
		public static function wordpress_data_plugins( $plugin ) 
		{

		$install_plugins_data =  get_plugins();
		
		return $install_plugins_data[$plugin];
		
		}
	/**
	 * Return WooCommerce version
	 *
	 * @since    1.0.0
	 * @return   string|null   The WooCommerce version
	 */
		public static function woocommerce_version() 
		{

		$is_woocommerce_activated = class_exists ( 'WC_Payment_Gateway' );

		//Check if WooCommerce class exists and gets WooCommerce version
		if ( $is_woocommerce_activated && property_exists( WC(), 'version' ) ) :
		
			return WC()->version;

		endif;

		return NULL;
		
		}

		/**
		 * Checks if WC version is less than passed in version.
		 *
		 * @since  1.0.0
		 * @param  string   $version   Version to check against.
		 * @return bool
		 */
		public static function is_woocommerce_lt( $version ) {
			
		return version_compare( WC_VERSION, $version, '<' );
		
		}

		/**
		 * String just the letters and numbers.
		 *
		 * @since  1.0.0
		 * @param  string   $string   The string.
		 * @return string
		 */
		public static function stringSerializer( $string ) {
			
		return preg_replace( '/[^a-z\d]+/i', '', $string ); 
		
		}

		/**
		 * Convert date from Brazilian to American format.
		 *
		 * @since  1.0.0
		 * @param  string   $date   Date in Brazilian format.
		 * @return string
		 */
		public static function usaDate( $date ){
			$_date = DateTime::createFromFormat( 'd/m/Y', $date );
			return ( false !== $_date ? $_date->format('Y-m-d') : null );
		}

	}
}