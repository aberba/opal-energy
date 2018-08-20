
$(function() {

   $(window).ajaxStart(function() {
        $(".loader").fadeIn("slow");
   });

    $(window).ajaxStop(function() {
        $(".loader").fadeOut("slow");
   });
    
   $(".tab").on("click", function(e) {
      e.preventDefault();
      $(".tab").removeClass("current");
      $(this).addClass("current");
      
      $(".form").hide();
      var id  = $(this).attr("id");
      $("#"+id+"-form").show();
   });
   
   $(".form input[type=file]").on("change", function(e) {
      e.preventDefault();
      Images.preview(this);
   });
   
   $("button#save").on("click", function(e) {
      e.preventDefault();
      Service.save();
   });
   
   $("button#cancel").on("click", function(e) {
      e.preventDefault();
      window.location.href = "cms_services.php";
   });

});

var Service = {
    save: function() {
        var $form = $("#information-form").serialize();
        $.post("ajax/save.php", $form, function(e) {
          //alert(e);
            var message;
            if(e == 1) {
                message = "Service information saved successfully";
                setTimeout(function() {
                    window.location.href = "cms_services.php";
                }, 4000);
            }else {
                message = "Ooops! error saving service information";
            }
            Notification.show(message);
        });
    }
}


var Images = {
    readFile: function (input) {
        var $name = $(input).attr("name");
        var $input = $(input)[0];
        
        if($input.files && $input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) { 
                var $img = $("<img />");
                $($img).attr("src", e.target.result);
                
                $("."+$name+"_preview").html($img).fadeIn("slow");
            }
            reader.readAsDataURL($input.files[0]);
            
            Images.uploadImage($input);
        }else {
            alert("Please upgarde your browser to upload files");
        }
    },

    preview: function(e) {
       var val = $(e).val();
       Images.readFile($(e));
    },

    uploadImage: function(input) {
        var $formdata    = new FormData();
        var $input       = $(input)[0];
        var $service_id  = $(input).attr("id");
        var $column  = $(input).attr("name");

        $formdata.append("upload_service_image", "yes");
        $formdata.append("service_image", $input.files[0]);
        $formdata.append("service_id", $service_id);
        $formdata.append("column_name", $column);
          
        $.ajax({
            type: "POST",
            url: "ajax/upload.php",
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            data: $formdata,
            success: function(e) {
                Notification.show(e);
            },
            error: function(e) {
                Notification.show("Ooops! errror connecting to server");
            }
        });
    }
}
