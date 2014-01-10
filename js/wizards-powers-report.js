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
						 $('#reportbutton').html('<a href="forms/agencybail1.php?id='+id+'" target="_blank"><button class="btn btn-small btn-primary"><i class=" icon-print"></i> Report</button></a></center>')
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
                 LoadExecuted();
				$('#back').prop('disabled', true);
            }else{

			   $('#back').prop('disabled', false);
			}

            if (step=='thirdStep'){
                LoadVoided();
            }
            if (step=='fourthStep'){
                LoadTransfered();
            }


            var reportdate = $("#report-date").val();

            $("#review_reportdate").text(reportdate);

			var reportnetpaymentdate = $('#report-netpaymentdate').val();
			var reportnetpaymentname = $('#report-netpaymentname').val();
			var reportnetpaymentmethod = $('#report-netpaymentmethod').val();
			var reportbufpaymentdate = $('#report-bufpaymentdate').val();
			var reportbufpaymentname = $('#report-bufpaymentname').val();
			var reportbufpaymentmethod = $('#report-bufpaymentmethod').val();

			if(reportnetpaymentdate.length > 0 ){
				$('#group-reportnetdate').show();
				$('#review_reportnetdate').html(reportnetpaymentdate);
			}else{
			     $('#group-reportnetdate').hide();
			}

			if(reportnetpaymentname.length > 0 ){
				$('#group-reportnetamount').show();
				$('#review_reportnetamount').html(reportnetpaymentname);

			}else{
				$('#group-reportnetamount').hide();
			}

			if(reportnetpaymentmethod.length > 0 ){
			   $('#group-reportnetmethod').show();
			   $('#review_reportnetmethod').html(reportnetpaymentmethod);
			}else{
			   $('#group-reportnetmethod').hide();
			}

			if(reportnetpaymentdate.length == 0 && reportnetpaymentname.length == 0 && reportnetpaymentmethod.length == 0 ){
			    $('#group-net').hide();
			}
			if(reportbufpaymentdate.length == 0 && reportbufpaymentname.length == 0 && reportbufpaymentmethod.length == 0 ){
			    $('#group-buf').hide();
			}

			if(reportbufpaymentname.length > 0 ){
			   $('#group-reportbufamount').show();
			$('#review_reportbufamount').html(reportbufpaymentname);
			}else{
			   $('#group-reportbufamount').hide();
			}

			if(reportbufpaymentmethod.length > 0 ){
			   $('#group-reportbufmethod').show();
			  $('#review_reportbufmethod').html(reportbufpaymentmethod);
			}else{
			   $('#group-reportbufmethod').hide();
			}

			if(reportbufpaymentdate.length > 0 ){
			   $('#group-reportbufdate').show();
			   $('#review_reportbufdate').html(reportbufpaymentdate);
			}else{
			   $('#group-reportbufdate').hide();
			}

			var row1 = $("#executed-bin").dataTable().fnGetNodes().length;
			var row2 = $("#void-bin").dataTable().fnGetNodes().length;
			var row3 = $("#transfer-bin").dataTable().fnGetNodes().length;

			if(row1 > 0){
			  $('#group-executed').show();
			}else{
			  $('#group-executed').hide();
			}
			if(row2 > 0){
			  $('#group-power').show();
			}else{
			   $('#group-power').hide();
			}
			if(row3 > 0){
			  $('#group-transfer').show();
			}else{
			  $('#group-transfer').hide();
			}



		});

	}

	//2nd step ############################################################################

    $("#executed-filter").click(function(e){
        LoadExecuted();
	});

    $("#executed-add").click(function(e){
        e.preventDefault();
        AddExecuted();
        CalcExecuted();
	});

    $("#executed-bin-remove").click(function(e){
        e.preventDefault();
        ExecutedRemoveBin();
        CalcExecuted();
        LoadExecuted();
	});


// 3rd step ##############################################################33

    $("#filter-prefix").change(function() {
       LoadVoided();
    });

    $('#filter-serial').keyup(function() {
        LoadVoided();
    });
    $('#filter-count').keyup(function() {
        LoadVoided();
    });

    $("#voided-add").click(function(e){
        e.preventDefault();
        AddVoided();
        CalcVoided();
	});

    $("#bin-remove").click(function(e){
        e.preventDefault();
        RemoveBin();
        CalcVoided();
        LoadVoided();
	});

