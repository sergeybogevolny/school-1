$(document).ready(function() {

    var form_wizard = $("#form-wizard");


    mv = new Array();
    mvi = 0;

	if (form_wizard.length > 0) {
		form_wizard.formwizard({
            formPluginEnabled: true,
			validationEnabled: true,
			focusFirstInput : false,
			disableUIStyles:true,
            inDuration: 0,
			validationOptions: {
				errorElement:'span',
				errorClass: 'help-block error',
				errorPlacement:function(error, element){
					element.parents('.controls').append(error);
				},
				highlight: function(label) {
					$(label).closest('.control-group').removeClass('error success').addClass('error');
				},
				success: function(label) {
					label.addClass('valid').closest('.control-group').removeClass('error success').addClass('success');
				}
			},
            formOptions :{
				success: function(data){
                    if (data.match('success') !== null) {
                         var $response=$(data);
                         var id = $response.filter('#status').text();
						 $('#reportbutton').html('<a href="forms/powerreceipt.php?id='+id+'" target="_blank"><button class="btn btn-small btn-primary"><i class=" icon-print"></i> Report</button></a></center>')
						 $('#form-wizard').hide();
						 $('#success').show();
						 $('#report-button').show();
                         //window.location = "powers-available.php";
                    } else {
                        $("#jqxWindow-status").jqxWindow('setTitle', 'Error');
                        $('#jqxWindow-status').jqxWindow({ content: data });
                        $('#jqxWindow-status').jqxWindow('open');
                        $('#jqxWindow-status').jqxWindow('focus');
                    }
				},

			},
            textSubmit: 'Create',
			textNext: 'Next',
			textBack: 'Back',
		}).bind("step_shown",function(){ // as the next button is not handled by the wizard, we need to handle the button caption ourselves
            var step = $("#form-wizard").formwizard("state").currentStep;
            StepValidate(step);

        }).trigger("step_shown");


        form_wizard.bind("before_step_shown", function(e, data) {
			
            var step = data.currentStep;
            if (step=='secondStep'){
                LoadResults();
            }
			
             var date 			= $("#powers-void-date").val();
			 var power 			= $("#powers-void-power").val();
			 var comment 		= $("#powers-void-comment").val();
			 
			 $("#review_date").text(date);
			 $("#review_power").text(power);
			 $("#review_comment").text(comment);
			 if (comment==''){
                $("#group-comment").hide();
             } else {
			    $("#review_comment").text(comment);
                $("#group-comment").show();
			 }
            

          

		});

	}

    $("#filter-prefix").change(function() {
        LoadResults();
    });

    $('#filter-serial').keyup(function() {
        LoadResults();
    });
    $('#filter-count').keyup(function() {
        LoadResults();
    });

    $("#distribute-add").click(function(e){
        e.preventDefault();
        AddDistribute();
        CalcDistribute();
	});

    $("#bin-remove").click(function(e){
        e.preventDefault();
        RemoveBin();
        CalcDistribute();
        LoadResults();
	});



	var datepicker = $('.datepicker').datepicker().on('changeDate', function(ev) {datepicker.hide();}).data('datepicker');
	var datep = $('.datep').datepicker().on('changeDate', function(ev) {datep.hide();}).data('datepicker');
	var datepe = $('.datepe').datepicker().on('changeDate', function(ev) {datepe.hide();}).data('datepicker');
	$("#report-bufpaymentname").autoNumeric('init');
	$("#report-netpaymentname").autoNumeric('init');
   
   
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

		$('.dataTable_2').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
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
				var oTable = $(this).dataTable(opt);
                $("#check_all_2").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);
				});
			}
		});
		
		


    $("#form-wizard").show();
	
	$('#distribute-agent').change(function(){ //get selected option id 
		var id = $(this).find(':selected')[0].id;
		$('#distribute-agent-id').val(id);
	})

    $("#form-wizard").show();

    $(".first-required").change(function() {
        StepValidate('firstStep');
    });

});


function Stepfirstvalidate(){
            var reportdate = $('#powers-void-date').val();
            //var reportpower = $('#powers-void-power').val();
			
			if(reportdate.length == 0 ){
			  $("#next").attr("disabled", "disabled");
			}
			else{
			   $('#next').prop('disabled', false);
			}
			
}



function surtyDetail(surtyaction){
			var oTable = $('.dataTable_1').dataTable();
			oTable.fnClearTable();
			$('.power-loading').show();
			$.get('classes/wizards_powers_void.class.php', { reportsurty:surtyaction }, function (data) {
				if (data.match('id="error"') !== null) {
	                $('.power-loading').hide();
					$('#detail-text').html(data);
					$('#detail-text').show();
				} else {
				    $('.power-loading').hide();
					var jsonData = JSON.parse(data);
					console.log(data);
					var count = 0;
					var sum   = 0;
					for (var i in jsonData) {
						var rec = jsonData[i];
				 $('#detail-list').dataTable().fnAddData([
							 '<input type="checkbox" name="report_detail" class="icheck-me" value="" data-skin="square" data-color="blue" id=""  onclick="validateSecondStep()">',				 
									rec.prefix,
									rec.serial,
									rec.executeddate,
									rec.amount,
									rec.first,
									rec.middle,
									rec.last,
									
								]);
					  ++count;
					  var s = eval(rec.amount);	
					  sum += s ;
                    // $('#detail-list tr:last').attr('id',rec.id);
					}
						$("#count").html('Count :'+count);
						$("#sum").html('Sum :'+sum);
					
					$('#detail-list').show();
				}
			});
}



