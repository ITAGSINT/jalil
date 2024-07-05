<?php

use App\Events\TestEvent;
use App\Http\Controllers\Api\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mobile\mobile_products_controller;
use App\Http\Controllers\mobile\mobile_users;

use App\Http\Controllers\mobile\mobile_favorite_products;
use App\Http\Controllers\mobile\OrderController;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\ProductController2;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\StripeController;
use App\Http\Middleware\LanguageChange;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/map', function (Request $request) {

    $lat = $request->lat;
    $long = $request->long;
    $location = ['lat' => $lat, 'long' => $long];
    $order = 1;
    event(new TestEvent($order, $location));
    return response()->json(['status' => true, 'data' => [$location, $order]]);
});




Route::get('/products/sub_category', [App\Http\Controllers\Api\CategoryController::class, 'sub_category'])->name('api.category.sub_category');
Route::get('/products/details', [App\Http\Controllers\Api\CategoryController::class, 'pro_details'])->name('api.category.pro_details');
Route::get('/products/main_categories', [App\Http\Controllers\Api\CategoryController::class, 'index'])->name('api.category.index');
Route::get('/products/product_manufacturer', [App\Http\Controllers\Api\CategoryController::class, 'product_manufacturer'])->name('api.product.manufacturer');

Route::put('update-fcm-token', [\App\Http\Controllers\Api\FcmController::class, 'update'])->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'create']);
Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/resendCode', [AuthController::class, 'resendCode']);
Route::post('/loginDriver', [AuthController::class, 'loginDriver']);
Route::post('/loginDataEntry', [AuthController::class, 'loginDataEntry']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::post('/edit_user', [AuthController::class, 'edit']);
Route::post('/user_info', [AuthController::class, 'user_info']);
Route::get('/main_info', [AuthController::class, 'main_info']);
Route::get('/images', [AuthController::class, 'images']);
Route::post('/edit_user_avatar', [AuthController::class, 'edit_avatar']);

Route::get('/getAllCarMan', [CarController::class, 'getAllCarMan'])->name('api.car.manufacture');
Route::get('/getAllManModel', [CarController::class, 'getAllManModel'])->name('api.car.model');
Route::get('/getAllColors', [CarController::class, 'getAllColors'])->name('api.car.colors');
Route::get('/getModelColorImage', [CarController::class, 'getModelColorImage'])->name('api.car.modelColors');

Route::get('/getAllCities', [CarController::class, 'getAllCity'])->name('api.car.city');


Route::prefix('/car')
    ->controller(CarController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/add',  'add')->name('api.car.add');
        Route::post('/edit',  'edit')->name('api.car.edit');
        Route::post('/delete', 'delete');
        Route::get('/get_all', 'getAllCars');
        Route::get('/getById', 'getCarById');
    });


Route::prefix('/address')
    ->controller(AddressController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/add', 'create');
        Route::post('/edit', 'edit');
        Route::post('/delete', 'delete');
        Route::get('/get_all', 'get_address');
        Route::get('/getById', 'get_address_ById');
    });





Route::prefix('/orders')
    ->controller(ApiOrderController::class)
    // ->middleware('auth:sanctum')
    ->group(function () {
        Route::post('/add', 'add')->middleware('auth:sanctum');
        Route::post('/add2', 'add2')->name('mobile.orders.add');
        Route::post('/coupons/apply', 'applyCoupon')->name('mobile.orders.coupon.apply');
        Route::get('/getAllOrders', 'getAllOrders')->name('mobile.orders.getAllOrders');
        Route::get('/getOrderById', 'getOrderById')->name('mobile.orders.getOrderById');

        //   Route::post('/status/accept',[DriverController::class,'status_accept'])->name('mobile.drivers.status.accept');

        Route::post('/status/cancel', 'status_cancel')->name('mobile.orders.status.cancel');

        // Route::post('/status/change',[DriverController::class,'status_changed'])->name('mobile.drivers.status.change');

        Route::get('/status/get_status', 'status_get')->name('mobile.orders.status.get');

        //   Route::post('/location/set',[DriverController::class,'location_set'])->name('mobile.drivers.location.set');

        // Route::post('/status/undelivered',[DriverController::class,'status_undelivered'])->name('mobile.drivers.status.undelivered');
        //  Route::post('/status/unreachable',[DriverController::class,'status_unreachable'])->name('mobile.drivers.status.unreachable');
    });



Route::prefix('/payments')
    ->controller(PaymentController::class)
    // ->middleware('auth:sanctum')
    ->group(function () {
        // Route::post('/add', 'add')->middleware('auth:sanctum');

        Route::get('/getAllPayments', 'getAllPayments')->name('mobile.payments.getAllPayments');
        Route::get('/getPaymentById', 'getPaymentById')->name('mobile.payments.getPaymentById');
    });

Route::prefix('/drivers')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/get_all', [DriverController::class, 'get_all'])->name('mobile.drivers.get_all');
        Route::get('/index', [DriverController::class, 'index'])->name('mobile.drivers.index');
        Route::get('/show', [DriverController::class, 'show'])->name('mobile.drivers.show');

        Route::post('/status/accept', [DriverController::class, 'status_accept'])->name('mobile.drivers.status.accept');

        Route::post('/status/reject', [DriverController::class, 'status_reject'])->name('mobile.drivers.status.reject');

        Route::post('/status/change', [DriverController::class, 'status_changed'])->name('mobile.drivers.status.change');
        Route::post('/toogleActive', [DriverController::class, 'toggleActive'])->name('mobile.drivers.toggleActive');

        Route::get('/status/get_status', [DriverController::class, 'status_get'])->name('mobile.drivers.status.get');

        Route::post('/location/set', [DriverController::class, 'location_set'])->name('mobile.drivers.location.set');

        // Route::post('/status/undelivered',[DriverController::class,'status_undelivered'])->name('mobile.drivers.status.undelivered');
        //  Route::post('/status/unreachable',[DriverController::class,'status_unreachable'])->name('mobile.drivers.status.unreachable');
    });









Route::middleware('auth:sanctum')->group(function () {
    Route::get('/conversations', [ChatController::class, 'getConversations']);
    Route::get('/conversations/{user}', [ChatController::class, 'getMessages']);
    Route::post('/conversations/{user}/message', [ChatController::class, 'sendMessage']);
    Route::patch('/conversations/{user}/read', [ChatController::class, 'markAsRead']);
});
