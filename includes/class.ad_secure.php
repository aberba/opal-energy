<?php

class Secure {
    private $login_table = "login";
    
    // Check passwors strenght and returns 'OK' iwhen succeeds or erroe maeesge if fails
    public function check_password_strength($password="") {
        // Validate
        if(!isset($password[7])) {
            return "Password must be at least 8 characters"; // validate length
        } elseif(!preg_match('/([a-z]+)/', $password)) {
            return "Password must include a lower case alphabet"; // validate lowercase
        } elseif(!preg_match('/([A-Z]+)/', $password)) {
            return "Password must include an upper case alphabet"; // validate uppercase
        } elseif(!preg_match('/([0-9]+)/', $password)) {
            return "Password must include a numeric character"; // validate numeric charaters
        } elseif(!preg_match('/([^a-zA-Z0-9]+)/', $password)) {
            return "Password must include a symbol"; // validate symbols
        } 
        return "OK";
    }
     
    // Validate users permisiion using password (used when deleting user)
    public function validate_permission($victim_id=0, $admin_password="") {
       global $Database, $Session;
       
       $session_u     = $Session->user();
       $session_id    = $session_u['id'];
       $session_level = $session_u['level'];
       $victim_id     = (int)$Database->clean_data($victim_id);
       
       // Fetch session user's level
       $sql     = "SELECT * FROM ".$this->login_table." WHERE admin_id = '{$session_id}' ";
       $sql    .= "LIMIT 1";
       $result  = $Database->query($sql);
       $row_session = $Database->fetch_data($result);
       
       //Fetch victim's level
       $sql    = "SELECT level FROM ".$this->login_table." WHERE admin_id = '{$victim_id}' ";
       $sql   .= "LIMIT 1";
       $result = $Database->query($sql);

       if($Database->num_rows($result) != 1) return 0;
       $row_victim   = $Database->fetch_data($result);

       // Check user's permission to delete victim
       if(($session_level <= $row_victim->level) && ($session_level != PERMS_SUPER_ADMIN)) return 2; 
       return ($this->password_check($admin_password, $row_session->password) === true) ? 1 : 0;
    }

    //for authenticating users permission to take an action
    public function authenticate($password="", $level=3) {
        global $Database, $Session;

        $session_u     = $Session->user();
        $session_id    = $session_u['id'];
        $session_level = $session_u['level'];
        if(empty($password)) return "Access denied";
       
        // Fetch session user's level
        $sql    = "SELECT * FROM ".$this->login_table." WHERE admin_id = '{$session_id}' ";
        $sql   .= "LIMIT 1";
        $result = $Database->query($sql);
        $row    = $Database->fetch_data($result);
        $level = (int)$Database->clean_data($level);
        if($row->level < $level) return "Access denied. You donnot have permission";
        return ($this->password_check($password, $row->password) === true) ? "Access granted" : "Access denied";
    }

    public function gen_salt($length=22) {
        $length = (int)$length;
        $len    = ($length >= 22) ? $length : 22;
        
        $unique_str = md5(uniqid(mt_rand(), true));
        $base64     = base64_encode($unique_str);
        $modified   = str_replace("+", ".", $base64);
        return substr($modified, 0, $len);
    }
    
    // returns an encryptes password
    public function password_secure($password="") {
        $hash_type     = "$2y$11$";
        $salt          = $hash_type.$this->gen_salt(22);
        return crypt($password, $salt);
    }
    
    public function password_check($password="", $hash_password="") {
        return (crypt($password, $hash_password) === $hash_password) ? true : false;
    }
}

$Secure = new Secure();
?>