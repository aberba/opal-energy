<?php
require_once("includes/pub_initialize.php");

$service_id = isset($_GET['service_id']) ? (int)$Database->clean_data($_GET['service_id']) : 0;

$service = $Services->find_by_id($service_id);
if(!$service) exit("Invalid service ID");


$page_title = htmlentities($service->title);
$css        = "service_information.css";
$js         = "service_information.js";

include_template("pub_header.php");
?>
<section id="content">
       <section class="information-section clearfix">
           <h2 class="title"><?php echo htmlentities($service->title); ?></h2>

           <p><?php echo $Services->insert_images($service->description); ?></p>
       </section>
</section>

<aside id="aside" class="green text-shadow">
   <?php include_template("pub_aside.php"); ?>
</aside>


<?php
include_template("pub_footer.php");
?>