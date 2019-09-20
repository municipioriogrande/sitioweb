<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function post_type_galleries() {
	$labels = array(
    	'name' => _x('Galleries', 'post type general name', THEMEDOMAIN),
    	'singular_name' => _x('Gallery', 'post type singular name', THEMEDOMAIN),
    	'add_new' => _x('Add New Gallery', 'book', THEMEDOMAIN),
    	'add_new_item' => __('Add New Gallery', THEMEDOMAIN),
    	'edit_item' => __('Edit Gallery', THEMEDOMAIN),
    	'new_item' => __('New Gallery', THEMEDOMAIN),
    	'view_item' => __('View Gallery', THEMEDOMAIN),
    	'search_items' => __('Search Gallery', THEMEDOMAIN),
    	'not_found' =>  __('No Gallery found', THEMEDOMAIN),
    	'not_found_in_trash' => __('No Gallery found in Trash', THEMEDOMAIN), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor', 'thumbnail', 'excerpt'),
    	'menu_icon' => get_template_directory_uri().'/functions/images/sign.png'
	); 		

	register_post_type( 'galleries', $args );
	
  	/*$labels = array(			  
  	  'name' => _x( 'Gallery Categories', 'taxonomy general name', THEMEDOMAIN ),
  	  'singular_name' => _x( 'Gallery Category', 'taxonomy singular name', THEMEDOMAIN ),
  	  'search_items' =>  __( 'Search Gallery Categories', THEMEDOMAIN ),
  	  'all_items' => __( 'All Gallery Categories', THEMEDOMAIN ),
  	  'parent_item' => __( 'Parent Gallery Category', THEMEDOMAIN ),
  	  'parent_item_colon' => __( 'Parent Gallery Category:', THEMEDOMAIN ),
  	  'edit_item' => __( 'Edit Gallery Category', THEMEDOMAIN ), 
  	  'update_item' => __( 'Update Gallery Category', THEMEDOMAIN ),
  	  'add_new_item' => __( 'Add New Gallery Category', THEMEDOMAIN ),
  	  'new_item_name' => __( 'New Gallery Category Name', THEMEDOMAIN ),
  	); 							  
  	
  	register_taxonomy(
		'gallerycat',
		'galleries',
		array(
			'public'=>true,
			'hierarchical' => true,
			'labels'=> $labels,
			'query_var' => 'gallerycat',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'gallerycat', 'with_front' => false ),
		)
	);*/  
} 
								  
add_action('init', 'post_type_galleries');

function post_type_slider() {
	$labels = array(
    	'name' => _x('Sliders', 'post type general name', THEMEDOMAIN),
    	'singular_name' => _x('Slider', 'post type singular name', THEMEDOMAIN),
    	'add_new' => _x('Add New Slider', 'book', THEMEDOMAIN),
    	'add_new_item' => __('Add New Slider', THEMEDOMAIN),
    	'edit_item' => __('Edit Slider', THEMEDOMAIN),
    	'new_item' => __('New Slider', THEMEDOMAIN),
    	'view_item' => __('View Slider', THEMEDOMAIN),
    	'search_items' => __('Search Slider', THEMEDOMAIN),
    	'not_found' =>  __('No Slider found', THEMEDOMAIN),
    	'not_found_in_trash' => __('No Slider found in Trash', THEMEDOMAIN), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor', 'thumbnail', 'excerpt'),
		 'menu_icon' => get_template_directory_uri().'/functions/images/sign.png',
		 'taxonomies' => array('post_tag')
	); 		

	register_post_type( 'slider', $args );
	
	$labels = array(			  
  	  'name' => _x( 'Slider Categories', 'taxonomy general name', THEMEDOMAIN ),
  	  'singular_name' => _x( 'Slider Category', 'taxonomy singular name', THEMEDOMAIN ),
  	  'search_items' =>  __( 'Search Slider Categories', THEMEDOMAIN ),
  	  'all_items' => __( 'All Slider Categories', THEMEDOMAIN ),
  	  'parent_item' => __( 'Parent Slider Category', THEMEDOMAIN ),
  	  'parent_item_colon' => __( 'Parent Slider Category:', THEMEDOMAIN ),
  	  'edit_item' => __( 'Edit Slider Category', THEMEDOMAIN ), 
  	  'update_item' => __( 'Update Slider Category', THEMEDOMAIN ),
  	  'add_new_item' => __( 'Add New Slider Category', THEMEDOMAIN ),
  	  'new_item_name' => __( 'New Slider Category Name', THEMEDOMAIN ),
  	); 							  
  	
  	register_taxonomy(
		'sliders',
		'slider',
		array(
			'public'=>true,
			'hierarchical' => true,
			'labels'=> $labels,
			'query_var' => 'sliders',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'sliders', 'with_front' => false ),
		)
	);	
} 
								  
