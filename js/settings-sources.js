$(document).ready(function() {

        $('#source-label').html('<i class="icon-list-alt"></i> Sources');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#source-name").val('');
            $("#source-delete").attr('checked', false);
            $('input[name=source-id]').val(-1);
			$('#list-actions').hide();
            $('#source-list').hide();
            $('#source-label').html('<i class="icon-list-alt"></i> Sources - Add');
            $('#source-box').show();
            $("#source-name").focus();
		});

        $("#source-cancel").click(function(){
            $('#source-box').hide();
            $('#source-label').html('<i class="icon-list-alt"></i> Sources');
            $('#list-actions').show();
            $('#source-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifySource('delete');
		});

        $("#source-form").validate({
	        submitHandler: function() {
                var flag = $('#source-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#source-save').button('loading');
                    var id = $("#source-id").val();
                    if (id==-1){
                        ModifySource('add');
                    } else {
                        ModifySource('edit');
                    }
                }
            },
        });

});

function LoadSource(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_source.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#source-list').hide();
            $('#source-label').html('<i class="icon-list-alt"></i> Sources - Edit');
            $('#source-box').show();
            $("#record-delete").show();
            $("#source-delete").attr('checked', false);
            $("#source-name").val(name);
            $('input[name=source-id]').val(id);
            $("#source-name").focus();
            }
        }
    });
}

function ModifySource(type){
    var post = $('#source-form').serialize();
    $.post('classes/settings_source.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-source').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#source-save').button('reset');
            }
        }
    });
}