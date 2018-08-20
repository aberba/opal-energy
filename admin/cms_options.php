<?php
require_once("../includes/ad_initialize.php");


$page_title = "Pages Options";
$css        = "cms_options.css";
$js         = "cms_options.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">
    <section class="form-section">
    <?php
        $options_list = $Options->fetch_all();
		if($options_list)  {
		    echo "
		    <h3>Pages Options</h3>
		    <form class='options-form form'>";
		    foreach ($options_list as $option => $value) {
		    	$opt_name = str_replace("_", " ", $value->option_name); // remove underscore

		    	if($value->option_value == 1) {

		    		echo "<p class='space'>
		    		         <label for='".$value->option_name."'>".$opt_name."</label><br />
		    		         <input type='radio' name='".$value->option_id."' value='1' checked='checked' />Yes
		    		         <input type='radio' name='".$value->option_id."' value='0' />No
		    		      </p>";
		    	}else {
		    		echo "<p class='space'>
		    		         <label for='".$value->option_name."'>".$opt_name."</label><br />
		    		         <input type='radio' name='".$value->option_id."' value='1' />Yes
		    		         <input type='radio' name='".$value->option_id."' value='0' checked='checked' />No
		    		      </p>";
		    	}
		    }
		    echo "<button type='button' class='save-options button'>Save Options</button>
		    </form>";
		}
    ?>
    </section>
</section>


<?php
include_template("ad_footer.php");
?>
