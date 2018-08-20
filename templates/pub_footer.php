<?php
global $js, $Products, $Services, $Settings, $Options;
?>
    <footer id="footer">
      <div class="archive clearfix">
         <div id="products" class="group">
             <h3>Products</h3>

<?php
$products_list  = $Products->fetch_prioritized();
if($products_list) {
     $show_link = ($Options->show_products_read_more() == true) ? true : false;
     $output    = "<ul>";
     foreach ($products_list as $product => $value) {
         $link    = ($show_link === true) ? "/product_information.php?product_id=".$value->product_id : "#";
         $output .= "<li><a href='".$link."'>".$value->product_name."</a></li>";
     }
     $output .= "</ul>";
     echo $output;
}
?>
         </div>


         <div id="services" class="group">
             <h3>Services</h3>
             <ul>
<?php
$services_list  = $Services->fetch_prioritized();
if($services_list) {
     $output    = "<ul>";
     foreach ($services_list as $product => $value) {
         $link    = "/service_information.php?service_id=".$value->service_id."&service=".urlencode($value->title);
         $output .= "<li><a href='".$link."'>".$value->title."</a></li>";
     }
     $output .= "</ul>";
     echo $output;
}
?>
             </ul>
         </div>

         <div id="more" class="group">
             <h3>More</h3>
             <a href="<?php echo $Settings->facebook_link(); ?>" target="_blank"><img src="/img/social_media/facebook-icon.png" alt="Facebook" /></a>
             <a href="<?php echo $Settings->twitter_link(); ?>" target="_blank"><img src="/img/social_media/twitter-icon.png" alt="Twitter" /></a>
             <a href="<?php echo $Settings->linkedin_link(); ?>" target="_blank"><img src="/img/social_media/linkedin-icon.png" alt="Linkedin" /></a>
             <a href="<?php echo $Settings->youtube_link(); ?>" target="_blank"><img src="/img/social_media/youtube-icon.png" alt="Youtube" /></a>
         </div>
      </div>

      <div id="copyright">
        <p> &copy; <?php echo $Settings->site_name(). " " . date("Y", time()); ?></p>
      </div>
    </footer>
  </article>

<!-- JS Files -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
window.jQuery || document.write("<script src='\/js\/jquery-1.11.0.min.js'><\/script>");
</script>


<!-- HTML% Shiv & Modernizr-->
    <!--[if lt IE 9]>
       <script src="http://html5shiv.googlecode.com/svn/trunk/html5-els.js"></script>
       <script src="/js/modernizr.js" type="text/javascript"></script>
    <![endif]-->

<script type="text/javascript" src="/js/fscSlider.js"></script>
<script type="text/javascript" src="/js/general.js"></script>
<script type="text/javascript" src="/js/<?php echo @$js; ?>"></script>
</body>
</html>
