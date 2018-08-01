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

Route::match(array('GET','POST'),'/backend/login','Backend\LoginController@index');

/* SUPER ADMIN */
Route::group(array('prefix' => 'backend','middleware'=> ['token_super_admin']), function()
{
	Route::resource('/modules', 'Backend\ModuleController');
    Route::get('/datatable/module','Backend\ModuleController@datatable');
    
    Route::post('/setting/check-language','Backend\SettingController@check_language');
    Route::post('/setting/insert-language','Backend\SettingController@insert_language');

	Route::resource('/language', 'Backend\LanguageController');
    Route::get('/datatable/language','Backend\LanguageController@datatable');
     
});

/* ACCESS CONTROL EDIT */
Route::group(array('prefix' => 'backend','middleware'=> ['token_admin', 'token_edit']), function()
{
	Route::get('/users-level/{id}/edit','Backend\UserLevelController@edit');
	Route::match(array('PUT','PATCH'),'/users-level/{id}','Backend\UserLevelController@update');

	Route::get('/users-user/{id}/edit','Backend\UserController@edit');
    Route::match(array('PUT','PATCH'),'/users-user/{id}','Backend\UserController@update');

	Route::get('/photos/{id}/edit','Backend\PhotosController@edit');
    Route::match(array('PUT','PATCH'),'/photos/{id}','Backend\PhotosController@update');
    
	Route::get('/photos/{id}/edit','Backend\PhotosController@edit');
	Route::match(array('PUT','PATCH'),'/photos/{id}','Backend\PhotosController@update');
    
	Route::get('/pages/{id}/edit','Backend\PagesController@edit');
	Route::match(array('PUT','PATCH'),'/pages/{id}','Backend\PagesController@update');

	Route::get('/blog-category/{id}/edit','Backend\CategoryController@edit');
	Route::match(array('PUT','PATCH'),'/blog-category/{id}','Backend\CategoryController@update');

	Route::get('/blog-content/{id}/edit','Backend\BlogController@edit');
	Route::match(array('PUT','PATCH'),'/blog-content/{id}','Backend\BlogController@update');
    
});

/* ACCESS CONTROL ALL */
Route::group(array('prefix' => 'backend','middleware'=> ['token_admin', 'token_all']), function()
{
	Route::get('/users-level/create','Backend\UserLevelController@create');
	Route::post('/users-level','Backend\UserLevelController@store');
	Route::delete('/users-level/{id}','Backend\UserLevelController@destroy');
	
	Route::get('/users-user/create','Backend\UserController@create');
	Route::post('/users-user','Backend\UserController@store');
    Route::delete('/users-user/{id}','Backend\UserController@destroy');
    Route::post('/users-user/delete','Backend\UserController@deleteAll');

	Route::get('/media-library/upload','Backend\MediaLibraryController@upload');
	Route::post('/media-library/upload','Backend\MediaLibraryController@upload');	
    Route::delete('/media-library/{id}','Backend\MediaLibraryController@destroy');
    Route::post('/media-library','Backend\MediaLibraryController@deleteAll');

	Route::get('/photos/create','Backend\PhotosController@create');
	Route::post('/photos','Backend\PhotosController@store');
	Route::delete('/photos/{id}','Backend\PhotosController@destroy');
    
    Route::delete('/contact-inbox/{id}','Backend\ContactInboxController@destroy');
    Route::post('/contact-inbox','Backend\ContactInboxController@deleteAll');
    
	Route::get('/pages/create','Backend\PagesController@create');
	Route::post('/pages','Backend\PagesController@store');
	Route::delete('/pages/{id}','Backend\PagesController@destroy');

	Route::get('/blog-category/create','Backend\CategoryController@create');
	Route::post('/blog-category','Backend\CategoryController@store');
	Route::delete('/blog-category/{id}','Backend\CategoryController@destroy');

	Route::get('/blog-content/create','Backend\BlogController@create');
	Route::post('/blog-content','Backend\BlogController@store');
	Route::delete('/blog-content/{id}','Backend\BlogController@destroy');
    
});

/* ACCESS CONTROL VIEW */
Route::group(array('prefix' => 'backend','middleware'=> ['token_admin']), function()
{
	Route::get('',function (){return Redirect::to('backend/dashboard');});
	Route::get('/logout','Backend\LoginController@logout');
	
	Route::get('/dashboard','Backend\DashboardController@dashboard');

	Route::get('/users-level/datatable','Backend\UserLevelController@datatable');	
	Route::get('/users-level','Backend\UserLevelController@index');
	Route::get('/users-level/{id}','Backend\UserLevelController@show');
	
	Route::get('/users-user/datatable','Backend\UserController@datatable');
	Route::get('/users-user','Backend\UserController@index');
	Route::get('/users-user/{id}','Backend\UserController@show');
    Route::get('/user/export/{type}','ExcelController@export_user');

	Route::get('/media-library/datatable/','Backend\MediaLibraryController@datatable');
	Route::get('/media-library','Backend\MediaLibraryController@index');
	Route::get('/media-library/popup-media/{from}/{id_count}','Backend\MediaLibraryController@popup_media');
    Route::get('/media-library/popup-media-gallery/','Backend\MediaLibraryController@popup_media_gallery');
    Route::get('/media-library/popup-media-editor/{id_count}','Backend\MediaLibraryController@popup_media_editor');
	
	Route::get('/access-control','Backend\AccessControlController@index');
	Route::post('/access-control','Backend\AccessControlController@update');

	Route::get('/setting','Backend\SettingController@index');
	Route::post('/setting','Backend\SettingController@update');
    
	Route::get('/photos/datatable','Backend\PhotosController@datatable');
	Route::get('/photos','Backend\PhotosController@index');
    
    Route::get('/contact-inbox','Backend\ContactInboxController@index');
    Route::get('/contact-inbox/datatable','Backend\ContactInboxController@datatable');
    Route::get('/contact-inbox/{id}','Backend\ContactInboxController@show');    
    
	Route::get('/pages/datatable','Backend\PagesController@datatable');
	Route::get('/pages','Backend\PagesController@index');
   
	Route::get('/blog-category/datatable','Backend\CategoryController@datatable');	
	Route::get('/blog-category','Backend\CategoryController@index');
	Route::get('/blog-category/{id}','Backend\CategoryController@show');

	Route::get('/blog-content/datatable','Backend\BlogController@datatable');
	Route::get('/blog-content','Backend\BlogController@index');
    
});