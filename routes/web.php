<?php

use Illuminate\Support\Facades\Route;

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
 
Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/about-us', 'App\Http\Controllers\HomeController@aboutUs')->name('about-us');
Route::get('/become-a-partner', 'App\Http\Controllers\HomeController@becomeAPartner')->name('become-a-partner');
Route::get('/faq', 'App\Http\Controllers\HomeController@faq')->name('faq');
Route::get('/contact-us', 'App\Http\Controllers\HomeController@contactUs')->name('contact-us');
Route::get('/reload-captcha', 'App\Http\Controllers\HomeController@reloadCaptcha')->name('reload-captcha');
Route::post('/partner/post', 'App\Http\Controllers\HomeController@partnerPost')->name('partner.post');
Route::post('/contact/post', 'App\Http\Controllers\HomeController@contactPost')->name('contact.post');
Route::get('/email/confirmation/{id}', 'App\Http\Controllers\HomeController@emailConfirmation')->name('email.confirmation');
Route::get('/success/email/confirmation', 'App\Http\Controllers\HomeController@successConfirmation')->name('success.email.confirmation');

Route::get('/forgot/password/{id}', 'App\Http\Controllers\HomeController@forgotPassword')->name('forget.password');
Route::post('reset/password', 'App\Http\Controllers\HomeController@resetPassword')->name('reset.password');

Route::get('/admin/auth/login', 'App\Http\Controllers\Backend\AuthController@login')->name('admin.auth.login');
//Route::get('/admin/auth/login', 'App\Http\Controllers\Backend\AuthController@login')->name('login');
Route::post('/admin/auth/login', 'App\Http\Controllers\Backend\AuthController@loginPost')->name('admin.auth.login.post');
Route::get('/admin/auth/forgot/password', 'App\Http\Controllers\Backend\AuthController@forgotPassword')->name('admin.auth.forgot.password');
Route::post('/admin/auth/forgot/password', 'App\Http\Controllers\Backend\AuthController@forgotPasswordPost')->name('admin.auth.forgot.password.post');
Route::get('/admin/auth/reset/password/{id}', 'App\Http\Controllers\Backend\AuthController@resetPassword')->name('admin.auth.reset.password');
Route::post('/admin/auth/reset/password/post/{id}', 'App\Http\Controllers\Backend\AuthController@resetPasswordPost')->name('admin.auth.reset.password.post');
Route::get('/admin/auth/logout','App\Http\Controllers\Backend\AuthController@logout')->name('admin.auth.logout');

