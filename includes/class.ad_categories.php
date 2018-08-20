<?php
/*********************  Products Categories Class ***********************/
class Categories {
    private $table          = "products_categories";
    private $images_table   = "products_images";
    private $products_table = "products";
    
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
        return $Database->fetch_data($result)->num;
    }
    
    public function count_unpublished() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->table." WHERE publish = '0'";
        $result = $Database->query($sql);
        return $Database->fetch_data($result)->num;
    }

    //Fetches all categories into an HTML select menu
    public function gen_select_html($current_category="") {
        global $Database;
        
        $current_cat = (empty($current_category)) ? null : $Database->clean_data($current_category);
        $sql = "SELECT * FROM ".$this->table." ORDER BY category_name ASC";
        $data = $Database->query($sql);
        $cats = "<select name='product_category'><option value=''>Select Product Category</option>";
        
        while($row = $Database->fetch_data($data)) {
            $cat_id   = $row->category_id;
            $cat_name = $row->category_name;
            
            if($cat_id == $current_cat) {
                $cats .= "<option value='{$cat_id}' selected='selected'>$cat_name</option>";
            }else {
                $cats .= "<option value='{$cat_id}'>$cat_name</option>";
            }   
        }
        
        $cats .= "</select>";
        return $cats;
    }
    
//Select all categories into a multi-dimensional array
    public function list_all() {
        global $Database;
        
        $sql = "SELECT * FROM ".$this->table." ORDER BY category_name ASC";
        $data = $Database->query($sql);
        
        if($Database->num_rows($data) < 1) return false;
        
        $output = array();
        while($row = $Database->fetch_data($data)) {
            $row->date_added = date("c", $row->date_added);
            $output[] = $row;
        }
        return $output;
    }
    
    public function add($category_name) {
        global $Database;
        
        $category_name = strtolower($Database->clean_data($category_name));
        $date          = time();
        
        if($this->is_category($category_name)) return 2;
         
        $sql  = "INSERT INTO ".$this->table." (category_name, date_added) ";
        $sql .= "VALUES ('{$category_name}', '{$date}')";
        $Database->query($sql);
         
        if($Database->affected_rows() == 1) {
            return 1;
        }else {
            return 0;
        }
    }
    
    public function save($category_id, $category_name) {
        global $Database;
        
        $category_id   = (int) $Database->clean_data($category_id);
        $category_name = strtolower($Database->clean_data($category_name));
        
        if($this->is_category($category_name)) return 2;
         
        $sql  = "UPDATE ".$this->table." SET category_name = '{$category_name}' ";
        $sql .= "WHERE category_id = '{$category_id}' LIMIT 1";
        $result = $Database->query($sql);
         
        if($result) {
            return 1;
        }else {
            return 0;
        }
    }

    public function change_status($id="") {
         global $Database;

         $id     = (int) $Database->clean_data($id);
         // Check current status
         $sql = "SELECT publish FROM ".$this->table." WHERE category_id = '{$id}' LIMIT 1";
         $data = $Database->query($sql);
         if($Database->num_rows($data) != 1) return "No results found for category ID";
         $row = $Database->fetch_data($data);
         $status = $row->publish;
         $new_status = ($status == 0) ? 1 : 0;

         $sql = "UPDATE ".$this->table." SET publish = '{$new_status}' WHERE category_id = '{$id}' LIMIT 1";
         $Database->query($sql);
         if($Database->affected_rows() != 1) return "Ooops! error changing category status";
         return ($status == 0) ? "Category is now shown in public" : "Category is now hidden from public";
    }
    
    
    public function remove($category_id) {
        global $Database;
        
        $category_id = (int) $Database->clean_data($_POST["category_id"]);
        // validate if there are products under this category
        $sql = "SELECT * FROM ".$this->products_table." WHERE category_id_fk = '{$category_id}' LIMIT 1";
        $result = $Database->query($sql);
        if($Database->num_rows($result) == 1) return 2;
    
        // delete category if there are no products under it
        $sql  = "DELETE FROM ".$this->table." WHERE "; 
        $sql .= "category_id = '{$category_id}' LIMIT 1";
        $result = $Database->query($sql);
        return ($Database->affected_rows() == 1) ? 1 : 0; 
    }
  
// Validates if a category is already added  
    public function is_category($category_name) {
        global $Database;
        
        $category_name = strtolower($Database->clean_data($category_name));
        $sql  = "SELECT * FROM ".$this->table." WHERE ";
        $sql .= "category_name = '{$category_name}' LIMIT 1";
        $result = $Database->query($sql);
        
        if($Database->num_rows($result) == 1) {
            return true;
        }else {
            return false;
        }
    }
}

$Categories = new Categories(); 
?>