jQuery(document).ready(function() {
   var $picker = $('.datetime').datepicker({
    //endDate: '+0d',
    format: 'yyyy-mm-dd'
  });
  
   var $picker2 = $('#prequalification_cert_date').datepicker({
    endDate: '+0d',
    format: 'yyyy-mm-dd'
  });  
});