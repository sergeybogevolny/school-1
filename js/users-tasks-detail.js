$(document).ready(function() {
       
    $('#action-detail').html('');
	    var description = $('.datepicker').datepicker().on('changeDate', function(ev) {description.hide();}).data('datepicker');
	   
        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });
	   
	   $("#task-detail-edit").click(function(e){
			e.preventDefault();
			$('#action-detail').html('<div class="box-title"><h3>Detail - Edit</h3></div>');
            $('#task-detail').hide();
            $('#task-edit-box').show();
			$('#timeline-box').hide();
			$('#timeline-addbox').hide();
           // $("#bond-charge").focus();
	   });

	   $("#timeline-add").click(function(e){
			e.preventDefault();
			$('#action-detail').html('<div class="box-title"><h3>Timeline - Add</h3></div>');
            $('#task-detail').hide();
            $('#task-edit-box').hide();
			$('#timeline-box').hide();
			$('#timeline-addbox').show();
           // $("#bond-charge").focus();
	   });
	   
        $("#task-cancel").click(function(){
			$('#action-detail').html('');
		    $('#task-edit-box').hide();
            $('#task-detail').show();
			$('#timeline-addbox').hide();
			$('#timeline-box').show();

		});
        $("#timeline-cancel").click(function(){
			$('#action-detail').html('')
		    $('#task-edit-box').hide();
            $('#task-detail').show();
			$('#timeline-addbox').hide();
			$('#timeline-box').show();

		});
		
		$("#timeline-form").validate({ //validating task form on submit for task field 
	        submitHandler: function(e) {
				    var id = $("#timeline-task").val();
                    if (id == ""){
						data = "task field can't be blank ";
						$('#jqxWindow-status').jqxWindow('open');
						$('#jqxWindow-status').jqxWindow('focus');						
						$("#jqxWindow-status").jqxWindow('setTitle', 'Error')
						$('#jqxWindow-status').jqxWindow({ content: data });
                    }else{ e.submit();}
				
            },
        });

})
