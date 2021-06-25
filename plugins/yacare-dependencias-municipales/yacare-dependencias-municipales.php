<?php 

/*
Plugin Name: Dependencias Municipales
Description: Trae las dependencias municipales desde el Yacaré (API)
Author: Ariela Quinzi
Version: 1.0
*/

add_shortcode( 'yacare-dependencias', 'yacare_dependencias_shortcode' );

function yacare_dependencias_shortcode(  ) {

	$context = stream_context_create(array(
		'http'=>array(
		'method'=>"GET",
		'header'=>"apikey: la-api-key\r\naccept: application/json"
		)
	));
	
	$places = json_decode( file_get_contents("https://yacare.dir.riogrande.gob.ar/api/organizacion/dependencias", false, $context), true );
	
	
	$places_categorized = array();

	
	foreach ( $places as $place ) {
		$place_cat = $place["etiquetasNombresLista"];
		if ( array_key_exists( $place_cat, $places_categorized ) === false ) {
			$places_categorized[$place_cat] = array();
		}
		
		$places_categorized[$place_cat][] = $place;
		
	}
	
	$output = "";
	
	
	foreach($places_categorized as $cat => $places){
		if (empty($places)){
			continue;
		}
		
		$the_cat = (!empty($cat)) ? $cat : "Otros";
		
		$output .= '<h4 id="telefonos-'.str_replace(" ","-", mb_strtolower($the_cat)).'">' . $the_cat . '</h4>';
		
		$output .= '<table class="wp-block-table"><tbody><tr><th>Nombre</th><th>Dirección</th><th>Teléfono</th></tr>';
		
		foreach ( $places as $place ){
			// TODO: Al 2021-01-26 hay un dependencia como 'No Name'. Fijarse si eliminarla del sistema y eliminar esto
			if ($place['nombre'] == 'No Name') {
				continue;
			}
			
			
			$tmp_tels = $place["telefonos"];
			$tels = array();

			if ( strpos($tmp_tels, " o ") ) {
				$tmp_tels = explode(" o ", $tmp_tels ); 
			}
			elseif ( strpos($tmp_tels, ", ") ) {
				$tmp_tels = explode(", ", $tmp_tels);
			}
			elseif ( strpos($tmp_tels, " - ") ) {
				//caso especial de uno que separa telefonos con -
				$tmp_tels = explode(" - ", $tmp_tels);
			}
			else {
				$tmp_tels = array($tmp_tels);
			}

			foreach ( $tmp_tels as $current_phone ) {
				$cur_phone = str_replace(array(" int:", "Internos:", " Interno:"), array(" int", " int", " int"), $current_phone);

				if ( strpos($cur_phone, " int ") ) {
					$tmp = explode(" int ", $cur_phone);
					$tels[] = '<a href="tel://' . $tmp[0] . '">' . $tmp[0] . "</a> int: " . $tmp[1];
				}
				else {
					$tels[] = '<a href="tel://' . $cur_phone . '">' . $cur_phone . '</a>';
				}
			}

			$tels = implode(", ", $tels);

			
			$lat = str_replace(",",".", $place["Ubicacion"]["longitude"]);
			$lon = str_replace(",",".", $place["Ubicacion"]["latitude"]);

			$output .= '<tr><td>'.$place["nombre"].'</td><td><a href="https://www.openstreetmap.org/?mlat='.$lat.'&amp;mlon='.$lon.'#map=17/'.$lat.'/'.$lon.'" title="Ver '.$place["nombre"].' en mapa" rel="noopener external">'.$place["domicilioTexto"].'</a></td><td>' . $tels . '</td></tr>';
		}
		
		$output .= '</tbody></table>';
		
	}

	return $output;
}
