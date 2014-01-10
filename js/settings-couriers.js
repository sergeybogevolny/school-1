$(document).ready(function() {

        $('#courier-label').html('<i class="icon-list-alt"></i> Couriers');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#courier-name").val('');
            $("#courier-delete").attr('checked', false);
            $('#list-actions').hide();
            $('#courier-list').hide();
            $('#courier-label').html('<i class="icon-list-alt"></i> Couriers - Add');
            $('#courier-box').show();
            $('input[name=courier-id]').val(-1);
            $("#courier-name").focus();
		});

        $("#courier-cancel").click(function(){
            $('#courier-box').hide();
            $('#courier-label').html('<i class="icon-list-alt"></i> Couriers');
            $('#list-actions').show();
            $('#courier-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyCourier('delete');
		});

        $("#courier-form").validate({
	        submitHandler: function() {
                var flag = $('#courier-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#courier-save').button('loading');
                    var id = $("#courier-id").val();
                    if (id==-1){
                        ModifyCourier('add');
                    } else {
                        ModifyCourier('edit');
                    }
                }
            },
        });

});

function LoadCourier(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_courier.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#courier-list').hide();
            $('#courier-label').html('<i class="icon-list-alt"></i> Couriers - Edit');
            $('#courier-box').show();
            $("#record-delete").show();
            $("#courier-delete").attr('checked', false);
            $("#courier-name").val(name);
            $('input[name=courier-id]').val(id);
            $("#courier-name").focus();
            }
        }
    });
}

function ModifyCourier(type){
    var post = $('#courier-form').serialize();
    $.post('classes/settings_courier.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-courier').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#courier-save').button('reset');
            }
        }
    });
}