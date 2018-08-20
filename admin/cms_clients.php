<?php
require_once("../includes/ad_initialize.php");

$page_title = "Manage Clients";
$css        = "cms_clients.css";
$js         = "cms_clients.js";

include_template("ad_header.php");
?>

<aside id="aside">
   <?php include_template("ad_aside.php"); ?>
</aside>


<section id="content" class="clients-section">
    <section>
        <button type="button" class="button add-btn">+ Add New</button>
        <button type="button" class="button cancel-btn">x Cancel</button>

        <form class="form client-upload-form">
            <label for="name">Clients Name</label>
            <input type="text" name="name">

            <label for="link">Client URL(Link)</label>
            <input type="text" name="link">

            <label for="logo">Select Client Logo</label>
            <input type="file" name="logo">

            <button type="button" class="button save-btn">Save</button>
        </form>
    </section>


    <?php
    $clients = $Manager->fetch_clients();
    if ($clients) {
        $output = "
        <section class='clients-list-section'>
            <table class='table'>
                <tr>
                    <th>Name</th>
                    <th>Link</th>
                    <th>Logo</th>
                    <th>Status</th>
                </tr>
        ";

        foreach ($clients as $key => $value) {
            $status = ($value->publish == 1) ? "Unpublish" : "Publish";

            $output .= "
                <tr>
                    <td>".$value->name."</td>
                    <td>".$value->link."</td>
                    <td><img src='../../uploads/templates/".$value->logo."'' /></td>
                    <td><button type='button' class='toggle-status'>".$status."</td>
                </tr>";
        }

        $output .= "</table>
        </section>
        ";

        echo $output;
    }
    ?>
</section>


<?php
include_template("ad_footer.php");
?>
