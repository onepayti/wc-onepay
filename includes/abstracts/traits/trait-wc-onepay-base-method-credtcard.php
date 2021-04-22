<?php if ( ! defined( 'ABSPATH' ) ) die;

if ( ! class_exists( 'Wc_OnePay_Base_Method_CredtCard' ) ) {

/**
 *
 * @link       https://github.com/1pay/wc-onepay
 * @author     1Pay <suporte.ti@gmail.com>
 * @since      1.0.0
 * @package    wc-onepay
 * @subpackage wc-onepay/includes/abstracts/traits
 * 
 * @author     AQUARELA - WILLIAN SANTANA <williansantanamic@gmail.com>
 * @link       https://github.com/santanamic/wc-z4money
 */
    trait Wc_OnePay_Base_Method_CredtCard
    {
		
		/**
		 * Get installments HTML.
		 *
		 * @param  float  $order_total Order total.
		 * @return string
		 */
		public function get_installments_html( $order_total = 0 ) 
		{			
			$html         = '';        
			$installments = apply_filters( STATIC::FILTER_MAX_INSTALLMENTS, $this->installments, $order_total );

			$html .= '<select id="onepay-installments" name="' . STATIC::CARD_INSTALLMENTS .'" style="font-size: 1.5em; padding: 4px; width: 100%;">';

			$interest_rate = $this->get_valid_value( $this->interest_rate ) / 100;

			for ( $i = 1; $i <= $installments; $i++ ) {
				$credit_total    = $order_total / $i;
				$credit_interest = sprintf( __( 'no interest. Total: %s', 'wc-onepay' ), sanitize_text_field( wc_price( $order_total ) ) );
				$smallest_value  = ( 5 <= $this->smallest_installment ) ? $this->smallest_installment : 5;

				if ( 'client' == $this->installment_type && $i >= $this->interest && 0 < $interest_rate ) {
					$interest_total = $order_total * ( $interest_rate / ( 1 - ( 1 / pow( 1 + $interest_rate, $i ) ) ) );
					$interest_order_total = $interest_total * $i;

					if ( $credit_total < $interest_total ) {
						$credit_total    = $interest_total;
						$credit_interest = sprintf( __( 'with interest of %s%% a.m. Total: %s', 'wc-onepay' ), $this->get_valid_value( $this->interest_rate ), sanitize_text_field( wc_price( $interest_order_total ) ) );
					}
				}

				if ( 1 != $i && $credit_total < $smallest_value ) {
					continue;
				}

				$at_sight = ( 1 == $i ) ? 'onepay-at-sight' : '';

				$html .= '<option value="' . $i . '" class="' . $at_sight . '">' . sprintf( __( '%sx of %s %s', 'wc-onepay' ), $i, sanitize_text_field( wc_price( $credit_total ) ), $credit_interest ) . '</option>';
			}

			$html .= '</select>';
			
			return $html;
		}

		/**
		 * Get the accepted brands in a text list.
		 *
		 * @param  array $methods
		 * @return string
		 */
		public function get_accepted_brands_list( $methods ) 
		{
			$total = count( $methods );
			$count = 1;
			$list  = '';

			foreach ( $methods as $method ) {
				$name = $this->get_payment_method_name( $method );

				if ( 1 == $total ) {
					$list .= $name;
				} else if ( $count == ( $total - 1 ) ) {
					$list .= $name . ' ';
				} else if ( $count == $total ) {
					$list .= sprintf( __( 'and %s', 'wc-onepay' ), $name );
				} else {
					$list .= $name . ', ';
				}

				$count++;
			}

			return $list;
		}
			
		/**
		 * Validate installments.
		 *
		 * @param  array $posted
		 * @param  float $order_total
		 * @return bool
		 */
		protected function validate_installments( $posted, $order_total ) 
		{
			// Stop if don't have installments.
			if ( ! isset( $posted[STATIC::CARD_INSTALLMENTS] ) && 1 == $this->installments ) {
				return true;
			}

			try {

				// Validate the installments field.
				if ( ! isset( $posted[STATIC::CARD_INSTALLMENTS] ) || '' === $posted[STATIC::CARD_INSTALLMENTS] ) {
					throw new Exception( __( 'Please select a number of installments.', 'wc-onepay' ) );
				}

				$installments      = absint( $posted[STATIC::CARD_INSTALLMENTS] );
				$installment_total = $order_total / $installments;
				$_installments     = apply_filters( STATIC::FILTER_MAX_INSTALLMENTS, $this->installments, $order_total );
				$interest_rate     = $this->get_valid_value( $this->interest_rate ) / 100;

				if ( 'client' == $this->installment_type && $installments >= $this->interest && 0 < $interest_rate ) {
					$interest_total    = $order_total * ( $interest_rate / ( 1 - ( 1 / pow( 1 + $interest_rate, $installments ) ) ) );
					$installment_total = ( $installment_total < $interest_total ) ? $interest_total : $installment_total;
				}
				$smallest_value = ( 5 <= $this->smallest_installment ) ? $this->smallest_installment : 5;

				if ( $installments > $_installments || 1 != $installments && $installment_total < $smallest_value ) {
					 throw new Exception( __( 'Invalid number of installments!', 'wc-onepay' ) );
				}
			} catch ( Exception $e ) {
				$this->add_error( $e->getMessage() );

				return false;
			}

			return true;
		}
		

		/**
		 * Payment fields.
		 *
		 * @return string
		 */
		public function payment_fields() 
		{
			if ( $description = $this->get_description() ) {
				echo wpautop( wptexturize( $description ) );
			}

			// Get order total.
			if ( method_exists( $this, 'get_order_total' ) ) {
				$order_total = $this->get_order_total();
			} else {
				$order_total = $this->get_order_total();
			}

			$this->get_checkout_form( $order_total );
		}		

		/**
		 * CreditCard data.
		 *
		 * @return array
		 */
		public function get_creditcard_data( $posted, $order ) 
		{
			
			if ( ! $this->validate_installments( $posted, $order->order_total ) ) {
				throw new Exception( __( 'Number or value of installments is invalid', 'wc-onepay' ) );
			}
			$card_number     = sanitize_text_field( $posted[STATIC::CARD_NUMBER] );
			$card_brand      = $this->get_card_brand_by_number( $card_number );
			$card_expiration = preg_replace('/\s/', '', $posted[STATIC::CARD_EXPIRY]);
			$avalible_brands = $this->get_available_brands();
			$installments    = absint( $posted[STATIC::CARD_INSTALLMENTS] );
			
			list( 
				$interest_order_total, 
				$interest_value,
				$interest_rate ) = $this->get_credit_interest_data( $installments, $order->order_total );
	
			if ( ! isset( $avalible_brands[$card_brand] ) ) {
				throw new Exception( __( 'Payment has not been made. Your card brand is not supported', 'wc-onepay' ) );
			}
			
			$data = [
				'type'                => 'credit-card',
				'name_on_card'        => $posted[STATIC::CARD_NAME],
				'card_number'         => str_replace ( ' ', '', $posted[STATIC::CARD_NUMBER] ),
				'card_expiration'     => $card_expiration,
				'card_cvv'            => $posted[STATIC::CARD_CVC],
				'card_brand'          => $card_brand,
				'card_installments'   => $installments,
				'card_interest_rate'  => $interest_rate,
				'card_interest_value' => round( $interest_value, 2 ),
				'card_order_total'    => round( $interest_order_total, 2 ),
			];
			
			update_post_meta( $order->id, '_wc_onepay_card', $data );
			
			return $data;
		}
		
		/**
		 * Return interest data.
		 *
		 * @return array
		 */
		public function get_credit_interest_data( $installments, $order_total )
		{
			$order_total          = (float) $order_total;
			$interest_order_total = $order_total;
			$real_interest_total  = 0;
			$interest_rate        = 0;
			
			if ( isset( $this->installment_type ) && 'client' == $this->installment_type && $installments >= $this->interest ) {
				$interest_rate        = $this->get_valid_value( $this->interest_rate ) / 100;
				$interest_total       = number_format( $order_total * ( $interest_rate / ( 1 - ( 1 / pow( 1 + $interest_rate, $installments ) ) ) ), 2 );
				$interest_order_total = $interest_total * $installments;
				$interest_order_calc  = $interest_order_total - $order_total; // fix interest total for 1 installments
				$real_interest_total  = $interest_order_calc < 0 ? 0 : $interest_order_calc; 
			}

			return [ 
				$interest_order_total, 
				$real_interest_total, 
				$interest_rate * 100 
			];
		}
	}        
}