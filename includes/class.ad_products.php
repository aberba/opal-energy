<?php
class Products {
    private $table        = "products";
    private $images_table = "products_images";
    private $cat_table    = "products_categories";
    private $info_table   = "products_information";
    
    //assingned when a product is we user find_by_id() method below
    private $image_one   = null;
    private $image_two   = null;
    private $image_three = null;
    private $image_four  = null;
    private $image_five  = null;
    private $image_six   = null;


    private $allowed_extensions = array("png", "gif", "jpeg", "jpg", "x-png");

    protected $upload_errors = array(
           UPLOAD_ERR_OK           => "No errors.",
           UPLOAD_ERR_INI_SIZE     => "File is larger than upload maximum size.",
           UPLOAD_ERR_FORM_SIZE    => "File is larger than upload maximum size.",
           UPLOAD_ERR_PARTIAL      => "THE upload was incomplete.",
           UPLOAD_ERR_NO_FILE      => "No file was selected.",
           UPLOAD_ERR_NO_TMP_DIR   => "No temporal directory.",
           UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
           UPLOAD_ERR_EXTENSION    => "File upload stopped by extension."
    );
    private $allowable_tags = "<h3><p><br><hr><ul><li><a><strong><b><i><em><p><table><th><tr><td><span>";



/********************* *****************************************
            Products Related Functions 
*******************************************************************/  
    //used to insert images dynamically in products description page
    public function insert_images($description="") {
        //assign the prevate images
        
        $products_DIR = "/uploads/products/";
        $img1 = "<img src='".$products_DIR."/".$this->image_one."' alt='".$this->image_one."' />";
        $img2 = "<img src='".$products_DIR."/".$this->image_two."' alt='".$this->image_two."' />";
        $img3 = "<img src='".$products_DIR."/".$this->image_three."' alt='".$this->image_three."' />";      
        $img4 = "<img src='".$products_DIR."/".$this->image_four."' alt='".$this->image_four."' />";        
        $img5 = "<img src='".$products_DIR."/".$this->image_five."' alt='".$this->image_five."' />";
        $img6 = "<img src='".$products_DIR."/".$this->image_six."' alt='".$this->image_six."' />";

        $description = str_replace("@IMAGE1@", $img1, $description);
        $description = str_replace("@IMAGE2@", $img2, $description);
        $description = str_replace("@IMAGE3@", $img3, $description);
        $description = str_replace("@IMAGE4@", $img4, $description);
        $description = str_replace("@IMAGE5@", $img5, $description);
        $description = str_replace("@IMAGE6@", $img6, $description);
        return $description; //return after images are inserted
    }

    //count all including unpublished products
    public function count_all() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->table;
        $result = $Database->query($sql);
        $row    = $Database->fetch_data($result);
        return  $row->num;
    }

    public function count_published() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->table." WHERE ppublish = '1'";
        $result = $Database->query($sql);
        $row    = $Database->fetch_data($result);
        return  $row->num;
    }

    public function count_unpublished() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->table." WHERE ppublish = '0'";
        $result = $Database->query($sql);
        $row    = $Database->fetch_data($result);
        return  $row->num;
    }

    public function fetch_all($offset=0, $per_page=6, $sort="Date") {
        global $Database;
        
        switch($sort) {
           case 'Name':
              $order_by = "P.product_name ASC";
              break;
           case 'Date':
              $order_by = "P.date_added DESC";
              break;
           case 'Priority':
              $order_by = "P.priority DESC";
              break;
           case 'Price':
              $order_by = "PI.price DESC";
              break;
           default:
              $order_by = "p.product_name ASC";
              break;
        }
        
        $sql  = "SELECT P.*, PC.*, PI.*, PIM.* FROM ";
        $sql .= $this->table." P, ".$this->cat_table." PC, ".$this->info_table." PI, ";
        $sql .= $this->images_table." PIM WHERE ";
        $sql .= "P.category_id_fk = PC.category_id AND ";
        $sql .= "P.product_id = PI.product_id_fk AND ";
        $sql .= "P.product_id = PIM.product_id_fk ";
        $sql .= "ORDER BY {$order_by} LIMIT {$per_page} OFFSET {$offset}";
        $data = $Database->query($sql);
        
        $products = array();
        if(!$data) return false;
        while($row = $Database->fetch_data($data)) {
            $products[] = $row;
        }
        return $products;
    }
    
 
