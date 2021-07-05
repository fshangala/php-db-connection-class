<?php

abstract class Db{

	public $servername = "localhost";
	public $username = "root";
	public $password = "";
	public $dbname = "homeexhibit";
	public $conn;
	public $error;
	public $table;
	public $fields = ["id"=>0];

	function __construct(){
		$this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
		if ($this->conn->connect_error) {
			$this->error = $this->conn->connect_error;
		}
		$this->__init__();
	}

	abstract function __init__();

	function return_one($sql){
		$result = $this->conn->query($sql);
		if ($result){
			$data = $result->fetch_assoc();
			return $data;
		} else {
			$this->error = $this->conn->error;
			return FALSE;
		}
	}

	function return_many($sql){
		$result = $this->conn->query($sql);
		if($result){
			$data = $result->fetch_all();
			$r = array();
			foreach($data as $datum){
				array_push($r, $this->get($datum[0]));
			}
			return $r;
		} else {
			$this->error = $this->conn->error;
			return FALSE;
		}
	}

	function get_where($data, $many=true, $join_by=", "){
		$sql = "SELECT * FROM ".$this->table." WHERE ";
		$first = true;
		foreach($data as $key => $value){
			if($first){
				$sql .= $key."='".$value."'";
				$first = false;
			} else {
				$sql .= $join_by.$key."='".$value."'";
			}
		}
		$sql .= ";";

		if($many){
			return $this->return_many($sql);
		} else {
			return $this->return_one($sql);
		}
	}

	function get($item_id){
		$sql = "SELECT * FROM ".$this->table." WHERE id=".$item_id;
		return $this->return_one($sql);
	}

	function get_all(){
		$sql = "SELECT * FROM ".$this->table;
		return $this->return_many($sql);
	}

	function post($sql){
		$result = $this->conn->query($sql);
		if ($result != TRUE){
			$this->error = $this->conn->error;
		}
		return $result;
	}

	function post_item($data){
		$fields = $this->fields;
		foreach($data as $key => $value){
			if(array_key_exists($key, $fields)){
				$fields[$key] = $value;
			}
		}

		$sql = "INSERT INTO ".$this->table." (id";
		$sql2 = ") VALUES ('0'";
		foreach($fields as $key=>$value){
			$sql .= ",".$key;
			$sql2 .= ",'".$value."'";
		}
		$sql2 .= ");";
		$sql .= $sql2;
		return $this->post($sql);
	}

	function update_item_by_id($id, $data){
		$fields = $this->fields;
		foreach($data as $key => $value){
			if(array_key_exists($key, $fields)){
				$fields[$key] = $value;
			}
		}

		$sql = "UPDATE ".$this->table." SET ";
		$i = 0;
		foreach($fields as $key=>$value){
			if ($i == 0){
				$sql .= $key."='".$value."'";
			} else {
				$sql .= ", ".$key."='".$value."'";
			}
			$i++;
		}
		$sql .= " WHERE id=$id;";
		return $this->post($sql);
	}

	function delete_item_by_id($id){
		$sql = "DELETE FROM ".$this->table." WHERE id='".$id."'";
		return $this->post($sql);
	}

}

?>
