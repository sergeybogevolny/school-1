$(document).ready(function() {

    var form_wizard = $("#form-wizard");
    mv = new Array();
    mvi = 0;

	if (form_wizard.length > 0) {
		form_wizard.formwizard({
            formPluginEnabled: true,
			validationEnabled: true,
			focusFirstInput : false,
			disableUIStyles:true,
            inDuration: 0,
			validationOptions: {
				errorElement:'span',
				errorClass: 'help-block error',
				errorPlacement:function(error, element){
					element.parents('.controls').append(error);
				},
				highlight: function(label) {
					$(label).closest('.control-group').removeClass('error success').addClass('error');
				},
				success: function(label) {
					label.addClass('valid').closest('.control-group').removeClass('error success').addClass('success');
				}
			},
            formOptions :{
				success: function(data){
                    if (data.match('success') !== null) {
                         var $response=$(data);
                         var id = $response.filter('#status').text();
						 $('#form-wizard').hide();
						 $('#success').show();
                         //window.location = "powers-available.php";
                    } else {
                        $("#jqxWindow-status").jqxWindow('setTitle', 'Error');
                        $('#jqxWindow-status').jqxWindow({ content: data });
                        $('#jqxWindow-status').jqxWindow('open');
                        $('#jqxWindow-status').jqxWindow('focus');
                    }
				},

			},
            textSubmit: 'Create',
			textNext: 'Next',
			textBack: 'Back',
		}).bind("step_shown",function(event){ // as the next button is not handled by the wizard, we need to handle the button caption ourselves
			if($("#form-wizard").formwizard("state").isFirstStep){
                StepFirstValidate()
            }
		    if($("#form-wizard").formwizard("state").currentStep == "secondStep" ){
				
			  $("#next").attr("disabled", "disabled");
			  	if($('#ledger-date').val() == '__/__/____' ){
					$('#next').prop('disabled', true);
				}else if($('#ledger-date').val() == ''){
					$('#next').prop('disabled', true);
				}else{
					$('#next').prop('disabled', false);
				}
				
			  
			};
			if($("#form-wizard").formwizard("state").currentStep == "thirdStep" ){
					
					var rows = $("#jqxgrid").jqxGrid('getrows');
					var amountCellValues = "";
					var name = "";
					var dob = "";
					var ssn = "";
					for( var i = 0; i < rows.length; i++)
					{ 
						amountCellValues += '<input type="hidden" value="'+rows[i]['amount']+'" name="amountmv[]" >';
						name += '<input type="hidden" value="'+rows[i]['name']+'" name="name[]" >';
						dob += '<input type="hidden" value="'+rows[i]['dob']+'" name="dob[]" >';
						ssn += '<input type="hidden" value="'+rows[i]['ssn']+'" name="ssn[]" >';
					}	
					$('#amount-credit').html(amountCellValues+''+name+''+dob+''+ssn);
										
			}
			if($("#form-wizard").formwizard("state").currentStep == "fourthStep" ){
					var date = $('#ledger-date').val();
					var creditentry = $('#ledger-creditentry').val();
					var paymentmethod = $('#ledger-paymentmethod').val();
					var memo = $('#ledger-memo').val();
                    var grid = $("#jqxgrid").html();					
                  
				   if (date==''){
						$("#group-date").hide();
					} else {
						$("#group-date").show();
						$("#review_date").html(date);
					}

					
					if (creditentry==''){
						$("#group-entry").hide();
					} else {
						$("#group-entry").show();
						$("#review_entry").html(creditentry);
					}
					
					if (paymentmethod==''){
						$("#group-method").hide();
					} else {
						$("#group-method").show();
						$("#review_method").html(paymentmethod);
					}
					
					if (memo==''){
						$("#group-memo").hide();
					} else {
						$("#group-memo").show();
						$("#review_memo").html(memo);
					}
					
					
					if (grid==''){
						$("#group_amount").hide();
					} else {
						
						var rows = $("#jqxgrid").jqxGrid('getrows');
						var DataTableValues = "";
						
						for( var i = 0; i < rows.length; i++)
						{ 
						   if(rows[i]['amount'] != 0){
							DataTableValues += '<tr><td>'+rows[i]['name']+'</td><td>'+rows[i]['dob']+'</td><td>'+rows[i]['ssn']+'</td><td>'+formatDollar(rows[i]['amount'])+'</td></tr>';
						   }
						 }
						
						$('#review_table').html(DataTableValues);	
					}
							
			}

			
        }).trigger("step_shown");

        form_wizard.bind("before_step_shown", function(e, data) {
		    return false;
		});

	}

    if($('.dataTable_1').length > 0){
		$('.dataTable_1').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sLengthMenu": "_MENU_ <span>entries per page</span>"
					},
                    "aoColumns": [
			            /* Checkbox */  null,
			            /* Name */      null,
                        /* Dob */       null,
                        /* SSN */       null
		            ]
				};
				if($(this).hasClass("dataTable-noheader")){
					opt.bFilter = false;
					opt.bLengthChange = false;
				}
				if($(this).hasClass("dataTable-nofooter")){
					opt.bInfo = false;
					opt.bPaginate = false;
				}
				if($(this).hasClass("dataTable-nosort")){
					var column = $(this).attr('data-nosort');
					column = column.split(',');
					for (var i = 0; i < column.length; i++) {
						column[i] = parseInt(column[i]);
					};
					opt.aoColumnDefs =  [
					{ 'bSortable': false, 'aTargets': column }
					];
				}
				var oTable = $(this).dataTable(opt);
                $("#check_all_1").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);
                    StepFirstValidate();   
				});
                //$('#search-table').editable();


			}
		});
    }

	//var dob = $('.datepicker').datepicker().on('changeDate', function(ev) {dob.hide();}).data('datepicker');

    $("#powers-add").click(function(e){
	    e.preventDefault();
        //$("#record-delete").hide();
        /*
        $("#bond-amount").val('');
        $("#bond-classFelony").prop('checked',false);
		$("#bond-classMisdemeanor").prop('checked',false);
        $("#bond-charge").val('');
        $("#bond-county").select2('val', '');

        $('#wizard-actions').hide();
        $('#list-actions').hide();
        $('#bonds-list').hide();
        $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds - Add');
        $('#bonds-box').show();
        */
	});

    $("#power-save").click(function(e){
        /*
        var a = $("#bond-amount").val();

		if($('input[name="bond-class"]').is(':checked')){
            var b = $('input[name="bond-class"]:checked').val();
	    }else{  var b = ''; }

		var c = $("#bond-charge").val();
        var d = $("#bond-county").val();

        var i = mv.length;
        mv[i] = new Array();
        mv[i][0] = mvi;
        mv[i][1] = a;
        mv[i][2] = b;
        mv[i][3] = c;
        mv[i][4] = d;

        mvi += 1

        var thead = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Amount</th><th>Class</th><th>Charge</th><th>County</th></tr></thead><tbody>';
        var trow = '';
        var tfoot = '</tbody><tfoot></tfoot></table>';

        for ( var j = 0; j < mv.length; j++) {
            var a = mv[j][1] +'<input type="hidden" name="amountmv[]" value="'+mv[j][1]+'">';
            var b = mv[j][2] +'<input type="hidden" name="classmv[]" value="'+mv[j][2]+'">';
            var c = mv[j][3] +'<input type="hidden" name="chargemv[]" value="'+mv[j][3]+'">';
            var d = mv[j][4] +'<input type="hidden" name="countymv[]" value="'+mv[j][4]+'">';
            var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+c+'</td><td>'+d+'</td></tr>';
            trow = trow + line;
        }

        var tfull = thead+trow+tfoot;
        document.getElementById("bonds-list").innerHTML = tfull;

        $('#bonds-box').hide();
        $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');
        $('#wizard-actions').show();
        $('#list-actions').show();
        $('#bonds-list').show();
        */
	});

    $("#power-cancel").click(function(){
        /*
        $('#bonds-box').hide();
        $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');
        $('#wizard-actions').show();
        $('#list-actions').show();
        $('#bonds-list').show();
        */
	});

    $("#form-wizard").show();

    $('.datepicker').mask("99/99/9999")

	var ledgerdate = $('.datepicker').datepicker().on('changeDate', function(ev) {ledgerdate.hide();StepSecondValidation();}).data('datepicker');
});


