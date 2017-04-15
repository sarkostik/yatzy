<?php
	session_start(); // Starting Session	
	$error=''; // Variable To Store Error Message
  	include $_SERVER['DOCUMENT_ROOT'].'/framework/mysqlconn/mysql_login.php';
	$db = mysql_select_db("yatzy", $connection);	
	$username = $_SESSION['login_user'];
	$username = stripslashes($username);
	$username = mysql_real_escape_string($username);

	// Selecting Database
	$db = mysql_select_db("yatzy", $connection);
	// SQL query to fetch information of registerd users and finds user match.
	$query = mysql_query("select * from Users where Nickname='$username'", $connection);
	$rows = mysql_num_rows($query);
		
	if ($rows == 1) {
		$profileImg = mb_convert_encoding(mysql_result($query,0,"ProfileImageSrc"),  'UTF-8', 'ISO-8859-1');
		$surname = mysql_result($query,0,"Surname");
		$lastname = mysql_result($query,0,"Lastname");
		$email = mb_convert_encoding(mysql_result($query,0,"Email"),  'UTF-8', 'ISO-8859-1');
		$userlvl = mb_convert_encoding(mysql_result($query,0,"Userlevel"),  'UTF-8', 'ISO-8859-1');		
		$address = mysql_result($query,0,"Address");		
		$zip = mb_convert_encoding(mysql_result($query,0,"Zip"),  'UTF-8', 'ISO-8859-1');		
		$zipAddress = mb_convert_encoding(mysql_result($query,0,"ZipAddress"),  'UTF-8', 'ISO-8859-1');		
	} 
	else {		
		$error ="failed";
	}
	mysql_close($connection); // Closing Connection	
?>