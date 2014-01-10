$(document).ready(function() {

        $('#detail-label').html('Detail');

        $("#actions-delete-associate").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Agent - Delete');
            $('#agent-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-candidate").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Agent - Delete');
            $('#agent-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-contracted").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Agent - Delete');
            $('#agent-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-revert").click(function(event){
			event.preventDefault();
            $("#modal-revert").modal();
		});

        $("#actions-reject").click(function(event){
			event.preventDefault();
            Rejectvalidate();
            $("#modal-reject").modal();
		});

        $("#actions-contract").click(function(event){
			event.preventDefault();
            Contractvalidate();
            $("#modal-contract").modal();
		});

        $('#contract-save').on('click', function(event) {
            event.preventDefault();
            ModifyAgent('contract');
            $('#modal-contract').modal('hide');
        });

        $('#revert-save').on('click', function(event) {
            event.preventDefault();
            ModifyAgent('revert');
            $('#modal-revert').modal('hide');
        });

        $('#reject-save').on('click', function(event) {
            event.preventDefault();
            ModifyAgent('reject');
            $('#modal-reject').modal('hide');
        });

        $('#detail-save').on('click', function(event) {
            event.preventDefault();
            ModifyAgent('detail');
        });

        $("#detail-cancel").click(function(){
            $('#detail-box').hide();
            $('#detail-label').html('Detail');
            $('#detail-list-actions').show();
            $('#detail-list').show();
		});

        $("#agent-netminimum").autoNumeric('init');
        $("#agent-bufminimum").autoNumeric('init');
        $(".mask-rate").mask("999");

});

function LoadDetail(id){
    var type = AGENT_TYPE;
    var company = AGENT_COMPANY;
	var contact = AGENT_CONTACT ;
	var address = AGENT_ADDRESS ;
	var city    = AGENT_CITY ;
	var state   = AGENT_STATE ;
	var zip     = AGENT_ZIP;
	var phone1type = AGENT_PHONE1TYPE;
	var phone1     = AGENT_PHONE1;
	var phone2type =AGENT_PHONE2TYPE;
	var phone2     =AGENT_PHONE2 ;
	var phone3type =AGENT_PHONE3TYPE;
	var phone3      =AGENT_PHONE3 ;
	

    $('input[name=detail-type]').val(type);
	$("#detail-company").val(company);
	$("#detail-contact").val(company);
    $("#detail-address").val(address);
    $("#detail-city").val(city);
    $("#detail-state").select2('val',state);;
    $("#detail-zip").val(zip);
    $("#detail-phone1type").select2('val',phone1type);
    $("#detail-phone1").val(phone1);
    $("#detail-phone2type").select2('val',phone2type);
    $("#detail-phone2").val(phone2);
    $("#detail-phone3type").select2('val',phone3type);
    $("#detail-phone3").val(phone3);
    
	
	$('#detail-list-actions').hide();
    $('#detail-list').hide();

    $('#detail-label').html('Detail - Edit');
    $('#detail-box').show();

    Detailvalidate();

    //$("#personal-company").focus();

}

function Detailvalidate(){
    /*
    var v = $('#detail-received').val().length;
    var w = $("#detail-civilcasenumber").val().length;
    var x = $("#detail-forfeited").val().length;
    var y = $("#detail-county").val().length;
    var z = $("#detail-amount").val().length;
    if(v > 0 && w > 0 && x > 0 && y > 0 && z>0){
	    $('#detail-save').prop('disabled', false);
	}else{
	    $("#detail-save").attr("disabled", "disabled");
	}
    */
}

function Rejectvalidate(){
    var z = $('#agent-rejectreason-select').val().length;
    if(z>0){
	    $('#reject-save').prop('disabled', false);
	}else{
	     $('#reject-save').prop('disabled', true);
	}
}

function Contractvalidate(){
    var w = $('#agent-net').val().length;
    var x = $("#agent-netminimum").val().length;
    var y = $("#agent-buf").val().length;
    var z = $("#agent-bufminimum").val().length;
    if(w > 0 && x > 0 && y > 0 && z>0){
	    $('#contract-save').prop('disabled', false);
	}else{
	    $("#contract-save").prop("disabled", true);
	}
}

function ModifyAgent(type){
    var post = '';
    switch (type){
        case 'detail':
            post = $('#detail-form').serialize();
            break;
        case 'contract':
            post = $('#contract-form').serialize();
            break;
        case 'reject':
            post = $('#reject-form').serialize();
            break;
        case 'revert':
            post = $('#revert-form').serialize();
            break;
    }
    if (post==''){
        return;
    }
    $.post('classes/agent.class.php', post, function (data) {
        if (data.match('success') !== null) {
			location.reload();
        } else {
            
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
        }
    });
}

