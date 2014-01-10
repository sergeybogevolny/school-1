$(document).ready(function() {

    var form_wizard = $("#form-wizard");

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
						 $('#reportbutton').html('<a href="forms/generaldistribution1.php?id='+id+'" target="_blank"><button class="btn btn-small btn-primary"><i class=" icon-print"></i> Report</button></a></center>')

						 $('#form-wizard').hide();
						 $('#success').show();
						 $('#report-button').show();
                    } else {
						$('#modal-title-error').html('System');
						$('#modal-body-error').html(data);
						$("#modal-error").modal();
                    }
				},

			},
            textSubmit: 'Create',
			textNext: 'Next',
			textBack: 'Back',
		}).bind("step_shown",function(){ // as the next button is not handled by the wizard, we need to handle the button caption ourselves
            var step = $("#form-wizard").formwizard("state").currentStep;
            StepValidate(step);
        }).trigger("step_shown");

        form_wizard.bind("before_step_shown", function(e, data) {
            var step = data.currentStep;
            if (step=='secondStep'){
                LoadResults();
            }
            var distributedate = $("#distribute-date").val();
            var agent = $("#distribute-agent").val();

            $("#review_distributedate").text(distributedate);
            $("#review_agent").text(agent);

		});

	}

	var distributedate = $('.datepicker').datepicker().on('changeDate', function(ev) {distributedate.hide();}).data('datepicker');

    if($('.dataTable_1').length > 0){
		$('.dataTable_1').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sLengthMenu": "_MENU_ <span>entries per page</span>"
					}
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

				});

			}
		});
    }

		$('.dataTable_2').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sLengthMenu": "_MENU_ <span>entries per page</span>"
					}
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
                $("#check_all_2").click(function(e){
					$('input', oTable.fnGetNodes()).prop('checked',this.checked);
				});
			}
		});

    $("#form-wizard").show();

	$('#distribute-agent').change(function(){ //get selected option id
		var id = $(this).find(':selected')[0].id;
		$('#distribute-agent-id').val(id);
	});

    $("#distribute-add").click(function(e){
        e.preventDefault();
        AddDistribute();
        CalcDistribute();
	});

    $("#bin-remove").click(function(e){
        e.preventDefault();
        RemoveBin();
        CalcDistribute();
        LoadResults();
	});

    $("#distribute-filter").click(function(e){
        LoadResults();
	});

    function AddDistribute(){
         $('#distribute-table td input:checked').each(function(){
            var a = $(this).closest('tr[id]').find('td:eq(1)').html();
            var b = $(this).closest('tr[id]').find('td:eq(2)').html();
            var c = $(this).closest('tr[id]').find('td:eq(3)').html();
            var d = $(this).closest('tr[id]').find('td:eq(4)').html();
            var e = $(this).closest('tr[id]').find('td:eq(5)').html();
            c = parseFloat(c);
            c = c.toFixed(2);
            $('#distribute-bin').dataTable().fnAddData([
		        '<input type="checkbox" name="check" value="1">',
		        a,
		        b,
                c,
                d,
                e
            ]);
            var rowindex = $('#distribute-table').dataTable().fnGetPosition($(this).closest('tr')[0]);
            $('#distribute-table').dataTable().fnDeleteRow(rowindex);

            $('#distribute-bin td').closest('tr').find('td:eq(4)').hide();
		    $('#distribute-bin td').closest('tr').find('td:eq(5)').hide();

        });
    }

    function RemoveBin(){
         $('#distribute-bin td input:checked').each(function(){
            var rowindex = $('#distribute-bin').dataTable().fnGetPosition($(this).closest('tr')[0]);
            $('#distribute-bin').dataTable().fnDeleteRow(rowindex);
        });
    }

});

