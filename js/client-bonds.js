$(document).ready(function() {


	    $('#setting-upload-save').prop('disabled', false);
	    $('#attroney-upload-save').prop('disabled', false);

        $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#bond-executeddate").inputmask("mm/dd/yyyy", { clearIncomplete: true, placeholder: "dd/mm/yyyy"});
        $("#bond-forfeiteddate").inputmask("mm/dd/yyyy", { clearIncomplete: true, placeholder: "dd/mm/yyyy"});
        $("#bond-disposeddate").inputmask("mm/dd/yyyy", { clearIncomplete: true, placeholder: "dd/mm/yyyy"});

        $("#bond-setting").datetimepicker({
            format: "dd MM yyyy - HH:ii P",
            showMeridian: true,
            forceParse: 0,
            autoclose: true,
            todayBtn: true
        });


		$('#bond-amount').autoNumeric('init');

		$("#bond-county").select2({
			placeholder: "Select county",
			allowClear: true,

		});
		$("#printer-select").select2({
			placeholder: "Select printer",
			allowClear: true
		});

	   $("#bonds-add").click(function(e){
			e.preventDefault();

			$("#bond-court").select2("disable");

            $("#record-delete").hide();
            $("#bond-amount").val('');
            $("#bond-checkamount").val('');
            $("#bond-classFelony").prop('checked',false);
		    $("#bond-classMisdemeanor").prop('checked',false);
            $("#bond-class").val('');
            $("#bond-charge").val('');
            $("#bond-casenumber").val('');
            $("#bond-county").select2('val', '');
            $("#bond-court").select2('val', '');
            var getYYYY = new Date().getFullYear();
            var getMM = new Date().getMonth() + 1;
            var getDD = new Date().getDate();
            var executeddate = getMM+''+getDD+'/'+getYYYY;
            $("#bond-executeddate").val(executeddate);
            $("#bond-dispositionExecuted").iCheck('check');
			$("#bond-setfor").select2('val', '');
			$("#bond-attorney").val('');
			$("#bond-setting").val('');
			$("#bond-forfeiteddate").val('');
			$("#bond-forfeitedcomment").val('');
			$("#bond-disposeddate").val('');
			$("#bond-disposedcomment").val('');
			$("#bond-delete").attr('checked', false);
			$("#bond-powers").select2('val','');
			$('#docview').html('<li><a href="#" onclick="upload()" class="document-upload"><i class="icon-upload"></i> Upload</a></li>');

			$('input[name=bond-id]').val(-1);

            $('#list-actions').hide();
            $('#bonds-list').hide();
            $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds - Add');
            $('#bonds-box').show();
			$('#attroney-doc').hide();
			$('#setting-doc').hide();
            $("#bond-charge").focus();

		});

        $("#bond-cancel").click(function(){
            $('#bonds-box').hide();
            $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds');
            $('#list-actions').show();
            $('#bonds-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyBond('delete');
		});

        $("#bond-form").validate({
	        submitHandler: function() {
                var flag = $('#bond-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#bond-save').button('loading');
                    var id = $("#bond-id").val();
                    if (id==-1){
                        ModifyBond('add');
                    } else {
                        ModifyBond('edit');
                    }
                }
            },
        });

$("#attrony-document-form").validate({
	        submitHandler: function() {

                    $('#attroney-upload-save').button('loading');
                    var id = $("#bond-id").val();

                        ModifyAttroney();


            },
        });




   $('#bond-dispositionExecuted').iCheck({
              radioClass: 'iradio_square-blue',
              increaseArea: '20%'
            });
	$('#bond-delete').iCheck({
               checkboxClass: 'icheckbox_square-blue',
			   labelHover: false,
			  cursor: true,
			  increaseArea: '20%'
            });

	$('#bond-dispositionExecuted').on("click", function( event ) {
		$('#disposedgroup').hide();
		$("#disposedgroup :input").val("");
		$('#forfeitedgroup').hide();
		$("#forfeitedgroup :input").val("");
		});

	$('#bond-dispositionForfeited').on("click", function( event ) {
		$('#disposedgroup').hide();
		$("#disposedgroup :input").val("");
		$('#forfeitedgroup').show();
	});

	$('#bond-dispositionDisposed').on("click", function( event ) {
		$('#forfeitedgroup').hide();
		$("#forfeitedgroup :input").val("");
		$('#disposedgroup').show();
	})

    $('#button-print').on('click', function(event) {
        var title = $('#modal-title-printer').val();
        var pid = $('#printer-select').val();
        var oname = $('#overwrite-name').val();
        var id = $('#form-id').val();
        var qstr = '';
        var flag = $('#printer-overwrite').is(":checked");
        switch (title){
            case 'Power - Allegheny':
                qstr = "forms/powerallegheny.php?id="+id+"&pid="+pid;
                if (flag==true){
                    qstr = qstr+"&oname="+oname;
                }
                window.open(qstr, "_blank");
                break;
            case 'Bond - Harris TX, County':
                qstr = "forms/bondharristxcounty.php?id="+id+"&pid="+pid;
                if (flag==true){
                    qstr = qstr+"&oname="+oname;
                }
                window.open(qstr, "_blank");
                break;
            case 'Bond - Harris TX, JP':
                qstr = "forms/bondharristxjp.php?id="+id+"&pid="+pid;
                if (flag==true){
                    qstr = qstr+"&oname="+oname;
                }
                window.open(qstr, "_blank");
                break;
            case 'Bond - Houston TX, City':
                qstr = "forms/bondhoustontxcity.php?id="+id+"&pid="+pid;
                if (flag==true){
                    qstr = qstr+"&oname="+oname;
                }
                window.open(qstr, "_blank");
                break;
            case 'Other - Harris TX, Assignment of Authority':
                qstr = "forms/otherharristxaoa.php?id="+id+"&pid="+pid;
                if (flag==true){
                    qstr = qstr+"&oname="+oname;
                }
                window.open(qstr, "_blank");
                break;
        }
        $('#modal-printer').modal('hide');

    });

    $("#printer-overwrite").change(function() {
        var flag = $('#printer-overwrite').is(":checked");
        if (flag==true){
            $('.overwrite').show();
        } else{
            $('.overwrite').hide();
        }
    });




});

