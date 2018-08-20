<?php
global $Session, $Settings, $Options, $page_title, $css, $js;  // Globals

if(!$Session->logged_id() || !$Session->is_moderator()) {
	redirect_to("cms_login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/ico" href="/img/templates/favicon.ico" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />

	  <title><?php echo $page_title." | ".$Settings->site_name(); ?></title>

    <link rel="stylesheet" href="css/cms_general.css" />
    <link rel="stylesheet" href="css/<?php echo $css; ?>" />
</head>

<body>
<article id="wrapper" class="clearfix">
   <header id="header" class="clearfix">
      <div class="banner green">
          <h1><?php echo $Settings->site_name(). " CMS"; ?></h1>
      </div>
      <div class="navigation">
          <ul>
              <li><a href="cms_add_product.php"> + ADD PRODUCT </a></li>
              <li><a href="cms_add_service.php"> + ADD SERVICE </a></li>
              <li><a class="send-mail" href="#"> SEND MAIL </a></li>
              <li><a href="logout.php"> LOGOUT ( <?php echo @$_SESSION['op_name']; ?> )</a></li>
              <li><a href="/index.php"> Go To Public Area </a></li>
          </ul>
      </div>
   </header>
