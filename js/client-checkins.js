$(document).ready(function() {

        $('#checkins-label').html('<i class="icon-list-alt"></i> Check Ins');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

	   $("#checkins-add").click(function(e){
			e.preventDefault();

            $("#record-delete").hide();
            $("#checkin-charge").val('');
            $("#checkin-delete").attr('checked', false);
            $('input[name=checkin-id]').val(-1);

            $('#list-actions').hide();
            $('#checkins-list').hide();
            $('#checkins-label').html('<i class="icon-list-alt"></i> Check Ins - Add');
            $('#checkins-box').show();
            $("#checkin-comment").focus();

		});

        $("#checkin-cancel").click(function(){
            $('#checkins-box').hide();
            $('#checkins-label').html('<i class="icon-list-alt"></i> Check Ins');
            $('#list-actions').show();
            $('#checkins-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyCheckin('delete');
		});

        $("#checkin-form").validate({
	        submitHandler: function() {
                var flag = $('#checkin-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#checkin-save').button('loading');
                    var id = $("#checkin-id").val();
                    if (id==-1){
                        ModifyCheckin('add');
                    } else {
                        ModifyCheckin('edit');
                    }
                }
            },
        });

});


function LoadCheckin(id){
    var row = CHECKINS_SOURCE.filter( function(item){return (item.id==id);} );

    var comment = row[0]['comment'];

    $("#record-delete").show();
    $("#checkin-comment").val(comment);
    $('input[name=checkin-id]').val(id);

    $('#list-actions').hide();
    $('#checkins-list').hide();
    $('#checkins-label').html('<i class="icon-list-alt"></i> Check Ins - Edit');
    $('#checkins-box').show();
    $("#checkin-comment").focus();

}


function ModifyCheckin(type){
    var post = $('#checkin-form').serialize();
    $.post('classes/client_checkin.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#checkin-save').button('reset');
            }
        }
    });
}