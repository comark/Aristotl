jQuery(document).ready( function() {
    jQuery('<div class="loader"></div>').css( {
      display:    'block',
      position:   'relative',
      'z-index':  1000,
      top:        0,
      left:       0,
      height:     '200px',
      width:      '100%',
      'background-color': 'rgba( 255, 255, 255, .8 )',
      'background-image': 'url('+ BASE +'/admin_assets/img/loading.gif)',
      'background-position': '50% 50%',
      'background-repeat': 'no-repeat',
    }).appendTo(".analytics-section");
  
    jQuery(".analytics-section").hide();
    jQuery(".analytics-inner").hide();
    jQuery(".analytics-section").css('position','relative');
    jQuery(".content-slideDown").click(function (e) {
      e.preventDefault();
      var $el = jQuery(this),
      content = $el.parents('.box').find(".box-content");
      content.slideToggle('fast', function(){
         $el.find("i").toggleClass('icon-angle-up').toggleClass("icon-angle-down");
         if(!$el.find("i").hasClass("icon-angle-up")){
          if(content.hasClass('scrollable')) slimScrollUpdate(content);
         } else {
          if(content.hasClass('scrollable')) destroySlimscroll(content);
         }
         
         if( content.data('hascontent') == 'no') {
            var ad_id = content.data('adid');
            var url = BASE + '/analytics/api/getaddata/' + ad_id
            jQuery.ajax({
              type: 'GET',
              url: url,
              timeout: 5000,
              async: 'false',
              success: function(data) {
                var plot_array = new Array();
                //console.log(data);
                jQuery.each( data.dates, function(key,value){
                  var d = key.match(/\d+/g);
                  var timestamp = +new Date(d[0], d[1] - 1, d[2]);
                  var plot_point = [timestamp, value];
                  plot_array.push(plot_point);
                });
                
                
                var $grid = content.find('#flot-analytics');
                jQuery.plot($grid, [{
                  label:"Ad Clicks",
                  data:plot_array,
                  color:"#3a8ce5"
                }], { 
                      xaxis: {
                        mode: "time"
                      },
                      series: {
                        lines: {
                          show: true, 
                          fill: true
                        },
                        points: {
                          show: true,
                        }
                      },
                      grid: { hoverable: true, clickable: true }
                    
                });
                
                $grid.bind("plothover", function (event, pos, item) {
                   
                    if (item) {
                      if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var y = item.datapoint[1].toFixed();
                        var x = item.datapoint[0];
                        var date = new Date(x);
                        var month_display = null;
                        var day_display = null;
                        if( (date.getMonth() +1 ) < 10  ) {
                           month_display =  date.getMonth() +1;
                           month_display = "0" + month_display.toString();
                        } else {
                           month_display =  date.getMonth() +1;
                           month_display = month_display.toString();                          
                        }
                        
                        if( (date.getDay() + 1 ) < 10  ) {
                           day_display =  date.getDay() +1 ;
                           day_display = "0" + day_display.toString();
                        } else {
                           day_display =  date.getDay() + 1;
                           day_display = day_display.toString();                          
                        }                        
                        var date_display = day_display +'-'+ month_display +'-'+ date.getFullYear(); 
                        showTooltip(item.pageX, item.pageY,
                                    date_display + ':  '+ item.series.label + " = " + y );
                      }
                    }
                    else {
                      $("#tooltip").remove();
                      previousPoint = null;            
                    }
                 });

                var cats = data.categories.join();
                var platforms = jQuery.map(data.platforms, function (k,v){ return [k];});
                platforms = platforms.join();
                
                var devices = jQuery.map(data.devices, function (k,v){ return [k];});
                devices = devices.join();
                
                var total = data.total;
                
                content.find('.al-categories').text(cats);
                content.find('.al-platforms').text(platforms);
                content.find('.al-devices').text(devices);
                content.find('.al-total').text(total);
                
                var src = BASE + '/' + data.image;
                var img = jQuery('<img/>').attr('src', src);
                jQuery(img).css('width','100px');
                
                content.find('.al-image').append(img);
                content.find('.loader').hide();
                content.find('.analytics-inner').show();

                content.data('hascontent','yes');
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {

                jQuery('.loader').hide();

               var error_title = 'Error';
               var error_text = 'There was a problem getting the analytics';

               //jQuery.fn.AnalyticsDialog(error_title,error_text);
              }
            });//end ajax call        
         }
      });
  });
});

jQuery.fn.AnalyticsDialog = function(title, text){
  var body = 
			['<div class="row-fluid">',
				'<div class="span12" id="modal-text">' + text + '</div>',
			'</div>'].join('\n');
    jQuery("#modal-title").text(title);
    jQuery("#modal-body").html(body);
    jQuery("#modal-notification").modal("show");
};
