$(document).ready(function() {

        $('#setfor-label').html('<i class="icon-list-alt"></i> Set Fors');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#setfor-name").val('');
            $("#setfor-delete").attr('checked', false);
            $('input[name=setfor-id]').val(-1);
			$('#list-actions').hide();
            $('#setfor-list').hide();
            $('#setfor-label').html('<i class="icon-list-alt"></i> Set Fors - Add');
            $('#setfor-box').show();
            $("#setfor-name").focus();
		});

        $("#setfor-cancel").click(function(){
            $('#setfor-box').hide();
            $('#setfor-label').html('<i class="icon-list-alt"></i> Set Fors');
            $('#list-actions').show();
            $('#setfor-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifySetfor('delete');
		});

        $("#setfor-form").validate({
	        submitHandler: function() {
                var flag = $('#setfor-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#setfor-save').button('loading');
                    var id = $("#setfor-id").val();
                    if (id==-1){
                        ModifySetfor('add');
                    } else {
                        ModifySetfor('edit');
                    }
                }
            },
        });

});

function LoadSetfor(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_setfor.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#setfor-list').hide();
            $('#setfor-label').html('<i class="icon-list-alt"></i> Set Fors - Edit');
            $('#setfor-box').show();
            $("#record-delete").show();
            $("#setfor-delete").attr('checked', false);
            $("#setfor-name").val(name);
            $('input[name=setfor-id]').val(id);
            $("#setfor-name").focus();
            }
        }
    });
}

function ModifySetfor(type){
    var post = $('#setfor-form').serialize();
    $.post('classes/settings_setfor.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-setfor').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#setfor-save').button('reset');
            }
        }
    });
}