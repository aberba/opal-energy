<?php
require_once("../includes/ad_initialize.php");

$page_title = "Add New Service";
$css        = "cms_add_service.css";
$js         = "cms_add_service.js";

include_template("ad_header.php");
?>
<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>

<section id="content">
    <section class="buttons-section">
       <button id="save" class="button green">Save</button>
       <button id="cancel" class="button">Cancel</button>
       <span class="loader"><img src="img/icons/ajax-loader.gif"></span>
    </section>

    <section class="form-section">
      <form id="information-form" class="form">
         <fieldset class="clearfix"><legend>Product Information</legend>

         <label for="title">Service Title: </label>
         <input type="text" name="title" placeholder="Service Title" />

         <label for="priority">Service Priority: </label>
         <input type="text" name="priority" placeholder="Service Priority" />

         <label for="introduction">Introduction <small>250 characters</small>: </label>
         <textarea name="introduction" maxlength="250" placeholder="Introductory Description of service"></textarea>

         <label for="description">Detailed Desciption: </label>
         <textarea name="description" placeholder="Detailed Description of service"></textarea>

         <input type="hidden" name="add_service" value="yes" />
         </fieldset>
      </form>
    </section>

</section>

<?php
include_template("ad_footer.php");
?>
