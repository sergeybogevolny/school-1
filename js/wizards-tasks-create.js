$(document).ready(function() {
	
    $("#tasks-filter-useremail").multipleSelect();
	
	var form_wizard = $("#form-wizard");
    $("#form-wizard").show();
	

    if ($("#task-type").length > 0) {
	    function formatImages(option) {
	        if (option.text!=''){
		        var img = "task_list_" + option.text.toLowerCase() + ".png";
			    return "<img style='padding-right:10px;' src='img/" + img + "'>" + option.text;
            } else {
                return '';
            }
		}
		$("#task-type").select2({
		    formatResult: formatImages,
			formatSelection:formatImages,
			escapeMarkup: function(m) { return m; }
		});
	}
    if ($("#task-priority").length > 0) {
	    function formatImages(option) {
		    var img = "task_list_" + option.text.toLowerCase() + ".png";
			return "<img style='padding-right:10px;' src='img/" + img + "'>" + option.text;
		}
		$("#task-priority").select2({
		    formatResult: formatImages,
			formatSelection:formatImages,
			escapeMarkup: function(m) { return m; }
		});
	}

    if (form_wizard.length > 0) {
		form_wizard.formwizard({
            formPluginEnabled: true,
			validationEnabled: true,
			focusFirstInput : true,
			disableUIStyles:true,
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
                    } else {
                        alert(data);
                    }
				}
			},
            textSubmit: 'Create',
			textNext: 'Next',
			textBack: 'Back',
		}).bind("step_shown",function(event){
            var step = $("#form-wizard").formwizard("state").currentStep;
            StepValidate(step);
        }).trigger("step_shown");

        form_wizard.bind("before_step_shown", function(e, data) {
            var step = data.currentStep;
            if (step=='firstStep'){
                $("#task-type").attr("selectedIndex", -1);
                $("#task-data").attr("selectedIndex", -1);
            }
            if (step=='secondStep'){
                loadResults();
            }
            if (step=='thirdStep'){
			    TasksDetail();
			}
			var type		    =$("#task-type").val();
			var data		    =$("#task-data").val();
			var task		    =$("#task").val();
			var description		=$("#task-description").val();
			var priority		=$("#task-priority").val();
			var deadline		=$("#task-deadline").val();
			//var reportresult   = $("#report-results").html();
			//var clientresult   = $()
			//$("#review_report").html(reportresult);
			if(type.length > 0 ){
				$('#group-type').show();
				$("#review_type").text(type);
			}else{
			    $('#group-type').hide();
			}
			if(data.length > 0 ){
				$('#group-data').show();
				$("#review_data").text(data);
			}else{
			    $('#group-data').hide();
			}
			if(task.length > 0 ){
				$('#group-task').show();
				$("#review_task").text(task);
			}else{
			    $('#group-task').hide();
			}
			if(description.length > 0 ){
				$('#group-description').show();
				$("#review_description").text(description);
			}else{
			    $('#group-description').hide();
			}
			if(priority.length > 0 ){
				$('#group-priority').show();
				$("#review_priority").text(priority);
			}else{
			    $('#group-priority').hide();
			}
			if(deadline.length > 0 ){
				$('#group-deadline').show();
				$("#review_deadline").text(deadline);
			}else{
			    $('#group-deadline').hide();
			}
			
			
			
            /*
                        var type			    = $("#task-type").val();
			var task    			= $('#task').val();
			var deadline        	= $('#task-deadline').val();
			var description        	= $('#task-description').val();

          // alert($('#transfer-create-requesting-select').attr('id'));

			if(type.length > 0 ){
				$('#group-type').show();
				$("#review_type").text(type);
			}else{
			    $('#group-type').hide();
			}

			if(task.length > 0 ){
				$('#group-task').show();
				$("#review_task").text(task);
			}else{
			    $('#group-task').hide();
			}

			if(deadline.length > 0 ){
				$('#group-deadline').show();
			    $("#review_deadline").text(deadline);
			}else{
				$('#group-deadline').hide();
			}


			if(description.length > 0 ){
				$('#group-description').show();
                $("#review_description").text(description);
			}else{
				$('#group-description').hide();
			}

            */
         

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
				},
                "aoColumns": [
			            /* Checkbox */      { "sWidth": "70px" },
			            /* Focus */         null,
                        /* Assignedto */    null,
                        /* Partyid */       null,
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
            $("#check_all_2").click(function(e){
			    $('input', oTable.fnGetNodes()).prop('checked',this.checked);
			});
		}
	});
	
	$('.dataTable_3').each(function(){
	    if(!$(this).hasClass("dataTable-custom")) {
		    var opt = {
			    "sPaginationType": "full_numbers",
				"oLanguage":{
				    "sSearch": "<span>Filter:</span> ",
					"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
					"sLengthMenu": "_MENU_ <span>entries per page</span>"
			    },
                "aoColumns": [
			            /* Checkbox */      { "sWidth": "60px" },
			            /* Focus */         null,
                        /* Partyid */       null,
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
            $("#check_all_3").click(function(e){
			    $('input', oTable.fnGetNodes()).prop('checked',this.checked);
			});
		}
	});
	
	

    var detaildeadline = $('.datepicker').datepicker().on('changeDate', function(ev) {detaildeadline.hide();}).data('datepicker');

    $("#tasks-add").click(function(e){
        e.preventDefault();
        AddTask();
        CalcTask();
	});

    $("#tasks-remove").click(function(e){
        e.preventDefault();
        TaskRemoveBin();
        CalcTask();
        TasksDetail();
	});
	
	
  $('.addCondition').click(function () {
	  $('#logic-data').show();
	  $('#report-results').hide();

  });


});

