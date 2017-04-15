<?php 
	session_start();		
	
		if ($_SESSION['login_user'] != null){
		$r = array();
		$dices = array();	
		$memDices = array();
		$holdArr = array();
		
		$_SESSION['rolls']++;
		$user = $_SESSION['login_user'];
		$myCounter = $_SESSION['rolls'];
		$memDices = $_SESSION['dices'];
		$holdArr = $_SESSION['holdBtn'];
		
		$scores = $_SESSION['scores'];

		if ($scores == null){		
			$scores = array(
				'ones'=>null, 
				'twos'=>null, 
				'threes'=>null, 
				'fours'=>null,
				'fives'=>null,
				'sixes'=>null,
				'onepairs'=>null,
				'twopairs'=>null,
				'threeofkind'=>null,
				'fourofakind'=>null,
				'fullhouse'=>null,
				'smallstraight'=>null,
				'largestraight'=>null,
				'yatzy'=>null,
				'chance'=>null
			);
			$_SESSION['scores'] = $scores;
		}

		include $_SERVER['DOCUMENT_ROOT'].'/framework/mysqlconn/mysql_login.php';
		$db = mysql_select_db("yatzy", $connection);	

		if ($myCounter <= 3)
		{	
			for ($i = 0; $i <= 4; $i++) 
			{			
				if ($holdArr[$i] == null)
				{
					$n = rand(1,6);	 		
			
					if ($n == "1"){
						$dices[$i] = 1;				
						$r[$i] = "one.svg";			
					}			
					
					if ($n == "2"){
						$dices[$i] = 2;				
						$r[$i] = "two.svg";
					}
					
					if ($n == "3"){
						$dices[$i] = 3;				
						$r[$i] = "three.svg";			
					}
					
					if ($n == "4"){
						$dices[$i] = 4;				
						$r[$i] = "four.svg";
					}
					
					if ($n == "5"){
						$dices[$i] = 5;				
						$r[$i] = "five.svg";
					}			
					
					if ($n == "6"){
						$dices[$i] = 6;
						$r[$i] = "six.svg";			
					}
				}	
				else
				{
					$dices[$i] = $memDices[$i];
				}			
			}	

			$sessionTime = new DateTime($datefinish);
			$sTime = $sessionTime->format('Y-m-d H:i:s');
			$sqlLine = $user."','".$dices[0]."','".$dices[1]."','".$dices[2]."','".$dices[3]."','".$dices[4]."','".$sTime."','".$myCounter;
			$query = mysql_query("insert into Gamelogg (Nickname, Dice1, Dice2, Dice3, Dice4, Dice5, SessionTime, GameCounter) values ('".$sqlLine."')" , $connection);
			mysql_close($connection); // Closing Connection	
		}
		else
		{
			$_SESSION['rolls'] = 0;
		}	

		$_SESSION['dices'] = $dices;

		if ($myCounter > 1)
			$_SESSION['test'] = $memDices;
		else
			$_SESSION['test'] = $dices;

		$memDicesL = $dices[0].",".$dices[1].",".$dices[2].",".$dices[3].",".$dices[4];
			
		$arr = array("time" => $sTime  ,"memDices" => $memDicesL,"counter" => $myCounter , "dice1" => $r[0], "dice2" => $r[1], "dice3" => $r[2], "dice4" => $r[3], "dice5" => $r[4]);
	}
	else{
		$arr = array("status" => "error");				
	}
	
	echo json_encode($arr, JSON_FORCE_OBJECT);
		
?>