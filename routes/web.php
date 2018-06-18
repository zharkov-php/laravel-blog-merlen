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


Route::group(['prefix'=>'admin','namespace'=>'Admin'], function(){
    //Route::get('/admin', 'Admin\DashboardController@index');
    Route::get('/', 'DashboardController@index');
    //Route::resource('/admin/categories', 'Admin\CategoriesController');
    Route::resource('/categories', 'CategoriesController');
    //Route::resource('/admin/tags', 'Admin\TagsController');
    Route::resource('/tags', 'TagsController');
});

