$(document).ready(function() {
        $('#detail-label').html('Detail');
        $('#comment-label').html('Comment');
        $('#comment-box-actions').hide();
		$('#bin-save').prop('disabled', true);

        $("#actions-delete-recorded").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Forfeiture - Delete');
            $('#forfeiture-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-questioned").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Forfeiture - Delete');
            $('#forfeiture-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-charged").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Forfeiture - Delete');
            $('#forfeiture-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-documented").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Forfeiture - Delete');
            $('#forfeiture-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-delete-disposed").click(function(event){
			event.preventDefault();
            $('#modal-title').html('Forfeiture - Delete');
            $('#forfeiture-action').val('delete');
            $("#modal-confirm").modal();
		});

        $("#actions-question").click(function(event){
			event.preventDefault();
            Questionvalidate();
            $("#modal-question").modal();
		});

        $("#actions-charge").click(function(event){
			event.preventDefault();
            var prefix = FORFEITURE_PREFIX;
            var serial = FORFEITURE_SERIAL;
            $.get( "classes/forfeiture.class.php", { chargepower: 1, prefix: prefix, serial: serial } )
			.done(function( data ) {
				var rec = JSON.parse(data);
				console.log(rec.id);
				if(rec.id == -1){
				    $('#charge-status').html('<p>Power has not been identified.</p>');
				}else{
				    $('#power-id').val(rec.powerid);
				    $('#charge-status').html('<div id="chargedvalid" style="display: block;"><label for="textfield" class="control-label">Charged Agent</label><input type="text" name="forfeiture-chargedagent" id="forfeiture-chargedagent" class="input-large span3" readonly value="'+rec.agent+'"><input type="hidden" name="forfeiture-chargedagent-id" id="forfeiture-chargedagent-id" value="'+rec.id+'"></div>');
                    $('#charge-save').prop('disabled', false);
                }
            });
            $("#modal-charge").modal();
		});

        $("#actions-revert").click(function(event){
			event.preventDefault();
            $("#modal-revert").modal();
		});

        $("#actions-document").click(function(event){
			event.preventDefault();
            Documentvalidate();
            $("#modal-document").modal();
		});

        $("#actions-dispose").click(function(event){
			event.preventDefault();
            Disposevalidate();
            $("#modal-dispose").modal();
		});

        $('#question-save').on('click', function(event) {
            event.preventDefault();
            ModifyForfeiture('question');
            $('#modal-question').modal('hide');
        });

        $('#charge-save').on('click', function(event) {
            event.preventDefault();
            ModifyForfeiture('charge');
            $('#modal-charge').modal('hide');
        });

        $('#revert-save').on('click', function(event) {
            event.preventDefault();
            ModifyForfeiture('revert');
            $('#modal-revert').modal('hide');
        });

        $('#document-save').on('click', function(event) {
            event.preventDefault();
            ModifyForfeiture('document');
            $('#modal-document').modal('hide');
        });

        $('#dispose-save').on('click', function(event) {
            event.preventDefault();
            ModifyForfeiture('dispose');
            $('#modal-dispose').modal('hide');
        });

        $('#detail-save').on('click', function(event) {
            event.preventDefault();
            ModifyForfeiture('detail');
        });

        $('#bin-save').on('click', function(event) {
            event.preventDefault();
            ModifyForfeiture('bin');
        });

        $("#detail-cancel").click(function(){
            $('#detail-box').hide();
            $('#detail-label').html('Detail');
            $('#detail-list-actions').show();
            $('#detail-list').show();
            $('#comment-view').show();
		});

        $("#comment-cancel").click(function(){
            $('#comment-box-actions').hide();
            $('#comment-box').hide();
            $('#comment-label').html('Comment');
            $('#comment-list-actions').show();
            $('#comment-list').show();
            $('#detail-view').show();
		});

        $('#forfeiture-questionedagent-select').change(function(){
    		var id = $(this).find(':selected')[0].id;
    		$('#forfeiture-questionedagent-id').val(id);
    	});

        var datepickerreceived = $('#detail-received').datepicker().on('changeDate', function(ev) {datepickerreceived.hide();}).data('datepicker');
        var datepickerforfeited = $('#detail-forfeited').datepicker().on('changeDate', function(ev) {datepickerforfeited.hide();}).data('datepicker');
        var datepickeranswered = $('#forfeiture-answerdate').datepicker().on('changeDate', function(ev) {datepickeranswered.hide();}).data('datepicker');

        $("#detail-hearing").datetimepicker({
            format: "dd MM yyyy - HH:ii P",
            showMeridian: true,
            autoclose: true,
            todayBtn: true
        });

        $("#detail-amount").autoNumeric('init');

		$('#bin-name').bind('keypress', function(e) {
		    Binvalidate();
			   console.log( e.which );
				var k = e.which;
				var ok = k >= 65 && k <= 90 || // A-Z
					k >= 97 && k <= 122 || // a-z
					k >= 48 && k <= 57 || k == 8 || k == 46; // 0-9
				if (!ok){
					e.preventDefault();
				}
		});

});

