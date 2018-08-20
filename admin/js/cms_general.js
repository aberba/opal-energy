$(function() {
    $(window).ajaxError(function(e) {
         Notification.show("Ooops! error connecting to server");
    });

    $(".timeago").each(function(e, exp) {
       var $text = $.timeago($(this).text());
       $(this).text($text);
   });

   $("#header .send-mail").on("click", function(e) {
        e.preventDefault();
        Email.showForm();
   })
});

var sPage = {
    getScript: function($file_source, calllbackFunction) {
     $file = $("<script />", {"type":"text\/javascript", "src": $file_source});
     $("head").append($file);
     if(calllbackFunction !== undefined) calllbackFunction();
    },
    getCSS: function($file_source) {
      $file = $("<link />", {"rel":"stylesheet", "href":$file_source});
      $("head").append($file);
    }
}

var Notification = {
    show: function(message) {

        clearTimeout(window.timer);
        $(".notification").fadeOut().replaceWith(" ");
        
        var container = $("<div />", {"class":"notification"});
        var p         = $("<p />");
        p.append(message);
        container.append(p);
        $("body").prepend(container);
        container.hide().fadeIn("slow");

        window.timer = setTimeout(function() {
            $(".notification").fadeOut("slow");
        }, 6000);
    }
}


var Email = {
    showForm: function() {

       var $status, $email, $subject, $message, $btn, $form, $container, $lightbox, $close;

        $close = $("<span />", {"class":"close", "text":"x"}).bind("click", function() {
           $lightbox.fadeOut("slow").replaceWith(" ");
       });
        
       $status = $("<p />", {"class":"status text-shadow"});
       $email     = $("<input />", {"type":"email", "name":"email", "placeholder":"Email Address"});
       $subject   = $("<input />", {"type":"text", "name":"subject", "placeholder":"Subject"});
       $message   = $("<textarea />", {"name":"message", "placeholder":"Message Body"});
       $btn       = $("<button />", {"class":"send-message button", "text":"Send", "type":"button"});
       $form = $("<form />", {"class":"form email-form"}).append($email).append($subject).append($message).append($btn);
       $container = $("<div />", {"class":"container email-container"}).append($close).append($status).append($form);
       $lightbox  = $("<div />", {"class":"lightbox email-lightbox"}).append($container);

       $("body").append($lightbox);
       $lightbox.hide().fadeIn("slow");

       $btn.bind("click", function(e) {
           e.preventDefault();
           Email.send();
       });
    },

    send: function() {
        var $status  = $(".email-container .status");
        var $email   = $(".email-container input[name=email]").val().trim();
        var $subject = $(".email-container input[name=subject]").val().trim();
        var $message = $(".email-container textarea[name=message]").val().trim();

        if($email == "" || $subject == "" || $message == "") {
            $status.html("<p class='invalid'>Please complete the form</p>");
            return false;
        }

        $url = "send_email=yes&email="+$email+"&subject="+$subject+"&message="+$message;
        $.post("ajax/query.php", $url, function(e) {
            $status.html(e);
            if (e.indexOf("successfully") != -1) {
                $status.removeClass("invalid").addClass("valid");
                setTimeout(function() {
                    $lightbox.fadeOut("slow").replaceWith(" ");
                }, 5000);
            } else {
                $status.removeClass("valid").addClass("invalid");
            }
        });
    }
}