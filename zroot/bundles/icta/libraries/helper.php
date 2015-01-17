<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IctaL;
use Laravel\URL;
use Laravel\View;
use ContentL;
use ContentM;
use Sentry;
use UserM;

class Helper{
  
    public static function make_structure($section_array){
      $main_view = View::make('icta::index');
      $meta      = 'icta::partials.meta';
      $header    = 'icta::partials.header';
      $content   = 'icta::partials.content';
      $footer    = 'icta::partials.footer';
      $notify    = 'icta::partials.notify';
      $carousel  = 'icta::partials.carousel';
      

      
      if (isset($section_array['title'])) {
        $title = $section_array['title'];
        $main_view->nest('page_title',$meta, array('title'=> $title));
      } else {
        $main_view->nest('page_title',$meta); 
      }
      
      $top_header = array();
      $menu_active = 'home';
      if (isset($section_array['menu_active'])) {
        $menu_active = $section_array['menu_active'];
      }
      
      $menu = \IctaL\Helper::menu_helper($menu_active);
      $top_header['menu'] = View::make('icta::tpls.menu')
                                ->with('menu', $menu);
      if (isset($section_array['header'])) {
        $top_header['custom'] = $section_array['header'];
        $main_view->nest('section_header',$header, array('content'=> $top_header));
      } else {
        $main_view->nest('section_header',$header, array('content'=> $top_header)); 
      }
      
      if (isset($section_array['carousel'])) {
        $main_view->nest('section_carousel',$carousel);
      }
      if (isset($section_array['notify'])) {
        $notify_content = $section_array['notify'];
        $color = isset($section_array['color']) ? $section_array['color'] : null;
        $main_view->nest('notify_content',$notify, array('message'=> $notify_content, 'color' => $color));
      }
      if (isset($section_array['content'])) {
        $top_content = $section_array['content'];
        $main_view->nest('section_content',$content, array('content'=> $top_content));
      } else {
        $main_view->nest('section_content',$content); 
      }
      
      $footer_menu = \IctaL\Helper::footermenu_helper();

      if (isset($section_array['footer'])) {
        $top_footer = $section_array['footer'];        
        $main_view->nest('section_footer',$footer, array('content'=> $top_footer,'menu'=>$footer_menu));
      } else {
        $main_view->nest('section_footer',$footer, array('menu'=>$footer_menu)); 
      }
      
      return $main_view;
    }
    
    public static function make_sidebar($list=null){
        $widgets_array  = array('sidelinks','text');
        $widgets = array() ;
       if($list == null ){
           
           foreach ($widgets_array as $wa_key=>$wa_val){
               $widgets[] = View::make('icta::widgets.'.$wa_val);
           }
       } else {
           
           foreach ($list as $wa_key=>$wa_val){
               $widgets[] = View::make('icta::widgets.'.$wa_val);
           }           
       }
      $sidebar = View::make('icta::tpls.sidebar')
                     ->with('widgets', $widgets);        
      return $sidebar;        
    }
    
    public static function menu_helper($active=null){
      $list = array(
          'home' => 
              array('title' => 'Home', 'url' => '', 'class' => ''),
          //'register'=> 
            //   array('title' => 'Register','url' => 'register', 'class' =>'')
      );
      
      /*$content_menus = ContentL\Helper::get_topmenu();
      if ( count($content_menus) > 0) {
       foreach ($content_menus as $cm) {
         $list[$cm->guid] = array('title'=> $cm->title, 'url'=> 'pages/'.$cm->guid);
       }        
      }
      if ($active) {
        foreach ( $list as $key => $val) {
           if ($active == $key) {
             $list[$key]['active'] = 'active';
           }
        }
      }
      return $list; */
      
      $content_menus = ContentL\Helper::get_topmenu();
      if ( count($content_menus) > 0) {
       foreach ($content_menus as $cm) {
         $list[$cm->guid] = array('title'=> $cm->title, 'url'=> 'pages/'.$cm->guid, 'class' => '');
         if ($cm->children && count($cm->children) > 0){
            foreach ($cm->children as $child) {
                $list[$cm->guid]['children'][] = array('title'=> $child->title, 'url'=> 'pages/'.$child->guid, 'class' => '');
            }
         }
       }        
      }
      if ($active) {
        foreach ( $list as $key => $val) {
           if ($active == $key) {
             $list[$key]['class'] = $list[$key]['class'].'active ';
           }
           
           if (isset( $list[$key]['children'] ) && count($list[$key]['children']) > 0 ){
             $list[$key]['class'] = $list[$key]['class'].'dropdown ';   
           }
        }
      }
      $list['contact'] = array('title' => 'Contact', 'url' => 'contact', 'class' => '');
      return $list;      
    }
    
    public static function sidebarmenu_helper(){
      $list = array();
      
      $content_menus = ContentL\Helper::get_sidebarmenu();
      if ( count($content_menus) > 0) {
       foreach ($content_menus as $cm) {
         $list[$cm->guid] = array('title'=> $cm->title, 'url'=> 'pages/'.$cm->guid);
       }        
      }
      return $list;
    }
    
    public static function footermenu_helper(){
      $list = array();
      
      $content_menus = ContentL\Helper::get_footermenu();
      if ( count($content_menus) > 0) {
       foreach ($content_menus as $cm) {
         $list[$cm->guid] = array('title'=> $cm->title, 'url'=> 'pages/'.$cm->guid);
       }        
      }
      return $list;
    }     
    
    public static function home_date_helper($date){        
        $month = strtoupper(date('M', strtotime($date)));
        $day = strtoupper(date('d', strtotime($date)));
        return '<span><strong>'. $month.'</strong>'.$day.'</span> ';
    }
    
    public static function blog_date_helper($date){        
        $month = strtoupper(date('M', strtotime($date)));
        $day = strtoupper(date('d', strtotime($date)));
        $year = date('Y', strtotime($date));
        return  $day.' '.$month.' '.$year;
    }    
    public static function home_blog_snippet($content){  
        $small = substr($content, 0, 100);
        return strip_tags($small).' ...';
    }   
    
    public static function get_blogs(){
       $posts = ContentM\ContentPost::posts_active()->get();
       if ( $posts ){
         return $posts;
       } else {
         return false;
       }
    }
    
    public static function validate_meta($meta, $key) {
        
        $unserialize = unserialize($meta);
        if (isset($unserialize[$key])){
            return $unserialize[$key];
        } else {
            return false;
        }
     }
}