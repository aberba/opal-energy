$(function() {

    $(".slider-form .slide-btn").on("click", function(e) {
        e.preventDefault();
        Manager.uploadSlide();
    });

    $(".thumbs-form input[type=file]").on("change", function() {
        Manager.uploadTemplateImage();
    });

    //templates
    $(".toggle-slides").on("click", function() {
        $(".slides-container").toggle();
    });

    $(".template-slides-section .slide .publish").on("click", function(e) {
        e.preventDefault();
        var $id = $(this).attr("id").split("publish")[1];
        Manager.changeSlideStatus($id);
    });

     $(".template-slides-section .slide .delete").on("click", function(e) {
        e.preventDefault();
        var $id = $(this).attr("id").split("delete")[1];
        Manager.removeSlide($id);
    });

    //upload
    $(".toggle-upload").on("click", function() {
        $(".upload-container").toggle();
    });
    
     $(".toggle-notification").on("click", function() {
        $(".notification-container").toggle();
    });
     

    $(".notification-section .table .edit").on("click", function() {
        Manager.showNotificationForm();
    });

    //map
    $(".map-section .toggle-map").on("click", function() {
        $(".map-container").toggle();
    });

    var mapContainer = document.querySelector(".map-container");
    Manager.showMap(mapContainer);
});

