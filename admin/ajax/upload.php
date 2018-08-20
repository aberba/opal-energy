<?php
require_once("../../includes/ad_initialize.php");

if(!is_ajax_request()) exit();

if(isset($_POST["upload_product_image"])) {
    $result = $Products->upload_image($_POST, $_FILES);
    echo $result;
}

if(isset($_POST["upload_service_image"])) {
    $result = $Services->upload_image($_POST, $_FILES);
    echo $result;
}

if(isset($_POST["upload_slide"])) {
    $result = $Manager->upload_slide($_POST, $_FILES);
    echo $result;
}

if(isset($_POST["upload_template_image"])) {
    $result = $Manager->upload_template_image($_POST['item'], $_FILES);
    echo $result;
}

/*************** CLIENTS ************************/
if (isset($_POST['upload_client'])) {
    $result = $Manager->add_client($_POST, $_FILES);
    echo $result; exit();
}
?>
