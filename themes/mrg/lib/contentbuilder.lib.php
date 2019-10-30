<?php

// THISNEW MRG
function ppb_header_gallery_slider_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'title' => '',
        'items' => 3,
        'sliders' => '',
        'order' => 'default',
		'height' => '350',
        'custom_css' => '',
        'custom_class' => '',
        'layout' => 'fullwidth',
                    ), $atts));

    $return_html = '<div class="ppb_header_gallery ' . $size . ' ';

    $columns_class = 'three_cols';
    if ($layout == 'fullwidth') {
        $columns_class .= ' fullwidth';
    }
    $element_class = 'one_third gallery3';

    $return_html .= '" ';

    if (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode($custom_css) . '" ';
    }
	$return_html .= '>';

    $return_html .= '<div class="page_content_wrapper ';

    if ($layout == 'fullwidth') {
        $return_html .= 'full_width';
    }

    $return_html .= '" style="text-align:center">';

	wp_enqueue_script("flexslider-js", get_template_directory_uri()."/js/flexslider/jquery.flexslider-min.js", false, THEMEVERSION, true);
	wp_enqueue_script("script-gallery-flexslider", get_template_directory_uri()."/templates/script-gallery-flexslider.php", false, THEMEVERSION, true);
	
	$slider_order = 'ASC';
    $slider_order_by = 'menu_order';
    switch ($order) {
        case 'default':
            $slider_order = 'ASC';
            $slider_order_by = 'menu_order';
            break;

        case 'newest':
            $slider_order = 'DESC';
            $slider_order_by = 'post_date';
            break;

        case 'oldest':
            $slider_order = 'ASC';
            $slider_order_by = 'post_date';
            break;

        case 'title':
            $slider_order = 'ASC';
            $slider_order_by = 'title';
            break;

        case 'random':
            $slider_order = 'ASC';
            $slider_order_by = 'rand';
            break;
    }

    //Get slider items
    $args = array(
        'order' => $slider_order,
        'orderby' => $slider_order_by,
        'post_type' => array('slider'),
        'suppress_filters' => 0,
    );

    if (!empty($sliders)) {
        $args['sliders'] = $sliders;
    }
    $sliders_arr = get_posts($args);
	
    if (!empty($sliders_arr) && is_array($sliders_arr)) {
		
		$return_html.= '<div class="slider_wrapper">';
		$return_html.= '<div class="flexslider" data-height="'.$height.'">';
		$return_html.= '<ul class="slides">';
		
        foreach ($sliders_arr as $key => $slider) {
			
            $image_url = '';
            $slider_ID = $slider->ID;

            if (has_post_thumbnail($slider_ID, 'large')) {
                $image_id = get_post_thumbnail_id($slider_ID);
                $image_url = wp_get_attachment_image_src($image_id, 'full', true);
                $small_image_url = wp_get_attachment_image_src($image_id, 'img_destacado_slider_home', true);
            }
			
			
            //Get slider Meta
            $slider_permalink_url 		= get_permalink($slider_ID);
            $slider_title 				= $slider->post_title;
				$slider_content				= $slider->post_content;
				$slider_show_button     = get_post_meta( $slider_ID, '_mrg_slider_btn_show', true );
				$slider_url_button      = get_post_meta( $slider_ID, '_mrg_slider_btn_url', true );
				$slider_url_button_text = get_post_meta( $slider_ID, '_mrg_slider_btn_text', true );



			$slider_tags = "";
			$tmp = wp_get_post_tags($slider_ID, array( "fields" => "names" ));

			if ( $tmp ) {
				$slider_tags  = " tag-" . implode(" tag-", $tmp) ;
			}
			
            //Begin display HTML
           
			
			$return_html.= '<li class="slide '.$slider_tags.'" style="background-image: -webkit-linear-gradient(270deg, rgba(0, 0, 0, .40), rgba(7, 112, 183, .5)), url('.$small_image_url[0].'); background-image: linear-gradient(180deg, rgba(0, 0, 0, .40), rgba(7, 112, 183, .5)), url('.$small_image_url[0].'); height:'.$height.'px;">';
			
			if(!empty($slider_title))
			{
				$return_html.= '<div class="box">';
				$return_html.= '<h1>'.$slider_title.'</h1>';
				$return_html.= '<p>'.$slider_content.'</p>';
				
				if( $slider_show_button && !empty($slider_url_button_text)     ) {
					$return_html.= '<a href="'.$slider_url_button.'" class="button">'.$slider_url_button_text.'</a>';
				}
				
				$return_html.= '</div>';
			}
			
			$return_html.= '</li>';
            

          
            
        }

        $return_html.= '</ul>';
		$return_html.= '</div>';
		$return_html.= '</div>';
		
		$return_html .= '</div>';
    }
	
    $return_html .= '</div>';

    return $return_html;
}
add_shortcode('ppb_header_gallery_slider', 'ppb_header_gallery_slider_func');

