$(document).ready(function() {

	var type =  TYPE_LIST ;
	$("#list-type").select2('val', type);

    $("#jqxWindow-status").jqxWindow({
    width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

    $('#agents-label').html('<i class="icon-list-alt"></i>');

    $("#agents-add").click(function(e){
	    e.preventDefault();

        $("#personal-company").val('');
        $("#personal-contact").val('');
        $('#personal-address').val('');
        $('#personal-city').val('');
        $('#personal-state').val('');
        $('#personal-zip').val('');
        $('.latitude').val('');
        $('.longitude').val('');
        $("#personal-phone1").val('');
        $("#personal-phone1type").select2('val','');
        $("#personal-phone2").val('');
        $("#personal-phone2type").select2('val','');
        $("#personal-phone3").val('');
        $("#personal-phone3type").select2('val','');
        $("#personal-email").val('');
        $('input[name=personal-isvalid]').val(0);
        $('input[name=personal-id]').val(-1);

        x=$("#personal-address").offset().left;
        y=$("#personal-address").offset().top+30;
        $(".smarty-ui").css({left:x,top:y});

        $('.streets-valid').hide();

        $('#list-actions').hide();
        $('#agents-list').hide();
        $('#agents-label').html('<i class="icon-list-alt"></i> Agents - Add');
        $('#agents-box').show();

        $("#personal-company").focus();

	});

    $("#agent-cancel").click(function(){
        $('#agents-box').hide();
        $('#agents-label').html('<i class="icon-list-alt"></i>');
        $('#list-actions').show();
        $('#agents-list').show();
    });

    $("#agent-form").validate({
	    submitHandler: function() {
			
               $('#agent-save').button('loading');
               ModifyAgent('add');
        },
    });

});

function getList(){
    var listaction = $('#list-type').val();
	document.location = "agents.php?type="+listaction;
}

function ModifyAgent(type){
    var post = $('#agent-form').serialize();
    $.post('classes/agent.class.php', post, function (data) {
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



