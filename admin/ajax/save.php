<?php
require_once("../../includes/ad_initialize.php");

if(!is_ajax_request()) exit();


if(isset($_POST["save_profile_info"])) {
    $result = $Administrators->update_profile($_POST);
    echo $result;
    exit();
}

if(isset($_POST["update_pass"])) {
    $result = $Administrators->change_pass($_POST);
    echo $result;
    exit();
}

if(isset($_POST["save_settings"])) {
    $result = $Settings->save($_POST['id'], $_POST['value']);
    exit($result);
}

if(isset($_POST["save_options"])) {
    $result = $Options->save($_POST);
    echo $result;
    exit();
}

if(isset($_POST["save_notification"])) {
    $result = $Message->save_notification($_POST);
    echo $result;
    exit();
}

if(isset($_POST["add_admin"])) {
    if(empty($_POST['uname']) || empty($_POST['pass1']) ||
       empty($_POST['level']) || empty($_POST['pass2'])) {
         echo "Please complete the form 2";
         exit();
    }

    if($_POST['pass1'] != $_POST['pass2']) {
        echo "The two passwords donnot match";
        exit();
    }

    //Validate password strength using (for validate passwords to make sure they are secure)
    $strength = $Secure->check_password_strength($_POST['pass1']);
    if($strength != "OK") {
        echo $strength;
        exit();
    }

    $result = $Administrators->add($_POST['uname'], $_POST['pass1'], $_POST['level']);
    if($result == 2) {
        echo "Username is unavailable";
    }elseif($result == 1) {
        echo "Administrator added successfully!";
    }else {
        echo "Ooops! error adding new admin";
    }
    exit();
}


/************   PRODUCTS  *****************/
if(isset($_POST["add_product"])) {

    $month = (int) $Database->clean_data($_POST['month']);
    $day   = (int) $Database->clean_data($_POST['day']);
    $year   = (int) $Database->clean_data($_POST['year']);
    $date_made = gen_mysql_date($month, $day, $year);

    if(!$date_made) {
        echo "The date set is invalid";
        exit();
    }

    $_POST['date_made'] = $date_made;

    $result = $Products->add($_POST);
    if($result == 1) {
        echo "Products has been added successfully!";
    }else {
        echo $result;
    }
    exit();
}

if(isset($_POST["save_product"])) {
    $month = (int) $Database->clean_data($_POST['month']);
    $day   = (int) $Database->clean_data($_POST['day']);
    $year   = (int) $Database->clean_data($_POST['year']);
    $date_made = gen_mysql_date($month, $day, $year);

    if(!$date_made) {
        echo "The date set is invalid";
        exit();
    }
    $_POST['date_made'] = $date_made;

    $result = $Products->save($_POST);
    if($result) {
        echo 1;
    }else {
        echo 0;
    }
    exit();
}


if(isset($_POST["change_product_status"])) {
    $result = $Products->change_status($_POST['id']);
    echo $result;
    exit();
}

/************  PRODUCT CATEGORIES  *****************/
// Add New Category
if(isset($_POST["add_category"])) {

    if(empty($_POST['category_name'])) {
       echo "Please enter category name";
       exit();
    }

    $result = $Categories->add($_POST['category_name']);

    if($result == 1) {
       echo "Category added successfully";
    }elseif($result == 2) {
       echo "<strong>".$_POST["category_name"]."</strong> is already added to categories";
    }else {
       echo "Ooops! error adding category";
    }
}

// Save an existing Category
if(isset($_POST["save_category"])) {

    if(empty($_POST['category_name'])) {
       echo "Please enter category name";
       exit();
    }
    $result = $Categories->save($_POST['category_id'], $_POST['category_name']);
    if($result == 1) {
       echo "Category saved successfully";
    }elseif($result == 2) {
       echo "<strong>".$_POST["category_name"]."</strong> is already added to categories";
    }else {
       echo "Ooops! error adding category";
    }
}

if(isset($_POST["change_category_status"])) {
    $result = $Categories->change_status($_POST['id']);
    echo $result;
    exit();
}

/************   SERVICES  *****************/
if(isset($_POST["add_service"])) {
    $result = $Services->add($_POST);
    if($result == 1) {
        echo "Products has been added successfully!";
    }else {
        echo $result;
    }
    exit();
}

if(isset($_POST["save_service"])) {
    $result = $Services->save($_POST);
    if($result) {
        echo 1;
    }else {
        echo 0;
    }
    exit();
}


if(isset($_POST["change_service_status"])) {
    $result = $Services->change_status($_POST['id']);
    echo $result;
    exit();
}


/**************  Templates******************/
/* Slider */
if(isset($_POST["change_slide_status"])) {
    $result = $Manager->change_slide_status($_POST['id']);
    echo $result;
    exit();
}

/****************  FAQ   ********************/

if (isset($_POST['change_question_status'])) {
    $result = $FAQ->change_status($_POST['question_id']);
    echo $result; exit();
}

if (isset($_POST['save_question'])) {
    $result = $FAQ->save($_POST);
    echo $result; exit();
}

if (isset($_POST['add_question'])) {
    $result = $FAQ->add_new($_POST);
    echo $result; exit();
}

?>
