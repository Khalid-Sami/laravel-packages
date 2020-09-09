<?php

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

Route::get('/', function () {
    return view('welcome');
});

/* ِAuth Routes */
Auth::routes();

/* All routes about Stripe API */
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['namespace' => 'Stripe','middleware' => 'auth'], function () {
    Route::get('/plans', 'PlanController@index')->name('plans.index');
    Route::get('/plan/{plan}', 'PlanController@show')->name('plans.show');
    Route::get('/subscription/{slug}', 'SubscriptionController@create')->name('subscription.create');
    Route::get('/subscription/trial/{slug}', 'SubscriptionController@createWithTrial')->name('subscription.create.trial');
    Route::get('/update-payment-method', 'UpdatePaymentMethod@index');
//    Route::get('/createCustomer', 'UpdatePaymentMethod@createCustomer')->name('createCustomer');
    Route::post('/update-payment-method', 'UpdatePaymentMethod@updatePaymentMethod')->name('updatePaymentMethod');
    Route::get('/payment-method/retrieve', 'PaymentMethodActions@retrieve');
    Route::get('/payment-method/default','PaymentMethodActions@default');
    Route::get('/payment-method/has', 'PaymentMethodActions@has');
//    Route::get('/plan-create', 'PlanController@create');
//    Route::get('/plan-update', 'PlanController@update');
    Route::get('/user/has-subscribed', 'PaymentMethodActions@booleanOptions');
    Route::get('/user/trial-subscription', 'PaymentMethodActions@booleanOptions');
    Route::get('/user/plan-subscribed', 'PaymentMethodActions@booleanOptions');
    Route::get('/user/subscribed-recurring', 'PaymentMethodActions@booleanOptions');
    Route::get('/user/subscription-cancelled', 'PaymentMethodActions@booleanOptions');
    Route::get('/user/subscription-grace-period', 'PaymentMethodActions@booleanOptions');
    Route::get('/user/subscription-ended-period', 'PaymentMethodActions@booleanOptions');
    Route::get('/user/has-incomplete-payment', 'PaymentMethodActions@booleanOptions');
    Route::get('/plan-change', 'PlanController@changeRoutePage');
    Route::get('/plan/change/{plan}', 'PlanController@change')->name('plan.change');
    Route::get('/plan/change-with-invoice/{plan}', 'PlanController@changeWithInvoice')->name('plan.change.invoice');
    Route::get('/user/subscription-increment', 'SubscriptionController@increment');
    Route::get('/user/subscription-decrement', 'SubscriptionController@decrement');
    Route::get('/user/subscription/sync-tax', 'SubscriptionController@syncTax');
    Route::get('/user/subscription/cancel', 'SubscriptionController@cancel');
    Route::get('/user/subscription/cancel-now', 'SubscriptionController@cancelNow');
    Route::get('/user/subscription/resume', 'SubscriptionController@resume');


    Route::get('/products', 'ProductController@index')->name('products');
    Route::post('/pay/{product}','ChargeController@pay')->name('pay');

    Route::get('/invoices', 'InvoiceController@invoices')->name('invoices');
    Route::get('/user/invoice/{invoice_id}', 'InvoiceController@invoice')->name('invoice');

});

Route::get('/user-check',function (){
    return 'checked ..!';
})->middleware('check.user','auth');

Route::post(
    'stripe/webhook',
    '\App\Http\Controllers\WebhookController@handleWebhook'
);


/* Container Biding */

Route::get('/payment-method',function (){
   return app()->make('payment')->process();
});

Route::get('/payment-tagged', function (){
    return app()->make('payment-tagged')->process();
});

Route::get('/payment-check', function (){
    return app()->make('Paypal')->check();
});

Route::get('/payment-operation', function (){
    return app()->makeWith('payment-operation', ['value' => 'master-card'])->process();
});

Route::get('/search/{search}', function ($search){
    return $search;
})->where('search', '[A-Za-z]+');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'],function (){
    Route::get('/users','UsersController@index')->name('users');
    Route::get('/news','NewsController@index')->name('news');
    Route::get('/url-user-name', function (){
        return redirect()->route('admin.users');
    });
});

/* Test Controllers section */

Route::group(['namespace' => 'ControllerTest', 'middleware' => ['auth']], function (){
    Route::get('/profile/{user}','Profile');
    Route::get('/user/followers', 'Follows@followers');
    Route::get('/user/following', 'Follows@following');
});

Route::group(['namespace' => 'Resources', 'middleware' => ['auth']], function (){
   Route::resource('bio','BioController');
   Route::resource('posts','PostController');
});

Route::get('/get-path','RequestController@getPath');
Route::get('/path/get-path','RequestController@isPath');
Route::get('/get-url','RequestController@getURL');
