<?php
//Get all galleries
$args = array(
    'numberposts' => -1,
    'post_type' => array('galleries'),
);

$galleries_arr = get_posts($args);
$galleries_select = array();
$galleries_select[''] = '';

foreach($galleries_arr as $gallery)
{
    $galleries_select[$gallery->ID] = $gallery->post_title;
}

//Get all categories
$categories_arr = get_categories();
$categories_select = array();
$categories_select[''] = '';

foreach ($categories_arr as $cat) {
	$categories_select[$cat->id] = $cat->cat_name;
}

/* THISNEW { */
//Get all habitaciones categories
$habitacion_cats_arr = get_terms('habitacionescats', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
$habitacion_cats_select = array();
$habitacion_cats_select[''] = '';

foreach ($habitacion_cats_arr as $habitacion_cat) {
	$habitacion_cats_select[$habitacion_cat->slug] = $habitacion_cat->name;
}
//Get all slider categories
$slider_cats_arr = get_terms('sliders', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
$slider_cats_select = array();
$slider_cats_select[''] = '';

foreach ($slider_cats_arr as $slider_cat) {
	$slider_cats_select[$slider_cat->slug] = $slider_cat->name;
}
/* } THISNEW */

/* THISNEW MRG {*/
//Get all destacados categories
/*$destacado_cats_arr = get_terms('destacadoscats', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
$destacado_cats_select = array();
$destacado_cats_select[''] = '';

foreach ($destacado_cats_arr as $destacado_cat) {
	$destacado_cats_select[$destacado_cat->slug] = $destacado_cat->name;
}*/

//Get tour pages
$habitaciones_pages_select = array(
	'' => '---- Please select habitaciones page template ----'
);
$args = array(
'meta_query' => array(
       array(
           'key' => '_wp_page_template',
           'value' => array('habitacion-classic-contain.php', 'habitacion-classic-fullwidth.php', 'habitacion-grid-contain.php', 'habitacion-grid-fullwidth.php', 'habitacion-list-image.php', 'habitacion-list.php'),
           'compare' => 'IN',
       )
    ),

    'sort_column' => 'post_title',
    'sort_order' => 'ASC',
    'posts_per_page' => -1,
    'post_type' => 'page'
);
$habitacion_pages = get_posts($args);
foreach($habitacion_pages as $habitacion_page)
{
	$habitaciones_pages_select[$habitacion_page->ID] = $habitacion_page->post_title;
}


$topics_select = array(
	'' => '---- Please select topic ----'
);
$url_topics 		= 'https://api.hubapi.com/blogs/v3/topics?hapikey=d2973eed-dea2-48e2-8344-7f21fdd1827e';  
$ch_topics 			= curl_init($url_topics);                                                                      
curl_setopt($ch_topics, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
curl_setopt($ch_topics, CURLOPT_RETURNTRANSFER, true);                                                                      
$result_topics 		= curl_exec($ch_topics);

//$return_data_topics = json_decode($result_topics, true);
//Quick fix below to get result
$return_data_topics = json_decode(file_get_contents( $url_topics, true ), true);

$data_topics 		= $return_data_topics['objects'];
$data_topics_length = count($data_topics)-1;

for($i=0; $i<=$data_topics_length; $i++)
{
	$topics_select['a'.$data_topics[$i]['id']] = $data_topics[$i]['name'];
	/*
	echo "id:".$data_topics[$i]['id'].'<br>';
	echo "name:".$data_topics[$i]['name'].'<br>';
	echo "slug:".$data_topics[$i]['slug'].'<br>';
	echo "description:".$data_topics[$i]['description'].'<br>';
	echo '---------------<br>';
	*/
}
/* } THISNEW MRG */

//Get order options
$order_select = array(
	'default' 	=> 'By Default',
	'newest'	=> 'By Newest',
	'oldest'	=> 'By Oldest',
	'title'		=> 'By Title',
	'random'	=> 'By Random',
);

$gallery_column_select = array(
	'3'	=> '3 Columns',
	'4'	=> '4 Columns',
);

$text_block_layout_select = array(
	'fixedwidth'=> 'Fixed Width',
	'fullwidth'	=> 'Fullwidth',
);

$tour_layout_select = array(
	'fullwidth'	=> 'Fullwidth',
	'fixedwidth'=> 'Fixed Width',
);
/* THISNEW { */
$habitacion_layout_select = array(
	'fullwidth'	=> 'Fullwidth',
	'fixedwidth'=> 'Fixed Width',
);
$contact_layout_select = array(
	'fullwidth'	=> 'Fullwidth',
	'fixedwidth'=> 'Fixed Width',
);
//Get parallax type options
$muestra_select = array(
	'show' 	=> 'Muestra título',
	'hidden'   => 'No muestra título',
);
/* } THISNEW */
/* THISNEW MRG { */
//Get parallax type options
$muestra_detalle = array(
	'show' 	=> 'Muestra detalle',
	'hidden'   => 'No muestra detalle',
);
$destacado_layout_select = array(
	'fullwidth'	=> 'Fullwidth',
	'fixedwidth'=> 'Fixed Width',
);
$social_layout_select = array(
	'fullwidth'	=> 'Fullwidth',
	'fixedwidth'=> 'Fixed Width',
);
$contacto_layout_select = array(
	'fullwidth'	=> 'Fullwidth',
	'fixedwidth'=> 'Fixed Width',
);
$dispocicion_layout_select = array(
	'left'	=> 'Izquierda',
	'right'=> 'Derecha',
);
$mostrar_seguidores_select = array(
	'true'	=> 'Si',
	'false'=> 'No',
);
$mostrar_padding_select = array(
	'si'	=> 'Si',
	'no'=> 'No',
);
$cta_layout_select = array(
	'fullwidth'	=> 'Fullwidth',
	'fixedwidth'=> 'Fixed Width',
);
/* } THISNEW MRG */
$gallery_layout_select = array(
	'fullwidth'	=> 'Fullwidth',
	'fixedwidth'=> 'Fixed Width',
);

//Get parallax type options
$parallax_select = array(
	'' 	=> 'None',
	'scroll_pos'   => 'Scroll Position',
);

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
	'1'	=> 'Usar boton comun',
	'2'	=> 'Usar Boton de HubSpot (Solo boton. El Boton de integrara al diseño)',
	'3'	=> 'Usar Boton de HubSpot (Imagen, La imagen reemplazara al diseño)',
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
    /*'ppb_text' => array(
    	'title' =>  'Text Block',
    	'attr' => array(
    		'layout' => array(
    			'title' => 'Layout',
    			'type' => 'select',
    			'options' => $text_block_layout_select,
    			'desc' => 'Select layout you want to display textblock wrapper',
    		),
    		'background' => array(
    			'title' => 'Background Image',
    			'type' => 'file',
    			'desc' => 'Upload background image you want to display for this content',
    		),
    		'background_parallax' => array(
    			'title' => 'Background Parallax Option',
    			'type' => 'select',
    			'options' => $parallax_select,
    			'desc' => 'You can choose parallax type for this content background. Select none to disable parallax',
    		),
    		'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),
    'ppb_divider' => array(
    	'title' =>  'Divider',
    	'attr' => array(),
    	'desc' => array(),
    	'content' => FALSE
    ),
    'ppb_gallery' => array(
    	'title' =>  'Gallery',
    	'attr' => array(
    		'gallery' => array(
    			'title' => 'Gallery',
    			'type' => 'select',
    			'options' => $galleries_select,
    			'desc' => 'Select the gallery you want to display',
    		),
    		'layout' => array(
    			'title' => 'Layout',
    			'type' => 'select',
    			'options' => $gallery_layout_select,
    			'desc' => 'Select layout you want to display gallery wrapper',
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
    'ppb_gallery_slider' => array(
    	'title' =>  'Gallery Slider',
    	'attr' => array(
    		'gallery' => array(
    			'title' => 'Gallery',
    			'type' => 'select',
    			'options' => $galleries_select,
    			'desc' => 'Select the gallery you want to display',
    		),
    		'layout' => array(
    			'title' => 'Layout',
    			'type' => 'select',
    			'options' => $gallery_layout_select,
    			'desc' => 'Select layout you want to display gallery wrapper',
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
    'ppb_blog' => array(
    	'title' =>  'Blog',
    	'attr' => array(
    		'category' => array(
    			'title' => 'Filter by category',
    			'type' => 'select',
    			'options' => $categories_select,
    			'desc' => 'You can choose to display only some posts from selected category',
    		),
    		'items' => array(
    			'type' => 'jslider',
    			'from' => 1,
    			'to' => 50,
    			'desc' => 'Enter number of posts to display (number value only)',
    		),
    		'background' => array(
    			'title' => 'Background Image',
    			'type' => 'file',
    			'desc' => 'Upload background image you want to display for this content',
    		),
    		'background_parallax' => array(
    			'title' => 'Background Parallax Option',
    			'type' => 'select',
    			'options' => $parallax_select,
    			'desc' => 'You can choose parallax type for this content background. Select none to disable parallax',
    		),
    		'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),*/
    /*'ppb_transparent_video_bg' => array(
    	'title' =>  'Transparent Video Background',
    	'attr' => array(
			'description' => array(
    			'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
    		'mp4_video_url' => array(
    			'title' => 'MP4 Video URL',
    			'type' => 'file',
    			'desc' => 'Upload .mp4 video file you want to display for this content',
    		),
    		'webm_video_url' => array(
    			'title' => 'WebM Video URL',
    			'type' => 'file',
    			'desc' => 'Upload .webm video file you want to display for this content',
    		),
    		'preview_img' => array(
    			'title' => 'Preview Image URL',
    			'type' => 'file',
    			'desc' => 'Upload preview image for this video',
    		),
    		'height' => array(
    			'type' => 'text',
    			'desc' => 'Enter number of height for background image (in pixel)',
    		),
			'cta_text' => array(
				'title' => 'CTA Botón',
    			'type' => 'text',
    			'desc' => 'Ingrese el texto del boton',
    		),
			'cta_url' => array(
				'title' => 'CTA URL',
    			'type' => 'text',
    			'desc' => 'Ingrese la URL destino del boton',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),*/
    /**'ppb_fullwidth_button' => array(
    	'title' =>  'Full Width Button',
    	'attr' => array(
    		'link_url' => array(
    			'type' => 'text',
    			'desc' => 'Enter redirected link URL when button is clicked',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),*/
    /*'ppb_promo_box' => array(
    	'title' =>  'Promo Box',
    	'attr' => array(
    		'background_color' => array(
    			'type' => 'text',
    			'desc' => 'Enter color code for background ex. #222222',
    		),
    		'button_text' => array(
    			'type' => 'text',
    			'desc' => 'Enter promo box button text',
    		),
    		'button_url' => array(
    			'type' => 'text',
    			'desc' => 'Enter redirected link URL when button is clicked',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),*/
    'ppb_contact' => array(
    	'title' =>  'Contact Form',
    	'attr' => array(
			'see_title' => array(
    			'title' => 'Muestra titulo',
    			'type' => 'select',
    			'options' => $muestra_select,
    			'desc' => 'Destildar si no quiere mostrar el titulo',
    		),
			'layout' => array(
    			'title' => 'Layout',
    			'type' => 'select',
    			'options' => $contact_layout_select,
    			'desc' => 'Select layout you want to display contact wrapper',
    		),
    		'address' => array(
    			'title' => 'Address Info',
    			'type' => 'textarea',
    			'desc' => 'Enter company address, email etc. HTML and shortcode are support',
    		),
    		'background' => array(
    			'title' => 'Background Image',
    			'type' => 'file',
    			'desc' => 'Upload background image you want to display for this content',
    		),
    		'background_parallax' => array(
    			'title' => 'Background Parallax Option',
    			'type' => 'select',
    			'options' => $parallax_select,
    			'desc' => 'You can choose parallax type for this content background. Select none to disable parallax',
    		),
    		'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
			'form_s_code' => array(
    			'title' => 'Short code Form',
    			'type' => 'text',
    			'desc' => 'Puede agregar el Short Code de un formulario para reemplazar el actual.',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	
	/* THISNEW { */
	/*'ppb_habitacion_grid' => array(
    	'title' =>  '• Habitacion Grid',
    	'attr' => array(
    		'habitacioncat' => array(
    			'title' => 'Filter by Habitación category',
    			'type' => 'select',
    			'options' => $habitacion_cats_select,
    			'desc' => 'You can choose to display only some Habitación items from selected category',
    		),
    		'layout' => array(
    			'title' => 'Layout',
    			'type' => 'select',
    			'options' => $habitacion_layout_select,
    			'desc' => 'Select layout you want to display habitación content',
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
    		'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),
	'ppb_habitaciones_search' => array(
    	'title' =>  '• Habitaciones Search Form',
    	'attr' => array(
    		'action' => array(
    			'title' => 'Result Page Template',
    			'type' => 'select',
    			'options' => $habitaciones_pages_select,
    			'desc' => 'Select Habitaciones pages template you want to display search results',
    		),
			'external_action' => array(
    			'title' => 'URL destino',
    			'type' => 'text',
    			'desc' => 'Ingrese la dirección a donde serán posteados los paramtros',
    		),
			'hotel_id' => array(
    			'title' => 'Hotel ID',
    			'type' => 'text',
    			'desc' => 'Ingrese el ID de hotel',
    		),
			'language_id' => array(
    			'title' => 'Idioma ID',
    			'type' => 'text',
    			'desc' => 'Ingrese el ID de idioma',
    		),
			'layout' => array(
    			'title' => 'Layout',
    			'type' => 'select',
    			'options' => $habitacion_layout_select,
    			'desc' => 'Select layout you want to display habitación content',
    		),
    		'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),*/
	/* } THISNEW */
	
	/* THINEW MRG { */
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
	'ppb_alert_notice' => array(
    	'title' =>  'HOME • Alertas o Notificaciones',
    	'attr' => array(
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			'show_module' => array(
    			'title' => 'Mostrar modulo',
    			'type' => 'select',
    			'options' => $mostrar_select,
    			'desc' => 'Select to show or hide the module',
    		),
			'boton_url' => array(
    			'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'boton_text' => array(
    			'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'boton_cta' => array(
    			'type' => 'textarea',
    			'desc' => 'Enter the code of CTA (HubSpot)',
    		),
			'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
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
	'ppb_secciones_destacadas' => array(
    	'title' =>  'HOME • Secciones Destacadas',
    	'attr' => array(
			'seccion_1_text' => array(
    			'title' => '1 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_1_url' => array(
    			'title' => '1 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'seccion_1_imagen' => array(
    			'title' => '1 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			
			
			'seccion_2_text' => array(
    			'title' => '2 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_2_url' => array(
    			'title' => '2 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'seccion_2_imagen' => array(
    			'title' => '2 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			
			
			'seccion_3_text' => array(
    			'title' => '3 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_3_url' => array(
    			'title' => '3 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'seccion_3_imagen' => array(
    			'title' => '3 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			
			
			'seccion_4_text' => array(
    			'title' => '4 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_4_url' => array(
    			'title' => '4 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'seccion_4_imagen' => array(
    			'title' => '4 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			
			
			'seccion_5_text' => array(
    			'title' => '5 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_5_url' => array(
    			'title' => '5 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'seccion_5_imagen' => array(
    			'title' => '5 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			
			
			'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),
	'ppb_descubre' => array(
    	'title' =>  'HOME • Descubre algo nuevo',
    	'attr' => array(
			
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			
			'seccion_a1_imagen' => array(
    			'title' => '1 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_a1_text' => array(
    			'title' => '1 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_a1_url' => array(
    			'title' => '1 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'seccion_a1_copete' => array(
    			'title' => '1 Copete',
				'type' => 'text',
    			'desc' => 'Enter the copete text of Button',
    		),
			
			'seccion_a2_imagen' => array(
    			'title' => '2 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_a2_text' => array(
    			'title' => '2 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_a2_url' => array(
    			'title' => '2 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'seccion_a2_copete' => array(
    			'title' => '2 Copete',
				'type' => 'text',
    			'desc' => 'Enter the copete text of Button',
    		),
			
			'seccion_a3_imagen' => array(
    			'title' => '3 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_a3_text' => array(
    			'title' => '3 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_a3_url' => array(
    			'title' => '3 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'seccion_a3_copete' => array(
    			'title' => '3 Copete',
				'type' => 'text',
    			'desc' => 'Enter the copete text of Button',
    		),
			
			'seccion_a4_imagen' => array(
    			'title' => '4 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_a4_text' => array(
    			'title' => '4 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_a4_url' => array(
    			'title' => '4 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'seccion_a4_copete' => array(
    			'title' => '4 Copete',
				'type' => 'text',
    			'desc' => 'Enter the copete text of Button',
    		),
			
			'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),
	'ppb_gestion_municipal' => array(
    	'title' =>  'HOME • Gestión Municipal',
    	'attr' => array(
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			'show_margin_superior' => array(
    			'title' => 'Margen superior',
    			'type' => 'select',
    			'options' => $margen_superior_select,
    			'desc' => 'Select that top margin show',
    		),
			'show_margin_inferiro' => array(
    			'title' => 'Margen inferior',
    			'type' => 'select',
    			'options' => $mostrar_padding_select,
    			'desc' => 'Select if you like show the maring bottom',
    		),
			'column_number' => array(
    			'title' => 'Numero de columnas',
    			'type' => 'select',
    			'options' => $cta_select_lines,
    			'desc' => 'Select the number of te column to show',
    		),
			'seccion_1_icono' => array(
    			'title' => '1 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_1_text' => array(
    			'title' => '1 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_1_url' => array(
    			'title' => '1 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_2_icono' => array(
    			'title' => '2 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_2_text' => array(
    			'title' => '2 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_2_url' => array(
    			'title' => '2 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_3_icono' => array(
    			'title' => '3 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_3_text' => array(
    			'title' => '3 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_3_url' => array(
    			'title' => '3 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_4_icono' => array(
    			'title' => '4 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_4_text' => array(
    			'title' => '4 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_4_url' => array(
    			'title' => '4 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_5_icono' => array(
    			'title' => '5 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_5_text' => array(
    			'title' => '5 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_5_url' => array(
    			'title' => '5 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_6_icono' => array(
    			'title' => '6 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_6_text' => array(
    			'title' => '6 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_6_url' => array(
    			'title' => '6 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),
	'ppb_content_blog' => array(
    	'title' =>  'BLOG • Contenido del blog de HubSpot',
    	'attr' => array(
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			'show_items' => array(
    			'type' => 'text',
    			'desc' => 'Enter the number of articles to show',
    		),
			/*'shortcodeform' => array(
				'title' => 'Short Code',
    			'type' => 'textarea',
    			'desc' => 'Ingrese Short Code del formulario',
    		),*/
			
			'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),
	'ppb_telefonos_utiles' => array(
    	'title' =>  'HOME • Teléfonos Útiles',
    	'attr' => array(
			
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			
			'seccion_01_imagen' => array(
    			'title' => '1 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_01_text' => array(
    			'title' => '1 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_01_numnero' => array(
    			'title' => '1 Número',
				'type' => 'text',
    			'desc' => 'Enter the copete text of Button',
    		),
			
			'seccion_02_imagen' => array(
    			'title' => '2 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_02_text' => array(
    			'title' => '2 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_02_numnero' => array(
    			'title' => '2 Número',
				'type' => 'text',
    			'desc' => 'Enter the copete text of Button',
    		),
			
			'seccion_03_imagen' => array(
    			'title' => '3 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_03_text' => array(
    			'title' => '3 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_03_numnero' => array(
    			'title' => '3 Número',
				'type' => 'text',
    			'desc' => 'Enter the copete text of Button',
    		),
			
			'seccion_04_imagen' => array(
    			'title' => '4 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_04_text' => array(
    			'title' => '4 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_04_numnero' => array(
    			'title' => '4 Número',
				'type' => 'text',
    			'desc' => 'Enter the copete text of Button',
    		),
			
			'seccion_05_imagen' => array(
    			'title' => '5 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_05_text' => array(
    			'title' => '5 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_05_numnero' => array(
    			'title' => '5 Número',
				'type' => 'text',
    			'desc' => 'Enter the copete text of Button',
    		),
			
			
			'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),
	
	'ppb_module_header' => array(
    	'title' =>  '(S) Encabezado: título y bajada + contacto',
    	'attr' => array(
			
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
			'contacto_titulo' => array(
    			'title' => 'Contacto Titulo',
				'type' => 'text',
    			'desc' => 'Enter the Title of Contact',
    		),
			'contacto_telefono' => array(
    			'title' => 'Teléfono',
				'type' => 'text',
    			'desc' => 'Enter the Phone Number',
    		),
			'contacto_horario' => array(
    			'title' => 'Horario',
				'type' => 'text',
    			'desc' => 'Enter the Schedule',
    		),
			'contacto_direccion' => array(
    			'title' => 'Dirección',
				'type' => 'text',
    			'desc' => 'Enter the Address',
    		),
			'contacto_email' => array(
    			'title' => 'Email',
				'type' => 'text',
    			'desc' => 'Enter the Email',
    		),
			'contacto_twitter_url' => array(
    			'title' => 'Twitter',
				'type' => 'text',
    			'desc' => 'Enter the Twetter url',
    		),
			'contacto_facebook_url' => array(
    			'title' => 'Facebook',
				'type' => 'text',
    			'desc' => 'Enter the Facebook url',
    		),
			'contacto_instagram_url' => array(
    			'title' => 'Instagram',
				'type' => 'text',
    			'desc' => 'Enter the Instagram url',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_indice_anclas' => array(
    	'title' =>  '(S) Indice de anclas',
    	'attr' => array(
			
			'anclas' => array(
    			'title' => 'Listado de Anclas',
				'type' => 'textarea',
    			'desc' => 'Ingresar el listado de anclas',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_c1_c2' => array(
    	'title' =>  '(S) Titular / bajada y cuerpo 1 + cuerpo 2 (img)',
    	'attr' => array(
			
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
			
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_bajada_c1_bajada_c2' => array(
    	'title' =>  '(S) Subtitulo / Subtitulo 1 y cuerpo 1 + Subtitulo 2 y cuerpo 2',
    	'attr' => array(
			
			'subtitulo' => array(
    			'title' => 'Subtitulo',
				'type' => 'text',
    			'desc' => 'Enter Subtitle',
    		),
			'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Enter the Anchor Text',
    		),
			
			'subtitulo_1' => array(
    			'title' => 'Subtitulo 1',
				'type' => 'text',
    			'desc' => 'Enter Subtitle 1',
    		),
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			
			'subtitulo_2' => array(
    			'title' => 'Subtitulo 2',
				'type' => 'text',
    			'desc' => 'Enter Subtitle 2',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_nota_destacada_titular_bajada' => array(
    	'title' =>  '(S) Nota destacada titular y bajada',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Detail',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_c1_c2_c3' => array(
    	'title' =>  '(S) títular / Subtitulo / bajada y cuerpo1 + cuerpo 2 + cuerpo 3',
    	'attr' => array(
			
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
			'subtitulo' => array(
    			'title' => 'Subtitulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Subtitulo',
    		),
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			'cuerpo_3' => array(
    			'title' => 'Campo 3',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 3',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_c1_img' => array(
    	'title' =>  '(S) títular / bajada y cuerpo1 + imagen',
    	'attr' => array(
			
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
			
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_full_c1_c2' => array(
    	'title' =>  '(S) Titular y bajada / cuerpo 1 + cuerpo 2',
    	'attr' => array(
			
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
			
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			'show_paddin_inferiro' => array(
    			'title' => 'Paddin inferior',
    			'type' => 'select',
    			'options' => $mostrar_padding_select,
    			'desc' => 'Select if you like disabled the padding bottom',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_full_c4' => array(
    	'title' =>  '(S) Titular y bajada / cuerpo x 4',
    	'attr' => array(
			
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
			
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			'cuerpo_3' => array(
    			'title' => 'Campo 3',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 3',
    		),
			'cuerpo_4' => array(
    			'title' => 'Campo 4',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 4',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	
	'ppb_module_titular_subtitulo_c1_subtitulo_c2' => array(
    	'title' =>  '(S) Titular / subtitulo 1 y cuerpo 1 + subtitulo 2 y cuerpo 2',
    	'attr' => array(
			
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
			
			'subtitulo_1' => array(
    			'title' => 'Subtitulo 1',
				'type' => 'textarea',
    			'desc' => 'Enter short description.',
    		),
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'subtitulo_2' => array(
    			'title' => 'Subtitulo 2',
				'type' => 'textarea',
    			'desc' => 'Enter short description.',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_cuerpo' => array(
    	'title' =>  '(S) Títular y Bajada / Cuerpo',
    	'attr' => array(
			
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			'bajada' => array(
    			'title' => 'Bajada',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Bajada',
    		),
			'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Enter the Anchor Text',
    		),
			'cuerpo' => array(
    			'title' => 'Campo',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	
	'ppb_module_header_full' => array(
    	'title' =>  '(-P-) Encabezado: título y bajada',
    	'attr' => array(
			
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
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
	'ppb_module_tramites' => array(
    	'title' =>  '(-P-) Todos los tramites',
    	'attr' => array(
			
			'subtitulo' => array(
    			'title' => 'Subtitulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Sub Title',
    		),
			'seccion_1_icono' => array(
    			'title' => '1 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_1_text' => array(
    			'title' => '1 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_1_url' => array(
    			'title' => '1 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_2_icono' => array(
    			'title' => '2 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_2_text' => array(
    			'title' => '2 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_2_url' => array(
    			'title' => '2 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_3_icono' => array(
    			'title' => '3 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_3_text' => array(
    			'title' => '3 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_3_url' => array(
    			'title' => '3 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_4_icono' => array(
    			'title' => '4 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_4_text' => array(
    			'title' => '4 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_4_url' => array(
    			'title' => '4 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_5_icono' => array(
    			'title' => '5 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_5_text' => array(
    			'title' => '5 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_5_url' => array(
    			'title' => '5 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
			'seccion_6_icono' => array(
    			'title' => '6 Icono',
    			'type' => 'file',
    			'desc' => 'Upload icon you want to display for this content',
    		),
			'seccion_6_text' => array(
    			'title' => '6 Texto',
				'type' => 'text',
    			'desc' => 'Enter text Button',
    		),
			'seccion_6_url' => array(
    			'title' => '6 URL',
				'type' => 'text',
    			'desc' => 'Enter URL Button',
    		),
			
    	),
    	'desc' => array(),
    	'content' => false
    ),
	
	'ppb_module_blog_titular_nota_3' => array(
    	'title' =>  '(S) BLOG Títular / Notas x 3',
    	'attr' => array(
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			'show_items' => array(
    			'type' => 'text',
    			'desc' => 'Enter the number of articles to show',
    		),
			'hubspot_topics' => array(
    			'title' => 'HubSpot Topics',
    			'type' => 'select',
    			'options' => $topics_select,
    			'desc' => 'Select the Topic you want to display on post results',
    		),
    	),
    	'desc' => array(),
    	'content' => false
    ),
	
	'ppb_module_titular_bajada_subtitulo_copete_subtitulo_c1_subtitulo_c2' => array(
    	'title' =>  '(S) Titular / Bajada + subtitulo + Copete / subtitulo 1 y cuerpo 1 + subtitulo 2 y cuerpo 2',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short Bajada.',
    		),
			'subtitulo' => array(
    			'title' => 'subtitulo',
				'type' => 'text',
    			'desc' => 'Enter short Subtitle.',
    		),
			'copete' => array(
    			'title' => 'copete',
				'type' => 'text',
    			'desc' => 'Enter short Copete.',
    		),
			'subtitulo_1' => array(
    			'title' => 'Subtitulo 1',
				'type' => 'text',
    			'desc' => 'Enter short description.',
    		),
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'subtitulo_2' => array(
    			'title' => 'Subtitulo 2',
				'type' => 'text',
    			'desc' => 'Enter short description.',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_recuadro_1_recuadro_1_grey' => array(
    	'title' =>  '(S) Titular / recuadro 1 + recuadro 2 / gris',
    	'attr' => array(
			
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
			
			'recuadro_1' => array(
    			'title' => 'Recuadro 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for the title of box 1',
    		),
			'recuadro_2' => array(
    			'title' => 'Recuadro 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for the title of box 2',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_cta_2' => array(
    	'title' =>  '(S) títular y bajada / CTA x2',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short Bajada.',
    		),
			
			'cta_1_imagen' => array(
    			'title' => 'CTA 1 - Imagen',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display on CTA Nº 1',
    		),
			'cta_1_titulo' => array(
    			'title' => 'CTA 1 - Titulo',
				'type' => 'text',
    			'desc' => 'Enter the text for the title of CTA 1',
    		),
			'cta_1_detalle' => array(
    			'title' => 'CTA 1 - Detalle',
				'type' => 'text',
    			'desc' => 'Enter the text for CTA 1',
    		),
			'cta_1_url' => array(
    			'title' => 'CTA 1 - URL',
				'type' => 'text',
    			'desc' => 'Enter the URL.',
    		),
			'cta_1_texto' => array(
    			'title' => 'CTA 1 - URL Texto',
				'type' => 'text',
    			'desc' => 'Enter the Text Button.',
    		),
			'cta_1_use_cta' => array(
    			'title' => 'CTA 1 - Usar CTA de HubSpot',
    			'type' => 'select',
    			'options' => $cta_select_2,
    			'desc' => 'Select use CTA if you want to show HubSpot CTA',
    		),
			'cta_1_code' => array(
    			'title' => 'CTA 1 - Código de HubsPot',
				'type' => 'html',
    			'desc' => 'Enter the HubSpot CTA code',
    		),
			
			'cta_2_imagen' => array(
    			'title' => 'CTA 2 - Imagen',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display on CTA Nº 2',
    		),
			'cta_2_titulo' => array(
    			'title' => 'CTA 2 - Titulo',
				'type' => 'text',
    			'desc' => 'Enter the text for the title of CTA',
    		),
			'cta_2_detalle' => array(
    			'title' => 'CTA 2 - Detalle',
				'type' => 'text',
    			'desc' => 'Enter the text for CTA',
    		),
			'cta_2_url' => array(
    			'title' => 'CTA 2 - URL',
				'type' => 'text',
    			'desc' => 'Enter the URL.',
    		),
			'cta_2_texto' => array(
    			'title' => 'CTA 2 - URL Texto',
				'type' => 'text',
    			'desc' => 'Enter the Text Button.',
    		),
			'cta_2_use_cta' => array(
    			'title' => 'CTA 2 - Usar CTA de HubSpot',
    			'type' => 'select',
    			'options' => $cta_select_2,
    			'desc' => 'Select use CTA if you want to show HubSpot CTA',
    		),
			'cta_2_code' => array(
    			'title' => 'CTA 2 - Código de HubsPot',
				'type' => 'html',
    			'desc' => 'Enter the HubSpot CTA code',
    		),
			
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	
	'ppb_header_module_mapa_sube' => array(
    	'title' =>  '(S) títular y bajada / mapa',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short Bajada.',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	
	'ppb_module_cta_imagen_texto_boton' => array(
    	'title' =>  '(S) CTA imagen + texto y boton',
    	'attr' => array(
			
			'cta_titulo' => array(
    			'title' => 'Titulo',
				'type' => 'text',
    			'desc' => 'Enter the text for the title of CTA',
    		),
			'cta_bajada' => array(
    			'title' => 'Bajada',
				'type' => 'text',
    			'desc' => 'Enter the text for the Bajada of CTA',
    		),
			'cta_lineas' => array(
    			'title' => 'Lineas del titulo',
    			'type' => 'select',
    			'options' => $cta_select_lines,
    			'desc' => 'Select the number of lines on the title',
    		),
			'cta_imagen' => array(
    			'title' => 'Imagen',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display',
    		),
			'cta_url' => array(
    			'title' => 'URL',
				'type' => 'text',
    			'desc' => 'Enter the URL.',
    		),
			'cta_boton_text' => array(
    			'title' => 'Texto del boton ',
				'type' => 'text',
    			'desc' => 'Enter the text for the button.',
    		),
			'cta_use_cta' => array(
    			'title' => 'Usar CTA de HubSpot',
    			'type' => 'select',
    			'options' => $cta_select_2,
    			'desc' => 'Select use CTA if you want to show HubSpot CTA',
    		),
			'cta_code' => array(
    			'title' => 'CTA - Código de HubsPot',
				'type' => 'html',
    			'desc' => 'Enter the HubSpot CTA code',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_full_c3' => array(
    	'title' =>  '(S) Titular y bajada / cuerpo x 3',
    	'attr' => array(
			
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
			
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			'cuerpo_3' => array(
    			'title' => 'Campo 3',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 3',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_imagen_torta_bajada' => array(
    	'title' =>  '(S) imagen + torta% + bajada',
    	'attr' => array(
			
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
			'imagen' => array(
    			'title' => 'Imagen',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display',
    		),
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter the text for the title of CTA',
    		),
			
			'valor' => array(
    			'title' => 'Valor',
				'type' => 'text',
    			'desc' => 'Enter the Valor to display.',
    		),
			'detail' => array(
    			'title' => 'Detail',
				'type' => 'text',
    			'desc' => 'Enter the Detail to display.',
    		),
			
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_cta_100_imagen_cuerpo_boton' => array(
    	'title' =>  '(S) CTA 100% / imgen fondo /cuerpo y boton',
    	'attr' => array(
    		'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Enter the Anchor Text',
    		),
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			'cta_url' => array(
    			'title' => 'URL',
				'type' => 'text',
    			'desc' => 'Enter the URL.',
    		),
			'cta_texto' => array(
    			'title' => 'Texto Boton',
				'type' => 'text',
    			'desc' => 'Enter the Text Button.',
    		),
			'cta_use_cta' => array(
    			'title' => 'Usar CTA de HubSpot',
    			'type' => 'select',
    			'options' => $cta_select_2,
    			'desc' => 'Select use CTA if you want to show HubSpot CTA',
    		),
			'cta_code' => array(
    			'title' => 'Código de HubsPot',
				'type' => 'html',
    			'desc' => 'Enter the HubSpot CTA code',
    		),
    		'background' => array(
    			'title' => 'Background Image',
    			'type' => 'file',
    			'desc' => 'Upload background image you want to display for this content',
    		),
    		'background_parallax' => array(
    			'title' => 'Background Parallax Option',
    			'type' => 'select',
    			'options' => $parallax_select,
    			'desc' => 'You can choose parallax type for this content background. Select none to disable parallax',
    		),
    		
    	),
    	'desc' => array(),
    	'content' => false
    ),
	'ppb_cta_imagen_cuerpo_boton' => array(
    	'title' =>  '(S) CTA 100% Grilla / imgen fondo / cuerpo y boton',
    	'attr' => array(
    		'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Enter the Anchor Text',
    		),
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			'cta_url' => array(
    			'title' => 'URL',
				'type' => 'text',
    			'desc' => 'Enter the URL.',
    		),
			'cta_texto' => array(
    			'title' => 'Texto Boton',
				'type' => 'text',
    			'desc' => 'Enter the Text Button.',
    		),
			'cta_use_cta' => array(
    			'title' => 'Usar CTA de HubSpot',
    			'type' => 'select',
    			'options' => $cta_select_2,
    			'desc' => 'Select use CTA if you want to show HubSpot CTA',
    		),
			'cta_code' => array(
    			'title' => 'Código de HubsPot',
				'type' => 'html',
    			'desc' => 'Enter the HubSpot CTA code',
    		),
    		'background' => array(
    			'title' => 'Background Image',
    			'type' => 'file',
    			'desc' => 'Upload background image you want to display for this content',
    		),
    		'background_parallax' => array(
    			'title' => 'Background Parallax Option',
    			'type' => 'select',
    			'options' => $parallax_select,
    			'desc' => 'You can choose parallax type for this content background. Select none to disable parallax',
    		),
    		
    	),
    	'desc' => array(),
    	'content' => false
    ),	
	'ppb_module_grilla_imagen_6' => array(
    	'title' =>  '(S) Grilla imagen x 6',
    	'attr' => array(
			
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Enter the Anchor Text',
    		),
			'titulo_1' => array(
    			'title' => 'Titulo Imagen 1',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title into the Imagen 1',
    		),
			'imagen_1' => array(
    			'title' => 'Imagen 1',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display for this content',
    		),
			'titulo_2' => array(
    			'title' => 'Titulo Imagen 2',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title into the Imagen 2',
    		),
			'imagen_2' => array(
    			'title' => 'Imagen 2',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display for this content',
    		),
			'titulo_3' => array(
    			'title' => 'Titulo Imagen 3',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title into the Imagen 3',
    		),
			'imagen_3' => array(
    			'title' => 'Imagen 3',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display for this content',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_full_c3_grey' => array(
    	'title' =>  '(S) Titular y bajada / cuerpo x 3 (Gris)',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
			'numero_1' => array(
    			'title' => 'Numero 1',
				'type' => 'text',
    			'desc' => 'Enter the Number for Column 1',
    		),
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'numero_2' => array(
    			'title' => 'Numero 2',
				'type' => 'text',
    			'desc' => 'Enter the Number for Column 2',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			'numero_3' => array(
    			'title' => 'Numero 3',
				'type' => 'text',
    			'desc' => 'Enter the Number for Column 3',
    		),
			'cuerpo_3' => array(
    			'title' => 'Campo 3',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 3',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_full_c3_titulo_bajada' => array(
    	'title' =>  '(S) títular / grilla de cuerpos x 3',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			
			'titulo_1' => array(
    			'title' => 'Titulo 1',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 1',
    		),
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'titulo_2' => array(
    			'title' => 'Numero 2',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 2',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			'titulo_3' => array(
    			'title' => 'Numero 3',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 3',
    		),
			'cuerpo_3' => array(
    			'title' => 'Campo 3',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 3',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_full_c4_titulo_bajada' => array(
    	'title' =>  '(S) títular / grilla de cuerpos x Nº',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			'column_number' => array(
    			'title' => 'Numero de columnas',
    			'type' => 'select',
    			'options' => $column_numbers_select,
    			'desc' => 'Select the number of te column to show',
    		),
			
			'titulo_1' => array(
    			'title' => 'Titulo 1',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 1',
    		),
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'titulo_2' => array(
    			'title' => 'Titulo 2',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 2',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			'titulo_3' => array(
    			'title' => 'Titulo 3',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 3',
    		),
			'cuerpo_3' => array(
    			'title' => 'Campo 3',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 3',
    		),
			'titulo_4' => array(
    			'title' => 'Titulo 4',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 4',
    		),
			'cuerpo_4' => array(
    			'title' => 'Campo 4',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 4',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_full_box_image_bajada' => array(
    	'title' =>  '(S) títular y bajada / box imagen texto x Nº',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			'column_number' => array(
    			'title' => 'Numero de columnas',
    			'type' => 'select',
    			'options' => $column_numbers_select,
    			'desc' => 'Select the number of te column to show',
    		),
			
			'imagen_1' => array(
    			'title' => 'Imagen 1',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display in to the Column 1',
    		),
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'imagen_2' => array(
    			'title' => 'Imagen 2',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display in to the Column 2',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			'imagen_3' => array(
    			'title' => 'Imagen 3',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display in to the Column 3',
    		),
			'cuerpo_3' => array(
    			'title' => 'Campo 3',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 3',
    		),
			'imagen_4' => array(
    			'title' => 'Imagen 4',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display in to the Column 4',
    		),
			'cuerpo_4' => array(
    			'title' => 'Campo 4',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 4',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_imagen_formulario' => array(
    	'title' =>  '(S) imagen + formulario',
    	'attr' => array(
			
			'titulo' => array(
    			'title' => 'Titulo',
				'type' => 'text',
    			'desc' => 'Enter the text for the title of CTA',
    		),
			'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Enter the Anchor Text',
    		),
			'imagen' => array(
    			'title' => 'Imagen',
    			'type' => 'file',
    			'desc' => 'Upload the image you want to display',
    		),
			'cta_code' => array(
    			'title' => 'Código de HubsPot',
				'type' => 'html',
    			'desc' => 'Enter the HubSpot code',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_peoplesocial' => array(
    	'title' =>  '(S) Personas Redes Social',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			'column_number' => array(
    			'title' => 'Numero de columnas',
    			'type' => 'select',
    			'options' => $column_numbers_select,
    			'desc' => 'Select the number of te column to show',
    		),
			
			
			'nombre_1' => array(
    			'title' => 'Nombre 1',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column',
    		),
			'thumbnail_1' => array(
    			'title' => 'Foto 1',
    			'type' => 'file',
    			'desc' => 'Upload image you want to display for this content',
    		),
			'facebook_1' => array(
    			'title' => 'URL Facebook 1',
				'type' => 'text',
    			'desc' => 'Enter the URL for Facebook Profile',
    		),
			'twitter_1' => array(
    			'title' => 'URL Twitter 1',
				'type' => 'text',
    			'desc' => 'Enter the URL for Twitter Profile',
    		),
			'linkedin_1' => array(
    			'title' => 'URL Linkedin 1',
				'type' => 'text',
    			'desc' => 'Enter the URL for Linkedin Profile',
    		),
			'instagram_1' => array(
    			'title' => 'URL Instagram 1',
				'type' => 'text',
    			'desc' => 'Enter the URL for Instagram Profile',
    		),
			
			
			'nombre_2' => array(
    			'title' => 'Nombre 2',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column',
    		),
			'thumbnail_2' => array(
    			'title' => 'Foto 2',
    			'type' => 'file',
    			'desc' => 'Upload image you want to display for this content',
    		),
			'facebook_2' => array(
    			'title' => 'URL Facebook 2',
				'type' => 'text',
    			'desc' => 'Enter the URL for Facebook Profile',
    		),
			'twitter_2' => array(
    			'title' => 'URL Twitter 2',
				'type' => 'text',
    			'desc' => 'Enter the URL for Twitter Profile',
    		),
			'linkedin_2' => array(
    			'title' => 'URL Linkedin 2',
				'type' => 'text',
    			'desc' => 'Enter the URL for Linkedin Profile',
    		),
			'instagram_2' => array(
    			'title' => 'URL Instagram 2',
				'type' => 'text',
    			'desc' => 'Enter the URL for Instagram Profile',
    		),
			
			
			'nombre_3' => array(
    			'title' => 'Nombre 3',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column',
    		),
			'thumbnail_3' => array(
    			'title' => 'Foto 3',
    			'type' => 'file',
    			'desc' => 'Upload image you want to display for this content',
    		),
			'facebook_3' => array(
    			'title' => 'URL Facebook 3',
				'type' => 'text',
    			'desc' => 'Enter the URL for Facebook Profile',
    		),
			'twitter_3' => array(
    			'title' => 'URL Twitter 3',
				'type' => 'text',
    			'desc' => 'Enter the URL for Twitter Profile',
    		),
			'linkedin_3' => array(
    			'title' => 'URL Linkedin 3',
				'type' => 'text',
    			'desc' => 'Enter the URL for Linkedin Profile',
    		),
			'instagram_3' => array(
    			'title' => 'URL Instagram 3',
				'type' => 'text',
    			'desc' => 'Enter the URL for Instagram Profile',
    		),
			
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),
	'ppb_module_titular_bajada_full_c4_titulo_imagen_bajada' => array(
    	'title' =>  '(S) títular / grilla de cuerpos + imagen x Nº',
    	'attr' => array(
			
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
			'bajada' => array(
    			'title' => 'Bajada',
				'type' => 'textarea',
    			'desc' => 'Enter short description. It displays under the title',
    		),
			'column_number' => array(
    			'title' => 'Numero de columnas',
    			'type' => 'select',
    			'options' => $column_numbers_select,
    			'desc' => 'Select the number of te column to show',
    		),
			
			'titulo_1' => array(
    			'title' => 'Titulo 1',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 1',
    		),
			'foto_1' => array(
    			'title' => 'Foto 1',
    			'type' => 'file',
    			'desc' => 'Upload image you want to display for this content',
    		),
			'cuerpo_1' => array(
    			'title' => 'Campo 1',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 1',
    		),
			'titulo_2' => array(
    			'title' => 'Titulo 2',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 2',
    		),
			'foto_2' => array(
    			'title' => 'Foto 2',
    			'type' => 'file',
    			'desc' => 'Upload image you want to display for this content',
    		),
			'cuerpo_2' => array(
    			'title' => 'Campo 2',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 2',
    		),
			'titulo_3' => array(
    			'title' => 'Titulo 3',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 3',
    		),
			'foto_3' => array(
    			'title' => 'Foto 3',
    			'type' => 'file',
    			'desc' => 'Upload image you want to display for this content',
    		),
			'cuerpo_3' => array(
    			'title' => 'Campo 3',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 3',
    		),
			'titulo_4' => array(
    			'title' => 'Titulo 4',
				'type' => 'text',
    			'desc' => 'Enter the Titulo for Column 4',
    		),
			'foto_4' => array(
    			'title' => 'Foto 4',
    			'type' => 'file',
    			'desc' => 'Upload image you want to display for this content',
    		),
			'cuerpo_4' => array(
    			'title' => 'Campo 4',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column 4',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    ),


/*-----------------------------------------------------------------------*/
/*---------------------------- WORK AREA { ------------------------------*/
/*-----------------------------------------------------------------------*/
	
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
	
/*-----------------------------------------------------------------------*/
/*---------------------------- } WORK AREA ------------------------------*/
/*-----------------------------------------------------------------------*/
	
	'ppb_modulecontact' => array(
    	'title' =>  '• Contactos',
    	'attr' => array(
    		'layout' => array(
    			'title' => 'Layout',
    			'type' => 'select',
    			'options' => $contacto_layout_select,
    			'desc' => 'Select layout you want to display',
    		),
			'contact_disposition' => array(
    			'title' => 'Dispocición del texto y imagen',
    			'type' => 'select',
				'options' => $dispocicion_layout_select,
    			'desc' => 'Selecciones si el texto se mostrara a la derecha o izquierda',
    		),
			'contact_phrase' => array(
    			'title' => 'Frase',
    			'type' => 'text',
    			'desc' => 'Ingrese texto a mostrar',
    		),
			'contact_cta_text' => array(
				'title' => 'CTA Botón',
    			'type' => 'text',
    			'desc' => 'Ingrese el texto del boton',
    		),
			'contact_cta_url' => array(
				'title' => 'CTA URL',
    			'type' => 'text',
    			'desc' => 'Ingrese la URL destino del boton',
    		),
			'contact_image' => array(
    			'title' => 'Image',
    			'type' => 'file',
    			'desc' => 'Cargue la imagen que se mostrará',
    		),
    		'custom_css' => array(
    			'title' => 'Custom CSS',
    			'type' => 'text',
    			'desc' => 'You can add custom CSS style for this block (advanced user only)',
    		),
			'custom_class' => array(
    			'title' => 'Custom CLASS',
    			'type' => 'text',
    			'desc' => 'You can add custom CLASS style for this block (advanced user only)',
    		),
    	),
    	'desc' => array(),
    	'content' => TRUE
    ),
	/* } THISNEW MRG */
	
);

//Check if Layer slider is installed	
$revslider = ABSPATH . '/wp-content/plugins/revslider/revslider.php';

// Check if the file is available to prevent warnings
$pp_revslider_activated = file_exists($revslider);

if($pp_revslider_activated)
{
	//Get WPDB Object
	global $wpdb;
	
	// Get Rev Sliders
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$is_revslider_active = is_plugin_active('revslider/revslider.php');
	$wp_revsliders = array();
	
	if($is_revslider_active)
	{
		$wp_revsliders = array(
			-1		=> "Choose a slide",
		);
		$revslider_objs = new RevSlider();
		$revslider_obj_arr = $revslider_objs->getArrSliders();
		
		foreach($revslider_obj_arr as $revslider_obj)
		{
			$wp_revsliders[$revslider_obj->getAlias()] = $revslider_obj->getTitle();
		}
	}
	
	$ppb_shortcodes['ppb_revslider'] = array(
    	'title' =>  'Revolution Slider',
    	'attr' => array(
    		'slider_id' => array(
    			'title' => 'Select Slider to display',
    			'type' => 'select',
    			'options' => $wp_revsliders,
    			'desc' => 'Choose which revolution slider to display (if it\'s empty. You need to create a revolution slider first.)',
    		),
    	),
    	'desc' => array(),
    	'content' => FALSE
    );
}





$ppb_shortcodes['ppb_add_shortcode'] = array(
	'title' =>  'Titular y shortcode',
    	'attr' => array(
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Ingrese el texto para mostrar como Titulo',
    		),
			'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Ingrese el texto del ancla',
    		),			
			'clases' => array(
    			'title' => 'Clases',
    			'type' => 'text',
    			'desc' => 'Clases para esta sección',
    		),	
			'contenido' => array(
    			'title' => 'Texto',
				'type' => 'textarea',
    			'desc' => 'Ingrese contenido (irá antes de shortcode)',
    		),	
			'shortcode' => array(
    			'title' => 'Contenido',
				'type' => 'text',
    			'desc' => 'Ingrese shortcode sin los [ ]',
    		),						
    	),
    	'desc' => array(),
    	'content' => false
    

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
		
		//$data[$cat["id"]] = array("name" => $cat["name"], "link" => $cat["link"]);
		//$categories_select[$cat['id']] = $cat["name"]; //expected format
		$categories_select[$the_cat_id] = $the_cat_name; //expected format
	}	
}




$ppb_shortcodes['ppb_blog_latest_posts'] = array(
	'title' =>  'BLOG (nuevo) Títular / Notas x 3',
    'attr' => array(
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Ingrese el texto para mostrar como Titulo',
    		),
			/*
			'show_items' => array(
    			'type' => 'text',
    			'desc' => 'Enter the number of articles to show',
    		),
			*/
			'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Ingrese el texto del ancla',
    		),			
			'selected_category' => array(
    			'title' => 'Categoría',
    			'type' => 'select',
    			'options' => $categories_select,
    			'desc' => 'Seleccionar la categoría para filtrar los posts',
    		),	
    	'desc' => array(),
    	'content' => false
    )

	 );
	 
 $ppb_shortcodes['ppb_lista_centros_salud'] = array(
	'title' =>  'Titular y lista Centros de Salud',
    	'attr' => array(
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Ingrese el texto para mostrar como Titulo',
    		)	,
			'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Ingrese el texto del ancla',
    		),			
			'contenido' => array(
    			'title' => 'Texto',
				'type' => 'textarea',
    			'desc' => 'Ingrese contenido (irá antes del listado)',
    		),	
			
    	),
    	'desc' => array(),
    	'content' => false
    );	 
	 
	 
	 
	 
	 
 $ppb_shortcodes['ppb_module_titular_cuerpo_nlb'] = array(
    	'title' =>  '(S) Títular y Bajada / Cuerpo (No Linebreaks)',
    	'attr' => array(
			
			'titulo' => array(
    			'title' => 'Titulo',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Title',
    		),
			'bajada' => array(
    			'title' => 'Bajada',
    			'type' => 'text',
    			'desc' => 'Enter the Text you want to display of Bajada',
    		),
			'ancla' => array(
    			'title' => 'Ancla',
    			'type' => 'text',
    			'desc' => 'Enter the Anchor Text',
    		),
			'cuerpo' => array(
    			'title' => 'Campo',
				'type' => 'textarea',
    			'desc' => 'Enter the text for Column',
    		),
			
    	),
    	'desc' => array(),
    	'content' => FALSE
    );
	 
	 
	 
	 

ksort($ppb_shortcodes);
?>