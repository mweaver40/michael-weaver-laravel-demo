<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');


Route::get('/test/{dog}', function($dog) {
    echo ("woof") . $dog . "\n";
});
 

Route::get('users', function()
{
   return View::make('users');
});

/* This is fairly infelxible routing. May ned to rethink 
 * adding  a special route here like 
 * Route::get('{any}/{args}', function($action, $args = null)
 * {
 *  // do something like return print_r(explode('/', $args), true);
 * })->where('args', '(.*)');
 * Which would be a custom dispatcher. Would alos need to rethink how the 
 * entire tree structure of categories is handled in DB. Slows things 
 * dwon  lot in a relational databse if we can have arbitrary n elements in
 * a lookup tree
 */ 
Route::get('scuba/{categoryName?}', [
    'as' => 'catalogPage', 'uses' => 'Store\CatalogController@getCatalogPage',
]);

Route::post('scuba/cart/add', [
    'as' => 'addToCart', 'uses' => 'Store\CartController@addItem',
]);

Route::get('scuba/cart/remove/{itemId}', [
    'as' => 'removeFromCart', 'uses' => 'Store\CartController@removeItem',
]);

Route::get('scuba/cart/get', [
    'as' => 'getCart', 'uses' => 'Store\CartController@getCart',
]);

Route::post('scuba/cart/update', [
    'as' => 'updateCart', 'uses' => 'Store\CartController@updateCart',
]);

Route::post('scuba/checkout/shippingAddress', [
    'as' => 'orderShippingAddress', 'uses' => 'Store\CartController@updateShippingAddress',
]);


Route::post('scuba/checkout/billingAddress', [
    'as' => 'orderBillingAddress', 'uses' => 'Store\CartController@updateBillingAddress',
]);

Route::post('scuba/checkout/submitOrder', [
    'as' => 'submitOrder', 'uses' => 'Store\CartController@submitOrder',
]);

/*
 * Route::post('scuba/cart/checkout', 
    ['middleware' => 'auth', 
        'https',
        'as' => 'checkout',
        'uses' => 'Store\CartController@checkout',
]);
 */
Route::get('scuba/cart/checkout', 
    [
        'middleware' => 'auth',
        'https',
        'as' => 'checkout',
        'uses' => 'Store\CartController@checkout',
]);

Route::get('scuba/{categoryName}/{productName}', [
    'as' => 'productInfo', 'uses' => 'Store\CatalogController@getProductInfo',
]);



Route::get(
    'auth/register', array(
        'as'   => 'getRegister',
        'https',
        'uses' => 'Auth\AuthController@getRegister',
    )
);

Route::get(
    'auth/login', array(
        'as'   => 'getLogin',
        'https',
        'uses' => 'Auth\AuthController@getLogin',
    )
);

Route::post(
    'auth/register', array(
        'as'   => 'register',
        'https',
        'uses' => 'Auth\AuthController@postRegister',
    )
);

Route::post(
    'auth/login', array(
        'as'   => 'login',
        'https',
        'uses' => 'Auth\AuthController@postLogin',
    )
);

Route::get(
    'auth/logout', array(
        'as'   => 'logout',
        'uses' => 'Auth\AuthController@getLogout',
    )
);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

