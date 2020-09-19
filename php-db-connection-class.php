class Db{
	function __construct($host,$user,$pass,$db){
		$this->error = null;
		$this->conn = new mysqli($host,$user,$pass,$db);
		if ($this->conn->connect_error) {
			$this->error = $this->conn->connect_error;
		}
	}

	public function error_BSAlert(){
		if ($this->error) {
			?>
			<div class="alert alert-warning alert-dismissible fade show" role="alert">
			  <?php echo $this->error;?>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<?php
		} else {
			?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
			  <b>Success!</b>
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<?php
		}
	}

	public function insert($sql){
		if (!$this->conn->query($sql)) {
			$this->error = $this->conn->error;
		}
	}

	public function get_row($sql){
		$data = $this->conn->query($sql);
		if ($data) {
			return $data->fetch_assoc();
		} else {
			$this->error = $this->conn->error;
		}
	}

	public function get_rows($sql){
		$data = $this->conn->query($sql);
		if ($data) {
			return $data->fetch_all();
		} else {
			$this->error = $this->conn->error;
		}
	}
}
