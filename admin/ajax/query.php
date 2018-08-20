<?php
require_once("../../includes/ad_initialize.php");

if(!is_ajax_request()) exit();


/* ******* Notification  **********/
if(isset($_GET["fetch_profile"])) {
    $result = $Administrators->find_by_id();
    if ($result) {
        echo json_encode($result);
    } else {
        echo 0;
    }
    exit();
}

if(isset($_GET["query_notification"])) {
  
    $result = $Message->fetch_notification();
    if($result) {
        echo json_encode($result);
    }else {
        echo 0;
    }
    exit();
}

if(isset($_GET["query_settings"])) {
    $result = $Settings->fetch_advanced();
    if ($result && is_array($result)) {
        echo json_encode($result);
    } else {
        echo 0;
    }
    exit();
}

/********************* FAQ ***********************/
if (isset($_POST['query_question'])) {
    $result = $FAQ->find_by_id($_POST['question_id']);
    if ($result) {
        echo json_encode($result);
    } else {
        echo 0;
    }
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

if(isset($_POST['send_email'])) {
    $result = $Email->send($_POST['email'], $_POST['subject'], $_POST['message']);
    if ($result) {
        echo "Message sent successfully!";
    } else {
        echo "Oops!, error sending message";
    }
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