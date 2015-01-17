<?php

class Dashboard_Home_Controller extends Admin_Base_Controller
{    
  
    private $main_view;
    private $notification;
    private $msg_email;
    private $msg_name;   
    private $site_title;     
    private $data;
    private $sections = array();
    public function __construct() {
      parent::__construct();
      $this->main_view = View::make('admin::index');
      $this->notification = 'admin::partials.notifications';
      $this->msg_email = Config::get('admin::mail.outgoing.email');
      $this->msg_name = Config::get('admin::mail.outgoing.name');
      $this->site_title = Config::get('admin::config.site_title');       
    }
    
    public function action_index() {
        
      $query = ICTACustomL\Helper::paginate_custom();
      $this->data['posts'] = $query['data'];
      $this->data['pagination'] = $query['pagination'];
      $list = ICTACustomL\Helper::list_data($this->data,'All Custom Posts');
      $this->main_view->nest('main','admin::partials.center', array('content'=>$list));
      
      $notes = Session::get('notes');
      if ($notes){ 
        $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notes));
      }      
      return $this->main_view;  
      

    }
    

}