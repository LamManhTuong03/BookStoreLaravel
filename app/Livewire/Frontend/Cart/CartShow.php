<?php

namespace App\Livewire\Frontend\Cart;

use App\Models\Cart;
use Livewire\Component;

class CartShow extends Component
{
    public $cart;
    public $totalPrice = 0;

    public function  decrementQuantity(int $cartId){
        $cartData = Cart::where('id',$cartId)->where('user_id',auth()->user()->id)->first();
        if($cartData){
            $cartData->decrement('quantity');
        }
    }
    public function  incrementQuantity(int $cartId){
        $cartData = Cart::where('id',$cartId)->where('user_id',auth()->user()->id)->first();
        if($cartData){
            $cartData->increment('quantity');
        }
    }

    public function removeCartItem(int $cartId){
        $cartRemoveData = Cart::where('user_id',auth()->user()->id)->where('id',$cartId)->first();
        if ($cartRemoveData){
            $cartRemoveData->delete();
            $this->dispatch('CartAdded');
            session()->flash('message','Cart Item Removed');
        }
    }
    public function render()
    {
        $this->cart = Cart::where('user_id',auth()->user()->id)->get();
        return view('livewire.frontend.cart.cart-show',[
            'cart' => $this->cart
        ]);
    }
}
