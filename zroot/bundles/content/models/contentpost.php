<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ContentM;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Config;
class ContentPost extends Eloquent {
  public static $timestamps = true;
  
  public static function posts_active() {
    return ContentPost::where('type', '=', 'post')
                        ->where('status', '!=', 'delete');
  }
  
  public static function pages_active() {
    return ContentPost::where('type', '=', 'page')
                        ->where('status', '!=', 'delete');
  }
  
  public static function public_page() {
    return ContentPost::where('type', '=', 'page')
                        ->where('status', '=', 'publish')
                        ->order_by('order','asc');
  }
  
  public static function public_page_parent($id=null){
      if ( $id ) {
   
        return ContentPost::where('type', '=', 'page')
                               ->where('status', '=', 'publish')
                               //->where_null('parent')
                               ->where('id','!=',$id)
                               ->order_by('order','asc');          
      } else {
        return ContentPost::where('type', '=', 'page')
                  ->where('status', '=', 'publish')
                  //->where_null('parent')
                  //->where('parent','=','')
                  ->order_by('order','asc');
      }
   
  }
  
  public static function public_page_children($id){
      return ContentPost::where('type','=','page')
                        ->where('status','=','publish')
                        ->where('parent','=',$id)
                        ->order_by('order','asc');
  }
  
  public static function public_page_active(){
      return ContentPost::where('type','=','page')
                        ->where('status','=','publish')
                        ->order_by('order','asc');      
  }
  
  public static function public_posts($page, $per_page = null,$offset = null){
      $take = ($per_page != null) ? $per_page : Config::get('content::content.blogs_per_page');
      $offset = ( $offset != null ) ? $offset : 0;
      if ($page != 1){
        $offset = ($page-1) * $take;
      }
      return ContentPost::where('type','=','post')
                        ->where('status','=','publish')
                        ->order_by('id','desc')
                        ->skip($offset)
                        ->take($take)->get();
  }
  
  public static function public_posts_count(){
      return ContentPost::where('type','=','post')
                        ->where('status','=','publish')
                        ->get();
  }
  
  public static function public_singleblog($guid){
      return ContentPost::where('guid','=',$guid)
                        ->where('type','=','post')
                        ->where('status','=','publish')
                        ->first();
  }
}