function SearchStatus(e){
    var sval = e.keyCode;
    if (sval!=13){
        $("#next").attr("disabled", "disabled");
        $('#search-text').hide();
        $('#search-table').hide();
    } else {
        LoadResults();
    }
}

function GoSearch(){
    LoadResults();
}

function LoadResults(){
    var oTable = $('.dataTable_1').dataTable();
    oTable.fnClearTable();

    var sval =  $("#search-value").val();
    $.post('classes/wizards_clients_payment.class.php', { "search-simple": 1, "search-value": sval }, function (data) {
        if (data.match('id="error"') !== null) {
            $('#search-text').html(data);
            $('#search-text').show();
        } else {
            var jsonData = JSON.parse(data);
            for (var i in jsonData) {
                var rec = jsonData[i];
                $('#search-table').dataTable().fnAddData([
				
		            '<input type="checkbox" name="check " class = "icheck-me checkget" data-skin="square" data-color="blue" value="1"  onclick="StepFirstValidate()">',
		            rec.name,
		            rec.dob,
		            rec.ssn
                ]);
                $('#search-table tr:last').attr('id',rec.id);

            }
            $('#search-table').show();
        }
    });
}

function StepFirstValidate(){
    $("#next").attr("disabled", "disabled");
    $('#search-table td input:checked').each(function(){
        //alert($(this).closest('tr[id]').attr('id'));// just to see the rowid's
        //alert($(this).closest('tr[id]').find('td:eq(1)').html());
        //alert($(this).closest('tr[id]').find('td:eq(2)').html());
        //alert($(this).closest('tr[id]').find('td:eq(3)').html());
        $('#next').prop('disabled', false);
    });
    FillPayments();
}

