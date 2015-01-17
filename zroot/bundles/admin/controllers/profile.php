<?php

class Admin_Profile_Controller extends Admin_Base_Controller{
  
  public function __construct() {
    parent::__construct();
    //Images loaded
    Asset::add('imageloader-js', 'admin_assets/js/plugins/imagesLoaded/jquery.imagesloaded.min.js');
    //Select 2
    Asset::add('select2-js', 'admin_assets/js/plugins/select2/select2.min.js');
    
	  //Bootbox
    Asset::add('bootbox-js', 'admin_assets/js/plugins/bootbox/jquery.bootbox.js');

	  // Validation 
	  Asset::add('validate-js', 'admin_assets/js/plugins/validation/jquery.validate.min.js');
	  Asset::add('additional-js', 'admin_assets/js/plugins/validation/additional-methods.min.js');
	  // Custom file upload 
	  Asset::add('fileupload-js', 'admin_assets/js/plugins/fileupload/bootstrap-fileupload.min.js');
    
    //CSS
    Asset::add('tagsinput-css', 'admin_assets/css/plugins/tagsinput/jquery.tagsinput.css');
    Asset::add('select2-css', 'admin_assets/css/plugins/select2/select2.css');
    
    $this->main_view = View::make('admin::index');
    $this->notification = 'admin::partials.notifications';
    $this->main_view->nest('center_top', 'admin::partials.centertop', array('title'=> $this->title));
    $this->main_view->with('page_title', $this->title );
    $this->admin_url =  Config::get('admin::config.admin_url');
  }
  
  public function action_index(){
     $this->_form_data();
     return $this->main_view;
  }
  
