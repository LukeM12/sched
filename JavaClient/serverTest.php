<?php
$user = $_GET['user'];
$method = $_GET['operation']; 
	if($method=="send"){
		$message = $_POST['message'];
	if($message != null){
		echo "Success";
	}
	else {
		echo "Null message";
	}
	}


?>
