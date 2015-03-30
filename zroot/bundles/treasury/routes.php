<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 Route::get('/pages/(:any?)', 'treasury::home@pages');
 Route::get('/contact', 'treasury::home@contact');
 Route::any('/contactsubmit','treasury::api@contactsubmit');
 Route::get('/blogitem/(:any?)', 'treasury::home@blog'); 
 Route::get('/type/(:any?)/(:any?)', 'treasury::home@customsingle'); 
 