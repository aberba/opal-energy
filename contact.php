<?php
require_once("includes/pub_initialize.php");

$page_title = "Contact";
$css        = "contact.css";
$js         = "contact.js";
include_template("pub_header.php");
?>
<section id="content">
    <section class="information-section">
        <h3>Contact <?php echo $Settings->site_name(); ?></h3>

        <table class="info-table">
           <tr>
              <td>Location: </td> <td><?php echo $Settings->location_address(); ?></td>
           </tr>
           <tr>
              <td>Phone / Telephone: </td> <td><?php echo $Settings->phone_number(); ?></td>
           </tr>
           <tr>
              <td>Email Address: </td> <td><?php echo $Settings->email_address(); ?></td>
           </tr>
           <tr>
              <td>Post Address: </td> <td><?php echo $Settings->post_address(); ?></td>
           </tr>
        </table>
    </section>

    <section class="about-us-section">
        <h3>About US</h3>

        <?php echo $Settings->content_about_us(); ?>
    </section>

    <section class="location-map-section">
       <h3>Find us on Google maps</h3>
        <div class="map-container"></div>
    </section>


    <?php
    //Clients section
    // $clients = $Manager->fetch_clients();
    // if ($clients) {
    //     $output = "<section class='clients-section'>
    //         <h3>Clients we have worked with</h3>
    //         <div>";
    //     foreach ($clients as $key => $value) {
    //         $link = ($value->link == "") ? "#" : $value->link;
    //         $output .= "
    //         <section>
    //             <a href='". $link ."'>
    //                 <figure>
    //                     <img src='/uploads/templates/".$value->logo."' alt='".$value->name."' />
    //                     <figcaption>".$value->name."</figcaption>
    //                 </figure>
    //             </a>
    //         </section>
    //         ";
    //     }
    //     $output .= "</div>
    //         </section>";
    //
    //     echo $output;
    // }
    ?>

</section>

<aside id="aside" class="green text-shadow">
   <?php include_template("pub_aside.php"); ?>
</aside>

<!--<script src="https://maps.googleapis.com/maps/api/js?key=h4IjeoOovFj7AkHQmhCx2G6I&language=en&sensor=false"></script> -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
<?php
include_template("pub_footer.php");
?>
