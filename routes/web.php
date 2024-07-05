<?php

use App\Events\SendLocation;
use App\Http\Controllers\Admin\CarController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\Website\WebsiteController;
use App\Http\Controllers\Website\productscontroller;
use App\Http\Controllers\Website\OrdersController;
use App\Http\Controllers\Website\AddressController;
use App\Http\Controllers\Website\SearchController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\ratingController;
use App\Http\Controllers\Website\TyreController;
use App\Http\Controllers\Website\LikedProductsControllers;

use App\Http\Controllers\Website\BatteryChangeController;


use App\Http\Controllers\Admin\home_Controller;

use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\dashboard\upload;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//use App\Http\Controllers\Admin\SliderController;
//use App\Http\Controllers\Admin\BannerController;


use App\Http\Controllers\Admin\UserController;


use App\Http\Controllers\Admin\product_companyController;
use App\Http\Controllers\Admin\product_brandController;
use App\Http\Controllers\Admin\product_manufacturersController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\FcmController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/setup', function () {
    return Artisan::call('storage:link');
});

Route::get('/setup2', function () {
    return Artisan::call('optimize:clear');
});


Route::get('test_track', function () {
    return view('website.order_track.test');
});
Route::get('test_track2', function () {
    return view('website.order_track.test2');
});

Route::post('test_token', function () {
    return  Auth::user()->createToken('API Token')->plainTextToken;
});

Route::get('/get_message', [MessagesController::class, 'get_message'])->name('get_message');
Route::get('/get_notification', [MessagesController::class, 'get_notification'])->name('get_notification');
Route::get('/update_notifi', [NotificationController::class, 'update'])->name('update-notufu');
// Route::get('/test', [NotificationController::class, 'test'])->name('test');
Route::post('/save-token', [FcmController::class, 'update'])->name('save-token');
Route::get('/send-token', [FcmController::class, 'send'])->name('send-token');
Route::get('/notifications', [NotificationController::class, 'showNotifications'])->name('notifications');
Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
// Route::post('/save-token', [NotificationController::class, 'saveToken']);

Route::get('payment-status', function () {
    return view('payment-status');
})->name('payment-status');


