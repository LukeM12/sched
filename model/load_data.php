<?php
//To load the script run "http://localhost/model/load_data.php"

$host = "127.0.0.1";
$user = "root";
$password = "oops123";
$enclosed =  '"';

$connection = mysqli_connect($host,$user,$password,'uni');

$sql = "LOAD DATA LOCAL INFILE '../model/course_data.csv'
        INTO TABLE course
        FIELDS 
            TERMINATED BY ';'
            ENCLOSED BY '".$enclosed."'
        LINES 
            TERMINATED BY '\r\n'
        IGNORE 1 LINES;";
        
$connection->query($sql);
echo mysqli_error($connection);

$sql = "LOAD DATA LOCAL INFILE '../model/ce_program_course_data.csv'
        INTO TABLE ce_program
        FIELDS 
            TERMINATED BY ';'
        LINES 
            TERMINATED BY '\r\n';";

$connection->query($sql);
echo mysqli_error($connection);
?>