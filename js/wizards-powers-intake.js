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
						  $('#success').show();
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
                var intakejobid = $('.checkedt:checked').val();
			    $('#intake_id').val(intakejobid);
			    IntakeJobDetail(intakejobid);
			}
            if (step=='thirdStep'){
                var trow = '';
    		    $('#detail-list td input:checked').each(function(){
    			    var a = $(this).closest('tr').find('td:eq(1)').html();
    				var b =  $(this).closest('tr').find('td:eq(2)').html();
    				var c = $(this).closest('tr').find('td:eq(3)').html();
                    var d = $(this).closest('tr').find('td:eq(4)').html();
                    var e = $(this).closest('tr').find('td:eq(5)').html();

                    a = a +'<input type="hidden" name="intakeprefixmv[]" value="'+a+'">';
                    b = b +'<input type="hidden" name="intakeserialmv[]" value="'+b+'">';
                    c = c +'<input type="hidden" name="intakevaluemv[]" value="'+c+'">';
                    d = d +'<input type="hidden" name="intakeexpirationmv[]" value="'+d+'">';
                    e = e +'<input type="hidden" name="intakeissuedmv[]" value="'+e+'">';

                    var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+c+'</td><td>'+d+'</td><td style="display:none;">'+e+'</td></tr>';
                    trow = trow + line;
                });
                $('#reviewintakesdetail').html(trow);
			}

		});
	}

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
    var bval = true;
    switch (step){
        case 'firstStep':
            $("#next").attr("disabled", "disabled");
            Stepfirstvalidate();
            break;
        case 'secondStep':
            $("#next").attr("disabled", "disabled");
            Stepsecondvalidate();
			break;
        case 'thirdStep':
            break;

    }
}


function IntakeJobDetail(intakejobid){
    var oTable = $('.dataTable_2').dataTable();
	oTable.fnClearTable();
	$('#detail-list').hide();
	$('.power-loading').show();
	$.get('classes/wizards_powers_intake.class.php', { intakejobid: intakejobid }, function (data) {
	    if (data.match('id="error"') !== null) {
	        $('.power-loading').hide();
			$('#detail-list').show();
			$('#detail-text').html(data);
			$('#detail-text').show();
		} else {
		    $('.power-loading').hide();
			var jsonData = JSON.parse(data);
			var count = 0;
			var sum   = 0;
			for (var i in jsonData) {
    			var rec = jsonData[i];
    			$('#detail-list').show().dataTable().fnAddData([
    			    '<input type="checkbox" name="intake_detail_id[]" class="checkedte" value="'+rec.id+'" onclick="Stepsecondvalidate()" >',
    				rec.prefix,
    				rec.serial,
    				rec.value,
                    rec.expiration,
                    rec.issued
                ]);
                $('#detail-list td').closest('tr').find('td:eq(5)').hide();
                count = count + 1
				var s = eval(rec.value);
				sum = sum + s;
			}
            $('#check_all_2').iCheck('uncheck');
			$("#count").html('Total Count: '+count);
			$("#sum").html('Total Value: '+sum);
			$("#reviewcount").html('Total Count: '+count);
			$("#reviewsum").html('Total Value: '+sum);
			$('#detail-list').show();
		}
	});
}

function Stepfirstvalidate(){
    $('#next').prop('disabled', false);
    $('#distribute-list td input:checked').each(function(){
	    $('#next').prop('disabled', false);
		$('.checkedt').iCheck('uncheck');
		$(this).iCheck('check');
    });
}

function Stepsecondvalidate(){
    $('#next').prop('disabled', false);
	if ($('.checkedte:checked').length == $('.checkedte').length) {
	    $('#next').prop('disabled', false);
	} else {
	    $("#next").attr("disabled", "disabled");
	}
}
