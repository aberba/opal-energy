<?php
require_once("../includes/ad_initialize.php");

$page_title = "Site Manager";
$css        = "cms_manager.css";
$js         = "cms_manager.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>

<section id="content">
   <section class='status-section clearfix'>
   	    <div class="group">
   	        <h4>Products</h4>
   	    	<ul>
   	    	    <li><?php echo $Products->count_all(); ?> Total</li>
   	    		<li><?php echo $Products->count_published(); ?> Published</li>
   	    		<li><?php echo $Products->count_unpublished(); ?> Unpublished</li>
   	    	</ul>
   	    </div>
   	    <div class="group">
   	        <h4>Categories</h4>
   	    	<ul>
   	    		<li><?php echo $Categories->count_all(); ?> Total</li>
   	    		<li><?php echo $Categories->count_published(); ?> Published</li>
   	    		<li><?php echo $Categories->count_unpublished(); ?> Unpublished</li>
   	    	</ul>
   	    </div>
   	    <div class="group">
   	        <h4>Services</h4>
   	    	<ul>
   	    		<li><?php echo $Services->count_all(); ?> Total</li>
   	    		<li><?php echo $Services->count_published(); ?> Published</li>
   	    		<li><?php echo $Services->count_unpublished(); ?> Unpublished</li>
   	    	</ul>
   	    </div>
   	    <div class="group">
   	        <h4>Administrators</h4>
   	    	<ul>
   	    		<li><?php echo $Administrators->count_all(); ?> Total</li>
   	    		<li><?php echo $Administrators->count_super_admin(); ?> Super Admin(s)</li>
   	    		<li><?php echo $Administrators->count_admin(); ?> Admin(s)</li>
   	    		<li><?php echo $Administrators->count_moderators(); ?> Moderator(s)</li>
   	    	</ul>
   	    </div>
   </section>

   <section class="upload-section clearfix">
       <button class="toggle-upload toggle button">Toggle Slide Upload</button>

       <div class="upload-container">
           <form class="slider-form form">
               <h3>Upload Slide</h3>

               <label for="title"> Slide Title: </label>
               <input type="text" name="title" placeholder="Enter slide title" maxlength="200">

               <label for="description"> Description: </label>
               <textarea name="description" placeholder="Enter slide description" maxlength="250"></textarea>

               <label for="slider-image">Select Slider Image</label>
               <input type="file" name="file">

               <button type="button" class="button slide-btn"> Upload </button>
           </form> <br>

           <form class="thumbs-form form">
               <h3>Upload Front Page Template Upload</h3>

               <label for="thumbs-image"> Select Upload Type: </label>
               <select>
                    <optgroup>
                        <option disabled="disabled"> Select Item Type </option>
                        <option value="products"> Products (285 X 160) </option>
                        <option value="services"> Services (285 X 160) </option>
                        <option value="forum"> Forum (285 X 160) </option>
                        <option value="logo"> logo (120 X 55) </option>
                    </optgroup>
               </select>

               <input type="file" name="banner-image">

           </form>
       </div>
   </section>


   <section class="template-slides-section">
        <button class="toggle-slides toggle button">Toggle Template Images</button>

        <div class="slides-container">
            <div class="slides clearfix">
<?php
$sliders = $Manager->fetch_slides();
if($sliders) {
     $output = "";
     foreach ($sliders as $slider => $value) {
         $status = ($value->publish == 1) ? "Unpublish" : "Publish";

         $output .= " <div class='slide' id='slide".$value->id."'>
                         <button id='publish".$value->id."' class='publish button'>".$status."</button>
                         <button id='delete".$value->id."' class='delete button'>Delete</button>

                         <img src='../uploads/slider/".$value->file_name."' alt=''>
                      </div>

                      <div id='slide-info". $value->id ."' class='slide-info'>
                          <h4>". $value->title ."</h4>
                          <p>". $value->description ."</p>
                      </div>
                      ";
     }
     echo $output;
}
?>
            </div>


            <div class="homepage-images clearfix">
                <h4>Homepage Thumbs</h4>
                <div class="products-thumb thumb clearfix">
                     <h5>Products</h5>
                     <figure>
                         <img src="../uploads/templates/<?php echo $Manager->products_thumb(); ?>" alt="">
                     </figure>
                </div>

                <div class="services-thumb thumb">
                     <h5>Services</h5>
                     <figure>
                         <img src="../uploads/templates/<?php echo $Manager->services_thumb(); ?>" alt="">
                     </figure>
                </div>

                <div class="faq-thumb thumb">
                     <h5>FAQ</h5>
                     <figure>
                         <img src="../uploads/templates/<?php echo $Manager->FAQ_thumb(); ?>" alt="">
                     </figure>
                </div>
            </div>
        </div>
   </section>


   <section class="map-section">
        <button class="toggle-map toggle button">Toggle Map</button>

        <div id="map-container" class="map-container"></div>
   </section>


   <section class="notification-section clearfix">
        <button class="toggle-notification toggle button">Toggle Notification</button>

        <div class="notification-container">
   	       <h4>Public Notification</h4><br />
       	   <table class="table">
       	        <tr>
       	           <th>Attribute</th> <th>Value <span class="edit clearfix"><img src="img/icons/edit.png"></span></th>
       	        </tr>
       	    	<tr>
       	    	   <td>Message</td> <td> Welcome to Opal Energy Solutions Admin</td>
       	    	</tr>
       	    	<tr>
       	    	   <td>Displayed</td> <td>No</td>
       	    	</tr>
       	    	<tr>
       	    	   <td>Added By</td> <td>Bash Loard</td>
       	    	</tr>
       	    	<tr>
       	    	   <td>Date to Expire</td> <td>21st March, 2014</td>
       	    	</tr>
       	    	<tr>
       	    	   <td>Date Added</td> <td>21st March, 2014</td>
       	    	</tr>
       	    </table>
        </div>
   </section>

</section>


<?php
include_template("ad_footer.php");
?>
