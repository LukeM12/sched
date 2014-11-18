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
                    courseID varchar(255) NOT NULL,
                    prereq text,
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
     * Description: Create the necessary tables for the site
     * param: A live instance of the database
     * return: implicit -> the tables are now produced //Return Bool?
     **/
    function testInitTables($DB) {
        //set up
        $sql = "INSERT INTO course(courseID, prereq) values ('ELEC 2501', 'Bruh');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO student(studentID, name, onCourse, password, coursesTaken) values (223, 'Jim', 'YES', 'Pass', 'ECOR 1101 and ELEC 2501');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO courses_Taken(studentID, courseID) values (223, 'ELEC 2501');";
        $DB->execute($sql);
        
        $sql = "INSERT INTO courses_Taken(studentID, courseID) values (223, 'ELEC 2501');";
        $DB->execute($sql);
        
        $sql = "select * from student;";
        $result = $DB->execute($sql);
        
        foreach($result as $row) {
            //echo "<tr>";
            //echo "<td><b>" . $row['studentID'] . "</b></td>";
            //echo "<td> <h1>" . $row['name'] . "</h1></td>";
            //echo "</tr>";        
            //Insert the test here;
        }
    }
?>
