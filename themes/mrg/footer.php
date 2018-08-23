<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 */
?>
	
<?php
	/**
    *	Setup Google Analyric Code
    **/
	$pp_ga_code = get_option('pp_ga_code');
	
	if(!empty($pp_ga_code))
	{
		echo stripslashes($pp_ga_code);
	}
	
	//Check if blank template
	global $is_no_header;
	
	if(!is_bool($is_no_header) OR !$is_no_header)
	{
?>

</div>

<!--<div id="map" path="<?php echo get_template_directory_uri(); ?>/js/map">
    <div id="map_container">
        <div id="main_content_google_lista"></div>
        <div id="main_content_google"></div>
    </div>
</div>-->
<?php
//wp_enqueue_style("jquery_map_css", get_template_directory_uri()."/js/map/jquery.map.css", false, THEMEVERSION, "all");
//wp_enqueue_script("jquery_map_script", get_template_directory_uri()."/js/map/jquery.map.php", false, THEMEVERSION, true);
?>
<?php
// THIS NEW Display Hamburguesa menu
$pp_hamburguesa_menu = get_option('pp_hamburguesa_menu');
if(!empty($pp_hamburguesa_menu))
{
	wp_enqueue_style("jquery_hamburger__css", get_template_directory_uri()."/js/hamburger/hamburger.css", false, THEMEVERSION, "all");
	wp_enqueue_script("jquery_hamburger_script", get_template_directory_uri()."/js/hamburger/hamburger.js", false, THEMEVERSION, true);
}
?>


<?php
	global $pp_homepage_style;
?>
<div class="footer <?php if(isset($pp_homepage_style) && !empty($pp_homepage_style)) { echo $pp_homepage_style; } ?>">
	<?php
	$html_return_footer = '';
	
	if($pp_homepage_style!='flow' && $pp_homepage_style!='fullscreen' && $pp_homepage_style!='carousel' && $pp_homepage_style!='flip' && $pp_homepage_style!='fullscreen_video')
	{
		# Logo {
		$html_logo 						= '';
		$pp_footer_logo 				= get_option('pp_footer_logo');
		$pp_footer_logo_retina 			= get_option('pp_footer_logo_retina');
		$pp_footer_logo_retina_width 	= 0;
		$pp_footer_logo_retina_height 	= 0;
					
		if(empty($pp_footer_logo) && empty($pp_footer_logo_retina))
		{	
			$pp_footer_logo_retina 			= get_template_directory_uri().'/images/logo_footer@2x.png';
			$pp_footer_logo_retina_width 	= 199;
			$pp_footer_logo_retina_height 	= 41;
		}
		
		if(!empty($pp_footer_logo_retina))
		{	
			if(empty($pp_footer_logo_retina_width) && empty($pp_footer_logo_retina_height))
			{
				//Get image width and height
				$pp_footer_logo_retina_id = pp_get_image_id($pp_footer_logo_retina);
				$footer_image_logo = wp_get_attachment_image_src($pp_footer_logo_retina_id, 'original');
				
				$pp_footer_logo_retina 			= $footer_image_logo[0];
				$pp_footer_logo_retina_width 	= $footer_image_logo[1]/2;
				$pp_footer_logo_retina_height 	= $footer_image_logo[2]/2;
			}
			
		$html_logo .= '<div class="content_logo">';
		$html_logo .= '	<a class="logo_href" href="' . home_url() . '">';
		$html_logo .= '		<img src="' . $pp_footer_logo_retina . '" alt="" width="' . $pp_footer_logo_retina_width . '" height="' . $pp_footer_logo_retina_height . '"/>';
		$html_logo .= '	</a>';
		$html_logo .= '</div>';
		
		}
		else //if not retina logo
		{

		$html_logo .= '<div class="content_logo">';
		$html_logo .= '	<a class="logo_href" href="' . home_url() . '">';
		$html_logo .= '		<img src="' . $pp_footer_logo . '" alt=""/>';
		$html_logo .= '	</a>';
		$html_logo .= '</div>';

		}
		# } Logo
		
		# Social {
		/*$html_return_social 			= '';
		$html_return_social 			= '<div class="content_social"><h4 class="folou_us">'. __('FOLLOW US', THEMEDOMAIN).'</h4> ';
		//Check if open link in new window
		$pp_footer_social_link_blank 	= get_option('pp_footer_social_link_blank');
		$html_return_social .= '<ul class="social_icons">';
		$pp_facebook_username 			= get_option('pp_facebook_username');
		
		if(!empty($pp_facebook_username))
		{
			$html_return_social .= '<li class="facebook"><a ';
			//if(!empty($pp_footer_social_link_blank)) {
				$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= ' href="' . $pp_facebook_username . '"><i class="fa fa-facebook"></i></a></li>';
		}
		
		$pp_twitter_username = get_option('pp_twitter_username');
		if(!empty($pp_twitter_username))
		{
			$html_return_social .= '<li class="twitter"><a ';
			//if(!empty($pp_footer_social_link_blank)) { 
				$html_return_social .= 'target="_blank"';
			//} 
			$html_return_social .= ' href="http://twitter.com/'.$pp_twitter_username.'"><i class="fa fa-twitter"></i></a></li>';
		}
		
		$pp_flickr_username = get_option('pp_flickr_username');
		if(!empty($pp_flickr_username))
		{
			$html_return_social .= '<li class="flickr"><a ';
			//if(!empty($pp_footer_social_link_blank)) { 
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= ' title="Flickr" href="http://flickr.com/people/'.$pp_flickr_username.'"><i class="fa fa-flickr"></i></a></li>';
		}
		
		$pp_youtube_username = get_option('pp_youtube_username');
		if(!empty($pp_youtube_username))
		{
			$html_return_social .= '<li class="youtube"><a ';
			//if(!empty($pp_footer_social_link_blank)) { 
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= ' title="Youtube" href="http://youtube.com/channel/'.$pp_youtube_username.'"><i class="fa fa-youtube"></i></a></li>';
		}
		
		$pp_vimeo_username = get_option('pp_vimeo_username');
		if(!empty($pp_vimeo_username))
		{
			$html_return_social .= '<li class="vimeo"><a ';
			//if(!empty($pp_footer_social_link_blank)) { 
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= ' title="Vimeo" href="http://vimeo.com/'.$pp_vimeo_username.'"><i class="fa fa-vimeo-square"></i></a></li>';
		}
		
		$pp_tumblr_username = get_option('pp_tumblr_username');
		if(!empty($pp_tumblr_username))
		{
			$html_return_social .= '<li class="tumblr"><a ';
			//if(!empty($pp_footer_social_link_blank)) { 
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= 'title="Tumblr" href="http://'.$pp_tumblr_username.'.tumblr.com"><i class="fa fa-tumblr"></i></a></li>';
		}
		
		$pp_google_username = get_option('pp_google_username');
		if(!empty($pp_google_username))
		{
			$html_return_social .= '<li class="google"><a ';
			//if(!empty($pp_footer_social_link_blank)) {
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= ' title="Google+" href="'.$pp_google_username.'"><i class="fa fa-google-plus"></i></a></li>';
		}
		
		$pp_dribbble_username = get_option('pp_dribbble_username');
		if(!empty($pp_dribbble_username))
		{
			$html_return_social .= '<li class="dribbble"><a ';
			//if(!empty($pp_footer_social_link_blank)) { 
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= 'title="Dribbble" href="http://dribbble.com/'.$pp_dribbble_username.'"><i class="fa fa-dribbble"></i></a></li>';
		}
		
		$pp_linkedin_username = get_option('pp_linkedin_username');
		if(!empty($pp_linkedin_username))
		{
			$html_return_social .= '<li class="linkedin"><a ';
			//if(!empty($pp_footer_social_link_blank)) {
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= 'title="Linkedin" href="'.$pp_linkedin_username.'"><i class="fa fa-linkedin"></i></a></li>';
		}
		
		$pp_pinterest_username = get_option('pp_pinterest_username');
		if(!empty($pp_pinterest_username))
		{
			$html_return_social .= '<li class="pinterest"><a ';
			//if(!empty($pp_footer_social_link_blank)) { 
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= 'title="Pinterest" href="http://pinterest.com/'.$pp_pinterest_username.'"><i class="fa fa-pinterest"></i></a></li>';
		}
		
		$pp_instagram_username = get_option('pp_instagram_username');
		if(!empty($pp_instagram_username))
		{
			$html_return_social .= '<li class="instagram"><a ';
			//if(!empty($pp_footer_social_link_blank)) { 
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= 'title="Instagram" href="http://instagram.com/'.$pp_instagram_username.'"><i class="fa fa-instagram"></i></a></li>';
		}
		
		$pp_behance_username = get_option('pp_behance_username');
		if(!empty($pp_behance_username))
		{
			$html_return_social .= '<li class="behance"><a ';
			//if(!empty($pp_topbar_social_link_blank)) { 
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= 'title="Behance" href="http://behance.net/'.$pp_behance_username.'"><i class="fa fa-behance-square"></i></a></li>';
		}
		
		$pp_tripadvisor_url = get_option('pp_tripadvisor_url');
		if(!empty($pp_tripadvisor_url))
		{
			$html_return_social .= '<li class="tripadvisor"><a ';
			//if(!empty($pp_footer_social_link_blank)) { 
			$html_return_social .= 'target="_blank"';
			//}
			$html_return_social .= ' title="Tripadvisor" href="'.$pp_tripadvisor_url.'"><i class="fa fa-tripadvisor"></i></a></li>';
		}
		$html_return_social .= '</ul></div>';*/
		# } Social
		
		
		$pp_footer_row_style = (int)get_option('pp_footer_row_style');
		
	    $row_first 	= false;
		$row_second = false;
		$row_third 	= false;
		$row_fourth = false;
	    	
		switch($pp_footer_row_style)
		{
			case 1:
				$row_first 	= true;
				$row_second = false;
				$row_third 	= false;
				$row_fourth = false;
			break;
			case 2:
				$row_first 	= true;
				$row_second = true;
				$row_third 	= false;
				$row_fourth = false;
			break;
			case 3:
				$row_first 	= true;
				$row_second = true;
				$row_third 	= true;
				$row_fourth = false;
			break;
			case 4:
				$row_first 	= true;
				$row_second = true;
				$row_third 	= true;
				$row_fourth = true;
			break;
			default:
				$row_first 	= false;
				$row_second = false;
				$row_third 	= false;
				$row_fourth = false;
			break;
		}
		
		# ROW FIRST {
		if($row_first===true)
		{
			$pp_footer_first_colum_style = (int) get_option('pp_footer_first_colum_style');
			
			$first_colum_first 	= false;
			$first_colum_second = false;
			$first_colum_third 	= false;
			$first_colum_fourth = false;
				
			switch($pp_footer_first_colum_style)
			{
				case 1:
					$first_colum_first 	= true;
					$first_colum_second = false;
					$first_colum_third 	= false;
					$first_colum_fourth = false;
					$first_width_cols = 'col-md col-md-12';
				break;
				case 2:
					$first_colum_first 	= true;
					$first_colum_second = true;
					$first_colum_third 	= false;
					$first_colum_fourth = false;
					$first_width_cols = 'col-md col-md-6';
				break;
				case 3:
					$first_colum_first 	= true;
					$first_colum_second = true;
					$first_colum_third 	= true;
					$first_colum_fourth = false;
					$first_width_cols = 'col-md col-md-4';
				break;
				case 4:
					$first_colum_first 	= true;
					$first_colum_second = true;
					$first_colum_third 	= true;
					$first_colum_fourth = true;
					$first_width_cols = 'col-md col-md-3';
				break;
				default:
					$first_colum_first 	= false;
					$first_colum_second = false;
					$first_colum_third 	= false;
					$first_colum_fourth = false;
					$first_width_cols = '';
				break;
			}
			
			$pp_footer_first_row_column_one 			= stripslashes(get_option('pp_footer_first_row_column_one'));
			$pp_footer_first_row_column_two 			= stripslashes(get_option('pp_footer_first_row_column_two'));
			$pp_footer_first_row_column_three 			= stripslashes(get_option('pp_footer_first_row_column_three'));
			$pp_footer_first_row_column_four 			= stripslashes(get_option('pp_footer_first_row_column_four'));
			$pp_footer_first_show_short_code 			= get_option('pp_footer_first_show_short_code');
			$pp_footer_first_into_colum_code 			= (int) get_option('pp_footer_first_into_colum_code');
			$pp_footer_first_short_code 				= get_option('pp_footer_first_short_code');
			$pp_footer_first_social_display 			= get_option('pp_footer_first_social_display');
			$pp_footer_first_into_colum_social 			= (int) get_option('pp_footer_first_into_colum_social');
			$pp_footer_first_social_link_blank 			= get_option('pp_footer_first_social_link_blank');
			$pp_footer_first_separating_horizontal_line = get_option('pp_footer_first_separating_horizontal_line');
			$pp_footer_first_show_languages 			= get_option('pp_footer_first_show_languages');
			$pp_footer_first_column_show_languages 		= (int) get_option('pp_footer_first_column_show_languages');
			$pp_footer_first_show_logo 					= get_option('pp_footer_first_show_logo');
			$pp_footer_first_column_show_logo 			= (int) get_option('pp_footer_first_column_show_logo');
			$pp_footer_first_bg_color 					= get_option('pp_footer_first_bg_color');
			$pp_footer_first_header_color 				= get_option('pp_footer_first_header_color');
			$pp_footer_first_font_color 				= get_option('pp_footer_first_font_color');
			$pp_footer_first_link_color 				= get_option('pp_footer_first_link_color');
			$pp_footer_first_hover_link_color 			= get_option('pp_footer_first_hover_link_color');
			
			
			# Social {
			$html_return_social 			= '';
			$html_return_social 			= '<div class="content_social"><h4 class="folou_us">'. __('FOLLOW US', THEMEDOMAIN).'</h4> ';
			//Check if open link in new window
			$html_return_social .= '<ul class="social_icons">';
			
			$pp_facebook_username 			= get_option('pp_facebook_username');
			if(!empty($pp_facebook_username))
			{
				$html_return_social .= '<li class="facebook"><a ';
				if(!empty($pp_footer_first_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' href="' . $pp_facebook_username . '"><i class="fa fa-facebook"></i></a></li>';
			}
			
			$pp_twitter_username = get_option('pp_twitter_username');
			if(!empty($pp_twitter_username))
			{
				$html_return_social .= '<li class="twitter"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				} 
				$html_return_social .= ' href="http://twitter.com/'.$pp_twitter_username.'"><i class="fa fa-twitter"></i></a></li>';
			}
			
			$pp_flickr_username = get_option('pp_flickr_username');
			if(!empty($pp_flickr_username))
			{
				$html_return_social .= '<li class="flickr"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Flickr" href="http://flickr.com/people/'.$pp_flickr_username.'"><i class="fa fa-flickr"></i></a></li>';
			}
			
			$pp_youtube_username = get_option('pp_youtube_username');
			if(!empty($pp_youtube_username))
			{
				$html_return_social .= '<li class="youtube"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Youtube" href="http://youtube.com/channel/'.$pp_youtube_username.'"><i class="fa fa-youtube"></i></a></li>';
			}
			
			$pp_vimeo_username = get_option('pp_vimeo_username');
			if(!empty($pp_vimeo_username))
			{
				$html_return_social .= '<li class="vimeo"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Vimeo" href="http://vimeo.com/'.$pp_vimeo_username.'"><i class="fa fa-vimeo-square"></i></a></li>';
			}
			
			$pp_tumblr_username = get_option('pp_tumblr_username');
			if(!empty($pp_tumblr_username))
			{
				$html_return_social .= '<li class="tumblr"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Tumblr" href="http://'.$pp_tumblr_username.'.tumblr.com"><i class="fa fa-tumblr"></i></a></li>';
			}
			
			$pp_google_username = get_option('pp_google_username');
			if(!empty($pp_google_username))
			{
				$html_return_social .= '<li class="google"><a ';
				if(!empty($pp_footer_first_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Google+" href="'.$pp_google_username.'"><i class="fa fa-google-plus"></i></a></li>';
			}
			
			$pp_dribbble_username = get_option('pp_dribbble_username');
			if(!empty($pp_dribbble_username))
			{
				$html_return_social .= '<li class="dribbble"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Dribbble" href="http://dribbble.com/'.$pp_dribbble_username.'"><i class="fa fa-dribbble"></i></a></li>';
			}
			
			$pp_linkedin_username = get_option('pp_linkedin_username');
			if(!empty($pp_linkedin_username))
			{
				$html_return_social .= '<li class="linkedin"><a ';
				if(!empty($pp_footer_first_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Linkedin" href="'.$pp_linkedin_username.'"><i class="fa fa-linkedin"></i></a></li>';
			}
			
			$pp_pinterest_username = get_option('pp_pinterest_username');
			if(!empty($pp_pinterest_username))
			{
				$html_return_social .= '<li class="pinterest"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Pinterest" href="http://pinterest.com/'.$pp_pinterest_username.'"><i class="fa fa-pinterest"></i></a></li>';
			}
			
			$pp_instagram_username = get_option('pp_instagram_username');
			if(!empty($pp_instagram_username))
			{
				$html_return_social .= '<li class="instagram"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Instagram" href="http://instagram.com/'.$pp_instagram_username.'"><i class="fa fa-instagram"></i></a></li>';
			}
			
			$pp_behance_username = get_option('pp_behance_username');
			if(!empty($pp_behance_username))
			{
				$html_return_social .= '<li class="behance"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Behance" href="http://behance.net/'.$pp_behance_username.'"><i class="fa fa-behance-square"></i></a></li>';
			}
			
			$pp_tripadvisor_url = get_option('pp_tripadvisor_url');
			if(!empty($pp_tripadvisor_url))
			{
				$html_return_social .= '<li class="tripadvisor"><a ';
				if(!empty($pp_footer_first_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Tripadvisor" href="'.$pp_tripadvisor_url.'"><i class="fa fa-tripadvisor"></i></a></li>';
			}
			$html_return_social .= '</ul></div>';
			# } Social
			
		
			# logo
			$first_colum_first_logo 	= '';
			$first_colum_second_logo 	= '';
			$first_colum_third_logo 	= '';
			$first_colum_fourth_logo 	= '';
				
			switch($pp_footer_first_column_show_logo)
			{
				case 1:
					$first_colum_first_logo 	= $html_logo;
					$first_colum_second_logo 	= '';
					$first_colum_third_logo 	= '';
					$first_colum_fourth_logo 	= '';
				break;
				case 2:
					$first_colum_first_logo 	= '';
					$first_colum_second_logo 	= $html_logo;
					$first_colum_third_logo 	= '';
					$first_colum_fourth_logo 	= '';
				break;
				case 3:
					$first_colum_first_logo 	= '';
					$first_colum_second_logo 	= '';
					$first_colum_third_logo 	= $html_logo;
					$first_colum_fourth_logo 	= '';
				break;
				case 4:
					$first_colum_first_logo 	= '';
					$first_colum_second_logo 	= '';
					$first_colum_third_logo 	= '';
					$first_colum_fourth_logo 	= $html_logo;
				break;
				default:
					$first_colum_first_logo 	= '';
					$first_colum_second_logo 	= '';
					$first_colum_third_logo 	= '';
					$first_colum_fourth_logo 	= '';
				break;
			}
			
			# Social
			$first_colum_first_social 	= '';
			$first_colum_second_social 	= '';
			$first_colum_third_social 	= '';
			$first_colum_fourth_social 	= '';
			
			if(!empty($pp_footer_first_social_display))
			{
				switch($pp_footer_first_into_colum_social)
				{
					case 1:
						$first_colum_first_social 	= $html_return_social;
						$first_colum_second_social 	= '';
						$first_colum_third_social 	= '';
						$first_colum_fourth_social 	= '';
					break;
					case 2:
						$first_colum_first_social 	= '';
						$first_colum_second_social 	= $html_return_social;
						$first_colum_third_social 	= '';
						$first_colum_fourth_social 	= '';
					break;
					case 3:
						$first_colum_first_social 	= '';
						$first_colum_second_social 	= '';
						$first_colum_third_social 	= $html_return_social;
						$first_colum_fourth_social 	= '';
					break;
					case 4:
						$first_colum_first_social 	= '';
						$first_colum_second_social 	= '';
						$first_colum_third_social 	= '';
						$first_colum_fourth_social 	= $html_return_social;
					break;
					default:
						$first_colum_first_social 	= '';
						$first_colum_second_social 	= '';
						$first_colum_third_social 	= '';
						$first_colum_fourth_social 	= '';
					break;
				}
			}
		
			$html_return_footer .= '<div class="row row-1">';
			if($first_colum_first === true)
			{
				$html_return_footer .= '	<div class="col col-1 ' . $first_width_cols . '">' . $first_colum_first_logo . $pp_footer_first_row_column_one . $first_colum_first_social . '</div>';
			}
			if($first_colum_second === true)
			{
				$html_return_footer .= '	<div class="col col-2 ' . $first_width_cols . '">' . $first_colum_second_logo . $pp_footer_first_row_column_two . $first_colum_second_social .'</div>';
			}
			if($first_colum_third === true)
			{
				$html_return_footer .= '	<div class="col col-3 ' . $first_width_cols . '">' . $first_colum_third_logo . $pp_footer_first_row_column_three . $first_colum_third_social . '</div>';
			}
			if($first_colum_fourth === true)
			{
				$html_return_footer .= '	<div class="col col-4 ' . $first_width_cols . '">' . $first_colum_fourth_logo . $pp_footer_first_row_column_four . $first_colum_fourth_social . '</div>';
			}
			$html_return_footer .= '</div>';
		
			if(!empty($pp_footer_first_separating_horizontal_line))
			{
				$html_return_footer .= '<div class="separator"></div>';
			}
		}
		# } ROW FIRST
		
		# ROW SECOND {
		if($row_second===true)
		{
			$pp_footer_second_colum_style = (int) get_option('pp_footer_second_colum_style');
			
			$second_colum_first 	= false;
			$second_colum_second 	= false;
			$second_colum_third 	= false;
			$second_colum_fourth 	= false;
			$second_width_cols 		= '';
				
			switch($pp_footer_second_colum_style)
			{
				case 1:
					$second_colum_first 	= true;
					$second_colum_second = false;
					$second_colum_third 	= false;
					$second_colum_fourth = false;
					$second_width_cols = 'col-md col-md-12';
				break;
				case 2:
					$second_colum_first 	= true;
					$second_colum_second = true;
					$second_colum_third 	= false;
					$second_colum_fourth = false;
					$second_width_cols = 'col-md col-md-6';
				break;
				case 3:
					$second_colum_first 	= true;
					$second_colum_second = true;
					$second_colum_third 	= true;
					$second_colum_fourth = false;
					$second_width_cols = 'col-md col-md-4';
				break;
				case 4:
					$second_colum_first 	= true;
					$second_colum_second = true;
					$second_colum_third 	= true;
					$second_colum_fourth = true;
					$second_width_cols = 'col-md col-md-3';
				break;
				default:
					$second_colum_first 	= false;
					$second_colum_second = false;
					$second_colum_third 	= false;
					$second_colum_fourth = false;
				break;
			}
			
			$pp_footer_second_row_column_one 			= stripslashes(get_option('pp_footer_second_row_column_one'));
			$pp_footer_second_row_column_two 			= stripslashes(get_option('pp_footer_second_row_column_two'));
			$pp_footer_second_row_column_three 			= stripslashes(get_option('pp_footer_second_row_column_three'));
			$pp_footer_second_row_column_four 			= stripslashes(get_option('pp_footer_second_row_column_four'));
			$pp_footer_second_show_short_code 			= get_option('pp_footer_second_show_short_code');
			$pp_footer_second_into_colum_code 			= (int) get_option('pp_footer_second_into_colum_code');
			$pp_footer_second_short_code 				= get_option('pp_footer_second_short_code');
			$pp_footer_second_social_display 			= get_option('pp_footer_second_social_display');
			$pp_footer_second_into_colum_social 		= (int) get_option('pp_footer_second_into_colum_social');
			$pp_footer_second_social_link_blank 		= get_option('pp_footer_second_social_link_blank');
			$pp_footer_second_separating_horizontal_line = get_option('pp_footer_second_separating_horizontal_line');
			$pp_footer_second_show_languages 			= get_option('pp_footer_second_show_languages');
			$pp_footer_second_column_show_languages 	= (int) get_option('pp_footer_second_column_show_languages');
			$pp_footer_second_show_logo 				= get_option('pp_footer_second_show_logo');
			$pp_footer_second_column_show_logo 			= (int) get_option('pp_footer_second_column_show_logo');
			$pp_footer_second_bg_color 					= get_option('pp_footer_second_bg_color');
			$pp_footer_second_header_color 				= get_option('pp_footer_second_header_color');
			$pp_footer_second_font_color 				= get_option('pp_footer_second_font_color');
			$pp_footer_second_link_color 				= get_option('pp_footer_second_link_color');
			$pp_footer_second_hover_link_color 			= get_option('pp_footer_second_hover_link_color');
			
			# Social {
			$html_return_social 			= '';
			$html_return_social 			= '<div class="content_social"><h4 class="folou_us">'. __('FOLLOW US', THEMEDOMAIN).'</h4> ';
			//Check if open link in new window
			$html_return_social .= '<ul class="social_icons">';
			
			$pp_facebook_username 			= get_option('pp_facebook_username');
			if(!empty($pp_facebook_username))
			{
				$html_return_social .= '<li class="facebook"><a ';
				if(!empty($pp_footer_second_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' href="' . $pp_facebook_username . '"><i class="fa fa-facebook"></i></a></li>';
			}
			
			$pp_twitter_username = get_option('pp_twitter_username');
			if(!empty($pp_twitter_username))
			{
				$html_return_social .= '<li class="twitter"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				} 
				$html_return_social .= ' href="http://twitter.com/'.$pp_twitter_username.'"><i class="fa fa-twitter"></i></a></li>';
			}
			
			$pp_flickr_username = get_option('pp_flickr_username');
			if(!empty($pp_flickr_username))
			{
				$html_return_social .= '<li class="flickr"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Flickr" href="http://flickr.com/people/'.$pp_flickr_username.'"><i class="fa fa-flickr"></i></a></li>';
			}
			
			$pp_youtube_username = get_option('pp_youtube_username');
			if(!empty($pp_youtube_username))
			{
				$html_return_social .= '<li class="youtube"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Youtube" href="http://youtube.com/channel/'.$pp_youtube_username.'"><i class="fa fa-youtube"></i></a></li>';
			}
			
			$pp_vimeo_username = get_option('pp_vimeo_username');
			if(!empty($pp_vimeo_username))
			{
				$html_return_social .= '<li class="vimeo"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Vimeo" href="http://vimeo.com/'.$pp_vimeo_username.'"><i class="fa fa-vimeo-square"></i></a></li>';
			}
			
			$pp_tumblr_username = get_option('pp_tumblr_username');
			if(!empty($pp_tumblr_username))
			{
				$html_return_social .= '<li class="tumblr"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Tumblr" href="http://'.$pp_tumblr_username.'.tumblr.com"><i class="fa fa-tumblr"></i></a></li>';
			}
			
			$pp_google_username = get_option('pp_google_username');
			if(!empty($pp_google_username))
			{
				$html_return_social .= '<li class="google"><a ';
				if(!empty($pp_footer_second_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Google+" href="'.$pp_google_username.'"><i class="fa fa-google-plus"></i></a></li>';
			}
			
			$pp_dribbble_username = get_option('pp_dribbble_username');
			if(!empty($pp_dribbble_username))
			{
				$html_return_social .= '<li class="dribbble"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Dribbble" href="http://dribbble.com/'.$pp_dribbble_username.'"><i class="fa fa-dribbble"></i></a></li>';
			}
			
			$pp_linkedin_username = get_option('pp_linkedin_username');
			if(!empty($pp_linkedin_username))
			{
				$html_return_social .= '<li class="linkedin"><a ';
				if(!empty($pp_footer_second_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Linkedin" href="'.$pp_linkedin_username.'"><i class="fa fa-linkedin"></i></a></li>';
			}
			
			$pp_pinterest_username = get_option('pp_pinterest_username');
			if(!empty($pp_pinterest_username))
			{
				$html_return_social .= '<li class="pinterest"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Pinterest" href="http://pinterest.com/'.$pp_pinterest_username.'"><i class="fa fa-pinterest"></i></a></li>';
			}
			
			$pp_instagram_username = get_option('pp_instagram_username');
			if(!empty($pp_instagram_username))
			{
				$html_return_social .= '<li class="instagram"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Instagram" href="http://instagram.com/'.$pp_instagram_username.'"><i class="fa fa-instagram"></i></a></li>';
			}
			
			$pp_behance_username = get_option('pp_behance_username');
			if(!empty($pp_behance_username))
			{
				$html_return_social .= '<li class="behance"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Behance" href="http://behance.net/'.$pp_behance_username.'"><i class="fa fa-behance-square"></i></a></li>';
			}
			
			$pp_tripadvisor_url = get_option('pp_tripadvisor_url');
			if(!empty($pp_tripadvisor_url))
			{
				$html_return_social .= '<li class="tripadvisor"><a ';
				if(!empty($pp_footer_second_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Tripadvisor" href="'.$pp_tripadvisor_url.'"><i class="fa fa-tripadvisor"></i></a></li>';
			}
			$html_return_social .= '</ul></div>';
			# } Social
		
			# logo
			$second_colum_first_logo 	= '';
			$second_colum_second_logo 	= '';
			$second_colum_third_logo 	= '';
			$second_colum_fourth_logo 	= '';
				
			switch($pp_footer_second_column_show_logo)
			{
				case 1:
					$second_colum_first_logo 	= $html_logo;
					$second_colum_second_logo 	= '';
					$second_colum_third_logo 	= '';
					$second_colum_fourth_logo 	= '';
				break;
				case 2:
					$second_colum_first_logo 	= '';
					$second_colum_second_logo 	= $html_logo;
					$second_colum_third_logo 	= '';
					$second_colum_fourth_logo 	= '';
				break;
				case 3:
					$second_colum_first_logo 	= '';
					$second_colum_second_logo 	= '';
					$second_colum_third_logo 	= $html_logo;
					$second_colum_fourth_logo 	= '';
				break;
				case 4:
					$second_colum_first_logo 	= '';
					$second_colum_second_logo 	= '';
					$second_colum_third_logo 	= '';
					$second_colum_fourth_logo 	= $html_logo;
				break;
				default:
					$second_colum_first_logo 	= '';
					$second_colum_second_logo 	= '';
					$second_colum_third_logo 	= '';
					$second_colum_fourth_logo 	= '';
				break;
			}
			
			# Social
			$second_colum_first_social 	= '';
			$second_colum_second_social 	= '';
			$second_colum_third_social 	= '';
			$second_colum_fourth_social 	= '';
			
			if(!empty($pp_footer_second_social_display))
			{
				switch($pp_footer_second_into_colum_social)
				{
					case 1:
						$second_colum_first_social 	= $html_return_social;
						$second_colum_second_social 	= '';
						$second_colum_third_social 	= '';
						$second_colum_fourth_social 	= '';
					break;
					case 2:
						$second_colum_first_social 	= '';
						$second_colum_second_social 	= $html_return_social;
						$second_colum_third_social 	= '';
						$second_colum_fourth_social 	= '';
					break;
					case 3:
						$second_colum_first_social 	= '';
						$second_colum_second_social 	= '';
						$second_colum_third_social 	= $html_return_social;
						$second_colum_fourth_social 	= '';
					break;
					case 4:
						$second_colum_first_social 	= '';
						$second_colum_second_social 	= '';
						$second_colum_third_social 	= '';
						$second_colum_fourth_social 	= $html_return_social;
					break;
					default:
						$second_colum_first_social 	= '';
						$second_colum_second_social 	= '';
						$second_colum_third_social 	= '';
						$second_colum_fourth_social 	= '';
					break;
				}
			}
		
			$html_return_footer .= '<div class="row row-2">';
			if($second_colum_first === true)
			{
				$html_return_footer .= '	<div class="col col-1 ' . $second_width_cols . '">' . $second_colum_first_logo . $pp_footer_second_row_column_one . $second_colum_first_social . '</div>';
			}
			if($second_colum_second === true)
			{
				$html_return_footer .= '	<div class="col col-2 ' . $second_width_cols . '">' . $second_colum_second_logo . $pp_footer_second_row_column_two . $second_colum_second_social .'</div>';
			}
			if($second_colum_third === true)
			{
				$html_return_footer .= '	<div class="col col-3 ' . $second_width_cols . '">' . $second_colum_third_logo . $pp_footer_second_row_column_three . $second_colum_third_social . '</div>';
			}
			if($second_colum_fourth === true)
			{
				$html_return_footer .= '	<div class="col col-4 ' . $second_width_cols . '">' . $second_colum_fourth_logo . $pp_footer_second_row_column_four . $second_colum_fourth_social . '</div>';
			}
			$html_return_footer .= '</div>';
		
			if(!empty($pp_footer_second_separating_horizontal_line))
			{
				$html_return_footer .= '<div class="separator"></div>';
			}
		}
		# } ROW SECOND
		
		# ROW Third {
		if($row_third===true)
		{
			$pp_footer_third_colum_style = (int) get_option('pp_footer_third_colum_style');
			
			$third_colum_first 	= false;
			$third_colum_second 	= false;
			$third_colum_third 	= false;
			$third_colum_fourth 	= false;
			$third_width_cols 		= '';
				
			switch($pp_footer_third_colum_style)
			{
				case 1:
					$third_colum_first 	= true;
					$third_colum_second = false;
					$third_colum_third 	= false;
					$third_colum_fourth = false;
					$third_width_cols = 'col-md col-md-12';
				break;
				case 2:
					$third_colum_first 	= true;
					$third_colum_second = true;
					$third_colum_third 	= false;
					$third_colum_fourth = false;
					$third_width_cols = 'col-md col-md-6';
				break;
				case 3:
					$third_colum_first 	= true;
					$third_colum_second = true;
					$third_colum_third 	= true;
					$third_colum_fourth = false;
					$third_width_cols = 'col-md col-md-4';
				break;
				case 4:
					$third_colum_first 	= true;
					$third_colum_second = true;
					$third_colum_third 	= true;
					$third_colum_fourth = true;
					$third_width_cols = 'col-md col-md-3';
				break;
				default:
					$third_colum_first 	= false;
					$third_colum_second = false;
					$third_colum_third 	= false;
					$third_colum_fourth = false;
				break;
			}
			
			$pp_footer_third_row_column_one 			= stripslashes(get_option('pp_footer_third_row_column_one'));
			$pp_footer_third_row_column_two 			= stripslashes(get_option('pp_footer_third_row_column_two'));
			$pp_footer_third_row_column_three 			= stripslashes(get_option('pp_footer_third_row_column_three'));
			$pp_footer_third_row_column_four 			= stripslashes(get_option('pp_footer_third_row_column_four'));
			$pp_footer_third_show_short_code 			= get_option('pp_footer_third_show_short_code');
				$pp_footer_third_into_colum_code 		= (int) get_option('pp_footer_third_into_colum_code');
			$pp_footer_third_short_code 				= get_option('pp_footer_third_short_code');
			$pp_footer_third_social_display 			= get_option('pp_footer_third_social_display');
				$pp_footer_third_into_colum_social 		= (int) get_option('pp_footer_third_into_colum_social');
			$pp_footer_third_social_link_blank 			= get_option('pp_footer_third_social_link_blank');
			$pp_footer_third_separating_horizontal_line = get_option('pp_footer_third_separating_horizontal_line');
			$pp_footer_third_show_languages 			= get_option('pp_footer_third_show_languages');
				$pp_footer_third_column_show_languages 	= (int) get_option('pp_footer_third_column_show_languages');
			$pp_footer_third_show_logo 					= get_option('pp_footer_third_show_logo');
				$pp_footer_third_column_show_logo 		= (int) get_option('pp_footer_third_column_show_logo');
			$pp_footer_third_bg_color 					= get_option('pp_footer_third_bg_color');
			$pp_footer_third_header_color 				= get_option('pp_footer_third_header_color');
			$pp_footer_third_font_color 				= get_option('pp_footer_third_font_color');
			$pp_footer_third_link_color 				= get_option('pp_footer_third_link_color');
			$pp_footer_third_hover_link_color 			= get_option('pp_footer_third_hover_link_color');
		
			# Social {
			$html_return_social 			= '';
			$html_return_social 			= '<div class="content_social"><h4 class="folou_us">'. __('FOLLOW US', THEMEDOMAIN).'</h4> ';
			//Check if open link in new window
			$html_return_social .= '<ul class="social_icons">';
			
			$pp_facebook_username 			= get_option('pp_facebook_username');
			if(!empty($pp_facebook_username))
			{
				$html_return_social .= '<li class="facebook"><a ';
				if(!empty($pp_footer_third_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' href="' . $pp_facebook_username . '"><i class="fa fa-facebook"></i></a></li>';
			}
			
			$pp_twitter_username = get_option('pp_twitter_username');
			if(!empty($pp_twitter_username))
			{
				$html_return_social .= '<li class="twitter"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				} 
				$html_return_social .= ' href="http://twitter.com/'.$pp_twitter_username.'"><i class="fa fa-twitter"></i></a></li>';
			}
			
			$pp_flickr_username = get_option('pp_flickr_username');
			if(!empty($pp_flickr_username))
			{
				$html_return_social .= '<li class="flickr"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Flickr" href="http://flickr.com/people/'.$pp_flickr_username.'"><i class="fa fa-flickr"></i></a></li>';
			}
			
			$pp_youtube_username = get_option('pp_youtube_username');
			if(!empty($pp_youtube_username))
			{
				$html_return_social .= '<li class="youtube"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Youtube" href="http://youtube.com/channel/'.$pp_youtube_username.'"><i class="fa fa-youtube"></i></a></li>';
			}
			
			$pp_vimeo_username = get_option('pp_vimeo_username');
			if(!empty($pp_vimeo_username))
			{
				$html_return_social .= '<li class="vimeo"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Vimeo" href="http://vimeo.com/'.$pp_vimeo_username.'"><i class="fa fa-vimeo-square"></i></a></li>';
			}
			
			$pp_tumblr_username = get_option('pp_tumblr_username');
			if(!empty($pp_tumblr_username))
			{
				$html_return_social .= '<li class="tumblr"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Tumblr" href="http://'.$pp_tumblr_username.'.tumblr.com"><i class="fa fa-tumblr"></i></a></li>';
			}
			
			$pp_google_username = get_option('pp_google_username');
			if(!empty($pp_google_username))
			{
				$html_return_social .= '<li class="google"><a ';
				if(!empty($pp_footer_third_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Google+" href="'.$pp_google_username.'"><i class="fa fa-google-plus"></i></a></li>';
			}
			
			$pp_dribbble_username = get_option('pp_dribbble_username');
			if(!empty($pp_dribbble_username))
			{
				$html_return_social .= '<li class="dribbble"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Dribbble" href="http://dribbble.com/'.$pp_dribbble_username.'"><i class="fa fa-dribbble"></i></a></li>';
			}
			
			$pp_linkedin_username = get_option('pp_linkedin_username');
			if(!empty($pp_linkedin_username))
			{
				$html_return_social .= '<li class="linkedin"><a ';
				if(!empty($pp_footer_third_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Linkedin" href="'.$pp_linkedin_username.'"><i class="fa fa-linkedin"></i></a></li>';
			}
			
			$pp_pinterest_username = get_option('pp_pinterest_username');
			if(!empty($pp_pinterest_username))
			{
				$html_return_social .= '<li class="pinterest"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Pinterest" href="http://pinterest.com/'.$pp_pinterest_username.'"><i class="fa fa-pinterest"></i></a></li>';
			}
			
			$pp_instagram_username = get_option('pp_instagram_username');
			if(!empty($pp_instagram_username))
			{
				$html_return_social .= '<li class="instagram"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Instagram" href="http://instagram.com/'.$pp_instagram_username.'"><i class="fa fa-instagram"></i></a></li>';
			}
			
			$pp_behance_username = get_option('pp_behance_username');
			if(!empty($pp_behance_username))
			{
				$html_return_social .= '<li class="behance"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Behance" href="http://behance.net/'.$pp_behance_username.'"><i class="fa fa-behance-square"></i></a></li>';
			}
			
			$pp_tripadvisor_url = get_option('pp_tripadvisor_url');
			if(!empty($pp_tripadvisor_url))
			{
				$html_return_social .= '<li class="tripadvisor"><a ';
				if(!empty($pp_footer_third_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Tripadvisor" href="'.$pp_tripadvisor_url.'"><i class="fa fa-tripadvisor"></i></a></li>';
			}
			$html_return_social .= '</ul></div>';
			# } Social
			
			# logo
			$third_colum_first_logo 	= '';
			$third_colum_second_logo 	= '';
			$third_colum_third_logo 	= '';
			$third_colum_fourth_logo 	= '';
				
			switch($pp_footer_third_column_show_logo)
			{
				case 1:
					$third_colum_first_logo 	= $html_logo;
					$third_colum_second_logo 	= '';
					$third_colum_third_logo 	= '';
					$third_colum_fourth_logo 	= '';
				break;
				case 2:
					$third_colum_first_logo 	= '';
					$third_colum_second_logo 	= $html_logo;
					$third_colum_third_logo 	= '';
					$third_colum_fourth_logo 	= '';
				break;
				case 3:
					$third_colum_first_logo 	= '';
					$third_colum_second_logo 	= '';
					$third_colum_third_logo 	= $html_logo;
					$third_colum_fourth_logo 	= '';
				break;
				case 4:
					$third_colum_first_logo 	= '';
					$third_colum_second_logo 	= '';
					$third_colum_third_logo 	= '';
					$third_colum_fourth_logo 	= $html_logo;
				break;
				default:
					$third_colum_first_logo 	= '';
					$third_colum_second_logo 	= '';
					$third_colum_third_logo 	= '';
					$third_colum_fourth_logo 	= '';
				break;
			}
			
			# Social
			$third_colum_first_social 	= '';
			$third_colum_second_social 	= '';
			$third_colum_third_social 	= '';
			$third_colum_fourth_social 	= '';
			
			if(!empty($pp_footer_third_social_display))
			{
				switch($pp_footer_third_into_colum_social)
				{
					case 1:
						$third_colum_first_social 	= $html_return_social;
						$third_colum_second_social 	= '';
						$third_colum_third_social 	= '';
						$third_colum_fourth_social 	= '';
					break;
					case 2:
						$third_colum_first_social 	= '';
						$third_colum_second_social 	= $html_return_social;
						$third_colum_third_social 	= '';
						$third_colum_fourth_social 	= '';
					break;
					case 3:
						$third_colum_first_social 	= '';
						$third_colum_second_social 	= '';
						$third_colum_third_social 	= $html_return_social;
						$third_colum_fourth_social 	= '';
					break;
					case 4:
						$third_colum_first_social 	= '';
						$third_colum_second_social 	= '';
						$third_colum_third_social 	= '';
						$third_colum_fourth_social 	= $html_return_social;
					break;
					default:
						$third_colum_first_social 	= '';
						$third_colum_second_social 	= '';
						$third_colum_third_social 	= '';
						$third_colum_fourth_social 	= '';
					break;
				}
			}
		
			$html_return_footer .= '<div class="row row-3">';
			if($third_colum_first === true)
			{
				$html_return_footer .= '	<div class="col col-1 ' . $third_width_cols . '">' . $third_colum_first_logo . $pp_footer_third_row_column_one . $third_colum_first_social . '</div>';
			}
			if($third_colum_second === true)
			{
				$html_return_footer .= '	<div class="col col-2 ' . $third_width_cols . '">' . $third_colum_second_logo . $pp_footer_third_row_column_two . $third_colum_second_social .'</div>';
			}
			if($third_colum_third === true)
			{
				$html_return_footer .= '	<div class="col col-3 ' . $third_width_cols . '">' . $third_colum_third_logo . $pp_footer_third_row_column_three . $third_colum_third_social . '</div>';
			}
			if($third_colum_fourth === true)
			{
				$html_return_footer .= '	<div class="col col-4 ' . $third_width_cols . '">' . $third_colum_fourth_logo . $pp_footer_third_row_column_four . $third_colum_fourth_social . '</div>';
			}
			$html_return_footer .= '</div>';
		
			if(!empty($pp_footer_third_separating_horizontal_line))
			{
				$html_return_footer .= '<div class="separator"></div>';
			}
		}
		# } ROW Third
		
		# ROW Fourth {
		if($row_fourth===true)
		{
			$pp_footer_fourth_colum_style = (int) get_option('pp_footer_fourth_colum_style');
			
			$fourth_colum_first 	= false;
			$fourth_colum_second 	= false;
			$fourth_colum_third 	= false;
			$fourth_colum_fourth 	= false;
			$fourth_width_cols 		= '';
				
			switch($pp_footer_fourth_colum_style)
			{
				case 1:
					$fourth_colum_first 	= true;
					$fourth_colum_second = false;
					$fourth_colum_third 	= false;
					$fourth_colum_fourth = false;
					$fourth_width_cols = 'col-md col-md-12';
				break;
				case 2:
					$fourth_colum_first 	= true;
					$fourth_colum_second = true;
					$fourth_colum_third 	= false;
					$fourth_colum_fourth = false;
					$fourth_width_cols = 'col-md col-md-6';
				break;
				case 3:
					$fourth_colum_first 	= true;
					$fourth_colum_second = true;
					$fourth_colum_third 	= true;
					$fourth_colum_fourth = false;
					$fourth_width_cols = 'col-md col-md-4';
				break;
				case 4:
					$fourth_colum_first 	= true;
					$fourth_colum_second = true;
					$fourth_colum_third 	= true;
					$fourth_colum_fourth = true;
					$fourth_width_cols = 'col-md col-md-3';
				break;
				default:
					$fourth_colum_first 	= false;
					$fourth_colum_second = false;
					$fourth_colum_third 	= false;
					$fourth_colum_fourth = false;
				break;
			}
			
			$pp_footer_fourth_row_column_one 			= stripslashes(get_option('pp_footer_fourth_row_column_one'));
			$pp_footer_fourth_row_column_two 			= stripslashes(get_option('pp_footer_fourth_row_column_two'));
			$pp_footer_fourth_row_column_three 			= stripslashes(get_option('pp_footer_fourth_row_column_three'));
			$pp_footer_fourth_row_column_four 			= stripslashes(get_option('pp_footer_fourth_row_column_four'));
			$pp_footer_fourth_show_short_code 			= get_option('pp_footer_fourth_show_short_code');
				$pp_footer_fourth_into_colum_code 		= (int) get_option('pp_footer_fourth_into_colum_code');
			$pp_footer_fourth_short_code 				= get_option('pp_footer_fourth_short_code');
			$pp_footer_fourth_social_display 			= get_option('pp_footer_fourth_social_display');
				$pp_footer_fourth_into_colum_social 		= (int) get_option('pp_footer_fourth_into_colum_social');
			$pp_footer_fourth_social_link_blank 			= get_option('pp_footer_fourth_social_link_blank');
			$pp_footer_fourth_separating_horizontal_line = get_option('pp_footer_fourth_separating_horizontal_line');
			$pp_footer_fourth_show_languages 			= get_option('pp_footer_fourth_show_languages');
				$pp_footer_fourth_column_show_languages 	= (int) get_option('pp_footer_fourth_column_show_languages');
			$pp_footer_fourth_show_logo 					= get_option('pp_footer_fourth_show_logo');
				$pp_footer_fourth_column_show_logo 		= (int) get_option('pp_footer_fourth_column_show_logo');
			$pp_footer_fourth_bg_color 					= get_option('pp_footer_fourth_bg_color');
			$pp_footer_fourth_header_color 				= get_option('pp_footer_fourth_header_color');
			$pp_footer_fourth_font_color 				= get_option('pp_footer_fourth_font_color');
			$pp_footer_fourth_link_color 				= get_option('pp_footer_fourth_link_color');
			$pp_footer_fourth_hover_link_color 			= get_option('pp_footer_fourth_hover_link_color');
			
			# Social {
			$html_return_social 			= '';
			$html_return_social 			= '<div class="content_social"><h4 class="folou_us">'. __('FOLLOW US', THEMEDOMAIN).'</h4> ';
			//Check if open link in new window
			$html_return_social .= '<ul class="social_icons">';
			
			$pp_facebook_username 			= get_option('pp_facebook_username');
			if(!empty($pp_facebook_username))
			{
				$html_return_social .= '<li class="facebook"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' href="' . $pp_facebook_username . '"><i class="fa fa-facebook"></i></a></li>';
			}
			
			$pp_twitter_username = get_option('pp_twitter_username');
			if(!empty($pp_twitter_username))
			{
				$html_return_social .= '<li class="twitter"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				} 
				$html_return_social .= ' href="http://twitter.com/'.$pp_twitter_username.'"><i class="fa fa-twitter"></i></a></li>';
			}
			
			$pp_flickr_username = get_option('pp_flickr_username');
			if(!empty($pp_flickr_username))
			{
				$html_return_social .= '<li class="flickr"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Flickr" href="http://flickr.com/people/'.$pp_flickr_username.'"><i class="fa fa-flickr"></i></a></li>';
			}
			
			$pp_youtube_username = get_option('pp_youtube_username');
			if(!empty($pp_youtube_username))
			{
				$html_return_social .= '<li class="youtube"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Youtube" href="http://youtube.com/channel/'.$pp_youtube_username.'"><i class="fa fa-youtube"></i></a></li>';
			}
			
			$pp_vimeo_username = get_option('pp_vimeo_username');
			if(!empty($pp_vimeo_username))
			{
				$html_return_social .= '<li class="vimeo"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Vimeo" href="http://vimeo.com/'.$pp_vimeo_username.'"><i class="fa fa-vimeo-square"></i></a></li>';
			}
			
			$pp_tumblr_username = get_option('pp_tumblr_username');
			if(!empty($pp_tumblr_username))
			{
				$html_return_social .= '<li class="tumblr"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Tumblr" href="http://'.$pp_tumblr_username.'.tumblr.com"><i class="fa fa-tumblr"></i></a></li>';
			}
			
			$pp_google_username = get_option('pp_google_username');
			if(!empty($pp_google_username))
			{
				$html_return_social .= '<li class="google"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Google+" href="'.$pp_google_username.'"><i class="fa fa-google-plus"></i></a></li>';
			}
			
			$pp_dribbble_username = get_option('pp_dribbble_username');
			if(!empty($pp_dribbble_username))
			{
				$html_return_social .= '<li class="dribbble"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Dribbble" href="http://dribbble.com/'.$pp_dribbble_username.'"><i class="fa fa-dribbble"></i></a></li>';
			}
			
			$pp_linkedin_username = get_option('pp_linkedin_username');
			if(!empty($pp_linkedin_username))
			{
				$html_return_social .= '<li class="linkedin"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) {
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Linkedin" href="'.$pp_linkedin_username.'"><i class="fa fa-linkedin"></i></a></li>';
			}
			
			$pp_pinterest_username = get_option('pp_pinterest_username');
			if(!empty($pp_pinterest_username))
			{
				$html_return_social .= '<li class="pinterest"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Pinterest" href="http://pinterest.com/'.$pp_pinterest_username.'"><i class="fa fa-pinterest"></i></a></li>';
			}
			
			$pp_instagram_username = get_option('pp_instagram_username');
			if(!empty($pp_instagram_username))
			{
				$html_return_social .= '<li class="instagram"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Instagram" href="http://instagram.com/'.$pp_instagram_username.'"><i class="fa fa-instagram"></i></a></li>';
			}
			
			$pp_behance_username = get_option('pp_behance_username');
			if(!empty($pp_behance_username))
			{
				$html_return_social .= '<li class="behance"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= 'title="Behance" href="http://behance.net/'.$pp_behance_username.'"><i class="fa fa-behance-square"></i></a></li>';
			}
			
			$pp_tripadvisor_url = get_option('pp_tripadvisor_url');
			if(!empty($pp_tripadvisor_url))
			{
				$html_return_social .= '<li class="tripadvisor"><a ';
				if(!empty($pp_footer_fourth_social_link_blank)) { 
					$html_return_social .= 'target="_blank"';
				}
				$html_return_social .= ' title="Tripadvisor" href="'.$pp_tripadvisor_url.'"><i class="fa fa-tripadvisor"></i></a></li>';
			}
			$html_return_social .= '</ul></div>';
			# } Social
		
			# logo
			$fourth_colum_first_logo 	= '';
			$fourth_colum_second_logo 	= '';
			$fourth_colum_third_logo 	= '';
			$fourth_colum_fourth_logo 	= '';
				
			switch($pp_footer_fourth_column_show_logo)
			{
				case 1:
					$fourth_colum_first_logo 	= $html_logo;
					$fourth_colum_second_logo 	= '';
					$fourth_colum_third_logo 	= '';
					$fourth_colum_fourth_logo 	= '';
				break;
				case 2:
					$fourth_colum_first_logo 	= '';
					$fourth_colum_second_logo 	= $html_logo;
					$fourth_colum_third_logo 	= '';
					$fourth_colum_fourth_logo 	= '';
				break;
				case 3:
					$fourth_colum_first_logo 	= '';
					$fourth_colum_second_logo 	= '';
					$fourth_colum_third_logo 	= $html_logo;
					$fourth_colum_fourth_logo 	= '';
				break;
				case 4:
					$fourth_colum_first_logo 	= '';
					$fourth_colum_second_logo 	= '';
					$fourth_colum_third_logo 	= '';
					$fourth_colum_fourth_logo 	= $html_logo;
				break;
				default:
					$fourth_colum_first_logo 	= '';
					$fourth_colum_second_logo 	= '';
					$fourth_colum_third_logo 	= '';
					$fourth_colum_fourth_logo 	= '';
				break;
			}
			
			# Social
			$fourth_colum_first_social 	= '';
			$fourth_colum_second_social 	= '';
			$fourth_colum_third_social 	= '';
			$fourth_colum_fourth_social 	= '';
			
			if(!empty($pp_footer_fourth_social_display))
			{
				switch($pp_footer_fourth_into_colum_social)
				{
					case 1:
						$fourth_colum_first_social 	= $html_return_social;
						$fourth_colum_second_social 	= '';
						$fourth_colum_third_social 	= '';
						$fourth_colum_fourth_social 	= '';
					break;
					case 2:
						$fourth_colum_first_social 	= '';
						$fourth_colum_second_social 	= $html_return_social;
						$fourth_colum_third_social 	= '';
						$fourth_colum_fourth_social 	= '';
					break;
					case 3:
						$fourth_colum_first_social 	= '';
						$fourth_colum_second_social 	= '';
						$fourth_colum_third_social 	= $html_return_social;
						$fourth_colum_fourth_social 	= '';
					break;
					case 4:
						$fourth_colum_first_social 	= '';
						$fourth_colum_second_social 	= '';
						$fourth_colum_third_social 	= '';
						$fourth_colum_fourth_social 	= $html_return_social;
					break;
					default:
						$fourth_colum_first_social 	= '';
						$fourth_colum_second_social 	= '';
						$fourth_colum_third_social 	= '';
						$fourth_colum_fourth_social 	= '';
					break;
				}
			}
		
			$html_return_footer .= '<div class="row row-4">';
			if($fourth_colum_first === true)
			{
				$html_return_footer .= '	<div class="col col-1 ' . $fourth_width_cols . '">' . $fourth_colum_first_logo . $pp_footer_fourth_row_column_one . $fourth_colum_first_social . '</div>';
			}
			if($fourth_colum_second === true)
			{
				$html_return_footer .= '	<div class="col col-2 ' . $fourth_width_cols . '">' . $fourth_colum_second_logo . $pp_footer_fourth_row_column_two . $fourth_colum_second_social .'</div>';
			}
			if($fourth_colum_third === true)
			{
				$html_return_footer .= '	<div class="col col-3 ' . $fourth_width_cols . '">' . $fourth_colum_third_logo . $pp_footer_fourth_row_column_three . $fourth_colum_third_social . '</div>';
			}
			if($fourth_colum_fourth === true)
			{
				$html_return_footer .= '	<div class="col col-4 ' . $fourth_width_cols . '">' . $fourth_colum_fourth_logo . $pp_footer_fourth_row_column_four . $fourth_colum_fourth_social . '</div>';
			}
			$html_return_footer .= '</div>';
		
			if(!empty($pp_footer_fourth_separating_horizontal_line))
			{
				$html_return_footer .= '<div class="separator"></div>';
			}
		}
		# } ROW Fourth
		
	}
	echo $html_return_footer;
	?>
	
</div>

<?php
    } //End if not blank template
?>

<?php
	/**
    *	Setup code before </body>
    **/
	$pp_before_body_code = get_option('pp_before_body_code');
	
	if(!empty($pp_before_body_code))
	{
		echo stripslashes($pp_before_body_code);
	}
?>

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
