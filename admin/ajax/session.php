<?php
require_once("../../includes/ad_initialize.php");

if(!is_ajax_request()) exit();


if(isset($_POST['authenticate'])) {
    $result = $Secure->authenticate($_POST['pass'], PERMS_SUPER_ADMIN);
    echo $result;
    exit();
}

if(isset($_POST['confirm'])) {
    $result = $Secure->validate_permission($_POST['user_id'], $_POST['pass'], PERMS_ADMIN);
    echo $result;
    exit();
}

if(isset($_POST["login"])) {
    if(empty($_POST['uname']) || empty($_POST['pass'])) exit();

    $result = $Session->authenticate($_POST['uname'], $_POST['pass']);
    
    if(!$result || !is_array($result))  {
        echo 0;
        exit();
    }
    if(!$Session->login($result["id"], $result["uname"], $result["level"])) {
        echo 0;
        exit();
    }
    echo 1;
    exit();
}
?>