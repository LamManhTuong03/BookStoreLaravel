<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/clt',function(){
    return view('client.index');
});

Auth::routes();

Route::get('/',[\App\Http\Controllers\Frontend\FrontendController::class,'index']);
Route::get('/collections',[\App\Http\Controllers\Frontend\FrontendController::class,'categories']);
Route::get('/collections/{category_slug}',[\App\Http\Controllers\Frontend\FrontendController::class,'products']);
Route::get('/collections/{category_slug}/{products_slug}',[\App\Http\Controllers\Frontend\FrontendController::class,'productView']);

Route::post('paypal/payment',[\App\Http\Controllers\paypalController::class,'payment'])->name('paypal');
Route::get('paypal/success',[\App\Http\Controllers\paypalController::class,'success'])->name('payment_success');
Route::get('paypal/cancel',[\App\Http\Controllers\paypalController::class,'cancel'])->name('payment_cancel');


Route::get("/order/{idOrder}", function($idOrder) {
    $order = Order::findOrFail($idOrder);

    return view('frontend.checkout.index', compact('order'));
});

Route::post('payment', [\App\Http\Controllers\CheckOutController::class,'checkout'])->name('payment-vnpay');

Route::get('handle-payment', [\App\Http\Controllers\CheckOutController::class,'handlePayment'])->name('handlePayment');




Route::middleware(['auth'])->group(function (){
    Route::get('wishlist',[\App\Http\Controllers\Frontend\WishlistController::class,'index']);
    Route::get('cart',[\App\Http\Controllers\Frontend\CartController::class,'index']);
    Route::get('checkout',[\App\Http\Controllers\Frontend\CheckoutController::class,'index']);
});

Route::get('thank-you',[\App\Http\Controllers\Frontend\FrontendController::class,'thankyou']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('admin')->middleware(['auth','isAdmin'])->group(function (){
    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class,'index']) ;

    Route::controller(\App\Http\Controllers\Admin\SliderController::class)->group(function (){
        Route::get('sliders','index');
        Route::get('sliders/create','create');
        Route::post('sliders/create','store');
        Route::get('sliders/{slider}/edit','edit');
        Route::put('sliders/{slider}','update');
        Route::get('sliders/{slider}/delete','destroy');
    });

    //Category Routes
    Route::controller(App\Http\Controllers\Admin\CategoryController::class)->group(function () {
        Route::get('/category', 'index');
        Route::get('/category/create   ', 'create');
        Route::post('/category', 'store');
        Route::get('/category/{category}/edit', 'edit');
        Route::put('/category/{category}','update');
    });

    Route::controller(App\Http\Controllers\Admin\ProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/products/create', 'create');
        Route::post('/products', 'store');
        Route::get('/products/{product}/edit', 'edit');
        Route::put('/products/{product}','update');
        Route::get('/products/{product_id}/delete','destroy');
        Route::get('product-image/{product_image_id}/delete','destroyImage');
    });

    Route::get('/brands', \App\Livewire\Admin\Brand\Index::class);

});
