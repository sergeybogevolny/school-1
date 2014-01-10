$(document).ready(function() {

    var data = new Array();
    var ffolders = [ "{Root}", "Application", "Legal", "Premium Finance", "{Trash}" ];
    var rfolders = [ "root", "application", "legal", "premium", "trash"];
    var k = 0;
            for (var i = 0; i < ffolders.length; i++) {
                var row = {};
                row["ffolders"] = ffolders[k];
                row["rfolders"] = rfolders[k];
                data[i] = row;
                k++;
    }
    var sfolder =
        {
            localdata: data,
            datatype: "array"
        };
    var dataAdapter = new $.jqx.dataAdapter(sfolder);
    $("#jqxWindow-document").jqxWindow({
            width: 290, height: 500, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

    $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

    $("#jqxDropDownList-directory-folder").jqxDropDownList({
          source: dataAdapter, selectedIndex: 0, width: '200', height: '25', displayMember: 'ffolders', valueMember: 'rfolders', theme: 'metro' });

    $("#jqxDropDownList-document-folder").jqxDropDownList({
          source: dataAdapter, width: '200', height: '25', displayMember: 'ffolders', valueMember: 'rfolders', theme: 'metro' });

    $("#jqxDropDownList-directory-folder").on('change', function (event){
        var args = event.args;
        var item = args.item;
        var value = item.value;
        $("#dir-root").hide();
        $("#dir-application").hide();
        $("#dir-legal").hide();
        $("#dir-premium").hide();
        $("#dir-trash").hide();
        switch (value){
            case 'root':
                $("#dir-root").show();
                break;
            case 'application':
                $("#dir-application").show();
                break;
            case 'legal':
                $("#dir-legal").show();
                break;
            case 'premium':
                $("#dir-premium").show();
                break;
            case 'trash':
                $("#dir-trash").show();
                break;
         }
    });

     $('#jqxDropDownList-document-folder').on('change', function (event){
        var args = event.args;
        var item = args.item;
        var value = item.value;
        var type = $('#document-type').html();
        var folder = $('#current-folder').val();
        if (folder!='root'){
            $('#modify-mugshot').hide();
        } else {
          if (value=='root' && type.match('Image')!=null){
              $('#modify-mugshot').show();
          } else {
              $('#modify-mugshot').hide();
          }
        }
     });

    $("#document-cancel").click(function(){
        $('#jqxWindow-document').jqxWindow('close');
	});

    $("#confirm-no").click(function(){
        $("#jqxWindow-confirm").jqxWindow('close');
	});

    $("#confirm-yes").click(function(){
        var type = $('#confirm-type').val();
        $('#document-save').button('loading');
        ModifyDocument(type);
	});

    $("#document-form").validate({
	    submitHandler: function() {
            var cfolder = $('#current-folder').val();
            var folder = $("#jqxDropDownList-document-folder").val();
            if (folder!=cfolder){
                $('input[name=confirm-type]').val('move');
                $("#jqxWindow-confirm").jqxWindow('setTitle', 'Move Document?')
                $("#jqxWindow-confirm").jqxWindow('open');
                $('#jqxWindow-confirm').jqxWindow('focus');
            } else {
                var cmugshot = $('#current-mugshot').val();
                var bmugshot = $('#document-mugshot').is(":checked");
                var mugshot = ( bmugshot == true ? 1 : 0);
                if (mugshot!=cmugshot){
                    $('input[name=confirm-type]').val('mugshot');
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Modify Mugshot?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#document-save').button('loading');
                    ModifyDocument('edit');
                }
            }
        },
    });




    var id = $('input[name=client-id]').val();
    var ichange = 0;
    var files = new Array();
    var ifile = 0;

    if($('.plupload').length > 0){
		$(".plupload").each(function(){
			var $el = $(this);
			$el.pluploadQueue({
				runtimes : 'html5',
				url : 'documents/plupload.php?id='+id,
				max_file_size : '10mb',
				chunk_size : '1mb',
				unique_names : false,
				resize : {width : 320, height : 240, quality : 90},
				filters : [
            	{title : "Image files", extensions : "gif,bmp,jpg,jpeg,tif,tiff,png"},
                {title : "Document files", extensions : "txt,rtf,doc,docx,xls,xlsx,pdf"}
				],
                preinit : {

        		},

        		init : {

                    FileUploaded: function(up, file, info) {
                        var obj = JSON.parse(info.response);
                        //var uploadfilename = file.name;
                        var filename = obj.cleanFileName;

                        //alert(uploadfilename);
                        //alert(cleanfilename);

                        files[ifile] = filename;
                        ifile = ifile + 1;
                        //alert(filename);

                    },

        			StateChanged: function(up) {
        				if (ichange==1){
                            //alert('sc');
                            for (var i in files) {

                                var file = files[i];
                                var type = "";
                                var arr = file.split(".");
                                var arr1 = file.split("\\");
                                if (arr[1] == "gif"){
                                    type = 'Image';
                                } else if (arr[1] == "bmp"){
                                    type = 'Image';
                                } else if (arr[1] == "jpeg" || arr[1] == "jpg"){
                                    type = 'Image';
                                } else if (arr[1] == "tif" || arr[1] == "tiff"){
                                    type = 'Image';
                                } else if (arr[1] == "png") {
                                    type = 'Image';
                                } else if (arr[1] == "txt" || arr[1] == "rtf"){
                                    type = 'Document';
                                } else if (arr[1] == "doc" || arr[1] == "docx"){
                                   type = 'Document';
                                } else if (arr[1] == "xls" || arr[1] == "xlsx") {
                                    type = 'Document';
                                } else if (arr[1] == "pdf") {
                                   type = 'Document';
                                }

                                $.ajax({
                                    type : 'POST',
                                    url : 'classes/client_document.class.php',
                                   dataType : 'html',
                                    async : false,
                                    data: { "document_add": true, "client_id": id, "file": file, "type": type },
                                    success : function(result){
                                        //alert(result);
                                    }
                                });
                            }

                            location.reload();
                        } else {
                            ichange = ichange + 1
                        }
        			}

        		}
			});
			$(".plupload_header").remove();
			var upload = $el.pluploadQueue();
			if($el.hasClass("pl-sidebar")){
				$(".plupload_filelist_header,.plupload_progress_bar,.plupload_start").remove();
				$(".plupload_droptext").html("<span>Drop files to upload</span>");
				$(".plupload_progress").remove();
				$(".plupload_add").text("Or click here...");
			} else {
				$(".plupload_progress_container").addClass("progress").addClass('progress-striped');
				$(".plupload_progress_bar").addClass("bar");
				$(".plupload_button").each(function(){
					if($(this).hasClass("plupload_add")){
						$(this).attr("class", 'btn pl_add btn-primary').html("<i class='icon-plus-sign'></i> "+$(this).html());
					} else {
						$(this).attr("class", 'btn pl_start btn-success').html("<i class='icon-cloud-upload'></i> "+$(this).html());
					}
				});
			}

		});
    }

    $(".adoc").click(function(e){
        i=$(this).data("value");
        LoadDocument(i);
    });

    $(".tdoc").click(function(e){
        i=$(this).data("value");
        LoadDocument(i);
    });

    $('#document-mugshot').click(function() {
        var bmugshot = $('#document-mugshot').is(":checked");
        if (bmugshot==true){
            $("#jqxDropDownList-document-folder").jqxDropDownList({ disabled: true });
        } else {
            $("#jqxDropDownList-document-folder").jqxDropDownList({ disabled: false });
        }
    });

});

function LoadDocument(id){
    $.ajax({
        type: "GET",
        url: "classes/client_document.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        var status = $response.filter('#status').text();
        if (status != 'FAIL') {
            var folder = $response.filter('#folder').text();
            var file = $response.filter('#file').text();
            var type = $response.filter('#type').text();
            var description = $response.filter('#description').text();
            var mugshot = $response.filter('#mugshot').text();
            var cid = $response.filter('#client_id').text();
            $("#document-name").html('<b>'+file+'</b>');
            $("#document-type").html('<strong>'+type+'</strong>');
            $("#document-description").val(description);
            $("#jqxDropDownList-document-folder").jqxDropDownList('clearSelection');
            $("#jqxDropDownList-document-folder").jqxDropDownList('val', folder);
            if (mugshot==1){
                $("#document-mugshot").prop('checked', true);
                $("#jqxDropDownList-document-folder").jqxDropDownList({ disabled: true });
            } else {
                $("#document-mugshot").prop('checked', false);
                $("#jqxDropDownList-document-folder").jqxDropDownList({ disabled: false });
            }
            $('input[name=current-file]').val(file);
            $('input[name=current-folder]').val(folder);
            $('input[name=current-mugshot]').val(mugshot);
            $('input[name=document-id]').val(id);
            $('input[name=client-id]').val(cid);
            $('input[name=document_modify]').val('');
            $('#jqxWindow-document').jqxWindow('setTitle', 'Documents - Edit');
            $('#jqxWindow-document').jqxWindow('open');
            $("#document-description").focus();
            }
        }
    });

}

function ModifyDocument(type){
    $('input[name=document_modify]').val(type);
    var post = $('#document-form').serialize();
    //alert(post);
    $.post('classes/client_document.class.php', post, function (data) {
        //alert(data);
        if (data.match('success') !== null) {
            $('#jqxWindow-document').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            $('#document-save').button('reset');
        }
    });


}

