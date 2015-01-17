<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$admin_url = Config::get('admin::config.admin_url');

Route::get($admin_url.'ictacustom', 'ictacustom::home@index');
Route::get($admin_url.'ictacustom/create', 'ictacustom::home@create');
Route::any($admin_url.'ictacustom/createtype/(:any)', 'ictacustom::home@createtype');
Route::any($admin_url.'ictacustom/initsubmit', 'ictacustom::home@initsubmit');
Route::any($admin_url.'ictacustom/typesubmit', 'ictacustom::home@typesubmit');
Route::get($admin_url.'ictacustom/list', 'ictacustom::home@listall');
Route::any($admin_url.'ictacustom/filtersubmit', 'ictacustom::home@listfiltered');
Route::any($admin_url.'ictacustom/edit/(:any)/(:num)', 'ictacustom::home@edit');
Route::any($admin_url.'ictacustom/editsubmit', 'ictacustom::home@editsubmit');
Route::get($admin_url.'ictacustom/confirmdelete/(:num)', 'ictacustom::home@confirmdelete');
Route::any($admin_url.'ictacustom/delete', 'ictacustom::home@delete');