
<?php

use App\Http\Controllers\Ecommerce\HomeController;
use App\Http\Controllers\Ecommerce\OrdersController;
use App\Http\Controllers\Ecommerce\PaymentController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ecommerce\UserController;
use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'ecommerce'], function () {


    Route::get('/', [HomeController::class, 'index'])->name('ecommerce.home');

    Route::post('/product-price', [HomeController::class, 'getProductPrice'])->name('ecommerce.product.price');

    Route::get('/register', [UserController::class, 'create'])->name('ecommerce.user.create')->middleware('guest');;

    Route::post('/register/store', [UserController::class, 'store'])->name('ecommerce.user.store')->middleware('guest');

    Route::get('/login', [UserController::class, 'show'])->name('ecommerce.user.show')->middleware('guest');

    Route::post('/login/store', [UserController::class, 'login'])->name('ecommerce.user.login')->middleware('guest');

    Route::get('/my-account', [UserController::class, 'account'])->name('ecommerce.account')->middleware('auth');

    Route::get('product/{product}', [ProductController::class, 'product'])->name('ecommerce.product');


    Route::post('cart/store', [ProductController::class, 'store'])->name('ecommerce.cart.store');
    Route::get('cart/destroy/{product}', [ProductController::class, 'destroy'])->name('ecommerce.cart.destroy');


    Route::get('cart', [ProductController::class, 'cart'])->name('ecommerce.cart');

    Route::post('cart/change', [ProductController::class, 'changeQuantity'])->name('ecommerce.cart.change');

    // favorite routes
    Route::get('wishlist', [ProductController::class, 'fav'])->name('ecommerce.fav');
    Route::get('wishlist/{product}', [ProductController::class, 'addFav'])->name('ecommerce.fav.add');


    Route::get('checkout', [ProductController::class, 'checkout'])->name('ecommerce.checkout');


    Route::get('products', [ProductController::class, 'products'])->name('ecommerce.products');


    Route::post('/shipping-calculate', [ProductController::class, 'shipping'])->name('ecommerce.shipping');
    Route::post('/country/states', [OrdersController::class, 'getStates'])->name('country.states');
    Route::post('/states/cities', [OrdersController::class, 'getCities'])->name('state.cities');
    // add new order
    Route::post('order', [OrdersController::class, 'store'])->name('ecommerce.order.store');

    Route::get('order-success', [OrdersController::class, 'orderSuccess'])->name('ecommerce.order.success');


    Route::get('payment/{orderId}', [PaymentController::class, 'checkingOut'])->name('ecommerce.payment');


    Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('ecommerce.payment.success');


    Route::post('payment/callback', [PaymentController::class, 'processedCallback'])->name('ecommerce.payment.callback');
});
