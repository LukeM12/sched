<?php
	require_once("model/db.php"); //php file which will contain the database class
	$data = new database(""); //This name has to be changed to the name of our database
	$type ="createaccount";// $_POST['typeofrequest'];

	if($type == "createaccount")
    {
        CreateAccount($data);
	}
	if($type == "login")
	{
		// Minimum req to prevent php injection
		$sql = sprintf(
				"SELECT*FROM users WHERE student_num='%s'",
				$data->realEscStr($_POST['StudentNum']));
		$rows = $data->execute($sql); //Retrieve user from table 
		$num = $rows->num_rows;
		if($num>0)
		{
			$user_info = $data->fetchAssoc($rows); //Fetch user info
			$db_password = $user_info['password'];
			$password = $_POST['Password'];
			if($password == $db_password)
			{
				header('Refresh:1;url=view/loggedin.html');
				echo "Successfully logged in.";
			}
			else
			{
				header('Refresh:1;url=/');
				echo "Password is incorrect. Please enter a valid password.";
			}
		}
		else
		{
			header('Refresh:1;url=/');
			echo "Account does not exist. Please create an account.";
		}
	}
	function CreateAccount($data){
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
