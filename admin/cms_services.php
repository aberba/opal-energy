<?php
require_once("../includes/ad_initialize.php");


$page_title = "Services";
$css        = "cms_services.css";
$js         = "cms_services.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">
     <section class="services-section">
<?php
$Services_result = $Services->fetch_all();
if($Services_result) {
	foreach ($Services_result as $service => $value) {
        $image_url = "../uploads/services/".$value->image_one;
        $status = ($value->publish == 1) ? "Unpublish" : "Publish";
		?>
	    <section class='service clearfix' id="service<?php echo $value->service_id; ?>">
	        <h3 class="title"><?php echo $value->title; ?></h3>
	    	<figure>
	    	     <img src="<?php echo $image_url; ?>" alt="<?php echo $value->title. " image"; ?>">
	    	</figure>

	    	<div class="info-section">
	    		<div class="options">
	    			<ul>
	    				<li><a class="button" href="cms_edit_service.php?service_id=<?php echo $value->service_id; ?>">Edit</a></li>
	    				<li><a class="button publish" id="publish<?php echo $value->service_id; ?>" href="#"><?php echo $status; ?></a></li>
	    				<li><a class="button delete" id="delete<?php echo $value->service_id; ?>" href="#">Delete</a></li>
	    			</ul>
	    		</div>

	    		<div><?php echo $value->introduction; ?></div>

	    		<table>
	    		    <tr>
	    				<td><strong>Priority: </strong></td>
	    				<td><?php echo $value->priority; ?></td>
	    			</tr>
	    			<tr>
	    				<td><strong>Date Added: </strong></td>
	    				<td><?php echo $value->date_added; ?></td>
	    			</tr>
	    		</table>
	    	</div>
	    </section>
<?php	}
}else {
	echo "<p>No services are added yet</p>";
}
?>
    </section>
</section>


<?php
include_template("ad_footer.php");
?>
