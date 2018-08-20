<?php

class Settings {
   private $settings = array();
   private $other_contents = array();

   function __construct() {
       $this->set_all();
       $this->set_contents();
   }

   //Google maps
    public function get_map_settings() {
        $output = array();
        $output['lat']          = $this->settings['location_latitude'];
        $output['lng']          = $this->settings['location_longitude'];
        $output['marker_label'] = $this->settings['map_marker_label'];
        $output['api_key']      = $this->settings['map_api_key'];
        return $output;
    }

   public function set_all() {
       global $Database, $Dates;

       $sql  = "SELECT * FROM settings ORDER BY setting_name ASC";
       $data = $Database->query($sql);
       if($Database->num_rows($data) <= 0) return false;

       $output = array();
       while($row = $Database->fetch_data($data)) {
           $output[$row->setting_name] =  $row->setting_value;
       }
       $this->settings = $output;
   }

   public function site_name() {
       return htmlentities($this->settings['site_name']);
   }

   public function logo_image() {
       return $this->settings['logo_image'];
   }


   public function pagination_per_page() {
       return (int) $this->settings['pagination_per_page'];
   }

   public function currency_symbol() {
       return $this->settings['currency_symbol'];
   }

   public function products_thumb_intro() { //introduction text in homepage
        return $this->settings['products_thumb_intro'];
    }

    public function services_thumb_intro() {
        return $this->settings['services_thumb_intro'];
    }

    public function faq_thumb_intro() {
        return $this->settings['faq_thumb_intro'];
    }

   public function facebook_link() {
       return $this->settings['facebook_page_link'];
   }

   public function twitter_link() {
       return $this->settings['twitter_page_link'];
   }

   public function linkedin_link() {
       return $this->settings['linkedin_page_link'];
   }

   public function youtube_link() {
       return $this->settings['youtube_page_link'];
   }

   public function location_address() {
       return $this->settings['location_address'];
   }

   public function email_address() {
       return $this->settings['email_address'];
   }

   public function phone_number() {
       return $this->settings['phone_number'];
   }

   public function post_address() {
       return $this->settings['post_address'];
   }


    //Content tabale method_exists(such as about us, etc)
    public function set_contents() {
        global $Database;

        $sql  = "SELECT * FROM other_contents";
        $data = $Database->query($sql);
        if($Database->num_rows($data) <= 0) return false;

        $output = array();
        while($row = $Database->fetch_data($data)) {
            $output[$row->content_name] =  $row->content_value;
        }
        $this->other_contents = $output;
    }

    public function content_about_us() {
        return $this->other_contents['about_us'];
    }

}

$Settings = new Settings();
?>
