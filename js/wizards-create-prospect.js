$(document).ready(function() {
	var form_wizard = $("#form-wizard");
    $("#form-wizard").show();

    $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');

    mv = new Array();
    mvi = 0;
    mv1 = new Array();
    mvi1 = 0;

	if (form_wizard.length > 0) {
		form_wizard.formwizard({
            formPluginEnabled: true,
			validationEnabled: true,
			focusFirstInput : true,
			disableUIStyles:true,
			validationOptions: {
				errorElement:'span',
				errorClass: 'help-block error',
				errorPlacement:function(error, element){
					element.parents('.controls').append(error);
				},
				highlight: function(label) {
					$(label).closest('.control-group').removeClass('error success').addClass('error');
				},
				success: function(label) {
					label.addClass('valid').closest('.control-group').removeClass('error success').addClass('success');
				}
			},
            formOptions :{
				success: function(data){
                    if (data.match('success') !== null) {
                         var $response=$(data);
                         var id = $response.filter('#status').text();
                         window.location = "client.php?id="+id;
                    } else {
                        alert(data);
                    }
				}
			},
            textSubmit: 'Create',
			textNext: 'Next',
			textBack: 'Back',
		}).bind("step_shown",function(event){ // as the next button is not handled by the wizard, we need to handle the button caption ourselves
            var step = $("#form-wizard").formwizard("state").currentStep;
            StepValidate(step);
        }).trigger("step_shown");

        form_wizard.bind("before_step_shown", function(e, data) {
            var step = data.currentStep;
            var last  = $("#personal-last").val();
            var first = $("#personal-first").val();
            var middle = $("#personal-middle").val();
            var dob = $("#personal-dob").val();
			if ($('input[name="personal-gender"]').is(':checked')){
			    var gender = $('[name=personal-gender]:checked').val();
	        } else {
	            var gender  = '';
            }
            var race = $("#personal-race").val();
            var phone1type = $("#personal-phone1type").val();
            var phone1 = $("#personal-phone1").val();
            var phone2type = $("#personal-phone2type").val();
            var phone2 = $("#personal-phone2").val();
            var source = $("#transaction-source").val();
            var address = $("#personal-address").val();
            var city = $("#personal-city").val();
            var state = $("#personal-state").val();
            var zip = $("#personal-zip").val();
			if ($('input[name="transaction-standing"]').is(':checked')) {
				var standing = $('[name=transaction-standing]:checked').val();
	        } else {
	            var standing = '';
            }
            if (standing==''){
                $('#transaction-standingcustodyjail').select2('val','');
                $('#transaction-standingwarrantdescription').val('');
		        $('#transaction-standingotherdescription').val('');
            } else if (standing=='Custody'){
				$('#transaction-standingwarrantdescription').val('');
				$('#transaction-standingotherdescription').val('');
			} else if (standing=='Warrant') {
				$('#transaction-standingcustodyjail').select2('val','');
				$('#transaction-standingotherdescription').val('');
			} else if (standing=='Other'){
				$('#transaction-standingcustodyjail').select2('val','');
				$('#transaction-standingwarrantdescription').val('');
			}
		    var jail = $("#transaction-standingcustodyjail").val();
            var warrant = $("#transaction-standingwarrantdescription").val();
            var other   = $("#transaction-standingotherdescription").val();
            var identifiertype = $("#transaction-identifiertype").val();
            var identifier = $("#transaction-identifier").val();
            var bonds = $("#bonds-list").html();
            var refrencelist  = $("#refrences-list").html();
            var fee  = $("#quote-fee").val();
            var down  = $("#quote-down").val();
            var terms  = $("#quote-terms").val();
            var subject  = $("#note-subject").val();
            var comment  = $("#note-comment").val();

			var initiated = $('[name=prospect-initiated]:checked').val();
			var callerlast = $('#caller-last').val();
			var callerfirst = $('#caller-first').val();
			var callerphone1type = $('#caller-phone1type').val();
			var callerphone1 = $('#caller-phone1').val();
			var callerphone2type = $('#caller-phone2type').val();
			var callerphone2 = $('#caller-phone2').val();
			var callerrelation = $('#caller-relation').val();

			$("#review_last").text(last);
            $("#review_first").text(first);
			$("#review_address").text(address);
			$("#review_city").text(city);
			$("#review_state").text(state);
			$("#review_zip").text(zip);

            $("#review-initiated").text(initiated);
		    if (callerlast==''){
                $("#group-caller-last").hide();
            } else {
			    $("#review-caller-last").text(callerlast);
                $("#group-caller-last").show();
            }
            if (callerfirst==''){
                $("#group-caller-first").hide();
            } else {
			    $("#review-caller-first").text(callerfirst);
                $("#group-caller-first").show();
            }
			if ((callerphone1=='')&&(callerphone1type=='')){
                $("#group-caller-phone1type").hide();
            } else {
			    $("#review-caller-phone1").text(callerphone1);
                $("#review-caller-phone1type").text(callerphone1type);
                $("#group-caller-phone1type").show();
            }
			if ((callerphone2=='')&&(callerphone2type=='')){
                $("#group-caller-phone2type").hide();
            } else {
			    $("#review-caller-phone2").text(callerphone2);
                $("#review-caller-phone2type").text(callerphone2type);
                $("#group-caller-phone2type").show();
            }
		    if (callerrelation==''){
                $("#group-caller-relation").hide();
            } else {
			    $("#review-caller-relation").text(callerrelation);
                $("#group-caller-relation").show();
            }

			if(address == '' && city == '' && state == '' && zip == ''){
				 $("#group-address").hide();
			}else{
				 $("#group-address").show();
			}
            if (middle==''){
                $("#group-middle").hide();
            } else {
			    $("#review_middle").text(middle);
                $("#group-middle").show();
            }
            if (dob==''){
                $("#group-dob").hide();
            } else {
			    $("#review_dob").text(dob);
                $("#group-dob").show();
            }
            if (gender==''){
                $("#group-gender").hide();
            } else {
			    $("#review_gender").text(gender);
                $("#group-gender").show();
            }
            if (race==''){
                $("#group-race").hide();
            } else {
			    $("#review_race").text(race);
                $("#group-race").show();
            }
            if (phone1==''){
                $("#group-phone1").hide();
            } else {
                $("#review_phone1type").text(phone1type);
    		    $("#review_phone1").text(phone1);
                $("#group-phone1").show();
            }
            if (phone2==''){
                $("#group-phone2").hide();
            } else {
                $("#review_phone2type").text(phone2type);
                $("#review_phone2").text(phone2);
                $("#group-phone2").show();
            }
            if (source==''){
                $("#group-source").hide();
            } else {
			    $("#review_source").text(source);
                $("#group-source").show();
            }
            if (standing==''){
                $("#group-standing").hide();
            } else {
			    $("#review_standing").text(standing);
                $("#group-standing").show();
            }
            if (jail==''){
                $("#group-jail").hide();
            } else {
			    $("#review_jail").text(jail);
                $("#group-jail").show();
            }
            if (warrant==''){
                $("#group-warrant").hide();
            } else {
			    $("#review_warrant").text(warrant);
                $("#group-warrant").show();
            }
            if (other==''){
                $("#group-other").hide();
            } else {
			    $("#review_other").text(other);
                $("#group-other").show();
            }
            if (identifier==''){
                $("#group-identifier").hide();
            } else {
                $("#review_identifiertype").text(identifiertype);
                $("#review_identifier").text(identifier);
                $("#group-identifier").show();
            }
            if (bonds==''){
                $("#group-bonds").hide();
            } else {
			    document.getElementById("review_bonds").innerHTML = bonds;
                $("#group-bonds").show();
            }
			if (refrencelist==''){
                $("#group-refrences").hide();
            } else {
			    document.getElementById("review_refrences").innerHTML = refrencelist;
                $("#group-refrences").show();
            }
            if (fee==''){
                $("#group-fee").hide();
            } else {
			    $("#review_fee").text(fee);
                $("#group-fee").show();
            }
            if (down==''){
                $("#group-down").hide();
            } else {
			    $("#review_down").text(down);
                $("#group-down").show();
            }
            if (terms==''){
                $("#group-terms").hide();
            } else {
			    $("#review_terms").text(terms);
                $("#group-terms").show();
            }
            if (subject==''){
                $("#group-subject").hide();
            } else {
			    $("#review_subject").text(subject);
                $("#group-subject").show();
            }
            if (comment==''){
                $("#group-comment").hide();
            } else {
			    $("#review_comment").text(comment);
                $("#group-comment").show();
            }
		});
	}

    if($('.dataTable_1').length > 0){
		$('.dataTable_1').each(function(){
			if(!$(this).hasClass("dataTable-custom")) {
				var opt = {
					"sPaginationType": "full_numbers",
					"oLanguage":{
						"sSearch": "<span>Filter:</span> ",
						"sInfo": "Showing <span>_START_</span> to <span>_END_</span> of <span>_TOTAL_</span> entries",
						"sLengthMenu": "_MENU_ <span>entries per page</span>"
					},
                    "aoColumns": [
			            /* Checkbox */      null,
			            /* Name */          null,
                        /* Dob */           null,
                        /* Type */          null,
                        /* Standing */      null,
                        /* Logged */        null,
		            ]
				};
				if($(this).hasClass("dataTable-noheader")){
					opt.bFilter = false;
					opt.bLengthChange = false;
				}
				if($(this).hasClass("dataTable-nofooter")){
					opt.bInfo = false;
					opt.bPaginate = false;
				}
				if($(this).hasClass("dataTable-nosort")){
					var column = $(this).attr('data-nosort');
					column = column.split(',');
					for (var i = 0; i < column.length; i++) {
						column[i] = parseInt(column[i]);
					};
					opt.aoColumnDefs =  [
					{ 'bSortable': false, 'aTargets': column }
					];
				}
				var oTable = $(this).dataTable(opt);
			}
		});
    }

    $("#bonds-add").click(function(e){
	    e.preventDefault();
        //$("#record-delete").hide();
        $("#bond-court").select2("disable");
        $("#bond-amount").val('');
        $("#bond-casenumber").val('');
       // $("#bond-classFelony").prop('checked',false);
		$("#bond-classFelony").iCheck('uncheck');
		//$("#bond-classMisdemeanor").prop('checked',false);
		$("#bond-classMisdemeanor").iCheck('uncheck');
        $("#bond-charge").val('');
        $("#bond-county").select2('val', '');
        $("#bond-court").select2('val', '');
		$("#bondId").val('');
		$("#bond-delete").iCheck('uncheck');
		$('#bondDelete').hide();
        $('#wizard-actions').hide();
        $('#list-actions').hide();
        $('#bonds-list').hide();
        $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds - Add');
        fifthStepValidation();
        $('#bonds-box').show();
	});

    $("#bond-save").click(function(e){
		setChangedBond();
        $("#bond-amount").val();
	});

    $("#bond-cancel").click(function(){
        $('#bonds-box').hide();
        $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');
        $('#wizard-actions').show();
        $('#list-actions').show();
        $('#bonds-list').show();
	});

    $("#refrences-add").click(function(e){
	    e.preventDefault();
        $("#refrences-last").val('');
		$("#refrences-first").val('');
		$("#reference-phone1type").select2('val', '');
		$("#reference-phone1").val('');
		$("#reference-phone2type").select2('val', '');
        $("#reference-phone2").val('');
		$("#reference-relation").val('');
		$("#refrencesId").val('');
		$("#refrences-delete").iCheck('uncheck');
		$('#refrencesDelete').hide();
        $('#wizard-actions').hide();
        $('#list-actions').hide();
        $('#refrences-list').hide();
        $('#refrences-label').html('<i class="icon-list-alt"></i> References - Add');
		sixthStepValidation();
        $('#refrences-box').show();
	});

    $("#refrences-save").click(function(e){
		setChangedRefrences();
	});

    $("#refrences-cancel").click(function(){
        $('#refrences-box').hide();
        $('#refrences-label').html('<i class="icon-list-alt"></i> References');
        $('#wizard-actions').show();
        $('#list-actions').show();
        $('#refrences-list').show();
	});

	$('#transaction-standingCustody').on("click", function( event ) {
	    $('#standingwarrant').hide();
		$('#standingother').hide();
		$('#standingjail').show();
	});

	$('#transaction-standingWarrant').on("click", function( event ) {
	    $('#standingjail').hide();
		$('#standingother').hide();
		$('#standingwarrant').show();
	});

	$('#transaction-standingOther').on("click", function( event ) {
	    $('#standingjail').hide();
		$('#standingwarrant').hide();
		$('#standingother').show();
	})

	$('#add-new').click(function(){
	    $('#search-table_wrapper').hide();
		$('#prospect-form-group').show();
		$('#personal-last').val('');
		$('#personal-first').val('');
		$('#personal-middle').val('');
		$('#personal-dob').val('');
		$("#form-wizard").formwizard("next");
	})

    var dob = $('.datepicker').datepicker().on('changeDate', function(ev) {dob.hide();}).data('datepicker');
	$("#bond-amount").autoNumeric('init');
    $("#quote-fee").autoNumeric('init');
	$("#quote-down").autoNumeric('init');

	$("#prospect-caller").click(function(){
        $('#caller-last').val('');
    	$('#caller-first').val('');
    	$('#caller-phone1type').val('');
    	$('#caller-phone1').val('');
    	$('#caller-phone2type').val('');
    	$('#caller-phone2').val('');
    	$('#caller-relation').val('');
		$("#caller-details").show();
        firstStepValidation();
    });

	$("#prospect-defendant").click(function(){
	    $("#caller-details").hide();
        $("#next").prop('disabled', false);
	});

    $("#back").hide();
    $("#next").hide();
    setTimeout(function(){
        $("#next").prop('disabled', true);
        $("#next").show();
        $("#back").show();
    },500);

});

