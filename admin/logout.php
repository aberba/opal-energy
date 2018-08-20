<?php
require_once("../includes/ad_initialize.php");

$Session->logout();
redirect_to("cms_login.php");
?>