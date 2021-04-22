<?php if ( ! defined( 'ABSPATH' ) ) exit;

$settings_onepay_creditcard = get_option( 'woocommerce_wc_onepay_creditcard_settings' );
$settings_onepay_boleto = get_option( 'woocommerce_wc_onepay_boleto_settings' );

?>

<?php if( 'yes' !== $settings_onepay_creditcard['testmode'] && empty( $settings_onepay_creditcard['token_secret'] ) ) : ?>
<div class="notice notice-info is-dismissible">
	<p><strong><?php _e( 'OnePay - Credit Card', 'wc-onepay' ); ?></strong>: <?php _e( 'To receive payments by Credit Card you must enter your token secret in the settings.', 'wc-onepay' ); ?>
	</p>
</div>
<?php endif; ?>

<?php if( 'yes' === $settings_onepay_creditcard['testmode'] && empty( $settings_onepay_creditcard['token_secret_sandbox'] ) ) : ?>
<div class="notice notice-info is-dismissible">
	<p><strong><?php _e( 'OnePay - Credit Card', 'wc-onepay' ); ?></strong>: <?php _e( 'To receive payments by Credit Card you must enter your token secret (sandbox) in the settings.', 'wc-onepay' ); ?>
	</p>
</div>
<?php endif; ?>

<?php if( 'yes' !== $settings_onepay_boleto['testmode'] && empty( $settings_onepay_boleto['token_secret'] ) ) : ?>
<div class="notice notice-info is-dismissible">
	<p><strong><?php _e( 'OnePay - Boleto', 'wc-onepay' ); ?></strong>: <?php _e( 'To receive payments by Boleto you must enter your token secret in the settings.', 'wc-onepay' ); ?>
	</p>
</div>
<?php endif; ?>

<?php if( 'yes' === $settings_onepay_boleto['testmode'] && empty( $settings_onepay_boleto['token_secret_sandbox'] ) ) : ?>
<div class="notice notice-info is-dismissible">
	<p><strong><?php _e( 'OnePay - Boleto', 'wc-onepay' ); ?></strong>: <?php _e( 'To receive payments by Boleto you must enter your token secret (sandbox) in the settings.', 'wc-onepay' ); ?>
	</p>
</div>
<?php endif; ?>