function ppb_module_subtitle_bajada_search_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'subtitulo' 		=> '',
		'bajada' 			=> '',
		'url_redirect' 		=> '',
    ), $atts));
	
    wp_enqueue_script("search_form_js", get_template_directory_uri() . "/js/jquery.validate.js", false, THEMEVERSION);
	wp_enqueue_script("search_form_script_js", get_template_directory_uri() . "/js/search/search_script.js", false, THEMEVERSION);
		
	$return_html = '<div class="ppb_module_subtitle_bajada_search ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$bajada = trim(str_replace($scapes, '', html_entity_decode($bajada)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<h2>'.$subtitulo.'</h2>';
	$return_html .= '			<p>'.html_entity_decode($bajada).'</p>';
		
	$return_html .= '			<form name="form_consultar" id="form_consultar" class="style_form" action="'.$url_redirect.'">';
	$return_html .= '			  <div class="row">';
	$return_html .= '			    <div class="col-md-10">';
	$return_html .= '			      <input type="text" class="form-control" id="consulta" name="seg" tabindex="1" placeholder="consulta" />';
	$return_html .= '			    </div>';
	$return_html .= '			    <div class="col-md-2">';
	$return_html .= '			      <input value="CONSULTAR" class="btn btn-xl" tabindex="2" type="submit">';
	$return_html .= '			    </div>';
	$return_html .= '			  </div>';
	$return_html .= '			</form>';
	
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close ppb_module_subtitle_bajada_search
	
    return $return_html;
}
add_shortcode('ppb_module_subtitle_bajada_search', 'ppb_module_subtitle_bajada_search_func');


