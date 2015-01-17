<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 Route::get('/pages/(:any?)', 'icta::home@pages');
 Route::get('/contact', 'icta::home@contact');
 Route::any('/contactsubmit','icta::api@contactsubmit');
 Route::get('/blogitem/(:any?)', 'icta::home@blog'); 
 
 