
<?php

use App\Http\Controllers\Ecommerce\EcommerceHomeController;
use App\Http\Controllers\Ecommerce\OrdersController;
use App\Http\Controllers\Ecommerce\PaymentController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ecommerce\UserController;
use Illuminate\Support\Facades\Route;


// ['prefix' => 'ecommerce'],
// Route::group(['prefix' => 'store'], function () {

// Route::post('/', [EcommerceHomeController::class, 'homePost']);

Route::get('/home', [EcommerceHomeController::class, 'index'])->name('ecommerce.home');

Route::post('/product-price', [EcommerceHomeController::class, 'getProductPrice'])->name('ecommerce.product.price');

Route::get('/register', [UserController::class, 'create'])->name('ecommerce.user.create')->middleware('guest');;

Route::post('/register/store', [UserController::class, 'store'])->name('ecommerce.user.store')->middleware('guest');

Route::get('/login', [UserController::class, 'show'])->name('ecommerce.user.show')->middleware('guest');

Route::post('/login/store', [UserController::class, 'login'])->name('ecommerce.user.login')->middleware('guest');

Route::get('/my-account', [UserController::class, 'account'])->name('ecommerce.account')->middleware('auth');

Route::get('/product/{product}/{slug}', [ProductController::class, 'product'])->name('ecommerce.product');


Route::post('/cart/store', [ProductController::class, 'store'])->name('ecommerce.cart.store');
Route::post('/cart/clac/rent', [ProductController::class, 'calcRentData'])->name('ecommerce.rent.calc');
Route::get('/cart/destroy/{product}', [ProductController::class, 'destroy'])->name('ecommerce.cart.destroy');


Route::get('/cart', [ProductController::class, 'cart'])->name('ecommerce.cart');

Route::post('/cart/change', [ProductController::class, 'changeQuantity'])->name('ecommerce.cart.change');

// favorite routes
Route::get('/wishlist/{product}', [ProductController::class, 'addFav'])->name('ecommerce.fav.add');
Route::get('/wishlist', [ProductController::class, 'wishlist'])->name('ecommerce.wishlist');


Route::get('/checkout', [ProductController::class, 'checkout'])->name('ecommerce.checkout');


Route::get('/products', [ProductController::class, 'products'])->name('ecommerce.products');


Route::post('/shipping-calculate', [ProductController::class, 'shipping'])->name('ecommerce.shipping');
Route::post('/company-months', [ProductController::class, 'companyMonths'])->name('company.months');
Route::post('/installment-price', [ProductController::class, 'getProductPrice'])->name('installment.product.price');
Route::post('/installment-data', [ProductController::class, 'getInstallmentData'])->name('installment.data');
Route::post('/country/states', [OrdersController::class, 'getStates'])->name('country.states');
Route::post('/states/cities', [OrdersController::class, 'getCities'])->name('state.cities');
// add new order
Route::post('/order', [OrdersController::class, 'store'])->name('ecommerce.order.store');
Route::get('/cancel-order/{order}', [OrdersController::class, 'orderCancle'])->name('ecommerce.order.cancle');
Route::post('/installment-order', [OrdersController::class, 'installmentStore'])->name('ecommerce.installment.store');


Route::get('/order-success', [OrdersController::class, 'orderSuccess'])->name('ecommerce.order.success');
Route::get('/order-faild', [PaymentController::class, 'orderFailed'])->name('ecommerce.order.failed');


Route::get('/payment/{orderId}', [PaymentController::class, 'checkingOut'])->name('ecommerce.payment');


Route::get('/download', [ProductController::class, 'download'])->name('ecommerce.download');


Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('ecommerce.payment.success');


Route::post('/payment-callback', [PaymentController::class, 'processedCallback'])->name('ecommerce.payment.callback');

Route::get('/payment-test', [PaymentController::class, 'test'])->name('ecommerce.payment.test');


Route::post('/review-product/{product}', [ProductController::class, 'storeReview'])->name('ecommerce.product.review');
Route::post('/review-order/{order}', [ProductController::class, 'storeOrderReview'])->name('ecommerce.order.review');

Route::post('/change-password', [UserController::class, 'changePassword'])->name('ecommerce.password.change')->middleware('auth');

Route::get('/invoice/{order}', [PaymentController::class, 'invoice'])->name('ecommerce.invoice');
Route::get('/about-us', [EcommerceHomeController::class, 'about'])->name('ecommerce.about');
Route::get('/terms', [EcommerceHomeController::class, 'terms'])->name('ecommerce.terms');

Route::get('/contact-us', [EcommerceHomeController::class, 'contact'])->name('ecommerce.contact');

Route::post('contact/create', [EcommerceHomeController::class, 'contactCreate'])->name('ecommerce.contact.create');


Route::post('/product-search', [ProductController::class, 'search'])->name('ecommerce.product.search');

Route::get('/contact', [EcommerceHomeController::class, 'contact'])->name('ecommerce.contact');
Route::get('/setCountry/{country_id}', [EcommerceHomeController::class, 'setCountry'])->name('set.country');

Route::get('/whatsapp', [EcommerceHomeController::class, 'whatsapp'])->name('whatsapp.send');


Route::get('/products.xml', function () {
    return response()->file(storage_path('app/products.xml'));
});


// });
