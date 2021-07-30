<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VMachinesController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ScenarioController;
use App\Http\Controllers\SearchController;

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

/*Route::get('/', function (){
    return view('welcome');
});*/
/*Route::get('/', function(){
    return view('/dashboard/index');
});*/
Route::get('/', [AdminController::class, 'dashboard']);


Route::get('/calendar', [CalendarController::class, 'showCalendar']);
Route::get('/calendar/user', [CalendarController::class, 'showUserCalendar']);

Route::get('/vmachines', [VMachinesController::class, 'showVMachines']);

Route::get('/users/new',[ AdminController::class, 'newUser']);
Route::post('/users/new',[AdminController::class, 'storeUser']);
Route::get('/users', [AdminController::class, 'showUsers']);

Route::get('/courses', [CoursesController::class, 'showCourses']);
Route::get('/courses/list', [CoursesController::class, 'listCourses']);
Route::get('/courses/new', [CoursesController::class, 'newCourse']);
Route::post('/courses/new', [CoursesController::class, 'storeCourse']);

Route::get('/scenarios', [ScenarioController::class, 'showScenarios']);
Route::get('/scenarios/new', [ScenarioController::class, 'newScenario']);
Route::get('/scenario/new/{id}', [ScenarioController::class, 'newScenario']);
Route::post('/scenarios/store', [ScenarioController::class, 'storeScenario']);
Route::post('/scenarios/update/{id}', [ScenarioController::class, 'updateScenario']);
Route::get('/scenarios/view/{id}', [ScenarioController::class,'viewScenario']);
Route::get('/scenarios/edit/{id}', [ScenarioController::class, 'editScenario']);
Route::get('/scenarios/delete/{id}', [ScenarioController::class, 'deleteScenario']);
Route::get('/scenarios/questions/new/{id}', [ScenarioController::class, 'newScenarioQuestion']);
Route::get('/scenarios/questions/delete/{id}', [ScenarioController::class, 'deleteScenarioQuestion']);

Route::get('/assignments', [AssignmentController::class, 'showAssignments']);
Route::get('/assignments', [AssignmentController::class, 'showAssignments']);
Route::get('/assignments/new/{enrollId}/{teacherId}', [AssignmentController::class, 'newUserAssignment']);
Route::post('/assignments/create', [AssignmentController::class, 'storeUserAssignment']);
Route::get('/assignments/delete/{id}', [AssignmentController::class,'deleteAssignment']);
Route::get('/assignments/new', [AssignmentController::class, 'newAssignment']);
Route::post('/assignments/new', [AssignmentController::class, 'storeAssignment']);
Route::get('/assignments/view/{id}', [AssignmentController::class, 'viewAssignment']);
Route::get('/assignments/list', [AssignmentController::class, 'listAssignments']);
Route::get('/assignments/take/{id}', [AssignmentController::class, 'takeAssignment']);
Route::post('/assignments/check/{id}', [AssignmentController::class, 'checkAssignment']);
// // styling result page
Route::get('/assignments/result', [AssignmentController::class, 'showResult']);

Route::get('/users/new', [AdminController::class, 'newUser']);
Route::get('/users', [AdminController::class, 'showUsers']);
Route::post('/users/new', [AdminController::class, 'storeUser']);

Route::get('/login', [LoginController::class, 'showLogin']);
Route::post('/login', [LoginController::class, 'storeLogin']);
Route::get('/logout',[LoginController::class, 'getLogout']);

Route::get('/users/edit/{userId}', [AdminController::class, 'editUser']);
Route::post('/users/edit/{userId}', [AdminController::class, 'updateUser']);
Route::get('/users/delete/{userId}', [AdminController::class, 'deleteUser']);
Route::get('/users/profile/{userId}', [AdminController::class, 'showProfile']);

// // User settings
Route::get('/users/settings/{userId}', [UserController::class, 'editProfile']);
Route::post('/users/settings/{userId}', [UserController::class, 'updateProfile']);