function getStanding(){
    if ($("#transaction-standingCustody").is(":checked")){
		$('#standingwarrant').hide();
		$('#standingother').hide();
		$('#standingjail').show();
	} else if ($("#transaction-standingWarrant").is(":checked")) {
	    $('#standingjail').hide();
		$('#standingwarrant').show();
		$('#standingother').hide();
	} else if ($("#transaction-standingOther").is(":checked")){
		$('#standingjail').hide();
		$('#standingwarrant').hide();
		$('#standingother').show();
	}
}


function SearchStatus(e){
    var sval = e.keyCode;
    if (sval!=13){
        $("#next").attr("disabled", "disabled");
        $('#add-new').attr("disabled", "disabled");
        $('#search-text').val('');
        $('#search-text').html('');
        $('#search-text').hide();
        $('#search-table').hide();
    } else {
        $('#search-text').val('loading');
        $('#search-text').html('Loading...');
        $('#search-text').show();
        $('#search-table').hide();
        LoadResults();
    }
}

function GoSearch(){
    $('#personal-last').val('');
	$('#personal-first').val('');
    var searchvalue = $('#search-value').val();
    var searchtext = $('#search-text').val();
    if((searchvalue.length>0)&&(searchtext=='')){
        $('#search-text').val('loading');
        $('#search-text').html('Loading...');
        $('#search-text').show();
        $('#search-table').hide();
		LoadResults();
	}else{
        $("#next").attr("disabled", "disabled");
        $('#add-new').attr("disabled", "disabled");
        $('#search-text').val('');
        $('#search-text').html('');
        $('#search-text').hide();
        $('#search-table').hide();
	}
}

