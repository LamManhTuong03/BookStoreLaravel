<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class paypalController extends Controller
{
    //
    public $totalProductAmount;

    public function payment(Request $request)
    {
        $this->totalProductAmount = 0;
        $this->carts = Cart::where('user_id', auth()->user()->id)->get();
        foreach ($this->carts as $cartItem) {
            $this->totalProductAmount += $cartItem->products->selling_price * $cartItem->quantity;
        }


        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('payment_success'),
                 "cancel_url" => route('payment_cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "$this->totalProductAmount"
                    ]
                ]
            ]
        ]);
//        dd($response);
        if(isset($response['id']) && $response['id']!=null){
            foreach ($response['links'] as $link){
                    if($link['rel'] === 'approve'){
                        return redirect()->away($link['href']);
                    }
            }

        }else{
            return redirect()->route('payment_cancel');
        }
    }
    public function success(Request $request){
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
//        dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED'){
            return 'Payment is successful';
        }else{
            return redirect()->route('payment_cancel');
        }
    }
    public function cancel(){
        return "Payment is cancelled";
    }
}
