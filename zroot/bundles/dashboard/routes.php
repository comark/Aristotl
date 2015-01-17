<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$admin_url = Config::get('admin::config.admin_url');

Route::get($admin_url.'dashboard', 'dashboard::home@index');
Route::get($admin_url.'dashboard/home', 'dashboard::home@index');
Route::get($admin_url.'dashboard/cforms/add/(:num)','dashboard::cforms@add');
Route::any($admin_url.'dashboard/cforms/datasubmit/(:any?)','dashboard::cforms@datasubmit');
