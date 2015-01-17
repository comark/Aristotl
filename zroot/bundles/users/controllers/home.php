<?php

class Users_Home_Controller extends Admin_Base_Controller {

    private $main_view;
    private $notification;
    private $msg_email;
    private $msg_name;
    private $site_title;

    public function __construct() {
        parent::__construct();
        $this->main_view = View::make('admin::index');
        $this->notification = 'admin::partials.notifications';
        $this->msg_email = Config::get('admin::mail.outgoing.email');
        $this->msg_name = Config::get('admin::mail.outgoing.name');
        $this->site_title = Config::get('admin::config.site_title');
    }

    public function action_index() {
        $list = $this->_list_data('backend_superuser', 'Admin Users');
        $this->main_view->nest('main', 'admin::partials.center', array('content' => $list));
        return $this->main_view;
    }
    
    public function action_allusers() {
        $list = $this->_list_data('all', 'All Users');
        $notes = Session::get('notes');
        $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notes));
        $this->main_view->nest('main', 'admin::partials.center', array('content' => $list));
        return $this->main_view;
    }    
  
    
    public function action_create() {
        $user_data = $this->_form_data('create');
        $create = View::make('users::editcreate')
                ->with('data', $user_data);
        $this->main_view->nest('main', 'admin::partials.center', array('content' => $create));
        return $this->main_view;
    }

    public function action_edit($id = null) {


        $data = array();
        if ($id == null) {
            return Redirect::to('users');
        }
        $current_user_id = Sentry::user()->get('id');

        if ($current_user_id == $id) {
            return Redirect::to('xprofile');
        }

        try {
            $user = Sentry::user(intval($id));
        } catch (Sentry\SentryException $e) {
            $data['errors'] = $e->getMessage();
        }

        if (array_key_exists('errors', $data)) {
            $notifications = array();
            $notifications['class'] = 'error';
            $notifications['msg'] = $data['errors'];
            $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notifications));
            $this->_list_data('all', 'All Users');
            return $this->main_view;
        }

        $user_data = $this->_form_data('edit', $id);
        $create = View::make('users::editcreate')
                ->with('data', $user_data);
        $this->main_view->nest('main', 'admin::partials.center', array('content' => $create));
        return $this->main_view;
    }

    public function action_submit() {
        $data = array();
        $user_data = array();

        $input = Input::all();

        if (!$input) {
            return Redirect::to('users');
        }

        $user_id = Input::get('id');

        if (Input::get('user_delete')) {
            return Redirect::to('users/confirmdelete/' . $user_id);
        }
        $pass_req = (empty($user_id)) ? 'required|' : '';
        $redirect = (!empty($user_id)) ? 'users/edit/' . $user_id : 'create';
        $rules = array(
            'first_name' => 'required|alpha_num',
            'last_name' => 'required|alpha_num|required_with:first_name',
            'avatar' => 'image|max:4000|mimes:jpg,gif,png'
        );

        if (empty($user_id)) {
            $rules['password'] = 'required|confirmed';
            $rules['email'] = 'required|email|unique:users';
        } else {
            $rules['password'] = 'confirmed';
            $rules['email'] = 'required|email|edit_email_check:' . $user_id;
        }


        $validation = Validator::make($input, $rules, Config::get('admin::rules.validation'));

        if ($validation->fails()) {
            return Redirect::to($redirect)->with_input()->with_errors($validation);
        }
        $file = Input::file('avatar');
        if (is_array($file) && isset($file['error']) && $file['error'] == 0) {

            try {
                $avatar_dir = path('public') . 'avatars/' . date('Ymd') . '/';
                $avatar_rel_path = 'avatars/' . date('Ymd') . '/';
                $extension = File::extension($input['avatar']['name']);
                $filename = sha1(Sentry::user()->get('id') . time()) . ".{$extension}";

                $upload = Input::upload('avatar', $avatar_dir, $filename);

                if ($upload) {
                    $user_data['metadata']['avatar'] = $avatar_rel_path . $filename;
                    if (Sentry::user()->get('metadata.avatar') != '') {
                        $current_avatar = path('public') . Sentry::user()->get('metadata.avatar');
                        File::delete($current_avatar);
                    }
                    // remove the one already assigned to the user
                } else {
                    $data['errors'] = 'Unable to upload image';
                }
            } catch (Exception $e) {
                $data['errors'] = $e->getMessage();
            }
        }

        $user_data['email'] = Input::get('email');
        $pass = Input::get('password');
        if (!empty($pass)) {
            $user_data['password'] = $pass;
        }

        $metainput = array('first_name', 'last_name', 'restricted_access');
        foreach ($metainput as $mi) {
            if (Input::get($mi)) {
                if ($mi == 'restricted_access') {
                    $user_data['metadata'][$mi] = serialize(Input::get($mi));
                } else {
                    $user_data['metadata'][$mi] = Input::get($mi);
                }
            } else {
                $user_data['metadata'][$mi] = '';
            }
        }
        // create or update the user
        $notifications = array();
        try {
            $create_edit = null;
            $group_sent = Input::get('groups');

            if ($user_id != '') {
                $user = Sentry::user(intval($user_id));

                $user_groups = $user->groups();

                foreach ($user_groups as $ug_key => $ug_val) {
                    $user->remove_from_group($ug_val['id']);
                }
                
                foreach ($group_sent as $gs_key => $gs_val) {
                    $user->add_to_group(intval($gs_val));
                }
                // add user to group
                //either enable or disable user

                $enable = Input::get('status');
                $user_data['status'] = intval($enable);

                if (Input::get('activate_user') == 'on') {
                    $user_data['activated'] = 1;
                    $user_data['activation_hash'] = '';
                }

                if ($user->update($user_data)) {
                    $create_edit = 'great';
                } else {
                    $create_edit = 'fail';
                }
            } else {
                $activate = Input::get('activate_user');

                $activation_required = ($activate == 'on') ? false : true;
                
                $created = $this->_create_user($user_data, $activation_required, $group_sent);
                //$created = Sentry::user()->create($user_data, $activation_required);
                $create_edit = $created;
            }

            $action = ( Input::get('id') != '') ? 'edited' : 'created';
            if ($create_edit) {                
                $notifications['class'] = 'success';
                $notifications['msg'] = 'Successfully ' . $action . ' the user.';                
            } else {
                $data['errors'] = 'There was a problem ' . $action . ' the user';
            }
        } catch (Sentry\SentryException $e) {
            $data['errors'] = $e->getMessage();
        }

        if (array_key_exists('errors', $data)) {
          return Redirect::to($redirect)->with('myerrors', $data['errors']);
        } else {
          return Redirect::to('users/allusers')->with('notes', $notifications);
        }
    }

    public function action_confirmdelete($id = null) {
        if ($id == null) {
            return Redirect::to('users');
        }
        // should not delete_self
        if (Sentry::user()->get('id') == $id) {
            return Redirect::to('users');
        }

        $data = array();

        try {
            $user = Sentry::user(intval($id));
        } catch (Sentry\SentryException $e) {
            $data['errors'] = $e->getMessage();
        }


        if (array_key_exists('errors', $data)) {
            $notifications = array();
            $notifications['class'] = 'error';
            $notifications['msg'] = 'Could not find that user.';
            $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notifications));
            $this->_list_data('all', 'All Users');
            return $this->main_view;
        }

        $user_data = array();
        $user_data['form_title'] = 'User delete';
        $user_data['text'] = "Confirm the removal of <strong>" . $user->get('metadata.first_name') . " " . $user->get('metadata.last_name') . '</strong>';
        $user_data['id'] = $id;


        $confirm = View::make('users::confirm')
                ->with('data', $user_data);
        $this->main_view->nest('main', 'admin::partials.center', array('content' => $confirm));
        return $this->main_view;
    }

    public function action_delete() {
        $data = array();
        $user_data = array();

        $input = Input::all();

        if (!$input) {
            return Redirect::to('users');
        }

        try {
            $id = Input::get('id');
            Sentry::user(intval($id))->delete();
        } catch (Sentry\SentryException $e) {
            $data['errors'] = $e->getMessage();
        }

        if (array_key_exists('errors', $data)) {
            return Redirect::to('users/edit/' . $id)->with('myerrors', $data['errors']);
        } else {
            $notifications = array();
            $notifications['class'] = 'success';
            $notifications['msg'] = 'Successfully deleted user';
            $this->main_view->nest('notes', 'admin::partials.notifications', array('msg' => $notifications));

            $this->_list_data('all', 'All Users');
            return $this->main_view;
        }
    }

    private function _create_user($user_data, $activation, $groups) {
        $data = array();
        $user = null;
        $created_user = null;
        try {

            $user = Sentry::user()->create($user_data, $activation);

            $user_id = null;
            if ($user) {

                $user_id = $activation ? $user['id'] : $user;
                $created_user = Sentry::user($user_id);

                // add to groups
                foreach ($groups as $group_key => $group_val) {
                    $created_user->add_to_group(intval($group_val));
                }
                // send mail

                $tpl = array();
                $tpl['title'] = ' Account created';
                $tpl['email'] = $created_user->get('email');
                $tpl['firstname'] = $created_user->get('metadata.first_name');
                $tpl['lastname'] = $created_user->get('metadata.last_name');

                $set_groups = $created_user->groups();
                $frontend_only = ( count($set_groups) == 1 && $set_groups[0]['name'] == 'frontend_user') ? true : false;
                $link = ($frontend_only == true) ? str_replace('admin.', '', URL::base()) : URL::base();
                $admin = ($frontend_only == false) ? 'x' : '';
                $link = $activation ? $link . '/' . $admin . 'activate/' . $user['hash'] : $link . '/' . $admin . 'login';
                $tpl['link'] = $link;

                $text = "Your account on " . $this->site_title . " has been successfully created.<br> Use the link below to login<br>";
                $text2 = "Your password is: <strong>" . $user_data['password'] . "</strong><br>";
                $tpl['text'] = $text . $text2;
                $view = View::make('admin::email.notify')->with('message', $tpl)->render();
              
                $message = Message::to($created_user->get('email'))
                        ->from($this->msg_email, $this->msg_name)
                        ->subject('Activation success')
                        ->body($view)
                        ->html(true)
                        ->send();

                if ($message->was_sent($created_user->get('email'))) {

                } else {
                    $data['errors'] = 'The user was registered, but the activation email could not be sent.';
                }
            } else {
                $data['errors'] = 'Could not create user';
            }
        } catch (Sentry\SentryException $e) {
            $data['errors'] = $e->getMessage();
        }

        if (array_key_exists('errors', $data)) {
            return Redirect::to('users/create')->with('myerrors', $data['errors']);
        } else {
           return true;
          //  $this->_list_data('all', 'All Users');
          //  return $this->main_view;
        }
        
        return false;
    }

    private function _form_assets() {
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
    }

    private function _list_assets() {
        Asset::add('imageloaded-js', 'admin_assets/js/plugins/imagesLoaded/jquery.imagesloaded.min.js');
        Asset::add('slimscroll-js', 'admin_assets/js/plugins/slimscroll/jquery.slimscroll.min.js');
        Asset::add('bootbox-js', 'admin_assets/js/plugins/bootbox/jquery.bootbox.js');
        //dataTables 
        Asset::add('datatables-js', 'admin_assets/js/plugins/datatable/jquery.dataTables.min.js');
        Asset::add('tabletools-js', 'admin_assets/js/plugins/datatable/TableTools.min.js');
        Asset::add('colreorder-js', 'admin_assets/js/plugins/datatable/ColReorder.min.js');
        Asset::add('colvis-js', 'admin_assets/js/plugins/datatable/ColVis.min.js');
        Asset::add('columnfilter-js', 'admin_assets/js/plugins/datatable/jquery.dataTables.columnFilter.js');
        //Chosen
        Asset::add('chosen-js', 'admin_assets/js/plugins/chosen/chosen.jquery.min.js');
        // Color box
        Asset::add('colorbox-js', 'admin_assets/js/plugins/colorbox/jquery.colorbox-min.js');

        //CSS
        Asset::add('tabletools-css', 'admin_assets/css/plugins/datatable/TableTools.css');
        Asset::add('colorbox-css', 'admin_assets/css/plugins/colorbox/colorbox.css');
        Asset::add('chosen-css', 'admin_assets/css/plugins/chosen/chosen.css');
    }

    private function _form_data($action, $user_id = null) {

        $this->_form_assets();
        $user_data = array();
        $user_data['action'] = $action;
        if ($action == 'create') {
            $user_data['form_title'] = "Create Admin User";
        } else if ($action == 'edit') {
            $user_data['form_title'] = "Edit Admin User";
        }

        foreach ($this->inputs['user'] as $key => $val) {
            $title = null;
            $value = null;
            $rules = null;
            $options = null;
            $title = isset($val['title']) ? $val['title'] : null;

            if ($action == 'edit') {
                $user = Sentry::user($user_id);
                if ($val['type'] != 'password') {
                    $value = $user->get($key) ? $user->get($key) : null;
                    if ($val['name'] == 'groups') {
                        $options = $val['options'];
                    }
                }
            }

            if (isset($val['rules']) && count($val['rules']) > 0) {
                if ($action == 'edit' && $val['type'] == 'password') {
                    $edit_pass_rules = array();
                    foreach ($val['rules'] as $rule_key => $rule_val) {
                        if ($rule_key != 'required') {
                            $edit_pass_rules[$rule_key] = $rule_val;
                        }
                    }
                    $rules = $edit_pass_rules;
                } else {
                    $rules = $val['rules'];
                }
            }


            $user_data[$val['type']][$key] = Form::edit_create($title, $val['name'], $val['type'], $value, $rules, $options);
        }

        if ($action == 'create') {
            foreach ($this->inputs['other']['create'] as $key => $val) {
                $title = null;
                $value = null;
                $rules = null;
                $options = null;
                $title = isset($val['title']) ? $val['title'] : null;
                if (isset($val['rules']) && count($val['rules']) > 0) {
                    $rules = $val['rules'];
                }
                $user_data[$val['type']][$key] = Form::edit_create($title, $val['name'], $val['type'], $value, $rules, $options);
            }
        }

        if ($action == 'edit') {
            foreach ($this->inputs['other']['edit'] as $key => $val) {
                $title = null;
                $value = null;
                $rules = null;
                $options = null;
                $title = isset($val['title']) ? $val['title'] : null;
                if (isset($val['rules']) && count($val['rules']) > 0) {
                    $rules = $val['rules'];
                }
                $user = Sentry::user($user_id);
                if ($val['type'] != 'password') {
                    $value = ($user->get($key) == '1' || $user->get($key) == '0') ? $user->get($key) : null;
                    if ($val['type'] == 'select') {
                        $options = $val['options'];
                    }
                }
                $user_data[$val['type']][$key] = Form::edit_create($title, $val['name'], $val['type'], $value, $rules, $options);
            }

            // check if the user is activated
            $user = Sentry::user($user_id);
            if ($user->get('activated') == '') {

                $user_data['checkbox']['activate_user'] = Form::edit_create('Activate User', 'activate_user', 'checkbox', $value = null, $rules = null, $options = null);
            }
        }
        // both

        foreach ($this->inputs['other']['both'] as $key => $val) {
            $title = null;
            $value = null;
            $rules = null;
            $options = null;
            $title = isset($val['title']) ? $val['title'] : null;
            if (isset($val['rules']) && count($val['rules']) > 0) {
                $rules = $val['rules'];
            }
            if ($val['name'] == 'restricted_access') {

                $names = Bundle::names();
                $val['options'] = array();
                foreach ($names as $name) {
                    $ra = Config::get($name . "::main.restrict_access");
                    if ($ra) {
                        $val['options'][$name] = $name;
                    }
                }
                $value = null;

                if ($action == 'edit') {
                    $tmp_ra = $user->get('metadata.restricted_access') ? $user->get('metadata.restricted_access') : null;
                    if ($tmp_ra) {
                        $ra = unserialize($tmp_ra);
                        foreach ($ra as $r) {
                            $value[$r] = $r;
                        }
                    }
                }
                $options = $val['options'];
            }

            if ($val['name'] == 'groups') {

                $groups = array();
                $all_groups = Sentry::group()->all();
                foreach ($all_groups as $all_g) {
                    $groups[$all_g['id']] = $all_g['name'];
                }
                $options = $groups;
                if ($action == 'edit') {
                    $user = Sentry::user($user_id);
                    $user_groups = $user->groups();

                    $value = array();
                    foreach ($user_groups as $g) {
                        $value[$g['id']] = $g['id'];
                    }
                }
            }
            $user_data[$val['type']][$key] = Form::edit_create($title, $val['name'], $val['type'], $value, $rules, $options);
        }
        return $user_data;
    }

    private function _list_data($group_id, $list_title = null, $active_status = null) {
        $this->_list_assets();

        if ($group_id == 'all') {
            $users = Sentry::user()->all();
        } else {
            $users = Sentry::group($group_id)->users();
        }
        $user_data = array();
        $public = null;
        foreach ($users as $user) {
            $user_id = intval($user['id']);
            $user_data[$user_id] = Sentry::user($user_id);
            if ($group_id == 'is_user') {
                $public = true;
            } else {
                $public = false;
            }
        }
        $list = View::make('users::list')->with('data', $user_data)
                ->with('title', $list_title)
                ->with('public', $public);
        return $list;
        $this->main_view->nest('main', 'admin::partials.center', array('content' => $list));
    }

    private $inputs = array(
        'user' => array(
            'metadata.first_name' =>
            array('type' => 'text', 'name' => 'first_name', 'title' => 'First Name',
                'rules' => array(
                    'lettersonly' => 'true', 'required' => 'true'
                )
            ),
            'metadata.last_name' =>
            array('type' => 'text', 'name' => 'last_name', 'title' => 'Last Name',
                'rules' => array(
                    'lettersonly' => 'true', 'required' => 'true'
                )
            ),
            'email' =>
            array('type' => 'text', 'name' => 'email', 'title' => 'Email',
                'rules' => array(
                    'email' => 'true', 'required' => 'true'
                )
            ),
            'password' =>
            array('type' => 'password', 'name' => 'password', 'title' => 'Password',
                'rules' => array(
                    'required' => 'true'
                )
            ),
            'password_confirmation' =>
            array('type' => 'password', 'name' => 'password_confirmation', 'title' => 'Confirm Password',
                'rules' => array(
                    'required' => 'true', 'equalTo' => '#password'
                )
            ),
            'metadata.avatar' =>
            array('type' => 'file', 'name' => 'avatar', 'title' => 'Profile picture'),
            'id' =>
            array('type' => 'hidden', 'name' => 'id', 'title' => 'User ID'),
        ),
        'other' => array(
            'create' => array(
                // 'send_email' => 
                //   array('type'=> 'checkbox', 'name' => 'send_email', 'title'=> 'Send Confirmation Email'),

                'activate_user' =>
                array('type' => 'checkbox', 'name' => 'activate_user', 'title' => 'Activate User'),
            ),
            'edit' => array(
                'status' =>
                array('type' => 'select', 'name' => 'status', 'title' => 'User Status', 'options' => array(
                        '1' => 'Enabled', '0' => 'Disabled'
                    )),
            ),
            'both' => array(
                'group' =>
                array('type' => 'multiple', 'name' => 'groups', 'title' => 'User Groups',
                    'options' => array(
                        /* '6' => 'Frontend User',
                          '5' => 'Frontend Editor', */
                        '4' => 'Backend User',
                        '3' => 'Backend Editor',
                        '2' => 'Backend Admin',
                        '1' => 'Backend Superuser'
                    )
                ),
                'restricted_access' => array(
                    'type' => 'multiple', 'name' => 'restricted_access', 'title' => 'Module Access',
                )
            )
        )
    );
    private $county_array = array('Baringo', 'Bomet', 'Bungoma', 'Busia', 'Elgeyo Marakwet', 'Embu', 'Garissa', 'Homa Bay', 'Isiolo', 'Kajiado', 'Kakamega', 'Kericho', 'Kiambu', 'Kilifi', 'Kirinyaga', 'Kisii', 'Kisumu', 'Kitui', 'Kwale', 'Laikipia', 'Lamu', 'Machakos', 'Makueni', 'Mandera', 'Marsabit', 'Meru', 'Migori', 'Mombasa', 'Muranga', 'Nairobi', 'Nakuru', 'Nandi', 'Narok', 'Nyamira', 'Nyandarua', 'Nyeri', 'Samburu', 'Siaya', 'Taita Taveta', 'Tana River', 'Tharaka Nithi', 'Trans Nzoia', 'Turkana', 'Uasin Gishu', 'Vihiga', 'Wajir', 'West Pokot');

}
