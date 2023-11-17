<div>
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <h4>My Cart</h4>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart">

                        <div class="cart-header d-none d-sm-none d-mb-block d-lg-block">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Products</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Price</h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Quantity</h4>
                                </div>
                                <div class="col-md-1">
                                    <h4>Total </h4>
                                </div>
                                <div class="col-md-2">
                                    <h4>Remove</h4>
                                </div>
                            </div>
                        </div>

                        @forelse($cart as $cartItem)
                            @if($cartItem->products)
                                <div class="cart-item">
                                <div class="row">
                                    <div class="col-md-6 my-auto">
                                        <a href="{{url('collections/'.$cartItem->products->category->slug.'/'.$cartItem->products->slug)}}">
                                            <label class="product-name">
                                                <img src="{{asset($cartItem->products->productImages[0]->image)}}" style="width: 50px; height: 50px" alt="">
                                                {{$cartItem->products->name}}
                                            </label>
                                        </a>
                                    </div>
                                    <div class="col-md-1 my-auto">
                                        <label class="price">${{$cartItem->products->selling_price}} </label>
                                    </div>
                                    <div class="col-md-2 col-7 my-auto">
                                        <div class="quantity">
                                            <div class="input-group">
                                                <button type="button" wire:loading.attr="disabled" wire:click="decrementQuantity({{$cartItem->id}})" class="btn btn1"><i class="fa fa-minus"></i></button>
                                                <input type="text" value="{{$cartItem->quantity}}" class="input-quantity" />
                                                <button type="button" wire:loading.attr="disabled" wire:click="incrementQuantity({{$cartItem->id}})" class="btn btn1"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 my-auto">
                                        <label class="price">${{$cartItem->products->selling_price * $cartItem->quantity}} </label>
                                        @php $totalPrice += $cartItem->products->selling_price * $cartItem->quantity  @endphp
                                    </div>
                                    <div class="col-md-2 col-5 my-auto">
                                        <div class="remove">
                                            <button type="button" wire:loading.attr="disabled" wire:click="removeCartItem({{$cartItem->id}})" class="btn btn-danger btn-sm">
                                                <span wire:loading.remove wire:target="removeCartItem({{$cartItem->id}})">
                                                    <i class="fa fa-trash"></i> Remove
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @empty
                            <div>No Cart Items available</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 my-md-auto mt-3">
                    <h5>
                        Get the best deals & Offers <a href="{{url('/collections')}}">Shop now</a>
                    </h5>
                </div>
                <div class="col-md-4">
                        <div class="shadow-sm bg-white p-3">
                            <h4>Total:
                                <span class="float-end">${{$totalPrice}}</span>
                            </h4>
                            <hr>
                            <a href="{{url('/checkout')}}" class="btn btn-warning w-100">Checkout</a>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
