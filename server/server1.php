<?php
	require_once("db.php");
	$data = new database("classdatabase");
	
	$type = $_POST['typeofrequest'];
	
	if($type == "createaccount")
	{
		$login = _POST['StudentNum'];
		$sql = "IF EXISTS (SELECT*FROM students WHERE student_num='$login')";
		$row = $data->execute($sql);
		if($row)
		{
			echo "Account already exists. Please login";
		}
		else
		{
			$password = $_POST['Password'];
			$firstName = $_POST['FirstName'];
			$lastName = $_POST['LastName'];
			$program = $_POST['program'];
			$onOffCourse = $_POST['onOffCourse'];
		}
		print "$login $password $firstName $lastName $program $onOffCourse";
	}
	
	if($type == "login")
	{
	}
	
	if($type == "cancel")
	{
	}
>