<?php
require_once("../includes/ad_initialize.php");

if (isset($_POST['save_contents'])) {
    $post = array();

    foreach ($_POST as $key => $value) {
        if ($key != "save_contents") {
            $post[$key] = $value;
        }
    }

    if ( $Settings->update_contents($post) ) {
        echo "Saved";
    } else {
        echo "error";
    }
}

$page_title = "Manage Contents";
$css        = "cms_contents.css";
$js         = "cms_contents.js";


include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content" class="contents-section">
    <?php

    $other_contents = $Settings->fetch_contents();

    if ($other_contents) {
        $output = "<form class='form contents-form' method='POST' action='". $_SERVER['PHP_SELF']. "'>";
        foreach ($other_contents as $key => $value) {
            $output .= "
                <label>". str_replace("_", " ", $key) ."</label>
                <textarea name='". $key ."'>". $value ."</textarea><br>
            ";

        }
        $output .= "
                <input type='submit' name='save_contents' value=' &nbsp; Save All &nbsp; ' />
            </form>
            ";
        echo $output;
    }
    ?>
</section>


<?php
include_template("ad_footer.php");
?>
