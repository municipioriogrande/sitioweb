<?php 
header("content-type: application/x-javascript");
$file_url = 'json/puntos-carga.json';
$response = json_decode( file_get_contents( $file_url ), true);
$points = $response;
//var_dump($points);
$point_popup_tpl = '<p>$name </p><dl><div><dt>Dirección:</dt><dd>$address</dd></div></dl>';	

?>
var compare_to = "";
if (MapPointsParams.tipo == "estacionamiento") {
	compare_to = "si";
}

var map = L.map('map_puntos_carga').setView([-53.78903, -67.69588], 15);
var tile_url = 'https://tiles.dir.riogrande.gob.ar/carto/{z}/{x}/{y}.png';

var map_icon = L.icon({
	iconUrl: 'https://riogrande.gob.ar/wp-content/uploads/2017/12/marker.png',
	iconSize: [36,46],
	iconAnchor: [18, 46],
	popupAnchor: [0,-40],
});

L.tileLayer(tile_url,{
	attribution: 'Map data © <a href=\"http://openstreetmap.org\">OpenStreetMap</a> contributors',
	maxZoom: 18,
	minZoom: 14
}).addTo(map);

<?php
foreach ($points as $point) :
	/*
	if ($point['is_estacionamiento-medido'] == $compare_to ) {
		continue;
	}
	*/

	$vars = array(
		'$name'       => $point['name'],
		'$address'    => str_replace("'", " ", $point['address']),
	);
	
?> 

if ( "<?php echo $point['is_estacionamiento-medido'];?>" == compare_to ) {
	
L.marker([<?php echo $point['geocoord'];?>], {icon: map_icon}).addTo(map).bindPopup('<?php echo strtr($point_popup_tpl, $vars);?>');
}
<?php endforeach; ?>

