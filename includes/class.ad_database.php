<?php

class Database {
    private $connection;
    private $last_sql = null;

    function __construct() {
       $this->open_connection();
    }

    function __destruct() {
       $this->close_connection();
    }

    private function open_connection() {
        try {
            $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_set_charset($this->connection, 'utf8');
        } catch (Exception $e) {
            exit($e);
        }
    }

    public function close_connection() {
        if(isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function insert_id() {
        return mysqli_insert_id($this->connection);
    }


    public function find_all($table="member") {
        $data = $this->find_by_sql("SELECT * FROM $table");
        return $data;
    }

    public function find_by_id($id=0, $table="users", $column_name="user_id") {
        $query = "SELECT * FROM $table WHERE $column_name = '$id' LIMIT 1";
        $data = $this->find_by_sql($query);
        $row =  $this->fetch_data($data);
        return $row;
    }


    public function delete_by_id($id=0, $table="users", $column_name="user_id") {
        $query = "SELECT * FROM $table WHERE $column_name = '$id' LIMIT 1";
        $result = $this->find_by_sql($query);
        return $result;
    }

    public function action_by_query($query) {
        $result = mysqli_query($this->connection, $this->clean_query($query));
        return $result;
    }

    public function num_rows($data) {
        return  mysqli_num_rows($data);
    }

    public function affected_rows() {
        if(mysqli_affected_rows($this->connection) >= 1) {
           return true;
        }else {
           return false;
        }
    }

    public function query($sql) {
        return  mysqli_query($this->connection, $sql);
    }

    public function fetch_data($data) {
        $result = mysqli_fetch_object($data);
        return $result;
    }

    public function find_by_sql($query) {
        return mysqli_query($this->connection, $query);
    }

    public function clean_data($data, $allowed_tags="") {
        $data = strip_tags($data, $allowed_tags);
        $data = mysqli_real_escape_string($this->connection, trim($data));
        return $data;
    }


}

$Database = new Database();

?>
