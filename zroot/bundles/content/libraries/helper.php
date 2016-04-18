<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ContentL;
use ContentM;
use Laravel\Config;
use Laravel\URL;

class Helper{
  
  public static function get_topmenu(){
    $return = array();
    $menus = ContentM\ContentPost::public_page_parent()->get();
    foreach ( $menus as $menu ){
  if ($menu->menus !=null && ( $menu->parent == NULL || $menu->parent == '')) {
        $getmenu = unserialize($menu->menus);
        $top_exist = in_array('top',$getmenu);
        if ($top_exist){
          $children = \ContentL\Helper::get_children($menu->id);
          if ( $children && count($children) > 0 ) {
              $menu->children = $children;
          }
          $return[] = $menu;
        }
      }
    }
    return $return;
  }
  
  public static function get_allactive(){
    $return = array();
    $menus = ContentM\ContentPost::public_page_active()->get();
    foreach ( $menus as $menu ){

          $children = \ContentL\Helper::get_children($menu->id);
          if ( $children && count($children) > 0 ) {
              $menu->children = $children;
          }
          $return[] = $menu;
    }
    return $return;      
  }
  
  public static function get_sidebarmenu(){
    $return = array();
    $menus = ContentM\ContentPost::public_page_parent()->get();
    foreach ( $menus as $menu ){
      if ($menu->menus !=null) {
        $getmenu = unserialize($menu->menus);
        $top_exist = in_array('sidebar',$getmenu);
        if ($top_exist){
          $return[] = $menu;
        }
      }
    }
    return $return;
  }

  public static function get_footermenu(){
    $return = array();
    $menus = ContentM\ContentPost::public_page_parent()->get();
    foreach ( $menus as $menu ){
      if ($menu->menus !=null) {
        $getmenu = unserialize($menu->menus);
        $top_exist = in_array('footer',$getmenu);
        if ($top_exist){
          $return[] = $menu;
        }
      }
    }
    return $return;
  }
  
  public static function get_tpls(){
    $tpls = array();
    $count = 0;
    $tpl_path = path('bundle').'aristotl/views/customtpls/';
    $path = $tpl_path.'*.blade.php';
    $files = glob($path);
    if ( count($files) > 0 ) {
      foreach ($files as $template_file ){
            $template_contents = file_get_contents($template_file);
            preg_match_all("/Template Name:(.*)\n/siU",$template_contents,$template_name);
            //var_dump($template_name[1][0]); return;
            $template_name = trim($template_name[1][0]);
            $tpls[$count]['name'] = $template_name;            
            preg_match_all("/(.*).blade.php$/siU",$template_file,$file_name);
            $file_name = str_replace($tpl_path, '', $file_name[1][0]);
            $tpls[$count]['file'] = $file_name;
            $count++;
      }
    }
    return $tpls;
  }

  public static function get_children($id){
      return ContentM\ContentPost::public_page_children($id)->get();
  }
      
  public static function get_blogs($page=1,$per_page=null,$offset=null){
    $blogs = ContentM\ContentPost::public_posts($page,$per_page, $offset);
    return $blogs;
  }
  
  public static function strip_content($content){
      $tags = strip_tags($content, '<p>');
      $result = substr($tags, 0, 300);
      return $result.'...';
  }
  
  public static function get_date($date){
     $datetime = new \DateTime($date); 
     $btm = $datetime->format('M Y');
     $top = $datetime->format('d');
     return '<span>'.$top.'</span><span>'. $btm .'</span>';
  }
  
  public static function get_postdate($date){
     $datetime = new \DateTime($date); 
     $top = $datetime->format('d M Y');
     return $top;
  }  
  
  public static function get_blog_count($page=1){
    $count = count(ContentM\ContentPost::public_posts_count());
    $per_page = Config::get('content::content.blogs_per_page');
    
    $pages = ceil($count/$per_page);
    $html = '';

    for ( $p=0; $p<$pages; $p++){
        $q = $p + 1;
        if ($page == $q ) {
          $html.= '<li class="active">';
        } else {
          $html.= '<li>';
        }
        $html.='<a href="'. URL::base() .'/blogpage/'. $q .'">'. $q.'</a>';
        $html.='</li>';
    }
    
    return $html;
  }
  
  public static function get_page_exist($page) {
    $count = count(ContentM\ContentPost::public_posts_count());
    $per_page = Config::get('content::content.blogs_per_page');    
    $pages = ceil($count/$per_page);
    
    if ($page > $pages ){
        return false;
    } else {
        return true;
    }
  }
}
