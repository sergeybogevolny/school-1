$(document).ready(function() {

    var form_wizard = $("#form-wizard");

    //$('#powers-label').html('<i class="icon-list-alt"></i> Powers');

    mv = new Array();
    mvi = 0;

	if (form_wizard.length > 0) {
		form_wizard.formwizard({
            formPluginEnabled: true,
			validationEnabled: true,
			focusFirstInput : false,
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
                         window.location = "powers-available.php";
                    } else {
                        $("#jqxWindow-status").jqxWindow('setTitle', 'Error');
                        $('#jqxWindow-status').jqxWindow({ content: data });
                        $('#jqxWindow-status').jqxWindow('open');
                        $('#jqxWindow-status').jqxWindow('focus');
                    }
				}
			},
            textSubmit: 'Create',
			textNext: 'Next',
			textBack: 'Back',
		});
        form_wizard.bind("before_step_shown", function(e, data) {

            alert('step');

		});
	}

	//var dob = $('.datepicker').datepicker().on('changeDate', function(ev) {dob.hide();}).data('datepicker');

    $("#powers-add").click(function(e){
	    e.preventDefault();
        //$("#record-delete").hide();
        /*
        $("#bond-amount").val('');
        $("#bond-classFelony").prop('checked',false);
		$("#bond-classMisdemeanor").prop('checked',false);
        $("#bond-charge").val('');
        $("#bond-county").select2('val', '');

        $('#wizard-actions').hide();
        $('#list-actions').hide();
        $('#bonds-list').hide();
        $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds - Add');
        $('#bonds-box').show();
        */
	});

    $("#power-save").click(function(e){
        /*
        var a = $("#bond-amount").val();

		if($('input[name="bond-class"]').is(':checked')){
            var b = $('input[name="bond-class"]:checked').val();
	    }else{  var b = ''; }

		var c = $("#bond-charge").val();
        var d = $("#bond-county").val();

        var i = mv.length;
        mv[i] = new Array();
        mv[i][0] = mvi;
        mv[i][1] = a;
        mv[i][2] = b;
        mv[i][3] = c;
        mv[i][4] = d;

        mvi += 1

        var thead = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Amount</th><th>Class</th><th>Charge</th><th>County</th></tr></thead><tbody>';
        var trow = '';
        var tfoot = '</tbody><tfoot></tfoot></table>';

        for ( var j = 0; j < mv.length; j++) {
            var a = mv[j][1] +'<input type="hidden" name="amountmv[]" value="'+mv[j][1]+'">';
            var b = mv[j][2] +'<input type="hidden" name="classmv[]" value="'+mv[j][2]+'">';
            var c = mv[j][3] +'<input type="hidden" name="chargemv[]" value="'+mv[j][3]+'">';
            var d = mv[j][4] +'<input type="hidden" name="countymv[]" value="'+mv[j][4]+'">';
            var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+c+'</td><td>'+d+'</td></tr>';
            trow = trow + line;
        }

        var tfull = thead+trow+tfoot;
        document.getElementById("bonds-list").innerHTML = tfull;

        $('#bonds-box').hide();
        $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');
        $('#wizard-actions').show();
        $('#list-actions').show();
        $('#bonds-list').show();
        */
	});

    $("#power-cancel").click(function(){
        /*
        $('#bonds-box').hide();
        $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');
        $('#wizard-actions').show();
        $('#list-actions').show();
        $('#bonds-list').show();
        */
	});

    $("#form-wizard").show();

});
