<!-- Author : Luke Morrison
              Matt 
              Volod 
     Email : lukemorrison@carleton.cmail.ca

     Description : login.php handles the main functions required for this app.
     -->
<?php
    require_once("model/db.php");
    require_once("install.php");
    $data = new database("uni");
    //$studentID = $_POST['StudentNum']; 
    //$password = $_POST['Password']; 
	
	$type = $_POST["typeofrequest"];

    if($type == "login"){
        echo "Hello World we just logged in";
        Login($data);
    }
    else if($type == "createaccount"){
        echo "Hello World we just created an account";
        CreateAccount($data);
    }
	//ParseCourses($DB);
	
   function Login($data){
		$login = $_POST['StudentNum'];
		
		// Minimum req to prevent php injection
		/*$sql = sprintf(
				"SELECT*FROM users WHERE student_num='%s'",
				$data->realEscStr($login));
				*/
		$sql = 'SELECT * FROM student WHERE studentID="$login"';		
		$rows = $data->execute($sql); //Retrieve user from table 
		echo $data->getError();
		$num = $rows->num_rows;
		
		if($num>0)
		{
            //This is where the cookie is set
			$user_info = $data->fetchAssoc($rows); //Fetch user info
			$db_password = $user_info['password'];
			$password = $_POST['Password'];
			if($password == $db_password)
			{
				//header('Refresh:1;url=view/loggedin.html');
				echo "Successfully logged in.";
				setcookie("user", $login, time() + 3600, "/");
			}
			else
			{
				//header('Refresh:1;url=/');
				echo "Password is incorrect. Please enter a valid password.";
				
			}
		}
		else
		{
			//header('Refresh:1;url=/');
			echo "Account does not exist. Please create an account.";
		}
	}
    
    
    /*
     * Description: Create the necessary tables for the site
     * param: A live instance of the database
     * return: implicit -> the tables are now produced //Return Bool?
     **/
    function displayStudent($result){
        foreach($result as $row) {
                echo "<tr>";
                echo "<td><b>" . $row['studentID'] . "</b></td>";
                echo "<td> <h1>" . $row['name'] . "</h1></td>";
                echo "</tr>";        
            //Insert the test here;
        }
    }
           
    function CreateAccount($data){

    		$connection = new Database("uni");
            $login = $_POST['StudentNum'];
            $password = $_POST['Password'];
            $firstName = $_POST['FirstName'];
            $lastName = $_POST['LastName'];
            $program = $_POST['program'];
            $onOffCourse = $_POST['onOffCourse'];
    		$sql = "INSERT INTO student (studentID, name, onCourse, password) VALUES('$login','$firstName', '$onOffCourse', '$password')";
    		if($connection->execute($sql)){
    			echo "The record is added";
    		}
    		else
    		{
    			echo "The record cannot be added ". mysqli_error($connection);
    		}
    		//mysqli_error($connection);
    		if($onOffCourse == 'offCourse'){
    					header('Refresh:1;url=/view/offCourse.html');
    					
    		}
    }  

	/*
     * Description: Initiate our database
     * param: an Empty Database instance blob
     * return: a live instance of our DB for this site
     **/
    function ParseCourses($DB){
       /* $file = $_FILES[csv][tmp_name];
        $csv_file = CSV_PATH . "model/data.csv"; // Name of your CSV file
        $csvfile = fopen($csv_file, 'r');
        $csv_array = explode(",", $csv_data[$i]);
        $theData = fgets($csvfile);
        $i = 0;*/
        $row=0;
        if (($handle = fopen("model/data.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";
                }
            }
        fclose($handle);
        }
    }


    
    
?>
