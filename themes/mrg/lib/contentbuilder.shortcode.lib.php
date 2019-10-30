<?php
//Get all galleries
$args = array(
    'numberposts' => -1,
    'post_type' => array('galleries'),
);

//Get all categories
$categories_arr = get_categories();
$categories_select = array();
$categories_select[''] = '';

foreach ($categories_arr as $cat) {
	$categories_select[$cat->id] = $cat->cat_name;
}

// THISNEW 
//Get all slider categories
$slider_cats_arr = get_terms('sliders', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
$slider_cats_select = array();
$slider_cats_select[''] = '';

foreach ($slider_cats_arr as $slider_cat) {
	$slider_cats_select[$slider_cat->slug] = $slider_cat->name;
}
// END THISNEW 

//Get order options
$order_select = array(
	'default' 	=> 'By Default',
	'newest'	=> 'By Newest',
	'oldest'	=> 'By Oldest',
	'title'		=> 'By Title',
	'random'	=> 'By Random',
);
$gallery_layout_select = array(
	'fullwidth'	=> 'Fullwidth',
	'fixedwidth'=> 'Fixed Width',
);

//Get parallax type options
$background_size_select = array(
	'' 	=> 'Cover',
	'110' 	=> '110%',
	'120' 	=> '120%',
	'130' 	=> '130%',
	'140' 	=> '140%',
	'150' 	=> '150%',
	'160' 	=> '160%',
	'170' 	=> '170%',
	'180' 	=> '180%',
	'190' 	=> '190%',
	'200' => '200%',
);

$background_overlay_select = array(
	'' 	=> '0',
	'10' 	=> '10%',
	'20' 	=> '20%',
	'30' 	=> '30%',
	'40' 	=> '40%',
	'50' 	=> '50%',
	'60' 	=> '60%',
	'70' 	=> '70%',
	'80' 	=> '80%',
	'90' 	=> '90%',
);
$cta_select_2 = array(
	'1'	=> 'Usar botón comun',
	'2'	=> 'Usar solo botón (el botón de integrará al diseño)',
	'3'	=> 'Usar imagen (la imagen reemplazará al diseño)',
);
$cta_select = array(
	''	=> 'False',
	'1'	=> 'TRUE',
);
$mostrar_select = array(
	'true'	=> 'Mostrar',
	'false'	=> 'Ocultar',
);

$cta_select_lines = array(
	'1'	=> '1',
	'2'	=> '2',
	'3'	=> '3',
	'4'=> '4',
	'5'=> '5',
	'6'=> '6',
);
$column_numbers_select= array(
	'1'	=> '1',
	'2'	=> '2',
	'3'	=> '3',
	'4' => '4',
);
$margen_superior_select = array(
	'normal'	=> 'Normal',
	'big'	=> 'Grande',
	'small'	=> 'Chico',
);
$select_row_number = array(
	'1'	=> '1',
	'2'	=> '2',
	'3'	=> '3',
	'4' => '4',
	'5'	=> '5',
	'6'	=> '6',
	'7'	=> '7',
	'8' => '8',
	'9'	=> '9',
	'10' => '10',
	'11' => '11',
	'12' => '12',
);
$select_targets = array(
	'_blank'	=> 'Ventana nueva',
	'_self'	=> 'Misma ventan',
);
$select_eventbrite_status = array(
	'all'	=> 'All',
	'draft'	=> 'Borradores',
	'live'	=> 'En vivo',
	'canceled' => 'Cancelados',
	'started' => 'iniciado',
	'ended' => 'terminado',
);

$select_seconds_expire= array(
	'0'		=> 'Al instante',
	'30'	=> '30 segundos',
	'60'	=> '1 Minuto',
	'300'	=> '5 Minutos',
	'600'	=> '10 Minutos',
	'1800'	=> '30 Minutos',
	'3600' 	=> '1 Hora',
	'18000' => '5 Horas',
	'86400' => '1 Día',
);



$ppb_shortcodes = array(
    
	// THINEW MRG
	'ppb_header_gallery_slider' => array(
    	'title' =>  'HOME • Header Gallery Slider',
    	'attr' => array(
    		'sliders' => array(
    			'title' => 'Category',
    			'type' => 'select',
    			'options' => $slider_cats_select,
    			'desc' => 'Select the Slider Category you want to display',
    		),
    		'layout' => array(
    			'title' => 'Layout',
    			'type' => 'select',
    			'options' => $gallery_layout_select,
    			'desc' => 'Select layout you want to display gallery wrapper',
    		),
			'order' => array(
    			'title' => 'Order By',
    			'type' => 'select',
    			'options' => $order_select,
    			'desc' => 'Select how you want to order portfolio items',
    		),
    		'items' => array(
    			'type' => 'jslider',
    			'from' => 1,
    			'to' => 50,
    			'desc' => 'Enter number of posts to display (number value only)',
    		),
			'height' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of height for the slider (in pixel)',
    		),
    		'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
	 ),
	'ppb_header_gallery_slider' => array(
    	'title' =>  'HOME • Header Gallery Slider',
    	'attr' => array(
    		'sliders' => array(
    			'title' => 'Category',
    			'type' => 'select',
    			'options' => $slider_cats_select,
    			'desc' => 'Select the Slider Category you want to display',
    		),
    		'layout' => array(
    			'title' => 'Layout',
    			'type' => 'select',
    			'options' => $gallery_layout_select,
    			'desc' => 'Select layout you want to display gallery wrapper',
    		),
			'order' => array(
    			'title' => 'Order By',
    			'type' => 'select',
    			'options' => $order_select,
    			'desc' => 'Select how you want to order portfolio items',
    		),
    		'items' => array(
    			'type' => 'jslider',
    			'from' => 1,
    			'to' => 50,
    			'desc' => 'Enter number of posts to display (number value only)',
    		),
			'height' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of height for the slider (in pixel)',
    		),
    		'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
	 ),
	'ppb_module_subtitle_bajada_search' => array(
    	'title' =>  '(-p-) Buscador',
    	'attr' => array(
			
			'subtitulo' => array(
    			'title' => 'Subtitulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Sub Title',
    		),
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description.',
    		),
			'url_redirect' => array(
    			'title' => 'URL Buscador',
				'type' => 'text',
    			'desc' => 'Enter URL redirect.',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
	 ),


	'ppb_module_eventbrite' => array(
    	'title' =>  '(e) Eventbrite',
    	'attr' => array(
			
			'eventbrite_token' => array(
    			'title' => 'Token de usuario Eventbrite',
    			'type' => 'text',
    			'desc' => 'Enter the Token code of Eventbrite',
    		),
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Enter the Anchor Text',
    		),
			'estado_del_evento' => array(
    			'title' => 'Estado del los eventos',
    			'type' => 'select',
    			'options' => $select_eventbrite_status,
    			'desc' => 'Select the status of te events to show',
    		),
			'numero_de_eventos' => array(
    			'title' => 'Numero de eventos',
    			'type' => 'select',
    			'options' => $select_row_number,
    			'desc' => 'Select the number of events to show',
    		),
			'column_number' => array(
    			'title' => 'Numero de columnas',
    			'type' => 'select',
    			'options' => $column_numbers_select,
    			'desc' => 'Select the number of te column to show',
    		),
			'leer_mas' => array(
    			'title' => 'URL botón',
    			'type' => 'text',
    			'desc' => 'Enter the URL for the button',
    		),
			'leer_mas_string' => array(
    			'title' => 'Texto del botón',
    			'type' => 'text',
    			'desc' => 'Enter the text for the button',
    		),
			'target' => array(
    			'title' => '¿Que hace al hacer clic en el botón?',
    			'type' => 'select',
    			'options' => $select_targets,
    			'desc' => 'Select the target of button',
    		),
			'seconds_expire' => array(
    			'title' => 'Tiempo de refresco de los eventos',
    			'type' => 'select',
    			'options' => $select_seconds_expire,
    			'desc' => 'Select the time in which the events are refreshed (we do not recommend leaving it configured "instantly")',
    		),
			
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	
	// end THISNEW MRG 
	
);

	 
// call from functions	 
$tmp = get_external_blog_categories();

$categories_select = array(
	'all' => 'Todas'
);

if ( !empty( $tmp ) ) {
	$the_cat_id = -1;
	$the_cat_name = "";
	foreach ($tmp as $cat_id => $cat_details ) {
		$the_cat_id = $cat_id;
		$the_cat_name = $cat_details['name'];
		
		if ( isset($cat_details['id']) ) {
			$the_cat_id = $cat_details['id'];
		}
		
		$categories_select[$the_cat_id] = $the_cat_name; //expected format
	}	
}


ksort($ppb_shortcodes);
?>