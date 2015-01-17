<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$admin_url = Config::get('admin::config.admin_url');
Route::get($admin_url.'users', 'users::home@index');
Route::get($admin_url.'users/allusers', 'users::home@allusers');

Route::get($admin_url.'users/create', 'users::home@create');
Route::any($admin_url.'users/edit/(:num)', 'users::home@edit');

Route::any($admin_url.'users/submit/(:all?)','users::home@submit'); 
Route::any($admin_url.'users/confirmdelete/(:num)','users::home@confirmdelete'); 
Route::any($admin_url.'users/delete/(:all?)','users::home@delete'); 
