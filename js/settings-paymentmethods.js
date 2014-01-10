$(document).ready(function() {


        $('#paymenttype-label').html('<i class="icon-list-alt"></i> Payment Methods');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#paymenttype-name").val('');
            $("#paymenttype-delete").attr('checked', false);
            $('#list-actions').hide();
            $('#paymenttype-list').hide();
            $('#paymenttype-label').html('<i class="icon-list-alt"></i> Payment Methods - Add');
            $('#paymenttype-box').show();
            $('input[name=paymenttype-id]').val(-1);
            $("#paymenttype-name").focus();
		});

        $("#paymenttype-cancel").click(function(){
            $('#paymenttype-box').hide();
            $('#paymenttype-label').html('<i class="icon-list-alt"></i> Payment Methods');
            $('#list-actions').show();
            $('#paymenttype-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyPaymenttype('delete');
		});

        $("#paymenttype-form").validate({
	        submitHandler: function() {
                var flag = $('#paymenttype-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#paymenttype-save').button('loading');
                    var id = $("#paymenttype-id").val();
                    if (id==-1){
                        ModifyPaymenttype('add');
                    } else {
                        ModifyPaymenttype('edit');
                    }
                }
            },
        });

});

function LoadPaymentmethods(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_paymenttype.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var seat = $response.filter('#seat').text();
            $('#list-actions').hide();
            $('#paymenttype-list').hide();
            $('#paymenttype-label').html('<i class="icon-list-alt"></i> Payment Methods - Edit');
            $('#paymenttype-box').show();
            $("#record-delete").show();
            $("#paymenttype-delete").attr('checked', false);
            $("#paymenttype-name").val(name);
            $('input[name=paymenttype-id]').val(id);
            $("#paymenttype-name").focus();
            }
        }
    });
}

function ModifyPaymenttype(type){
    var post = $('#paymenttype-form').serialize();
    $.post('classes/settings_paymenttype.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-paymenttype').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#paymenttype-save').button('reset');
            }
        }
    });
}