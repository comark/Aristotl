<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Libraries;
use \FPDI;
use YagpoM;
use UserM;

class PDFGenerate{
  
  public static function generate_cert($user_id, $input){
    
  $cert_number = PDFGenerate::get_cert_number($input);
  $business = YagpoM\BusinessMain::get_user($user_id);
  $public = path('public').'bundles/certificates/';


  $pdf = new FPDI();
  // add a page
  $pdf->AddPage(array(1170,827));
  $pdf->AddFont('georgia', '', 'Georgia.php');
  $pdf->AddFont('georgia-bold', '', 'GeorgiaBold.php');
  $pdf->AddFont('georgia-italic', '', 'GeorgiaItalic.php');
  // set the source file
  $pdf->setSourceFile($public."tpl/tpl.pdf");
  // import page 1
  $tplIdx = $pdf->importPage(1);
  // use the imported page and place it at point 10,10 with a width of 100 mm
  $pdf->useTemplate($tplIdx, 0, 0, 310);

  // Cert number
  $pdf->SetFont('Georgia-Italic','',14);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(40, 40);
  $pdf->Write(0, $cert_number);
  
  // Broad category
  $pdf->SetFont('Georgia-Bold','',12);
  $pdf->SetTextColor(0, 0, 0);
  if ( $input['group'] == 'DISADVANTAGED GROUP-WOMEN') {
    $pdf->SetXY(112, 73);
  } else if ( $input['group'] == 'YOUTH ACCESS TO GOVERNMENT PROCUREMENT OPPORTUNITIES (YAGPO)') {
    $pdf->SetXY(50, 73);
  } else if ( $input['group'] == 'PERSONS WITH DISABILITY') {
    $pdf->SetXY(112, 73);
  }
  
  $pdf->Write(0, $input['group']);

  
  // Company Name
  if ( $business && $business->business_name ) {
   $pdf->SetXY(110, 85);
   $pdf->SetTextColor(0, 0, 0);
   $pdf->Write(8, strtoupper($business->business_name));
  }

  
  
  // Dates
  $pdf->SetXY(155, 93);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->Write(8, date('jS'));  
  
  $pdf->SetXY(185, 93);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->Write(8, date('F')); 
  
  // Bottom Category  
  $pdf->SetXY(40, 128);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->Write(8, $input['sector']); 
  
  
    // Address
  if ( $business && $business->address_box ) {
    $pdf->SetFont('Georgia-Bold','',8);
    $pdf->SetXY(60, 93);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Write(8, $business->address_box);  
  }
  
  $pdf->Output($public.$user_id.'.pdf');  
 
  }
  
  public static function generate_image($user_id) {
    $cert = UserM\UserCertificates::get_user($user_id);
    $path = path('public').'bundles/certificates/'.$cert->url;
    $im = new \imagick($path.'[0]');
    $im->setImageFormat('jpg');
    $im->writeImage(path('public').'bundles/certificates/'.$user_id.'.jpg');
    $im->clear();
    $im->destroy();    
  }
    
  public static function get_cert_number($input) {
    $group_array = array(
       'YOUTH ACCESS TO GOVERNMENT PROCUREMENT OPPORTUNITIES (YAGPO)' => 'YP',
       'DISADVANTAGED GROUP-WOMEN' => 'DGW',
       'PERSONS WITH DISABILITY' => 'PWD'
    );
    
    $sector_array = array(
        'ICT' => 'A',
        'Small works and Engineering' => 'B',
        'Professional Services and Consultancy' => 'C',
        'Fresh Produce and Agricultural Products' => 'D',
        'General Supplies' => 'E'
    );
    $group = $group_array[$input['group']];
    $sector = $sector_array[$input['sector']];
    $number = $input['certificate_number'];
    
    if ( $group == 'DGW') {
      $sector = 'A';
    } else if ($group == 'PWD') {
      $sector = 'F';
    }
    
    $cert_number = 'NO.NT/PPD/'.$group.'/'.$number.'/'.$sector;
    return $cert_number;
    
  }
}
