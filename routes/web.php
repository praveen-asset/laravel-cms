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

Route::get('/about-us', 'PagesController@about');
Route::get('/contact-us', 'PagesController@contact');
Route::post('/contact-us', 'PagesController@send_inquiry')->name('contact-us');
Route::get('/terms-of-use', 'PagesController@terms_use');
Route::get('/privacy-policy', 'PagesController@privacy_policy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('logout', function(){
	Auth::logout(); //logout the current user
	Session::flush(); //delete the session
	Cache::flush();
	return Redirect::to('login'); //redirect to login page
})->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']] , function(){
	// HomeController Related to profile
	Route::get('/', 'Admin\HomeController@index');	
	Route::get('/dashboard', 'Admin\HomeController@index')->name('dashboard');	
	Route::get('/profile', 'Admin\HomeController@profile')->name('profile');
	Route::post('/profile', 'Admin\HomeController@updateProfile')->name('updateProfile');
	Route::post('/update_email', 'Admin\HomeController@updateEmail');
	Route::post('/change_password', 'Admin\HomeController@changePassword');
	Route::get('/resetPwd', 'Admin\HomeController@resetPwd');

	// UserController Related to users detail
	Route::resource('user', 'Admin\UserController');
	Route::post('user/update_status', 'Admin\UserController@update_status');

	// EmailController Related to Email template
	Route::resource('email', 'Admin\EmailController');

	// CmsController related to Cms 
	Route::resource('cms', 'Admin\CmsController');
	Route::post('cms/update_status', 'Admin\CmsController@update_status');
	
	Route::get('social', 'Admin\SocialController@index')->name('social');
	Route::post('social', 'Admin\SocialController@update');

	Route::get('company-details', 'Admin\BasicController@view_company_details')->name('company-details');
	Route::delete('company-details', 'Admin\BasicController@update_company_details')->name('update-company-details');
	Route::post('company-details/{type}', 'Admin\BasicController@save_company_details')->name('save-company-details');


	Route::resource('inquiry', 'Admin\InquiryController');
});

Route::group(['middleware' => 'auth'] , function(){
	Route::get('/profile', 'ProfileController@index')->name('profile');
	Route::post('/profile-update', 'ProfileController@updateProfile')->name('profile_update');
	Route::get('/change-password', 'ProfileController@changePasswordView');
	Route::post('/change-password', 'ProfileController@changePassword')->name('change-password');
	Route::get('/resetpassword-confirmation', 'ProfileController@confirmResetpassword')->name('checkreset');
});

Route::get('/joinuser/{id}', 'JoinUserController@index');
Route::post('/joinuser/create' , 'JoinUserController@join')->name('joinuser.create');


// to confirm account
Route::get('register/confirm/{user_id}', 'Auth\RegisterController@confirm');
Route::post('register/change-email/{user_id}', 'Auth\RegisterController@changeEmail')->name('change-email');

// to verify email
Route::get('register/verify/{confirmationCode}', 'Auth\VerifyController@verify');
Route::post('register/verify/', 'Auth\VerifyController@verify')->name('register_verify');

Route::get('register/resend/{user_id}', 'Controller@resendVerification')->name('resendverification');