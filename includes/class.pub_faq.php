<?php

class FAQ {
      private $faq_table = "faq";

      public function fetch_all() {
      	 global $Database;
      	 $sql  = "SELECT * FROM ".$this->faq_table." WHERE publish = '1' ORDER BY question ASC";
      	 $result = $Database->query($sql);
      	 if($Database->num_rows($result) <= 0) return false;

      	 $output = array();
      	 while($row = $Database->fetch_data($result)) {
      	 	$output[] = $row;
      	 }
      	 return $output;
      }
}
$FAQ = new FAQ(); 
?>