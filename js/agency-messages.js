$(document).ready(function() {
	$('#message-label').html('<i class="icon-list-alt"></i> Inbox');
	    loadMessage();
		$("#jqxWindow-status").jqxWindow({
					width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });
		
				$("#jqxWindow-confirm").jqxWindow({
					width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });
		   
		
		
		$('#message-cancel').click( function () {
			 $('#new-message-box').hide();
			 $('.inbox-content').show();
	         $('#message-label').html('<i class="icon-list-alt"></i> Inbox');
			 loadMessage(); 
		});
		
		$('#message-send').click( function () {
		   AddMessage();
		});
		
		$('.mail-group-checkbox').click(function() {
			
				if($(this).is(':checked')) {
						$('.mail-checkbox').prop("checked" , this.checked);
					} else {
						$('.mail-checkbox').attr ( "checked" , false );
					}			
			
		});	
 });

   
    function loadMessage(){
        var url = 'classes/agency_messages.class.php?messagelist=message';

        $('.inbox-loading').show();
        $('.inbox-content').html('');
        //toggleButton(el);
        
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {   
			   	$('#message-label').html('<i class="icon-list-alt"></i> Inbox');
                $('.inbox-loading').hide();
                $('.inbox-content').html(res);

            },
            error: function(xhr, ajaxOptions, thrownError)
            {
               
            },
            async: false
        });
    }
   
   
   
    function loadSingleMessage(id){
        var url = 'classes/agency_messages.class.php?singlemessageid='+id;

        $('.inbox-loading').show();
        $('.inbox-content').html('');
        //toggleButton(el);
        
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
				$('#message-label').html('<i class="icon-list-alt"></i> Read Message');
				$.get('classes/agency_messages.class.php',{ messagecount: "count"} )
							.done(function( data ) {
								$('#unreadmessagecount').html(data);
								if( data == 0){
									$('#unreadmessagecount').remove();
								}
							});
				
                $('.inbox-loading').hide();
                $('.inbox-content').html(res);

            },
            error: function(xhr, ajaxOptions, thrownError)
            {
               
            },
            async: false
        });
    }
	
	function LoadMessageForm(){
		     $('.inbox-content').hide();
		     $('#new-message-box').show();
			 $('#message-label').html('<i class="icon-list-alt"></i> Add-Message');
			 
		}


	function AddMessage(){
		var post = $('#message-form').serialize();
		$.post('classes/agency_messages.class.php', post, function (data) {
			if (data.match('success') !== null) {
				location.reload();
			} else {
				$("#jqxWindow-status").jqxWindow('setTitle', 'Error')
				$('#jqxWindow-status').jqxWindow({ content: data });
				$('#jqxWindow-status').jqxWindow('open');
				$('#jqxWindow-status').jqxWindow('focus');
			}
		});
	 }
