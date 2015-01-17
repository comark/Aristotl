<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*Route::get('/', array('as' => 'home', function() {
     return Redirect::to('admin/user/login');
}));
*/

// carry checks for domain here
$admin_url = Config::get('admin::config.admin_url');
$admin_routes = array( 'xlogin', 'xactivate', 'xauthenticate', 'xconfirmation','xforgotpassword',
      'index','xlogout','xnotifications', 'xregister','xreset','xsignupform');

$profile_routes = array('xupdate','index','xchangepassword');

foreach ( $admin_routes as $aroute ) {
  //$aroute = $aroute.'/(:all?)';
  $aroute_orig = $aroute;
  if ( $aroute == 'xactivate' || $aroute =='xconfirmation') {   
    $aroute = $aroute.'/(:any)/(:any)';
  }
  Route::any($admin_url.$aroute,'admin::user@'.$aroute_orig);
}

Route::get($admin_url.'xprofile','admin::profile@index');
foreach ( $profile_routes as $proute ){
  $func = $proute;
  $proute = 'xprofile/'.$proute.'/(:all?)';    
  Route::any($admin_url.$proute,'admin::profile@'.$func); 
}

Route::any($admin_url.'notihandler/(:num)','admin::notificationhandler@viewsingle');
Route::any($admin_url.'notimessages','admin::notificationhandler@viewall');
Route::get($admin_url.'setup', 'admin::setup@start');
Route::any($admin_url.'setupsubmit', 'admin::setup@submit');


Route::filter('before', function(){
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	//if (Request::forged()) return Response::error('500');
});

Route::filter('adminnonauth', function() {
    $admin_url = Config::get('admin::config.admin_url');  
    $users = Sentry\Sentry::user()->all();
    if (!$users) {
      return Redirect::to($admin_url.'setup');
    }    

    if( Sentry::check() && Sentry::user()->has_access('superuser') ){
      return Redirect::to($admin_url.'dashboard');
    }
    
    // for all other users do Sentry check and redirect them either to dashboard
    // or respective modules

});

Route::filter('adminsentry', function() {
    $admin_url = Config::get('admin::config.admin_url');
    if ( !Sentry::check()  ) {
      $uri =URI::current();
      return Redirect::to($admin_url.'xlogin?redirect='.$uri);
    } 
});


View::composer( 'admin::index', function( $view ) {
  $bundles = Bundle::names();
  $all = Bundle::all();
  
  // Get URL segments
  $segs = explode("/", str_replace(URL::base(),"", URL::current()));  

  $menu = array();
  $title;
  $active_title='';
 
  foreach ($bundles as $bundle_key => $bundle_name) {
   
    // Get all the necessary menu links and config settings for the bundle
    $title = Config::get($bundle_name.'::main.title');
    $root_link = Config::get($bundle_name.'::main.root_link');
    $nav_submenu = Config::get($bundle_name.'::main.nav_submenu');
    $left_menu = Config::get($bundle_name.'::main.left_menu');
    $privs = Config::get($bundle_name.'::main.priv');
    $priv_count = 0;  
    
    /* Only set vars if title and root link are available
     * as they are the first point of entry into url-available
     * bundle.     * 
     */
    if ( $title && $root_link ) {
      
      /* we should check for privileges
       * so that users with none of the assigned
       * privileges do not see any links
       */
      foreach ($privs as $priv_val ){
        if ( Sentry::user()->has_access($priv_val) ) {
          $priv_count = $priv_count+1;
          
        }
      }
      
      // if the user has a priv level but cannot access a restricted module set
      // the prive count explicitly to 0
      
      $restricted_access = Config::get($bundle_name.'::main.restrict_access');
      $user = Sentry::user();
      $user_id = $user->get('id');
      if ( $restricted_access && ($user_id != '1' )) {
        $ra_count = 0;
        $user_ra = $user->get('metadata.restricted_access');
        
        if ($user_ra) {
         $user_ra_unserialize = unserialize($user_ra);
         foreach ($user_ra_unserialize as $ra_key => $ra_val ) {
            if ($ra_val == $bundle_name) {
              $ra_count++;
            }
         }
        }
        if ($ra_count == 0) {
          $priv_count = 0;
        }
      }
      
      /*
       *  If the $priv_count is greater than 0, the user has at least one
       *  of the assigned privs and so we can display the menus
       */
      if ( $priv_count > 0 ) {
         $menu[$bundle_name]['title'] = $title;
         $menu[$bundle_name]['root_link'] = $root_link;
         $menu[$bundle_name]['sub_menu'] = $nav_submenu  ;
         $menu[$bundle_name]['left_menu'] = $left_menu;
      }
      
      /*
       *  We also need to display the active menu to the user when they access
       *  it
       */
      
      if ($bundle_name == $segs[2] ) {
        $menu[$bundle_name]['active'] = 1;
        $active_title = $title;
        
        /* if the user access this bundle and does not have privileges
         * presumably they will have bookmarked the page earlier or
         *  have typed the url on the address bar
         */
        if( $priv_count == 0 ) {
          // sorry you do not have permissions to see what is under the hood
          $notifications = array();
          $notifications['class'] = 'error';
          $notifications['msg'] = 'You are trying to access sections that you do not have access to.';
          $view->nest('no_access', 'admin::partials.notifications', array('msg' => $notifications));
         }
      }
    }
  }
  
  if ( $active_title ){
    $view->with('page_title', $active_title );
    $view->nest('center_top', 'admin::partials.centertop', array('title'=>$active_title));
  }
  $user = Sentry::user();
  $user_id = $user->get('id');
  //$messages = Admin\Models\Notifications::get_notices($user_id)->get();
  //$view->nest('user_messages', 'admin::partials.usermessages', array('count' => count($messages), 'messages' => $messages) );
  $view->nest('user','admin::partials.user');  
  $view->nest('nav', 'admin::partials.nav', array('top_menu' => $menu) );
  $view->nest('left_hook','admin::partials.lefthook', array('left_menu' => $menu));
  //$view->nest('top_hidden', 'admin::partials.tophidden');

  // Explicitly set privilege for admin links
  if ( Sentry::user()->has_access('superuser') ) {
    $view->nest('left_admin','admin::partials.leftadmin');
  }
});

