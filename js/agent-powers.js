$(document).ready(function() {

	var type =  TYPE_LIST ;
	$("#list-type").select2('val', type);

});

function getList(id){
    var listaction = $('#list-type').val();
	document.location = "agent-powers.php?id="+id+"&type="+listaction;
}