// 4th step ##############################################################33

    $("#transfer-filter-prefix").change(function() {
       LoadTransfered();
    });

    $('#transfer-filter-serial').keyup(function() {
        LoadTransfered();
    });
    $('#transfer-filter-count').keyup(function() {
       LoadTransfered();
    });

    $("#transfer-add").click(function(e){
        e.preventDefault();
        AddTransfer();
        CalcTransfer();
	});

    $("#transfer-bin-remove").click(function(e){
        e.preventDefault();
        TransferRemoveBin();
        CalcTransfer();
        LoadTransfered();
	});

	var reportdate = $('#report-date').datepicker().on('changeDate', function(ev) {reportdate.hide();}).data('datepicker');
    var netpaymentdate = $('#report-netpaymentdate').datepicker().on('changeDate', function(ev) {netpaymentdate.hide();}).data('datepicker');
    var bufpaymentdate = $('#report-bufpaymentdate').datepicker().on('changeDate', function(ev) {bufpaymentdate.hide();}).data('datepicker');

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
						"sInfoEmpty": 'No entries to show',
						"sLengthMenu": "_MENU_ <span>entries per page</span>",
						"sEmptyTable": "No data available in table",
						"sLoadingRecords": "Please wait - loading..."
					},
                    /*
                    "aoColumns": [
			            /* Checkbox   null,
			            /* Prefix     null,
                        /* Serial    null
		            ]
                    */
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
                    //StepValidate('secondStep');
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





    if($('.dataTable_3').length > 0){
		$('.dataTable_3').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sInfoEmpty": 'No entries to show',
						"sLengthMenu": "_MENU_ <span>entries per page</span>",
						"sEmptyTable": "No data available in table",
						"sLoadingRecords": "Please wait - loading..."
					},
                    /*
                    "aoColumns": [
			            /* Checkbox   null,
			            /* Prefix     null,
                        /* Serial    null
		            ]
                    */
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
                $("#check_all_3").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);
                    //StepValidate('secondStep');
				});

			}
		});
    }

		$('.dataTable_4').each(function(){
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
                $("#check_all_4").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);
				});
			}
		});





    if($('.dataTable_5').length > 0){
		$('.dataTable_5').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sInfoEmpty": 'No entries to show',
						"sLengthMenu": "_MENU_ <span>entries per page</span>",
						"sEmptyTable": "No data available in table",
						"sLoadingRecords": "Please wait - loading..."
					},
                    /*
                    "aoColumns": [
			            /* Checkbox   null,
			            /* Prefix     null,
                        /* Serial    null
		            ]
                    */
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
                $("#check_all_5").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);
                    //StepValidate('secondStep');
				});

			}
		});
    }

		$('.dataTable_6').each(function(){
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
                $("#check_all_6").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);
				});
			}
		});

    $("#form-wizard").show();

    $("#report-surety").change(function() {
		var surety = $('#report-surety').val();
		getDetailAgencySettingsListSurety(surety);
    })


});

function Stepfirstvalidate(){
    var reportdate = $('#report-date').val();
    var reportdate = $('#report-surety').val();

	if(reportdate.length == 0 ){
	    $("#next").attr("disabled", "disabled");
	} else if(reportdate.length == 0){
	    $("#next").attr("disabled", "disabled");
	} else{
		$('#next').prop('disabled', false);
	}
}

function StepValidate(step){
    var bval = true;
    switch (step){
        case 'firstStep':
            $("#next").attr("disabled", "disabled");
            Stepfirstvalidate();
            break;
        case 'secondStep':
            $("#back").attr("disabled", "disabled");
            CalcExecuted();
            break;
        case 'thirdStep':
			 CalcVoided();
			 break;
		case 'fourthStep':
             $("#next").attr("disabled", "disabled");
		     TableRowValidation();
			 CalcTransfer();
			 break;
    }
}


// second step ################################################################################################


