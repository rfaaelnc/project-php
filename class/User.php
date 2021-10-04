<?php

class User {
	private $user_id;
	private $name;
	private $login;
	private $password;
	private $date;
	private $errorStatus;
	private $user_serialize;


	public function getUserID() {
		return $this->user_id;
	}

	public function setUserID($value) {
		$this->user_id = $value;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($value) {
		$this->name = $value;
	}

	public function getLogin() {
		return $this->login;
	}

	public function setLogin($value) {
		$this->login = $value;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($value) {
		$this->password = $value;
	}

	public function getDate() {
		return $this->date;
	}

	public function setDate($value) {
		$this->date = $value;
	}

	public function loadById($id) {
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM users WHERE user_id = :ID", 
			array(
			":ID"=>$id
			)
		);

		if(count($results) > 0) {		

			$this->setData($results[0]);

		} 

	}

	public static function getList() {
		$sql = new Sql();

		$result = $sql->select("SELECT * FROM users ORDER BY login");

		return $result;

	}

	public static function search($login) {

		$sql = new Sql();

		return $sql->select("SELECT * FROM users WHERE login LIKE :SEARCH ORDER BY login", array(
			':SEARCH'=> "%". $login ."%",
		));
	}

	public function login($login, $password) {

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM users WHERE login = :LOGIN AND password = :PASSWORD", 
			array(
			":LOGIN"=>$login,
			":PASSWORD"=>$password,
			)
		);

		if(count($results) > 0) {			

			$this->setData($results[0]);

			if(session_status() == PHP_SESSION_NONE) {
				session_start();
			}

			$_SESSION['user_login'] = serialize($results[0]);


			return true; 

		} 

		if(session_status() == PHP_SESSION_ACTIVE) {
			session_destroy();
		}

		return false;

		// try {

			// throw new Exception("Login e/ou senha inválidos.", 1);

		// } catch (Exception $e) {
		// 	echo json_encode(array(
		// 		"message"=> $e->getMessage(),
		// 		// "line"=> $e->getLine(),
		// 		// "code"=> $e->getCode(),
		// 	));

		// 	$this->errorStatus = 1;
		// }

	}

	public function setData($data) {


		$this->setUserID($data['user_id']);
		$this->setLogin($data['login']);
		$this->setPassword($data['password']);
		$this->setDate(new DateTime($data['date']));

	}

	public function insert() {

		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getLogin(),
			':PASSWORD'=>$this->getPassword(),
		));

		if(count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function update($login, $password) {

		$this->setLogin($login);
		$this->setPassword($password);

		$sql = new Sql();

		$sql->query("UPDATE users SET login = :LOGIN, password = :PASSWORD WHERE user_id = :ID", 
			array(
			':LOGIN'=>$this->getLogin(),
			':PASSWORD'=>$this->getPassword(),
			':ID'=>$this->getUserID(),
			));

		
	}

	public function delete() {

		$sql = new Sql();

		$sql->query("DELETE FROM users WHERE user_id = :ID", array(
			':ID'=>$this->getUserID(),
		));


		$this->userEmpty();


	}

	public function userEmpty() {
		$this->setUserID(0);
		$this->setLogin("");
		$this->setPassword("");
		$this->setDate(new DateTime());
	}

	public function __construct($login = "", $password = "") {

		$this->setLogin($login);
		$this->setPassword($password);
	}

	public function __toString() {

		return json_encode(array(
			"user_id"=>$this->getUserID(),
			"login"=>$this->getLogin(),
			"password"=>$this->getPassword(),
			"date"=>$this->getDate()->format("d/m/Y H:i:s"),
		));
	}

}