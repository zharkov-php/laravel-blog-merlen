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

Route::get('/', 'HomeController@index');
Route::get('/post/{slug}', 'HomeController@show')->name('post.show');

Route::group(['prefix'=>'admin','namespace'=>'Admin'], function(){
    //Route::get('/admin', 'Admin\DashboardController@index');
    Route::get('/', 'DashboardController@index');
    //Route::resource('/admin/categories', 'Admin\CategoriesController');
    Route::resource('/categories', 'CategoriesController');
    //Route::resource('/admin/tags', 'Admin\TagsController');
    Route::resource('/tags', 'TagsController');
    //Route::resource('/admin/users', 'Admin\UsersController');
    Route::resource('/users', 'UsersController');
    //Route::resource('/admin/posts', 'Admin\PostsController');
    Route::resource('/posts', 'PostsController');

});

