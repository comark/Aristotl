<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ICTACustomM;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Config;
class Ictacustom extends Eloquent {
  public static $timestamps = true;
  public static $table = 'ictacustom';
  
  
    public static function posts_active() {
        return Ictacustom::where('status', '!=', 'delete')
                        ->order_by('id', 'asc')
                        ->get();
    }  
    public static function posts_active_type($type) {
        return Ictacustom::where('type', '=', $type)
                        ->where('status', '!=', 'delete')
                        ->order_by('id', 'asc')
                        ->get();
    }
    
    public static function post_active_id($id) {
        return Ictacustom::where('id', '=', $id)
                        ->where('status', '!=', 'delete')
                        ->first();
    }    
}