function AddExecuted(){
    $('#executed-table td input:checked').each(function(){
        var a = $(this).closest('tr[id]').find('td:eq(1)').html(); //prefix
        var b = $(this).closest('tr[id]').find('td:eq(2)').html(); //serial
        var c = $(this).closest('tr[id]').find('td:eq(3)').html(); //name
        var d = $(this).closest('tr[id]').find('td:eq(4)').html(); //executed
        var e = $(this).closest('tr[id]').find('td:eq(5)').html(); //amount

		var net    = $('#executed-net').val();
		var buf    = $('#executed-buf').val();
		var bufmin  = $('#executed-buf-min').val();
		var netmin  = $('#executed-net-min').val();

		var f = e * net;
		var g = e * buf;
		if( f < netmin ){
		    f = netmin;
		}
		if (g < bufmin){
		    g = bufmin;
		}

		e = parseFloat(e);
		f = parseFloat(f);
        g = parseFloat(g);
        e = e.toFixed(2);
		f = f.toFixed(2);
		g = g.toFixed(2);

        $('#executed-bin').dataTable().fnAddData([
		    '<input type="checkbox" name="check" value="1">',
		    a, //prefix
		    b, //serial
            e, //amount
			f, //net
			g, //buf
            c, //name (hidden)
			d  //executed (hidden)
        ]);

        var rowindex = $('#executed-table').dataTable().fnGetPosition($(this).closest('tr')[0]);
        $('#executed-table').dataTable().fnDeleteRow(rowindex);

        $('#executed-bin td').closest('tr').find('td:eq(6)').hide();
		$('#executed-bin td').closest('tr').find('td:eq(7)').hide();

    });

}

function ExecutedRemoveBin(){
    $('#executed-bin td input:checked').each(function(){
        var rowindex = $('#executed-bin').dataTable().fnGetPosition($(this).closest('tr')[0]);
        $('#executed-bin').dataTable().fnDeleteRow(rowindex);
    });
}

function CalcExecuted(){
    var rcount = 0;
    var ramount = 0;
	var calculatednet = 0;
	var calculatedbuf= 0;

    var thead = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Prefix</th><th>Serial</th><th>Name</th><th>Executed</th><th>Amount</th><th>Net</th><th>BUF</th></tr></thead><tbody>';
    var trow = '';
    var tfoot = '</tbody><tfoot></tfoot></table>';

    var rows = $("#executed-bin").dataTable().fnGetNodes();
    for(var i=0;i < rows.length; i++) {
        var a = $(rows[i]).find("td:eq(1)").html(); //prefix
        var b = $(rows[i]).find("td:eq(2)").html(); //serial
        var c = $(rows[i]).find("td:eq(3)").html(); //amount
        var d = $(rows[i]).find("td:eq(4)").html(); //net
        var e = $(rows[i]).find("td:eq(5)").html(); //buf
        var f = $(rows[i]).find("td:eq(6)").html(); //name
        var g = $(rows[i]).find("td:eq(7)").html(); //executed

        rcount = rcount + 1;
        ramount = ramount + parseFloat(c);

		calculatednet = calculatednet + parseFloat(d) ;
		calculatedbuf = calculatedbuf + parseFloat(e);

        a = a +'<input type="hidden" name="executedprefixmv[]" value="'+a+'">';
        b = b +'<input type="hidden" name="executedserialmv[]" value="'+b+'">';
        c = c +'<input type="hidden" name="executedamountmv[]" value="'+c+'">';
        d = d +'<input type="hidden" name="executednetmv[]" value="'+d+'">';
        e = e +'<input type="hidden" name="executedbufmv[]" value="'+e+'">';

        f = f +'<input type="hidden" name="executednamemv[]" value="'+f+'">';
        g = g +'<input type="hidden" name="executedexecutedmv[]" value="'+g+'">';

        var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+f+'</td><td>'+g+'</td><td>'+c+'</td><td>'+d+'</td><td>'+e+'</td></tr>';
        trow = trow + line;
    }

    var tfull = thead+trow+tfoot;
    document.getElementById("review_executed").innerHTML = tfull;

    $("#executed-review-count").html('Executed Count: '+rcount);
    $("#executed-review-value").html('Executed Amount: '+ramount);
    $("#executed-count").html('Executed Count: '+rcount);
    $("#executed-amount").html('Executed Amount: '+ramount);

	calculatednet = formatDollar(calculatednet);
	calculatedbuf = formatDollar(calculatedbuf);
	$('#netCalculated').html('  CALCULATED :   '+calculatednet);
	$('#bufCalculated').html('  CALCULATED :   '+calculatedbuf);

	if (rcount == 0) {
	    $('#netCalculated').html(' ');
		$('#bufCalculated').html(' ');
	}
}


