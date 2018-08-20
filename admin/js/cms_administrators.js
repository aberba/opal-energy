$(function() {
	//show and hide add form
     $(".form-section button.add").on("click", function(e) {
     	  e.preventDefault();
     	  $(this).hide();
          Administrator.showAddForm();
     });

     $(".form-section button.save").on("click", function(e) {
     	  e.preventDefault();
     	  Administrator.add();
     });

     $(".form-section button.cancel").on("click", function(e) {
     	  e.preventDefault();
          Administrator.removeAddForm();
     });

     $("button.delete").on("click", function(e) {
     	  e.preventDefault();
          var $this  = $(this);
          var $id     = $this.attr("id");
          Administrator.authenticateDelete($id);
     });
});

Administrator = {
	add: function() {	
		   var $uname = $("input[name=uname]").val().trim();
     	 var $level = $("select[name=level]").val().trim();
     	 var $pass1 = $("input[name=pass1]").val();
     	 var $pass2 = $("input[name=pass2]").val();

     	 if($uname == "" || $level == "" || $pass1 =="" || $pass2 == "") {
     	  	  Notification.show("Please complete the form");
     	  	  return false;
     	 }else if($pass1 != $pass2) {
     	  	  Notification.show("The two passwords donnot match");
     	  	  return false;
     	 }else if($pass1.length < 8) {
            Notification.show("Password must bes at least 8 characters");
            return false;
       }

     	 $url = encodeURI("add_admin=yes"+"&uname="+$uname+"&level="+$level+"&pass1="+$pass1+"&pass2="+$pass2);
     	 $.post("ajax/save.php", $url, function(e) {
              if(e.contains("successfully")) {
               	   Administrator.removeAddForm();
              }
              Notification.show(e);
     	 });
	},
  
  authenticateDelete: function(id) {
      var $pass = window.prompt("Please enter your password to proceed ...");
      $auth_url = "confirm=yes&user_id="+id+"&pass="+$pass;
      $.post("ajax/session.php", $auth_url, function(e) {
         //alert(e);
         if(e == 1) {
              var $confirmation = window.confirm("Are you sure you want to delete this user?");
              if($confirmation) {
                  Administrator.remove(id);
              }else {
                  Notification.show("Action has been cancelled");
              }
         }else if(e == 2) {
              Notification.show("You donnot have permission to delete this user");
         }else {
              Notification.show("Authentication failed, invalid password");
         }
      });
  },
	 remove: function($id) {
	 	if($id == "") return false;
	 	var $id = parseInt($id);
	 	$url = "remove_admin=yes&id="+$id;

	 	$.post("ajax/delete.php", $url, function(e) {
	 		  if(e.indexOf("successfully") != -1) {
	 			   $("table tr#"+$id).fadeOut("slow");
	 		  }
        Notification.show(e);
	 	});
	 },
   
	 showAddForm: function() {
	 	 // hide btns
	 	 $(".form-section button.cancel").fadeIn();
         $(".form-section button.save").fadeIn();

	 	 $namebox  = $("<input />", {"type":"text", "value":"", "name":"uname", "placeholder":"Enter username"});
	 	 $passbox1  = $("<input />", {"type":"password", "name":"pass1", "placeholder":"Enter password"});
	 	 $passbox2  = $("<input />", {"type":"password", "name":"pass2", "placeholder":"Confirm password"});
         
         $opt = $("<option />", {"value":"", "text":"Select User Level"});
         $admin_sup = $("<option />", {"value":"3", "text":"Super Administrator"});
         $admin     = $("<option />", {"value":"2", "text":"Administrator"});
         $admin_mod = $("<option />", {"value":"1", "text":"Moderator"});
	 	 $level = $("<select />", {"name":"level"}).append($opt).append($admin_sup).append($admin).append($admin_mod);

	 	 $form = $("<form />", {"class":"add-form form"}).append($namebox).append($level).append($passbox1).append($passbox2);
	 	 $(".form-section").prepend($form).fadeIn(1000); 
	 },
	 removeAddForm: function() {
	 	 $(".form-section button.add").fadeIn();
         $(".form-section button.save").fadeOut();
         $(".form-section button.cancel").fadeOut();
	 	 $(".form-section .add-form").fadeOut("slow").replaceWith(" ");
	 }
}