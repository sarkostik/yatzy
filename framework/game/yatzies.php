<?php
	session_start();

	$usr = $_SESSION['login_user'];		
  	include $_SERVER['DOCUMENT_ROOT'].'/framework/mysqlconn/mysql_login.php';		
	
	$db = mysql_select_db("yatzy", $connection);	
	
	$sqlLine1 = "select max(Score) as Score, Nickname, Latitude, Longitude, ProfileImageSrc from Highscores, Users";
	$sqlLine2 = " where Highscores.UserId = Email group by Score, Nickname,Latitude, Longitude";

	$query = mysql_query($sqlLine1. $sqlLine2, $connection);
	$rows = mysql_num_rows($query);

	$arr = array();

	for ($x = 0; $x < $rows; $x++){
		$lat = mysql_result($query,$x,"Latitude");
		$lng = mysql_result($query,$x,"Longitude");
		$score = mysql_result($query,$x,"Score");
		$nickname = mysql_result($query,$x,"Nickname");
		$profileImg = mysql_result($query,$x,"ProfileImageSrc");

		$arr[] = array("score" => $score, "nickname" => $nickname, "lat" => $lat, "lng" => $lng, "profileimg" => $profileImg);
	}

	echo json_encode($arr, JSON_FORCE_OBJECT);
?>