$(document).ready(function() {
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
						$('#modal-title-error').html('System');
						$('#modal-body-error').html(data);
						$("#modal-error").modal();
                   }
				},
			},
            textSubmit: 'Submit',
			textNext: 'Next',
			textBack: 'Back',
		}).bind("step_shown",function(){ // as the next button is not handled by the wizard, we need to handle the button caption ourselves
            var step = $("#form-wizard").formwizard("state").currentStep;
            StepValidate(step);
        }).trigger("step_shown");

        form_wizard.bind("before_step_shown", function(e, data) {
			
            var type			    = $("#agency-type").val();
			var company    			= $('#agency-company').val();
			var contact        		= $('#agency-contact').val();
			var address        		= $('#agency-address').val();
			var city        		= $('#agency-city').val();
			var state        		= $('#agency-state').val();
			var zip        			= $('#agency-zip').val();
			var phone1        		= $('#agency-phone1').val();
			var phone2        		= $('#agency-phone2').val();
			var phone3        		= $('#agency-phone3').val();
			var phone1type        	= $('#agency-phone1type').val();
			var phone2type        	= $('#agency-phone2type').val();
			var phone3type        	= $('#agency-phone3type').val();
			var email        		= $('#agency-email').val();
			
			if(type.length > 0 ){
				$('#group-type').show();
				$("#review_type").text(type);
			}else{
			    $('#group-type').hide();
			}	
			
			if(company.length > 0 ){
				$('#group-company').show();
				$("#review_company").text(company);
			}else{
			    $('#group-company').hide();
			}	

			if(contact.length > 0 ){
				$('#group-contace').show();
			    $("#review_contace").text(contact);
			}else{
				$('#group-contace').hide();
			}	
			
            $("#review_address").text(address);
            $("#review_city").text(city);
            $("#review_state").text(state);
            $("#review_zip").text(zip);
	
			if(phone1.length > 0 ){
				$('#group-phone1').show();
                $("#review_phone1").text(phone1);
		        $("#review_phone1type").text(phone1type);
			}else{
				$('#group-phone1').hide();
			}	
			
			if(phone2.length > 0 ){
				$('#group-phone2').show();
                $("#review_phone2").text(phone2);
				$("#review_phone2type").text(phone2type);				
			}else{
				$('#group-phone2').hide();
			}	
			
			if(phone3.length > 0 ){
				$('#group-phone3').show();
                $("#review_phone3").text(phone3);
				$("#review_phone3type").text(phone3type);
			}else{
				$('#group-phone3').hide();
			}
			
			if(email.length > 0 ){
				$('#group-email').show();
                $("#review_email").text(email);
			}else{
				$('#group-email').hide();
			}	
		});
	}

    $("#form-wizard").show();

    $(".first-required").change(function() {
        StepValidate('firstStep');
    });
});


function firstStepValidation(){
			var x = $('#agency-type').val();
            var y = $('#agency-company').val();
            var z = $('#agency-contact').val();
			if (x != '' && y != '' && z != ''){
				
				 $('#next').prop('disabled', false);
            }
}

function StepValidate(step){
    var bval = true;
    switch (step){
        case 'firstStep':
            $("#next").attr("disabled", "disabled");
			var x = $('#agency-type').val();
            var y = $('#agency-company').val();
            var z = $('#agency-contact').val();
			if (x != '' && y != '' && z != ''){
				
				 $('#next').prop('disabled', false);
            }
            
			break;
    }
}