function LoadResults(){
    var oTable = $('.dataTable_1').dataTable();
    oTable.fnClearTable();
    $('#no-search-text').hide();
    var sval =  $("#search-value").val();
    $.post('classes/wizards_create_prospect.class.php', { "search-simple": 1, "search-value": sval }, function (data) {
        if (data.match('id="error"') !== null) {
            $("#add-new").attr("disabled", "disabled");
			$('#search-text').html(data);
			$('#search-table_length').hide();
            $('#search-text').show();

            var name = $('#search-value').val();
            var arrname = name.split(" ");
            var i = arrname.length;
            var slast = '';
            var sfirst = '';
            var smiddle = '';
            if (i==1){
                sfirst = arrname[0];
                slast = arrname[0];
            } else if (i==2){
                sfirst = arrname[0];
                slast = arrname[1];
            } else {
                sfirst = arrname[0];
                slast = arrname[1];
                for (var j=1; j<i; j++){
                    slast = slast + " " + arrname[j];
                }
                slast = slast.trim();
            }

			$('#prospect-form-group').show();
			$('#personal-last').val(slast);
			$('#personal-first').val(sfirst);
			$('#personal-middle').val('');
			$('#personal-dob').val('');
			$('#personal-address').val('');
			$('#personal-city').val('');
			$('#personal-state').select2("val",'');
			$('#personal-zip').val('');

			$('#no-search-text').show().html('<h5>No records found in search. Please ADD HERE</h5>');
			$("#form-wizard").formwizard("next");
        } else {
			$('#no-search-text').hide();
			$('#prospect-form-group').hide();
            var jsonData = JSON.parse(data);
            for (var i in jsonData) {
                var rec = jsonData[i];
                var reclink = '';
                if(rec.type=='Client'){
                    reclink = '<a href="#" onclick="loadClient('+rec.id+',\''+rec.dob+'\',\''+rec.first+'\',\''+rec.middle+'\',\''+rec.last+'\',\''+rec.address+'\',\''+rec.city+'\',\''+rec.state+'\',\''+rec.zip+'\')">'+ rec.name +'</a>';
                } else {
                    reclink  = '<a href="client.php?id='+rec.id+'">'+ rec.name +'</a>';
                }
                $('#search-table').dataTable().fnAddData([
                    reclink,
                    rec.dob,
		            rec.ssn,
                    rec.type,
                    rec.standing,
                    rec.logged
                ]);
                $('#search-table tr:last').attr('id',rec.id);
            }
            $('#search-text').val('');
            $('#search-text').html('');
            $('#search-text').hide();
            $('#add-new').prop('disabled', false);
            $('#search-table').show();
        }
    });
}

