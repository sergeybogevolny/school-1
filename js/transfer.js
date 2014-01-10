$(document).ready(function() {

        $('#detail-label').html('Detail');
        $('#comment-label').html('Comment');
        $('#comment-box-actions').hide();

        $("#actions-delete-recorded").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Transfer - Delete');
            $('#transfer-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-dispatched").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Transfer - Delete');
            $('#transfer-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-rejected").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Transfer - Delete');
            $('#transfer-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-posted").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Transfer - Delete');
            $('#transfer-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-settled").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Transfer - Delete');
            $('#transfer-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-dispatch").click(function(event){
			event.preventDefault();
            $("#modal-dispatch").modal();
		});

        $("#actions-reject").click(function(event){
			event.preventDefault();
            $("#modal-reject").modal();
		});

        $("#actions-revert").click(function(event){
			event.preventDefault();
            $("#modal-revert").modal();
		});

        $("#actions-post").click(function(event){
			event.preventDefault();
            Postvalidate();
            $("#modal-post").modal();
		});

        $("#actions-settle").click(function(event){
			event.preventDefault();
            var prefix = TRANSFER_PREFIX;
            var serial = TRANSFER_SERIAL;
            $.get( "classes/transfer.class.php", { settlepower: 1, prefix: prefix, serial: serial } )
			.done(function( data ) {
			    var rec = JSON.parse(data);
				console.log(rec.id);
				if(rec.powerid == -1){
				    $('#settle-valid').hide();
				    $('#settle-invalid').show();
				}else{
				    $('#power-id').val(rec.powerid);
                    $('#transfer-settlereason-select').val('');
                    $('#settle-invalid').hide();
				    $('#settle-valid').show();
                }
            });
            Settlevalidate();
            $("#modal-settle").modal();
		});

        $('#dispatch-save').on('click', function(event) {
            event.preventDefault();
            var postingagentid = $('#transfer-postingagent-select').find(':selected')[0].id;
            $('#transfer-postingagent-id').val(postingagentid);
            ModifyTransfer('dispatch');
            $('#modal-dispatch').modal('hide');
        });

        $('#reject-save').on('click', function(event) {
            event.preventDefault();
            ModifyTransfer('reject');
            $('#modal-reject').modal('hide');
        });

        $('#revert-save').on('click', function(event) {
            event.preventDefault();
            ModifyTransfer('revert');
            $('#modal-revert').modal('hide');
        });

        $('#post-save').on('click', function(event) {
            event.preventDefault();
            ModifyTransfer('post');
            $('#modal-post').modal('hide');
        });

        $('#settle-save').on('click', function(event) {
            event.preventDefault();
            ModifyTransfer('settle');
            $('#modal-settle').modal('hide');
        });

        $('#detail-save').on('click', function(event) {
            event.preventDefault();
            ModifyTransfer('detail');
        });

        $("#detail-cancel").click(function(){
            $('#detail-box').hide();
            $('#detail-label').html('Detail');
            $('#detail-list-actions').show();
            $('#detail-list').show();
            $('#comment-view').show();
		});

        $("#comment-cancel").click(function(){
            $('#comment-box-actions').hide();
            $('#comment-box').hide();
            $('#comment-label').html('Comment');
            $('#comment-list-actions').show();
            $('#comment-list').show();
            $('#detail-view').show();
		});

        $("#detail-postingagent-fee").autoNumeric('init');
        $("#detail-postingagent-received").autoNumeric('init');
        $("#detail-requestingagent-fee").autoNumeric('init');
        $("#detail-requestingagent-received").autoNumeric('init');

        $("#transfer-requesting-amount").autoNumeric('init');
        $("#transfer-posting-amount").autoNumeric('init');
});

