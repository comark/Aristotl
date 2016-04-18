<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace AristotlL;
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

    public static function get_front_blogs($type=null){
       $query = Database::table('contentposts')
                ->where('contentposts.status','!=','delete');
   
           $query->where('type','=','post');
	   $query->take(5);
       
       $query->order_by('contentposts.id','desc');

       $result = $query->get();

       $data = array();

       $data['data'] = $result;


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
	
    public static function get_front_custom($type=null){
       $query = Database::table('ictacustom')
                ->where('ictacustom.status','!=','delete');
       if ($type){
           $query->where('type','=',$type);
	   $query->take(5);
       }
       $query->order_by('ictacustom.id','desc');
       $result = $query->get();

       $data['data'] = $result;

       if ( isset ( $data['data'])  ) {
           return $data;
       } else {
           return false;
       }

    }	
	
	public static function display_front_custom($type){

	$list = '';
		if (\AristotlL\ContentHelper::get_front_custom($type)) :
			foreach ( \AristotlL\ContentHelper::get_front_custom($type) as $data_big_key=>$data_big_val )  :       
				if(isset($data_big_val) && $data_big_key == 'data') :
					foreach( $data_big_val as $data):
					$list.='<li style="margin-bottom:4px; padding-bottom:4px; border-bottom:1px solid #ccc;"><a href='. \AristotlL\ContentHelper::custom_url_helper($data).'>'.$data->title.'</a></li> ';            
					endforeach;
				endif;
			endforeach;
		endif;
	return $list;
	}

	public static function display_news_custom(){

	$list = '';
		if (\AristotlL\ContentHelper::get_front_blogs()) :
			foreach ( \AristotlL\ContentHelper::get_front_blogs() as $data_big_key=>$data_big_val )  :       
				if(isset($data_big_val) && $data_big_key == 'data') :
					foreach( $data_big_val as $data):
					$list.='<li style="margin-bottom:4px; padding-bottom:4px; border-bottom:1px solid #ccc;"><a href='. URL::base().'/blogitem/'.$data->guid.'>'.$data->title.'</a></li> ';            
					endforeach;
				endif;
			endforeach;
		endif;
	return $list;
	}
    
    public static function single_blog($data){
        $bundle = 'aristotl';
        $view = View::make($bundle.'::singletpls.singlepost')->with('data',$data);
        return $view;
    }
    
    public static function single_custom($type,$data){
        $bundle = 'aristotl';
        $view = '';
        if ( $type == 'projects') {
            $view.= View::make($bundle.'::listtpls.projects')->with('data',$data);
        } else {
            $array_v = array('resources', 'bills', 'publications','publicsector','reports','policies','tenders','regulations');
             foreach ($array_v as $key=>$val){
                 if($type == $val) {
                        $view.= View::make($bundle.'::listtpls.resources')->with('data',$data);
                 }
             }
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
                $order = \AristotlL\ContentHelper::custom_meta_object('order', $slide);
                $image = \AristotlL\ContentHelper::custom_meta_object('image', $slide);
                $description = \AristotlL\ContentHelper::custom_meta_object('description', $slide);
                $title = \AristotlL\ContentHelper::custom_meta_object('title', $slide);
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
