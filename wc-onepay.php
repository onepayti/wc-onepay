<?php if ( ! defined( 'ABSPATH' ) ) die;

/**
 * Plugin Name:       OnePay for WooCommerce
 * Plugin URI:        https://github.com/onepayti/wc-onepay
 * Description:       Take payments using OnePay.
 * Version:           1.0.1
 * Author:            1Pay
 * Author URI:        https://github.com/onepayti/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-onepay
 * Domain Path:       /languages
 */

define( 'WC_ONEPAY_NAME', 'WooCommerce OnePay' );
define( 'WC_ONEPAY_VERSION', '1.0.1' );
define( 'WC_ONEPAY_DEBUG_OUTPUT', 0 );
define( 'WC_ONEPAY_BASENAME', plugin_basename( __FILE__ ) );
define( 'WC_ONEPAY_SLUG', plugin_basename( plugin_dir_path( __FILE__ ) ) );
define( 'WC_ONEPAY_CORE_FILE', __FILE__ );
define( 'WC_ONEPAY_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WC_ONEPAY_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

require_once( WC_ONEPAY_PATH . 'vendor/autoload.php' );

/**
 * The code that runs during plugin activation and The code that runs during plugin deactivation.
 */
register_activation_hook( __FILE__, 'wc_onepay_plugin_activate' );
register_deactivation_hook( __FILE__, 'wc_onepay_plugin_deactivate' );

/**
 * Initial hook for plugin run and Initial hook for plugin internationalization.
 */
add_action( 'plugins_loaded', 'wc_onepay' );
add_action( 'plugins_loaded', 'wc_onepay_plugin_i18n' );

/**
 * Initial hook for add admin scripts and styles.
 */
add_filter( 'plugin_action_links_' . WC_ONEPAY_BASENAME, 'wc_onepay_admin_links' );
add_action( 'admin_enqueue_scripts', 'wc_onepay_admin_enqueue_script' );
add_action( 'admin_enqueue_scripts', 'wc_onepay_admin_enqueue_styles' );
