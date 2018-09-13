<?php
/**
 * The main template file for display single curso.
 *
 * @package WordPress
*/

get_header(); 

global $global_pp_topbar;

/**
*	Get current page id
**/

$current_page_id = $post->ID;

?>

<br class="clear supercheck"/>

<?php
	$page_menu_transparent = get_post_meta($current_page_id, 'post_menu_transparent', true);
	$pp_page_bg = '';
	
	//Get page featured image
	if(has_post_thumbnail( $current_page_id)){   
	   $image_id = get_post_thumbnail_id( $current_page_id );
		$post_featured_image = wp_get_attachment_image_src($image_id, 'original');

		$background_image        = $post_featured_image[0];
		$pp_page_bg              = $post_featured_image[0];
		$background_image_width  = $post_featured_image[1];
		$background_image_height = $post_featured_image[2];
	}
?>
<div id="page_caption" <?php if(!empty($pp_page_bg)) { ?>class="hasbg parallax <?php if(empty($page_menu_transparent)) { ?>notransparent<?php } ?>" data-image="<?php echo $background_image; ?>" data-width="<?php echo $background_image_width; ?>" data-height="<?php echo $background_image_height; ?>"<?php } ?>>
	<div class="page_title_wrapper">
		<h2 class="title"><?php the_title() ?></h2>
		
	</div>
	<?php if(!empty($pp_page_bg)) { ?>
		<div class="parallax_overlay_header"></div>
	<?php } ?>
</div>

<div id="page_content_wrapper" class="wrapper_max_width <?php if(!empty($pp_page_bg)) { ?>hasbg fix-height<?php } ?> <?php if(empty($page_menu_transparent)) { ?>notransparent<?php } ?> <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>withtopbar<?php } ?>">
    
    <div class="inner">

    	<!-- Begin main content -->
    	<article class="inner_wrapper">
			<?php
			if (have_posts()) : while (have_posts()) : the_post();	?>
						
				<!-- Begin each blog post -->
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="centro-details">
						<dl>
						
						<dt> <span class="icon address"></span>Dirección</dt>
							<dd> <?php echo get_post_meta( $post->ID, '_mrg_health_center_address', true );?> </dd>
							
						<dt> <span class="icon phone"></span>Teléfono</dt>
							<dd> <?php echo get_post_meta( $post->ID, '_mrg_health_center_phone', true );?> </dd>

						<dt> <span class="icon hours"></span>Horario</dt>
							<dd> <?php echo get_post_meta( $post->ID, '_mrg_health_center_open_hrs', true );?> </dd>								
							
						</dl>
						
					</div>

					<div class="post_wrapper">
					   <?php the_content(); ?>
					</div>


					<?php
				endwhile; 
			endif; //have posts
			?>
						
 		</article>

 		
		
    
    </div>
   
</div>

<br class="clear"/>
</div>
<?php get_footer(); ?>