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
	// if (Auth::guest()) return Redirect::guest('login');
	if (Auth::guest()) return Redirect::to('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic('username');
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
	if (Auth::check()) return Redirect::route('home')
                        ->with('flash_notice', 'You are already logged in!');
});

/*
|--------------------------------------------------------------------------
| Role Permissions
|--------------------------------------------------------------------------
|
| Access filters based on roles.
|
*/

// Check for role on all admin routes
// Entrust::routeNeedsRole( 'control*', array('control'), Redirect::to('control/login') );

// Check for permissions on admin actions
// Entrust::routeNeedsPermission( 'admin/blogs*', 'manage_blogs', Redirect::to('/admin') );
// Entrust::routeNeedsPermission( 'admin/comments*', 'manage_comments', Redirect::to('/admin') );
// Entrust::routeNeedsPermission( 'admin/users*', 'manage_users', Redirect::to('/admin') );
// Entrust::routeNeedsPermission( 'admin/roles*', 'manage_roles', Redirect::to('/admin') );

Route::filter('admin', function()
{
    if ( !Entrust::hasRole('Admin') ) return Redirect::to('control/login');
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