//Fetches a single product using it's product ID   
    public function find_by_id($product_id="") {
        global $Database;
        $product_id = (int) $Database->clean_data($product_id);
        
        $sql  = "SELECT P.*, PC.*, PI.*, PIM.* FROM ";
        $sql .= "products P, products_categories PC, products_information PI, ";
        $sql .= "products_images PIM WHERE ";
        $sql .= "PC.category_id = P.category_id_fk AND ";
        $sql .= "P.product_id = PI.product_id_fk AND ";
        $sql .= "PIM.product_id_fk = P.product_id ";
        $sql .= "AND P.product_id = {$product_id} LIMIT 1";
        $data = $Database->query($sql);
        $row = $Database->fetch_data($data);

        //Iassing private copy of image fila names
        $this->image_one   = $row->image_one;
        $this->image_two   = $row->image_two;
        $this->image_three = $row->image_three;
        $this->image_four  = $row->image_four;
        $this->image_five  = $row->image_five;
        $this->image_six   = $row->image_six;
        return $row;
    }

   
// saves editted product info into DB 
    public function add(array $post) {
        global $Database, $Session;
        
        if(empty($post['product_name'])) {
            return "Please enter the product name"; 
        }else {
            $name = $Database->clean_data($post['product_name']);
        }
        
        if(empty($post["product_category"])) { //ie. category ID
           return "Please select product category";
        }else {
           $category = (int) $Database->clean_data($post['product_category']); 
        }
        
        if(empty($post["price"])) {
           return "Please enter price for product";
        }else {
           $price = (float)$Database->clean_data($post['price']);
        }

        if(empty($post["priority"])) {
           return "Please enter priority for product";
        }else {
           $priority = (int)$Database->clean_data($post['priority']);
        }

        if(empty($post["stock"])) {
           return "Please enter the number of products in stock";
        }else {
           $stock = $Database->clean_data($post['stock']);
        }
        
        if(empty($post["specs"])) {
           return "Please enter the product specifications";
        }else {
           $specs = $Database->clean_data($post['specs']);
        }
        
        if(empty($post["description"])) {
           return "Please enter the product description";
        }else {
           $description = $Database->clean_data($post['description'], $this->allowable_tags);
        }

        if(empty($post["manufacturer"])) {
           return "Please enter the product manufacturer"; 
        }else {
           $manufacturer = $Database->clean_data($post['manufacturer']);
        }
        
        //initialize other variables
        $session_user = $Session->user();
        $session_id = $session_user['id'];
        $bonus      = $Database->clean_data($post['bonus']);
        $date_made  = $Database->clean_data($post['date_made']);
        $time       = time();

        //Start Transaction
        $sql = "BEGIN";
        $Database->query($sql);
         
        // add product name and cat into products
        $sql  = "INSERT INTO ".$this->table." (category_id_fk, product_name, priority, added_by, edited_by, date_added) ";
        $sql .= "VALUES ('{$category}', '{$name}', '{$priority}', '{$session_id}', '{$session_id}', '{$time}')";
        $Database->query($sql);
        if($Database->affected_rows() != 1) {
            $sql = "ROLLBACK";
            $Database->query($sql);
            return "Error adding product";
        }
        $last_id = $Database->insert_id();

        //add Product Info 
        $sql  = "INSERT INTO products_information (product_id_fk, price, bonus, stock, ";
        $sql .= "specs, description, manufacturer, date_made) ";
        $sql .= "VALUES ('{$last_id}', '{$price}', '{$bonus}', '{$stock}', '{$specs}', ";
        $sql .= "'{$description}', '{$manufacturer}', UNIX_TIMESTAMP('$date_made'))"; 
        
        $Database->query($sql);
        if($Database->affected_rows() != 1) {
            $sql = "ROLLBACK";
            $Database->query($sql);
            return "Error adding product information";
        }

        //add product Image
        $sql = "INSERT INTO products_images (product_id_fk) VALUES ('{$last_id}')";
        $Database->query($sql);
        if($Database->affected_rows() != 1) {
            $sql = "ROLLBACK";
            $Database->query($sql);
            return "Error adding product images";
        }

        $sql = "COMMIT";
        $Database->query($sql);
        return 1; //if there are no errors 
    }

    public function save(array $post=null) {
        global $Database, $Session;

        $admin_id    = $Session->user()['id'];
        $pid         = (int) $Database->clean_data($post["product_id"]);
        $category    = (int) $Database->clean_data($post["product_category"]);
        $name        = $Database->clean_data($post["product_name"]);
        $price       = (float) $Database->clean_data($post["price"]);
        $priority    = (int) $Database->clean_data($post["priority"]);
        $bonus       = $Database->clean_data($post["bonus"]);
        $stock       = $Database->clean_data($post["stock"]);
        $specs       = $Database->clean_data($post["specs"]);
        $description = $Database->clean_data($post["description"], $this->allowable_tags);
        $manufacturer = $Database->clean_data($post["manufacturer"]);
        $date_made   = $Database->clean_data($post["date_made"]);
        $time        = time();
         
        $sql  = "UPDATE ".$this->table." SET category_id_fk = '{$category}', ";
        $sql .= "product_name = '{$name}', priority = '{$priority}', edited_by = '{$admin_id}', ";
        $sql .= "date_edited = '{$time}' WHERE product_id = '{$pid}' LIMIT 1";
        $result = $Database->query($sql);
        
        if(!$result) return false;
        
        $sql  = "UPDATE products_information SET price = '{$price}', ";
        $sql .= "bonus = '{$bonus}', stock = '{$stock}', specs = '{$specs}', ";
        $sql .= "description = '{$description}', date_made = UNIX_TIMESTAMP('$date_made') ";
        $sql .= "WHERE product_id_fk = '{$pid}' LIMIT 1";
        
        $result = $Database->query($sql);
        return ($result === true) ? true : false;  
    }

    public function change_status($id="") {
         global $Database;
         $id     = (int) $Database->clean_data($id);
         
         // Check current status
         $sql = "SELECT ppublish FROM ".$this->table." WHERE product_id = '{$id}' LIMIT 1";
         $data = $Database->query($sql);
         if($Database->num_rows($data) != 1) return "No results found for product ID";
         $row = $Database->fetch_data($data);
         $status = $row->ppublish;
         $new_status = ($status == 0) ? 1 : 0;
        
         $sql2 = "UPDATE ".$this->table." SET ppublish = '{$new_status}' WHERE product_id = '{$id}' LIMIT 1";
         $Database->query($sql2);
         if($Database->affected_rows() != 1) return "Ooops! error changing product status";
         return ($status == 0) ? "Product is now shown in public" : "Product is now hidden from public";
    }

    public function remove($product_id="") {
        global $Database, $Session;

        if(!$Session->is_admin()) return 2;

        $product_id = (int)$Database->clean_data($product_id);
        //Delete all images of product first
        $sql    = "SELECT * FROM products_images WHERE product_id_fk = '{$product_id}' LIMIT 1";
        $result = $Database->query($sql);
        $row    = $Database->fetch_data($result);
        
        $dir = $this->gen_product_dir();
        if(!empty($row->image_one) && is_file($dir.DS.$row->image_one)) {
            unlink($dir.DS.$row->image_one);
        }
        if(!empty($row->image_two) && is_file($dir.DS.$row->image_two)) {
            unlink($dir.DS.$row->image_two);
        }
        if(!empty($row->image_three) && is_file($dir.DS.$row->image_three)) {
            unlink($dir.DS.$row->image_three);
        }
        if(!empty($row->image_four) && is_file($dir.DS.$row->image_four)) {
            unlink($dir.DS.$row->image_four);
        }
        if(!empty($row->image_five) && is_file($dir.DS.$row->image_five)) {
            unlink($dir.DS.$row->image_five);
        }
        if(!empty($row->image_six) && is_file($dir.DS.$row->image_six)) {
            unlink($dir.DS.$row->image_six);
        }
        
        $sql  = "DELETE FROM ".$this->table." WHERE product_id = '{$product_id}' LIMIT 1";
        $Database->query($sql);
        return ($Database->affected_rows() == 1) ? 1 : 0;
    }
    
    //Generates product full directory path
    public function gen_product_dir() {
        return PRODUCTS_DIR.DS;
    }



