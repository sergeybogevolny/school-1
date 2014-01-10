$(document).ready(function() {

    $('.alpha').click(function() {
        var abc = $(this).attr('data-value');
        var url = location.protocol + '//' + location.host + location.pathname;
        window.location.href = url + '?alpha=' + abc;
    });


});
