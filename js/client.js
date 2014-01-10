$(document).ready(function() {
	    TasksSummery();
        $('#posted-upload-save').prop('disabled', true);
	    if ($("#rate").length > 0) {
			function formatImages(option) {
				var img = "rate_list_"+option.text.toLowerCase()+".png";
				return "<img style='padding-right:10px;' src='img/" + img + "'>" + option.text;
			}
			$("#rate").select2({
				formatResult: formatImages,
				formatSelection:formatImages,
				escapeMarkup: function(m) { return m; }
			});
	    }

        $('#personal-label').html('Personal');
        $('#transaction-label').html('Transaction');

		$("#jqxWindow-communications").jqxWindow({
            width: 290, height: 500, position: 'center', resizable: true, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });


	    $("#jqxWindow-prospect-rate").jqxWindow({
            width: 290, height: 500, position: 'center', resizable: true, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

	    $("#jqxWindow-client-automatedCall").jqxWindow({
            width: 290, height: 300, position: 'center', resizable: true, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

	    $("#jqxWindow-client-spoofCall").jqxWindow({
            width: 290, height: 300, position: 'center', resizable: true, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

	    $("#jqxWindow-ledger").jqxWindow({
            width: 290, height: 500, position: 'center', resizable: true, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

		$("#jqxDropDownList-ledger-entry").jqxDropDownList({ height: '25', displayMember: 'name', valueMember: 'name', placeHolder: "Select:", theme: 'metro' });

		$("#jqxCalendar-account").jqxCalendar({ enableTooltips: true, width: 250, height: 250, theme: 'metro' });

		$("#ledger-date").datepicker({ format: "mm/dd/yyyy" });
		$("#ledger-amount").autoNumeric('init');
		$("#quote-fee").autoNumeric('init');
		$("#quote-down").autoNumeric('init');
        $("#personal-dob").inputmask("mm/dd/yyyy", { clearIncomplete: true, placeholder: "dd/mm/yyyy"});
        $("#personal-employersince").inputmask("mm/dd/yyyy", { clearIncomplete: true, placeholder: "dd/mm/yyyy"});

        $("#transaction-logged").datetimepicker({
            format: "dd MM yyyy - HH:ii P",
            showMeridian: true,
            autoclose: true,
            todayBtn: true
        });
        $("#transaction-rejected").datetimepicker({
            format: "dd MM yyyy - HH:ii P",
            showMeridian: true,
            autoclose: true,
            todayBtn: true
        });
        $("#transaction-posted").datetimepicker({
            format: "dd MM yyyy - HH:ii P",
            showMeridian: true,
            autoclose: true,
            todayBtn: true
        });

		$('.timepick').timepicker({
		    defaultTime: 'current',
			minuteStep: 1,
			disableFocus: true,
			template: 'dropdown'
		});

		$(".mask_ssn").mask("9999");

        $("#actions-convert").click(function(e){
			e.preventDefault();
            $("#confirm-type").val('convert');
            $('#jqxWindow-confirm').jqxWindow('setTitle', 'Convert?');
            $('#jqxWindow-confirm').jqxWindow('open');
		});

        $("#actions-reject").click(function(e){
			e.preventDefault();
            $("#confirm-type").val('reject');
            $('#jqxWindow-confirm').jqxWindow('setTitle', 'Reject?');
            $('#jqxWindow-confirm').jqxWindow('open');
		});

        $("#actions-delete").click(function(e){
			e.preventDefault();
            $("#confirm-type").val('delete');
            $('#jqxWindow-confirm').jqxWindow('setTitle', 'Delete?');
            $('#jqxWindow-confirm').jqxWindow('open');
		});


		$("#actions-revert").click(function(e){
			e.preventDefault();
            $("#confirm-type").val('revert');
            $('#jqxWindow-confirm').jqxWindow('setTitle', 'Revert?');
            $('#jqxWindow-confirm').jqxWindow('open');
		});

        $("#prospect-rate").click(function(e){
			e.preventDefault();
			var rate    = CLIENT_RATE ;
            var comment = CLIENT_RATECOMMENT ;
            $("#rate").select2('val',rate);
			$('#ratecomment').val(comment);
			 $('#form-horizontal form-bordered').hide();
			 $('#rate-label').html('Prospect Rate');
			 $('#quote-box').hide();
			 $('#rate-box').show();
			 $('#list-actions').hide();
			 $('#quote-list-actions').hide();
			 $('#quote-list').hide();
			 $('#personal-view').hide();
			 $('#transaction-view').hide();
			 $('#quote-view').hide();
		});


        $(".communications-sms").click(function(e){
			e.preventDefault();
			var phonemess = $(this).closest('.controls').find('.phone').text() ;
            $("#communications-alert").remove();
            $("#twilio-status").hide();
            $("#communications-phone").val(phonemess);
            $("#communications-message").val('');
			$("#communications-save").text('Text');
            $('input[name=communications-type]').val('sms');
            $('#jqxWindow-communications').jqxWindow('setTitle', 'Send Txt');
            $('#jqxWindow-communications').jqxWindow('open');
            $("#communications-phone").focus();
		});

        $(".communications-call").click(function(e){
			e.preventDefault();
			var phonecall = $(this).closest('.controls').find('.phone').text() ;
            $("#communications-alert").remove();

            if (TWILIO_STATUS == 'DISCONNECTED') {
                $("#twilio-status").html('Ready to make a call!');
            }
            $("#twilio-status").show();
            $("#communications-phone").val(phonecall);
			$("#communications-save").text('Call');
            $("#communications-message").val('');
            $('input[name=communications-type]').val('call');
            $("#communications-type").val('call');
            $('#jqxWindow-communications').jqxWindow('setTitle', 'Call Phone');
            $('#jqxWindow-communications').jqxWindow('open');
            $("#communications-phone").focus();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            var type = $("#confirm-type").val();
            if (type=='convert'){
                FileAction(type);
            } else if (type=='reject'){
                FileAction(type);
            } else if (type=='delete'){
                FileAction(type);
            } else if (type=='revert'){
                FileAction(type);
            }
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        var rate = CLIENT_RATE;
        if (rate!=''){
            $('#prospect-rate-tile').show();
        }

//  checkin action div show
	$('#client_checkin').click(function(){
			$('#personal-list-actions').hide();
			$('#transaction-list-actions').hide();
			$('#personal-list').hide();
			$('#transaction-view').hide();
			$('#list-actions').hide();
			$('#transaction-list').hide();
			$('#personal-view').hide();
			$('#payment-box').hide();
			$('#payment-view').hide();
			$('#checkin-box').show();
			$('#checkin-view').show();
			$('#checkin-label').html('Checkin - Add');

		})

//client_payment action
	$('#client_payment').click(function(){
		$('input[name=ledger-id]').val(-1);
        $('input[name=ledger-column]').val('credit');
        var ndate = new Date();
        $('#ledger-date').datepicker('setValue', ndate)
        $('#ledger-amount').autoNumeric('set', '');
        $("#ledger-creditentry").select2('val', '');
        $("#ledger-paymentmethod").select2('val', '');
        $("#ledger-memo").val('');
	    $('.debit-group').hide();
        $('.credit-group').show();

        $('#personal-list-actions').hide();
		$('#transaction-list-actions').hide();
		$('#personal-list').hide();
		$('#transaction-view').hide();
		$('#list-actions').hide();
		$('#transaction-list').hide();
		$('#personal-view').hide();
		$('#payment-box').hide();
		$('#payment-view').hide();
		$('#checkin-box').hide();
		$('#checkin-view').hide();
		$('#payment-box').show();
		$('#payment-view').show();
		$('#payment-label').html('Ledger - Credit');

	})

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

});

function ReportCampaign(reportid,sqlid){
    window.location.href = 'reports-campaign.php?id='+reportid+'&rsqlid='+sqlid;
}


function CommunicationsCancel(){
		$("#communications-alert").remove();
		$("#communications-phone").val('');
		$("#communications-message").val('');
		$('#jqxWindow-communications').jqxWindow('close');
}

function ProspectRate(){
    var post = $('#rate-form').serialize();
	$.post('classes/client.class.php', post, function (data) {
	    if (data.match('success') !== null) {
		    location.reload();
		} else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
		}
	});
}

function LoadPersonal(id){

    var last = CLIENT_LAST;
    var first = CLIENT_FIRST;
    var middle = CLIENT_MIDDLE;
    var dob = CLIENT_DOB;
    var ssn = CLIENT_SSN;
    var gender = CLIENT_GENDER;
    var race = CLIENT_RACE;
    var address = CLIENT_ADDRESS;
    var city = CLIENT_CITY;
    var state = CLIENT_STATE;
    var zip = CLIENT_ZIP;
    var latitude = CLIENT_LATITUDE;
    var longitude = CLIENT_LONGITUDE;
    var phone1type = CLIENT_PHONE1TYPE;
    var phone1 = CLIENT_PHONE1;
    var phone2type = CLIENT_PHONE2TYPE;
    var phone2 = CLIENT_PHONE2;
    var phone3type = CLIENT_PHONE3TYPE;
    var phone3 = CLIENT_PHONE3;
    var phone4type = CLIENT_PHONE4TYPE;
    var phone4 = CLIENT_PHONE4;
	var dl 	   =CLIENT_DL ;
	var employer = CLIENT_EMPLOYER ;
	var employersince = CLIENT_EMPLOYERSINCE ;
	var email = CLIENT_EMAIL ;
    var isvalid = CLIENT_ISVALID;
	$("#personal-last").val(last);
    $("#personal-first").val(first);
    $("#personal-middle").val(middle);
    $("#personal-dob").val(dob);
    $("#personal-ssn").val(ssn);
    if(gender == 'Male'){
		$("#personal-genderMale").iCheck('check').trigger('click');
	}else if(gender == 'Female'){
		$("#personal-genderFemale").iCheck('check').trigger('click');
	}else{
	    $("#personal-genderMale").prop('checked',false);
	    $("#personal-genderFemale").prop('checked',false);
	}
    $("#personal-race").select2('val',race);
    $('#personal-address').val(address);
    $('#personal-city').val(city);
    $("#personal-state").select2('val',state);
    $('#personal-zip').val(zip);
    //$('.latitude').val(latitude);
    //$('.longitude').val(longitude);
    $("#personal-phone1").val(phone1);
    $("#personal-phone1type").select2('val',phone1type);
    $("#personal-phone2").val(phone2);
    $("#personal-phone2type").select2('val',phone2type);
    $("#personal-phone3").val(phone3);
    $("#personal-phone3type").select2('val',phone3type);
    $("#personal-phone4").val(phone4);
    $("#personal-phone4type").select2('val',phone4type);
    $("#personal-dl").val(dl);
    $("#personal-email").val(email);
    $("#personal-employer").val(employer);
    $("#personal-employersince").val(employersince);
    $('input[name=personal-isvalid]').val(isvalid);
    $('input[name=personal-id]').val(id);

    $('#list-actions').hide();
    if (isvalid==1){
        $('.streets-valid').show();
    } else {
        $('.streets-valid').hide();
    }
    $('#personal-list-actions').hide();
    $('#personal-list').hide();
    $('#transaction-view').hide();
    $('#personal-label').html('Personal - Edit');
    $('#personal-box').show();

    x=$("#personal-address").offset().left;
    y=$("#personal-address").offset().top+30;
    $(".smarty-ui").css({left:x,top:y});

    $("#personal-last").focus();
    $('#transaction-view').hide();
    $('#quote-view').hide();
	 $('#rate-box').hide();

}


function LoadTransaction(id){

     //$.ajax({ url: 'ajaxtags.php', type: "GET", }).done(function (data) { $('#transactiontags-container').html(data);})

	 var source = CLIENT_SOURCE;
	 var logged = CLIENT_LOGGED;
     var posted = CLIENT_POSTED;
     var rejected = CLIENT_REJECTED;
	 var standing = CLIENT_STANDING;
	 var jail = CLIENT_JAIL;
	 var warrant = CLIENT_WARRANT;
	 var other	 = CLIENT_OTHER;
	 var identifiertype = CLIENT_IDENTIFIERTYPE;
     var identifier = CLIENT_IDENTIFIER;
     var type = CLIENT_TYPE;

	 $("#transaction-source").select2('val',source);
	 $("#transaction-logged").val(logged);
     $("#transaction-rejected").val(rejected);
     $("#transaction-posted").val(posted);
	 $("#transaction-identifiertype").select2('val',identifiertype);
	  $("#transaction-identifier").val(identifier);
	 if(standing == 'Custody'){
        $("#transaction-standingCustody").iCheck('check').trigger('click');
	 }else if(standing == 'Warrant'){
        $("#transaction-standingWarrant").iCheck('check').trigger('click');
	 }else if(standing == 'Other'){
        $("#transaction-standingOther").iCheck('check').trigger('click');
	 }else{
	    $("#transaction-standingCustody").prop('checked',false);
		$("#transaction-standingCarrant").prop('checked',false);
		$("#transaction-standingOther").prop('checked',false);
	 }

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



	 $("#transaction-standingcustodyjail").select2('val',jail);
	 $("#transaction-standingwarrantdescription").val(warrant);
	 $("#transaction-standingotherdescription").val(other);
     $('input[name=transaction-type]').val(type);
     $('input[name=transaction-id]').val(id);

	 $('#list-actions').hide();
	 $('#transaction-list-actions').hide();
	 $('#transaction-list').hide();
	 $('#personal-view').hide();
	 $('#transaction-label').html('Transaction - Edit');
	 //$('#transaction-view').css('margin-left','-5px');
	 $('#transaction-box').show();

	 $("#transaction-source").focus();
    $('#quote-view').hide();
	 $('#rate-box').hide();
}
function LoadQuote(id){

     //$.ajax({ url: 'ajaxtags.php', type: "GET", }).done(function (data) { $('#transactiontags-container').html(data);})

	 var fee = CLIENT_FEE;
	 var down = CLIENT_DOWN;
     var terms = CLIENT_TERMS;

	 $("#quote-fee").val(fee);
	 $("#quote-down").val(down);
     $("#quote-terms").val(terms);
     $("#quote-id").val(id);


	 $('#form-horizontal form-bordered').hide();
	 $('#quote-label').html('Quote - Edit');
	 //$('#transaction-view').css('margin-left','-5px');
	 $('#quote-box').show();
      $('#rate-box').hide();
	 
	 $('#list-actions').hide();
	 $('#quote-list-actions').hide();
	 $('#quote-list').hide();
	 $('#personal-view').hide();
	 $('#transaction-view').hide();
	 $('#quote-label').html('Quote - Edit');
	 //$('#transaction-view').css('margin-left','-5px');

   // $('#quote-view').show();
	 
}

function PersonalCancel(){
    $('#personal-box').hide();
    $('#personal-label').html('Personal');
    $('#list-actions').show();
    $('#personal-list-actions').show();
    $('#personal-list').show();
    $('#transaction-view').show();
    $('#quote-view').show();
}

function TransactionCancel(){
    $('#transaction-box').hide();
    //$('#transaction-view').css('margin-left','40px');
    $('#transaction-label').html('Transaction');
    $('#list-actions').show();
    $('#transaction-list-actions').show();
    $('#transaction-list').show();
    $('#personal-view').show();
    $('#quote-view').show();
    $('#transaction-view').show();
}

function QuoteCancel(){
    $('#quote-box').hide();
    //$('#transaction-view').css('margin-left','40px');
    $('#quote-label').html('Quote');
    $('#list-actions').show();
    $('#quote-list-actions').show();
    $('#quote-list').show();
    $('#personal-view').show();
    $('#quote-view').show();
    $('#transaction-view').show();
}



function RateCancel(){
	$("#rate").select2('val','');
	$('#ratecomment').val('');
    $('#quote-box').hide();
	 $('#rate-box').hide();
    //$('#transaction-view').css('margin-left','40px');
    $('#quote-label').html('Quote');
    $('#list-actions').show();
    $('#quote-list-actions').show();
    $('#quote-list').show();
    $('#personal-view').show();
    $('#quote-view').show();
    $('#transaction-view').show();
}

function PersonalSave(){
    $('#personal-save').button('loading');
    ModifyClient('personal');
}

function TransactionSave(){
    $('#transaction-save').button('loading');
    ModifyClient('transaction');
}
function  QuoteSave(){
    $('#quote-save').button('loading');
    ModifyClient('quote');
}


function ModifyClient(type){
    var post = '';
    if (type=='personal'){
        post = $('#personal-form').serialize();
    } else if(type=='transaction'){
        if($("#transaction-standingCustody").is(":checked")){
		    $('#transaction-standingwarrantdescription').val('') ;
		    $('#transaction-standingotherdescription').val('');
	    } else if ($("#transaction-standingWarrant").is(":checked")) {
		    $('#transaction-standingcustodyjail').select2('val',"") ;
		    $('#transaction-standingotherdescription').val('') ;
	    } else if ($("#transaction-standingOther").is(":checked")){
		    $('#transaction-standingcustodyjail').select2('val',"") ;
		    $('#transaction-standingwarrantdescription').val('');
	    }
        post = $('#transaction-form').serialize();
    }else if (type=='quote'){
        post = $('#quote-form').serialize();
    } 
    $.post('classes/client.class.php', post, function (data) {
        if (data.match('success') !== null) {
			location.reload();
        } else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
            if (type=='personal'){
                $('#personal-save').button('reset');
            } else {
                $('#transaction-save').button('reset');
            }
        }
    });
}

function FileAction(action){
    var id = $("#client-id").val();
        $.post('classes/client.class.php', { 'action' : action , 'client-id' : id }, function (data) {
        if (data.match('success') !== null) {
            if (action=='convert'){
                location.reload();
            } else if (action=='reject'){
                location.reload();
            } else if (action=='delete'){
                window.location.replace("prospects.php?type=deleted");
            } else if (action=='revert'){
                location.reload();
            }
        } else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
        }
    });
}

function CheckinSave(){
    var post = $('#checkin-form').serialize();
        $.post('classes/client_checkin.class.php', post, function (data) {
			if (data.match('success') !== null) {
		        location.reload();
			} else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
            
                $('#checkin-save').button('reset');
           
        }
    });

}

function CheckinCancel(){
			$('#personal-list-actions').show();
			$('#transaction-list-actions').show();
			$('#personal-list').show();
			$('#transaction-view').show();
			$('#list-actions').show();
			$('#transaction-list').show();
			$('#personal-view').show();
			$('#payment-box').show();
			$('#payment-view').show();
			$('#checkin-box').hide();
			$('#checkin-view').hide();
			$('#payment-box').hide();
		    $('#payment-view').hide();
}

function PaymentSave(){
	var post = $('#payment-form').serialize();
		$.post('classes/client_account.class.php', post, function (data) {
			if (data.match('success') !== null) {
		        location.reload();
			} else {
                $('#modal-title-error').html('System');
                $('#modal-body-error').html(data);
                $("#modal-error").modal();
            	$('#ledger-save').button('reset');
			}
		});
}

function PaymentCancel(){
			$('#personal-list-actions').show();
			$('#transaction-list-actions').show();
			$('#personal-list').show();
			$('#transaction-view').show();
			$('#list-actions').show();
			$('#transaction-list').show();
			$('#personal-view').show();
			$('#payment-box').show();
			$('#payment-view').show();
			$('#checkin-box').hide();
			$('#checkin-view').hide();
			$('#payment-box').hide();
		    $('#payment-view').hide();
}

function ClientAutomatedCall(){
		$('#call-status').html('');
		$('#jqxWindow-client-automatedCall').jqxWindow('setTitle', 'Automated Call');
		$('#jqxWindow-client-automatedCall').jqxWindow('open');

}


function automated_call_action(){
	 $('#automated-call').button('loading');
	 $('#call-status').show().html('<div class="alert" ><i class="icon-spinner icon-spin"></i> Call in process .......</div>');
	   var number = $('#automatedCall').val();
		$.get('classes/client.class.php?automatedcall=call',{ number: number }).done(function(data) {
			var $response=$(data);
            var status = $response.filter('#callStatus').text();
				 $('#automated-call').button('enable').text('Call');
				 $('#automatedCall').val('');
				 $('#call-status').show().html(data);
		});
}


function automated_cancel() {
	Twilio.Device.disconnectAll();
	$('#automatedCall').val('');
	 $('#automated-call').button('enable').text('Call');
    $('#call-status').hide().html('');
    $('#jqxWindow-client-automatedCall').jqxWindow('close');
}


//document for ssn and employer

//get $_FILE name by model 
(function($) {
    $.fn.serializeAll = function() {
        var rselectTextarea = /^(?:select|textarea)/i;
        var rinput = /^(?:color|date|datetime|datetime-local|email|file|hidden|month|number|password|range|search|tel|text|time|url|week)$/i;
        var rCRLF = /\r?\n/g;

        var arr = this.map(function(){
            return this.elements ? jQuery.makeArray( this.elements ) : this;
        })
        .filter(function(){
            return this.name && !this.disabled &&
                ( this.checked || rselectTextarea.test( this.nodeName ) ||
                    rinput.test( this.type ) );
        })
        .map(function( i, elem ){
            var val = jQuery( this ).val();

            return val == null ?
                null :
                jQuery.isArray( val ) ?
                    jQuery.map( val, function( val, i ){
                        return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
                    }) :
                    { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
        }).get();

        return $.param(arr);
    }
})(jQuery);


function documentValidate(){
	
	var x = $('#dl-upload').val().length;
	var y = $('#dl-friendly-name').val().length;
	
	var m = $('#employer-upload').val().length;
	var n = $('#employer-friendly-name').val().length;
	
	var p = $('#posted-upload').val().length;
	var q = $('#posted-friendly-name').val().length;
	
    if(x > 0 && y>0){
	    $('#dl-upload-save').prop('disabled', false);
	}else{
	    $('#dl-upload-save').prop('disabled', true);
	}
	
    if(m > 0 && n>0){
	    $('#employer-upload-save').prop('disabled', false);
	}else{
	    $('#employer-upload-save').prop('disabled', true);
	}
	
    if(p > 0 && q>0){
	    $('#posted-upload-save').prop('disabled', false);
	}else{
	    $('#posted-upload-save').prop('disabled', true);
	}
	

}

function Dlupload(){
    $("#dl-friendly-name").val('');
	$("#dl-upload").val('');
    documentValidate();
    $("#modal-dl").modal();
}

function dlDoc(id){
	//alert(id);
	
		$.ajaxFileUpload({
			url:'documents/document-upload.php?filename=dl-upload&p1='+id+'&p2=root',
			secureuri:false,
			fileElementId:'dl-upload',
			success: function (data, status){
				//alert('here');
				if(status == 'success'){
					Modifydl(); 
						
				  }
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)
			
}


function Modifydl(){

    var post = $('#dl-document-form').serializeAll();
    $.post('classes/document.class.php', post, function (data) {
        if (data.match('success') !== null) {
			getDlDoc();
        } else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#bond-save').button('reset');
            }
        }
    });
}

function getDlDoc(){
	        
	      // $('#attroneyDoc').html('<li>   Loading...  </li>');
	        var id = $('#personal-id').val();
			//var clientid = CLIENT_ID ;
			$.post('classes/document.class.php',{id:id,action:'getdl'}).done(function(data){
				    $('#dlDoc').html(data);
				})

}



function Employerupload(){
    $("#employer-friendly-name").val('');
	$("#employer-upload").val('');
    documentValidate();
    $("#modal-employer").modal();
}


//save doc by ajax 
function EmployerDoc(id){

	
		$.ajaxFileUpload({
			url:'documents/document-upload.php?filename=employer-upload&p1='+id+'&p2=root',
			secureuri:false,
			fileElementId:'employer-upload',
			success: function (data, status){
				//alert('here');
				if(status == 'success'){
					ModifyEmployer(); 
						
				  }
			  
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)
			
}

function ModifyEmployer(){

    var post = $('#employer-document-form').serializeAll();
    $.post('classes/document.class.php', post, function (data) {
        if (data.match('success') !== null) {
			getEmployerDoc();
        } else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#bond-save').button('reset');
            }
        }
    });
}



function getEmployerDoc(){
	      // $('#settingDoc').html('<li>  Loading...  </li>');
	        var id = $('#personal-id').val();
			$.post('classes/document.class.php',{id:id,action:'getemployer'}).done(function(data){
				    $('#employerDoc').html(data);
				})

}



function Postedupload(){
    $("#posted-friendly-name").val('');
	$("#posted-upload").val('');
    documentValidate();
    $("#modal-posted").modal();
}




function PostedDoc(id){
	
		$.ajaxFileUpload({
			url:'documents/posted-upload.php?filename=indemnify-upload&p1='+id+'&p2=root',
			secureuri:false,
			fileElementId:'posted-upload',
			success: function (data, status){
				//alert('here');
				if(status == 'success'){
					ModifyPosted(); 
				  }
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)
}



function ModifyPosted(){

    var post = $('#posted-document-form').serializeAll();
    $.post('classes/document.class.php', post, function (data) {
        if (data.match('success') !== null) {
			getPostedDoc();
        } else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#bond-save').button('reset');
            }
        }
    });
}

function getPostedDoc(){
	        
	      // $('#attroneyDoc').html('<li>   Loading...  </li>');
	        var id = $('#transaction-id').val();
			//var clientid = $('#client-id').val();
			$.post('classes/document.class.php',{id:id,action:'getposted'}).done(function(data){
				    $('#postedDoc').html(data);
				})

}


function TasksSummery(){
    $('#taskSummery').hide();
    var partyid = CLIENT_ID;
    $.get('classes/tasks.class.php', { tasks: 1, type: 'partyq', filter: 'NONE', partyid: partyid }, function (data) {
		if(data != '""'){
				var jsonData = JSON.parse(data);
				var taskCount = jsonData.length;
				$('#taskSummeryCount').html(taskCount);
				$('#taskSummery').show();
				 var k = 0;
				 var Detail =new Array();
				 
				for (var i in jsonData) {
					var rec = jsonData[i];
					Detail[k] = '<span style="width:120px;height:20px"><img src="img/task_list_'+rec.type+'_white.png" style="margin-right:6px;">'+rec.task.substring(0,13)+'...</span>';
					k++;
				}
				changeSummeryDetail(Detail);
				if(taskCount > 1)	
				setInterval(function(){ changeSummeryDetail(Detail)},3000 * taskCount);
		}else{
			    $('#taskSummery').hide();
		}
	});
}

function changeSummeryDetail(Detail){
	
			var x = document.getElementById('taskSummeryDetail');
			var s = Detail;
			var i = 0;
			
			if(s.length == 1){
				x.innerHTML = s[i];
			}else{
			
			(function loop() {
				x.innerHTML = s[i];
				
				if (++i < s.length) {
					setTimeout(loop, 3000);  
				}
			})(); 
	     }
	
}
