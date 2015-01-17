<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Libraries;
use Admin\Models\Notifications;
use Sentry;

class Notihandler {
  
   public static function noti_handler($bundle,$msg,$action, $targ = null){
     
       // Noti_Handler
       $noti_users = Sentry::group(1)->users();
       $targets = array();
       
       if ($targ != null && is_array($targ) ){
         foreach ($targ as $tg ){
           $targets[] = $tg;
         }
       } else if ($targ!=null && is_scalar($targ)) {
         $targets[] = $targ;
       }
       foreach ($noti_users as $ni ) {
         $targets[] = $ni['id'];
       }
       
      $targets = array_unique($targets);
      if ($targets && is_array($targets)) {
        foreach ($targets as $target) {
          $notify = new Notifications();
          $notify->bundle = $bundle;
          $notify->message = $msg;
          $notify->action = $action;
          $notify->target = $target;
          $notify->save();
        }
      }      
   }  
}