// // VMachines control
Route::get('/vmachines', [VMachinesController::class, 'showVMachines']);
Route::get('/vmachines/new', [VMachinesController::class, 'newMachine']);
Route::post('/vmachines/new', [VMachinesController::class, 'storeVMachine']);
Route::get('/vmachines/delete/{id}', [VMachinesController::class, 'deleteVMachine']);
Route::get('/vmachine/{id}/operation/{operation}', [VMachinesController::class, 'operateVMachine']);
Route::get('/vmachines/log', [VMachinesController::class, 'serverLog']);


/* Route::group(['prefix' => 'admin','middleware' => 'adminauth'], function () {
	// Admin Dashboard
	//Route::get('dashboard','AdminController@dashboard')->name('dashboard');	
	// Route::get('admin/users', [AdminController::class, 'showUsers']);
});

// Login & Signup & oAuth
Route::get('/login', array('before' => 'check_auth', 'uses' => 'App\Http\Controllers\LoginController@showLogin'));
Route::post('/login', array('before' => 'check_auth', 'uses' => 'App\Http\Controllers\LoginController@storeLogin'));
Route::get('/logout','App\Http\Controllers\LoginController@getLogout');
Route::get('/signup', array('before' => 'check_auth', 'uses' => 'App\Http\Controllers\LoginController@showSignup'));
Route::post('/signup', array('before' => 'check_auth', 'uses' => 'App\Http\Controllers\LoginController@storeSignup'));
Route::get('/signup/{userId}/activate/{activationCode}','App\Http\Controllers\LoginController@signupActivate');
Route::get('/forgotpassword', array('before' => 'check_auth', 'uses' => 'App\Http\Controllers\LoginController@showForgotpassword'));
Route::post('/forgotpassword', array('before' => 'check_auth', 'uses' => 'App\Http\Controllers\LoginController@storeForgotpassword'));
Route::get('/newpassword', array('before' => 'check_auth', 'uses' => 'App\Http\Controllers\LoginController@showNewPassword'));
Route::post('/newpassword', array('before' => 'check_auth', 'uses' => 'App\Http\Controllers\LoginController@storeNewPassword'));
Route::get('/social/{provider}/{action?}', array('as' => 'oauth', 'before' => 'check_auth', 'uses' => 'App\Http\Controllers\LoginController@oAuthSocial'));
//
// // Admin user control
//Route::get('/users', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AdminController@showUsers'));
Route::get('/users', [AdminController::class, 'showUsers']);
Route::get('/users/edit/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AdminController@editUser'));
Route::post('/users/edit/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AdminController@updateUser'));
Route::get('/users/delete/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AdminController@deleteUser'));
Route::get('/users/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AdminController@newUser'));
Route::post('/users/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AdminController@storeUser'));
Route::get('/users/profile/{userId}', array('before' => 'members_auth|hasUserAccess', 'uses' => 'App\Http\Controllers\AdminController@showProfile'));

// // User settings
Route::get('/users/settings/{userId}', array('before' => 'members_auth|hasUserAccess', 'uses' => 'App\Http\Controllers\UserController@editProfile'));
Route::post('/users/settings/{userId}', array('before' => 'members_auth|hasUserAccess', 'uses' => 'App\Http\Controllers\UserController@updateProfile'));

// // Admin Calendar
Route::get('/calendar', [CalendarController::class, 'showCalendar']);
Route::get('/calendar/user', [CalendarController::class, 'showUserCalendar']);

Route::get('/calendar', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CalendarController@showCalendar'));
Route::get('/calendar/user', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\CalendarController@showUserCalendar'));
Route::get('/search/events/admin', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CalendarController@searchEvents'));
Route::get('/search/events/user', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\CalendarController@searchUserEvents'));

// // Admin courses control
Route::get('/courses', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@showCourses'));
Route::get('/courses/delete/{courseId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@deleteCourse'));
Route::get('/courses/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@newCourse'));
Route::get('/courses/edit/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@editCourse'));
Route::post('/courses/edit/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@updateCourse'));
Route::post('/courses/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@storeCourse'));
Route::get('/courses/view/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@showCourse'));
Route::get('/courses/enroll', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@newEnrollment'));
Route::post('/courses/enroll', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@storeEnrollment'));
Route::get('/courses/{courseId}/enroll/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@enrollUser'));
Route::get('/courses/{courseId}/review/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@reviewUser'));
Route::get('/courses/{courseId}/remove/{userId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\CoursesController@remove'));

// // User course control
Route::get('/courses/list', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\CoursesController@listCourses'));
Route::get('/course/view/{id}', array('before' => 'members_auth|check_enroll', 'uses' => 'App\Http\Controllers\CoursesController@viewCourse'));
Route::get('/courses/enroll/{courseId}', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\CoursesController@enrollCourse'));

// // VMachines control
Route::get('/vmachines', [VMachinesController::class, 'showVMachines']);

//Route::get('/vmachines', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\VMachinesController@showVMachines'));
Route::get('/vmachines/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\VMachinesController@newMachine'));
Route::post('/vmachines/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\VMachinesController@storeVMachine'));
Route::get('/vmachines/delete/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\VMachinesController@deleteVMachine'));
Route::get('/vmachine/{id}/operation/{operation}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\VMachinesController@operateVMachine'));
Route::get('/vmachines/log', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\VMachinesController@serverLog'));
// // User control
Route::get('/vmachine/console/{id}/{assignId}', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\VMachinesController@requestConsole'));
//
// // Assignments control
//Route::get('/assignments', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AssignmentController@showAssignments'));
Route::get('/assignments', [AssignmentController::class, 'showAssignments']);
Route::get('/assignments/new/{enrollId}/{teacherId}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AssignmentController@newUserAssignment'));
Route::post('/assignments/create', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AssignmentController@storeUserAssignment'));
Route::get('/assignments/delete/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AssignmentController@deleteAssignment'));
Route::get('/assignments/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AssignmentController@newAssignment'));
Route::post('/assignments/new', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AssignmentController@storeAssignment'));
Route::get('/assignments/view/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'App\Http\Controllers\AssignmentController@viewAssignment'));

// // User assignments control
Route::get('/assignments/list', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\AssignmentController@listAssignments'));
Route::get('/assignments/take/{id}', array('before' => 'members_auth|check_assign', 'uses' => 'App\Http\Controllers\AssignmentController@takeAssignment'));
Route::post('/assignments/check/{id}', array('before' => 'members_auth|check_assign', 'uses' => 'App\Http\Controllers\AssignmentController@checkAssignment'));
// // styling result page
Route::get('/assignments/result', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\AssignmentController@showResult'));
//
// Scenario control
Route::get('/scenarios', array('before' => 'members_auth', 'uses' => 'ScenarioController@showScenarios'));
// Route::get('/scenarios/new', array('before' => 'members_auth', 'uses' => 'ScenarioController@newScenario'));
// //Route::get('/scenario/new/{id}', array('before' => 'members_auth|hasAccess:admin', 'uses' => 'ScenarioController@newScenario'));
// Route::post('/scenarios/store', array('before' => 'members_auth', 'uses' => 'ScenarioController@storeScenario'));
// Route::post('/scenarios/update/{id}', array('before' => 'members_auth', 'uses' => 'ScenarioController@updateScenario'));
// Route::get('/scenarios/view/{id}', array('before' => 'members_auth', 'uses' => 'ScenarioController@viewScenario'));
// Route::get('/scenarios/edit/{id}', array('before' => 'members_auth', 'uses' => 'ScenarioController@editScenario'));
// Route::get('/scenarios/delete/{id}', array('before' => 'members_auth', 'uses' => 'ScenarioController@deleteScenario'));
// Route::get('/scenarios/questions/new/{id}', array('before' => 'members_auth', 'uses' => 'ScenarioController@newScenarioQuestion'));
// Route::get('/scenarios/questions/delete/{id}', array('before' => 'members_auth', 'uses' => 'ScenarioController@deleteScenarioQuestion'));
//

// // Attachments download
Route::get('/delete/{id}', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\CoursesController@deleteAttachment'));
Route::get('/download/{id}', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\CoursesController@downloadAttachment'));
//
// // SearchController Autocomplete
Route::get('/search/user/{query}', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\SearchController@searchUser'));
Route::get('/search/course/{query}', array('before' => 'members_auth', 'uses' => 'App\Http\Controllers\SearchController@searchCourse'));
//
// // TEST
// Route::get('login', function(){
//         return view('login');
//         });
