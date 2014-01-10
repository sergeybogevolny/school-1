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
                         $('#report-button').show();
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

            var step = data.currentStep;
            if (step=='secondStep'){

            }
            if (step=='thirdStep'){
                var transactionamount	    = $("#transaction-amount").val();
			    var invoiceamount           = $('#invoice-amount').val();
                var installmentamount       = $('#installment-amount').val();
                var installmentinterval     = $('#installment-interval').select2('val');
                $('#supplement-transactionamount').val(transactionamount);
                $('#supplement-invoiceamount').val(invoiceamount);
                $('#supplement-installmentamount').val(installmentamount);
                $('#supplement-installmentinterval').val(installmentinterval);
                $('#review-transactionamount').html(transactionamount);
                $('#review-invoiceamount').html(invoiceamount);
                $('#review-installmentamount').html(installmentamount);
                $('#review-installmentinterval').html(installmentinterval.charAt(0).toUpperCase() + installmentinterval.slice(1).toLowerCase());
            }
            if (step=='fourthStep'){
                var drawmethod	    = $("#draw-method").val();
                var drawbank	    = $("#draw-bank").val();
                var drawbankrouting	    = $("#draw-bankrouting").val();
                var drawbankaccount	    = $("#draw-bankaccount").val();
                var drawcard	    = $("#draw-card").val();
                var drawcardnumber	    = $("#draw-cardnumber").val();
                var drawcardexpiration	    = $("#draw-cardexpiration").val();
                var drawcardcvv 	    = $("#draw-cardcvv").val();
                var drawcardaddress	    = $("#draw-cardaddress").val();
                var drawcardcity	    = $("#draw-cardcity").val();
                var drawcardstate	    = $("#draw-cardstate").select2('val');
                var drawcardzip	    = $("#draw-cardzip").val();
                if (drawmethod=='check'){
                    $('#supplement-drawmethod').val(drawmethod);
                    $('#supplement-drawbank').val(drawbank);
                    $('#supplement-drawbankrouting').val(drawbankrouting);
                    $('#supplement-drawbankaccount').val(drawbankaccount);
                    $('#supplement-drawcard').val('');
                    $('#supplement-drawcardnumber').val('');
                    $('#supplement-drawcardexpiration').val('');
                    $('#supplement-drawcardcvv').val('');
                    $('#supplement-drawcardaddress').val('');
                    $('#supplement-drawcardcity').val('');
                    $('#supplement-drawcardstate').val('');
                    $('#supplement-drawcardzip').val('');
                    $('#review-method').html(drawmethod.charAt(0).toUpperCase() + drawmethod.slice(1).toLowerCase());
                    $('#review-bank').html(drawbank);
                    $('#review-bankrouting').html(drawbankrouting);
                    $('#review-bankaccount').html(drawbankaccount);
                    $('#review-card').html('');
                    $('#review-cardnumber').html('');
                    $('#review-cardexpiration').html('');
                    $('#review-cardcvv').html('');
                    $('#review-cardaddress').html('');
                    $('#review-cardcity').html('');
                    $('#review-cardstate').html('');
                    $('#review-cardzip').html('');
                    $('#group-method-card').hide();
                    $('#group-method-check').show();
                }
                if (drawmethod=='card'){
                    $('#supplement-drawmethod').val(drawmethod);
                    $('#supplement-drawbank').val('');
                    $('#supplement-drawbankrouting').val('');
                    $('#supplement-drawbankaccount').val('');
                    $('#supplement-drawcard').val(drawcard);
                    $('#supplement-drawcardnumber').val(drawcardnumber);
                    $('#supplement-drawcardexpiration').val(drawcardexpiration);
                    $('#supplement-drawcardcvv').val(drawcardcvv);
                    $('#supplement-drawcardaddress').val(drawcardaddress);
                    $('#supplement-drawcardcity').val(drawcardcity);
                    $('#supplement-drawcardstate').val(drawcardstate);
                    $('#supplement-drawcardzip').val(drawcardzip);
                    $('#review-method').html(drawmethod.charAt(0).toUpperCase() + drawmethod.slice(1).toLowerCase());
                    $('#review-bank').html('');
                    $('#review-bankrouting').html('');
                    $('#review-bankaccount').html('');
                    $('#review-card').html(drawcard);
                    $('#review-cardnumber').html(drawcardnumber);
                    $('#review-cardexpiration').html(drawcardexpiration);
                    $('#review-cardcvv').html(drawcardcvv);
                    $('#review-cardaddress').html(drawcardaddress);
                    $('#review-cardcity').html(drawcardcity);
                    $('#review-cardstate').html(drawcardstate);
                    $('#review-cardzip').html(drawcardzip);
                    $('#group-method-check').hide();
                    $('#group-method-card').show();
                }

            }
		});
	}

    $("#transaction-amount").autoNumeric('init');
    $("#invoice-amount").autoNumeric('init');
    $("#installment-amount").autoNumeric('init');

    $("#form-wizard").show();

});

