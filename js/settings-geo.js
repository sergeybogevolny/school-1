$(document).ready(function() {
        $("#jqxWindow-status").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });

        $("#jqxWindow-confirm").jqxWindow({
            width: 290, height: 160, resizable: false, keyboardCloseKey: 'esc', isModal: true, autoOpen: false, theme: 'metro' });
        LoadGeo();
})


function LoadGeo(){

   var address = GEO_ADDRESS;
   var city    = GEO_CITY;
   var state   = GEO_STATE;
   var zip     = GEO_ZIP;
   var latitude= GEO_LATITUDE;
   var longitude = GEO_LONGITUDE;
   
   $('#geo-address').val(address);
   $('#geo-city').val(city);
   $('#geo-state').val(state);
   $('#geo-zip').val(zip);
   $('#geo-latitude').val(latitude);
   $('#geo-longitude').val(longitude);
   $('#geo-id').val(1);
   
}


function GeoSave(){
    var post = $('#settings-geo-form').serialize();
    $.post('classes/settings_geo.class.php', post, function (data) {
        if (data.match('success') !== null) {
            $('#jqxWindow-directory').jqxWindow('close');
            location.reload();
        } else {
            $("#jqxWindow-status").jqxWindow('setTitle', 'Error')
            $('#jqxWindow-status').jqxWindow({ content: data });
            $('#jqxWindow-status').jqxWindow('open');
            $('#jqxWindow-status').jqxWindow('focus');
        }
    });
}

function GeoCancel(){
    location.reload();
}
