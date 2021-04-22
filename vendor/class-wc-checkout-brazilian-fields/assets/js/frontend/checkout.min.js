(function( $ ) {
	'use strict';

	$( function() {

		$( '#billing_cpf' ).mask( '000.000.000-00' );
		$( '#billing_cnpj' ).mask( '00.000.000/0000-00' );
		$( '#billing_birthdate' ).mask( '00/00/0000' );

		var MaskBehavior = function( val ) {
				return val.replace( /\D/g, '' ).length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
			},
			maskOptions = {
				onKeyPress: function( val, e, field, options ) {
					field.mask( MaskBehavior.apply( {}, arguments ), options );
				}
			};
		
		$( '#billing_persontype' ).on( 'change', function () {
			var current = $( this ).val();

			$( '#billing_cpf_field, #billing_company_field, #billing_cnpj_field, #billing_birthdate_field' ).hide().removeClass( 'validate-required' ).find( 'label .optional' ).hide();
			
			if ( '1' === current ) {
				$( '#billing_cpf_field, #billing_birthdate_field' ).show().addClass( 'validate-required' );
				
				$( '#billing_cpf_field label .required, #billing_birthdate_field label .required' ).remove();
				$( '#billing_cpf_field label, #billing_birthdate_field label' ).append( ' <abbr class="required">*</abbr>' );
			}

			if ( '2' === current ) {
				$( '#billing_company_field, #billing_cnpj_field' ).show().addClass( 'validate-required' );

				$( '#billing_company_field label .required, #billing_cnpj_field label .required' ).remove();
				$( '#billing_company_field label, #billing_cnpj_field label' ).append( ' <abbr class="required">*</abbr>' );
			}

		}).change();
		
		$( '#billing_country' ).on( 'change', function () {
			var current = $( this ).val();

			if ( 'BR' === current ) {
				$( '.person-type-field label, #billing_number_field, #billing_neighborhood_field, #shipping_number_field, #shipping_neighborhood_field' ).find( 'label .optional' ).hide();
				$( '.person-type-field label .required' ).remove();
				$( '.person-type-field' ).addClass( 'validate-required' );
				$( '.person-type-field, #billing_number_field, #billing_neighborhood_field, #shipping_number_field, #shipping_neighborhood_field' ).find( 'label' ).append( ' <abbr class="required">*</abbr>' );

			} else {
				$( '.person-type-field label, #billing_number_field, #billing_neighborhood_field, #shipping_number_field, #shipping_neighborhood_field' ).find( 'label .optional' ).show();
				$( '.person-type-field' ).removeClass( 'validate-required' );
				$( '.person-type-field, #billing_number_field, #billing_neighborhood_field, #shipping_number_field, #shipping_neighborhood_field' ).find( 'label .required' ).remove();
			}
		}).change();

	});

}( jQuery ));
