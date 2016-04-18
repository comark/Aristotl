<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Aristotl_Base_Controller extends Controller{
    public function __construct() {
        parent::__construct();
        $first = Asset::container('first');
        $middle = Asset::container('middle');
        $last = Asset::container('last');
        
        $first->add('bootstrap-css', 'aristotl/css/bootstrap.min.css'); 
        $first->add('font-awesome-css','aristotl/font-awesome/css/font-awesome.min.css');
        $first->add('animations-css','aristotl/css/animate.min.css');
        $first->add('flexisel-css','aristotl/css/flexisel.css');
        $first->add('owl.carousel-css','aristotl/css/owl.carousel.css');        
        
        /***** Work ***/
        
        $middle->add('prettyphoto-css','aristotl/css/prettyPhoto.css');
        $middle->add('ytplayer-css','aristotl/css/YTPlayer.css');
        $middle->add('flaticon-css','aristotl/css/flaticon.css');
        $middle->add('color_panel-css','aristotl/css/color_panel.css');
        $middle->add('aristotl-css','aristotl/css/color-schemes/aristotl.css');
        $middle->add('style-css','aristotl/css/style.css');
        $middle->add('responsive-css','aristotl/css/responsive.css');
        
        
        /***js **/
        $first->add('jquery-js', 'aristotl/js/jquery-1.11.1.min.js');
        $first->add('bootstrap-js', 'aristotl/js/bootstrap.min.js');
        $first->add('bootstrapv-js', 'aristotl/js/bootstrapValidator.min.js');
        $first->add('bootstrap-hover-js', 'aristotl/js/bootstrap-hover-dropdown.min.js');
        
        $middle->add('owlcarousel-js','aristotl/js/owl.carousel.min.js');
        $middle->add('sticky-js','aristotl/js/jquery.sticky.js');
        $middle->add('carousel-js','aristotl/js/carousel.min.js');
        $middle->add('fractionslider-js','aristotl/js/slider/jquery.fractionslider.js');
        $middle->add('slider-js','aristotl/js/slider/main.js');
        $middle->add('prettyphoto-js','aristotl/js/jquery.prettyPhoto.js');
        $middle->add('flexslider-js','aristotl/js/jquery.flexslider-min.js');
        $middle->add('contentslider-js','aristotl/js/jquery.content_slider.js');
        $middle->add('tweetcarousel-js','aristotl/js/tweet/carousel.js');
        $middle->add('scripts-js','aristotl/js/tweet/scripts.js');
        $middle->add('tweetie-js','aristotl/js/tweet/tweetie.min.js');
        $middle->add('easypie-js','aristotl/js/jquery.easypiechart.min.js');
        $middle->add('effect-js','aristotl/js/effect.js');
        $middle->add('color-js','aristotl/js/color-panel.js');
        
        $middle->add('YTPlayer-js','aristotl/js/jquery.mb.YTPlayer.js');
        $middle->add('appear-js','aristotl/js/jquery.appear.js');
        $middle->add('custom-js','aristotl/js/custom.js');
        
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