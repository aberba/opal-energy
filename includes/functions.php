<?php

// Spl registers (as recommended in documentation in place of __autoload() )
spl_autoload_register(function ($class) {
    require_once(strtolower("class.{$class}.php"));
});

/*
 //Depricated Approach PHP 5.5
function __autoload($class_name) {
    $class_name = strtolower($class_name);
    $path = INC_DIR.DS."{$class_name}.php";
    if(file_exists($path)) {
       require_once($path); 
    }else {
        die("The file {$class_name}.php could not be found");
    }
}*/


function include_template($filename) {
    return include(TEM_DIR.DS.$filename);
}

function redirect_to($location="") {
    header("Location: {$location}");
}

function readable_date($unix_timestamp) {
    return date("jS F Y \a\\t H:I  A", $unix_timestamp);
}

// genearates directory name using id
function gen_file_name($file_name) {
   global $database;
   return substr(($database->clean_data(md5($file_name))), 0, 23);
}

// to validate an ajax XMLhttpRequest
function is_ajax_request() {
    if($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest"){
        //NOTE: uncomment this statement b4 hosting
        //if($_SERVER['HTTP_HOST'] != HTTP_HOST) return false;
      
        return true;
    }else {
        return false;
    }
}

 //generates html date select menu
function gen_date_html($Year="", $Month="", $Day="") {
    $output = "<div class='date'><select name='year'>";
    $cur_year = (int) date("Y", time()) + 1;
    
    $months = array(1 => "January",
                    2 => "February",
                    3 => "March",
                    4 => "April",
                    5 => "May",
                    6 => "June",
                    7 => "July",
                    8 => "August",
                    9 => "September",
                    10 => "October",
                    11 => "November",
                    12 => "December"
    );
    
    //year
    for($i=2000; $i<$cur_year; $i++) {
        if($i == $Year) {
           $output .= "<option selected='selected' value='$i'> {$i} </option>";  
        }else {
           $output .= "<option value='$i'> {$i} </option>"; 
        }   
    }
    $output .= "</select><select name='month'>";


    //month
    foreach($months as $mon => $value) {
        if($mon == $Month) {
           $output .= "<option selected='selected' value='{$mon}'>{$value}</option>"; 
        }else {
           $output .= "<option value='{$mon}'>{$value}</option>"; 
        }   
    }
    $output .= "</select><select name='day'>";
    
    
    //day
    for($i=1; $i<32; $i++) {
        if($i == $Day) {
           $output .= "<option selected='selected' value='$i'>$i</option>"; 
        }else {
           $output .= "<option value='$i'>$i</option>"; 
        }
    }
    $output .= "</select></div>";
    
    return $output;  
}

function validate_date($Month=null, $Day=null, $Year=null) {
    return (@checkdate($Month, $Day, $Year) === true) ? true : false;
}

function gen_mysql_date($Month, $Day, $Year) {
    return (@checkdate($Month, $Day, $Year) === true) ? "{$Year}-{$Month}-{$Day} 00:00:00" : false;
}


function require_once_action($file) {
    require_once("actions/$file");
}
?>












