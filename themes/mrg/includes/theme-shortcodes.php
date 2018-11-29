<?php
/*
Custom shortcodes for custom post editor - MRG theme (2017).


// Add shortcode for theme's content builder (display in front end)
// To add sections (backend), must edit /themes/mrg/lib/contentbuilder.shortcode.lib.php

*/


add_shortcode('ppb_add_shortcode', 'ppb_add_shortcode_func');
function ppb_add_shortcode_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
		'layout' => 'fixedwidth',
		'titulo' => '',
		'ancla' 	=> '',
		'clases' 	=> '',
		'contenido' => '',
		'shortcode' => '',
		
    ), $atts));

	$return_html = '<div class="module_add_shortcode ';

   if (!empty($layout) && $layout == 'fullwidth') {
      $return_html .= 'fullwidth ';
   }
   $return_html .= '" ';
	
	$return_html .= ( $ancla ) ? ' id="'.$ancla.'" ' : '';

   $return_html .= '><div class="page_content_wrapper '. html_entity_decode($atts['clases']) .'">';


	$return_html .= '<div class="row">';
	$return_html .= '	<div class="col col-md col-md-12">';
	
	if( !empty($titulo) ) {
		$return_html .= '			<h2 class="section-title">'.html_entity_decode($atts['titulo']).'</h2>'; 
	}
	if(!empty($contenido)){		
		$return_html .= '			<div class="text">' . html_entity_decode($atts['contenido']) . '</div>';
		
	}
	if(!empty($shortcode))	{		
		//$contenido = str_replace("&quot;",'"',$contenido);
		$contenido = "[" . htmlspecialchars_decode($atts['shortcode']) . "]";
		$return_html .= '			<div class="content">' . do_shortcode($contenido) . '</div>';
	}		
	
	$return_html .= '	</div>'."\r";
	$return_html .= '</div>'; // close row
	
	$return_html .= '</div>'; // close page_content_wrapper
	$return_html .= '</div>'; // close bilder_modul
	
   return $return_html;
}



add_shortcode('ppb_lista_centros_salud', 'ppb_lista_centros_salud_func');
function ppb_lista_centros_salud_func($atts, $content) {

   //extract short code attr
   extract(shortcode_atts(array(
		'layout' => 'fixedwidth',
		'titulo' => '',
		'ancla' 	=> '',
		'contenido' => '',
		
   ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_centros-salud ppb_module_titular_bajada_full_c1_c2 ';

   if (!empty($layout) && $layout == 'fullwidth') {
      $return_html .= 'fullwidth ';
   }

   $return_html .= '" ';
   $return_html .= '><div class="page_content_wrapper">';


	if( !empty($titulo) ) {
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if( !empty($titulo) ) {
			$return_html .= '			<h2>'.html_entity_decode($atts['titulo']).'</h2>'; 
		}
		
		if(!empty($bajada)) {
			$return_html .= '			<div>'.html_entity_decode($atts['contenido']).'</div>';
		}
		
		$return_html .= '			<div>'.list_centros_salud().'</div>';
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '</div>'; // close page_content_wrapper
	$return_html .= '</div>'; // close bilder_modul
	
   return $return_html;
}


add_shortcode('ppb_module_titular_cuerpo_nlb', 'ppb_module_titular_cuerpo_nlb_func');
function ppb_module_titular_cuerpo_nlb_func($atts, $content) {

	//extract short code attr
	extract(shortcode_atts(array(
		'layout'  => 'fixedwidth',
		'titulo'  => '',
		'ancla'   => '',
		'bajada'  => '',
		'cuerpo'  => '',
	), $atts));

	$return_html = '<div id="'.$ancla.'" class="module_titular_bajada_c1_img ';

	$return_html .= (!empty($layout) && $layout == 'fullwidth') ? 'fullwidth ' : '' ;
	 
	$scapes = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo = trim(str_replace($scapes, '', html_entity_decode($cuerpo)));

	$return_html .= '" ';
	$return_html .= '><div class="page_content_wrapper">';
	
	if( !empty($titulo) || !empty($bajada) ) {
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		$return_html .= ( !empty($titulo) ) ? '			<h2>' . html_entity_decode($titulo) . '</h2>' : '';
		
		
		if( !empty($bajada) ) {
			$return_html .= ( empty($cuerpo) ) ? '			<aside style="margin:0;">'.html_entity_decode($bajada).'</aside>' : '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	if( !empty($cuerpo) ) {
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<p>'.html_entity_decode($cuerpo).'</p>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '</div>'; // close page_content_wrapper
   $return_html .= '</div>'; // close bilder_modul
	
   return $return_html;
}


add_shortcode('ppb_blog_latest_posts', 'ppb_blog_latest_posts_func');
function ppb_blog_latest_posts_func($atts, $content) {

   //extract short code attr
   extract(shortcode_atts(array(
		'layout' => 'fixedwidth',
		'titulo' => '',
		'ancla' 	=> '',
		'show_items' => '',
		'selected_category' => '',
		
   ), $atts));
	 
	 
	$remote_posts = ( $selected_category != "all" ) ? get_external_blog_posts($selected_category) : get_external_blog_posts();
	
	if ( empty( $remote_posts ) ) {
		return "";
	}
	
   print_external_blog_posts($remote_posts, $titulo);
}