function LoadExecuted(){
	var oTable = $('.dataTable_1').dataTable();
	oTable.fnClearTable();
	$('.power-loading').show();
	$('#executed-table').hide();

	var surety = $('#report-surety').val();
	$('.power-loading').show();

    var level = $('input[name=report-level]').val();
    var prefix =  $("#executed-filter-prefix").val();
    var serial =  $("#executed-filter-serial").val();
    var count =  $("#executed-filter-count").val();
    $.get('classes/wizards_powers_report.class.php', { reportexecuted:surety, "level": level, "list-filter": 1, "filter-prefix": prefix, "filter-serial": serial, "filter-count": count }, function (data) {
        if (data.match('id="error"') !== null) {
	        $('.power-loading').hide();
			$('#executed-table').show()
            $('#executed-table').hide();
            $('#executed-text').html(data);
            $('#executed-text').show();
        } else {
			$('.power-loading').hide();
            var jsonData = JSON.parse(data);
            for (var i in jsonData) {
                var rec = jsonData[i];
                if (!ExecutedInBin(rec.prefix,rec.serial)){

                    $('#executed-table').show().dataTable().fnAddData([
    		            '<input type="checkbox" name="check" value="1">',
    		            rec.prefix,
    		            rec.serial,
						rec.name,
						rec.executed,
                        rec.amount
                    ]);
                    $('#executed-table tr:last').attr('id',rec.id);
                }
            }
            $('#executed-text').hide();
            $('#executed-table').show();
        }
    });
}


