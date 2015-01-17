<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ContentM;
use \Laravel\Database\Eloquent\Model as Eloquent;
 
class ContentTax extends Eloquent {
  public static $timestamps = true;
  
  public static function activetaxes(){
    return ContentTax::where('status','!=','delete');
  }
  
  public static function gettax($id){
    return ContentTax::where('id','=',$id)
                     ->where('status','!=', 'delete');
  }
}

