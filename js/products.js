$(function() {
   $(".product figure img").on("click", function(e) {
      e.preventDefault();
    
      $product_id = $(this).attr("id");
      ProductsLightbox.show($product_id);
   });
  
});

ProductsLightbox = {
    show: function(product_id) {
       var lightbox = $("<div />",{"id": "lightbox"+product_id,"class": "lightbox"});
       var container = $("<div />", {"class":"container" });

        $close   = $("<p />", {"id":"close", "text":"x"});
        $close.on("click", function(e) {
              e.preventDefault();
              ProductsLightbox.hide();
        });
          
       $(container).append($close);
       $(lightbox).append(container);

       var $url = encodeURI("query_product=yes&product_id="+product_id);
       $.post("/ajax/query.php", $url, function(e) {
          if(e == 0)  {
              ProductsLightbox.hide();
              return false;
          }
          var data = JSON.parse("["+e+"]");
          
          for(var i in data) {
              var preview = $("<div />", {"class":"preview"});
              var preview_image = $("<img />", {"class":"preview-image"});
              var info_text = $("<h3>"+data[i].product_name+"</h3><p>"+data[i].specs+"</p>");

              var info          = $("<div />", {"class":"product-info"});
              $(info).append(info_text);
              
              $(preview_image).attr("src", data[i].image_one);
              $(preview).append(preview_image);
              $(preview).append(info);
              
              var list    = $("<div />", {"class":"list"});
              
              if(data[i].image_one != null) {
                 var image1 = $("<img />", {"class":"image", "src":data[i].image_one});
                 $(image1).attr("src", data[i].image_one);
                 $(list).append(image1);
              }
              
              
              if(data[i].image_two != null) {
                 var image2 = $("<img />", {"class":"image", "src":data[i].image_two});
                 $(image2).attr("src", data[i].image_two);
                 $(list).append(image2);
              }
              
              if(data[i].image_three !== null) {
                 var image3 = $("<img />", {"class":"image", "src":data[i].image_three});
                 $(list).append(image3);
              }
              
              if(data[i].image_four != null) {
                 var image4 = $("<img />", {"class":"image", "src":data[i].image_four});
                 $(list).append(image4);
              }
              
              if(data[i].image_five != null) {
                 var image5 = $("<img />", {"class":"image", "src":data[i].image_five });
                 $(list).append(image5);
              }
              
              if(data[i].image_six != null) {
                 var image6 = $("<img />", {"class":"image", "src":data[i].image_six});
                 $(image6).attr("src", data[i].image_six);
                 $(list).append(image6);
              }
          }
          
          $(container).append(preview);
          $(container).append(list);
        
          $(".lightbox .container .list .image").bind("click", function(e) {
              e.preventDefault();
              $(".lightbox .container .list .image").removeClass("current");
              $(this).addClass("current");
              $(".preview .preview-image").attr("src", $(this).attr("src"));
          });
       }); // end of Ajax request
       
       $("body").append(lightbox).fadeIn("slow");
       container.hide().fadeIn("slow");
       container.css({
          backgroundImage: "url('')" // removes loader
       });
    },
    hide: function() {
        $(".lightbox").fadeOut("slow").replaceWith(" ");
    }
}















