<?php

class Admin_Base_Controller extends Controller {

    public function __construct()
    {
      
        $first = Asset::container('first');
        $last = Asset::container('last');
        //Main jQuery
        $first->add('jquery', 'admin_assets/js/jquery.min.js');
        $first->add('nicescroll-js', 'admin_assets/js/plugins/nicescroll/jquery.nicescroll.min.js');
        
        if(Sentry::check() ){
        // jQuery-UI
        $first->add('jquery-ui-core-js', 'admin_assets/js/plugins/jquery-ui/jquery.ui.core.min.js');
        $first->add('jquery-ui-widget-js','admin_assets/js/plugins/jquery-ui/jquery.ui.widget.min.js');
        $first->add('jquery-ui-mouse-js','admin_assets/js/plugins/jquery-ui/jquery.ui.mouse.min.js');
        $first->add('jquery-ui-draggable-js','admin_assets/js/plugins/jquery-ui/jquery.ui.draggable.min.js');
        $first->add('jquery-ui-resizable-js','admin_assets/js/plugins/jquery-ui/jquery.ui.resizable.min.js');
        $first->add('jquery-ui-sortable-js','admin_assets/js/plugins/jquery-ui/jquery.ui.sortable.min.js');
         // Tablets 
        
        Asset::add('jquery-touch-enabled-js','admin_assets/js/plugins/touch-punch/jquery.touch-punch.min.js');
        Asset::add('jquery-slimscroll-js','admin_assets/js/plugins/slimscroll/jquery.slimscroll.min.js');                   //Form
        Asset::add('form-js', 'admin_assets/js/plugins/form/jquery.form.min.js');      
        //css
        
        $first->add('jquery-ui-css', 'admin_assets/css/plugins/jquery-ui/smoothness/jquery-ui.css');
        $first->add('jquery-ui-theme-css', 'admin_assets/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css'); 

        // Theme Scripts
        $last->add('scripts-js','admin_assets/js/application.js');
        
        // Just for demonstration
        $last->add('demonstration-js','admin_assets/js/demonstration.js');
        }     

        

        
        // Bootstrap js
        Asset::add('bootstrap-js', 'admin_assets/js/bootstrap.min.js');
         // iCheck js
        Asset::add('icheck-js', 'admin_assets/js/plugins/icheck/jquery.icheck.min.js');
        // Theme Framework
        Asset::container('last')->add('framework-js','admin_assets/js/eakroko.js');
       
        // CSS
        Asset::container('first')
                ->add('bootstrap-css', 'admin_assets/css/bootstrap.min.css');
        Asset::container('first')
                ->add('bootstrap-css-responsive', 'admin_assets/css/bootstrap-responsive.min.css', 'bootstrap-css');

        Asset::add('icheck-css','admin_assets/css/plugins/icheck/all.css');        
        Asset::container('last')->add('style-css', 'admin_assets/css/style__not-minified.css');
        Asset::container('last')->add('color-css','admin_assets/css/themes.css');
        parent::__construct();

        //Filters
        $class = get_called_class();
        
        
        switch($class) {
            case 'Admin_Home_Controller':
                $this->filter('before', 'adminnonauth');
                break;   
            case 'Admin_User_Controller':               
                $this->filter('before', 'adminsentry')->only(array('xlogout'));
                $this->filter('before', 'adminnonauth')->except(array('xlogout'));
                break;
            case 'Admin_Setup_Controller':
                break;
            default:
                $this->filter('before', 'adminsentry');
                break;
        }
    }
    
	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters){
		return Response::error('404');
	}
    
  public function logRequest() {
    $route = Request::route();
    Log::log('request', "Controller: {$route->controller} / Action: {$route->controller_action} called at ". date('Y-m-d H:i:s'));
  }
}