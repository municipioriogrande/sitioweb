<?php
/**
 * The Header for the template.
 *
 * @package WordPress
 */
 
 /*
// load contact form 7 when it's needed

if ( is_page( 
		array(
			'home',
			'medioambiente',
			'espacio-tecnologico',
			'1er-congreso-internacional-educacion-e-inclusion-desde-el-sur'
		) 
	) ) {	
	

	if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
		wpcf7_enqueue_scripts();
	}

	if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
		wpcf7_enqueue_styles();
	}

}
*/

if (!isset( $content_width ) ) $content_width = 1170;

if(session_id() == '') {
	session_start();
}
 
global $pp_homepage_style;
?><!DOCTYPE html>
<html <?php language_attributes(); ?> <?php if(isset($pp_homepage_style) && !empty($pp_homepage_style)) { echo 'data-style="'.$pp_homepage_style.'"'; } ?> class="<?php
echo ( wp_is_mobile() ) ? "in-mobile" : "in-desktop";?>">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="format-detection" content="telephone=no">

<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php 
?>


<?php
	/**
	*	Get favicon URL
	**/
	$pp_favicon = get_option('pp_favicon');
	
	if(!empty($pp_favicon))
	{
?>
		<link rel="shortcut icon" href="<?php echo $pp_favicon; ?>" />
        <link rel="apple-touch-icon" href="<?php echo $pp_favicon; ?>" />
<?php
	}
?>

<?php
//global $post;
$fb_thumb = "";
if ( has_post_thumbnail() ) { 
	$fb_thumb = get_the_post_thumbnail_url( get_the_ID(), "large");
}
else{
	$fb_thumb = wp_get_attachment_image_src(get_the_ID(), 'gallery_3', true);
	$fb_thumb = $fb_thumb[0];

	/*
	if(isset($fb_thumb) && !empty($fb_thumb)){
		$image_desc = get_post_field('post_content', $post->ID);
		$image_desc = strip_tags(strip_shortcodes($image_desc);
	}
	*/
}

$image_desc = "";
if ( get_the_excerpt($post) ) {
	$image_desc = get_the_excerpt($post);
}

?>
	<!-- Open Graph data -->
    <meta property="og:type" content="article" />
	<meta property="og:image" content="<?php echo $fb_thumb; ?>"/>
	<meta property="og:title" content="<?php the_title(); ?>"/>
	<meta property="og:url" content="<?php echo get_permalink(get_the_ID()); ?>"/>
	<meta property="og:description" content="<?php echo $image_desc; ?>"/>
    
    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="<?php echo get_permalink(get_the_ID()); ?>" />
    <meta name="twitter:title" content="<?php the_title(); ?>" />
    <meta name="twitter:description" content="<?php echo $image_desc; ?>" />
    <meta name="twitter:image" content="<?php echo $fb_thumb; ?>">

	<!-- Apple -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">

    <!-- Icons -->
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icon/apple-icon-180x180.png" />
    <link rel="fluid-icon" href="<?php echo get_template_directory_uri(); ?>/images/icon/apple-icon-180x180.png" title="<?php the_title(); ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/images/icon/favicon-16x16.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/images/icon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/images/icon/favicon-96x96.png" />
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/images/icon/android-icon-192x192.png" />
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/images/icon/manifest.json" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/images/icon/ms-icon-144x144.png" />
    <meta name="theme-color" content="#ffffff" />

<?php
	/**
    *	Setup code before </head>
    **/
	$pp_before_head_code = get_option('pp_before_head_code');
	
	if(!empty($pp_before_head_code))
	{
		if ( defined(DEV_ENV) && !DEV_ENV) {
			echo stripslashes($pp_before_head_code);
		}
	}
	
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>

<link rel='dns-prefetch' href='//mautic.dir.riogrande.gob.ar/' />

</head>

<body <?php body_class(); ?> <?php if(isset($pp_homepage_style) && !empty($pp_homepage_style)) { echo 'data-style="'.$pp_homepage_style.'"'; } ?> >

