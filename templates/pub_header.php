<?php
global $meta_author, $meta_title, $meta_type, $meta_description, $meta_url,
       $page_title, $css, $js, $Settings, $Manager;
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/ico" href="/img/templates/favicon.ico" />
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	  <meta http-equiv="content-type" content="text/html" charset="utf-8" />

	  <meta name="author" content="<?php echo @$meta_author; ?>" />
    <meta name="description" content="<?php echo @$meta_description ?>" />
    <meta property="og:type" content="blog" />
    <meta property="og:url" content="<?php echo @$meta_url; ?>" />
    <meta property="og:description" content="<?php echo @$meta_description ?>" />

    <!--  CSS Files -->
    <link rel="stylesheet" href="/css/normalize.css" />
    <link rel="stylesheet" href="/css/general.css" />
    <link rel="stylesheet" href="/css/<?php echo @$css; ?>" />

	<title><?php echo @$page_title." | ".@$Settings->site_name(); ?></title>
</head>

<body>

<article id="wrapper"> <!-- Wrapper -->
  <!-- Header -->
  <header id="header" class="green clearfix" role="Header">
        <div id="logo" role="Logo">
          <a href="<?php echo SITE_URL; ?>"><img src="/uploads/templates/<?php echo $Manager->logo_image(); ?>" /></a>
        </div>

        <nav id="navigation" class="text-shadow" role="Navigation">
          <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/products.php?category=all">Products</a></li>
            <li><a href="/services.php">Services</a></li>
            <li><a href="/faq.php">FAQ</a></li>
            <li><a href="/contact.php">Contact</a></li>
          </ul>
        </nav>

        <form action="/search.php" method="get" id="search-form" role="Search_Form">
           <input type="text" name="find" placeholder="  Search ..." autocomplete="off" />
           <input type="submit" value="Search" class="green" />
        </form>
  </header>
