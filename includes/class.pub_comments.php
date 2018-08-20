<?php

class FAQ {
      private $table = "faq";

      public function fetch_all() {
      	 global $Database;
      	 $sql  = "SELECT * FROM faq ORDER BY question ASC";
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