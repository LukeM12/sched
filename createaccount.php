<?php
	
require_once("install.php");
require_once("model/db.php");	
$type = $_POST["typeofrequest"];

if($type == "createaccount"){
	CreateAccount();
}


function CreateAccount(){
		$connection = mysqli_connect("localhost", "root", "oops123");
        $login = $_POST['StudentNum'];
        $password = $_POST['Password'];
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $program = $_POST['program'];
        $onOffCourse = $_POST['onOffCourse'];
		$sql = "INSERT INTO student (studentID, name, onCourse, password, coursesTaken) VALUES('$login','$firstName', '$onOffCourse', '$password')";
		if($connection->query($sql)){
			echo "The record is added";
		}
		else
		{
			echo "The record cannot be added ". mysqli_error($connection);
		}
		if($onOffCourse == 'offCourse'){
					header('Refresh:1;url=/view/offCourse.html');
					
		}
}
?>
