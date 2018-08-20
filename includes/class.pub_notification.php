
<?php
class Notification {
     function fetch_all() {
         global $Database;
         $time = time();

         $sql = "SELECT * FROM notifications WHERE publish = '1' AND date_to_expire > '{$time}' LIMIT 1";
         $result = $Database->query($sql);
         if($Database->num_rows($result) != 1) return false;
         $row = $Database->fetch_data($result);
         return array("message" => $row->message);
     }
}
$Notification = new Notification();
?>