function loadClient( id , dob , first , middle , last , address , city , state , zip){
	//$("#next").prop('disabled', false);
	$('#prospect-form-group').show();
	$('#search-table_wrapper').hide();
	$('#personal-last').val(last);
	$('#personal-first').val(first);
	$('#personal-address').val(address);
	$('#personal-city').val(city);
	$('#personal-state').select2("val",state);
	$('#personal-zip').val(zip);
    $('#personal-id').val(id);

	if( middle != 'null' ){
	  $('#personal-middle').val(middle);
	} else{
		$('#personal-middle').val('');
	}
	if( dob != 'null' ){
		$('#personal-dob').val(dob);
	}
	$("#form-wizard").formwizard("next");
}


function StepValidate(step){
    var bval = true;
    switch (step){
        case 'firstStep':
		    if ($("#prospect-defendant").is(":checked")){
			    $("#next").prop('disabled', false);
			}else{
			    firstStepValidation();
			}
            break;
        case 'secondStep':
            $("#add-new").attr("disabled", "disabled");
            $("#next").attr("disabled", "disabled");
            break;
        case 'thirdStep':
            $("#next").attr("disabled", "disabled");
            thirdStepValidation();
            break;
        case 'fourthStep':
            break;
        case 'fifthStep':
            break;
        case 'sixthStep':
            break;
        case 'seventhStep':
            break;
        case 'eigthStep':
            break;

    }
}

