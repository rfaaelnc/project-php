<?php
class PollAnswer {
  private $answer_id;
  private $question_id;
  public  $answer;
  private $votes;


  public function getAnswerID() {
    return $this->answer_id;
  }

  public function setAnswerID($value) {
    $this->answer_id = $value;
  }

  public function getQuestionID() {
    return $this->question_id;
  }

  public function setQuestionID($value) {
    $this->question_id = $value;
  }

  public function getAnswer() {
    return $this->answer;
  }

  public function setAnswer($value) {
    $this->answer = $value;
  }
  public function getVotes() {
    return $this->votes;
  }

  public function setVotes($value) {
    $this->votes = $value;
  }

  public function loadById($id) {
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM poll_answers WHERE answer_id = :ID", 
			array(
			":ID"=>$id
			)
		);

		if(count($results) > 0) {		

			$this->setData($results[0]);

		} 

	}

	public static function loadAll($id) {

		$sql = new Sql();

		$result = $sql->select("SELECT * FROM poll_answers WHERE question_id = :ID ORDER BY answer_id", array(
			':ID'=> $id,
		));

		return $result;

	}

	public function updateVotes($answer_id, $value) {

		$this->setVotes($value);

		print_r($this->getVotes());

		$sql = new Sql();

		$sql->query("UPDATE poll_answers SET votes = :VOTE WHERE answer_id = :ID", 
			array(
			':VOTE'=>$this->getVotes(),
			':ID'=>$this->getAnswerID(),
			));

	}

	public function updateAnswer($answer) {

		$this->setAnswer($answer);

		$sql = new Sql();

		$sql->query("UPDATE poll_answers SET answer = :ANSWER WHERE answer_id = :ID", 
			array(
			':ANSWER'=>$this->getAnswer(),
			':ID'=>$this->getAnswerID(),
			));

	}

	public function setData($data) {


		$this->setAnswerID($data['answer_id']);
		$this->setQuestionID($data['question_id']);
		$this->setAnswer($data['answer']);
		$this->setVotes($data['votes']);

	}

	public function __toString() {
		
		return json_encode(array(
			"answer_id"=>$this->getAnswerID(),
			"question_id"=>$this->getQuestionID(),
			"answer"=>$this->getAnswer(),
			"votes"=>$this->getVotes(),
			// "user_id"=>$this->getDate()->format("d/m/Y H:i:s"),
		));
	}


}