<?php

/*
 * links and titles of menus
 *  Required array definition
 *  1. 'title' : Title of the menu
 *  2. 'root_link' : Should match the bundle handle slug as defined in the main bundle.php file
 *  3. 'nav_submenu' :
 *     'left_menu'   : 
 *    a) level1 : second level menu
 *       either
 *       i)  set the title and dropdown value which has a sub level of its own
 *       ii) set the title and its controller_func map to the controller and method
 *           in the bundle controller/method
 *    b) level2: third level menu
 *       i)   has parent name which should match the key on level1 array
 *       ii)  has title
 *       iii) has controller_func mapping to the controller and method in the 
 *            bundle controller/method 
 *    c) 'left_title' : left title
 *    d) 'privs': privileges 
 *    e) 'main_controller' : set the main controller for routing purposes     
 */

return array(
  'priv' => array('superuser','is_admin','is_editor', 'is_user'), // required
   
  'main_controller' => 'dashboard',
  'title' => 'Dashboard', // required
   
  'root_link' => 'dashboard',  // required
    
  // Main top sub nav
  'nav_submenu' => array(
            
     'level1' => array(
        'home' => array('title' => 'Home', 'controller_func' => 'home'),
     ),
  ),    
    
  // Left menu
  'left_menu' => array()
);