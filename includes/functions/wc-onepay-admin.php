<?php

/**
 * Register styles and scripts in admin panel.
 *
 * @link       https://github.com/santanamic/wc-onepay
 * @since      1.0.0
 * 
 * @package    wc-onepay
 * @subpackage wc-onepay/includes/functions/admin/
 * @author     OnePay <suporte@1pay.com.br>
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! function_exists( 'wc_onepay_admin_enqueue_script' ) ) {

/**
 * Register scripts in WP admin
 *
 * @since    1.0.0
 * @return   array    void
 */
	function wc_onepay_admin_enqueue_script() 
	{
	
	wp_enqueue_script( 'wc-onepay-admin', WC_ONEPAY_URI . 'admin/assets/js/script.js' );

	}

}

if ( ! function_exists( 'wc_onepay_admin_enqueue_styles' ) ) {

/**
 * Register styles in WP admin
 *
 * @since    1.0.0
 * @return   array    void
 */
	function wc_onepay_admin_enqueue_styles() 
	{

	wp_enqueue_style( 'wc-onepay-admin', WC_ONEPAY_URI . 'admin/assets/css/style.css' );

	}

}

if ( ! function_exists( 'wc_onepay_admin_links' ) ) {

	/**
	 * Add link shortcut in admin page
	 *
	 * @since    1.0.0
	 * @return   void
	 */
	function wc_onepay_admin_links( $links ) 
	{

	$links[] = '<a href="' . esc_url( admin_url('admin.php?page=wc-settings&tab=checkout' ) ) . '">' . __( 'Settings', 'wc-onepay' ) . '</a>';
	$links[] = '<a href="mailto:suporte.ti@1pay.com.br">' . __('Support', 'wc-onepay') . '</a>';
	
	return $links;
	
	}
	
}