var Manager = {

    uploadSlide: function() {
        var $title = $(".slider-form input[name=title]").val();
        var $desc  = $(".slider-form textarea[name=description]").val();

        if ($title == "") {
            Notification.show("Please enter slide title");
            return;
        }

        if ($desc == "") {
            Notification.show("Please enter slide description");
            return;
        }

        var $file  = $(".slider-form input[name=file]")[0].files[0];
        if(!$file) {
            Notification.show("Please select banner image to upload");
            return false;
        }

        var $formdata = false;
        $formdata     = new FormData();
        if(!$formdata) {
            Notification.show("Your browser does not support FormData");
            return false;
        }

        $formdata.append("upload_slide", "yes");
        $formdata.append("title", $title);
        $formdata.append("description", $desc);
        $formdata.append("file", $file);

        //upload
        $.ajax({
            type: "POST",
            url: "ajax/upload.php",
            data: $formdata,
            contentType: false,
            processData: false,
            success: function(e) {
                Notification.show(e);

                if (e.indexOf("successfully") != -1) {
                    $(".slider-form input[name=title]").val("");
                    $(".slider-form textarea[name=description]").val("");
                    $(".slider-form input[name=file]").val("");
                }
            },
            error: function(e) {
                Notification.show("Ooops! error connecting to server");
            }
        });
    },

    uploadTemplateImage: function() {
        $file = $(".thumbs-form input[type=file]")[0].files[0];
        $item = $(".thumbs-form option:selected").val();

        if($item == "" || $item === undefined) {
            Notification.show("Please select selecte template item type");
            return false;
        }

        if(!$file) {
            Notification.show("Please select banner image to upload");
            return false;
        }

        var $formdata = false;
        $formdata = new FormData();
        if(!$formdata) {
            Notification.show("Your browser does not support FormData");
            return false;
        }
        $formdata.append("upload_template_image", "yes");
        $formdata.append("item", $item.toLowerCase());
        $formdata.append("file", $file);

        //upload
        $.ajax({
            type: "POST",
            url: "ajax/upload.php",
            data: $formdata,
            contentType: false,
            processData: false,
            success: function(e) {
                Notification.show(e);
                $(".thumb-form input[type=file]").val("");
            },
            error: function(e) {
                Notification.show("Ooops! error connecting to server");
            }
        });
    },

	showNotificationForm: function() {
		var $url = "query_notification=yes";
		$.get("ajax/query.php", $url, function(e) {
		   if(e == 0) return false;
		   var $data = JSON.parse("["+e+"]");

          $form = $("<form />", {"class":"notification-form"});
          $form.append($("<h5 />", {"text":"Update Notification"}));
		  for(var i in $data) {
             $ta_label = $("<label />", {"for":"message", "text":"Notification Message :"});
		     $ta = $("<textarea />", {"name":"message"}).append($data[i].message);
		     $form.append($form).append($ta_label).append($ta);
             
             $sp = $("<span />");
             $cb_label = $("<label />", {"for":"publish", "text":"Do you want it published?"});
		     $cb1 = $("<input />", {"type":"radio", "name":"publish", "value":"1"});
		     $cb2 = $("<input />", {"type":"radio", "name":"publish", "value":"0"});
		     $data[i].publish == 1 ? $cb1.attr("checked", "checked") : $cb2.attr("checked", "checked");
		     $form.append($cb_label).append($("<br />")).append($cb1).append($sp.clone().append("Yes")).append($cb2).append($sp.clone().append("No")).append($("<br />"));
             
             $date_label = $("<label />", {"for":"year", "text":"Date to Expire: yyyy/mm/dd"});
		     $y_tb  = $("<input />", {"type":"text", "maxlength":4, "size":4, "name":"year", "placeholder":"yyyy", "value":$data[i].year}); 	
		     $m_tb  = $("<input />", {"type":"text", "maxlength":2, "size":2, "name":"month", "placeholder":"mm", "value":$data[i].month}); 	
		     $d_tb  = $("<input />", {"type":"text", "maxlength":2, "size":2, "name":"day", "placeholder":"dd", "value":$data[i].day}); 	
		     $s_btn = $("<button />", {"class":"update button", "text":"Update"});
			 $form.append($date_label).append($("<br />")).append($y_tb).append($m_tb).append($d_tb).append($("<br />")).append($s_btn);
			 
          }
          $s_btn.bind("click", function(e) {
          	  e.preventDefault();
          	  Manager.saveNotification();
          });

          $(".notification-section").append($form);
          $(".notification-section .table .edit").hide();
          $form.hide().fadeIn(2000);
		});	
	},

	saveNotification: function() {
        var $form = $(".notification-form").serialize();
        var $url  = "save_notification=yes&"+$form;
        $.post("ajax/save.php", $url, function(e) {
        	Notification.show(e);
            if(e.indexOf("successfully") != -1) {
            	Manager.hideNotificationForm();
            }
        });
	},

	hideNotificationForm: function() {
		$(".notification-section .notification-form").fadeOut("slow").replaceWith(" ");
		$(".notification-section .table .edit").fadeIn();
	},	

    changeSlideStatus: function(slideID) {
        if(slideID === undefined) throw new Error("Slider iD wa snot set");
        
        var $url = "change_slide_status=yes&id="+slideID;
        $.post("ajax/save.php", $url, function(e) {
            Notification.show(e);
            $text = (e.indexOf("shown") != -1) ? "Unpublish" : "Publish";
            $("#publish"+slideID).text($text);
        });
    },

    removeSlide: function(slideID) {
        if(slideID === undefined) throw new Error("Slider iD wa snot set");

        var $url = "remove_slide=yes&id="+slideID;
        $.post("ajax/delete.php", $url, function(e) {
            Notification.show(e);
            if(e.indexOf("successfully") != -1) {
                $("#slide"+slideID).fadeOut("slow");
                $("#slide-info"+slideID).fadeOut("slow");
            }
        });
    },

    //Google map
    showMap: function(mapContainerID, lat, lng, markerLabel) {
        $positionLat = (lat != "") ? lat : -484848; // remomeber to change them
        $positionLng = (lng != "") ? lng : 484844;
        $markerLabel = (markerLabel != "") ? markerLabel : "Our Location";

        if(window.google) {
            var myPosition = new google.maps.LatLng($positionLat, $positionLng);

            var mapOptions = {
                map: myMap,
                zoom: 18,
                center: myPosition,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var containerElement = $("#"+mapContainerID);
            if(!containerElement) throw new Error("Map container was no found");
            myMap = new google.maps.Map(containerElement, mapOptions);

            var container = new google.maps.InfoWindow({
                position: myPosition,
                content: $markerLabel
            });
            myMap.setCenter(myPosition);
            var mapMarker = new google.maps.Marker({
                position: myPosition,
                title: $markerLabel,
                map: myMap
            });
        }
    }
}
