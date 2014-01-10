$(document).ready(function() {

		$('#county-label').html('<i class="icon-list-alt"></i> Counties');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#county-name").val('');
            $("#county-seat").val('');
            $("#county-delete").attr('checked', false);
            $('#list-actions').hide();
            $('#county-list').hide();
            $('#county-label').html('<i class="icon-list-alt"></i> Counties - Add');
            $('#county-box').show();
            $('input[name=county-id]').val(-1);
            $("#county-name").focus();
		});

        $("#county-cancel").click(function(){
            $('#county-box').hide();
            $('#county-label').html('<i class="icon-list-alt"></i> Counties');
            $('#list-actions').show();
            $('#county-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyCounty('delete');
		});

        $("#county-form").validate({
	        submitHandler: function() {
                var flag = $('#county-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#county-save').button('loading');
                    var id = $("#county-id").val();
                    if (id==-1){
                        ModifyCounty('add');
                    } else {
                        ModifyCounty('edit');
                    }
                }
            },
        });

});

function LoadCounty(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_county.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#county-list').hide();
            $('#county-label').html('<i class="icon-list-alt"></i> Counties - Edit');
            $('#county-box').show();
            $("#record-delete").show();
            $("#county-delete").attr('checked', false);
            $("#county-name").val(name);
            $("#county-seat").val(seat);
            $('input[name=county-id]').val(id);
            $("#county-name").focus();
            }
        }
    });
}

function ModifyCounty(type){
    var post = $('#county-form').serialize();
    $.post('classes/settings_county.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-county').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#county-save').button('reset');
            }
        }
    });
}