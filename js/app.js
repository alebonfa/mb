$(document).ready(function(){

	if(navigator.userAgent.match(/Android/i)) {
	    window.scrollTo(0,1);
	}

	if(mbPage=="login") {
		if(Modernizr.localstorage) {
			mbDeviceID = localStorage.getItem('magicBanditID');
			if(mbDeviceID === undefined || mbDeviceID == null || mbDeviceID == "") {
				var myGuid = guid();
				localStorage.setItem('magicBanditID', myGuid);
				mbDeviceID = myGuid; 
			} else {
				$.ajax({
					type: "POST",
					dataType: "json",
					url: "php/seekDevice.php",
					data: {myGuid: mbDeviceID},
					cache: false,
			        success: function(msg){
			            if (msg['status'] == "success") {
			                loginSignupSuccess(msg['playerName'], msg['playerID']);
			            }
			        }
				})
			}
		}

		$(document).on('click','#btnLogin', function(){

		    if($("#frmLogin")[0].checkValidity()) {
			    $.ajax({
			        type: "POST",
			        url: "php/authentication.php",
			        data: $("#frmLogin").serialize()+"&mbDeviceID="+mbDeviceID,
			        dataType: 'json',
			        success: function(msg){
			            if (msg['status'] == "success") {
			                loginSignupSuccess(msg['playerName'], msg['playerID']);
			            } else {
			                loginSignupError(msg['message']);
			            }
			        }
			    });
			} else {
			    $("#sbmLogin").trigger("click");
			}
		});

	}

    function loginSignupError(msg) {
        alert(msg);
    }

    function loginSignupSuccess(playerName, playerID) {
        if(Modernizr.sessionstorage) {
			sessionStorage.setItem('mbPlayerName', playerName);
			sessionStorage.setItem('mbPlayerID', playerID);
	        window.location.href="closeAcorns.php";
		} else {
			alert('Seu Dispositivo não é compatível com este Jogo!');
	        window.location.href="index.php";
		}
    }

	if(mbPage !== "login") {
		if(sessionStorage.getItem('mbPlayerID') == null) {
		    window.location.href="index.php";
		}

		var playerName = sessionStorage.getItem('mbPlayerName');
		var playerID = sessionStorage.getItem('mbPlayerID');
		$("#btnPlayerName").html('');
		lblPN  = '<span class="ui-btn-inner">';
		lblPN += '<span class="ui-btn-class">';
		lblPN += playerName;
		lblPN += '</span>';
		lblPN += '</span>';
		$("#btnPlayerName").append(lblPN);
	}

	if(mbPage=="ranking") {
		var playerID = sessionStorage.getItem('mbPlayerID');
		players = [];
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "php/makeRanking.php",
	        cache: false,
            success: function(data) {
                players = [];
                _.each( data, function(item, ix, list) {
                    players.push([item.id, 
                    	item.name,
                    	parseInt(item.points)]);
                });
                players.sort(function(a,b){
                	if(a[2]==b[2]) return 0;
                	return a[2] > b[2] ? -1 : 1;
                });
                if(players.length>0) {
	                for(var i=0; i<players.length; i++) {
	                	var playerClass = "ui-li ui-li-static ui-btn-up-c";
	                	if(players[i][0] == playerID) {
	                		playerClass += " myPoints ";
	                	}
	                	var newLine = '';
	                	newLine += '<li id="' + players[i][0] + '" class="' + playerClass + '">';
		                	newLine += '<div class="ui-grid-a">';
			                	newLine += '<div class="ui-block-a">' + (i+1) + '. ' + players[i][1] + '</div>';
			                	newLine += '<div class="ui-block-b">' + players[i][2] + '</div>';
				    		newLine += '</div>';
			    		newLine += '</li>';
	                    $('#rankingList').append(newLine);
	                }
	            	$('html, body').animate({
		    			scrollTop: $('#'+playerID).offset().top-300
					}, 100);
                }
            }
        });
	}

	$("#admNewPlayers").on('click', function() {
		getNewPlayers("dia");

		$(document).on('click','#adm01Day', function(){
			getNewPlayers('dia');
		});
		$(document).on('click','#adm01Week', function(){
			getNewPlayers('semana');
		});
		$(document).on('click','#adm01Always', function(){
			getNewPlayers('sempre');
		});
	})

	/*
	if(mbPage=="adm01") {
		getNewPlayers("dia");

		$(document).on('click','#adm01Day', function(){
			getNewPlayers('dia');
		});
		$(document).on('click','#adm01Week', function(){
			getNewPlayers('semana');
		});
		$(document).on('click','#adm01Always', function(){
			getNewPlayers('sempre');
		});
	}
	*/

	function getNewPlayers(model) {
		players = [];
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "php/makeNewPlayers.php",
			data: {model: model},
	        cache: false,
            success: function(data) {
                players = [];
                _.each( data, function(item, ix, list) {
                    players.push([item.city, 
                    	parseInt(item.qty_players)]);
                });
                players.sort(function(a,b){
                	if(a[1]==b[1]) return 0;
                	return a[1] > b[1] ? -1 : 1;
                });
      			$('#admList').empty();
                if(players.length>0) {
	                for(var i=0; i<players.length; i++) {
	                	var playerClass = "ui-li ui-li-static ui-btn-up-c";
	                	var newLine = '';
	                	newLine += '<li id="' + players[i][0] + '" class="' + playerClass + '">';
		                	newLine += '<div class="ui-grid-a">';
			                	newLine += '<div class="ui-block-a">' + (i+1) + '. ' + players[i][0] + '</div>';
			                	newLine += '<div class="ui-block-b">' + players[i][1] + '</div>';
				    		newLine += '</div>';
			    		newLine += '</li>';
	                    $('#admList').append(newLine);
	                }
                }
            }
        });
	}

	if(mbPage=="adm02") {
		getNewColects("dia");

		$(document).on('click','#adm02Day', function(){
			getNewColects('dia');
		});
		$(document).on('click','#adm02Week', function(){
			getNewColects('semana');
		});
		$(document).on('click','#adm02Always', function(){
			getNewColects('sempre');
		});
	}

	function getNewColects(model) {
		players = [];
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "php/makeNewColects.php",
			data: {model: model},
	        cache: false,
            success: function(data) {
                players = [];
                _.each( data, function(item, ix, list) {
                    players.push([item.city.toUpperCase(), 
                    	parseInt(item.qty_players)]);
                });
                players.sort(function(a,b){
                	if(a[1]==b[1]) return 0;
                	return a[1] > b[1] ? -1 : 1;
                });
      			$('#admList').empty();
                if(players.length>0) {
	                for(var i=0; i<players.length; i++) {
	                	var playerClass = "ui-li ui-li-static ui-btn-up-c";
	                	var newLine = '';
	                	newLine += '<li id="' + players[i][0] + '" class="' + playerClass + '">';
		                	newLine += '<div class="ui-grid-a">';
			                	newLine += '<div class="ui-block-a">' + (i+1) + '. ' + players[i][0] + '</div>';
			                	newLine += '<div class="ui-block-b">' + players[i][1] + '</div>';
				    		newLine += '</div>';
			    		newLine += '</li>';
	                    $('#admList').append(newLine);
	                }
                }
            }
        });
	}

	if(mbPage=="adm03") {
		getColPlaces("dia");

		$(document).on('click','#adm03Day', function(){
			getColPlaces('dia');
		});
		$(document).on('click','#adm03Week', function(){
			getColPlaces('semana');
		});
		$(document).on('click','#adm03Always', function(){
			getColPlaces('sempre');
		});
	}

	function getColPlaces(model) {
		players = [];
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "php/makeColPlaces.php",
			data: {model: model},
	        cache: false,
            success: function(data) {
                players = [];
                _.each( data, function(item, ix, list) {
                    players.push([item.name.toUpperCase(), 
                    	parseInt(item.qty_players)]);
                });
                players.sort(function(a,b){
                	if(a[1]==b[1]) return 0;
                	return a[1] > b[1] ? -1 : 1;
                });
      			$('#admList').empty();
                if(players.length>0) {
	                for(var i=0; i<players.length; i++) {
	                	var playerClass = "ui-li ui-li-static ui-btn-up-c";
	                	var newLine = '';
	                	newLine += '<li id="' + players[i][0] + '" class="' + playerClass + '">';
		                	newLine += '<div class="ui-grid-a">';
			                	newLine += '<div class="ui-block-a">' + (i+1) + '. ' + players[i][0] + '</div>';
			                	newLine += '<div class="ui-block-b">' + players[i][1] + '</div>';
				    		newLine += '</div>';
			    		newLine += '</li>';
	                    $('#admList').append(newLine);
	                }
                }
            }
        });
	}

	if(mbPage=="colect") {
		var x = document.getElementById("placeList");
	    var places = new Array();
		var la, lo;
		getLocation();
	}

	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
		} else {
			alert("Choba!!! Seu browser é muito Loser!!!");
		}
	}
	
	function loadRoute() {


		var medievalStyle = [
		  {
		    "elementType": "geometry.stroke",
		    "stylers": [
		      { "invert_lightness": true },
		      { "color": "#a78080" },
		      { "weight": 0.1 },
		      { "visibility": "on" }
		    ]
		  },{
		    "elementType": "geometry.fill",
		    "stylers": [
		      { "visibility": "off" }
		    ]
		  }
		];

		var styledMap = new google.maps.StyledMapType(medievalStyle, {
			name: "Styled Map"
		});

		var placeID = $(this).attr('id');
		var mapSpace = 'map' + placeID;
		if($('#'+mapSpace).attr('class') == 'mapsRoute') {
			$('#'+mapSpace).removeClass('mapsRoute');	
		} else {
			$('#'+mapSpace).addClass('mapsRoute');
			var laF = la;
			var loF = lo;
	        for(var i=0; i<places.length; i++) {
	        	if(places[i][0] === placeID) {
	        		laT = places[i][2];
	        		loT = places[i][3];
	        	}
	        }

	      	var map; 
	      	var sp2 = new google.maps.LatLng(laF, loF);
	      	var sp3 = new google.maps.LatLng(laT, loT);
	      	var directionDisplay;
	      	var directionsService = new google.maps.DirectionsService();

	    	directionsDisplay = new google.maps.DirectionsRenderer();
	    	var myOptions = { 
	      		zoom: 15, 
	      		center: sp2, 
	      		mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
	    	}; 

	    	map = new google.maps.Map(document.getElementById(mapSpace), myOptions); 
	    	map.mapTypes.set('map_style', styledMap);
	    	map.setMapTypeId('map_style');
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
	    	$('html, body').animate({
			    scrollTop: $('#'+placeID).offset().top-45
			}, 100);
		}

	}

	function showPrizes() {
		var placeID = $(this).attr('id');
		var mapSpace = 'map' + placeID;
		if($('#'+mapSpace).attr('class') == 'mapsRoute') {
			$('#'+mapSpace).removeClass('mapsRoute');	
			$('#'+mapSpace).empty();
			this.removeEventListener("click", showPrizes, false) ;
        	this.addEventListener("mouseup", msgBlockTime, false) ;
		} else {
			$('#'+mapSpace).addClass('mapsRoute');
			$.ajax({
				type: "POST",
				dataType: "json",
				url: "php/getTreasures.php",
				data: {
					playerID: playerID, 
					placeID: placeID, 
					lat: la,
					lng: lo
				},
				cache: false,
				success: function(data) {
					var allTreaures = "";
					_.each( data, function(item, ix, list) {
						allTreasures = item.treasures;
					})

					var prizeList  = '<div>';
					prizeList += '<h2 class="prizeText">Tesouros Coletados</h2>';
					for (var i = 0; i < allTreasures.substr(0,1); i++) {
						prizeList += '<span class="prizeIcon"><img src="images/acorn01.png" width="50" height="50"></span>';
					}
					if(parseInt(allTreasures.substr(4,1))>0) {
						prizeList += '<span class="prizeIcon"><img src="images/acorn02.png" width="50" height="50"></span>';
					}
					if(parseInt(allTreasures.substr(9,1))>0) {
						prizeList += '<span class="prizeIcon"><img src="images/artefact01.png" width="50" height="50"></span>';
					}
					if(parseInt(allTreasures.substr(14,1))>0) {
						prizeList += '<span class="prizeIcon"><img src="images/artefact02.png" width="50" height="50"></span>';
					}
					if(parseInt(allTreasures.substr(19,1))>0) {
						prizeList += '<span class="prizeIcon"><img src="images/artefact03.png" width="50" height="50"></span>';
					}
					if(parseInt(allTreasures.substr(24,1))>0) {
						prizeList += '<span class="prizeIcon"><img src="images/artefact04.png" width="50" height="50"></span>';
					}
					prizeList += '</div>';
			        $('#'+mapSpace).append(prizeList);

					var nextColect = new Date();
					nextColect.setDate(nextColect.getDate()+1);
                	$('#count'+placeID).countdown({until: nextColect, compact:true, format: 'HMS'});
                	$('#'+placeID).addClass('blockTime');
                	$('#colectScreen').removeClass('getPrizes');

				}
			})
		}
    	// $(window).scrollTop($('#'+placeID).position().top);
    	$('html, body').animate({
		    scrollTop: $('#'+placeID).offset().top-45
		}, 100);
	}

	function showPosition(position) {
		la = position.coords.latitude;
		lo = position.coords.longitude;

		places = [];

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "php/closePlaces.php",
            data: {playerID: playerID, la: la, lo: lo},
	        cache: false,
            success: function(data) {
                places = [];
                _.each( data, function(item, ix, list) {
                    places.push([item.id, 
                    	item.name, 
                    	item.lat, 
                    	item.lng, 
                    	Math.round(distanceTwoPoints(la, lo, item.lat, item.lng),2),
                    	item.treasures,
                    	item.lastColect]);
                });
                places.sort(function(a,b){
                	if(a[4]==b[4]) return 0;
                	return a[4] < b[4] ? -1 : 1;
                });
                if(places.length>0) {
	                for(var i=0; i<places.length; i++) {
	                	var qtyTreasures = parseInt(places[i][5].substr(0,1));
	                	qtyTreasures += parseInt(places[i][5].substr(4,1));
	                	qtyTreasures += parseInt(places[i][5].substr(9,1));
	                	qtyTreasures += parseInt(places[i][5].substr(14,1));
	                	qtyTreasures += parseInt(places[i][5].substr(19,1));
	                	qtyTreasures += parseInt(places[i][5].substr(24,1));
	                	var placeClass = "ui-li ui-li-static ui-btn-up-c ui-li-has-thumb ui-first-child ui-last-child closePlaceList ";
	                	if(places[i][4]<=30) {
	                		placeClass += " getPrizes ";
	                	}
	                	var newLine = '';
	                	newLine += '<li id="' + places[i][0] + '" class="' + placeClass + '">';
			    		newLine += '<img src="images/bau'+ qtyTreasures +'.png"  class="ui-li-thumb">';
			    		newLine += '<h2 class="ui-li-heading">' + places[i][1] + '</h2>';
			    		newLine += '<em>' + places[i][4] + ' metros</em>';
	                	newLine += '<span id="count' + places[i][0] + '" class="unblockTime"></span>';
			    		newLine += '</li>';
			    		newLine += '<li><div id="map' + places[i][0] + '"></div></li>';
	                    $('#placeList').append(newLine);
	                    if(places[i][6] !== null) {
							var t = places[i][6].split(/[- :]/);
							var nextColect = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
							nextColect.setDate(nextColect.getDate()+1);
	                    	hoje = new Date();
	                    	if(hoje < nextColect) {
		                    	$('#count'+places[i][0]).countdown({until: nextColect, compact:true, format: 'HMS'});
		                    	$('#'+places[i][0]).addClass('blockTime');
		                    	$('#'+places[i][0]).removeClass('getPrizes');
	                    	}
	                    }
	                    if(i>=25){break;}
	                }
	                var allPlaces = document.getElementsByClassName('closePlaceList');
	                for(var i=0; i<allPlaces.length;i++) {
	                	if($(allPlaces[i]).hasClass('getPrizes')) {
		                	allPlaces[i].addEventListener("click", showPrizes, false) ;
	                	} else {
	                		if($(allPlaces[i]).hasClass('blockTime')) {
		                		allPlaces[i].addEventListener("click", msgBlockTime, false) ;
		                	} else {
		                		allPlaces[i].addEventListener("click", loadRoute, false) ;
		                	}
	                	}
	                }
                }
            }
        })
	}

	function msgBlockTime() {
		alert('Fora do Prazo!');
	}

	function distanceTwoPoints(LaF, LoF, LaT, LoT) {
        var earthRadius = 6372.795477598;
        var latFrom = LaF * Math.PI / 180;
        var lonFrom = LoF * Math.PI / 180;
        var latTo = LaT * Math.PI / 180;
        var lonTo = LoT * Math.PI / 180;
  
        var lonDelta = lonTo - lonFrom;
        var a = Math.pow(Math.cos(latTo) * Math.sin(lonDelta), 2) + Math.pow(Math.cos(latFrom) * Math.sin(latTo) - Math.sin(latFrom) * Math.cos(latTo) * Math.cos(lonDelta), 2);
        var b = Math.sin(latFrom) * Math.sin(latTo) + Math.cos(latFrom) * Math.cos(latTo) * Math.cos(lonDelta);
        var angle = Math.atan2(Math.sqrt(a), b);

        return angle *  earthRadius * 1000;
	}


	function s4() {
	  return Math.floor((1 + Math.random()) * 0x10000)
	             .toString(16)
	             .substring(1);
	};

	function guid() {
	  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
	         s4() + '-' + s4() + s4() + s4();
	}

})
