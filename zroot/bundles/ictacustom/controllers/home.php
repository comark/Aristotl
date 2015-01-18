<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Ictacustom_Home_Controller extends Admin_Base_Controller{
    
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
        $data = $this->_form_data('ictacustom::fields.legend','Create Custom Type');
        $data['submit_url'] = 'ictacustom/initsubmit';
        $data['submit'] = true;
        $view = View::make('admin::std.neweditcreate')
                    ->with('data', $data);        
       $this->main_view->nest('main','admin::partials.center', array('content'  => $view));
       return $this->main_view;
    }    
      
    public function action_create() {
        $data = $this->_form_data('ictacustom::fields.legend','Create Custom Type');
        $data['submit_url'] = 'ictacustom/initsubmit';
        $data['submit'] = true;
        $view = View::make('admin::std.neweditcreate')
                    ->with('data', $data);        
       $this->main_view->nest('main','admin::partials.center', array('content'  => $view));
       return $this->main_view;
    }
    
    public function action_initsubmit(){
      $data = array();    
      $input = Input::all();      
      if ( !$input ) {
       return Redirect::to($this->admin_url.'ictacustom/create');
      } else {
          
       $legend = Input::get('legend');
       return Redirect::to($this->admin_url.'ictacustom/createtype/'.$legend);
      }
     
    }
    
    public function action_createtype($legend){
        $type = Config::get('ictacustom::fields.'.$legend);
        if(!$type){
           return Redirect::to($this->admin_url.'ictacustom/create');
        }
        $config = ( $type['default'] == true ) ?  'ictacustom::fields.default.fields' : 'ictacustom::fields.'.$legend.'.fields';
        $entity =  array('type'=>'hidden', 'name' => 'type', 'value'=>$legend);
        $data = $this->_form_data($config,'Create '.$type['title'],null,$entity);
        $data['submit_url'] = 'ictacustom/typesubmit';
        $data['submit'] = true;
        $view = View::make('admin::std.neweditcreate')
                    ->with('data', $data);        
       $this->main_view->nest('main','admin::partials.center', array('content'  => $view));
       return $this->main_view;         
    }
    
    public function action_typesubmit(){
      $data = array();    
      $input = Input::all();      
      if ( !$input ) {
       return Redirect::to($this->admin_url.'ictacustom/create');
      }
      
        $title = Input::get('title');
        $type = Input::get('type');
        $status = Input::get('status');       
        $legend = Input::get('legend');
        
        
      $rules = array(  
        'image' => 'image|max:4000|mimes:jpg,gif,png',
        'file' => 'max:10000', 
      );
     
      
      $validation = Validator::make($input, $rules, Config::get('admin::rules.validation'));    
      if ($validation->fails()) {        
        return Redirect::to($this->admin_url.'ictacustom/createtype/'.$type)->with_input()->with_errors($validation);
      }        
        
        $fields = Config::get('ictacustom::fields.'.$type);
        $config = ( $fields['default'] == true ) ?  'ictacustom::fields.default.fields' : 'ictacustom::fields.'.$legend.'.fields';
        $capture = array();
        $upload_error = array();
        
        $array_fields = ( $fields['default'] == true ) ? Config::get('ictacustom::fields.default.fields') : Config::get('ictacustom::fields.'.$type.'.fields');
        
            foreach($array_fields as $key=>$val){
                if (Input::get($key)) {
                    $capture[$key] = Input::get($key);
                    
                    if  ( $key == 'title' ){
                      $guid = strtolower($capture[$key]);
                      $guid = str_replace(' ', '-', $guid);
                      $capture['guid'] = $type.'/'.$guid;
                    }                    
                } else if ( Input::file($key) ) {
                    $upload = Admin\Libraries\FileUpload::county_upload($key, 'bundles/ictacustom/',Input::file($key));
                    if (isset( $upload['url'] )) {
                        $capture[$key] = $upload['url'];
                    } else if (isset($upload['errors'])){
                        $upload_error[] = $upload['errors'];
                    }
                }
            }
            
       $serialize = serialize($capture);  
       
       $post = new ICTACustomM\Ictacustom();
       $post->title = $title;
       $post->status = $status;
       $post->guid = $capture['guid'];
       $post->type = $type;
       $post->meta = $serialize;
       $post->save();
       
       $notes['msg'] = "Successfully created post type: ".$type ;
       if (count($upload_error) > 0 ) {
           foreach($upload_error as $key=>$val){
               $notes['msg'].='<br>'.$val;
           }
       }
       $notes['class']= 'success';                    
       return Redirect::to($this->admin_url.'ictacustom/list')->with('notes',$notes);       
     
    }  
    
    public function action_listall(){
      $query = $this->_paginate_custom();
      $this->data['posts'] = $query['data'];
      $this->data['pagination'] = $query['pagination'];
      $this->_list_data($this->data,'All Custom Posts');      
      $notes = Session::get('notes');
      if ($notes){ 
        $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notes));
      }      
      return $this->main_view;        
    }
    
    public function action_listfiltered(){
      $input = Input::all();      
      if ( !$input ) {
       return Redirect::to($this->admin_url.'ictacustom/list');
      }      
     
      $type = Input::get('legend');
      $query = $this->_paginate_custom($type);
      //$filtered_posts = ICTACustomM\Ictacustom::posts_active_type($type);
      $this->data['posts'] = $query['data'];
      $this->data['pagination'] = $query['pagination'];
      $this->_list_data($this->data,'All Custom Posts');
      
      $notes = Session::get('notes');
      if ($notes){ 
        $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notes));
      }      
      return $this->main_view;        
    }  
    
    public function action_edit($type,$id){
      $post = ICTACustomM\Ictacustom::post_active_id($id);
      if (!$post ){           
          $notes['msg'] = "Post does not exist";
          $notes['class']= 'error';                    
          return Redirect::to($this->admin_url.'ictacustom/list')->with('notes',$notes);
      }
      
      $notes = Session::get('notes');
      if ($notes){ 
        $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notes));
      }       
        $data = $this->_edit_form_data($post);
        $data['submit_url'] = 'ictacustom/editsubmit';
        $data['action'] = 'edit';
        $view = View::make('admin::std.neweditcreate')
                    ->with('data', $data);        
       $this->main_view->nest('main','admin::partials.center', array('content'  => $view));
       return $this->main_view;       
    }      
    
    public function action_editsubmit(){
        $data = array();    
        $input = Input::all();      
        if ( !$input ) {
         return Redirect::to($this->admin_url.'ictacustom/create');
        }

        if ( Input::get('delete') ) {
         $id = Input::get('post_id');
         return Redirect::to($this->admin_url.'ictacustom/confirmdelete/'.$id);
        }     
        
        $id = Input::get('post_id');
        $title = Input::get('title');
        $type = Input::get('type');
        $status = Input::get('status');   
        
        
      $rules = array(  
        'image' => 'image|max:4000|mimes:jpg,gif,png',
        'file' => 'max:10000', 
      );
     
      
      $validation = Validator::make($input, $rules, Config::get('admin::rules.validation'));    
      if ($validation->fails()) {        
        return Redirect::to($this->admin_url.'ictacustom/createtype/'.$type)->with_input()->with_errors($validation);
      }        
        
        $fields = Config::get('ictacustom::fields.'.$type);
        $config = ( $fields['default'] == true ) ?  'ictacustom::fields.default.fields' : 'ictacustom::fields.'.$type.'.fields';
        $capture = array();
        $upload_error = array();
        $post = ICTACustomM\Ictacustom::post_active_id($id);
        $unserialize = unserialize($post->meta);
        $array_fields = ( $fields['default'] == true ) ? Config::get('ictacustom::fields.default.fields') : Config::get('ictacustom::fields.'.$type.'.fields');
        
            foreach($array_fields as $key=>$val){
                if (Input::get($key)) {
                    $capture[$key] = Input::get($key);
                    
                    if  ( $key == 'title' ){
                      $guid = strtolower($capture[$key]);
                      $guid = str_replace(' ', '-', $guid);
                      $capture['guid'] = $type.'/'.$guid;
                    }                    
                } else if ( Input::file($key) ) {
                    $files = Input::file($key);
                    if ($files['error'] == 0 ){
                        $upload = Admin\Libraries\FileUpload::county_upload($key, 'bundles/ictacustom/',Input::file($key));
                        if (isset( $upload['url'] )) {
                            $capture[$key] = $upload['url'];
                        } else if (isset($upload['errors'])){
                            $upload_error[] = $upload['errors'];
                        }
                    } else {
                        if (isset($unserialize[$key])) {
                         $capture[$key] = $unserialize[$key];
                        }
                    }
                } else  {                    
                    if (isset($unserialize[$key])) {
                        $capture[$key] = $unserialize[$key];
                    }
                }
            }

       $serialize = serialize($capture);  
       
       $post->title = $title;
       $post->status = $status;
       $post->guid = $capture['guid'];
       //$post->type = $type;
       $post->meta = $serialize;
       $post->save();
       
       $notes['msg'] = "Successfully edited post type: ".$type ;
       if (count($upload_error) > 0 ) {
           foreach($upload_error as $key=>$val){
               $notes['msg'].='<br>'.$val;
           }
       }
       $notes['class']= 'success';                    
       return Redirect::to($this->admin_url.'ictacustom/edit/'.$type.'/'.$id)->with('notes',$notes);           
    }
    
    public function action_confirmdelete($id){
        $post = ICTACustomM\Ictacustom::post_active_id($id);
        if(!$post){
          $notes['msg'] = "Post does not exist";
          $notes['class']= 'error';                    
          return Redirect::to($this->admin_url.'ictacustom/list')->with('notes',$notes);            
        }
        
      if ($id==null){
        return Redirect::to($this->admin_url.'content');
      }
      
      $data = array();        
      $data['form_title'] =  'Delete'.$post->type;
      $data['text'] = "Confirm the removal of <strong>".$post->title.'<strong>';
      $data['id'] = $post->id;
      $data['type'] = $post->type;
      $confirm = View::make('ictacustom::confirm')
                  ->with('data', $data);
      $this->main_view->nest('main','admin::partials.center', array('content'  => $confirm)); 
      return $this->main_view;         
    }
    
    public function action_delete(){
      $data = array();    
      $input = Input::all();    
      if ( !$input ) {
        return Redirect::to($this->admin_url.'ictacustom/list');
      }      
      $id = Input::get('id');
      $post = ICTACustomM\Ictacustom::post_active_id($id);
      $post->status = 'delete';
      $post->save();
      
      $notes['msg'] = "Deleted post";
      $notes['class']= 'success';                    
      return Redirect::to($this->admin_url.'ictacustom/list')->with('notes',$notes);      
    }
