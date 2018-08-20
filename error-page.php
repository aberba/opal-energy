<?php
require_once("includes/pub_initialize.php");

$page_title = "Request Not Found";
$css        = "error-page.css";
$js         = "";

include_template("pub_header.php");
?>
<section id="content">
   <section class="message-section">
       <figure>
           <img src="img/templates/brainy-smurf.png" alt="Not foung robot">
       </figure>

       <p>Sorry, the resource you requested could not be found. <br>It may have been removed or you provided an invalid request address.</p>
       <p>&laquo; Back to <a href="/">homepage</a></p>
   </section>
</section>

<aside id="aside" class="green text-shadow">
   <?php include_template("pub_aside.php"); ?>
</aside>
<?php
include_template("pub_footer.php");
?>
