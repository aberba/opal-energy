<?php
require_once("includes/pub_initialize.php");

if(!$Options->show_products_read_more()) {
    //echo "<p>No results found</p><a href='/'>&laquo; Back to homepage</a></p>";
    redirect_to("error-page.php");
    exit();
}

if(!isset($_GET['product_id'])) exit("No results found");

$product_id = $Database->clean_data($_GET['product_id']);

$Product_info = $Products->find_by_id($product_id);
if(!$Product_info) exit("Invalid service ID");

$image_file = SITE_URL."/uploads/products/".$Product_info->image_one;


$page_title = htmlentities($Product_info->product_name);
$css        = "product_information.css";
$js         = "product_information.js";

include_template("pub_header.php");
?>
<section id="content">
       <section class="information-section clearfix">
           <h3 class="title"><?php echo htmlentities($Product_info->product_name); ?></h3>

           <figure class="image-container">
              <img src="<?php echo $image_file; ?>" alt="Product image" width="650">
           </figure>

           <div class="listing-container">
               <p class="specs">
                   <?php
                    if($Options->show_products_specs()) {
                        echo $Product_info->specs;
                    }
                   ?>
               </p>

               <table>
                 <?php
                 if($Options->show_products_price()) {
                    echo "<tr>
                              <td>Price: </td>  <td>".$Settings->currency_symbol() . $Product_info->price."</td>
                          </tr>";
                 }

                 if($Options->show_bonus_offer()) {
                    echo "<tr>
                              <td>Bonus Offer: </td>  <td>".$Product_info->bonus. "</td>
                          </tr>";
                 }

                 if($Options->show_products_stock()) {
                    echo "<tr>
                              <td>In Stock: </td>  <td>".$Product_info->stock."</td>
                          </tr>";
                 }

                 if($Options->show_manufacturer()) {
                    echo "<tr>
                              <td>Manufacturer: </td>  <td>".$Product_info->manufacturer."</td>
                          </tr>";
                 }

                  if($Options->show_date_made()) {
                    echo "<tr>
                              <td>Date Made: </td>  <td>".$Dates->gen_product_date($Product_info->date_made)."</td>
                          </tr>";
                 }
                  ?>
               </table>
           </div>


           <div class="description-section clearfix">
               <h3>Product Description</h3>
               <p><?php echo $Products->insert_images($Product_info->description); ?></p>
           </div>

       </section>
</section>

<aside id="aside" class="green text-shadow">
   <?php include_template("pub_aside.php"); ?>
</aside>


<?php
include_template("pub_footer.php");
?>
