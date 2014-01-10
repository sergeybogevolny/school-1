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
             var received 		= $("#forfeiture-record-received").val();
             var caseno 	    = $("#forfeiture-record-caseno").val();
             var forfeited 		= $("#forfeiture-record-forfeited").val();
             var county 		= $("#forfeiture-record-county").val();
			 var amount 		= $("#forfeiture-record-amount").val();
             var defendant  	= $("#forfeiture-record-defendant").val();
			 var prefix 		= $("#forfeiture-record-prefix").val();
			 var serial 		= $("#forfeiture-record-serial").val();
			 var file 	        = $("#forfeiture-record-file").val();
			 var comment        = $('#forfeiture-record-comment').val();

			 $("#review_received").text(received);
             $("#review_caseno").text(caseno);
             $("#review_forfeited").text(forfeited);
             $("#review_county").text(county);
			 $("#review_amount").text(amount);
             $("#review_defendant").text(defendant);
             $("#review_prefix").text(prefix);
			 $("#review_serial").text(serial);
			 $("#review_civilcitation").text(file);
			 $("#review_comment").text(comment);
		});
	}
	var datepickerreceived = $('#forfeiture-record-received').datepicker().on('changeDate', function(ev) {datepickerreceived.hide();}).data('datepicker');
    var datepickerforfeited = $('#forfeiture-record-forfeited').datepicker().on('changeDate', function(ev) {datepickerforfeited.hide();}).data('datepicker');
	$("#forfeiture-record-amount").autoNumeric('init');
	$("#form-wizard").show();
});


function Stepfirstvalidate(){
    var w = $('#forfeiture-record-received').val().length;
    var x = $("#forfeiture-record-caseno").val().length;
    var y = $("#forfeiture-record-forfeited").val().length;
    var z = $("#forfeiture-record-county").val().length;
	if(w > 0 && x > 0 && y > 0 && z>0){
	    $('#next').prop('disabled', false);
	}else{
	    $("#next").attr("disabled", "disabled");
	}
 }

 function Stepsecondvalidate(){
    var x = $('#forfeiture-record-amount').val().length;
    if(x > 0){
        $('#next').prop('disabled', false);
    }else{
        $("#next").attr("disabled", "disabled");
	}
 }


function Validate() {
	
	var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
	var arrInputs = $("#forfeiture-record-file").val().length;

    if(arrInputs > 0) {
		  $('#next').prop('disabled', false);
		}else{
		$("#next").attr("disabled", "disabled");
		}

    return true;
}



function StepValidate(step){
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
            $("#next").attr("disabled", "disabled");
			 Validate();
		    break;
        
    }
}

