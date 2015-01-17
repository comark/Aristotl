<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace ICTACustomL;
use Laravel\Database;
use Laravel\Config;
use Laravel\Input;
use Laravel\Asset;
use Laravel\Form;
use Laravel\View;

class Helper{
 
    public static function paginate_custom($type=null){
       $query = Database::table('ictacustom')
                ->where('ictacustom.status','!=','delete');
       if ($type){
           $query->where('type','=',$type);
       }
       $query->order_by('ictacustom.id','asc');
       $per_page = Config::get('ictacustom::custom.per_page');
       $url = $query->paginate($per_page);
       $result = $query->get();
       $params = Input::all();
       unset($params['page']);
       $pagination = $url->appends($params)->links(); 
       $data = array();
       $data['data'] = $result;
       $data['pagination'] = $pagination;
       return $data;
               
    }
    
    public static function list_data($data, $list_title=null){
        \Admin\Libraries\ArAssets::listing_assets();
        
        /*********** Filter **************/
        $filter = \ICTACustomL\Helper::form_data('ictacustom::fields.legend','Filter Custom Types');
        $filter['submit_url'] = 'ictacustom/filtersubmit';
        $filter['submit'] = true;
        $list= View::make('admin::std.neweditcreate')
                    ->with('data', $filter);   
 
        /****List****/
        $list.= View::make('ictacustom::list')->with('data', $data)
                                        ->with('title',$list_title);   
        return $list;
        $this->main_view->nest('main','admin::partials.center', array('content'=>$list));
     
    }    
    
    public static function form_data($field,$form_title,$id=null,$adds=null) {
        \Admin\Libraries\ArAssets::form_assets();
        Asset::container('first')->add('chosen-js','admin_assets/js/plugins/chosen/chosen.jquery.min.js');
        Asset::container('first')->add('tinymce-js', 'admin_assets/js/plugins/tinymce/tinymce.min.js');
        Asset::container('first')->add('content-js','admin_assets/js/content.js');  
        
        $fields = Config::get($field) ;
        $user_data = array();
        $input_data = array();
        $input_data['form_title'] = $form_title;        
      
        if ($adds != null){
          $fields['adds'] = $adds;
        }
        foreach ($fields as $key=>$val){
           $value = isset( $val['value'] ) ? $val['value'] : null;; 
           $rules = null; 
           $options = null;
           $selector_id = null;
           $title =  isset( $val['title'] ) ? $val['title'] : null;
           if (isset($val['rules']) && count($val['rules']) > 0) {
             $rules = $val['rules'];
           }     
           if (($val['type'] == 'select') && isset($val['options'])) {               
             $options = $val['options'];
           }
           if ($val['type'] == 'multiple' && isset($val['options'])) {
             $options = $val['options'];
           }

           
           if($val['name']== 'action' && $id == null){
               $value = 'create';
           } else if ($val['name']=='action' && $id != null){
               $value = 'edit';
           }
           
           if($val['name'] == 'post_id' && $id != null ){
               $value = $id;
           }
          if (isset($val['id'])) {
              $selector_id = $val['id'];
          }
           $user_data[][$val['type']][$key] =
             Form::edit_create($title, $val['name'],$val['type'], $value, $rules, $options, $selector_id);            
        }
        $input_data['input_items'] = $user_data;
        return $input_data;        
        
    }
        
}