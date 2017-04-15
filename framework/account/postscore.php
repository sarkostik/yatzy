<?php
	session_start();

	$myCounter = $_SESSION['rolls'];	

	if ($myCounter == 3)
		$myCounter = 0;

	$arr = array("gameRun" => $myCounter);
	echo json_encode($arr, JSON_FORCE_OBJECT);
?>