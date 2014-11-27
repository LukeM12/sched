<?php 
	$login = $_COOKIE['user'];
    $classesTaken = array();
    $connection = mysqli_connect("127.0.0.1", "root", "oops123", "uni");

	$sql = "SELECT * FROM student WHERE studentID = '$login';";
	$id = $connection->query($sql);
	$row_id = $id->fetch_assoc();
	$toTake = $row_id['year'] - 1;
	$nextLevel = $row_id['year']; 
	$dynamicLevel = $row_id['year']; 
	
	while ($toTake != 0){
		$sql = "SELECT * FROM ce_program WHERE year ='$toTake';";
		$classes = $connection->query($sql);
	
			while($row_classes = $classes->fetch_assoc()){ 
	
	
				$sql = "INSERT IGNORE INTO courses_taken (studentID, courseName) VALUES ('$login', '".$row_classes['courseName']."')";
				$insert = $connection->query($sql);
			}
	
		$toTake = $toTake - 1;
					
	}  					
	
	while($nextLevel < 5){
	$sql = "SELECT * FROM ce_program WHERE year ='$nextLevel';";			
	$nextClasses = $connection->query($sql);
	
		while($row_nextClasses = $nextClasses->fetch_assoc()){
	
			if($nextLevel == $dynamicLevel){ //this is to ensure the eligibility can be set dynamically, not using hard coded values
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
	echo "Done"; // echo done just to make sure this works before timing out
	?>


