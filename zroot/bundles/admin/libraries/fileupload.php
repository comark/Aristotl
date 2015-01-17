<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Libraries;
use File;
use Input;
use Sentry;

class FileUpload{
  
  public static function do_upload($path, $file=null, $file_url = null ) {
      if ($file == null) {
        return false;
      }
     
      $data = array();
         
      if ( is_array($file) && isset($file['error']) && $file['error'] == 0 ) {
       
        try{
          $file_dir = path('public').$path.date('Ymd').'/';
          $file_rel_path = $path.date('Ymd').'/';
          $extension = File::extension($file['name']);
          $filename = sha1(Sentry::user()->get('id').time()).".{$extension}";       
       
          $upload = Input::upload('image', $file_dir, $filename );

          if ( $upload ) {
            $data['url'] = $file_rel_path.$filename;
            if ($file_url) {
             $current_file = path('public').$file_url;
              File::delete($current_file);
            }
            // remove the one already assigned to the user
          } else {
            $data['errors'] = 'Unable to upload image';
          }
        } catch ( Exception $e ) {        
          $data['errors'] = $e->getMessage();
        }

      } else if ( is_array($file) && isset($file['error']) && $file['error'] == 1 ) {
         
        $data['errors'] = "Unable to upload image";
      }
      
      return $data;    
  }
  
  public static function county_upload($input_name,$path, $file=null, $file_url = null ) {
      if ($file == null) {
        return false;
      }
     
      $data = array();
         
      if ( is_array($file) && isset($file['error']) && $file['error'] == 0 ) {
       
        try{
          $file_dir = path('public').$path.date('Ymd').'/';
          $file_rel_path = $path.date('Ymd').'/';
          $extension = File::extension($file['name']);
          $filename = sha1(Sentry::user()->get('id').time()).".{$extension}";       
       
          $upload = Input::upload($input_name, $file_dir, $filename );

          if ( $upload ) {
            $data['url'] = $file_rel_path.$filename;
            $data['filename'] = $filename;
            if ($file_url) {
             $current_file = path('public').$file_url;
              File::delete($current_file);
            }
            // remove the one already assigned to the user
          } else {
            $data['errors'] = 'Unable to upload image';
          }
        } catch ( Exception $e ) {        
          $data['errors'] = $e->getMessage();
        }

      } else if ( is_array($file) && isset($file['error']) && $file['error'] == 1 ) {
         
        $data['errors'] = "Unable to upload image";
      }
      
      return $data;    
  }  
}
