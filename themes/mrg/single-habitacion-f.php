<?php
/**
 * The main template file for display single post habitaciones.
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

if(!isset($current_page_id) && isset($page->ID))
{
    $current_page_id = $page->ID;
}

get_header(); 

//Include custom header feature
get_template_part("/templates/template-header-habitacion");
?>  
    <div class="inner">

    	<!-- Begid Main content -->
    	<div class="inner_wrapper">
    		
    		<?php
    			//Get habitacion Meta
				$habitacion_price			= get_post_meta($current_page_id, 'habitacion_price', true);
				$habitacion_price_currency	= get_post_meta($current_page_id, 'habitacion_price_currency', true);
				$habitacion_availability	= get_post_meta($current_page_id, 'habitacion_availability', true);
				$habitacion_booking_url		= get_post_meta($current_page_id, 'habitacion_booking_url', true);
				$habitacion_booking_hotel_id= get_post_meta($current_page_id, 'habitacion_booking_hotel_id', true);
				
				$habitacion_gallery_detail	= get_post_meta($current_page_id, 'habitacion_gallery_detail', true);
				$habitacion_gallery_photo	= get_post_meta($current_page_id, 'habitacion_gallery_photo', true);
				$habitacion_tamano			= get_post_meta($current_page_id, 'habitacion_tamano', true);
				$habitacion_url_plano		= get_post_meta($current_page_id, 'habitacion_url_plano', true);
				
				$post_excerpt		= !empty($post->post_excerpt)? $post->post_excerpt : '';
				
				//Get page plano image
				$habitacion_foto_plano = get_post_meta($current_page_id, 'habitacion_foto_plano', true);
				if(!empty($habitacion_foto_plano))
				{
					//Get image width and height
					$habitacion_foto_plano_id = pp_get_image_id($habitacion_foto_plano);
					$habitacion_foto_plano_image = wp_get_attachment_image_src($habitacion_foto_plano_id, 'img_plano');
					
					$plano_image = $habitacion_foto_plano_image[0];
					$plano_image_width = $habitacion_foto_plano_image[1];
					$plano_image_height = $habitacion_foto_plano_image[2];
				}
				
				//Get foto amenities
				$habitacion_amenities_foto = get_post_meta($current_page_id, 'habitacion_amenities_foto', true);
				if(!empty($habitacion_amenities_foto))
				{
					//Get image width and height
					$habitacion_amenities_foto_id = pp_get_image_id($habitacion_amenities_foto);
					$habitacion_amenities_foto_image = wp_get_attachment_image_src($habitacion_amenities_foto_id, 'img_amenities');
					
					$amenities_image = $habitacion_amenities_foto_image[0];
					$amenities_image_width = $habitacion_amenities_foto_image[1];
					$amenities_image_height = $habitacion_amenities_foto_image[2];
				}
				
				
				$habitacion_price_display = 0;
				if(empty($habitacion_price_discount))
				{   
				    if(!empty($habitacion_price))
				    {
				    	$habitacion_price_display = $habitacion_price_currency.pp_number_format($habitacion_price);
				    }
				}
				else
				{
				    $habitacion_price_display = '<span class="tour_normal_price">'.$habitacion_price_currency.pp_number_format($habitacion_price).'</span>';
				    $habitacion_price_display.= '<span class="tour_discount_price">'.$habitacion_price_currency.pp_number_format($habitacion_price_discount).'</span>';
				}
				?>
            
            <div class="box-content padding_60" style="height: 430px;">
            	<div class="box-detail"  style="vertical-align: top;">
                    <h1><?php echo get_the_title(); ?></h1>
                    <div class="content"><p>
                    <?php 
                    echo $post_excerpt;
                    /*if(!empty($habitacion_gallery_detail))
                    {
                        echo do_shortcode(tg_apply_content($habitacion_gallery_detail));
                    }*/
                    ?></p>
                    </div>
                </div>
            </div>
            <div class="box-content padding_60" style="height: 430px; background-color: rgb(244, 244, 241);">
                <div class="box-detail" style="vertical-align: top;">
					<?php
                    wp_enqueue_script("jquery-ui-core");
                    wp_enqueue_script("jquery-ui-datepicker");
                    wp_enqueue_script("custom_date", get_template_directory_uri()."/js/custom-date.js", false, THEMEVERSION, "all");
					
					wp_enqueue_script("jquery.validate", get_template_directory_uri() . "/js/jquery.validate.js", false, THEMEVERSION, true);
					wp_register_script("script-search-habitaciones-detail-form", get_template_directory_uri() . "/templates/script-search-habitaciones-detail-form.php", false, THEMEVERSION, true);
					wp_enqueue_script("script-search-habitaciones-detail-form", get_template_directory_uri() . "/templates/script-search-habitaciones-detail-form.php", false, THEMEVERSION, true);
					
					
					/*wp_register_script("script-booking-form", get_template_directory_uri()."/templates/script-booking-form.php", false, THEMEVERSION, true);
					$params = array(
					  'ajaxurl' => admin_url('admin-ajax.php'),
					  'ajax_nonce' => wp_create_nonce('tgajax-post-contact-nonce'),
					);
					wp_localize_script( 'script-booking-form', 'tgAjax', $params );
					wp_enqueue_script("script-booking-form", get_template_directory_uri()."/templates/script-booking-form.php", false, THEMEVERSION, true);
					*/
					
                    ?>
                    <form id="habitacion_detail_search_form" name="habitacion_detail_search_form" method="get">
                        <input id="hotelId" name="hotelId" type="hidden"  value="4795" />
                        <input id="languageid" name="languageid" type="hidden"  value="2" />
                        <input id="urldestiny" name="urldestiny" type="hidden"  value="https://reservations.travelclick.com/4795" />
                        <div class="tour_search_wrapper">
                            
                            <div class="one_box">
                            	<h1><?php echo _e( 'BOOK NOW ROOM', THEMEDOMAIN ); ?></h1>
                            </div>
                            <div class="one_box">
                                <!--<label for="start_date"><?php echo _e( 'Date', THEMEDOMAIN ); ?></label>-->
                                <div class="one_box_cube">
                                    <i class="fa fa-calendar fa-3" aria-hidden="true"></i>
                                    <label for="datein" class="lavel-detail"><?php echo _e( 'Arrival date', THEMEDOMAIN ); ?></label>
                                    <input id="datein" class="required_fields" name="datein" type="text" placeholder="<?php echo _e( 'Arrival', THEMEDOMAIN ); ?>" value=""/>
                                    <input id="datein_raw" name="datein_raw" type="hidden" value=""/>
                                </div>
                                <div class="one_box_cube">
                                    <i class="fa fa-calendar fa-3" aria-hidden="true"></i>
                                    <label for="dateout" class="lavel-detail"><?php echo _e( 'Departure date', THEMEDOMAIN ); ?></label>
                                    <input id="dateout" class="required_fields"  name="dateout" type="text" placeholder="<?php echo _e( 'Departure', THEMEDOMAIN ); ?>" value=""/>
                                    <input id="dateout_raw" name="dateout_raw" type="hidden" value=""/>
                                </div>
                            </div>
                            <div class="box-separator"></div>
                            <div class="two_box">
                                <div class="one_box_cube">
                                    <input id="promotioncode" name="promotioncode" type="text" placeholder="<?php echo _e( 'Enter your coupon', THEMEDOMAIN ); ?>" value=""/>
                                </div>
                            	<div class="one_box_cube" style="padding: 0; width: 47%;">
                                	<input id="tour_search_btn" type="submit" value="<?php echo _e( 'BOOK NOW', THEMEDOMAIN ); ?>" style="padding: 1.4em 1.7em !important;"/>
                                </div>
                                
                                <div id="reponse_msg" class="box_msn" style="display:block; height:auto !important; background-color:#fff;"><ul></ul></div>
                                
                            </div>
                        </div>
                    </form>
                 </div>
            </div>
            <div class="box-separator"></div>
            <div class="box-content listing_image_bg" style="background-image:url('<?php echo $amenities_image;?>'); height:<?php echo $amenities_image_height;?>px;"></div>
            <div class="box-content" style="height:<?php echo $amenities_image_height;?>px;">
				<div class="box-detail2">
				<?php
					if (have_posts())
					{ 
						while (have_posts()) : the_post();
		
						the_content();
						
						endwhile; 
					}
				?>
                </div>
            </div>
            <div class="box-separator"></div>
            <div class="box-content" style="height:<?php echo $plano_image_height;?>px;">
				<div class="box-detail">
                    <h1>EL TAMAÑO DE LA HABITACIÓN</h1>
                    <h2><?php echo $habitacion_tamano; ?></h2>
                    <div class="detail">
                        <a class="open-popup-link button fancy-gallery" href="<?php echo $habitacion_url_plano; ?>"><?php echo __('SEE FLOOR PLAN', THEMEDOMAIN); ?></a>
                        
                        <!--<div id="plan-popup" class="white-popup mfp-hide" style="text-align: center;">
                            <h1>ICON 36 CIUDAD &amp; PUERTO</h1>
                            <img id="storepromo-pop-img" src="<?php echo $habitacion_url_plano; ?>" />
                        </div>-->
                    </div>
            	</div>
            </div>
            <div class="box-content">
            	<img src="<?php echo $plano_image; ?>" width="100%" style="display_block" />
            </div>
            <div class="box-separator"></div>
            <div class="sidebar_content full_width">
	    	
		    	<?php
		    		//Get habitacion gallery
		    		$habitacion_gallery= get_post_meta($current_page_id, 'tour_gallery', true);
		    		
		    		if(!empty($habitacion_gallery))
		    		{
		    			$images_arr = get_post_meta($habitacion_gallery, 'wpsimplegallery_gallery', true);
		    			$pp_lightbox_enable_title = get_option('pp_lightbox_enable_title');
		    	?>
		    	<div id="portfolio_filter_wrapper" class="three_cols gallery tour_single fullwidth section content clearfix">
		    		<?php
		    			foreach($images_arr as $key => $image)
						{
							$image_url = wp_get_attachment_image_src($image, 'original', true);
							$small_image_url = wp_get_attachment_image_src($image, 'gallery_grid', true);
							$image_caption = get_post_field('post_excerpt', $image);
		    		?>
		    			<div class="element portfolio3filter_wrapper">
							<div class="one_third gallery3 filterable gallery_type animated1">
								<a href="<?php echo $image_url[0]; ?>" <?php if(!empty($pp_lightbox_enable_title)) { ?>title="<?php echo esc_attr($image_caption); ?>"<?php } ?> class="fancy-gallery">
				        		    <img src="<?php echo $small_image_url[0]; ?>" alt="" />
				        		</a>
							</div>
		    			</div>
		    		<?php
		    			}
		    		?>
		    	</div>
		    	<?php
		    		}
		    	?>
		    	<!--
		    	<?php
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
				    
				    if(!empty($pp_page_bg))
				    {
		    	?>
			    	<div class="tour_call_to_action parallax" <?php if(!empty($pp_page_bg)) { ?>style="background-image:url('<?php echo $pp_page_bg; ?>');"<?php } ?>>
						<div class="parallax_overlay_header default"></div>
						
						<div class="tour_call_to_action_box">
							<div class="tour_call_to_action_price"><?php _e( "STARTING PRICE", THEMEDOMAIN ); ?> <?php echo $habitacion_price_display; ?></div>
							<div class="tour_call_to_action_book"><?php _e( "RESERVE BY EMAIL", THEMEDOMAIN ); ?></div>
							<a id="call_to_action_tour_book_btn" <?php if(!empty($habitacion_booking_url)) { ?>href="<?php echo $habitacion_booking_url; ?>"<?php }?> class="button"><?php echo _e( 'BOOK NOW', THEMEDOMAIN ); ?></a>
						</div>
			    	</div>
		    	<?php
		    		}
		    	?>
		    	-->
		    	
		    	<?php
		    	$pp_tour_next_prev = get_option('pp_tour_next_prev');
		    	if(!empty($pp_tour_next_prev))
		    	{
				    //Get Previous and Next Post
				    $prev_post = get_previous_post();
				    $next_post = get_next_post();
				?>
				<div class="blog_next_prev_wrapper default">
				   <div class="post_previous">
				      	<?php
				    	    //Get Previous Post
				    	    if (!empty($prev_post)): 
				    	    	$prev_image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($prev_post->ID), 'thumbnail', true);
				    	    	if(isset($prev_image_thumb[0]))
				    	    	{
									$image_file_name = basename($prev_image_thumb[0]);
				    	    	}
				    	?>
				      		<a <?php if(isset($prev_image_thumb[0]) && $image_file_name!='default.png') { ?>class="post_prev_next_link" data-img="<?php echo $prev_image_thumb[0]; ?>"<?php } ?> href="<?php echo get_permalink( $prev_post->ID ); ?>"><span class="post_previous_icon"><i class="fa fa-angle-left"></i></span></a>
				      		<div class="post_previous_content">
				      			<h6><?php echo _e( 'Previous Room', THEMEDOMAIN ); ?></h6>
				      			<strong><a <?php if(isset($prev_image_thumb[0]) && $image_file_name!='default.png') { ?>class="post_prev_next_link" data-img="<?php echo $prev_image_thumb[0]; ?>"<?php } ?> href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php echo $prev_post->post_title; ?></a></strong>
				      		</div>
				      	<?php endif; ?>
				   </div>
				   <span class="separated"></span>
				   <div class="post_next">
				   		<?php
				    	    //Get Next Post
				    	    if (!empty($next_post)): 
				    	    	$next_image_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($next_post->ID), 'thumbnail', true);
				    	    	if(isset($next_image_thumb[0]))
				    	    	{
									$image_file_name = basename($next_image_thumb[0]);
				    	    	}
				    	?>
				      		<a <?php if(isset($prev_image_thumb[0]) && $image_file_name!='default.png') { ?>class="post_prev_next_link" data-img="<?php echo $next_image_thumb[0]; ?>"<?php } ?> href="<?php echo get_permalink( $next_post->ID ); ?>"><span class="post_next_icon"><i class="fa fa-angle-right"></i></span></a>
				      		<div class="post_next_content">
				      			<h6><?php echo _e( 'Next Room', THEMEDOMAIN ); ?></h6>
				      			<strong><a <?php if(isset($prev_image_thumb[0]) && $image_file_name!='default.png') { ?>class="post_prev_next_link" data-img="<?php echo $next_image_thumb[0]; ?>"<?php } ?> href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a></strong>
				      		</div>
				      	<?php endif; ?>
				   </div>
				</div>
				<?php
				}
				?>
		    </div>
		    
    	</div>
    
    </div>
    <!-- End main content -->
   
