<?php 
header("content-type: application/x-javascript");
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );

	$pp_contact_lat = get_option('pp_contact_lat');
    $pp_contact_long = get_option('pp_contact_long');
    $pp_contact_map_zoom = get_option('pp_contact_map_zoom');
    $pp_contact_map_popup = get_option('pp_contact_map_popup');
    $pp_contact_map_type = get_option('pp_contact_map_type');
	$pp_map_icon = get_option('pp_map_icon');
	$pp_map_icon = get_option('pp_map_icon');
	$pp_map_max_items = get_option('pp_map_max_items');

	$sube_order = 'ASC';
    $sube_order_by = 'menu_order';
    switch ($sube_order) {
        case 'default':
            $sube_order = 'ASC';
            $sube_order_by = 'menu_order';
            break;

        case 'newest':
            $sube_order = 'DESC';
            $sube_order_by = 'post_date';
            break;

        case 'oldest':
            $ssube_order = 'ASC';
            $sube_order_by = 'post_date';
            break;

        case 'title':
            $sube_order = 'ASC';
            $sube_order_by = 'title';
            break;

        case 'random':
            $sube_order = 'ASC';
            $sube_order_by = 'rand';
            break;
    }

    //Get sube items
    $args = array(
        'numberposts' => $pp_map_max_items,
        'order' => $sube_order,
        'orderby' => $sube_order_by,
        'post_type' => array('sube'),
        'suppress_filters' => 0,
    );

    $subes_arr = get_posts($args);

    if(empty($pp_contact_map_type))
    {
	    $pp_contact_map_type = 'MapTypeId.TERRAIN';
    }

	
?>
	var image_path = jQuery('#map').attr('path');
	var flags 	= new Array();
    
<?php
if (!empty($subes_arr) && is_array($subes_arr)) {
		
		$subes_arr_leng = count($subes_arr)-1;
		
		for($i=0; $i<=$subes_arr_leng; $i++) {
			
			$sube_title 	= $subes_arr[$i]->post_title;
			$sube_content	= $subes_arr[$i]->post_content;
			$sube_lat 		= $subes_arr[$i]->sube_latitud;
			$sube_long 		= $subes_arr[$i]->sube_longitud;
			$sube_data 		=  $sube_title.'<br>'.$sube_content;
			$sube_popup 	=  preg_replace('/[\n|\r|\n\r|\t|\0]/i', '',$sube_data);
?>    
		var temp_arr = new Array();
        temp_arr.push('<?php echo addslashes_gpc($sube_title); ?>');
		temp_arr.push('<?php echo $sube_lat; ?>');
		temp_arr.push('<?php echo $sube_long; ?>');
		temp_arr.push(<?php echo $i+1; ?>);
		temp_arr.push('<?php echo addslashes_gpc($sube_popup); ?>');
        flags.push(temp_arr);
<?php
		}
}else{
?>
		var temp_arr = new Array();
        temp_arr.push('<?php echo addslashes_gpc($pp_contact_map_popup); ?>');
		temp_arr.push('<?php echo $pp_contact_lat; ?>');
		temp_arr.push('<?php echo $pp_contact_long; ?>');
		temp_arr.push(1);
		temp_arr.push('<?php echo addslashes_gpc($pp_contact_map_popup); ?>');
        flags.push(temp_arr);
<?php
}
?>
    
	beaches = flags;
    var mapa_visible = false;
	
	var map;
	function initialize(beaches) {
		var increase 			= 0;
		var length 				= beaches.length;
		console.log(beaches);
		
		var stylez = [
			{"elementType": "geometry","stylers": [{"color": "#f5f5f5"}]},
			{"elementType": "labels.icon","stylers": [{"visibility": "on"},{"saturation": -100}]},
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
			zoom: <?php echo $pp_contact_map_zoom; ?>,
			center: new google.maps.LatLng(<?php echo $pp_contact_lat; ?>,<?php echo $pp_contact_long; ?>),
            scrollwheel: false,
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
        
        jQuery( ".map_bt_close" ).click(function() {
            jQuery( "#map" ).animate({
                height: "toggle"
                }, 500, function() {
                // Animation complete.
            });
        });
	}
	function setMarkers(map, locations) {
        var image = new google.maps.MarkerImage('<?php echo $pp_map_icon; ?>',
		  new google.maps.Size(46, 62),
		  new google.maps.Point(0, 0));
		var shape = {
		  coord: [1, 1, 46, 62],
		  type: 'rect'
		};
		
		for (var i = 0; i < locations.length; i++) {
		var beach = locations[i];
		var myLatLng = new google.maps.LatLng(parseFloat(beach[1]), parseFloat(beach[2]));
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
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
			map.setZoom(<?php echo $pp_contact_map_zoom; ?>);
		});
	}
	
	function moveToDarwin(map,lat,lon) {
		var darwin = new google.maps.LatLng(lat,lon);
		map.setCenter(darwin);
		map.setZoom(<?php echo $pp_contact_map_zoom; ?>);
	}
	
	function moveToDarwinOut(map,lat,lon) {
		var darwin = new google.maps.LatLng(lat,lon);
		map.setCenter(darwin);
		map.setZoom(4);
	}
    
	initialize(flags);
    
	