<?php

namespace App\Livewire\Frontend\Checkout;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Livewire\Component;
use Nette\Utils\ArrayHash;

class CheckoutShow extends Component
{
    public $carts;
    public $totalProductAmount;
    public $fullname;
    public $email;
    public $phone;
    public $pincode;
    public $address;
    public $payment_mode = NULL;
    public $payment_id = NULL;
    protected $listeners = [
        'validationForAll'
    ];

    public function validationForAll(){
        $this->validate();
    }
    public function rules(){
        return [
            'fullname' => 'required|string|max:121',
            'email' => 'required|email|max:121',
            'phone' => 'required|string|max:11|min:10',
            'pincode' => 'required|string|max:121',
            'address' => 'required|string|max:500'
        ];
    }
    public function placeOrder(){
        $this->validate();
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'tracking_no' => 'bookstore-'.Str::random(10),
            'fullname' => $this->fullname,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'pincode'=> $this->pincode,
            'address'=> $this->address,
            'status_message'=> 'in progress',
            'payment_mode'=> $this->payment_mode,
            'payment_id' => $this->payment_id
        ]);
        foreach ($this->carts as $cartItem){
            $orderItems = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->products->selling_price
            ]);
        }
        return $order;
    }
    public function codOrder(){
        $this->payment_mode = 'Cash on Delivery';
        $codOrder = $this->placeOrder();
        if($codOrder){
            Cart::where('user_id',auth()->user()->id)->delete();
            session()->flash('message','Order Sucessfully');
            return redirect()->to('thank-you');
        }else{
            session()->flash('message','Order Failed');
        }
    }
    public function totalProductAmount(){
        $this->totalProductAmount = 0;
        $this->carts = Cart::where('user_id',auth()->user()->id)->get();
        foreach ($this->carts as $cartItem){
            $this->totalProductAmount += $cartItem->products->selling_price * $cartItem->quantity;
        }
        return $this->totalProductAmount;
    }
    public function render()
    {
        $this->fullname = auth()->user()->name;
        $this->email = auth()->user()->name;
        $this->totalProductAmount = $this->totalProductAmount();
        return view('livewire.frontend.checkout.checkout-show',[
            'totalProductAmount' => $this->totalProductAmount
        ]);
    }
}
