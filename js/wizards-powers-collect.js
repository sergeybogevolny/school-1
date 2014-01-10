$(document).ready(function() {
    $('.checkedt').click(function(){
		$('.checkedt').iCheck('uncheck');
		$(this).iCheck('check');
		StepValidate('firstStep');
    });

	window.onload = function () {
		var url = document.URL;
		var text = url;
		var term = "jobid";
		if( text.indexOf( term ) != -1 ){
			var step = url.split('?');
			var steps = step[1].split('=');
			if(  steps[1] != '' ){
				$('input:checkbox[value="' + steps[1] + '"]').iCheck('check');
				$('#next').trigger('click');
			 }
		}
	};

    var form_wizard = $("#form-wizard");
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
						 $('#form-wizard').hide();
						 $('#reportbutton').html('<a href="forms/generalbail1.php?id='+id+'" target="_blank"><button class="btn btn-small btn-primary"><i class=" icon-print"></i> Report</button></a></center>')
						 $('#success').show();
						 $('#report-button').show();
                    } else {
						$('#modal-title-error').html('System');
						$('#modal-body-error').html(data);
						$("#modal-error").modal();
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
            if (step=='firstStep'){

            }

            if (step=='secondStep'){
                $('#job-list td input:checked').each(function(){
    			    var a = $(this).closest('tr').find('td:eq(3)').html(); //count
    				var b = $(this).closest('tr').find('td:eq(4)').html(); //amount
    				var c = $(this).closest('tr').find('td:eq(5)').html(); //netcalculated
                    var d = $(this).closest('tr').find('td:eq(6)').html(); //bufcalculated
                    var e = $(this).closest('tr').find('td:eq(7)').html(); //netdate
                    var f = $(this).closest('tr').find('td:eq(8)').html(); //netamount
                    var g = $(this).closest('tr').find('td:eq(9)').html(); //netmethod
                    var h = $(this).closest('tr').find('td:eq(10)').html(); //bufdate
                    var i = $(this).closest('tr').find('td:eq(11)').html(); //bufamount
                    var j = $(this).closest('tr').find('td:eq(12)').html(); //bufmethod

                    $("#count").html('Total Count: '+a);
    		        $("#sum").html('Total Value: '+b);
                    if (e=='') {
          			    $('#collected-netpaymentdate-group').hide();
          			}else{
          			    $("#collected-netpaymentdate").html(e);
                        $('#collected-netpaymentdate-group').hide();
          			}
                    if (f=='') {
                        $('#report-netpaymentamount-agency').val(0);
          			    $('#collected-netpaymentamount-group').hide();
          			}else{
          			    $('#report-netpaymentamount-agency').val(f);
                        $("#collected-netpaymentamount").html(f);
                        $('#collected-netpaymentamount-group').hide();
          			}
                    if (g=='') {
          			    $('#collected-netpaymentmethod-group').hide();
          			}else{
          			    $("#collected-netpaymentmethod").html(g);
                        $('#collected-netpaymentmethod-group').hide();
          			}
                    if (h=='') {
          			    $('#collected-bufpaymentdate-group').hide();
          			}else{
          			    $("#collected-bufpaymentdate").html(h);
                        $('#collected-bufpaymentdate-group').hide();
          			}
                    if (i=='') {
                        $('#report-bufpaymentamount-agency').val(0);
          			    $('#collected-bufpaymentamount-group').hide();
          			}else{
          			    $('#report-bufpaymentamount-agency').val(i);
          			    $("#collected-bufpaymentamount").html(i);
                        $('#collected-bufpaymentamount-group').hide();
          			}
                    if (j=='') {
          			    $('#collected-bufpaymentmethod-group').hide();
          			}else{
          			    $("#collected-bufpaymentmethod").html(j);
                        $('#collected-bufpaymentmethod-group').hide();
          			}
                    $("#review-count").html('Total Count: '+a);
    		        $("#review-sum").html('Total Value: '+b);
                    $('#report-count').val(a);
                    $('#report-amount').val(b);


                });
                var collectjobid = $('.checkedt:checked').val();
                $('#report-collectid').val(collectjobid);
                $('#check_all_2').iCheck('uncheck');
                CollectJobDetail(collectjobid);
			}
            if (step=='thirdStep'){
                var collectednetcontracted = 0;
                var collectedbufcontracted = 0;
                var reportnetcalculated = 0;
                var reportbufcalculated = 0;

                var trow = '';
    		    $('#detail-list td input:checked').each(function(){
    			    var a = $(this).closest('tr').find('td:eq(1)').html();
    				var b = $(this).closest('tr').find('td:eq(2)').html();
    				var c = $(this).closest('tr').find('td:eq(3)').html();
                    var d = $(this).closest('tr').find('td:eq(4)').html();
                    var e = $(this).closest('tr').find('td:eq(5)').html();
                    var f = $(this).closest('tr').find('td:eq(6)').html();
                    var g = $(this).closest('tr').find('td:eq(7)').html();
                    var h = $(this).closest('tr').find('td:eq(8)').html();
                    var i = $(this).closest('tr').find('td:eq(9)').html();
                    var j = $(this).closest('tr').find('td:eq(10)').html();
                    var k = $(this).closest('tr').find('td:eq(11)').html();
                    var l  =$(this).closest('tr').attr('id');

                    a = a +'<input type="hidden" name="prefixmv[]" value="'+a+'">';
                    b = b +'<input type="hidden" name="serialmv[]" value="'+b+'">';
                    c = c +'<input type="hidden" name="executedmv[]" value="'+c+'">';
                    d = d +'<input type="hidden" name="defendantmv[]" value="'+d+'">';
                    e = e +'<input type="hidden" name="amountmv[]" value="'+e+'">';
                    f = f +'<input type="hidden" name="transfermv[]" value="'+f+'">';
                    g = g +'<input type="hidden" name="netcontractedagencymv[]" value="'+g+'">';
                    h = h +'<input type="hidden" name="bufcontractedagencymv[]" value="'+h+'">';
                    i = i +'<input type="hidden" name="netcalculatedgeneralmv[]" value="'+i+'">';
                    j = j +'<input type="hidden" name="bufcalculatedgeneralmv[]" value="'+j+'">';
                    k = k +'<input type="hidden" name="voidmv[]" value="'+k+'">';
                    l = l +'<input type="hidden" name="collectdetailidmv[]" value="'+l+'">';

                    collectednetcontracted = collectednetcontracted +g;
                    collectednetcontracted = parseFloat(collectednetcontracted);
                    collectednetcontracted = collectednetcontracted.toFixed(2);

                    collectedbufcontracted = collectedbufcontracted +h;
                    collectedbufcontracted = parseFloat(collectedbufcontracted);
                    collectedbufcontracted = collectedbufcontracted.toFixed(2);

                    reportnetcalculated = reportnetcalculated + i;
                    reportnetcalculated = parseFloat(collectedbufcontracted);
                    reportnetcalculated = reportnetcalculated.toFixed(2);

                    reportbufcalculated = reportbufcalculated +j;
                    reportbufcalculated = parseFloat(reportbufcalculated);
                    reportbufcalculated = reportbufcalculated.toFixed(2);

                    var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+c+'</td><td>'+d+'</td><td>'+e+'</td><td>'+f+'</td><td>'+g+'</td><td>'+h+'</td><td>'+i+'</td><td>'+j+'</td><td style="display:none;">'+k+'</td><td style="display:none;">'+l+'</td></tr>';
                    trow = trow + line;
                });
                $('#reviewcollectdetail').html(trow);

                //alert(1);
                //$('#collected-netcontracted').val(collectednetcontracted);
                //$('#collected-bufcontracted').val(collectedbufcontracted);

                //$('#collected-netcontracted').html('  Contracted :   '+collectednetcontracted);
		        //$('#collected-bufcontracted').html('  Contracted :   '+bufcontractedagencysum);
		        //$('#report-netcalculated').html('  Calculated :   '+netcalculatedgeneralsum);
		        //$('#report-bufcalculated').html('  Calculated :   '+bufcalculatedgeneralsum);

			}

            var getYYYY = new Date().getFullYear();
            var getMM = new Date().getMonth() + 1;
            var getDD = new Date().getDate();
            var reportdate = ('0' + getMM).slice(-2) + '/'
             + ('0' + getDD).slice(-2) + '/'
             + getYYYY;

            $("#review_collectdate").text(reportdate);
            $("#review_reportdate").text(reportdate);

			var reportnetpaymentdate = $('#report-netpaymentdate-general').val();
			var reportnetpaymentamount = $('#report-netpaymentamount-general').val();
			var reportnetpaymentmethod = $('#report-netpaymentmethod-general').val();
			var reportbufpaymentdate = $('#report-bufpaymentdate-general').val();
			var reportbufpaymentamount = $('#report-bufpaymentamount-general').val();
			var reportbufpaymentmethod = $('#report-bufpaymentmethod-general').val();

			if(reportnetpaymentdate.length > 0 ){
				$('#group-netpaymentdate').show();
				$('#review-netpaymentdate-general').html(reportnetpaymentdate);
			}else{
			    $('#group-netpaymentdate').hide();
			}

			if(reportnetpaymentamount.length > 0 ){
				$('#group-netpaymentamount').show();
				$('#review-netpaymentamount-general').html(reportnetpaymentamount);
			}else{
				$('#group-netpaymentamount').hide();
			}

			if(reportnetpaymentmethod.length > 0 ){
			    $('#group-netpaymentmethod').show();
			    $('#review-netpaymentmethod-general').html(reportnetpaymentmethod);
			}else{
			    $('#group-netpaymentmethod').hide();
			}

            /*
			if(reportnetpaymentdate.length == 0 && reportnetpaymentamount.length == 0 && reportnetpaymentmethod.length == 0 ){
			    $('#group-net').hide();
			}
            */

			if(reportbufpaymentamount.length > 0 ){
			    $('#group-bufpaymentmethod').show();
			    $('#review-bufpaymentamount-general').html(reportbufpaymentamount);
			}else{
			    $('#group-bufpaymentmethod').hide();
			}

			if(reportbufpaymentmethod.length > 0 ){
			    $('#group-bufpaymentamount').show();
			    $('#review-bufpaymentmethod-general').html(reportbufpaymentmethod);
			}else{
			   $('#group-bufpaymentamount').hide();
			}

			if(reportbufpaymentdate.length > 0 ){
			   $('#group-bufpaymentdate').show();
			   $('#review-bufpaymentdate-general').html(reportbufpaymentdate);
			}else{
			   $('#group-bufpaymentdate').hide();
			}

            /*
            if(reportbufpaymentdate.length == 0 && reportbufpaymentamount.length == 0 && reportbufpaymentmethod.length == 0 ){
			    $('#group-buf').hide();
			}
            */

		});

	}

	var netpaymentdate = $('#report-netpaymentdate-general').datepicker().on('changeDate', function(ev) {netpaymentdate.hide();}).data('datepicker');
	var bufpaymentdate = $('#report-bufpaymentdate-general').datepicker().on('changeDate', function(ev) {bufpaymentdate.hide();}).data('datepicker');

	$("#report-netpaymentamount-general").autoNumeric('init');
	$("#report-bufpaymentamount-general").autoNumeric('init');

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


    if($('.dataTable_2').length > 0){
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
					Stepsecondvalidate();
				});


			}
		});
    }

    $("#form-wizard").show();

});

