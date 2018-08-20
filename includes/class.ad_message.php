
<?php
class Message {
     private $notif_table = "notifications";
     function fetch_notification() {
         global $Database;
         $sql = "SELECT * FROM ".$this->notif_table." LIMIT 1";
         $result = $Database->query($sql);
         if($Database->num_rows($result) != 1) return false;
         $row = $Database->fetch_data($result);
         $date_to_expire = $row->date_to_expire;
         $row->year      = date("Y", $date_to_expire);
         $row->month     = date("m", $date_to_expire);
         $row->day       = date("d", $date_to_expire);
         return $row;
     }

     function save_notification($post=null) {
         global $Database, $Dates;
          
         $day   = (int)$Database->clean_data($post['day']);
         $month = (int)$Database->clean_data($post['month']);
         $year  = (int)$Database->clean_data($post['year']);

         if(!$Dates->validate_date($month, $day, $year)) return "The date set is invalid";
         $msg     = $Database->clean_data($post['message']);
         $publish = (int)$Database->clean_data($post['publish']);
         $date    = $Dates->gen_mysql_date($month, $day, $year);
         $time    = time();

         $sql  = "UPDATE ".$this->notif_table." SET message = '{$msg}', publish = '{$publish}', ";
         $sql .= "date_to_expire = UNIX_TIMESTAMP('{$date}'), date_saved = '{$time}'";
         return ($Database->query($sql) === true) ? "Notification saved successfully" : "Ooops! saving notification";
      }
}
$Message = new Message();
?>