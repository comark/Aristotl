<?php
class Admin_User_Controller extends Admin_Base_Controller {   

    private $start_view;
    private $msg_email;
    private $msg_name;
    private $site_title;
    private $can_register;
    private $admin_url;
    
    public function __construct() {

       parent::__construct();
       Asset::add('jquery-validate-js','admin_assets/js/plugins/validation/jquery.validate.min.js');
       Asset::add('jquery-additional-methods-js','admin_assets/js/plugins/validation/additional-methods.min.js');
       Asset::add('loggedout-js','admin_assets/js/loggedout.js');
       $this->start_view = View::make('admin::start');
       $this->msg_email = Config::get('admin::mail.outgoing.email');
       $this->msg_name = Config::get('admin::mail.outgoing.name');
       $this->site_title = Config::get('admin::config.site_title');
       $this->can_register = Config::get('admin::config.admin_register');
       $this->admin_url =  Config::get('admin::config.admin_url');
    }
    
    public function action_index() {
      return Redirect::to($this->admin_url.'xlogin');
    }
     
    public function action_xlogin(){
       $redir = Input::get('redirect');
       if ( $redir) {
         $this->start_view->nest('start', 'admin::loggedout.login', array('redirect'=>$redir));
       } else {
         $this->start_view->nest('start', 'admin::loggedout.login'); 
       }
       return $this->start_view;
    }
   
    public function action_xauthenticate() {   
        
        $input = Input::get();

        if ( !$input ) {
          return Redirect::to($this->admin_url.'xlogin');
        }
        $rules = array(
            'email' => 'required|email|exists:users',
            'password' => 'required'
        );
        
        $validation = Validator::make($input, $rules);

        if( $validation->fails() ) {
            return Redirect::to($this->admin_url.'xlogin')->with_errors($validation);
        }

        try
        {
            $valid_login = Sentry::login(Input::get('email'), Input::get('password'), Input::get('remember'));

            if($valid_login)
            {
              $redirect = Input::get('redirect');
              if ( $redirect ) {
                return Redirect::to($redirect);
              } else {
                return Redirect::to($this->admin_url.'dashboard');
              }
            }
            else
            {
               $data['errors'] = "Invalid login!";
            }
        }
        catch (Sentry\SentryException $e)
        {
            $data['errors'] = $e->getMessage();
        }
        
        if (array_key_exists('errors', $data))  {
          return Redirect::to($this->admin_url.'xlogin')->with('myerrors', $data['errors']);
        } else {
          return Redirect::to($this->admin_url.'xlogin');  
        }
        

    }
    
    public function action_xlogout() {
        Sentry::logout();
        return Redirect::to($this->admin_url.'xlogin');
    }
    
    public function action_xsignupform() {
        if ( $this->can_register == false) {
          return Redirect::to($this->admin_url.'xlogin');
        }
       $this->start_view->nest('start', 'admin::loggedout.register');
       return $this->start_view;
    }
    
    public function action_xregister(){
      

        $data = array();
        $notifications = '';
        $rules = array(
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'firstname' => 'required|alpha_num',
            'lastname' => 'required|alpha_num|required_with:firstname'
        );
        
        $input = Input::get();
        if ( !$input ) {
          return Redirect::to($this->admin_url.'xsignupform');
        }
        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return Redirect::to($this->admin_url.'xsignupform')->with_input()->with_errors($validation);
        }
        
        // add user
        $new_user_id = null;
        try {
            $user = Sentry::user()->register(array(
              'email'    =>Input::get('email'),
              'password' => Input::get('password'),
              'metadata' => array(
                  'first_name' => Input::get('firstname'),
                  'last_name'  => Input::get('lastname'),
              )
            ));

            if(!$user) {
                $data['errors'] = 'There was an issue when add user to database';
            } else {
             
                 $super_perms = array(
                    'is_admin'   => 1, 
                    'superuser'   => 1,
                    'is_editor' => 1,
                    'is_user' => 1
                 );
                 
                 $is_user_perms = array(
                     'is_user' => 1,
                 );


              
              $reg_user = Sentry::user($user['id']);
              $new_user_id = $user['id'];
              $set_perms = ($user['id'] == 1) ?  $super_perms : $is_user_perms; 
               // Update current user permissions
              if (Sentry::user($user['id'])->update_permissions($set_perms)) {
                  $reg_user->add_to_group(7);
                  $reg_user->add_to_group(4);
                  // User permissions were successfully updated
              } else    {
                 
                 $notifications.= 'There was a problem assigning your access to certain sections of the site.';                       $notifications.='\n Please Contact administrator after logging in \n';
              }   
              $tpl = array();
              $tpl['email'] = $reg_user->get('email');
              $tpl['firstname'] = $reg_user->get('metadata.first_name');
              $tpl['lastname'] = $reg_user->get('metadata.last_name');
              $tpl['activation'] = URL::base().$this->admin_url.'/xactivate/'.$user['hash'];
              
              $view =  View::make('admin::email.register')->with('message',$tpl)->render();
              
              
              $message = Message::to($reg_user->get('email'))
		                     ->from($this->msg_email, $this->msg_name)
		                     ->subject('Sign Up activation')
		                     ->body($view)
		                     ->html(true) 
		                     ->send();

              if($message->was_sent($reg_user->get('email'))){
                   
              } else {
                $data['errors'] = 'The user was registered, but the activation email could not be sent.';
              } 
            }
        }
        catch (Sentry\SentryException $e) {
            $data['errors'] = $e->getMessage();
        }

