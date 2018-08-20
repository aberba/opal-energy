<?php
require_once("../includes/ad_initialize.php");

$user = $Session->user();

$page_title = "Dashboard";
$css        = "cms_dashboard.css";
$js         = "cms_dashboard.js";
include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">
   <section class="quick-links-section text-shadow clearfix">
         <div class="welcome">
         	  <h3>Welcome to <?php echo $Settings->site_name(); ?></h3>
         	  <p>You are logged in as <a href="cms_profile.php"><?php echo $user['fullname']; ?></a></p>
         </div>

   	     <div class="group">
   	          <h4>Quick Actions</h4>
   	          <ul>
   	          	  <li><a href="cms_add_product.php">+Add New Product</a></li>
   	          	  <li><a href="cms_categories.php">+Add New Category</a></li>
   	          	  <li><a href="cms_add_service.php">+Add New Service</a></li>
   	          </ul>
   	     </div>

   	     <div class="group">
   	          <h4>Update</h4>
   	          <ul>
   	              <li><a href="cms_profile.php">Your Profile</a></li>
   	          	  <li><a href="cms_settings.php">Settings</a></li>
   	          	  <li><a href="cms_options.php">Options</a></li>
   	          </ul>
   	     </div>

   	     <div class="group">
   	          <h4>Current Status</h4>
   	          <ul>
   	          	  <li><?php echo $Products->count_all(); ?> Products</li>
   	          	  <li><?php echo $Categories->count_all(); ?> Categories</li>
   	          	  <li><?php echo $Services->count_all(); ?> Services</li>
   	          	  <li><?php echo $Administrators->count_all(); ?> Administrators</li>
   	          </ul>
   	    </div>
   </section>
</section>


<?php
include_template("ad_footer.php");
?>
