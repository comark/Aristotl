jQuery(document).ready( function() {
  
  jQuery("#start_date, #end_date").datepicker({
    format: 'dd-mm-yyyy',
    //startDate: '0'
  });

  var click_url = BASE + '/analytics/adminadviews';
  get_analytics(click_url, 'analytics1');

function get_analytics(url, func) {
  var ret = new Object();
  jQuery.ajax({
    url: url,
    type: 'GET',
    async: 'false',
    success: function(response, textStatus, xhr) {
      ret.obj = response;
      ret.status = xhr.status;

    },
    error: function(xhr, ajaxOptions, thrownError) {
      ret.status = xhr.status;
      ret.obj = thrownError;
    },
   complete: function(xhr,textStatus) {
      if ( ret.status == 200 ) {
        if (func == 'analytics1') {
          call_analytics_one(ret.obj);
        }
     }
   }
  });  
}

function call_analytics_one(data) {
  if(jQuery("#flot-analytics-1").length > 0){
   var list = new Array();
   for ( i=0; i<data.length; i++ ){
     var inner_array = new Array();
     var timestamp = parseInt(data[i].created_at) * 1000;
     inner_array.push(timestamp);
     inner_array.push(1);
     list.push( inner_array);
   }

    var data = [[1262304000000, 1300], [1264982400000, 2200], [1267401600000, 3600], [1270080000000, 5200], [1272672000000, 4500], [1275350400000, 3900], [1277942400000, 3600], [1280620800000, 4600], [1283299200000, 5300], [1285891200000, 7100], [1288569600000, 7800], [1291241700000, 8195]];


    jQuery.plot(jQuery("#flot-analytics-1"), [{ 
      label: "Visits", 
      data: list,
      color: "#3a8ce5"
    }], {
      xaxis: {
        min: (new Date(2012, 12, 1)).getTime(),
        max: (new Date(2013, 11, 31)).getTime(),
        mode: "time",
        tickSize: [1, "month"],
        monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
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
      grid: { hoverable: true, clickable: true },
      legend: {
        show: false
      }
    });

    jQuery("#flot-analytics-1").bind("plothover", function (event, pos, item) {
      if (item) {
        if (previousPoint != item.dataIndex) {
          previousPoint = item.dataIndex;

          jQuery("#tooltip").remove();
          var y = item.datapoint[1].toFixed();

          showTooltip(item.pageX, item.pageY,
                      item.series.label + " = " + y);
        }
      }
      else {
        jQuery("#tooltip").remove();
        previousPoint = null;            
      }
    });

  }

}
// end call_ananlytics_one
});


