<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Functions for payment method.
 *
 * @link       https://github.com/1pay/wc-onepay
 * @author     1Pay <suporte.ti@gmail.com>
 * @since      1.0.0
 * @package    wc-onepay
 * @subpackage wc-onepay/includes/gateway/methods/boleto/
 * 
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 * @link       https://github.com/santanamic/wc-z4money
 */
 
if ( ! function_exists( 'wc_onepay_method_boleto_admin_enqueue' ) ) {

/**
 * Register admin styles and scripts for payment method
 *
 * @since    1.0.0
 * @return   array    void
 */
	function wc_onepay_method_boleto_admin_enqueue() 
	{

	wp_enqueue_script( 'wc-onepay-method-boleto-admin', 
		WC_ONEPAY_URI . 'includes/gateway/methods/boleto/assets/admin/js/script.js' );
	wp_enqueue_style( 'wc-onepay-method-boleto-admin', 
		WC_ONEPAY_URI . 'includes/gateway/methods/boleto/assets/admin/css/style.css' );

	}

}

if ( ! function_exists( 'wc_onepay_method_boleto_public_enqueue' ) ) {

/**
 * Register public styles and scripts for payment method
 *
 * @since    1.0.0
 * @return   array    void
 */
	function wc_onepay_method_boleto_public_enqueue() 
	{

	wp_enqueue_script( 'wc-onepay-method-boleto', 
		WC_ONEPAY_URI . 'includes/gateway/methods/boleto/assets/public/js/script.js', array( 'jquery', 'wc-credit-card-form' ), WC_ONEPAY_VERSION, true );
	wp_enqueue_style( 'wc-onepay-method-boleto', 
		WC_ONEPAY_URI . 'includes/gateway/methods/boleto/assets/public/css/style.css' );

	}

}