function upload(){
    $("#modal-upload").modal();
}

function LoadDetail(id){
    var recorded = FORFEITURE_RECORDED;
    var received = FORFEITURE_RECEIVED;
    var civilcasenumber = FORFEITURE_CIVILCASENUMBER;
    var forfeited = FORFEITURE_FORFEITED;
    var county = FORFEITURE_COUNTY;
    var defendant = FORFEITURE_DEFENDANT;
    var amount = FORFEITURE_AMOUNT;
    var prefix = FORFEITURE_PREFIX;
    var serial = FORFEITURE_SERIAL;
    var questioned = FORFEITURE_QUESTIONED;
    var questionedagent = FORFEITURE_QUESTIONEDAGENT;
    var charged = FORFEITURE_CHARGED;
    var postingagent = FORFEITURE_POSTINGAGENT;
    var documented = FORFEITURE_DOCUMENTED;
    var documentedlevel = FORFEITURE_DOCUMENTEDLEVEL;
    var hearing = FORFEITURE_HEARING;
    var disposed =  FORFEITURE_DISPOSED;
    var disposedreason = FORFEITURE_DISPOSEDREASON;
    var power = FORFEITURE_POWER;

	$("#detail-recorded").val(recorded);
    $("#detail-received").val(received);
    $("#detail-civilcasenumber").val(civilcasenumber);
    $("#detail-forfeited").val(forfeited);
    $("#detail-county").val(county);
    $("#detail-amount").val(amount);
    $("#detail-prefix").val(prefix);
    $("#detail-serial").val(serial);
    $("#detail-questioned").val(questioned);
    $("#detail-questionedagent").val(questionedagent);
    $("#detail-charged").val(charged);
    $("#detail-postingagent").val(postingagent);
    $("#detail-power").val(power);
    $("#detail-documented").val(documented);
    $("#detail-documentedlevel").val(documentedlevel);
    $("#detail-hearing").val(hearing);

    //$("#personal-phone1type").select2('val',phone1type);
    $('input[name=detail-id]').val(id);

    $('#detail-list-actions').hide();
    $('#detail-list').hide();
    $('#comment-view').hide();

    $('#detail-label').html('Detail - Edit');
    $('#detail-box').show();

    Detailvalidate();

    //$("#personal-company").focus();

}

function Detailvalidate(){
    var v = $('#detail-received').val().length;
    var w = $("#detail-civilcasenumber").val().length;
    var x = $("#detail-forfeited").val().length;
    var y = $("#detail-county").val().length;
    var z = $("#detail-amount").val().length;
    if(v > 0 && w > 0 && x > 0 && y > 0 && z>0){
	    $('#detail-save').prop('disabled', false);
	}else{
	    $('#detail-save').prop('disabled', true);
	}
}

function Questionvalidate(){
    var z = $('#forfeiture-questionedagent-select').val().length;
    if(z>0){
	    $('#question-save').prop('disabled', false);
	}else{
	     $('#question-save').prop('disabled', true);
	}
}