Number.prototype.format = function() {
    return this.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
};

function getCourt(){
		var selectedcounty = $('#bond-county').val();
		var courtval = $('#bond-court').val();
        $('#bond-court').html('');
		$("#bond-court").select2("enable", true);
	    $('#bond-court').select2("val","");
		$.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"ajaxcourts" , county:selectedcounty}, dataType: 'html'
		}).done(function (e) {
			  if(e.length == 0){
				  $('.select2-search-choice-close').trigger('click');
				  }
              $('#bond-court').html(e);
		})
}

function getLoadCourt( county ){
		var selectedcounty = county;
		var courtval = $('#bond-court').val();
        $('#bond-court').html('');
		$("#bond-court").select2("enable", true);
	    $('#bond-court').select2("val","");
		$.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"ajaxcourts" , county:selectedcounty}, dataType: 'html'
		}).done(function (e) {
			  if(e.length == 0){
				  $('.select2-search-choice-close').trigger('click');
				  }
              $('#bond-court').html(e);
		})
}





function getPowers(){

	  	var LOADID = $('#loadID').text();

		var powers = $('#bond-powers').val();
		$('#powers-id').val(powers);

		if(powers.length > 0){

            $('.bond-transfer').iCheck('enable');
			  if(LOADID == 1){
				  $('.bond-transfer').iCheck('check');
			  }else{
				$('.bond-transfer').iCheck('uncheck');
			  }


		}else{
			$('.bond-transfer').iCheck('uncheck');
			$('.bond-transfer').iCheck('disable');
		}
 }




$(function () {
    'use strict';

    $.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"suggestcharges"}, dataType: 'json'
    }).done(function (source) {

        var chargesArray = $.map(source, function (value, key) { return { value: value, data: key }; }),
            charges = $.map(source, function (value) { return value; });

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



 $.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"bondattorney"}, dataType: 'json'
    }).done(function (source) {

        var chargesArray = $.map(source, function (value, key) { return { value: value, data: key }; }),
            charges = $.map(source, function (value) { return value; });

        $('#bond-attorney').autocomplete({
            lookup: chargesArray,
            lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
                var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
                return re.test(suggestion.value);
            },
            onHint: function (hint) {
                $('#bond-attorney-x').val(hint);
            }
        });
	})


});