Route::prefix('dashboard')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm']);
    // ->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
});
Route::prefix('user')->group(function () {
    // Route::get('login', [UserAuthController::class, 'showLoginForm']);
    Route::post('register', [UserAuthController::class, 'register'])->name('user.register');
    Route::get('verify', [UserAuthController::class, 'verify_page'])->name('user.verify_page');
    Route::post('verify', [UserAuthController::class, 'verify'])->name('user.verify');

    Route::post('login', [UserAuthController::class, 'login'])->name('user.login');
    // Route::post('logout', [UserAuthController::class, 'logout'])->name('user.logout');
});

Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->group(function () {
        Route::prefix('dashboard')->middleware(['isAdmin'])->group(function () {
            Route::get('/', [home_Controller::class, 'index'])->name('dashboard.index');
            Route::get('/user_profile', [home_Controller::class, 'profile'])->name('profile');
            Route::post('/update_user', [UserController::class, 'update_user'])->name('dashboard.update_user');

            //categories
            //Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
            Route::prefix('categories')->group(function () {
                Route::get('/', [CategoryController::class, 'index'])->name('dashboard.categories.index');
                //get url "/dashboard/categories/dataTable"
                Route::get('dataTable', [CategoryController::class, 'getDataTableOfCategories'])->name('dashboard.categories.dataTable');
                //post url "dashboard/categories/id/edit
                Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('dashboard.categories.edit');
                //post url "dashboard/categories/id/update
                Route::post('/{id}/update', [CategoryController::class, 'update'])->name('dashboard.categories.update');
                // post url "dashboard/categories/id/destroy
                Route::post('/{id}/destroy', [CategoryController::class, 'destroy'])->name('dashboard.categories.destroy');
                // post url "/dashboard/categories/store"
                Route::post('/store', [CategoryController::class, 'store'])->name('dashboard.categories.store');
                Route::get('/{categories}/categories_image', [ProductController::class, 'getImages'])->name('dashboard.categories.categories_image.getImages');
            });



            Route::prefix('coupons')->group(function () {
                Route::get('/', [CouponController::class, 'index'])->name('dashboard.coupons.index');
                Route::get('/dataTable', [CouponController::class, 'getDataTableOfCoupons'])->name('dashboard.coupons.dataTable');
                Route::post('/store', [CouponController::class, 'store'])->name('dashboard.coupons.store');
                Route::get('/create', [CouponController::class, 'create'])->name('dashboard.coupons.create');
                Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('dashboard.coupons.edit');
                Route::post('/{coupon}/update', [CouponController::class, 'update'])->name('dashboard.coupons.update');
                Route::post('/{coupon}/destroy', [CouponController::class, 'destroy'])->name('dashboard.coupons.destroy');
            });



            Route::post('store_size', [ProductController::class, 'store_size'])->name('dashboard.products.store_size');
            Route::post('store_color', [ProductController::class, 'store_color'])->name('dashboard.products.store_color');
            //products"
            Route::prefix('products')->group(function () {
                // get url "/dashboard/products_company"
                Route::get('/products_company', [product_companyController::class, 'index'])->name('dashboard.product_company.index');
                Route::post('/products_company', [product_companyController::class, 'store'])->name('dashboard.product_company.store');

                Route::get('/products_company/edit{id}', [product_companyController::class, 'edit'])->name('dashboard.product_company.edit');
                Route::post('/products_company/update', [product_companyController::class, 'update'])->name('dashboard.product_company.update');

                //get url "/dashboard/products_company/dataTable"
                Route::get('products_companydataTable', [product_companyController::class, 'getDataTableOfproduct_company'])->name('dashboard.products_company.dataTable');

                // get url "/dashboard/products_brand"
                Route::get('/products_brand', [product_brandController::class, 'index'])->name('dashboard.product_brand.index');
                Route::post('/products_brand', [product_brandController::class, 'store'])->name('dashboard.product_brand.store');

                Route::get('/products_brand/edit{id}', [product_brandController::class, 'edit'])->name('dashboard.product_brand.edit');
                Route::post('/products_brand/update', [product_brandController::class, 'update'])->name('dashboard.product_brand.update');

                //get url "/dashboard/products_brand/dataTable"
                Route::get('products_branddataTable', [product_brandController::class, 'getDataTableOfproducts_brand'])->name('dashboard.product_brand.dataTable');


                // get url "/dashboard/product_manufacturers"
                Route::get('/product_manufacturers', [product_manufacturersController::class, 'index'])->name('dashboard.product_manufacturers.index');
                Route::post('/product_manufacturers', [product_manufacturersController::class, 'store'])->name('dashboard.product_manufacturers.store');

                Route::get('/product_manufacturers/edit{id}', [product_manufacturersController::class, 'edit'])->name('dashboard.product_manufacturers.edit');
                Route::post('/product_manufacturers/update', [product_manufacturersController::class, 'update'])->name('dashboard.product_manufacturers.update');

                //get url "/dashboard/product_manufacturers/dataTable"
                Route::get('product_manufacturersdataTable', [product_manufacturersController::class, 'getDataTableOfproduct_manufacturers'])->name('dashboard.product_manufacturers.dataTable');


                // get url "/dashboard/products"
                Route::get('/', [ProductController::class, 'index'])->name('dashboard.products.index');

                // post url "/dashboard/products/store"
                Route::post('store', [ProductController::class, 'store'])->name('dashboard.products.store');
                Route::post('store_attributes', [ProductController::class, 'store_attributes'])->name('dashboard.products.store_attributes');
                Route::post('/store_variations', [ProductController::class, 'store_variations'])->name('dashboard.products.store_variations');
                Route::post('/update_variations', [ProductController::class, 'update_variations'])->name('dashboard.products.update_variations');
                Route::post('/destroy_attributes', [ProductController::class, 'destroy_attributes'])->name('dashboard.products.destroy_attributes');
                //get url "/dashboard/products/dataTable"
                Route::get('dataTable', [ProductController::class, 'getDataTableOfProducts'])->name('dashboard.products.dataTable');
                //get url "dashboard/products/id/edit
                Route::get('/{id}/prices-log', [ProductController::class, 'pricesLog'])->name('dashboard.products.priceslog');
                Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('dashboard.products.edit');
                Route::get('/{id}/update_active_variation', [ProductController::class, 'update_active_variation'])->name('dashboard.products.update_active_variation');
                Route::get('/{id}/edit_variations', [ProductController::class, 'edit_variations'])->name('dashboard.products.edit_variations');
                Route::get('/{id}/edit_attributes', [ProductController::class, 'edit_attributes'])->name('dashboard.products.edit_attributes');
                Route::get('/get_attributes_val', [ProductController::class, 'get_attributes_val'])->name('dashboard.products.get_attributes_val');
                Route::get('/get_variations', [ProductController::class, 'get_variations'])->name('dashboard.products.get_variations');
                Route::get('/{id}/review', [ProductController::class, 'productReview'])->name('dashboard.products.review');
                // post url "/dashboard/products/id/update"
                Route::post('/{id}/update', [ProductController::class, 'update'])->name('dashboard.products.update');
                Route::post('/{id}/destroy', [ProductController::class, 'destroy'])->name('dashboard.products.destroy');
                Route::get('/Add', [ProductController::class, 'add_index'])->name('dashboard.products.Add');

                Route::get('/{product}/attributes', [ProductController::class, 'getAttributes'])->name('dashboard.products.attributes');
                Route::post('/{product}/destroyAttribute', [ProductController::class, 'destroyAttribute'])->name('dashboard.products.attributes.destroyAttribute');
                Route::post('/{product}/storeAttribute', [ProductController::class, 'storeAttribute'])->name('dashboard.products.attributes.storeAttribute');
                Route::post('/{product}/updateAttribute', [ProductController::class, 'updateAttribute'])->name('dashboard.products.attributes.updateAttribute');

                ////////////////Images Routes///////////////////////

                Route::get('/{product}/images/{image}/getImages_sub', [ProductController::class, 'getImages_sub'])->name('dashboard.products.images.getImages_sub');
                Route::get('/{product}/images', [ProductController::class, 'getImages'])->name('dashboard.products.images.getImages');
                Route::post('/{image}/destroyImage', [ProductController::class, 'destroyImage'])->name('dashboard.products.images.destroyImage');
                Route::post('/{product}/images/{image}/storeImage', [ProductController::class, 'storeImage'])->name('dashboard.products.images.storeImage');
                Route::post('/{product}/storeImage2', [ProductController::class, 'storeImage2'])->name('dashboard.products.images.storeImage2');

                ///////////////orders routes///////////////////

                // Route::get('{product}/orders',[ProductController::class, 'getOrders'])->name('dashboard.products.orders.getOrders');
                // Route::get('{product}/orders/dataTable',[ProductController::class, 'getDataTableOfProductOrders'])->name('dashboard.products.orders.dataTable');

            });

            Route::prefix('sliders')->group(function () {

                Route::get('/', [SliderController::class, 'index'])->name('dashboard.slider.index');
                Route::post('/', [SliderController::class, 'store'])->name('dashboard.slider.store');

                Route::get('/edit{id}', [SliderController::class, 'edit'])->name('dashboard.slider.edit');
                Route::post('/update', [SliderController::class, 'update'])->name('dashboard.slider.update');
                Route::get('/delete{id}', [SliderController::class, 'delete'])->name('dashboard.slider.delete');

                //get url "/dashboard/slider/dataTable"
                Route::get('sliderdataTable', [SliderController::class, 'getDataTableOfslider'])->name('dashboard.slider.dataTable');
            });


            //cars
            Route::prefix('cars')->group(function () {
                // get url "/dashboard/products"

                Route::get('/manufacturer', [CarController::class, 'index'])->name('dashboard.manufacturer.index');
                Route::post('/manufacturer', [CarController::class, 'store'])->name('dashboard.manufacturer.store');

                Route::get('/manufacturer/edit{id}', [CarController::class, 'edit'])->name('dashboard.manufacturer.edit');
                Route::post('/manufacturer/update', [CarController::class, 'update'])->name('dashboard.manufacturer.update');

                //get url "/dashboard/manufacturer/dataTable"
                Route::get('manufacturerdataTable', [CarController::class, 'getDataTableOfmanufacturer'])->name('dashboard.manufacturer.dataTable');


                Route::get('/model', [CarController::class, 'index_model'])->name('dashboard.model.index');
                Route::post('/model', [CarController::class, 'store_model'])->name('dashboard.model.store');

                Route::post('/model_color', [CarController::class, 'store_model_color'])->name('dashboard.model_color.store');

                Route::get('/model/edit{id}', [CarController::class, 'edit_model'])->name('dashboard.model.edit');
                Route::post('/model/update', [CarController::class, 'update_model'])->name('dashboard.model.update');

                //get url "/dashboard/model/dataTable"
                Route::get('modeldataTable', [CarController::class, 'getDataTableOfmodel'])->name('dashboard.model.dataTable');

                Route::get('/color', [CarController::class, 'index_color'])->name('dashboard.color.index');
                Route::post('/color', [CarController::class, 'store_color'])->name('dashboard.color.store');

                Route::get('/color/edit{id}', [CarController::class, 'edit_color'])->name('dashboard.color.edit');
                Route::get('/color/delete{id}', [CarController::class, 'delete_color'])->name('dashboard.color.delete');
                Route::post('/color/update', [CarController::class, 'update_color'])->name('dashboard.color.update');

                //get url "/dashboard/color/dataTable"
                Route::get('colordataTable', [CarController::class, 'getDataTableOfcolor'])->name('dashboard.color.dataTable');


                Route::get('/city', [CityController::class, 'index'])->name('dashboard.city.index');
                Route::post('/city', [CityController::class, 'store'])->name('dashboard.city.store');

                Route::get('/city/edit{id}', [CityController::class, 'edit'])->name('dashboard.city.edit');
                Route::get('/city/delete{id}', [CityController::class, 'delete'])->name('dashboard.city.delete');
                Route::post('/city/update', [CityController::class, 'update'])->name('dashboard.city.update');

                //get url "/dashboard/city/dataTable"
                Route::get('citydataTable', [CityController::class, 'getDataTableOfcity'])->name('dashboard.city.dataTable');
            });


            //users
            Route::prefix('users')->group(function () {
                Route::get('/edit{user}', [UserController::class, 'edit'])->name('dashboard.users.edit');
                Route::post('/update_user2', [UserController::class, 'update_user2'])->name('dashboard.update_user2');
                Route::get('/', [UserController::class, 'index'])->name('dashboard.users.index');
                Route::get('/{type}', [UserController::class, 'index_user'])->name('dashboard.users.users');
                Route::post('/{user}/update', [UserController::class, 'update'])->name('dashboard.users.update');
                Route::post('/store', [UserController::class, 'store'])->name('dashboard.users.store');
            });


            Route::prefix('orders')->group(function () {
                Route::get('/', [OrderController::class, 'index'])->name('dashboard.orders.index');
                Route::get('/dataTable/{client_id?}', [OrderController::class, 'getDataTableOfOrders'])->name('dashboard.orders.dataTable');
                Route::post('/updateStatus', [OrderController::class, 'updateStatus'])->name('dashboard.orders.updateStatus');
                Route::get('/show/{order_id}', [OrderController::class, 'show'])->name('dashboard.orders.show');
                Route::get('/getInvoice', [OrderController::class, 'getInvoice'])->name('dashboard.orders.getInvoice');
                Route::post('/driver', [OrderController::class, 'select_driver'])->name('dashboard.orders.driver');
                Route::get('/driver_location_api/{order_id}', [OrderController::class, 'get_driver_location_api'])->name('dashboard.orders.driver.location.api');
            });







            // get url "/dashboard/drivers"
            Route::prefix('drivers')->group(function () {
                Route::get('/', [DriverController::class, 'index'])->name('dashboard.drivers.index');

                Route::get('dataTable/{driver_id?}', [DriverController::class, 'getDataTableOfdrivers'])->name('dashboard.drivers.dataTable');

                Route::post('/{id}/destroy', [DriverController::class, 'destroy'])->name('dashboard.drivers.destroy');
                Route::get('/dataTable/driver_orders/{driver_id?}', [DriverController::class, 'getDataTableOfOrders'])->name('dashboard.drivers.orders.dataTable');
                /* //post url "dashboard/drivers/driver_id/update
            Route::post('/{id}/update', [DriverController::class, 'update'])->name('dashboard.drivers.update');
            //post url "dashboard/drivers/driver_id/edit
            Route::get('/{id}/edit', [DriverController::class, 'edit'])->name('dashboard.drivers.edit');
            //post url "dashboard/drivers/driver_id/restore
            Route::post('/{id}/restore', [DriverController::class, 'restore'])->name('dashboard.drivers.restore');
            Route::post('/{id}/forceDestroy', [DriverController::class, 'forceDestroy'])->name('dashboard.drivers.forceDestroy');
            */
                Route::get('/{driver}/getdriverOrders', [DriverController::class, 'getdriverOrders'])->name('dashboard.drivers.getdriverOrders');
            });
        });

        Route::prefix('/')->middleware(['isUser'])->group(function () {
            Route::prefix('tyre')->group(function () {
                Route::get('/', [WebsiteController::class, 'tyre'])->name('website.tyre');
                Route::get('/getAllCars', [TyreController::class, 'getAllCars'])->name('website.get.all.cars');
                Route::get('/getAllColors', [TyreController::class, 'getAllColors'])->name('website.get.all.colors');
                Route::get('/sub_category', [TyreController::class, 'sub_category'])->name('website.sub_category');
                Route::get('/sub_category1', [BatteryChangeController::class, 'sub_category'])->name('website.sub_category1');
            });
            Route::prefix('addresses')->group(function () {
                Route::get('/addmyaddress', [WebsiteController::class, 'addmyaddress'])->name('website.addmyaddress');

                Route::get('/addAddress', [WebsiteController::class, 'addresses'])->name('website.addresses');
                Route::get('/', [WebsiteController::class, 'addressesTwo'])->name('website.addresses.two');
                Route::get('/get_address', [WebsiteController::class, 'get_address'])->name('website.addresses.get');
                Route::post('/create', [AddressController::class, 'create'])->name('website.addresses.create');

                Route::post('/create_myAdress', [AddressController::class, 'create_myAdress'])->name('website.addresses.create_myAdress');
                Route::post('/delete', [AddressController::class, 'delete'])->name('website.addresses.delete');
                Route::post('/deleteMyAddress', [AddressController::class, 'deleteMyAddress'])->name('website.addresses.deleteMyAddress');

                Route::get('/editmyAddress/{id}', [AddressController::class, 'editmyAddress'])->name('website.addresses.editmyAddress');
                Route::get('/edit/{id}', [AddressController::class, 'edit'])->name('website.addresses.edit');

                Route::post('/updateMyaddress', [AddressController::class, 'updateMyaddress'])->name('website.addresses.updateMyaddress');

                Route::post('/update', [AddressController::class, 'update'])->name('website.addresses.update');
            });

            Route::get('/add/{id}', [WebsiteController::class, 'add'])->name('website.add');
            Route::post('/storeaddPage', [WebsiteController::class, 'storeaddPage'])->name('website.storeaddPage');
            Route::post('/storeProductInSession', [TyreController::class, 'storeProductInSession'])->name('website.storeProductInSession');
            Route::post('/storeAddressTimeInSession', [TyreController::class, 'storeAddressTimeInSession'])->name('website.storeAddressTimeInSession');
            Route::post('/storeCarInSession', [WebsiteController::class, 'storeVichle'])->name('website.storeCarInSession');
            Route::get('/addNext', [WebsiteController::class, 'addone'])->name('website.add.next');
            Route::get('/two', [WebsiteController::class, 'two'])->name('website.two');
            Route::get('/yes', [WebsiteController::class, 'yes'])->name('website.yes');
            Route::get('/myvehicles', [WebsiteController::class, 'myvehicles'])->name('website.myvehicles');
            Route::get('/myAddress', [WebsiteController::class, 'myAddress'])->name('website.myAddress');

            Route::get('/addresses', [WebsiteController::class, 'addresses'])->name('website.addresses');
            Route::get('/addressesNext', [WebsiteController::class, 'addressesTwo'])->name('website.addresses.two');
            Route::get('/orderSummary', [WebsiteController::class, 'orderSummary'])->name('website.orderSummary');
            Route::get('/no', [WebsiteController::class, 'no'])->name('website.no');
            Route::get('/carWash', [WebsiteController::class, 'carWash'])->name('website.carWash');

            Route::get('/cahnge', [WebsiteController::class, 'change'])->name('website.change');
            Route::get('/cahngeNext', [WebsiteController::class, 'changeTwo'])->name('website.change.two');
            Route::get('/checkCopon', [WebsiteController::class, 'checkCopon'])->name('website.checkCopon');
            Route::post('/storeCouponInSession', [WebsiteController::class, 'storeCouponInSession'])->name('website.storeCouponInSession');
            Route::get('/payment', [WebsiteController::class, 'payment'])->name('website.payment');

            Route::prefix('how')->group(function () {
                Route::get('/', [WebsiteController::class, 'how'])->name('website.how');
                Route::get('/Next', [WebsiteController::class, 'how_2'])->name('website.how2');
                Route::get('/Final', [WebsiteController::class, 'how_3'])->name('website.how3');
            });
            Route::prefix('orders')->group(function () {
                Route::get('/', [OrdersController::class, 'index'])->name('website.orders.index');
                Route::get('/getAllOrders', [OrdersController::class, 'getAllOrders'])->name('website.orders.all');
                Route::get('/orderDetails/{id}', [OrdersController::class, 'orderDetails'])->name('website.orders.details');
                Route::get('/payment_history', [OrdersController::class, 'getOrderPaymentHistory'])->name('website.orders.payment.history');
                Route::post('/add', [OrdersController::class, 'add2'])->name('website.orders.add');
                Route::post('/addOrderWithcredit', [OrdersController::class, 'addOrderWithcredit'])->name('website.orders.addOrderWithcredit');
                Route::get('/payment_status', [OrdersController::class, 'payment_status'])->name('website.orders.payment_status');



                Route::post('/coupons/apply', [OrdersController::class, 'applyCoupon'])->name('website.orders.coupon.apply');
            });
        });

        Route::prefix('/')->group(function () {
            //Route::get('/order', function () {return view('website.order');});
            Route::get('stripe', [StripeController::class, 'handleGet']);
            Route::post('stripe', [StripeController::class, 'handlePost'])->name('stripe.payment');
            Route::post('handleOrdersCash', [StripeController::class, 'handleOrdersCash'])->name('handleOrdersCash');
            Route::post('handleOrdersCard', [StripeController::class, 'handleOrdersCard'])->name('handleOrdersCard');
            Route::post('/edit_to_login', [OrdersController::class, 'edit_to_login'])->name('website.edit_to_login');
            Route::get('/order', [OrdersController::class, 'User_orders'])->name('website.order');
            Route::get('/', [WebsiteController::class, 'index'])->name('website.index');


            Route::get('/Img_sub', [WebsiteController::class, 'subImg'])->name('Img_sub');
            Route::post('/customer_review', [WebsiteController::class, 'customerReviews'])->name('customer.review');

            Route::post('/rating', [ratingController::class, 'rating'])->name('rating');

            Route::prefix('shop')->group(function () {
                Route::get('/all', [WebsiteController::class, 'all_products'])->name('website.shop');
                Route::get('/{id}', [WebsiteController::class, 'store'])->name('website.shop.categories');
                Route::get('all/{type}/{cat}/{price}', [WebsiteController::class, 'all_products2'])->name('website.all_shop');
                // Route::get('/all/{{cat}}', [WebsiteController::class, 'filter_fun2'])->name('filter_fun');
            });
            //Route::get('/filter_fun', [WebsiteController::class, 'filter_fun'])->name('filter_fun');
            Route::get('/combination_products', [WebsiteController::class, 'combination_products'])->name('combination_products');

            // Route::get('/profile', [ProfileController::class, 'index'])->name('website.profile');
            // Route::get('/edit_order/{id}', [ProfileController::class, 'editOrder'])->name('website.order.edit');
            // Route::get('/delete_order/{id}', [ProfileController::class, 'deleteFromOrder'])->name('website.order.delete');
            // Route::post('/profile/update', [ProfileController::class, 'updateInfo'])->name('website.profile.update');



            Route::get('product', [WebsiteController::class, 'productDetails'])->name('website.product');
            Route::get('special-product', [WebsiteController::class, 'specialProductDetails'])->name('website.special.product');
            Route::get('categoriers_menue', [WebsiteController::class, 'categoriers_menue'])->name('website.categoriers_menue');
            Route::get('productDetails_conbination', [WebsiteController::class, 'productDetails_conbination'])->name('productDetails_conbination');
            Route::get('categoriers_sub_menue', [WebsiteController::class, 'categoriers_sub_menue'])->name('website.categoriers_sub_menue');


        // Route::get('terms', function () {
        //     return view('website.terms');
        // })->name('website.terms');

            Route::get('bill', function () {
                return view('website.bill-summary');
            })->name('bill');

            Route::get('checkout', [OrdersController::class, 'index'])->name('website.checkout');
            Route::get('hyperpay', [OrdersController::class, 'hps'])->name('hyperpay');
            Route::get('hyperpay1', [OrdersController::class, 'ch'])->name('hyperpay1');

            Route::get('w-register', function () {
                return view('website.register');
            });
            Route::get('hf', function () {
                return view('website.hf');
            })->name('payPage');
            Route::get('ps', [OrdersController::class, 'ps'])->name('ps');
            Route::get('footer', function () {
                return view('website.footer');
            })->name('website.footer');


            Route::get('contact', function () {
                return view('website.contact');
            })->name('website.contact');



            Route::get('about', function () {
                return view('website.about');
            })->name('website.about');


            Route::get('terms', function () {
                return view('website.terms');
            })->name('website.terms');

            Route::get('policy', function () {
                return view('website.policy');
            })->name('website.policy');


            Route::get('bill-summary', function () {
                return view('website.bill-summary');
            })->name('website.summary');


        Route::post('storeInDashboard', [CartController::class, 'storeInDashboard'])->name('storeInDashboard');
        Route::post('add-to-card', [CartController::class, 'store'])->name('add.to.card');
        Route::get('add-to-card2', [CartController::class, 'store2'])->name('add.to.card2');
        Route::get('check_user', [CartController::class, 'check_user'])->name('check_user');
        Route::post('destroy-card', [CartController::class, 'destroy'])->name('destroy.card');
        Route::get('view-cart-website', [CartController::class, 'index'])->name('view.cart.website');
        Route::get('update_quantity', [CartController::class, 'update_quantity'])->name('update.quantity');
        Route::post('add-new-review', [Productscontroller::class, 'addReview'])->name('website.new.review');
        Route::post('remove-from-card', [Productscontroller::class, 'removeFromCard'])->name('remove.from.card');
        Route::post('add-to-favorite', [Productscontroller::class, 'addToFavorite'])->name('add.to.favorite');
        Route::post('add-new-order', [OrdersController::class, 'bOrder'])->name('add.new.order');
        Route::post('coupon-applay', [OrdersController::class, 'couponApplay'])->name('coupon.apply');
        Route::get('cancel-order', [OrdersController::class, 'status_cancel'])->name('cancel.order');

        Route::get('get-card-content', [Productscontroller::class, 'getBasketContent'])->name('get.basket.content');
        Route::get('autocomplete', [Productscontroller::class, 'autocomplete'])->name('autocomplete');
        Route::get('change-quantity', [Productscontroller::class, 'changeQuantity'])->name('change.quantity');
        Route::get('fv', function () {
            return view('ajax.form');
        });
        // search operation
        //Route::post('search', [SearchController::class, 'search'])->name('website.search');
        //Route::get('orders/{order}/invoice',[InvoiceController::class,'index'])->name('website.orders.invoice');
        //Route::get('/mobile/orders/{order}/{checkoutId}/{type}',[PayController::class,'index'])->name('mobile.pay.index');
        //Route::get('/mobile/orders/{order}/payment_status',[PayController::class,'paymentstatus'])->name('mobile.pay.status');


        });
        Route::prefix('accounting')->middleware(['auth', 'isAccounting'])->group(function () {
            Route::get('/', function () {
                return view('accounting.statistics');
            });
        });
        Route::prefix('delivery')->middleware(['auth', 'isDelivery'])->group(function () {
            Route::get('/', function () {
                return view('delivery.statistics');
            });
        });
        Route::prefix('ecommerce')->middleware(['auth', 'isEcommerce'])->group(function () {
            Route::get('/', function () {
                return view('ecommerce.statistics');
            });
        });
    });
Route::get('/gal', function () {
    return view('website.gal');
});






Route::get('/logins', function () {
    return view('website.login');
});


Route::get('/empty-bag', function () {
    return view('website.empty-bag');
});
/////////////////// Dashboard Routes //////////////////

Route::get('/edit-client', function () {
    return view('dashboard.edit-client');
});

Route::get('/reports', function () {
    return view('dashboard.reports');
});

///////////////
Route::post('/image_upload', [upload::class, 'imgUpload']);
Auth::routes();
Route::get('/bag', [CartController::class, 'bag'])->name('bag');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
