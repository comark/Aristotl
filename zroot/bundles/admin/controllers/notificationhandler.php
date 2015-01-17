<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_NotificationHandler_Controller extends Admin_Base_Controller{
  
    private $main_view;
    private $title = 'Message Center';
    private $user;
    private $admin_url;
    public function __construct() {

       parent::__construct();
       Asset::add('jquery-validate-js','admin_assets/js/plugins/validation/jquery.validate.min.js');
       Asset::add('jquery-additional-methods-js','admin_assets/js/plugins/validation/additional-methods.min.js');
       $this->main_view = View::make('admin::index');
       $this->main_view->nest('center_top', 'admin::partials.centertop', array('title'=> $this->title));
       $this->main_view->with('page_title', $this->title );
       $this->user = Sentry::user();
       $this->admin_url =  Config::get('admin::config.admin_url');
    }

    public function action_index() {
      return Redirect::to($this->admin_url.'notimessages');
    }
    
    public function action_viewsingle($id){
       $noti = Admin\Models\Notifications::mark_read_single($id, $this->user->id);
       
       if ($noti) {

         return $this->main_view;
       } else {
         //redirect to message centre
         return Redirect::to($this->admin_url.'notimessages');
       }
    }
    
    public function action_viewall(){
      $this->_list_messages($this->user->id);
      return $this->main_view;
    }
    
    
    private function _list_messages($user_id){
     Asset::add('imageloaded-js', 'admin_assets/js/plugins/imagesLoaded/jquery.imagesloaded.min.js');
     Asset::add('slimscroll-js','admin_assets/js/plugins/slimscroll/jquery.slimscroll.min.js');
     Asset::add('bootbox-js','admin_assets/js/plugins/bootbox/jquery.bootbox.js');
	   //dataTables 
	   Asset::add('datatables-js','admin_assets/js/plugins/datatable/jquery.dataTables.min.js');
	   Asset::add('tabletools-js','admin_assets/js/plugins/datatable/TableTools.min.js');
	   Asset::add('colreorder-js','admin_assets/js/plugins/datatable/ColReorder.min.js');
	   Asset::add('colvis-js','admin_assets/js/plugins/datatable/ColVis.min.js');
	   Asset::add('columnfilter-js','admin_assets/js/plugins/datatable/jquery.dataTables.columnFilter.js');
	   //Chosen
	   Asset::add('chosen-js','admin_assets/js/plugins/chosen/chosen.jquery.min.js');
     // Color box
     Asset::add('colorbox-js','admin_assets/js/plugins/colorbox/jquery.colorbox-min.js');
     
     //CSS
     Asset::add('tabletools-css','admin_assets/css/plugins/datatable/TableTools.css');
     Asset::add('colorbox-css','admin_assets/css/plugins/colorbox/colorbox.css');
     Asset::add('chosen-css','admin_assets/css/plugins/chosen/chosen.css');
     
     $notis = Admin\Models\Notifications::get_all_notis($user_id)->get();
     $messages = View::make('admin::partials.messageslist')
                  ->with('data', $notis);
     $this->main_view->nest('main','admin::partials.center', array('content'  => $messages)); 
    }
}