<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ICTA_Base_Controller extends Controller{
    public function __construct() {
        parent::__construct();
        $first = Asset::container('first');
        $middle = Asset::container('middle');
        $last = Asset::container('last');
        
        $first->add('reset-css', 'icta/css/reset.css');
        $first->add('style-css', 'icta/css/style.css'); 
        $first->add('font-awesome-css','icta/css/font-awesome/css/font-awesome.min.css');
        $first->add('simpleline-css','icta/simpleline-icons/simple-line-icons.css');
        $first->add('animations-css','icta/js/animations/css/animations.min.css');
        $first->add('responsive-css','icta/css/responsive-leyouts.css');
        $first->add('shortcodes-css','icta/css/shortcodes.css');
        
        
        $middle->add('bootstrap-css','icta/js/mainmenu/bootstrap.min.css');
        $middle->add('menu-css','icta/js/mainmenu/menu.css');
        $middle->add('slidepanel-css','icta/js/slidepanel/slidepanel.css');
        $middle->add('masterslider-css','icta/js/masterslider/style/masterslider.css');
        $middle->add('style-css','icta/js/masterslider/skins/default/style.css');
        $middle->add('owl.transitions-css','icta/js/carouselowl/owl.transitions.css');
        $middle->add('owl.carousel-css','icta/js/carouselowl/owl.carousel.css');
        $middle->add('component-css','icta/js/iconhoverefs/component.css');
        $middle->add('bacslider-css','icta/js/basicslider/bacslider.css');
        $middle->add('cubeportfolio-css','icta/js/cubeportfolio/cubeportfolio.min.css');
        $middle->add('flexslider-css','icta/js/flexslider/flexslider.css');
        $middle->add('skin-css','icta/js/flexslider/skin.css');
        $middle->add('responsive-tabs3-css','icta/js/tabs/assets/css/responsive-tabs3.css');
        $middle->add('accordion-css','icta/js/accordion/style.css');
        
        $first->add('jquery-js', 'icta/js/universal/jquery.js');
        $first->add('classyloader-js', 'icta/js/classyloader/jquery.classyloader.min.js');
        
        
        $middle->add('animations-js','icta/js/animations/js/animations.min.js');
        $middle->add('slidepanel-js','icta/js/slidepanel/slidepanel.js');
        $middle->add('bootstrap-js','icta/js/mainmenu/bootstrap.min.js');
        $middle->add('customeUI-js','icta/js/mainmenu/customeUI.js');
        $middle->add('easing-js','icta/js/masterslider/jquery.easing.min.js');
        $middle->add('masterslider-js','icta/js/masterslider/masterslider.min.js');
        
        $middle->add('scrolltotop-js','icta/js/scrolltotop/totop.js');
        $middle->add('sticky-js','icta/js/mainmenu/sticky-main.js');
        $middle->add('mainmenu-js','icta/js/mainmenu/modernizr.custom.75180.js');
        $middle->add('cubeportfolio-js','icta/js/cubeportfolio/jquery.cubeportfolio.min.js');
        $middle->add('cubeportfolio-main-js','icta/js/cubeportfolio/main.js');
        $middle->add('cubeportfolio-main2-js','icta/js/cubeportfolio/main2.js');
        $middle->add('flexslider-js','icta/js/flexslider/jquery.flexslider.js">');
        $middle->add('flexslider-custom-js','icta/js/flexslider/custom.js');
        $middle->add('carouselowl-js','icta/js/carouselowl/owl.carousel.js');
        $middle->add('basicslider-js','icta/js/basicslider/bacslider.js');
        $middle->add('responsive-js','icta/js/tabs/assets/js/responsive-tabs.min.js');
        $middle->add('accordion-js','icta/js/accordion/jquery.accordion.js');
        $middle->add('accordion-custom-js','icta/js/accordion/custom.js');
        $middle->add('universal-js','icta/js/universal/custom.js');
        
        
        $class = get_called_class();
        
         
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