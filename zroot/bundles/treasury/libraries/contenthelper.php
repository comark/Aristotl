<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace TreasuryL;
use Laravel\URL;
use Laravel\View;
use Laravel\Database;
use Laravel\Config;
use Laravel\Input;
use ContentL;
use ContentM;

class ContentHelper{
  
   
    public static function get_blogs($type=null){
       $query = Database::table('contentposts')
                ->where('contentposts.status','!=','delete');
       if ($type){
           $query->where('type','=',$type);
       }
       $query->order_by('contentposts.id','desc');
       $per_page = Config::get('ictacustom::custom.public_per_page');
       $url = $query->paginate($per_page);
       $result = $query->get();
       $params = Input::all();
       unset($params['page']);
       $pagination = $url->appends($params)->links(); 
       $data = array();
       if ($pagination!='') {
       $data['pagination_top'] = $pagination;
       }
       $data['data'] = $result;
        if ($pagination!='') {
       $data['pagination_bottom'] = $pagination;
        }

       if ( isset ( $data['data'])  ) {
           return $data;
       } else {
           return false;
       }

    } 

    public static function get_custom($type=null){
       $query = Database::table('ictacustom')
                ->where('ictacustom.status','!=','delete');
       if ($type){
           $query->where('type','=',$type);
       }
       $query->order_by('ictacustom.id','desc');
       $per_page = Config::get('ictacustom::custom.public_per_page');
       $url = $query->paginate($per_page);
       $result = $query->get();

       $params = Input::all();
       unset($params['page']);
       $pagination = $url->appends($params)->links(); 
       $data = array();
       $data['pagination_top'] = $pagination;
       $data['data'] = $result;       
       $data['pagination_bottom'] = $pagination;

       if ( isset ( $data['data'])  ) {
           return $data;
       } else {
           return false;
       }

    } 
    
    public static function single_blog($data){
        $bundle = 'treasury';
        $view = View::make($bundle.'::singletpls.singlepost')->with('data',$data);
        return $view;
    }
    
    public static function single_custom($type,$data){
        $bundle = 'treasury';
        $view = '';
        if ( $type == 'projects') {
            $view.= View::make($bundle.'::listtpls.projects')->with('data',$data);
        } else if( $type == 'resources'  || $type == 'bills' || $type == 'publications' 
                || $type == 'publicsector' || $type == 'reports' ){
            $view.= View::make($bundle.'::listtpls.resources')->with('data',$data);
        }
        return $view;
    }    
    
    public static function blog_date_helper($date){        
        $month = strtoupper(date('M', strtotime($date)));
        $day = strtoupper(date('d', strtotime($date)));
        $year = date('Y', strtotime($date));
        return  $day.' '.$month.' '.$year;
    }   
    
    public static function custom_meta_object($key,$data){
        if($data){
            $array = unserialize($data);
            if (isset($array[$key])){
                return $array[$key];
            }
        }        
        return false;
    }
    
    public static function custom_url_helper($data){
        if($data){
           $guid = $data->guid;
           $url = URL::base().'/type/'.$guid;
           return $url;
        }        
        return false;
    }
    
    public static function slider_helper(){
        $sliders = \ICTACustomM\Ictacustom::posts_active_type('slideshow');
        if ( $sliders) {
            $display = array();
            foreach ( $sliders as $slider ){
                $slide = $slider->meta;
                $order = \TreasuryL\ContentHelper::custom_meta_object('order', $slide);
                $image = \TreasuryL\ContentHelper::custom_meta_object('image', $slide);
                $description = \TreasuryL\ContentHelper::custom_meta_object('description', $slide);
                $title = \TreasuryL\ContentHelper::custom_meta_object('title', $slide);
                $display[intval($order)]['title'] = $title;
                $display[intval($order)]['description'] = $description;
                $display[intval($order)]['image'] = $image;
            }
            ksort($display);
            return $display;
        }         
        return false;
    }
       
}
