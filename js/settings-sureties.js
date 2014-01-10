$(document).ready(function() {

        $('#surety-label').html('<i class="icon-list-alt"></i> Sureties');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#surety-name").val('');
            $("#surety-delete").attr('checked', false);
            $('input[name=surety-id]').val(-1);
			$('#list-actions').hide();
            $('#surety-list').hide();
            $('#surety-label').html('<i class="icon-list-alt"></i> Sureties - Add');
            $('#surety-box').show();
            $("#surety-name").focus();
		});

        $("#surety-cancel").click(function(){
            $('#surety-box').hide();
            $('#surety-label').html('<i class="icon-list-alt"></i> Sureties');
            $('#list-actions').show();
            $('#surety-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifySurety('delete');
		});

        $("#surety-form").validate({
	        submitHandler: function() {
                var flag = $('#surety-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#surety-save').button('loading');
                    var id = $("#surety-id").val();
                    if (id==-1){
                        ModifySurety('add');
                    } else {
                        ModifySurety('edit');
                    }
                }
            },
        });

});

function LoadSurety(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_surety.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#surety-list').hide();
            $('#surety-label').html('<i class="icon-list-alt"></i> Sureties - Edit');
            $('#surety-box').show();
            $("#record-delete").show();
            $("#surety-delete").attr('checked', false);
            $("#surety-name").val(name);
            $('input[name=surety-id]').val(id);
            $("#surety-name").focus();
            }
        }
    });
}

function ModifySurety(type){
    var post = $('#surety-form').serialize();
    $.post('classes/settings_surety.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-surety').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#surety-save').button('reset');
            }
        }
    });
}