function LoadBond(id){
	 
	$('#attroney-doc').show();
	$('#setting-doc').show();
    var row = BONDS_SOURCE.filter( function(item){return (item.id==id);} );

	var amount = row[0]['amount'];
    amount = parseFloat(amount);
    amount = amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    var bondclass = row[0]['class'];
	var charge = row[0]['charge'];
	var casenumber = row[0]['casenumber'];
	var county = row[0]['county'];
	var court = row[0]['court'];
	var executeddate = row[0]['executeddate'];
	var disposition = row[0]['disposition'];
	var setting = row[0]['setting'];
	var attorney = row[0]['attorney'];
	var setfor = row[0]['setfor'];
	var forfeiteddate = row[0]['forfeiteddate'];
	var forfeitedcomment = row[0]['forfeitedcomment'];
	var disposeddate = row[0]['disposeddate'];
	var disposedcomment = row[0]['disposedcomment'];
	var powerid = row[0]['power_id'];
	var reportid = row[0]['report_id'];
	var powers = row[0]['powers'];
	var checkamount = row[0]['checkamount'];
	var transfer = row[0]['transfer'];
	var documentsetting = row[0]['documentsetting'];
	var clientid = CLIENT_ID ;

    getLoadCourt(county);
	getTransfer(transfer);

	 $('#attrony-bond-id').val(id);
	 $('#setting-bond-id').val(id);


	  $('.bond-transfer').iCheck('disable');
	  if(transfer == 1){
		  $('.bond-transfer').iCheck('check');
	  }else{
		$('.bond-transfer').iCheck('uncheck');
	  }
	  if(powerid != 0){
		$.get( "classes/client_bond.class.php", { powerId: powerid } )
			.done(function( data ) {
					if(reportid != null){
					$("#bond-powers").select2("val",'');
				    $("#empty_report").hide();
					$("#powers").show();
					$("#powers-transfer").show();
					$("#powers").html('<input type="text" value="'+data+'" class="input-large" readonly><input type="hidden" value="'+powerid+'" name="bond-powers" id="bond-powers">');

					}else{
						$("#powers").html('');

						$("#powers-transfer").hide();
						$("#empty_report").show();
						$("#bond-powers").select2("enable");
						$('.bond-transfer').iCheck('enable');
						$("#bond-powers").html(BONDS_POWERS+'<option value="'+powerid+'">'+data+'</option>');
						$("#bond-powers").select2("val",powerid);
	               }

	    });
	  }


	if(county.length > 0  ){

		   if( court != null){
					$('#bond-court').html('<option value=""></option><option value="'+court+'">'+court+'</option>');
					$("#bond-court").select2('val', court);
				}

		}else{

           $("#bond-court").select2("disable");
		}

    $("#record-delete").show();
    $("#bond-delete").attr('checked', false);
	$("#bond-amount").val(amount);
    $("#bond-checkamount").val(checkamount);

	if(bondclass == 'Misdemeanor'){
        $("#bond-classMisdemeanor").iCheck('check');
	}else if(bondclass == 'Felony'){
	    $("#bond-classFelony").iCheck('check');
	}else{
	    $("#bond-classFelony").prop('checked',false);
		$("#bond-classMisdemeanor").prop('checked',false);
	}
    $("#bond-class").val(bondclass);
    $("#bond-charge").val(charge);
	$("#bond-casenumber").val(casenumber);
    $("#bond-county").select2('val', county);
	$("#bond-executeddate").val(executeddate);
    $("#bond-disposition").val(disposition);
	$("#bond-setfor").select2('val', setfor);
    $("#bond-attorney").val(attorney);
    $("#bond-setting").val(setting);
    $("#bond-forfeiteddate").val(forfeiteddate);
    $("#bond-forfeitedcomment").val(forfeitedcomment);
    $("#bond-disposeddate").val(disposeddate);
    $("#bond-disposedcomment").val(disposedcomment);





	if(disposition == 'Executed'){
        $("#bond-dispositionExecuted").iCheck('check').trigger('click');
		$('#disposedgroup').hide();
		$("#disposedgroup :input").val("");
		$('#forfeitedgroup').hide();
		$("#forfeitedgroup :input").val("");

	}else if(disposition == 'Forfeited'){
	    $("#bond-dispositionForfeited").iCheck('check').trigger('click');
		$('#disposedgroup').hide();
		$("#disposedgroup :input").val("");
		$('#forfeitedgroup').show();

	}else if(disposition == 'Disposed'){
		$("#bond-dispositionDisposed").iCheck('check').trigger('click');
		$('#forfeitedgroup').hide();
		$("#forfeitedgroup :input").val("");
		$('#disposedgroup').show();
	}
	else{
		$("#bond-bond-dispositionExecuted").prop('checked',false);
		$("#bond-dispositionForfeited").prop('checked',false);
		$("#bond-dispositionDisposed").prop('checked',false);
	}

    $('input[name=bond-id]').val(id);
    $('#list-actions').hide();
    $('#bonds-list').hide();
    $('#bonds-label').html('<i class="icon-list-alt"></i> Bonds - Edit');
    $('#bonds-box').show();
    $("#bond-charge").focus();

}