<a href="#content" class="visually-hide">Saltear al contenido</a> 


	<?php
		//Check if disable right click
		$pp_enable_right_click = get_option('pp_enable_right_click');
		
		//Check if disable image dragging
		$pp_enable_dragging = get_option('pp_enable_dragging');
		
		//Check auto display gallery info
		$pp_gallery_auto_info = get_option('pp_gallery_auto_info');
		
		//Check if use reflection in flow gallery
		$pp_flow_enable_reflection = get_option('pp_flow_enable_reflection');
		
		//Check if use AJAX search
		$pp_blog_ajax_search = get_option('pp_blog_ajax_search');
		
		//Check if sticky menu
		$pp_fixed_menu = get_option('pp_fixed_menu');
		
		//Check if display top bar
		$pp_topbar = get_option('pp_topbar');
	?>
	<input type="hidden" id="pp_enable_reflection" name="pp_enable_reflection" value="<?php echo $pp_flow_enable_reflection; ?>"/>
	<input type="hidden" id="pp_enable_right_click" name="pp_enable_right_click" value="<?php echo $pp_enable_right_click; ?>"/>
	<input type="hidden" id="pp_enable_dragging" name="pp_enable_dragging" value="<?php echo $pp_enable_dragging; ?>"/>
	<input type="hidden" id="pp_gallery_auto_info" name="pp_gallery_auto_info" value="<?php echo $pp_gallery_auto_info; ?>"/>
	<input type="hidden" id="pp_image_path" name="pp_image_path" value="<?php echo get_template_directory_uri(); ?>/images/"/>
	<input type="hidden" id="pp_homepage_url" name="pp_homepage_url" value="<?php echo home_url(); ?>"/>
	<input type="hidden" id="pp_blog_ajax_search" name="pp_blog_ajax_search" value="<?php echo $pp_blog_ajax_search; ?>"/>
	<input type="hidden" id="pp_fixed_menu" name="pp_fixed_menu" value="<?php echo $pp_fixed_menu; ?>"/>
	<input type="hidden" id="pp_topbar" name="pp_topbar" value="<?php echo $pp_topbar; ?>"/>
	
	<?php
		//Check footer sidebar columns
		$pp_footer_colum_style = get_option('pp_footer_colum_style');
	?>
	<input type="hidden" id="pp_footer_colum_style" name="pp_footer_colum_style" value="<?php echo $pp_footer_colum_style; ?>"/>
	
	

	<!-- Begin template wrapper -->
	<div id="wrapper">
	
	<?php 
		//Check if blank template
		global $is_no_header;
		
		//Get page ID
		if(is_object($post))
		{
		    $page = get_page($post->ID);
		}
		$current_page_id = '';
		
		
		if(is_home())
		{
		    $current_page_id = get_option('page_on_front');
		}
		
		
		if(!is_bool($is_no_header) OR !$is_no_header)
		{
		
		//Get Page RevSlider
	    $page_revslider = get_post_meta($current_page_id, 'page_revslider', true);
	    $page_header_below = get_post_meta($current_page_id, 'page_header_below', true);
	    $page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
	    if(is_single() && $post->post_type == 'post')
	    {
		    $page_menu_transparent = get_post_meta($current_page_id, 'post_menu_transparent', true);
	    }
	    
		/* THISNEW MRG { */
        if(is_single() && $post->post_type=='exhibicion')
	    {
		    $page_menu_transparent = TRUE;
	    }
		/* } THISNEW MRG */
	    global $pp_hook_menu_transparent;
		if(!empty($pp_hook_menu_transparent))
		{
		    $page_menu_transparent = TRUE;
		}
	    
	    //Check if display header below menu
	    if(!empty($page_header_below) && !empty($page_revslider) && $page_revslider != -1)
		{
			echo '<div class="page_slider">'.do_shortcode('[rev_slider '.$page_revslider.']').'</div>';
		}
	?>
	
	<div class="header_style_wrapper">
		<?php
			//Check if display top bar
			$pp_topbar = get_option('pp_topbar');
			
			if(THEMEDEMO && isset($_GET['topbar']) && $_GET['topbar'] == 'true')
		    {
		    	$pp_topbar = 1;
		    }
		    
		    global $global_pp_topbar;
		    $global_pp_topbar = $pp_topbar;
			
			if(!empty($pp_topbar))
			{
		?>
		<div class="above_top_bar">
			<div class="page_content_wrapper">
				<div class="top_contact_info">
				    <?php
				    	//Display top contact info
				    	
				        $pp_topbar_phone = get_option('pp_topbar_phone');
				        
				        if(!empty($pp_topbar_phone))
				        {
				    ?>
				        <span><a href="tel:<?php echo $pp_topbar_phone; ?>"><i class="fa fa-phone"></i><?php echo $pp_topbar_phone; ?></a></span>
				    <?php
				        }
				    ?>
				    <?php
				        $pp_topbar_contact_url = get_option('pp_topbar_contact_url');
				        
				        if(!empty($pp_topbar_contact_url))
				        {	
				    ?>
				        <span><a href="<?php echo $pp_topbar_contact_url; ?>"><i class="fa fa-map-marker"></i><?php _e( 'Find our Address', THEMEDOMAIN ); ?></a></span>
				    <?php
				        }
				    ?>
				    <?php
				        $pp_topbar_email = get_option('pp_topbar_email');
				        
				        if(!empty($pp_topbar_email))
				        {	
				    ?>
				        <span><a href="mailto:<?php echo $pp_topbar_email; ?>"><i class="fa fa-envelope-o"></i><?php echo $pp_topbar_email; ?></a></span>
				    <?php
				        }
				    ?>
				</div>
				
				<?php
				    //Display top social icons
				    //Check if open link in new window
					$pp_topbar_social_link_blank = get_option('pp_topbar_social_link_blank');
				?>
				<div class="social_wrapper">
				    <ul>
				    	<?php
				    		$pp_facebook_username = get_option('pp_facebook_username');
				    		
				    		if(!empty($pp_facebook_username))
				    		{
				    	?>
				    	<li class="facebook"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> href="<?php echo $pp_facebook_username; ?>"><i class="fa fa-facebook"/></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_twitter_username = get_option('pp_twitter_username');
				    		
				    		if(!empty($pp_twitter_username))
				    		{
				    	?>
				    	<li class="twitter"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> href="http://twitter.com/<?php echo $pp_twitter_username; ?>"><i class="fa fa-twitter"/></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_flickr_username = get_option('pp_flickr_username');
				    		
				    		if(!empty($pp_flickr_username))
				    		{
				    	?>
				    	<li class="flickr"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Flickr" href="http://flickr.com/people/<?php echo $pp_flickr_username; ?>"><i class="fa fa-flickr"/></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_youtube_username = get_option('pp_youtube_username');
				    		
				    		if(!empty($pp_youtube_username))
				    		{
				    	?>
				    	<li class="youtube"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Youtube" href="http://youtube.com/channel/<?php echo $pp_youtube_username; ?>"><i class="fa fa-youtube"/></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_vimeo_username = get_option('pp_vimeo_username');
				    		
				    		if(!empty($pp_vimeo_username))
				    		{
				    	?>
				    	<li class="vimeo"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Vimeo" href="http://vimeo.com/<?php echo $pp_vimeo_username; ?>"><i class="fa fa-vimeo-square"></i></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_tumblr_username = get_option('pp_tumblr_username');
				    		
				    		if(!empty($pp_tumblr_username))
				    		{
				    	?>
				    	<li class="tumblr"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Tumblr" href="http://<?php echo $pp_tumblr_username; ?>.tumblr.com"><i class="fa fa-tumblr"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_google_username = get_option('pp_google_username');
				    		
				    		if(!empty($pp_google_username))
				    		{
				    	?>
				    	<li class="google"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Google+" href="<?php echo $pp_google_username; ?>"><i class="fa fa-google-plus"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_dribbble_username = get_option('pp_dribbble_username');
				    		
				    		if(!empty($pp_dribbble_username))
				    		{
				    	?>
				    	<li class="dribbble"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Dribbble" href="http://dribbble.com/<?php echo $pp_dribbble_username; ?>"><i class="fa fa-dribbble"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				    		$pp_linkedin_username = get_option('pp_linkedin_username');
				    		
				    		if(!empty($pp_linkedin_username))
				    		{
				    	?>
				    	<li class="linkedin"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Linkedin" href="<?php echo $pp_linkedin_username; ?>"><i class="fa fa-linkedin"></i></a></li>
				    	<?php
				    		}
				    	?>
				    	<?php
				            $pp_pinterest_username = get_option('pp_pinterest_username');
				            
				            if(!empty($pp_pinterest_username))
				            {
				        ?>
				        <li class="pinterest"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Pinterest" href="http://pinterest.com/<?php echo $pp_pinterest_username; ?>"><i class="fa fa-pinterest"></i></a></li>
				        <?php
				            }
				        ?>
				        <?php
				        	$pp_instagram_username = get_option('pp_instagram_username');
				        	
				        	if(!empty($pp_instagram_username))
				        	{
				        ?>
				        <li class="instagram"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Instagram" href="http://instagram.com/<?php echo $pp_instagram_username; ?>"><i class="fa fa-instagram"></i></a></li>
				        <?php
				        	}
				        ?>
				        <?php
				        	$pp_behance_username = get_option('pp_behance_username');
				        	
				        	if(!empty($pp_behance_username))
				        	{
				        ?>
				        <li class="behance"><a <?php if(!empty($pp_topbar_social_link_blank)) { ?>target="_blank"<?php } ?> title="Behance" href="http://behance.net/<?php echo $pp_behance_username; ?>"><i class="fa fa-behance-square"></i></a></li>
				        <?php
				        	}
				        ?>
				    </ul>
				</div>
			</div>
		</div>
		<?php
			}
		?>
		
		<?php
			$pp_page_bg = '';
			//Get page featured image
			if(has_post_thumbnail($current_page_id, 'original'))
		    {
		        $image_id = get_post_thumbnail_id($current_page_id); 
		        $image_thumb = wp_get_attachment_image_src($image_id, 'original', true);
		        $pp_page_bg = $image_thumb[0];
		    }
		    
		    if(is_single() && $post->post_type == 'post')
		    {
			    $pp_page_bg = get_post_meta($post->ID, 'post_header_background', true);
			}
		    
		   if(!empty($pp_page_bg) && basename($pp_page_bg)=='default.png')
		    {
		    	$pp_page_bg = '';
		    }
		    
		    //If enable menu transparent
		    $page_revslider = get_post_meta($current_page_id, 'page_revslider', true);
		    $page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
		    if(is_single() && $post->post_type == 'post')
		    {
			    $page_menu_transparent = get_post_meta($current_page_id, 'post_menu_transparent', true);
		    }
			
		    global $pp_hook_menu_transparent;
		    if(!empty($pp_hook_menu_transparent))
		    {
			    $page_menu_transparent = TRUE;
		    }
		    
		    //If enable header below slider, always display menu in solid background color
		    if(!empty($page_header_below))
		    {
			    $page_menu_transparent = 0;
		    }
		    
		
		
		?>
		<div class="top_bar <?php if(!empty($page_menu_transparent)) { ?>hasbg<?php } ?> <?php if(!empty($page_revslider) && $page_revslider!= -1 && !empty($page_menu_transparent)) { ?>hasbg<?php } ?> <?php if(isset($pp_homepage_style) && !empty($pp_homepage_style)) { echo $pp_homepage_style; } ?>">
		
			<!--<div id="mobile_nav_icon"></div>-->
		
			<div id="menu_wrapper">

			 	<div class="col col-left">

									<?php
										// THISNEW Display Hamburguesa menu
										$pp_hamburguesa_menu = get_option('pp_hamburguesa_menu');
										if(!empty($pp_hamburguesa_menu))
										{
									?>
										<div class="hamburger hamburger--squeeze">
											<div class="hamburger-box">
													<div class="hamburger-inner"></div>
											</div>
										</div>
									<?php 
										}
									?>
										
									<!-- Begin logo -->	
									<?php
										$use_transparent_logo = FALSE;
										if(isset($pp_homepage_style) OR !empty($page_menu_transparent))
										{
											if($pp_homepage_style=='fullscreen' OR $pp_homepage_style=='fullscreen_video' OR $pp_homepage_style=='flip' OR !empty($pp_page_bg) OR !empty($page_menu_transparent))
											{
												$use_transparent_logo = TRUE;
											}
										}
									
										//get custom logo
										$pp_logo = get_option('pp_logo');
										$pp_retina_logo = get_option('pp_retina_logo');
										$pp_retina_logo_width = 0;
										$pp_retina_logo_height = 0;
													
										if(empty($pp_logo) && empty($pp_retina_logo))
										{	
											$pp_retina_logo = get_template_directory_uri().'/images/logo@2x.png';
											$pp_retina_logo_width = 165;
											$pp_retina_logo_height = 62;
										}

										if(!empty($pp_retina_logo))
										{	
											if(empty($pp_retina_logo_width) && empty($pp_retina_logo_height))
											{
												//Get image width and height
												$pp_retina_logo_id = pp_get_image_id($pp_retina_logo);
												$image_logo = wp_get_attachment_image_src($pp_retina_logo_id, 'original');
												
												$pp_retina_logo = $image_logo[0];
												$pp_retina_logo_width = $image_logo[1]/2;
												$pp_retina_logo_height = $image_logo[2]/2;
											}
									?>		
										<a id="custom_logo" class="logo_wrapper <?php if($use_transparent_logo) { ?>hidden<?php } else { ?>default<?php } ?>" href="<?php echo home_url(); ?>">
											<img src="<?php echo $pp_retina_logo; ?>" alt="<?php echo SITE_LOGO_ALT;?>" width="<?php echo $pp_retina_logo_width; ?>" height="<?php echo $pp_retina_logo_height; ?>"/>
										</a>
									<?php
										}
										else //if not retina logo
										{
									?>
										<a id="custom_logo" class="logo_wrapper <?php if($use_transparent_logo) { ?>hidden<?php } else { ?>default<?php } ?>" href="<?php echo home_url(); ?>">
											<img src="<?php echo $pp_logo?>" alt="<?php echo SITE_LOGO_ALT;?>"/>
										</a>
									<?php
										}
									?>
									
									<?php
										//get custom logo transparent
										$pp_logo_transparent = get_option('pp_logo_transparent');
										$pp_retina_logo_transparent = get_option('pp_retina_logo_transparent');
										$pp_retina_logo_transparent_width = 0;
										$pp_retina_logo_transparent_height = 0;
										
										if(empty($pp_logo_transparent) && empty($pp_retina_logo_transparent))
										{
											$pp_retina_logo_transparent = get_template_directory_uri().'/images/logo@2x.png';
											$pp_retina_logo_transparent_width = 69;
											$pp_retina_logo_transparent_height = 33;
										}

										if(!empty($pp_retina_logo_transparent))
										{
											if(empty($pp_retina_logo_transparent_width) && empty($pp_retina_logo_transparent_width))
											{
												//Get image width and height
												$pp_retina_logo_transparent_id = pp_get_image_id($pp_retina_logo_transparent);
												$image_logo = wp_get_attachment_image_src($pp_retina_logo_transparent_id, 'original');
												
												$pp_retina_logo_transparent = $image_logo[0];
												$pp_retina_logo_transparent_width = $image_logo[1]/2;
												$pp_retina_logo_transparent_height = $image_logo[2]/2;
											}
									?>		
										<a id="custom_logo_transparent" class="logo_wrapper <?php if(!$use_transparent_logo) { ?>hidden<?php } else { ?>default<?php } ?>" href="<?php echo home_url(); ?>">
											<img src="<?php echo $pp_retina_logo_transparent; ?>" alt="<?php echo SITE_LOGO_ALT;?>" width="<?php echo $pp_retina_logo_transparent_width; ?>" height="<?php echo $pp_retina_logo_transparent_height; ?>"/>
										</a>
									<?php
										}
										else //if not retina logo
										{
									?>
										<a id="custom_logo_transparent" class="logo_wrapper <?php if(!$use_transparent_logo) { ?>hidden<?php } else { ?>default<?php } ?>" href="<?php echo home_url(); ?>">
											<img src="<?php echo $pp_logo_transparent?>" alt="<?php echo SITE_LOGO_ALT;?>"/>
										</a>
									<?php
										}
									?>
									<!-- End logo -->
										
										<div class="header_line" style="height:<?php echo $pp_retina_logo_height; ?>px"></div>
										
										<!-- Mayor name -->
										<?php
										// THISNEW Display Hamburguesa menu
										$pp_mayor_show = get_option('pp_mayor_show');
										if(!empty($pp_mayor_show))
										{
											$pp_mayor_name = get_option('pp_mayor_name');
											$pp_mayor_url = get_option('pp_mayor_url');
									?>
										<div class="mayor-name">
											<div class="mayor-name-content">
													<?php 
											if($pp_mayor_url){
											?>
													<a href="<?php echo $pp_mayor_url; ?>"><?php echo $pp_mayor_name; ?></a>
													<?php
											}else{
												echo $pp_mayor_name; 
											}
											?>
											</div>
										</div>
									<?php 
										}
									?>
				</div>

				<div class="col col-middle">
					<div class="button-holder">
						<a href="https://www.riogrande.gob.ar/turnos/" class="btn">
							<span><img class="image lazy loaded" data-src="https://www.riogrande.gob.ar/wp-content/uploads/global/turnos-white.svg" data-was-processed="true" src="https://www.riogrande.gob.ar/wp-content/uploads/global/turnos-white.svg" style="vertical-align:bottom;margin-right: 0.5em;" width="50"></span>
							<span class="text">Turnos web</span>
						</a>
					</div>
				</div>
				<div class="col col-right">

					

										
										<!-- Weather -->
										<?php
										// THISNEW Display tehe wather 
										$pp_wather_show = get_option('pp_wather_show');
										if(!empty($pp_wather_show))
										{
									?>
										<div class="content-weather">
											<div class="content-weather-content">
													<?php echo do_shortcode('[do_widget id=andimol_clima-2 wrap=div]'); ?>
											</div>
										</div>
									<?php 
										}
									?>
									<?php
										//Display phone button
										$pp_phone_button_header = get_option('pp_phone_button_header');
										if(!empty($pp_phone_button_header))
										{
											$pp_phone_button_number = get_option('pp_phone_button_number');
									?>
									<a href="tel:<?php echo $pp_phone_button_number; ?>">
										<div class="header_action">
											<i class="fa fa-phone"></i><?php echo $pp_phone_button_number; ?>
										</div>
									</a>
									<?php 
										}
									?>
										
										<?php
										//Display CTA button
										$pp_cta_button_in_header = get_option('pp_cta_button_in_header');
										if(!empty($pp_cta_button_in_header))
										{
											$pp_cta_button_text = get_option('pp_cta_button_text');
											$pp_cta_button_url = get_option('pp_cta_button_url');
									?>
									<a href="<?php echo $pp_cta_button_url; ?>" class="cta_wrapper">
										<div class="header_cta">
											<?php echo $pp_cta_button_text; ?>
										</div>
									</a>
									<?php 
										}
									?>
										
									
									<?php
										//Check if display search in header
										$pp_ajax_search_header = get_option('pp_ajax_search_header');
										
										if(!empty($pp_ajax_search_header))
										{
									?>
									<form role="search" method="get" name="searchform" id="searchform" action="<?php echo home_url(); ?>/">
										<div>
											<label for="s"><?php echo _e( 'To Search, type and hit enter', THEMEDOMAIN ); ?></label>
											<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" autocomplete="off"/>
											<button>
												<i class="fa fa-search"></i><span class="visually-hide">Buscar</span>
											</button>
										</div>
										<div id="autocomplete"></div>
									</form>
									<?php
										}
									?>
									
									<?php
									if(empty($pp_hamburguesa_menu))
									{
									?>
									<!-- Begin main nav -->
									<div id="nav_wrapper">
										<div class="nav_wrapper_inner">
											<div id="menu_border_wrapper">
												<?php 	
													if ( has_nav_menu( 'primary-menu' ) ) 
													{
														//Get page nav
														wp_nav_menu( 
																array( 
																	'menu_id'			=> 'main_menu',
																	'menu_class'		=> 'nav',
																	'theme_location' 	=> 'primary-menu',
																	'link_before' 		=> '<span>', 
																	'link_after' 		=> '</span>',
																	'walker' => new tg_walker(),
																) 
														); 
													}
													else
													{
															echo '<div class="notice">Please setup "Main Menu" using Wordpress Dashboard > Appearance > Menus</div>';
													}
												?>
											</div>
										</div>
									</div>
									<!-- End main nav -->
									<?php
									}
									?>
									<div class="header-escudo">
													<img src="<?php echo get_template_directory_uri();?>/images/escudo.png">
												</div>
									</div>
					
					
					
					
					
					
					
					
					
					
					
					</div>


				
				 
			</div>
            
            
            <?php
			if(!empty($pp_hamburguesa_menu))
			{
			?>
			<!-- Begin Hamburger nav -->
            <div class="cajaexterna">
                <div class="cajainterna animated_hamburger">
                    <div class="cajacentrada">
                        <?php 	
							if ( has_nav_menu( 'primary-menu' ) ) 
							{
								//Get page nav
								wp_nav_menu( 
										array( 
											'menu_id'			=> 'main_menu',
											'menu_class'		=> 'nav',
											'theme_location' 	=> 'primary-menu',
											'link_before' 		=> '<span>', 
											'link_after' 		=> '</span>',
											'walker' => new tg_walker(),
										) 
								); 
							}
							else
							{
									echo '<div class="notice">Please setup "Main Menu" using Wordpress Dashboard > Appearance > Menus</div>';
							}
						?>
                    </div>
                </div>
            </div>
			<!-- End Hamburger nav -->
			<?php
			}
			?>
            
						
		</div>
		<?php
			} //End if not blank template
		?>
		
		
		
		
		