function StepSecondValidation(){
    $("#next").attr("disabled", "disabled");
	
	if($('#ledger-date').val() == '__/__/____' ){
	    $('#next').prop('disabled', true);
	}else if($('#ledger-date').val() == '' ){
		
		$('#next').prop('disabled', true);
		
	}else{
		$('#next').prop('disabled', false);
		
		}
	
}


function formatDollar(num) { // change number to $ formet 
    var p = num.toFixed(2).split(".");
    return "$" + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}

function addAmount(){
}


function FillPayments(){

    var data = '';
    $('#search-table td input:checked').each(function(){
        var id = $(this).closest('tr[id]').attr('id');
        var name = $(this).closest('tr[id]').find('td:eq(1)').html();
        var dob = $(this).closest('tr[id]').find('td:eq(2)').html();
        var ssn = $(this).closest('tr[id]').find('td:eq(3)').html();
        if (data!=''){
            data = data +',';
        }
        data =  data + '{ "id":  "' + id + '", "name":  "' + name + '", "dob":  "' + dob + '", "ssn":  "' + ssn + '", "amount":  "0.00" }';
    });
    data = '['+data+']';
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id' },
            { name: 'name' },
            { name: 'dob' },
            { name: 'ssn' },
            { name: 'amount' }
        ],
        localdata: data
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
	var totalAmount=0 ;
    $("#jqxgrid").jqxGrid(
    {
        width: 400,
        theme: 'metro',
        editable: true,
        selectionmode: 'none',
        editmode: 'click',
        source: dataAdapter,
        ready: function () {
            $("#jqxgrid").jqxGrid('hidecolumn', 'id');
        },
        columnsresize: false,
        columns: [
            { text: 'Name', datafield: 'name', width: 140},
            { text: 'Dob', datafield: 'dob', width: 80 },
            { text: 'SSN', datafield: 'ssn', width: 80 },
            { text: 'Amount', datafield: 'amount', align: 'right', cellsalign: 'right', cellsformat: 'c2', columntype: 'numberinput', width: 100, aggregates: ['sum', 'avg'], 
				
				validation: function (cell, value) {
                    /*if (value < 0 || value > 15) {
                        return { result: false, message: "Price should be in the 0-15 interval" };
                    }*/
					if(value > 0){
						   $('#next').prop('disabled', true);
					}
                    return true;
                },
                createeditor: function (row, cellvalue, editor) {
                    editor.jqxNumberInput({ inputMode: 'advanced', spinButtons: false, digits: 8, decimalDigits: 2 });
					
                }
				
            }

        ]
    });
	
	$('#jqxgrid').on('cellbeginedit', function (event) 
		{
					var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'amount', ['sum']);	            
					var converted = formatDollar(summaryData.sum) ; 
					$('#ledger-amount').val(converted);
		});
		
	$('#jqxgrid').on('cellvaluechanged', function (event) 
		{
					var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'amount', ['sum']);	            
					var converted = formatDollar(summaryData.sum) ; 
					$('#ledger-amount').val(converted);
		});
		
	
    $('#jqxgrid').jqxGrid('setcolumnproperty', 'name', 'editable', false);
    $('#jqxgrid').jqxGrid('setcolumnproperty', 'dob', 'editable', false);
    $('#jqxgrid').jqxGrid('setcolumnproperty', 'ssn', 'editable', false);
     

}

function StepValidate(step){
    var bval = true;
    switch (step){
        case 'firstStep':
            break;
        case 'secondStep':
            break;
        case 'thirdStep':
            break;
        case 'fourthstep':
            break;

    }
}


