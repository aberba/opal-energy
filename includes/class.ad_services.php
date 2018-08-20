<?php

class Services {
   private $table = "services";
   private $images_table = "services_images";
   private $allowed_extensions = array("png", "gif", "jpeg", "jpg", "x-png");
   protected $upload_errors = array(
           UPLOAD_ERR_OK           => "File uploaded successfully.",
           UPLOAD_ERR_INI_SIZE     => "File is larger than upload maximum size.",
           UPLOAD_ERR_FORM_SIZE    => "File is larger than forms maximum size.",
           UPLOAD_ERR_PARTIAL      => "File upload was incomplete.",
           UPLOAD_ERR_NO_FILE      => "No file was selected.",
           UPLOAD_ERR_NO_TMP_DIR   => "No temporal directory is set in system.",
           UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
           UPLOAD_ERR_EXTENSION    => "File upload stopped by extension."
   );

   private $allowable_tags = "<h3><hr><p><br><ul><li><a><strong><b><i><em><p><table><th><tr><td><span>";

   public function count_all() {
       global $Database;

       $sql = "SELECT COUNT(*) as num FROM ".$this->table;
       $result = $Database->query($sql);
       return $Database->fetch_data($result)->num;
   }

    public function count_published() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->table." WHERE publish = '1'";
        $result = $Database->query($sql);
        $row    = $Database->fetch_data($result);
        return  $row->num;
    }

    public function count_unpublished() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->table." WHERE publish = '0'";
        $result = $Database->query($sql);
        $row    = $Database->fetch_data($result);
        return  $row->num;
    }

   public function fetch_all() {
       global $Database, $Dates;

       $sql  = "SELECT S.*, SI.* FROM ".$this->table." S, ".$this->images_table." SI ";
       $sql .= "WHERE S.service_id = SI.service_id_fk ORDER BY S.date_added DESC";
       $data = $Database->query($sql);
       if($Database->num_rows($data) <= 0) return false;

       $output = array();
       while($row = $Database->fetch_data($data)) {
           $row->date_added = $Dates->gen_date($row->date_added); 
           $output[] = $row;
       }
       return $output;
   }

   public function find_by_id($service_id="") {
       global $Database;
       $service_id = (int)$Database->clean_data($service_id);

       $sql  = "SELECT S.*, SI.* FROM ".$this->table." S, ".$this->images_table." SI WHERE ";
       $sql .= "S.service_id = SI.service_id_fk AND S.service_id = '{$service_id}' ";
       $sql .= "LIMIT 1";
       $data = $Database->query($sql);
       return ($Database->num_rows($data) == 1) ? $Database->fetch_data($data) : false;
   }   

   public function add(array $post) {
        global $Database, $Session;

        if(empty($post['title'])) {
            return "Please enter the service title"; 
        }else {
            $title = $Database->clean_data($post['title']);
        }
        
        if(empty($post["priority"])) { //ie. category ID
           return "Please enter priority for service";
        }else {
           $priority = (int)$Database->clean_data($post['priority']); 
        }
        
        if(empty($post["introduction"])) {
           return "Please enter an introduction for the service";
        }else {
           $intro = $Database->clean_data($post['introduction']);
        }

        if(empty($post["description"])) {
           return "Please enter a detailed description for service";
        }else {
           $desc = $Database->clean_data($post['description'], $this->allowable_tags);
        }

        $session_id = $Session->user()['id'];
        $date       = time();

        //Start Transaction
        $sql = "BEGIN";
        $Database->query($sql);
         
        // add product name and cat into products
        $sql  = "INSERT INTO ".$this->table." (title, introduction, description, priority, added_by, edited_by, date_added) ";
        $sql .= "VALUES ('{$title}', '{$intro}', '{$desc}', '{$priority}', '{$session_id}', '{$session_id}', '{$date}')";
        $Database->query($sql);
        if($Database->affected_rows() != 1) {
            $sql = "ROLLBACK";
            $Database->query($sql);
            return "Error adding service";
        }
        $last_id = $Database->insert_id();

        //add service Image
        $sql = "INSERT INTO ".$this->images_table." (service_id_fk) VALUES ('{$last_id}')";
        $Database->query($sql);
        if($Database->affected_rows() != 1) {
            $sql = "ROLLBACK";
            $Database->query($sql);
            return "Error adding service images";
        }

        $sql = "COMMIT";
        $Database->query($sql);
        return 1; //if there are no errors 
   }    

   public function save(array $posts) {
       global $Database;
        
       $id       = (int)$Database->clean_data($posts['service_id']);
       $title    = $Database->clean_data($posts['title']);
       $intro    = $Database->clean_data($posts['introduction']);
       $desc     = $Database->clean_data($posts['description'], $this->allowable_tags);
       $priority = (int)$Database->clean_data($posts['priority']);
       $time     = time();

       $sql  = "UPDATE ".$this->table." SET title = '{$title}', introduction = '{$intro}', ";
       $sql .= "description = '{$desc}', priority = '{$priority}', date_added = '{$time}' WHERE ";
       $sql .= "service_id = '{$id}' LIMIT 1";
       if(!$Database->query($sql)) return false;
       return true;
   }   