function CalcDistribute(){
    var rcount = 0;
    var rvalue = 0;

    var thead = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Prefix</th><th>Serial</th><th>Value</th><th>Issued</th><th>Expiration</th></tr></thead><tbody>';
    var trow = '';
    var tfoot = '</tbody><tfoot></tfoot></table>';

    $('#next').prop('disabled', true);
    var rows = $("#distribute-bin").dataTable().fnGetNodes();
    for(var i=0;i<rows.length;i++){
        var a = $(rows[i]).find("td:eq(1)").html();
        var b = $(rows[i]).find("td:eq(2)").html();
        var c = $(rows[i]).find("td:eq(3)").html();
        var d = $(rows[i]).find("td:eq(4)").html();
        var e = $(rows[i]).find("td:eq(5)").html();

        rcount = rcount + 1;
        rvalue += parseFloat(c);

        a = a +'<input type="hidden" name="prefixmv[]" value="'+a+'">';
        b = b +'<input type="hidden" name="serialmv[]" value="'+b+'">';
        c = c +'<input type="hidden" name="valuemv[]" value="'+c+'">';
        d = d +'<input type="hidden" name="issuedmv[]" value="'+d+'">';
        e = e +'<input type="hidden" name="expirationmv[]" value="'+e+'">';

        var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+c+'</td><td>'+d+'</td><td>'+e+'</td></tr>';
        trow = trow + line;

        $('#next').prop('disabled', false);
    }

    var tfull = thead+trow+tfoot;
    document.getElementById("review_powers").innerHTML = tfull;

    $("#review-count").html('Total Count: '+rcount);
    $("#review-value").html('Total Value: '+rvalue);

    $("#distribute-count").html('Total Count: '+rcount);
    $("#distribute-value").html('Total Value: '+rvalue);
}

function LoadResults(){
    var oTable = $('.dataTable_1').dataTable();
    oTable.fnClearTable();
	$('.power-loading').show();
	$('#distribute-table').hide();

    var prefix =  $("#filter-prefix").val();
    var serial =  $("#filter-serial").val();
    var count =  $("#filter-count").val();
    $.post('classes/wizards_powers_distribute.class.php', { "list-filter": 1, "filter-prefix": prefix, "filter-serial": serial, "filter-count": count }, function (data) {
        if (data.match('id="error"') !== null) {
	        $('.power-loading').hide();
			$('#distribute-table').show()
            $('#distribute-table').hide();
            $('#distribute-text').html(data);
            $('#distribute-text').show();

        } else {
	       $('.power-loading').hide();
            var jsonData = JSON.parse(data);
            for (var i in jsonData) {
                var rec = jsonData[i];
                if (!InBin(rec.prefix,rec.serial)){
                    $('#distribute-table').show().dataTable().fnAddData([
    		            '<input type="checkbox" name="check" value="1">',
    		            rec.prefix,
    		            rec.serial,
                        rec.value,
                        rec.issued,
                        rec.expiration
                    ]);
                    $('#distribute-table tr:last').attr('id',rec.id);
                }
            }
            $('#distribute-text').hide();
            $('#distribute-table').show();
        }
    });
}

function InBin(prefix,serial){
    var rows = $("#distribute-bin").dataTable().fnGetNodes();
    for(var i=0;i<rows.length;i++)
    {
        var a = $(rows[i]).find("td:eq(1)").html();
        var b = $(rows[i]).find("td:eq(2)").html();
        if ((a==prefix) && (b==serial)){
            return true;
        }
    }
    return false;
}

function Stepfirstvalidate(){
		var x = $('#distribute-date').val().length;
		var y = $('#distribute-agent').val().length;
		if(x > 0 && y > 0){
		   $('#next').prop('disabled', false);
		}else{
		   $("#next").attr("disabled", "disabled");
		}
}

function StepValidate(step){
    switch (step){
        case 'firstStep':
            $("#next").attr("disabled", "disabled");
            Stepfirstvalidate();
            break;
        case 'secondStep':
				$("#next").attr("disabled", "disabled");
				$('.power-loading').show();
                CalcDistribute();
            break;
    }
}


