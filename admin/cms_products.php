<?php
require_once("../includes/ad_initialize.php");


// Total Records
$total_records = (int) $Products->count_all();

// Pages Number
$current_page = isset($_GET['Page']) ? (int)$_GET['Page'] : 1;

// Sorting order
$sort         = isset($_GET['Sort']) ? $_GET['Sort'] : "Date";

// Initialize pagination
$Pagination  = new Pagination($current_page, $Settings->pagination_per_page(), $total_records);

// Fetch products
$Product_results = $Products->fetch_all($Pagination->offset(), $Settings->pagination_per_page(), $sort);

$page_title = "Products";
$css        = "cms_products.css";
$js         = "cms_products.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">

    <section class="products-section">
<?php

if($Product_results) {
      echo "
        <section class='sorting-section'>
            <ul>
                <li>Sort By:</li>
                <li><a href='cms_products.php?Sort=Name'>Product Name</a></li>
                <li><a href='cms_products.php?Sort=Date'>Date Added</a></li>
                <li><a href='cms_products.php?Sort=Priority'>Product Priority</a></li>
                <li><a href='cms_products.php?Sort=Price'>Product Price</a></li>
            </ul>
        </section>
      ";
      foreach($Product_results as $product => $value) {
          $product_id = $value->product_id;
          $image1_file = $Products->gen_product_dir().DS.$value->image_one;
          $status = ($value->ppublish == 1) ? "Unpublish" : "Publish";
           //set unedited image for unedited products
          $image_url = "../uploads/products/".$value->image_one;
          if(empty($value->image_one) || !is_file($image1_file)) {
              $image_url = "../img/template/not-yet-edited.png";
          }
?>
          <section class="product clearfix" id="product<?php echo $product_id; ?>">
             <h3><?php echo $value->product_name; ?></h3>
             <figure>
                <img src="<?php echo $image_url; ?>" />
             </figure>

             <div class="product-info">
                 <div class="options-bar">
                    <ul id="<?php echo $product_id; ?>">
                       <li><a class="button" href="cms_edit_product.php?product=<?php echo $product_id; ?>">Edit</a></li>
                       <li><a class="publish button" id="publish<?php echo $product_id; ?>" href="#"><?php echo $status; ?></a></li>
                       <li><a  class="delete button" id="delete<?php echo $product_id; ?>" href="#">Delete</a></li>
                    </ul>
                 </div>

                 <p><?php echo $value->specs; ?></p>

                 <table id="<?php echo $product_id; ?>">
                    <tr>
                       <td>Price: </td>
                       <td><?php echo $Settings->currency_symbol().$value->price; ?></td>
                    </tr>
                    <tr>
                       <td>Category:</td>
                       <td><?php echo $value->category_name; ?></td>
                    </tr>
                    <tr>
                       <td>Stock:</td>
                       <td><?php echo $value->stock; ?></td>
                    </tr>
                 </table>
             </div>
          </section>

<?php
      }
}else {
    echo "No products are added yet";
}
?>
   </section>


<?php
 // show pagination if there are more than one page
if($Pagination->total_pages() > 1) {
   echo "<section class='pagination-section clearfix'>";

    if($Pagination->has_previous_page()) {
        echo " <a class='previous' href='cms_products.php?Sort={$sort}&Page=";
        echo $Pagination->previous_page();
        echo "'>&laquo; Previous</a>";
   }

   // Shows pages Numbers
   for($i =1; $i <= $Pagination->total_pages(); $i++) {
      if($i == $current_page) {
          echo "<span class='current'>{$i}</span>";
      } else {
        echo "<a href='cms_products.php?Sort={$sort}&Page={$i}'>{$i}</a>";
      }
   }

   if($Pagination->has_next_page()) {
        echo " <a class='next' href='cms_products.php?Sort={$sort}&Page=";
        echo $Pagination->next_page();
        echo "'>Next &raquo; </a>";
   }

   echo "</section>";
} // end of if there are more than a page
?>


</section>

<?php
include_template("ad_footer.php");
?>
