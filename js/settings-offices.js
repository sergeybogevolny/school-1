$(document).ready(function() {

        $('#office-label').html('<i class="icon-list-alt"></i> Offices');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#office-name").val('');
            $("#office-delete").attr('checked', false);
            $('input[name=office-id]').val(-1);
			$('#list-actions').hide();
            $('#office-list').hide();
            $('#office-label').html('<i class="icon-list-alt"></i> Offices - Add');
            $('#office-box').show();
            $("#office-name").focus();
		});

        $("#office-cancel").click(function(){
            $('#office-box').hide();
            $('#office-label').html('<i class="icon-list-alt"></i> Offices');
            $('#list-actions').show();
            $('#office-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyOffice('delete');
		});

        $("#office-form").validate({
	        submitHandler: function() {
                var flag = $('#office-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#office-save').button('loading');
                    var id = $("#office-id").val();
                    if (id==-1){
                        ModifyOffice('add');
                    } else {
                        ModifyOffice('edit');
                    }
                }
            },
        });

});

function LoadOffice(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_office.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#office-list').hide();
            $('#office-label').html('<i class="icon-list-alt"></i> Offices - Edit');
            $('#office-box').show();
            $("#record-delete").show();
            $("#office-delete").attr('checked', false);
            $("#office-name").val(name);
            $('input[name=office-id]').val(id);
            $("#office-name").focus();
            }
        }
    });
}

function ModifyOffice(type){
    var post = $('#office-form').serialize();
    $.post('classes/settings_office.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-office').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#office-save').button('reset');
            }
        }
    });
}