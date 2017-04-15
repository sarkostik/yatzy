<?php include 'framework/master.php'; ?>

<script src="js/game.js"></script>
<script type="text/javascript">
    var isGame = true;

    $(document).ready(function () {            
       checkGameState();
    });
  
</script>
 

<label id="userSessionPanel"  class="lert alert-danger alert-dismissible" role="alert"  Font-Bold="true" Font-Size="Large" >Inloggad</label>
<label id="debugger"  class="lert alert-danger alert-dismissible" role="alert" Font-Bold="true" Font-Size="Large" ></label>
<label id="information"  class="lert alert-danger alert-dismissible" role="alert" Font-Bold="true" Font-Size="Large" ></label>
<label id="webCounter"  class="lert alert-danger alert-dismissible" role="alert" Font-Bold="true" Font-Size="Large" ></label>

<div id="loginDetails" class="lert alert-danger alert-dismissible" role="alert"></div>   
<div id="loginRegisterForm" style="float: right;"></div>        
<div id="rollBtns">
    <button ID="rollDicesBtn" class="btn btn-info" onclick="rollDices()">Kasta tärningar</button>            
</div>
<div>            
    <table class="span5 center-table">
        <thead>
            <tr>
                <th class="text-center"><button ID="holdDice1" type="button" disabled class="btn btn-info btn-sm" onclick="holdBtn(1)"> --Lås-- </button></th>
                <th class="text-center"><button ID="holdDice2" type="button" disabled class="btn btn-info btn-sm" onclick="holdBtn(2)"> --Lås-- </button></th>
                <th class="text-center"><button ID="holdDice3" type="button" disabled class="btn btn-info btn-sm" onclick="holdBtn(3)"> --Lås-- </button></th>
                <th class="text-center"><button ID="holdDice4" type="button" disabled class="btn btn-info btn-sm" onclick="holdBtn(4)"> --Lås-- </button></th>
                <th class="text-center"><button ID="holdDice5" type="button" disabled class="btn btn-info btn-sm" onclick="holdBtn(5)"> --Lås-- </button></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><img ID="dice1" src="/img/dices/death.svg" class="dices"/></td>
                <td><img ID="dice2" src="/img/dices/death.svg" class="dices"/></td>
                <td><img ID="dice3" src="/img/dices/death.svg" class="dices"/></td>
                <td><img ID="dice4" src="/img/dices/death.svg" class="dices"/></td>
                <td><img ID="dice5" src="/img/dices/death.svg" class="dices"/></td>                            
            </tr>
      </tbody>                      
    </table>
</div>    

