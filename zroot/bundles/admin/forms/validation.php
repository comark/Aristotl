<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Validator::register('email_check', function($attribute, $value, $parameters)
{
  
    $user_id = Sentry::user()->get('id');
    $users = Sentry::user()->all();
    $count = 0;
     foreach( $users as $user ) {
       if ( ( $user['id'] != $user_id ) && ($user['email'] == $value ) ) {
          $count = 1;
       }
     }
     if( $count == 0) {
       return $value;
     } else {
       return false;
     }
});

Validator::register('title_check', function($attribute, $value, $parameters)
{
  
    $id = null;
    $what = $parameters[0];
    $action = $parameters[1];
    if ( $action == 'edit') {
      $id = $parameters[2];
    }
    $entity = null;
    if ($what == 'post' || $what == 'page') {
      
      $entity = ( $id == null )? ContentM\ContentPost::where('type','=',$what)
                                   ->where('status','!=','delete')->get():
                                ContentM\ContentPost::where('type','=',$what)
                                   ->where('status','!=','delete')
                                   ->where('id','!=', $id)->get();
    } else if ( $what == 'tax') {
      $entity = ( $id == null )? ContentM\ContentTax::where('status','!=','delete')->get():
                                ContentM\ContentTax::where('status','!=','delete')
                                   ->where('id','!=', $id)->get();
    }       
    $count = 0;
    
    foreach( $entity as $ent_key => $ent_val ) {
       if ( isset($ent_val->id) ) {         
        if (  $ent_val->title == $value  ) {
          $count = 1;
        }
       }
      
    } 
     if( $count == 0) {
       return $value;
     } else {
       return false;
     }
});

Validator::register('delete_check', function($attribute, $value, $parameters){
  
  $return = ( ($value == 'delete') && ($parameters[0] == 'create')) ? false : $value;
  return $return;
  
});

Validator::register('edit_email_check', function($attribute, $value, $parameters)
{
    
    $user_id = $parameters[0];
    $users = Sentry::user()->all();
    $count = 0;
     foreach( $users as $user ) {
       if ( ( $user['id'] != $user_id ) && ($user['email'] == $value ) ) {
          $count = 1;
       }
     }
     if( $count == 0) {
       return $value;
     } else {
       return false;
     }
});

Validator::register('check_setup', function($attribute, $value, $parameters)
{
   $return = $value;
  
   $db = $parameters[0];
   $user = $parameters[1];
   $pass = $parameters[2];
   $conn = \Laravel\Database::connection('mysql');
    if (  ( $value != $conn->config['host'] )
          ||  ( $db != $conn->config['database'])
          ||  ( $user != $conn->config['username'])
          ||   ( $pass != $conn->config['password'])  
       ) {
     $return = false;
    } 

   return $return;
});

Validator::register('check_county_unique',function($attribute,$value,$parameters){
    $return = $value;
    $number = $parameters[0];
    $id = $parameters[1];
    
    $permalink = strtolower(trim($value));
    if (isset($id)) {
      $num_check = CountiesM\Counties::check_county_number($number);
      if ( $num_check && $num_check->id != $id){
         $return = false;
      }
      
      $perm_check = CountiesM\Counties::check_county_permalink($permalink);
      if ( $perm_check && $perm_check->id != $id){
         $return = false;
      }
    } else {
      $num_check = CountiesM\Counties::check_county_number($number);
      if ($num_check){
          $return = false;
      }
      
      $perm_check = CountiesM\Counties::check_county_permalink($permalink);
      if ($perm_check) {
          $return = false;
      }
        
    }
    
    return $return;
});

Validator::register('check_province_unique',function($attribute,$value,$parameters){
    $return = $value;
    $number = $parameters[0];
    $id = $parameters[1];
    
    $permalink = strtolower(trim($value));
    if (isset($id)) {
      $num_check = ProvincesM\Provinces::check_province_number($number);
      if ( $num_check && $num_check->id != $id){
         $return = false;
      }
      
      $perm_check = ProvincesM\Provinces::check_province_permalink($permalink);
      if ( $perm_check && $perm_check->id != $id){
         $return = false;
      }
    } else {
      $num_check = ProvincesM\Provinces::check_province_number($number);
      if ($num_check){
          $return = false;
      }
      
      $perm_check = ProvincesM\Provinces::check_province_permalink($permalink);
      if ($perm_check) {
          $return = false;
      }
        
    }
    
    return $return;
});

Validator::register('check_cform_unique',function($attribute,$value,$parameters){
    $return = $value;
    $name = $parameters[0];
    $id = $parameters[1];
    if (isset($id)) {
      $name_check = CformsM\Cforms::check_cform_name($name);
      if ($name_check && $name_check->id != $id) {
          $return = false;
      }
    } else {
      $name_check = CformsM\Cforms::check_cform_name($name);
      if ( $name_check ) {
          $return = false;
      }
    }
    return $return;
});

Validator::register('pub_title_check', function($attribute, $value, $parameters)
{
  
    $id = null;
    $action = $parameters[0];
    if ( $action == 'edit') {
      $id = $parameters[1];
    }
    
    $entity = null;    
    $entity = ($id== null)? PublicationsM\Publications::where('status','!=','delete')->get():
                            PublicationsM\Publications::where('status','!=','delete')
                                                      ->where('id','!=',$id)->get();
    $count = 0;
    
    foreach( $entity as $ent_key => $ent_val ) {
       if ( isset($ent_val->id) ) {         
        if (  $ent_val->title == $value  ) {
          $count = 1;
        }
       }
      
    } 
     if( $count == 0) {
       return $value;
     } else {
       return false;
     }
});