/*********************  Images Related Methods ***********************/
    // Genetares full path to services IMG directory
    public function gen_service_path() {
         return SERVICES_DIR;
    }

    public function upload_image($post=null, array $files=null) {
        global $Database, $Settings;

        $exp_array =  explode(".", basename($files["service_image"]["name"]));
        $ext       = $exp_array[count($exp_array) -1];
        $file_name = time()."_".md5(uniqid(mt_rand(), true)). ".". $ext;
        $file_size = $files["service_image"]['size'];
        $tmp_name  = $files["service_image"]['tmp_name'];
        $error     = $this->upload_errors[$files["service_image"]['error']];
        $max_size  = $Settings->max_file_size();
        $max_size_unit = $Settings->gen_size_unit($max_size);
        
        if($file_size > $max_size) return "Maximum file size must not exceed ".$max_size_unit;
        if(!in_array($ext, $this->allowed_extensions)) return "File format is not supported";

        $new_image = $this->gen_service_path().DS.$file_name;
        //echo $new_image;
        //return false;
        //echo $ext." ".$file_name." ".$new_image.$column_name;

        $service_id = $Database->clean_data($post['service_id']); 
        $column_name = $Database->clean_data($post['column_name']); 
        
        if(!$this->save_image($service_id, $column_name, $file_name)) return "Ooops! error saving image into database";
        if(!move_uploaded_file($tmp_name, $new_image)) return $error;
        return "Image file uploaded successfully";        
    }   
    
    public function save_image($service_id="", $column_name="", $file_name="") {
        global $Database;
        
        $this->delete_image($service_id, $column_name);

        $sql  = "UPDATE ".$this->images_table." SET {$column_name} = '{$file_name}' ";
        $sql .= "WHERE service_id_fk = '{$service_id}' LIMIT 1";
        $Database->query($sql);
        return ($Database->affected_rows() == 1) ? true : false;
    }
    
    public function delete_image($service_id="", $column_name="") {
        global $Database;
        
        $sql   = "SELECT * FROM ".$this->images_table." WHERE ";
        $sql  .= "service_id_fk = '{$service_id}' LIMIT 1";
        $data  = $Database->query($sql);
        
        if($Database->num_rows($data) != 1) return "No images record found";
        $row       = $Database->fetch_data($data);
        $file_name = $row->$column_name;
        $file      = $this->gen_service_path().DS.$file_name;
        if(is_file($file)) unlink($file);
    }  

    public function change_status($service_id="") {
         global $Database;
         $id     = (int) $Database->clean_data($service_id);
         
         // Check current status
         $sql = "SELECT publish FROM ".$this->table." WHERE service_id = '{$id}' LIMIT 1";
         $data = $Database->query($sql);
         if($Database->num_rows($data) != 1) return "No results found for service ID";
         $row = $Database->fetch_data($data);
         $status = $row->publish;

         $sql = "UPDATE ".$this->table." SET publish = '1' WHERE service_id = '{$id}' LIMIT 1";
         if($status == 1) {
            $sql = "UPDATE ".$this->table." SET publish = '0' WHERE service_id = '{$id}' LIMIT 1";
         }
         $Database->query($sql);
         if($Database->affected_rows() != 1) return "Ooops! error changing product status";
         
         if($status == 0) {
             return "Service is now shown in public";
         }else {
             return "Service is now hidden from public";
         }
    }

    public function remove($service_id="") {
        global $Database, $Session;

        if(!$Session->is_admin()) return 2;

        $service_id = (int)$Database->clean_data($service_id);
        //Delete all images of product first
        $sql    = "SELECT * FROM ".$this->images_table." WHERE service_id_fk = '{$service_id}' LIMIT 1";
        $result = $Database->query($sql);
        $row    = $Database->fetch_data($result);
        
        $dir =   $this->gen_service_path();
        if(!empty($row->image_one) && is_file($dir.DS.$row->image_one)) {
            unlink($dir.DS.$row->image_one);
        }
        if(!empty($row->image_two) && is_file($dir.DS.$row->image_two)) {
            unlink($dir.DS.$row->image_two);
        }
        if(!empty($row->image_three) && is_file($dir.DS.$row->image_three)) {
            unlink($dir.DS.$row->image_three);
        }
        
        $sql  = "DELETE FROM ".$this->table." WHERE service_id = '{$service_id}' LIMIT 1";
        $Database->query($sql);
        return ($Database->affected_rows() == 1) ? 1 : 0;
    }
}
$Services = new Services(); 
?>