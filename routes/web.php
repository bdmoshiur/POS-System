<?php
use Illuminate\Support\Facades\Route;

//Frontend Route
Route::get('/', 'Frontend\FrontendController@index');

//Backend Route
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
// Users Route
Route::prefix('users')->group(function () {
Route::get('/view', 'Backend\UserController@view')->name('users.view');
Route::get('/add', 'Backend\UserController@add')->name('users.add');
Route::post('/store', 'Backend\UserController@store')->name('users.store');
Route::get('/edit/{id}', 'Backend\UserController@edit')->name('users.edit');
Route::post('/update/{id}', 'Backend\UserController@update')->name('users.update');
Route::get('/delete/{id}', 'Backend\UserController@delete')->name('users.delete');

});

// Users Profile Route
Route::prefix('profiles')->group(function () {
Route::get('/view', 'Backend\ProfileController@view')->name('profiles.view');
Route::get('/edit', 'Backend\ProfileController@edit')->name('profiles.edit');
Route::post('/update', 'Backend\ProfileController@update')->name('profiles.update');
Route::get('/password/view', 'Backend\ProfileController@passwordView')->name('profiles.password.view');
Route::post('/password/update', 'Backend\ProfileController@passwordUpdate')->name('profiles.password.update');

});


// Suppliers Route
Route::prefix('suppliers')->group(function () {
    Route::get('/view', 'Backend\SupplierController@view')->name('suppliers.view');
    Route::get('/add', 'Backend\SupplierController@add')->name('suppliers.add');
    Route::post('/store', 'Backend\SupplierController@store')->name('suppliers.store');
    Route::get('/edit/{id}', 'Backend\SupplierController@edit')->name('suppliers.edit');
    Route::post('/update/{id}', 'Backend\SupplierController@update')->name('suppliers.update');
    Route::get('/delete/{id}', 'Backend\SupplierController@delete')->name('suppliers.delete');
    
    });

    
// Suppliers Route
Route::prefix('customers')->group(function () {
    Route::get('/view', 'Backend\CustomerController@view')->name('customers.view');
    Route::get('/add', 'Backend\CustomerController@add')->name('customers.add');
    Route::post('/store', 'Backend\CustomerController@store')->name('customers.store');
    Route::get('/edit/{id}', 'Backend\CustomerController@edit')->name('customers.edit');
    Route::post('/update/{id}', 'Backend\CustomerController@update')->name('customers.update');
    Route::get('/delete/{id}', 'Backend\CustomerController@delete')->name('customers.delete');
    
    });

    Route::prefix('units')->group(function () {
        Route::get('/view', 'Backend\UnitController@view')->name('units.view');
        Route::get('/add', 'Backend\UnitController@add')->name('units.add');
        Route::post('/store', 'Backend\UnitController@store')->name('units.store');
        Route::get('/edit/{id}', 'Backend\UnitController@edit')->name('units.edit');
        Route::post('/update/{id}', 'Backend\UnitController@update')->name('units.update');
        Route::get('/delete/{id}', 'Backend\UnitController@delete')->name('units.delete');
        
        });



});

