$(function() {
    $(".service a.publish").on("click", function(e) {
    	e.preventDefault();
    	var $id = $(this).attr("id").split("publish")[1];
    	Service.publishORunpublish($id);
    });

    $(".service a.delete").on("click", function(e) {
        e.preventDefault();
        var $id = $(this).attr("id").split("delete")[1];
        Service.delete($id);
    });


});

Service = {
	publishORunpublish: function(id) {
         var $url = "change_service_status=yes&id="+id;
         $.post("ajax/save.php", $url, function(e) {
             if(e.indexOf("shown") != -1) {
             	$(".service a#publish"+id).text("Unpublish");
             }else if(e.indexOf("hidden") != -1) {
             	$(".service a#publish"+id).text("Publish");
             }
             Notification.show(e);
         });
	},
    delete: function(service_id) {
        if(service_id == "" || service_id == undefined) return false;
        var $confirm = window.confirm("Are you sure you want to delete this service record?");
        if($confirm) {
            var $url = "remove_service=yes&service_id="+service_id;
            $.post("ajax/delete.php", $url, function(e) {
                if(e.indexOf("deleted") != -1) {
                    $("#service"+service_id).fadeOut("slow");
                }
                Notification.show(e);
            });
        }
    }
}