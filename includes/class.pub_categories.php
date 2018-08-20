<?php

class Categories {
      private $table = "products_categories";

      function find_by_name($category_name="") {
        global $Database;
        
        $name   = $Database->clean_data($category_name);
        $sql    = "SELECT * FROM ".$this->table." WHERE category_name = '{$name}' LIMIT 1";
        $data   = $Database->query($sql);
        return ($Database->num_rows($data) == 1) ? $Database->fetch_data($data) : false;
      }

       public function fetch_all() {
        global $Database;
        
        $sql = "SELECT * FROM ".$this->table." WHERE publish = '1' ORDER BY category_name ASC";
        $result = $Database->query($sql);
        if($Database->num_rows($result) <= 0) return false;
        $output = array();
        while($row = $Database->fetch_data($result)) {
            $output[] = $row;
        }
        return $output;
    }
    
}
$Categories = new Categories(); 
?>