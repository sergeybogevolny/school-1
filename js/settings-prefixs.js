$(document).ready(function() {

        $('#prefix-label').html('<i class="icon-list-alt"></i> Prefixs');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#prefix-name").val('');
            $("#prefix-delete").attr('checked', false);
            $('input[name=prefix-id]').val(-1);
			$('#list-actions').hide();
            $('#prefix-list').hide();
            $('#prefix-label').html('<i class="icon-list-alt"></i> Prefixs - Add');
            $('#prefix-box').show();
            $("#prefix-name").focus();
		});

        $("#prefix-cancel").click(function(){
            $('#prefix-box').hide();
            $('#prefix-label').html('<i class="icon-list-alt"></i> Prefixs');
            $('#list-actions').show();
            $('#prefix-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyPrefix('delete');
		});

        $("#prefix-form").validate({
	        submitHandler: function() {
                var flag = $('#prefix-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#prefix-save').button('loading');
                    var id = $("#prefix-id").val();
                    if (id==-1){
                        ModifyPrefix('add');
                    } else {
                        ModifyPrefix('edit');
                    }
                }
            },
        });

});

function LoadPrefix(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_prefix.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#prefix-list').hide();
            $('#prefix-label').html('<i class="icon-list-alt"></i> Prefixs - Edit');
            $('#prefix-box').show();
            $("#record-delete").show();
            $("#prefix-delete").attr('checked', false);
            $("#prefix-name").val(name);
            $('input[name=prefix-id]').val(id);
            $("#prefix-name").focus();
            }
        }
    });
}

function ModifyPrefix(type){
    var post = $('#prefix-form').serialize();
    $.post('classes/settings_prefix.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-prefix').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#prefix-save').button('reset');
            }
        }
    });
}