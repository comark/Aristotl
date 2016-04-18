<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Aristotl_Api_Controller extends Controller{
     public $restful = true;
     public function __construct() {
         parent::__construct();
     }
     
  public function post_contactsubmit(){
      /*
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
        } */
        $to_email = "malobacomark@gmail.com"; // email address to which the form data will be sent
        $subject = "Contact Request";
        $contact_name = strip_tags($_POST["contact_name"]);
        $contact_email = strip_tags($_POST["contact_email"]);
        $contact_number = strip_tags($_POST["contact_number"]);
        $contact_message = strip_tags($_POST["contact_message"]);

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: <' .$contact_email. '>' . "\r\n";
        $headers .= "Reply-To: ".$contact_email."\r\n";

        $email_body = 
                "<strong>From: </strong>" . $contact_name . "<br />
                <strong>Email: </strong>" . $contact_email . "<br />	
                <strong>Phone: </strong>" . $contact_number . "<br />	
                <strong>Message: </strong>" . $contact_message;


        // Assuming there's no error, send the email and redirect to Thank You page
        
        $msg =   Message::to('malobacomark@gmail.com')
                                    ->from($to_email)
                                    ->subject($subject)
                                    ->body($email_body)
                                    ->html(true) 
                                    ->send();
        if( $msg ) {	
                echo '<i class="fa fa-check"></i> Thank you ' .$_POST["contact_name"]. '. Your Email was successfully sent!';

        } else {	
                echo '<i class="fa fa-times"></i> Sorry ' .$contact_name. '. Your Email was not sent. Resubmit form again Please..';
        }        
   }     
}
