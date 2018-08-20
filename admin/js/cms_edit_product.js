
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

    $("#product-images-form input[type=file]").on("change", function(e) {
        e.preventDefault();
        Products.preview(this);
    });

    $("#product-images-form .delete").on("click", function(e) {
        e.preventDefault();
        var $product_id = $(this).parent().parent().parent().parent().data("productid");
        var $type       = $(this).attr("id");
        Products.removeImage($product_id, $type);
    });

    $("button#save").on("click", function(e) {
        e.preventDefault();
        Products.save();
    });

    $("button#cancel").on("click", function(e) {
        e.preventDefault();
        window.location.href = "cms_products.php";
    });

});


var Products = {

    save: function() {
        var form = $("#product-info-form").serialize();
        $.post("ajax/save.php", form, function(e) {
            var message;
            if(e == 1) {
                message = "Product information saved successfully";
                setTimeout(function() {
                   window.location.href = "cms_products.php";
                }, 3000);
            }else {
                message = "Ooops! error saving product information";
            }
            Notification.show(message);
        });
    },

    preview: function (input) {
        var $column = $(input).attr("name");
        var $input = $(input)[0];
        
        if($input.files && $input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) { 
                var $img = $("<img />");
                $($img).attr("src", e.target.result);
                
                $("."+$column+"_preview").html($img).fadeIn("slow");
            }
            reader.readAsDataURL($input.files[0]);
            
            Products.uploadImage(input);
        }else {
            alert("Please upgarde your browser to upload files");
        }
    },
   
    uploadImage: function(input) {
        
        var $formdata    = new FormData();
        var $input       = $(input)[0];
        var $product_id  = $(input).attr("id");
        var $column      = $(input).attr("name");
        
        $formdata.append("upload_product_image", "yes");
        $formdata.append("product_image", $input.files[0]);
        $formdata.append("product_id", $product_id);
        $formdata.append("column_name", $column);
          
        $.ajax({
            type: "POST",
            url: "ajax/upload.php",
            enctype: "multipart/form-data",
            processData: false,
            contentType: false,
            data: $formdata,
            success: function(e) {
                //alert(e);
                Notification.show(e);
            },
            error: function(e) {
                Notification.show("Ooops! errror connecting to server");
            }
        });
    },

    removeImage: function(product_id, type) {
        var $image_type, $column;

        switch(type) {
            case '1':
                $image_type = "one";
                $column     = "image_one";
                break;
            case '2':
                $image_type = "two";
                 $column    = "image_two";
                break;
            case '3':
                $image_type = "three";
                $column     = "image_three";
                break;
            case '4':
                $image_type = "four";
                $column     = "image_four";
                break;
            case '5':
                $image_type = "five";
                $column     = "image_five";
                break;
            case '6':
                $image_type = "six";
                $column     = "image_six";
                break;
            default:
                 Notification.show("Image type is unknowmn: Products.removeImage()");
                 return false;
                 break;
        }

        var $url = "remove_product_image=yes&product_id=" + product_id+ "&column_name=" + $column;

       $.post("ajax/delete.php", $url, function(e) {
            Notification.show(e);

            if (e.indexOf("successfully") != -1) {   
                $(".image_" + $image_type + "_preview img").attr("src", "");
            }
       });
    }
}