/*************************************************************************
      Images Related Methods 
 ************************************************************************/
    public function upload_image($post=null, array $files=null) {
        global $Database, $Settings;
        
        $product_id = $Database->clean_data($post['product_id']);
        $column     = $Database->clean_data($post['column_name']);
      
        //Extension and file name
        $exp_array = explode(".", basename($files["product_image"]["name"]));
        $ext       = $exp_array[count($exp_array) -1];
        $file_name = time()."_".md5(uniqid(mt_rand(), true)). ".". $ext;

        $file_size = $files["product_image"]['size'];
        $max_size  = $Settings->max_file_size();
        $max_size_unit = $Settings->gen_size_unit($max_size);
        
        if($file_size > $max_size) return "Maximum file size must not exceed ".$max_size_unit;
        if(!in_array($ext, $this->allowed_extensions)) return "File format is not supported";

        // Continue processing if file is valid
        $tmp_name  = $files["product_image"]['tmp_name'];
        $error     = $this->upload_errors[$files["product_image"]['error']];
        $dir       = $this->gen_product_dir();
        $new_image = $dir.$file_name;
            
        if(!is_dir($dir)) mkdir($dir, 0755, true); // Make dir when it does not exist
               
        if(!$this->save_image($product_id, $column, $file_name)) return "Ooops! error saving image into database"; 
        //echo "<hr/>".$tmp_name."<hr/>";
        if(!move_uploaded_file($tmp_name, $new_image)) return $error;        
        return "Image file uploaded successfully";            
    }   
    
    public function save_image($product_id=0, $column_name="", $file_name="") {
        global $Database;
        
        $product_id  = $Database->clean_data($product_id);
        $column_name = $Database->clean_data($column_name);
        $delete_post = array("product_id"=> $product_id, "column_name" => $column_name);

        if(!$this->delete_image($delete_post)) return false;
        
        $sql  = "UPDATE ".$this->images_table." SET {$column_name} = '{$file_name}' ";
        $sql .= "WHERE product_id_fk = '{$product_id}' LIMIT 1";
        $Database->query($sql);
        
        if($Database->affected_rows() == 1) {
            return true;
        }else {
            return false;
        }
    }
    
    public function delete_image($post=null) {
        global $Database, $Products;

        $product_id = (int)$Database->clean_data($post['product_id']);
        $column_name = $Database->clean_data($post['column_name']);
        
        $sql   = "SELECT * FROM ".$this->images_table." WHERE ";
        $sql  .= "product_id_fk = '{$product_id}' LIMIT 1";
        $data  = $Database->query($sql);
        
        if($Database->num_rows($data) != 1) return false;
        $row       = $Database->fetch_data($data);
        $file_name = $row->$column_name; 
        $file      = $this->gen_product_dir().$file_name;

        if(is_file($file)) unlink($file);  
        $sql = "UPDATE ".$this->images_table." SET {$column_name} = NULL WHERE product_id_fk = '{$product_id}' LIMIT 1";
        $Database->query($sql);
        return true;
    }    
}

$Products = new Products();
?>