function firstStepValidation(){
    var a = $('#caller-last').val().length;
	var b = $('#caller-first').val().length;
	var c = $('#caller-phone1type').val().length;
	var d = $('#caller-phone1').val().length;
	//var e = $('#caller-phone2type').val().length;
	//var f = $('#caller-phone2').val().length;
	var g = $('#caller-relation').val().length;
	if(a>0 && b>0 && c>0 && d>0  && g>0){
	    $("#next").prop('disabled', false);
	}else{
	    $("#next").prop('disabled', true);
	}
}

function thirdStepValidation(){
	var x = $('#personal-last').val().length;
	var y = $('#personal-first').val().length;
	if( x > 0 && y > 0){
        $("#next").prop('disabled', false);
	}else{
        $("#next").attr("disabled", "disabled");
	}
}

function fifthStepValidation(){
	var x = $('#bond-charge').val().length;
	if( x > 0){
        $('#bond-save').prop('disabled', false);
	}else{
        $("#bond-save").attr("disabled", "disabled");
	}
}

function sixthStepValidation(){
	var x = $('#refrences-last').val().length;
	var y = $('#refrences-first').val().length;
	if( x > 0 && y){
        $('#refrences-save').prop('disabled', false);
	}else{
        $("#refrences-save").attr("disabled", "disabled");
	}
}

