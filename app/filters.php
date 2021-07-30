<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


/* Custom Filter */

Route::filter('members_auth',function()
{
	if(!Sentry::check()){
		return Redirect::to('/login');
	}
});

Route::filter('check_auth',function()
{
	if(Sentry::check()){
		return Redirect::to('/');
	}
});

Route::filter('hasAccess', function($route, $request, $value)
{
	 try
	 {
	 	$user = Sentry::getUser();

	 	if( ! $user->hasAccess($value) )
	 	{
	 		return Redirect::to('/')->withErrors(array(Lang::get('You do not have sufficient permissions to access this page.')));
	 	}
	 } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
	 	return Redirect::to('/')->withErrors(array(Lang::get('User does not exist.')));
	 }
});

Route::filter('hasUserAccess', function($route, $request)
{
	try
	 {
	 	$user = Sentry::getUser();

	 	if( $route->parameter('userId') != $user->id && !$user->hasAccess('admin') )
	 	{	
	 		return Redirect::to('/')->withErrors(array(Lang::get('You do not have sufficient permissions to access this page.')));
	 	} 
	 } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
	 	return Redirect::to('/')->withErrors(array(Lang::get('User does not exist.')));
	 }
});

Route::filter('check_enroll', function($route, $request)
{
	try
	 {
	 	$user = Sentry::getUser();
	 	$courseId = $route->parameter('id');

	 	$enrollment = Enrollment::where('course_id',$courseId)->where('user_id', $user->id)->first();

	 	if( !$enrollment )
	 	{	
	 		return Redirect::to('/courses/list')->withErrors(array(Lang::get('You do not have sufficient permissions to access this page.')));
	 	} 
	 } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
	 	return Redirect::to('/courses/list')->withErrors(array(Lang::get('User does not exist.')));
	 }
});

Route::filter('check_assign', function($route, $request)
{
	try
	 {
	 	$user = Sentry::getUser();
	 	$assignId = $route->parameter('id');

	 	$assignment = Assignment::leftJoin('enrollment', function($join) {
									$join->on('assignment.enrollment_id', '=', 'enrollment.id');
								})->where('user_id', $user->id)
	 							->where('assignment.id', '=', $assignId)	
	 							->first();

	 	if( !$assignment )
	 	{	
	 		return Redirect::to('/assignments/list')->withErrors(array(Lang::get('You do not have sufficient permissions to access this page.')));
	 	} 
	 } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
	 	return Redirect::to('/assignments/list')->withErrors(array(Lang::get('User does not exist.')));
	 }
});

