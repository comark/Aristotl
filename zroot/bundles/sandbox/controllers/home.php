<?php

class Sandbox_Home_Controller extends Admin_Base_Controller
{    
  
    public function __construct() {
      parent::__construct();
    }
    
    public function action_index()
    {
       $view = View::make('admin::index');
       $view->nest('main','admin::partials.center');
       return $view;
    }

}