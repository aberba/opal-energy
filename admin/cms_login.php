<?php
require_once("../includes/ad_initialize.php");

if($Session->logged_id() && $Session->is_moderator()) {
	redirect_to("index.php");
}
//echo $Secure->password_secure("test");
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8" />
	<title>Login | <?php echo $Settings->site_name(); ?></title>

	<link rel="stylesheet" type="text/css" href="css/cms_login.css">
</head>
<body>

<section id="wrapper">
	 <form class="form text-shadow">
	    <h1>Opal Energy Solutions</h1>

	    <div class="status"><p></p></div>

	    <p>
	 	   <label for="uname">Username</label>
	 	   <input type="text" name="uname" placeholder="Enter your username" />
	    </p>

	    <p>
	 	   <label for="password">Password</label>
	 	   <input type="password" name="password" placeholder="Enter your password" />
	 	</p>
	 	<button type="button" name="login">Login Into My Account</button>
	 </form>
</section>

<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="js/cms_login.js"></script>
</body>
</html>
