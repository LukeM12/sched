<?php

//This file creates the account for the user,
/**
  Still requires 
  1)sanitation of input
  2)redirection to the right page
  **/
require_once("../install.php");
require_once("../model/db.php");	

CreateAccount();

function CreateAccount(){
		$connection = mysqli_connect("127.0.0.1", "root", "oops123", "uni");
        $login = $_POST['StudentNum'];
        $password = $_POST['Password'];
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $program = $_POST['program'];
        $onOffCourse = $_POST['onOffCourse'];
		$sql = "INSERT INTO student (studentID, name, onCourse, password, coursesTaken) VALUES('$login','$firstName', '$onOffCourse', '$password', '')";
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
