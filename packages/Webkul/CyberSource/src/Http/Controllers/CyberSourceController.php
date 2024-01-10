<?php

namespace Webkul\CyberSource\Http\Controllers;

use Webkul\Checkout\Facades\Cart;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;

class CyberSourceController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,  
        protected InvoiceRepository $invoiceRepository
    ) 
    {
    }

    /*
     * To Get Signature
     * 
     * @param  array  $params
     * @return string
     */
    public function sign($params) 
    {
    	$secretKey = core()->getConfigData('sales.payment_methods.cyber_source.secret_key');

        return $this->signData($this->buildDataToSign($params), $secretKey);
    }

    /*
     * To Get Signature
     * 
     * @param  string  $data
     * @param  string  $secretKey
     * @return string
     */
    public function signData($data, $secretKey) 
    {
        return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
    }
	  
    /*
     * To Prepare Data for Signature
     * 
     * @param  array  $params
     * @return string
     */
    public function buildDataToSign($params) 
    {
        $signedFieldNames = explode(",", $params["signed_field_names"]);

        foreach ($signedFieldNames as $field) {
            $dataToSign[] = $field . "=" . $params[$field];
        }

        return implode(",", $dataToSign);
    }
	  
    /**
     * Redirects to the payment server.
     *
     * @return \Illuminate\View\View
     */
    public function redirect()
    {
        $cart = Cart::getCart();

        $uniqueId =  uniqid();

        if ((bool) core()->getConfigData('sales.payment_methods.cyber_source.sandbox')) {
            cyberSourceUrl = "https://testsecureacceptance.cybersource.com/pay";        			// For Sandbox Mode
        } else {
            $cyberSourceUrl = "https://secureacceptance.cybersource.com/pay";        				// For Production Mode
        }

        $shippingRate = $cart?->selected_shipping_rate->price ?? 0; 								// shipping rate

        $discountAmount = $cart->discount_amount; 													// discount amount
		
        $amount = ($cart->sub_total + $cart->tax_total + $shippingRate) - $discountAmount; 		// total amount

        $params  = [
            "access_key"                  => core()->getConfigData('sales.payment_methods.cyber_source.access_key'),
            "profile_id"                  => core()->getConfigData('sales.payment_methods.cyber_source.profile_id'),
            "transaction_uuid" 	          => $uniqueId,
            "signed_field_names"          => 'partner_solution_id,access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency,bill_to_address_line1,bill_to_address_city,bill_to_address_state,bill_to_address_country,bill_to_address_postal_code,bill_to_email,bill_to_surname,bill_to_forename',
            "unsigned_field_names"        => '',
            "signed_date_time"            => gmdate("Y-m-d\TH:i:s\Z"),
            "locale"                      => 'en',
            "partner_solution_id"         => 'IGT4AWTG',
            "transaction_type"            => 'authorization',
            "reference_number"            => $uniqueId,
            "amount"                      => $amount,
            "currency"                    => $cart->cart_currency_code,
            "bill_to_address_line1"       => $cart->billing_address->address1,
            "bill_to_address_city"        => $cart->billing_address->city,
            "bill_to_address_state"       => $cart->billing_address->state,
            "bill_to_address_country"     => $cart->billing_address->country,
            'bill_to_address_postal_code' => $cart->billing_address->postcode,
            "bill_to_email"               => $cart->billing_address->email,
            "bill_to_surname"             => $cart->billing_address->last_name,
            "bill_to_forename"            => $cart->billing_address->first_name,
        ];

        $params['signature'] = $this->sign($params);

        return view('cyber_source::cyber-source-redirect', compact('params', 'cyberSourceUrl'));
    }

    /*
     * To Check Status of Payment
     * 
     * @return \Illuminate\Http\Response 
     */
    public function processPayment() 
    {
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
     * @param  \Webkul\Sales\Models\Order  $order
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
     * 
     * @return \Illuminate\Http\Response
     */
    public function cancelPayment() 
    {
        session()->flash('success', trans('cyber_source::app.admin.transaction.error'));

        return redirect()->route('shop.checkout.onepage.index');
    }
}