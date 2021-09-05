<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use \API\LoginController;
//use \API\UsersController;
use App\Http\Controllers\API\LoginController;
use API\UsersController;
use App\Http\Controllers\API\LanguageController;
use App\Http\Controllers\API\MarketsController;
use App\Http\Controllers\API\CoursesController;
use App\Http\Controllers\API\ReviewsController;
use App\Http\Controllers\API\ModuleTypeController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\NotificationsController;
use App\Http\Controllers\API\PaymentsController;
use App\Http\Controllers\API\CoursesVideosController;
use App\Http\Controllers\API\UsersChatController;
use App\Http\Controllers\API\PagesController;
use App\Http\Controllers\API\PromoCodeController;
use App\Http\Controllers\API\AdvisoryNotificationsController;
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

Route::post('login', [LoginController::class, 'login']);
Route::post('verifyOTP', [LoginController::class, 'verifyOTP']);
Route::post('signup', [LoginController::class, 'signup']);
Route::post('logout', [LoginController::class, 'logout']);
Route::post('profileupload/{id}', [UsersController::class, 'uploadprofile']);
Route::post('getOTP', [LoginController::class, 'getOTP']);

Route::get('getlanguage', [LanguageController::class, 'getlanguage']);
Route::post('setlanguage/{id}', [LanguageController::class, 'setlanguage']);

Route::get('getmarkets', [MarketsController::class, 'getmarkets']);
Route::post('setmarket/{id}', [MarketsController::class, 'setmarket']);

Route::post('getCourses', [CoursesController::class, 'getCourses']);
Route::post('getCourseDetails/{id}', [CoursesController::class, 'getCourseDetails']);

Route::post('getReviews', [ReviewsController::class, 'getReviews']);
Route::post('addReview', [ReviewsController::class, 'addReview']);
// Route::get('getModuleTypes', [ModuleTypeController::class, 'getModuleTypes']);

// Route::get('getDashboard ', [CoursesController::class, 'getDashboard']);
Route::post('getDashboard ', [DashboardController::class, 'getDashboard']);
Route::post('getAboutUs ', [PagesController::class, 'getAboutUs']);
Route::post('getPrivacyPolicy ', [PagesController::class, 'getPrivacyPolicy']);
Route::post('getTermsandConditions ', [PagesController::class, 'getTermsandConditions']);


Route::group(['middleware' => ['auth:api']], function(){
    Route::resource('users', UsersController::class);
    Route::post('resetPassword', [LoginController::class, 'resetPassword']);
	Route::post('getNotificationList', [NotificationsController::class, 'getNotificationList']);
	Route::get('readNotification', [NotificationsController::class, 'readNotification']);
	Route::get('getNotificationCount', [NotificationsController::class, 'getNotificationCount']);
    Route::post('getOrder', [PaymentsController::class, 'getOrder']);
    Route::post('verifyPaymentSignature', [PaymentsController::class, 'verifyPaymentSignature']);
    Route::post('getPaymentHistory', [PaymentsController::class, 'getPaymentHistory']);
	Route::get('getMySubscriptions', [PaymentsController::class, 'getMySubscriptions']);
	Route::post('getCourseVideos', [CoursesVideosController::class, 'getCourseVideos']);
	Route::post('registerDeviceToken', [LoginController::class,'registerDeviceToken']);
    Route::post('deRegisterDeviceToken', [LoginController::class,'deRegisterDeviceToken']);
    Route::post('sendMessage', [UsersChatController::class,'sendMessage']);
	Route::post('getMessageList', [UsersChatController::class,'getMessageList']);
	Route::post('activateTrial', [PaymentsController::class, 'activateTrial']);
	Route::get('getOffer', [PromoCodeController::class, 'getOffer']);
	Route::post('getCombineOrder', [PaymentsController::class, 'getCombineOrder']);
	Route::post('getCoursesbyMarket ', [CoursesController::class, 'getCoursesbyMarket']);
	Route::post('getAdvisoryNotificationList', [AdvisoryNotificationsController::class, 'getAdvisoryNotificationList']);
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
