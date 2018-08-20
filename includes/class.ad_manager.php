<?php

class Manager {
	private $slides_table = "slides";
	private $templates_table = "templates";
	 private $clients_table = "clients";
    private $templates_info = array();

    private $allowed_extensions = array("png", "gif", "jpeg", "jpg", "x-png", "JPG", "PNG", "JPEG");

    protected $upload_errors = array(
           UPLOAD_ERR_OK           => "File uploaded successfully!",
           UPLOAD_ERR_INI_SIZE     => "File is larger than upload maximum size.",
           UPLOAD_ERR_FORM_SIZE    => "File is larger than upload maximum size.",
           UPLOAD_ERR_PARTIAL      => "THE upload was incomplete.",
           UPLOAD_ERR_NO_FILE      => "No file was selected.",
           UPLOAD_ERR_NO_TMP_DIR   => "No temporal directory.",
           UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
           UPLOAD_ERR_EXTENSION    => "File upload stopped by extension."
    );

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

    public function fetch_logo_image() {
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

        $sql = "SELECT * FROM ".$this->slides_table." ORDER BY date_added DESC";
        $result = $Database->query($sql);
        if($Database->num_rows($result) < 1) return false;

        $output = array();
        while($row = $Database->fetch_data($result)) {
           $output[] = $row;
        }
        return $output;
    }

    public function change_slide_status($id="") {
        global $Database;

        $id = (int)$Database->clean_data($id);
        //fetch current status
        $sql = "SELECT publish FROM ".$this->slides_table." WHERE id = '{$id}' LIMIT 1";
        $result = $Database->query($sql);
        if($Database->num_rows($result) != 1) return "No record of slider found";
        $status = $Database->fetch_data($result)->publish;
        $new_status = ($status == 1) ? 0 : 1;

        //Change current status
        $sql = "UPDATE ".$this->slides_table." SET publish = '{$new_status}' WHERE id = '{$id}' LIMIT 1";
        if(!$Database->query($sql)) return "Error updating slide status";

        return ($new_status == 1) ? "Slide is now shown in public" : "Slide is now hidden from public";
    }

    public function remove_slide($id="") {
        global $Database;

        $id = (int)$Database->clean_data($id);
        //select slide filename and delete file;
         //fetch current status
        $sql = "SELECT file_name FROM ".$this->slides_table." WHERE id = '{$id}' LIMIT 1";
        $result = $Database->query($sql);
        if($Database->num_rows($result) != 1) return "No record of slider found";
        $file_name = $Database->fetch_data($result)->file_name;
        $file = $this->gen_slider_dir().DS.$file_name;
        if(is_file($file)) unlink($file);

        //No delete record
        $sql = "DELETE FROM ".$this->slides_table." WHERE id = '{$id}' LIMIT 1";
        return ($Database->query($sql) === true) ? "Slide has been removed successfully!" : "Ooops! error removing slide";
    }


    public function gen_templates_dir() {
        return TEMP_IMG_DIR;
    }

    public function gen_slider_dir() {
    	return SLIDER_DIR;
    }

	public function upload_slide($post=null, $file=null) {
	    global $Database, $Settings;

        $title     = $Database->clean_data($post['title']);
        $desc      = $Database->clean_data($post['description']);

        //Extension and file name
        $exp_array = explode(".", basename($file["file"]["name"]));
        $ext       = $exp_array[count($exp_array) -1];
        $file_name = "file_at_".time(). ".". $ext;

        $file_size = $file["file"]['size'];
        $max_size  = $Settings->max_file_size();
        $max_size_unit = $Settings->gen_size_unit($max_size);

        if($file_size > $max_size) return "Maximum file size must not exceed ".$max_size_unit;
        if(!in_array($ext, $this->allowed_extensions)) return "File format is not supported";

        // Continue processing if file is valid
        $tmp_name  = $file["file"]['tmp_name'];
        $error     = $this->upload_errors[$file["file"]['error']];
        $dir       = $this->gen_slider_dir();
        $new_file  = $dir.DS.$file_name;
        $time      = time();

        if(!is_dir($dir)) mkdir($dir, 0755, true);

        // Save inage into DB
        $sql  = "INSERT INTO ".$this->slides_table." (title, description, file_name, date_added) ";
        $sql .= "VALUES ('{$title}', '{$desc}', '{$file_name}', '{$time}')";

        if(!$Database->query($sql)) return "Ooops! error saving image into database";

        if(move_uploaded_file($tmp_name, $new_file));

        return $error;
	}


