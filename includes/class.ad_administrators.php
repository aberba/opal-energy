<?php

class Administrators {
    private $table       = "administrators";
    private $login_table = "login";

    public function count_all() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->table;
        $result = $Database->query($sql);
        return $Database->fetch_data($result)->num;
    }

    public function count_super_admin() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->login_table." WHERE level = '3'";
        $result = $Database->query($sql);
        return $Database->fetch_data($result)->num;
    }

    public function count_admin() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->login_table." WHERE level = '2'";
        $result = $Database->query($sql);
        return $Database->fetch_data($result)->num;
    }

    public function count_moderators() {
        global $Database;

        $sql = "SELECT COUNT(*) as num FROM ".$this->login_table." WHERE level = '1'";
        $result = $Database->query($sql);
        return $Database->fetch_data($result)->num;
    }

    public function fetch_all() {
        global $Database;

        $sql  = "SELECT L.*, A.* FROM ".$this->login_table." L, ".$this->table." A WHERE L.admin_id = A.admin_id_fk ";
        $sql .= "ORDER BY A.first_name ASC, A.last_name ASC";
        $data = $Database->query($sql);
        if($Database->num_rows($data) <= 0) return false;

        $output = array();
        while($row = $Database->fetch_data($data)) {
        	$output[] = array(
                           "id"         => $row->admin_id,
                           "user_name"   => $row->user_name,
                           "fullname"       => $row->first_name." ".$row->last_name,
                           "level"      => $this->get_level($row->level),
                           "last_login" => date("c", $row->last_login)
        		        );
        }
        return $output;
    }

    public function find_by_id($admin_id="") {
        global $Database, $Session;

        $admin_id = (!isset($admin_id) && !empty($admin_id)) ? (int)$Database->clean_data($admin_id) : (int)$Session->user()['id'];
        $sql = "SELECT * FROM administrators WHERE admin_id_fk = '{$admin_id}' LIMIT 1";
        $result = $Database->query($sql);
        if($Database->num_rows($result) != 1) return false;
        return $Database->fetch_data($result);
    }

    public function check_username($user_name="") {
        global $Database;

        $user_name = $Database->clean_data($user_name);
        $sql       = "SELECT * FROM ".$this->login_table." WHERE user_name = '{$user_name}' LIMIT 1";
        $result    = $Database->query($sql);
        return ($Database->num_rows($result) == 1) ? false : true;
    }

    public function update_profile($post="") {
        global $Database, $Session;
        
        $user_id = (int)$Session->user()['id'];
        $fname = $Database->clean_data($post['fname']);
        $lname = $Database->clean_data($post['lname']);
        $email = $Database->clean_data($post['email']);
        
        if(empty($fname) || empty($lname) || empty($email)) return "Please complete the form";
        if(!isset($fname[2])) return "Enter a valid first name";
        if(!isset($lname[2])) return "Enter a valid last name";
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Invalid email address";

        $sql  = "UPDATE ".$this->table." SET first_name = '{$fname}', last_name = '{$lname}', email = '{$email}' ";
        $sql .= "WHERE admin_id_fk = '{$user_id}' LIMIT 1";
        return ($Database->query($sql) === true) ? "Profile information updated successfully!" : "Ooops! eror saving information";
    }

      // for validating admin password update
    public function change_pass($post="") {
        global $Database, $Session, $Secure;
        
        $session_u    = $Session->user();
        $session_id   = $session_u['id'];
        $pass1        = $post['pass1'];
        $pass2        = $post['pass2'];
        $current_pass = $post['current_pass'];

        if(empty($pass1) || empty($pass2) || empty($current_pass)) {
            $message = "Please complete the form";
        }if($pass1 != $pass2) {
            return "The two passwords donnot match";
        }

        // Validate pass strenght Using Secure.class.php and return error message or 'OK' if success
        $strength = $Secure->check_password_strength($pass1);
        if($strength != "OK") return $strength;
       
        // Fetch session user's current password
        $sql    = "SELECT * FROM ".$this->login_table." WHERE admin_id = '{$session_id}' LIMIT 1";
        $result = $Database->query($sql);
        $row    = $Database->fetch_data($result);
        if(!$Secure->password_check($current_pass, $row->password)) {
            return "Invalid current password";
        }
        
        //update pass if there are no errors
        $new_pass = $Secure->password_secure($pass1);
        $sql      = "UPDATE ".$this->login_table." SET password = '{$new_pass}' WHERE admin_id = '{$session_id}' LIMIT 1";
        return ($Database->query($sql) === true) ? "Password changed successfully!" : "Ooops! error changing password";
    }

    public function add($user_name="", $password="", $level="") {
        global $Database, $Secure;
        
        //check if admin name is not in use
        if(!$this->check_username($user_name)) return 2;

        $user_name  = $Database->clean_data($user_name);
        $pass       = $Secure->password_secure($password);
        $level      = (int)$Database->clean_data($level);
        $time       = time();
        
        //start transaction
        $sql = "BEGIN";
        $Database->query($sql);

        //add login info
        $sql  = "INSERT INTO ".$this->login_table." (user_name, password, level, last_login) ";
        $sql .= "VALUES ('{$user_name}', '{$pass}', '{$level}', '{$time}')";
        $Database->query($sql);
        if($Database->affected_rows() != 1) {
            $sql = "ROLLBACK";
            $Database->query($sql);
            return 0;
        }

        // Profile info
        $last_id  = $Database->insert_id();
        $sql = "INSERT INTO ".$this->table." (admin_id_fk) VALUES ('{$last_id}')";
        $Database->query($sql);

        if($Database->affected_rows() != 1) {
            $sql = "ROLLBACK";
            $Database->query($sql);
            return 0;
        } 
        $sql = "COMMIT";
        $Database->query($sql);
        return 1;
    }

    public function remove($victim_id="") {
        global $Database, $Session;

        $admin_id = (int)$Database->clean_data($victim_id);
        if(!$Session->is_admin()) return "You donnot have permission to delete a user";

        // Deny delete if admin has added products 
        $sql  = "SELECT * FROM products WHERE added_by = '{$admin_id}' OR ";
        $sql .= "edited_by = '{$admin_id}' LIMIT 1";
        $result = $Database->query($sql);
        if($Database->num_rows($result) == 1) return "User has added or edited products, thus cannot be removed";

        //Deny delete if admin has added or edited services
        $sql  = "SELECT * FROM services WHERE added_by = '{$admin_id}' OR ";
        $sql .= "edited_by = '{$admin_id}' LIMIT 1";
        if($Database->num_rows($result) == 1) return "User has added or edited services, thus cannot be removed";

        $sql = "DELETE FROM ".$this->login_table." WHERE admin_id = '{$admin_id}' LIMIT 1";
        $Database->query($sql);
        return ($Database->affected_rows() == 1) ? "User deleted successfully!" : "Ooops! error deleting user";
    }

    public function get_level($level_code="") {
    	if($level_code == 3) {
    		$level = "Super Administrator";
    	}elseif($level_code == 2) {
    		$level = "Administrator";
    	}else {
    		$level = "Moderator";
    	}
    	return $level;
    } 
}

$Administrators = new Administrators();
?>
