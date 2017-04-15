<?php	
	session_start(); // Starting Session	
	$error=''; // Variable To Store Error Message
	$lat=$_POST['lat1'];
	$lng=$_POST['lng1'];
	$usr = $_SESSION['login_user'];
		
  	include $_SERVER['DOCUMENT_ROOT'].'/framework/mysqlconn/mysql_login.php';
	$db = mysql_select_db("yatzy", $connection);	
	$lat = stripslashes($lat);
	$lng = stripslashes($lng);
	$lat = mysql_real_escape_string($lat);
	$lng = mysql_real_escape_string($lng);	


	// SQL query to fetch information of registerd users and finds user match.
	$query = mysql_query("update Users set Latitude='$lat', Longitude='$lng' where Nickname='$usr'", $connection);
	//$rows = mysql_num_rows($query);
	//header("Access-Control-Allow-Origin: *");
	//header("Content-Type: application/json; charset=UTF-8");
	
	//if ($rows == 1) {
//		$profileImg = mb_convert_encoding(mysql_result($query,0,"ProfileImageSrc"),  'UTF-8', 'ISO-8859-1');
//		$_SESSION['login_user']=$username; // Initializing Session
//		$_SESSION['login_pass']=$password;
//		$_SESSION['profile_img']=$profileImg;		

		$arr = array("status" => "success");
   		echo json_encode($arr, JSON_FORCE_OBJECT);
	//} 
	//else {
	//	$arr = array("status" => "failed");
	//	echo json_encode($arr, JSON_FORCE_OBJECT);
//	}
	mysql_close($connection); // Closing Connection	
?>