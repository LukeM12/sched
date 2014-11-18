<?php
$type = $_POST["typeofrequest"];

if($type == "submitclasses"){
	printClasses();
}




function printClasses(){
$classesTaken = array();

$connection = mysqli_connect("localhost", "root", "oops123", "uni");


foreach ($_POST['class'] as $taken) {
	array_push($classesTaken, $taken);	
/*	$sql = "INSERT INTO courses_taken (coursesTaken) VALUES ('$taken');";
	if($connection->query($sql)){
			echo "The record is added";
		}
		else
		{
			echo "The record cannot be added ". mysqli_error($connection);
		}  */
}

print_r($classesTaken);

}







?>