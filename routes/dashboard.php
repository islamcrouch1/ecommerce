<?php

use App\Http\Controllers\Dashboard\AccountsController;
use App\Http\Controllers\Dashboard\AssetsController;
use App\Http\Controllers\Dashboard\AttributesController;
use App\Http\Controllers\Dashboard\BonusController;
use App\Http\Controllers\Dashboard\BranchesController;
use App\Http\Controllers\Dashboard\BrandsController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\CitiesController;
use App\Http\Controllers\Dashboard\ClientsController;
use App\Http\Controllers\Dashboard\ColorsController;
use App\Http\Controllers\Dashboard\CountriesController;
use App\Http\Controllers\Dashboard\EntriesController;
use App\Http\Controllers\Dashboard\ExportController;
use App\Http\Controllers\Dashboard\FinancesController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\LogsController;
use App\Http\Controllers\Dashboard\MediasController;
use App\Http\Controllers\Dashboard\MessagesController;
use App\Http\Controllers\Dashboard\NotesController;
use App\Http\Controllers\Dashboard\OrdersController;
use App\Http\Controllers\Dashboard\PasswordResetController;
use App\Http\Controllers\Dashboard\PaymentsController;
use App\Http\Controllers\Dashboard\PreviewsClientsController;
use App\Http\Controllers\Dashboard\PreviewsController;
use App\Http\Controllers\Dashboard\PurchasesController;
use App\Http\Controllers\Dashboard\QueriesController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\SalesController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\ShippingRatesController;
use App\Http\Controllers\Dashboard\SizesController;
use App\Http\Controllers\Dashboard\SlidesController;
use App\Http\Controllers\Dashboard\StagesController;
use App\Http\Controllers\Dashboard\StatesController;
use App\Http\Controllers\Dashboard\StockController;
use App\Http\Controllers\Dashboard\StockTransferController;
use App\Http\Controllers\Dashboard\TaxesController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\VariationsController;
use App\Http\Controllers\Dashboard\WarehousesController;
use App\Http\Controllers\Dashboard\WebsitesettingController;
use App\Http\Controllers\Dashboard\WithdrawalsController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'dashboard', 'middleware' => ['role:superadministrator|administrator']], function () {

    // admin users routes
    Route::resource('users', UsersController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('users/export/', [UsersController::class, 'export'])->name('users.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-users', [UsersController::class, 'trashed'])->name('users.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-users/{user}', [UsersController::class, 'restore'])->name('users.restore')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/activate-users/{user}', [UsersController::class, 'activate'])->name('users.activate')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/block-users/{user}', [UsersController::class, 'block'])->name('users.block')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/add-bonus/{user}', [UsersController::class, 'bonus'])->name('users.bonus')->middleware('auth', 'checkverified', 'checkstatus');

    // countries routes
    Route::resource('countries', CountriesController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-countries', [CountriesController::class, 'trashed'])->name('countries.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-countries/{country}', [CountriesController::class, 'restore'])->name('countries.restore')->middleware('auth', 'checkverified', 'checkstatus');


    // states routes
    Route::resource('states', StatesController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-states', [StatesController::class, 'trashed'])->name('states.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-states/{state}', [StatesController::class, 'restore'])->name('states.restore')->middleware('auth', 'checkverified', 'checkstatus');


    // cities routes
    Route::resource('cities', CitiesController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-cities', [CitiesController::class, 'trashed'])->name('cities.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-cities/{city}', [CitiesController::class, 'restore'])->name('cities.restore')->middleware('auth', 'checkverified', 'checkstatus');




    // withdrawal routes
    Route::get('withdrawals', [WithdrawalsController::class, 'index'])->name('withdrawals.index')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('withdrawals/update/{withdrawal}', [WithdrawalsController::class, 'update'])->name('withdrawals.update')->middleware('auth', 'checkverified', 'checkstatus');

    // roles routes
    Route::resource('roles',  RoleController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-roles', [RoleController::class, 'trashed'])->name('roles.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-roles/{role}', [RoleController::class, 'restore'])->name('roles.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // categories routes
    Route::resource('categories', CategoriesController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-categories', [CategoriesController::class, 'trashed'])->name('categories.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-categories/{category}', [CategoriesController::class, 'restore'])->name('categories.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // brands routes
    Route::resource('brands', BrandsController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-brands', [BrandsController::class, 'trashed'])->name('brands.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-brands/{brand}', [BrandsController::class, 'restore'])->name('brands.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // attributes routes
    Route::resource('attributes', AttributesController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-attributes', [AttributesController::class, 'trashed'])->name('attributes.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-attributes/{attribute}', [AttributesController::class, 'restore'])->name('attributes.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // variations routes
    Route::resource('variations', VariationsController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-variations', [VariationsController::class, 'trashed'])->name('variations.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-variations/{variation}', [VariationsController::class, 'restore'])->name('variations.restore')->middleware('auth', 'checkverified', 'checkstatus');


    // warehouses routes
    Route::resource('warehouses', WarehousesController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-warehouses', [WarehousesController::class, 'trashed'])->name('warehouses.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-warehouses/{warehouse}', [WarehousesController::class, 'restore'])->name('warehouses.restore')->middleware('auth', 'checkverified', 'checkstatus');


    // stock transfer routes
    Route::resource('stock_transfers', StockTransferController::class)->middleware('auth', 'checkverified', 'checkstatus');


    // settings route
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/settings-store', [SettingController::class, 'store'])->name('settings.store')->middleware('auth', 'checkverified', 'checkstatus');


    // website settings route
    Route::get('/website-setting', [WebsitesettingController::class, 'index'])->name('website-setting.index')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/website-setting-store', [WebsitesettingController::class, 'store'])->name('website-setting.store')->middleware('auth', 'checkverified', 'checkstatus');



    // products routes
    Route::resource('products', ProductsController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-products', [ProductsController::class, 'trashed'])->name('products.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-products/{product}', [ProductsController::class, 'restore'])->name('products.restore')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/products/stock/{product}', [ProductsController::class, 'stockCreate'])->name('products.stock.create')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/products/stock/create', [ProductsController::class, 'stockProductCreate'])->name('products.stock.add')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/products/stock-store/{product}', [ProductsController::class, 'stockStore'])->name('products.stock.store')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/products/color/{product}', [ProductsController::class, 'colorCreate'])->name('products.color.create')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/products/color-store/{product}', [ProductsController::class, 'colorStore'])->name('products.color.store')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/stock/color-remove/{stock}', [ProductsController::class, 'colorDestroy'])->name('products.color.destroy')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('products/status/{product}', [ProductsController::class, 'updateStatus'])->name('products.status')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('products-bulk/status', [ProductsController::class, 'updateStatusBulk'])->name('products.status.bulk')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/vendors-products', [ProductsController::class, 'vendorsIndex'])->name('products.vendors')->middleware('auth', 'checkverified', 'checkstatus');

    // product color routes
    Route::resource('colors', ColorsController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-colors', [ColorsController::class, 'trashed'])->name('colors.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-colors/{color}', [ColorsController::class, 'restore'])->name('colors.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // product size routes
    Route::resource('sizes', SizesController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-sizes', [SizesController::class, 'trashed'])->name('sizes.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-sizes/{size}', [SizesController::class, 'restore'])->name('sizes.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // shipping rates routes
    Route::resource('shipping_rates', ShippingRatesController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-shipping_rates', [ShippingRatesController::class, 'trashed'])->name('shipping_rates.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-shipping_rates/{shipping_rate}', [ShippingRatesController::class, 'restore'])->name('shipping_rates.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // slider routes
    Route::resource('slides', SlidesController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-slides', [SlidesController::class, 'trashed'])->name('slides.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-slides/{slide}', [SlidesController::class, 'restore'])->name('slides.restore')->middleware('auth', 'checkverified', 'checkstatus');


    // orders routes
    Route::resource('orders', OrdersController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('orders/status/{order}', [OrdersController::class, 'updateStatus'])->name('orders.status')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('orders-bulk/status', [OrdersController::class, 'updateStatusBulk'])->name('orders.status.bulk')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('orders/admin/refund/{order}', [OrdersController::class, 'rejectRefund'])->name('orders.refund.reject')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('orders/admin/refunds', [OrdersController::class, 'refundsIndex'])->name('orders.refunds')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('orders/admin/mandatory', [OrdersController::class, 'mandatoryIndex'])->name('orders.mandatory')->middleware('auth', 'checkverified', 'checkstatus');

    // vendors orders routes  orders.vendor.mandatory
    Route::get('vendor-orders', [OrdersController::class, 'indexVendors'])->name('orders-vendor')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('vendor-orders/status/{vendor_order}', [OrdersController::class, 'updateStatusVendor'])->name('orders.vendor.status')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('vendor-orders-bulk/status', [OrdersController::class, 'updateStatusVendorBulk'])->name('orders.vendor.status.bulk')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('vendor-orders/mandatory', [OrdersController::class, 'mandatoryIndexVendor'])->name('orders.vendor.mandatory')->middleware('auth', 'checkverified', 'checkstatus');

    // users and orders notes routes
    Route::post('user/note/{user}', [NotesController::class, 'addUserNote'])->name('users.note')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('order/note/{order}', [NotesController::class, 'addorderNote'])->name('orders.note')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('notes/edit/{note}', [NotesController::class, 'edit'])->name('notes.admin.edit')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('notes/update/{note}', [NotesController::class, 'update'])->name('notes.admin.update')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('notes/delete/{note}', [NotesController::class, 'destroy'])->name('notes.admin.destroy')->middleware('auth', 'checkverified', 'checkstatus');

    // users queries routes
    Route::post('user/query/{user}', [QueriesController::class, 'addUserQuery'])->name('users.query')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('queries/edit/{query}', [QueriesController::class, 'edit'])->name('queries.admin.edit')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('queries/update/{query}', [QueriesController::class, 'update'])->name('queries.admin.update')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('queries/delete/{query}', [QueriesController::class, 'destroy'])->name('queries.admin.destroy')->middleware('auth', 'checkverified', 'checkstatus');

    // bonus routes
    Route::resource('bonus', BonusController::class)->middleware('auth', 'checkverified', 'checkstatus');

    // logs routes
    Route::resource('logs', LogsController::class)->middleware('auth', 'checkverified', 'checkstatus');

    // finances routes
    Route::get('finances', [FinancesController::class, 'index'])->name('finances.index')->middleware('auth', 'checkverified', 'checkstatus');

    // messages routes
    Route::get('messages/admin', [MessagesController::class, 'index'])->name('messages.admin.index')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('messages/admin/store/{user}', [MessagesController::class, 'store'])->name('messages.admin.store')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-messages', [MessagesController::class, 'trashed'])->name('messages.admin.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-messages/{message}', [MessagesController::class, 'restore'])->name('messages.admin.restore')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('messages/delete/{message}', [MessagesController::class, 'destroy'])->name('messages.admin.destroy')->middleware('auth', 'checkverified', 'checkstatus');

    // export and import routes
    Route::get('orders/admin/export',  [ExportController::class, 'ordersExport'])->name('orders.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('withdrawals/admin/export', [ExportController::class, 'withdrawalsExport'])->name('withdrawals.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('products/admin/export', [ExportController::class, 'productsExport'])->name('products.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('users/admin/export', [ExportController::class, 'usersExport'])->name('users.export')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('products/import/', [ExportController::class, 'import'])->name('products.import')->middleware('auth', 'checkverified', 'checkstatus');

    // stock management routes
    Route::get('stock/management', [StockController::class, 'index'])->name('stock.management.index')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('stock/add', [StockController::class, 'atockAdd'])->name('stock.management.add')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('stock/list', [StockController::class, 'stockList'])->name('stock.management.list')->middleware('auth', 'checkverified', 'checkstatus');

    Route::post('stock/search', [StockController::class, 'search'])->name('stock.management.search')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('stock/combination', [StockTransferController::class, 'search'])->name('stock.management.com')->middleware('auth', 'checkverified', 'checkstatus');

    Route::get('stock/inventory', [StockController::class, 'inventory'])->name('stock.management.inventory')->middleware('auth', 'checkverified', 'checkstatus');

    // media routes
    Route::resource('medias', MediasController::class)->middleware('auth', 'checkverified', 'checkstatus');


    // accounts routes
    Route::resource('accounts', AccountsController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-accounts', [AccountsController::class, 'trashed'])->name('accounts.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-accounts/{account}', [AccountsController::class, 'restore'])->name('accounts.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // accounts routes
    Route::resource('assets', AssetsController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-assets', [AssetsController::class, 'trashed'])->name('assets.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-assets/{asset}', [AssetsController::class, 'restore'])->name('assets.restore')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/sell-assets-post/{account}', [AssetsController::class, 'sell'])->name('assets.sell')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/sell-assets/{account}', [AssetsController::class, 'sellCreate'])->name('assets.sell.create')->middleware('auth', 'checkverified', 'checkstatus');

    Route::post('/purchase-assets-post/{account}', [AssetsController::class, 'purchase'])->name('assets.purchase')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/purchase-assets/{account}', [AssetsController::class, 'purchaseCreate'])->name('assets.purchase.create')->middleware('auth', 'checkverified', 'checkstatus');



    // taxes routes
    Route::resource('taxes', TaxesController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-taxes', [TaxesController::class, 'trashed'])->name('taxes.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-taxes/{tax}', [TaxesController::class, 'restore'])->name('taxes.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // entries routes
    Route::resource('entries', EntriesController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-entries', [EntriesController::class, 'trashed'])->name('entries.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-entries/{entry}', [EntriesController::class, 'restore'])->name('entries.restore')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/getsubaccounts', [EntriesController::class, 'getSubAccounts'])->name('entries.accounts')->middleware('auth', 'checkverified', 'checkstatus');

    Route::get('/income', [EntriesController::class, 'income'])->name('entries.income')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/balance', [EntriesController::class, 'balance'])->name('entries.balance')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trial-balance', [EntriesController::class, 'trial'])->name('entries.trial')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/settle', [EntriesController::class, 'settleCreate'])->name('entries.settle.create')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/settle-store', [EntriesController::class, 'settleStore'])->name('entries.settle.store')->middleware('auth', 'checkverified', 'checkstatus');


    // purchases routes
    Route::resource('purchases', PurchasesController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/combination/purchase', [PurchasesController::class, 'searchPurchase'])->name('purchases.combinations')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/combination/purchase/calculate', [PurchasesController::class, 'calTotal'])->name('purchases.combinations.cal')->middleware('auth', 'checkverified', 'checkstatus');

    Route::get('/return-purchases', [PurchasesController::class, 'craeteReturn'])->name('purchases.create.return')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/return-purchases-post', [PurchasesController::class, 'storeReturn'])->name('purchases.store.return')->middleware('auth', 'checkverified', 'checkstatus');

    Route::post('purchases/status/{order}', [PurchasesController::class, 'updateStatus'])->name('purchases.status')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('purchases-bulk/status', [PurchasesController::class, 'updateStatusBulk'])->name('purchases.status.bulk')->middleware('auth', 'checkverified', 'checkstatus');



    // sales routes
    Route::resource('sales', SalesController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::post('/combination/sales', [SalesController::class, 'searchSales'])->name('sales.combinations')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/combination/sales/calculate', [SalesController::class, 'calTotal'])->name('sales.combinations.cal')->middleware('auth', 'checkverified', 'checkstatus');

    Route::get('/return-sales', [SalesController::class, 'craeteReturn'])->name('sales.create.return')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/return-sales-post', [SalesController::class, 'storeReturn'])->name('sales.store.return')->middleware('auth', 'checkverified', 'checkstatus');


    Route::post('/return-sales-search', [StockController::class, 'searchReturn'])->name('sales.create.search')->middleware('auth', 'checkverified', 'checkstatus');


    Route::post('sales/status/{order}', [SalesController::class, 'updateStatus'])->name('sales.status')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('sales-bulk/status', [SalesController::class, 'updateStatusBulk'])->name('sales.status.bulk')->middleware('auth', 'checkverified', 'checkstatus');


    // branches routes
    Route::resource('branches', BranchesController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-branches', [BranchesController::class, 'trashed'])->name('branches.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-branches/{branche}', [BranchesController::class, 'restore'])->name('branches.restore')->middleware('auth', 'checkverified', 'checkstatus');


    // stages routes
    Route::resource('stages', StagesController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-stages', [StagesController::class, 'trashed'])->name('stages.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-stages/{stage}', [StagesController::class, 'restore'])->name('stages.restore')->middleware('auth', 'checkverified', 'checkstatus');

    // previews routes
    Route::resource('previews', PreviewsController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-previews', [PreviewsController::class, 'trashed'])->name('previews.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-previews/{preview}', [PreviewsController::class, 'restore'])->name('previews.restore')->middleware('auth', 'checkverified', 'checkstatus');


    // previews clients routes
    Route::resource('previews_clients', PreviewsClientsController::class)->middleware('auth', 'verifiedphone', 'checkstatus');
    Route::get('/trashed-previews_clients', [PreviewsClientsController::class, 'trashed'])->name('previews_clients.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-previews/{previews_client}', [PreviewsClientsController::class, 'restore'])->name('previews_clients.restore')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/previews/create/{user}', [PreviewsClientsController::class, 'createPreview'])->name('previews.create')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/previews/store/{user}', [PreviewsClientsController::class, 'StorePreview'])->name('previews.store')->middleware('auth', 'checkverified', 'checkstatus');


    // clients routes
    Route::resource('clients', ClientsController::class)->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-clients', [ClientsController::class, 'trashed'])->name('clients.trashed')->middleware('auth', 'checkverified', 'checkstatus');
    Route::get('/trashed-clients/{country}', [ClientsController::class, 'restore'])->name('clients.restore')->middleware('auth', 'checkverified', 'checkstatus');


    // payments routes
    Route::get('/payments/{order}', [PaymentsController::class, 'create'])->name('payments.create')->middleware('auth', 'checkverified', 'checkstatus');
    Route::post('/payments-store/{order}', [PaymentsController::class, 'store'])->name('payments.store')->middleware('auth', 'checkverified', 'checkstatus');



    // --------------------------------------------- Vendors Routes ---------------------------------------------

    // vendor product routes
    Route::resource('vendor-products', ProductsController::class)->middleware('auth', 'checkverified', 'checkstatus');
});


// reset password routes
Route::get('/send-conf', [PasswordResetController::class, 'sendConf'])->name('send.conf');
Route::get('/password-reset-request', [PasswordResetController::class, 'index'])->name('password.reset.request');
Route::post('/password-reset-verify', [PasswordResetController::class, 'verify'])->name('password.reset.verify');
Route::post('/password-reset-change', [PasswordResetController::class, 'change'])->name('password.reset.change');
Route::get('/password-reset-confirm-show', [PasswordResetController::class, 'show'])->name('password.reset.confirm.show');
Route::get('/password-reset-resend', [PasswordResetController::class, 'resend'])->name('resend.code.password');
Route::post('/password-reset-confirm-password', [PasswordResetController::class, 'confirm'])->name('password.reset.confirm.password');