function ppb_module_eventbrite_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'eventbrite_token' 	=> '',	
		'titulo' 			=> '',
		'estado_del_evento' => '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'numero_de_eventos' => '3',
		'column_number' 	=> '3',
		'leer_mas' 			=> 'https://www.eventbrite.com.ar/o/espacio-para-el-desarrollo-laboral-y-tecnologico-edlt-municipio-de-rio-grande-17204344257',
		'leer_mas_string' 	=> 'LEER MÁS',
		'target' 			=> '_blank',
		'seconds_expire' 	=> 3600,
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_eventbrite ';
	
    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
		
    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($eventbrite_token))
	{
		
		# Traemos eventos de Eventbrite
		require_once('eventbrite/eventbrite-sdk-php-master/HttpClient.php');
		
		# OBTENEMOS DATOS DEL USUARIO
		$client = new HttpClient($eventbrite_token, $seconds_expire);//OSJHICU36WBCDNXCFW4M//NA323OU6DZOHFY32DXOE
		$client->setTimeUpdate($seconds_expire);
		$user = $client->get('/users/me/');
		
		# OBTENEMOS DIRECCIONES
		$my_venues = $client->get_user_venues($user['id'], $expand=array());
		$venues = $my_venues['venues'];
		
		# OBTENEMOS EVENTOS
		if(!empty($estado_del_evento)){
			$arguments = array('status'=>$estado_del_evento);
		}else{
			$arguments = array('order_by'=>'created_asc');
		}
		$client->setArguments($arguments);
		
		$my_events = $client->get_user_owned_events($user['id'], $expand=array());
		$make_file_status = $client->getStatus();
		
			
		if(!empty($titulo) || !empty($bajada))
		{
			$return_html .= '<div class="row">';
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			
			if(!empty($titulo))
			{
				$return_html .= '			<h2 data-user-id="'.$user['id'].'" data-status="'.$estado_del_evento.'" data-expire="'.$seconds_expire.'" data-file-status="'.$make_file_status.'">'.html_entity_decode($titulo).'</h2>';
			}
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
			$return_html .= '</div>'; // close row
		}
		
		$css_columns = '';
		
		switch($column_number){
			
			case '1':
				$css_columns = 'col-md-12';
			break;
			
			case '2':
				$css_columns = 'col-md-6';
			break;
			
			case '3':
				$css_columns = 'col-md-4';
			break;
			
			case '4':
				$css_columns = 'col-md-3';
			break;
			
			default:
				$css_columns = 'col-md-6';
			break;
		}
		
		date_default_timezone_set('UTC');
		date_default_timezone_set("America/Argentina/Ushuaia");
		setlocale(LC_ALL,"es_ES");
		
		
		$counter_column = 1;
		$total_row = $numero_de_eventos / $column_number;
		
		$return_html .= '<div class="row">';
		setlocale(LC_TIME, 'es_ES.utf8',"es_ES","esp");
		foreach($my_events['events'] as $eventos){
			
			$direccion = MRG_getSegmentOffArrayByIndice($venues,'id',$eventos['venue_id']);
			$direccion_address = $direccion['address']['localized_address_display'];
			$status = $eventos['status'];
			
			if($status == $estado_del_evento)
			{
				if($counter_column<=$numero_de_eventos){
					
					$return_html .= '	<div class="col col-md '.$css_columns.'">';
					$return_html .= '	<a href="'.$eventos['url'].'" target="_blank">';
					$return_html .= '		<div class="content">';
					$return_html .= '			<div class="title">';
					$return_html .= '				<h4>'.str_replace('- Municipio de Rio Grande','',html_entity_decode($eventos['name']['text'])).'</h4>';
					$return_html .= '			</div>';
					$return_html .= '			<div class="image" style="background-image:url(\''.$eventos['logo']['url'].'\')">';
					$return_html .= '				<img src="'. get_template_directory_uri() .'/images/img_bg_small.gif" alt="image" width="100%">';
					$return_html .= '			</div>';
					$return_html .= '			<div class="detail">'; 
					$return_html .= '				<strong>Inicio:</strong> <span class="capitalize">' . strftime("%A %d/%m",strtotime($eventos['start']['local'])) . '</span> ' . date("H:i", strtotime($eventos['start']['local'])) .'<br>';
					$return_html .= '				<strong>Duración:</strong> ' . date("d/m/Y", strtotime($eventos['start']['local'])) . ' a ' . date("d/m/Y", strtotime($eventos['end']['local'])) .'<br>';
					$return_html .= '				<strong>Horario:</strong> ' . date("H:i", strtotime($eventos['start']['local'])) . ' a ' . date("H:i", strtotime($eventos['end']['local'])) .'<br>';
					$return_html .= '				<strong>Cupo:</strong> '.$eventos['capacity']. '<br>';
					$return_html .= '				<strong>Sede:</strong> '.$direccion_address . '<br>';
					$return_html .= '				Más info <span class="orange">aquí</span>';
					$return_html .= '			</div>';
					$return_html .= '		</div>';
					$return_html .= '	</a>'."\r";
					$return_html .= '	</div>'."\r";
					
					if ($counter_column % 3 == 0) {
						$return_html .= '</div>';
						$return_html .= '<div class="row">';
					}
					
					$counter_column = $counter_column + 1;
				}
			}
		}
		
		$return_html .= '</div>'; // close row
		
		$return_html .= '<div class="row read">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<a href="'.$leer_mas.'" class="button" target="'.$target.'">'.$leer_mas_string.'</a>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close ppb_module_eventbrite
	
    return $return_html;
}
add_shortcode('ppb_module_eventbrite', 'ppb_module_eventbrite_func');

?>
