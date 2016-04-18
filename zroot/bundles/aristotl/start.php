<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Autoloader::namespaces(array(
    'AristotlM' => Bundle::path('aristotl').'models',
    'AristotlL' => Bundle::path('aristotl').'libraries'
));

Autoloader::map(array(
  'Aristotl_Base_Controller'   => Bundle::path('aristotl').'controllers/base.php',
));