/*************************************************************************/
    private function _form_data($field,$form_title,$id=null,$adds=null) {
        Admin\Libraries\ArAssets::form_assets();
        Asset::container('first')->add('chosen-js','admin_assets/js/plugins/chosen/chosen.jquery.min.js');
        Asset::container('first')->add('tinymce-js', 'admin_assets/js/plugins/tinymce/tinymce.min.js');
        Asset::container('first')->add('content-js','admin_assets/js/content.js');  
        
        $fields = Config::get($field) ;
        $user_data = array();
        $input_data = array();
        $input_data['form_title'] = $form_title;        
      
        if ($adds != null){
          $fields['adds'] = $adds;
        }
        foreach ($fields as $key=>$val){
           $value = isset( $val['value'] ) ? $val['value'] : null;; 
           $rules = null; 
           $options = null;
           $selector_id = null;
           $title =  isset( $val['title'] ) ? $val['title'] : null;
           if (isset($val['rules']) && count($val['rules']) > 0) {
             $rules = $val['rules'];
           }     
           if (($val['type'] == 'select') && isset($val['options'])) {               
             $options = $val['options'];
           }
           if ($val['type'] == 'multiple' && isset($val['options'])) {
             $options = $val['options'];
           }
           if (isset($input)) {
             $value = $this->_get_meta_key($key, $input);
             if ($val['type']=='checkbox' && $value=='on') {
               $value = 1;
             } else if ($val['type'] == 'file') {
                $value = $value['url']; 
             }
           }
           
           if($val['name']== 'action' && $id == null){
               $value = 'create';
           } else if ($val['name']=='action' && $id != null){
               $value = 'edit';
           }
           
           if($val['name'] == 'post_id' && $id != null ){
               $value = $id;
           }
          if (isset($val['id'])) {
              $selector_id = $val['id'];
          }
           $user_data[][$val['type']][$key] =
             Form::edit_create($title, $val['name'],$val['type'], $value, $rules, $options, $selector_id);            
        }
        $input_data['input_items'] = $user_data;
        return $input_data;        
        
    }
    
    private function _list_data($data, $list_title=null){
        Admin\Libraries\ArAssets::listing_assets();
        
        /*********** Filter **************/
        $filter = $this->_form_data('ictacustom::fields.legend','Filter Custom Types');
        $filter['submit_url'] = 'ictacustom/filtersubmit';
        $filter['submit'] = true;
        $list= View::make('admin::std.neweditcreate')
                    ->with('data', $filter);   
 
        /****List****/
        $list.= View::make('ictacustom::list')->with('data', $data)
                                        ->with('title',$list_title);   
        
        $this->main_view->nest('main','admin::partials.center', array('content'=>$list));
     
    } 
    
    private function _edit_form_data($post) {
        Admin\Libraries\ArAssets::form_assets();     
        Asset::container('first')->add('chosen-js','admin_assets/js/plugins/chosen/chosen.jquery.min.js');
        Asset::container('first')->add('tinymce-js', 'admin_assets/js/plugins/tinymce/tinymce.min.js');
        Asset::container('first')->add('content-js','admin_assets/js/content.js');        
        $content = unserialize($post->meta);
        
        $check_field = Config::get('ictacustom::fields.'.$post->type);
        $config = ( $check_field['default'] == true ) ?  'ictacustom::fields.default.fields' : 'ictacustom::fields.'.$post->type.'.fields';        
        $fields = Config::get($config) ;
        $user_data = array();
        $input_data = array();
        $input_data['form_title'] = 'Editing post type: '.$post->type;     
        
        
        /********** mandatory ************/
          //$fields['action'] = array('type'=>'hidden','name'=>'action');
          $fields['post_id'] = array('type'=>'hidden','name'=>'post_id');
          $fields['type'] = array('type'=>'hidden','name'=>'type', 'value'=>$post->type);
        /*******************/
         foreach ($content as $key=>$val){
            if (isset($fields[$key])) {
                $fields[$key]['value'] = $val;
            }     
         }
        /*********************/
        foreach ($fields as $key=>$val){
           $value = isset( $val['value'] ) ? $val['value'] : null;; 
           $rules = null; 
           $options = null;
           $title =  isset( $val['title'] ) ? $val['title'] : null;
           $selector_id = null;
           if (isset($val['rules']) && count($val['rules']) > 0) {
             $rules = $val['rules'];
           }     
           if (($val['type'] == 'select') && isset($val['options'])) {               
             $options = $val['options'];
           }
           if ($val['type'] == 'multiple' && isset($val['options'])) {
             $options = $val['options'];
           }
           if (isset($input)) {
             $value = $this->_get_meta_key($key, $input);
             if ($val['type']=='checkbox' && $value=='on') {
               $value = 1;
             } else if ($val['type'] == 'file') {
                $value = $value['url']; 
             }
           }
           
           if($val['name']== 'action' && $post->id == null){
               $value = 'create';
           } else if ($val['name']=='action' && $post->id != null){
               $value = 'edit';
           }
           
           if($val['name'] == 'post_id' && $post->id != null ){
               $value = $post->id;
           }
        
            if(isset($val['id'])) {
                $selector_id = $val['id'];
            }
           $user_data[][$val['type']][$key] =
             Form::edit_create($title, $val['name'],$val['type'], $value, $rules, $options, $selector_id);            
        }
        $input_data['input_items'] = $user_data;
        return $input_data;        
        
    }  
    
    private function _paginate_custom($type=null){
       $query = DB::table('ictacustom')
                ->where('ictacustom.status','!=','delete');
       if ($type){
           $query->where('type','=',$type);
       }
       $query->order_by('ictacustom.id','asc');
       $per_page = Config::get('ictacustom::custom.per_page');
       $url = $query->paginate($per_page);
       $result = $query->get();
       $params = Input::all();
       unset($params['page']);
       $pagination = $url->appends($params)->links(); 
       $data = array();
       $data['data'] = $result;
       $data['pagination'] = $pagination;
       return $data;
       
    }
        
}