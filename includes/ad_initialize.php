<?php
/**     *****************************************************************************
 *      ********************     Opal Energy Solutions        ***********************************
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

date_default_timezone_set("Africa/Accra"); //default time zone
define("DS", DIRECTORY_SEPARATOR);
define("SITE_ROOT", dirname(dirname(__FILE__)));

/************************** PHP FILES PATH *************************/
define("INC_DIR", SITE_ROOT.DS."includes");
define("TEM_DIR", SITE_ROOT.DS."templates");

// Development environment OR Production
define("DEV_ENV", true);

// Production && development settings
if (DEV_ENV) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', SITE_ROOT.DS."logs".DS."errors.log");
}

/*************  APP FILES PATHS        */
defined("PRODUCTS_DIR") ? null : define("PRODUCTS_DIR", SITE_ROOT.DS."uploads".DS."products");
defined("SERVICES_DIR") ? null : define("SERVICES_DIR", SITE_ROOT.DS."uploads".DS."services");
defined("SLIDER_DIR")   ? null : define("SLIDER_DIR", SITE_ROOT.DS."uploads".DS."slider");
defined("TEMP_IMG_DIR") ? null : define("TEMP_IMG_DIR", SITE_ROOT.DS."uploads".DS."templates");


// Admin permsissions
defined("PERMS_SUPER_ADMIN") ? null : define("PERMS_SUPER_ADMIN", 3);
defined("PERMS_ADMIN")       ? null : define("PERMS_ADMIN", 2);
defined("PERMS_MODERATOR")   ? null : define("PERMS_MODERATOR", 1);


/*
* *************************  INITIALIZE FILES  ************************
*/

//Core
require_once(INC_DIR.DS."all_connect.php");
require_once(INC_DIR.DS."class.ad_database.php");
require_once(INC_DIR.DS."functions.php");

// Helper Classes
require_once(INC_DIR.DS."class.ad_session.php");
require_once(INC_DIR.DS."class.ad_secure.php");
require_once(INC_DIR.DS."class.ad_email.php");
require_once(INC_DIR.DS."class.ad_message.php");
require_once(INC_DIR.DS."class.ad_settings.php");
require_once(INC_DIR.DS."class.ad_options.php");
require_once(INC_DIR.DS."class.pagination.php");
require_once(INC_DIR.DS."class.dates.php");

//App Classes
require_once(INC_DIR.DS."class.ad_manager.php");
require_once(INC_DIR.DS."class.ad_products.php");
require_once(INC_DIR.DS."class.ad_categories.php");
require_once(INC_DIR.DS."class.ad_services.php");
require_once(INC_DIR.DS."class.ad_administrators.php");
require_once(INC_DIR.DS."class.ad_faq.php")
?>