add_action('init', 'post_type_slider');

add_action( 'carbon_fields_register_fields', 'crb_attach_post_meta_slider' );
function crb_attach_post_meta_slider() {

	Container::make( 'post_meta', __( 'Botón', 'crb' ) )
        ->where( 'post_type', '=', 'slider' )
        ->set_context( 'carbon_fields_after_title' )
        ->add_fields( array(

				Field::make( 'checkbox', 'mrg_slider_btn_show', __( '¿Mostrar botón?' ) )
					->set_option_value( 'no' )
				,
				Field::make( 'text', 'mrg_slider_btn_url', 'URL' )
					->set_attribute( 'type', 'url' )
					->set_width (50)

					->set_conditional_logic( array(
						'relation' => 'AND', // Optional, defaults to "AND"
						array(
							 'field' => 'mrg_slider_btn_show',
							 'value' => true,
						)
				  ) )

				,
				Field::make( 'text', 'mrg_slider_btn_text', 'Texto' )
					->set_attribute( 'type', 'text' )
					->set_width (50)

					->set_conditional_logic( array(
						'relation' => 'AND', // Optional, defaults to "AND"
						array(
							 'field' => 'mrg_slider_btn_show',
							 'value' => true,
						)
				  ) )

			) );
}









/* THISNEW MRG { */

function post_type_sube() {
	$labels = array(
    	'name' => _x('Puntos Sube', 'post type general name', THEMEDOMAIN),
    	'singular_name' => _x('Punto Sube', 'post type singular name', THEMEDOMAIN),
    	'add_new' => _x('Add New Punto Sube', 'book', THEMEDOMAIN),
    	'add_new_item' => __('Add New Punto Sube', THEMEDOMAIN),
    	'edit_item' => __('Edit Punto Sube', THEMEDOMAIN),
    	'new_item' => __('New Punto Sube', THEMEDOMAIN),
    	'view_item' => __('View Punto Sube', THEMEDOMAIN),
    	'search_items' => __('Search Punto Sube', THEMEDOMAIN),
    	'not_found' =>  __('No Punto Sube found', THEMEDOMAIN),
    	'not_found_in_trash' => __('No Punto Sube found in Trash', THEMEDOMAIN), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title','editor'),
    	'menu_icon' => get_template_directory_uri().'/functions/images/sign.png'
	); 		

	register_post_type( 'sube', $args );
} 
								  
add_action('init', 'post_type_sube');

