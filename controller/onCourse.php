<?php 
//Scripting to Do some OnCourse Logic 
$login = $_COOKIE['user'];
$classesTaken = array();
$connection = mysqli_connect("127.0.0.1", "root", "oops123", "uni");
$sql = "SELECT * FROM student WHERE studentID = '$login';";
$id = $connection->query($sql);
$row_id = $id->fetch_assoc();
onCourse_CoursesTaken($login, $connection, $row_id);
onCourse_CoursesNeeded($login, $connection,$row_id);	
/** 
 * 
 * @param $login
 * @param $connection
 * @param $row_id
 */
function onCourse_CoursesTaken($login, $connection, $row_id){
	$toTake = $row_id['year'] - 1;
	while ($toTake != 0){
		$sql = "SELECT * FROM ce_program WHERE year ='$toTake';";
		$classes = $connection->query($sql);
		while($row_classes = $classes->fetch_assoc()){ 
			$sql = "INSERT IGNORE INTO courses_taken (studentID, courseName) VALUES ('$login', '".$row_classes['courseName']."')";			
			$insert = $connection->query($sql);
		}
		$toTake = $toTake - 1;			
	}  					
}
/** 
 * 
 * @param unknown $login
 * @param unknown $connection
 * @param unknown $row_id
 */	
function onCourse_CoursesNeeded($login, $connection, $row_id){
	$nextLevel = $row_id['year']; 
	$dynamicLevel = $row_id['year']; 
	while($nextLevel < 5){
		$sql = "SELECT * FROM ce_program WHERE year ='$nextLevel';";			
		$nextClasses = $connection->query($sql);
		while($row_nextClasses = $nextClasses->fetch_assoc()){
			if($nextLevel == $dynamicLevel){ 
				$sql = "INSERT IGNORE INTO courses_needed (studentID, courseName, year, term, eligible) VALUES ('$login', '".$row_nextClasses['courseName']."', '$nextLevel','".$row_nextClasses['term']."' , 'Y')";
				$insert1 = $connection->query($sql);
			}
			else {
					$sql = "INSERT IGNORE INTO courses_needed (studentID, courseName, year, term, eligible) VALUES ('$login', '".$row_nextClasses['courseName']."', '$nextLevel','".$row_nextClasses['term']."' , 'N')";
					$insert2 = $connection->query($sql);
			}
		}					
			$nextLevel = $nextLevel + 1;
	}		
}
?>


