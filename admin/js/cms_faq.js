$(function() {
    $(".add-new").on("click", function(e) {
        e.preventDefault();
        $(this).hide();
        $(".add-question-form").fadeIn("slow");
    });

    $(".add-question-form .cancel-btn").on("click", function(e) {
        e.preventDefault();

        $(".add-new").show()
        $(".add-question-form").fadeOut("slow");
    });

    $(".add-question-form .add-btn").on("click", function(e) {
        e.preventDefault();
        FAQ.addNew();
    });

    $(".faq-item a.toggle").on("click", function(e) {
      e.preventDefault();

      $(this).text( $(this).text() == "+" ? "-" : "+" );
      FAQ.toggleAnswer( $(this).parent().parent() );
    });

    $(".faq-item .edit").on("click", function(e) {
        e.preventDefault();
        var $id = $(this).parent().parent().attr("id").split("faq")[1];
        FAQ.queryQuestion($id);
    });

    $(".faq-item .publish").on("click", function(e) {
      e.preventDefault();
        
        var $id = $(this).parent().parent().attr("id").split("faq")[1];
        FAQ.changeStatus($id);
    });

    $(".faq-item .delete").on("click", function(e) {
      e.preventDefault();
        
        var $id = $(this).parent().parent().attr("id").split("faq")[1];
        FAQ.remove($id);
    });
});


var FAQ = {
  toggleAnswer: function(item) {
    if (item == null) throw "FAQ.toggleAnswer(): faq_id was not set";

    $(item).children(".answer").slideToggle("slow");
  },

  changeStatus: function(question_id) {
      if (question_id == null) throw "FAQ.changeStatus(): question_id was not set";

      var $url = "change_question_status=yes&question_id=" + question_id;
      $.post("ajax/save.php", $url, function(e) {
        Notification.show(e);

        var $text = (e.indexOf("published") != -1) ? "Unpublish" : "Publish";
        $("#faq" + question_id + " .publish").text($text);
      });
  },

  queryQuestion: function(question_id) {
        if (question_id == null) throw "FAQ.findByID(): question_id was not set";
        $url = "query_question=yes&question_id=" + question_id;

        $.post("ajax/query.php", $url, function(e) {
           if (e == 0) {
               Notification.show("Oops!, error fetching question with ID: " + question_id);
               return;
           }

           var data, form, qLabel, aLabel, qInput, aInput, sBtn, cBtn, container, lightbox, close;

           data = JSON.parse("[" + e + "]");
           form = $("<form />", {"class":"form edit-question-form"});


           for (var i in data) {
              qLabel = $("<label />", {"for":"question","text":"Question: "});
              aLabel = $("<label />", {"for":"answer","text":"Answer: "});

              qInput = $("<input />", {"type":"text","name":"question", "placeholder":"Enter question", "value": data[i].question});
              aInput = $("<textarea />", {"name":"answer", "placeholder":"Enter answer"}).append(data[i].answer);

              sBtn   = $("<button />", {"type":"button","class":"button save-btn", "text":"Save"}).bind("click", function(e) {
                  e.preventDefault();
                  FAQ.save( question_id, qInput.val(), aInput.val() );
              });

              form.append(qLabel).append(qInput).append(aLabel).append(aInput).append(sBtn);              
           }

           close     = $("<span />", {"class":"close", "text":"x"}).bind("click", function(e) {
               e.preventDefault();
               lightbox.fadeOut("slow").replaceWith(" ");
           });

           container = $("<div />", {"class":"container"}).append(close).append(form);
           lightbox  = $("<div />", {"class":"lightbox question-lightbox"}).append(container);
           
           $("body").append(lightbox);
           lightbox.hide().fadeIn("slow");
        });
  },

  save: function(question_id, question, answer) {
    if (question_id == null || question == null || answer == null) throw "FAQ.findByID(): parameters not completely provided";

    var $url = "save_question=yes&question_id=" + question_id + "&question=" + question + "&answer=" + answer;
    $.post("ajax/save.php", $url, function(e) {
            Notification.show(e);

            if (e.indexOf("successfully") != -1) {
                $(".lightbox").fadeOut("slow").replaceWith(" ");
            }
    });
  },

  addNew: function() {
       var qInput = $(".add-question-form input[name=question]");
       var aInput = $(".add-question-form textarea[name=answer]");

       var question = qInput.val();
       var answer   = aInput.val();
      
       if (question == "" || answer == "") {
            Notification.show("Please complete the form");
            return;
       }

       var $url = "add_question=yes&question=" + question + "&answer=" + answer;
      
       $.post("ajax/save.php", $url, function(e) {
           Notification.show(e);

           if (e.indexOf("successfully") != -1) {
               qInput.val("");
               aInput.val("");
               $(".add-question-form").fadeOut("slow");
               $(".add-new").fadeIn("slow");
           }
       });
  },

  remove: function(question_id) {
      $url = "remove_question=yes&question_id=" + question_id;
      $.post("ajax/delete.php", $url, function(e) {
          Notification.show(e);

          if (e.indexOf("successfully") != -1) {
              $("#faq" + question_id).fadeOut("slow");
          }
      });
  }

}