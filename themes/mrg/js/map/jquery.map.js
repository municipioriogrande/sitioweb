	var image_path = jQuery('#map').attr('path');
	var flags 	= new Array();
	var temp_arr = new Array();
		temp_arr.push('ICON Hotel Buenos Aires');
		temp_arr.push('-34.5988619117494');
		temp_arr.push('-58.3714878559113');
		temp_arr.push(1);
		temp_arr.push('ICON Hotel Buenos Aires');
		flags.push(temp_arr);
	beaches = flags;
	initialize(flags);
	
	var map;
	function initialize(beaches) {
		var increase 	= 0;
		var length 	= beaches.length;
		var menu_lista_header 	= '<a href="javascript:moveToDarwinOut(map,-38.341656,-63.28125);">HOTELES:</a>';
		var menu_lista_close 	= '<div class="map_bt_close"></div>';
		var menu_lista_links	= '';
		jQuery.each(beaches, function(key, mensaje) {
			menu_lista_links += '<a href="javascript:moveToDarwin(map,beaches['+increase+'][1],beaches['+increase+'][2]);">'+mensaje[0]+'</a>';
			increase = increase+1;
		});
		jQuery('#main_content_google_lista').html(menu_lista_header + menu_lista_links + menu_lista_close);
		console.log(beaches);
		
		var stylez = [
			{"elementType": "geometry","stylers": [{"color": "#f5f5f5"}]},
			{"elementType": "labels.icon","stylers": [{"visibility": "off"}]},
			{"elementType": "labels.text.fill","stylers": [{"color": "#616161"}]},
			{"elementType": "labels.text.stroke","stylers": [{"color": "#f5f5f5"}]},
			{"featureType": "administrative.land_parcel","elementType": "labels.text.fill","stylers": [{"color": "#bdbdbd"}]},
			{"featureType": "poi","elementType": "geometry","stylers": [{"color": "#eeeeee"}]},
			{"featureType": "poi","elementType": "labels.text.fill","stylers": [{"color": "#757575"}]},
			{"featureType": "poi.park","elementType": "geometry","stylers": [{"color": "#e5e5e5"}]},
			{"featureType": "poi.park","elementType": "labels.text.fill","stylers": [{"color": "#9e9e9e"}]},
			{"featureType": "road","elementType": "geometry","stylers": [{"color": "#ffffff"}]},
			{"featureType": "road.arterial","elementType": "labels.text.fill","stylers": [{"color": "#757575"}]},
			{"featureType": "road.highway","elementType": "geometry","stylers": [{"color": "#dadada"}]},
			{"featureType": "road.highway","elementType": "labels.text.fill","stylers": [{"color": "#616161"}]},
			{"featureType": "road.local","elementType": "labels.text.fill","stylers": [{"color": "#9e9e9e"}]},
			{"featureType": "transit.line","elementType": "geometry","stylers": [{"color": "#e5e5e5"}]},
			{"featureType": "transit.station","elementType": "geometry","stylers": [{"color": "#eeeeee"}]},
			{"featureType": "water","elementType": "geometry","stylers": [{"color": "#c9c9c9"}]},
			{"featureType": "water","elementType": "labels.text.fill","stylers": [{"color": "#9e9e9e"}
		]}];
	
		var myOptions = {
			zoom: 14,
			center: new google.maps.LatLng(-34.5988619117494,-58.3714878559113),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById("main_content_google"),myOptions);
		var styledMapOptions = {
		  map: map,
		  name: "Hip-Hop"
		}
		var jayzMapType =  new google.maps.StyledMapType(stylez,styledMapOptions);
		map.mapTypes.set('hiphop', jayzMapType);
		map.setMapTypeId('hiphop');
		setMarkers(map, beaches);
		//mapHidden();
	}
	function setMarkers(map, locations) {
		var image = new google.maps.MarkerImage(window.image_path+'/img/marker.png',
		  new google.maps.Size(46, 43),
		  new google.maps.Point(0,0),
		  new google.maps.Point(16, 43));
		var shape = {
		  coord: [1, 1, 46, 43],
		  type: 'rect'
		};
		
		for (var i = 0; i < locations.length; i++) {
		var beach = locations[i];
		var myLatLng = new google.maps.LatLng(parseFloat(beach[1]), parseFloat(beach[2]));
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			/*shadow: shadow,*/
			icon: image,
			shape: shape,
			title: beach[0],
			zIndex: Number(beach[3])
		});
		createInfoWindow(marker, beach[4], map, myLatLng);
		}
	}
	
	var infoWindow = new google.maps.InfoWindow();
	
	function createInfoWindow(marker, popupContent, map, myLatLng) {
		google.maps.event.addListener(marker, 'click', function () {
			infoWindow.setContent(popupContent);
			infoWindow.open(map, this);
			map.setCenter(myLatLng);
			map.setZoom(8);
		});
	}
	
	function moveToDarwin(map,lat,lon) {
		var darwin = new google.maps.LatLng(lat,lon);
		map.setCenter(darwin);
		map.setZoom(14);
	}
	
	function moveToDarwinOut(map,lat,lon) {
		var darwin = new google.maps.LatLng(lat,lon);
		map.setCenter(darwin);
		map.setZoom(4);
	}
	
	jQuery( ".map_bt_close" ).click(function() {
		jQuery( "#map" ).animate({
			height: "toggle"
			}, 500, function() {
			// Animation complete.
		});
	});
	
	jQuery( ".map_bt_open" ).click(function() {
		jQuery( "#map" ).animate({
			height: "toggle"
			}, 500, function() {
			// Animation complete.
		});
	});
	
	function mapHidden() {
		jQuery( "#map" ).animate({
			height: "toggle"
			}, 500, function() {
			// Animation complete.
		});
	}
	window.addEventListener('DOMContentLoaded', function() {
		setTimeout(mapHidden, 2000);
	});
	