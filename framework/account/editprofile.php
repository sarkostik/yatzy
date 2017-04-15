<?php	
	session_start(); // Starting Session	
	$error = ''; // Variable To Store Error Message
	$username = $_POST['user1'];
	$password = $_POST['password1'];
	$address = $_POST['address1'];
	$email = $_POST['email1'];
	$zip = $_POST['zip1'];
	$zipAddress = $_POST['zipAddress1'];
	$surname = $_POST['surname1'];
	$lastname = $_POST['lastname1'];

		
  	include $_SERVER['DOCUMENT_ROOT'].'/framework/mysqlconn/mysql_login.php';
	$db = mysql_select_db("yatzy", $connection);	
	$currUser = $_SESSION['login_user'];

	$username = stripslashes($username);
	$username = mysql_real_escape_string($username);	
	$password = stripslashes($password);	
	$password = mysql_real_escape_string($password);
	$email = stripslashes($email);	
	$email = mysql_real_escape_string($email);
	$address = stripslashes($address);	
	$address = mysql_real_escape_string($address);	
	$zip = stripslashes($zip);	
	$zip = mysql_real_escape_string($zip);
	$zipAddress = stripslashes($zipAddress);	
	$zipAddress = mysql_real_escape_string($zipAddress);
	$lastname = stripslashes($lastname);	
	$lastname = mysql_real_escape_string($lastname);
	$surname = stripslashes($surname);	
	$surname = mysql_real_escape_string($surname);

	// Selecting Database
	$db = mysql_select_db("yatzy", $connection);
	
	$sqlLine = "update Users set Nickname = '$username', Password='$password', Address='$address', Zip='$zip', ZipAddress='$zipAddress', Surname='$surname', Lastname='$lastname' where Nickname='$currUser'";
		 
	$query = mysql_query($sqlLine, $connection);
	$rows = mysql_num_rows($query);
	
	echo $sqlLine;

	mysql_close($connection); // Closing Connection	
?>