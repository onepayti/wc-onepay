<?php

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if ( ! class_exists( 'Wc_OnePay_Logger' ) ) {

/**
 * Log all things.
 *
 * @link       https://github.com/1pay/wc-onepay
 * @author     1Pay <suporte.ti@gmail.com>
 * @since      1.0.0
 * @package    wc-onepay
 * @subpackage wc-onepay/includes/api/
 * 
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 * @link       https://github.com/santanamic/wc-z4money
 */
	class Wc_OnePay_Logger 
	{
		
		public $enable_logger = null;
		
		public $logger;
		
		const WC_LOG_FILENAME = 'wc-onepay';
		
		/**
		 * Utilize WC logger class
		 *
		 * @since 1.0.0
		 * @version 1.0.0
		 */
		public function add( $message, $start_time = null, $end_time = null ) 
		{

			if ( ! class_exists( 'WC_Logger' ) ) {
				return;
			}

			if ( apply_filters( 'wc_onepay_logging', true, $message ) ) 
			{
				if ( empty( $this->logger ) ) {
					
					if ( Wc_OnePay_Helper::is_woocommerce_lt( '3.0' ) ) {
						$this->logger = new WC_Logger();
					} else {
						$this->logger = wc_get_logger();
					}

				}
				
				if ( true !== $this->enable_logger ) {
					return;
				}
				
				if ( ! is_null( $start_time ) ) {
					
					$formatted_start_time = date_i18n( get_option( 'date_format' ) . ' g:ia', $start_time );
					$end_time             = is_null( $end_time ) ? current_time( 'timestamp' ) : $end_time;
					$formatted_end_time   = date_i18n( get_option( 'date_format' ) . ' g:ia', $end_time );
					$elapsed_time         = round( abs( $end_time - $start_time ) / 60, 2 );
					$log_entry  = "\n" . '====' . WC_ONEPAY_NAME . ' Version: ' . WC_ONEPAY_VERSION . '====' . "\n";
					$log_entry .= '====Start Log ' . $formatted_start_time . '====' . "\n" . $message . "\n";
					$log_entry .= '====End Log ' . $formatted_end_time . ' (' . $elapsed_time . ')====' . "\n\n";
				
				} 

				else {
					$log_entry  = "\n" . '====' . WC_ONEPAY_NAME . ' Version: ' . WC_ONEPAY_VERSION . '====' . "\n";
					$log_entry .= '====Start Log====' . "\n" . $message . "\n" . '====End Log====' . "\n\n";
				}
				
				if ( Wc_OnePay_Helper::is_woocommerce_lt( '3.0' ) ) {
					$this->logger->add( self::WC_LOG_FILENAME, $log_entry );
				} 

				else {
					$this->logger->debug( $log_entry, array( 'source' => self::WC_LOG_FILENAME ) );
				}
			}
		}
	}
}