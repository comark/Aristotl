<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ContentM;
use \Laravel\Database\Eloquent\Model as Eloquent;
 
class ContentRel extends Eloquent {
  public static $timestamps = true;
  
  public static function delete_post($id){
    ContentRel::where('posts_id','=', $id)->delete();
  }
  
  public static function get_posts_rel($id) {
    return ContentRel::where('posts_id','=',$id);
  }
  
}