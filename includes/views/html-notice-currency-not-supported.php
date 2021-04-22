<?php if ( ! defined( 'ABSPATH' ) ) exit;

$is_valid_currency = wc_onepay()->environment()->valid_woocommerce_currency();

?>

<?php if( ! $is_valid_currency ) : ?>
<div class="notice notice-info is-dismissible">
	<p><strong><?php _e( 'OnePay Disabled', 'wc-onepay' ); ?></strong>: <?php __( 'Currency not supported. Works only with Brazilian Real.', 'wc-onepay' ); ?>
	</p>
</div>
<?php endif; ?>