function ExecutedInBin(prefix,serial){
    var rows = $("#executed-bin").dataTable().fnGetNodes();
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


//third step  ###############################################################################################

function AddVoided(){
    $('#void-table td input:checked').each(function(){
        var a = $(this).closest('tr[id]').find('td:eq(1)').html(); //prefix
        var b = $(this).closest('tr[id]').find('td:eq(2)').html(); //serial
        var c = $(this).closest('tr[id]').find('td:eq(3)').html(); //value
        var d = $(this).closest('tr[id]').find('td:eq(4)').html(); //voided

        c = parseFloat(c);
        c = c.toFixed(2);

        $('#void-bin').dataTable().fnAddData([
		    '<input type="checkbox" name="check" value="1">',
		    a, //prefix
		    b, //serial
            c, //value
            d //voided (hidden)
        ]);
        var rowindex = $('#void-table').dataTable().fnGetPosition($(this).closest('tr')[0]);
        $('#void-table').dataTable().fnDeleteRow(rowindex);

        $('#void-bin td').closest('tr').find('td:eq(4)').hide();

    });
}

function RemoveBin(){
    $('#void-bin td input:checked').each(function(){
        var rowindex = $('#void-bin').dataTable().fnGetPosition($(this).closest('tr')[0]);
        $('#void-bin').dataTable().fnDeleteRow(rowindex);
    });
}

function CalcVoided(){
    var rcount = 0;
    var rvalue = 0;

    var thead = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Prefix</th><th>Serial</th><th>Value</th><th>Voided</th></tr></thead><tbody>';
    var trow = '';
    var tfoot = '</tbody><tfoot></tfoot></table>';

    var rows = $("#void-bin").dataTable().fnGetNodes();
    for(var i=0;i<rows.length;i++) {
        var a = $(rows[i]).find("td:eq(1)").html(); //prefix
        var b = $(rows[i]).find("td:eq(2)").html(); //serial
        var c = $(rows[i]).find("td:eq(3)").html(); //value
        var d = $(rows[i]).find("td:eq(4)").html(); //voided (hidden)

        rcount = rcount + 1;
        rvalue += parseFloat(c);

        a = a +'<input type="hidden" name="voidprefixmv[]" value="'+a+'">';
        b = b +'<input type="hidden" name="voidserialmv[]" value="'+b+'">';
        c = c +'<input type="hidden" name="voidvaluemv[]" value="'+c+'">';
        d = d +'<input type="hidden" name="voiddatemv[]" value="'+d+'">';

        var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+c+'</td><td>'+d+'</td></tr>';
        trow = trow + line;
    }

    var tfull = thead+trow+tfoot;
    document.getElementById("review_powers").innerHTML = tfull;

    $("#review-count").html('Voided Count: '+rcount);
    $("#review-value").html('Voided Value: '+rvalue);
    $("#void-count").html('Voided Count: '+rcount);
    $("#void-value").html('Voided Value: '+rvalue);
}

function LoadVoided(){
	$('#next').prop('disabled', false);
	var oTable = $('.dataTable_3').dataTable();

	oTable.fnClearTable();
	$('#void-table').hide();

    var surety = $('#report-surety').val();
	$('.power-loading').show();

    var level = $('input[name=report-level]').val();
    var prefix =  $("#filter-prefix").val();
    var serial =  $("#filter-serial").val();
    var count =  $("#filter-count").val();
    $.get('classes/wizards_powers_report.class.php', { "reportvoided": surety, "level": level, "list-filter": 1, "filter-prefix": prefix, "filter-serial": serial, "filter-count": count }, function (data) {
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
                        rec.value,
                        rec.voideddate
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

//Fourth step

function AddTransfer(){
    $('#transfer-table td input:checked').each(function(){
        var a = $(this).closest('tr[id]').find('td:eq(1)').html(); //prefix
        var b = $(this).closest('tr[id]').find('td:eq(2)').html(); //serial
        var c = $(this).closest('tr[id]').find('td:eq(3)').html(); //name
        var d = $(this).closest('tr[id]').find('td:eq(4)').html(); //executed
        var e = $(this).closest('tr[id]').find('td:eq(5)').html(); //amount

		e = parseFloat(e);
		f = parseFloat(0);
        g = parseFloat(0);
        e = e.toFixed(2);
		f = f.toFixed(2);
		g = g.toFixed(2);

        $('#transfer-bin').dataTable().fnAddData([
		    '<input type="checkbox" name="check" value="1">',
		    a, //prefix
		    b, //serial
            e, //amount
			f, //net
			g, //buf
            c, //name (hidden)
			d  //executed (hidden)
        ]);

        var rowindex = $('#transfer-table').dataTable().fnGetPosition($(this).closest('tr')[0]);
        $('#transfer-table').dataTable().fnDeleteRow(rowindex);

        $('#transfer-bin td').closest('tr').find('td:eq(6)').hide();
		$('#transfer-bin td').closest('tr').find('td:eq(7)').hide();

    });

}

function TransferRemoveBin(){
    $('#transfer-bin td input:checked').each(function(){
        var rowindex = $('#transfer-bin').dataTable().fnGetPosition($(this).closest('tr')[0]);
        $('#transfer-bin').dataTable().fnDeleteRow(rowindex);
    });
}

function CalcTransfer(){
    var rcount = 0;
    var ramount = 0;
	var calculatednet = 0;
	var calculatedbuf= 0;

    var thead = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Prefix</th><th>Serial</th><th>Name</th><th>Executed</th><th>Amount</th><th>Net</th><th>BUF</th></tr></thead><tbody>';
    var trow = '';
    var tfoot = '</tbody><tfoot></tfoot></table>';

    var rows = $("#transfer-bin").dataTable().fnGetNodes();
    for(var i=0;i < rows.length; i++) {
        var a = $(rows[i]).find("td:eq(1)").html(); //prefix
        var b = $(rows[i]).find("td:eq(2)").html(); //serial
        var c = $(rows[i]).find("td:eq(3)").html(); //amount
        var d = $(rows[i]).find("td:eq(4)").html(); //net
        var e = $(rows[i]).find("td:eq(5)").html(); //buf
        var f = $(rows[i]).find("td:eq(6)").html(); //name
        var g = $(rows[i]).find("td:eq(7)").html(); //executed

        rcount = rcount + 1;
        ramount = ramount + parseFloat(c);

		calculatednet = calculatednet + parseFloat(d) ;
		calculatedbuf = calculatedbuf + parseFloat(e);

        a = a +'<input type="hidden" name="transferprefixmv[]" value="'+a+'">';
        b = b +'<input type="hidden" name="transferserialmv[]" value="'+b+'">';
        c = c +'<input type="hidden" name="transferamountmv[]" value="'+c+'">';
        d = d +'<input type="hidden" name="transfernetmv[]" value="'+d+'">';
        e = e +'<input type="hidden" name="transferbufmv[]" value="'+e+'">';

        f = f +'<input type="hidden" name="transfernamemv[]" value="'+f+'">';
        g = g +'<input type="hidden" name="transferexecutedmv[]" value="'+g+'">';

        var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+f+'</td><td>'+g+'</td><td>'+c+'</td><td>'+d+'</td><td>'+e+'</td></tr>';
        trow = trow + line;
    }

    var tfull = thead+trow+tfoot;
    document.getElementById("review_transfer").innerHTML = tfull;

    $("#transfer-review-count").html('Transfered Count: '+rcount);
    $("#transfer-review-value").html('Transfered Amount: '+ramount);
    $("#transfer-count").html('Transfered Count: '+rcount);
    $("#transfer-amount").html('Transfered Amount: '+ramount);
    TableRowValidation();

}


function LoadTransfered(){
	var oTable = $('.dataTable_5').dataTable();
	oTable.fnClearTable();
	$('.power-loading').show();
	$('#transfer-table').hide();

	var surety = $('#report-surety').val();
	$('.power-loading').show();

    var level = $('input[name=report-level]').val();
    var prefix =  $("#transfer-filter-prefix").val();
    var serial =  $("#transfer-filter-serial").val();
    var count =  $("#transfer-filter-count").val();
    $.get('classes/wizards_powers_report.class.php', { reporttransfered:surety, "level": level, "list-filter": 1, "filter-prefix": prefix, "filter-serial": serial, "filter-count": count }, function (data) {
        if (data.match('id="error"') !== null) {
	        $('.power-loading').hide();
			$('#transfer-table').show()
            $('#transfer-table').hide();
            $('#transfer-text').html(data);
            $('#transfer-text').show();
        } else {
			$('.power-loading').hide();
            var jsonData = JSON.parse(data);
            for (var i in jsonData) {
                var rec = jsonData[i];
                if (!TransferInBin(rec.prefix,rec.serial)){

                    $('#transfer-table').show().dataTable().fnAddData([
    		            '<input type="checkbox" name="check" value="1">',
    		            rec.prefix,
    		            rec.serial,
						rec.name,
						rec.executed,
                        rec.amount
                    ]);
                    $('#transfer-table tr:last').attr('id',rec.id);
                }
            }

            $('#transfer-text').hide();
            $('#transfer-table').show();
        }
    });
}

function TransferInBin(prefix,serial){
    var rows = $("#transfer-bin").dataTable().fnGetNodes();
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


function TableRowValidation(){
	var row1 = $("#executed-bin").dataTable().fnGetNodes().length;
	var row2 = $("#void-bin").dataTable().fnGetNodes().length;
	var row3 = $("#transfer-bin").dataTable().fnGetNodes().length;
	if( row1 >0 || row2 > 0 || row3 > 0 ){
	    $('#next').prop('disabled', false);
	}else{
	    $('#next').prop('disabled', true);
	}
}

function getDetailAgencySettingsListSurety(surety){
    $.get('classes/wizards_powers_report.class.php',{surety:surety}).done(function(data){
    	var jsonData = JSON.parse(data);
        for (var i in jsonData) {
            var rec = jsonData[i];
    		$('#executed-net').val(rec.net);
    		$('#executed-net-min').val(rec.netmin);
    		$('#executed-buf').val(rec.buf);
    		$('#executed-buf-min').val(rec.bufmin);
    	}
	})
}

function formatDollar(num) { // change number to $ formet
    var p = num.toFixed(2).split(".");
    return "$" + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}


