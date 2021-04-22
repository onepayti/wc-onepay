<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<fieldset id="onepay-card-payment-form" class="onepay-payment-form">
	<p class="form-row">
		<label for="onepay-card-number"><?php _e( 'Card Number', 'wc-onepay' ); ?> <span class="required">*</span></label>
		<input value="" id="onepay-card-number" name="<?php echo $card_number ?>" class="input-text wc-credit-card-form-card-number" type="tel" maxlength="22" autocomplete="off" placeholder="&bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull;" style="font-size: 1.5em; padding: 8px;" />
	</p>
	<p class="form-row">
		<label for="onepay-card-holder-name"><?php _e( 'Name Printed on the Card', 'wc-onepay' ); ?> <span class="required">*</span></label>
		<input value="" id="onepay-card-holder-name" name="<?php echo $card_name ?>" class="input-text" type="text" autocomplete="off" style="font-size: 1.5em; padding: 8px;" />
	</p>
	<div class="clear"></div>
	<p class="form-row form-row-first">
		<label for="onepay-card-expiry">Validade (MM/AAAA) <span class="required">*</span></label>
		<input value="" id="onepay-card-expiry" name="<?php echo $card_expiry ?>" class="input-text wc-credit-card-form-card-expiry" type="tel" autocomplete="off" placeholder="<?php _e( 'MM / YYYY', 'wc-onepay' ); ?>" style="font-size: 1.5em; padding: 8px;" />
	</p>
	<p class="form-row form-row-last">
		<label for="onepay-card-cvc"><?php _e( 'Security Code', 'wc-onepay' ); ?> <span class="required">*</span></label>
		<input value="" id="onepay-card-cvc" name="<?php echo $card_cvc ?>" class="input-text wc-credit-card-form-card-cvc" type="tel" autocomplete="off" placeholder="<?php _e( 'CVC', 'wc-onepay' ); ?>" style="font-size: 1.5em; padding: 8px;" />
	</p>
	<?php if ( ! empty( $installments ) ) : ?>
		<p class="form-row form-row-wide">
			<label for="onepay-installments"><?php _e( 'Installments', 'wc-onepay' ); ?> <span class="required">*</span></label>
			<?php echo $installments; ?>
		</p>
	<?php endif; ?>
	<div class="clear"></div>
</fieldset>
