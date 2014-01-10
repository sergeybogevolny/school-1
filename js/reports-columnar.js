$(document).ready(function(){

/*    //JUNK??
    $('#btnCondition').click(function () {
        var query = {};
        query = getCondition('.query > table');
        //var l = JSON.stringify(query,null,4);
        var l = JSON.stringify(query);
        alert(l);
    });

    //JUNK??
    $('#btnQuery').click(function () {
        var con = getCondition('.query >table');
        var k = getQuery(con);
        alert(k);
    });

    //JUNK??
	$('#btnFriendQuery').click(function () {
	    var con = getCondition('.query >table');
		var fq = getFriendlyQuery(con);
		alert(fq);
	});

    addqueryroot('.query', true);

    $('#btnResult').click(function () {
	    var condition = getCondition('.query >table');
        var conditionraw = getQuery(condition);
        $("#report-conditionraw").val(conditionraw);
        loadResults();
	});

    $('#btnPrint').click(function () {
	    var condition = getCondition('.query >table');
        var conditionraw = getQuery(condition);
        var conditionfriendly = getFriendlyQuery(condition);
        $("#report-conditionraw").val(conditionraw);
        $("#report-conditionfriendly").val(conditionfriendly);
        generateReport();
	});
*/
  $('.addCondition').click(function () {
	  $('#logic-data').show();
	  $('#report-results').hide();

  });


    loadResults();
	
	
    $('#btnPrint').on('click', function() {
		
      
       generateReport();
       
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

function generateReport(){

    var id = $("#report-id").val();
    var conditionraw = $("#report-conditionraw").val();
    var conditionfriendly = $("#report-conditionfriendly").val();

    $.post('classes/reports_columnar.class.php', { 'report' : true, 'reportid' : id , 'conditionraw' : conditionraw, 'conditionfriendly' : conditionfriendly }, function (data) {
        if (data.match('error') !== null) {
            alert(data);
        } else {
            window.open('forms/'+data,'_blank');
        }
    });

}

//REWORK
function getvalue(val){
	// $('.col')= $(this);
	var value = val;
	//alert(val);
		if(value =='date'){

			$('#inputText').html('<input type="text"  id="valData" class="form-control datepicker span2"/>');
			var distributedate = $('.datepicker').datepicker().on('changeDate', function(ev) {distributedate.hide();}).data('datepicker');

		  }else{
				 $('#inputText').html('<input type="text"  id="valData" class="form-control span2"/>');
		  }

}
