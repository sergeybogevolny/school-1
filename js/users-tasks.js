$(document).ready(function() {
       
	   $('#task-label').html('Tasks');
       
        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });
	  
	    var description = $('.datepicker').datepicker().on('changeDate', function(ev) {description.hide();}).data('datepicker');
	   
	   
	   $("#task-add").click(function(e){
			e.preventDefault();
			$('#list-actions').hide();
            $('#task-list').hide();
            $('input[name=task_id]').val(-1);
            $('#task-label').html('Tasks - Add');
            $('#task-box').show();
           // $("#bond-charge").focus();
	   });
	   
        $("#bond-cancel").click(function(){
           
		    $('#task-box').hide();
            $('#task-label').html('Tasks');
            $('#list-actions').show();
            $('#task-list').show();

		});
		
		$("#task-form").validate({ //validating task form on submit for task field 
	        submitHandler: function(e) {
				    var id = $("#task").val().length;
                    if (id == 0){
						data = "task field can't be blank ";
						$('#jqxWindow-status').jqxWindow('open');
						$('#jqxWindow-status').jqxWindow('focus');						
						$("#jqxWindow-status").jqxWindow('setTitle', 'Error')
						$('#jqxWindow-status').jqxWindow({ content: data });
                    }else{ e.submit();}
				
            },
        });
		
		

})
