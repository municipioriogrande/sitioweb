<?php


use Carbon_Fields\Container;
use Carbon_Fields\Field;

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'flush_rewrites_licitaciones' );
function flush_rewrites_centros_salud() {
	// call your CPT registration function here (it should also be hooked into 'init')
	centros_salud_post_type();
	flush_rewrite_rules();
}




// Register Custom Post Type
function centros_salud_post_type() {

	$labels = array(
		'name'                  => _x( 'Centros de salud', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Centro de salud', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Centros de salud', 'text_domain' ),
		'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
		'archives'              => __( 'Item Archives', 'text_domain' ),
		'attributes'            => __( 'Item Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Todos', 'text_domain' ),
		'add_new_item'          => __( 'Agregar nuevo centro', 'text_domain' ),
		'add_new'               => __( 'Agregar nuevo', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Editar Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'Ver Item', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'No encontrado', 'text_domain' ),
		'not_found_in_trash'    => __( 'No encontrado en Papelera', 'text_domain' ),
		'featured_image'        => __( 'Imagen destacada', 'text_domain' ),
		'set_featured_image'    => __( 'Agregar Imagen destacada', 'text_domain' ),
		'remove_featured_image' => __( 'Eliminar Imagen destacada', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	
	$rewrite = array(
		'slug'                  => 'salud/centros-salud',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	
	$args = array(
		'label'                 => __( 'Centro de salud', 'text_domain' ),
		'description'           => __( 'Post Type Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail'),
		//'taxonomies'            => array( 'category', "post_tag" ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 25,
		'menu_icon'             => 'dashicons-plus-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		//'capability_type'       => 'page',
		'capability_type'       => 'centros_salud', //allow custom capabilities easily
		'map_meta_cap' => true, //add all capabilities 
	);
	register_post_type( 'centros_salud', $args );

}
add_action( 'init', 'centros_salud_post_type', 0 );





add_action( 'carbon_fields_register_fields', 'crb_attach_post_meta_centros_salud' );
function crb_attach_post_meta_centros_salud() {

   Container::make( 'post_meta', __( 'Propiedades', 'crb' ) )
        ->where( 'post_type', '=', 'centros_salud' )
        ->set_context( 'carbon_fields_after_title' )
        ->add_fields( array(

            Field::make( 'text', 'mrg_health_center_address', 'Dirección' )
            	->set_required( true )
        		,
            Field::make( 'text', 'mrg_health_center_phone', 'Teléfono' )
					->set_width ( 50 )
        		,				
            Field::make( 'text', 'mrg_health_center_open_hrs', 'Horario de atención' )
					->set_width ( 50 )
					->set_attribute ( 'placeholder', "8 a 17hs" )
        		

			) );
}





if ( ! function_exists( 'list_centros_salud' ) ) {
/**
 * My Awesome function is awesome (pluggable)
 *
 * @param int $max_items   default -1 = show all
 * @return array
 */
function list_centros_salud( ) {
	//by default, list by date, new-to-old
	//     if want to organize in a certain way, for now, use the dates
	$args = array(
		'post_type' => "centros_salud",
		
	);
	
	$query = new WP_Query( $args );

  	if( !$query->have_posts() ) {
  		return false;
  	}
	
	$final_text = "<ul>";
  	  	
	while ($query->have_posts()) :
		$query->the_post();

		// carbon_get_the_post_meta( 'crb_sede' ))  es = a  get_post_meta( get_the_ID(), '_crb_sede', true )
		
		$final_text .= "<li class='centro-salud'>";
		$final_text .= '    <div class="featured-image"><img src="'.wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium_large', true)[0].'" alt="'.get_the_title().'"></div>';
		$final_text .= '    <div class="info">';
		$final_text .= '        <p class="title">' . get_the_title() . "</p>";
		$final_text .= '        <p class="icon address">Dirección: ' . get_post_meta( get_the_ID(), '_mrg_health_center_address', true ) . "</p>";
		$final_text .= '        <p class="icon phone">Teléfono: ' . get_post_meta( get_the_ID(), '_mrg_health_center_phone', true ) . "</p>";
		$final_text .= '        <p class="icon hours">Horario: ' . get_post_meta( get_the_ID(), '_mrg_health_center_open_hrs', true ) . "</p>";
		$final_text .= '        <p class="more-info"><a href="' . get_the_permalink() . '">Más información</a></p>';
		$final_text .= "    </div>";
		
		
		$final_text .= "</li>";

	endwhile;
	$final_text .= "</ul>";
	

	return $final_text;
  }
}



?>