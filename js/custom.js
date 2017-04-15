var myAvatar;
var isSession2;
var emailInp = false;
var newUsrInp = false;
var map;
var sessionName;
var latGlobal;
var lngGlobal;
var markerMem;

function Initializer2(){

}

function Initializer() {   
    maunalGeoTag = true;
    google.maps.visualRefresh = true;
    geocoder = new google.maps.Geocoder();
    var ljungby = new google.maps.LatLng(61.229077352774, 14.842794200000);    
    var markerIcon = 0;
    var mapOptions = {
        zoom: 2,
        center: ljungby,
        mapTypeId: google.maps.MapTypeId.G_NORMAL_MAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);  
}

function yatzies(selector){ 
    Initializer();  
    //extractYatizes();   
}

function extractYatizes(){
    $.ajax({
        type: 'GET',
        url: '',
        contentType: 'application/json; charset=utf-8',                 
        success: function(response) {                                       
                //alert("funkar");
                var arr = JSON.parse(response.d);
                if (selector == "highscores"){
                    highscoreTable(arr);
                }

                if (selector == "markers"){
                    for (var x = 0; x < arr.length; x++){                   
                        newMarker(arr[x]);   
                    }
                }               
        },
        error: function(error) {              
            alert(error);           
        }
    });
}

function checkUserInp(type) {
    var addUp = 0;
    var addUp2 = 0;

    if ($('#user_inp').val() == ""){
        if (usrInp == false){
            $('#warnUser').append('<div id="warnUserMsg"><strong>Warning!</strong> You must enter a username.</div>');
            usrInp = true;  
        }       
    }
    else
        addUp++;

    if ($('#pwd_inp').val() == ""){
        if (pwdInp == false){
            pwdInp = true;
            $('#warnPwd').append('<div id="warnPwdMsg"><strong>Warning!</strong> You must enter a password.</div>');
        }       
    }
    else
        addUp++;

    if ($('#newUsrEmail').val() == ""){
        if (emailInp == false){
            $('#warnNoEmail').append('<div id="warnUserMsg"><strong>Warning!</strong> You must enter Email.</div>');
            emailInp = true;    
        }       
    }
    else
        addUp2++;

    if ($('#newUsr_inp').val() == ""){
        if (newUsrInp == false){
            $('#warnNoUsrInp').append('<div id="warnUserMsg"><strong>Warning!</strong> You must enter a username.</div>');
            newUsrInp = true;   
        }       
    }
    else
        addUp2++;    
    if (addUp == 2 && type == null)     
        sendUser();
    if (type === "register" && addUp2 == 2){
        registerUser();
    }   
}

function registerUser(){
    var myPwd = $('#newUsr_pwd').val();
    var myUser = $('#newUsr_inp').val();
    var myEmail = $('#newUsrEmail').val();
    var myUsr = 'user1='+ myUser + '&password1='+ myPwd + '&email1=' + myEmail;    

    $.ajax({
        type: 'POST',
        url: 'framework/account/new_user.php',        
        data: myUsr,        
        cache: false,        
        success: function(response) { 
            alert(response);
        },
        error: function(error) {
            alert("fel");
        }
    });
}

function clearErrorMessages(msgVar){
    $("#user_inp").focus();
    if (msgVar == "warnuser" || msgVar==null)
        $('#warnUser').empty();
    if (msgVar == "warnpwd" || msgVar==null)
        $('#warnPwd').empty();
    if (msgVar == "warnNoUser" || msgVar==null)
        $('#warnNoUsrInp').empty();
    if (msgVar == "warnNoEmail" || msgVar==null)
        $('#warnNoEmail').empty();
    if (msgVar == null){
        usrInp = false;
        pwdInp = false;
        cred = false;
    }
}

function logout(){   

    $.ajax({
        type: 'POST',
        url: 'framework/account/logout.php',        
        cache: false,        
        success: function(response) { 
            loginNavBar();        
        },
        error: function(error) {
            
        }
     });
}

function geotag(){

    codeAddress();
     
}

function convertMarker(){    
    var myCoords = 'status='+ 'none';
    $.ajax({
      type: 'POST',
      url: 'framework/account/profilecoords.php', 
      data: myCoords,                                   
      dataType: 'JSON',                   
      cache: false,   
      success: function(response) {                
        var newPos = new google.maps.LatLng(response.lat, response.lng);                                
        placeMarker(newPos);
      },
      error: function(error) {
          alert("fel");
      }
    });           
}

