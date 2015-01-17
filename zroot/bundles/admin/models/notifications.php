<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
 
class Notifications extends Eloquent {
  public static $timestamps = true;
  
  public static function get_notices($user_id) {
    return Notifications::where('target','=',$user_id)
                        ->where('viewed','=',0)
                        ->where('deleted','=',0)
                        ->order_by('created_at','desc')->take(5);
  }
  
  public static function mark_read_single($noti_id, $user_id) {
    $noti = Notifications::where('id','=',$noti_id)
                         ->where('target','=',$user_id)
                         ->where('deleted','=',0)->first();
    if ($noti) {
      if ($noti->viewed == 0 ) {
        $noti->viewed = 1;
        $noti->save();
      }
    }
    return $noti;
  }
  
  public static function get_all_notis($user_id) {
    return Notifications::where('target','=',$user_id)
                         ->where('deleted','=',0)
                         ->order_by('created_at','desc'); 
  }

}
