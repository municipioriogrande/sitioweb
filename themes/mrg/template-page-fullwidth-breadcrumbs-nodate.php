<?php
/**
 * Template Name: Page fullwidth - breadcrumbs, no date
 *
 * @package WordPress
*/



// to get current page info before The Loop ("needed" for Breadcrumbs)
global $post; 
$current_page_id = $post->ID;
$current_page_parent_id = wp_get_post_parent_id($current_page_id);


get_header(); 
?>

<div class="page-breadcrumb">
	<div class="page-breadcrumb-wrapper">
    	<div class="row">
        	<div class="col-md col col-1 col-md-12">
                <ul>
                    <li><a href="<?php echo home_url(); ?>">RÍO GRANDE</a></li>
                    <li>›</li>
						  <?php if ( $current_page_parent_id ) { ?>
                    <li><a href="<?php echo get_permalink( $current_page_parent_id ); ?>"><?php echo get_the_title( $current_page_parent_id ); ?></a></li>
                    <li>›</li>
                    <?php } ?>
                    <li><a href="<?php echo get_permalink($current_page_id); ?>"><?php the_title(); ?></a></li>
                </ul>
            </div>
            
        </div>
    </div>
</div>

<!-- Begin content -->
<div id="page_content_wrapper">
    <div class="inner">
    	<!-- Begin main content -->
    	<div class="inner_wrapper">
    		<div class="sidebar_content full_width">
    		<?php 
    			if ( have_posts() ):
    		   	while ( have_posts() ) : the_post();
    		    		the_content(); break; 
    				endwhile; 
	    		endif;
    		?>
    		</div>
    	</div>
    	<!-- End main content -->
    </div> 
</div>
<br class="clear"/><br/><br/>
<?php get_footer(); ?>