$(document).ready(function() {
    var form_wizard = $("#form-wizard");
    $('#powers-label').html('<i class="icon-list-alt"></i> Powers');
  
    mv = new Array();
    mvi = 0;

	if (form_wizard.length > 0) {
		form_wizard.formwizard({
            formPluginEnabled: true,
			validationEnabled: true,
			focusFirstInput : true,
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
            textSubmit: 'Create',
			textNext: 'Next',
			textBack: 'Back',
		}).bind("step_shown",function(){ // as the next button is not handled by the wizard, we need to handle the button caption ourselves
            var step = $("#form-wizard").formwizard("state").currentStep;
            StepValidate(step);
        }).trigger("step_shown");

        form_wizard.bind("before_step_shown", function(e, data) {
				var orderdate = $("#order-date").val();
				var courier = $("#order-courier").val();
				var ordername = $("#surety-ordername").val();
				var surety = $("#order-surety").val();
	
				var powers = $("#powers-list").html();
	
				$("#review_orderdate").text(orderdate);
				if (courier==''){
					$("#group-courier").hide();
				} else {
					$("#review_courier").text(courier);
					$("#group-courier").show();
				}
				$("#review_surety").text(surety);
	
				if (powers==''){
					$("#group-powers").hide();
				} else {
					document.getElementById("review_powers").innerHTML = powers;
					$("#group-powers").show();
				}
		});

	}

	var orderdate = $('#order-date').datepicker().on('changeDate', function(ev) {orderdate.hide();}).data('datepicker');
    var powerissued = $('#power-issued').datepicker().on('changeDate', function(ev) {powerissued.hide();}).data('datepicker');
    var powerexpiration = $('#power-expiration').datepicker().on('changeDate', function(ev) {powerexpiration.hide();}).data('datepicker');

	$("#powers-add").click(function(e){
	    e.preventDefault();
        $("#power-save").attr("disabled", "disabled");
        $("#power-prefix").select2('val', '');
        $("#power-serialbegin").val('');
        $("#power-serialend").val('');
        $("#power-issued").val('');
        $("#power-expiration").val('');
		$("#power-delete").iCheck('uncheck');
		$('#powerDelete').hide();
        $('#wizard-actions').hide();
        $('#list-actions').hide();
        $('#powers-list').hide();
		$("#powerId").val('');
        $('#powers-label').html('<i class="icon-list-alt"></i> Powers - Add');
        $('#powers-box').show();
	});

    $("#power-save").click(function(e){
		setChangedPower();
	});

    $("#power-cancel").click(function(){
        $('#powers-box').hide();
        $('#powers-label').html('<i class="icon-list-alt"></i> Powers');
        $('#wizard-actions').show();
        $('#list-actions').show();
        $('#powers-list').show();
	});

    $("#form-wizard").show();

    $("#power-issued").change(function() {
        var issued = $("#power-issued").val();
        if (issued!=''){
            var getYYYY = new Date(issued).getFullYear()+1;
            var getMM = new Date(issued).getMonth() + 1;
            var getDD = new Date(issued).getDate();
            var editdate = ('0' + getMM).slice(-2) + '/'
             + ('0' + getDD).slice(-2) + '/'
             + getYYYY;
            $('#power-expiration').val(editdate);
        }
    });

});

function Powerlistvalidate(){
    var bval = true;
    $("#power-save").attr("disabled", "disabled");
    var powerprefix = $('#power-prefix').val();
    var powerserialbegin = $('#power-serialbegin').val();
    var powerserialend = $('#power-serialend').val();
    var powerissued = $('#power-issued').val();
    var powerexpiration = $('#power-expiration').val();
    if ((powerprefix=='')||(powerserialbegin=='')||(powerserialend=='')||(powerissued=='')||(powerexpiration=='')){
        bval = false;
    }
    if (bval==true){
        $('#power-save').prop('disabled', false);
    }
}