<div class="modal fade right-table" data-backdrop="static" data-keyboard="false" id="scoresModal" role="dialog">    
    <div class="modal-content">
        <div class="modal-header">    
            <button type="button" class="close" onclick="resetRound()" >&times;</button>             
            <h4 class="modal-title">Poäng</h4>                    
        </div>
        <div class="modal-body">                 
            <table class="span5">
                <thead>
                        <tr>
                        <th></th>                            
                        <th>Övre sektion</th>
                        <th></th>
                        <th>Poäng</th>                            
                    </tr>
                </thead>
                <tbody id="score-card">
                    <tr>
                        <td><button id="take1" class="btn btn-xs" disabled onclick="score_Click(1)" >Ta</button></td>
                        <td>Ettor</td>
                        <td>Summan av alla ettor</td>                            
                        <td><label ID="lbl1"></label></t>                            
                    </tr>
                    <tr>
                        <td><button id="take2" class="btn btn-xs" disabled onclick="score_Click(2)" >Ta</button></td>                                                        
                        <td>Tvåor</td>
                        <td>Summan av alla tvåor</td>                            
                        <td><label ID="lbl2"></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="take3" class="btn btn-xs" disabled onclick="score_Click(3)" >Ta</button></td>                            
                        <td>Treor</td>
                        <td>Summan av alla treor</td>                            
                        <td><label ID="lbl3"></label></t>                            
                    </tr>
                    <tr>
                        <td><button id="take4" class="btn btn-xs" disabled onclick="score_Click(4)" >Ta</button></td>
                        <td>Fyror</td>
                        <td>Summan av alla fyror</td>
                        <td><label ID="lbl4"></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="take5" class="btn btn-xs" disabled onclick="score_Click(5)" >Ta</button></td>
                        <td>Femmor</td>
                        <td>Summan av alla femmor</td>
                        <td><label ID="lbl5"></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="take6" class="btn btn-xs" disabled onclick="score_Click(6)" >Ta</button></td>                            
                        <td>Sexor</td>
                        <td>Summan av alla sexor</td>
                        <td><label ID="lbl6"></label></td>                            
                    </tr>
                    <tr>
                        <td></td>
                        <td>Total Poäng</td>                            
                        <td id="upper-section-score"></td>
                        <td class="ui-helper-center"><label ID="upperTotal"></label></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Bonus (63 poäng eller mer)</td>                            
                        <td id="upper-section-bonus"></td>
                        <td class="ui-helper-center"><label ID="bonusPoints"></label></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Summan av övre sektion</td>                            
                        <td class="upper-section-total"></td>
                        <td class="ui-helper-center"><label ID="sumUpperBonus"></label></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><strong>Lägre Sektion</strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><button id="onepair" class="btn btn-xs" disabled onclick="score_Click(7)" >Ta</button></td>                            
                        <td>Ett par</td>
                        <td>Summan av alla tärningar</td>
                        <td class="ui-helper-center"><label ID="lbl7"></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="twopair" class="btn btn-xs" disabled onclick="score_Click(8)" >Ta</button></td>
                        <td>Två par</td>
                        <td>Summan av alla tärningar</td>
                        <td class="ui-helper-center"><label ID="lbl8"></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="threeofakind" class="btn btn-xs" disabled onclick="score_Click(9)" >Ta</button></td>
                        <td>Triss</td>
                        <td>Summan av alla tärningar</td>
                        <td class="ui-helper-center"><label ID="lbl9"></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="fourofakind" class="btn btn-xs" disabled onclick="score_Click(10)" >Ta</button></td>                            
                        <td>Fyrtal</td>
                        <td>Summan av alla tärningar</td>                            
                        <td class="ui-helper-center"><label ID="lbl10" ></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="fullhouse" class="btn btn-xs" disabled onclick="score_Click(11)" >Ta</button></td>                            
                        <td>Kåk</td>
                        <td>28 poäng</td>
                        <td class="ui-helper-center"><label ID="lbl11" ></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="smallstraight" class="btn btn-xs" disabled onclick="score_Click(12)" >Ta</button></td>                            
                        <td>Liten stege</td>
                        <td>15 poäng</td>
                        <td class="ui-helper-center"><label ID="lbl12"></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="largestraight" class="btn btn-xs" disabled onclick="score_Click(13)" >Ta</button></td>                            
                        <td>Hög stege</td>
                        <td>20 poäng</td>
                        <td class="ui-helper-center"><label ID="lbl13"></label></td>                            
                    </tr>
                    <tr>
                        <td><button id="yahtzee" class="btn btn-xs" disabled onclick="score_Click(14)" >Ta</button></td>                            
                        <td>Yahtzee</td>
                        <td>50 poäng</td>
                        <td class="ui-helper-center"><label ID="lbl14"></label></t>                            
                    </tr>
                    <tr>
                        <td><button id="chance" class="btn btn-xs" disabled onclick="score_Click(15)" >Ta</button></td>                            
                        <td>Chans</td>
                        <td>Summan av alla tärningar</td>
                        <td class="ui-helper-center"><label ID="lbl15"></label></td>                        
                    </tr>
                    <tr>
                        <td></td>
                        <td><label>Lägre Sektion Totalt</label></td>                            
                        <td id="lower-section-total"></td>
                        <td class="ui-helper-center"><label ID="sumLowScores"><label></td>
                    </tr>
                    <tr>         
                        <td></td>                   
                        <td><label>Övre Sektion Totalt</label></td>                            
                        <td class="upper-section-total"></td>
                        <td class="ui-helper-center"><label ID="sumHiScores"></label></td>
                    </tr>
                    <tr>         
                        <td></td>                   
                        <td class="text-success h4"><label>Totalt</label></td>                            
                        <td id="grand-total"></td>
                        <td class="ui-helper-center"><label ID="grandTotal"></label></td>
                    </tr>
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>                
        <div class="modal-footer"></div>        
    </div>
</div>

</body>
</html>