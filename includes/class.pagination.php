<?php

class Pagination {
   private $current_page;
   private $per_page;
   private $total_records;

   function __construct($current_page=1, $per_page=6, $total_records=0) {
       $this->current_page   = (int) $current_page;
       $this->per_page       = (int) $per_page;
       $this->total_records = (int) $total_records;
   }

   public function offset() {
       return ($this->current_page - 1) * $this->per_page;
   }

   public function total_pages() {
       return ceil($this->total_records/$this->per_page);
   }

   public function previous_page() {
       return $this->current_page - 1;
   }

   public function next_page() {
       return $this->current_page + 1;
   }

   // Previous and next pages
   public function has_previous_page() {
       return ($this->previous_page() >= 1) ? true : false;
   }

   public function has_next_page() {
       return ($this->next_page() <= $this->total_pages()) ? true : false;
   }
}
?>