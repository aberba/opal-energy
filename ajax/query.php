<?php
require_once("../includes/pub_initialize.php");

if(!is_ajax_request()) exit();

if(isset($_POST['query_product'])) {
    $Result = $Products->find_by_id($_POST['product_id']);
    if(!$Result || count($Result) <= 0) {
        echo 0; exit();  
    }
    
    //Empty product specs if hidden in setting
    if(!$Options->show_products_specs()) $Result->specs = "";

    $image1 = $Result->image_one;
    $image2 = $Result->image_two;
    $image3 = $Result->image_three;
    $image4 = $Result->image_four;
    $image5 = $Result->image_five;
    $image6 = $Result->image_six;
    $dir_path = "/uploads/products/";

    // Assign images path
    $Result->image_one   = ($image1 != null) ? "$dir_path{$image1}" : null;
    $Result->image_two   = ($image2 != null) ? "$dir_path{$image2}" : null;
    $Result->image_three = ($image3 != null) ? "$dir_path{$image3}" : null;
    $Result->image_four  = ($image4 != null) ? "$dir_path{$image4}" : null;
    $Result->image_five  = ($image5 != null) ? "$dir_path{$image5}" : null;
    $Result->image_six   = ($image6 != null) ? "$dir_path{$image6}" : null;
    echo json_encode($Result);
    exit();
}

if(isset($_GET['query_notification'])) {
    if(isset($_COOKIE['stop_notifications'])) {
        echo 0; exit();
    }

    $result = $Notification->fetch_all();
    if(!$result) {
        echo 0; exit();
    }
    echo json_encode($result);
    exit();
}

if(isset($_POST['stop_notifications'])) {
    setcookie("stop_notifications", "yes", time()+ 3600*4);
    exit();
}

if(isset($_GET['get_map_settings'])) {
    $map_settings = $Settings->get_map_settings();
    if($map_settings && is_array($map_settings)) {
        echo json_encode($map_settings);
    } else {
        echo 0;
    }
    exit();
}
?>