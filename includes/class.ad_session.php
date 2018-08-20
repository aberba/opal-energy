<?php

class Session {
    private $login_table = "login";
    private $admin_table = "administrators";

    private $logged_id     = false;
    private $session_id    = null;
    private $session_name  = null;
    private $session_level = null;
    
    function __construct() {
        session_start();
        $this->check_login();
    }

    public function check_login() {
        global $Database;

        if(isset($_SESSION['op_id']) && isset($_SESSION['op_name']) && 
            isset($_SESSION['op_level'])) {
            $uid    =  (int) $Database->clean_data($_SESSION['op_id']); 
            $uname  =  $Database->clean_data($_SESSION['op_name']); 
            $ulevel =  (int)$Database->clean_data($_SESSION['op_level']); 

            $sql  = "SELECT admin_id FROM ".$this->login_table." WHERE admin_id = '{$uid}' ";
            $sql .= "AND user_name = '{$uname}' AND level = '{$ulevel}' LIMIT 1";
            $result = $Database->query($sql);
            if($Database->num_rows($result) == 1) {
                $this->session_id    = $uid;
                $this->session_name  = $uname;
                $this->session_level = $ulevel;
                $this->logged_id     = true; 
            }
        }
    }

    public function authenticate($uname="", $password="") {
        global $Database, $Secure;

        //echo $uname." -> ".$password;

        $uname  = $Database->clean_data($uname);
        $sql    = "SELECT * FROM ".$this->login_table." WHERE user_name = '{$uname}' LIMIT 1";
        $result = $Database->query($sql);
        if($Database->num_rows($result) != 1) return false;
        $row = $Database->fetch_data($result);
        
        // Validate passsword with the encrypted copy
        if(!$Secure->password_check($password, $row->password)) return false;
        $output = array("id"    => $row->admin_id,
                        "uname" => $row->user_name,
                        "level" => $row->level
                );
        return $output;
    }

    public function log_login($session_id="") {
        global $Database;

        $session_id   = (int) $Database->clean_data($session_id);
        $time         = time();
        $sql  = "UPDATE ".$this->login_table." SET last_login = '{$time}' WHERE admin_id = '{$session_id}' LIMIT 1";
        $Database->query($sql);
    }

    function login($id="", $name="", $level="") {
        if(empty($id) || empty($name) || empty($level)) return false;
        $_SESSION['op_id']    = $id;
        $_SESSION['op_name']  = $name;
        $_SESSION['op_level'] = $level;
        $this->log_login($id);
        return true;
    }

    public function find_by_id($admin_id="") {
        global $Database;

        $admin_id = (int)$Database->clean_data($admin_id);
        $sql = "SELECT * FROM ".$this->admin_table." WHERE admin_id_fk = '{$admin_id}' LIMIT 1";
        $record = $Database->query($sql);
        return ($Database->num_rows($record) == 1) ? $Database->fetch_data($record) : false;
    }
    
    public function logout() {
        if(isset($_COOKIE[session_name()])) {
            setcookie(session_name(), "", time()-3600);
        }
        unset($_SESSION['op_id']);
        unset($_SESSION['op_name']);
        unset($_SESSION['op_level']);
        session_destroy();

        $this->session_id    = null; 
        $this->session_name  = null; 
        $this->session_level = null;
        $this->logged_id     = false;    
    }

    public function logged_id() {
        return $this->logged_id;
    }

    public function is_super_admin() {
        return ($this->session_level == 3) ? true : false;
    }

    public function is_admin() {
        return ($this->session_level >= 2) ? true : false;
    }

    public function is_moderator() {
        return ($this->session_level >= 1) ? true : false;
    }
    
    public function user() {
        $info = $this->find_by_id($this->session_id);
        $admin = array("id"          => $this->session_id,
                        "user_name"  => $this->session_name,
                        "fullname"   => $info->first_name." ".$info->last_name,
                        "email"      => $info->email,
                        "level"      => $this->session_level
                      );
        return $admin; 
    }
}

$Session = new Session();
?>