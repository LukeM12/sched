<?php
	require_once("db.php");
	$data = new database("classdatabase");
	
	$type = $_POST['typeofrequest'];
	
	if($type=="createaccount"){
		$login = $_POST['login'];
		$sql = "IF EXISTS (SELECT*FROM students WHERE login='$login')";
		$row = $data->execute($sql);
		if($row){
			echo "Account already exists. Please login";
		}else{
			$user = $_POST['studentNum'];
			$password = $_POST['password'];
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
		}
	}
	
	if($type=="login"){
		
	}
	
	if(@type=="cancel"){
	}
	
	

?>