<?php
require_once("includes/pub_initialize.php");

$page_title = "Forum";
$css        = "faq.css";
$js         = "faq.js";

include_template("pub_header.php");
?>
<section id="content"> 
   <section class="top-section">
      <h3>Frequently asked questions</h3>
   </section>


   <section class="questions-section">
<?php
$questions = $FAQ->fetch_all();

if($questions) {
     $i = 0;
     foreach ($questions as $question => $value) {
     $i++;
?>
        <section class="question box-shadow clearfix">
            <p class="toggle"> + </p>
            <p id="title<?php echo $value->question_id; ?>" class="title"> <?php echo $value->question; ?></p>

            <div class="answer" id="answer<?php echo $value->question_id; ?>">
                <p><?php echo $value->answer; ?></p>
            </div>
        </section>
<?php
     }
} else {
   echo "<p>No question added yet</p>";
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