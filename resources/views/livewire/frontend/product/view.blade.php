<div>
    <div class="py-3 py-md-5 bg-light">
        <div class="container">

            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-5 mt-3">
                    <div class="bg-white border">
                        <img src="{{asset($products->productImages[0]->image)}}" class="w-100" alt="Img">
                    </div>
                </div>
                <div class="col-md-7 mt-3">
                    <div class="product-view">
                        <h4 class="product-name">
                            {{$products->name}}
                            <label class="label-stock bg-success">In Stock</label>
                        </h4>
                        <hr>
                        <p class="product-path">
                            Home / {{$products->category->name}} / {{$products->name}}
                        </p>
                        <div>
                            <span class="selling-price">${{$products->selling_price}}</span>
                            <span class="original-price">${{$products->original_price}}</span>
                        </div>
                        <div>
                            @if($products->quantity)
                                <label class="btn-sm py-1 mt-2 text-white bg-success">In Stock</label>
                            @else
                                <label class="btn-sm py-1 mt-2 text-white bg-danger">Out of Stock</label>
                            @endif
                        </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <span class="btn btn1" wire:click="decrementQuantity"><i class="fa fa-minus"></i></span>
                                <input type="text" wire:model="quantityCount" value="{{$this->quantityCount}}" readonly class="input-quantity" />
                                <span class="btn btn1" wire:click="incrementQuantity"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" class="btn btn1" wire:click="addToCart({{$products->id}})">
                            <i class="fa fa-shopping-cart"></i> Add To Cart
                            </button>

                            <button type="button" wire:click="addToWishList({{$products->id}})" class="btn btn1">
                                <span wire:loading.remove wire:target="addToWishList"><i class="fa fa-heart"></i> Add To Wishlist</span>
                                <span wire:loading wire:target="addToWishList">Adding...</span>
                            </button>
                        </div>
                        <div class="mt-3">
                            <h5 class="mb-0">Small Description</h5>
                            <p>
                             {!! $products->small_description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h4>Description</h4>
                        </div>
                        <div class="card-body">
                            <p>
                                {!! $products->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
