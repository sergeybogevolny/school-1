$(document).ready(function() {

        var targets = [ "Client", "Prospect", "Power" ];

        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxDropDownList-search-target").jqxDropDownList({
          source: targets, selectedIndex: 0, width: '100', height: '29', displayMember: 'name', valueMember: 'name', theme: 'metro' });

        $('#jqxDropDownList-search-target').on('change', function (event){
            $("#search-value").val('');
            $("#search-value").focus();
        });

        $("#search-form").validate({
	        submitHandler: function() {
                var sval = $('#search-value').val();
                if (sval==''){
                    $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
                    $("#jqxWindow-status").jqxWindow('setContent', '<div class="alert alert-error">You must enter a Search For value.</div>')
                    $("#jqxWindow-status").jqxWindow('open');
                    $('#jqxWindow-status').jqxWindow('focus');
                } else {
                    LoadResults();
                }
            },
        });

        window.onload=function(){$("#search-value").focus();};

});

function SearchStatus(e){
    var sval = e.keyCode;
    if (sval!=13){
        $('#search-results').hide();
    }
}

function LoadResults(){
    var post = $('#search-form').serialize();
    $.post('classes/search.class.php', post, function (data) {
        if (data.match('error') !== null) {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
        } else {
            document.getElementById("search-results").innerHTML = data;
            $('#search-results').show();
        }
    });

}


