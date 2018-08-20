<?php

class Manager {

   private $slides_table    = "slides";
   private $templates_table = "templates";
    private $clients_table = "clients";
   private $templates_info  = array();


    function __construct() {
        $this->set_template_info();
    }

    private function set_template_info() {
        global $Database;

        $sql    = "SELECT * FROM ".$this->templates_table;
        $result = $Database->query($sql);
        if($Database->num_rows($result) < 1) return false;

        $output = array();
        while($row = $Database->fetch_data($result)) {
            $output[$row->item_name] = $row->item_value;
        }
        $this->templates_info = $output;
    }

    public function logo_image() {
        return $this->templates_info['logo_image'];
    }

    public function products_thumb() {
        return $this->templates_info['products_thumb_image'];
    }

    public function services_thumb() {
        return $this->templates_info['services_thumb_image'];
    }

    public function FAQ_thumb() {
        return $this->templates_info['faq_thumb_image'];
    }

    public function fetch_slides() {
        global $Database;

        $sql = "SELECT * FROM ".$this->slides_table." WHERE publish = '1' ORDER BY date_added DESC";
        $result = $Database->query($sql);
        if($Database->num_rows($result) < 1) return false;

        $output = array();
        while($row = $Database->fetch_data($result)) {
           $output[] = $row;
        }
        return $output;
    }

    public function fetch_clients()
    {
        global $Database;

        $sql = "SELECT * FROM ".$this->clients_table." WHERE publish = '1' ORDER BY name ASC";

        $result = $Database->query($sql);
        if($Database->num_rows($result) < 1) return false;

        $output = array();
        while($row = $Database->fetch_data($result)) {
           $output[] = $row;
        }
        return $output;
    }

}
$Manager = new Manager();
?>
