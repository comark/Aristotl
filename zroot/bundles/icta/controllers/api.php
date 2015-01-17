<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Icta_Api_Controller extends Controller{
     public $restful = true;
     public function __construct() {
         parent::__construct();
     }
     
  public function post_contactsubmit(){
      
        if( isset($_POST['name']) )
        {
                $to = 'malobacomark@gmail.com'; // Replace with your email

                $subject = $_POST['subject'];
                $message = $_POST['message'] . "\n\n" . 'Regards, ' . $_POST['name'] . '.';
                $headers = 'From: ' . $_POST['name'] . "\r\n" . 'Reply-To: ' . $_POST['email'] . "\r\n" . 'X-Mailer: PHP/' . phpversion();

                $msg = mail($to, $subject, $message, $headers);

                if( $_POST['copy'] == 'on' )
                {
                        mail($_POST['email'], $subject, $message, $headers);
                }
                
                return Response::json($msg, 200);
        }   
   }     
}
