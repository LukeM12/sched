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
		$connection = new database("uni");//mysqli_connect("127.0.0.1", "root", "oops123", "uni");

        $login = $_POST['StudentNum'];
        $password = $_POST['Password'];
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $program = $_POST['program'];
        $onOffCourse = $_POST['onOffCourse'];
		$sql = "INSERT INTO student (studentID, name, onCourse, password, coursesTaken) VALUES('$login','$firstName', '$onOffCourse', '$password', '')";
		if($connection->execute($sql)){
			require('../view/pages/login_pass.html');
			header('Refresh:3;url=http:///localhost');
		}
		else
		{
		require('../view/pages/login_fail.html');
		header('Refresh:3;url=http:///localhost');
		}

}
?>
