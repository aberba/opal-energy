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
    
     //used to insert images dynamically in products description page
    public function insert_images($description="") {
        //assign the prevate images
        
        $products_path = "/uploads/products/";
        $img1 = "<img src='".$products_path."/".$this->image_one."' alt='".$this->image_one."' />";
        $img2 = "<img src='".$products_path."/".$this->image_two."' alt='".$this->image_two."' />";
        $img3 = "<img src='".$products_path."/".$this->image_three."' alt='".$this->image_three."' />";      
        $img4 = "<img src='".$products_path."/".$this->image_four."' alt='".$this->image_four."' />";        
        $img5 = "<img src='".$products_path."/".$this->image_five."' alt='".$this->image_five."' />";
        $img6 = "<img src='".$products_path."/".$this->image_six."' alt='".$this->image_six."' />";
         
        $description = str_replace("@IMAGE1@", $img1, $description);
        $description = str_replace("@IMAGE2@", $img2, $description);
        $description = str_replace("@IMAGE3@", $img3, $description);
        $description = str_replace("@IMAGE4@", $img4, $description);
        $description = str_replace("@IMAGE5@", $img5, $description);
        $description = str_replace("@IMAGE6@", $img6, $description);
        return $description; //return after images are inserted
    }

    //count only published products
    public function count_all($category_name="all") {
        global $Database, $Categories;
       
        $category_name = $Database->clean_data($category_name);
        $sql = "SELECT COUNT(*) as num FROM ".$this->table." WHERE ppublish = '1'";
        
        if($category_name != "all") {
            $category_info = $Categories->find_by_name($category_name);
            if(!$category_info) return 0;
            $cat_id = $category_info->category_id;
            $sql = "SELECT COUNT(*) as num FROM ".$this->table." WHERE category_id_fk = '{$cat_id}' AND ppublish = '1'";
        }    
        $result = $Database->query($sql);
        return  $Database->fetch_data($result)->num;
    }

    public function fetch_prioritized() {
        global $Database;

        $sql = "SELECT * FROM ".$this->table." WHERE ppublish = '1' ORDER BY priority LIMIT 8";
        $result = $Database->query($sql);
        if($Database->num_rows($result) < 1) return false;

        $output = array();
        while ($row = $Database->fetch_data($result)) {
            $output[] = $row;
        }
        return $output;
    }
    
    public function fetch_all($category_name="all", $offset=0, $per_page=0, $sort_by="date") {
        global $Database;
        $order_by = "P.date_added DESC";
        
        switch($sort_by) {
           case 'name':
              $order_by = "P.product_name ASC";
              break;
           case 'date':
              $order_by = "P.date_added DESC";
              break;
           default:
              $order_by = "P.priority DESC, P.date_added DESC";
              break;
        }

        if($category_name == "all") {
            $sql  = "SELECT P.*, PC.*, PI.*, PIM.* FROM ";
            $sql .= $this->table." P, ".$this->cat_table." PC, ".$this->info_table." PI, ";
            $sql .= $this->images_table." PIM WHERE ";
            $sql .= "PC.category_id = P.category_id_fk AND ";
            $sql .= "P.product_id = PI.product_id_fk AND ";
            $sql .= "PIM.product_id_fk = P.product_id AND P.ppublish = '1' AND PC.publish = '1' ";
            $sql .= "ORDER BY {$order_by} LIMIT {$per_page} OFFSET {$offset}";
        }else {
            $sql  = "SELECT P.*, PC.*, PI.*, PIM.* FROM ";
            $sql .= $this->table." P, ".$this->cat_table." PC, ".$this->info_table." PI, ";
            $sql .= $this->images_table." PIM WHERE ";
            $sql .= "PC.category_id = P.category_id_fk AND ";
            $sql .= "P.product_id = PI.product_id_fk AND PC.category_name = '{$category_name}' AND ";
            $sql .= "PIM.product_id_fk = P.product_id AND P.ppublish = '1' AND PC.publish = '1' ";
            $sql .= "ORDER BY {$order_by} LIMIT {$per_page} OFFSET {$offset}";
        }
        
        $data = $Database->query($sql);
        
        $products = array();
        while($row = $Database->fetch_data($data)) {
            $products[] = $row;
        }
        return $products;
    }
    
    public function find_by_id($product_id="") {
        global $Database;
        $product_id = (int) $Database->clean_data($product_id);
        
        $sql  = "SELECT P.*, PC.*, PI.*, PIM.* FROM ";
        $sql .= $this->table." P, products_categories PC, products_information PI, ";
        $sql .= "products_images PIM WHERE ";
        $sql .= "PC.category_id = P.category_id_fk AND ";
        $sql .= "P.product_id = PI.product_id_fk AND ";
        $sql .= "PIM.product_id_fk = P.product_id ";
        $sql .= "AND P.product_id = {$product_id} LIMIT 1";
        
        $result = $Database->query($sql);
        if($Database->num_rows($result) != 1) return false;
        $row = $Database->fetch_data($result);

        //Iassing private copy of image fila names
        $this->image_one   = $row->image_one;
        $this->image_two   = $row->image_two;
        $this->image_three = $row->image_three;
        $this->image_four  = $row->image_four;
        $this->image_five  = $row->image_five;
        $this->image_six   = $row->image_six;
        return $row;
    } 

    public function find_by_name($name) {
        global $Database;
        
        $name = $Database->clean_data($name);
        $sql  = "SELECT P.*, PC.*, PI.*, PIM.* FROM ";
        $sql .= $this->table." P, ".$this->cat_table." PC, ".$this->info_table." PI, ";
        $sql .= $this->images_table." PIM WHERE P.product_name LIKE '%{$name}%' AND ";
        $sql .= "PC.category_id = P.category_id_fk AND ";
        $sql .= "P.product_id = PI.product_id_fk AND ";
        $sql .= "PIM.product_id_fk = P.product_id AND P.ppublish = '1' AND PC.publish = '1'";

        $results = $Database->query($sql);
        if($Database->num_rows($results) < 1) return false;

        $output = array();
        while ($row = $Database->fetch_data($results)) {
            $output[] = $row;
        }
        return $output;
    }
}
$Products = new Products();
?>