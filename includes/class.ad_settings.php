<?php

class Settings {
   private $table    = "settings";
   private $contents_table = "other_contents";
   private $settings = array();
   private $other_contents = array();

   function __construct() {
       $this->set_all();
       $this->set_contents();
   }

   public function save($id="", $value="") {
       global $Database;

       $id    = (int)$Database->clean_data($id);
       $value = $Database->clean_data($value);

       $sql = "UPDATE ".$this->table." SET setting_value = '{$value}' WHERE setting_id = '{$id}' LIMIT 1";
       return ($Database->query($sql) == true) ? "Setting saved successfully!" : "Ooops! error saving settings";
   }

   public function set_all() {
       global $Database, $Dates;

       $sql  = "SELECT * FROM ".$this->table." ORDER BY setting_name ASC";
       $data = $Database->query($sql);
       if($Database->num_rows($data) <= 0) return false;

       $output = array();
       while($row = $Database->fetch_data($data)) {
           $output[$row->setting_name] =  $row->setting_value;
       }
       $this->settings = $output;
   }

   public function get_map_settings() {
       $output = array();
       $output['lat']          = $this->settings['location_latitude'];
       $output['lng']          = $this->settings['location_longitude'];
       $output['marker_label'] = $this->settings['map_marker_label'];
       $output['api_key']      = $this->settings['map_api_key'];
       return $output;
   }

   public function fetch_basic() {
       global $Database;

       $sql  = "SELECT * FROM ".$this->table."";
       $data = $Database->query($sql);
       if($Database->num_rows($data) <= 0) return false;

       $output = array();
       while($row = $Database->fetch_data($data)) {
           if(preg_match("/(smtp|password|currency)/", $row->setting_name)) continue;
           $output[] =  $row;
       }
       return $output;
   }

   public function fetch_advanced() {
       global $Database;

       $sql  = "SELECT * FROM ".$this->table."";
       $data = $Database->query($sql);
       if($Database->num_rows($data) <= 0) return false;

       $output = array();
       while($row = $Database->fetch_data($data)) {
           if(!preg_match("/(smtp|password|currency)/", $row->setting_name)) continue;
           $output[] =  $row;
       }
       return $output;
   }

   public function site_name() {
       return htmlentities($this->settings['site_name']);
   }

   // SMTP methods
   public function smtp_host() {
       return htmlentities($this->settings['smtp_host']);
   }

   public function smtp_port() {
       return htmlentities($this->settings['smtp_port']);
   }

   public function smtp_user_name() {
       return htmlentities($this->settings['smtp_user_name']);
   }

   public function smtp_password() {
       return htmlentities($this->settings['smtp_password']);
   }

   public function site_email_address() {
       return htmlentities($this->settings['site_email_address']);
   }

   //Pagination perpage (products listing)
   public function pagination_per_page() {
       return (int) $this->settings['pagination_per_page'];
   }

   // Currnecy for products
   public function currency_symbol() {
       return $this->settings['currency_symbol'];
   }

   // File size and unit calculation functions
   public function max_file_size() {
       return (int)$this->settings['max_file_size'];
   }

   public function gen_size_unit($file_size=0) {
       $file_size = $file_size;

       $GB = 1073741824;
       $MB = 1048576;
       $KB = 1024;
       $size = null;
       $unit = null;

       if($file_size >= $GB) {
           $size = number_format(($file_size / $GB), 2);
           $unit = "GB";
       }elseif($file_size >= $MB) {
           $size = number_format(($file_size / $MB), 2);
           $unit = "MB";
       }elseif ($file_size >= $KB) {
           $size = number_format(($file_size / $KB), 2);
           $unit = "KB";
       }elseif($file_size > 0) {
           $size = $file_size;
           $unit = "B";
       }
       return $size.$unit;
   }



    //Content tabale method_exists(such as about us, etc)
    public function set_contents() {
        global $Database;

        $sql  = "SELECT * FROM ".$this->contents_table;
        $data = $Database->query($sql);
        if($Database->num_rows($data) <= 0) return false;

        $output = array();
        while($row = $Database->fetch_data($data)) {
           $output[$row->content_name] =  $row->content_value;
        }

        $this->other_contents = $output;
    }

    public function fetch_contents() {
        return  $this->other_contents;
    }

    public function update_contents($post) {
        global $Database;



        $result = "";
        foreach ($post as $key => $value) {
            $skey = $Database->clean_data($key);
            $svalue = $Database->clean_data($value, "<p><h3><h4><h5><a><em><strong><span>");

            $sql = "UPDATE ". $this->contents_table . " SET {$skey} = '{$svalue}' WHERE content_name = '{$skey}' LIMIT 1";

            // NB: A better way would be to set all query errors as a global or
            // do a single query and report the results as one
            $result = ( $Database->query($sql) ) ? true : false;
            echo "<br>".$sql;
        }

        return $result;
    }

    public function content_about_us() {
        return $this->other_contents['about_us'];
    }
}

$Settings = new Settings();
?>
