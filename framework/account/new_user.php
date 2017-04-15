<?php	
	session_start(); // Starting Session	
	$error=''; // Variable To Store Error Message
	$username=$_POST['user1'];
	$password=$_POST['password1'];
	$email=$_POST['email1'];
	
  	include $_SERVER['DOCUMENT_ROOT'].'/framework/mysqlconn/mysql_login.php';
	$db = mysql_select_db("yatzy", $connection);	
	$username = stripslashes($username);
	$password = stripslashes($password);
	$email = stripslashes($email);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	$email = mysql_real_escape_string($email);
	// Selecting Database
	$db = mysql_select_db("yatzy", $connection);
	// SQL query to fetch information of registerd users and finds user match.
	$query = mysql_query("select * from Users where Email='$email'", $connection);
	$rows = mysql_num_rows($query);
	//header("Access-Control-Allow-Origin: *");
	//header("Content-Type: application/json; charset=UTF-8");
	
	if ($rows == 1) {
		$usr = mb_convert_encoding(mysql_result($query,0,"Nickname"),  'UTF-8', 'ISO-8859-1');
		if ($usr == null){
			$query = mysql_query("update Users set Nickname='$username', Password='$password', Userlevel='3' where Email='$email'", $connection);

			echo "ny användare ";
		}
		else{
			echo $usr . " finns redan!";
		}

		echo mb_convert_encoding(mysql_result($query,0,"Email"),  'UTF-8', 'ISO-8859-1');
		//$_SESSION['login_user']=$username; // Initializing Session
		//$_SESSION['login_pass']=$password;
		//$_SESSION['profile_img']=$profileImg;		

		//$arr = array("user" => $username, "profileImg" => $profileImg, "status" => "newsession");
   		//echo json_encode($arr, JSON_FORCE_OBJECT);
	} 
	else {
		//$arr = array("user" => "none", "profileImg" => "", "status" => "failed");
		//echo json_encode($arr, JSON_FORCE_OBJECT);
		echo "hittade inget";
	}
	mysql_close($connection); // Closing Connection	
?>