<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
use App\Http\Controllers\UserController;

Route::get('/', array('before' => 'members_auth', 'uses' => 'AdminController@dashboard'));
 
// Login & Signup & oAuth
Route::get('/login', array('before' => 'check_auth', 'uses' => 'LoginController@showLogin'));
Route::post('/login', array('before' => 'check_auth', 'uses' => 'LoginController@storeLogin'));
Route::get('/logout','LoginController@getLogout');
Route::get('/signup', array('before' => 'check_auth', 'uses' => 'LoginController@showSignup'));
Route::post('/signup', array('before' => 'check_auth', 'uses' => 'LoginController@storeSignup'));
Route::get('/signup/{userId}/activate/{activationCode}','LoginController@signupActivate');
Route::get('/forgotpassword', array('before' => 'check_auth', 'uses' => 'LoginController@showForgotpassword'));
Route::post('/forgotpassword', array('before' => 'check_auth', 'uses' => 'LoginController@storeForgotpassword'));
Route::get('/newpassword', array('before' => 'check_auth', 'uses' => 'LoginController@showNewPassword'));
Route::post('/newpassword', array('before' => 'check_auth', 'uses' => 'LoginController@storeNewPassword'));
Route::get('/social/{provider}/{action?}', array('as' => 'oauth', 'before' => 'check_auth', 'uses' => 'LoginController@oAuthSocial'));

// Admin user control
Route::get('/users', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AdminController@showUsers'));
Route::get('/users/edit/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AdminController@editUser'));
Route::post('/users/edit/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AdminController@updateUser'));
Route::get('/users/delete/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AdminController@deleteUser'));
Route::get('/users/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AdminController@newUser'));
Route::post('/users/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AdminController@storeUser'));
Route::get('/users/profile/{userId}', array('before' => 'members_auth|hasUserAccess', 'uses' => 'AdminController@showProfile'));

// User settings
Route::get('/users/settings/{userId}', array('before' => 'members_auth|hasUserAccess', 'uses' => 'UserController@editProfile'));
Route::post('/users/settings/{userId}', array('before' => 'members_auth|hasUserAccess', 'uses' => 'UserController@updateProfile'));
// Admin Calendar
Route::get('/calendar', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CalendarController@showCalendar'));
Route::get('/calendar/user', array('before' => 'members_auth', 'uses' => 'CalendarController@showUserCalendar'));
Route::get('/search/events/admin', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CalendarController@searchEvents'));
Route::get('/search/events/user', array('before' => 'members_auth', 'uses' => 'CalendarController@searchUserEvents'));

// Admin courses control
Route::get('/courses', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@showCourses'));
Route::get('/courses/delete/{courseId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@deleteCourse'));
Route::get('/courses/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@newCourse'));
Route::get('/courses/edit/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@editCourse'));
Route::post('/courses/edit/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@updateCourse'));
Route::post('/courses/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@storeCourse'));
Route::get('/courses/view/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@showCourse'));
Route::get('/courses/enroll', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@newEnrollment'));
Route::post('/courses/enroll', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@storeEnrollment'));
Route::get('/courses/{courseId}/enroll/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@enrollUser'));
Route::get('/courses/{courseId}/review/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@reviewUser'));
Route::get('/courses/{courseId}/remove/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'CoursesController@remove'));
// User course control
Route::get('/courses/list', array('before' => 'members_auth', 'uses' => 'CoursesController@listCourses'));
Route::get('/course/view/{id}', array('before' => 'members_auth|check_enroll', 'uses' => 'CoursesController@viewCourse'));
Route::get('/courses/enroll/{courseId}', array('before' => 'members_auth', 'uses' => 'CoursesController@enrollCourse'));

// VMachines control
Route::get('/vmachines', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'VMachinesController@showVMachines'));
Route::get('/vmachines/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'VMachinesController@newMachine'));
Route::post('/vmachines/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'VMachinesController@storeVMachine'));
Route::get('/vmachines/delete/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'VMachinesController@deleteVMachine'));
Route::get('/vmachine/{id}/operation/{operation}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'VMachinesController@operateVMachine'));
Route::get('/vmachines/log', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'VMachinesController@serverLog'));
// User control
Route::get('/vmachine/console/{id}/{assignId}', array('before' => 'members_auth', 'uses' => 'VMachinesController@requestConsole'));

// Assignments control
Route::get('/assignments', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AssignmentController@showAssignments'));
Route::get('/assignments/new/{enrollId}/{teacherId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AssignmentController@newUserAssignment'));
Route::post('/assignments/create', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AssignmentController@storeUserAssignment'));
Route::get('/assignments/delete/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AssignmentController@deleteAssignment'));
Route::get('/assignments/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AssignmentController@newAssignment'));
Route::post('/assignments/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AssignmentController@storeAssignment'));
Route::get('/assignments/view/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'AssignmentController@viewAssignment'));
// User assignments control
Route::get('/assignments/list', array('before' => 'members_auth', 'uses' => 'AssignmentController@listAssignments'));
Route::get('/assignments/take/{id}', array('before' => 'members_auth|check_assign', 'uses' => 'AssignmentController@takeAssignment'));
Route::post('/assignments/check/{id}', array('before' => 'members_auth|check_assign', 'uses' => 'AssignmentController@checkAssignment'));
// styling result page
Route::get('/assignments/result', array('before' => 'members_auth', 'uses' => 'AssignmentController@showResult'));

// Attachments download
Route::get('/delete/{id}', array('before' => 'members_auth', 'uses' => 'CoursesController@deleteAttachment'));
Route::get('/download/{id}', array('before' => 'members_auth', 'uses' => 'CoursesController@downloadAttachment'));

// SearchController Autocomplete
Route::get('/search/user/{query}', array('before' => 'members_auth', 'uses' => 'SearchController@searchUser'));
Route::get('/search/course/{query}', array('before' => 'members_auth', 'uses' => 'SearchController@searchCourse'));

// TEST
Route::get('login', function(){
	return view('login');
});


