var firstname;
var lastname;
var email;
var gender;
var language;
var hobbies = new Array();
var age;
var url;
var aboutme;

$(document).ready(function() {
	var form_wizard = $("#form-wizard");

	if (form_wizard.length > 0) {
		form_wizard.formwizard({
			formPluginEnabled: false,
			validationEnabled: true,
			validationOptions: {
				errorElement: 'span',
				errorClass: 'help-block error',
				errorPlacement: function(error, element) {
					element.parent('.controls').append(error);
				},
				highlight: function(label) {
					$(label).closest('.control-group').removeClass('error success').addClass('error');
				},
				success: function(label) {
					label.addClass('valid').closest('.control-group').removeClass('error success').addClass('success');
				}
			}, 
			textSubmit: 'Generate PDF',
			textNext: 'Next',
			textBack: 'Back',
			disableUIStyles: true,
		});

		form_wizard.bind("before_step_shown", function(e, data) {
			firstname = $("#firstname").val();
			lastname = $("#lastname").val();
			email = $("#email").val();
			gender = $("input[type='radio'][name='gender']:checked").val();
			language = $("#language").val();

			hobbies = new Array();
			$("input[type='checkbox'][name='hobbies[]']:checked").each(function() {
				hobbies.push($(this).val());
			});

			age = $("#age").val();
			url = $("#url").val();
			aboutme = $("#aboutme").val();

			$("#review_firstname").text(firstname);
			$("#review_lastname").text(lastname);
			$("#review_email").text(email);
			$("#review_gender").text(gender);
			$("#review_language").text(language);
			$("#review_hobbies").text(hobbies.join(", "));
			$("#review_age").text(age);
			$("#review_url").text(url);
			$("#review_aboutme").text(aboutme);
		});
	}
});