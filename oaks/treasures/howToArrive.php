<!DOCTYPE html> 
<html> 
  <head> 
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
    <style type="text/css"> 
      html { height: 100% }
      body { height: 100%; margin: 0px; padding: 0px; }
      #map_canvas { width: 65%; height: 100%; float: left;}
    #directionsPanel { float:right;width:30%;height 100%; }
    </style> 
    <title>Calcula a rota a partir de dois pontos clicados no mapa</title> 
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript"> 
      var map; 
    var time = 0;
    var sp = new google.maps.LatLng(-23.546, -46.638);
    var directionDisplay;
    var directionsService = new google.maps.DirectionsService();
    var marker0;
    var marker1;

    function initialize()
      {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var myOptions = { 
      zoom: 15, 
          center: sp, 
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }; 
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions); 
    google.maps.event.addListener(map, "click", function(pt){ 
      createMarker(pt);
    });
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById("directionsPanel"));
      }
    function createMarker(pt){
    if( marker0 != null && marker1 != null ){
      nullMap();
    }
    eval(" infowindow"+time+" = new google.maps.InfoWindow({ content: pt.latLng.toString() });");
    eval(" marker"+time+" = new google.maps.Marker({ position: pt.latLng, map: map });");
        eval(" google.maps.event.addListener(marker"+time+", \"click\", function() { infowindow"+time+".open(map, marker"+time+"); });");
    time++;
    if( time == 2 ){
      start = marker0.getPosition();
      end = marker1.getPosition();
      route(start, end);
      time = 0;
    }
    
    }
    
    function route(start, end){
    var request = {
      origin:start, 
      destination:end,
      travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      nullMap();
      } else {
      alert(status);
      }
    });
    }
    
    function nullMap(){
    try { 
      marker0.setMap(null);
      marker0 = null;
      marker1.setMap(null);
      marker1 = null;
    } catch(e) {}
    }
    </script>
  </head> 
  <body onload="initialize()"> 
    <div id="map_canvas"></div> 
  <div id="directionsPanel"></div>
  </body> 
</html> 