<?php
/**     *****************************************************************************
 *      ********************     Lowdownz         ***********************************
 * 
 *      Written by :        aberba lawrence
 *      Last Editted by:    aberba lawrence
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
defined("DS") ?        null : define("DS", DIRECTORY_SEPARATOR);
defined("SITE_ROOT") ? null : define("SITE_ROOT", dirname(dirname(__FILE__)));
//defined("CONN_PATH") ? null : define("CONN_PATH", dirname(dirname(dirname(__FILE__))).DS);
defined("INC_PATH") ?  null : define("INC_PATH", SITE_ROOT.DS."includes".DS);
defined("TEM_PATH") ?  null : define("TEM_PATH", SITE_ROOT.DS."templates".DS);
defined("ADMIN_PATH") ?null : define("ADMIN_PATH", SITE_ROOT."admin".DS);

// DEVElpment environment OR Production
defined("DEV_ENV") ?null : define("DEV_ENV", true);


// Production && development settings
if (DEV_ENV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', ADMIN_PATH."logs".DS."errors.log");   
}

defined("SITE_URL") ? null : define("SITE_URL", "http://localhost");
//defined("SITE_URL") ? null : define("SITE_URL", "http://169.254.21.168");
defined("HTTP_HOST") ? null : define("HTTP_HOST", "localhost");

// SITE Settings
defined("MB") ? null : define("MB", 1048576);


/*
* *************************  INITIALIZE FILES  ************************
*/

require_once(INC_PATH."all_connect.php");

// Core classes
require_once(INC_PATH."class.pub_database.php");
require_once(INC_PATH."pub_functions.php");
require_once(INC_PATH."class.pub_dates.php");

//Helper Classes
require_once(INC_PATH."class.pub_settings.php");
require_once(INC_PATH."class.pub_options.php");
require_once(INC_PATH."class.pub_pagination.php");
require_once(INC_PATH."class.pub_notification.php");

// App Classes
require_once(INC_PATH."class.pub_manager.php");
require_once(INC_PATH."class.pub_products.php");
require_once(INC_PATH."class.pub_categories.php");
require_once(INC_PATH."class.pub_services.php");
require_once(INC_PATH."class.pub_faq.php");
?>








