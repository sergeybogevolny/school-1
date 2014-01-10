$(document).ready(function() {
        $('#detail-label').html('Detail');
        $('#comment-label').html('Comment');
        $('#comment-box-actions').hide();

        $("#actions-delete-recorded").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Supplement - Delete');
            $('#supplement-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-questioned").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Supplement - Delete');
            $('#supplement-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-charged").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Supplement - Delete');
            $('#supplement-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-bill").click(function(event){
			event.preventDefault();
            Billvalidate();
            $("#modal-bill").modal();
		});

        $("#actions-revert").click(function(event){
			event.preventDefault();
            $("#modal-revert").modal();
		});

        $('#bill-save').on('click', function(event) {
            event.preventDefault();
            ModifySupplement('bill');
            $('#modal-bill').modal('hide');
        });

        $('#revert-save').on('click', function(event) {
            event.preventDefault();
            ModifySupplement('revert');
            $('#modal-revert').modal('hide');
        });

        $('#detail-save').on('click', function(event) {
            event.preventDefault();
            ModifySupplement('detail');
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

});

function LoadDetail(id){
    var type = SUPPLEMENT_TYPE;
    var recorded = SUPPLEMENT_RECORDED;
    var payer = SUPPLEMENT_PAYER;
    var defendant = SUPPLEMENT_DEFENDANT;
    var amount = SUPPLEMENT_AMOUNT;
    var charged = SUPPLEMENT_CHARGED;
    var billed = SUPPLEMENT_BILLED;

	$("#detail-recorded").val(recorded);
	$("#detail-payer").val(payer);
	$("#detail-defendant").val(defendant);
	$("#detail-amount").val(amount);
	$("#detail-charged").val(charged);
	$("#detail-billed").val(billed);
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
	    $('#detail-save').prop('disabled', true);
	}
    */
    $('#detail-save').prop('disabled', false);
}

function Billvalidate(){
    /*
    var z = $('#supplement-questionedagent-select').val().length;
    if(z>0){
	    $('#question-save').prop('disabled', false);
	}else{
	     $('#question-save').prop('disabled', true);
	}
    */
    $('#bill-save').prop('disabled', false);
}

function LoadComment(id){
    //var comment = SUPPLEMENT_COMMENT;
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

function ModifySupplement(type){
    var post = '';
    switch (type){
        case 'detail':
            post = $('#detail-form').serialize();
            break;
        case 'bill':
            post = $('#bill-form').serialize();
            break;
        case 'revert':
            post = $('#revert-form').serialize();
            break;
    }
    if (post==''){
        return;
    }

    $.post('classes/supplement.class.php', post, function (data) {
        if (data.match('success') !== null) {
			location.reload();
        } else {
            alert('error');

        }
    });
}