Route::group(['prefix' => 'admin','middleware' => 'auth','as'=>'admin.'], function()
{
    Route::get('/', 'App\Http\Controllers\Backend\HomeController@index')->name('index');
	Route::get('/dashboard', 'App\Http\Controllers\Backend\HomeController@index')->name('dashboard');
    Route::get('/edit/profile/{id}', 'App\Http\Controllers\Backend\HomeController@profileEdit')->name('edit.profile');
    Route::post('/profile/update/{id}', 'App\Http\Controllers\Backend\HomeController@profileUpdate')->name('profile.update');
    Route::get('/change/password/{id}', 'App\Http\Controllers\Backend\HomeController@changePassword')->name('change.password');
    Route::post('/change/password/update/{id}', 'App\Http\Controllers\Backend\HomeController@changePasswordUpdate')->name('change.password.update');

    Route::get('/services/category', 'App\Http\Controllers\Backend\ServicesCategoryController@index')->name('services.category.list');
    Route::get('/services/category/create', 'App\Http\Controllers\Backend\ServicesCategoryController@create')->name('services.category.create');
    Route::post('/services/category/store', 'App\Http\Controllers\Backend\ServicesCategoryController@store')->name('services.category.store');
    Route::get('/services/category/edit/{id}', 'App\Http\Controllers\Backend\ServicesCategoryController@edit')->name('services.category.edit');
    Route::post('/services/category/update/{id}', 'App\Http\Controllers\Backend\ServicesCategoryController@update')->name('services.category.update');
    Route::get('/services/category/delete/{id}', 'App\Http\Controllers\Backend\ServicesCategoryController@delete')->name('services.category.delete');
    Route::post('/services/category/status/change', 'App\Http\Controllers\Backend\ServicesCategoryController@statusChange')->name('services.category.status.change');
    Route::post('/services/category/showonheadertatus/change', 'App\Http\Controllers\Backend\ServicesCategoryController@showOnHeaderChange')->name('services.category.showonheader.change');
    Route::get('/services/category/view/{id}', 'App\Http\Controllers\Backend\ServicesCategoryController@view')->name('services.category.view');

    Route::get('/services', 'App\Http\Controllers\Backend\ServicesController@index')->name('services.list');
    Route::get('/services/create', 'App\Http\Controllers\Backend\ServicesController@create')->name('services.create');
    Route::post('/services/store', 'App\Http\Controllers\Backend\ServicesController@store')->name('services.store');
    Route::get('/services/edit/{id}', 'App\Http\Controllers\Backend\ServicesController@edit')->name('services.edit');
    Route::post('/services/update/{id}', 'App\Http\Controllers\Backend\ServicesController@update')->name('services.update');
    Route::get('/services/delete/{id}', 'App\Http\Controllers\Backend\ServicesController@delete')->name('services.delete');
    Route::post('/services/status/change', 'App\Http\Controllers\Backend\ServicesController@statusChange')->name('services.status.change');
    Route::post('/services/showonheadertatus/change', 'App\Http\Controllers\Backend\ServicesController@showOnHeaderChange')->name('services.showonheader.change');
    Route::get('/services/view/{id}', 'App\Http\Controllers\Backend\ServicesController@view')->name('services.view');

    Route::get('/users', 'App\Http\Controllers\Backend\UserController@index')->name('users.list');
    Route::get('/users/create', 'App\Http\Controllers\Backend\UserController@create')->name('users.create');
    Route::post('/users/store', 'App\Http\Controllers\Backend\UserController@store')->name('users.store');
    Route::get('/users/edit/{id}', 'App\Http\Controllers\Backend\UserController@edit')->name('users.edit');
    Route::post('/users/update/{id}', 'App\Http\Controllers\Backend\UserController@update')->name('users.update');
    Route::get('/users/delete/{id}', 'App\Http\Controllers\Backend\UserController@delete')->name('users.delete');
    Route::post('/users/status/change', 'App\Http\Controllers\Backend\UserController@statusChange')->name('users.status.change');

    Route::get('/professionalist', 'App\Http\Controllers\Backend\UserController@professionalist')->name('professionalist.list');
    Route::get('/professionalist/create', 'App\Http\Controllers\Backend\UserController@professionalCreate')->name('professionalist.create');
    Route::post('/professionalist/store', 'App\Http\Controllers\Backend\UserController@professionalStore')->name('professionalist.store');
    Route::get('/professionalist/edit/{id}', 'App\Http\Controllers\Backend\UserController@professionalEdit')->name('professionalist.edit');
    Route::post('/professionalist/update/{id}', 'App\Http\Controllers\Backend\UserController@professionalUpdate')->name('professionalist.update');
    Route::get('/professionalist/delete/{id}', 'App\Http\Controllers\Backend\UserController@professionalDelete')->name('professionalist.delete');
    Route::get('/professionalist/view/{id}', 'App\Http\Controllers\Backend\UserController@professionalView')->name('professionalist.view');

    Route::get('/customerlist', 'App\Http\Controllers\Backend\CustomerController@customerlist')->name('customerlist.list');
    Route::get('/customerlist/view/{id}', 'App\Http\Controllers\Backend\CustomerController@customerView')->name('customerlist.view');
    Route::get('/customerlist/edit/{id}', 'App\Http\Controllers\Backend\CustomerController@customerEdit')->name('customerlist.edit');
    Route::post('/customerlist/update/{id}', 'App\Http\Controllers\Backend\CustomerController@customerUpdate')->name('customerlist.update');


    Route::get('/contactus', 'App\Http\Controllers\Backend\ContactusController@index')->name('contactus.list');
    Route::get('/contactus/delete/{id}', 'App\Http\Controllers\Backend\ContactusController@delete')->name('contactus.delete');
    Route::get('/contactus/view/{id}', 'App\Http\Controllers\Backend\ContactusController@view')->name('contactus.view');
	
	Route::get('/orders', 'App\Http\Controllers\Backend\OrderController@index')->name('orders.list');
	Route::get('/orders/delete/{id}', 'App\Http\Controllers\Backend\OrderController@delete')->name('orders.delete');
    Route::get('/orders/view/{id}', 'App\Http\Controllers\Backend\OrderController@view')->name('orders.view');
    Route::post('/orders/status/change', 'App\Http\Controllers\Backend\OrderController@statusChange')->name('orders.status.change');
    Route::get('/orders/report/{id}', 'App\Http\Controllers\Backend\OrderController@reportView')->name('orders.report');

    Route::post('/professionalist/document/status/change', 'App\Http\Controllers\Backend\UserController@professionalDocumentStatusChange')->name('professionalist.document.status.change');

    Route::get('/reviews', 'App\Http\Controllers\Backend\ReviewController@index')->name('review.list');
    Route::get('/reviews/delete/{id}', 'App\Http\Controllers\Backend\ReviewController@delete')->name('review.delete');
   
  
});
Route::group(['prefix' => 'admin','middleware' => 'role:1,2,3','as'=>'admin.'], function()
{
    Route::get('/', 'App\Http\Controllers\Backend\HomeController@index')->name('index');
	Route::get('/dashboard', 'App\Http\Controllers\Backend\HomeController@index')->name('dashboard');
    Route::get('/edit/profile/{id}', 'App\Http\Controllers\Backend\HomeController@profileEdit')->name('edit.profile');
    Route::post('/profile/update/{id}', 'App\Http\Controllers\Backend\HomeController@profileUpdate')->name('profile.update');
    Route::get('/change/password/{id}', 'App\Http\Controllers\Backend\HomeController@changePassword')->name('change.password');
    Route::post('/change/password/update/{id}', 'App\Http\Controllers\Backend\HomeController@changePasswordUpdate')->name('change.password.update');

    Route::get('/services/category', 'App\Http\Controllers\Backend\ServicesCategoryController@index')->name('services.category.list');
    Route::get('/services/category/create', 'App\Http\Controllers\Backend\ServicesCategoryController@create')->name('services.category.create');
    Route::post('/services/category/store', 'App\Http\Controllers\Backend\ServicesCategoryController@store')->name('services.category.store');
    Route::get('/services/category/edit/{id}', 'App\Http\Controllers\Backend\ServicesCategoryController@edit')->name('services.category.edit');
    Route::post('/services/category/update/{id}', 'App\Http\Controllers\Backend\ServicesCategoryController@update')->name('services.category.update');
    Route::get('/services/category/delete/{id}', 'App\Http\Controllers\Backend\ServicesCategoryController@delete')->name('services.category.delete');
    Route::post('/services/category/status/change', 'App\Http\Controllers\Backend\ServicesCategoryController@statusChange')->name('services.category.status.change');
    Route::post('/services/category/showonheadertatus/change', 'App\Http\Controllers\Backend\ServicesCategoryController@showOnHeaderChange')->name('services.category.showonheader.change');

    Route::get('/services', 'App\Http\Controllers\Backend\ServicesController@index')->name('services.list');
    Route::get('/services/create', 'App\Http\Controllers\Backend\ServicesController@create')->name('services.create');
    Route::post('/services/store', 'App\Http\Controllers\Backend\ServicesController@store')->name('services.store');
    Route::get('/services/edit/{id}', 'App\Http\Controllers\Backend\ServicesController@edit')->name('services.edit');
    Route::post('/services/update/{id}', 'App\Http\Controllers\Backend\ServicesController@update')->name('services.update');
    Route::get('/services/delete/{id}', 'App\Http\Controllers\Backend\ServicesController@delete')->name('services.delete');
    Route::post('/services/status/change', 'App\Http\Controllers\Backend\ServicesController@statusChange')->name('services.status.change');
    Route::post('/services/showonheadertatus/change', 'App\Http\Controllers\Backend\ServicesController@showOnHeaderChange')->name('services.showonheader.change');

    Route::get('/users', 'App\Http\Controllers\Backend\UserController@index')->name('users.list');
    Route::get('/users/create', 'App\Http\Controllers\Backend\UserController@create')->name('users.create');
    Route::post('/users/store', 'App\Http\Controllers\Backend\UserController@store')->name('users.store');
    Route::get('/users/edit/{id}', 'App\Http\Controllers\Backend\UserController@edit')->name('users.edit');
    Route::post('/users/update/{id}', 'App\Http\Controllers\Backend\UserController@update')->name('users.update');
    Route::get('/users/delete/{id}', 'App\Http\Controllers\Backend\UserController@delete')->name('users.delete');

    Route::get('/setting/create','App\Http\Controllers\Backend\SettingController@create')->name('setting.create');
    Route::post('/setting/store','App\Http\Controllers\Backend\SettingController@store')->name('setting.store');

    Route::get('/sendemail','App\Http\Controllers\Backend\SettingController@sendemail');
     
});


 
