$(function() {

    $("button#save").on("click", function(e) { //cancel btn
        e.preventDefault();
        Services.addNew();
    });

    $("button#cancel").on("click", function(e) { //cancel btn
        e.preventDefault();
        window.location.href = "cms_services.php";
    });

});

var Services =  {
    addNew: function() {
        var $form = $("#information-form").serialize();
        $.post("ajax/save.php", $form, function(e) {
           if(e.indexOf("successfully") != -1) {
            window.location.href = "cms_services.php";
           }
           Notification.show(e);
        });
    }
}
