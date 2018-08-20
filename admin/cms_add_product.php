<?php
require_once("../includes/ad_initialize.php");

$page_title = "Add New Product";
$css        = "cms_add_product.css";
$js         = "cms_add_product.js";



include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">
   <section class="status-section">

   </section>

   <section class="product-buttons-section">
       <button id="save" class="green">Save</button>
       <button id="cancel">Cancel</button>
   </section>

   <section class="product-tab">
      <ul>
         <li id="product-info" class="tab info-tab  current">Product Information</li>
      </ul>
   </section>

   <section class="product-form-section">

      <form id="product-info-form" class="form">

         <fieldset><legend>Product Information</legend>

            <label>Product Name: </label>
            <input type="text" name="product_name" placeholder="Product Name" maxlength="75" />

            <label>Product Category: </label>
            <?php
              $cats = $Categories->gen_select_html("");
              if($cats) {
                 echo $cats;
              }
            ?>

            <label>Price of Product <small>(GH Cedis)</small>: </label>
            <input type="text" name="price" placeholder="Price of Product" />

            <label>Bonus Price: </label>
            <input type="text" name="bonus" placeholder="Product Offer (optional)" />

            <label>Product Priority: </label>
            <input type="text" name="priority" placeholder="Product priority eg. 3" />

            <label>Products in Stock: </label>
            <input type="text" name="stock" placeholder="Products in stock" />

             <label>Products Manufacturer: </label>
            <input type="text" name="manufacturer" placeholder="Manufacturer's Name" />


            <label>Date Manufactured: </label><br />
            <label>&nbsp; Year
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Month
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Day</label>

           <?php
            // Date select menu

            $Year  = (int) date("Y", time());
            $Day   = (int) date("j", time());
            $Month = (int) date("m", time());

            $date = gen_date_html($Year, $Month, $Day);
            echo $date;
           ?>

            <label>Product Specifications: </label>
            <textarea name="specs"></textarea>

            <label>Product Detailed Desciption: </label>
            <textarea name="description"></textarea>
            <input type="hidden" name="add_product" value="yes" />
         </fieldset>
         </form>
   </section>
</section>

<?php
include_template("ad_footer.php");
?>
