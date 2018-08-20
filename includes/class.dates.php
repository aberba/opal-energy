<?php

class Dates {
   public function gen_date($unix_timestamp=null) {
       return date("jS F Y \a\\t H:I  A", $unix_timestamp);
   }  

   public function validate_date($Month=null, $Day=null, $Year=null) {
       return (@checkdate($Month, $Day, $Year) === true) ? true : false;
   }

   public function gen_mysql_date($Month, $Day, $Year) {
       return "{$Year}-{$Month}-{$Day} 00:00:00";
   }

   public function gen_product_date($unix_timestamp="") {
       return date("jS F Y", $unix_timestamp);
   } 
}

$Dates = new Dates();
?>