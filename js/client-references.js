$(document).ready(function() {
        $('#references-label').html('<i class="icon-list-alt"></i> References');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

	    $("#references-add").click(function(e){
			e.preventDefault();
			
            
            $("#record-delete").hide();
			
            $("#reference-delete").prop('checked', false);

            $("#reference-last").val('');
            $("#reference-first").val('');
            $("#reference-middle").val('');
            $('#reference-address').val('');
            $('#reference-city').val('');
            $('#reference-state').val('');
            $('#reference-zip').val('');
            $('.latitude').val('');
            $('.longitude').val('');
            $("#reference-phone1type").select2('val', '');
            $("#reference-phone1").val('');
            $("#reference-phone2type").select2('val', '');
            $("#reference-phone2").val('');
            $("#reference-phone3type").select2('val', '');
            $("#reference-phone3").val('');
            $("#reference-phone4type").select2('val', '');
            $("#reference-phone4").val('');
            $("#reference-relation").val('');
            
           
            $("#document-indemnitor").hide();
             $("#reference-delete").iCheck('uncheck');
			 $('#reference-indemnify').iCheck('uncheck');
			 $('#reference-caller').iCheck('uncheck');
			$('#indemnifyCheck').find('.icheckbox_square-blue').removeClass('checked');
            $('input[name=reference-isvalid]').val(0);
            $('input[name=reference-id]').val(-1);


            $('#list-actions').hide();
            $('.streets-valid').hide();
            $('#references-list').hide();
            $('#references-label').html('<i class="icon-list-alt"></i> References - Add');
            $('#references-box').show();

            var x=$("#reference-address").offset().left;
            var y=$("#reference-address").offset().top+30;
            $(".smarty-ui").css({left:x,top:y});

            $("#reference-last").focus();
			
			$("#supplement-doc").hide(); 

		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyReference('delete');
		});
		

        $("#reference-indemnify").change(function() {
            var flag = $('#reference-indemnify').is(":checked");
            if (flag==true){
                $('#supplement-indemnitor').show();
                $('#document-indemnitor').show();
				$('#indemnifyCheck').find('.icheckbox_square-blue').addClass('checked');
				
            } else{
                $('#supplement-indemnitor').hide();
                $('#document-indemnitor').hide();
				$('#indemnifyCheck').find('.icheckbox_square-blue').removeClass('checked');
            }
        });

});

function LoadReference(id){
    var row = REFERENCES_SOURCE.filter( function(item){return (item.id==id);} );

    var last  = row[0]['last'];
    var first = row[0]['first'];
    var middle = row[0]['middle'];
    var address = row[0]['address'];
    var city = row[0]['city'];
    var state = row[0]['state'];
    var zip = row[0]['zip'];
    var latitude = row[0]['latitude'];
    var longitude = row[0]['longitude'];
    var isvalid = row[0]['isvalid'];
    var phone1type = row[0]['phone1type'];
    var phone1 = row[0]['phone1'];
    var phone2type = row[0]['phone2type'];
    var phone2 = row[0]['phone2'];
    var phone3type = row[0]['phone3type'];
    var phone3 = row[0]['phone3'];
    var phone4type = row[0]['phone4type'];
    var phone4 = row[0]['phone4'];
    var relation = row[0]['relation'];
	var caller = row[0]['caller'];
    var indemnify = row[0]['indemnify'];
	var application = row[0]['application'];
	
	
	$("#indemnify-client-id").val(id);
	$("#record-delete").show();

    $("#reference-delete").prop('checked', false);
    $("#reference-last").val(last);
    $("#reference-first").val(first);
    $("#reference-middle").val(middle);
    $('#reference-address').val(address);
    $('#reference-city').val(city);
    $("#reference-state").select2('val', state);
    $('#reference-zip').val(zip);
    $('.latitude').val(latitude);
    $('.longitude').val(longitude);
    $('input[name=reference-isvalid]').val(isvalid);
    $("#reference-phone1type").select2('val', phone1type);
    $("#reference-phone1").val(phone1);
    $("#reference-phone2type").select2('val', phone2type);
    $("#reference-phone2").val(phone2);
    $("#reference-phone3type").select2('val', phone3type);
    $("#reference-phone3").val(phone3);
    $("#reference-phone4type").select2('val', phone4type);
    $("#reference-phone4").val(phone4);
    $("#reference-relation").val(relation);

    if(caller == 1){
		$("#reference-caller").iCheck('check').trigger('click');
		//$('#indemnifyCheck').find('.icheckbox_square-blue').addClass('checked');
	}else{
		 $('#reference-indemnify').iCheck('uncheck');
		// $('#indemnifyCheck').find('.icheckbox_square-blue').removeClass('checked');
	}

	if(indemnify == 1){
		$("#reference-indemnify").iCheck('check').trigger('click');
		$('#indemnifyCheck').find('.icheckbox_square-blue').addClass('checked');
        $("#supplement-indemnitor").show();
        $("#document-indemnitor").show();
	}else{
		 $('#reference-indemnify').iCheck('uncheck');
		 $('#indemnifyCheck').find('.icheckbox_square-blue').removeClass('checked');
	   // $("#reference-indemnify").prop('checked',false);
        $("#supplement-indemnitor").hide();
        $("#document-indemnitor").hide();
	}
	
	if(application == '' || application == null ){
	   $("#supplement-doc").hide();  
	}else{
		$("#supplement-doc").show();
	}

	
    $('input[name=reference-id]').val(id);
    $('#supplement-id').val(id);
    $('#list-actions').hide();
    if (isvalid==1){
        $('.streets-valid').show();
    } else {
        $('.streets-valid').hide();
    }
    $('#references-list').hide();
    $('#references-label').html('<i class="icon-list-alt"></i> References - Edit');
    $('#references-box').show();

    x=$("#reference-address").offset().left;
    y=$("#reference-address").offset().top+30;
    $(".smarty-ui").css({left:x,top:y});

    $("#reference-last").focus();

}