function Stepfirstvalidate(){
		var x = $('#order-date').val().length;
		var y = $('#order-surety').val().length;

		if(x > 0 && y > 0){
		   $('#next').prop('disabled', false);
		}else{
		   $("#next").attr("disabled", "disabled");
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
            $("#next").attr("disabled", "disabled");
            var i = mv.length;
            if (i>0){
                $('#next').prop('disabled', false);
            }
            break;
    }
}

function getPowerDetail(id){
		var eprefix         = $("#"+id).find('td:eq(0)').text()
		var eserial_begin   = $("#"+id).find('td:eq(1)').text()
		var eserial_end     = $("#"+id).find('td:eq(2)').text()
		var eissuedate      = $("#"+id).find('td:eq(3)').text()
		var eexpirationdate = $("#"+id).find('td:eq(4)').text()
		
		$("#power-prefix").select2('val', eprefix);
		$("#power-serialbegin").val(eserial_begin);
		$("#power-serialend").val(eserial_end);
		$("#power-issued").val(eissuedate);
		$("#power-expiration").val(eexpirationdate);
		$("#power-delete").iCheck('uncheck');
		$('#powerDelete').show();
		$("#powerId").val(id);
		$('#wizard-actions').hide();
		$('#list-actions').hide();
		$('#powers-list').hide();
		$('#powers-label').html('<i class="icon-list-alt"></i> Powers - Edit');
		$('#powers-box').show();
}

function setChangedPower(){
		var a = $("#power-prefix").select2('val');
		var b = $("#power-serialbegin").val();
		var c = $("#power-serialend").val();
		var d = $("#power-issued").val();
		var e = $("#power-expiration").val();
		
		var ids = $("#powerId").val();
		var trRow = $('#powerOrder').find('tr.op').length;
		
		if( ids != '' && trRow != 0 ){
		    var i = ids;
			mv.length = trRow;
		}else{
            var i = mv.length;
		}
		
        mv[i] = new Array();
        mv[i][0] = mvi;
        mv[i][1] = a;
        mv[i][2] = b;
        mv[i][3] = c;
        mv[i][4] = d;
        mv[i][5] = e;
        mvi += 1

        var thead = '<table class="table table-hover table-nomargin table-bordered" id="powerOrder"><thead><tr><th>Prefix</th><th>Serial Begin</th><th>Serial End</th><th>Issued</th><th>Expiration</th></tr></thead><tbody>';
        var trow = '';
        var tfoot = '</tbody><tfoot></tfoot></table>';
        var id = 0;
        for ( var j = 0; j < mv.length; j++) {
            var a = mv[j][1] +'<input type="hidden" name="prefixmv[]" value="'+mv[j][1]+'">';
            var b = mv[j][2] +'<input type="hidden" name="serialbeginmv[]" value="'+mv[j][2]+'">';
            var c = mv[j][3] +'<input type="hidden" name="serialendmv[]" value="'+mv[j][3]+'">';
            var d = mv[j][4] +'<input type="hidden" name="issuedmv[]" value="'+mv[j][4]+'">';
            var e = mv[j][5] +'<input type="hidden" name="expirationmv[]" value="'+mv[j][5]+'">';
            var line = '<tr id="'+id+'" class="op"><td>'+a+'</td><td><a href="#" onclick="getPowerDetail('+id+')">'+b+'</a></td><td>'+c+'</td><td>'+d+'</td><td>'+e+'</td></tr>';
            trow = trow + line;
			id++ ;
        }

        var tfull = thead+trow+tfoot;
        document.getElementById("powers-list").innerHTML = tfull;
		
	    var flag = $('#power-delete').is(":checked");
            if (flag==true){	
			  $("#powerOrder").find("#" + ids).remove();
			  if(trRow == 1){
                   mv.length = 0;
				   document.getElementById("powers-list").innerHTML = '';
				}
			};
        $('#next').prop('disabled', false);
        $('#powers-box').hide();
        $('#powers-label').html('<i class="icon-list-alt"></i> Powers');
        $('#wizard-actions').show();
        $('#list-actions').show();
        $('#powers-list').show();
	
}

function PowerDelete(id){
   document.getElementById(id).remove();
}
	


