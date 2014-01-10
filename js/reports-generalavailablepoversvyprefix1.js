window.onload = function () {
	//loadResult();
  // var datep = $('.datepicker').datepicker().on('changeDate', function(ev) {datep.hide();}).data('datepicker');
loadResult();


}


$(document).ready(function(){
	   $('#send').attr('disabled','disabled');


	$('#campaign-table').hide();

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




	})

function loadResult(){
	$('#campaign-table').hide();
    $('.power-loading').show();
    var oTable = $('.dataTable_1').dataTable();
    oTable.fnClearTable();



			$.get("classes/reports-generalavailablepoversvyprefix1.class.php",{ value:'sql'}, function(data) {


					if (data.match('id="error"') !== null) {
						$('.power-loading').hide();
						$('#campaign-table').show();

					    $('#printReport').html('');

						$('#campaign-text').show();
					} else {

					   $('.power-loading').hide();
						var jsonData = JSON.parse(data);
						//console.log(jsonData);
					 for (var i in jsonData) {
							var rec = jsonData[i];

							console.log(rec);
						    $('#campaign-table').show().dataTable().fnAddData([
    		                  
								  rec.prefix,
								  rec.serial,
								  rec.value,
								  rec.date1,
								  rec.agency
								  
								]);
						 $('#reportbutton').html('<a href="forms/generalavailablepoverprefix.php" target="_blank"><button class="btn btn-small btn-primary"><i class=" icon-print"></i> Report</button></a></center>')

								 $('.power-loading').hide();
								//$('#campaign-table tr:last').attr('id',rec.id);

						}
						//alert(reportId);
			            // $('#printReport').html(' <a href="forms/mReports.php?id='+reportId+'" target="_blank" class="btn btn-primary" style="float:right">Report</a>')
						$('#campaign-table').find('.checkval').closest('tr').find('.sorting_1').hide();

						$('#campaign-text').hide();
						$('#campaign-table').show();
					}

			})
}



function sendData(){
	    var arr = [];
	    var email = [];
	    var message = [];
	    var auto = [];
	    var letter = [];
		
		console.log($('#campaign-table').find('.checkval:checked'));
			$('#campaign-table').find('.checkval:checked').each(function(){
					
				
				var a = $(this).closest('tr').find('td:eq(0) .checkval').val();
				var b = $(this).closest('tr').find('td:eq(1) .isletter').val();
				var c = $(this).closest('tr').find('td:eq(2) .isemail').val();
				var d = $(this).closest('tr').find('td:eq(3) .ismessage').val();
				var e = $(this).closest('tr').find('td:eq(4) .isautomatedcall').val();
				var f = $(this).closest('tr').find('td:eq(5)').html();
				var g = $(this).closest('tr').find('td:eq(6)').html();
				var h = $(this).closest('tr').find('td:eq(7)').html();
		       
				var da = a +',' + b +','+ c +','+ d +',' + e
				arr.push(da)
			if( b == 1){	
   			 $.ajax({
				   type: "GET",
				   data: {id:a},
				   url: "forms/compaignletter.php",
				   success: function(data){
					   var url =  'forms/compaignletter.php?id='+a;
					   window.open(url,'_blank');
					// $('.answer').html(data);
				   }
				});		
			   }
			});
			alert(arr);
			$.get('classes/campaign.class.php',{send:arr}).done(function(data){
				
				
			})
			
		var userid = [];
}

function checkAll(bx)
{
 var cbs = document.getElementsByTagName('input');
 for(var i=0; i < cbs.length; i++)
 {
    if(cbs[i].type == 'checkbox')
    {
        cbs[i].checked = bx.checked;
		checkData();
     }
 }
}


function getvals(sa){
var kal = $(sa).parent();

console.log(kal)

}

function campaignCheck(get){
	console.log(get);

	if(get.is(':checked')){ 
		 get.val(1); 
		 get.parent().parent().find('.checkval').attr('checked','checked'); 
		 checkData();
	 }else{
		get.val(0);
		get.parent().parent().find('.checkval').removeAttr('checked'); 
		checkDataFalse();
	 }

}

function checkData(){
	
	 $('#campaign-table td input:checked').each(function(){
	   $('#send').prop('disabled',false);
	   $('#generate').attr('disabled','disabled');
	})
}

function checkDataFalse() {
		$('#send').attr('disabled','disabled');
		$('#generate').prop('disabled',false);
		checkData()
	}

/*
if($(this).is(\':checked\')){ $(this).val(1); $(this).parent().parent().find(\'.checkval\').attr(\'checked\',\'checked\'); checkData(); }else{$(this).val(0);$(this).parent().parent().find(\'.checkval\').removeAttr(\'checked\'); checkDataFalse();}
*/