$(function () { //charge autosuggest
    'use strict';
    $.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"suggestcharges"}, dataType: 'json'}).done(function (source) {
        var chargesArray = $.map(source, function (value, key) { return { value: value, data: key }; }), charges = $.map(source, function (value) { return value; });
        $('#bond-charge').autocomplete({
            lookup: chargesArray,
            lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);
            },
            onHint: function (hint) {
                $('#bond-charge-x').val(hint);
            }
        });
	})
})

$(function () {
    'use strict';
    $.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"clientsubject"}, dataType: 'json'}).done(function (source) {
        var chargesArray = $.map(source, function (value, key) { return { value: value, data: key }; }), charges = $.map(source, function (value) { return value; });
        $('#note-subject').autocomplete({
            lookup: chargesArray,
            lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);
            },
            onHint: function (hint) {
                $('#note-subject-x').val(hint);
            }
        });
	})
});

function getCourt(){
    var selectedcounty = $('#bond-county').val();
	if(selectedcounty.length > 0 ){
	    $("#bond-court").select2("enable", true);
		$('#bond-court').select2("val","");
		$.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"ajaxcourts" , county:selectedcounty}, dataType: 'html'}).done(function (e) {
		    if(e.length == 0){
			    $('.select2-search-choice-close').trigger('click');
			}
			$('#bond-court').html(e);
		})
	}else{
        $("#bond-court").select2("disable");
	}
}

function getBondDetail(id){
    var eamount = $("#"+id).find('td:eq(0)').text()
    var eclass = $("#"+id).find('td:eq(1)').text()
    var echarge = $("#"+id).find('td:eq(2)').text()
    var ecaseno = $("#"+id).find('td:eq(3)').text()
    var ecounty = $("#"+id).find('td:eq(4)').text()
    var ecourt  = $("#"+id).find('td:eq(5)').text()

    $("#bond-court").select2("disable");
    $("#bond-amount").val(eamount);
    $("#bond-casenumber").val(ecaseno);
    // $("#bond-classFelony").prop('checked',false);
	$("#bond-classFelony").iCheck('uncheck');
	//$("#bond-classMisdemeanor").prop('checked',false);
	$("#bond-classMisdemeanor").iCheck('uncheck');
	$("#bond-delete").iCheck('uncheck');

    $("#bond-charge").val(echarge);
    $("#bond-county").select2('val', ecounty);
    $("#bond-court").select2('val', ecourt);
	$('#bondDelete').show();
	$("#bondId").val(id);
    $('#wizard-actions').hide();
    $('#list-actions').hide();
    $('#bonds-list').hide();
    $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds - Edit');
    fifthStepValidation();
    $('#bonds-box').show();
}

