$(document).ready(function() {

        if ($("#detail-type").length > 0) {
			function formatImages(option) {
				var img = "task_list_" + option.text.toLowerCase() + ".png";
				return "<img style='padding-right:10px;' src='img/" + img + "'>" + option.text;
			}
			$("#detail-type").select2({
				formatResult: formatImages,
				formatSelection:formatImages,
				escapeMarkup: function(m) { return m; }
			});
	    }

        $('#detail-label').html('Detail');
        $('#timeline-label').html('Timeline');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        var detaildeadline = $('.datepicker').datepicker().on('changeDate', function(ev) {detaildeadline.hide();}).data('datepicker');

        $("#detail-cancel").click(function(){
            DetailCancel();
		});

        $("#timeline-cancel").click(function(){
            TimelineCancel();
		});

        $("#detail-form").validate({
	        submitHandler: function() {
                $('#detail-save').button('loading');
				var id = $('#detail-id').val();
                ModifyDetail(id);
            },
        });

        $("#timeline-form").validate({
	        submitHandler: function() {
                $('#timeline-save').button('loading');
                ModifyTimeline();
            },
        });

});


function LoadDetail(id){
    var task  = DETAIL_TASK;
    var type  = DETAIL_TYPE;
    var assignedstamp = DETAIL_ASSIGNEDSTAMP;
    var deadline = DETAIL_DEADLINE;
    var description = DETAIL_DESCRIPTION;
    var important = DETAIL_IMPORTANT;
    var completed = DETAIL_COMPLETED;

    $("#detail-name").val(task);
    $("#detail-type").select2('val', type);
    $("#detail-description").val(description);
    $("#detail-deadline").val(deadline);
    if (important==1){
        $("#detail-important").prop('checked', true);
    } else {
        $("#detail-important").prop('checked', false);
    }
    $('input[name=detail-id]').val(id);

    $('#list-actions').hide();
    $('#detail-list-actions').hide();
    $('#detail-list').hide();
    $('#timeline-view').hide();
    $('#detail-label').html('Detail - Edit');
    $('#detail-box').show();

    $("#detail-task").focus();

}


function LoadTimeline(id){

    $('#list-actions').hide();
    $('#timeline-list-actions').hide();
    $('#timeline-list').hide();
    $('#detail-view').hide();
    $('#timeline-label').html('Timeline - Add');
    //$('#timeline-view').css('margin-left','-5px');
    $('#timeline-box').show();

    //$("#timeline-source").focus();

}

function DetailCancel(){
    $('#detail-box').hide();
    $('#detail-label').html('Detail');
    $('#list-actions').show();
    $('#detail-list-actions').show();
    $('#detail-list').show();
    $('#timeline-view').show();
}

function TimelineCancel(){
    $('#timeline-box').hide();
    //$('#timeline-view').css('margin-left','40px');
    $('#timeline-label').html('Timeline');
    $('#list-actions').show();
    $('#timeline-list-actions').show();
    $('#timeline-list').show();
    $('#detail-view').show();
}

function ModifyDetail(){
    post = $('#detail-form').serialize();
    $.post('classes/task.edit.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            $('#detail-save').button('reset');
        }
    });
}

function ModifyTimeline(){
    post = $('#timeline-form').serialize();
    $.post('classes/task.add.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            $('#timeline-save').button('reset');
        }
    });
}

