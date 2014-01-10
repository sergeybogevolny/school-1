$(document).ready(function() {

		$('#charge-label').html('<i class="icon-list-alt"></i> Charges');
		
        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#charge-name").val('');
            $("#charge-delete").attr('checked', false);
            $('#list-actions').hide();
            $('#charge-list').hide();
            $('#charge-label').html('<i class="icon-list-alt"></i> Charges - Add');
            $('#charge-box').show();
            $('input[name=charge-id]').val(-1);
            $("#charge-name").focus();
		});

        $("#charge-cancel").click(function(){
            $('#charge-box').hide();
            $('#charge-label').html('<i class="icon-list-alt"></i> Charges');
            $('#list-actions').show();
            $('#charge-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyCharge('delete');
		});

        $("#charge-form").validate({
	        submitHandler: function() {
                var flag = $('#charge-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#charge-save').button('loading');
                    var id = $("#charge-id").val();
                    if (id==-1){
                        ModifyCharge('add');
                    } else {
                        ModifyCharge('edit');
                    }
                }
            },
        });

});

function LoadCharge(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_charge.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#charge-list').hide();
            $('#charge-label').html('<i class="icon-list-alt"></i> Charges - Edit');
            $('#charge-box').show();
            $("#record-delete").show();
            $("#charge-delete").attr('checked', false);
            $("#charge-name").val(name);
            $('input[name=charge-id]').val(id);
            $("#charge-name").focus();
            }
        }
    });
}

function ModifyCharge(type){
    var post = $('#charge-form').serialize();
    $.post('classes/settings_charge.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-charge').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#charge-save').button('reset');
            }
        }
    });
}