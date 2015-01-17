<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Libraries;
use Laravel\URL;
use Laravel\Input;

class FormGenerator{
  
  public static function std_form($title=null,$name,$type,$value=null,$rules=null, $options=null, $id=null){
    $input = '';
    $data_rules='';

    $selector_id  = isset($id) ? $id : $name;
    if ($rules) {
      foreach ($rules as $rule_key => $rule_val ) {
        $data_rules.= 'data-rule-'.$rule_key.'="'.$rule_val.'" ';
      }
    }
    
    $old_input = Input::old($name) ? Input::old($name) : null;
    $value = $value ? $value : $old_input;
    if ($type == 'text' || $type == 'password' ) {

       $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <input type="'.$type.'" id="'.$selector_id.'" name="'.$name.'" '.$data_rules.' class="input-xlarge"  value="'.$value.'">';
        $input.='</div>';
       $input.='</div>'; 
    } else if ($type == 'textarea') {
       $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <textarea  id="'.$selector_id.'" name="'.$name.'" '.$data_rules.' rows="5" class="input-block-level" >'. $value .'</textarea>';
        $input.='</div>';
       $input.='</div>';
     } else if ($type == 'checkbox') {
       $html  =  ($value == 1 ) ? 'checked = "checked"' : ''; 
       $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <input '.$html.' type="'.$type.'" id="'.$selector_id.'" name="'.$name.'" '.$data_rules.' >';
        $input.='</div>';
       $input.='</div>';

    } else if ($type == 'file' ) {
      $input.= '<div class="control-group">';
      $input.= '<label for="name" class="control-label">'.$title.':</label>';
      $input.='<div class="controls">';    

        $input.='<div class="fileupload fileupload-new" data-provides="fileupload">';
         $input.='<div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px;">';
          $file_url = $value ? URL::to($value) : URL::base().'/admin_assets/img/aristotle.jpg';
            $input.='<img width="120px" src="'.$file_url.'" />';
          $input.='</div>';
          $input.='<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">';
          $input.='</div>';

          $input.='<div>';          
            $input.='<span class="btn btn-file">';
              $input.='<span class="fileupload-new">Select image</span>';
              $input.='<span class="fileupload-exists">Change</span>';
              $input.='<input type="file" id="'.$selector_id.'" name="'.$name.'" />';
            $input.='</span>';
            $input.='<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>';
          $input.='</div>';

      $input.='</div>';
      $input.='</div>';     
      $input.='</div>';
    } else if ( $type == 'select') {
        $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <select id="'.$selector_id.'" '.$data_rules.' class="input-large " name="'.$name.'" >';
          if($options) {
            foreach ($options as $key => $val ){
               $selected = (isset($value) && $value==$key)? ' selected="selected" ' : '';
              $input.= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
            }
          }
         $input.='</select>';
        $input.='</div>';
       $input.='</div>'; 
    } else if ( $type == 'multiple') {
      
        $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <select id="'.$selector_id.'" multiple="multiple" class="input-large " name="'.$name.'[]" >';
          if($options) {
            foreach ($options as $key => $val ){
              $selected = (isset($value) && in_array( strval($key), $value))? ' selected="selected" ' : '';
              $input.= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
            }
          }
         $input.='</select>';
        $input.='</div>';
       $input.='</div>'; 
    } else if ( $type == 'hidden') {   
         $input.=' <input type="'.$type.'" id="'.$selector_id.'" name="'.$name.'" value="'. $value.'" >';   
    } else if ( $type == 'datetime') {
       $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div style="display:block;" class="controls input-append date" id="'.$selector_id.'" >';
         $input.=' <input type="text" name="'.$name.'" '.$data_rules.' class="input-xlarge" value="'.$value.'">';
         $input.='<span class="add-on">';
           $input.='<i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>';
         $input.='</span>';
        $input.='</div>';
       $input.='</div>';     
    } else if ($type == 'upload') {
      $input.= '<div class="control-group">';
      $input.= '<label for="name" class="control-label">'.$title.':</label>';
      $input.='<div class="controls">';    

        $input.='<div class="fileupload fileupload-new" data-provides="fileupload">';

         $input.='<div class="fileupload-new thumbnail" style="max-width: 700px; max-height: 150px;">';
          $file_url = $value ? URL::to($value) : 'No file chosen';
            $input.='<span>'.$file_url.'</span>';
          $input.='</div>';
          $input.='<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 700px; max-height: 150px; line-height: 20px;">';
          $input.='</div>';        
    
          $input.='<div>';  
        
            $input.='<span class="btn btn-file">';
              $input.='<span class="fileupload-new">Select File</span>';
              $input.='<span class="fileupload-exists">Change</span>';
              $input.='<input type="file" id="'.$selector_id.'" name="'.$name.'" />';
            $input.='</span>';
            $input.='<span class="fileupload-filename"></span>';
            $input.='<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>';
          $input.='</div>';

      $input.='</div>';
      $input.='</div>';     
      $input.='</div>';
    }
   return $input;    
  }
  
