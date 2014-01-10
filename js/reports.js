window.onload = function () {
	//loadResult();
  // var datep = $('.datepicker').datepicker().on('changeDate', function(ev) {datep.hide();}).data('datepicker');
}

$(document).ready(function(){
	$('#distribute-table').hide();
	
    if($('.dataTable_1').length > 0){
		$('.dataTable_1').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sLengthMenu": "_MENU_ <span>entries per page</span>"
					},
                    "aoColumns": [
			            /* Checkbox */  null,
			            /* Prefix */    null,
                        /* Serial */    null,
                        /* Value */     null
		            ]
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
				var oTable = $(this).dataTable(opt);
                $("#check_all_1").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);

				});

			}
		});
    }
	
	
	
            $('#btnCondition').click(function () {
                var query = {};
                query = getCondition('.query > table');
                //var l = JSON.stringify(query,null,4);
                var l = JSON.stringify(query);
                //alert(l);
            });

            $('#btnQuery').click(function () {
                var con = getCondition('.query >table');
                var k = getQuery(con);
                //alert(k);
            });
            addqueryroot('.query', true);
			
			$('#btnFriendQuery').click(function () {
						var con = getCondition('.query >table');
						var fq = getFriendlyQuery(con);
						//alert(fq);
					});
	
	})
	
function loadResult(){
	$('#distribute-table').hide();
    $('.power-loading').show();		
    var con = getCondition('.query >table');
		var k = getQuery(con);
		var fq = getFriendlyQuery(con);
		//alert();
		
      var valueData = encodeURIComponent(k);
	  var frndSqlQuery = encodeURIComponent(fq);
	  
    var oTable = $('.dataTable_1').dataTable();
    oTable.fnClearTable();
	
	
		
			$.get("classes/reports.class.php",{ data:valueData,frndsql:frndSqlQuery,value:'sql'}, function(data) {
			      //alert(data);
					if (data.match('id="error"') !== null) {
						$('.power-loading').hide();
						$('#distribute-table').show();
						$('#distribute-text').html(data);
					    $('#printReport').html('');

						$('#distribute-text').show();
					} else {
					  
					   $('.power-loading').hide();
						var jsonD = JSON.parse(data);
						console.log(jsonData);
						var jsonData = jsonD[0];
						var reportId = jsonD[1];
						
						for (var i in jsonData) {
							var rec = jsonData[i];
							console.log(rec);
							
							if(rec.credit == null){
							  var credit = 0;
							}else{var credit = rec.credit;}
							
							if(rec.debit == null){
							  var debit = 0;
							}else{var debit = rec.debit;}
							
								$('#distribute-table').show().dataTable().fnAddData([
								  rec.date,
								  rec.entry,
								  credit,
								  debit
								]);
								 $('.power-loading').hide();
								$('#distribute-table tr:last').attr('id',rec.id);

						}
						//alert(reportId);
			             $('#printReport').html(' <a href="forms/mReports.php?id='+reportId+'" target="_blank" class="btn btn-primary" style="float:right">Report</a>')
						$('#distribute-text').hide();
						$('#distribute-table').show();
					}
			
			})
}

function getvalue(val){
	// $('.col')= $(this);
	var value = val;
	//alert(val);
		if(value =='date'){
			
			$('#inputText').html('<input type="text"  id="valData" class="form-control datepicker span2"/>');	
			var distributedate = $('.datepicker').datepicker().on('changeDate', function(ev) {distributedate.hide();}).data('datepicker');
		
		  }else{
				 $('#inputText').html('<input type="text"  id="valData" class="form-control span2"/>');	
		  }

}

function checkVal(){
}


