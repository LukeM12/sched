
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
		echo "THIS IS THIE SHIT BOI=".$courses;

