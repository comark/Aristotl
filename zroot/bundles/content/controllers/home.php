<?php

class Content_Home_Controller extends Admin_Base_Controller
{    
  
    private $main_view;
    private $notification;   
    private $site_title;
    private $data;
    private $admin_url;
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
      $posts = ContentM\ContentPost::posts_active()->get();
      $this->data['posts'] = $posts;
      $this->_list_data($this->data,'Posts');
      return $this->main_view;
    }
    
    public function action_listposts(){
      $posts = ContentM\ContentPost::posts_active()->get();
      $this->data['posts'] = $posts;
      $this->_list_data($this->data,'Posts');
      return $this->main_view;
    }
    
    public function action_listpages() {
      $posts = ContentM\ContentPost::pages_active()->get();
      $this->data['posts'] = $posts;
      $this->_list_data($this->data,'Pages');
      return $this->main_view;
    }
    
    public function action_createpost() {
     $post_data = $this->_post_data('create','post');
     $create = View::make('content::editcreatepost')
                  ->with('data', $post_data);
     $this->main_view->nest('main','admin::partials.center', array('content'  => $create)); 
     return $this->main_view; 
    }
    
    public function action_createpage() {
     $post_data = $this->_post_data('create','page');
     $create = View::make('content::editcreatepost')
                  ->with('data', $post_data);
     $this->main_view->nest('main','admin::partials.center', array('content'  => $create)); 
     return $this->main_view; 
    }
    
    public function action_editpost($id=null){
      
     if ($id == null) {
       return Redirect::to('content');
     }
     $post_data = $this->_post_data('edit','post', $id);
     $create = View::make('content::editcreatepost')
                  ->with('data', $post_data);
     $this->main_view->nest('main','admin::partials.center', array('content'  => $create)); 
     return $this->main_view;      
    }
    
    public function action_editpage($id=null){
      
     if ($id == null) {
       return Redirect::to('content');
     }
     $post_data = $this->_post_data('edit','page', $id);
     $create = View::make('content::editcreatepost')
                  ->with('data', $post_data);
     $this->main_view->nest('main','admin::partials.center', array('content'  => $create)); 
     return $this->main_view;      
    }
    
    public function action_submit(){
      $data = array();    
      $input = Input::all();
      
      if ( !$input ) {
       return Redirect::to($this->admin_url.'content');
      }
      
      if ( Input::get('delete') ){
        $delete_id = Input::get('post_id');
        return Redirect::to($this->admin_url.'content/confirmdelete/'.$delete_id);  
      }
      $action = Input::get('action');
      $type = Input::get('type');
      $id = Input::get('post_id');
      
      $rules = array(  
        'title' => 'required|title_check:'.$type.','.$action.','.$id,
        'content' => 'required',
        'status' => 'delete_check:'.$action,
        'image' => 'image|max:4000|mimes:jpg,gif,png'          
      );
     
      
      $validation = Validator::make($input, $rules, Config::get('admin::rules.validation'));    
     
      $redirect = $action == 'edit' ? $action.$type.'/'.$id : $action.$type;
      if ($validation->fails()) {
        
        return Redirect::to($this->admin_url.'content/'.$redirect)->with_input()->with_errors($validation);
      }
      
      // get the action and type
      $post = null;
      if ( $action == 'create') {
        $post = $this->_create_data($input,$type);
      } else if ($action == 'edit') {
        $post = $this->_edit_data($input,$type);
      }
      
      if (is_array($post)) {
         if (isset($post['errors'])){
           return Redirect::to($this->admin_url.'content/'.$redirect)->with('myerrors', $post['errors']);
         } else if (isset($post['success'])) {
          $notifications = array();
          $notifications['class'] = 'success';          
          $notifications['msg'] = 'Successfully '.$action.'d the '.$type;
          $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notifications));
         }
      }
      
      $this->data['posts'] = $type == 'post' ?
         ContentM\ContentPost::posts_active()->get():
         ContentM\ContentPost::pages_active()->get();
      
      $list_title = ( $type == 'post')? 'Posts' : 'Pages';
      $this->_list_data($this->data,$list_title);
      return $this->main_view;
    }
    
    public function action_confirmdelete($id=null){
      if ($id==null){
        return Redirect::to($this->admin_url.'content');
      }
      
      $data = array();
      
      $post = ContentM\ContentPost::find(intval($id));
      
      $data['form_title'] = $post->type == 'post' ? 'Delete Post' : 'Delete Page';
      $data['text'] = "Confirm the removal of <strong>".$post->title.'<strong>';
      $data['id'] = $post->id;
      $data['type'] = $post->type;
      $confirm = View::make('content::confirm')
                  ->with('data', $data);
      $this->main_view->nest('main','admin::partials.center', array('content'  => $confirm)); 
      return $this->main_view; 
    }
    
    public function action_delete(){
      $input = Input::all();
      if ( !$input ){
        return Redirect::to($this->admin_url.'content');
      }
      
      $id = Input::get('id');
      $type = Input::get('type');
      $post = ContentM\ContentPost::find(intval($id));
      $post->status = 'delete';
      $post->save();
      
      return Redirect::to($this->admin_url.'content/list'.$type.'s');
    }
    
    //////////////////////Private Functions//////////////////////////////
    private function _create_data($input, $type){
      $data = array();
      $post = new ContentM\ContentPost();
      $user = Sentry::user();
      
      $post->title = isset($input['title']) ? $input['title'] : '';
      $post->content = isset($input['content']) ? $input['content'] : '';
      $post->status = isset($input['status']) ? $input['status'] : '';
      $post->author_id = $user->get('id');
      $post->order = isset($input['order']) ? $input['order'] : null;
      $post->menus = isset($input['menus']) ? serialize($input['menus']) : null;
      $post->template = isset($input['template']) && ($input['template'] != '') ? $input['template'] : null;
      $post->parent = isset($input['parent']) ? $input['parent'] : null;
      $post->inactiveurl = isset($input['inactiveurl']) ? $input['inactiveurl'] : null;
      if  ( isset($input['title']) ){
        $guid = strtolower($input['title']);
        $guid = str_replace(' ', '-', $guid);
        $post->guid = $guid;
      }
      
      $post->type = $type;
      //$upload = $this->_upload_file($input['image']);
      $upload = Admin\Libraries\FileUpload::do_upload('bundles/content/', $input['image']);
      
      if (is_array($upload) && isset($upload['errors'])) {
        $data['errors'] = 'Could not upload image';
      } else if (is_array($upload) && isset($upload['url']) ) {
        $post->image = $upload['url'];
      }
      
      if (array_key_exists('errors', $data))  {
        return $data;
      }
      $post->save();
      if ( isset($input['taxs']) && count($input['taxs']) > 0 ) {
  
        foreach ( $input['taxs'] as $key => $val ) {
          $tax_rels = new ContentM\ContentRel();
          $tax_rels->posts_id = $post->id;
          $tax_rels->taxs_id = $val;
          $tax_rels->save();
        }
      }
      
      $data['success'] = true;
      return $data;
      
    }
    
    private function _edit_data($input, $type){
      $data = array();
      $id = $input['post_id'];
      $post = ContentM\ContentPost::find(intval($id));
      
      $user = Sentry::user();
      $post->title = isset($input['title']) ? $input['title'] : '';
      $post->content = isset($input['content']) ? $input['content'] : '';
      $post->status = isset($input['status']) ? $input['status'] : '';
      $post->author_id = $user->get('id');
      $post->order = isset($input['order']) ? $input['order'] : null;
      $post->menus = isset($input['menus']) ? serialize($input['menus']) : null;
      $post->template = isset($input['template']) && ($input['template'] != '') ? $input['template'] : null;
      $post->parent = isset($input['parent']) ? $input['parent'] : null;
      $post->inactiveurl = isset($input['inactiveurl']) ? $input['inactiveurl'] : null;     
      if  ( isset($input['title']) ){
        $guid = strtolower($input['title']);
        $guid = str_replace(' ', '-', $guid);
        $post->guid = $guid;
      }
      
      $post->type = $type;
      $file_url = isset($post->image)? $post->image: null;
      //$upload = $this->_upload_file($input['image'], $file_url);
      $upload = Admin\Libraries\FileUpload::do_upload('bundles/content/', $input['image'],$file_url);
      if (is_array($upload) && isset($upload['errors'])) {
        $data['errors'] = 'Could not upload image';
      } else if (is_array($upload) && isset($upload['url']) ) {
        $post->image = $upload['url'];
      }
      
      if (array_key_exists('errors', $data))  {
        return $data;
      }
      $post->save();
      if ( isset($input['taxs']) && count($input['taxs']) > 0 ) {
        // delete existing
        ContentM\ContentRel::delete_post($id);
        // update
        foreach ( $input['taxs'] as $key => $val ) {
          $tax_rels = new ContentM\ContentRel();
          $tax_rels->posts_id = $post->id;
          $tax_rels->taxs_id = $val;
          $tax_rels->save();
        }
      }
      
      $data['success'] = true;
      return $data;   
    }
    
    private function _upload_file($file=null, $file_url = null){
      if ($file == null) {
        return false;
      }
     
      $data = array();
         
      if ( is_array($file) && isset($file['error']) && $file['error'] == 0 ) {
       
        try{
          $file_dir = path('public').'bundles/content/'.date('Ymd').'/';
          $file_rel_path = 'bundles/content/'.date('Ymd').'/';
          $extension = File::extension($file['name']);
          $filename = sha1(Sentry::user()->get('id').time()).".{$extension}";       
       
          $upload = Input::upload('image', $file_dir, $filename );

          if ( $upload ) {
            $data['url'] = $file_rel_path.$filename;
            if ($file_url) {
             $current_file = path('public').$file_url;
              File::delete($current_file);
            }
            // remove the one already assigned to the user
          } else {
            $data['errors'] = 'Unable to upload image';
          }
        } catch ( Exception $e ) {        
          $data['errors'] = $e->getMessage();
        }

      } else if ( is_array($file) && isset($file['error']) && $file['error'] == 1 ) {
         
        $data['errors'] = "Unable to upload image";
      }
      
      return $data;
    }
    
    private function _post_data($action,$type,$id=null){
      
     Asset::add('imageloader-js', 'admin_assets/js/plugins/imagesLoaded/jquery.imagesloaded.min.js');
     //Select 2
     //Bootbox
     Asset::add('bootbox-js', 'admin_assets/js/plugins/bootbox/jquery.bootbox.js');
     // Custom file upload 
     Asset::add('fileupload-js', 'admin_assets/js/plugins/fileupload/bootstrap-fileupload.min.js');
     //TinMCE
     Asset::container('first')->add('chosen-js','admin_assets/js/plugins/chosen/chosen.jquery.min.js');
     Asset::container('first')->add('tinymce-js', 'admin_assets/js/plugins/tinymce/tinymce.min.js');
     Asset::container('first')->add('content-js','admin_assets/js/content.js');
     
    //CSS
     Asset::add('tagsinput-css', 'admin_assets/css/plugins/tagsinput/jquery.tagsinput.css');
     Asset::add('chosen-css','admin_assets/css/plugins/chosen/chosen.css');
     $form_title =( $action == 'create' ) ? 'Create ': 'Edit ';
     $form_title.= ($type == 'post')? 'Post': 'Page';
     
     // Add the category choices
     $tpls = ContentL\Helper::get_tpls();
     
     $parents_array = NULL;
     
     if  ( $type == 'post' ) {
       $taxs = ContentM\ContentTax::activetaxes()->get();
       $tax_options = array();
       foreach ( $taxs as $tax ){
         $tax_options[$tax->id] = $tax->title;
       }
       
      /* $multiple = array('type'=>'multiple','name'=> 'taxs', 'title'=> 'Categories',
             'options' => $tax_options
           );
       $this->inputs['posts']['taxs'] = $multiple;
      */
     }  
     if ($type == 'page') {
       $parents = ContentM\ContentPost::public_page_parent($id)->get();
       $this->inputs['posts']['parent'] = array('type' => 'select','name' => 'parent', 'title' => 'Parent' );
       $parents_array[''] = 'Select Parent';
       foreach ( $parents as $parent ){
           $parents_array[$parent->id] = $parent->title;
       }
       $this->inputs['posts']['parent']['options'] = $parents_array;
       if ($tpls) {
         $this->inputs['posts']['template'] = array('type'=>'select', 'name'=>'template', 'title'=> 'Template');
         $this->inputs['posts']['template']['options'][''] = 'Select Template';
         foreach ($tpls as $tpl) {           
          $this->inputs['posts']['template']['options'][$tpl['file']] = $tpl['name'];
         }
       }
       $this->inputs['posts']['order'] = array('type'=>'text', 'title'=> 'Order', 'name'=> 'order', 'rules' => array('integer'=>'true'));
       $this->inputs['posts']['menus'] = array('type'=>'multiple', 'name'=>'menus', 'title'=> 'Menus', 
                       'options' => array(
                           'top' => 'Top',
                           'sidebar' => 'Sidebar',
                           'footer' => 'Footer',
                       )
            );
     }
     $post_data = array();
     $post_data['form_title'] = $form_title;
     $post_data['action'] = $action;
     $post_data['type'] = $type;
     if ( $action == 'create') {
       foreach ( $this->inputs['posts'] as $post_key => $post_val) {
         $title = isset($post_val['title']) ? $post_val['title'] : null;
         $val = null;
         $selector_id = isset($post_val['id']) ? $post_val['id']:null;
         $rules =( isset($post_val['rules']) && count($post_val['rules']) > 0 )? $post_val['rules'] : null;
         $options = (isset($post_val['options']) ) ? $post_val['options'] : null;
         if ($post_key == 'type'){
           $val = $type;
         }
         if ($post_key == 'action'){
           $val = $action;
         }
         
         if ($post_key == 'parent') {
            $options = $parents_array; 
         }
         $post_data[$post_val['type']][$post_key] =
            Form::content_edit_create($title, $post_val['name'],$post_val['type'], $val, $rules,$options, $selector_id);
       }
     } else if ( $action == 'edit') {
       $post = ContentM\ContentPost::find(intval($id));
       foreach ( $this->inputs['posts'] as $post_key => $post_val) {
         $title = isset($post_val['title']) ? $post_val['title'] : null;
         $val = null;
         $selector_id = isset($post_val['id']) ? $post_val['id']:null;
         $rules =( isset($post_val['rules']) && count($post_val['rules']) > 0 )? $post_val['rules'] : null;
         $options = (isset($post_val['options']) ) ? $post_val['options'] : null;
         
         
         if ($post_key == 'action'){
           $val = $action;
         } else if($post_key == 'post_id'){
           $val = $id;
         } else if ($post_key == 'menus') {
           $menus = $post->menus;
           if ($menus) {
            $val = unserialize($menus);
           }
         } else if ($post_key == 'taxs'){
           $set_taxs = ContentM\ContentRel::get_posts_rel($id)->get();
           $tax_val = array();
           
           foreach ($set_taxs as $st ){
             
             if ( $st->posts_id == $id ) {
               $tax_val[] = $st->taxs_id;               
             }
           }
           $val = $tax_val;
         } else if( $post_key == 'parent' ){
           $options = $parents_array;
           $val = $post->$post_key;
         } else if($post_key== 'inactiveurl'){
           $val = $post->$post_key == 'on' ? 1:NULL;
         } else {
           $val = $post->$post_key;
         }
         $post_data[$post_val['type']][$post_key] =
            Form::content_edit_create($title, $post_val['name'],$post_val['type'], $val, $rules,$options, $selector_id);
       }
     }
     
     return $post_data;
    }
    
    private function _list_data($data, $list_title=null){
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
     
     $list = View::make('content::list')->with('data', $data)
                                        ->with('title',$list_title);
     $this->main_view->nest('main','admin::partials.center', array('content'=>$list));
     
    }
    
    
    private $inputs = array(
        'posts' => array(
            'title' => array('type'=>'text', 'name'=> 'title', 'title'=> 'Title',
                             'rules' => array('required'=> 'true')
                ),
            'content' => array('type'=>'textarea', 'name' => 'content', 'title'=>'Content', 'id' => 'post_content',
                             'rules' => array('required' => 'true')
                ),
            'post_id' => array('type'=>'hidden', 'name' => 'post_id'),
            'type' => array('type'=> 'hidden', 'name'=> 'type'),
            'action' => array('type'=>'hidden', 'name'=> 'action'),
            'status' => array('type'=>'select', 'name'=>'status', 'title'=> 'Status', 
                           'options' => array(
                               'draft' => 'Draft',
                               'publish' => 'Publish',
                               'delete' => 'Delete',
                           )
                ),
           'template' => array('type'=>'select', 'name'=>'template', 'title'=> 'Template'),            
          /* 'menus' => array('type'=>'multiple', 'name'=>'menus', 'title'=> 'Menus', 
                       'options' => array(
                           'top' => 'Top',
                           'sidebar' => 'Sidebar',
                           'footer' => 'Footer',
                       )
            ),*/
           // 'parent' => array('type' => 'select','name' => 'parent', 'title' => 'Parent' ), 
            //'inactiveurl' => array( 'type' => 'checkbox','name' => 'inactiveurl','title' => 'Inactive URL' ),
            //'order' => array('type'=>'text', 'title'=> 'Order', 'name'=> 'order', 'rules' => array('integer'=>'true')),
            'image' => array('type'=>'file', 'name'=> 'image', 'title'=> 'Featured Image')
        )
    );
    

}