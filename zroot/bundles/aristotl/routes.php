<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 Route::get('/pages/(:any?)', 'aristotl::home@pages');
 Route::get('/contact', 'aristotl::home@contact');
 Route::any('/contactsubmit','aristotl::api@contactsubmit');
 Route::get('/blogitem/(:any?)', 'aristotl::home@blog'); 
 Route::get('/type/(:any?)/(:any?)', 'aristotl::home@customsingle'); 
 