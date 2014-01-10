$(document).ready(function() {

        if ($("#directory-type").length > 0) {
			function formatImages(option) {
				var img = "directory_list_" + option.text.toLowerCase() + ".png";
				return "<img style='padding-right:10px;' src='img/" + img + "'>" + option.text;
			}
			$("#directory-type").select2({
				formatResult: formatImages,
				formatSelection:formatImages,
				escapeMarkup: function(m) { return m; }
			});
	    }

        $('#directory-label').html('<i class="glyphicon-adress_book"></i> Directory');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

		$("#directory-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#directory-delete").attr('checked', false);

            $("#directory-type").select2('val', 'person');
            $("#directory-name").val('');
            $('#directory-address').val('');
            $('#directory-city').val('');
            $('#directory-state').val('');
            $('#directory-zip').val('');
            $('.latitude').val('');
            $('.longitude').val('');
            $("#directory-phone1type").select2('val', '');
            $('input[name=directory-phone1]').val('');
            $("#directory-phone2type").select2('val', '');
            $('input[name=directory-phone2]').val('');
            $("#directory-phone3type").select2('val', '');
            $('input[name=directory-phone3]').val('');
            $('input[name=directory-email]').val('');
            $('input[name=directory-website]').val('');
            $('input[name=directory-isvalid]').val(0);
            $('input[name=directory-id]').val(-1);

            $('#list-actions').hide();
            $('#directory-list').hide();
            $('.streets-valid').hide();
            $('#directory-label').html('<i class="glyphicon-adress_book"></i> Directory - Add');
            $('#directory-box').show();

            var x=$("#directory-address").offset().left;
            var y=$("#directory-address").offset().top+30;
            $(".smarty-ui").css({left:x,top:y});

            $("#directory-name").focus();
		});

        $("#directory-cancel").click(function(){
            location.reload();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyDirectory('delete');
		});

        $("#directory-form").validate({
	        submitHandler: function() {
                var flag = $('#directory-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#directory-save').button('loading');
                    var id = $("#directory-id").val();
                    if (id==-1){
                        ModifyDirectory('add');
                    } else {
                        ModifyDirectory('edit');
                    }
                }
            },
        });


        $(".table .alpha").click(function (e) {
            e.preventDefault();
            var $el = $(this),
            str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
            elements = "",
            available = [];
            $el.parents().find('.alpha .alpha-val span').each(function(){
                available.push($(this).text());
            });

            elements += "<li class='active'><span>All</span></li>";

            for(var i=0; i<str.length; i++)
            {
                var active = ($.inArray(str.charAt(i), available) != -1) ? " class='active'" : "";
                elements += "<li"+active+"><span>"+str.charAt(i)+"</span></li>";
            }
            $el.parents(".table").before("<div class='letterbox'><ul class='letter'>"+elements+"</ul></div>");
            $(".letterbox .letter > .active").click(function(){
                var $el = $(this);
                if($el.text() != "All"){
                    slimScrollUpdate($el.parents(".scrollable"), 0);
                    var scrollToElement = $el.parents(".box-content").find(".table .alpha:contains('"+$el.text()+"')");
                    slimScrollUpdate($el.parents(".scrollable"), scrollToElement.position().top);
                }
                //$el.parents(".letterbox").remove();
                $('.letterbox').remove();
            });
        });

});

function LoadDirectory(id){
    var row = DIRECTORY_SOURCE.filter( function(item){return (item.id==id);} );

    var type = row[0]['type'];
    var name = row[0]['name'];
    var address = row[0]['address'];
    var city = row[0]['city'];
    var state = row[0]['state'];
    var zip = row[0]['zip'];
    var latitude = row[0]['latitude'];
    var longitude = row[0]['longitude'];
    var phone1type = row[0]['phone1type'];
    var phone1 = row[0]['phone1'];
    var phone2type = row[0]['phone2type'];
    var phone2 = row[0]['phone2'];
    var phone3type = row[0]['phone3type'];
    var phone3 = row[0]['phone3'];
    var email = row[0]['email'];
    var website = row[0]['website'];
    var isvalid = row[0]['isvalid'];

    $("#record-delete").show();
    $("#directory-delete").attr('checked', false);

    $("#directory-type").val(type);
    $("#directory-name").val(name);
    $('#directory-address').val(address);
    $('#directory-city').val(city);
    $('#directory-state').val(state);
    $('#directory-zip').val(zip);
    $('.latitude').val(latitude);
    $('.longitude').val(longitude);
    $("#directory-phone1type").select2('val', phone1type);
    $('input[name=directory-phone1]').val(phone1);
    $("#directory-phone2type").select2('val', phone2type);
    $('input[name=directory-phone2]').val(phone2);
    $("#directory-phone3type").select2('val', phone3type);
    $('input[name=directory-phone3]').val(phone3);
    $('input[name=directory-email]').val(email);
    $('input[name=directory-website]').val(website);
    $('input[name=directory-isvalid]').val(isvalid);
    $('input[name=directory-id]').val(id);

    $('#list-actions').hide();
    $('#directory-list').hide();
    if (isvalid==1){
        $('.streets-valid').show();
    } else {
        $('.streets-valid').hide();
    }
    $('#directory-label').html('<i class="glyphicon-adress_book"></i> Directory - Edit');
    $('#directory-box').show();

    x=$("#directory-address").offset().left;
    y=$("#directory-address").offset().top+30;
    $(".smarty-ui").css({left:x,top:y});

    $("#directory-name").focus();

}

function ModifyDirectory(type){
    var post = $('#directory-form').serialize();
    $.post('classes/agency_directory.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-directory').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#directory-save').button('reset');
            }
        }
    });
}

function DirectorySave(){
    var flag = $('#directory-delete').is(":checked");
    if (flag==true){
        $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
        $("#jqxWindow-confirm").jqxWindow('open');
        $('#jqxWindow-confirm').jqxWindow('focus');
    } else {
        $('#directory-save').button('loading');
        var id = $("#directory-id").val();
        if (id==-1){
            ModifyDirectory('add');
        } else {
            ModifyDirectory('edit');
        }
    }
}

function DirectoryCancel(){
    $('#directory-box').hide();
    $('#directory-label').html('<i class="glyphicon-adress_book"></i> Directory');
    $('#list-actions').show();
    $('#directory-list').show();
}