  public static function profile_form($title=null,$name,$type,$value=null,$rules=null){
    $input='';
    $data_rules='';
    if ($rules) {
      foreach ($rules as $rule_key => $rule_val ) {
        $data_rules.= 'data-rule-'.$rule_key.'="'.$rule_val.'" ';
      }
    }
    
    $old_input = Input::old($name) ? Input::old($name) : null;
    $value = $value ? $value : $old_input;
    
    if ($type == 'text' || $type == 'password' ) {

       $input.= '<div class="control-group">';
      # $input.=' <label for="name" class="control-label right">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <input type="'.$type.'" id="'.$name.'" name="'.$name.'" '.$data_rules.' class="input-xlarge" placeholder="'.$title.'" value="'.$value.'">';
        $input.='</div>';
       $input.='</div>';

    } else if ($type == 'textarea') {
       $input.= '<div class="control-group">';
           $input.='<div class="controls">';
         $input.=' <textarea  id="'.$name.'" name="'.$name.'" '.$data_rules.' class="input-xlarge" placeholder="'.$title.'" >'. $value .'</textarea>';
        $input.='</div>';
       $input.='</div>';

    } else if ($type == 'file') {
        $input.='<div class="fileupload fileupload-new" data-provides="fileupload">';

          $input.='<div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px;">';
          $file_url = $value ? URL::to($value) : URL::base().'/admin_assets/img/aristotle.jpg';
            $input.='<img src="'.$file_url.'" />';
          $input.='</div>';
          $input.='<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">';
          $input.='</div>';

          $input.='<div>';          
            $input.='<span class="btn btn-file">';
              $input.='<span class="fileupload-new">Select image</span>';
              $input.='<span class="fileupload-exists">Change</span>';
              $input.='<input type="file" name="avatar" />';
            $input.='</span>';
            $input.='<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>';
          $input.='</div>';

        $input.='</div>';
    } else if ($type == 'upload') {
       $input.= '<div class="control-group">';
        $input.='<div class="controls">';
         $input.='<input type="file" name="upload" id="file" class="form-control">';
        //$input.=' <textarea  id="'.$name.'" name="'.$name.'" '.$data_rules.' class="input-xlarge" placeholder="'.$title.'" >'. $value .'</textarea>';
        $input.='</div>';
       $input.='</div>';
    }
    
   return $input;    
  }
  
  public static function cforms_form($title=null,$name,$type,$value=null,$rules=null, $options=null, $id=null){
    $input = '';
    $data_rules='';

    $selector_id  = isset($id) ? $id : $name;
    if ($rules) {
      foreach ($rules as $rule_key => $rule_val ) {
        $data_rules.= 'data-rule-'.$rule_key.'="'.$rule_val.'" ';
      }
    }
    
    $old_input = Input::old($name) ? Input::old($name) : null;
    $value = $value ? $value : $old_input;
    if ($type == 'text' || $type == 'password' ) {

       $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <input type="'.$type.'" id="'.$selector_id.'" name="'.$name.'" '.$data_rules.' class="input-xlarge"  value="'.$value.'">';
        $input.='</div>';
       $input.='</div>'; 
    } else if ($type == 'textarea') {
       $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <textarea  id="'.$selector_id.'" name="'.$name.'" '.$data_rules.' rows="5" class="input-block-level" >'. $value .'</textarea>';
        $input.='</div>';
       $input.='</div>';
     } else if ($type == 'checkbox') {
       $html  =  ($value == 1 ) ? 'checked = "checked"' : ''; 
       $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <input '.$html.' type="'.$type.'" id="'.$selector_id.'" name="'.$name.'" '.$data_rules.' >';
        $input.='</div>';
       $input.='</div>';

    } else if ($type == 'file' ) {
      $input.= '<div class="control-group">';
      $input.= '<label for="name" class="control-label">'.$title.':</label>';
      $input.='<div class="controls">';    

        $input.='<div class="fileupload fileupload-new" data-provides="fileupload">';
         $input.='<div class="fileupload-new thumbnail" style="max-width: 200px; max-height: 150px;">';
          $file_url = $value ? URL::to($value) : URL::base().'/admin_assets/img/aristotle.jpg';
            $input.='<img width="120px" src="'.$file_url.'" />';
          $input.='</div>';
          $input.='<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">';
          $input.='</div>';

          $input.='<div>';          
            $input.='<span class="btn btn-file">';
              $input.='<span class="fileupload-new">Select image</span>';
              $input.='<span class="fileupload-exists">Change</span>';
              $input.='<input type="file" id="'.$selector_id.'" name="'.$name.'" />';
            $input.='</span>';
            $input.='<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>';
          $input.='</div>';

      $input.='</div>';
      $input.='</div>';     
      $input.='</div>';
    } else if ( $type == 'select') {
        $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <select id="'.$selector_id.'" '.$data_rules.' class="input-large " name="'.$name.'" >';
          if($options) {
            foreach ($options as $key => $val ){
               $selected = (isset($value) && $value==$key)? ' selected="selected" ' : '';
              $input.= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
            }
          }
         $input.='</select>';
        $input.='</div>';
       $input.='</div>'; 
    } else if ( $type == 'multipleselect') {
       $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div class="controls">';
         $input.=' <select id="'.$selector_id.'" multiple="multiple" class="input-large " name="'.$name.'[]" >';
          if($options) {
            foreach ($options as $key => $val ){
              $selected = (isset($value) && in_array( strval($key), $value))? ' selected="selected" ' : '';
              $input.= '<option value="'.$key.'" '.$selected.' >'.$val.'</option>';
            }
          }
         $input.='</select>';
        $input.='</div>';
       $input.='</div>'; 
    } else if ( $type == 'hidden') {   
         $input.=' <input type="'.$type.'" id="'.$selector_id.'" name="'.$name.'" value="'. $value.'" >';   
    } else if ( $type == 'datetime') {
       $input.= '<div class="control-group">';
       $input.=' <label for="name" class="control-label">'.$title.':</label>';
        $input.='<div style="display:block;" class="controls input-append date datetime" id="'.$selector_id.'">';
         $input.=' <input readonly type="text" name="'.$name.'" '.$data_rules.' class="input-xlarge" value="'.$value.'">';
         $input.='<span class="add-on">';
           $input.='<i class="icon-calendar"></i>';
         $input.='</span>';
        $input.='</div>';
       $input.='</div>';     
    }
   return $input;    
  }  
}