function Documentvalidate(){
    var y = $("#forfeiture-answerdate").val().length;
    var z = $("#forfeiture-answer-file").val().length;
    if(y > 0 && z>0){
	    $('#document-save').prop('disabled', false);
	}else{
	    $('#document-save').prop('disabled', true);
	}
}

function Disposevalidate(){
    var y = $('#forfeiture-dispose-file').val().length;
	var z = $('#forfeiture-disposereason-select').val().length;
	
    if(z>0 && y>0){
	    $('#dispose-save').prop('disabled', false);
	}else{
	    $('#dispose-save').prop('disabled', true);
	}
}

function LoadComment(id){
    //var comment = FORFEITURE_COMMENT;
    var comment = $("#comment-value").html();
    CKEDITOR.instances.editor.setData(comment);
    $('input[name=comment-id]').val(id);

    $('#comment-list-actions').hide();
    $('#comment-list').hide();
    $('#detail-view').hide();

    $('#comment-box-actions').show();
    $('#comment-label').html('Comment - Edit');
    $('#comment-box').show();

    //$("#personal-company").focus();

}

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

function ModifyForfeiture(type){
    var post = '';
    switch (type){
        case 'detail':
            post = $('#detail-form').serialize();
            break;
        case 'question':
            post = $('#question-form').serialize();
            break;
        case 'charge':
            post = $('#charge-form').serialize();
            break;
        case 'revert':
            post = $('#revert-form').serialize();
            break;
        case 'document':
            post = $('#document-form').serializeAll();
            break;
        case 'dispose':
            post = $('#dispose-form').serializeAll();
            break;
        case 'bin':
            post = $('#document-bin-form').serializeAll();
            break;
    }
    if (post==''){
        return;
    }

    $.post('classes/forfeiture.class.php', post, function (data) {
        if (data.match('success') !== null) {
			location.reload();
        } else {
            alert('error');

/*            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='personal'){
                $('#personal-save').button('reset');
            } else {
                //$('#transaction-save').button('reset');
            }
*/
        }
    });
}

function saveFile(id){
		$.ajaxFileUpload({
			url:'documents/document-upload.php?p1=forfeitures&p2='+id+'&filename=forfeiture-answer-file',
			secureuri:false,
			fileElementId:'forfeiture-answer-file',
			dataType: 'json',
			success: function (data, status){
				console.log(status);
				//document.getElementById("isForm").submit();
				if(typeof(data.error) != 'undefined'){
						if(data.error != ''){
							alert(data.error);
						}else{
						    alert(msg); // returns location of uploaded file
						}
				  }
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)

}

function saveBinDoc(id){
		$.ajaxFileUpload({
			url:'documents/document-upload.php?p1=forfeitures&p2='+id+'&filename=bin-upload',
			secureuri:false,
			fileElementId:'bin-upload',
			dataType: 'json',
			success: function (data, status){
				console.log(status);
				//document.getElementById("isForm").submit();
				if(typeof(data.error) != 'undefined'){
						if(data.error != ''){
							alert(data.error);
						}else{
						    alert(msg); // returns location of uploaded file
						}
				  }
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)

}

function Binvalidate(){
	var x = $('#bin-name').val().length;
	var y = $('#bin-upload').val().length;

    if(x > 0 && y>0){
	    $('#bin-save').prop('disabled', false);
	}else{
	    $('#bin-save').prop('disabled', true);
	}
}


function saveDisposeDoc(id){
		$.ajaxFileUpload({
			url:'documents/document-upload.php?p1=forfeitures&p2='+id+'&filename=forfeiture-dispose-file',
			secureuri:false,
			fileElementId:'forfeiture-dispose-file',
			dataType: 'json',
			success: function (data, status){
				console.log(status);
				//document.getElementById("isForm").submit();
				if(typeof(data.error) != 'undefined'){
						if(data.error != ''){
							alert(data.error);
						}else{
						    alert(msg); // returns location of uploaded file
						}
				  }
			  },
			error: function (data, status, e){
					alert(e);
					}
				}
			)

}
