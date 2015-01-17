<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$admin_url = Config::get('admin::config.admin_url');

Route::get($admin_url.'content', 'content::home@index');
Route::get($admin_url.'content/createpost', 'content::home@createpost');
Route::get($admin_url.'content/createpage', 'content::home@createpage');

Route::get($admin_url.'content/editpost/(:num)', 'content::home@editpost');
Route::get($admin_url.'content/editpage/(:num)', 'content::home@editpage');

Route::any($admin_url.'content/submit/(:all?)', 'content::home@submit');
Route::get($admin_url.'content/confirmdelete/(:num)', 'content::home@confirmdelete');
Route::any($admin_url.'content/delete/(:all?)', 'content::home@delete');

Route::any($admin_url.'content/listposts/(:all?)', 'content::home@listposts');
Route::any($admin_url.'content/listpages/(:all?)', 'content::home@listpages');

Route::get($admin_url.'content/listcategories', 'content::tax@index');
Route::get($admin_url.'content/createcategory', 'content::tax@createcategory');
Route::get($admin_url.'content/editcategory/(:num)', 'content::tax@editcategory');
Route::any($admin_url.'content/submittax/(:all?)', 'content::tax@submittax');


