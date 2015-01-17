<?php

class Www_Base_Controller extends Controller {

    public function __construct()
    {
     parent::__construct();
     $first = Asset::container('first');
     $middle = Asset::container('middle');
     $last = Asset::container('last');

       //Filters
     $class = get_called_class();
        
        switch($class) {

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