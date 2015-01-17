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
  'priv' => array('superuser','is_admin','is_editor'), // required
  'restrict_access' => true, 
  'main_controller' => 'ictacustom',
    
  'title' => 'Custom Content', // required
   
  'root_link' => 'ictacustom',  // required
    
  // Main top sub nav
  'nav_submenu' => array(
      
     'level1' => array(
        //'pages' => array('title' => 'Pages', 'dropdown' => true ),
        'create' => array('title' => 'Create', 'controller_func' => 'create'),
        'list' => array('title' => 'List', 'controller_func' => 'list'),
       // 'menus' => array('title' => 'Menus', 'controller_func' => 'menus'),
     ),
      
     'level2' => array(
         'listpages' => array('parent'=>'pages', 'title' => 'List Pages', 'controller_func' => 'listpages'),
         'createpage' => array('parent'=>'pages', 'title' => 'Create Page', 'controller_func' => 'createpage'),
         'listposts' => array('parent'=>'posts', 'title' => 'List Posts', 'controller_func' => ''),
         'createpost' => array('parent'=>'posts', 'title' => 'Create Post', 'controller_func' => 'createpost'),
         'listcategories' => array('parent'=>'categories', 'title' => 'List Categories', 'controller_func' => 'listcategories'),
         'createcategory' => array('parent'=>'categories', 'title' => 'Create Category', 'controller_func' => 'createcategory'),
     )
  ),    
    
  // Left menu
  'left_menu' => array(
      
    /* 'level1' => array(
        'sublink1' => array('title' => 'Sublink 1', 'dropdown' => true ),
        'sublink2' => array('title' => 'Sublink 2', 'controller_func' => 'home'),
     ),
      
     'level2' => array(
         'sublink3' => array('parent'=>'sublink1', 'title' => 'Sublink 3', 'controller_func' => 'home')
     ),
      
     'left_title' => 'Content'*/
  )
);