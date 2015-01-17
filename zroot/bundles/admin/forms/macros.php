<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Form::macro('edit_create',
 function($title=null,$name,$type,$value=null,$rules=null, $options=null, $id=null){
    $form = Admin\Libraries\FormGenerator::std_form($title, $name, $type, $value, $rules, $options, $id);
    return $form;
});

Form::macro('profile_input', function($title=null,$name,$type,$value=null,$rules=null){
$profile = Admin\Libraries\FormGenerator::profile_form($title, $name, $type, $value, $rules);
return $profile;

});

Form::macro('content_edit_create',
  function($title=null,$name,$type,$value=null,$rules=null, $options=null, $id=null){
    $form = Admin\Libraries\FormGenerator::std_form($title, $name, $type, $value, $rules, $options, $id);
    return $form;
});

Form::macro('yagpo_register',
 function($title=null,$name,$type,$value=null,$rules=null, $options=null, $id=null){
    $form = YagpoL\FormGenerator::std_form($title, $name, $type, $value, $rules, $options, $id);
    return $form;
});

Form::macro('cforms_create',
 function($title=null,$name,$type,$value=null,$rules=null, $options=null, $id=null){
    $form = Admin\Libraries\FormGenerator::cforms_form($title, $name, $type, $value, $rules, $options, $id);
    return $form;
});
