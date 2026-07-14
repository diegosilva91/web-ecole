<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/auth/{user_id}', 'Api\Auth\AuthController@GetUserAuth')->middleware('auth:api');
Route::post('/register/{provider}', 'Auth\SocialController@redirect');

Route::get('/favorite/{course_id}', 'Api\FavoritesCourses\FavoritesCoursesController@isFavorite');
Route::post('/favorite/{course_id}', 'Api\FavoritesCourses\FavoritesCoursesController@create');
Route::delete('/favorite/{course_id}', 'Api\FavoritesCourses\FavoritesCoursesController@remove');

Route::get('/mi-perfil/{id}', 'Api\Users\GetUsersProfile@getUsersProfile')->middleware('auth');
Route::get('/mi-perfil-teacher/{id}', 'Api\Teachers\GetProfileTeacherController@getTeacherPerfil')->middleware('auth');
Route::delete('/user-assistant/{user_id}', 'PortalCustomer\UserAssitantController@delete')->middleware('auth');

Route::get('/teachers', 'Api\Teachers\GetUsersWithTeacherRoleIsFeaturedController@getTeachers');
Route::post('/teachers/{user_id}', 'Api\Teachers\UpdateProfileTeacherController@update')->middleware('auth');

Route::get('/courses/featured', 'Api\Courses\FeaturedCoursesController@index');
Route::get('/courses', 'Api\Courses\FindCoursesController@index');

Route::get('/courses/search', 'Api\Courses\CoursesSearchController@index');

Route::get('/promotions', 'Api\Promotions\FilterPromotionsController@filter');

Route::get('/coupons', 'Api\Coupons\GetUserCouponsController@getCoupons');
Route::post('/coupons/{code}', 'Api\Coupons\GetCouponController@getPromoCode');

Route::get('/reviews', 'Api\Reviews\CourseReviewsController@index');
Route::post('/reviews/{token}', 'Api\Reviews\StoreReviewsController@storeReview');

Route::post('/payment/intent', 'PaymentController@createPaymentIntent');
Route::post('/payment/intent/{id}', 'PaymentController@updatePaymentIntent');
Route::post('/payment/update', 'PaymentController@UpdatePayment');
Route::post('/payment/update/{promotion_purchase_id}', 'PaymentController@UpdatePaymentNew');
Route::post('/trajectories/subscriptions-intent', 'Subscriptions\TrajectoriesController@createSubscription');
Route::post('/trajectories/subscriptions-intent/{id}', 'Subscriptions\TrajectoriesController@updateSubscription');

Route::post('/recommender-courses/update', 'RecommenderCoursesController@update');
Route::post('/recommender-courses/webhooks', 'RecommenderCoursesController@webhooks');
Route::get('/recommender-courses', 'RecommenderCoursesController@index');


Route::post('/stripe/webhooks/payment-intents', 'Payments\StripeController@webhookPaymentIntents');
Route::post('/stripe/webhooks/invoices', 'Payments\StripeController@webhookInvoices');
Route::post('/stripe/webhooks/customer/subscriptions', 'Api\Stripe\WebhookCustomerSubscriptionController@webhookCustomerSubscriptions');
Route::post('/stripe/webhooks/charge', 'Payments\StripeController@webhookCharge');

/**
 * Landings pages (Marketing)
 */
Route::post('/landing-request', 'Api\MarketingLandingController@landingRequest');
Route::post('/landing-teacher-request', 'Api\Teachers\LandingRequestController@landingRequest');

Route::get('/banner-featured', 'Api\BannerFeatured\GetBannerFeaturedController@index');
Route::get('/banner-featured/categories', 'Api\BannerFeatured\GetBannerFeaturedController@getCategories');
