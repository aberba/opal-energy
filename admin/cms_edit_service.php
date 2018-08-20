<?php
require_once("../includes/ad_initialize.php");


if(!isset($_GET['service_id'])) exit("Invalid service ID");

$service_id = (int)$Database->clean_data($_GET['service_id']);
$service = $Services->find_by_id($service_id);
if(!$service) exit("No record of service was found");

$page_title = "Edit ".$service->title;
$css        = "cms_edit_service.css";
$js         = "cms_edit_service.js";

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

   <section class="navigation-tab">
      <ul>
         <li id="information" class="tab info-tab  current">Service Information</li>
         <li id="images" class="tab images-tab">Service Images</li>
      </ul>
   </section>

   <section class="product-form-section">
      <form id="information-form" class="form">
         <fieldset class="clearfix"><legend>Product Information</legend>

         <label for="title">Service Title: </label>
         <input type="text" name="title" placeholder="Service Title"
         value="<?php echo $service->title; ?>" />

         <label for="priority">Service Priority: </label>
         <input type="text" name="priority" value="<?php echo $service->priority; ?>"
         placeholder="Priority" />

         <label for="introduction">Introduction <small>250 characters</small>: </label>
         <textarea name="introduction" maxlength="250" placeholder="Introductory Description of service"><?php echo $service->introduction; ?></textarea>

         <label for="description">Detailed Desciption: </label>
         <textarea name="description" placeholder="Detailed Description of service"><?php echo $service->description; ?></textarea>

         <input type="hidden" name="service_id" value="<?php echo $service_id; ?>" />
         <input type="hidden" name="save_service" value="yes" />
         </fieldset>
      </form>



      <form id="images-form" class="form">
          <fieldset class="clearfix"><legend>Product Images</legend>
          <p>Note: The recommended size for images is 440 X 310</p><br>
          <p>Images aspect ratio must be kept constant to ensure best user experience</p>

            <?php
            $images_url = "../uploads/services/"

            ?>
            <div class="file-section clearfix">
                <div class="input-box">
                   <label for="image_one">Image One</label>
                   <input type="file" id="<?php echo $service_id; ?>" name="image_one" />
                </div>

                <div id="image-preview" class="image_one_preview">
                   <img src="<?php echo $images_url.$service->image_one; ?>" alt="Image One" />
                </div>
            </div>

            <div class="file-section clearfix">
                <div class="input-box">
                   <label for="image_two">Image Two</label>
                   <input type="file" id="<?php echo $service_id; ?>" name="image_two" />
                </div>
                <div id="image-preview" class="image_two_preview">
                   <img src="<?php echo $images_url.$service->image_two; ?>" alt="Image Two" />
                </div>
            </div>

            <div class="file-section clearfix">
                <div class="input-box">
                   <label for="image_three">Image Three</label>
                   <input type="file" id="<?php echo $service_id; ?>" name="image_three" />
                </div>
                <div id="image-preview" class="image_three_preview">
                    <img src="<?php echo $images_url.$service->image_three; ?>" alt="Image Three" />
                </div>
            </div>
          </fieldset>
      </form>

   </section>

</section>


<?php
include_template("ad_footer.php");
?>
