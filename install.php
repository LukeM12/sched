<?php
	require_once("model/db.php"); //php file which will contain the database class
	$blob = new database(""); //This name has to be changed to the name of our database
    
    $data->execute($sql);

    function InitDB($DB){
        $Students = "CREATE DATABASE IF NOT EXISTS uni";
        $blob->execute($Students);
        $data = new database("uni");
        $sql = "CREATE TABLE course(
                    id course int NOT NULL,
                    onCourse text, 
                    FirstName varchar(255)
             );";
        $sql = "CREATE TABLE student(
                    id int NOT NULL,
                    onCourse text, 
                    FirstName varchar(255)
             );";
    }


   /* 
    //Evalute the kind of request that has been processed
	if($type == "createaccount")
    {
        echo "Hello World";
        CreateAccount($data);
	}
	if($type == "login")
	{
		Login($data);
	}
	function Login($data){
		$login = $_POST['StudentNum'];
		// Minimum req to prevent php injection
		$sql = sprintf(
				"SELECT*FROM users WHERE student_num='%s'",
				$data->realEscStr($login));
		$rows = $data->execute($sql); //Retrieve user from table 
		$num = $rows->num_rows;
		if($num>0)
		{
            //This is where the cookie is set
			$user_info = $data->fetchAssoc($rows); //Fetch user info
			$db_password = $user_info['password'];
			$password = $_POST['Password'];
			if($password == $db_password)
			{
				header('Refresh:1;url=view/loggedin.html');
				echo "Successfully logged in.";
				setcookie("user", $login, time() + 3600, "/");
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
//First create the database
        $sql = "CREATE TABLE STUDENT(
                    id int NOT NULL,
                    onCourse text, 
                    FirstName varchar(255)
                );";
        
                    
// Create database
        $sql = "CREATE DATABASE myDB";
        if ($conn->query($sql) === TRUE) {
                echo "Database created successfully";
        } else {
                echo "Error creating database: " . $conn->error;
        }

        $myDB = 
		$table = $data->execute($sql);
        //$sql = "SELECT*FROM users WHERE student_num='$login'";
		//$rows = $data->execute($sql);
		//$num = $rows->num_rows;
	
//        if($num > 0)
//		{
//			header('Refresh:1;url=/');
//			echo "Account already exists. Please login";
//		}


	//	else
	//	{
	//		$password = $_POST['Password'];
	//		$firstName = $_POST['FirstName'];
			//$lastName = $_POST['LastName'];
			//$program = $_POST['program'];
			//$onOffCourse = $_POST['onOffCourse'];
			
			//$sql = "INSERT INTO users VALUES('$login','$password','$firstName','$lastName','$program','$onOffCourse')";
			//$row = $data->execute($sql);
			//if($row)
			//{
		//		header('Refresh:1;url=/');
	//			echo "Account was successfully created. Please log in.";
//			}
	//		else
	//		{
	//			echo "Failed to create account.";
	//		}
	//	}
	}
*/
?>
