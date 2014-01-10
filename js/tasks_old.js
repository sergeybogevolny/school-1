$(document).ready(function() {

        if ($("#task-type").length > 0) {
			function formatImages(option) {
				var img = "task_list_" + option.text.toLowerCase() + ".png";
				return "<img style='padding-right:10px;' src='img/" + img + "'>" + option.text;
			}
			$("#task-type").select2({
				formatResult: formatImages,
				formatSelection:formatImages,
				escapeMarkup: function(m) { return m; }
			});
	    }

        $('#tasks-label').html('<i class="icon-tasks"></i> My Tasks');

        var detaildeadline = $('.datepicker').datepicker().on('changeDate', function(ev) {detaildeadline.hide();}).data('datepicker');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

	    $("#tasks-add").click(function(e){
			e.preventDefault();
            $("#task-select").hide();
			$("#LastPaymentClientList").html('');
			$("#LastPaymentList").hide();
            $("#task-name").val('');
            $("#task-type").select2('val', '');
            $("#task-description").val('');
            $("#task-deadline").val('');
            $("#task-important").prop('checked',false);
            $('input[name=task-id]').val(-1);

            $('#list-actions').hide();
            $('#tasks-list').hide();
            $('#tasks-label').show().html('<i class="icon-tasks"></i> My Tasks - Add');
            $('#tasks-box').show();

            $("#task-name").focus();

		});

        $("#task-cancel").click(function(){
            $('#tasks-box').hide();
			$("#LastPaymentList").hide();
			$("#LastPaymentClientList").html('');
            $('#tasks-label').hide();
			 $("#task-select").show();
            $('#list-actions').show();
            $('#tasks-list').show();
		});

        $("#task-form").validate({
	        submitHandler: function() {
                $('#task-save').button('loading');
                ModifyTask('add');
            },
        });
		
	var type =  TYPE_LIST ;
	$("#my-task-type").select2('val', type);
	var filter =  FILTER_LIST ;
	$("#taskfilter-type").select2('val', filter);
	
	
	$('#letter-report').click(function(){
		var userid = [];
		$('#mytasktable td input:checked').each(function(){ 
		    var id = $(this).attr('id');
			//userid.push(id);
			$.ajax({
			   type: "GET",
			   data: {id:id},
			   url: "forms/taskletter.php",
			   success: function(data){
				   var url =  'forms/taskletter.php?id='+id;
				   window.open(url,'_blank');
				// $('.answer').html(data);
			   }
			});				
		});
	   
	    //alert(userid);
			
		});

});


function ModifyTask(type){
    var post = $('#task-form').serialize();
    $.post('classes/tasks.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            $('#task-save').button('reset');
        }
    });
}

function getMyTask(){
	 
			var mytaskaction = $('#my-task-type').val();
			document.location = "tasks.php?type="+mytaskaction;
	}
	
function getTaskType(val){
	 
			if(val == 'all'){
				document.location = "tasks.php?type=myassignedtask";
			}else{
			document.location = "tasks.php?type=myassignedtask&filter="+val;
			}
	}	
	
	

function LastPayment(){
            $("#task-select").hide();
		    $("#LastPaymentList").show();
			
			$("#LastPaymentClientList").html('<i class="icon-spinner icon-spin icon-large" style="font-size:100px; margin-top:30px;"></i>');
			
			$.get('classes/tasks.class.php', { lastpayment: "lastpayment"})
					.done(function(data) {
						$("#LastPaymentClientList").html(data);
					});           
		   
		    $("#task-name").val('');
            $("#task-type").select2('val', '');
            $("#task-description").val('');
            $("#task-deadline").val('');
            $("#task-important").prop('checked',false);
            $('input[name=task-id]').val(-1);

            $('#list-actions').hide();
            $('#tasks-list').hide();
            $('#tasks-label').show().html('<i class="icon-tasks"></i> My Tasks - Add');
            $('#tasks-box').show();

            $("#task-name").focus();
			
			

}

function checkall(){
     var checkboxes = $('.mytask');
    if($(this).is(':checked')) {
        checkboxes.attr("checked" , true);
    } else {
        checkboxes.attr ( "checked" , false );
    }
}