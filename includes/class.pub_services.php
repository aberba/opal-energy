<?php

class Services {
   private $table        = "services";
   private $images_table = "services_images";

   //assingned when a product is we user find_by_id() method below
   private $image_one   = null;
   private $image_two   = null;
   private $image_three = null;

    //used to insert images dynamically in products description page
   public function insert_images($description="") {
        //assign the prevate images
        $products_path = "/uploads/services/";
        $img1 = "<img src='".$products_path."/".$this->image_one."' alt='".$this->image_one."' />";
        $img2 = "<img src='".$products_path."/".$this->image_two."' alt='".$this->image_two."' />";
        $img3 = "<img src='".$products_path."/".$this->image_three."' alt='".$this->image_three."' />";      
     
        $description = str_replace("@IMAGE1@", $img1, $description);
        $description = str_replace("@IMAGE2@", $img2, $description);
        $description = str_replace("@IMAGE3@", $img3, $description);
        return $description; //return after images are inserted
   }

   public function fetch_all() {
       global $Database, $Dates;

       $sql  = "SELECT S.*, SI.* FROM ".$this->table." S, ".$this->images_table." SI ";
       $sql .= "WHERE S.service_id = SI.service_id_fk AND S.publish = '1' ORDER BY S.priority DESC";
       $data = $Database->query($sql);
       if($Database->num_rows($data) <= 0) return false;

       $output = array();
       while($row = $Database->fetch_data($data)) {
           $row->date_added = $Dates->gen_date((int)$row->date_added); 
           $output[] = $row;
       }
       return $output;
   }

   public function fetch_prioritized() {
        global $Database;

        $sql = "SELECT * FROM ".$this->table." WHERE publish = '1' ORDER BY priority LIMIT 8";
        $result = $Database->query($sql);
        if($Database->num_rows($result) < 1) return false;

        $output = array();
        while ($row = $Database->fetch_data($result)) {
            $output[] = $row;
        }
        return $output;
    }

   public function find_by_id($service_id="") {
       global $Database;
       $service_id = (int)$Database->clean_data($service_id);

       $sql  = "SELECT S.*, SI.* FROM ".$this->table." S, ".$this->images_table." SI WHERE ";
       $sql .= "S.service_id = SI.service_id_fk AND S.service_id = '{$service_id}' ";
       $sql .= "AND S.publish = '1' LIMIT 1";
       $data = $Database->query($sql);
       if($Database->num_rows($data) != 1) return false;
       $row = $Database->fetch_data($data);

       $this->image_one   = $row->image_one;
       $this->image_two   = $row->image_two;
       $this->image_three = $row->image_three;
       return $row;
   }
      
     
}

$Services = new Services(); 
?>