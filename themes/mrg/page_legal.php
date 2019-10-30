<?php
/**
 * Template Name: Page Legal
 * The main template file for display page.
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
$current_page_id = '';

if(isset($page->ID))
{
    $current_page_id = $page->ID;
}

get_header(); 
?>
<!-- Title -->
<div id="content" class="ppb_wrapper">
    <div class="ppb_default_detail one ">
    	<div class="page_content_wrapper full_width" style="text-align:center">
        	<div class="title"><h1><?php echo __('LEGAL', THEMEDOMAIN); ?></h1></div>
        </div>
    </div>
</div>
<?php
	//Check if use page builder
	$ppb_form_data_order = '';
	$ppb_form_item_arr = array();
	$ppb_enable = get_post_meta($current_page_id, 'ppb_enable', true);
	
	global $global_pp_topbar;
?>
<?php
	if(!empty($ppb_enable))
	{
?>
<div id="content" class="ppb_wrapper <?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>withtopbar<?php } ?>" style="margin: 20px 0  100px 0;">
<?php
		tg_apply_builder($current_page_id);
?>
</div>
<?php
	}
	else
	{
?>
<!-- Begin content -->
<div id="page_content_wrapper" class="<?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>withtopbar<?php } ?>">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content full_width more-percent" id="contact-form">
    		
            <?php
			
			if ( have_posts() ) {
				
				$post_id		 		= !empty($post->ID)? $post->ID : '';
				$post_title 			= !empty($post->post_title) ? $post->post_title : '';
				$post_excerpt 			= !empty($post->post_excerpt) ? $post->post_excerpt : '';
				$post_content 			= !empty($post->post_content) ? $post->post_content : '';
				$post_permalink_url 	= !empty(get_permalink($default_ID)) ? get_permalink($default_ID) : '';
				
				if(has_post_thumbnail($post_id, 'full'))
				{
					$image_destacada_id 		= get_post_thumbnail_id($post_id); 
					$post_image_destacada_url 	= wp_get_attachment_image_src($image_destacada_id, 'img_contacto', true);
				}
				
				$imagen_destacada				= !empty($post_image_destacada_url[0]) ? $post_image_destacada_url[0] : '';
				$imagen_destacada_w				= !empty($post_image_destacada_url[1]) ? $post_image_destacada_url[1] : '';
				$imagen_destacada_h				= !empty($post_image_destacada_url[2]) ? $post_image_destacada_url[2] : '';
			?>
            <?php echo $post_content; ?>
            <?php
			};
			?>
            
    		</div>
    	</div>
    	<!-- End main content -->
    </div> 
</div>
<?php
}
?>
<?php
if(empty($ppb_enable))
{
?>
<br class="clear"/><br/><br/>
<?php
}
?>
<?php get_footer(); ?>