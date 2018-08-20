$(function() {
    Notification.queryMessage();
});

var Notification = {
    queryMessage: function() {
        var $url = "query_notification=yes";
        $.get("/ajax/query.php", $url, function(e) {
            if(e == 0) return false;
            var $data = JSON.parse("["+e+"]");

            var $container;
            for(var i in $data) {
                $close = $("<p />", {"class":"close", "text":"x"});
                $msg = $("<p />").html($data[i].message);
                $container = $("<section />", {"class":"message-notification"}).append($close).append($msg);
            }
            $close.bind("click", function() {
                Notification.removeMessage();
            });
            $("#content").prepend($container);
            $container.hide().fadeIn(3000);
        });
    },
    removeMessage: function() {
        $(".message-notification").fadeToggle(1000);
        $.post("/ajax/query.php", "stop_notifications=yes");
    }
}
