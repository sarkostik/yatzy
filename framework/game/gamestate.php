<?php
	session_start();
	
	$holdArr = array();
	$holdArr = $_SESSION['holdBtn'];	
	$gameRun = $_SESSION['rolls'];
	$hold=$_POST['status'];	


	$arr = array("gamerun" => $gameRun ,"hold1" => $holdArr[0], "hold2" => $holdArr[1], "hold3" => $holdArr[2], "hold4" => $holdArr[3], "hold5" => $holdArr[4]);
	echo json_encode($arr, JSON_FORCE_OBJECT);
?>