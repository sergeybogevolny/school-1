$(document).ready(function() {
      $('#mugshot-upload-save').prop('disabled', true);
});


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


function Doc1Validate(){

	var x = $('#mugshot-upload').val().length;


    if(x > 0 ){
	    $('#mugshot-upload-save').prop('disabled', false);
	}else{
	    $('#mugshot-upload-save').prop('disabled', true);
	}
	

}


function Mugshotupload(){
    $("#modal-mugshot").modal();
	$("#mugshot-upload").val('');
    $('#mugshot-upload-save').prop('disabled', true);

	
}

function MugshotDoc(id){
	
		$.ajaxFileUpload({
			url:'documents/document-upload.php?filename=mugshot-upload&p1='+id+'&p2=root',
			secureuri:false,
			fileElementId:'mugshot-upload',
			success: function (data, status){
				//alert('here');
				if(status == 'success'){
					ModifyMugshot(); 
						
				  }
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)
			
}


function ModifyMugshot(){

    var post = $('#mugshot-document-form').serializeAll();
    $.post('classes/document.class.php', post, function (data) {
        if (data.match('success') !== null) {
			getMugshotDoc();
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

function getMugshotDoc(){  
	        
	        $('#mugshot-img').html('<img src="img/spinnerLarge.gif" style="width:56px;">');
	        var id = $('#mugshot-client-id').val();
			var clientid = $('#mugshot-client-id').val();
			$.post('classes/document.class.php',{id:id,action:'getmugshot',clientid:clientid}).done(function(data){
					       // $('#mugshot-img').html('<img src="img/loading.gif" style="width:56px;">');
							
                    setTimeout(function(){$('#mugshot-img').html('<img src="documents/'+id+'/root/'+data+'" style="width:56px; height:56px;border: 2px  solid #0099FF;">');},2000);				    
				})

}
