<?php include 'framework/master.php'; ?>

<script type="text/javascript">

  $(document).ready(function () {            
        yatzies("markers");
        getYatzies();                    

  });
  
  var isYatzies = true;

  function getYatzies(){
    var myData = 'blawa='+ "none";         
     $.ajax({
          type: 'POST',
          url: 'framework/game/yatzies.php',        
          data: myData,        
          cache: false,
          dataType: 'JSON',  
          success: function(response) {                
            console.log(response);                        
            for (var x = 0; x < 5; x++){           
              console.log(response[x]);
              newMarker(response[x]);   
            }
          },
          error: function(error) {
              console.log(error); 
          }
    });       
  }

  function newMarker(myobj){    
    console.log(myobj);
    var newPos = new google.maps.LatLng(myobj.lat, myobj.lng);    
    var circleIcon = {
          path: google.maps.SymbolPath.CIRCLE,
          strokeOpacity: 2,        
          fillColor: 'blue',
          fillOpacity: 0.6,
          scale: 3,
          strokeColor: 'blue',
          strokeWeight: 14
      };

    var marker = new google.maps.Marker({
          map: map,
          title: myobj.nickname,
          position: newPos,
          icon: circleIcon,        
          draggable: false
      });

    var contData = 
    "<h2>Spelare: " + myobj.nickname +
    "<br /><img src='/usr/img/"+ myobj.profileimg +"' id='myProfilePic'>" +
    "</h2><br />Utmana "+ myobj.nickname +" på en runda Yatzy " + 
    "<br /><button typ='button' class='btn btn-info btn-sm'>Utmana</button>"+    
    "&nbsp;<button typ='button' class='btn btn-info btn-sm'>Profilsida</button>"+
    "<br /> Bästa runda: <b>"+ myobj.score + 
    "</b> poäng.<br /> Datum: " +
    "<br /><br />";

    marker.infowindow = new google.maps.InfoWindow({        
        content: contData 
    });

    google.maps.event.addListener(marker, 'click', function () {
    marker.infowindow.open(map, marker);  
    map.setZoom(10);
    map.setCenter(marker.getPosition());              
   });
  }
</script>


 <div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">                  
      <h4 class="modal-title">Yatzies</h4>                                    
    </div>
    <div class="modal-body">                                        
        <div class="jumbotron" id="map_canvas" style="height:580px;">
            <div class="container text-center">
                <div id="map"></div>                              
            </div>
        </div>
    </div>                
    <div class="modal-footer"></div>
  </div>
</div>                
</body>
</html>