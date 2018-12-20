<?php
/**
 * Template Name: Page Habitaciones Listing Full Width
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
<!--
<?php
    //Get Page RevSlider
    $page_revslider = get_post_meta($current_page_id, 'page_revslider', true);
    $page_menu_transparent = get_post_meta($current_page_id, 'page_menu_transparent', true);
    $page_header_below = get_post_meta($current_page_id, 'page_header_below', true);
    
    if(!empty($page_revslider) && $page_revslider != -1 && empty($page_header_below))
    {
    	echo '<div class="page_slider ';
    	if(!empty($page_menu_transparent))
    	{
	    	echo 'menu_transparent';
    	}
    	echo '">'.do_shortcode('[rev_slider '.$page_revslider.']').'</div>';
    }
?>

<?php
//Get page header display setting
$page_hide_header = get_post_meta($current_page_id, 'page_hide_header', true);

if($page_revslider != -1 && !empty($page_menu_transparent))
{
	$page_hide_header = 1;
}

if(empty($page_hide_header) && ($page_revslider == -1 OR empty($page_revslider) OR !empty($page_header_below)))
{
	$pp_page_bg = '';
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'full'))
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
?>
<div id="page_caption" <?php if(!empty($pp_page_bg)) { ?>class="hasbg parallax <?php if(empty($page_menu_transparent)) { ?>notransparent<?php } ?> <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?> withtopbar<?php } ?>" data-image="<?php echo $background_image; ?>" data-width="<?php echo $background_image_width; ?>" data-height="<?php echo $background_image_height; ?>"<?php } ?>>
	<div class="page_title_wrapper">
		<h1 <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>class ="withtopbar"<?php } ?>><?php the_title(); ?></h1>
	</div>
	<?php if(!empty($pp_page_bg)) { ?>
		<div class="parallax_overlay_header"></div>
	<?php } ?>
</div>
<?php
}
?>
-->
<?php
get_template_part("/templates/template-header-habitaciones-listing");
?>
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
<div id="content" class="ppb_wrapper <?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>withtopbar<?php } ?>">
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
<div id="" class="<?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>withtopbar<?php } ?>">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content full_width">
    		<?php 
    			if ( have_posts() ) {
    		    while ( have_posts() ) : the_post(); ?>		
    	
    		    <?php the_content(); break;  ?>

    		<?php endwhile; 
    		}
    		?>
    		</div>
    	</div>
    	<!-- End main content -->
    </div> 
</div>

<!--
<div id="featured_filter_wrapper" class="page_content_wrapper fullwidth " style="text-align:center; padding: 0;">
    <div class="one withsmallpadding intro-habitaciones" style="padding: 1.6% 0 0 0;">
        <div class="page_content_wrapper">
            <h1>HABITACIONES</h1>
        </div>
    </div>
</div>
-->


<?php

global $post;
$pp_habitaciones_items_page = get_option('pp_habitaciones_items_page');
if(empty($pp_habitaciones_items_page))
{
	$pp_habitaciones_items_page = 6;
}
$habitaciones_args = array( 
	'posts_per_page' => $pp_habitaciones_items_page,
	'order' => 'ASC',
	'orderby' => 'menu_order', 
	'post_type'=> 'habitaciones' 
);
$habitaciones_posts = get_posts( $habitaciones_args );

?>
<div class="ppb_habitaciones_listing one withsmallpadding module-experiencia fullwidth  " style="padding:0; margin-top: -1px;">
  <div class="page_content_wrapper is_not_mobile" style="text-align:center; width: 100%;">
	<?php
	$count_par = 2;
    foreach ( $habitaciones_posts as $post ) : setup_postdata( $post );
          
    $relate_post_id		 		= !empty($post->ID)? $post->ID : '';
    $relate_post_title			= !empty($post->post_title)? $post->post_title : '';
	$relate_post_excerpt		= !empty($post->post_excerpt)? $post->post_excerpt : '';
    //$relate_post_permalink 	= !empty(the_permalink())? the_permalink() : '';
    $relate_post_country		= get_post_meta($relate_post_id, 'habitacion_country', true);
    $relate_post_price			= get_post_meta($relate_post_id, 'habitacion_price', true);
    $relate_post_price_discount	= get_post_meta($relate_post_id, 'habitacion_price_discount', true);
    $relate_post_price_currency	= get_post_meta($relate_post_id, 'habitacion_price_currency', true);
    $relate_post_availability	= get_post_meta($relate_post_id, 'habitacion_availability', true);
    //$relate_post_booking_url	= get_post_meta($relate_post_id, 'habitacion_booking_url', true);
    
    $relate_post_price_display = 0;
    
    if (!empty($relate_post_price)) {
        if (!empty($relate_post_price_discount)) {
            if ($relate_post_price_discount < $relate_post_price) {
                $relate_post_discount_percentage = intval((($relate_post_price - $relate_post_price_discount) / $relate_post_price) * 100);
            }
        }
    
        if (empty($relate_post_price_discount)) {
            $relate_post_price_display = $relate_post_price_currency . pp_number_format($relate_post_price);
        } else {
            $relate_post_price_display = $relate_post_price_currency . pp_number_format($relate_post_price_discount);
        }
    }
    
    if(has_post_thumbnail($relate_post_id, 'full') && empty($term))
    {
        $the_image_id = get_post_thumbnail_id($relate_post_id); 
        $relate_post_small_image_url = wp_get_attachment_image_src($the_image_id, 'img_listados', true);
    }
    
    $relate_post_cats_arr = get_terms('habitacionescats', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
    $relate_post_cat = '';
	
	foreach ($relate_post_cats_arr as $cats) {
        $relate_post_cat = $cats->name;
    }
	
	if ($count_par%2==0){ //par
	?>
    <div class="module-habitacion par">
        <div class="one_half listing_image_bg" style="background-image:url('<?php echo $relate_post_small_image_url[0];?>'); height:<?php echo $relate_post_small_image_url[2];?>px"></div>
        <div class="one_half last " style="width: 50%; height:<?php echo $relate_post_small_image_url[2];?>px">
          <div class="content-detail content-detail-fix">
            <h1><a href="<?php the_permalink(); ?>"><?php echo $relate_post_title; ?></a></h1>
            <div class="line-separator"></div>
            <h4><?php echo cortar_frase($relate_post_excerpt,45); ?></h4>
            <div class="detail">
                <a class="open-popup-link button" href="<?php the_permalink(); ?>"><?php echo _e( 'See Detail', THEMEDOMAIN ); ?></a>
            </div>
          </div>
        </div>
    </div>
    <div class="clear"></div>
    <?php
	}else{ //impar
	?>
    <div class="module-habitacion impar">
        <div class="one_half last" style="float:left; height:<?php echo $relate_post_small_image_url[2];?>px">
          <div class="content-detail content-detail-fix">
            <h1><a href="<?php the_permalink(); ?>"><?php echo $relate_post_title; ?></a></h1>
            <div class="line-separator"></div>
            <h4><?php echo cortar_frase($relate_post_excerpt,45); ?></h4>
            <div class="detail">
                <a class="open-popup-link button" href="<?php the_permalink(); ?>"><?php echo _e( 'See Detail', THEMEDOMAIN ); ?></a>
            </div>
          </div>
        </div>
        <div class="one_half listing_image_bg" style="float: right; width: 50%; background-image:url('<?php echo $relate_post_small_image_url[0];?>'); height:<?php echo $relate_post_small_image_url[2];?>px"></div>
    </div>
    <div class="clear"></div>
    <?php
	}
    ?>
    <?php
	$count_par = $count_par+1; 
	endforeach; 
	?>
  </div>
  <div class="page_content_wrapper is_mobile" style="text-align:center; padding:0 1.5%; width: 97%;">
	<?php
    foreach ( $habitaciones_posts as $post ) : setup_postdata( $post );
          
    $relate_post_id		 		= !empty($post->ID)? $post->ID : '';
    $relate_post_title			= !empty($post->post_title)? $post->post_title : '';
	$relate_post_excerpt		= !empty($post->post_excerpt)? $post->post_excerpt : '';
    //$relate_post_permalink 	= !empty(the_permalink())? the_permalink() : '';
    $relate_post_country		= get_post_meta($relate_post_id, 'habitacion_country', true);
    $relate_post_price			= get_post_meta($relate_post_id, 'habitacion_price', true);
    $relate_post_price_discount	= get_post_meta($relate_post_id, 'habitacion_price_discount', true);
    $relate_post_price_currency	= get_post_meta($relate_post_id, 'habitacion_price_currency', true);
    $relate_post_availability	= get_post_meta($relate_post_id, 'habitacion_availability', true);
    //$relate_post_booking_url	= get_post_meta($relate_post_id, 'habitacion_booking_url', true);
    
    $relate_post_price_display = 0;
    
    if (!empty($relate_post_price)) {
        if (!empty($relate_post_price_discount)) {
            if ($relate_post_price_discount < $relate_post_price) {
                $relate_post_discount_percentage = intval((($relate_post_price - $relate_post_price_discount) / $relate_post_price) * 100);
            }
        }
    
        if (empty($relate_post_price_discount)) {
            $relate_post_price_display = $relate_post_price_currency . pp_number_format($relate_post_price);
        } else {
            $relate_post_price_display = $relate_post_price_currency . pp_number_format($relate_post_price_discount);
        }
    }
    
    if(has_post_thumbnail($relate_post_id, 'full') && empty($term))
    {
        $the_image_id = get_post_thumbnail_id($relate_post_id); 
        $relate_post_small_image_url = wp_get_attachment_image_src($the_image_id, 'gallery_grid', true);
    }
    
    $relate_post_cats_arr = get_terms('habitacionescats', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
    $relate_post_cat = '';
	
	foreach ($relate_post_cats_arr as $cats) {
        $relate_post_cat = $cats->name;
    }
	?>
    <div class="module-habitacion par">
        <div class="one_half "><img src="<?php echo $relate_post_small_image_url[0];?>" alt="" width="100%"></div>
        <div class="one_half last " style="width: 50%;">
          <div class="content-detail content-detail-fix">
            <h1><a href="<?php the_permalink(); ?>"><?php echo $relate_post_title; ?></a></h1>
            <div class="line-separator"></div>
            <h4><?php echo cortar_frase($relate_post_excerpt,45); ?><br /><br /></h4>
            <div class="detail">
                <a class="open-popup-link button" href="<?php the_permalink(); ?>"><?php echo _e( 'See Detail', THEMEDOMAIN ); ?></a>
            </div>
          </div>
        </div>
    </div>
    <div class="clear"></div>
    <?php
	endforeach; 
	?>
  </div>
</div>   

<?php
}
?><!--
<?php
if(empty($ppb_enable))
{
?>
<br class="clear"/><br/><br/>
<?php
}
?>-->
<?php get_footer(); ?>