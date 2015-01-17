/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



jQuery(document).ready(function () {
  
  jQuery('#main').on('click', '.createtpl', function(e) {
    e.preventDefault();
    var seats = jQuery('#seats').val();
    var title = jQuery('#title').val();
    
    if ( seats < 1 ) {
       var error_title = 'Error';
       var error_text = 'Please enter a valid number of seats';
       jQuery.fn.iFastDialog(error_title,error_text);
       return;
    }

    jQuery('.loader').show();
    
    var url = BASE + '/ifast/template/gettpl';
    var subData = 'seats=' + seats + '&title=' + title; 
    jQuery.ajax({
      type: 'POST',
      url: url,
      data: subData,
      timeout: 5000,
      async: 'false',
      success: function(data) {
        jQuery('.row-fluid').remove();
        jQuery('#main .container-fluid').append(data);
       // console.log(data);
       
        jQuery('.loader').hide();
        
        var height = jQuery("#main").height();
        jQuery('#left').css({'top': '0','height': height + 'px'});
        var footer_height = jQuery('#footer').height();
        height = footer_height + height;
        jQuery('#footer').css({'top': height + 'px','position': 'absolute'});
        
        resizeContent();
        jQuery(".seat").draggable({
		      snap: ".targetseat",
		      snapMode: "inner"
	      });
         
        return false;
        
        
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        
        jQuery('.loader').hide();
               
       var error_title = 'Error';
       var error_text = 'There was a problem getting the templates. Contact the administrator';
       
       jQuery.fn.iFastDialog(error_title,error_text);
      }
    }); 
     
  });

  jQuery('#main').on('click', '.savetpl', function(e) {
    e.preventDefault();
    jQuery('.loader').show();
    tilesObj = new Object();
    tilesObj.targets = new Array();
    tilesObj.seats   = new Array();
    tilesObj.mapped  = new Array();
    
    jQuery('.targetseat').each( function(index, value){
       var target = new Object();
       
       target.id = jQuery(value).attr('id');       
       var position = jQuery(value).position();
       target.left = position.left;
       target.top = position.top;
       
       tilesObj.targets.push(target);
    });
    
    jQuery('.seat').each( function(index, value){
       var seat = new Object();
       
       seat.id = jQuery(value).attr('id');       
       var position = jQuery(value).position();
       seat.left = position.left;
       seat.top = position.top;
       
       tilesObj.seats.push(seat);
    });
    
    // Go through the target and see if any seat dragged matches
    
    jQuery(tilesObj.targets).each( function(index, value) {
      var target_left = value.left;
      var target_top  = value.top;
      
        // run through the seats to see which has been placed correctly
        jQuery.grep(tilesObj.seats, function(n,i) {
           var source_left = n.left;
           var source_top  = n.top;
           
           if ( ( source_left == target_left ) && (source_top == target_top) ) {
              var map = new Object();
              map.target = value.id;
              map.source = n.id;
              map.left   = target_left;
              map.top    = target_top;
              
              tilesObj.mapped.push(map);
           }
        });
    });
    
     // check to see that all the seats are allocated
     var numbers_mapped = tilesObj.mapped.length;     
     var seats_passed = jQuery("#number_seats").val();
     
     if ( numbers_mapped < seats_passed ){
       jQuery('.loader').hide();
       
       var error_title = 'Error';
       var error_text = 'All the seats need to be set in the template';
       
       jQuery.fn.iFastDialog(error_title,error_text);
       
     } else {       
       // process the ajax request to save the data
       var tplObj = new Object();
       tplObj.title = jQuery('#title').val();
       tplObj.seats = jQuery('#number_seats').val();
       tplObj.data = tilesObj.mapped;
    
       //console.log(JSON.stringify(tplObj));
        var url = BASE + '/ifast/template/newtpl';
        jQuery.ajax({
          type: 'POST',
          url: url,
          contentType: "application/json",        
          data: JSON.stringify(tplObj),
          timeout: 5000,
          async: 'false',
          success: function(data) {
           // console.log(data); return;
            jQuery('.row-fluid').remove();
            jQuery('#main .container-fluid').append(data);

            jQuery('.loader').hide();

            var height = jQuery("#main").height();
            jQuery('#left').css({'top': '0','height': height + 'px'});
            var footer_height = jQuery('#footer').height();
            height = footer_height + height;
            jQuery('#footer').css({'top': height + 'px','position': 'absolute'});

            resizeContent();
            return false;
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(errorThrown);
            jQuery('.loader').hide();
            var error_title = 'Error';
            var error_text = 'There was a problem saving the templates. Contact the administrator';

            jQuery.fn.iFastDialog(error_title,error_text);
          }
        }); 
            
     }
    
  });
  
  jQuery('#main').on('click', '.tpl-preview', function(e) {
    e.preventDefault();
    var $link = jQuery(this);
    var id = $link.data('tplid');
        var url = BASE + '/ifast/template/preview/' + id;
        jQuery.ajax({
          type: 'GET',
          url: url,
          contentType: "application/json",
          timeout: 5000,
          async: 'false',
          success: function(data) {
            var tiles = data.data;
            last_tile = 0;
            jQuery.each(tiles, function(k,v){
              if ( last_tile < parseInt(v.target) ) {
                last_tile = parseInt(v.target);
              }
            });
            
            // get the number of rows
            var rows = last_tile / 6;
            var final_row = 0;
            if( rows % 1 === 0 ) {
              final_row = rows;
            } else {
              var remainder = rows % 1;
              final_row = (rows - remainder) + 1;
            }
            
            
            var tile_tpl = new Array();
            for (i=1; i<= ( final_row * 6 ) ; i++ ){
              var obj = jQuery.grep(tiles, function (a) {  if (parseInt(a.target) == i) { return a;}  });
              
              var tile_class = '';
              if ( obj[0] && obj[0].target ) {
                tile_class = 'lime';
              }
              
              var tile_number = '';
              if ( obj[0] && obj[0].source ){
                tile_number = obj[0].source;
              }
              var li = 
                    ['<li class="'+ tile_class +'" id="">',
									  	'<a href="#"><span class="count">'+ tile_number +'</span></a>',
									  '</li>'].join('\n');
              tile_tpl.push(li);
            }
            
            var layout = 
                ['<div class="row-fluid">',
                  '<div class="span12" style="width:496px !important;">',
                    '<div class="box-content">',
                      '<ul class="minitiles ifasttiles">',
                       tile_tpl.join('\n'),
                      '</ul>',
                    '</div>',
                  '</div>',
                '</div>'].join('\n');
            
            jQuery.fn.iFastPreview(data.title + ' Preview', layout);
            return;
            //console.log(data); return;
            jQuery('.row-fluid').remove();
            jQuery('#main .container-fluid').append(data);

            jQuery('.loader').hide();

            var height = jQuery("#main").height();
            jQuery('#left').css({'top': '0','height': height + 'px'});
            var footer_height = jQuery('#footer').height();
            height = footer_height + height;
            jQuery('#footer').css({'top': height + 'px','position': 'absolute'});

            resizeContent();
            return false;
          },
          error: function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(errorThrown);
            jQuery('.loader').hide();
            var error_title = 'Error';
            var error_text = 'There was a problem saving the templates. Contact the administrator';

            jQuery.fn.iFastDialog(error_title,error_text);
          }
        }); 
        
  });
  
});

jQuery.fn.iFastDialog = function(title, text){
  var body = 
			['<div class="row-fluid">',
				'<div class="span12" id="modal-text">' + text + '</div>',
			'</div>'].join('\n');
    jQuery("#modal-title").text(title);
    jQuery("#modal-body").html(body);
    jQuery("#modal-notification").modal("show");
};

jQuery.fn.iFastPreview = function(title, body){
    jQuery("#modal-title").text(title);
    jQuery("#modal-body").html(body);
    jQuery("#modal-notification").modal("show");
};