function stepsecondValidate(){
	var w = $('#transaction-amount').val().length;
	var x = $('#invoice-amount').val().length;
    var y = $('#installment-amount').val().length;
    var z = $('#installment-interval').val().length;
	if(w > 0 && x > 0 && y > 0 && z > 0){
          $('#next').prop('disabled', false);
	}else{
          $("#next").attr("disabled", "disabled");
	}
}

function stepthirdValidate(){
    var method = $('#draw-method').select2('val');
    $("#next").attr("disabled", "disabled");
    if (method=='check'){
        var w = $('#draw-method').val().length;
    	var x = $('#draw-bank').val().length;
        var y = $('#draw-bankrouting').val().length;
        var z = $('#draw-bankaccount').val().length;
    	if(w > 0 && x > 0 && y > 0 && z > 0){
              $('#next').prop('disabled', false);
    	}else{
              $("#next").attr("disabled", "disabled");
    	}
    }
    if (method=='card'){
        var r = $('#draw-method').val().length;
    	var s = $('#draw-card').val().length;
        var t = $('#draw-cardnumber').val().length;
        var u = $('#draw-cardexpiration').val().length;
        var v = $('#draw-cardcvv').val().length;
        var w = $('#draw-cardaddress').val().length;
        var x = $('#draw-cardcity').val().length;
        var y = $('#draw-cardstate').val().length;
        var z = $('#draw-cardzip').val().length;
    	if(r > 0 && s > 0 && t > 0 && u > 0 && v > 0 && w > 0 && x > 0 && y > 0 && z > 0){
              $('#next').prop('disabled', false);
    	}else{
              $("#next").attr("disabled", "disabled");
    	}
    }

}

function StepValidate(step){
    var bval = true;
    switch (step){
        case 'firstStep':
			break;
        case 'secondStep':
            stepsecondValidate();
            break;
        case 'thirdStep':
            stepthirdValidate();
            break;
    }
}


function SearchStatus(e){
    var sval = e.keyCode;
    if (sval!=13){
        $("#next").attr("disabled", "disabled");
        $('#search-results').hide();
    } else {
        LoadResults();
    }
}

function GoSearch(){
    var searchValue = $('#search-value').val();
    if(searchValue.length > 0){
		LoadResults();
	}
}

function LoadResults(){
    var sval =  $("#search-value").val();
    $.post('classes/wizards_supplements_create.class.php', { "search-indemnitors": 1, "search-value": sval }, function (data) {
	    $('#search-results').html(data);
        $('#search-results').show();
    });
}

function loadIndemnitor(id){

    var payer = $("#"+id).find('td:eq(3)').text();
    var defendant = $("#"+id).find('td:eq(0)').text();
    var defendantid = $("#"+id).find('td:eq(4)').text();
    defendantid = $.trim(defendantid);
    $('#supplement-payer').val(payer);
    $('#supplement-payerid').val(id);
    $('#supplement-defendant').val(defendant);
    $('#supplement-defendantid').val(defendantid);
    $('#review-indemnitor').html(payer);
    $('#reportbutton').html('<a href="documents/'+defendantid+'/supplementapplication'+id+'.pdf" target="_blank"><button class="btn btn-small btn-primary"><i class=" icon-print"></i> Report</button></a></center>');
	$("#form-wizard").formwizard("next");

}
function displayMethod(){
    var method = $("#draw-method").select2('val');
    $('#check-detail').hide();
    $('#card-detail').hide();
    if (method=='check'){
        $('#check-detail').show();
    }
    if (method=='card'){
        $('#card-detail').show();
    }
    stepthirdValidate();
}
