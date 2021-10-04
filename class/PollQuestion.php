<?php
class PollQuestion {
  private $question_id;
  private $question;
  public  $link;
  private $user_id;


  public function getQuestionID() {
    return $this->question_id;
  }

  public function setQuestionID($value) {
    $this->question_id = $value;
  }
  public function getQuestion() {
    return $this->question;
  }

  public function setQuestion($value) {
    $this->question = $value;
  }

  public function getLink() {
    return $this->link;
  }

  public function setLink($value) {
    $this->link = $value;
  }

  public function getUserID() {
    return $this->user_id;
  }

  public function setUserID($value) {
    $this->user_id = $value;
  }



  public function loadById($id) {
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM poll_questions WHERE question_id = :ID", 
			array(
			":ID"=>$id
			)
		);
    
		if(count($results) > 0) {		

			$this->setData($results[0]);

		} 

	}

  public function loadByLink($id) {
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM poll_questions WHERE link = :ID", 
			array(
			":ID"=>$id
			)
		);
    
		if(count($results) > 0) {		

			$this->setData($results[0]);

		} 

	}

	public static function getList($id) {
		$sql = new Sql();

		$result = $sql->select("SELECT * FROM poll_questions WHERE user_id = :ID ORDER BY question_id", array(
			':ID'=> $id,
		));

		return $result;

	}

	public function setData($data) {

		$this->setQuestionID($data['question_id']);
		$this->setQuestion($data['question']);
		$this->setLink($data['link']);
		// $this->setS($data['status']);
		$this->setUserID($data['user_id']);

	}

	public function updateQuestion($id) {

		$sql = new Sql();

		print_r($id);

		$sql->query("UPDATE poll_questions SET question = :QUESTION WHERE question_id = :ID", 
			array(
			':QUESTION'=>$this->getQuestion(),
			':ID'=>$id,
			));

	}

	public function generatorLink() {

		$lettersUppercase = "ABCDEFGHIJKLMNOPQRSTUVYXWZ";
		$lettersLowercase = "abcdefghijklmnopqrstuvyxwz";
		$numbers = "0123456789";

		$link = $lettersUppercase . $lettersLowercase . $numbers;

		return substr(str_shuffle($link), 0, 10);

	}

	public static function findLink($link) {

		$sql = new Sql();

		return $sql->select("SELECT * FROM poll_questions WHERE link = :LINK", array(
			':LINK'=> $link,
		));

	}


	public function __toString() {

		// if($this->errorStatus) {

		// 	$this->errorStatus = 0;

		// 	return FALSE;
		// }

		return json_encode(array(
			"question_id"=>$this->getQuestionID(),
			"question"=>$this->getQuestion(),
			"link"=>$this->getLink(),
      "user_id"=>$this->getUserID(),
			// "user_id"=>$this->getDate()->format("d/m/Y H:i:s"),
		));
	}


}