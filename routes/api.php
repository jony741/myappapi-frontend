<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/db-test', function() {
    if(DB::connection()->getDatabaseName())
    {
       echo "conncted sucessfully to database ".DB::connection()->getDatabaseName();
    }
 });

// Route::get('articles', 'ArticleController@index');
// Route::get('articles/{article}', 'ArticleController@show');
// Route::post('articles', 'ArticleController@store');
// Route::put('articles/{article}', 'ArticleController@update');
// Route::delete('articles/{article}', 'ArticleController@delete');

Route::get('featured_main', 'FeaturedMainController@index');
Route::get('featured/{type}', 'FeaturedInPlanningEvents@index');
Route::get('occasions', 'OccasionController@index');
Route::get('av', 'ProvidersAvailabilityController@index');
Route::get('categories', 'CategoriesController@index');
Route::get('provider/{id}', 'ProviderController@providerByID');
Route::post('cat_provider_count', 'CatProviderCountController@index');
Route::post('providers_by_occ_and_time', 'ProvidersByOccAndTime@index');
Route::post('providers_by_occ_and_time_cat', 'ProvidersByOccAndTimeCat@index');
Route::post('venues_count_and_planners', 'VenuesCountAndPlanners@index');
Route::get('providers', 'ProviderController@index');

Route::get('providers_by_cat/{catID}', 'ProvidersByCatController@index');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('resend_email', 'AuthController@resendEmail');
    Route::post('find_or_create', 'AuthController@findOrCreate');
    Route::post('login_with', 'AuthController@loginWith');
    Route::get('signup/activate/{token}', 'AuthController@signupActivate');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        // Route::post('provider_add', 'ProviderController@addProvider');
    });
});

Route::group([    
    'namespace' => 'Auth',    
    'middleware' => 'api',    
    'prefix' => 'password'
], function () {    
    Route::post('create', 'ResetPasswordController@create');
    Route::get('find/{token}', 'ResetPasswordController@find');
    Route::post('reset', 'ResetPasswordController@reset')->name('coco');
});

// Route::get('/email_ver', function () {
//     return view('email_verfication_result', ['name' => 'James']);
// });

Route::get('/email_ver', function () {
    return view('email_verfication_result');
});


// Route::prefix('order')->name('order.')->group(function () {
//     Route::get('/', 'OrderController@index')->name('index');
// //        Route::post('/', 'OrderController@store')->name('store');
// //
//     Route::prefix('{id}')->group(function () {
//         Route::put('/', 'OrderController@update')->name('update');
// //            Route::delete('/', 'OrderController@destroy')->name('destroy');
//     });
// });

// Route::prefix('service')->name('service.')->group(function () {
//     Route::get('/', 'ServiceController@index')->name('index');
//     Route::post('/', 'ServiceController@store')->name('store');

//     Route::prefix('{id}')->group(function () {
//         Route::put('/', 'ServiceController@update')->name('update');
//         Route::delete('/', 'ServiceController@destroy')->name('destroy');
//     });
// });

Route::group([
    'middleware' => 'auth:api'
  ], function() {
      Route::post('provider_add', 'ProviderController@addProvider');
      Route::post('provider_edit', 'ProviderController@editProvider');
      Route::get('order', 'OrderController@index');
      Route::put('order/{id}', 'OrderController@update');
      Route::get('service', 'ServiceController@index');
      Route::post('service', 'ServiceController@store');
      Route::delete('service/{id}', 'ServiceController@destroy');
      Route::put('service/{id}', 'ServiceController@update');
      Route::get('service_options/{service_id}', 'ServiceOptionsController@index');
      Route::post('service_options/{service_id}', 'ServiceOptionsController@store');
      Route::put('service_options/{service_id}/{id}', 'ServiceOptionsController@update');
      Route::delete('service_options/{service_id}/{id}', 'ServiceOptionsController@destroy');
  });


// Route::get('/reset_pass', function () {
//     return view('reset_password');
// });

// Route::get('reset_pass', 'ResetPasswordController@index');