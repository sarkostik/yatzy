<?php	
	session_start(); // Starting Session	
	$error=''; // Variable To Store Error Message	
	$usr = $_SESSION['login_user'];		
  	include $_SERVER['DOCUMENT_ROOT'].'/framework/mysqlconn/mysql_login.php';
		
	// Selecting Database
	$db = mysql_select_db("yatzy", $connection);
	// SQL query to fetch information of registerd users and finds user match.
	$query = mysql_query("select Latitude, Longitude from Users where Nickname='$usr'", $connection);
	$rows = mysql_num_rows($query);
	//header("Access-Control-Allow-Origin: *");
	//header("Content-Type: application/json; charset=UTF-8");

	if ($rows == 1) {
		$lat = mysql_result($query,0,"Latitude");
		$lng = mysql_result($query,0,"Longitude");

		if ($lat !=""){
			$arr = array("status" => "success", "lng" => "$lng", "lat" => "$lat");   			
			echo json_encode($arr, JSON_FORCE_OBJECT);
		}		
	} 
	else {
		$arr = array("status" => "failed");				
	}

	mysql_close($connection); // Closing Connection		
?>