function getTransfer(transfer){
	 $('#loadID').text(transfer);
}

function ModifyBond(type){

    var post = $('#bond-form').serialize();
    $.post('classes/client_bond.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
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

function PrinterLocation(name,id){
    $('input[name=form-id]').val(id);
    $("#modal-title-printer").val(name);
    $("#modal-title-printer").html(name);
    $("#modal-printer").modal();
}

function ReportCampaign(reportid,sqlid){
    window.location.href = 'reports-campaign.php?id='+reportid+'&rsqlid='+sqlid;
}

function setCheckAmount(){
        var a = $("#bond-amount").val();
        var ca = ''
        if (a!=''){
            ca = a.replace(",","");
            ca = getCheckamount(ca);
        }
      $("#bond-checkamount").val(ca);

}



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


function DocValidate(){

	var x = $('#setting-upload').val().length;
	var y = $('#setting-friendly-name').val().length;

	var m = $('#attroney-upload').val().length;
	var n = $('#attroney-friendly-name').val().length;

    if(x > 0 && y>0){
	    $('#setting-upload-save').prop('disabled', false);
	}else{
	    $('#setting-upload-save').prop('disabled', true);
	}
	
    if(m > 0 && n>0){
	    $('#attroney-upload-save').prop('disabled', false);
	}else{
	    $('#attroney-upload-save').prop('disabled', true);
	}
	

}

function nameValidate(){
	
	var x = $('#setting-upload').val().length;
	var y = $('#setting-friendly-name').val().length;
	
	var m = $('#attroney-upload').val().length;
	var n = $('#attroney-friendly-name').val().length;
	
    if(x > 0 && y>0){
	    $('#setting-upload-save').prop('disabled', false);
	}else{
	    $('#setting-upload-save').prop('disabled', true);
	}

    if(m > 0 && n>0){
	    $('#attroney-upload-save').prop('disabled', false);
	}else{
	    $('#attroney-upload-save').prop('disabled', true);
	}

}

function Arronyupload(){
    $("#modal-attrony").modal();
	$("#attroney-friendly-name").val('');
	$("#attroney-upload").val('');
	
}

function AttronyDoc(id){
	//alert(id);
	
		$.ajaxFileUpload({
			url:'documents/document-upload.php?filename=attroney-upload&p1='+id+'&p2=root',
			secureuri:false,
			fileElementId:'attroney-upload',
			success: function (data, status){
				//alert('here');
				if(status == 'success'){
					ModifyAttroney(); 
						
				  }
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)
			
}


function ModifyAttroney(){

    var post = $('#attrony-document-form').serializeAll();
    $.post('classes/document.class.php', post, function (data) {
        if (data.match('success') !== null) {
			getAttroneyDoc();
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

function getAttroneyDoc(){
	        
	      // $('#attroneyDoc').html('<li>   Loading...  </li>');
	        var id = $('#bond-id').val();
			var clientid = CLIENT_ID ;
			$.post('classes/document.class.php',{id:id,action:'getattroney',clientid:clientid}).done(function(data){
				    $('#attroneyDoc').html(data);
				})

}



function Settingupload(){
    $("#modal-upload").modal();
}


//save doc by ajax 
function saveDoc(id){

	
		$.ajaxFileUpload({
			url:'documents/document-upload.php?filename=setting-upload&p1='+id+'&p2=root',
			secureuri:false,
			fileElementId:'setting-upload',
			success: function (data, status){
				//alert('here');
				if(status == 'success'){
					ModifySetting(); 
						
				  }
			  
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)
			
}

function ModifySetting(){

    var post = $('#setting-document-form').serializeAll();
    $.post('classes/document.class.php', post, function (data) {
        if (data.match('success') !== null) {
			getSettingDoc();
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

function getSettingDoc(){
	      // $('#settingDoc').html('<li>  Loading...  </li>');
	        var id = $('#bond-id').val();
			var clientid = CLIENT_ID ;
			$.post('classes/document.class.php',{id:id,action:'getsetting',clientid:clientid}).done(function(data){
				    $('#settingDoc').html(data);
				})

}



