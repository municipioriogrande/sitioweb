<?php 
header("content-type: application/x-javascript");
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );
?>

<?php
    $pp_contact_lat = get_option('pp_contact_lat');
    $pp_contact_long = get_option('pp_contact_long');
    $pp_contact_map_zoom = get_option('pp_contact_map_zoom');
    $pp_contact_map_popup = get_option('pp_contact_map_popup');
    $pp_contact_map_type = get_option('pp_contact_map_type');
	$pp_map_icon = get_option('pp_map_icon');
    if(empty($pp_contact_map_type))
    {
	    $pp_contact_map_type = 'MapTypeId.TERRAIN';
    }
?>
    jQuery(document).ready(function(){ 
        jQuery("#map_contact").gMap({ 
        					zoom: <?php echo $pp_contact_map_zoom; ?>, 
                            markers: [ { latitude: '<?php echo $pp_contact_lat; ?>', 
                            	longitude: '<?php echo $pp_contact_long; ?>', 
                            	html: "<?php echo $pp_contact_map_popup; ?>", 
                                icon: {
                                    image: "<?php echo $pp_map_icon; ?>",
                                    iconsize: [46, 43],
                                    iconanchor: [16, 43]
                                },
                            	popup: true } ], 
                            mapTypeControl: false, 
                            zoomControl: false, 
                            scrollwheel: false,
                            styles: [
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
                              ]}],
                            maptype: google.maps.<?php echo $pp_contact_map_type; ?> 
                            });
    });