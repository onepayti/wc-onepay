jQuery(function( $ ) {
	'use strict';

	/**
	 * Checkbox ID.
	 */
	var wc_braspag_testmode = '#woocommerce_wc_braspag_splitcreditcard_testmode';
	var wc_braspag_installment_type = '#woocommerce_wc_braspag_splitcreditcard_installment_type';

	/**
	 * Object to handle Cielo admin functions.
	 */
	var wc_braspag_admin = {
		isTestMode: function() {
			return $( wc_braspag_testmode ).is( ':checked' );
		},

		/**
		 * Initialize.
		 */
		init: function() {
			$( document.body ).on( 'change', wc_braspag_testmode, function() {
				var client_secret = $( '#woocommerce_wc_braspag_splitcreditcard_client_secret' ).parents( 'tr' ).eq( 0 ),
					merchant_id = $( '#woocommerce_wc_braspag_splitcreditcard_merchant_id' ).parents( 'tr' ).eq( 0 ),
					merchant_key = $( '#woocommerce_wc_braspag_splitcreditcard_merchant_key' ).parents( 'tr' ).eq( 0 ),
					client_secret_sandbox = $( '#woocommerce_wc_braspag_splitcreditcard_client_secret_sandbox' ).parents( 'tr' ).eq( 0 ),
					merchant_id_sandbox = $( '#woocommerce_wc_braspag_splitcreditcard_merchant_id_sandbox' ).parents( 'tr' ).eq( 0 ),
					merchant_key_sandbox = $( '#woocommerce_wc_braspag_splitcreditcard_merchant_key_sandbox' ).parents( 'tr' ).eq( 0 );
		
				if ( $( this ).is( ':checked' ) ) {
					merchant_key_sandbox.show();
					merchant_id_sandbox.show();
					client_secret_sandbox.show();
					merchant_key.hide();
					merchant_id.hide();
					client_secret.hide();
				} else {
					merchant_key_sandbox.hide();
					merchant_id_sandbox.hide();
					client_secret_sandbox.hide();
					merchant_key.show();
					merchant_id.show();
					client_secret.show();
				}
			} );

			$( document.body ).on( 'change', wc_braspag_installment_type, function() {
				
				var interest_rate = $( '#woocommerce_wc_braspag_splitcreditcard_interest_rate' ).parents( 'tr' ).eq( 0 );
				var interest = $( '#woocommerce_wc_braspag_splitcreditcard_interest' ).parents( 'tr' ).eq( 0 );
		
				if ( $( this ).val() != 'client' ) {
					interest_rate.hide();
					interest.hide();
				} else {
					interest_rate.show();
					interest.show();
				}
			} );

			$( wc_braspag_testmode  ).change();
			$( wc_braspag_installment_type  ).change();
		}
	};

	wc_braspag_admin.init();

});