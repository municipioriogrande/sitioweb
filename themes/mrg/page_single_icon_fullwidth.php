<?php
/**
 * Template Name: Page Single Icon Full Width
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
get_template_part("/templates/template-header-single-icon-full-width");
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
<div class="ppb_wrapper <?php if(!empty($pp_page_bg)) { ?>hasbg<?php } ?> <?php if(!empty($pp_page_bg) && !empty($global_pp_topbar)) { ?>withtopbar<?php } ?>">
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
<div class="ppb_instalaciones_detail one withsmallpadding module-experiencia fullwidth  " style="padding:0; margin-top: -1px;">
  <div class="page_content_wrapper is_not_mobile" style="text-align:center; padding:0 1.5%; width: 97%;">
    
    <div class="one withsmallpadding intro-instalacion ">
        <div class="page_content_wrapper">
          <h1><?php echo get_the_title(); ?></h1>
          <h4>
          <?php
                if (have_posts())
                { 
                    while (have_posts()) : the_post();
    
                    the_content();
                    
                    endwhile; 
                }
            ?>
          </h4>
        </div>
    </div>
  </div>
</div>

<?php
}
?>
<?php get_footer(); ?>