    public function upload_template_image($item="", $file="") {
        global $Database, $Settings;

        //Extension and file name
        $item      = $Database->clean_data($item);
        $item_name = "";
        switch ($item) {
            case 'products':
                $item_name = "products_thumb_image";
                break;
            case 'services':
                $item_name = "services_thumb_image";
                break;
            case 'forum':
                $item_name = "forum_thumb_image";
                break;
            case 'logo':
                $item_name = "logo_image";
                break;
            default:
                return "Thumb item was no specified";
                break;
        }

        $exp_array = explode(".", basename($file["file"]["name"]));
        $ext       = $exp_array[count($exp_array) -1];
        $file_name = time()."_".md5(uniqid(mt_rand(), true)). ".". $ext;

        $file_size = $file["file"]['size'];
        $max_size  = $Settings->max_file_size();
        $max_size_unit = $Settings->gen_size_unit($max_size);

        if($file_size > $max_size) return "Maximum file size must not exceed ".$max_size_unit;
        if(!in_array($ext, $this->allowed_extensions)) return "File format is not supported";

        // Continue processing if file is valid
        $tmp_name  = $file["file"]['tmp_name'];
        $error     = $this->upload_errors[$file["file"]['error']];
        $dir       = $this->gen_templates_dir();
        $new_file  = $dir.DS.$file_name;
        $time      = time();

        //Delete current thumb image first
        $sql    = "SELECT * FROM ".$this->templates_table." WHERE item_name = '{$item_name}' LIMIT 1";
        $result = $Database->query($sql);
        if($Database->num_rows($result) != 1) return "Item specified was not found";

        $current_file_name = $Database->fetch_data($result)->item_value;
        $current_file      = $this->gen_templates_dir().DS.$current_file_name;
        if(is_file($current_file)) unlink($current_file);

        // Save inage into DB
        $sql2 = "UPDATE ".$this->templates_table." SET item_value = '{$file_name}' WHERE item_name = '{$item_name}' LIMIT 1";
        if(!$Database->query($sql2)) return "Ooops! error saving image into database";

        if(!is_dir($dir)) mkdir($dir, 0744, true); // Make dir when it does not exist
        move_uploaded_file($tmp_name, $new_file);
        return $error;
    }

	public function delete_image($product_id="", $column_name="") {
        global $Database, $Products;

        $product_id = (int)$Database->clean_data($product_id);

        $sql   = "SELECT * FROM ".$this->images_table." WHERE ";
        $sql  .= "product_id_fk = '{$product_id}' LIMIT 1";
        $data  = $Database->query($sql);

        if($Database->num_rows($data) != 1) return false;
        $row       = $Database->fetch_data($data);
        $file_name = $row->$column_name;
        $file      = $this->gen_product_path().$file_name;

        if(is_file($file)) unlink($file);
        return true;
    }

	public function fetch_clients()
	{
		global $Database;

		$sql = "SELECT * FROM ".$this->clients_table." ORDER BY name ASC";

		$result = $Database->query($sql);
		if($Database->num_rows($result) < 1) return false;

		$output = array();
		while($row = $Database->fetch_data($result)) {
		   $output[] = $row;
		}
		return $output;
	}

	public function add_client($post=null, $files=null)
    {
        global $Database;

        $name = $Database->clean_data($post['name']);
        $link = $Database->clean_data($post['link']);

        if (!isset($name[0])) {
            return "Please enter client name";
        } elseif (!isset($files['logo'])) {
            return "Please select client logo to upload";
        }

        //File information
        $file_name = $Database->clean_data($files['logo']['name']);
        $file_size = $Database->clean_data($files['logo']['size']);
        $tmp_name = $Database->clean_data($files['logo']['tmp_name']);

        //Extension and file name
        $exp_array = explode(".", basename($files['logo']['name']));
        $ext       = $exp_array[count($exp_array) -1];
        $new_file_name = time()."_".md5(uniqid(mt_rand(), true)). ".". $ext;

        if(!in_array($ext, $this->allowed_extensions)) return "File format is not supported";

        $error     = $this->upload_errors[$files["logo"]['error']];
        $dir       = TEMP_IMG_DIR;
        if(!is_dir($dir)) mkdir($dir, 0755, true); // Make dir when it does not exist

        $new_image = $dir.DS.$new_file_name;
		echo $new_image;
		//return false;

        //Save in DB
        $sql = "INSERT INTO ".$this->clients_table." (name, link, logo) VALUES ('{$name}', '{$link}', '{$new_file_name}')";
        if(!$Database->query($sql)) return "Ooops! error saving image into database";

        //Move file to destination
        if(!move_uploaded_file($tmp_name, $new_image)) return $error;
        return "Image file uploaded successfully";
    }

	public function delete_client($id=0)
	{
		global $Database;

		$id = (int)$Database->clean_data($id);

		//unlink image first
		$sql = "SELECT * FROM ".$this->clients_table." WHERE id = '{$id}'";
		$result = $Database->query($sql);

		if (!$result) return "No record of client with ID of {$id} found";
		$record = $Database->fetch_data($result);
		$file = TEMP_IMG_DIR.DS.$record->logo;

		if (is_file($file)) unlink($file);

		$sql = "DELETE FROM ".$this->clients_table." WHERE id = '{$id}'";
		return ($Database->query($sql) == true) ? "Client deleted!" : "Oops! could not delete client";
	}
}

$Manager = new Manager();
?>
