$(function() {
    $(".product a.publish").on("click", function(e) {
    	e.preventDefault();
    	var $id = $(this).attr("id").split("publish")[1];
    	
    	Products.changeStatus($id);
    });

    $(".product a.delete").on("click", function(e) {
        e.preventDefault();
        var $id = $(this).attr("id").split("delete")[1];
        Products.delete($id);
    });


});

Products = {
	changeStatus: function(id) {
         var $url = "change_product_status=yes&id="+id;
         $.post("ajax/save.php", $url, function(e) {
             $text = (e.indexOf("shown") != -1) ? "Unpublish": "Publish";
             $(".product a#publish"+id).text($text);
             Notification.show(e);
         });
	},
    delete: function(products_id) {
        if(products_id == "" || products_id == undefined) return false;
         
        var $confirm = window.confirm("Are you sure you want to delete this product record?");
            if($confirm) {
            var $url = "remove_product=yes&product_id="+products_id;
            $.post("ajax/delete.php", $url, function(e) {
                if(e.indexOf("successfully") != -1) $("#product"+products_id).fadeOut("slow");
                Notification.show(e);
            });
        }
    }
}