function LoadDetail(id){
    var type = TRANSFER_TYPE;
    var recorded = TRANSFER_RECORDED;
    var requestingagent = TRANSFER_REQUESTINGAGENT;
    var amount = TRANSFER_AMOUNT;
    var county = TRANSFER_COUNTY;
    var dispatched = TRANSFER_DISPATCHED;
    var postingagent = TRANSFER_POSTINGAGENT;
    var rejected = TRANSFER_REJECTED;
    var rejectedreason = TRANSFER_REJECTEDREASON;
    var posted = TRANSFER_POSTED;
    var postingfee = TRANSFER_POSTINGFEE;
    var postingreceived = TRANSFER_POSTINGRECEIVED;
    var generalfee = TRANSFER_GENERALFEE;
    var generalreceived = TRANSFER_GENERALRECEIVED;
    var settled = TRANSFER_SETTLED;
    var settledreason = TRANSFER_SETTLEDREASON;
    var prefix = TRANSFER_PREFIX;
    var serial = TRANSFER_SERIAL;
    var power = TRANSFER_POWER;

    $('input[name=detail-type]').val(type);
	$("#detail-recorded").val(recorded);
    $("#detail-requestingagent-select").select2('val',requestingagent);
	$("#detail-amount").val(amount);
    $("#detail-county-select").select2('val',county);
	$("#detail-dispatched").val(dispatched);
    $("#detail-postingagent").val(postingagent);
	$("#detail-rejected").val(rejected);
    $("#detail-rejectedreason").val(rejectedreason);
    $("#detail-posted").val(posted);
	$("#detail-postingagent-fee").val(postingfee);
    $("#detail-postingagent-received").val(postingreceived);
	$("#detail-generalagent-fee").val(generalfee);
    $("#detail-generalagent-received").val(generalreceived);
	$("#detail-settled").val(settled);
    $("#detail-settledreason").val(settledreason);
    $("#detail-prefix").val(prefix);
    $("#detail-serial").val(serial);
    $("#detail-power").val(power);

    if ((type=='dispatched') || (type=='rejected') || (type=='posted') || (type=='settled')){
        $("#detail-requestingagent-select").select2("enable", false);
        $("#detail-county-select").select2("enable", false);
    } else {
      $("#detail-requestingagent-select").select2("enable", true);
      $("#detail-county-select").select2("enable", true);
    }

    //$("#detail").select2('val',);
    $('input[name=detail-id]').val(id);

    $('#detail-list-actions').hide();
    $('#detail-list').hide();
    $('#comment-view').hide();

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

function Postvalidate(){
    var y = $("#transfer-general-amount").val().length;
    var z = $("#transfer-posting-amount").val().length;
    if(y > 0 && z>0){
	    $('#post-save').prop('disabled', false);
	}else{
	    $("#post-save").attr("disabled", "disabled");
	}
}

function Settlevalidate(){
    var z = $("#transfer-settlereason-select").val().length;
    if(z>0){
	    $('#settle-save').prop('disabled', false);
	}else{
	    $("#settle-save").attr("disabled", "disabled");
	}
}

function LoadComment(id){
    //var comment = FORFEITURE_COMMENT;
    var comment = $("#comment-value").html();
    CKEDITOR.instances.editor.setData(comment);
    $('input[name=comment-id]').val(id);

    $('#comment-list-actions').hide();
    $('#comment-list').hide();
    $('#detail-view').hide();

    $('#comment-box-actions').show();
    $('#comment-label').html('Comment - Edit');
    $('#comment-box').show();

    //$("#personal-company").focus();

}

function ModifyTransfer(type){
    var post = '';
    switch (type){
        case 'detail':
            post = $('#detail-form').serialize();
            break;
        case 'dispatch':
            post = $('#dispatch-form').serialize();
            break;
        case 'reject':
            post = $('#reject-form').serialize();
            break;
        case 'revert':
            post = $('#revert-form').serialize();
            break;
        case 'post':
            post = $('#post-form').serialize();
            break;
        case 'settle':
            post = $('#settle-form').serialize();
            break;
    }
    if (post==''){
        return;
    }
    alert(post);
    $.post('classes/transfer.class.php', post, function (data) {
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

