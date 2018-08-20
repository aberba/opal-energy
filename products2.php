<?php
require_once("includes/pub_initialize.php");

$page_title = "Products";
$css        = "products.css";
$js         = "products.js";

include_template("pub_header.php");

// $_GET parameters
$category_name = isset($_GET['category']) ? urldecode($_GET['category']) : "all";
$current_page  = isset($_GET['page'])     ? (int)$_GET['page']     : 1;
$sort          = isset($_GET['sort'])     ? urlencode($_GET['sort']) : "date";
$total_records = (int)$Products->count_all($category_name);

// Escaped category name for links
$cat_url_name = urlencode($category_name);

// Initialize pagination
$Pagination  = new Pagination($current_page, $Settings->pagination_per_page(), $total_records);
// Fetch products
$Product_results = $Products->fetch_all($category_name, $Pagination->offset(), $Settings->pagination_per_page(), $sort);
?>

<section id="content">
<?php  
    if($Product_results) { 
?>
       <section id="sorting-section" class="green">
             <ul>
                <li>Sort by: </li>
                <li><a href="/products.php?category=<?php echo $cat_url_name; ?>&sort=name">Product Names</a></li>
                <li><a href="/products.php?category=<?php echo $cat_url_name; ?>&sort=date">Date Added</a></li>
             </ul>
       </section>
<?php
         foreach($Product_results as $product => $value) {
            $product_id = $value->product_id;
            $image_file = SITE_URL."/uploads/products/".$value->image_one; 
            $bonus      = ($value->bonus == null) ? "" : " Bonus: ".$value->bonus;
?>
            <section id="product<?php echo $product_id; ?>" class="product">
               <h3 class="name"><?php echo $value->product_name;  ?></h3>

               <figure>
                   <img id="<?php echo $product_id; ?>" src="<?php echo $image_file; ?>" alt="<?php echo $value->product_name. " image"; ?>" />
                   
                   <figcaption class="product-info">
<?php           
                   if($Options->show_products_specs()) {
                       // Do substring if specs text is long
                       $specs = $value->specs;
                       if(isset($value->specs[85])) {
                           $specs =  substr($value->specs, 0, 102)." ...";
                       }
                       echo "<p class='specs'>". htmlentities($specs). "</p>";
                   }
           
                   if($Options->show_products_price()) {
                      echo "<p>Price: <strong>".$Settings->currency_symbol()."</strong> ". $value->price."</p>";
                   }

                   if($Options->show_products_read_more()) {
                      echo "<p class='link'><a href='/product_information.php?product_id=". $product_id."&product_name".urlencode($value->product_name)."'>Read More &raquo; </a></p>";
                   }
?>
                   </figcaption>
               </figure>
            </section>  
<?php    
         } // End of the foreach loop

    }else {
        echo "<p>No products are added under this category</p>";
    } // end of if there are added products 
?>

<?php
 // show pagination if there are more than one page
if($Pagination->total_pages() > 1) {
   echo "<section class='pagination-section clearfix'>";

    if($Pagination->has_previous_page()) {
        echo " <a class='previous' href='/products.php?category={$cat_url_name}&sort={$sort}/";
        echo $Pagination->previous_page();
        echo "/'>&laquo; Previous</a>";
   }

   // Shows pages Numbers
   for($i =1; $i <= $Pagination->total_pages(); $i++) {
      if($i == $current_page) {
          echo "<span class='current'>{$i}</span>";
      } else {
        echo "<a href='/products.php?category={$cat_url_name}&sort={$sort}&page={$i}'>{$i}</a>";
      }
   }

   if($Pagination->has_next_page()) {
        echo " <a class='next' href='/products.php?category={$cat_url_name}&sort={$sort}";
        echo $Pagination->next_page();
        echo "/'>Next &raquo; </a>";
   }
         
   echo "</section>";
} // end of if there are more than a page
?>
</section> <!-- End of content div -->

<aside id="aside" class="green text-shadow">
   <?php include_template("pub_aside.php"); ?>
</aside>




<?php
include_template("pub_footer.php");
?>