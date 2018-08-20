<?php
require_once("includes/pub_initialize.php");


$page_title = "Services";
$css        = "services.css";
$js         = "services.js";

include_template("pub_header.php");
?>


<section id="content">

   <section class="services-section">
<?php
$services = $Services->fetch_all();
if($services) {
   $class = "even";
   foreach ($services as $service => $value) {
      $class = ($class == "even") ? "odd" : "even";
      
      $description = $Database->clean_data($value->description);
      if(isset($value->description[240])) {
          $description = substr($value->description, 0, 240)." ...";
      }
?>
      <section class="service <?php echo $class; ?> clearfix">
         <figure>
            <img src="/uploads/services/<?php echo $value->image_one; ?>" alt="<?php echo $value->title. " image"; ?>" />
         </figure>
         <div>
            <h3><?php echo $value->title; ?></h3>
            <p><?php echo $description; ?> 
            <br /><br /> <a href="/service_information.php?service_id=<?php echo $value->service_id; ?>">Read More &raquo;</a></p>
         </div>
      </section> 
<?php   
   }
}else {
    echo "<p>No services are offered currently</p>";
}
?>
   </section><!-- End of services section -->
  
</section> <!-- End of content div -->


<aside id="aside" class="green text-shadow">
   <?php include_template("pub_aside.php"); ?>
</aside>




<?php
include_template("pub_footer.php");
?>