<?php
require_once("../includes/ad_initialize.php");


if(!isset($_GET['product']))  exit("Invalid Product ID");

$product_id = (int) $Database->clean_data($_GET['product']);

$product = $Products->find_by_id($product_id);

if(!$product) exit("No record of product was found");

$images_url = "../uploads/products/";

$page_title = "Edit ".$product->product_name;
$css        = "cms_edit_product.css";
$js         = "cms_edit_product.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">
   <section id="status-section">

   </section>

   <section class="product-buttons-section">
       <button id="save" class="green">Save</button>
       <button id="cancel" class="">Cancel</button>
       <span class="loader"><img src="img/icons/ajax-loader.gif"></span>
   </section>

   <section class="product-tab">
      <ul>
         <li id="product-info" class="tab info-tab  current">Product Information</li>
         <li id="product-images" class="tab images-tab">Product Images</li>
      </ul>
   </section>

   <section class="product-form-section">

      <form id="product-info-form" class="form">
         <fieldset class="clearfix"><legend>Product Information</legend>

         <label>Product Name: </label>
         <input type="text" name="product_name" placeholder="Product Name" maxlength="75"
         value="<?php echo $product->product_name; ?>" />


         <label>Product Category: </label>
         <?php
           $cats = $Categories->gen_select_html($product->category_id);
           if($cats) {
              echo $cats;
           }
         ?>

         <label>Price of Product: </label>
         <input type="text" name="price" value="<?php echo $product->price; ?>"
         placeholder="Price of Product" />

         <label>Bonus Price: </label>
         <input type="text" name="bonus" value="<?php echo $product->bonus; ?>"
         placeholder="Product Offer (optional)" />

         <label>Product Priority: </label>
         <input type="text" name="priority" value="<?php echo $product->priority; ?>"
         placeholder="Product priority eg. 3" />

         <label>Products in Stock: </label>
         <input type="text" name="stock" value="<?php echo $product->stock; ?>"
         placeholder="Number in stock" />

         <label>Product Manufacturer: </label>
         <input type="text" name="manufacturer" value="<?php echo $product->manufacturer; ?>" placeholder="Manufacturer's Name" />

         <label>Date Manufactured: </label><br />
         <label>&nbsp; Year
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Month
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Day</label>

         <?php
         // Date select menu

           $unix_timestamp = $product->date_made;
           $Year  = (int) date("Y", $unix_timestamp);
           $Day   = (int) date("j", $unix_timestamp);
           $Month = (int) date("n", $unix_timestamp);

           $date = gen_date_html($Year, $Month, $Day);
           echo $date;
         ?>

         <label>Product Specifications: </label>
         <textarea name="specs"><?php echo $product->specs; ?></textarea>

         <label>Product Detailed Desciption: </label>
         <textarea name="description"><?php echo $product->description; ?></textarea>

         <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
         <input type="hidden" name="save_product" value="yes" />
         </fieldset>
        </form>



         <form id="product-images-form" data-productid="<?php echo $product_id; ?>" class="form">
             <fieldset class="clearfix"><legend>Product Images</legend>

             <p>Note: The recommended size for images is 440 X 310</p><br>
             <p>Images aspect ratio must be kept constant to ensure best user experience</p>

             <div class="file-section clearfix">
                <div class="input-box">
                   <label for="image1">Image One</label>
                   <input type="file" id="<?php echo $product_id; ?>" name="image_one" />
                </div>

                <div id="image-preview" class="image_one_preview">
                   <img src="<?php echo $images_url.$product->image_one; ?>" alt="Image One" />
                   <a href="#" id="1" class="delete"> delete </a>
                </div>
             </div>

             <div class="file-section clearfix">
                <div class="input-box">
                   <label for="image2">Image Two</label>
                   <input type="file" id="<?php echo $product_id; ?>" name="image_two" />
                </div>
                <div id="image-preview" class="image_two_preview">
                   <img src="<?php echo $images_url.$product->image_two; ?>" alt="Image Two" />
                    <a href="#" id="2" class="delete"> delete </a>
                </div>
             </div>

             <div class="file-section clearfix">
                <div class="input-box">
                   <label for="image3">Image Three</label>
                   <input type="file" id="<?php echo $product_id; ?>" name="image_three" />
                </div>
                <div id="image-preview" class="image_three_preview">
                    <img src="<?php echo $images_url.$product->image_three; ?>" alt="Image Three" />
                     <a href="#" id="3" class="delete"> delete </a>
                </div>
             </div>

             <div class="file-section clearfix">
                <div class="input-box">
                   <label for="image4">Image Four</label>
                   <input type="file" id="<?php echo $product_id; ?>" name="image_four" />
                </div>
                <div id="image-preview" class="image_four_preview">
                   <img src="<?php echo $images_url.$product->image_four; ?>" alt="Image Four" />
                    <a href="#" id="4" class="delete"> delete </a>
                </div>
             </div>

             <div class="file-section clearfix">
                <div class="input-box">
                   <label for="image5">Image Five</label>
                   <input type="file" id="<?php echo $product_id; ?>" name="image_five" />
                </div>
                <div id="image-preview" class="image_five_preview">
                   <img src="<?php echo $images_url.$product->image_five; ?>" alt="Image Five" />
                    <a href="#" id="5" class="delete"> delete </a>
                </div>
             </div>

             <div class="file-section clearfix">
                <div class="input-box">
                   <label for="image6">Image Six</label>
                   <input type="file" id="<?php echo $product_id; ?>" name="image_six" />
                </div>
                <div id="image-preview" class="image_six_preview">
                   <img src="<?php echo $images_url.$product->image_six; ?>" alt="Image Six" />
                    <a href="#" id="6" class="delete"> delete </a>
                </div>
             </div>
         </fieldset>
      </form>

   </section>
</section>


<?php
include_template("ad_footer.php");
?>
