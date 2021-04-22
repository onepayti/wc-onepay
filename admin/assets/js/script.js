(function( $ ) {
	'use strict';

	$( function() {
		
		var woopage = $( '#order_data.panel.woocommerce-order-data' ),
			onePayOrder = $( 'input[value="ONEPAY_ID"]' ).closest( 'tr' ).find( 'textarea' ).val();

		if ( undefined !== onePayOrder && '' !== onePayOrder && 1 === woopage.length ) {
			$( '<p class="woocommerce-order-data__meta order_number">OnePay ID: <span>' + onePayOrder + '</span></p>' )
				.insertAfter( $( woopage ).find( 'h2' ) );
		}

	});

}( jQuery ));