function loadResults(){
	$('#report-results').hide();
    $('.loading').show();
    var id = $("#report-id").val();
    var conditionraw = $("#report-conditionraw").val();

    $.post('classes/reports_columnar.class.php', { 'load' : true, 'reportid' : id , 'conditionraw' : conditionraw }, function (data) {
        if (data.match('error') !== null) {
            alert(data);
        } else {
			$('.loading').hide();
			$('#report-results').show();
           document.getElementById("report-results").innerHTML = data;
           $('#report-results').show();
        }
    });

}


function StepValidate(step){
    switch (step){
        case 'firstStep':
            $("#next").attr("disabled", "disabled");
			firstStepValidation();
            break;
        case 'secondStep':
            break;
        case 'thirdStep':
            $("#next").attr("disabled", "disabled");
            break;
        case 'fourthStep':
            $("#next").attr("disabled", "disabled");
            fourthStepValidation();
			reportlist();
            break;
    }
}

function firstStepValidation(){
    var a = $('#task-type').val();
   

    var y = $('#task-type').val().length;
	var z =  $('#task-data').val().length;
	if( y>0 && z>0 ){
	    $("#next").prop('disabled', false);
	}else{
	    $("#next").prop('disabled', true);
	}
	getNqlData(a);
	
}

function getNqlData(val){
	
	$('#task-data').html('<option value=""></option>');
	$('#task-data').select2('val','');
	$.get('classes/wizards_tasks_create.class.php',{nqldata:true,type:val,level:LEVEL}).done(function(data){
			  $('#task-data').html(data);
			  
		})
  
}

function firstDataValidation(){
    var b = $('#task-data').val();
    var c = $("#task-data option[value='"+b+"']").text();
	
   $("#report-id").val(b);

    var y = $('#task-type').val().length;
	var z =  $('#task-data').val().length;
	if( y>0 && z>0 ){
	    $("#next").prop('disabled', false);
	}else{
	    $("#next").prop('disabled', true);
	}
	
	$('#datatitle').html(c);
	
}



function fourthStepValidation(){
    var x = $('#task').val().length;
    var y = $('#task-priority').val().length;
    var z = $('#task-deadline').val().length;
	if(x>0 && y>0 && z>0){
	    $("#next").prop('disabled', false);
	}else{
	    $("#next").prop('disabled', true);
	}
}


function AddTask(){
    $('#tasks-table td input:checked').each(function(){
        var a = $(this).closest('tr[id]').attr('id');
        var b = $(this).closest('tr[id]').find('td:eq(1)').html();
        var c = $(this).closest('tr[id]').find('td:eq(2)').html();
        var d = "agency@eo.com";
        $('#tasks-bin').dataTable().fnAddData([
		    '<input type="checkbox" name="check" value="1">',
		    b,
            d,
            c
        ]);
        $('#tasks-bin tr:last').attr('id',a);
		$('#tasks-bin td').closest('tr[id]').find('td:eq(3)').hide();
        var rowindex = $('#tasks-table').dataTable().fnGetPosition($(this).closest('tr')[0]);
        $('#tasks-table').dataTable().fnDeleteRow(rowindex);
    });
}

function TaskRemoveBin(){
    $('#tasks-bin td input:checked').each(function(){
        var rowindex = $('#tasks-bin').dataTable().fnGetPosition($(this).closest('tr')[0]);
        $('#tasks-bin').dataTable().fnDeleteRow(rowindex);
    });
}

