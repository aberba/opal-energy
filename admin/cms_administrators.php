<?php
require_once("../includes/ad_initialize.php");

if(!$Session->is_admin()) {
	echo "<h3>Sorry! you donot have permission to view this content</h3>
	       <a href='index.php'>&laquo; Back to Dashboard </a>";
	       exit();
}

$session_id = $Session->user()['id'];

$page_title = "Administrators";
$css        = "cms_administrators.css";
$js         = "cms_administrators.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">
   <section class="form-section">
   	   <button type="button" class="add button green">+ Add New Administrator</button>
   	   <button type="button" class="save button">Save</button>
   	   <button type="button" class="cancel button">Cancel</button>
   </section>

   <section class="table-section">
<?php
$admins = $Administrators->fetch_all();
if($admins) {
	echo "<table class='table'>
	         <tr>
	            <th>Full Name</th>
	            <th>Username</th>
	            <th>Role</th>
	            <th>Last Login</th>
	            <th>Options</th>
	         </tr>";
	foreach ($admins as $admin => $value) {
?>
	       <tr id="<?php echo $value['id']; ?>">
	           <td><?php echo $value['fullname']; ?></td>
	           <td><?php echo $value['user_name']; ?></td>
	           <td><?php echo $value['level']; ?></td>
	           <td class='timeago'><?php echo $value['last_login'] ?></td>
	           <td>
	           	   <?php
	           	   if($session_id != $value['id']) echo "<button id='".$value['id']."' class='delete button' title='Delete'> X </button>";
	           	   ?></td>
	       </tr>
<?php
	}
	echo "</table>";
}

?>
   </section>
</section>


<?php
include_template("ad_footer.php");
?>
