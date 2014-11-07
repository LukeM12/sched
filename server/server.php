<?php
	require_once("server/db.php"); //php file which will contain the database class
	$data = new database("classdatabase"); //This name has to be changed to the name of our database
	
	$type = $_POST['typeofrequest'];

	if($type == "createaccount")
	{
		$login = $_POST['StudentNum'];
		$sql = "SELECT*FROM users WHERE student_num='$login'";
		$rows = $data->execute($sql);
		$num = $rows->num_rows;
		if($num > 0)
		{
			header('Refresh:1;url=/');
			echo "Account already exists. Please login";
		}
		else
		{
			$password = $_POST['Password'];
			$firstName = $_POST['FirstName'];
			$lastName = $_POST['LastName'];
			$program = $_POST['program'];
			$onOffCourse = $_POST['onOffCourse'];
			
			$sql = "INSERT INTO users VALUES('$login','$password','$firstName','$lastName','$program','$onOffCourse')";
			$row = $data->execute($sql);
			if($row)
			{
				header('Refresh:1;url=/');
				echo "Account was successfully created. Please log in.";
			}
			else
			{
				echo "Failed to create account.";
			}
		}
	}
?>