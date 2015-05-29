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

Route::get('scuba/{categoryName}/{productName}', [
    'as' => 'productInfo', 'uses' => 'Store\CatalogController@getProductInfo',
]);

Route::post('scuba/cart/add', [
    'as' => 'addToCart', 'uses' => 'Store\CartController@addItem',
]);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
        'store' => 'Store\StoreController',
        'storecatalog' => 'Store\Catalog\CatalogController', 
]);
