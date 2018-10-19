<?php

/**
 * Archivo licitaciones, taken from Template Name: MODULE - Page Full Width
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
<div class="page-breadcrumb">
	<div class="page-breadcrumb-wrapper">
    	<div class="row">
        	<div class="col-md col col-1 col-md-8">
                <ul>
                    <li><a href="<?php echo home_url(); ?>">RÍO GRANDE</a></li>
                    <li>›</li>
                    <li><a href="<?php echo get_permalink($current_page_id); ?>">Centros de salud</a></li>
                </ul>
            </div>
            <div class="col-md col col-2 col-md-4">
                <?php the_modified_date('d/m/Y', '<div class="the-modified-date">Última actualización: ', '</div>'); ?>
            </div>
        </div>
    </div>
</div>


<div class="ppb_wrapper wrapper_max_width">

	<?php 
	//taken from mrg\lib\contentbuilder.lib.php:3102 (ppb_module_header_full_func)
	?>
	<div class="bilder_modul_full ">
	  <div class="page_content_wrapper">
	    <div class="row">
	      <div class="col-md col-md-12">
	        <div class="content">
	          <h2>Centros de salud</h2>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
	<?php 
	//end taken
	?>


<div class="page_content_wrapper">
	<div class="row">
		<div class="col-md col-md-12">
			<div class="content">


	<div id="list-centros_salud">
		<?php echo list_centros_salud(); ?>
	</div>
			</div>
		</div>
	</div>
</div>


</div>


<?php get_footer(); ?>