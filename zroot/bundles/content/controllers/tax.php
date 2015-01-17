<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Content_Tax_Controller extends Admin_Base_Controller{  
  
  private $main_view;
  private $notification;   
  private $site_title;
  private $data;
  
  public function __construct() {
    parent::__construct();
     Asset::add('validate-js', 'admin_assets/js/plugins/validation/jquery.validate.min.js');
	   Asset::add('additional-js', 'admin_assets/js/plugins/validation/additional-methods.min.js');
     $this->main_view = View::make('admin::index');
     $this->notification = 'admin::partials.notifications';
     $this->site_title = Config::get('admin::config.site_title');
     $this->admin_url =  Config::get('admin::config.admin_url');
  }
  
  public function action_index() {
    $taxs = ContentM\ContentTax::activetaxes()->get();
    $this->data['taxs'] = $taxs;
    $this->_list_data($this->data);
    return $this->main_view;
  }
  
  public function action_submittax(){
    $input = Input::all();
    
    if (!$input) {
      return Redirect::to($this->admin_url.'content/listcategories');
    }
    
    if ( Input::get('delete') ){
      $delete_id = Input::get('id');
      return Redirect::to($this->admin_url.'content/confirmdeletecategory/'.$delete_id);  
    }
    
    $action = Input::get('action');
    $id = Input::get('id');
    
    $rules = array(  
      'title' => 'required|title_check:tax,'.$action.','.$id,
      'status' => 'delete_check:'.$action
    );
    
    $validation = Validator::make($input, $rules, Config::get('admin::rules.validation'));

    $redirect = ( $action == 'edit' ) ? $action.'category/'.$id : $action.'category';
    if ($validation->fails()) {   
      return Redirect::to($this->admin_url.'content/'.$redirect)->with_input()->with_errors($validation);
    }

    $entity = ($action == 'edit') ? ContentM\ContentTax::find(intval($id)) : new ContentM\ContentTax();
    $entity->title = Input::get('title');
    $entity->status = Input::get('status');    
    $entity->guid = str_replace(' ', '-', strtolower(Input::get('title')) );
    
    if ( (Input::get('status') == 'delete') && Input::get('id')) {
      $rel_id = Input::get('id');
      ContentM\ContentRel::where('taxs_id','=',$rel_id)->delete();
    }
   // $entity->status = Input::get('status');
    $entity->save();
    
    return Redirect::to($this->admin_url.'content/listcategories');
    
  }
  
  public function action_editcategory($id=null){
    if($id==null){
      return Redirect::to($this->admin_url.'content/listcategories');
    }
    
    $tax = ContentM\ContentTax::find($id);
    if ( $tax ) {
      $tax_data = $this->_post_data('edit',$tax, $id);
      $edit = View::make('content::editcreatetax')
                  ->with('data', $tax_data);
      $this->main_view->nest('main','admin::partials.center', array('content'  => $edit)); 
      return $this->main_view;     
    } else {
      return Redirect::to($this->admin_url.'content/listcategories');
    }
  }
  
  public function action_createcategory(){
    $tax_data = $this->_post_data('create');
    $create = View::make('content::editcreatetax')
                ->with('data', $tax_data);
    $this->main_view->nest('main','admin::partials.center', array('content'  => $create)); 
    return $this->main_view;    
  }
  
  public function _post_data($action,$tax=null,$id=null){
    	  //Bootbox
     Asset::add('bootbox-js', 'admin_assets/js/plugins/bootbox/jquery.bootbox.js');
     Asset::container('first')->add('content-js','admin_assets/js/content.js');
     
     $form_title =( $action == 'create' ) ? 'Create ': 'Edit ';
     $form_title.= 'Category';

     $tax_data = array();
     $tax_data['form_title'] = $form_title;
     $tax_data['action'] = $action;
     
     if ( $action == 'create'){
       foreach ( $this->inputs['taxs'] as $tax_key => $tax_val) {
         $title = isset($tax_val['title']) ? $tax_val['title'] : null;
         $val = null;
         $selector_id = isset($tax_val['id']) ? $tax_val['id']:null;
         $rules =( isset($tax_val['rules']) && count($tax_val['rules']) > 0 )? $tax_val['rules'] : null;
         $options = (isset($tax_val['options']) ) ? $tax_val['options'] : null;
         if ( $tax_key == 'action'){
           $val = $action;
         }
         $tax_data[$tax_val['type']][$tax_key] =
            Form::content_edit_create($title, $tax_val['name'],$tax_val['type'], $val, $rules,$options, $selector_id);
       }
     } else if ( $action == 'edit') {
       foreach ( $this->inputs['taxs'] as $tax_key => $tax_val) {
         $title = isset($tax_val['title']) ? $tax_val['title'] : null;
         $val = null;
         
         $selector_id = isset($tax_val['id']) ? $tax_val['id']:null;
         $rules =( isset($tax_val['rules']) && count($tax_val['rules']) > 0 )? $tax_val['rules'] : null;
         $options = (isset($tax_val['options']) ) ? $tax_val['options'] : null;
         if ( $tax_key == 'action'){
           $val = $action;
         } else {
           $val = $tax->$tax_key;
         }
         $tax_data[$tax_val['type']][$tax_key] =
            Form::content_edit_create($title, $tax_val['name'],$tax_val['type'], $val, $rules,$options, $selector_id);
       }     
     }
     
     return $tax_data;
  }
  
  public function _list_data($data) {
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
     
     $list = View::make('content::taxlist')->with('data', $data)
                                        ->with('title','Categories');
     $this->main_view->nest('main','admin::partials.center', array('content'=>$list));
  }
  

   private $inputs = array(
       'taxs' => array(
           'title' => array('type' => 'text', 'title' => 'Title', 'name' => 'title',
                   'rules' => array( 'required' => 'true')
               ),
           'id' => array('type' => 'hidden', 'name' => 'id'),
           'action' => array('type'=>'hidden', 'name'=> 'action'),
           'status' => array('type' => 'select', 'title'=> 'Status', 'name'=> 'status',
                   'options' => array (
                     'draft' => 'Draft',
                     'publish' => 'Publish',
                     'delete' => 'Delete'
                 )
               )
       )
   );
}
