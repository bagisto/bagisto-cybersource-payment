<?php

namespace Webkul\CyberSource\Http\Controllers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;

class CyberSourceController extends Controller
{
	/**
	 * Constructor for the class
	 *
	 * 
	 * @return void
	 */
	public function __construct(
		protected OrderRepository $orderRepository,  
		protected InvoiceRepository $invoiceRepository
	) {

	}

	/*
	 * To Get Signature
	 * 
     * @return string
	 */
	public function sign($params) {
		$secretKey = core()->getConfigData('sales.payment_methods.cyber_source.secret_key');

		$signData = $this->signData($this->buildDataToSign($params), $secretKey);

		return $signData;
	}

	/*
	 * To Get Signature
	 * 
	 * @return string
	 */
	public function signData($data, $secretKey) {
		$hashSign = base64_encode(hash_hmac('sha256', $data, $secretKey, true));

		return $hashSign; 
	}
	  
	/*
	 * To Prepare Data for Signature
	 * 
	 * @return string
	 */
	public function buildDataToSign($params) {
		$signedFieldNames = explode(",",$params["signed_field_names"]);

		foreach ($signedFieldNames as $field) {
			$dataToSign[] = $field . "=" . $params[$field];
		}

		$commaSeparatedData = implode(",",$dataToSign);

		return $commaSeparatedData;
 	}
	  
    /**
	 * Redirects to the payment server.
	 *
	 * @return \Illuminate\View\View
	 */
	public function redirect()
	{
		$cart = Cart::getCart();

		$accessKey = core()->getConfigData('sales.payment_methods.cyber_source.access_key');

		$secretKey = core()->getConfigData('sales.payment_methods.cyber_source.secret_key');

		$profileId = core()->getConfigData('sales.payment_methods.cyber_source.profile_id');

		$uniqueId =  uniqid();

		if ((bool) core()->getConfigData('sales.payment_methods.cyber_source.sandbox')) 
			$CYBERSOURCE_URL = "https://testsecureacceptance.cybersource.com/pay";        			// For Sandbox Mode
		else 
			$CYBERSOURCE_URL = "https://secureacceptance.cybersource.com/pay";        				// For Production Mode

		$shipping_rate = $cart->selected_shipping_rate ? $cart->selected_shipping_rate->price : 0; 	// shipping rate
		$discount_amount = $cart->discount_amount; 													// discount amount
		$amount = ($cart->sub_total + $cart->tax_total + $shipping_rate) - $discount_amount; 		// total amount

		$billingAddress = $cart->billing_address;

		$signedDateAndTime = gmdate("Y-m-d\TH:i:s\Z");

		$params  = array(
			"access_key" 					=> $accessKey,
			"profile_id" 					=> $profileId,
			"transaction_uuid" 				=> $uniqueId,
			"signed_field_names"			=> 'partner_solution_id,access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,bill_to_address_postal_code,bill_to_email,bill_to_surname,bill_to_forename',
			"unsigned_field_names"			=> '',
			"signed_date_time"				=> $signedDateAndTime,
			"locale"						=> app()->getLocale(),
			"partner_solution_id"			=> 'IGT4AWTG',
			"transaction_type" 				=> 'authorization',
			"reference_number" 				=> $uniqueId,
			"amount" 						=> $amount,
			"currency"						=> $cart->cart_currency_code,
			"bill_to_address_line1"			=> $billingAddress['address1'],
			"bill_to_address_city"			=> $billingAddress['city'],
			"bill_to_address_state"			=> $billingAddress['state'],
			"bill_to_address_country"		=> $billingAddress['country'],
			'bill_to_address_postal_code'	=> $billingAddress['postcode'],
			"bill_to_email"					=> $billingAddress['email'],
			"bill_to_surname"				=> $billingAddress['last_name'],
			"bill_to_forename"				=> $billingAddress['first_name']
		);

		$params['signature'] = $this->sign($params);

		return view('cyber_source::cyber-source-redirect', compact('params', 'CYBERSOURCE_URL'));
	}

	/*
	 * To Check Status of Payment
	 */
	public function processPayment() {
        try {
			if (request()->reason_code == 100) {
				$order = $this->orderRepository->create(Cart::prepareDataForOrder());
	
				$this->orderRepository->update(['status' => 'processing'], $order->id);
		
				if ($order->canInvoice()) {
					$this->invoiceRepository->create($this->prepareInvoiceData($order));
				}
		
				Cart::deActivateCart();
	
				session()->flash('order', $order);

				return redirect()->route('shop.checkout.onepage.success');
			} 
        } catch (\Exception $e) {

        }

		session()->flash('error', trans('cyber_source::app.admin.transaction.error'));

		return redirect()->route('shop.checkout.onepage.index');
	}

	/**
	 * Prepare order's invoice data for creation.
	 *
	 * @return array
	 */
	protected function prepareInvoiceData($order)
	{
		$invoiceData = ["order_id" => $order->id];

		foreach ($order->items as $item) {
			$invoiceData['invoice']['items'][$item->id] = $item->qty_to_invoice;
		}

		return $invoiceData;
	}

	/**
	 * To Cancel Payment
	 */
	public function cancelPayment() {
		session()->flash('success', trans('cyber_source::app.admin.transaction.error'));

		return redirect()->route('shop.checkout.onepage.index');
	}
}