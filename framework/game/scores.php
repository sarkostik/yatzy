<?php	
	session_start();

	$scores = $_SESSION['scores'];
	$upperSection = $scores['ones'] + $scores['twos'] + $scores['threes'] + $scores['fours'] + $scores['fives'] + $scores['sixes'];
	$bonus = 0;

	if ($upperSection >= 63)
		$bonus = 50;

	$lowerSection = $scores['onepairs'] + $scores['twopairs'] + $scores['threeofkind'] + 
			$scores['fourofakind'] + $scores['fullhouse'] + $scores['smallstraight'] + $scores['largestraight'] + $scores['yatzy'] + $scores['chance'];

	$gameStatus = $_SESSION['gameCounter'];
	$arr = array("uppper_section" => $upperSection, "bonus" => $bonus, "lower_section" => $lowerSection, "gameCounter" => $gameStatus);
	echo json_encode($arr, JSON_FORCE_OBJECT);
?>