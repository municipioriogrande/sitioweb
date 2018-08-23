<?php
/**
 * Template Name: Contact With Map ICON
 * The main template file for display contact page.
 *
 * @package WordPress
*/

/**
*	Get Current page object
**/
$current_page = get_page($post->ID);
$current_page_id = '';

if(isset($current_page->ID))
{
    $current_page_id = $current_page->ID;
}

get_header(); 
?>

<?php
	global $pp_contact_display_map;
	$pp_contact_display_map = TRUE;

	//Include custom header feature
	get_template_part("/templates/template-header-contact");
	
	$pp_footer_pre_address 	= get_option('pp_footer_pre_address');
	$pp_footer_pre_phone 	= get_option('pp_footer_pre_phone');
	$pp_footer_pre_email 	= get_option('pp_footer_pre_email');
	
?>
<!-- Begin content -->
<div id="page_content_wrapper full_width">

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>		

        <?php the_content(); ?>

    <?php endwhile; ?>
    
    
    <div class="one contact-form-data fullwidth ">
      <div class="page_content_wrapper" style="text-align:center">
        <div style="text-align:left">
          <div class="one_half">
            
            <h3><?php echo  __('Address', THEMEDOMAIN); ?></h3>
            <div class="line-separator"></div>
            <h4><?php echo $pp_footer_pre_address; ?></h4>
            <div class="spacer-separator"></div>
            <h3><?php echo  __('Phone', THEMEDOMAIN); ?></h3>
            <div class="line-separator"></div>
            <h4><?php echo $pp_footer_pre_phone; ?></h4>
            <div class="spacer-separator"></div>
            <h3><?php echo  __('Email', THEMEDOMAIN); ?></h3>
            <div class="line-separator"></div>
            <h4><?php echo $pp_footer_pre_email; ?></h4>
            
          </div>
          <div class="one_half last">
            <?php echo do_shortcode('[contact-form-7 id="3632" title="Contacto"]'); ?>
          </div>
        </div>
      </div>
    </div>
    
            
</div>

</div>
<?php get_footer(); ?>		