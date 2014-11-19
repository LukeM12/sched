<!-- Author : Luke Morrison
              Matt 
              Volod 
     Email : lukemorrison@carleton.cmail.ca
     -->
<?php
	require_once("model/db.php"); //php file which will contain the database class
	
    $DB = new database(""); //This name has to be changed to the name of our database
    $DB = InitDB($DB);
    initTables($DB);
    
    /*
     * Description: Initiate our database
     * param: an Empty Database instance blob
     * return: a live instance of our DB for this site
     **/
    function InitDB($DB){
        $Students = "CREATE DATABASE IF NOT EXISTS uni";
        $DB->execute($Students);
        $DB = new database("uni");
        return $DB;
    }
    /*
     * Description: Create the necessary tables for the site
     * param: A live instance of the database
     * return: implicit -> the tables are now produced //Return Bool?
     **/

    function initTables($DB){
        
        //Make the courses table
        //The prereqs are implicit in a string
        $sql = "CREATE TABLE IF NOT EXISTS course(
                    subject text NOT NULL,
                    courseID varchar(255) NOT NULL,
                    sequence varchar(2) NOT NULL,
                    catalog_title varchar(255) NOT NULL,
                    instruction_type varchar(3) NOT NULL,
                    days varchar(5) NOT NULL,
                    startTime varchar(4) NOT NULL,
                    endTime varchar(4) NOT NULL,
                    room_cap int NOT NULL,
                    PRIMARY KEY(courseID)
             );";
        $DB->execute($sql);

       //Make the student table  
        $sql = "CREATE TABLE IF NOT EXISTS student(
                    studentID int NOT NULL,
                    name varchar(255),
                    onCourse text,
                    password varchar(255),
                    coursesTaken varchar(255),
                    PRIMARY KEY(studentID)
             );";
        $DB->execute($sql);
        //Make the courses the student has taken table
        //This table is actually coupled between student and course, and there will be copies of both the student and the course but not combined
        $sql = "CREATE TABLE IF NOT EXISTS courses_Taken(
                    studentID int NOT NULL,
                    courseID varchar(255) NOT NULL,
                    entry int,
                    FOREIGN KEY (studentID) references student(studentID),
                    FOREIGN KEY (courseID) references course(courseID)
            );";
        $DB->execute($sql);
        //Make the courses that the student needs to take table
        //It is similar to courses_Taken table but instead of having the courses the student took it will contain 
        //the courses the student needs to take
        $sql = "CREATE TABLE IF NOT EXISTS courses_Needed(
                    studentID int NOT NULL,
                    courseID varchar(255) NOT NULL,
                    entry int,
                    FOREIGN KEY (studentID) references student(studentID),
                    FOREIGN KEY (courseID) references course(courseID)
            );";
        $DB->execute($sql);
        //Make a communication engineering required courses table
        //Table contains the courses required by the communication engineering
        //Table is coupled with course table
        $sql = "CREATE TABLE IF NOT EXISTS CE_program(
                    year int NOT NULL,
                    courseID varchar(255) NOT NULL,
                    term char NOT NULL,
                    PRIMARY KEY (courseID)
                );";
        $DB->execute($sql);
        $DB->getError();
        //Had an issue when populating the database when it had the foreign key
        
        /*$sql = "CREATE TABLE IF NOT EXISTS CE_program(
                    year int NOT NULL,
                    courseID varchar(255) NOT NULL,
                    term char NOT NULL,
                    UNIQUE (courseID),
                    FOREIGN KEY (courseID) references course(courseID)
        );";
        $DB->execute($sql);*/
        //testInitTables($DB);
    }

    /*
     * Description: Create the necessary tables for the site
     * param: A live instance of the database
     * return: implicit -> the tables are now produced //Return Bool?
     **/
    function testInitTables($DB) {
        //set up
        $sql = "INSERT INTO course(courseID, days, startTime, endTime) values ('ELEC2501', 'M,W' ,'835','1035');";
        $DB->execute($sql);
        $DB->getError();
        
        $sql = "INSERT INTO course(courseID, days, startTime, endTime) values ('ECOR1101', 'T,R' ,'935','1135');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO course(courseID, days, startTime, endTime) values ('SYSC2004', 'M,W' ,'1135','1435');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO course(courseID, days, startTime, endTime) values ('SYSC2002', 'T,R' ,'1135','1435');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO student(studentID, name, onCourse, password, coursesTaken) values (223, 'Jim', 'YES', 'Pass', 'ECOR1101,ELEC2501,SYSC2004,SYSC2002');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO courses_Taken(studentID, courseID) values ('223', 'ECOR1101');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO courses_Taken(studentID, courseID) values ('223', 'ELEC2501');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO courses_Taken(studentID, courseID) values ('223', 'SYSC2004');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO courses_Taken(studentID, courseID) values ('223', 'SYSC2002');";
        $DB->execute($sql);
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
