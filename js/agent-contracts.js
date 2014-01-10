$(document).ready(function() {

        $('#contracts-label').html('<i class="icon-list-alt"></i> Contracts');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

		//$('.double').mask("99.9999")
		$("#contract-netminimum").autoNumeric('init');
		$("#contract-bufminimum").autoNumeric('init');
        $(".mask-rate").mask("999");


	   $("#contracts-add").click(function(e){
			e.preventDefault();

            $("#record-delete").hide();
			$("#record-delete").show();
			$("#contract-date").val('');
			$("#contract-net").val('');
			$("#contract-netminimum").val('');
			$("#contract-buf").val('');
			$("#contract-bufminimum").val('');
			$('input[name=contract-id]').val(-1);


		    $("#contract-delete").attr('checked', false);
           // $('#contract-id').val(-1);

            $('#list-actions').hide();
            $('#contracts-list').hide();
            $('#contracts-label').html('<i class="icon-list-alt"></i> Contracts - Add');
            $('#contracts-box').show();
            $("#contract-comment").focus();

		});

        $("#contract-cancel").click(function(){
            $('#contracts-box').hide();
            $('#contracts-label').html('<i class="icon-list-alt"></i> Contracts');
            $('#list-actions').show();
            $('#contracts-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyContract('delete');
		});

        $("#contract-form").validate({
	        submitHandler: function() {
                var flag = $('#contract-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#contract-save').button('loading');
                    var id = $("#contract-id").val();
                    if (id==-1){
                        ModifyContract('add');
                    } else {
                        ModifyContract('edit');
                    }
                }
            },
        });

		var contractDate = $('.datepicker').datepicker().on('changeDate', function(ev) {contractDate.hide();}).data('datepicker');

});


function LoadContract(id){
    var row = CONTRACTS_SOURCE.filter( function(item){return (item.id==id);} );

    var date       = row[0]['date'];
	var net        = row[0]['net'];
    net = net*1000;
	var netminimum = row[0]['netminimum'];
    netminimum = parseFloat(netminimum);
    netminimum = netminimum.toFixed(2);
    var buf        = row[0]['buf'];
    buf = buf*1000;
    var bufminimum = row[0]['bufminimum'];
    bufminimum = parseFloat(bufminimum);
    bufminimum = bufminimum.toFixed(2);

    $("#record-delete").show();
    $("#contract-date").val(date);
    $("#contract-net").val(net);
    $("#contract-netminimum").val(netminimum);
    $("#contract-buf").val(buf);
    $("#contract-bufminimum").val(bufminimum);
    $('input[name=contract-id]').val(id);

    $('#list-actions').hide();
    $('#contracts-list').hide();
    $('#contracts-label').html('<i class="icon-list-alt"></i> Contracts - Edit');
    $('#contracts-box').show();
    $("#contract-comment").focus();

}


function ModifyContract(type){
    var post = $('#contract-form').serialize();
	alert(post);
    $.post('classes/agent_contract.class.php', post, function (data) {
        alert(data);
        if (data.match('success') !== null) {
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#contract-save').button('reset');
            }
        }
    });
}