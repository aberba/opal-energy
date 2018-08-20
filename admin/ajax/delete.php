<?php
require_once("../../includes/ad_initialize.php");

if(!is_ajax_request()) exit();


/* *******  Products   **********/
if (isset($_POST["remove_product"])) {
    if(empty($_POST['product_id'])) {
        echo "Undefined product ID";
        exit();
    }
    $result = $Products->remove($_POST["product_id"]);
    if($result == 1) {
        echo "Product deleted successfully!";
    }elseif($result == 2) {
        echo "You donnot have permission to delete a product";
    }else {
        echo "Oops! error, product could not be deleted";
    }
    exit();
}


if (isset($_POST["remove_product_image"])) {
    if ($Products->delete_image($_POST)) {
        echo "Product image removed successfully!";
    } else {
        echo "Oops!, error removing product image";
    }
    exit();
}


/* ******* Services ******/
if(isset($_POST["remove_service"])) {
    if(empty($_POST['service_id'])) {
        echo "Undefined service ID";
        exit();
    }
    $result = $Services->remove($_POST["service_id"]);
    if($result == 1) {
        echo "Service deleted successfully!";
    }elseif($result == 2) {
        echo "You donnot have permission to delete a service";
    }else {
        echo "Oops! error, service could not be deleted";
    }
    exit();
}


/***********    ADMIN  *******/
if(isset($_POST["remove_admin"])) {
    if(empty($_POST['id'])) {
        echo "Undefined User ID";
        exit();
    }
    $result = $Administrators->remove($_POST["id"]);
    echo $result;
    exit();
}


/* *******   PRODUCT CATEGORIES    **************/
if(isset($_POST["remove_category"])) {
    if(empty($_POST['category_id'])) {
        echo "Undefined Category ID";
        exit();
    }
    $result = $Categories->remove($_POST["category_id"]);
    if($result == 1) {
        echo "Category deleted successfully!";
    }elseif($result == 2) {
        echo "Please delete all products under this category first";
    }else {
        echo "Oops! error, category could not be deleted";
    }
    exit();
}

if(isset($_POST["remove_slide"])) {
    $result = $Manager->remove_slide($_POST['id']);
    echo $result;
    exit();
}


/********************** FAQ  *************************/
if (isset($_POST["remove_question"])) {
    $result = $FAQ->remove($_POST['question_id']);
    echo $result; exit();
}
?>