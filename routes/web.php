<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

/**
 * Static Pages
 */

Route::get('/', 'Web\HomeController@redirectHome')->name('home');
Route::get('/es', 'Web\HomeController@home')->name('home.es');

Route::post('/es/login', 'Auth\LoginController@login')->name('login')->middleware('guest');
Route::post('/es/registro', 'Auth\RegisterController@registerSpanish')->name('registro');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/es/cursos', 'Web\Courses\CoursesController@courses')->name('courses.list');
Route::get('/es/cursos/s/{any?}', 'Web\Courses\CoursesController@searchAnyCourses')->where('any', '.*');

Route::get('/es/cursos/{category}/{slug}', 'Web\RedirectsController@oldCourseUrl');
Route::get('/es/cursos/{category}/{specialization}/{slug}', 'Web\Courses\CoursesController@courseNew');

Route::get('/es/contacto', 'Web\ContactController@contact')->name('contacto');
Route::post('/es/contacto', 'Web\ContactController@contactMail');

/**
 * Static pages
 */
Route::get('/es/faq', 'Web\StaticPagesController@faq')->name('faq');
Route::get('/es/sobre-mi-empresa', 'Web\StaticPagesController@aboutUs');

/**
 * Routes Legal pages
 */
Route::get('/es/terminos-y-condiciones', 'Web\LegalPagesController@conditions')->name('terms-conditions');
Route::get('/es/politica-de-cookies', 'Web\LegalPagesController@cookies');
Route::get('/es/aviso-legal', 'Web\LegalPagesController@legal')->name('legal');
Route::get('/es/politica-de-privacidad', 'Web\LegalPagesController@privacy')->name('policy');
Route::get('/es/terminos-invita-amigos', 'Web\LegalPagesController@termsGetMember');

Auth::routes(
    ['login' => false]
);

Route::get('/es/payment/{course_id}', 'Web\Payment\ShowPaymentPreview@showPaymentPreview');
Route::get('/es/payment/{course_id}/{promotion_id}', 'Web\Payment\ShowPaymentView@showPaymentView');
Route::get('/es/payment/{course_id}/{promotion_purchase_id}/success', 'Web\Payment\ShowPaymentViewSuccess@showPaymentViewSuccess');
Route::post('/es/payment', 'PaymentController@payout');
Route::post('/es/payment-log', 'PaymentController@logPayment');

/**
 * SPA
 */
Route::get('/es/lf/{any}', 'pagesController@portalLF')->where('any', '.*')->middleware('auth');
Route::post('/es/mi-perfil/{user_id}', 'Web\Customers\UpdateProfileCustomerController@update')->middleware('auth');
Route::post('/es/mi-perfil/photo/{user_id}', 'Services\ImageController@imageUpload')->middleware('auth');

Route::get('/es/mis-cursos', 'Web\Teachers\CoursesTeacherController@coursesTeacher')->middleware('auth');
Route::get('/es/cursos-favoritos', 'PortalCustomer\FavoriteCoursesController@listFavoritesCourses')->middleware('auth');

/**
 * Landings pages
 */
Route::get('/es/nuevas-tecnologias', 'Web\LandingController@tech');
Route::get('/es/refuerzo_idiomas', 'Web\LandingController@techSchool');
Route::get('/es/tech/programacion', 'Web\LandingController@techCode');
Route::get('/es/tech/redes_sociales', 'Web\LandingController@techRs');
Route::get('/es/tech/web', 'Web\LandingController@techWeb');
Route::get('/es/tech/robotica', 'Web\LandingController@techRobot');
Route::get('/es/tech/videojuegos', 'Web\LandingController@techGame');
Route::get('/es/tech/microsoft_office', 'Web\LandingController@techOffice');
Route::get('/es/tech/diseno', 'Web\LandingController@techDesign');
Route::get('/es/campus-verano', 'Web\LandingController@techSummer');
Route::get('/es/campus-de-navidad', 'Web\LandingController@techWinter');
Route::get('/es/campus-de-semana-santa', 'Web\LandingController@techHolyWeek');
Route::get('/es/descuentos-mi-empresa', 'Web\LandingController@promo');

/**
* Landings pages (Marketing)
*/
Route::get('/es/landing-general', function () {
    return redirect('/es/landing-general-tech');
});
Route::get('/es/landing-general-tech', 'Web\MarketingLandingController@landingCategoriesTech');

/**
 * Routes Reviews Form
 */
Route::get('/es/reviews/{token}', 'Web\ReviewsController@showReviewsForm');

/**
* Routes Dar Clases
*/
Route::get('/es/dar-clases', 'Web\LandingController@teachers');

/**
 * Routes for Social Login and Register
 */
Route::post('/register/{provider}', 'Auth\SocialController@redirect');
Route::get('/auth/{provider}/callback', 'Auth\SocialController@Callback')->where('provider', '.*');
Route::get('/register/{provider}', 'Auth\SocialController@redirect');


/**
 * Routes for Feed RS
 */
Route::get('/courses/export/csv', 'Web\Courses\ExportCourseCsvController@exportCsv');
Route::get('/courses/{course}', 'Web\Courses\ShowFeedCourseController@show')->name('courses.show');
Route::feeds();

/**
 *  Routes for Recommender
 */
Route::get('/es/recommender', 'RecommenderCoursesController@showTypeForm');
Route::get('/es/recommender/show-courses', 'RecommenderCoursesController@showTypeForm');// replace for courses pages

/**
 * Routes for exports
 */
Route::get('/es/courses/complete/export/pdf/{user_id}', 'Services\ExportPdfCoursesController@exportPdfCoursesReceipt');

/***
 *  Routes for Trayectorias
 */
Route::get('/es/cursos-anuales/landing', 'Subscriptions\TrajectoriesController@landingTrajectories');
Route::get('/es/cursos-anuales/payment/{course_id}/{pack_id}', 'Subscriptions\TrajectoriesController@paymentTrajectoriesPreView');
Route::get('/es/cursos-anuales/payment/{course_id}/{pack_id}/{promotion_id}', 'Subscriptions\TrajectoriesController@paymentTrajectoriesView');
Route::get('/es/cursos-anuales', 'Subscriptions\TrajectoriesController@trajectoriesAll');

Route::get('/sitemap_courses.xml', 'Web\SiteMapController@index');

/**
 * Redirects for compatibility
 */
Route::get('/es/cursos-anuales/programacion', 'Web\RedirectsController@trajectoriesCode');
Route::get('/es/cursos-anuales/videojuegos', 'Web\RedirectsController@trajectoriesGame');
Route::get('/es/cursos-anuales/robotica', 'Web\RedirectsController@trajectoriesRobot');
Route::get('/es/cursos-anuales/arte-digital', 'Web\RedirectsController@trajectoriesDigitalArt');
Route::get('/es/cursos-anuales/redes-sociales', 'Web\RedirectsController@trajectoriesRs');

Route::get('/healtz', 'Web\Tech\HealtzController@healtz');