  public function action_xupdate(){
 
     $data = array();
     $user_data = array();
     
     $rules = array(
        'email' => 'required|email|email_check',
        'first_name' => 'required|alpha_num',
        'last_name' => 'required|alpha_num|required_with:first_name',
        'avatar' => 'image|max:4000|mimes:jpg,gif,png'
    );
    
    $input = Input::all();

    if ( !$input ) {
      return Redirect::to($this->admin_url.'xprofile');
    }
   
    $validation = Validator::make($input, $rules,Config::get('admin::rules.validation'));

    if ($validation->fails()) {
        return Redirect::to($this->admin_url.'xprofile')->with_input()->with_errors($validation);
    }

    $file = Input::file('avatar');
    if ( is_array($file) && isset($file['error']) && $file['error'] == 0 ) {
      
      try{
        $avatar_dir = path('public').'avatars/'.date('Ymd').'/';
        $avatar_rel_path = 'avatars/'.date('Ymd').'/';
        $extension = File::extension($input['avatar']['name']);
        $filename = sha1(Sentry::user()->get('id').time()).".{$extension}";
       
        $upload = Input::upload('avatar', $avatar_dir, $filename );
        
        if ( $upload ) {
          $user_data['metadata']['avatar'] = $avatar_rel_path.$filename;
          if ( Sentry::user()->get('metadata.avatar') != '') {
            $current_avatar = path('public').Sentry::user()->get('metadata.avatar');
            //var_dump($current_avatar); return;
            File::delete($current_avatar);
          }
          // remove the one already assigned to the user
        } else {
          $data['errors'] = 'Unable to upload image';
        }
      } catch ( Exception $e ) {        
        $data['errors'] = $e->getMessage();
      }
      
    }
    
    $user_data['email'] = Input::get('email');
    $metainput = array('first_name','last_name');
    foreach ( $metainput as $mi ){
      if ( Input::get($mi) ) {
        $user_data['metadata'][$mi] = Input::get($mi);
      } else {
        $user_data['metadata'][$mi] = '';
      }
    }
    
    try{
      $user = Sentry::user();
      if ( $user->update($user_data)) {
        $notifications = array();
        $notifications['class'] = 'success';
        $notifications['msg'] = 'Successfully updated your profile.';
        $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notifications));
      } else {
        $data['errors'] = "There was a problem updating your profile";
      }
    } catch ( Sentry\SentryException $e) {
      $data['errors'] = $e->getMessage(); 
    }
    
    if (array_key_exists('errors', $data)) {
      return Redirect::to($this->admin_url.'xprofile')->with('myerrors', $data['errors']);
    } else  {
     $this->_form_data();
     return $this->main_view;
    }   

  }
  
  public function action_xchangepassword(){
    $data = array();
    $user_data = array();
     
    $rules = array(
        'password' => 'confirmed'
    );
    
    $input = Input::get();
    if ( !$input ) {
      return Redirect::to($this->admin_url.'xprofile');
    }

    $validation = Validator::make($input, $rules);

    if ($validation->fails()) {
        return Redirect::to($this->admin_url.'xprofile')->with_input()->with_errors($validation);
    }
    
    $password = Input::get('password');
    try{
      $user_data['password'] = $password;
      $user = Sentry::user();
      if ( $user->update($user_data)) {
        $notifications = array();
        $notifications['class'] = 'success';
        $notifications['msg'] = 'Successfully changed your password.';
        $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notifications));
      } else {
        $data['errors'] = "There was a problem updating your password";
      }     
    } catch (Sentry\SentryException $e) {
      $data['errors'] = $e->getMessage(); 
    }
    
    if (array_key_exists('errors', $data)) {
      return Redirect::to($this->admin_url.'xprofile')->with('myerrors', $data['errors']);
    } else  {
     $this->_form_data();
     return $this->main_view;
    } 
  }

  public function _form_data(){
       
     $user = Sentry::user();
     $user_data = array();
    
     foreach ( $this->inputs['user'] as $key => $val ) {
       $title = null;  $value = null; $rules = null;
       if ( $val['type'] != 'password') {
         $value =  $user->get($key) ? $user->get($key) : null;
       }
       if ( $val['type'] != 'file'){
          $title =  $val['title'] ? $val['title'] : null;
       }
       
       if (isset($val['rules']) && count($val['rules']) > 0) {
         $rules = $val['rules'];
       }
       $user_data[$val['type']][$key] =
          Form::profile_input($title, $val['name'],$val['type'], $value, $rules); 
     }
     

     $profile = View::make('admin::partials.profile')
                  ->with('data', $user_data)
                  ->with('admin_url',$this->admin_url);
     $this->main_view->nest('main','admin::partials.center', array('content'  => $profile)); 
  }
  
  
  // class variable declaration
  
  private $main_view;
  private $notification;
  private $msg = array();
  private $title = 'Profile';
  
  private $inputs = array(
      'user' => array(
          'metadata.first_name' => 
             array('type'=> 'text', 'name' => 'first_name', 'title'=> 'First Name',
                   'rules' => array(
                      'lettersonly' => 'true', 'required' => 'true'                    
                   )    
             ),
          
          'metadata.last_name' => 
             array('type'=> 'text', 'name' => 'last_name', 'title'=> 'Last Name',
                   'rules' => array(
                      'lettersonly' => 'true', 'required' => 'true'
                   )       
             ),
          
          'email' => 
             array('type'=>'text','name' => 'email', 'title' => 'Email',
                  'rules' => array(
                      'email' => 'true', 'required' => 'true'                      
                   )       
             ),          
          'password' =>
             array('type'=>'password', 'name'=>'password', 'title' =>'Password',
                  'rules' => array(
                      'required' => 'true'                      
                   )    
             ),
          
          'password_confirmation' => 
              array('type'=>'password','name'=>'password_confirmation','title' =>'Confirm Password',
                  'rules' => array(
                      'required' => 'true', 'equalTo' => '#password'                     
                   )                  
              ),
          'metadata.avatar' => 
            array('type' =>'file', 'name' => 'avatar'),
      ),
  );
  
}
