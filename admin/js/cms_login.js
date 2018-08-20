$(function() {
   $("button[name=login]").on("click", function(e) {
       e.preventDefault();
       Session.validateForm();
   });
});

var Session = {
	validateForm: function() {
		$status = $(".status p");
		$uname = $("input[name=uname]").val();
		$pass  = $("input[name=password]").val();

		if ($uname == "" || $pass == "") {
			$(".status p").html("Please enter your username and password");
			$(".status").fadeIn("slow");
			return false;
		} else {
			$(".status").fadeOut("slow");
		}
        $url  = "login=yes&uname="+$uname+"&pass="+$pass;
		$.post("ajax/session.php", $url, function(e) {
            if (parseInt(e, 10) === 1) {
            	window.location.href = "index.php";
            } else {
            	$(".status p").html("Invalid username and password combination");
			    $(".status").fadeIn("slow");
            }

		});
	}
}
