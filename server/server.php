<?php
	require_once("db.php");
	$data = new database("classdatabase");
	
	$type = $_POST['typeofrequest'];
	
	if($type=="createaccount"){
		$login = $_POST['login'];
		
	}
	
	if($type=="login"){
		
	}
	
	if(@type=="cancel"){
	}
	
	

?>