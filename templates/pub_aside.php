<!-- NOTE: All aside css and Js are coded here -->


<!-- Aside CSS -->
<?php

global $Categories;

?>

<!-- Aside Wrapper -->
<section class="aside-wrapper">
    <div class="aside-section categories">
        <?php
            $category_list = $Categories->fetch_all();
            if($category_list) {
              echo "<div id='aside-section'>
                       <h3>Product Categories</h3>
                       <ul>";
                foreach ($category_list as $category => $value) {
                    echo "<li><a href='/products.php?category=".urldecode($value->category_name)."'>".$value->category_name."</a></li>";
                }
              echo "   </ul>
                    </div>";
            }
        ?>
    </div>

    <!-- Twitter Feeds-->
    <div class="aside-section">
        <a class="twitter-timeline" href="https://twitter.com/campus_updates" data-widget-id="523169400916946944">Tweets by @campus_updates</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>

</section>
