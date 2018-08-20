<?php
require_once("../includes/ad_initialize.php");


$page_title = "FAQ";
$css        = "cms_faq.css";
$js         = "cms_faq.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">
   <h3>Frequently asked questions</h3>

   <section class="form-section">
       <button class="button add-new"> + Add New </button>

	   <form class="form add-question-form">
	   	   <label for="question"> Question: </label>
	   	   <input type="text" name="question" placeholder="Question asked">

	   	   <label for="answer"> Answer: </label>
	   	   <textarea name="answer" placeholder="Answer to question"></textarea>

	   	   <button type="button" class="button add-btn"> + Add </button>
	   	   <button type="button" class="button cancel-btn"> X Cancel</button>
	   </form>
   </section>

   <section class="questions-section">
<?php
$questions = $FAQ->fetch_all();

if ($questions) {
	$output = "";

	foreach ($questions as $q => $value) {
		$status = ($value->publish == 1) ? "Unpublish" : "Publish";

		$output .= "<div class='faq-item' id='faq".$value->question_id."'>
		               <p class='question green'> <a class='toggle'>+</a> ". $value->question ."</p>
		               <p class='answer'>". $value->answer ."</p>
		               <p> <a href='#' class='edit'> Edit </a> &nbsp;&nbsp;  <a href='#' class='publish'> ". $status. " </a> &nbsp;&nbsp;
		               <a href='#' class='delete'> Delete </a>  &nbsp;&nbsp;<span> <strong>Date Added</strong>: ".$Dates->gen_date($value->date_added)."</span></p>
		            </div>";
	}

	echo $output;
}
?>
   </section>

</section>


<?php
include_template("ad_footer.php");
?>