function CalcTask(){
        var rcount = 0;
        var thead  = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Focus</th><th>Assigned To</th><th></th></tr></thead><tbody>';
		var trow   = '';
		var tfoot  = '</tbody><tfoot></tfoot></table>';
		$('#next').prop('disabled', true);
		
		var rows = $("#tasks-bin").dataTable().fnGetNodes();
		
		for(var i=0;i < rows.length; i++){
			
			var a = $(rows[i]).find("td:eq(1)").html();
			var b = $(rows[i]).find("td:eq(2)").html();
			var c = $(rows[i]).find("td:eq(3)").html();
		   
			rcount = rcount + 1;
			
			a = a +'<input type="hidden" name="focusmv[]" value="'+a+'">';
			b = b +'<input type="hidden" name="assignedtomv[]" value="'+b+'">';
			c = c +'<input type="hidden" name="idmv[]" value="'+c+'">';
	
			var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+c+'</td></tr>';
			trow = trow + line;
			
		}
	
		$("#tasks-count").html('<h5>Total Count: '+rcount+'</h5>');
		if (rcount>0){
			$('#next').prop('disabled', false);
		}
	
        var tfull = thead+trow+tfoot;
        document.getElementById("review_client").innerHTML = tfull;

        $("#task-client-count").html('Total Count: '+rcount);

}


function TasksDetail(){
    var oTable = $('.dataTable_3').dataTable();
	oTable.fnClearTable();
	$('.power-loading').show();
	$('#tasks-table').hide();
	$.post('classes/wizards_tasks_create.class.php', { datasetid: 1 }, function (data) {
	    if (data.match('id="error"') !== null) {
	        $('.power-loading').hide();
			$('#tasks-table').show()
            $('#tasks-table').hide();
            $('#tasks-text').html(data);
            $('#tasks-text').show();
		} else {
			$('.power-loading').hide();
            var jsonData = JSON.parse(data);
            for (var i in jsonData) {
                var rec = jsonData[i];
				var focusid = rec.focusid;
                if (!tasksInBin(focusid)){
                    $('#tasks-table').show().dataTable().fnAddData([
    		            '<input type="checkbox" name="check" value="1">',
    		            rec.name+' - '+rec.focustext,
                        rec.partyid
                    ]);
                    $('#tasks-table tr:last').attr('id',focusid);
					$('#tasks-table td').closest('tr[id]').find('td:eq(2)').hide();
                }
			}
            $('#tasks-text').hide();
            $('#tasks-table').show();

		}
	});
}

function tasksInBin(focusid){
    var rows = $("#tasks-bin").dataTable().fnGetNodes();
    for(var i=0;i<rows.length;i++){
        var a = $(rows[i]).attr('id');
        if ((a==focusid) ){
            return true;
        }
    }
    return false;
}


function reportlist(){
	
        var rcount = 0;
        var thead  = '<table class="table table-hover table-nomargin table-bordered"><thead><tr><th>Name</th><th>Setting</th><th>Class</th><th>Charge</th><th>Case</th><th>County</th><th>Court</th></tr></thead><tbody>';
		var trow   = '';
		var tfoot  = '</tbody><tfoot></tfoot></table>';
		$('#next').prop('disabled', true);
		
		var rows = $("#report-table").dataTable().fnGetNodes();
		
		for(var i=0;i < rows.length; i++){
			
			var a = $(rows[i]).find("td:eq(1)").html();
			var b = $(rows[i]).find("td:eq(2)").html();
			var c = $(rows[i]).find("td:eq(3)").html();
			var d = $(rows[i]).find("td:eq(4)").html();
			var e = $(rows[i]).find("td:eq(5)").html();
			var f = $(rows[i]).find("td:eq(6)").html();
			var g = $(rows[i]).find("td:eq(7)").html();
		   
			rcount = rcount + 1;
			
			a = a +'<input type="hidden" name="focusmv[]" value="'+a+'">';
			b = b +'<input type="hidden" name="assignedtomv[]" value="'+b+'">';
			c = c +'<input type="hidden" name="idmv[]" value="'+c+'">';
			d = d +'<input type="hidden" name="focusmv[]" value="'+d+'">';
			e = e +'<input type="hidden" name="assignedtomv[]" value="'+e+'">';
			f = f +'<input type="hidden" name="idmv[]" value="'+f+'">';
			g = g +'<input type="hidden" name="idmv[]" value="'+g+'">';
	
			var line = '<tr><td>'+a+'</td><td>'+b+'</td><td>'+c+'</td><td>'+d+'</td><td>'+e+'</td><td>'+f+'</td><td>'+g+'</td></tr>';
			trow = trow + line;
			
		}
	
	
        var tfull = thead+trow+tfoot;
        document.getElementById("review_report").innerHTML = tfull;

       // $("#task-client-count").html('Total Count: '+rcount);
	
}

