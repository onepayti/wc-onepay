<?php if ( ! defined( 'ABSPATH' ) ) die;

if ( ! function_exists( 'wc_onepay_plugin_activate' ) ) {

	/**
	 * Plugin activate call function
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	function wc_onepay_plugin_activate() 
	{

	}

}

if ( ! function_exists( 'wc_onepay_plugin_deactivate' ) ) {

	/**
	 * Plugin deactivation call function
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	function wc_onepay_plugin_deactivate() 
	{

	}
	
}

if ( ! function_exists( 'wc_onepay_plugin_i18n' ) ) {

	/**
	 * Load the plugin text domain for translation
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	function wc_onepay_plugin_i18n() 
	{

	load_plugin_textdomain( 'wc-onepay', false, WC_ONEPAY_SLUG . '/languages/' );
	
	}
	
}

if ( ! function_exists( 'wc_onepay' ) ) {

	/**
	 * Begins execution of the plugin.
	 *
	 * @since    1.0.0
	 * @return   Wc_OnePay
	 */
	function wc_onepay() 
	{
		
	$plugin = Wc_OnePay::instance();
		
	return $plugin;
	
	}

}