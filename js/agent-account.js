$(document).ready(function() {

    var type =  TYPE_LIST ;
	$("#list-type").select2('val', type);
    $("#jqxWindow-status").jqxWindow({
        width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

    $("#jqxWindow-confirm").jqxWindow({
        width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });
	
    var ledgerdate = $('#ledger-date').datepicker().on('changeDate', function(ev) {ledgerdate.hide();}).data('datepicker');
    $("#ledger-amount").autoNumeric('init');

	
    $("#confirm-yes").click(function(){
        var type = $("#confirm-type").val();
        if (type=='ledger'){
            ModifyLedger();
        } 
	});
	
	
	$("#ledger-debit").click(function() {
        var type = TYPE_LIST;
		
		$('#ledger-view').hide();
		$('#creditentry-view').show();
		$('#ledgerDelete').hide();
		$('#creditentry-label').html('Ledger - Invoice');
		$('input[name=ledger-id]').val(-1);
		$('input[name=ledger-column]').val('Invoice');
        var ndate = new Date();
        $('#ledger-date').datepicker('setValue', ndate)
        $('#ledger-amount').autoNumeric('set', '');
        $("#ledger-debitentry").select2('val', '');
		$("#ledger-type").val(type)
        $('.credit-group').hide();
        $('.debit-group').show();

    });

    $("#ledger-credit").click(function() {
        var type = TYPE_LIST;
		$('#ledger-view').hide();
		$('#creditentry-view').show();
		$('#ledgerDelete').hide();

		$('#creditentry-label').html('Ledger - Payment');
		$('input[name=ledger-id]').val(-1);
		$('input[name=ledger-column]').val('Payment');
		$("#ledger-type").val(type)

		var ndate = new Date();
		$('#ledger-date').datepicker('setValue', ndate)
		$('#ledger-amount').autoNumeric('set', '');
		$("#ledger-creditentry").select2('val', '');
		$("#ledger-paymentmethod").select2('val', '');
		$('.debit-group').hide();
		$('.credit-group').show();
	});

    $("#ledger-cancel").click(function(){
		    $('#ledger-view').show();
			$('#creditentry-view').hide();
	});
	
    $("#ledger-form").validate({
	    submitHandler: function() {
            var flag = $('#ledger-delete').is(":checked");
            if (flag==true){
                $('input[name=confirm-type]').val('ledger');
                $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                $("#jqxWindow-confirm").jqxWindow('open');
                $('#jqxWindow-confirm').jqxWindow('focus');
            } else {
                $('#ledger-save').button('loading');
                ModifyLedger();
            }
        },
    });
	
	

});

function getList(){
    var id = $('input[name=agent-id]').val();
    var listaction = $('#list-type').val();
	document.location = "agent-account.php?id="+id+"&type="+listaction;
}

function ModifyLedger(){

	post = $('#ledger-form').serialize();
    $.post('classes/agent_account.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
            $('#ledger-save').button('reset');
        }
    });
}

function editDebitAccount(id,debit){
	
		$('#ledger-view').hide();
		$('#creditentry-view').show();
		$('#ledgerDelete').show();

		$('#creditentry-label').html('Edit - Invoice');
		$('input[name=ledger-id]').val(id);
		$('input[name=ledger-column]').val('Invoice');
        var ndate = new Date();
        $('.credit-group').hide();
        $('.debit-group').show();
		
		var debitrow = $(debit).closest('tr');
		var rowDate = $(debitrow).find("td:eq(0)").text();
		var rowEntry = $(debitrow).find("td:eq(1)").text();
        var rowAmount  =$(debitrow).find("td:eq(2)").text();
        var rowMethod  =$(debitrow).find("td:eq(5)").text();
	    $('.controlLedgerDate').html('<input type="text" name="ledger-date" id="ledger-date" class="input-large datepicker span7 ledgerDate" value="'+ rowDate +'">');
		$('#ledger-date').datepicker('setValue', rowDate)
        $('#ledger-amount').val(rowAmount);
        $("#ledger-debitentry").select2('val', rowEntry);
		$("#ledger-paymentmethod").select2('val',rowMethod);
}
function editCreditAccount(id,credit){
		$('#ledger-view').hide();
		$('#creditentry-view').show();
		$('#creditentry-label').html('Edit - Payment');
		$('input[name=ledger-column]').val('Payment');
		$('input[name=ledger-id]').val(id);
		$('.debit-group').hide();
		$('.credit-group').show();
		$('#ledgerDelete').show();
		
		var debitrow = $(credit).closest('tr');
		var rowDate = $(debitrow).find("td:eq(0)").text();
		var rowEntry = $(debitrow).find("td:eq(1)").text();
        var rowAmount  =$(debitrow).find("td:eq(3)").text();
        var rowMethod  =$(debitrow).find("td:eq(5)").text();
		
	    $('.controlLedgerDate').html('<input type="text" name="ledger-date" id="ledger-date" class="input-large datepicker span7 ledgerDate" value="'+ rowDate +'">');
		$('#ledger-date').datepicker('setValue', rowDate)
		$('#ledger-amount').val(rowAmount);
		$("#ledger-creditentry").select2('val',rowEntry);
		$("#ledger-paymentmethod").select2('val',rowMethod);
	
}
