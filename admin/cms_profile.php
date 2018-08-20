<?php
require_once("../includes/ad_initialize.php");


$session_user = $Session->user();
$user_id      = $session_user['id'];
$user_role    = $Administrators->get_level($session_user['level']);
$profile = $Administrators->find_by_id($user_id);

if(!$profile) {
	exit("<p>No record of your information was found, please contact the system administrators</p>");
}

$page_title = "User Profile";
$css        = "cms_profile.css";
$js         = "cms_profile.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">
     <section class="information-section clearfix">
     	  <button class="edit-profile button">Edit Profile</button><br>

     	  <table class="table">
               <tr>
                  <td>First Name: </td>    <td><?php echo $profile->first_name; ?></td>
               </tr>
               <tr>
                  <td>Last Name: </td>     <td><?php echo $profile->last_name; ?></td>
               </tr>
               <tr>
                  <td>Email Address: </td> <td><?php echo $profile->email; ?></td>
               </tr>
               <tr>
                  <td>Role: </td>          <td><?php echo $user_role; ?></td>
               </tr>
     	  </table>
     </section>

     <section class="password-section">
          <button class="change-pass button">Change Your Password: </button>
     </section>
</section>


<?php
include_template("ad_footer.php");
?>
