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
*/
   // addqueryroot('.query', true);
/*
    $('#btnResult').click(function () {
	    var condition = getCondition('.query >table');
        var conditionraw = getQuery(condition);
        $("#report-conditionraw").val(conditionraw);
        loadResults();
	});
*/
  $('.addCondition').click(function () {
	  $('#logic-data').show();
	  $('#report-results').hide();

  });

    $('#btnPrint').click(function () {
        var i = 0;
        var autocall=new Array();
        $('#table-campaign td .campaign-autocall:checked').each(function(){
            var a = $(this).closest('tr').attr('id');
            //alert(a);
            autocall[i] = a;
            i = i + 1;
        });
        $('input[name=campaign-autocalls]').val(autocall);

        var j = 0;
        var email=new Array();
        $('#table-campaign td .campaign-email:checked').each(function(){
            var b = $(this).closest('tr').attr('id');
            //alert(a);
            email[j] = b;
            j = j + 1;
        });
        $('input[name=campaign-emails]').val(email);

	    var k = 0;
        var text=new Array();
        $('#table-campaign td .campaign-text:checked').each(function(){
            var c = $(this).closest('tr').attr('id');
            //alert(a);
            text[k] = c;
            k = k + 1;
        });
        $('input[name=campaign-texts]').val(text);

	    var l = 0;
        var letter=new Array();
        $('#table-campaign td .campaign-letter:checked').each(function(){
            var d = $(this).closest('tr').attr('id');
            //alert(a);
            letter[l] = d;
            l = l + 1;
        });
        $('input[name=campaign-letters]').val(letter);


        $("#modal-campaign").modal();
	});

    $('#campaign-save').on('click', function(event) {
        event.preventDefault();
/*        var condition = getCondition('.query >table');
        var conditionraw = getQuery(condition);
        var conditionfriendly = getFriendlyQuery(condition);
        $("#report-conditionraw").val(conditionraw);
        $("#report-conditionfriendly").val(conditionfriendly);
*/        generateReport();
        $('#modal-campaign').modal('hide');
    });


    loadResults();

});

function checkletter(){
    var res = $("#check-letter").is(':checked');
    $("#table-campaign .campaign-letter:checkbox").prop('checked', res);
}
function checkemail(){
    var res = $("#check-email").is(':checked');
    $("#table-campaign .campaign-email:checkbox").prop('checked', res);
}
function checktext(){
    var res = $("#check-text").is(':checked');
    $("#table-campaign .campaign-text:checkbox").prop('checked', res);
}
function checkautocall(){
    var res = $("#check-autocall").is(':checked');
    $("#table-campaign .campaign-autocall:checkbox").prop('checked', res);
}


function loadResults(){
	$('#report-results').hide();
    $('.loading').show();
    var id = $("#report-id").val();
    var rsqlid = $("#report-sqlid").val();
    var conditionraw = $("#report-conditionraw").val();

    $.post('classes/reports_campaign.class.php', { 'load' : true, 'reportid' : id , 'reportsqlid' : rsqlid, 'conditionraw' : conditionraw }, function (data) {
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
    var rsqlid = $("#report-sqlid").val();
    var conditionraw = $("#report-conditionraw").val();
    var conditionfriendly = $("#report-conditionfriendly").val();
    var autocalls = $("#campaign-autocalls").val();
    var emails = $("#campaign-emails").val();
    var texts = $("#campaign-texts").val();
    var letters = $("#campaign-letters").val();

	var autocalltemplate = $("#campaign-autocall-select").val();
    var texttemplate = $("#campaign-text-select").val();
    var emailtemplate = $("#campaign-email-select").val();
    var lettertemplate = $("#campaign-letter-select").val();

    //alert(autocalls);
    /*
    $.post('classes/reports_campaign.class.php', { 'report' : true, 'reportid' : id , 'conditionraw' : conditionraw, 'conditionfriendly' : conditionfriendly, 'autocalls' : autocalls , 'autocalltemplate':autocalltemplate,'texttemplate':texttemplate,'emailtemplate':emailtemplate,'lettertemplate':lettertemplate,'emails':emails,'texts':texts,'letters':letters }, function (data) {
        if (data.match('error') !== null) {
            //alert(data);
        } else {
            //alert(data);
			var res = data.split("=");
			$.post('forms/forms.class.php', { 'campaign' : true, 'campaignid' : res[1]  }, function (data) {
		          var jsonData = JSON.parse(data);
				  console.log(jsonData);
					for (var i in jsonData) {
						var rec = jsonData[i];
				        window.open('forms/compaignletter1.php?name='+rec.name+'&date'+rec.date,'_blank');
					}

			   });

            //window.open('forms/'+data,'_blank');

        }
    });
    */

    $.post('classes/reports_campaign.class.php', { 'report' : true, 'reportid' : id, 'reportsqlid' : rsqlid, 'conditionraw' : conditionraw, 'conditionfriendly' : conditionfriendly, 'autocalls' : autocalls , 'autocalltemplate':autocalltemplate,'texttemplate':texttemplate,'emailtemplate':emailtemplate,'lettertemplate':lettertemplate,'emails':emails,'texts':texts,'letters':letters }, function (data) {
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
