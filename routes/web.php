<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::group([
    'middleware' => ['auth:sanctum', 'verified'], 
    'prefix' => 'users'
    ], 
    function ($router) {

        $router->get('/get/{id?}', 'App\Http\Controllers\UsersController@get');
        $router->post('/post', 'App\Http\Controllers\UsersController@post');
        $router->put('/update/{id?}', 'App\Http\Controllers\UsersController@update');
        $router->delete('/delete/{id?}', 'App\Http\Controllers\UsersController@destroy');
        
        $router->get('/', function () {
            return 'Nada pra ver ^^"';
        });

});

Route::group([
    'middleware' => ['auth:sanctum', 'verified'], 
    'prefix' => 'customers'
    ], 
    function ($router) {

        $router->get('/get/{id?}', 'App\Http\Controllers\CustomersController@get');
        $router->post('/post', 'App\Http\Controllers\CustomersController@post');
        $router->put('/update/{id?}', 'App\Http\Controllers\CustomersController@update');
        $router->delete('/delete/{id?}', 'App\Http\Controllers\CustomersController@destroy');
        
        $router->get('/', function () {
            return 'Nada pra ver ^^"';
        });

});

Route::group([
    'middleware' => ['auth:sanctum', 'verified'], 
    'prefix' => 'numbers'
    ], 
    function ($router) {

        $router->get('/get/{id?}', 'App\Http\Controllers\NumbersController@get');
        $router->post('/post', 'App\Http\Controllers\NumbersController@post');
        $router->put('/update/{id?}', 'App\Http\Controllers\NumbersController@update');
        $router->delete('/delete/{id?}', 'App\Http\Controllers\NumbersController@destroy');
        
        $router->get('/', function () {
            return 'Nada pra ver ^^"';
        });

});

Route::group([
    'middleware' => ['auth:sanctum', 'verified'], 
    'prefix' => 'number_preferences'
    ], 
    function ($router) {

        $router->get('/get/{id?}', 'App\Http\Controllers\NumberPreferencesController@get');
        $router->post('/post', 'App\Http\Controllers\NumberPreferencesController@post');
        $router->put('/update/{id?}', 'App\Http\Controllers\NumberPreferencesController@update');
        $router->delete('/delete/{id?}', 'App\Http\Controllers\NumberPreferencesController@destroy');
        
        $router->get('/', function () {
            return 'Nada pra ver ^^"';
        });

});

Route::group([
    'middleware' => ['auth:sanctum', 'verified'], 
    'prefix' => 'dashboard/'
    ], 
    function ($router) {

        $router->get('/users', 'App\Http\Controllers\DashboardController@users')->name('dashboard_users');
        $router->get('/customers', 'App\Http\Controllers\DashboardController@customers')->name('dashboard_customers');
        $router->get('/numbers', 'App\Http\Controllers\DashboardController@numbers')->name('dashboard_numbers');
        $router->get('/number_preferences', 'App\Http\Controllers\DashboardController@numberPreferences')->name('dashboard_number_preferences');
        
        $router->get('/', function () {
            return 'Nada pra ver ^^"';
        });

});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', 'App\Http\Controllers\DashboardController@users')->name('dashboard');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});