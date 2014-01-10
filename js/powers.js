$(document).ready(function() {

	var type =  TYPE_LIST ;
	$("#list-type").select2('val', type);

});

function getList(){
    var listaction = $('#list-type').val();
	document.location = "powers.php?type="+listaction;
}

