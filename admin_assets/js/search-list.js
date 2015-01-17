$(document).ready(function() {
	$('.dataTable').dataTable( {
		"bDestroy": true
	} );
 if($('.searchTable').length > 0){
		$('.searchTable').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Search:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sLengthMenu": "_MENU_ <span>entries per page</span>"
					}
				};
				if($(this).hasClass("dataTable-noheader")){
					opt.bFilter = false;
					opt.bLengthChange = false;
				}
				if($(this).hasClass("dataTable-nofooter")){
					opt.bInfo = false;
					opt.bPaginate = false;
				}
				if($(this).hasClass("dataTable-nosort")){
					var column = $(this).attr('data-nosort');
					column = column.split(',');
					for (var i = 0; i < column.length; i++) {
						column[i] = parseInt(column[i]);
					};
					opt.aoColumnDefs =  [
					{ 'bSortable': false, 'aTargets': column }
					];
				}
				if($(this).hasClass("dataTable-scroll-x")){
					opt.sScrollX = "100%";
					opt.bScrollCollapse = true;
				}
				if($(this).hasClass("dataTable-scroll-y")){
					opt.sScrollY = "300px";
					opt.bPaginate = false;
					opt.bScrollCollapse = true;
				}
				if($(this).hasClass("dataTable-reorder")){
					opt.sDom = "Rlfrtip";
				}
				if($(this).hasClass("dataTable-colvis")){
					opt.sDom = 'C<"clear">lfrtip';
					opt.oColVis = {
						"buttonText": "Change columns <i class='icon-angle-down'></i>"
					};
				}
				if($(this).hasClass('dataTable-tools')){
					if($(this).hasClass("dataTable-colvis")){
						opt.sDom= 'TC<"clear">lfrtip';
					} else {
						opt.sDom= 'T<"clear">lfrtip';
					}
					opt.oTableTools = {
						"sSwfPath": BASE + "/admin_assets/js/plugins/datatable/swf/copy_csv_xls_pdf.swf"
					};
				}
				if($(this).hasClass("dataTable-scroller")){
					opt.sScrollY = "300px";
					opt.bDeferRender = true;
					if($(this).hasClass("dataTable-tools")){
						opt.sDom = 'T<"clear">frtiS';
					} else {
						opt.sDom = 'frtiS';
					}
					//opt.sAjaxSource = "js/plugins/datatable/demo.txt";
				}
				var oTable = $(this).dataTable(opt);
				$('.dataTables_filter input').attr("placeholder", "Search here...");
				$(".dataTables_length select").wrap("<div class='input-mini'></div>").chosen({
					disable_search_threshold: 9999999
				}); 
        $(".dataTables_length").hide();
				$("#check_all").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);
				});
				if($(this).hasClass("dataTable-fixedcolumn")){
					new FixedColumns( oTable );
				}
				if($(this).hasClass("dataTable-columnfilter")){
					oTable.columnFilter({
						"sPlaceHolder" : "head:after"
					});
				}
			}
		});
  }
  
});


