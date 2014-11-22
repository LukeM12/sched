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
                    subject varchar(4) NOT NULL,
                    courseID varchar(255) NOT NULL,
                    sequence varchar(2) NOT NULL,
                    catalog_title varchar(255) NOT NULL,
                    instruction_type varchar(3) NOT NULL,
                    days varchar(5) NOT NULL,
                    startTime varchar(4) NOT NULL,
                    endTime varchar(4) NOT NULL,
                    room_cap int NOT NULL
             );";
        $DB->execute($sql);
        echo $DB->getError();
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
                    subject varchar(4) NOT NULL,
                    courseID varchar(255) NOT NULL);";

        $DB->execute($sql);
        echo $DB->getError();
        //Make the courses that the student needs to take table
        //It is similar to courses_Taken table but instead of having the courses the student took it will contain 
        //the courses the student needs to take
        $sql = "CREATE TABLE IF NOT EXISTS courses_Needed(
                    studentID int NOT NULL,
                    subject varchar(4) NOT NULL,
                    courseID varchar(255) NOT NULL,
                    entry int);";
            
        $DB->execute($sql);
        echo $DB->getError();
        //Make a communication engineering required courses table
        //Table contains the courses required by the communication engineering
        //Table is coupled with course table
        $sql = "CREATE TABLE IF NOT EXISTS CE_program(
                    year int NOT NULL,
                    subject varchar(4) NOT NULL,
                    courseID varchar(255) NOT NULL,
                    term char NOT NULL,
                    PRIMARY KEY (courseID));";
                
        $DB->execute($sql);
        echo $DB->getError();
        //Had an issue when populating the database when it had the foreign key
        
        /*$sql = "CREATE TABLE IF NOT EXISTS CE_program(
                    year int NOT NULL,
                    courseID varchar(255) NOT NULL,
                    term char NOT NULL,
                    UNIQUE (courseID),
                    FOREIGN KEY (courseID) references course(courseID)
        );";
        $DB->execute($sql);*/
    }
?>
