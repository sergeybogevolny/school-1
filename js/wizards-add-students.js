$(document).ready(function() {
	var form_wizard = $("#form-wizard");
    $("#form-wizard").show();

    $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');

    mv = new Array();
    mvi = 0;
    mv1 = new Array();
    mvi1 = 0;

	if (form_wizard.length > 0) {
		form_wizard.formwizard({
            formPluginEnabled: true,
			validationEnabled: true,
			focusFirstInput : true,
			disableUIStyles:true,
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
                         window.location = "client.php?id="+id;
                    } else {
                        alert(data);
                    }
				}
			},
            textSubmit: 'Create',
			textNext: 'Next',
			textBack: 'Back',
		}).bind("step_shown",function(event){ // as the next button is not handled by the wizard, we need to handle the button caption ourselves
            var step = $("#form-wizard").formwizard("state").currentStep;
            StepValidate(step);
        }).trigger("step_shown");

        form_wizard.bind("before_step_shown", function(e, data) {
            var step = data.currentStep;
            var perfirst 		= $("#student_firstname").val();
            var permiddle 		= $("#student_middlename").val();
            var perlast 		= $("#student_lastname").val();
			if ($('input[name="personal-gender"]').is(':checked')){
			    var gender = $('[name=personal-gender]:checked').val();
	        } else {
	            var gender  = '';
            }
            var peraddress 		=$("#student_current_street").val();
            var percity 		=$("#student_current_city").val();
            var perstate 		=$("#student_current_state").val();
            var perzip 			=$("#student_current_zip").val();
			
            var fatherfirst  	= $("#father_firstname").val();
            var fathermiddle 	= $("#father_middlename").val();
            var fatherlast 		= $("#father_lastname").val();
			var fphonetype1		=$("#father_phone1_type").val();
			var fphone1			=$("#father_phone1").val();
			var fphonetype2		=$("#father_phone2_type").val();
			var fphone2			=$("#father_phone2").val();
			var fqualification	=$("#father_qualification").val();
			var foccupation		=$("#father_occupation").val();
			
            var motherfirst  	=$("#mother_firstname").val();
            var mothermiddle 	=$("#mother_middlename").val();
            var motherlast 		=$("#mother_lastname").val();
			var mphonetype1		=$("#mother_phone1_type").val();
			var mphone1			=$("#mother_phone1").val();
			var mphonetype2		=$("#mother_phone2_type").val();
			var mphone2			=$("#mother_phone2").val();
			var mqualification	=$("#mother_qualification").val();
			var moccupation		=$("#mother_occupation").val();
			
            var parentaddress 	=$("#student_parmanent_street").val();
            var parentcity 		=$("#student_parmanent_city").val();
            var parentstate 	=$("#student_parmanent_state").val();
            var parentzip 		=$("#student_parmanent_zip").val();
			var parentcountry	=$("#student_parmanent_country").val();
			var parentremark	=$("#student_parmanent_remark").val();
			
            var guardianfirst  	=$("#guardian_firstname").val();
            var guardianfirst 	=$("#guardian_middlename").val();
            var guardianlast 	=$("#guardian_lastname").val();
			var gphonetype1		=$("#guardian_phone1_type").val();
			var gphone1			=$("#guardian_phone1").val();
			var gphonetype2		=$("#guardian_phone2_type").val();
			var gphone2			=$("#guardian_phone2").val();
			var gqualification	=$("#guardian_qualification").val();
			var goccupation		=$("#guardian_occupation").val();
            var guardiaaddress 	=$("#student_guardian_street").val();
            var guardiacity 	=$("#student_guardian_city").val();
            var guardiastate 	=$("#student_guardian_state").val();
            var guardiazip 		=$("#student_guardian_zip").val();
			var guardiacountry	=$("#student_guardian_country").val();
			var guardiaremark	=$("#student_guardian_remark").val();
			
			
			



			
			$("#review_student_firstname").val(perfirst);
			$("#review_student_middlename").val(permiddle);
			$("#review_student_lastname").val(perlast);
		//	$("#review_student_").text(pergender);
			$("#review_student_current_street").val(peraddress);
			$("#review_student_current_city").val(percity);
			$("#review_student_current_state").val(perstate);
			$("#review_student_current_zip").val(perzip);
			
			$("#review_student_fatherfirstname").val(fatherfirst);
			$("#review_student_fathermiddlename").val(fathermiddle);
			$("#review_student_fatherlastname").val(fatherlast);
			$("#review_father_phone1_type").select2('val',fphonetype1);
			$("#review_father_phone1").val(fphone1);
			$("#review_father_phone2_type").select2('val',fphonetype2);
			$("#review_father_phone2").val(fphone2);
			$("#review_father_qualification").select2('val',fqualification);
			$("#review_father_occupation").select2('val',foccupation);
			
			$("#review_student_motherfirstname").val(motherfirst);
			$("#review_student_mothermiddlename").val(mothermiddle);
			$("#review_student_motherlastname").val(motherlast);
			$("#review_mother_phone1_type").select2('val',mphonetype1);
			$("#review_mother_phone1").val(mphone1);
			$("#review_mother_phone2_type").select2('val',mphonetype2);
			$("#review_mother_phone2").val(mphone2);
			$("#review_mother_qualification").select2('val',mqualification);
			$("#review_mother_occupation").select2('val',moccupation);
			
			$("#review_student_parmanent_street").val(parentaddress);
			$("#review_student_parmanent_city").val(parentcity);
			$("#review_student_parmanent_state").val(parentstate);
			$("#review_student_parmanent_zip").val(parentzip);
			$("#review_student_parmanent_country").select2('val',parentcountry);
			$("#review_student_parmanent_remark").val(parentremark);
			
			$("#review_guardian_firstname").val(guardianfirst);
			$("#review_guardian_middlename").val(guardianfirst);
			$("#review_guardian_lastname").val(guardianlast);
			$("#review_guardian_phone1_type").select2('val',gphonetype1);
			$("#review_guardian_phone1").val(gphone1);
			$("#review_guardian_phone2_type").select2('val',gphonetype2);
			$("#review_guardian_phone2").val(gphone2);
			$("#review_guardian_qualification").select2('val',gqualification);
			$("#review_guardian_occupation").select2('val',goccupation);
			$("#review_student_guardian_street").val(guardiaaddress);
			$("#review_student_guardian_city").val(guardiacity);
			$("#review_student_guardian_state").val(guardiastate);
			$("#review_student_guardian_zip").val(guardiazip);
			$("#review_student_guardian_country").select2('val',guardiacountry);
			$("#review_student_guardian_remark").val(guardiaremark);
		});

  }




var dob = $('.datepicker').datepicker().on('changeDate', function(ev) {dob.hide();}).data('datepicker');



});


function StepValidate(step){
    var bval = true;
    switch (step){
        case 'firstStep':

            break;
        case 'secondStep':

            break;
        case 'thirdStep':

            break;
        case 'fourthStep':
            break;
        case 'fifthStep':
            break;
        case 'sixthStep':
            break;
        case 'seventhStep':
            break;
        case 'eigthStep':
            break;

    }
}

function firstStepValidation(){

}

function thirdStepValidation(){

}

function fifthStepValidation(){

}

function sixthStepValidation(){

}
