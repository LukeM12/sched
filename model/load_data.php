<?php
    //To load the script run "http://localhost/model/load_data.php"

    function loadCSVfiles($DB) {
        $dir = getcwd();
        
        $pieces = explode("/", $dir);
        $size_path = sizeof($pieces);
        $OS = '';

        if ( $size_path == 1 ){
            $pieces = explode("\\", $dir);
		    $size_path = sizeof($pieces);
		    $OS = $OS.'WINDOWS';
		}
		else {
			$OS = $OS.'LINUX';
		}
        
        $final_path = '';
		$ce_program = ''; //this array later on
		$courses = '';
		if ( strcmp($OS, "LINUX") == 0 ){ 
			$i=0;
			while( strcmp($pieces[$i], 'controller') != 0){
				if ($i==0){
					$final_path = $pieces[$i];
				}	
				else{
					$final_path = $final_path.'/'.$pieces[$i];
				}			
				$i++;
			}
			$final_path = $final_path.'/';
            $courses= $final_path.'model/course_data.csv';
            $ce_program = $final_path.'model/ce_program.csv';
		}
		//Data filepath reconstruction on Linux Operating Systems
		if ( strcmp($OS, "WINDOWS") == 0 ){  	
			$i=0;
			while( strcmp($pieces[$i], 'controller') != 0){
				if ($i==0){
					$final_path = $pieces[$i];
				}	
				else{
					$final_path = $final_path.'/'.$pieces[$i];
				}			
				$i++;
			}
			$final_path = $final_path.'/';
			$courses= $final_path.'model/course_data.csv';
            $ce_program = $final_path.'model/ce_program_c.csv';
		}

        $enclosed =  '"';
	    $sql=   'LOAD DATA LOCAL INFILE "'.$courses.'"                 
		        INTO TABLE course 
		        FIELDS 
		        	TERMINATED BY ";" 
		        	ENCLOSED BY "\""
		        		LINES TERMINATED BY "\n" IGNORE 1 LINES';

        //Up until now, the path is effectively the right path to the data, and that is validated
        $DB->execute($sql);
        echo $DB->getError();
        $enclosed =  '"';
	    $sql=   'LOAD DATA LOCAL INFILE "'.$ce_program.'"                 
		        INTO TABLE ce_program
		        FIELDS 
		        	TERMINATED BY ";" 
		        		LINES TERMINATED BY "\n" IGNORE 1 LINES';

       $DB->execute($sql);
        echo $DB->getError();
    }

    /*
     * Description: Create the necessary tables for the site
     * param: A live instance of the database
     * return: implicit -> the tables are now produced //Return Bool?
     **/

    function testInitTables($DB) {
        //set up
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse) 
                values ('111', 'Bob', '111', 'T', 'F');";
        $DB->execute($sql);
        echo $DB->getError();
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse) 
                values ('222', 'Mike', '111', 'T', 'T');";
        $DB->execute($sql);
        echo $DB->getError();
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse) 
                values ('333', 'Blob', '111', 'F', 'F');";
        $DB->execute($sql);
        echo $DB->getError();
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse) 
                values ('444', 'Mlob', '111', 'F', 'T');";
        $DB->execute($sql);
        echo $DB->getError();
       /*
           INSERT INTO COURSES TAKEN
        $sql = "INSERT INTO courses_Taken(studentID, subject, courseID) values ('223', 'SYSC', '2001');";
        $connection->query($sql);
        echo mysqli_error($connection);
            }*/
    }
    
/*

    THIS IS ALL GARBAGE ONCE THE CROSS PLATFORM SOLUATION WORKS */    
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
        /* In Linux the file paths is '/', and in Windows '\') */
?>