function validateSecondStep()
{
	$("#next").attr("disabled", "disabled");
	$('#detail-list td input:checked').each(function(){
			
			$('#next').prop('disabled', false);
	   
	  });

}




    function AddDistribute(){
         $('#void-table td input:checked').each(function(){
            var a = $(this).closest('tr[id]').find('td:eq(1)').html();
            var b = $(this).closest('tr[id]').find('td:eq(2)').html();
            var c = $(this).closest('tr[id]').find('td:eq(3)').html();
            c = parseFloat(c);
            c = c.toFixed(2);
            $('#void-bin').dataTable().fnAddData([
		        '<input type="checkbox" name="check" value="1">',
		        a,
		        b,
                c
            ]);
            var rowindex = $('#void-table').dataTable().fnGetPosition($(this).closest('tr')[0]);
            $('#void-table').dataTable().fnDeleteRow(rowindex);
        });
    }

    function RemoveBin(){
         $('#void-bin td input:checked').each(function(){
            var rowindex = $('#void-bin').dataTable().fnGetPosition($(this).closest('tr')[0]);
            $('#void-bin').dataTable().fnDeleteRow(rowindex);
        });
    }

    function CalcDistribute(){
        var rcount = 0;
        var rvalue = 0;

        var thead = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Prefix</th><th>Serial</th><th>Value</th></tr></thead><tbody>';
        var trow = '';
        var tfoot = '</tbody><tfoot></tfoot></table>';

        $('#next').prop('disabled', true);
        var rows = $("#void-bin").dataTable().fnGetNodes();
        for(var i=0;i<rows.length;i++)
        {

            var a = $(rows[i]).find("td:eq(1)").html();
            var b = $(rows[i]).find("td:eq(2)").html();
            var c = $(rows[i]).find("td:eq(3)").html();

            rcount = rcount + 1;
            rvalue += parseFloat(c);

            a = a +'<input type="hidden" name="prefixmv[]" value="'+a+'">';
            b = b +'<input type="hidden" name="serialmv[]" value="'+b+'">';
            c = c +'<input type="hidden" name="valuemv[]" value="'+c+'">';

            var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+c+'</td></tr>';
            trow = trow + line;

            $('#next').prop('disabled', false);
        }

        var tfull = thead+trow+tfoot;
        document.getElementById("review_powers").innerHTML = tfull;

        $("#review-count").html('Total Count: '+rcount);
        $("#review-value").html('Total Value: '+rvalue);

        $("#void-count").html('Total Count: '+rcount);
        $("#void-value").html('Total Value: '+rvalue);
    }






function LoadResults(){
    var oTable = $('.dataTable_1').dataTable();
    oTable.fnClearTable();
	$('.power-loading').show();
	$('#void-table').hide();

    var prefix =  $("#filter-prefix").val();
    var serial =  $("#filter-serial").val();
    var count =  $("#filter-count").val();
    $.post('classes/wizards_powers_void.class.php', { "list-filter": 1, "filter-prefix": prefix, "filter-serial": serial, "filter-count": count }, function (data) {
        if (data.match('id="error"') !== null) {
	        $('.power-loading').hide();
			$('#void-table').show()
            $('#void-table').hide();
            $('#void-text').html(data);
            $('#void-text').show();
        } else {
			$('.power-loading').hide();
            var jsonData = JSON.parse(data);
            for (var i in jsonData) {
                var rec = jsonData[i];
                if (!InBin(rec.prefix,rec.serial)){
					
                    $('#void-table').show().dataTable().fnAddData([
    		            '<input type="checkbox" name="check" value="1">',
    		            rec.prefix,
    		            rec.serial,
                        rec.value
                    ]);
                    $('#void-table tr:last').attr('id',rec.id);
                }
            }
            $('#void-text').hide();
            $('#void-table').show();
        }
    });
}

function InBin(prefix,serial){
    var rows = $("#void-bin").dataTable().fnGetNodes();
    for(var i=0;i<rows.length;i++)
    {
        var a = $(rows[i]).find("td:eq(1)").html();
        var b = $(rows[i]).find("td:eq(2)").html();
        if ((a==prefix) && (b==serial)){
            return true;
        }
    }
    return false;
}

function StepValidate(step){
    var bval = true;
    switch (step){
        case 'firstStep':
            $("#next").attr("disabled", "disabled");
            break;
			
        case 'secondStep':
			 $('#next').prop('disabled', true);
			 var power = $('#powers-void-power :checked').text();
			 var serial = power.split('-');
			 $('#serial_no').val(serial[0]);
             break;
        
    }
}



