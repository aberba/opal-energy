<?php
/**     *****************************************************************************
 *      OPAL ENERGY 2015/2016
 * 
 *      Written by :        aberba lawrence (@Laberba_)
 * 
 * NB:  * the paths defined are only used to for PHP files
 *      * they will not work for CSS, Images or JS files
 * 
 */

/**
  ***************************  PHP CONSTANTS  ***************************
*/
error_reporting(E_ALL);
date_default_timezone_set("Africa/Accra"); //default time zone

// define path constants
define("DS", DIRECTORY_SEPARATOR);
define("SITE_ROOT", dirname(dirname(__FILE__)));

define("INC_DIR", SITE_ROOT.DS."includes".DS);
define("TEM_DIR", SITE_ROOT.DS."templates".DS);
define("ADMIN_DIR", SITE_ROOT."admin".DS);

// DEVElpment environment OR Production
define("DEV_ENV", true);


// Production && development settings
if (DEV_ENV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', ADMIN_DIR."logs".DS."errors.log");   
}

define("SITE_URL", "http://localhost");
//defined("SITE_URL") ? null : define("SITE_URL", "http://169.254.21.168");
define("HTTP_HOST", "localhost");

// SITE Settings
define("MB", 1048576);


/*
* *************************  INITIALIZE FILES  ************************
*/

require_once(INC_DIR."all_connect.php");

// Core classes
require_once(INC_DIR."class.pub_database.php");
require_once(INC_DIR."functions.php");
require_once(INC_DIR."class.dates.php");

//Helper Classes
require_once(INC_DIR."class.pub_settings.php");
require_once(INC_DIR."class.pub_options.php");
require_once(INC_DIR."class.pagination.php");
require_once(INC_DIR."class.pub_notification.php");

// App Classes
require_once(INC_DIR."class.pub_manager.php");
require_once(INC_DIR."class.pub_products.php");
require_once(INC_DIR."class.pub_categories.php");
require_once(INC_DIR."class.pub_services.php");
require_once(INC_DIR."class.pub_faq.php");
?>








