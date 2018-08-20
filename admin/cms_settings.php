<?php
require_once("../includes/ad_initialize.php");


$page_title = "Pages Settings";
$css        = "cms_settings.css";
$js         = "cms_settings.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">

    <section class="table-section">
<?php
$settings_list = $Settings->fetch_basic();
if($settings_list) {
	echo "<table class='table'>
	         <tr>
	            <th>Settings Name</th>
	            <th>Settings Value <span class='edit clearfix'><img src='img/icons/edit.png'></span></th>
	         <tr>";
	$class = "even";
	foreach ($settings_list as $setting => $value) {
		  $class = ($class == "even") ? "odd" : "even";
		  $setting_name = str_replace("_", " ", $value->setting_name);
	?>
             <tr class="<?php echo $class; ?>">
	            <td><?php echo $setting_name; ?></td>
	            <td class="value" contenteditable="false" id="<?php echo $value->setting_id; ?>"><?php echo $value->setting_value; ?></td>
	         <tr>
<?php
	}
	echo "</table>";
}
?>
    </section>

    <section class="advanced-settings-section">
    	 <h4>Advanced Settings</h4>
    	 <button class="show-form button">Show Advanced Settings</button>
    </section>
</section>


<?php
include_template("ad_footer.php");
?>
