<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	    <meta charset="utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1" />
	    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>    
	    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDD-BBJF-1h79yVXl-VhBw01zB9B6Iwbh8" type="text/javascript"></script>
	    <script src="js/custom.js"></script>
      <script>
        var usrInp = false;
        var pwdInp = false;
        var cred = false;
        var sessionName = "";
        var firstPage = false;

        $(document).ready(function () {            
            
            $('#txtUploadFile').on('change', function (e) {
              uploader(e);
            });

            $("#newUsr_pwd").change(function () {
              controlPassword("register");
            });

            $("#newUsr_pwd2").change(function () {              
              controlPassword("register_verify");
            });

            $("#newUsrEmail").change(function () {                            
              clearErrorMessages("warnNoEmail");
            });

            $("#newUsr_inp").change(function () {               
              clearErrorMessages("warnNoUser");
            });
                        
            $("#user_inp").change(function () {
                clearErrorMessages("warnuser");
                usrInp = false;
                if (cred == true) {
                    cred = false;
                    clearErrorMessages("warnpwd");
                }
            });

            $("#pwd_inp").change(function () {
                clearErrorMessages("warnpwd");
                pwdInp = false;
                cred = false;
            });            
        });
        
     </script>

      <link rel="stylesheet" type="text/css" href="css/custom.css" />
      
	    <style>
	        #map_canvas img {
	            max-width:NONE;
	        }

	        #map_canvas2 img {
	            max-width:NONE;
	        }

	        .jumbotron{
	            height:100%;
	            width:100%;
	        }

	        .container{
	          
	        }

	        .jumbotron .container {
	            max-width: 100%;
	        }

	    </style>
	            
	    <style>
	        .infoDiv {
	            height: 250px;
	            width: 840px;
	            -webkit-user-select: none;
	            background-color: white;
	        }
	    </style>
	    <title>RetroYatzy</title>
    </head>
    <body>
    <form id="form1">
        <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                            
                            <span class="icon-bar"></span>                            
                        </button>
                        <a class="navbar-brand" runat="server" href="./">RetroYatzy</a>
                    </div>   
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav"">                                                             
                            <li><a href="yatzies.php" class="navbar-link" >Yatzies</a></li>
                            <li><a href="highscore.php" class="navbar-link">Highscore</a></li>
                            <li><a href="rules.php" class="navbar-link">Spelregler</a></li>
                        </ul>                  
                        <ul class="nav navbar-nav navbar-right" id="profileBar">                                 
                            <?php 
                              session_start();
                              if ($_SESSION['login_user'] != null){
                                $profileImg = $_SESSION['profile_img'];
                                if ($profileImg != ""){
                                  echo '<li><img src="usr/img/'.$profileImg.'" ImageAlign="Middle" class="profileAvatar" /></li>';
                                }                                
                              }
                              else 
                                echo '<li><img src="img/yatzyfun.jpg" ImageAlign="Middle" class="profileAvatar" /></li>';
                            ?>                            
                        </ul>                  

                        <ul class="nav navbar-nav navbar-right"  id="headerBar">    
                            <?php
                              session_start();
                              if ($_SESSION['login_user'] != null){                          
                                $usrSession = $_SESSION['login_user'];
                                echo '<li><a href="/game.php" class="navbar-link" >Spela Yatzy</a></li>';    
                                echo '<li><a href="/profile.php" class="navbar-link">'. $usrSession . '</a></li> ';
                                echo '<li><a href="/index.php" class="navbar-link" onClick="logout()">Logga ut</a></li> ';

                              }
                              else{
                                echo '<li><a href="#" class="navbar-link" data-toggle="modal" onclick="clearErrorMessages()"  data-target="#loginModal" >Logga in</a></li>';
                                echo '<li><a href="#" class="navbar-link" data-toggle="modal" onclick="clearErrorMessages()"  data-target="#registerModal" >Registrera</a></li>';
                              }
                            ?> 
                        </ul>                        
                    </div>                    
                </div>                    
            </nav>             
              <!-- Login modal -->
          <div class="modal fade" data-backdrop="static" data-keyboard="false" id="loginModal" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Logga in</h4>
                </div>
                <div class="modal-body">                                        
                  <label class="control-label col-sm-2" for="email">Användarnamn:</label>                          
                    <input type="text" id="user_inp" text="" class="form-control" placeholder="Enter username" tooltip="Enter email" />                   
                    <div id="warnUser" class="lert alert-danger alert-dismissible" role="alert"></div>                    
                  <label class="control-label col-sm-2" for="pwd">Lösenord:</label>
                    <input type="password" placeholder="Enter password" id="pwd_inp" class="form-control" tooltip="Enter password"/>                    
                    <div id="warnPwd" class="lert alert-danger alert-dismissible" role="alert"></div> 
                                       
                  <button type="button" class="btn btn-default" onclick="checkUserInp()">Logga in</button>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Stäng</button>
                </div>
              </div>
            </div>
          </div>       

        <div class="container">   
          <!-- User registration modal-->
          <div class="modal fade" data-backdrop="static" data-keyboard="false" id="registerModal" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Registrering</h4>
                </div>
                <div class="modal-body">                                        
                  <label class="control-label col-sm-2" for="newUsrEmail">Email:</label>                          
                  <div id="alertEmail" class="lert alert-danger alert-dismissible" role="alert">You need contact admin to register email</div>
                    <input type="email" class="form-control" id="newUsrEmail" placeholder="Email" />
                    <div id="warnNoEmail" class="lert alert-danger alert-dismissible" role="alert"></div>                    
                  <label class="control-label col-sm-2" for="newUsr_inp">Användarnamn:</label>                          
                    <input type="email" class="form-control" id="newUsr_inp" placeholder="Användarnamn" />
                    <div id="warnNoUsrInp" class="lert alert-danger alert-dismissible" role="alert"></div>                    
                  <label class="control-label col-sm-2" for="newUsr_pwd">Lösenord:</label>
                    <input type="password" class="form-control" id="newUsr_pwd" placeholder="Lösenord" />
                    <div id="secondPassword">                      
                    </div>
                  <button class="btn btn-default" type="button" onclick="checkUserInp('register')">Registrera</button>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>
            
        <div class="container">   
          <!-- Google maps modal-->
          <!--<div class="modal fade" class="modal hide" data-backdrop="static" data-keyboard="false" id="userEditor" role="dialog"-->          
          <div class="modal fade" data-backdrop="static" data-keyboard="false" id="userEditor" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Redigera din användarprofil</h4>
                  <asp:Image runat="server" ID="profilePic2" ImageUrl="/img/dices/six.svg" ImageAlign="Middle" CssClass="profileAvatar" />
                  <asp:FileUpload ID="FileUpload1" runat="server" CssClass="btn btn-default" Visible="true" />                  
                    <asp:Button CssClass="btn btn-default" ID="uploadBtn" runat="server" Text="Byt bild" OnClick="uploadBtn_Click" Visible="true"/>
                </div>
                <div class="modal-body">
                  <label class="control-label col-sm-2" for="email">Användarnamn:</label>                          
                    <input type="email" class="form-control" id="email2" placeholder="Användarnamn" />
                  <label class="control-label col-sm-2" for="surname_inp">Förnamn:</label>                          
                    <input type="email" class="form-control" id="surname_inp" placeholder="Förnamn" />
                  <label class="control-label col-sm-2" for="lastname_inp">Efternamn:</label>                          
                    <input type="email" class="form-control" id="lastname_inp" placeholder="Efternamn" />
                  <label class="control-label col-sm-2" for="address_inp">Address:</label>                          
                    <input type="email" class="form-control" id="address_inp" placeholder="Address" />
                  <label class="control-label col-sm-2" for="zip_inp">Postnummer:</label>                          
                    <input type="email" class="form-control" id="zip_inp" placeholder="Postnummer" />
                  <label class="control-label col-sm-2" for="postalTown_inp">Postaddress:</label>                          
                    <input type="email" class="form-control" id="postalTown_inp" placeholder="Postaddress" />
                  <label class="control-label col-sm-2" for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd2" placeholder="Ditt lösenord" />
                  <button type="submit" class="btn btn-default" data-dismiss="modal">Redigera</button>
                </div>                
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
        </div>              
    </form>