/*function post_type_destacados() {
	$labels = array(
    	'name' => _x('-> Destacados', 'post type general name', THEMEDOMAIN),
    	'singular_name' => _x('--Destacado', 'post type singular name', THEMEDOMAIN),
    	'add_new' => _x('Add Destacado', 'book', THEMEDOMAIN),
    	'add_new_item' => __('Add Destacado', THEMEDOMAIN),
    	'edit_item' => __('Edit Destacado', THEMEDOMAIN),
    	'new_item' => __('New Destacado', THEMEDOMAIN),
    	'view_item' => __('View Destacado', THEMEDOMAIN),
    	'search_items' => __('Search Destacado', THEMEDOMAIN),
    	'not_found' =>  __('No found Destacados', THEMEDOMAIN),
    	'not_found_in_trash' => __('No found Destacados en la Papelera', THEMEDOMAIN), 
    	'parent_item_colon' => ''
	);		
	$args = array(
    	'labels' => $labels,
    	'public' => true,
    	'publicly_queryable' => true,
    	'show_ui' => true, 
    	'query_var' => true,
    	'rewrite' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => null,
    	'supports' => array('title', 'editor', 'thumbnail'),
    	'menu_icon' => get_template_directory_uri().'/functions/images/sign.png'
	); 		

	register_post_type( 'destacados', $args );
	
	/*$labels = array(			  
  	  'name' => _x( 'Destacados Categories', 'taxonomy general name', THEMEDOMAIN ),
  	  'singular_name' => _x( 'Destacado Category', 'taxonomy singular name', THEMEDOMAIN ),
  	  'search_items' =>  __( 'Search Destacado Category', THEMEDOMAIN ),
  	  'all_items' => __( 'All Destacados Categories', THEMEDOMAIN ),
  	  'parent_item' => __( 'Parent Destacados Categories', THEMEDOMAIN ),
  	  'parent_item_colon' => __( 'Parent Destacados Categories:', THEMEDOMAIN ),
  	  'edit_item' => __( 'Edit Destacados Categories', THEMEDOMAIN ), 
  	  'update_item' => __( 'Update Destacados Categories', THEMEDOMAIN ),
  	  'add_new_item' => __( 'Add new Destacados Categories ', THEMEDOMAIN ),
  	  'new_item_name' => __( 'Add new Destacados Name Categories', THEMEDOMAIN ),
  	); 							  
  	
  	register_taxonomy(
		'destacadocats',
		'destacados',
		array(
			'public'=>true,
			'hierarchical' => true,
			'labels'=> $labels,
			'query_var' => 'destacadocats',
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'destacadocats', 'with_front' => false ),
		)
	);*/  
/*}
add_action('init', 'post_type_destacados');
/* } THISNEW MRG */

add_filter( 'manage_posts_columns', 'rt_add_gravatar_col');
function rt_add_gravatar_col($cols) {
	$cols['thumbnail'] = __('Thumbnail', THEMEDOMAIN);
	return $cols;
}

add_action( 'manage_posts_custom_column', 'rt_get_author_gravatar');
function rt_get_author_gravatar($column_name ) {
	if ( $column_name  == 'thumbnail'  ) {
		echo get_the_post_thumbnail(get_the_ID(), array(100, 100));
	}
}

/*
	Get gallery list
*/
$args = array(
    'numberposts' => -1,
    'post_type' => array('galleries'),
);

$galleries_arr = get_posts($args);
$galleries_select = array();
$galleries_select['(Display Post Featured Image)'] = '';
$galleries_select['(Hide Post Featured Image)'] = -1;

foreach($galleries_arr as $gallery)
{
	$galleries_select[$gallery->post_title] = $gallery->ID;
}

/*
	Get post layouts
*/
$post_layout_select = array();
$post_layout_select = array(
	'With Right Sidebar' => 'With Right Sidebar',
	'With Left Sidebar' => 'With Left Sidebar',
	'Fullwidth' => 'Fullwidth',
);

//Get all sidebars
$theme_sidebar = array(
	'' => '',
	'Page Sidebar' => 'Page Sidebar', 
	'Contact Sidebar' => 'Contact Sidebar', 
	'Blog Sidebar' => 'Blog Sidebar',
);

$dynamic_sidebar = get_option('pp_sidebar');

if(!empty($dynamic_sidebar))
{
	foreach($dynamic_sidebar as $sidebar)
	{
		$theme_sidebar[$sidebar] = $sidebar;
	}
}

/*
	Begin creating custom fields
*/

