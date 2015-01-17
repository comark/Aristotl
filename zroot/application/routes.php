<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/


/*
Route::get('/', function()
{
	return View::make('home.index');
});
*/

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application. The exception object
| that is captured during execution is then passed to the 500 listener.
|
*/


Event::listen('404', function()
{
  $server_listen = explode('.', Request::server('SERVER_NAME'));  
  $admin = in_array('admin', $server_listen);
  $admin_url = Config::get('admin::config.admin_url');
  if ($admin) {
    return Response::error('404');
  } else {
    return Redirect::to($admin_url.'pages/notfound');
  }
});

Event::listen('500', function($exception)
{
    return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/
//Route::get('/', 'admin::user@adminlogin');

$server = explode('.', Request::server('SERVER_NAME'));


$docs =in_array('docs', $server);
if ($docs) {
   Route::get('/', function(){
    return Redirect::to('ardocs');
  });     
}else {
    
 Route::get('/', 'treasury::home@index');    
 Route::get('/xadmin', function(){
   $admin_url = Config::get('admin::config.admin_url');
   return Redirect::to($admin_url.'xlogin');
 });
 
 Route::get('/xadmin/pages/notfound', 'treasury::home@404');  
} 

