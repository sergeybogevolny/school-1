$(document).ready(function() {

        $('#notes-label').html('<i class="icon-list-alt"></i> Notes');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

	   $("#notes-add").click(function(e){
			e.preventDefault();

            $("#record-delete").hide();
            $("#note-comment").val('');
            $("#note-subject").val('');
            $("#note-delete").attr('checked', false);
            $('input[name=note-id]').val(-1);

            $('#list-actions').hide();
            $('#notes-list').hide();
            $('#notes-label').html('<i class="icon-list-alt"></i> Notes - Add');
            $('#notes-box').show();
            $("#note-comment").focus();

		});

        $("#note-cancel").click(function(){
            $('#notes-box').hide();
            $('#notes-label').html('<i class="icon-list-alt"></i> Notes');
            $('#list-actions').show();
            $('#notes-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyNote('delete');
		});

        $("#note-form").validate({
	        submitHandler: function() {
                var flag = $('#note-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#note-save').button('loading');
                    var id = $("#note-id").val();
                    if (id==-1){
                        ModifyNote('add');
                    } else {
                        ModifyNote('edit');
                    }
                }
            },
        });

});

function LoadNote(id){
    var row = NOTES_SOURCE.filter( function(item){return (item.id==id);} );

    var comment = row[0]['comment'];
    var subject = row[0]['subject'];
	console.log(row[0]);
	alert(comment);
     alert(subject);
    $("#record-delete").show();
    $("#note-delete").attr('checked', false);
    $("#note-comment").val(comment);
	
    $("#note-subject").val(subject);
    $('input[name=note-id]').val(id);

    $('#list-actions').hide();
    $('#notes-list').hide();
    $('#notes-label').html('<i class="icon-list-alt"></i> Notes - Edit');
    $('#notes-box').show();
    $("#note-comment").focus();

}


function ModifyNote(type){
    var post = $('#note-form').serialize();
    $.post('classes/client_note.class.php', post, function (data) {
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
                $('#note-save').button('reset');
            }
        }
    });
}

function clientnoteedit(id){
            $("#record-delete").hide();
            $("#note-delete").attr('checked', false);
            $('input[name=note-id]').val(id);

            $('#list-actions').hide();
            $('#notes-list').hide();
            $('#notes-label').html('<i class="icon-list-alt"></i> Notes - Edit');
            $('#notes-box').show();
            $("#note-comment").focus();
            
			$.get('classes/client_note.class.php',{noteid :id}).done(function(data){
				
				       
            var jsonData = JSON.parse(data);
            for (var i in jsonData) {
                var rec = jsonData[i];
				console.log(rec);
				$("#note-comment").val(rec.comment);
				$("#note-subject").val(rec.subject);
			}

				})  



}

$(function () {
    'use strict';

    $.ajax({ url: 'classes/valuelist.class.php', type: "GET", data:{valuelist:"clientsubject"}, dataType: 'json'
    }).done(function (source) {

        var chargesArray = $.map(source, function (value, key) { return { value: value, data: key }; }),
            charges = $.map(source, function (value) { return value; });

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
