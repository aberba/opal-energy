<?php
require_once("../includes/ad_initialize.php");

$page_title = "Product Categories";
$css        = "cms_categories.css";
$js         = "cms_categories.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content">

    <section class="category-form-section">
         <form id="category-form" class="form">
             <label for="category">Enter Category Name</label><br />
             <input type="text" id="category_name" name="category_name"
             placeholder="Category Name" />
             <input type="hidden" name="add_category" value="yes" />

             <button type="button" class="add-category button">Add category</button>
         </form>
    </section>

    <section class="category-list-section">
    <?php
      $lists = $Categories->list_all();

      if(!$lists) {
          echo "<p>No categories added yet</p>";
      }else {
        $output = "<table class='categories-table table'>
                      <tr>
                         <th>Category Name</th>
                         <th>Action</th>
                         <th>Date Added</th>
                         <th></th>
                      </tr>";

        foreach($lists as $category => $value) {
            $cat_id     = $value->category_id;
            $cat_name   = htmlentities($value->category_name);
            $date_added = $value->date_added;
            $status = ($value->publish == 1) ? "Unpublish" : "Publish";
            $output .= "<tr id='category{$cat_id}'>
                           <td contenteditable='true'>{$cat_name}</td>
                           <td><button id='publish{$cat_id}' class='publish button'>{$status}</button></td>
                           <td class='timeago'>{$date_added}</td>
                           <td><img class='delete' src='img/icons/trash.png' alt='X' title='delete' /></td>
                       </tr>";
        }
        $output .= "</table>";
        echo $output;
      }
    ?>
    </section>
</section>


<?php
include_template("ad_footer.php");
?>