function setChangedBond(){
    var a = $("#bond-amount").val();
    var ca = ''
    if (a!=''){
        ca = a.replace(",","");
        ca = getCheckamount(ca);
    }
	if($('input[name="bond-class"]').is(':checked')){
        var b = $('input[name="bond-class"]:checked').val();
	}else{
	    var b = '';
    }
	var c = $("#bond-charge").val();
	var d = $("#bond-casenumber").val();
    var e = $("#bond-county").val();
    var f = $("#bond-court").val();

	var g = ca;
	var ids = $("#bondId").val();
	var trRow = $('#prospectBond').find('tr.op').length;
	if( ids != '' && trRow != 0 ){
	    var i = ids;
		mv.length = trRow;
	}else{
        var i = mv.length;
	}
    mv[i] = new Array();
    mv[i][0] = mvi;
    mv[i][1] = a;
    mv[i][2] = b;
    mv[i][3] = c;
    mv[i][4] = d;
    mv[i][5] = e;
    mv[i][6] = f;
    mv[i][7] = g;

    mvi += 1

    var thead = '<table class="table table-hover table-nomargin table-bordered" id="prospectBond"><thead><tr><th>Amount</th><th>Class</th><th>Charge</th><th>Case Number</th><th>County</th><th>Court</th></tr></thead><tbody>';
    var trow = '';
    var tfoot = '</tbody><tfoot></tfoot></table>';
    var id = 0;
    for ( var j = 0; j < mv.length; j++) {
        var a = mv[j][1] +'<input type="hidden" name="amountmv[]" value="'+mv[j][1]+'"><input type="hidden" name="checkamountmv[]" value="'+mv[j][7]+'">';
        var b = mv[j][2] +'<input type="hidden" name="classmv[]" value="'+mv[j][2]+'">';
        var c = mv[j][3] +'<input type="hidden" name="chargemv[]" value="'+mv[j][3]+'">';
        var d = mv[j][4] +'<input type="hidden" name="casenumbermv[]" value="'+mv[j][4]+'">';
        var e = mv[j][5] +'<input type="hidden" name="countymv[]" value="'+mv[j][5]+'">';
        var f = mv[j][6] +'<input type="hidden" name="courtmv[]" value="'+mv[j][6]+'">';

		var res = f.replace(null,"");
		f = res ;

        var line = '<tr id="'+id+'" class="op"><td>'+a+'</td><td>'+b+'</td><td><a href="#" onclick="getBondDetail('+id+')">'+c+'<a></td><td>'+d+'</td><td>'+e+'</td><td>'+f+'</td></tr>';
        trow = trow + line;
		id++;
    }
    var tfull = thead+trow+tfoot;
    document.getElementById("bonds-list").innerHTML = tfull;
	var flag = $('#bond-delete').is(":checked");
    if (flag==true){
	    $("#prospectBond").find("#" + ids).remove();
		if(trRow == 1){
            mv.length = 0;
            document.getElementById("bonds-list").innerHTML = '';
		}
	};
    $('#bonds-box').hide();
    $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');
    $('#wizard-actions').show();
    $('#list-actions').show();
    $('#bonds-list').show();
}

function BondDelete(id){
   document.getElementById(id).remove();
}

