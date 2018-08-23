<?php
/**
 * Template Name: Page Thank You Page
 * The main template file for display single post default.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$page = get_page($post->ID);

/**
*	Get current page id
**/

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

get_header(); 

$pp_page_bg = '';
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'full') && empty($term))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        $pp_page_bg = $image_thumb[0];
    }
    
    if(isset($image_thumb[0]))
    {
	    $background_image = $image_thumb[0];
		$background_image_width = $image_thumb[1];
		$background_image_height = $image_thumb[2];
	}
	
    global $global_pp_topbar;
    
    if(!empty($pp_page_bg)) 
    {
		
		if ( have_posts() ) {
				/*print_r($post);
				exit();*/
				$post_id		 		= !empty($post->ID)? $post->ID : '';
				$post_title 			= !empty($post->post_title) ? $post->post_title : '';
				$post_excerpt 			= !empty($post->post_excerpt) ? $post->post_excerpt : '';
				$post_content 			= !empty($post->post_content) ? $post->post_content : '';
				$post_permalink_url 	= !empty(get_permalink($default_ID)) ? get_permalink($default_ID) : '';
				
				
				/* SOCIAL */
			
				if($pp_homepage_style!='flow' && $pp_homepage_style!='fullscreen' && $pp_homepage_style!='carousel' && $pp_homepage_style!='flip' && $pp_homepage_style!='fullscreen_video')
				{	
					$html_return_social = '<div class="content_social"><h4 class="folou_us">'. __('FOLLOW ME', THEMEDOMAIN).'</h4> ';
					//Check if open link in new window
					$pp_footer_social_link_blank = get_option('pp_footer_social_link_blank');
					
					$html_return_social .= '<ul class="social_icons">';
					
					$pp_facebook_username = get_option('pp_facebook_username');
					if(!empty($pp_facebook_username))
					{
						$html_return_social .= '<li class="facebook"><a ';
						if(!empty($pp_footer_social_link_blank)) {
							$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= ' href="' . $pp_facebook_username . '"><i class="fa fa-facebook"></i></a></li>';
					}
					
					$pp_twitter_username = get_option('pp_twitter_username');
					if(!empty($pp_twitter_username))
					{
						$html_return_social .= '<li class="twitter"><a ';
						if(!empty($pp_footer_social_link_blank)) { 
							$html_return_social .= 'target="_blank"';
						} 
						$html_return_social .= ' href="http://twitter.com/'.$pp_twitter_username.'"><i class="fa fa-twitter"></i></a></li>';
					}
					
					$pp_flickr_username = get_option('pp_flickr_username');
					if(!empty($pp_flickr_username))
					{
						$html_return_social .= '<li class="flickr"><a ';
						if(!empty($pp_footer_social_link_blank)) { 
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= ' title="Flickr" href="http://flickr.com/people/'.$pp_flickr_username.'"><i class="fa fa-flickr"></i></a></li>';
					}
					
					$pp_youtube_username = get_option('pp_youtube_username');
					if(!empty($pp_youtube_username))
					{
						$html_return_social .= '<li class="youtube"><a ';
						if(!empty($pp_footer_social_link_blank)) { 
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= ' title="Youtube" href="http://youtube.com/channel/'.$pp_youtube_username.'"><i class="fa fa-youtube"></i></a></li>';
					}
					
					$pp_vimeo_username = get_option('pp_vimeo_username');
					if(!empty($pp_vimeo_username))
					{
						$html_return_social .= '<li class="vimeo"><a ';
						if(!empty($pp_footer_social_link_blank)) { 
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= ' title="Vimeo" href="http://vimeo.com/'.$pp_vimeo_username.'"><i class="fa fa-vimeo-square"></i></a></li>';
					}
					
					$pp_tumblr_username = get_option('pp_tumblr_username');
					if(!empty($pp_tumblr_username))
					{
						$html_return_social .= '<li class="tumblr"><a ';
						if(!empty($pp_footer_social_link_blank)) { 
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= 'title="Tumblr" href="http://'.$pp_tumblr_username.'.tumblr.com"><i class="fa fa-tumblr"></i></a></li>';
					}
					
					$pp_google_username = get_option('pp_google_username');
					if(!empty($pp_google_username))
					{
						$html_return_social .= '<li class="google"><a ';
						if(!empty($pp_footer_social_link_blank)) {
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= ' title="Google+" href="'.$pp_google_username.'"><i class="fa fa-google-plus"></i></a></li>';
					}
					
					$pp_dribbble_username = get_option('pp_dribbble_username');
					if(!empty($pp_dribbble_username))
					{
						$html_return_social .= '<li class="dribbble"><a ';
						if(!empty($pp_footer_social_link_blank)) { 
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= 'title="Dribbble" href="http://dribbble.com/'.$pp_dribbble_username.'"><i class="fa fa-dribbble"></i></a></li>';
					}
					
					$pp_linkedin_username = get_option('pp_linkedin_username');
					if(!empty($pp_linkedin_username))
					{
						$html_return_social .= '<li class="linkedin"><a ';
						if(!empty($pp_footer_social_link_blank)) {
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= 'title="Linkedin" href="'.$pp_linkedin_username.'"><i class="fa fa-linkedin"></i></a></li>';
					}
					
					$pp_pinterest_username = get_option('pp_pinterest_username');
					if(!empty($pp_pinterest_username))
					{
						$html_return_social .= '<li class="pinterest"><a ';
						if(!empty($pp_footer_social_link_blank)) { 
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= 'title="Pinterest" href="http://pinterest.com/'.$pp_pinterest_username.'"><i class="fa fa-pinterest"></i></a></li>';
					}
					
					$pp_instagram_username = get_option('pp_instagram_username');
					if(!empty($pp_instagram_username))
					{
						$html_return_social .= '<li class="instagram"><a ';
						if(!empty($pp_footer_social_link_blank)) { 
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= 'title="Instagram" href="http://instagram.com/'.$pp_instagram_username.'"><i class="fa fa-instagram"></i></a></li>';
					}
					
					$pp_behance_username = get_option('pp_behance_username');
					if(!empty($pp_behance_username))
					{
						$html_return_social .= '<li class="behance"><a ';
						if(!empty($pp_topbar_social_link_blank)) { 
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= 'title="Behance" href="http://behance.net/'.$pp_behance_username.'"><i class="fa fa-behance-square"></i></a></li>';
					}
					
					$pp_tripadvisor_url = get_option('pp_tripadvisor_url');
					if(!empty($pp_tripadvisor_url))
					{
						$html_return_social .= '<li class="tripadvisor"><a ';
						if(!empty($pp_footer_social_link_blank)) { 
						$html_return_social .= 'target="_blank"';
						}
						$html_return_social .= ' title="Tripadvisor" href="'.$pp_tripadvisor_url.'"><i class="fa fa-tripadvisor"></i></a></li>';
					}
					$html_return_social .= '</ul></div>';
				}
				
?>
<div id="page_caption" <?php if(!empty($pp_page_bg)) { ?>class="hasbg parallax fullscreen <?php if(empty($page_menu_transparent)) { ?>notransparent<?php } ?>" data-image="<?php echo $background_image; ?>" data-width="<?php echo $background_image_width; ?>" data-height="<?php echo $background_image_height; ?>"<?php } ?>>
	<div class="page_title_wrapper">
		<h1 <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>class ="withtopbar"<?php } ?>><?php echo $post_title; ?></h1>
        <h3><?php echo $post_content; ?></h3>
        <?php echo $html_return_social; ?>
	</div>
	<?php if(!empty($pp_page_bg)) { ?>
		<div class="parallax_overlay_header"></div>
	<?php } ?>
</div>
<?php
		}
	}
?>
<!-- Begin content -->
<div id="page_content_wrapper" class="<?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>withtopbar<?php } ?>">
</div>

<?php get_footer(); ?>