<?php
    //To load the script run "http://localhost/model/load_data.php"

    function loadCSVfiles($DB) {
        /**
        * Uncomment this section to parse the files on Linux box and comment out the 
        * Windows section
        */
        /*
	    $sql=   'LOAD DATA LOCAL INFILE "/opt/lampp/htdocs/model/course_data.csv"                 
		        INTO TABLE course 
		        FIELDS 
		        	TERMINATED BY ";" 
		        	ENCLOSED BY "\""
		        		LINES TERMINATED BY "\n" IGNORE 1 LINES';
                
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = 'LOAD DATA LOCAL INFILE "/opt/lampp/htdocs/model/ce_program_course_data.csv"
                INTO TABLE ce_program
                FIELDS 
                    TERMINATED BY ";"
                LINES 
                	TERMINATED BY "\n";';

        $DB->execute($sql);
        echo $DB->getError();
        */
        
        /**
        * Uncomment this section to parse the files on Windows box and comment out the 
        * Linux section
        */
        $enclosed =  '"';
        $sql = "LOAD DATA LOCAL INFILE '../model/course_data.csv'
                INTO TABLE course
                FIELDS 
                    TERMINATED BY ';'
                    ENCLOSED BY '".$enclosed."'
                LINES 
                    TERMINATED BY '\r\n'
                IGNORE 1 LINES;";
                
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "LOAD DATA LOCAL INFILE '../model/ce_program.csv'
                INTO TABLE ce_program
                FIELDS 
                    TERMINATED BY ';'
                LINES 
                    TERMINATED BY '\r\n';";
        $DB->execute($sql);
        echo $DB->getError();
    }

    //mysql> LOAD DATA LOCAL INFILE '/opt/lampp/htdocs/model/course_data.csv'                 INTO TABLE course FIELDS TERMINATED BY ';' ENCLOSED BY '"' LINES TERMINATED BY '\n' IGNORE 1 LINES;

    //testInitTables($connection);
    //$studentID = 223;
    //populateCoursesNeeded($connection, $studentID);

    /*
     * Description: Create the necessary tables for the site
     * param: A live instance of the database
     * return: implicit -> the tables are now produced //Return Bool?
     **/

    function testInitTables($DB) {
        //set up
        
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse, year, program) 
                values ('111', 'Bob', '111', 'T', 'F', 1, 'CE');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse, year, program) 
                values ('222', 'Mike', '111', 'T', 'T', 3, 'CE');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse, year, program) 
                values ('333', 'Blob', '111', 'F', 'F', 2, 'CE');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse, year, program) 
                values ('444', 'Mlob', '111', 'F', 'T', 3, 'CE');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        /*$sql = "SELECT * FROM courses_Taken WHERE courseID='223';";
        $result = $connection->query($sql);
        echo mysqli_error($connection);
        $rows = $result->num_rows;
        if($rows==0){
            $sql = "INSERT INTO courses_Taken(studentID, subject, courseID) values ('223', 'ECOR', '1101');";
            $connection->query($sql);
            echo mysqli_error($connection);
            
            $sql = "INSERT INTO courses_Taken(studentID, subject, courseID) values ('223', 'MATH', '1104');";
            $connection->query($sql);
            echo mysqli_error($connection);
            
            $sql = "INSERT INTO courses_Taken(studentID, subject, courseID) values ('223', 'SYSC', '2004');";
            $connection->query($sql);
            echo mysqli_error($connection);
            
            $sql = "INSERT INTO courses_Taken(studentID, subject, courseID) values ('223', 'SYSC', '2001');";
            $connection->query($sql);
            echo mysqli_error($connection);
        }*/
    }
    
    
?>
