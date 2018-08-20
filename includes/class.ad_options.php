<?php

class Options {
   private $table = "options";
   private $options = array();

   function __construct() {
       $this->set_all();
   }

   public function set_all() {
       global $Database;

       $sql  = "SELECT * FROM ".$this->table." ORDER BY option_name ASC";
       $data = $Database->query($sql);
       if($Database->num_rows($data) <= 0) return false;

       $output = array();
       while($row = $Database->fetch_data($data)) {
           $output[$row->option_name] =  $row->option_value;
       }
       $this->options = $output;
   }

   public function fetch_all() {
       global $Database;

       $sql  = "SELECT * FROM options ORDER BY option_name ASC";
       $data = $Database->query($sql);
       if($Database->num_rows($data) <= 0) return false;

       $output = array();
       while($row = $Database->fetch_data($data)) {
           $output[] = $row;
       }
       return $output;
   }

   public function save($post=null) {
       global $Database;

       if(empty($post)) return "No data was recieved from client";
       $ou = "";
       foreach ($post as $option => $value) {
           $sql = "UPDATE ".$this->table." SET option_value = '{$value}' WHERE option_id = '{$option}' LIMIT 1";
           $result = ($Database->query($sql) == 1) ? "Options saved successfully!" : "Error saving options";
       }
       return $result;
   }
}

$Options = new Options();
?>
