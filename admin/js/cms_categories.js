
$(function() {
    

    $(".add-category").on("click", function(e) {
        e.preventDefault();
        Category.addNew();
    });

    $(".categories-table td[contenteditable=true]").on("blur", function() {
        var category_id   = $(this).parent().attr("id").split("category")[1];
        var category_name = $(this).text();
        Category.save(category_id, category_name);
    });

    $(".categories-table .publish").on("click", function(e) {
        e.preventDefault();
        var $id = $(this).attr("id").split("publish")[1];
        Category.changeStatus($id);
    });

    $("img.delete").on("click", function(e) {
       e.preventDefault();
       var category_id = $(this).parent().parent().attr("id").split("category")[1];
       Category.remove(category_id);
    });
});


var Category = {
    addNew: function() {

       var form = $("#category-form").serialize();
       var category_name = $("input[type=text]#category_name").val();

       $.post("ajax/save.php", form, function(e) {
          if (e.indexOf("successfully") != -1) {
             var td1 = $("<td />", {"text": category_name});
             var td2 = $("<td />", {"text": "Now"});
             var td3 = $("<td />");
             var row = $("<tr />" ).append(td1).append(td2).append(td3);
             $(row).insertAfter(".categories-table tr:first-child");
          }
          Notification.show(e);
       });
    },

    save: function(category_id, category_name) {
        var url = "save_category=yes&category_id="+category_id+"&category_name="+category_name;
        $.post("ajax/save.php", url, function(e) {
            Notification.show(e)
        });
    },

    changeStatus: function(id) {
        if(id === undefined) throw "Undefined category ID";
        $url = "change_category_status=yes&id="+id;
        $.post("ajax/save.php", $url, function(e) {
           $text = (e.indexOf("shown") != -1) ? "Unpublish": "Publish";
           $(".categories-table #publish"+id).text($text);
           Notification.show(e);
        });
    },

    remove: function(category_id) {
        var url = "remove_category=yes&category_id="+category_id;
        $.post("ajax/delete.php", url, function(e) {

           if(e.indexOf("successfully") != -1) {
              $("#category"+category_id).fadeOut("slow");
           }
           Notification.show(e);
        });
    }
}