/* THISNEW MRG { */
/*
	Get post layouts
*/
$post_paises_select = array(
	'Afghanistan' => 'Afghanistan',
	'Åland Islands' => 'Åland Islands',
	'Albania' => 'Albania',
	'Algeria' => 'Algeria',
	'American Samoa' => 'American Samoa',
	'Andorra' => 'Andorra',
	'Angola' => 'Angola',
	'Anguilla' => 'Anguilla',
	'Antarctica' => 'Antarctica',
	'Antigua and Barbuda' => 'Antigua and Barbuda',
	'Argentina' => 'Argentina',
	'Armenia' => 'Armenia',
	'Aruba' => 'Aruba',
	'Australia' => 'Australia',
	'Austria' => 'Austria',
	'Azerbaijan' => 'Azerbaijan',
	'Bahamas' => 'Bahamas',
	'Bahrain' => 'Bahrain',
	'Bangladesh' => 'Bangladesh',
	'Barbados' => 'Barbados',
	'Belarus' => 'Belarus',
	'Belgium' => 'Belgium',
	'Belize' => 'Belize',
	'Benin' => 'Benin',
	'Bermuda' => 'Bermuda',
	'Bhutan' => 'Bhutan',
	'Bolivia' => 'Bolivia',
	'Bosnia and Herzegovina' => 'Bosnia and Herzegovina',
	'Botswana' => 'Botswana',
	'Bouvet Island' => 'Bouvet Island',
	'Brazil' => 'Brazil',
	'British Indian Ocean Territory' => 'British Indian Ocean Territory',
	'British, Virgin Islands' => 'British, Virgin Islands',
	'Brunei Darussalam' => 'Brunei Darussalam',
	'Bulgaria' => 'Bulgaria',
	'Burkina Faso' => 'Burkina Faso',
	'Burundi' => 'Burundi',
	'Cambodia' => 'Cambodia',
	'Cameroon' => 'Cameroon',
	'Canada' => 'Canada',
	'Cape Verde' => 'Cape Verde',
	'Cayman Islands' => 'Cayman Islands',
	'Central African Republic' => 'Central African Republic',
	'Chad' => 'Chad',
	'Chile' => 'Chile',
	'China' => 'China',
	'Christmas Island' => 'Christmas Island',
	'Cocos Keeling Islands' => 'Cocos Keeling Islands',
	'Colombia' => 'Colombia',
	'Comoros' => 'Comoros',
	'Congo' => 'Congo',
	'Cook Islands' => 'Cook Islands',
	'Costa Rica' => 'Costa Rica',
	'Côte D’Ivoire' => 'Côte D’Ivoire',
	'Croatia' => 'Croatia',
	'Cuba' => 'Cuba',
	'Cyprus' => 'Cyprus',
	'Czech Republic' => 'Czech Republic',
	'Denmark' => 'Denmark',
	'Djibouti' => 'Djibouti',
	'Dominica' => 'Dominica',
	'Dominican Republic' => 'Dominican Republic',
	'Ecuador' => 'Ecuador',
	'Egypt' => 'Egypt',
	'El Salvador' => 'El Salvador',
	'Equatorial Guinea' => 'Equatorial Guinea',
	'Eritrea' => 'Eritrea',
	'Estonia' => 'Estonia',
	'Ethiopia' => 'Ethiopia',
	'Falkland Islands (Malvinas)' => 'Falkland Islands (Malvinas)',
	'Faroe Islands' => 'Faroe Islands',
	'Fiji' => 'Fiji',
	'Finland' => 'Finland',
	'France' => 'France',
	'French Guiana' => 'French Guiana',
	'French Polynesia' => 'French Polynesia',
	'French Southern Territories' => 'French Southern Territories',
	'Gabon' => 'Gabon',
	'Gambia' => 'Gambia',
	'Georgia' => 'Georgia',
	'Germany' => 'Germany',
	'Ghana' => 'Ghana',
	'Gibraltar' => 'Gibraltar',
	'Greece' => 'Greece',
	'Greenland' => 'Greenland',
	'Grenada' => 'Grenada',
	'Guadeloupe' => 'Guadeloupe',
	'Guam' => 'Guam',
	'Guatemala' => 'Guatemala',
	'Guinea' => 'Guinea',
	'Guinea-Bissau' => 'Guinea-Bissau',
	'Guyana' => 'Guyana',
	'Haiti' => 'Haiti',
	'Heard Island and Mcdonald Islands' => 'Heard Island and Mcdonald Islands',
	'Holy See (Vatican City State)' => 'Holy See (Vatican City State)',
	'Honduras' => 'Honduras',
	'Hong Kong' => 'Hong Kong',
	'Hungary' => 'Hungary',
	'Iceland' => 'Iceland',
	'India' => 'India',
	'Indonesia' => 'Indonesia',
	'Iran, Islamic Republic of' => 'Iran, Islamic Republic of',
	'Iraq' => 'Iraq',
	'Ireland' => 'Ireland',
	'Israel' => 'Israel',
	'Italy' => 'Italy',
	'Jamaica' => 'Jamaica',
	'Japan' => 'Japan',
	'Jordan' => 'Jordan',
	'Kazakhstan' => 'Kazakhstan',
	'Kenya' => 'Kenya',
	'Kiribati' => 'Kiribati',
	'Korea North' => 'Korea North',
	'Korea South' => 'Korea South',
	'Kuwait' => 'Kuwait',
	'Kyrgyzstan' => 'Kyrgyzstan',
	'Lao' => 'Lao',
	'Latvia' => 'Latvia',
	'Lebanon' => 'Lebanon',
	'Lesotho' => 'Lesotho',
	'Liberia' => 'Liberia',
	'Libyan Arab Jamahiriya' => 'Libyan Arab Jamahiriya',
	'Liechtenstein' => 'Liechtenstein',
	'Lithuania' => 'Lithuania',
	'Luxembourg' => 'Luxembourg',
	'Macao' => 'Macao',
	'Macedonia, the Former Yugoslav Republic of' => 'Macedonia, the Former Yugoslav Republic of',
	'Madagascar' => 'Madagascar',
	'Malawi' => 'Malawi',
	'Malaysia' => 'Malaysia',
	'Maldives' => 'Maldives',
	'Mali' => 'Mali',
	'Malta' => 'Malta',
	'Marshall Islands' => 'Marshall Islands',
	'Martinique' => 'Martinique',
	'Mauritania' => 'Mauritania',
	'Mauritius' => 'Mauritius',
	'Mayotte' => 'Mayotte',
	'Mexico' => 'Mexico',
	'Micronesia, Federated States of' => 'Micronesia, Federated States of',
	'Moldova, Republic of' => 'Moldova, Republic of',
	'Monaco' => 'Monaco',
	'Mongolia' => 'Mongolia',
	'Montserrat' => 'Montserrat',
	'Morocco' => 'Morocco',
	'Mozambique' => 'Mozambique',
	'Myanmar' => 'Myanmar',
	'Namibia' => 'Namibia',
	'Nauru' => 'Nauru',
	'Nepal' => 'Nepal',
	'Netherlands' => 'Netherlands',
	'Netherlands Antilles' => 'Netherlands Antilles',
	'New Caledonia' => 'New Caledonia',
	'New Zealand' => 'New Zealand',
	'Nicaragua' => 'Nicaragua',
	'Niger' => 'Niger',
	'Nigeria' => 'Nigeria',
	'Niue' => 'Niue',
	'Norfolk Island' => 'Norfolk Island',
	'Northern Mariana Islands' => 'Northern Mariana Islands',
	'Norway' => 'Norway',
	'Oman' => 'Oman',
	'Pakistan' => 'Pakistan',
	'Palau' => 'Palau',
	'Palestinian Territory, Occupied' => 'Palestinian Territory, Occupied',
	'Panama' => 'Panama',
	'Papua New Guinea' => 'Papua New Guinea',
	'Paraguay' => 'Paraguay',
	'Peru' => 'Peru',
	'Philippines' => 'Philippines',
	'Pitcairn' => 'Pitcairn',
	'Poland' => 'Poland',
	'Portugal' => 'Portugal',
	'Puerto Rico' => 'Puerto Rico',
	'Qatar' => 'Qatar',
	'Reunion' => 'Reunion',
	'Romania' => 'Romania',
	'Russian Federation' => 'Russian Federation',
	'Rwanda' => 'Rwanda',
	'Saint Helena' => 'Saint Helena',
	'Saint Kitts and Nevis' => 'Saint Kitts and Nevis',
	'Saint Lucia' => 'Saint Lucia',
	'Saint Pierre and Miquelon' => 'Saint Pierre and Miquelon',
	'Saint Vincent and the Grenadines' => 'Saint Vincent and the Grenadines',
	'Samoa' => 'Samoa',
	'San Marino' => 'San Marino',
	'São Tomé and Príncipe' => 'São Tomé and Príncipe',
	'Saudi Arabia' => 'Saudi Arabia',
	'Senegal' => 'Senegal',
	'Serbia and Montenegro' => 'Serbia and Montenegro',
	'Seychelles' => 'Seychelles',
	'Sierra Leone' => 'Sierra Leone',
	'Singapore' => 'Singapore',
	'Slovakia' => 'Slovakia',
	'Slovenia' => 'Slovenia',
	'Solomon Islands' => 'Solomon Islands',
	'Somalia' => 'Somalia',
	'South Africa' => 'South Africa',
	'South Georgia and the South Sandwich Islands' => 'South Georgia and the South Sandwich Islands',
	'Spain' => 'Spain',
	'Sri Lanka' => 'Sri Lanka',
	'Sudan' => 'Sudan',
	'Suriname' => 'Suriname',
	'Svalbard and Jan Mayen' => 'Svalbard and Jan Mayen',
	'Swaziland' => 'Swaziland',
	'Sweden' => 'Sweden',
	'Switzerland' => 'Switzerland',
	'Syrian Arab Republic' => 'Syrian Arab Republic',
	'Tajikistan' => 'Tajikistan',
	'Tanzania' => 'Tanzania',
	'Thailand' => 'Thailand',
	'Timor-Leste' => 'Timor-Leste',
	'Togo' => 'Togo',
	'Tokelau' => 'Tokelau',
	'Tonga' => 'Tonga',
	'Trinidad and Tobago' => 'Trinidad and Tobago',
	'Tunisia' => 'Tunisia',
	'Turkey' => 'Turkey',
	'Turkmenistan' => 'Turkmenistan',
	'Turks and Caicos Islands' => 'Turks and Caicos Islands',
	'Tuvalu' => 'Tuvalu',
	'Uganda' => 'Uganda',
	'Ukraine' => 'Ukraine',
	'United Arab Emirates' => 'United Arab Emirates',
	'United Kingdom' => 'United Kingdom',
	'United States' => 'United States',
	'United States Minor Outlying Islands' => 'United States Minor Outlying Islands',
	'Uruguay' => 'Uruguay',
	'Uzbekistan' => 'Uzbekistan',
	'Vanuatu' => 'Vanuatu',
	'Venezuela' => 'Venezuela',
	'Viet Nam' => 'Viet Nam',
	'Virgin Islands, U.s.' => 'Virgin Islands, U.s.',
	'Wallis and Futuna' => 'Wallis and Futuna',
	'Western Sahara' => 'Western Sahara',
	'Yemen' => 'Yemen',
	'Zambia' => 'Zambia',
	'Zimbabwe' => 'Zimbabwe'
);
/* } THISNEW MRG */
$postmetas = 
	array (
		'post' => array(
			array("section" => "Galería", 		"id" => "post_nombre_galeria", 	"type" => "textarea", 	"title" => "Galería",                           "description" => "Introduzca el Nombre de la Galería donde se realizo/a la Exhibición"),	
			array("section" => "País del evento", 	"id" => "post_pais",		"type" => "select", 	"title" => "País donde se hace la Exhibición",  "description" => "Por favor selecciones el País donde se realizará la Exhibición", "items" => $post_paises_select),
			array("section" => "Fecha de Inicio", 	"id" => "post_start_date", 	"type" => "date", 	"title" => "Fecha Inicio de Exibición",         "description" => "Selecciones la Fecha de Inicio de la Exhibición"),
			array("section" => "Fecha de Cierre", 	"id" => "post_end_date", 	"type" => "date", 	"title" => "Fecha Cierre de Exibición",         "description" => "Selecciones la Fecha de Cierre de la Exhibición"),
		
			
			array("section" => "Content Type", "id" => "post_layout", "type" => "select", "title" => "Post Layout", "description" => "You can select layout of this single post page.", "items" => $post_layout_select),
			array(
    		"section" => "Featured Content Type", "id" => "post_ft_type", "type" => "select", "title" => "Featured Content Type", "description" => "Select featured content type for this post. Different content type will be displayed on single post page", 
				"items" => array(
					"Image" => "Image",
					"Gallery" => "Gallery",
					"Vimeo Video" => "Vimeo Video",
					"Youtube Video" => "Youtube Video",
				)),
			array("section" => "Gallery Photo", "id" => "post_ft_gallery", "type" => "select", "title" => "Gallery Photo", "description" => "Please select a gallery (*Note enter if you select \"Gallery\" as Featured Content Type))", "items" => $galleries_select),
			array("section" => "Vimeo Video ID", "id" => "post_ft_vimeo", "type" => "text", "title" => "Vimeo Video ID", "description" => "Please enter Vimeo Video ID for example 73317780 (*Note enter if you select \"Vimeo Video\" as Featured Content Type)"),
			array("section" => "Youtube Video ID", "id" => "post_ft_youtube", "type" => "text", "title" => "Youtube Video ID", "description" => "Please enter Youtube Video ID for example 6AIdXisPqHc (*Note enter if you select \"Youtube Video\" as Featured Content Type)"),
			array("section" => "Menu", "id" => "post_menu_transparent", "type" => "checkbox", "title" => "Make Menu Transparent", "description" => "Check this option if you want to display menu in transparent (support only when you upload gallery page header image using set featured image box)"),
			array("section" => "Header", "id" => "post_header_background", "type" => "image", "title" => "Single Post Page Header Background", "description" => "Upload background image for this post and it displays as header in single post page"),
		),
		

		
		/* THISNEW MRG {*/
		/*
		'destacados' => array(
			array("section" => "Destacado Option", "id" => "destacado_use_detail", "type" => "checkbox", "title" => "Ocultar boton a detalle", "description" => "Check this option if you want to hide the Detail Button"),
		),
		*/
		'galleries' => array(
			array("section" => "Gallery Template", "id" => "gallery_template", "type" => "select", "title" => "Gallery Template", "description" => "Select gallery template for this gallery", 
				"items" => array(
					"Gallery Grid Fullwidth" => "Gallery Grid Fullwidth",
					"Gallery Grid Contain" => "Gallery Grid Contain",
					"Gallery Fullscreen" => "Gallery Fullscreen",
				)),
			array("section" => "Menu", "id" => "page_menu_transparent", "type" => "checkbox", "title" => "Make Menu Transparent", "description" => "Check this option if you want to display menu in transparent (support only when you upload gallery page header image using set featured image box)"),
		),
		'sube' => array(
			array("section" => "Latitud", 		"id" => "sube_latitud", 	"type" => "text", 	  "title" => "Latitud", 		"description" => "Ingresar la Latitud"),
			array("section" => "Longitud", 		"id" => "sube_longitud",	"type" => "text", 	  "title" => "Longitud", 		"description" => "Ingresar la Longitud"),
		),
);

