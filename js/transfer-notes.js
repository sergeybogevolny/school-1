$(document).ready(function() {

        $('#notes-label').html('<i class="icon-list-alt"></i> Notes');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

	   $("#notes-add").click(function(e){
			e.preventDefault();

            $("#record-delete").hide();
            $("#note-comment").val('');
            $("#note-delete").attr('checked', false);
            $('input[name=note-id]').val(-1);

            $('#list-actions').hide();
            $('#notes-list').hide();
            $('#notes-label').html('<i class="icon-list-alt"></i> Notes - Add');
            $('#notes-box').show();
            $("#note-comment").focus();

		});

        $("#note-cancel").click(function(){
            $('#notes-box').hide();
            $('#notes-label').html('<i class="icon-list-alt"></i> Notes');
            $('#list-actions').show();
            $('#notes-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyNote('delete');
		});

        $("#note-form").validate({
	        submitHandler: function() {
                var flag = $('#note-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#note-save').button('loading');
                    var id = $("#note-id").val();
                    if (id==-1){
                        ModifyNote('add');
                    } else {
                        ModifyNote('edit');
                    }
                }
            },
        });

});

function LoadNote(id){
    var row = NOTES_SOURCE.filter( function(item){return (item.id==id);} );

    var comment = row[0]['comment'];

    $("#record-delete").show();
    $("#note-delete").attr('checked', false);
    $("#note-comment").val(comment);
    $('input[name=note-id]').val(id);

    $('#list-actions').hide();
    $('#notes-list').hide();
    $('#notes-label').html('<i class="icon-list-alt"></i> Notes - Edit');
    $('#notes-box').show();
    $("#note-comment").focus();

}


function ModifyNote(type){
    var post = $('#note-form').serialize();
    $.post('classes/transfer_note.class.php', post, function (data) {
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
                $('#note-save').button('reset');
            }
        }
    });
}