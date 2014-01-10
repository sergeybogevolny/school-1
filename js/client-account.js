$(document).ready(function() {

    $('#ledger-label').html('Ledger');
    $('#schedule-label').html('Schedule');

    $("#jqxWindow-status").jqxWindow({
        width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

    $("#jqxWindow-confirm").jqxWindow({
        width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

    $("#jqxCalendar-account").jqxCalendar({ enableTooltips: true, width: 250, height: 250, theme: 'metro' });

    var ledgerdate = $('#ledger-date').datepicker().on('changeDate', function(ev) {ledgerdate.hide();}).data('datepicker');
    $("#ledger-amount").autoNumeric('init');

    $("#confirm-no").click(function(){
        $('#jqxWindow-confirm').jqxWindow('close');
	});

    $("#confirm-yes").click(function(){
        var type = $("#confirm-type").val();
        if (type=='ledger'){
            ModifyLedger();
        } else if (type=='installment'){
            ModifyInstallment();
        } else if (type=='schedule') {
            var id = $('input[name=client-id]').val();
            $.post('classes/client_account.class.php', { "schedule-delete": true, "id": id, "owed": 0 }, function (data) {
                location.reload();
            });
        }
	});

    $("#schedule-add").click(function(e){
	    e.preventDefault();

        $('#ledger-view').hide();
        $('#schedule-list-actions').hide();
        $('#schedule-list').hide();
        $balance = $('input[name=account-balance]').val();
        $('#schedule-owed').text($balance);
        ReadySchedule();
        $('#schedule-label').html('Schedule - Add');
        $('#schedule-form').show();

        FillSchedule();

	});


    $("#schedule-edit").click(function(e){
	    e.preventDefault();

        $('#ledger-view').hide();
        $('#schedule-list-actions').hide();
        $('#schedule-list').hide();
        $('.recurring-group').hide();
        ReadySchedule();
        $('#schedule-label').html('Schedule - Edit');
        $('#schedule-form').show();

        FillSchedule();

	});

    $("#schedule-delete").click(function(e){
	    e.preventDefault();
        $('input[name=schedule-delete]').val(1);
        $('input[name=schedule-id]').val(1);
        $('input[name=confirm-type]').val('schedule');
        $('#jqxWindow-confirm').jqxWindow('setTitle', 'Delete?');
        $('#jqxWindow-confirm').jqxWindow('open');
	});

    $("#schedule-cancel").click(function(e){
	    e.preventDefault();
        location.reload();
        //$('#ledger-view').show();
        //$('#schedule-list-actions').show();
        //$('#schedule-list').show();
        //$('#schedule-label').html('Schedule');
        //$('#schedule-form').hide();
	});

    $("#schedule-save").click(function() {
        var id = $('input[name=client-id]').val();
        var scheduleowed = $('#schedule-owed').text();
        scheduleowed = scheduleowed.replace(",","");
        scheduleowed = parseFloat(scheduleowed);
        scheduleowed = scheduleowed.toFixed(2);
        var spdates = $('#jqxCalendar-account').jqxCalendar('specialDates');
        spdates.sortByProp('Date');
        var remaining = scheduleowed;
        var schedulearray = [];
        $.each(spdates, function (index) {
            var sdate = this.Date;
            var getYYYY = new Date(sdate).getFullYear();
            var getMM = new Date(sdate).getMonth() + 1;
            var getDD = new Date(sdate).getDate();
            var date = getYYYY+'-'+getMM+'-'+getDD;
            var amount = this.Tooltip;
            remaining = remaining - amount;
            schedulearray[index] = {
                'date'   : date,
                'amount' : amount,
                'remaining' : remaining
            };
        });
        $.post('classes/client_account.class.php', { "schedule-add": true, "id": id, "schedule": schedulearray }, function (data) {
            /*alert(data);*/
            location.reload();
        });
    });

    $("#ledger-debit").click(function() {

        $('#quote-view').hide();
		$('#ledger-view').hide();
		$('#schedule-view').hide();
		$('#installment-view').hide();
		$('#creditentry-view').show();
		$('#ledgerDelete').hide();
		$('#creditentry-label').html('Ledger - Debit');
		$('input[name=ledger-id]').val(-1);
		$('input[name=ledger-column]').val('debit');
        var ndate = new Date();
        $('#ledger-date').datepicker('setValue', ndate)
        $('#ledger-amount').autoNumeric('set', '');
        $("#ledger-debitentry").select2('val', '');
        $('.credit-group').hide();
        $('.debit-group').show();

    });

    $("#ledger-credit").click(function() {

        $('#quote-view').hide();
		$('#ledger-view').hide();
		$('#schedule-view').hide();
		$('#installment-view').hide();
		$('#creditentry-view').show();
		$('#ledgerDelete').hide();

		$('#creditentry-label').html('Ledger - Credit');
		$('input[name=ledger-id]').val(-1);
		$('input[name=ledger-column]').val('credit');
		var ndate = new Date();
		$('#ledger-date').datepicker('setValue', ndate)
		$('#ledger-amount').autoNumeric('set', '');
		$("#ledger-creditentry").select2('val', '');
		$("#ledger-paymentmethod").select2('val', '');
		$("#ledger-memo").val('');
		$('.debit-group').hide();
		$('.credit-group').show();
	});

    $("#ledger-cancel").click(function(){

        if (ACCOUNT_COUNT==0){
            $('#quote-view').show();
        } else {
		    $('#ledger-view').show();
		    $('#schedule-view').show();
        }
        $('#installment-view').hide();
		$('#creditentry-view').hide();

	});

    $("#installment-cancel").click(function(e){
	    e.preventDefault();
        $('#jqxWindow-installment').jqxWindow('close');
        $('#ledger-view').hide();
        $('#schedule-list-actions').hide();
        $('#schedule-list').hide();
        $('#schedule-label').html('Schedule - Add');
        $('#schedule-form').show();

	});

    $("#installment-save").click(function(){
        var amount = $("#installment-amount").val();
        if (amount==0 || amount==''){
            return;
        }
        amount = amount.replace(",","");
        amount = parseFloat(amount);
        amount = amount.toFixed(2);

        //$('#jqxWindow-installment').jqxWindow('close');
        var scheduleowed = $('#schedule-owed').text();
        scheduleowed = scheduleowed.replace(",","");
        scheduleowed = parseFloat(scheduleowed);
        scheduleowed = scheduleowed.toFixed(2);
        var schedulebalance = $('input[name=schedule-balance]').val();
        schedulebalance = schedulebalance.replace(",","");
        schedulebalance = parseFloat(schedulebalance);
        schedulebalance = schedulebalance.toFixed(2);

        if (schedulebalance==''){
            $('input[name=schedule-balance]').val(scheduleowed);
            schedulebalance = scheduleowed;
        }

        var specialdate = $('input[name=special-date]').val();
        specialdate = new Date(specialdate);
        if(parseFloat(amount,10)>parseFloat(schedulebalance,10)){
            amount = schedulebalance;
        }

        $("#jqxCalendar-account").jqxCalendar('addSpecialDate', specialdate, '', amount);
        schedulebalance = schedulebalance - amount;
        $('input[name=schedule-balance]').val(schedulebalance);

        var recurring = $("#recurring-type").val();
        if (recurring!=''){
            while (schedulebalance>0){
                var date1 = new Date(specialdate);
                if (recurring=='weekly'){
                    date1.setDate(date1.getDate() + 7);
                } else if (recurring=='biweekly'){
                    date1.setDate(date1.getDate() + 14);
                } else if (recurring=='monthly'){
                    date1.setDate(date1.getMonth() + 1);
                }
                specialdate = new Date(date1.getFullYear(), date1.getMonth(), date1.getDate());
                if(parseFloat(amount,10)>parseFloat(schedulebalance,10)){
                    amount = schedulebalance;
                }
                schedulebalance = schedulebalance-amount;
                $('input[name=schedule-balance]').val(schedulebalance);
                //alert(specialdate+' - '+amount+' - '+schedulerbalance);
                $("#jqxCalendar-account").jqxCalendar('addSpecialDate', specialdate, '', amount);
            }
        }
        ListSchedule();
        $('#installment-view').hide();
        $('#installment-form').hide();
        $('#schedule-view').show();
        $('#schedule-form').show();
	});

    $("#installment-cancel").click(function(){
		$('#ledger-view').hide();
		$('#installment-view').hide();
        $('#installment-form').hide();
        $('#schedule-view').show();
        $('#schedule-form').show();

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


    $('#jqxCalendar-account').on('change', function (event){
        var udate = true;
        var sdate = event.args.date;
        var ndate = sdate.toLocaleDateString();
        var spdates = $('#jqxCalendar-account').jqxCalendar('specialDates');
        $.each(spdates, function (index) {
            var spdate=this.Date;
            spdate = spdate.toLocaleDateString();
            if (ndate==spdate){
                $('input[name=special-date]').val(sdate);
                $('input[name=confirm-type]').val('installment');
                $('#jqxWindow-confirm').jqxWindow('setTitle', 'Delete?');
                $('#jqxWindow-confirm').jqxWindow('open');
                udate=false;
                return;
            }
        });
        if (udate==true){
            var getYYYY = new Date(sdate).getFullYear();
            var getMM = new Date(sdate).getMonth() + 1;
            var getDD = new Date(sdate).getDate();
            $('input[name=special-date]').val(sdate);
            $("#installment-date").html('<strong>'+getMM+"/"+getDD+"/"+getYYYY+'</strong>');
            $("#recurring-type").select2('val','');
            $('#schedule-view').hide();
            $('#schedule-form').hide();
            $('#installment-view').show();
            $('#installment-form').show();
            var scount = spdates.length;
            if (scount==0){
              $('.recurring-group').show();
            } else {
              $('.recurring-group').hide();
            }
        }
    });

    Array.prototype.sortByProp = function(p){
        return this.sort(function(a,b){
            return (a[p] > b[p]) ? 1 : (a[p] < b[p]) ? -1 : 0;
        });
    }


});


function ModifyLedger(){

	post = $('#ledger-form').serialize();
    $.post('classes/client_account.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            $('#ledger-save').button('reset');
        }
    });
}

function FillSchedule(){

    $.each(SCHEDULE_SOURCE, function (index) {
        var sdate = this.date;
        var samount = parseFloat(this.amount);
        samount = samount.toFixed(2);
        $("#jqxCalendar-account").jqxCalendar('addSpecialDate', new Date(sdate), '', samount);
    });
    ListSchedule();
}

function ListSchedule(){
    var scheduleowed = $('#schedule-owed').text();
    scheduleowed = scheduleowed.replace(",","");
    scheduleowed = parseFloat(scheduleowed);
    scheduleowed = scheduleowed.toFixed(2);
    var spdates = $('#jqxCalendar-account').jqxCalendar('specialDates');
    spdates.sortByProp('Date');
    var thead = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Date</th><th>Amount</th><th>Remaining</th></tr></thead><tbody>';
    var trow = '';
    var tfoot = '</tbody><tfoot></tfoot></table>';

    $.each(spdates, function (index) {
        var getYYYY = new Date(this.Date).getFullYear();
        var getMM = new Date(this.Date).getMonth() + 1;
        var getDD = new Date(this.Date).getDate();
        var paid = parseFloat(this.Tooltip);
        scheduleowed = scheduleowed - paid;
        var line = '<tr><td>'+getMM+'/'+getDD+'/'+getYYYY+'</td><td>'+paid.toFixed(2)+'</td><td>'+scheduleowed.toFixed(2)+'</td></tr>';
        trow = trow + line;
    });

    if (scheduleowed>0){
        $('#schedule-save').hide();
    } else {
        $('#schedule-save').show();
    }
    $('input[name=schedule-balance]').val(scheduleowed);
    var tfull = thead+trow+tfoot;
    document.getElementById("schedule").innerHTML = tfull;
    $('#schedule').show();
}

function ModifyInstallment(){
    var sdate = $('input[name=special-date]').val();
    sdate = new Date(sdate);
    var ndate = sdate.toLocaleDateString();
    var spdates = $('#jqxCalendar-account').jqxCalendar('specialDates');
    var nspdates = new Array();
    $.each(spdates, function (index) {
        var spdate=this.Date;
        spdate = spdate.toLocaleDateString();
        if (ndate!=spdate) {
            nspdates[nspdates.length] = this;
        }
    });
    $("#jqxCalendar-account").jqxCalendar({ specialDates: nspdates });
    ListSchedule();
    $('#jqxWindow-confirm').jqxWindow('close');
}

function ReadySchedule(){
    var nspdates = new Array();
    $("#jqxCalendar-account").jqxCalendar({ specialDates: nspdates });
    $("#jqxCalendar-account").jqxCalendar('refresh');
    var scheduleowed = $('#schedule-owed').text();
    scheduleowed = scheduleowed.replace(",","");
    scheduleowed = parseFloat(scheduleowed);
    scheduleowed = scheduleowed.toFixed(2);
    var schedulebalance = $('input[name=schedule-balance]').val();
    if (schedulebalance==''){
        schedulebalance = scheduleowed;
        $('input[name=schedule-balance]').val(schedulebalance);
    }
}

function editDebitAccount(id,debit){
	
        $('#quote-view').hide();
		$('#ledger-view').hide();
		$('#schedule-view').hide();
		$('#installment-view').hide();
		$('#creditentry-view').show();
		$('#ledgerDelete').show();

		$('#creditentry-label').html('Edit - Debit');
		$('input[name=ledger-id]').val(id);
		$('input[name=ledger-column]').val('debit');
        var ndate = new Date();
        $('.credit-group').hide();
        $('.debit-group').show();
		
		var debitrow = $(debit).closest('tr');
		var rowDate = $(debitrow).find("td:eq(0)").text();
		var rowEntry = $(debitrow).find("td:eq(1)").text();
        var rowAmount  =$(debitrow).find("td:eq(2)").text();
	    $('.controlLedgerDate').html('<input type="text" name="ledger-date" id="ledger-date" class="input-large datepicker span7 ledgerDate" value="'+ rowDate +'">');
		$('#ledger-date').datepicker('setValue', rowDate)
        $('#ledger-amount').val(rowAmount);
        $("#ledger-debitentry").select2('val', rowEntry);
	
}
function editCreditAccount(id,credit){
        $('#quote-view').hide();
		$('#ledger-view').hide();
		$('#schedule-view').hide();
		$('#installment-view').hide();
		$('#creditentry-view').show();
		$('#creditentry-label').html('Ledger - Credit');
		$('input[name=ledger-id]').val(id);
		$('.debit-group').hide();
		$('.credit-group').show();
		$('#ledgerDelete').show();
		console.log($(credit).closest('tr'));
		
		var debitrow = $(credit).closest('tr');
		var rowDate = $(debitrow).find("td:eq(0)").text();
		var rowEntry = $(debitrow).find("td:eq(1)").text();
        var rowAmount  =$(debitrow).find("td:eq(3)").text();
        var rowMethod  =$(debitrow).find("td:eq(5)").text();
        var rowMemo  =$(debitrow).find("td:eq(6)").text();
		//alert(rowDate);
		$('input[name=ledger-column]').val('credit');
	    $('.controlLedgerDate').html('<input type="text" name="ledger-date" id="ledger-date" class="input-large datepicker span7 ledgerDate" value="'+ rowDate +'">');
		$('#ledger-date').datepicker('setValue', rowDate)
		$('#ledger-amount').val(rowAmount);
		$("#ledger-creditentry").select2('val',rowEntry);
		$("#ledger-paymentmethod").select2('val',rowMethod);
		$("#ledger-memo").val(rowMemo);
	
}