function create_meta_box() {

	global $postmetas;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}
	
	if ( function_exists('add_meta_box') && isset($postmetas) && count($postmetas) > 0 ) {  
		foreach($postmetas as $key => $postmeta)
		{
			if($_GET['post_type']==$key && !empty($postmeta))
			{
				if($key != 'pricing')
				{
					add_meta_box( 'metabox', ucfirst($key).' Options', 'new_meta_box', $key, 'side', 'high' );
				}
				else
				{
					add_meta_box( 'metabox', ucfirst($key).' Options', 'new_meta_box', $key, 'normal', 'high' );
				}
			}
		}
	}

}  

function new_meta_box() {
	global $post, $postmetas;
	
	if(!isset($_GET['post_type']) OR empty($_GET['post_type']))
	{
		if(isset($_GET['post']) && !empty($_GET['post']))
		{
			$post_obj = get_post($_GET['post']);
			$_GET['post_type'] = $post_obj->post_type;
		}
		else
		{
			$_GET['post_type'] = 'post';
		}
	}

	echo '<input type="hidden" name="pp_meta_form" id="pp_meta_form" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	$meta_section = '';

	foreach ( $postmetas as $key => $postmeta ) {
	
		if($_GET['post_type'] == $key)
		{
		
			foreach ( $postmeta as $postmeta_key => $each_meta ) {
		
				$meta_id = $each_meta['id'];
				$meta_title = $each_meta['title'];
				$meta_description = $each_meta['description'];
				
				if(isset($postmeta['section']))
				{
					$meta_section = $postmeta['section'];
				}
				
				$meta_type = '';
				if(isset($each_meta['type']))
				{
					$meta_type = $each_meta['type'];
				}
				
				echo "<br/><div class='meta_$meta_type'><strong>".$meta_title."</strong><hr class='pp_widget_hr'/>";
				echo "<div class='pp_widget_description'>$meta_description</div>";
				
				if ($meta_type == 'checkbox') {
					$checked = get_post_meta($post->ID, $meta_id, true) == '1' ? "checked" : "";
					echo "<br style='clear:both'><input type='checkbox' name='$meta_id' id='$meta_id' class='iphone_checkboxes' value='1' $checked /><br style='clear:both'><br/><br/>";
				}
				else if ($meta_type == 'select') {
					echo "<p><select name='$meta_id' id='$meta_id'>";
					
					if(!empty($each_meta['items']))
					{
						foreach ($each_meta['items'] as $key => $item)
						{
							echo '<option value="'.$item.'"';
							
							if($item == get_post_meta($post->ID, $meta_id, true))
							{
								echo ' selected ';
							}
							
							echo '>'.$key.'</option>';
						}
					}
					
					echo "</select></p>";
				}
				else if ($meta_type == 'file') { 
				    echo "<p><input type='text' name='$meta_id' id='$meta_id' class='' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:89%' /><input id='".$meta_id."_button' name='".$meta_id."_button' type='button' value='Upload' class='metabox_upload_btn button' readonly='readonly' rel='".$meta_id."' style='margin:7px 0 0 5px' /></p>";
				}
				else if ($meta_type == 'date') { 
					echo "<p><input type='text' name='$meta_id' id='$meta_id' class='pp_date' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
				}
				else if ($meta_type == 'date_raw') { 
					echo "<p><input id='".$meta_id."' name='".$meta_id."' type='text' value='".get_post_meta($post->ID, $meta_id, true)."' /></p>";
				}
				else if ($meta_type == 'image') { 
				    echo "<p><input type='text' name='$meta_id' id='$meta_id' class='' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:89%' /><input id='".$meta_id."_button' name='".$meta_id."_button' type='button' value='Upload' class='metabox_upload_btn button post_image' readonly='readonly' rel='".$meta_id."' style='margin:7px 0 0 5px' /></p>";
				    
				    $meta_post_image = get_post_meta($post->ID, $meta_id, true);
				    if(!empty($meta_post_image))
				    {
					    echo '<img id="meta_post_img'.$meta_id.'" src="'.$meta_post_image.'" alt="" class="meta_post_img"/>';
					    echo '<br/><a id="meta_post_img_remove'.$meta_id.'" href="#" class="meta_post_img_remove" rel="'.$meta_id.'">Remove header image</a>';
				    }
				    else
				    {
					    echo '<img id="meta_post_img'.$meta_id.'" src="'.$meta_post_image.'" alt="" class="meta_post_img hidden"/>';
					    echo '<br/><a id="meta_post_img_remove'.$meta_id.'" href="#" class="meta_post_img_remove hidden" rel="'.$meta_id.'">Remove header image</a>';
				    }
				    
				}
				else if ($meta_type == 'textarea') {
					if(isset($postmeta[$postmeta_key]['sample']))
					{
						echo "<p><textarea name='$meta_id' id='$meta_id' class=' hint' style='width:100%' rows='7' title='".$postmeta[$postmeta_key]['sample']."'>".get_post_meta($post->ID, $meta_id, true)."</textarea></p>";
					}
					else
					{
						echo "<p><textarea name='$meta_id' id='$meta_id' class='' style='width:100%' rows='7'>".get_post_meta($post->ID, $meta_id, true)."</textarea></p>";
					}
				}			
				else {
					if(isset($postmeta[$postmeta_key]['sample']))
					{
						echo "<p><input type='text' name='$meta_id' id='$meta_id' class='' title='".$postmeta[$postmeta_key]['sample']."' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
					}
					else
					{
						echo "<p><input type='text' name='$meta_id' id='$meta_id' class='' value='".get_post_meta($post->ID, $meta_id, true)."' style='width:99%' /></p>";
					}
				}
				
				echo '</div>';
			}
		}
	}
	
	echo '<br/>';

}

function update_custom_meta($postID, $newvalue, $field_name) {

	if (!get_post_meta($postID, $field_name)) {
		add_post_meta($postID, $field_name, $newvalue);
	} else {
		update_post_meta($postID, $field_name, $newvalue);
	}

}

//init

add_action('admin_menu', 'create_meta_box'); 

/*
	End creating custom fields
*/

?>