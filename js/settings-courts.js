$(document).ready(function() {
        
        var types = [ "District", "County", "JP", "Municipal" ];
		$('#court-label').html('<i class="icon-list-alt"></i> Court');

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxDropDownList-court-type").jqxDropDownList({
          source: types, width: '200', height: '25', displayMember: 'name', valueMember: 'name', placeHolder: "Select:", theme: 'metro' });

        $("#jqxDropDownList-court-county").jqxDropDownList({
          width: '200', height: '25', displayMember: 'name', valueMember: 'name', placeHolder: "Select:", theme: 'metro' });

        $('#jqxDropDownList-court-type').on('change', function (event){
            var args = event.args;
            var item = args.item;
            var value = item.value;
            if (value=='JP'){
                $('#type-jp').show();
            } else {
              $('#type-jp').hide();
              $("#court-precinct").val('');
              $("#court-position").val('');
            }
        });

        $("#settings-add").click(function(e){
			e.preventDefault();
            $("#record-delete").hide();
            $("#jqxDropDownList-court-county").jqxDropDownList('clearSelection');
            $("#jqxDropDownList-court-type").jqxDropDownList('clearSelection');
            LoadCounties();
            $('#type-jp').hide();
            $("#court-name").val('');
            $("#court-precinct").val('');
            $("#court-position").val('');
            $("#court-term").val('0');
            $("#court-delete").attr('checked', false);
			$('#list-actions').hide();
            $('#court-list').hide();
            $('#court-label').html('<i class="icon-list-alt"></i> Courts - Add');
            $('#court-box').show();
            $('input[name=court-id]').val(-1);
            $("#court-name").focus();
		});

        $("#court-cancel").click(function(){
            $('#court-box').hide();
            $('#court-label').html('<i class="icon-list-alt"></i> Courts');
            $('#list-actions').show();
            $('#court-list').show();
		});

        $("#confirm-no").click(function(){
            $('#jqxWindow-confirm').jqxWindow('close');
		});

        $("#confirm-yes").click(function(){
            ModifyCourt('delete');
		});

        $("#court-form").validate({
	        submitHandler: function() {
                var flag = $('#court-delete').is(":checked");
                if (flag==true){
                    $("#jqxWindow-confirm").jqxWindow('setTitle', 'Delete?')
                    $("#jqxWindow-confirm").jqxWindow('open');
                    $('#jqxWindow-confirm').jqxWindow('focus');
                } else {
                    $('#court-save').button('loading');
                    var id = $("#court-id").val();
                    if (id==-1){
                        ModifyCourt('add');
                    } else {
                        ModifyCourt('edit');
                    }
                }
            },
        });

});

function LoadCounties(){
    var sourcecounties =
    {
        datatype: "json",
    	datafields: [
    	    { name: 'name'},
    		{ name: 'name'},
    	],
    	url: 'classes/valuelist.class.php?valuelist=counties',
    	async: false
    };
    var counties = new $.jqx.dataAdapter(sourcecounties);
    $("#jqxDropDownList-court-county").jqxDropDownList({ source: counties });
}

function LoadCourt(id){
    $.ajax({
        type: "GET",
        url: "classes/settings_court.class.php?id="+id,
        dataType: "html",
        success: function(result){
        var $response=$(result);
        if (status != 'FAIL') {
            var name = $response.filter('#name').text();
            var status = $response.filter('#status').text();
            var county = $response.filter('#county').text();
            var type = $response.filter('#type').text();
            var precinct = $response.filter('#precinct').text();
            var position = $response.filter('#position').text();
            var term = $response.filter('#term').text();
            $('#list-actions').hide();
            $('#court-list').hide();
            $('#court-label').html('<i class="icon-list-alt"></i> Courts - Edit');
            $('#court-box').show();
            $("#record-delete").show();
            $("#court-delete").attr('checked', false);
            $("#jqxDropDownList-court-county").jqxDropDownList('clearSelection');
            $("#jqxDropDownList-court-type").jqxDropDownList('clearSelection');
            LoadCounties();
            $('#type-jp').hide();
            $("#court-name").val(name);
            $("#jqxDropDownList-court-county").jqxDropDownList('val', county);
            $("#jqxDropDownList-court-type").jqxDropDownList('val', type);
            $("#court-precinct").val(precinct);
            $("#court-position").val(position);
            $("#court-term").val(term);
            $('input[name=court-id]').val(id);
            $("#court-name").focus();
            }
        }
    });
}

function ModifyCourt(type){
    var post = $('#court-form').serialize();
    $.post('classes/settings_court.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-court').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
            if (type=='delete'){
                $('#jqxWindow-confirm').jqxWindow('close');
            } else {
                $('#court-save').button('reset');
            }
        }
    });
}