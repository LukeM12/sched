<!-- Author : Luke Morrison
              Matt 
              Volod 
     Email : lukemorrison@carleton.cmail.ca
     -->
<?php
    require_once("model/db.php");
    require_once("install.php");
    
    $studentID = $_POST['StudentNum']; 
    $password = $_POST['Password']; 
    Login($DB, $studentID, $password);
    ParseCourses($DB);
    
    /*
     * Description: 
     * param: 
     * return: 
     **/
    function Login($DB, $studentID, $password){
        $sql = 'SELECT * FROM student where studentID='.$studentID;// WHERE studentID=' + 223;//$studentID;// +'AND PASSWORD="'+$password +'"';
        $result = $DB->execute($sql);

        echo '<h2><b>Welcome</b></h2>'; 
        
        while($row = mysqli_fetch_assoc($result)) {
            echo "<p><h3><b><i> " . $row["name"]. "</i></b></h3></p> - ID: " . $row["studentID"]. " ";
            //Matt this is for you
            //TODO - display the accomplished  courses for that student. below is an sql eaxmple of this
            //select * from courses_Taken where studentID= $studentID;
            //For each row in result
            //Put into a pretty table, 
            //You can call this function display_courses(){ and have it accept ($studentID, and $DB
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

       /* $Students = "CREATE DATABASE IF NOT EXISTS uni";
        $DB->execute($Students);
        $DB = new database("uni");
        return $DB;
    }*/
    
    
?>