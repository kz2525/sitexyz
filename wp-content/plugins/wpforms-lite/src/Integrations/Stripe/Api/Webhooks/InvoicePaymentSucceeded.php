<?php

namespace WPForms\Integrations\Stripe\Api\Webhooks;

use RuntimeException;
use WPForms\Db\Payments\Queries;
use WPForms\Integrations\Stripe\Helpers;
use WPForms\Vendor\Stripe\PaymentIntent;

/**
 * Webhook invoice.payment_succeeded class.
 *
 * @since 1.8.4
 */
class InvoicePaymentSucceeded extends Base {

	/**
	 * Handle invoice.payment_succeeded webhook for subscription_cycle billing reason (payment renewal).
	 *
	 * @since 1.8.4
	 *
	 * @throws RuntimeException       If subscription not found or not updated.
	 *
	 * @return bool
	 */
	public function handle() {

		if ( ! isset( $this->data->billing_reason ) || $this->data->billing_reason !== 'subscription_cycle' ) {
			return false; // Webhook handler for Invoice.PaymentSucceeded with reason subscription_cycle not implemented yet.
		}

		if ( $this->data->paid !== true ) {
			return false; // Subscription not paid, so we are not going to proceed with update.
		}

		$db_renewal = ( new Queries() )->get_renewal_by_invoice_id( $this->data->id );

		if ( is_null( $db_renewal ) ) {
			return false; // Newest renewal not found.
		}

		$currency = strtoupper( $this->data->currency );
		$amount   = $this->data->amount_paid / Helpers::get_decimals_amount( $currency );

		wpforms()->get( 'payment' )->update(
			$db_renewal->id,
			[
				'total_amount'    => $amount,
				'subtotal_amount' => $amount,
				'status'          => 'completed',
				'transaction_id'  => $this->data->payment_intent,
			]
		);

		$this->copy_meta_from_payment_intent( $db_renewal->id );

		wpforms()->get( 'payment_meta' )->add_log(
			$db_renewal->id,
			sprintf(
				'Stripe renewal was successfully paid. (Payment Intent ID: %1$s)',
				$this->data->payment_intent
			)
		);

		return true;
	}

	/**
	 * Copy meta from payment intent.
	 *
	 * @since 1.8.4
	 *
	 * @param int $renewal_id Renewal ID.
	 *
	 * @return array
	 */
	private function copy_meta_from_payment_intent( $renewal_id ) {

		$payment_intent = PaymentIntent::retrieve( $this->data->payment_intent, Helpers::get_auth_opts() );

		if ( ! isset( $payment_intent->charges->data[0]->payment_method_details ) ) {
			return;
		}

		$details = $payment_intent->charges->data[0]->payment_method_details;

		if ( ! empty( $details->card->last4 ) ) {
			if ( ! empty( $details->type ) ) {
				$meta['method_type'] = sanitize_text_field( $details->type );
			} else {
				$meta['method_type'] = 'card';
			}

			$meta['credit_card_last4']   = $details->card->last4;
			$meta['credit_card_method']  = $details->card->brand;
			$meta['credit_card_expires'] = $details->card->exp_month . '/' . $details->card->exp_year;
		} else {
			$meta['method_type'] = 'link';
		}

		wpforms()->get( 'payment_meta' )->bulk_add( $renewal_id, $meta );
	}
}
