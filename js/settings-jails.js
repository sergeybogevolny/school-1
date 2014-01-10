$(document).ready(function() {
	
        $('#jail-label').html('<i class="icon-list-alt"></i> Jails');
		
        $("#jqxWindow-jail").jqxWindow({
            width: 290, height: 500, position: 'center', resizable: true, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#jail-name").val('');
            $("#jail-delete").attr('checked', false);
            $('input[name=jail-id]').val(-1);
			$('#list-actions').hide();
            $('#jail-list').hide();
            $('#jail-label').html('<i class="icon-list-alt"></i> Jails - Add');
            $('#jail-box').show();
            $("#jail-name").focus();
		});

        $("#jail-cancel").click(function(){
            $('#jail-box').hide();
            $('#jail-label').html('<i class="icon-list-alt"></i> Jails');
            $('#list-actions').show();
            $('#jail-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyJail('delete');
		});

        $("#jail-form").validate({
	        submitHandler: function() {
                var flag = $('#jail-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#jail-save').button('loading');
                    var id = $("#jail-id").val();
                    if (id==-1){
                        ModifyJail('add');
                    } else {
                        ModifyJail('edit');
                    }
                }
            },
        });

});

function LoadJail(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_jail.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#jail-list').hide();
            $('#jail-label').html('<i class="icon-list-alt"></i> Jails - Edit');
            $('#jail-box').show();
            $("#record-delete").show();
            $("#jail-delete").attr('checked', false);
            $("#jail-name").val(name);
            $('input[name=jail-id]').val(id);
            $("#jail-name").focus();
            }
        }
    });
}

function ModifyJail(type){
    var post = $('#jail-form').serialize();
    $.post('classes/settings_jail.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-jail').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#jail-save').button('reset');
            }
        }
    });
}