function placeMarker(myLngLat){
     if (markerMem != null)
        markerMem.setMap(null);
    
    marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: myLngLat
    });
    map.setCenter(marker.getPosition());    
    map.setZoom(15);
    marker.addListener('click');
    markerMem = marker;
}

function codeAddress() {
    var address = $('#address_inp3').val();
    var zip = $('#zip_inp3').val();
    var city = $('#postaltown_inp3').val();
    
    geocoder.geocode({ 'address': address+","+city}, function (results, status) 
    {
        if (status == google.maps.GeocoderStatus.OK) {  
            var lng = results[0].geometry.location.lng();
            var lat = results[0].geometry.location.lat();
            var newPos = new google.maps.LatLng(lat, lng); 
            placeMarker(newPos);            

        } else {
            swal({   title: "Warning!",   text: "Geocoding failed for the following reason: "+status,   timer: 3000,   showConfirmButton: true });
        }
    });
}

function roundDecimal (myDec, roundLength) {    
    var tmpDec = myDec.toFixed();
    return (myDec = myDec.toFixed(roundLength - tmpDec.length));
}

function saveCords(){
    
    var myCoords = marker.getPosition();
    if (myCoords != ""){
        var lng = myCoords.lng();
        var lat = myCoords.lat();

        lat = roundDecimal(lat,14); 
        lng = roundDecimal(lng,14);

        var myCoords = 'lat1='+ lat + '&lng1='+ lng; 

        $.ajax({
            type: 'POST',
            url: 'framework/account/savecoords.php',
            data: myCoords,
            dataType: 'JSON',
            cache: false,        
            success: function(response) {                             
                if (response.status == "success"){
                    alert("Lyckades spara koordinater!");
                }
                else{
                    alert("error");
                }
            },
            error: function(error) {
                alert("fel");            
            }            
        });
        //alert(lat + " - "+ lng);
    }
    else{
        alert("Du har ej geotaggat!");
    }
}

function geotag2(){
        var infoWindow = new google.maps.InfoWindow({map: map});        
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }      
}



function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
}

function loginNavBar(){
    $("#profileBar").empty();    
    $("#profileBar").append('<li><img src="img/dices/six.svg" ImageAlign="Middle" class="profileAvatar" /></li>');

    $("#headerBar").empty(); 
    $("#headerBar").append('<li><a href="#" class="navbar-link" data-toggle="modal" onclick="clearErrorMessages()"  data-target="#loginModal" >Logga in</a></li>');
    $("#headerBar").append('<li><a href="#" class="navbar-link" data-toggle="modal" onclick="clearErrorMessages()"  data-target="#registerModal" >Registrera</a></li>');    
}

function userNavBar(){
    $("#profileBar").empty();    
    $("#profileBar").append('<li><img src="usr/img/'+ myAvatar +'" ImageAlign="Middle" class="profileAvatar" /></li>');

    $("#headerBar").empty();    
    $("#headerBar").append('<li><a href="/game.php" class="navbar-link" >Spela Yatzy</a></li> ');    
    $("#headerBar").append('<li><a href="/profile.php" class="navbar-link">'+sessionName+' </a></li> ');
    $("#headerBar").append('<li><a href="/index.php" class="navbar-link" onClick="logout()">Logga ut</a></li> ');       

    
    $("#playBtn").append('<a href="game.php" class="popup-link">Spela RetroYatzy</a> ');       

}


function sendUser(){    
    var myPwd = $('#pwd_inp').val();
    var myUser = $('#user_inp').val();
    var myUsr = 'user1='+ myUser + '&password1='+ myPwd;    

    $.ajax({
        type: 'POST',
        url: 'framework/account/login.php',
        data: myUsr,
        dataType: 'JSON',
        cache: false,        
        success: function(response) { 
            //console.log(response.user);   
            //console.log(response.profileImg);   
            if (response.user != "none"){                
                sessionName = response.user;
                myAvatar = response.profileImg;
                successfulLogin();
                userNavBar();
            }
            else{
                alert("Felaktig användare eller lösenord");
            }
        },
        error: function(error) {
            alert("fel");            
        }            
    });
}

function successfulLogin(){
    $('#pwd_inp').val('');
    $('#user_inp').val('');
    $('#loginModal').modal('hide');         
    $("#loginRegisterForm").empty();
    //location.reload();  
    //isSession();  
}

