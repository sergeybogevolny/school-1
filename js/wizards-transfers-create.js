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
						 $('#form-wizard').hide();
						 $('#success').show();
						 //window.location = "powers.php?type=available";
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
            var date                = $("#transfer-create-date").val();
            var amount			    = $("#transfer-create-amount").val();
			var requestingselect    = $('#transfer-create-requesting-select').val();
			var countyselect        = $('#transfer-create-county-select').val();
            var comment             = $('#transfer-create-comment').val();

			$("#review_date").text(date);
			$("#review_amount").text(amount);
			$("#review_requesting").text(requestingselect);
            $("#review_county").text(countyselect);
			
		    if (comment.length == 0){
                $("#group-comments").hide();
            } else {
			    $("#review_comment").text(comment);
                $("#group-comments").show();
            }

			var requestingagentid = $('#transfer-create-requesting-select').find(':selected')[0].id;
			$('#requestingagent_id').val(requestingagentid);

		});
	}
	
	$("#transfer-create-amount").autoNumeric('init');
	var recordeddate = $('#transfer-create-date').datepicker().on('changeDate', function(ev) {recordeddate.hide();}).data('datepicker');

    $("#form-wizard").show();

    $(".first-required").change(function() {
        StepValidate('firstStep');
    });

    $(".second-required").change(function() {
        StepValidate('secondStep');
    });
});

function StepValidate(step){
    var bval = true;
    switch (step){
        case 'firstStep':
            $("#next").attr("disabled", "disabled");
			var transferdate = $('#transfer-create-date').val();
            var transferamount = $('#transfer-create-amount').val();
			if ((transferdate =='')){
				bval = false;
            }
			if ((transferamount =='')){
				bval = false;
            }
            if (bval==true){
                $('#next').prop('disabled', false);
            }
			break;
        case 'secondStep':
            $("#next").attr("disabled", "disabled");
			var requestingselect = $('#transfer-create-requesting-select').val();
			var countyselect    = $('#transfer-create-county-select').val();
			if( requestingselect == ''){
				bval = false;
			}
            if( countyselect == ''){
				bval = false;
			}
		    if (bval==true){
                $('#next').prop('disabled', false);
            }
            break;
    }
}


