$(function() {
    $(".options-form .save-options").on("click", function(e) {
    	e.preventDefault();

        var $formdata = false;
        $formdata     = new FormData();
        if(!$formdata) {
        	Notification.show("Sorry your browser does not support FormData");
        	return false;
        }
          
        $(".options-form input[type=radio]:checked").each(function() {
        	var $id  = $(this).attr("name");
            var $value = $(this).val();
            $formdata.append($id, $value);
        });

        $formdata.append("save_options", "yes");
    	$.ajax({
    		type: "POST",
    		url: "ajax/save.php",
    		data: $formdata,
    		contentType: false,
    		processData: false,
    		success: function(e) {
    		    Notification.show(e);
    	    },
    	    error: function(e) {
    	    	Notification.show("Ooops! error connecting to server");
    	    }
    	});
    });
});

Options = {
	save: function() {
		var $url = "query_notification=yes";
		$.post("ajax/query.php", $url, function(e) {
		   if(e == 0) return false;
		   var $data = JSON.parse("["+e+"]");

		});	
	}
}
