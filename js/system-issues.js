$(document).ready(function() {

        $('#attorney-label').html('<i class="icon-list-alt"></i> Attorneys');
		
        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#attorney-name").val('');
            $("#attorney-delete").attr('checked', false);
            $('#list-actions').hide();
            $('#attorney-list').hide();
            $('#attorney-label').html('<i class="icon-list-alt"></i> Attorneys - Add');
            $('#attorney-box').show();
            $('input[name=attorney-id]').val(-1);
            $("#attorney-name").focus();
		});

        $("#attorney-cancel").click(function(){
            $('#attorney-box').hide();
            $('#attorney-label').html('<i class="icon-list-alt"></i> Attorneys');
            $('#list-actions').show();
            $('#attorney-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyAttorney('delete');
		});

        $("#attorney-form").validate({
	        submitHandler: function() {
                var flag = $('#attorney-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#attorney-save').button('loading');
                    var id = $("#attorney-id").val();
                    if (id==-1){
                        ModifyAttorney('add');
                    } else {
                        ModifyAttorney('edit');
                    }
                }
            },
        });

});

function LoadAttorney(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_attorney.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#attorney-list').hide();
            $('#attorney-label').html('<i class="icon-list-alt"></i> Attorneys - Edit');
            $('#attorney-box').show();
			$("#record-delete").show();
            $("#attorney-delete").attr('checked', false);
            $("#attorney-name").val(name);
		    $('input[name=attorney-id]').val(id);
            $("#attorney-name").focus();
            }
        }
    });
}

function ModifyAttorney(type){
    var post = $('#attorney-form').serialize();
    $.post('classes/settings_attorney.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-attorney').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#attorney-save').button('reset');
            }
        }
    });
}