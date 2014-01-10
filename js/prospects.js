$(document).ready(function() {

    $('.alpha').click(function() {
        var abc = $(this).attr('data-value');
        var url = location.protocol + '//' + location.host + location.pathname;
        window.location.href = url + '?alpha=' + abc;
    });
	
	var type =  TYPE_LIST ;
	$("#list-type").select2('val', type);
	
	 $('.prospectBar').sparkline(COUNT_TOTAL_PROSPECTS, {type: 'bar', barColor: '#ff7f66',
			height: '35px',
			barWidth: ($("#left").width() > 200) ? 4 : Math.floor(($("#left").width() - 100)/17)-1,
			enableTagOptions: true	
	});


});

function getList(){
			var listaction = $('#list-type').val();
			document.location = "prospects.php?type="+listaction;
}

