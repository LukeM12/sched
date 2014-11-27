<?php
    //To load the script run "http://localhost/model/load_data.php"

    function loadCSVfiles($DB) {
        $dir = getcwd();
		echo "this is the current direc=".$dir;
        $pieces = explode("/", $dir);
        echo ' this is what hit is';

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
		        echo $pieces[0];
		//This is the effective path that directs to the data
		//We could do an AJAX call for the data (i.e.("GET,"../course/data.csv")
		//But permissions would disallow this kind of access to
		//large data to the client browser
		//in a "real" scenario. The best way to do is cross platform
		
		//Reconstruct the file path
        $final_path = '';
		/*if ( strcmp($OS, "WINDOWS") == 0 ){  	
			for ($i=0; $i < $size_path-1; $i++ ){
				$final_path = $final_path.'\\'.$pieces[$i];
			}
		}*/
		//Ok this works
		
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
		}
		
				//Ok this works
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
		}
		echo "THIS IS THIE SHIT BOI=".$courses;

        $enclosed =  '"';
        $sql = "LOAD DATA LOCAL INFILE '".$courses."'
                INTO TABLE course
                FIELDS 
                    TERMINATED BY ';'
                    ENCLOSED BY '".$enclosed."'
                LINES 
                    TERMINATED BY '\r\n'
                IGNORE 1 LINES;";
                
        $DB->execute($sql);
        echo $DB->getError();
        
        /*$sql = "LOAD DATA LOCAL INFILE '/opt/lampp/htdocs/model/ce_program_course_data.csv'
                INTO TABLE ce_program
                FIELDS 
                    TERMINATED BY ';'
                LINES 
                    TERMINATED BY '\r\n';";
       //$DB->execute($sql);
        //echo $DB->getError();*/
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
        
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse) 
                values ('111', 'Bob', '111', 'T', 'F');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse) 
                values ('222', 'Mike', '111', 'T', 'T');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse) 
                values ('333', 'Blob', '111', 'F', 'F');";
        //$connection->query($sql);
        //echo mysqli_error($connection);
        $DB->execute($sql);
        echo $DB->getError();
        
        $sql = "INSERT INTO student(studentID, name, password, newUser, onCourse) 
                values ('444', 'Mlob', '111', 'F', 'T');";
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
