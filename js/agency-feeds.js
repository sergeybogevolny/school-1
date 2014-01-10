// JavaScript Document

function refreshFeed(start_after) {
    var $el = $("#feeds-container");
    var auto = $("#feeds-refresh").hasClass("checkbox-active");

    if (auto) {
        $.getJSON('ajax.php', { action: 'refresh_feed', after_feed: start_after }, function(responce){
            $el.prepend(responce.feeds);
            $el.find("tr.hide").fadeIn().removeClass('hide');
            if ($el.find("tbody tr").length > 20) {
                $el.find("tbody tr").last().fadeOut(400, function () {
                    $(this).remove();
                });
            }
            start_after = responce.latest_feed_id;
        });
    }

    slimScrollUpdate($el.parents(".scrollable"));

    setTimeout(function(){
        refreshFeed(start_after);
    }, 3000);
}