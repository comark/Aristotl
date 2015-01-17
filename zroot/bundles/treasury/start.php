<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


Autoloader::namespaces(array(
    'TreasuryM' => Bundle::path('treasury').'models',
    'TreasuryL' => Bundle::path('treasury').'libraries'
));

Autoloader::map(array(
  'Treasury_Base_Controller'   => Bundle::path('treasury').'controllers/base.php',
));