<?php
/**
 * Template Name: MRG - Pagina Simple (Full Width)
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

<?php
//Get page header display setting
$page_hide_header = get_post_meta($current_page_id, 'page_hide_header', true);

if(empty($page_revslider))
{
	$page_revslider = '';
}
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
	
	$page_iframe_code = get_post_meta($current_page_id, 'page_iframe_code', true);
?>
<div class="page-breadcrumb">
	<div class="page-breadcrumb-wrapper">
		<div class="row">
			<div class="col-md col col-1 col-md-8">
				<ul>
					<li><a href="<?php echo home_url(); ?>">RÍO GRANDE</a></li>
					<li>›</li>
					<?php if ( $post->post_parent ) { ?>
					<li><a href="<?php echo get_permalink( $post->post_parent ); ?>"><?php echo get_the_title( $post->post_parent ); ?></a></li>
					<li>›</li>
					<?php } ?>
					<li><a href="<?php echo get_permalink($current_page_id); ?>"><?php the_title(); ?></a></li>
				</ul>
			</div>
			<div class="col-md col col-2 col-md-4">
				<?php the_modified_date('d/m/Y', '<div class="the-modified-date">Última actualización: ', '</div>'); ?>
			</div>
		</div>
	</div>
</div>
<div class="page-title">
	<div class="page-title-wrapper">
		<h1><?php the_title(); ?></h1>
	</div>
</div>
<?php
}
?>

<!-- Begin content -->
<div id="page_content_wrapper" class="page-content ">
    <div class="inner">
    	<!-- Begin main content -->
        <div class="sidebar_content full_width">
        <?php 
            if ( have_posts() ) {
            while ( have_posts() ) : the_post(); ?>		
    
            <?php the_content(); break;  ?>

        <?php endwhile; 
        }
        ?>
        
        <?php echo $page_iframe_code; ?>
        </div>
    	<!-- End main content -->
    </div> 
</div>

<?php
if(empty($ppb_enable))
{
?>
<br class="clear"/><br/><br/>
<?php
}
?>
<?php get_footer(); ?>