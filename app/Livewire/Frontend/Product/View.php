<?php

namespace App\Livewire\Frontend\Product;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class View extends Component
{
    public $category;
    public $products;
    public $quantityCount = 1;

    public function addToWishList($productId)
    {
        if (Auth::check()) {
            if (Wishlist::where('user_id', auth()->user()->id)->where('product_id', $productId)->exists()) {
                session()->flash('message', 'Added to Wishlist');
                return false;
            } else {
                Wishlist::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $productId
                ]);
                $this->dispatch('wishlistAdded');
                session()->flash('message', 'Added to Wishlist');
            }
        } else {
            session()->flash('message', 'Please Login To Continue');
            $this->dispatch('message', [
                'text' => 'Please Login To Continue',
                'type' => 'info',
                'status' => 401,
            ]);
            return false;
        }

    }

    public function addToCart(int $productId)
    {
        if (Auth::check()) {
            if ($this->products->where('id', $productId)->where('status', '0')->exists()) {
                if ($this->products->quantity > 0) {
                    if ($this->products->quantity > $this->quantityCount) {
                        Cart::create([
                            'user_id' => auth()->user()->id,
                            'product_id' => $productId,
                            'quantity' => $this->quantityCount
                        ]);
                        $this->dispatch('CartAdded');
                        session()->flash('message','Product Added');
                    } else {
                        session()->flash('message', 'Only'.$this->products->quantity.'Quantity Available');
                    }
                } else {
                    session()->flash('message', 'Out of Stock');
                }
            } else {
                session()->flash('message', 'Out of Stock');
            }
        } else {
            session()->flash('message', 'Please Login To Continue');
        }
    }
    function incrementQuantity()
    {
        if ($this->quantityCount < 10) {
            $this->quantityCount++;
        }

    }

    public
    function decrementQuantity()
    {
        if ($this->quantityCount > 1) {
            $this->quantityCount--;
        }

    }

    public
    function mount($category, $products)
    {
        $this->category = $category;
        $this->products = $products;
    }

    public
    function render()
    {
        return view('livewire.frontend.product.view', [
            'category' => $this->category,
            'products' => $this->products
        ]);
    }
}