function getRefrencesDetail(id){
    var ename       = $("#"+id+'a').find('td:eq(0)').text()
	var ephone1type = $("#"+id+'a').find('td:eq(1)').text()
	var ephone1     = $("#"+id+'a').find('td:eq(2)').text()
	var ephone2type = $("#"+id+'a').find('td:eq(3)').text()
	var ephone2     = $("#"+id+'a').find('td:eq(4)').text()
	var erelation   = $("#"+id+'a').find('td:eq(5)').text()
	var res         = ename.split(' ');

    $("#refrences-last").val(res[0]);
	$("#refrences-first").val(res[1]);
	$("#reference-phone1type").select2('val', ephone1type);
	$("#reference-phone1").val(ephone1);
    $("#reference-phone2type").select2('val', ephone2type);
    $("#reference-phone2").val(ephone2);
    $("#reference-relation").val(erelation);
	$("#refrencesId").val(id);
	$("#refrences-delete").iCheck('uncheck');
	$('#refrencesDelete').show();
    $('#wizard-actions').hide();
    $('#list-actions').hide();
    $('#refrences-list').hide();
    $('#refrences-label').html('<i class="icon-list-alt"></i> References - Edit');
    sixthStepValidation();
    $('#refrences-box').show();
}

function setChangedRefrences(){
    var a = $("#refrences-last").val();
    var b = $("#refrences-first").val();
	var c = $("#reference-phone1type").val();
	var d = $("#reference-phone1").val();
    var e = $("#reference-phone2type").val();
    var f = $("#reference-phone2").val();
	var g = $("#reference-relation").val();
	var ids = $("#refrencesId").val();
	var trRow = $('#prospectRefrences').find('tr.op').length;
	if( ids != '' && trRow != 0 ){
	    var i = ids;
		mv1.length = trRow;
	}else{
        var i   = mv1.length;
	}
    mv1[i]    = new Array();
    mv1[i][0] = mvi;
    mv1[i][1] = a;
    mv1[i][2] = b;
    mv1[i][3] = c;
    mv1[i][4] = d;
    mv1[i][5] = e;
    mv1[i][6] = f;
    mv1[i][7] = g;
    mvi1 += 1

    var thead = '<table class="table table-hover table-nomargin table-bordered" id="prospectRefrences"><thead><tr><th>Name</th><th>Phone1 type</th><th>Phone1</th><th>Phone2 type</th><th>Phone2</th><th>Relation</th></tr></thead><tbody>';
    var trow  = '';
    var tfoot = '</tbody><tfoot></tfoot></table>';
    var idss = 0;
    for (var j = 0; j < mv1.length; j++) {
        var a = mv1[j][1]+' '+mv1[j][2] +'<input type="hidden" name="firstmv[]" value="'+mv1[j][1]+'"><input type="hidden" name="lastmv[]" value="'+mv1[j][2]+'">';
        var b = mv1[j][3] +'<input type="hidden" name="phone1typemv[]" value="'+mv1[j][3]+'">';
        var c = mv1[j][4] +'<input type="hidden" name="phone1mv[]" value="'+mv1[j][4]+'">';
        var d = mv1[j][5] +'<input type="hidden" name="phone2typemv[]" value="'+mv1[j][5]+'">';
        var e = mv1[j][6] +'<input type="hidden" name="phone2mv[]" value="'+mv1[j][6]+'">';
        var f = mv1[j][7] +'<input type="hidden" name="relationmv[]" value="'+mv1[j][7]+'">';
        var line = '<tr id="'+idss+'a" class="op"><td><a href="#" onclick="getRefrencesDetail('+idss+')">'+a+'</a></td><td>'+b+'</td><td>'+c+'</td><td>'+d+'</td><td>'+e+'</td><td>'+f+'</td></tr>';
        trow = trow + line;
		idss++;
    }
    var tfull = thead+trow+tfoot;
    document.getElementById("refrences-list").innerHTML = tfull;
	var flag = $('#refrences-delete').is(":checked");
    if (flag==true){
	    $("#prospectRefrences").find("#" + ids).remove();
		if(trRow == 1){
            mv1.length = 0;
            document.getElementById("refrences-list").innerHTML = '';
		}
	};
    $('#refrences-box').hide();
    $('#refrences-label').html('<i class="icon-list-alt"></i> Refrences');
    $('#wizard-actions').show();
    $('#list-actions').show();
    $('#refrences-list').show();
}

function RefrencesDelete(id){
   document.getElementById(id).remove();
}


