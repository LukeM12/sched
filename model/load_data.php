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
		$courses_fall = '';
        $courses_winter = '';
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
            $courses_fall= $final_path.'model/course_data_fall.csv';
            $courses_winter = $final_path.'model/course_data_winter.csv';
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
			$courses_fall= $final_path.'model/course_data_fall.csv';
            $courses_winter = $final_path.'model/course_data_winter.csv';
            $ce_program = $final_path.'model/ce_program.csv';
		}

        $enclosed =  '"';
	    $sql=   'LOAD DATA LOCAL INFILE "'.$courses_fall.'"                 
		        INTO TABLE course 
		        FIELDS 
		        	TERMINATED BY ";" 
		        	ENCLOSED BY "\""
		        		LINES TERMINATED BY "\n" 
                IGNORE 1 LINES
                    SET term="F"';

        //Up until now, the path is effectively the right path to the data, and that is validated
        $DB->execute($sql);
        echo $DB->getError();
        $enclosed =  '"';
	    $sql=   'LOAD DATA LOCAL INFILE "'.$courses_winter.'"                 
		        INTO TABLE course 
		        FIELDS 
		        	TERMINATED BY ";" 
		        	ENCLOSED BY "\""
		        		LINES TERMINATED BY "\n" 
                IGNORE 1 LINES
                    SET term="W"';

        //Up until now, the path is effectively the right path to the data, and that is validated
        $DB->execute($sql);
        echo $DB->getError();
        $enclosed =  '"';
	    $sql=   'LOAD DATA LOCAL INFILE "'.$ce_program.'"                 
		        INTO TABLE ce_program
		        FIELDS 
		        	TERMINATED BY ";" 
		        		LINES TERMINATED BY "\n"';

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
        
        $sql = "INSERT IGNORE INTO student(studentID, name, password, newUser, onCourse, year, program) 
                values ('111', 'Bob', '111', 'T', 'F', 1, 'CE');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "INSERT IGNORE INTO student(studentID, name, password, newUser, onCourse, year, program) 
                values ('222', 'Mike', '111', 'T', 'T', 3, 'CE');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "INSERT IGNORE INTO student(studentID, name, password, newUser, onCourse, year, program) 
                values ('333', 'Blob', '111', 'F', 'F', 2, 'CE');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "INSERT IGNORE INTO student(studentID, name, password, newUser, onCourse, year, program) 
                values ('444', 'Mlob', '111', 'F', 'T', 3, 'CE');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
    }
?>
