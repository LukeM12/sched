<!-- Author : Luke Morrison
              Matt 
              Volod 
     Email : lukemorrison@carleton.cmail.ca
     Description : A single script to create and populate our database 
     -->
<?php
	require_once("model/db.php"); //php file which will contain the database class
    require_once("model/load_data.php");
	
    $DB = new database(""); //This name has to be changed to the name of our database
    $DB = InitDB($DB);
    initTables($DB);
    //ParseCEProgram($DB);
    //ParseCourses($DB);
    loadCSVfiles($DB);
    ParsePrerequisites($DB);
    testInitTables($DB);
    
    
    /**************************************** Database Configuration and Creation ************************************/
    
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
                    name varchar(255) NOT NULL,
                    password varchar(255) NOT NULL,
                    newUser varchar(1) NOT NULL,
                    onCourse varchar(1) NOT NULL,
					year char NOT NULL,
                    program varchar(5) NOT NULL,
                    PRIMARY KEY(studentID)
             );";
        $DB->execute($sql);
        //Make the courses the student has taken table
        //This table is actually coupled between student and course, and there will be copies of both the student and the course but not combined
        $sql = "CREATE TABLE IF NOT EXISTS courses_Taken(
                    studentID int NOT NULL,
                    courseName varchar(255) NOT NULL);";

        $DB->execute($sql);
        echo $DB->getError();
        //Make the courses that the student needs to take table
        //It is similar to courses_Taken table but instead of having the courses the student took it will contain 
        //the courses the student needs to take
        $sql = "CREATE TABLE IF NOT EXISTS courses_Needed(
                    studentID int NOT NULL,
                    courseName varchar(255) NOT NULL,
                    year int NOT NULL,
                    term char NOT NULL,
					eligible char NOT NULL,
					registered char NOT NULL,
                    entry int);";
            
        $DB->execute($sql);
        echo $DB->getError();
        //Make a communication engineering required courses table
        //Table contains the courses required by the communication engineering
        //Table is coupled with course table
        $sql = "CREATE TABLE IF NOT EXISTS ce_program(
                    year int NOT NULL,
                    courseName varchar(255) NOT NULL,
                    term char NOT NULL);";
                
        $DB->execute($sql);
        echo $DB->getError();
        //Make a course prerequisite table
        $sql = "CREATE TABLE IF NOT EXISTS course_prereq(
                    courseName varchar(255) NOT NULL,
                    yearReq int NOT NULL,
                    programReq varchar(255) NOT NULL,
                    departmentPerReq char NOT NULL,
                    concurrent varchar(255) NOT NULL,
                    firstPreReq varchar(255) NOT NULL,
                    secondPreReq varchar(255) NOT NULL,
                    thirdPreReq varchar(255) NOT NULL,
                    PRIMARY KEY (courseName));";
        $DB->execute($sql);
        echo $DB->getError();
    }
    /**************************************** Course and Program Data Parsing  ************************************/ 
	/** NOTE -INFILE did not work for everyone (different MYSQL version?) So I hard-coded a workaround
	/**
     * Description: Parse the Courses Data File
     * param : Live database instance 
     * return: the ce_program table is then initialized
     **/
    function ParseCEProgram($DB){
        $i = 0;
        $row=0;
        //echo getcwd();
        if (($handle = fopen("../model/ce_program.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $num = count($data);
                $row++;
                $format = 'INSERT into ce_program(year, courseName, term) 
                        VALUES ("%s", "%s", "%s");';
                $sql = sprintf($format, $data[0], $data[1], $data[2]);
                
                $DB->execute($sql);
                echo $DB->getError();
            }
        fclose($handle);
        }
    }
	/** NOTE -INFILE did not work for everyone (different MYSQL version?) So I hard-coded a workaround
     * Description: Parse all the courses in the csv file 
     * param: a initialized database instance
     * return: mysql course table is then populated
     **/
    function ParseCourses($DB){
        $i = 0;
        $row=0;

        if (($handle = fopen("../model/course_data.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $num = count($data);
                $row++;
                $format = 'INSERT into course(subject, courseID, sequence, catalog_title, instruction_type, days, startTime, endTime, room_cap) 
                           VALUES ("%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s");';
                $sql = sprintf($format,$data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]);
                $DB->execute($sql);
            }
            fclose($handle);
        }
    }
    /** 
     * Description: Parse all the prerequisites in the csv file 
     * param: a initialized database instance
     * return: mysql prerequisite table is then populated
     **/
    function ParsePrerequisites($DB){
        $courseName = '';
        $programReq = '';
        $concurrent = '';
        $firstPreReq = '';
        $secondPreReq = '';
        $thirdPreReq = '';
        $departmentPerReq = '';
        if (($handle = fopen("../model/prereq.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $data[1] = strtoupper($data[1]);
                $courseName = $data[0];
                
                //Setting permission requirement
                if(strstr($data[1], 'PERMISSION OF THE DEPARTMENT') !== FALSE) {
                    $departmentPerReq = 'T';
                    $data[1] = strstr($data[1], 'PERMISSION OF THE DEPARTMENT', true);
                }
                else {
                    $departmentPerReq = 'F';
                }
                
                //Setting program prerequisite
                if(strstr($data[1], 'ENGINEERING') !== FALSE) {
                    $stringToAppend = '';
                    if(strstr($data[1], 'BIOMEDICAL AND MECHANICAL ENGINEERING') !== FALSE){
                        $data[1] = str_replace('BIOMEDICAL AND MECHANICAL ENGINEERING','',$data[1]);
                        $stringToAppend .= 'BME ';
                    }
                    if(strstr($data[1], 'BIOMEDICAL AND ELECTRICAL ENGINEERING') !== FALSE){
                        $data[1] = str_replace('BIOMEDICAL AND ELECTRICAL ENGINEERING','',$data[1]);
                        $stringToAppend .= 'BEE ';
                    }
                    if(strstr($data[1], 'ELECTRICAL ENGINEERING') !== FALSE){
                        $data[1] = str_replace('ELECTRICAL ENGINEERING','',$data[1]);
                        $stringToAppend .= 'EE ';
                    }
                    if(strstr($data[1], 'SOFTWARE ENGINEERING') !== FALSE){
                        $data[1] = str_replace('SOFTWARE ENGINEERING','',$data[1]);
                        $stringToAppend .= 'SE ';
                    }
                    if(strstr($data[1], 'COMPUTER SYSTEMS ENGINEERING') !== FALSE){
                        $data[1] = str_replace('COMPUTER SYSTEMS ENGINEERING','',$data[1]);
                        $stringToAppend .= 'CSE ';
                    }
                    if(strstr($data[1], 'COMMUNICATIONS ENGINEERING') !== FALSE){
                        $data[1] = str_replace('COMMUNICATIONS ENGINEERING','',$data[1]);
                        $stringToAppend .= 'CE ';
                    }
                    if(strstr($data[1], 'SUSTAINABLE AND RENEWABLE ENERGY ENGINEERING') !== FALSE){
                        $data[1] = str_replace('SUSTAINABLE AND RENEWABLE ENERGY ENGINEERING','',$data[1]);
                        $stringToAppend .= 'SREE ';
                    }
                    if(strstr($data[1], 'ENGINEERING PHYSICS') !== FALSE){
                        $data[1] = str_replace('ENGINEERING PHYSICS','',$data[1]);
                        $stringToAppend .= 'EP ';
                    }
                    if(strstr($data[1], 'ENGINEERING') !== FALSE){
                        $data[1] = str_replace('ENGINEERING','',$data[1]);
                        $stringToAppend .= 'ENG ';
                    }
                    $programReq = $stringToAppend;
                }
                else {
                    $programReq = '';
                }
                
                //Setting year prerequisite
                $yearReq = 0;
                if(strstr($data[1], 'YEAR') !== FALSE) {
                    if(strstr($data[1], 'FOURTH-YEAR STATUS IN') !== FALSE){
                        $data[1] = str_replace('FOURTH-YEAR STATUS IN','',$data[1]);
                        $yearReq = 4;
                    }
                    if(strstr($data[1], 'THIRD-YEAR STATUS IN') !== FALSE){
                        $data[1] = str_replace('THIRD-YEAR STATUS IN','',$data[1]);
                        $yearReq = 3;
                    }
                }
                
                //Clean up
                $tempStr = strstr($data[1], 'ONAL');
                if($tempStr !== FALSE) {
                    $data[1] = str_replace($tempStr,'',$data[1]);
                }
                $data[1] = str_replace('(','',$data[1]);
                $data[1] = str_replace(')','',$data[1]);
                $data[1] = str_replace(',','',$data[1]);
                $data[1] = str_replace('ENROLMENT IN THE','',$data[1]);
                $data[1] = str_replace('PROGRAM','',$data[1]);
                $data[1] = str_replace('DESIGN','',$data[1]);
                
                //Finding concurrent requirement
                $course = '';
                while(strpos($data[1],'MAY BE TAKEN CONCURRENTLY') !== FALSE){
                    $tempStr = strstr($data[1],'MAY BE TAKEN CONCURRENTLY', true);
                    $course .= substr($tempStr,-10,9).",";
                    
                    $pos = strpos($data[1],'MAY BE TAKEN CONCURRENTLY');
                    $data[1] = substr_replace($data[1],'',$pos,strlen('MAY BE TAKEN CONCURRENTLY'));
                }
                $concurrent = $course;
                
                //Finally parse the courses
                $preReqCourse = explode("AND",$data[1]);
                $arrayOfPreReq = ['firstPreReq','secondPreReq','thirdPreReq'];
                $arrayOfSubject = ["ECOR ","ELEC ","SYSC ","COMP ","MATH ","STAT ","PHYS "];
                //Clean up blocks that dont contain courses
                for($i = 0; $i < sizeof($preReqCourse); $i++){
                    $hit = 0;
                    foreach ($arrayOfSubject as $subject) {
                        if(strpos($preReqCourse[$i],$subject) !== FALSE){
                            $hit++;
                        }
                    }
                    if($hit==0){
                        $preReqCourse[$i] = '';
                    }
                }
                $emptyRemoved = array_filter($preReqCourse);
                for($i = 0; $i < sizeof($preReqCourse); $i++){
                    if($i == 0){
                        $firstPreReq = $preReqCourse[0];
                    }
                    if($i == 1){
                        $firstPreReq = $preReqCourse[0]; 
                        $secondPreReq = $preReqCourse[1];
                    }
                    if($i == 2){
                        $firstPreReq = $preReqCourse[0]; 
                        $secondPreReq = $preReqCourse[1];
                        $thirdPreReq = $preReqCourse[2];
                    }
                }
                $format = "INSERT INTO course_prereq(courseName,yearReq,programReq,departmentPerReq,concurrent,firstPreReq,secondPreReq,thirdPreReq)
                        VALUES('%s',%s,'%s','%s','%s','%s','%s','%s');";
                $sql = sprintf($format,$courseName,$yearReq,$programReq,$departmentPerReq,$concurrent,$firstPreReq,$secondPreReq,$thirdPreReq);
                $DB->execute($sql);
                echo $DB->getError();
            }
            fclose($handle);
        }
    }



?>
