<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Treasury_Base_Controller extends Controller{
    public function __construct() {
        parent::__construct();
        $first = Asset::container('first');
        $middle = Asset::container('middle');
        $last = Asset::container('last');
        
        $first->add('bootstrap-css', 'treasury/css/bootstrap.min.css'); 
        $first->add('font-awesome-css','treasury/font-awesome/css/font-awesome.min.css');
        $first->add('animations-css','treasury/css/animate.min.css');
        $first->add('flexisel-css','treasury/css/flexisel.css');
        $first->add('owl.carousel-css','treasury/css/owl.carousel.css');        
        
        /***** Work ***/
        
        $middle->add('prettyphoto-css','treasury/css/prettyPhoto.css');
        $middle->add('ytplayer-css','treasury/css/YTPlayer.css');
        $middle->add('flaticon-css','treasury/css/flaticon.css');
        $middle->add('color_panel-css','treasury/css/color_panel.css');
        $middle->add('treasury-css','treasury/css/color-schemes/treasury.css');
        $middle->add('style-css','treasury/css/style.css');
        $middle->add('responsive-css','treasury/css/responsive.css');
        
        
        /***js **/
        $first->add('jquery-js', 'treasury/js/jquery-1.11.1.min.js');
        $first->add('bootstrap-js', 'treasury/js/bootstrap.min.js');
        $first->add('bootstrapv-js', 'treasury/js/bootstrapValidator.min.js');
        $first->add('bootstrap-hover-js', 'treasury/js/bootstrap-hover-dropdown.min.js');
        
        $middle->add('owlcarousel-js','treasury/js/owl.carousel.min.js');
        $middle->add('sticky-js','treasury/js/jquery.sticky.js');
        $middle->add('carousel-js','treasury/js/carousel.min.js');
        $middle->add('fractionslider-js','treasury/js/slider/jquery.fractionslider.js');
        $middle->add('slider-js','treasury/js/slider/main.js');
        $middle->add('prettyphoto-js','treasury/js/jquery.prettyPhoto.js');
        $middle->add('flexslider-js','treasury/js/jquery.flexslider-min.js');
        $middle->add('contentslider-js','treasury/js/jquery.content_slider.js');
        $middle->add('tweetcarousel-js','treasury/js/tweet/carousel.js');
        $middle->add('scripts-js','treasury/js/tweet/scripts.js');
        $middle->add('tweetie-js','treasury/js/tweet/tweetie.min.js');
        $middle->add('easypie-js','treasury/js/jquery.easypiechart.min.js');
        $middle->add('effect-js','treasury/js/effect.js');
        $middle->add('color-js','treasury/js/color-panel.js');
        
        $middle->add('YTPlayer-js','treasury/js/jquery.mb.YTPlayer.js');
        $middle->add('appear-js','treasury/js/jquery.appear.js');
        $middle->add('custom-js','treasury/js/custom.js');
        
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