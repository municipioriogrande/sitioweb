<?php
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
	
	
	$habitacion_price= get_post_meta($current_page_id, 'habitacion_price', true);
	$habitacion_price_discount= get_post_meta($current_page_id, 'habitacion_price_discount', true);
	$habitacion_price_currency= get_post_meta($current_page_id, 'habitacion_price_currency', true);
	$habitacion_availability= get_post_meta($current_page_id, 'habitacion_availability', true);
	$habitacion_booking_url= get_post_meta($current_page_id, 'habitacion_booking_url', true);
	
	$habitacion_price_display = 0;
	if(empty($habitacion_price_discount))
	{   
		if(!empty($habitacion_price))
		{
			$habitacion_price_display = pp_number_format($habitacion_price);
		}
	}
	else
	{
		$habitacion_price_display = '<span class="tour_normal_price">'.$habitacion_price_currency.pp_number_format($habitacion_price).'</span>';
		$habitacion_price_display.= '<span class="tour_discount_price">'.$habitacion_price_currency.pp_number_format($habitacion_price_discount).'</span>';
	}
	
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
	
	$tour_title = get_the_title();
	$tour_country= get_post_meta($page->ID, 'tour_country', true);
    
    global $global_pp_topbar;
    
    if(!empty($pp_page_bg)) 
    {
?>
<div id="page_caption" <?php if(!empty($pp_page_bg)) { ?>class="hasbg parallax fullscreen <?php if(empty($page_menu_transparent)) { ?>notransparent<?php } ?>" data-image="<?php echo $background_image; ?>" data-width="<?php echo $background_image_width; ?>" data-height="<?php echo $background_image_height; ?>"<?php } ?>>
	<div class="page_title_wrapper">
		<?php
		if(!empty($tour_country))
		{
		?>
		<div class="tour_country_subheader"><?php echo $tour_country; ?></div><br class="clear"/>
		<?php
		}
		?>
		<h1 <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>class ="withtopbar"<?php } ?>><?php echo $tour_title; ?></h1>
	</div>
    
<div id="manifest-booking" class="manifest-rates">
<div class="manifest-header"><?php echo _e( 'RATE FROM', THEMEDOMAIN ); ?></div>
<div class="manifest-pre-rates">
<span class="manifest-pre-rates-from"><?php echo _e( 'since', THEMEDOMAIN ); ?></span>
<span class="manifest-pre-rates-dollars"><?php if(!empty($habitacion_price_display)) { echo $habitacion_price_display; }else{ echo ''; }?></span>
<span class="manifest-pre-rates-cents"><i>00</i> <?php echo $habitacion_price_currency; ?></span>
<span class="manifest-pre-rates-night"><?php echo _e( 'per nigth', THEMEDOMAIN ); ?></span>
</div>
<a id="manifest-pre-cta" <?php if(!empty($habitacion_booking_url)) { ?>href="<?php echo $habitacion_booking_url; ?>"<?php }?> class="manifest-pre-btn"><?php echo _e( 'BOOK NOW', THEMEDOMAIN ); ?></a>
</div>
    
	<?php if(!empty($pp_page_bg)) { ?>
		<div class="parallax_overlay_header"></div>
	<?php } ?>
</div>
<?php
	}
?>

<!-- Begin content -->
<div id="page_content_wrapper" <?php if(!empty($pp_page_bg)) { ?>class="hasbg fullwidth fullscreen <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>withtopbar<?php } ?>"<?php } ?>>