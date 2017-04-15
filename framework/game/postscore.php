<?php 
	session_start();
	$dices = $_SESSION['test'];
	$rolls = $_SESSION['rolls'];
	$gameStatus = $_SESSION['gameCounter'];

	if ($gameStatus == null)
		$gameStatus = 0;

	$choosedScore=$_POST['choosedScore'];			
	$fD = isStraight($dices);
	$dice1 = $fD[0];
	$dice2 = $fD[1];
	$dice3 = $fD[2];
	$dice4 = $fD[3];
	$dice5 = $fD[4];
	$dice6 = $fD[5];
	$scores = $_SESSION['scores'];
	$score = 0;

	if ($choosedScore <= 6 && $choosedScore >=1){
		$score = sum16Score($choosedScore, $dices);

		switch ($choosedScore) {
			case 1:
				$scores['ones'] = $score;
				break;

			case 2:
				$scores['twos'] = $score;
				break;

			case 3:
				$scores['threes'] = $score;
				break;

			case 4:
				$scores['fours'] = $score;
				break;

			case 5:
				$scores['fives'] = $score;
				break;

			case 6:
				$scores['sixes'] = $score;
				break;			
		}

	}

	if ($choosedScore >= 7){		
		$sumpair = array();
		$sumpair = sumPairs($dices);

		if ($choosedScore == 15){			
			$score = sumDices($dices);
			$scores['chance'] = $score;
		}		

		if ($choosedScore == 14){
			$score = 0;
			if ($sumpair[0] == 4){
				$score = 50;				
			}
			$scores['yatzy'] = $score;
		}		

		if ($choosedScore == 13){
			$score = 0;
			if ($dice2 && $dice3 && $dice4 && $dice5 && $dice6){				
            	$score = 20;			            	
			}
			$scores['largestraight'] = $score;
		}				

		if ($choosedScore == 12){
			$score = 0;
			if ($dice1 && $dice2 && $dice3 && $dice4 && $dice5){				
            	$score = 15;			            	
			}
			$scores['smallstraight'] = $score;
		}		

		if ($choosedScore == 11){
			$score = 0;
			if ($sumpair[0] == 2 && $sumpair[1] == 1 || $sumpair[1] == 2 && $sumpair[0] == 1){				
				$score = 28;				
			}
			$scores['fullhouse'] = $score;
		}

		if ($choosedScore == 10){
			$score = 0;
			if ($sumpair[0] == 3 || $sumpair[1] == 3){
				$score = sumDices($dices);				
			}
			$scores['fourofakind'] = $score;
		}		

		if ($choosedScore == 9){
			$score = 0;
			if ($sumpair[0] >= 2 || $sumpair[1] >= 2){
				$score = sumDices($dices);				
			}
			$scores['threeofkind'] = $score;
		}		

		if ($choosedScore == 8){
			$score = 0;
			if ($sumpair[0] >= 1 && $sumpair[1] >= 1){
				$score = sumDices($dices);				
			}
			$scores['twopairs'] = $score;
		}

		if ($choosedScore == 7){
			$score = 0;
			if ($sumpair[0] >= 1 || $sumpair[1] >= 1){
				$score = sumDices($dices);			
			}
			$scores['onepairs'] = $score;
		}
	}

	$_SESSION['scores'] = $scores;
	$_SESSION['holdBtn'] = null;	
	$_SESSION['test'] = null;	
	$_SESSION['dices'] = null;	
	$_SESSION['rolls'] = null;			
	$gameStatus++;

	if ($gameStatus == 15){
		$gameStatus = 0;
	}

	$_SESSION['gameCounter'] = $gameStatus;

	$arr = array("pairs" => $sumpair, "selScore" => $choosedScore,"num rolls: " => $rolls,"score" => $score, "dices" => $dices, "straight" => $fD, "allscores" => $scores, "gameStatus" => $gameStatus);
	echo json_encode($arr, JSON_FORCE_OBJECT);

	function isStraight($myDices){
			$fD = array(false,false,false,false,false,false);
			$x = 0;

            for ($x = 0; $x < 5; $x++)
            {
                switch ($myDices[$x])
                {
                    case 1:
                        $fD[0] = true;
                        break;
                    case 2:
                        $fD[1] = true;
                        break;
                    case 3:
                        $fD[2] = true;
                        break;
                    case 4:
                        $fD[3] = true;
                        break;
                    case 5:
                        $fD[4] = true;
                        break;
                    case 6:
                        $fD[5] = true;
                        break;
                }
            }            

            return $fD;
	}

	function sumPairs($myDices){		 
        $rtnValues = array();        
        $memOne = 0;            
        $memTwo = 0;
        $oneCount = 0;
        $twoCount = 0;

        for ($x = 0; $x < 5; $x++)
        {                
            if ($oneCount == 0)
            {   
                $memOne = $myDices[$x];                    
                
                for ($y = 1; $y < 5; $y++)
                {
                    if ($x != $y)
                        if ($myDices[$y] == $memOne)
                            $oneCount++;
                }
            }
        }

        if ($oneCount > 0)
        {
            for ($x = 0; $x < 5; $x++)
            {
                if ($twoCount == 0)
                {   
                    $memTwo = $myDices[$x];

                    for ($y = 1; $y < 5; $y++)
                    {
                        if ($x != $y)
                            if ($myDices[$y] == $memTwo && $memTwo != $memOne)
                                $twoCount++;
                    }
                }
            }
        }

        $rtnValues[0] = $oneCount;
        $rtnValues[1] = $twoCount;

        return $rtnValues;
	}

	function sumDices($dice){
		$scores = 0;

		for ($x = 0; $x <= 4; $x++)
        {            
            $scores += $dice[$x];
        }    

        return $scores;
	}

	function sum16Score($choosedSc, $dice){        
        $scores = 0;
    
        for ($x = 0; $x <= 4; $x++)
        {
            if ($dice[$x] == $choosedSc)
                $scores += $choosedSc;
        } 

        return $scores;
    }

?>