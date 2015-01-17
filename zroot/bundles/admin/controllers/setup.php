<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Admin_Setup_Controller extends Admin_Base_Controller{
    
    private $start_view;
    private $msg_email;
    private $msg_name;
    private $site_title;
    
    public function __construct() {
        parent::__construct();
       Asset::add('jquery-validate-js','admin_assets/js/plugins/validation/jquery.validate.min.js');
       Asset::add('jquery-additional-methods-js','admin_assets/js/plugins/validation/additional-methods.min.js');
       Asset::add('loggedout-js','admin_assets/js/loggedout.js');
       
       $this->start_view = View::make('admin::start');
       $this->msg_email = Config::get('admin::mail.outgoing.email');
       $this->msg_name = Config::get('admin::mail.outgoing.name');
       $this->site_title = Config::get('admin::config.site_title'); 
       $this->admin_url =  Config::get('admin::config.admin_url');
    }
    
    public function action_start() {
        
        $users = Sentry::user()->all();
       
        if (count($users) > 0) {
          return  Redirect::to($this->admin_url.'xlogin');
        }
       $this->start_view->nest('start', 'admin::setup.start'); 
       return $this->start_view;
    }
    
    public function action_submit(){


        $data = array();
        $notifications = '';
        $user_data = array(); 
        
        $host = Input::get('server');
        $database = Input::get('dbname');
        $dbuser = Input::get('dbuser');
        $dbpass = Input::get('dbpass');        
        $rules = array(
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'firstname' => 'required|alpha_num',
            'lastname' => 'required|alpha_num|required_with:firstname',
            'server' => 'required|check_setup:'.$database.','.$dbuser.','.$dbpass,
            'dbname' => 'required',
            'dbuser' => 'required',
            //'dbpass' => 'required'
        );
        
        $input = Input::get();
        if ( !$input ) {
          return Redirect::to('setup');
        }

        $validation = Validator::make($input, $rules,Config::get('admin::rules.validation'));
        
        if ($validation->fails()) {
            return Redirect::to($this->admin_url.'setup')->with_input()->with_errors($validation);
        }
        // add user
        $new_user_id = null;
        try {
            $user_data = array(
              'email'    =>Input::get('email'),
              'password' => Input::get('password'),
              'metadata' => array(
                  'first_name' => Input::get('firstname'),
                  'last_name'  => Input::get('lastname'),
              ),
              'status' => 1,
              
            );
            $user = Sentry::user()->create($user_data, false);

            if(!$user) {
                $data['errors'] = 'There was an issue when adding user to database';
            } else {
             
   
              $reg_user = Sentry::user($user);
              $new_user_id = $user;
       
               // Update current user permissions
              if (Sentry::user($user)->update_permissions(Config::get('admin::config.super_perms'))) {
                  
                  $groups =  Config::get('admin::config.all_groups');
                  foreach ($groups as $group) {
                      $group_id = Sentry::group()->create(array('name'=> $group));
                      $reg_user->add_to_group($group_id);
                  }
                  //$reg_user->add_to_group(7);
                  //$reg_user->add_to_group(4);
                  // User permissions were successfully updated
              } else    {
                 
                 $notifications.= 'There was a problem assigning your access to certain sections of the site.';                       $notifications.='\n Please Contact administrator after logging in \n';
              }   

            }
        }
        catch (Sentry\SentryException $e) {
            $data['errors'] = $e->getMessage();
        }

        if (array_key_exists('errors', $data))  {
          return Redirect::to($this->admin_url.'setup')->with('myerrors', $data['errors']);
        } else  {
          // Noti Handler
          //$noti_msg = 'New user registered: '.Sentry::user($new_user_id)->get('email');
          //$noti_msg.= '<br>'.Sentry::user($new_user_id)->get('metadata.first_name');
          //$noti_msg.='&nbsp;'.Sentry::user($new_user_id)->get('metadata.last_name');
          //Admin\Libraries\Notihandler::noti_handler('users',$noti_msg ,'register');
          
          // Form notification
          $notifications.= 'You have successfully setup'. Config::get('admin::config.site_title');  
          return Redirect::to($this->admin_url.'xnotifications')->with('notifications', $notifications );
        }        
    }
}

