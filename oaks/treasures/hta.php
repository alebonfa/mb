<?php
  if(isset($_REQUEST['laF'])) {
    $laF = $_REQUEST['laF'];
    $loF = $_REQUEST['loF'];
    $laT = $_REQUEST['laT'];
    $loT = $_REQUEST['loT'];
  }
?>
<!DOCTYPE html> 
<html> 
  <head> 
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
    <style type="text/css"> 
      html { height: 100% }
      body { height: 100%; margin: 0px; padding: 0px; }
      #map_canvas { width: 100%; height: 100%; float: left;}
    </style> 
    <title>Magic Bandit - Rotas</title> 
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript"> 

      var laF = <?php echo $laF; ?> ;
      var loF = <?php echo $loF; ?> ;
      var laT = <?php echo $laT; ?> ;
      var loT = <?php echo $loT; ?> ;
      var map; 
      var sp2 = new google.maps.LatLng(laF, loF);
      var sp3 = new google.maps.LatLng(laT, loT);
      var directionDisplay;
      var directionsService = new google.maps.DirectionsService();

      function initialize() {
        directionsDisplay = new google.maps.DirectionsRenderer();
        var myOptions = { 
          zoom: 15, 
          center: sp2, 
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }; 
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 
        directionsDisplay.setMap(map);

        var request = {
          origin: sp2, 
          destination: sp3,
          travelMode: google.maps.DirectionsTravelMode.DRIVING
        };

        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          } else {
            alert(status);
          }
        });

      }

    </script>
  </head> 
  <body onload="initialize()"> 
    <div id="map_canvas"></div> 
  </body> 
</html> 