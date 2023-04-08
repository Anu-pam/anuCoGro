<?php

use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\StripeController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\Backend\UserController;

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
 
Route::group([
    'prefix' => 'v1',
    'as' => 'api.',
], function () {
    Route::post('register', [UsersController::class, 'register'])->name('register');
    Route::post('login', [UsersController::class, 'login'])->name('login');
	Route::post('forgot/password', [UsersController::class, 'forgotPassword'])->name('forgot.password');
	Route::post('reset/password', [UsersController::class, 'resetPassword'])->name('reset.password');
    Route::get('email/confirmation/{id}', [UsersController::class, 'emailConfirmation'])->name('email.confirmation');
    Route::get('category', [ServicesController::class, 'serviceCategory'])->name('category');
  
	  
    Route::middleware('auth:api')->group(function () { 
        //Route::get('category', [ServicesController::class, 'serviceCategory'])->name('category');
        Route::get('services', [ServicesController::class, 'services'])->name('services');
		Route::get('services/edit/{id}', [ServicesController::class, 'edit'])->name('services.edit');
		Route::post('services/store', [ServicesController::class, 'serviceStore'])->name('services.store');
		Route::post('services/update/{id}', [ServicesController::class, 'serviceUpdate'])->name('services.update');
		Route::get('services/category', [ServicesController::class, 'servicesCat'])->name('services.category.list');
		Route::post('professional/services/store', [ServicesController::class, 'professionalServiceStore'])->name('professional.services.store');
		Route::post('professional/services/update/{id}', [ServicesController::class, 'professionalServiceUpdate'])->name('professional.services.update');
		Route::get('professional/services/price/{id}', [ServicesController::class, 'professionalServicePrice'])->name('professional.services.price');
        Route::post('professional/services/price/update', [ServicesController::class, 'professionalServicePriceUpdate'])->name('professional.services.Price.Update');
        Route::get('orders', [ServicesController::class, 'orders'])->name('orders');
		Route::post('order/store', [ServicesController::class, 'orderStore'])->name('order.store'); 
        Route::get('logout', [UsersController::class, 'logout'])->name('logout');  
        Route::get('professional/list', [UsersController::class, 'getAllProfessionalList'])->name('professional.list');
        Route::get('professional/details/{id}', [UsersController::class, 'getProfessionalDetails'])->name('professional.details');
        Route::get('professional/services', [UsersController::class, 'getProfessionalServices'])->name('professional.services');
        Route::get('professional/services/delete/{id}', [UsersController::class, 'professionalServicesDelete'])->name('professional.services.delete');
        Route::post('professional/users/update', [UsersController::class, 'professionalUserUpdate'])->name('professional.users.update');
        Route::post('users/update', [UsersController::class, 'UserUpdate'])->name('users.update');
        Route::get('professional/booking/list', [UsersController::class, 'getProfessionalBooking'])->name('professional.booking.list');
        Route::get('professional/booking/upcoming/list', [UsersController::class, 'getProfessionalUpcomingBooking'])->name('professional.booking.upcoming.list');
        Route::get('professional/booking/Detail/{id}', [UsersController::class, 'getProfessionalBookingAllDetail'])->name('professional.booking.list.detail');
        Route::get('user/booking/list', [UsersController::class, 'getUserBooking'])->name('user.booking.list');
        Route::get('user/booking/upcoming/list', [UsersController::class, 'getUserUpcomingBooking'])->name('user.booking.upcoming.list');
        Route::get('user/booking/Detail/{id}', [UsersController::class, 'getUserBookingAllDetail'])->name('user.booking.list.detail');
        Route::post('user/booking/Detail/{id}/review', [UsersController::class, 'requestUserBookingReview'])->name('user.booking.list.detail.review');
        Route::post('user/favorite/professional/save', [UsersController::class, 'saveUserFavProf'])->name('user.fav.prof');
        Route::get('favorite/professional/list', [UsersController::class, 'getFavProf'])->name('fav.professional.list');
        Route::post('professional/available/status',[UsersController::class,'availableStatus']);
        Route::post('notification/status',[UsersController::class,'notificationStatus']);
        Route::get('user/setting',[UsersController::class,'getUserSetting']);
        Route::put('user/setting',[UsersController::class,'getUserSettingupdate']);
        Route::post('professional/order/update',[UsersController::class,'checkUserOtp']);
        Route::Post('professional/booking/AcceptCancel',[BookingController::class,'AcceptCancelStatus']);
        Route::get('professional/booking/wallet',[BookingController::class,'wallet']);
        Route::post('professional/booking/slot',[BookingController::class,'bookingSlot']);
        //cron job 
        Route::get('orderCancel/cronJob',[ServicesController::class,'OrderCancelByCronJob']);
        //send email
        Route::get('event/email', [BookingController::class,'Adminemail']); 
        Route::post('stripe', [StripeController::class,'stripePost'])->name('stripe.post'); 
        Route::get('stripeResource', [ServicesController::class,'getStripeResource'])->name('stripe.resource'); 
        Route::get('professional/identification',[ServicesController::class,'getidentification'])->name('identification');
        Route::post('professional/identification',[ServicesController::class,'setidentification'])->name('set.identification');
        Route::get('professional/documents',[ServicesController::class,'getDocuments'])->name('documents');
        Route::delete('professional/documents/{id}',[ServicesController::class,'getDocumentsRemove'])->name('documents.delete');
        Route::get('professional/reviews',[UsersController::class,'getReviews'])->name('reviews');
        Route::post('professional/gallery',[ServicesController::class,'requestGallery'])->name('gallery.store');
        Route::get('professional/gallery',[ServicesController::class,'getRequestGallery'])->name('gallery.get');
        Route::delete('professional/gallery/{id}',[ServicesController::class,'galleryDelete'])->name('gallery.delete');
        Route::post('user/servicesPrice',[ServicesController::class,'servicesPrice'])->name('services.price');
        Route::get('user/address',[UsersController::class,'userAddress'])->name('user.address');
        Route::post('user/address',[UsersController::class,'addAddress'])->name('user.addAddress');
        Route::delete('user/address/{id}',[UsersController::class,'deleteAddress'])->name('user.deleteAddress');
        
    });
});
  