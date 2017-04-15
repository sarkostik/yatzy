var resetButtonScores = false;
var isNewGame = false;
var isGame = true;
var scoresBtns = new Array(true,true,true,true,true,true,true,true,true,true,true,true,true,true,true);
var isNewRound = false;
var roundCounter = 0;
var holdMyDice1 = false;
var holdMyDice2 = false;
var holdMyDice3 = false;
var holdMyDice4 = false;
var holdMyDice5 = false;

function checkGameState(){            
        
        var shuffleData = 'status='+ "documentReady";         
         $.ajax({
              type: 'POST',
              url: 'framework/game/gamestate.php',        
              data: shuffleData,        
              cache: false,
              dataType: 'JSON',  
              success: function(response) {
                
                console.log(response);
                //roundCounter = response.counter;
                /*
                if (response.counter <= 3){
                    showDices(response);
                    if (response.counter == 3){
                        $("#rollDicesBtn").html('Ta poäng');
                        disableHolders(false);   
                        $("#btnScore").remove();
                    }            
                    if (response.counter == 1){
                        disableHolders(true);   
                        var r = $('<button ID="btnScore" class="btn btn-info" onclick="showScores()">Ta poäng</button>');
                        $("#rollBtns").append(r);  
                    }        
                }                                
                else{                    
                    resetHoldBtns();
                    showScores();                    
                    $("#rollDicesBtn").html('Kasta tärningar');                                      
                }*/
              },
              error: function(error) {
                  console.log(error);
              }
        });              
        //disableHolders();
    }

    function rollDices(){
         var shuffleData = 'holdDice1='+ holdMyDice1 + '&user='+ "none";         
         $.ajax({
              type: 'POST',
              url: 'framework/game/shuffle.php',        
              data: shuffleData,        
              cache: false,
              dataType: 'JSON',  
              success: function(response) {                
                console.log(response)
                roundCounter = response.counter;
                if (response.counter <= 3){
                    showDices(response);
                    if (response.counter == 3){
                        $("#rollDicesBtn").html('Ta poäng');
                        nextRound();
                    }            
                    if (response.counter == 1){
                        disableHolders(true);   
                        var r = $('<button ID="btnScore" class="btn btn-info" onclick="showScores()">Ta poäng</button>');
                        $("#rollBtns").append(r);  
                    }        
                }                                
                else{                    
                    resetHoldBtns();
                    showScores();                    
                    $("#rollDicesBtn").html('Kasta tärningar');                                      
                }
              },
              error: function(error) {
                  alert("fel");
              }
        });          
    }

    function nextRound(){        
        disableHolders(false);   
        $("#btnScore").remove();
    }

    function showDices(dices){             
        if (!holdMyDice1)
            document.getElementById("dice1").src = "/img/dices/" + dices.dice1;
        if (!holdMyDice2)
            document.getElementById("dice2").src = "/img/dices/" + dices.dice2;
        if (!holdMyDice3)
            document.getElementById("dice3").src = "/img/dices/" + dices.dice3;
        if (!holdMyDice4)
            document.getElementById("dice4").src = "/img/dices/" + dices.dice4;
        if (!holdMyDice5)
            document.getElementById("dice5").src = "/img/dices/" + dices.dice5;

        if (dices.dice1 = "death"){
            
        }        
    }

    function disableHolders(state){             
        
        if (state == null){            
            if (roundCounter > 0 && roundCounter < 3)
                state = true;
            else if (roundCounter == 0 || roundCounter == 3)
                state = false
        }

        btnSwith("#holdDice1", state); 
        btnSwith("#holdDice2", state);
        btnSwith("#holdDice3", state);
        btnSwith("#holdDice4", state);
        btnSwith("#holdDice5", state);
    }


    function holdButton(isHold, btn){        
        var btnText = "Lås upp";        
        var btnColor = "#000000";
        var btnBgColor = "#aaffaa";

        if (!isHold){
            btnText = "--Lås--";
            btnColor = "#fff";
            btnBgColor = "#5bc0de";
        }

        $(btn).html(btnText);
        $(btn).css('background-color', btnBgColor);
        $(btn).css('color', btnColor);
    }

    function resetHoldBtns(){
        holdMyDice1 = true;
        holdMyDice2 = true;
        holdMyDice3 = true;
        holdMyDice4 = true;
        holdMyDice5 = true;
        var x;
        for (x = 0; x <= 5; x++){
            holdBtn(x);
        }
    }

    function setHoldBackend(btn){
         var shuffleData = 'holdDice='+ btn;         
         $.ajax({
              type: 'POST',
              url: 'framework/game/holddice.php',        
              data: shuffleData,        
              cache: false,
              dataType: 'JSON',  
              success: function(response) {                
                console.log(response)                
              },
              error: function(error) {
                  console.log(error);
              }
        });          
    }

    function holdBtn(btn){
        switch(btn){
            case 1:
                if (!holdMyDice1){                    
                    setHoldBackend(btn);
                    holdMyDice1 = true;                                        
                    holdButton(true, "#holdDice1"); 
                }                    
                else{                    
                    setHoldBackend(-btn);
                    holdMyDice1 = false;                    
                    holdButton(false, "#holdDice1"); 
                }                    
                break;

            case 2:
                if (!holdMyDice2){
                    setHoldBackend(btn);
                    holdMyDice2 = true;
                    holdButton(true, "#holdDice2");                    
                }
                else{
                    setHoldBackend(-btn);
                    holdMyDice2 = false;
                    holdButton(false, "#holdDice2");                    
                }
                break;

            case 3:            
                if (!holdMyDice3){
                    setHoldBackend(btn);
                    holdMyDice3 = true;
                    holdButton(true, "#holdDice3");                    
                }
                else{
                    setHoldBackend(-btn);
                    holdMyDice3 = false;
                    holdButton(false, "#holdDice3");                    
                }
                break;

            case 4:            
                if (!holdMyDice4){
                    setHoldBackend(btn);
                    holdMyDice4 = true;
                    holdButton(true, "#holdDice4");                                        
                }
                else{
                    setHoldBackend(-btn);
                    holdMyDice4 = false;
                    holdButton(false, "#holdDice4");                                        
                }
                break;

            case 5: 
                if (!holdMyDice5){
                    setHoldBackend(btn);
                    holdMyDice5 = true;
                    holdButton(true, "#holdDice5");                                                            
                }
                else{
                    setHoldBackend(-btn);
                    holdMyDice5 = false;
                    holdButton(false, "#holdDice5");                                                            
                }
                break;
        }
    }

    function showScores(){        
        $("#scoresModal").modal()
        isNewRound = false;
        scoresAvail(false);
    }

    function scoresAvail(state){
        var scoreBtns = new Array(false,false,false,false,false,false,false,false,false,false,false,false,false,false,false);            
        var x = 0;

        if (state == false){
            for (x = 0; x < 16; x++)
                scoreBtns[x] = scoresBtns[x];
        }

        btnSwith("#take1", scoreBtns[0]); 
        btnSwith("#take2", scoreBtns[1]); 
        btnSwith("#take3", scoreBtns[2]); 
        btnSwith("#take4", scoreBtns[3]); 
        btnSwith("#take5", scoreBtns[4]); 
        btnSwith("#take6", scoreBtns[5]); 
        btnSwith("#onepair", scoreBtns[6]); 
        btnSwith("#twopair", scoreBtns[7]); 
        btnSwith("#threeofakind", scoreBtns[8]); 
        btnSwith("#fourofakind", scoreBtns[9]); 
        btnSwith("#fullhouse", scoreBtns[10]); 
        btnSwith("#smallstraight", scoreBtns[11]); 
        btnSwith("#largestraight", scoreBtns[12]); 
        btnSwith("#yahtzee", scoreBtns[13]); 
        btnSwith("#chance", scoreBtns[14]);         
    }

    function postScore(btn){
        var scoreData = 'choosedScore='+ btn;         
        $.ajax({
              type: 'POST',
              url: 'framework/game/postscore.php',        
              data: scoreData,        
              cache: false,
              dataType: 'JSON',  
              success: function(response) {
                setScore(response.score, response.selScore);                
                console.log(response)
                resetHoldBtns();                

                if (response.gameStatus == 15)
                    finishGame();

              },
              error: function(error) {
                  alert("fel");
              }
        });          
    }

    function finishGame(){
        var scoreData = 'score='+ "myscore";         
        $.ajax({
              type: 'POST',
              url: 'framework/game/scores.php',        
              data: scoreData,        
              cache: false,
              dataType: 'JSON',  
              success: function(response) {
                visibleScore("#upperTotal", response.uppper_section);
                visibleScore("#bonusPoints", response.bonus);
                visibleScore("#sumUpperBonus", response.bonus + response.uppper_section);

                visibleScore("#sumHiScores", response.bonus + response.uppper_section);
                visibleScore("#sumLowScores", response.lower_section);                
                visibleScore("#grandTotal", response.lower_section + (response.bonus + response.uppper_section));

                isNewGame = true;

              },
              error: function(error) {
                  console.log(error);
              }
        });          

        
    }

    function setScore(score, selscore){

        switch(selscore){
            case "1":
                visibleScore("#lbl1", score)
                break;

            case "2":
                visibleScore("#lbl2", score)
                break;

            case "3":
                visibleScore("#lbl3", score)
                break;

            case "4":
                visibleScore("#lbl4", score)
                break;

            case "5":
                visibleScore("#lbl5", score)
                break;

            case "6":
                visibleScore("#lbl6", score)
                break;

            case "7":                
                visibleScore("#lbl7", score)
                break;

            case "8":                
                visibleScore("#lbl8", score)
                break;

            case "9":                
                visibleScore("#lbl9", score)
                break;

            case "10":                
                visibleScore("#lbl10", score)
                break;

            case "11":                
                visibleScore("#lbl11", score)
                break;

            case "12":
                visibleScore("#lbl12", score)
                break;

            case "13":
                visibleScore("#lbl13", score)
                break;

            case "14":
                visibleScore("#lbl14", score)
                break;

            case "15":
                visibleScore("#lbl15", score)
                break;                

        }
    }

    function visibleScore(scoreLabel, score){
        $(scoreLabel).html(score);       
    }

    function score_Click(btn){                
        postScore(btn);

        switch(btn){
            case 1:
                scoresBtns[0] = resetButtonScores;
                btnSwith("#take1", resetButtonScores);
                break;
            case 2:
                scoresBtns[1] = resetButtonScores;
                btnSwith("#take2", resetButtonScores);
                break;
            case 3:
                scoresBtns[2] = resetButtonScores;
                btnSwith("#take3", resetButtonScores);
                break;
            case 4:
                scoresBtns[3] = resetButtonScores;
                btnSwith("#take4", resetButtonScores);
                break;
            case 5:
                scoresBtns[4] = resetButtonScores;
                btnSwith("#take5", resetButtonScores);
                break;
            case 6:
                scoresBtns[5] = resetButtonScores;
                btnSwith("#take6", resetButtonScores);
                break;
            case 7:
                scoresBtns[6] = resetButtonScores;
                btnSwith("#onepair", resetButtonScores);
                break;
            case 8:
                scoresBtns[7] = resetButtonScores;
                btnSwith("#twopair", resetButtonScores);
                break;
            case 9:
                scoresBtns[8] = resetButtonScores;
                btnSwith("#threeofakind", resetButtonScores);
                break;
            case 10:
                scoresBtns[9] = resetButtonScores;
                btnSwith("#fourofakind", resetButtonScores);
                break;
            case 11:
                scoresBtns[10] = resetButtonScores;
                btnSwith("#fullhouse", resetButtonScores);
                break;
            case 12:
                scoresBtns[11] = resetButtonScores;
                btnSwith("#smallstraight", resetButtonScores);
                break;                
            case 13:
                scoresBtns[12] = resetButtonScores;
                btnSwith("#largestraight", resetButtonScores);
                break;
            case 14:
                scoresBtns[13] = resetButtonScores;
                btnSwith("#yahtzee", resetButtonScores);
                break;
            case 15:
                scoresBtns[14] = resetButtonScores;
                btnSwith("#chance", resetButtonScores);
                break;
        }
        isNewRound = true;
        scoresAvail(true);
        cleanDices();
        $("#btnScore").remove();

    }

    function cleanDices(){
        var dices = {dice1:"death.svg", dice2:"death.svg", dice3:"death.svg", dice4:"death.svg", dice5:"death.svg"};            
        showDices(dices);
    }

    function btnSwith(btn, isDisabled){
        if (isDisabled){
            $(btn).attr('disabled',false).removeClass('ui-state-disabled');    
        }
        else
        {
            $(btn).attr('disabled',true).addClass('ui-state-disabled');
        }        
    }

    function resetRound(){
        if (isNewRound || roundCounter < 3){
            $('#scoresModal').modal('hide');
        }
        else{

        }

        if (isNewGame){

            $("#rollDicesBtn").html('Spela igen');                 

            visibleScore("#upperTotal", "");
            visibleScore("#bonusPoints", "");
            visibleScore("#sumUpperBonus", "");

            visibleScore("#sumHiScores", "");
            visibleScore("#sumLowScores", "");                
            visibleScore("#grandTotal", "");


            visibleScore("#lbl1", "");            
            visibleScore("#lbl2", "");            
            visibleScore("#lbl3", "");
            visibleScore("#lbl4", "");
            visibleScore("#lbl5", "");
            visibleScore("#lbl6", "");
            visibleScore("#lbl7", "");
            visibleScore("#lbl8", "");
            visibleScore("#lbl9", "");
            visibleScore("#lbl10", "");
            visibleScore("#lbl11", "");
            visibleScore("#lbl12", "");
            visibleScore("#lbl13", "");
            visibleScore("#lbl14", "");
            visibleScore("#lbl15", "");            

            resetButtonScores = true;

            for (var x = 1; x <= 14; x++){
                score_Click(x);    
            }
            resetButtonScores = false;            
        }
    }


    /*
    $.fn.dialogButtons = function(name, state){
        var buttons = $(this).next('div').find('button');
        if(!name)return buttons;
            return buttons.each(function(){
            var text = $(this).text();
            if(text==name && state=='disabled') {$(this).attr('disabled',true).addClass('ui-state-disabled');return this;}
            if(text==name && state=='enabled') {$(this).attr('disabled',false).removeClass('ui-state-disabled');return this;}
            if(text==name){return this;}
            if(name=='disabled'){$(this).attr('disabled',true).addClass('ui-state-disabled');return buttons;}
            if(name=='enabled'){$(this).attr('disabled',false).removeClass('ui-state-disabled');return buttons;}
    });};*/
