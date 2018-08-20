<?php
class FAQ {
	private $faq_table = "faq";

	public function fetch_all() {
		global $Database;

		$sql = "SELECT * FROM ".$this->faq_table." ORDER BY question ASC";
		$result = $Database->query($sql);
		if ($Database->num_rows($result) < 1) return false;

		$output = array();
		while ($row = $Database->fetch_data($result)) {
			$output[] = $row;
		} 
		return $output;
	}

	public function find_by_id($question_id=0) {
		global $Database;

		$question_id = (int)$Database->clean_data($question_id);
		$sql = "SELECT * FROM ".$this->faq_table." WHERE question_id = '{$question_id}' LIMIT 1";
		$result = $Database->query($sql);
		return ($Database->num_rows($result) == 1) ? $Database->fetch_data($result) : false;
	}

	public function add_new($post=null) {
		global $Database;

		$question = $Database->clean_data($post["question"], "<a>");
		$answer   = $Database->clean_data($post['answer'], "<a>");
		$date     = time();

		$sql = "INSERT INTO ".$this->faq_table." (question, answer, date_added) VALUES ('{$question}', '{$answer}', '{$date}')";
		return ($Database->query($sql) === true) ? "Question added successfully!" : "Oops!, an error occured whilst adding question";
	}

	public function save($post=null) {
		global $Database;

        $question_id = (int)$Database->clean_data($post["question_id"]);
		$question    = $Database->clean_data($post["question"], "<a>");
		$answer      = $Database->clean_data($post['answer'], "<a>");
	
		$sql = "UPDATE ".$this->faq_table." SET question = '{$question}', answer = '{$answer}' WHERE question_id = '{$question_id}' LIMIT 1";
		return ($Database->query($sql) === true) ? "Question saved successfully!" : "Oops!, an error occured whilst saving question";
	}

	public function change_status($question_id=0) {
		global $Database;

		$question_id = (int)$Database->clean_data($question_id);

		$sql = "SELECT publish FROM ".$this->faq_table." WHERE question_id = '{$question_id}' LIMIT 1";
		$result = $Database->query($sql);
		$current_status = (int)$Database->fetch_data($result)->publish;

		$new_status = ($current_status === 1) ? 0 : 1;
		$message    = ($current_status === 1) ? "Question hidden successfully!" : "Question published successfully!";

		$sql = "UPDATE ".$this->faq_table." SET publish = '{$new_status}' WHERE question_id = '{$question_id}' LIMIT 1";

		return ($Database->query($sql) === true) ? $message : "Oops!, an error occured whilst deleting question";
	}

    public function remove($question_id=0) {
		global $Database;

		$question_id = (int)$Database->clean_data($question_id);

		$sql = "DELETE FROM ".$this->faq_table." WHERE question_id = '{$question_id}' LIMIT 1";
		return ($Database->query($sql) === true) ? "Question deleted successfully!" : "Oops!, an error occured whilst deleting question";
	}
}

$FAQ = new FAQ();
?>