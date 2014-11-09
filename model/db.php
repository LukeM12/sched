<?php
class database{
	/*When creating class connect to database*/
	function __construct($db){
		$host = "127.0.0.1";
		$user = "root";
		$password = "HelpMe";
		if ($db!=''){
			$this->connection = mysqli_connect($host,$user,$password,$db);
		}
		else{
			$this->connecion = mysqli_connect($host,$user,$password);
		}
	}
	/* execute the current query instruction */		
	function execute($sql){
		return $this->connection->query($sql);
	}
	
	function fetchAssoc($sql_query){
		return $sql_query->fetch_assoc();
	}
	
	function realEscStr($string){
		return $this->connection->escape_string($string);
	}
	
	function getError(){
		return mysqli_error($this->connection);
	}
}
?>
