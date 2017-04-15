<?php
	session_start();
	
	$holdArr = array();
	$holdArr = $_SESSION['holdBtn'];

	$hold=$_POST['holdDice'];	
	
	switch ($hold) {
		case '1':
			$holdArr[0] = true;
			break;
		case '2':
			$holdArr[1] = true;
			break;
		case '3':
			$holdArr[2] = true;
			break;
		case '4':
			$holdArr[3] = true;
			break;
		case '5':
			$holdArr[4] = true;
			break;

		case '-1':
			$holdArr[0] = null;
			break;
		case '-2':
			$holdArr[1] = null;
			break;
		case '-3':
			$holdArr[2] = null;
			break;
		case '-4':
			$holdArr[3] = null;
			break;
		case '-5':
			$holdArr[4] = null;
			break;
	}

	$_SESSION['holdBtn'] = $holdArr;

	$hold1 = $holdArr[0];
	$hold2 = $holdArr[1];
	$hold3 = $holdArr[2];
	$hold4 = $holdArr[3];
	$hold5 = $holdArr[4];


	$arr = array("hold1" => $hold1, "hold2" => $hold2, "hold3" => $hold3, "hold4" => $hold4, "hold5" => $hold5);
	echo json_encode($arr, JSON_FORCE_OBJECT);
?>