<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Autoloader::namespaces(array(
    'IctaM' => Bundle::path('icta').'models',
    'IctaL' => Bundle::path('icta').'libraries'
));

Autoloader::map(array(
  'Icta_Base_Controller'   => Bundle::path('icta').'controllers/base.php',
));