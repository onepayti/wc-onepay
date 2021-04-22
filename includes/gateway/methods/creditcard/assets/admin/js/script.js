jQuery(function( $ ) {
	'use strict';

	/**
	 * Checkbox ID.
	 */
	var wc_onepay_creditcard_installment_type = '#woocommerce_wc_onepay_creditcard_installment_type';

	/**
	 * Object to handle Cielo admin functions.
	 */
	var wc_onepay_creditcard_admin = {

		/**
		 * Initialize.
		 */
		init: function() {

			$( document.body ).on( 'change', wc_onepay_creditcard_installment_type, function() {
				
				var interest_rate = $( '#woocommerce_wc_onepay_creditcard_interest_rate' ).parents( 'tr' ).eq( 0 );
				var interest = $( '#woocommerce_wc_onepay_creditcard_interest' ).parents( 'tr' ).eq( 0 );
		
				if ( $( this ).val() != 'client' ) {
					interest_rate.hide();
					interest.hide();
				} else {
					interest_rate.show();
					interest.show();
				}
			} );

			$( wc_onepay_creditcard_installment_type  ).change();
		}
	};

	wc_onepay_creditcard_admin.init();

});