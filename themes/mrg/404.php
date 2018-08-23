<?php
/**
 * The main template file for display error page.
 *
 * @package WordPress
*/


get_header(); 

	$pp_404_title 					= get_option('pp_404_title');
	$pp_404_detail 					= get_option('pp_404_detail');
	$pp_404_display_back_home 		= get_option('pp_404_display_back_home');
	$pp_404_display_history_back 	= get_option('pp_404_display_history_back');
	$pp_404_background_image 		= get_option('pp_404_background_image');
	
	if(!empty($pp_404_background_image)){
		$pp_404_background_image_data = getimagesize($pp_404_background_image);
		
		$background_image = $pp_404_background_image;
		$background_image_width = $pp_404_background_image_data[0];
		$background_image_height = $pp_404_background_image_data[1];
	}
	/*echo $background_image;
	echo $background_image_width;
	echo $background_image_height;
	exit();*/
?>
<?php 
if(!empty($background_image)){ 
?>
<div id="page_caption" class="hasbg parallax fullscreen notransparent" data-image="<?php echo $background_image; ?>" data-width="<?php echo $background_image_width; ?>" data-height="<?php echo $background_image_height; ?>">
	<div class="page_title_wrapper">
		<h1><?php echo $pp_404_title; ?></h1>
        <p><?php echo $pp_404_detail; ?></p>
        <div class="content_button">
        	<?php if(!empty($pp_404_display_back_home)){ ?>
            <a href="<?php echo get_site_url();?>">
            	<div class="button-cta w-button">IR A HOME</div>
            </a>
            <?php
			}
			
			if(!empty($pp_404_display_history_back)){
			?>
            &nbsp;&nbsp;&nbsp;
            <a href="javascript:window.history.back();">
            	<div class="button-cta w-button">VOLVER ATRÁS</div>
            </a>
            <?php
			}
			?>
        </div>
	</div>
		<div class="parallax_overlay_header"></div>
</div>
<?php
}else{
?>
<div id="page_caption" class="notransparent">
	<div class="page_title_wrapper">
    	<img src="<?php echo get_site_url(); ?>/wp-content/themes/mrg/images/404.png" width="184" alt="<?php echo $pp_404_title; ?>" />
		<h1><?php echo $pp_404_title; ?></h1>
        <p><?php echo $pp_404_detail; ?></p>
        <div class="content_button">
        	<?php if(!empty($pp_404_display_back_home)){ ?>
            <a href="<?php echo get_site_url();?>">
            	<div class="button-cta w-button">IR A HOME</div>
            </a>
            <?php
			}
			
			if(!empty($pp_404_display_history_back)){
			?>
            &nbsp;&nbsp;&nbsp;
            <a href="javascript:window.history.back();">
            	<div class="button-cta w-button">VOLVER ATRÁS</div>
            </a>
            <?php
			}
			?>
        </div>
	</div>
</div>
<?php
}
?>
<!-- Begin content -->
<div id="page_content_wrapper" class="hasbg"></div>
<?php get_footer(); ?>