<?php
require_once("includes/pub_initialize.php");

$page_title = "Search";
$css        = "products.css";
$js         = "products.js";

$query = (isset($_GET['find'])) ? $Database->clean_data($_GET['find']) : "";

include_template("pub_header.php");
?>
<section id="content">
   <section id="products-section clearfix">
<?php
if(empty($query)) {
     echo "<h3 class='results-title'>Please type something to search</h3>";
}elseif (!isset($query[2])) {
     echo "<h3 class='results-title'>Please type a keyword to search</h3>";
}else {
     $results = $Products->find_by_name($query);
     if($results) {
         echo "<h3 class='results-title'>Search results for <em>{$query}</em></h3>";

         foreach ($results as $product => $value) {
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
                           $specs =  substr($value->specs, 0, 85)." ...";
                       }
                       echo "<p class='specs'>". htmlentities($specs). "</p>";
                   }
           
                   if($Options->show_products_price()) {
                      echo "<p>Price: <strong>".$Settings->currency_symbol()."</strong> ". $value->price."</p>";
                   }

                   if($Options->show_products_read_more()) {
                      echo "<p class='link'><a href='/product-information/". $product_id."/'>Read More &raquo; </a></p>";
                   }
?>
                  </figcaption>
             </figure>
         </section>  

<?php
         }
     } else { //If there are no results
         echo "<h3 class='results-title'>No results found for <em>{$query}</em></h3>";
     }
} 

?>    

   </section> 
</section>

<aside id="aside" class="green text-shadow">
   <?php include_template("pub_aside.php"); ?>
</aside>





<?php
include_template("pub_footer.php");
?>