<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Admin\Libraries;
use Asset;

class ArAssets{
  
  public static function listing_assets(){
    //dataTables 
    Asset::add('datatables-js','admin_assets/js/plugins/datatable/jquery.dataTables.min.js');
    Asset::add('tabletools-js','admin_assets/js/plugins/datatable/TableTools.min.js');
    Asset::add('colreorder-js','admin_assets/js/plugins/datatable/ColReorder.min.js');
    Asset::add('colvis-js','admin_assets/js/plugins/datatable/ColVis.min.js');
    Asset::add('columnfilter-js','admin_assets/js/plugins/datatable/jquery.dataTables.columnFilter.js');
    //Chosen
     Asset::add('chosen-js','admin_assets/js/plugins/chosen/chosen.jquery.min.js');     
     //CSS
     Asset::add('tabletools-css','admin_assets/css/plugins/datatable/TableTools.css');
     Asset::add('chosen-css','admin_assets/css/plugins/chosen/chosen.css');    
  }
  
  public static function form_assets(){
          //Images loaded
     Asset::add('imageloader-js', 'admin_assets/js/plugins/imagesLoaded/jquery.imagesloaded.min.js');
     //Select 2
     Asset::add('select2-js', 'admin_assets/js/plugins/select2/select2.min.js');    
     //Bootbox
     Asset::add('bootbox-js', 'admin_assets/js/plugins/bootbox/jquery.bootbox.js');
     // Validation 
     Asset::add('validate-js', 'admin_assets/js/plugins/validation/jquery.validate.min.js');
     Asset::add('additional-js', 'admin_assets/js/plugins/validation/additional-methods.min.js');
     // Custom file upload 
     Asset::add('fileupload-js', 'admin_assets/js/plugins/fileupload/bootstrap-fileupload.min.js');    
     //CSS
     Asset::add('tagsinput-css', 'admin_assets/css/plugins/tagsinput/jquery.tagsinput.css');
     Asset::add('select2-css', 'admin_assets/css/plugins/select2/select2.css');       
  }
}
