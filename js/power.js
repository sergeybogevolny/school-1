$(document).ready(function() {

        $('#detail-label').html('Detail');

        $("#actions-dispatch").click(function(event){
			event.preventDefault();
            $("#modal-dispatch").modal();
		});

        $('#dispatch-save').on('click', function(event) {
            event.preventDefault();
            var postingagentid = $('#transfer-postingagent-select').find(':selected')[0].id;
            $('#transfer-postingagent-id').val(postingagentid);
            ModifyPower('dispatch');
            $('#modal-dispatch').modal('hide');
        });

        $('#detail-save').on('click', function(event) {
            event.preventDefault();
            ModifyPower('detail');
        });

        $("#detail-cancel").click(function(){
            $('#detail-box').hide();
            $('#detail-label').html('Detail');
            $('#detail-list-actions').show();
            $('#detail-list').show();
		});

});

function LoadDetail(id){
    var ordered = POWER_ORDERED;

	$("#detail-ordered").val(ordered);

    //$("#detail").select2('val',);
    $('input[name=detail-id]').val(id);

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

function ModifyPower(type){
    var post = '';
    switch (type){
        case 'detail':
            post = $('#detail-form').serialize();
            break;
        case 'dispatch':
            post = $('#dispatch-form').serialize();
            break;
    }
    if (post==''){
        return;
    }
    alert(post);
    $.post('classes/power.class.php', post, function (data) {
        alert(data);
        if (data.match('success') !== null) {
			location.reload();
        } else {
            alert('error');
            /*
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='personal'){
                $('#personal-save').button('reset');
            } else {
                //$('#transaction-save').button('reset');
            }
            */
        }
    });
}

