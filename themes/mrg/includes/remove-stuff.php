<?php

/**
 *  Unregister and remove stuff
 */


//wp_deregister_script( 'jquery-migrate' ); //doens't work :( 
wp_deregister_script( 'comment-reply' );

add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
// load contact form 7 when needed. (see header.php)


add_action('wp_print_styles','_remove_style');
function _remove_style(){
	if ( is_front_page() ){
		wp_dequeue_style('fancybox');
		wp_deregister_script( 'fancybox' );
		wp_dequeue_style('tooltipster');
		//wp_deregister_script( 'jquery.tooltipster.min.js' );  //sino se rompe
		wp_dequeue_style('magnific-popup');		
		//wp_deregister_script( 'jquery.magnific-popup.js' );  //sino se rompe
	}
}


remove_action( 'wp_head', 'rsd_link' ) ;  // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
add_action( 'wp_footer', 'disable_embed' );
	function disable_embed(){
		wp_dequeue_script( 'wp-embed' );
	}
add_filter('xmlrpc_enabled', '__return_false');
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
add_action( 'pre_ping', 'disable_pingback' );
	function disable_pingback( &$links ) {
		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
				unset($links[$l]);
			}
		}
	}
remove_action( 'wp_head', 'feed_links_extra', 3 );            // extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 );                  // general feeds: Post and Comment Feed
remove_action( 'wp_head', 'index_rel_link' );                 // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );    // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );     // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // links for the posts adjacent to the current post.