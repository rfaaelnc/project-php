<?php

class Sql extends PDO {

	private $conn;

	public function __construct() {
		$this->conn = new PDO("mysql:host=localhost;dbname=polls","root","");

		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$this->conn->query('SET NAMES utf8');

		/* Informa o nível dos erros que serão exibidos */
		error_reporting(E_ALL);

		/* Habilita a exibição de erros */
		ini_set("display_errors", 1);
		
	}


	private function setParams($statement, $parameters = array()) {

		foreach ($parameters as $key => $value) {

			$this->setParam($statement, $key, $value);

		}

	}

	private function setParam($statement, $key, $value) {

		$statement->bindParam($key, $value);

	}

	public function query($rawQuery, $params = array()) {

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt;

	}

	public function select($rawQuery, $params = array()):array {

		$stmt = $this->query($rawQuery, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);

	}

	public function getConn() {
		return $this->conn;
	}
	
}

?>