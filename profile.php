<?php include 'framework/master.php'; ?>

<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">                  
      <h4 class="modal-title">Redigera din användarprofil</h4>                  
      
      <?php 
        session_start();        
        if ($_SESSION['login_user'] != null){
          $profileImg = $_SESSION['profile_img'];
          if ($profileImg != ""){

          }
        }
        echo '<img src="/usr/img/' .$profileImg. '" ImageAlign="Middle" class="profileAvatar" ID="profilePic2" />'
      ?>
      
      <script> 

        $(document).ready(function () {           
          yatzies("markers");          
          convertMarker();
        });

        function changeProfile(){
          var myPwd = $('#password_inp3').val();
          var myUser = $('#username_inp3').val();
          var myEmail = $('#email_inp3').val();
          var myAddress = $('#address_inp3').val();
          var myZip = $('#zip_inp3').val();
          var myZipAddress = $('#postaltown_inp3').val();
          var myLastname = $('#lastname_inp3').val();
          var mySurname = $('#surname_inp3').val();
          var myUsr = 'user1='+ myUser + '&password1='+ myPwd + '&email1=' + myEmail + '&address1=' + myAddress + '&zip1=' + myZip + '&zipAddress1=' + myZipAddress + '&surname1=' + mySurname + '&lastname1=' + myLastname;

          console.log(myUsr);

          if (myPwd !=""){
            $.ajax({
              type: 'POST',
              url: 'framework/account/editprofile.php',        
              data: myUsr,        
              cache: false,        
              success: function(response) {
                alert("Användarprofil redigerad!");
              },
              error: function(error) {
                  alert("fel");
              }
            });          
          }
          else
            alert("Du måste skriva in ett lösenord!");
        }
      </script>

      <script type="text/javascript">
 
      function fileSelected() {
 
        var count = document.getElementById('fileToUpload').files.length;
 
              document.getElementById('details').innerHTML = "";
 
              for (var index = 0; index < count; index ++)
 
              {
 
                     var file = document.getElementById('fileToUpload').files[index];
 
                     var fileSize = 0;
 
                     if (file.size > 1024 * 1024)
 
                            fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
 
                     else
 
                            fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
 
                     document.getElementById('details').innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;
 
                     document.getElementById('details').innerHTML += '<p>';
 
              }
 
      }
 
      function uploadFile() {
 
        var fd = new FormData();
 
              var count = document.getElementById('fileToUpload').files.length;
 
              for (var index = 0; index < count; index ++)
 
              {
 
                     var file = document.getElementById('fileToUpload').files[index];
 
                     fd.append('myFile', file);
 
              }
 
        var xhr = new XMLHttpRequest();
 
        xhr.upload.addEventListener("progress", uploadProgress, false);
 
        xhr.addEventListener("load", uploadComplete, false);
 
        xhr.addEventListener("error", uploadFailed, false);
 
        xhr.addEventListener("abort", uploadCanceled, false);
 
        xhr.open("POST", "framework/account/savetofile.php");
 
        xhr.send(fd);
 
      }
 
      function uploadProgress(evt) {
 
        if (evt.lengthComputable) {
 
          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
 
          document.getElementById('progress').innerHTML = percentComplete.toString() + '%';
 
        }
 
        else {
 
          document.getElementById('progress').innerHTML = 'unable to compute';
 
        }
 
      }
 
      function uploadComplete(evt) {
 
        /* This event is raised when the server send back a response */
 

        var xhr2 = new XMLHttpRequest();
 
        
        xhr2.upload.addEventListener("progress", uploadProgress, false);
 
        xhr2.addEventListener("load", uploadComplete, false);
 
        xhr2.addEventListener("error", uploadFailed, false);
 
        xhr2.addEventListener("abort", uploadCanceled, false);
        

        xhr2.open("POST", "framework/account/savetofi2le.php");
 
        xhr2.send();



        //location.reload();
        //alert(evt.target.responseText);
 
      }
 
      function uploadFailed(evt) {
 
        alert("There was an error attempting to upload the file.");
 
      }
 
      function uploadCanceled(evt) {
 
        alert("The upload has been canceled by the user or the browser dropped the connection.");
 
      }
 
    </script>




      <label id="warnMsg"></label>  
      <br />                  
      <asp:FileUpload ID="FileUpload1" runat="server" CssClass="btn btn-default" Visible="true" /> 

      <button class="btn btn-default" data-toggle="modal" onclick="clearErrorMessages()"  data-target="#changePictureModal">Byt bild</button>
      <button class="btn btn-default" id="geotagBtn" onclick="geotag()" Visible="false">Geotagging</button>       
      <button type="button" class="btn btn-default"  onclick="saveCords()">Spara koordinater</button>
                         
      <div id="map_canvas" style="height:250px;">
        <div class="container text-center">
          <div id="map"></div>                            
        </div>
      </div>        
      </div>      
      <div class="modal-body">
      <?php
        include 'framework/account/profile.php';

        echo '
          <label class="control-label col-sm-2" for="email">Email:</label>                          
            <input id="email_inp3" class="form-control" placeholder="Email" disabled value="'.$email.'" />
          <label class="control-label col-sm-2" for="email">Användarnamn:</label>                          
            <input id="username_inp3" class="form-control" placeholder="Användarnamn" disabled value="'.$username.'" />                    
          <label class="control-label col-sm-2" for="surname_inp">Förnamn:</label>                                              
            <input id="surname_inp3" class="form-control" placeholder="Förnamn" value="'.$surname.'" />
          <label class="control-label col-sm-2" for="lastname_inp">Efternamn:</label>                          
            <input id="lastname_inp3" class="form-control" placeholder="Efternamn" value="'.$lastname.'" />
          <label class="control-label col-sm-2" for="address_inp">Address:</label>                                              
            <input id="address_inp3" class="form-control" placeholder="Address" value="'.$address.'" />
          <label class="control-label col-sm-2" for="zip_inp">Postnummer:</label>                          
            <input id="zip_inp3" class="form-control" placeholder="Postnummer" value="'.$zip.'" />          
          <label class="control-label col-sm-2" for="postaltown_inp">Postaddress:</label>                                              
            <input id="postaltown_inp3" class="form-control" placeholder="Postaddress" value="'.$zipAddress.'" />
          <label class="control-label col-sm-2" for="pwd">Lösenord:</label>
            <input id="password_inp3" type="password" class="form-control" placeholder="Lösenord" />          
          <button class="btn btn-default" ID="changeProfile" onclick="changeProfile()">Redigera</button>';
      ?>

      </div>                
      <div class="modal-footer"></div>
    </div>
  </div>
  
  <div class="modal fade" data-backdrop="static" data-keyboard="false" id="changePictureModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Byt bild</h4>
        </div>
        <div class="modal-body">

          <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx"> 
            <div>
              <label for="fileToUpload">Ta en bild eller välj foton</label><br />
              <input type="file" class="btn btn-default" name="fileToUpload" id="fileToUpload" onchange="fileSelected();" accept="image/*" capture="camera" />
            </div>

            <div id="details"></div>

            <div>
              <input type="button" class="btn btn-default"  onclick="uploadFile()" value="Ladda upp" />
            </div>
            <div id="progress"></div>
        </form>          
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Stäng</button>
        </div>
      </div>
    </div>
  </div>

</body>
</html>