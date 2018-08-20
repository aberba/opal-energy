$(function() {
    $(".edit-profile").on("click", function(e) {
    	e.preventDefault();
    	Profile.showEditInfoForm();
    });

    $(".change-pass").on("click", function(e) {
    	e.preventDefault();
    	Profile.showPasswordForm();
    });
});


Profile = {
	showEditInfoForm: function() {
         var $url = "fetch_profile=yes"
            $.get("ajax/query.php", $url, function(e) {
         	if(e == 0) {
         		Notification.show("Error fetching information");
         		return false;
         	}
            $data = JSON.parse("["+ e +"]"); 
            $form  = $("<form />", {"class":"information-form"});

         	for(var i in $data) {
         		$fname = $("<input />", {"type":"text", "name":"fname", "value":$data[i].first_name, "placeholder":" First Name "});
         		$lname = $("<input />", {"type":"text", "name":"lname", "value":$data[i].last_name, "placeholder":" Last Name "});
         		$email = $("<input />", {"type":"email", "name":"email", "value":$data[i].email, "placeholder":" Email Address "});
         		$btn   = $("<button />", {"type":"button", "class":"save-profile button", "text":"Save Profile"})
         		$form.append($fname).append($lname).append($email).append($btn);
         	}

     		$btn.on("click", function(e) {
     			 e.preventDefault();
                 Profile.updateInfo();
     		});

         	$(".information-section").append($form);
         	$form.hide().fadeIn("slow");
         	$(".edit-profile").hide();
         });
	},
    
    updateInfo: function() {
         var $fname = $(".information-form input[name=fname]").val().trim();
         var $lname = $(".information-form input[name=lname]").val().trim();
         var $email = $(".information-form input[name=email]").val().trim();

         if($fname == "" || $lname == "" || $email == "") {
         	 Notification.show("Please complete the form");
         	 return false;
         }

         var $url = "save_profile_info=yes&fname="+$fname+"&lname="+$lname+"&email="+$email;
         $.post("ajax/save.php", $url, function(e) {
         	 Notification.show(e);
         	 if(e.indexOf("successfully") != -1) {
         	 	 $(".information-form").fadeOut("slow").replaceWith(" ");
         	 	 $(".edit-profile").show();
         	 	 setTimeout(function() {
         	 	 	window.location.href = "cms_profile.php";
         	 	 }, 4000);
         	 }
         });

    },

    showPasswordForm: function() {
        $form  = $("<form />", {"class":"pass-form"});	
 		$pass1 = $("<input />", {"type":"password", "name":"pass1", "placeholder":" New Password "});
 		$pass2 = $("<input />", {"type":"password", "name":"pass2", "placeholder":" Confirm Password "});
 		$current_pass = $("<input />", {"type":"password", "name":"current-pass", "placeholder":" Current Password "});
 		$save_btn   = $("<button />", {"type":"button", "class":"update-pass button", "text":"Update Password"});
        $cancel_btn  = $("<button />", {"type":"button", "class":"cancel-pass-update button", "text":" Cancel "});
 		
 		$form.append($pass1).append($pass2).append($current_pass).append($save_btn).append($cancel_btn);

 		$save_btn.on("click", function(e) {
 			 e.preventDefault();
             Profile.updatePass();
 		});

 		$cancel_btn.on("click", function(e) {
 			 e.preventDefault();
             Profile.cancelPassUpdate();
 		});

     	$(".password-section").append($form);
     	$form.hide().fadeIn("slow");
     	$(".change-pass").hide(); 
    },

    cancelPassUpdate: function() {
         $(".pass-form").fadeOut("slow").replaceWith(" ");
         $(".change-pass").show();
    },

    updatePass: function() {
    	 var $pass1 = $(".pass-form input[name=pass1]").val();
         var $pass2 = $(".pass-form input[name=pass2]").val();
         var $current_pass = $(".pass-form input[name=current-pass]").val();
         
         if($pass1 == "" || $pass2 == "" || $current_pass =="") {
             Notification.show("Please complete the password form");
         	 return false;
         }
         if($pass1 != $pass2) {
         	 Notification.show("The two new passwords donnot match");
         	 return false;
         }
         
         var $url = "update_pass=yes&pass1="+$pass1+"&pass2="+$pass2+"&current_pass="+$current_pass;
         $.post("ajax/save.php", $url, function(e) {
         	 Notification.show(e);
         	 if(e.indexOf("successfully") != -1) {
         	 	 $(".pass-form").fadeOut("slow").replaceWith(" ");
         	 	 $(".change-pass").show();
         	 }
         });
    }
}