</div> 

<?php
	$pp_page_bg = '';
	//Get page featured image
	if(has_post_thumbnail($current_page_id, 'full') && empty($term))
    {
        $image_id = get_post_thumbnail_id($current_page_id); 
        $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
        $pp_page_bg = $image_thumb[0];
    }
    
    wp_enqueue_script("jquery.validate", get_template_directory_uri()."/js/jquery.validate.js", false, THEMEVERSION, true);
    wp_register_script("script-booking-form", get_template_directory_uri()."/templates/script-booking-form.php", false, THEMEVERSION, true);
	$params = array(
	  'ajaxurl' => admin_url('admin-ajax.php'),
	  'ajax_nonce' => wp_create_nonce('tgajax-post-contact-nonce'),
	);
	wp_localize_script( 'script-booking-form', 'tgAjax', $params );
	wp_enqueue_script("script-booking-form", get_template_directory_uri()."/templates/script-booking-form.php", false, THEMEVERSION, true);
	
?>
<div id="tour_book_wrapper" <?php if(!empty($pp_page_bg)) { ?>style="background-image: url('<?php echo $pp_page_bg; ?>');"<?php } ?>>
	<div class="tour_book_content">
		<a id="booking_cancel_btn" href="javascript:;"><i class="fa fa-close"></i></a>
		<div class="tour_book_form">
			<div class="tour_book_form_wrapper">
				<h2 class="ppb_title"><?php _e( "Book Now", THEMEDOMAIN ); ?><?php echo get_the_title(); ?></h2>
				<div id="reponse_msg"><ul></ul></div>
				
				<form id="pp_booking_form" method="post" action="/wp-admin/admin-ajax.php">
			    	<input type="hidden" id="action" name="action" value="pp_booking_mailer"/>
			    	<input type="hidden" id="tour_title" name="tour_title" value="<?php echo get_the_title(); ?>"/>
			    	<input type="hidden" id="tour_url" name="tour_url" value="<?php echo get_permalink($current_page_id); ?>"/>
			    	
			    	<div class="one_half">
				    	<label for="first_name"><?php echo _e( 'Name', THEMEDOMAIN ); ?></label>
						<input id="first_name" name="first_name" type="text" class="required_field"/>
			    	</div>
					
					<div class="one_half last">
						<label for="last_name"><?php echo _e( 'Last Name', THEMEDOMAIN ); ?></label>
						<input id="last_name" name="last_name" type="text" class="required_field"/>
					</div>
					
					<br class="clear"/><br/>
					
					<div class="one_half">
						<label for="email"><?php echo _e( 'Email', THEMEDOMAIN ); ?></label>
						<input id="email" name="email" type="text" class="required_field"/>
					</div>
					
					<div class="one_half last">
						<label for="phone"><?php echo _e( 'Phone', THEMEDOMAIN ); ?></label>
						<input id="phone" name="phone" type="text"/>
					</div>
					
					<br class="clear"/><br/>
					
					<div class="one">
						<label for="message"><?php echo _e( 'Message', THEMEDOMAIN ); ?></label>
					    <textarea id="message" name="message" rows="7" cols="10"></textarea>
					</div>
					
					<br class="clear"/>
				    
				    <div class="one">
					    <p>
		    				<input id="booking_submit_btn" type="submit" value="<?php echo _e( 'Book by email', THEMEDOMAIN ); ?>"/>
					    </p>
				    </div>
				</form>
			</div>
		</div>
	</div>
	<div class="parallax_overlay_header default"></div>
</div>



<?php get_footer(); ?>