function StepValidate(step){
    switch (step){
        case 'firstStep':
            Stepfirstvalidate();
            break;
        case 'secondStep':
            Stepsecondvalidate();
			break;
        case 'thirdStep':
            break;
    }
}


function CollectJobDetail(collectjobid){
    $('#detail-list').hide();
	$('.power-loading').show();
    var oTable = $('.dataTable_2').dataTable();
	oTable.fnClearTable();
    $.get('classes/wizards_powers_collect.class.php', { collectjobid: collectjobid }, function (data) {
        if (data.match('id="error"') !== null) {
            $('#detail-list').show();
			$('.power-loading').hide();
		    $('#detail-text').html(data);
			$('#detail-text').show();
		} else {
	        $('.power-loading').hide();
		    var jsonData = JSON.parse(data);

            //need to set
            var agency = jsonData.collect[0]['agency'];
            var agencyid = jsonData.collect[0]['agency_id'];

            var netagency = jsonData.collect[0]['netagency'];
            var netminimumagency = jsonData.collect[0]['netminimumagency'];
            var bufagency = jsonData.collect[0]['bufagency'];
            var bufminimumagency = jsonData.collect[0]['bufminimumagency'];
            var surety = jsonData.collect[0]['surety'];
            var netgeneral = jsonData.collect[0]['netgeneral'];
            var netminimumgeneral = jsonData.collect[0]['netminimumgeneral'];
            var bufgeneral =jsonData.collect[0]['bufgeneral'];
            var bufminimumgeneral = jsonData.collect[0]['bufminimumgeneral'];

            $('#report-agency').val(agency);
            $('#report-agencyid').val(agencyid);
            $('#report-net-agency').val(netagency);
            $('#report-netminimum-agency').val(netminimumagency);
            $('#report-buf-agency').val(bufagency);
            $('#report-bufminimum-agency').val(bufminimumagency);
            $('#report-surety').val(surety);
            $('#report-net-general').val(netgeneral);
            $('#report-netminimum-general').val(netminimumgeneral);
            $('#report-buf-general').val(bufgeneral);
            $('#report-bufminimum-general').val(bufminimumgeneral);

            var netcontractedagency = 0;
            var bufcontractedagency = 0;
            var netcontractedagencysum = 0;
            var bufcontractedagencysum = 0;

            var netcalculatedgeneral = 0;
            var bufcalculatedgeneral = 0;
            var netcalculatedgeneralsum = 0;
            var bufcalculatedgeneralsum = 0;

            for (var i in jsonData.list) {
			    var rec = jsonData.list[i];

                if (rec.transfer==1){
                    netcontractedagency = 0;
                } else {
                    netcontractedagency = rec.amount * netagency;
                    if (netcontractedagency < netminimumagency){
                        netcontractedagency = netminimumagency;
                    }
                }
                netcontractedagency = parseFloat(netcontractedagency);
                netcontractedagencysum = netcontractedagencysum + netcontractedagency;
                netcontractedagencysum = parseFloat(netcontractedagencysum);

                netcontractedagency = netcontractedagency.toFixed(2);

                if (rec.transfer==1){
                    bufcontractedagency = 0;
                } else {
                    bufcontractedagency = rec.amount * bufagency;
                    if (bufcontractedagency < bufminimumagency){
                        bufcontractedagency = bufminimumagency;
                    }
                }
                bufcontractedagency = parseFloat(bufcontractedagency);
                bufcontractedagencysum = bufcontractedagencysum + bufcontractedagency;
                bufcontractedagencysum = parseFloat(bufcontractedagencysum);

                bufcontractedagency = bufcontractedagency.toFixed(2);

                netcalculatedgeneral = rec.amount * netgeneral;
                if (netcalculatedgeneral < netminimumgeneral){
                    netcalculatedgeneral = netminimumgeneral;
                }
                netcalculatedgeneral = parseFloat(netcalculatedgeneral);
                netcalculatedgeneralsum = netcalculatedgeneralsum + netcalculatedgeneral;
                netcalculatedgeneralsum = parseFloat(netcalculatedgeneralsum);

                netcalculatedgeneral = netcalculatedgeneral.toFixed(2);

                bufcalculatedgeneral = rec.amount * bufgeneral;
                if (bufcalculatedgeneral < bufminimumgeneral){
                    bufcalculatedgeneral = bufminimumgeneral;
                }
                bufcalculatedgeneral = parseFloat(bufcalculatedgeneral);
                bufcalculatedgeneralsum = bufcalculatedgeneralsum + bufcalculatedgeneral;
                bufcalculatedgeneralsum = parseFloat(bufcalculatedgeneralsum);

                bufcalculatedgeneral = bufcalculatedgeneral.toFixed(2);

			    $('#detail-list').show().dataTable().fnAddData([
                    '<input type="checkbox" name="collect_detail" class="checkedte" value="'+rec.id+'" onclick="Stepsecondvalidate()">',
				    rec.prefix,
				    rec.serial,
				    rec.executed,
				    rec.defendant,
				    rec.amount,
                    rec.transfer,
                    netcontractedagency,
                    bufcontractedagency,
                    netcalculatedgeneral,
                    bufcalculatedgeneral,
                    rec.voided
			    ]);

                $('#detail-list tr:last').attr('id',rec.id);
		    }

			//$('#detail-list td').closest('tr').find('td:eq(9)').hide();
			//$('#detail-list td').closest('tr').find('td:eq(10)').hide();
            $('#detail-list td').closest('tr').find('td:eq(11)').hide();

            netcontractedagencysum = netcontractedagencysum.toFixed(2);
            bufcontractedagencysum = bufcontractedagencysum.toFixed(2);
            netcalculatedgeneralsum = netcalculatedgeneralsum.toFixed(2);
            bufcalculatedgeneralsum = bufcalculatedgeneralsum.toFixed(2);

            $('#report-netcontracted-agency').val(netcontractedagencysum);
            $('#report-bufcontracted-agency').val(bufcontractedagencysum);
            $('#report-netcalculated-general').val(netcalculatedgeneralsum);
            $('#report-bufcalculated-general').val(bufcalculatedgeneralsum);

		    $('#collected-netcontracted').html('  Contracted :   '+netcontractedagencysum);
		    $('#collected-bufcontracted').html('  Contracted :   '+bufcontractedagencysum);
		    $('#reporting-netcalculated').html('  Calculated :   '+netcalculatedgeneralsum);
		    $('#reporting-bufcalculated').html('  Calculated :   '+bufcalculatedgeneralsum);

            $('#review-netcalculated').html('  Calculated :   '+netcalculatedgeneralsum);
		    $('#review-bufcalculated').html('  Calculated :   '+bufcalculatedgeneralsum);

    		$('#detail-list').show();
    	}
    });
}



function Stepfirstvalidate(){
    $('#next').prop('disabled', true);
    $('#job-list td input:checked').each(function(){
	    $('#next').prop('disabled', false);
		$(this).iCheck('check');
    });
}

function Stepsecondvalidate(){
    $('#next').prop('disabled', true);
	if (($('.checkedte:checked').length == $('.checkedte').length) && ($('.checkedte:checked').length >0))  {
	    $('#next').prop('disabled', false);
	}
}


function formatDollar(num) { // change number to $ formet
    var p = num.toFixed(2).split(".");
    return "$" + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}