        if (array_key_exists('errors', $data))  {
          return Redirect::to($this->admin_url.'xsignupform')->with('myerrors', $data['errors']);
        } else  {
          // Noti Handler
          $noti_msg = 'New user registered: '.Sentry::user($new_user_id)->get('email');
          $noti_msg.= '<br>'.Sentry::user($new_user_id)->get('metadata.first_name');
          $noti_msg.='&nbsp;'.Sentry::user($new_user_id)->get('metadata.last_name');
          Admin\Libraries\Notihandler::noti_handler('users',$noti_msg ,'register');
          
          // Form notification
          $notifications.= 'You have successfully registered, please check your email to activate your account';  
          return Redirect::to($this->admin_url.'xnotifications')->with('notifications', $notifications );
        }
    }
    
    public function action_xnotifications(){
      $this->start_view->nest('start', 'admin::loggedout.notifications');
      return $this->start_view;
    }
    
    public function action_xactivate($email=null, $hash=null){
      $notifications = '';
      $activate_msg = 'Account activation success!';
        try
        {
            $activate_user = Sentry::activate_user($email, $hash);

            if($activate_user)
            {
              $noti_msg = 'New user activated: '.$activate_user->get('email');
              $noti_msg.= '<br>'.$activate_user->get('metadata.first_name');
              $noti_msg.= '&nbsp;'.$activate_user->get('metadata.last_name');
              Admin\Libraries\Notihandler::noti_handler('users',$noti_msg ,'activate');
              
              $tpl = array();
              $tpl['title'] =$activate_msg; 
              $tpl['email'] = $activate_user->get('email');
              $tpl['firstname'] = $activate_user->get('metadata.first_name');
              $tpl['lastname'] = $activate_user->get('metadata.last_name');
              $tpl['link'] = URL::base().$this->admin_url.'/xlogin';
              $tpl['text'] = "You have successfully activated your account on ". $this->site_title ."<br>";
              $tpl['text'].= "Use the link below to login";
              $view =  View::make('admin::email.notify')->with('message',$tpl)->render();
              
              
              $message = Message::to($activate_user->get('email'))
		                     ->from($this->msg_email, $this->msg_name)
		                     ->subject('Activation success')
		                     ->body($view)
		                     ->html(true) 
		                     ->send();

              if($message->was_sent($activate_user->get('email'))){
                   
              } else {
                $data['errors'] = 'The user was registered, but the activation email could not be sent.';
              } 
              return Redirect::to($this->admin_url.'xlogin')->with('notes', $activate_msg);
            }
            else
            {
                $notifications.= 'The user was not activated <br>';
            }
        }catch (Sentry\SentryEXception $e)  {
           $notifications.=  $e->getMessage();
        }
         return Redirect::to($this->admin_url.'xnotifications')->with('notifications', $notifications );
    }
    
    public function action_xforgotpassword(){
      $this->start_view->nest('start', 'admin::loggedout.reset');
      return $this->start_view;
    }
    
    public function action_xreset(){
        $data = array();
        
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|confirmed',
        );

        $input = Input::get();
        if ( !$input ) {
          return Redirect::to($this->admin_url.'xforgotpassword');
        }
        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
          return Redirect::to($this->admin_url.'xforgotpassword')->with_input()->with_errors($validation);
        }
        
        // reset password
        try  {
            $reset = Sentry::reset_password(Input::get('email'), Input::get('password'));

            if(!$reset) {
                $data['errors'] = 'There was an issue when reset the password';
            } else {
              $reg_user = Sentry::user($reset['email']);
              
              $tpl = array();
              $tpl['email'] = $reg_user->get('email');
              $tpl['firstname'] = $reg_user->get('metadata.first_name');
              $tpl['lastname'] = $reg_user->get('metadata.last_name');
              $tpl['reset'] = URL::base().'/'.$this->admin_url.'xconfirmation/'.$reset['link'];
              
              $view =  View::make('admin::email.reset')->with('message',$tpl)->render();
              
              $message = Message::to($reg_user->get('email'))
		                     ->from($this->msg_email, $this->msg_name)
		                     ->subject('Reset password')
		                     ->body($view)
		                     ->html(true) 
		                     ->send();

              if($message->was_sent($reg_user->get('email'))){
                   
              } else {
                $data['errors'] = 'The password was done, but the reset confirmation email could not be sent.';
              } 
            }
        } catch (Sentry\SentryException $e)   {
            $data['errors'] = $e->getMessage();
        }

        if (array_key_exists('errors', $data)) {
          return Redirect::to($this->admin_url.'xforgotpassword')->with_input()->with('myerrors', $data['errors']);
        } else  {
          $notifications = 'The request to reset password has been made, please check your email to confirm your reset';       
          return Redirect::to($this->admin_url.'xnotifications')->with('notifications', $notifications );
        }
    }
    
    public function action_xconfirmation($email = null, $hash = null) {
      $data = array();
      try {
        $confirmation = Sentry::reset_password_confirm($email, $hash);

        if($confirmation){
          $reset_msg = 'You\'ve Successfully reset your password';
          return Redirect::to($this->admin_url.'xlogin')->with('notes', $reset_msg);
        } else {
          $data['errors'] =  'Unable to reset password';
        }
      } catch (Sentry\SentryException $e) {
          $data['errors'] =  $e->getMessage();
      }
      
      if (array_key_exists('errors', $data)) {
        return Redirect::to($this->admin_url.'xlogin')->with_input()->with('notes', $data['errors']);
      } else  {
        $notifications = 'There was a problem resetting your password. Contact the administrator';       
        return Redirect::to($this->admin_url.'xnotifications')->with('notifications', $notifications );
      }
    }
    
    
   

}
