<?php 

/*
Plugin Name: Dependencias Municipales
Description: Trae las dependencias municipales desde el Yacaré (API)
Author: Ariela Quinzi
Version: 1.0
*/

add_shortcode( 'yacare-dependencias', 'yacare_dependencias_shortcode' );

function yacare_dependencias_shortcode(  ) {


	$places = json_decode( file_get_contents("https://yacare.dir.riogrande.gob.ar/api/organizacion/dependencias.json"), true );
	$places_categorized = array();

	
	foreach ( $places as $place ) {
		$place_cat = $place["etiquetas"][0]["nombre"];
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
		
		$output .= '<h4 id="telefonos-'.str_replace(" ","-",mb_strtolower($cat)).'">' . $cat . '</h4>';
		
		$output .= '<table class="wp-block-table"><tbody><tr><th>Nombre</th><th>Dirección</th><th>Teléfono</th></tr>';
		
		foreach ( $places as $place ){
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
				$cur_phone = str_replace(array("-", " int:", "4 4"), array("", " int", "44"), $current_phone);

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

			$output .= '<tr><td>'.$place["nombre"].'</td><td><a href="https://www.openstreetmap.org/?mlat='.$lat.'&amp;mlon='.$lon.'#map=17/'.$lat.'/'.$lon.'" title="Ver '.$place["nombre"].' en mapa" rel="noopener external">'.$place["domicilio"].'</a></td><td>' . $tels . '</td></tr>';
		}

		if ( $cat == "Emprendedores" ) {
			// not in API as of 2020-01-17
			$output .= '<tr><td>Paseo “Canto del Viento”</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78673&mlon=-67.69834#map=17/-53.78673/-67.69834" title="Ver Paseo “Canto del Viento” en mapa" rel="noopener external">Fagnano 650</a></td><td><a href="tel://436206">436206</a></td></tr>';
			$output .= '<tr><td>Oficina de Empleo</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78567&mlon=-67.70259#map=17/-53.78567/-67.70259" title="Ver Oficina de Empleo en mapa" rel="noopener external">San Martín 619</a></td><td><a href="tel://420394">420394</a> o <a href="tel://433587">433587</a></td></tr>';
		}

		if ( $cat == "Centros Comunitarios" ) {
			// not in API as of 2020-01-17
			$output .= '<tr><td>Casa Municipal</td><td><a href="https://www.openstreetmap.org/?mlat=-53.80269&mlon=-67.67515#map=17/-53.80269/-67.67515" title="Ver Casa Municipal en mapa" rel="noopener external">Portolán 465</a></td><td></td></tr>';
			$output .= '<tr><td>Los Cisnes</td><td>Calle 116 - Casa 557</td><td></td></tr>';
		}
		
		$output .= '</tbody></table>';
		
	}


	//not in API as of 2020-01-17
	$cat = "Promoción Social";
	$output .= '<h4 id="telefonos-'.str_replace(" ","-",mb_strtolower($cat)).'">' . $cat . '</h4>';
	$output .='<table class="wp-block-table"><tbody><tr><th>Nombre</th><th>Dirección</th><th>Teléfono</th></tr><tr><td>Promoción Humana</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78908&amp;mlon=-67.69378#map=17/-53.78908/-67.69378" title="Ver Promoción Humana en mapa" rel="noopener external">Luis Py 152</a></td><td><a href="tel://436245">436245</a></td></tr><tr><td>Defensoría Municipal</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78323&amp;mlon=-67.71479#map=17/-53.78323/-67.71479" title="Ver Defensoría Municipal en mapa" rel="noopener external">Pje. Roca y Almte. Brown</a></td><td><a href="tel://436237">436237</a></td></tr><tr><td>Promoción Adulto Mayor</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78436&amp;mlon=-67.70032#map=17/-53.78436/-67.70032" title="Ver Promoción Adulto Mayor en mapa" rel="noopener external">Belgrano 556</a></td><td><a href="tel://431821">431821</a></td></tr></tbody></table>';	

	//not in API as of 2020-01-17
	$cat = "Salud";
	$output .= '<h4 id="telefonos-'.str_replace(" ","-",mb_strtolower($cat)).'">' . $cat . '</h4>';

	$output .='<table class="wp-block-table"><tbody><tr><th>Nombre</th><th>Dirección</th><th>Teléfono</th></tr><tr><td>Centro de Salud Nº1</td><td><a href="https://www.openstreetmap.org/?mlat=-53.76697&amp;mlon=-67.72331#map=17/-53.76697/-67.72331" title="Ver Centro de Salud Nº1 en mapa" rel="noopener external">Luisa Rosso 779</a></td><td><a href="tel://436239">436239</a></td></tr><tr><td>Centro de Salud Nº2</td><td><a href="https://www.openstreetmap.org/?mlat=-53.80136&amp;mlon=-67.75218#map=17/-53.80136/-67.75218" title="Ver Centro de Salud Nº2 en mapa" rel="noopener external">Taparello 389</a></td><td><a href="tel://504838">504838</a></td></tr><tr><td>Centro de Salud Nº3</td><td><a href="https://www.openstreetmap.org/?mlat=-53.8059&amp;mlon=-67.67153#map=17/-53.8059/-67.67153" title="Ver Centro de Salud Nº3 en mapa" rel="noopener external">El Alambrador y Rafaela Ishton</a></td><td><a href="tel://436254">436254</a></td></tr><tr><td>Mamá Margarita</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78845&amp;mlon=-67.71778#map=17/-53.78845/-67.71778" title="Ver Mamá Margarita en mapa" rel="noopener external">Don Bosco 1489</a></td><td><a href="tel://431610">431610</a> o <a href="tel://433805">433805</a></td></tr><tr><td>Laboratorio</td><td><a href="https://www.openstreetmap.org/?mlat=-53.76704&amp;mlon=-67.72139#map=17/-53.76704/-67.72139" title="Ver Laboratorio en mapa" rel="noopener external">Anadón 735</a></td><td><a href="tel://436282">436282</a></td></tr><tr><td>Centro de Especialidades Médicas</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78988&amp;mlon=-67.69345#map=17/-53.78988/-67.69345" title="Ver Centro de Especialidades Médicas en mapa" rel="noopener external">San Martín 28 (3er piso)</a></td><td><a href="tel://436220">436220</a></td></tr><tr><td>Casa de María</td><td><a href="https://www.openstreetmap.org/?mlat=-53.79163&amp;mlon=-67.72876#map=17/-53.79163/-67.72876" title="Ver Casa de María en mapa" rel="noopener external">Edison y Finocchio</a></td><td><a href="tel://431823">431823</a></td></tr></tbody></table>';	

	//not in API as of 2020-01-17
	$cat = "Servicios";
	$output .= '<h4 id="telefonos-'.str_replace(" ","-",mb_strtolower($cat)).'">' . $cat . '</h4>';

	$output .='<table class="wp-block-table"><tbody><tr><th>Nombre</th><th>Dirección</th><th>Teléfono</th></tr><tr><td>Zoonosis</td><td><a href="https://www.openstreetmap.org/?mlat=-53.80219&amp;mlon=-67.73522#map=17/-53.80219/-67.73522" title="Ver Zoonosis en mapa" rel="noopener external">25 de mayo 2937</a></td><td><a href="tel://436200">436200</a> interno 5, <a href="tel://436265">436265</a>, o <a href="tel://436266">436266</a></td></tr><tr><td>Limpieza Urbano</td><td><a href="https://www.openstreetmap.org/?mlat=-53.80152&amp;mlon=-67.73402#map=17/-53.80152/-67.73402" title="Ver Limpieza Urbano en mapa" rel="noopener external">Chacabuco 987</a></td><td><a href="tel://436277">436277</a></td></tr><tr><td>Ecología</td><td><a href="https://www.openstreetmap.org/?mlat=-53.7874&amp;mlon=-67.69535#map=17/-53.7874/-67.69535" title="Ver Ecología en mapa" rel="noopener external">Rosales 246 (Planta baja)</a></td><td><a href="tel://436200">436200</a> int 5027/5028</td></tr><tr><td>Tarjeta SUBE</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78886&amp;mlon=-67.69378#map=17/-53.78886/-67.69378" title="Ver Tarjeta SUBE en mapa" rel="noopener external">Luis Py 168 dpto 2</a></td><td><a href="tel://436232">436232</a></td></tr><tr><td>Estacionamiento Medida</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78665&amp;mlon=-67.69535#map=17/-53.78665/-67.69535" title="Ver Estacionamiento Medida en mapa" rel="noopener external">Espora 567</a></td><td><a href="tel://436262">436262</a></td></tr><tr><td>Rentas</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78855&amp;mlon=-67.69366#map=17/-53.78855/-67.69366" title="Ver Rentas en mapa" rel="noopener external">Luis Py 198</a></td><td><a href="tel://436214">436214</a></td></tr><tr><td>Educación Vial</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78631&amp;mlon=-67.69457#map=17/-53.78631/-67.69457" title="Ver Educación Vial en mapa" rel="noopener external">Laserre 179 (1er piso)</a></td><td><a href="tel://436258">436258</a></td></tr><tr><td>Compras</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78766&amp;mlon=-67.69677#map=17/-53.78766/-67.69677" title="Ver Compras en mapa" rel="noopener external">Espera 655 (2do piso, of. 24)</a></td><td><a href="tel://436213">436213</a></td></tr><tr><td>Bromatología</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78205&amp;mlon=-67.7131#map=17/-53.78205/-67.7131" title="Ver Bromatología en mapa" rel="noopener external">Guillermo Brown 810</a></td><td><a href="tel://421995">421995</a> o <a href="tel://436295">436295</a></td></tr><tr><td>Turismo</td><td><a href="https://www.openstreetmap.org/?mlat=-53.78653&amp;mlon=-67.69698#map=17/-53.78653/-67.69698" title="Ver Turismo en mapa" rel="noopener external">Rosales 350</a></td><td><a href="tel://430516">430516</a></td></tr></tbody></table>';	






	return $output;


}
