<?php

class Options {
   private $options = array();

   function __construct() {
       $this->set_all();
   }

   public function set_all() {
       global $Database, $Dates;

       $sql  = "SELECT * FROM options ORDER BY option_name ASC";
       $data = $Database->query($sql);
       if($Database->num_rows($data) <= 0) return false;

       $output = array();
       while($row = $Database->fetch_data($data)) {
           $output[$row->option_name] =  $row->option_value;
       }
       $this->options = $output;
   }

   public function show_products_price() {
       return ((int)$this->options['show_products_price'] == 1) ? true : false;
   }

   public function show_products_stock() {
       return ((int)$this->options['show_products_stock'] == 1) ? true : false;
   }

   public function show_products_read_more() {
       return ((int)$this->options['show_products_read_more'] == 1) ? true : false;
   }

   public function show_products_specs() {
       return ((int)$this->options['show_products_specs'] == 1) ? true : false;
   }

   public function show_manufacturer() {
       return ((int)$this->options['show_manufacturer'] == 1) ? true : false;
   }

   public function show_date_made() {
       return ((int)$this->options['show_date_made'] == 1) ? true : false;
   }

   public function show_bonus_offer() {
       return ((int)$this->options['show_bonus_offer'] == 1) ? true : false;
   }
}

$Options = new Options();
?>
