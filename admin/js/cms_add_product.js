
$(function() {

   $(".form input[type=file]").on("change", function(e) {
      e.preventDefault();
      images.preview(this);
   });

   $("button#save").on("click", function(e) { //cancel btn
      e.preventDefault();
      Products.addNew();
   });

   $("button#cancel").on("click", function(e) { //cancel btn
      e.preventDefault();
      window.location.href = "cms_products.php";
   });

});

var Products =  {
    addNew: function() {
        var form = $("#product-info-form").serialize();
        $.post("ajax/save.php", form, function(e) {
           if(e.indexOf("successfully") != -1) {
            window.location.href = "cms_products.php";
           }
           Notification.show(e);
        });
    }
}
