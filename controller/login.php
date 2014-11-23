<!-- Author : Luke Morrison
              Matt 
              Volod 
     Email : lukemorrison@carleton.cmail.ca

     Description : login.php handles the main functions required for this app.
     -->
<?php
    require_once("../model/db.php");
    require_once("../install.php");
    $data = new database("uni");
    $studentID = $_POST['StudentNum']; 
    $password = $_POST['Password']; 
    Login($data,$studentID,$password );
				//header('Refresh:1;url=/view/offCourse.html');

    /**
     * 
     * @param unknown $data - the database
     * @param unknown $studentID - the users id 
     * @param unknown $password - the user password
     */
   function Login($data,$studentID,$password ){
		$login = $_POST['StudentNum'];
		
		// Minimum req to prevent php injection
		/*$sql = sprintf(
				"SELECT*FROM users WHERE student_num='%s'",
				$data->realEscStr($login));
				*/
        
		$sql = 'SELECT * FROM student WHERE studentID=\''.$studentID.'\'';		
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
				setcookie("user", $login, time() + 3600, "/");
                //This is where we bring the next page and
					header('Refresh:1;url=/view/offCourse.html');
                //show the user information about themself
				//echo "Successfully logged in.";
			}
			else
            {
			//header('Refresh:1;url=/');
				echo "Password is incorrect. Please enter a valid password.";
				
			}
		}
		else
		{
            echo "<br>Account#".$studentID . " does not exist. Please create an account\n";
		}
	}
    
    
    /**
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

    
    
?>