function ReferenceCancel(){
    $('#references-box').hide();
    $('#list-actions').show();
    $('#references-list').show();
    $('#references-label').html('<i class="icon-list-alt"></i> References');
}

function ReferenceSave(){
    var flag = $('#reference-delete').is(":checked");
    if (flag==true){
        $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
        $("#jqxWindow-confirm").jqxWindow('open');
        $('#jqxWindow-confirm').jqxWindow('focus');
    } else {
        $('#reference-save').button('loading');
        var id = $("#reference-id").val();
        if (id==-1){
            ModifyReference('add');
        } else {
            ModifyReference('edit');
        }
    }
}

function ModifyReference(type){
    var post = $('#reference-form').serialize();
    $.post('classes/client_reference.class.php', post, function (data) {
        if (data.match('success') !== null) {
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#reference-save').button('reset');
            }
        }
    });
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

	var x = $('#indemnify-upload').val().length;
	var y = $('#indemnify-friendly-name').val().length;
    var z = $('#supplement-upload').val().length;

    if(x > 0 && y>0){
	    $('#indemnify-upload-save').prop('disabled', false);
	}else{
	    $('#indemnify-upload-save').prop('disabled', true);
	}
	
	 if(z > 0 ){
	    $('#supplement-upload-save').prop('disabled', false);
	 }else{
	    $('#supplement-upload-save').prop('disabled', true);
	 }
}

function nameValidate(){
	
	var x = $('#indemnify-upload').val().length;
	var y = $('#indemnify-friendly-name').val().length;
	
	
    if(x > 0 && y>0){
	    $('#indemnify-upload-save').prop('disabled', false);
	}else{
	    $('#indemnify-upload-save').prop('disabled', true);
	}
}

function Indemnifyupload(){
    $("#modal-indemnify").modal();
	$("#indemnify-friendly-name").val('');
	$("#indemnify-upload").val('');
	
}
function Supplementupload(){
    $("#modal-supplement").modal();
	$("#supplement-upload").val('');
    $('#supplement-upload-save').prop('disabled', true);

	
}

function IndemnifyDoc(id){
	
		$.ajaxFileUpload({
			url:'documents/document-upload.php?filename=indemnify-upload&p1='+id+'&p2=root',
			secureuri:false,
			fileElementId:'indemnify-upload',
			success: function (data, status){
				//alert('here');
				if(status == 'success'){
					ModifyIndemnify(); 
						
				  }
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)
			
}


function SupplementDoc(id){
	
		$.ajaxFileUpload({
			url:'documents/document-upload.php?filename=supplement-upload&p1='+id+'&p2=',
			secureuri:false,
			fileElementId:'supplement-upload',
			success: function (data, status){
				//alert('here');
				if(status == 'success'){
					ModifySupplement(); 
						
				  }
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)
			
}


function ModifyIndemnify(){

    var post = $('#indemnify-document-form').serializeAll();
    $.post('classes/document.class.php', post, function (data) {
        if (data.match('success') !== null) {
			getIndemnifyDoc();
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


function ModifySupplement(){

    var post = $('#supplement-document-form').serializeAll();
	alert(post);
    $.post('classes/document.class.php', post, function (data) {
        if (data.match('success') !== null) {
			getSupplementDoc();
        } else {
            $('#modal-title-error').html('System');
            $('#modal-body-error').html(data);
            $("#modal-error").modal();
            
        }
    });
}


function getIndemnifyDoc(){
	        
	      // $('#attroneyDoc').html('<li>   Loading...  </li>');
	        var id = $('#reference-id').val();
			var clientid = $('#client-id').val();
			$.post('classes/document.class.php',{id:id,action:'getindemnify',clientid:clientid}).done(function(data){
				    $('#indemnifyDoc').html(data);
				})

}
function getSupplementDoc(){
	        
	      // $('#attroneyDoc').html('<li>   Loading...  </li>');
	        var id = $('#reference-id').val();
			var clientid = $('#client-id').val();
			$.post('classes/document.class.php',{id:id,action:'getsupplement',clientid:clientid}).done(function(data){
				    $('#supplementDoc').html(data);
				})

}
