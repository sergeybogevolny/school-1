$(document).ready(function() {

	var type =  TYPE_LIST ;
	$("#list-type").select2('val', type);

    $('#forfeitures-label').html('<i class="icon-list-alt"></i>');

});

function getList(){
    var listaction = $('#list-type').val();
	document.location = "general-forfeitures.php?type="+listaction;
}




