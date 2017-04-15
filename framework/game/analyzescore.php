<?php

    function getCounter() {            
        
        $rtnValues = array();

        $myDices = $_SESSION['test'];
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


    function setter(){
        return 1;
    }

    function getNum($choosedScore){        

        $dices = $_SESSION['test'];
        $score = 0;
    
        for ($x = 0; $x <= 4; $x++)
        {
            if ($dices[$x] == $choosedScore)
                $score += $choosedScore;
        }    

        return $this->$score;
    }
?>