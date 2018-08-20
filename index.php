<?php
require_once("includes/pub_initialize.php");

$page_title = "Homepage";
$css        = "home.css";
$js         = "home.js";

include_template("pub_header.php");
?>
    <section class="slider-section clearfix">
<?php
$slides_result = $Manager->fetch_slides();
if($slides_result) {
      $images_path = "/uploads/slider/";
      $slider      = "<div class='fscslider'>";

      foreach ($slides_result as $s => $value) {

          $slider .= "<img src='".$images_path . $value->file_name."' alt='". $value->title ."' data-tooltipheader='".$value->title."' data-tooltipcontent='".$value->description."' />";

      }
      $slider .= "</div>";

      echo $slider;
}
?>
    </section>


    <section class="thumbs-section clearfix"> <br />
        <div id="thumb-one" class="item-thumb">
            <h3><a href="/products.php?category=all">Products</a></h3>
            <figure>
               <a href="/products.php?category=all"><img src="/uploads/templates/<?php echo $Manager->products_thumb(); ?>" /></a>
            </figure>
            <p><?php echo $Settings->products_thumb_intro(); ?> <a href="/products.php?category=all">&nbsp;View &raquo;</a></p>
        </div>

        <div id="thumb-two" class="item-thumb">
            <h3><a href="/services.php">Services</a></h3>
            <figure>
               <a href="/services.php"><img src="/uploads/templates/<?php echo $Manager->services_thumb(); ?>" /></a>
            </figure>
            <p><?php echo $Settings->services_thumb_intro(); ?> <a href="/services.php">&nbsp;View &raquo;</a></p>
        </div>

        <div id="thumb-three" class="item-thumb">
            <h3><a href="/faq.php">FAQ</a></h3>
            <figure>
               <a href="/faq.php"><img src="/uploads/templates/<?php echo $Manager->FAQ_thumb(); ?>" /></a>
            </figure>
            <p><?php echo $Settings->faq_thumb_intro(); ?> <a href="/faq.php">&nbsp;View &raquo;</a></p>
        </div>
    </section>

<?php
include_template("pub_footer.php");
?>
