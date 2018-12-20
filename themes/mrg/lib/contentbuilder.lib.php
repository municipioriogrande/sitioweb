<?php

function ppb_text_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'layout' => 'fixedwidth',
        'background' => '',
        'background_parallax' => 'none',
        'custom_css' => '',
        'custom_class' => '',
                    ), $atts));


    if (!empty($custom_class)) {
        $return_html = '<div id="' . urldecode(esc_attr($custom_class)) . '" class="' . $size . ' withsmallpadding ' . urldecode(esc_attr($custom_class)) . ' ';
    } else {
        $return_html = '<div class="' . $size . ' withsmallpadding ';
    }

    if (!empty($background)) {
        $return_html .= 'withbg ';
    }

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    if (!empty($background_parallax) && $background_parallax != 'none') {
        $return_html .= 'parallax';
    }
    $return_html .= '" ';

    $parallax_data = '';

    //Get image width and height
    $background = esc_url($background);
    $pp_background_image_id = pp_get_image_id($background);
    if (!empty($pp_background_image_id)) {
        $background_image_arr = wp_get_attachment_image_src($pp_background_image_id, 'original');

        $background_image = $background_image_arr[0];
        $background_image_width = $background_image_arr[1];
        $background_image_height = $background_image_arr[2];
    } else {
        $background_image = $background;
        $background_image_width = '';
        $background_image_height = '';
    }

    //Check parallax background

    switch ($background_parallax) {
        case 'scroll_pos':
        case 'mouse_pos':
        case 'scroll_pos':
        case 'mouse_scroll_pos':
            $parallax_data = ' data-image="' . esc_attr($background_image) . '" data-width="' . esc_attr($background_image_width) . '" data-height="' . esc_attr($background_image_height) . '"';
            break;
    }

    if ((empty($background_parallax) OR $background_parallax == 'none') && !empty($background)) {
        $return_html .= 'style="background-image:url(' . esc_attr($background_image) . ');background-size:cover;' . urldecode(esc_attr($custom_css)) . '" ';
    } elseif (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode(esc_attr($custom_css)) . '" ';
    }

    $return_html .= $parallax_data;

    $return_html .= '><div class="page_content_wrapper">' . do_shortcode(tg_apply_content($content)) . '</div>';

    $return_html .= '</div>';

    return $return_html;
}
add_shortcode('ppb_text', 'ppb_text_func');

function ppb_divider_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one'
                    ), $atts));

    $return_html = '<div class="divider ' . $size . '">&nbsp;</div>';

    return $return_html;
}
add_shortcode('ppb_divider', 'ppb_divider_func');

function ppb_gallery_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'title' => '',
        'gallery' => '',
        'background' => '',
        'custom_css' => '',
        'layout' => 'fullwidth',
                    ), $atts));

    $return_html = '<div class="' . $size . ' ppb_gallery withpadding ';

    if (!empty($background)) {
        $return_html .= 'withbg';
    }

    $columns_class = 'three_cols';
    if ($layout == 'fullwidth') {
        $columns_class .= ' fullwidth';
    }
    $element_class = 'one_third gallery3';

    $return_html .= '" ';

    if (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode($custom_css) . ' ';
    }

    if (!empty($background)) {
        $background = esc_url($background);
        if (!empty($custom_css)) {
            $return_html .= 'background-image: url(' . $background . ');background-attachment: fixed;background-position: center top;background-repeat: no-repeat;background-size: cover;" ';
        } else {
            $return_html .= 'style="background-image: url(' . $background . ');background-attachment: fixed;background-position: center top;background-repeat: no-repeat;background-size: cover;" ';
        }

        $return_html .= 'data-type="background" data-speed="10"';
    } else {
        $return_html .= '"';
    }

    $return_html .= '>';

    $return_html .= '<div class="page_content_wrapper ';

    if ($layout == 'fullwidth') {
        $return_html .= 'full_width';
    }

    $return_html .= '" style="text-align:center">';

    //Display Title
    if (!empty($title)) {
        $return_html .= '<h2 class="ppb_title">' . $title . '</h2>';
    }

    //Display Content
    if (!empty($content)) {
        $return_html .= '<div class="page_caption_desc">' . $content . '</div>';
    }

    //Display Horizontal Line
    if (empty($content) && !empty($title)) {
        $return_html .= '<br/><br/>';
    }

    //Get gallery images
    $all_photo_arr = get_post_meta($gallery, 'wpsimplegallery_gallery', true);

    //Get global gallery sorting
    $all_photo_arr = pp_resort_gallery_img($all_photo_arr);

    if (!empty($all_photo_arr) && is_array($all_photo_arr)) {
        $return_html .= '<div class="' . $columns_class . ' portfolio_filter_wrapper gallery section content clearfix">';

        foreach ($all_photo_arr as $key => $photo_id) {
            $small_image_url = '';
            $hyperlink_url = get_permalink($photo_id);

            if (!empty($photo_id)) {
                $image_url = wp_get_attachment_image_src($photo_id, 'original', true);
                $small_image_url = wp_get_attachment_image_src($photo_id, 'gallery_grid', true);
            }

            $last_class = '';
            if (($key + 1) % 4 == 0) {
                $last_class = 'last';
            }

            //Get image meta data
            $image_title = get_the_title($photo_id);
            $image_desc = get_post_field('post_content', $photo_id);
            $image_caption = get_post_field('post_excerpt', $photo_id);

            $return_html .= '<div class="element portfolio3filter_wrapper">';
            $return_html .= '<div class="' . $element_class . ' filterable gallery_type animated' . ($key + 1) . ' ' . $last_class . '">';

            if (!empty($small_image_url[0])) {
                $pp_lightbox_enable_title = get_option('pp_lightbox_enable_title');
                $pp_social_sharing = get_option('pp_social_sharing');

                $return_html .= '<a ';
                if (!empty($pp_lightbox_enable_title)) {
                    $return_html .= 'title="' . $image_caption . '" ';
                }

                $return_html .= 'class="fancy-gallery" href="' . $image_url[0] . '">';
                $return_html .= '<img src="' . $small_image_url[0] . '" alt="" class=""/>';

                if (!empty($pp_lightbox_enable_title) && !empty($image_caption)) {
                    $return_html .= '<div class="thumb_content">
						    	<h3>' . $image_caption . '</h3>
						    </div>
			    		';
                }
            }
            $return_html .= '</a></div></div>';
        }

        $return_html .= '</div>';
    }

    $return_html .= '</div></div>';

    return $return_html;
}
add_shortcode('ppb_gallery', 'ppb_gallery_func');

function ppb_gallery_slider_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'title' => '',
        'gallery' => '',
        'custom_css' => '',
        'layout' => 'fullwidth',
                    ), $atts));

    $return_html = '<div class="' . $size . ' ppb_gallery ';

    $columns_class = 'three_cols';
    if ($layout == 'fullwidth') {
        $columns_class .= ' fullwidth';
    }
    $element_class = 'one_third gallery3';

    $return_html .= '" ';

    if (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode($custom_css) . ' ';
    }

    $return_html .= '">';

    $return_html .= '<div class="page_content_wrapper ';

    if ($layout == 'fullwidth') {
        $return_html .= 'full_width';
    }

    $return_html .= '" style="text-align:center">';

    //Display Title
    if (!empty($title)) {
        $return_html .= '<h2 class="ppb_title">' . $title . '</h2>';
    }

    //Display Content
    if (!empty($content)) {
        $return_html .= '<div class="page_caption_desc">' . $content . '</div>';
    }

    //Display Horizontal Line
    if (empty($content) && !empty($title)) {
        $return_html .= '<br/><br/>';
    }

    $return_html .= do_shortcode('[tg_gallery_slider gallery_id="' . $gallery . '" size="full"]');

    $return_html .= '</div></div>';

    return $return_html;
}
add_shortcode('ppb_gallery_slider', 'ppb_gallery_slider_func');

function ppb_blog_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'title' => '',
        'category' => '',
        'items' => '',
        'background' => '',
        'background_parallax' => 'none',
        'custom_css' => '',
                    ), $atts));

    $return_html = '<div class="' . $size . ' withsmallpadding ';

    if (!empty($background)) {
        $return_html .= 'withbg ';
    }

    if (!empty($background_parallax)) {
        $return_html .= 'parallax';
    }
    $return_html .= '" ';

    $parallax_data = '';

    //Get image width and height
    $background = esc_url($background);
    $pp_background_image_id = pp_get_image_id($background);
    $background = esc_url($background);
    if (!empty($pp_background_image_id)) {
        $background_image_arr = wp_get_attachment_image_src($pp_background_image_id, 'original');

        $background_image = $background_image_arr[0];
        $background_image_width = $background_image_arr[1];
        $background_image_height = $background_image_arr[2];
    } else {
        $background_image = $background;
        $background_image_width = '';
        $background_image_height = '';
    }

    //Check parallax background
    switch ($background_parallax) {
        case 'scroll_pos':
        case 'mouse_pos':
        case 'scroll_pos':
        case 'mouse_scroll_pos':
            $parallax_data = ' data-image="' . esc_attr($background_image) . '" data-width="' . esc_attr($background_image_width) . '" data-height="' . esc_attr($background_image_height) . '"';
            break;
    }

    if ((empty($background_parallax) OR $background_parallax == 'none') && !empty($background)) {
        $return_html .= 'style="background-image:url(' . $background_image . ');background-size:cover;';

        if (!empty($custom_css)) {
            $return_html .= urldecode($custom_css);
        }

        $return_html .= '" ';
    } else {
        if (!empty($custom_css)) {
            $return_html .= 'style="' . urldecode($custom_css) . '" ';
        }
    }

    $return_html .= $parallax_data;

    $return_html .= '>';

    $return_html .= '<div class="page_content_wrapper fullwidth" style="text-align:center">';

    if (!is_numeric($items)) {
        $items = 3;
    }

    //Display Title
    if (!empty($title)) {
        $return_html .= '<h2 class="ppb_title">' . $title . '</h2>';
    }

    //Display Content
    if (!empty($content)) {
        $return_html .= '<div class="page_caption_desc">' . $content . '</div>';
    }

    //Display Horizontal Line
    if (empty($content)) {
        $return_html .= '<br/><br/>';
    }

    //Get blog posts
    $args = array(
        'numberposts' => $items,
        'order' => 'DESC',
        'orderby' => 'post_date',
        'post_type' => array('post'),
        'suppress_filters' => 0,
    );

    if (!empty($category)) {
        $args['category'] = $category;
    }
    $posts_arr = get_posts($args);

    if (!empty($posts_arr) && is_array($posts_arr)) {
        $return_html .= '<div id="blog_grid_wrapper" class="sidebar_content full_width ppb_blog_posts" style="text-align:left">';

        foreach ($posts_arr as $key => $ppb_post) {
            $animate_layer = $key + 7;
            $image_thumb = '';

            if (has_post_thumbnail($ppb_post->ID, 'large')) {
                $image_id = get_post_thumbnail_id($ppb_post->ID);
                $image_thumb = wp_get_attachment_image_src($image_id, 'large', true);
            }

            $return_html .= '<div id="post-' . $ppb_post->ID . '" class="post type-post hentry status-publish">';
            $return_html .= '<div class="post_wrapper grid_layout" ';

            if (isset($image_thumb[0]) && !empty($image_thumb[0])) {
                $return_html .= 'style="background-image:url(\'' . $image_thumb[0] . '\');"';
            }

            $return_html .= '>';
            $return_html .= '<div class="parallax_overlay_header"></div>';
            $return_html .= '<div class="grid_wrapper">';
            $return_html .= '<div class="post_header grid">';
            $return_html .= '<a href="' . get_permalink($ppb_post->ID) . '" title="' . get_the_title($ppb_post->ID) . '">';
            $return_html .= '<h6>' . get_the_title($ppb_post->ID) . '</h6></a>
			    <div class="post_detail">
			        ' . __('On', THEMEDOMAIN) . '&nbsp;' . get_the_time(THEMEDATEFORMAT, $ppb_post->ID) . '
			    </div>
			</div>';
            $return_html .= '
	    </div>
	</div>
</div>';
        }

        $return_html .= '</div>';
    }

    $return_html .= '<br class="clear"/></div></div>';

    return $return_html;
}
add_shortcode('ppb_blog', 'ppb_blog_func');

function ppb_transparent_video_bg_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'title' => '',
		'title_mobile' => '',
        'height' => '300',
        'description' => '',
        'mp4_video_url' => '',
        'webm_video_url' => '',
        'preview_img' => '',
		'cta_text'=>'',
		'cta_url'=>'',
		'custom_class' => '',
                    ), $atts));

    if (!is_numeric($height)) {
        $height = 600;
    }
	
    $return_html = '';
	if (!empty($custom_class)) {
		$return_html .= '<div class="' . $size . ' ' . urldecode(esc_attr($custom_class)) . ' ppb_transparent_video_bg" style="height:' . $height . 'px;max-height:' . $height . 'px;" >';
    } else {
        $return_html .= '<div class="' . $size . ' ppb_transparent_video_bg" style="position:relative;height:' . $height . 'px;max-height:' . $height . 'px;" >';
    }
    
    $return_html .= '<div class="ppb_video_bg_mask"></div>';

    if (!empty($title)) {
        $return_html .= '<div class="post_title entry_post ppb_transparent_video_bg_text"><div class="caption">';

        if (!empty($title)) {
            $return_html .= '<h1 class="is-desktop"><span>' . $title . '</span></h1>';
			$return_html .= '<div class="bg-title-mobile"><h1 class="is-mobile"><span>' . $content . '</span></h1></div>';
        }
		$return_html .= '<div class="content">';

        if (!empty($description)) {
            $return_html .= '<h4>' . urldecode($description). '</h4>';
        }
		if (!empty($cta_text) && !empty($cta_url)) {
            $return_html .= '<a href="'.$cta_url.'" class="page-scroll cta_button">'.$cta_text.'</a>';
        }
		$return_html .= '</div>';

        $return_html .= '</div></div>';
    }
	
	if (!empty($custom_class)) {
		$return_html .= '<div class="ppb_transparent_video_bg_content" style="position:absolute;overflow:hidden;width:100%;height:' . $height . 'px;" >';
    } else {
        $return_html .= '<div style="position:relative;width:100%;height:100%;overflow:hidden">';
    }

    if (!empty($mp4_video_url) OR ! empty($webm_video_url)) {
        //Generate unique ID
        $wrapper_id = 'ppb_video_' . uniqid();

        $return_html .= '<video ';

        if (!empty($preview_img)) {
            $return_html .= 'poster="' . $preview_img . '"';
        }

        $return_html .= 'id="' . $wrapper_id . '" loop="true" autoplay="true" muted="muted" controls="controls">';

        if (!empty($mp4_video_url)) {
            $return_html .= '<source type="video/mp4" src="' . $mp4_video_url . '" />';
        }

        if (!empty($webm_video_url)) {
            $return_html .= '<source type="video/webm" src="' . $webm_video_url . '" />';
        }

        $return_html .= '</video>';

        wp_enqueue_style("mediaelementplayer", get_template_directory_uri() . "/js/mediaelement/mediaelementplayer.css", false, THEMEVERSION, "all");
        wp_enqueue_script("mediaelement-and-player.min", get_template_directory_uri() . "/js/mediaelement/mediaelement-and-player.min.js", false, THEMEVERSION);
        wp_enqueue_script("script-ppb-video-bg" . $wrapper_id, get_stylesheet_directory_uri() . "/templates/script-ppb-video-bg.php?video_id=" . $wrapper_id . "&height=" . $height, false, THEMEVERSION, true);
    }

    $return_html .= '</div>';

    $return_html .= '</div>';
	
	if (!empty($custom_class)) {
		$return_html .= '<div class="ppb_transparent_video_bg_divider" style="margin-top:' . $height . 'px;" ></div>';
		$return_html .= '<div class="ppb_transparent_video_arrow" style="margin-top:' . $height . 'px;" >';
		$return_html .= '<div style="whidth:100%"><a class="page-scroll cta_text_descubrir_mas" href="'.$cta_url.'">' . __('SCROLL FOR MORE', THEMEDOMAIN) . '</a></div>';
		$return_html .= '<a class="page-scroll cta_descubrir_mas" href="'.$cta_url.'">';
		$return_html .= '<i class="fa fa-angle-down" aria-hidden="true"></i></a></div>';
    }

    return $return_html;
}
add_shortcode('ppb_transparent_video_bg', 'ppb_transparent_video_bg_func');

function ppb_fullwidth_button_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'title' => '',
        'link_url' => '',
                    ), $atts));

    $return_html = '<div class="' . $size . '"><a href="' . esc_url($link_url) . '" class="button fullwidth ppb"><i class="fa fa-link"></i>' . htmlentities($title) . '</a></div>';

    return $return_html;
}
add_shortcode('ppb_fullwidth_button', 'ppb_fullwidth_button_func');

function ppb_promo_box_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'title' => '',
        'button_text' => '',
        'button_url' => '',
        'background_color' => '',
                    ), $atts));

    $return_html = '<div class="one skinbg" ';

    if (!empty($background_color)) {
        $return_html .= 'style="background:' . $background_color . '"';
    }

    $return_html .= '>';
    $return_html .= '<div class="page_content_wrapper promo_box_wrapper">';
    $return_html .= do_shortcode('[tg_promo_box title="' . $title . '" button_text="' . urldecode($button_text) . '" button_url="' . esc_url($button_url) . '" button_style="button transparent"]' . $content . '[/tg_promo_box]');
    $return_html .= '</div></div>';

    return $return_html;
}
add_shortcode('ppb_promo_box', 'ppb_promo_box_func');

function ppb_contact_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'title' => '',
		'size' => 'one',
		'see_title' => 'hidden',
		'layout' => 'fixedwidth',
        'address' => '',
        'background' => '',
        'background_parallax' => 'none',
        'custom_css' => '',
		'custom_class' => '',
		'form_s_code' => '',
                    ), $atts));

	if (!empty($custom_class)) {
        $return_html = '<div class="' . $size . ' ' . urldecode(esc_attr($custom_class)) . ' ';
    } else {
        $return_html = '<div class="' . $size . ' withsmallpadding ';
    }
	
    if (!empty($background)) {
        $return_html .= 'withbg ';
    }
	
	if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    if (!empty($background_parallax)) {
        $return_html .= 'parallax';
    }
    $return_html .= '" ';

    $parallax_data = '';

    //Get image width and height
    $background = esc_url($background);
    $pp_background_image_id = pp_get_image_id($background);
    if (!empty($pp_background_image_id)) {
        $background_image_arr = wp_get_attachment_image_src($pp_background_image_id, 'original');

        $background_image = $background_image_arr[0];
        $background_image_width = $background_image_arr[1];
        $background_image_height = $background_image_arr[2];
    } else {
        $background_image = $background;
        $background_image_width = '';
        $background_image_height = '';
    }

    //Check parallax background
    switch ($background_parallax) {
        case 'scroll_pos':
        case 'mouse_pos':
        case 'scroll_pos':
        case 'mouse_scroll_pos':
            $parallax_data = ' data-image="' . esc_attr($background_image) . '" data-width="' . esc_attr($background_image_width) . '" data-height="' . esc_attr($background_image_height) . '"';
            break;
    }

    if ((empty($background_parallax) OR $background_parallax == 'none') && !empty($background)) {
        $return_html .= 'style="background-image:url(' . $background_image . ');background-size:cover;" ';
    }

    if (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode($custom_css) . '" ';
    }

    $return_html .= $parallax_data;

    $return_html .= '>';

    $return_html .= '<div class="page_content_wrapper" style="text-align:center">';
	
	
	if (!empty($see_title) && $see_title=='show') {
		//Display Title
		if (!empty($title)) {
			$return_html .= '<h2 class="ppb_title">' . $see_title.$title . '</h2>';
		}
	
		//Display Content
		if (!empty($content)) {
			$return_html .= '<div class="page_caption_desc">' . $content . '</div>';
		}

		//Display Horizontal Line
		if (empty($content)) {
			$return_html .= '<br/><br/>';
		}
	}

    $return_html .= '<div style="text-align:left">';

    //Displat address
    $return_html .= '<div class="one_half">';
    $return_html .= do_shortcode(html_entity_decode($address));
    $return_html .= '</div>';

    //Display contact form
    $return_html .= '<div class="one_half last">';
	//$return_html .= do_shortcode('[tg_gallery_slider gallery_id="' . $gallery . '" size="full"]');
	//$return_html .= do_shortcode(html_entity_decode('[contact-form-7 id="3554" title="Footer Newsletter"]'));
	if(!empty($form_s_code)){
		
		//$return_html .= do_shortcode(html_entity_decode('[contact-form-7 id="3554" title="Footer Newsletter"]'));
		//$form_s_code = str_replace("\\", "", $form_s_code);
		$return_html .= do_shortcode('[contact-form-7 id="3632" title="Contacto"]');
	
	}else{
		//Get contact form random ID
		$custom_id = time() . rand();
		$pp_contact_form = unserialize(get_option('pp_contact_form_sort_data'));
		wp_enqueue_script("jquery.validate", get_template_directory_uri() . "/js/jquery.validate.js", false, THEMEVERSION, true);
	
		wp_register_script("script-contact-form", get_template_directory_uri() . "/templates/script-contact-form.php?form=" . $custom_id . '&amp;skin=dark', false, THEMEVERSION, true);
		$params = array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'ajax_nonce' => wp_create_nonce('tgajax-post-contact-nonce'),
		);
		wp_localize_script('script-contact-form', 'tgAjax', $params);
		wp_enqueue_script("script-contact-form", get_template_directory_uri() . "/templates/script-contact-form.php?form=" . $custom_id . '&amp;skin=dark', false, THEMEVERSION, true);
	
		$return_html .= '<div id="reponse_msg_' . $custom_id . '" class="contact_form_response"><ul></ul></div>';
	
		$return_html .= '<form id="contact_form_' . $custom_id . '" class="contact_form_wrapper" method="post" action="/wp-admin/admin-ajax.php">';
		$return_html .= '<input type="hidden" id="action" name="action" value="pp_contact_mailer"/>';
	
		if (is_array($pp_contact_form) && !empty($pp_contact_form)) {
			foreach ($pp_contact_form as $form_input) {
				switch ($form_input) {
					case 1:
	
						$return_html .= '<label for="your_name">' . __('Name *', THEMEDOMAIN) . '</label><input id="your_name" name="your_name" type="text" class="required_field" placeholder="' . __('Name *', THEMEDOMAIN) . '"/>
						';
	
						break;
	
					case 2:
	
						$return_html .= '<label for="email">' . __('Email *', THEMEDOMAIN) . '</label><input id="email" name="email" type="text" class="required_field email" placeholder="' . __('Email *', THEMEDOMAIN) . '"/>
						';
	
						break;
	
					case 3:
	
						$return_html .= '<label for="message">' . __('Message *', THEMEDOMAIN) . '</label><textarea id="message" name="message" rows="7" cols="10" class="required_field" style="width:91%;" placeholder="' . __('Message *', THEMEDOMAIN) . '"></textarea>
						';
	
						break;
	
					case 4:
	
						$return_html .= '<label for="address">' . __('Address', THEMEDOMAIN) . '</label><input id="address" name="address" type="text" placeholder="' . __('Address', THEMEDOMAIN) . '"/>
						';
	
						break;
	
					case 5:
	
						$return_html .= '<label for="phone">' . __('Phone', THEMEDOMAIN) . '</label><input id="phone" name="phone" type="text" placeholder="' . __('Phone', THEMEDOMAIN) . '"/>
						';
	
						break;
	
					case 6:
	
						$return_html .= '<label for="mobile">' . __('Mobile', THEMEDOMAIN) . '</label><input id="mobile" name="mobile" type="text" placeholder="' . __('Mobile', THEMEDOMAIN) . '"/>
						';
	
						break;
	
					case 7:
	
						$return_html .= '<label for="company">' . __('Company Name', THEMEDOMAIN) . '</label><input id="company" name="company" type="text" placeholder="' . __('Company Name', THEMEDOMAIN) . '"/>
						';
	
						break;
	
					case 8:
	
						$return_html .= '<label for="country">' . __('Country', THEMEDOMAIN) . '</label><input id="country" name="country" type="text" placeholder="' . __('Country', THEMEDOMAIN) . '"/>
						';
						break;
				}
			}
		}
	
		$pp_contact_enable_captcha = get_option('pp_contact_enable_captcha');
	
		if (!empty($pp_contact_enable_captcha)) {
	
			$return_html .= '<div id="captcha-wrap">
				<div class="captcha-box">
					<img src="' . get_stylesheet_directory_uri() . '/get_captcha.php" alt="" id="captcha" />
				</div>
				<div class="text-box">
					<label>Type the two words:</label>
					<input name="captcha-code" type="text" id="captcha-code">
				</div>
				<div class="captcha-action">
					<img src="' . get_stylesheet_directory_uri() . '/images/refresh.jpg"  alt="" id="captcha-refresh" />
				</div>
			</div>
			<br class="clear"/><br/><br/>';
		}
	
		$return_html .= '<br/><br/><p>
			<input id="contact_submit_btn" type="submit" class="solidbg" value="' . __('Send', THEMEDOMAIN) . '"/>
		</p>';
	
		$return_html .= '</form>';
	
		$return_html .= '</div>';
	}

    $return_html .= '</div>';

    $return_html .= '</div>';

    $return_html .= '</div>';

    return $return_html;
}
add_shortcode('ppb_contact', 'ppb_contact_func');


/* THISNEW { */
function ppb_habitacion_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'title' => '',
        'items' => 3,
        'habitacioncat' => '',
        'order' => 'default',
        'custom_css' => '',
        'layout' => 'fullwidth',
                    ), $atts));

    if (!is_numeric($items)) {
        $items = 3;
    }

    $return_html = '<div class="ppb_habitacion ' . $size . ' withpadding ';

    $columns_class = 'three_cols';
    if ($layout == 'fullwidth') {
        $columns_class .= ' fullwidth';
    }
    $element_class = 'one_third gallery3';
    $habitacion_h = 'h5';

    if (empty($content) && empty($title)) {
        $return_html .= 'nopadding ';
    }

    $return_html .= '" ';

    if (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode($custom_css) . '" ';
    }

    $return_html .= '>';

    $return_html .= '<div class="page_content_wrapper ';

    if ($layout == 'fullwidth') {
        $return_html .= 'full_width';
    }

    $return_html .= '" style="text-align:center">';

    //Display Title
    if (!empty($title)) {
        $return_html .= '<h2 class="ppb_title">' . $title . '</h2>';
    }

    //Display Content
    if (!empty($content) && !empty($title)) {
        $return_html .= '<div class="page_caption_desc">' . $content . '</div>';
    }

    //Display Horizontal Line
    if (empty($content) && !empty($title)) {
        $return_html .= '<br/>';
    }

    $habitacion_order = 'ASC';
    $habitacion_order_by = 'menu_order';
    switch ($order) {
        case 'default':
            $habitacion_order = 'ASC';
            $habitacion_order_by = 'menu_order';
            break;

        case 'newest':
            $habitacion_order = 'DESC';
            $habitacion_order_by = 'post_date';
            break;

        case 'oldest':
            $habitacion_order = 'ASC';
            $habitacion_order_by = 'post_date';
            break;

        case 'title':
            $habitacion_order = 'ASC';
            $habitacion_order_by = 'title';
            break;

        case 'random':
            $habitacion_order = 'ASC';
            $habitacion_order_by = 'rand';
            break;
    }

    //Get habitacion items
    $args = array(
        'numberposts' => $items,
        'order' => $habitacion_order,
        'orderby' => $habitacion_order_by,
        'post_type' => array('habitaciones'),
        'suppress_filters' => 0,
    );

    if (!empty($habitacioncat)) {
        $args['habitacionescats'] = $habitacioncat;
    }
    $habitaciones_arr = get_posts($args);

    if (!empty($habitaciones_arr) && is_array($habitaciones_arr)) {
        $return_html .= '<div class="portfolio_filter_wrapper ' . $columns_class . ' shortcode gallery section content clearfix">';

        foreach ($habitaciones_arr as $key => $habitacion) {
            $image_url = '';
            $habitacion_ID = $habitacion->ID;

            if (has_post_thumbnail($habitacion_ID, 'large')) {
                $image_id = get_post_thumbnail_id($habitacion_ID);
                $image_url = wp_get_attachment_image_src($image_id, 'full', true);
                $small_image_url = wp_get_attachment_image_src($image_id, 'gallery_grid', true);
            }

            //Get Habitacion Meta
            $habitacion_permalink_url = get_permalink($habitacion_ID);
            $habitacion_title = $habitacion->post_title;
            $habitacion_country = get_post_meta($habitacion_ID, 'habitacion_country', true);
            $habitacion_price = get_post_meta($habitacion_ID, 'habitacion_price', true);
            $habitacion_price_discount = get_post_meta($habitacion_ID, 'habitacion_price_discount', true);
            $habitacion_price_currency = get_post_meta($habitacion_ID, 'habitacion_price_currency', true);
            $habitacion_discount_percentage = 0;
            $habitacion_price_display = '';

            if (!empty($habitacion_price)) {
                if (!empty($habitacion_price_discount)) {
                    if ($habitacion_price_discount < $habitacion_price) {
                        $habitacion_discount_percentage = intval((($habitacion_price - $habitacion_price_discount) / $habitacion_price) * 100);
                    }
                }

                if (empty($habitacion_price_discount)) {
                    $habitacion_price_display = $habitacion_price_currency . ' ' . pp_number_format($habitacion_price);
                } else {
                    $habitacion_price_display = $habitacion_price_currency . ' ' . pp_number_format($habitacion_price_discount);
                }
            }

            //Get number of your days
            $habitacion_days = 0;
            $habitacion_start_date = get_post_meta($habitacion_ID, 'habitacion_start_date', true);
            $habitacion_end_date = get_post_meta($habitacion_ID, 'habitacion_end_date', true);
            if (!empty($habitacion_start_date) && !empty($habitacion_end_date)) {
                $habitacion_start_date_raw = get_post_meta($habitacion_ID, 'habitacion_start_date_raw', true);
                $habitacion_end_date_raw = get_post_meta($habitacion_ID, 'habitacion_end_date_raw', true);
                $habitacion_days = pp_date_diff($habitacion_start_date_raw, $habitacion_end_date_raw);
                if ($habitacion_days > 0) {
                    $habitacion_days = intval($habitacion_days + 1) . ' ' . __('Days', THEMEDOMAIN);
                } else {
                    $habitacion_days = intval($habitacion_days + 1) . ' ' . __('Day', THEMEDOMAIN);
                }
            }

            $habitacion_permalink_url = get_permalink($habitacion_ID);

            //Begin display HTML
            $return_html .= '<div class="element portfolio3filter_wrapper">';
            $return_html .= '<div class="' . $element_class . ' filterable gallery_type animated' . ($key + 1) . '">';

            if (!empty($image_url[0])) {
                $return_html .= '<a href="' . $habitacion_permalink_url . '">
        		    <img src="' . $small_image_url[0] . '" alt="" />
        		</a>';
            }
            if (!empty($habitacion_discount_percentage)) {
                $return_html .= '<div class="habitacion_sale ';
                if ($layout == 'fullwidth') {
                    $return_html .= 'fullwidth';
                    ;
                }
                $return_html .= '"><div class="habitacion_sale_text">' . __('Best Deal', THEMEDOMAIN) . '</div>
        			' . $habitacion_discount_percentage . '% ' . __('Off', THEMEDOMAIN) . '
        		</div>';
            }

            $return_html .= '<div class="thumb_content ';
            if ($layout == 'fullwidth') {
                $return_html .= 'fullwidth';
            }
            $return_html .= ' classic">
	            <div class="thumb_title">';

            if (!empty($habitacion_country)) {
                $return_html .= '<div class="habitacion_country">
	            		' . $habitacion_country . '
	            	</div>';
            }
            $return_html .= '<h3>' . $habitacion_title . '</h3>
	            </div>
	            <div class="thumb_meta">';
            if (!empty($habitacion_days)) {
                $return_html .= '<div class="habitacion_days">
	            		' . $habitacion_days . '
	            	</div>';
            }
            if (!empty($habitacion_price)) {
                $return_html .= '<div class="habitacion_price">
	            		' . $habitacion_price_display . '
	            	</div>';
            }
            $return_html .= '</div>';

            $habitacion_excerpt = $habitacion->post_excerpt;
            if (!empty($habitacion_excerpt)) {
                $return_html .= '<br class="clear"/>
	            <div class="habitacion_excerpt">' . nl2br($habitacion_excerpt) . '</div>';
            }
            $return_html .= '</div>';
            $return_html .= '</div>';
            $return_html .= '</div>';
        }

        $return_html .= '</div>';
    }

    $return_html .= '</div></div>';

    return $return_html;
}
add_shortcode('ppb_habitacion', 'ppb_habitacion_func');

function ppb_habitacion_grid_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'title' => '',
        'items' => 4,
        'habitacioncat' => '',
        'order' => 'default',
        'custom_css' => '',
        'custom_class' => '',
        'layout' => 'fullwidth',
                    ), $atts));

    if (!is_numeric($items)) {
        $items = 4;
    }
    /* THISNEW { */
    if (!empty($custom_class)) {
		
        $return_html = '<div class="ppb_habitacion ' . $size . ' withpadding ' . urldecode(esc_attr($custom_class)) . ' ';
    } else {
        $return_html = '<div class="ppb_habitacion ' . $size . ' withpadding ';
    }
    /* } THISNEW */

    $columns_class = 'three_cols';
    if ($layout == 'fullwidth') {
        $columns_class .= ' fullwidth';
    }
    $element_class = 'one_third gallery3';
    $habitacion_h = 'h5';

    if (empty($content) && empty($title)) {
        $return_html .= 'nopadding ';
    }

    $return_html .= '" ';

    if (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode($custom_css) . '" ';
    }

    $return_html .= '>';

    $return_html .= '<div class="page_content_wrapper ';

    if ($layout == 'fullwidth') {
        $return_html .= 'full_width';
    }

    $return_html .= '" style="text-align:center">';

    //Display Title
    if (!empty($title)) {
        $return_html .= '<h2 class="ppb_title">' . $title . '</h2>';
    }

    //Display Content
    if (!empty($content) && !empty($title)) {
        $return_html .= '<div class="page_caption_desc">' . $content . '</div>';
    }

    //Display Horizontal Line
    /* if(empty($content) && !empty($title))
      {
      $return_html.= '<br/>';
      } */

    $habitacion_order = 'ASC';
    $habitacion_order_by = 'menu_order';
    switch ($order) {
        case 'default':
            $habitacion_order = 'ASC';
            $habitacion_order_by = 'menu_order';
            break;

        case 'newest':
            $habitacion_order = 'DESC';
            $habitacion_order_by = 'post_date';
            break;

        case 'oldest':
            $habitacion_order = 'ASC';
            $habitacion_order_by = 'post_date';
            break;

        case 'title':
            $habitacion_order = 'ASC';
            $habitacion_order_by = 'title';
            break;

        case 'random':
            $habitacion_order = 'ASC';
            $habitacion_order_by = 'rand';
            break;
    }

    //Get habitacion items
    $args = array(
        'numberposts' => $items,
        'order' => $habitacion_order,
        'orderby' => $habitacion_order_by,
        'post_type' => array('habitaciones'),
        'suppress_filters' => 0,
    );

    if (!empty($habitacioncat)) {
        $args['habitacionescats'] = $habitacioncat;
    }
    $habitaciones_arr = get_posts($args);
	
    if (!empty($habitaciones_arr) && is_array($habitaciones_arr)) {
        $return_html .= '<div class="portfolio_filter_wrapper ' . $columns_class . ' shortcode gallery section content clearfix">';

        foreach ($habitaciones_arr as $key => $habitacion) {
            $image_url = '';
            $habitacion_ID = $habitacion->ID;

            if (has_post_thumbnail($habitacion_ID, 'large')) {
                $image_id = get_post_thumbnail_id($habitacion_ID);
                $image_url = wp_get_attachment_image_src($image_id, 'full', true);
                $small_image_url = wp_get_attachment_image_src($image_id, 'img_grid_habitaciones', true);
            }
            //Get habitacion Meta
            $habitacion_permalink_url = get_permalink($habitacion_ID);
            $habitacion_title = $habitacion->post_title;
            $habitacion_country = get_post_meta($habitacion_ID, 'habitacion_country', true);
            $habitacion_price = get_post_meta($habitacion_ID, 'habitacion_price', true);
            $habitacion_price_discount = get_post_meta($habitacion_ID, 'habitacion_price_discount', true);
            $habitacion_price_currency = get_post_meta($habitacion_ID, 'habitacion_price_currency', true);
            $habitacion_discount_percentage = 0;
            $habitacion_price_display = '';

            if (!empty($habitacion_price)) {
                if (!empty($habitacion_price_discount)) {
                    if ($habitacion_price_discount < $habitacion_price) {
                        $habitacion_discount_percentage = intval((($habitacion_price - $habitacion_price_discount) / $habitacion_price) * 100);
                    }
                }

                if (empty($habitacion_price_discount)) {
                    $habitacion_price_display = $habitacion_price_currency . ' ' . pp_number_format($habitacion_price);
                } else {
                    $habitacion_price_display = $habitacion_price_currency . ' ' . pp_number_format($habitacion_price_discount);
                }
            }

            //Get number of your days
            $habitacion_days = 0;
            $habitacion_start_date = get_post_meta($habitacion_ID, 'habitacion_start_date', true);
            $habitacion_end_date = get_post_meta($habitacion_ID, 'habitacion_end_date', true);
            if (!empty($habitacion_start_date) && !empty($habitacion_end_date)) {
                $habitacion_start_date_raw = get_post_meta($habitacion_ID, 'habitacion_start_date_raw', true);
                $habitacion_end_date_raw = get_post_meta($habitacion_ID, 'habitacion_end_date_raw', true);
                $habitacion_days = pp_date_diff($habitacion_start_date_raw, $habitacion_end_date_raw);
                if ($habitacion_days > 0) {
                    $habitacion_days = intval($habitacion_days + 1) . ' ' . __('Days', THEMEDOMAIN);
                } else {
                    $habitacion_days = intval($habitacion_days + 1) . ' ' . __('Day', THEMEDOMAIN);
                }
            }
            $habitacion_permalink_url = get_permalink($habitacion_ID);

            //Begin display HTML
            $return_html .= '<div class="element portfolio3filter_wrapper">';
//$return_html .= '<a href="' . $habitacion_permalink_url . '">';
            $return_html .= '<div class="' . $element_class . ' filterable gallery_type animated' . ($key + 1) . '">';

            if (!empty($image_url[0])) {
                $return_html .= '<a href="' . $habitacion_permalink_url . '" style="float:left;">
        		    <img src="' . $small_image_url[0] . '" alt="" />
        		</a>';
            }
            if (!empty($habitacion_discount_percentage)) {
                $return_html .= '<div class="habitacion_sale ';
                if ($layout == 'fullwidth') {
                    $return_html .= 'fullwidth';
                    ;
                }
                $return_html .= '"><div class="habitacion_sale_text">' . __('Best Deal', THEMEDOMAIN) . '</div>
        			' . $habitacion_discount_percentage . '% ' . __('Off', THEMEDOMAIN) . '
        		</div>';
            }
            
$return_html .= '<a href="' . $habitacion_permalink_url . '" style="position:absolute; height:100%; width:100%; float:left;">';
            
            $return_html .= '<div class="thumb_content ';
            if ($layout == 'fullwidth') {
                $return_html .= 'fullwidth';
            }
            $return_html .= ' "><div class="thumb_title">';

            if (!empty($habitacion_country)) {
                $return_html .= '<div class="habitacion_country">
	            		' . $habitacion_country . '
	            	</div>';
            }
            $return_html .= '<h3>' . $habitacion_title . '</h3>
	            </div>
	            <div class="thumb_meta">';



            // if(!empty($habitacion_days))
            //  {
            //  $return_html.= '<div class="habitacion_days"> RRRRR
            //  '.$habitacion_days.'
             // </div>';
             // } 

            $habitacion_cats_arr = get_terms('habitacionescats', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
            $habitacioncat = '';
            foreach ($habitacion_cats_arr as $habitacion_cat) {
                $habitacioncat = $habitacion_cat->name;
            }
            if (!empty($habitacion_days)) {
                $return_html .= '<div class="habitacion_cat">
	            		' . $habitacioncat . '
	            	</div>';
            }
            if (!empty($habitacion_price_display)) {
                $return_html .= '<div class="habitacion_price">
	            		' . $habitacion_price_display . '
	            	</div>';
            }
          
            $return_html .= '</div>';
            $return_html .= '</div>';
            
            $return_html .= '</div>';
			$return_html .= '</a>';              
            $return_html .= '</div>';
        }

        $return_html .= '</div>';
    }

    $return_html .= '</div></div>';

    return $return_html;
}
add_shortcode('ppb_habitacion_grid', 'ppb_habitacion_grid_func');

function ppb_habitaciones_search_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'action' => '',
        'external_action' => '',
        'hotel_id' => '',
        'language_id' => '',
        'custom_css' => '',
        'custom_class' => '',
        'layout' => 'fullwidth',
                    ), $atts));

    wp_enqueue_script("jquery-ui-core");
    wp_enqueue_script("jquery-ui-datepicker");
    wp_enqueue_script("custom_date", get_template_directory_uri() . "/js/custom-date.js", false, THEMEVERSION, "all");
    wp_enqueue_script("jquery.validate", get_template_directory_uri() . "/js/jquery.validate.js", false, THEMEVERSION, true);
    wp_register_script("script-search-habitaciones-form", get_template_directory_uri() . "/templates/script-search-habitaciones-form.php", false, THEMEVERSION, true);
    wp_enqueue_script("script-search-habitaciones-form", get_template_directory_uri() . "/templates/script-search-habitaciones-form.php", false, THEMEVERSION, true);
    /* $params = array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'ajax_nonce' => wp_create_nonce('tgajax-post-contact-nonce'),
      );
      wp_localize_script( 'script-contact-form', 'tgAjax', $params );
      wp_enqueue_script("script-contact-form", get_template_directory_uri()."/templates/script-contact-form.php", false, THEMEVERSION, true);
     */
    if (!empty($custom_class)) {
        $return_html = '<div class="one pp_tour_search ' . urldecode(esc_attr($custom_class)) . ' ';
    } else {
        $return_html = '<div class="one pp_tour_search ';
    }

    if ($layout == 'fullwidth') {
        $columns_class .= ' fullwidth';
    }

    $return_html .= '"';

    if (!empty($custom_css)) {
        $return_html .= ' style="' . urldecode($custom_css) . '" ';
    }

    $return_html .= '><div class="page_content_wrapper';

    if ($layout == 'fullwidth') {
        $return_html .= ' full_width';
    }
    $return_html .= '">';

    //Begin search form
    if (!empty($external_action)) {
        $return_html .= '<form id="tour_search_form" name="tour_search_form" method="get">
	<input id="hotelId" name="hotelId" type="hidden"  value="' . $hotel_id . '" />
    <input id="languageid" name="languageid" type="hidden"  value="' . $language_id . '" />
	<input id="urldestiny" name="urldestiny" type="hidden"  value="'.$external_action.'" />
    <div class="tour_search_wrapper">';
    } else {
        $return_html .= '<form id="tour_search_form" name="tour_search_form" method="get" action="' . get_the_permalink($action) . '">
    <div class="tour_search_wrapper">';
    }
    $return_html .= '<div class="one_third one_third_search">
    		<label for="datein">' . __('Date', THEMEDOMAIN) . '</label>
    		<div class="start_date_input">
    			<input id="datein" name="datein" type="text" class="required_field" placeholder="' . __('Departure', THEMEDOMAIN) . '" />
    			<input id="datein_raw" name="datein_raw" type="hidden"/>
    			<i class="fa fa-calendar"></i>
    		</div>
    	</div>';
		
	$return_html .= '<div class="one_third one_third_search">
			<label for="datein">&nbsp;</label>
    		<div class="end_date_input">
    			<input id="dateout" name="dateout" type="text" class="required_field" placeholder="' . __('Arrival', THEMEDOMAIN) . '"/>
    			<input id="dateout_raw" name="dateout_raw" type="hidden"/>
    			<i class="fa fa-calendar"></i>
    		</div>
    	</div>';

    $return_html .= '<div class="one_third one_third_search">
    		<label for="promotioncode">' . __('PROMO CODE', THEMEDOMAIN) . '</label>
    		<input id="promotioncode" name="promotioncode" type="text" placeholder="' . __('Enter your coupon', THEMEDOMAIN) . '"/>
    	</div>';

    $return_html .= '<div class="one_third last one_third_search_last">
			<div id="reponse_msg"><ul></ul></div>
    		<input id="tour_search_btn" type="submit" value="' . __('CHECK AVAILABILITY', THEMEDOMAIN) . '"/>
    	</div>';

    $return_html .= '</div>';
    $return_html .= '</form>';
    $return_html .= '</div>';
    $return_html .= '</div>';

    return $return_html;
}
add_shortcode('ppb_habitaciones_search', 'ppb_habitaciones_search_func');
/* } THISNEW */

/* THISNEW MRG { */
function ppb_header_gallery_slider_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'size' => 'one',
        'title' => '',
        'items' => 3,
        'sliders' => '',
        'order' => 'default',
		'height' => '350',
        'custom_css' => '',
        'custom_class' => '',
        'layout' => 'fullwidth',
                    ), $atts));

    $return_html = '<div class="ppb_header_gallery ' . $size . ' ';

    $columns_class = 'three_cols';
    if ($layout == 'fullwidth') {
        $columns_class .= ' fullwidth';
    }
    $element_class = 'one_third gallery3';

    $return_html .= '" ';

    if (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode($custom_css) . '" ';
    }
	$return_html .= '>';

    $return_html .= '<div class="page_content_wrapper ';

    if ($layout == 'fullwidth') {
        $return_html .= 'full_width';
    }

    $return_html .= '" style="text-align:center">';

	wp_enqueue_script("flexslider-js", get_template_directory_uri()."/js/flexslider/jquery.flexslider-min.js", false, THEMEVERSION, true);
	wp_enqueue_script("script-gallery-flexslider", get_template_directory_uri()."/templates/script-gallery-flexslider.php", false, THEMEVERSION, true);
	
	$slider_order = 'ASC';
    $slider_order_by = 'menu_order';
    switch ($order) {
        case 'default':
            $slider_order = 'ASC';
            $slider_order_by = 'menu_order';
            break;

        case 'newest':
            $slider_order = 'DESC';
            $slider_order_by = 'post_date';
            break;

        case 'oldest':
            $slider_order = 'ASC';
            $slider_order_by = 'post_date';
            break;

        case 'title':
            $slider_order = 'ASC';
            $slider_order_by = 'title';
            break;

        case 'random':
            $slider_order = 'ASC';
            $slider_order_by = 'rand';
            break;
    }

    //Get habitacion items
    $args = array(
        //'numberposts' => $items,
        'order' => $slider_order,
        'orderby' => $slider_order_by,
        'post_type' => array('slider'),
        'suppress_filters' => 0,
    );

    if (!empty($sliders)) {
        $args['sliders'] = $sliders;
    }
    $sliders_arr = get_posts($args);
	
    if (!empty($sliders_arr) && is_array($sliders_arr)) {
		
		$return_html.= '<div class="slider_wrapper">';
		$return_html.= '<div class="flexslider" data-height="'.$height.'">';
		$return_html.= '<ul class="slides">';
		
        foreach ($sliders_arr as $key => $slider) {
			
            $image_url = '';
            $slider_ID = $slider->ID;

            if (has_post_thumbnail($slider_ID, 'large')) {
                $image_id = get_post_thumbnail_id($slider_ID);
                $image_url = wp_get_attachment_image_src($image_id, 'full', true);
                $small_image_url = wp_get_attachment_image_src($image_id, 'img_destacado_slider_home', true);
            }
			
			
            //Get slider Meta
            $slider_permalink_url 		= get_permalink($slider_ID);
            $slider_title 				= $slider->post_title;
			$slider_content				= $slider->post_content;
			$slider_show_button 		= get_post_meta($slider_ID, 'slider_show_button', true);
			$slider_url_button 			= get_post_meta($slider_ID, 'slider_url_button', true);
			$slider_url_button_text 	= get_post_meta($slider_ID, 'slider_url_button_text', true);
			$slider_show_cta 			= get_post_meta($slider_ID, 'slider_show_cta', true);
			$slider_cta_code 			= get_post_meta($slider_ID, 'slider_cta_code', true);
			
			$slider_show_greeting 		= get_post_meta($slider_ID, 'slider_show_greeting', true);
			$slider_text_day 			= get_post_meta($slider_ID, 'slider_text_day', true);
			$slider_text_afternoon 		= get_post_meta($slider_ID, 'slider_text_afternoon', true);
			$slider_text_night 			= get_post_meta($slider_ID, 'slider_text_night', true);
			
			if(!empty($slider_show_greeting))
			{
				date_default_timezone_set('UTC');
				date_default_timezone_set("America/Argentina/Ushuaia");
				setlocale(LC_ALL,"es_ES");
				
				# Consultamos si existe el archivo de clima
				$salutation_file 		= dirname(__FILE__).'\saludo.json';
					
				$hora 					= getdate();
				$segundos_menos 		= 3600*3; 										// Diferencia horaria (3hs Argentina)
				$segundos_validos 		= 3600*5; 										// Segundos validos para el archivo (5hs)
				$hora_actual 			= gmdate("H:i:s", ($hora[0]-$segundos_menos));	// Formateamos hora de sistema
				$hora_archivo 			= date("H:i:s.", filemtime($salutation_file));	// Formateamos hora de sistema
				$horas_resta 			= MRG_normalice_fecha($hora_actual)-MRG_normalice_fecha($hora_archivo);
				
				if($horas_resta<=$segundos_validos && file_exists($salutation_file)){
					$satutation_response_load = json_decode(file_get_contents($salutation_file), true);
					//echo 'Cargo archivo<br>'."\r";
				}
				else
				{
					$satutation_response_load = MRG_salutation_open_weather_map();
					//echo 'Proceso archivo<br>'."\r";
				}
				
				if($satutation_response_load['saludo']=='dia')
				{
					$retorno_saludo = $slider_text_day ;
				}
				elseif($satutation_response_load['saludo']=='tarde')
				{
					$retorno_saludo = $slider_text_afternoon;
				}
				elseif($satutation_response_load['saludo']=='noche')
				{
					$retorno_saludo = $slider_text_night;
				}
				else
				{
					$retorno_saludo = 'Error!';
				}
			}
			

            //Begin display HTML
            /*if (!empty($image_url[0])) {
        		    echo $small_image_url[0];
            }
			$image_url 		= wp_get_attachment_image_src($image, $size, true);
			$image_title 	= get_the_title($image);
		    $image_caption 	= get_post_field('post_excerpt', $image);
		    $image_desc 	= get_post_field('post_content', $image);*/
			
			//$return_html.= '<li class="slide" style="background-image: url('.$small_image_url[0].'); height:'.$height.'px;">';
			$return_html.= '<li class="slide" style="background-image: -webkit-linear-gradient(270deg, rgba(0, 0, 0, .40), rgba(7, 112, 183, .5)), url('.$small_image_url[0].'); background-image: linear-gradient(180deg, rgba(0, 0, 0, .40), rgba(7, 112, 183, .5)), url('.$small_image_url[0].'); height:'.$height.'px;">';
			
			if(!empty($slider_title))
			{
				$return_html.= '<div class="box">';
				if(!empty($slider_show_greeting))
				{
					//$return_html.= '<h1>'.$saludo['saludo'].'</h1>';
					$return_html.= '<h1>'.$retorno_saludo.'</h1>';
				}else{
					$return_html.= '<h1>'.$slider_title.'</h1>';
				}
				$return_html.= '<p>'.$slider_content.'</p>';
				if(!empty($slider_show_cta))
				{
					$return_html.= $slider_cta_code;
				}
				else
				{
					if(!empty($slider_url_button_text))
					{
						$return_html.= '<a href="'.$slider_url_button.'" class="button">'.$slider_url_button_text.'</a>';
					}
				}
				$return_html.= '</div>';
			}
			
			//$return_html.= '<img src="'.$image_url[0].'" alt="AAAAAAAAAA"/>';
			$return_html.= '</li>';
            

            /*$slider_cats_arr = get_terms('sliders', 'hide_empty=0&hierarchical=0&parent=0&orderby=menu_order');
            $habitacioncat = '';
            foreach ($habitacion_cats_arr as $habitacion_cat) {
                $habitacioncat = $habitacion_cat->name;
            }
            if (!empty($habitacion_days)) {
                $return_html .= '<div class="habitacion_cat">
	            		' . $habitacioncat . '
	            	</div>';
            }
            if (!empty($habitacion_price_display)) {
                $return_html .= '<div class="habitacion_price">
	            		' . $habitacion_price_display . '
	            	</div>';
            }*/
          
            
        }

        $return_html.= '</ul>';
		$return_html.= '</div>';
		$return_html.= '</div>';
		
		$return_html .= '</div>';
    }
	
    $return_html .= '</div>';

    return $return_html;
}
add_shortcode('ppb_header_gallery_slider', 'ppb_header_gallery_slider_func');

function ppb_alert_notice_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'titulo' => '',
		'show_module' => 'Mostrar',
		'layout' => 'fixedwidth',
        'boton_url' => '',
		'boton_text' => '',
		'boton_cta' => '',
        'custom_css' => '',
        'custom_class' => '',
                    ), $atts));
	
	$return_html = '';
	
	if (!empty($show_module) && $show_module=='true') {

	
		$return_html .= '<div class="ppb_alert_notice ';
		/*
		if (!empty($custom_class)) {
			$return_html = $size . ' withsmallpadding ' . urldecode(esc_attr($custom_class)) . ' id="' . urldecode(esc_attr($custom_class)) . '" ';
		} else {
			$return_html = ' ' . $size . ' withsmallpadding ';
		}*/
	
		if (!empty($layout) && $layout == 'fullwidth') {
			$return_html .= 'fullwidth ';
		}
	
		$return_html .= '" ';
		$return_html .= '><div class="page_content_wrapper">';
		
		# Contenido
		$return_html .= '	<div class="page_content_content">';
		$return_html .= '		<div class="title">'.$titulo . '</div>';
		$return_html .= '		<div class="divisor"><img src="'. get_template_directory_uri() .'/images/bell.svg" width="25px"></div>';
		$return_html .= '		<div class="content">'.$content . '</div>';
		
		
		if(!empty($boton_cta))
		{
			$return_html .= '		<div class="cta">'.$boton_cta . '</div>';
		}
		else
		{
			if(!empty($boton_url) && !empty($boton_text))
			{
				$return_html .= '		<div class="cta"><a href="'.$boton_url.'" class="bt">'.$boton_text.'</a></div>';
			}
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>';
		$return_html .= '</div>';
	}
    return $return_html;
}
add_shortcode('ppb_alert_notice', 'ppb_alert_notice_func');

function ppb_secciones_destacadas_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'seccion_1_text' 	=> '',
		'seccion_1_url'		=> '',
		'seccion_1_imagen' 	=> '',
        
		'seccion_2_text' 	=> '',
		'seccion_2_url'		=> '',
		'seccion_2_imagen' 	=> '',
		
		'seccion_3_text' 	=> '',
		'seccion_3_url'		=> '',
		'seccion_3_imagen' 	=> '',
		
		'seccion_4_text' 	=> '',
		'seccion_4_url'		=> '',
		'seccion_4_imagen' 	=> '',
		
		'seccion_5_text' 	=> '',
		'seccion_5_url'		=> '',
		'seccion_5_imagen' 	=> '',
		
		'custom_css' 		=> '',
        'custom_class' 		=> '',
                    ), $atts));

	$return_html = '<div class="ppb_secciones_destacadas ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	# Contenido
	$return_html .= $content . ' ';
	
	if(!empty($seccion_1_text))
	{
		$return_html.= '<a href="'.$seccion_1_url.'" class="bt">';
		$return_html.= '<div class="box">';
		$return_html.= '<img src="'.$seccion_1_imagen.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_1_text.'</h3>';
		$return_html.= '</div>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_2_text))
	{
		$return_html.= '<a href="'.$seccion_2_url.'" class="bt">';
		$return_html.= '<div class="box">';
		$return_html.= '<img src="'.$seccion_2_imagen.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_2_text.'</h3>';
		$return_html.= '</div>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_3_text))
	{
		$return_html.= '<a href="'.$seccion_3_url.'" class="bt">';
		$return_html.= '<div class="box">';
		$return_html.= '<img src="'.$seccion_3_imagen.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_3_text.'</h3>';
		$return_html.= '</div>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_4_text))
	{
		$return_html.= '<a href="'.$seccion_4_url.'" class="bt">';
		$return_html.= '<div class="box">';
		$return_html.= '<img src="'.$seccion_4_imagen.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_4_text.'</h3>';
		$return_html.= '</div>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_5_text))
	{
		$return_html.= '<a href="'.$seccion_5_url.'" class="bt">';
		$return_html.= '<div class="box">';
		$return_html.= '<img src="'.$seccion_5_imagen.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_5_text.'</h3>';
		$return_html.= '</div>';
		$return_html.= '</a>';
	}
	
	$return_html .= '</div>';
    $return_html .= '</div>';

    return $return_html;
}
add_shortcode('ppb_secciones_destacadas', 'ppb_secciones_destacadas_func');

function ppb_descubre_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 	=> '',
		
		'seccion_a1_imagen' 	=> '',
		'seccion_a1_text'		=> '',
		'seccion_a1_url' 		=> '',
		'seccion_a1_copete' 	=> '',
        
		'seccion_a2_imagen' 	=> '',
		'seccion_a2_text'		=> '',
		'seccion_a2_url' 		=> '',
		'seccion_a2_copete' 	=> '',
		
		'seccion_a3_imagen' 	=> '',
		'seccion_a3_text'		=> '',
		'seccion_a3_url' 		=> '',
		'seccion_a3_copete' 	=> '',
		
		'seccion_a4_imagen' 	=> '',
		'seccion_a4_text'		=> '',
		'seccion_a4_url' 		=> '',
		'seccion_a4_copete' 	=> '',
		
		'custom_css' 		=> '',
        'custom_class' 		=> '',
                    ), $atts));

	$return_html = '<div class="ppb_descubre ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	
	$return_html.= '<div class="title">'.html_entity_decode($titulo).'</div>';
	
	# Contenido
	//$return_html .= $content . ' ';
	
	if(!empty($seccion_a1_text))
	{
		$return_html.= '<a href="'.$seccion_a1_url.'" class="bt">';
		$return_html.= '<div class="box">';
		$return_html.= '<img src="'.$seccion_a1_imagen.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_a1_text.'</h3>';
		$return_html.= '<p>'.$seccion_a1_copete.'</p>';
		$return_html.= '</div>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_a2_text))
	{
		$return_html.= '<a href="'.$seccion_a2_url.'" class="bt">';
		$return_html.= '<div class="box">';
		$return_html.= '<img src="'.$seccion_a2_imagen.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_a2_text.'</h3>';
		$return_html.= '<p>'.$seccion_a2_copete.'</p>';
		$return_html.= '</div>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_a3_text))
	{
		$return_html.= '<a href="'.$seccion_a3_url.'" class="bt">';
		$return_html.= '<div class="box">';
		$return_html.= '<img src="'.$seccion_a3_imagen.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_a3_text.'</h3>';
		$return_html.= '<p>'.$seccion_a3_copete.'</p>';
		$return_html.= '</div>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_a4_text))
	{
		$return_html.= '<a href="'.$seccion_a4_url.'" class="bt">';
		$return_html.= '<div class="box">';
		$return_html.= '<img src="'.$seccion_a4_imagen.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_a4_text.'</h3>';
		$return_html.= '<p>'.$seccion_a4_copete.'</p>';
		$return_html.= '</div>';
		$return_html.= '</a>';
	}
	
	$return_html .= '</div>';
    $return_html .= '</div>';

    return $return_html;
}
add_shortcode('ppb_descubre', 'ppb_descubre_func');



function ppb_gestion_municipal_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'title' 	=> '',
		'titulo' 	=> '',
		
		'show_margin_superior' => 'big',
		'show_margin_inferiro' => 'no',
		'column_number' 	=> '5',
		'seccion_1_icono' 	=> '',
		'seccion_1_text'	=> '',
		'seccion_1_url' 	=> '',
        
		'seccion_2_icono' 	=> '',
		'seccion_2_text'	=> '',
		'seccion_2_url' 	=> '',
		
		'seccion_3_icono' 	=> '',
		'seccion_3_text'	=> '',
		'seccion_3_url' 	=> '',
		
		'seccion_4_icono' 	=> '',
		'seccion_4_text'	=> '',
		'seccion_4_url' 	=> '',
		
		'seccion_5_icono' 	=> '',
		'seccion_5_text'	=> '',
		'seccion_5_url' 	=> '',
		
		'seccion_6_icono' 	=> '',
		'seccion_6_text'	=> '',
		'seccion_6_url' 	=> '',

		'custom_css' 		=> '',
        'custom_class' 		=> '',
                    ), $atts));
	
	switch($column_number){
		case '1':
			$ancho_columna = '98%';
		break;
		case '2':
			$ancho_columna = '48%';
		break;
		case '3':
			$ancho_columna = '31.3%';
		break;
		case '4':
			$ancho_columna = '23%';
		break;
		case '5':
			$ancho_columna = '18%';
		break;
		case '6':
			$ancho_columna = '14.64%';
		break;
		default:
			$ancho_columna = '18%';
		break;
	}
	
	switch($show_margin_superior){
		case 'normal':
			$margen_top = '80px';
		break;
		case 'big':
			$margen_top = '120px';
		break;
		case 'small':
			$margen_top = '50px';
		break;
		default:
			$margen_top = '120px';
		break;
	}

	if (!function_exists ('ppb_gestion_municipal_print_icon')) {
		function ppb_gestion_municipal_print_icon($text, $icon, $url, $col_width) {
			return '<a href="'.$url.'" class="bt">
						<div class="box" style="width: '.$col_width.';">
							<img src="'.$icon.'" class="image" alt="'.get_attachment_metadata_from_url($icon, "alt_text").'"/>
							<h3>'.$text.'</h3>
						</div>
					</a>';		
		}
	}

	$return_html = '<div class="ppb_gestion_municipal ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
	if($show_margin_inferiro == 'si')
	{
		$return_html .= ' style="margin: 0 0 50px 0 !important;" ';
	}
    $return_html .= '><div class="page_content_wrapper">';
	
	if (!empty($titulo)){
		$return_html.= '<div class="title" style="margin-top: '.$margen_top.' !important;">'.$titulo.'</div>';
	}
	
	# Contenido

	if(!empty($seccion_1_text))	{
		$return_html.= ppb_gestion_municipal_print_icon($seccion_1_text, $seccion_1_icono, $seccion_1_url, $ancho_columna);
	}
	if(!empty($seccion_2_text))	{
		$return_html.= ppb_gestion_municipal_print_icon($seccion_2_text, $seccion_2_icono, $seccion_2_url, $ancho_columna);
	}
	if(!empty($seccion_3_text))	{
		$return_html.= ppb_gestion_municipal_print_icon($seccion_3_text, $seccion_3_icono, $seccion_3_url, $ancho_columna);
	}
	if(!empty($seccion_4_text))	{
		$return_html.= ppb_gestion_municipal_print_icon($seccion_4_text, $seccion_4_icono, $seccion_4_url, $ancho_columna);
	}
	if(!empty($seccion_5_text))	{
		$return_html.= ppb_gestion_municipal_print_icon($seccion_5_text, $seccion_5_icono, $seccion_5_url, $ancho_columna);
	}
	
	if(!empty($seccion_6_text))	{
		$return_html.= ppb_gestion_municipal_print_icon($seccion_6_text, $seccion_6_icono, $seccion_6_url, $ancho_columna);
	}
	
	$return_html .= '</div>';
    $return_html .= '</div>';

    return $return_html;
}
add_shortcode('ppb_gestion_municipal', 'ppb_gestion_municipal_func');

function ppb_content_blog_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		
		'show_items'		=> '3',
		//'shortcodeform' 	=> '',
		
		'custom_css' 		=> '',
        'custom_class' 		=> '',
                    ), $atts));
	
	$pp_hubspot_api_key = get_option('pp_hubspot_api_key');
	
	$return_html = '<div class="ppb_content_blog ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html.= '<div class="title">'.html_entity_decode($titulo).'</div>';
	
	# JSON DE HUBSPOT
	$name_file 	= dirname(__FILE__).'/json/data_hubspot.json';
	$url_post = 'https://api.hubapi.com/content/api/v2/blog-posts?state=PUBLISHED&hapikey='.$pp_hubspot_api_key;
	
	# Si el archivo no existe lo cre por primera vez
	if(!file_exists($name_file))
	{
		$data = MRG_make_file_hubspot_blog($url_post,$name_file);
		$status = 'Init';
	}
	else
	{
		date_default_timezone_set('UTC');
		date_default_timezone_set("America/Argentina/Ushuaia");
		setlocale(LC_ALL,"es_ES");
		
		$hora 					= getdate();
		$segundos_menos 		= 3600*3; 									// Diferencia horaria (3hs Argentina)
		$segundos_validos 		= 3600; 										// Segundos validos para el archivo (5hs)
		$hora_actual 			= gmdate("H:i:s", ($hora[0]-$segundos_menos));	// Formateamos hora de sistema
		$hora_archivo 			= date("H:i:s.", filemtime($name_file));	// Formateamos hora de sistema
		$horas_resta 			= MRG_normalice_fecha($hora_actual)-MRG_normalice_fecha($hora_archivo);
		
		if($horas_resta<=$segundos_validos){
			$data = json_decode(file_get_contents($name_file), true);
			$status = 'On time';
		}
		else
		{
			$data = MRG_make_file_hubspot_blog($url_post,$name_file);
			$status = 'Off time';
		}
	}

	/*
	$url_post = 'https://api.hubapi.com/content/api/v2/blog-posts?state=PUBLISHED&hapikey='.$pp_hubspot_api_key;  
	$ch = curl_init($url_post);                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	$result = curl_exec($ch);
	
	$return_data = json_decode($result, true);*/
	
	//$data = $return_data['objects'];
	$elements_to_show = $show_items-1;
	$data_length = count($data)-1;
	
	if($data_length>=1)
	{
		$return_html.= '<div class="row" data-state="'.$status.'">';
		
		for($i=0; $i<=$data_length; $i++)
		{
			if($i<=2)
			{
				if($i<=$elements_to_show)
				{
					$return_html .= '<div class="col-md col-md-4">';
					$return_html .= '	<div class="box-flex">';
					$return_html .= '		<div class="image" style="background-image:url(\''.rawurldecode($data[$i]['featured_image']).'\')">';
					$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_small.gif" alt="image" width="100%">';
					$return_html .= '		</div>';
					$return_html .= '		<div class="content-middle">';
					$return_html .= '			<div class="title">';
					$return_html .= '				<a href="'.$data[$i]['absolute_url'].'"><h3>'.$data[$i]['html_title'].'</h3></a>';
					$return_html .= '			</div>';
					
					if(!empty($data[$i]['tag_ids']['0']))
					{
						$return_html .= '			<div class="category">';
					
						$url_tags_ids = 'https://api.hubapi.com/blogs/v3/topics/'.$data[$i]['tag_ids']['0'].'?hapikey='.$pp_hubspot_api_key;
						$ch2 = curl_init($url_tags_ids);                                                                      
						curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
						curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);                                                                      
						$result_tags_ids = curl_exec($ch2);
						$return_data_tags_ids = json_decode($result_tags_ids, true);
						
						if(is_array($return_data_tags_ids) && !empty($return_data_tags_ids['name']))
						{
							$return_html .= '				<a class="button_categoria_select w-button" href="//info.riogrande.gob.ar/topic/'.$return_data_tags_ids['name'].'">'.$return_data_tags_ids['name'].'</a>';
						}
					
						$return_html .= '			</div>';
					}
					$return_html .= '		</div>';
					$return_html .= '	</div>';
					$return_html .= '</div>'."\r";
				}
			}
			if($i==3)
			{
				$return_html .= '<div class="col-md col-md-4 ss_form">';
				$return_html .= '	<div class="box-flex box-flex-variant">';
				$return_html .= '	<div class="ss_content_form">';
				$return_html .= '		<div class="ss_text">';
				$return_html .= '	    	<h2>Suscribite a noticias de la Muni</h2>';
				$return_html .= '	    </div>';
				//$return_html .= do_shortcode(html_entity_decode($shortcodeform));
				$return_html .= do_shortcode('[contact-form-7 id="100" title="Sucribe a noticias"]');
				$return_html .= '	</div>';
				$return_html .= '	</div>';
				$return_html .= '</div>'."\r";
			}
			if($i==4)
			{
				$return_html .= '<div class="col-md col-md-8">';
				$return_html .= '	<div class="box-flex box-flex-variant">';
				$return_html .= '		<div class="image" style="background-image:url(\''.rawurldecode($data[$i]['featured_image']).'\')">';
				$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_medium.gif" alt="image" width="100%">';
				$return_html .= '		</div>';
				$return_html .= '		<div class="content-middle">';
				$return_html .= '			<div class="title">';
				$return_html .= '				<a href="'.$data[$i]['absolute_url'].'"><h3>'.$data[$i]['html_title'].'</h3></a>';
				$return_html .= '			</div>';
				
				if(!empty($data[$i]['tag_ids']['0']))
				{
					$return_html .= '			<div class="category">';
				
					$url_tags_ids = 'https://api.hubapi.com/blogs/v3/topics/'.$data[$i]['tag_ids']['0'].'?hapikey='.$pp_hubspot_api_key;
					$ch2 = curl_init($url_tags_ids);                                                                      
					curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
					curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);                                                                      
					$result_tags_ids = curl_exec($ch2);
					$return_data_tags_ids = json_decode($result_tags_ids, true);
					
					if(is_array($return_data_tags_ids) && !empty($return_data_tags_ids['name']))
					{
						$return_html .= '				<a class="button_categoria_select w-button" href="//info.riogrande.gob.ar/topic/'.$return_data_tags_ids['name'].'">'.$return_data_tags_ids['name'].'</a>';
					}
				
					$return_html .= '			</div>';
				}
				$return_html .= '		</div>';
				$return_html .= '	</div>';
				$return_html .= '</div>'."\r";
			}
			if($i==2)
			{
				$return_html.= '</div>';
				$return_html.= '<div class="row">';
			}
		}
	
		$return_html .= '</div>'; //close second row
	}
	$return_html .= '<div class="icon_blog">';
	$return_html .= '	<a class="button_blog" href="//info.riogrande.gob.ar/" target="_blank"><img src="'. get_template_directory_uri() .'/images/globa_blog.svg" alt="Blog" width="73"></a>';
	$return_html .= '</div>';
	
	$return_html .= '</div>';
    $return_html .= '</div>';
	
    return $return_html;
}
add_shortcode('ppb_content_blog', 'ppb_content_blog_func');

function ppb_telefonos_utiles_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		
		'seccion_01_imagen' 	=> '',
		'seccion_01_text'		=> '',
		'seccion_01_numnero' 	=> '',
		
		'seccion_02_imagen' 	=> '',
		'seccion_02_text'		=> '',
		'seccion_02_numnero' 	=> '',
		
		'seccion_03_imagen' 	=> '',
		'seccion_03_text'		=> '',
		'seccion_03_numnero' 	=> '',
		
		'seccion_04_imagen' 	=> '',
		'seccion_04_text'		=> '',
		'seccion_04_numnero' 	=> '',
		
		'seccion_05_imagen' 	=> '',
		'seccion_05_text'		=> '',
		'seccion_05_numnero' 	=> '',
		
		'custom_css' 		=> '',
        'custom_class' 		=> '',
                    ), $atts));

	$return_html = '<div class="ppb_telefonos_utiles ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="title">'.html_entity_decode($titulo).'</div>';
	$return_html .= '<div class="row">';
	
	if(!empty($seccion_01_text))
	{
		$return_html .= '<div class="col-md col-md-2_4">';
		$return_html .= '	<div class="box-flex">';
		$return_html .= '		<div class="image" style="background-image:url(\''.$seccion_01_imagen.'\')">';
		$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_smaller.gif" alt="image" width="100%">';
		$return_html .= '		</div>';
		$return_html .= '		<div class="content-middle">';
		$return_html .= '			<div class="title">';
		$return_html .= '				<h3>'.$seccion_01_text.'</h3>';
		$return_html .= '			</div>';
		$return_html .= '			<div class="number">';
		$return_html .= '				<h2>'.$seccion_01_numnero.'</h2>';
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>';
		$return_html .= '</div>'."\r";
	}
	if(!empty($seccion_02_text))
	{
		$return_html .= '<div class="col-md col-md-2_4">';
		$return_html .= '	<div class="box-flex">';
		$return_html .= '		<div class="image" style="background-image:url(\''.$seccion_02_imagen.'\')">';
		$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_smaller.gif" alt="image" width="100%">';
		$return_html .= '		</div>';
		$return_html .= '		<div class="content-middle">';
		$return_html .= '			<div class="title">';
		$return_html .= '				<h3>'.$seccion_02_text.'</h3>';
		$return_html .= '			</div>';
		$return_html .= '			<div class="number">';
		$return_html .= '				<h2>'.$seccion_02_numnero.'</h2>';
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>';
		$return_html .= '</div>'."\r";
	}
	if(!empty($seccion_03_text))
	{
		$return_html .= '<div class="col-md col-md-2_4">';
		$return_html .= '	<div class="box-flex">';
		$return_html .= '		<div class="image" style="background-image:url(\''.$seccion_03_imagen.'\')">';
		$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_smaller.gif" alt="image" width="100%">';
		$return_html .= '		</div>';
		$return_html .= '		<div class="content-middle">';
		$return_html .= '			<div class="title">';
		$return_html .= '				<h3>'.$seccion_03_text.'</h3>';
		$return_html .= '			</div>';
		$return_html .= '			<div class="number">';
		$return_html .= '				<h2>'.$seccion_03_numnero.'</h2>';
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>';
		$return_html .= '</div>'."\r";
	}
	if(!empty($seccion_04_text))
	{
		$return_html .= '<div class="col-md col-md-2_4">';
		$return_html .= '	<div class="box-flex">';
		$return_html .= '		<div class="image" style="background-image:url(\''.$seccion_04_imagen.'\')">';
		$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_smaller.gif" alt="image" width="100%">';
		$return_html .= '		</div>';
		$return_html .= '		<div class="content-middle">';
		$return_html .= '			<div class="title">';
		$return_html .= '				<h3>'.$seccion_04_text.'</h3>';
		$return_html .= '			</div>';
		$return_html .= '			<div class="number">';
		$return_html .= '				<h2>'.$seccion_04_numnero.'</h2>';
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>';
		$return_html .= '</div>'."\r";
	}
	if(!empty($seccion_05_text))
	{
		$return_html .= '<div class="col-md col-md-2_4">';
		$return_html .= '	<div class="box-flex">';
		$return_html .= '		<div class="image" style="background-image:url(\''.$seccion_05_imagen.'\')">';
		$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_smaller.gif" alt="image" width="100%">';
		$return_html .= '		</div>';
		$return_html .= '		<div class="content-middle">';
		$return_html .= '			<div class="title">';
		$return_html .= '				<h3>'.$seccion_05_text.'</h3>';
		$return_html .= '			</div>';
		$return_html .= '			<div class="number">';
		$return_html .= '				<h2>'.$seccion_05_numnero.'</h2>';
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>';
		$return_html .= '</div>'."\r";
	}
		
	$return_html .= '</div>'; //close row
	$return_html .= '</div>';
    $return_html .= '</div>';
	
    return $return_html;
}
add_shortcode('ppb_telefonos_utiles', 'ppb_telefonos_utiles_func');


function ppb_module_header_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 				=> '',
		'bajada' 				=> '',
		'contacto_titulo' 		=> '',
		'contacto_telefono' 	=> '',
		'contacto_horario' 		=> '',
		'contacto_direccion' 	=> '',
		'contacto_email' 		=> '',
		'contacto_twitter_url' 	=> '',
		'contacto_facebook_url' => '',
		'contacto_instagram_url' => '',
		
    ), $atts));

	$return_html = '<div class="bilder_modul ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$bajada = trim(str_replace($scapes, '', html_entity_decode($bajada)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-8">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
	$return_html .= '			<p>'.html_entity_decode($bajada).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md col-md-4">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<h5 class="blue-dark">'.$contacto_titulo.'</h5>';
	$return_html .= '			<ul>';
	$return_html .= '				<li><img src="'. get_template_directory_uri() .'/images/iconos/celular.svg" alt="Teléfono" width="37px">'.$contacto_telefono.'</li>';
	$return_html .= '				<li><img src="'. get_template_directory_uri() .'/images/iconos/horario.svg" alt="Horario" width="37px">&nbsp;'.$contacto_horario.'</li>';
	$return_html .= '				<li><img src="'. get_template_directory_uri() .'/images/iconos/globa.svg" alt="Dirección" width="37px">&nbsp;'.$contacto_direccion.'</li>';
	if(!empty($contacto_email))
	{
		$return_html .= '				<li><img src="'. get_template_directory_uri() .'/images/iconos/email.svg" alt="Email" width="37px">&nbsp;&nbsp;<a href="mailto:'.$contacto_email.'" alt="'.$contacto_email.'">Contactanos</a></li>';
	}
	if(!empty($contacto_twitter_url))
	{
		$return_html .= '				<li><img src="'. get_template_directory_uri() .'/images/iconos/twitter.svg" alt="Twitter" width="37px">&nbsp;&nbsp;<a href="'.$contacto_twitter_url.'" alt="'.$contacto_twitter_url.'" target="_blank">Twitter</a></li>';
	}
	if(!empty($contacto_facebook_url))
	{
		$return_html .= '				<li><img src="'. get_template_directory_uri() .'/images/iconos/facebook.svg" alt="Facebook" width="37px">&nbsp;&nbsp;<a href="'.$contacto_facebook_url.'" alt="'.$contacto_facebook_url.'" target="_blank">Facebook</a></li>';
	}
	if(!empty($contacto_instagram_url))
	{
		$return_html .= '				<li><img src="'. get_template_directory_uri() .'/images/iconos/instagram.svg" alt="Facebook" width="37px">&nbsp;&nbsp;<a href="'.$contacto_instagram_url.'" alt="'.$contacto_instagram_url.'" target="_blank">Instagram</a></li>';
	}
	//$return_html .= '				<li><img src="'. get_template_directory_uri() .'/images/iconos/celular.svg" alt="Twitter" width="37px">'.$contacto_twitter_url.'</li>';
	//$return_html .= '				<li><img src="'. get_template_directory_uri() .'/images/iconos/celular.svg" alt="Facebook" width="37px">'.$contacto_facebook_url.'</li>';
	$return_html .= '			</ul>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_header', 'ppb_module_header_func');

function ppb_module_indice_anclas_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'anclas' 			=> '',
    ), $atts));

	$return_html = '<div class="indice_anclas ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$order   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	//$anclas = str_replace($order, '', $anclas);
	
	$anclas = str_replace($order, '', html_entity_decode($anclas));
	$anclas = trim($anclas);
	//$anclas = str_replace('<br />', '', $anclas);

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-8">';
	$return_html .= '		<div class="content">';
	$return_html .= '			'.$anclas.'';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	$return_html .= '			';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_indice_anclas', 'ppb_module_indice_anclas_func');

function ppb_module_titular_bajada_c1_c2_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'cuerpo_1' 			=> '',
		'cuerpo_2' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="titular_bajada_c1_c2 ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));
	$bajada = trim(str_replace($scapes, '', html_entity_decode($bajada)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-6">';
	$return_html .= '		<div class="content">';
	
	if(!empty($bajada))
	{
		$return_html .= '			<aside>'.$bajada.'</aside>';
	}
	
	$return_html .= '			<p>'.$cuerpo_1.'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-6">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<p>'.html_entity_decode($cuerpo_2).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_c1_c2', 'ppb_module_titular_bajada_c1_c2_func');

function ppb_module_bajada_c1_bajada_c2_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		'subtitulo' 		=> '',
		'ancla' 			=> '',
		'subtitulo_1' 		=> '',
		'cuerpo_1' 			=> '',
		'subtitulo_2' 		=> '',
		'cuerpo_2' 			=> '',
	
    ), $atts));
	
	$return_html = '<div id="'.$ancla.'" class="subtitulo1_c1_subtitulo2_c2 ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';

	if(!empty($subtitulo))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<h3>'.$subtitulo.'</h3>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-6">';
	$return_html .= '		<div class="content">';
	
	if(!empty($subtitulo_1))
	{
		$return_html .= '			<h3>'.$subtitulo_1.'</h3>';
	}else{
		if(empty($subtitulo))
		{
			$return_html .= '			<h3 class="not-mobile">&nbsp;</h3>';
		}
	}
	
	$return_html .= '			<p>'.html_entity_decode($cuerpo_1).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-6">';
	$return_html .= '		<div class="content">';
	
	if(!empty($subtitulo_2))
	{
		$return_html .= '			<h3>'.$subtitulo_2.'</h3>';
	}else{
		if(empty($subtitulo))
		{
			$return_html .= '			<h3 class="not-mobile">&nbsp;</h3>';
		}
	}
	
	$return_html .= '			<p>'.html_entity_decode($cuerpo_2).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_bajada_c1_bajada_c2', 'ppb_module_bajada_c1_bajada_c2_func');

function ppb_module_nota_destacada_titular_bajada_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
		'ancla' 			=> '',
		'titulo' 			=> '',
		'bajada' 			=> '',
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="module_nota_destacada_titular_bajada ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';

	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<h3>'.html_entity_decode($titulo).'</h3>';
	$return_html .= '			<p>'.html_entity_decode($bajada).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_nota_destacada_titular_bajada', 'ppb_module_nota_destacada_titular_bajada_func');

function ppb_module_titular_bajada_c1_c2_c3_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'subtitulo' 			=> '',
		'bajada' 			=> '',
		'cuerpo_1' 			=> '',
		'cuerpo_2' 			=> '',
		'cuerpo_3' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="module_titular_bajada_c1_c2_c3 ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));
	$cuerpo_3 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_3)));
	
    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '		<div class="content">';
	
	if(!empty($titulo))
	{
		$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
	}
	if(!empty($subtitulo))
	{
		$return_html .= '			<h3>'.$subtitulo.'</h3>';
	}
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	if(!empty($bajada))
	{
		$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
	}
	$return_html .= '			'.html_entity_decode($cuerpo_1).'';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	$return_html .= '			'.html_entity_decode($cuerpo_2).'';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	$return_html .= '			'.html_entity_decode($cuerpo_3).'';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_c1_c2_c3', 'ppb_module_titular_bajada_c1_c2_c3_func');

function ppb_module_titular_bajada_c1_img_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'cuerpo_1' 			=> '',
		'cuerpo_2' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="module_titular_bajada_c1_img ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	if(!empty($bajada))
	{
		$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
	}
	$return_html .= '			<p>'.html_entity_decode($cuerpo_1).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-8">';
	$return_html .= '		<div class="content">';
	$return_html .= '			'.html_entity_decode($cuerpo_2).'';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_c1_img', 'ppb_module_titular_bajada_c1_img_func');

function ppb_module_titular_bajada_full_c1_c2_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'cuerpo_1' 			=> '',
		'cuerpo_2' 			=> '',
		'show_paddin_inferiro' => 'no',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_full_c1_c2 ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
	if($show_paddin_inferiro == 'si')
	{
		$return_html .= ' style="padding: 0 !important;" ';
	}
    $return_html .= '><div class="page_content_wrapper">';
	
	if( !empty($titulo) ||!empty($bajada) )
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if( !empty($titulo) )
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	if( !empty($cuerpo_1) || !empty($cuerpo_2) )
	{
		if( !empty($cuerpo_1) )
		{
			$return_html .= '<div class="row">';
		
			$return_html .= '	<div class="col-md col-md-6">';
			$return_html .= '		<div class="content">';
			
			$find_ul = strpos(html_entity_decode($cuerpo_1), '<ul>');
			if ($find_ul === false) {
				$return_html .= '			<p>'.html_entity_decode($cuerpo_1).'</p>';
			} else {
				$return_html .= '			'.html_entity_decode($cuerpo_1);
			}
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
		
		if( !empty($cuerpo_2) )
		{
			$return_html .= '	<div class="col-md col-md-6">';
			$return_html .= '		<div class="content">';
			
			$find_ul2 = strpos(html_entity_decode($cuerpo_2), '<ul>');
			if ($find_ul2 === false) {
				$return_html .= '			<p>'.html_entity_decode($cuerpo_2).'</p>';
			} else {
				$return_html .= '			'.html_entity_decode($cuerpo_2);
			}
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
		
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_full_c1_c2', 'ppb_module_titular_bajada_full_c1_c2_func');

function ppb_module_titular_bajada_full_c4_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'cuerpo_1' 			=> '',
		'cuerpo_2' 			=> '',
		'cuerpo_3' 			=> '',
		'cuerpo_4' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_full_c4 ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	if(!empty($titulo) || !empty($bajada))
	{
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		if(!empty($titulo))
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	$return_html .= '</div>'; // close row
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-3">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<p>'.html_entity_decode($cuerpo_1).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-3">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<p>'.html_entity_decode($cuerpo_2).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-3">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<p>'.html_entity_decode($cuerpo_3).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-3">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<p>'.html_entity_decode($cuerpo_4).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_full_c4', 'ppb_module_titular_bajada_full_c4_func');


function ppb_module_titular_subtitulo_c1_subtitulo_c2_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'subtitulo_1' 		=> '',
		'cuerpo_1' 			=> '',
		'subtitulo_2' 		=> '',
		'cuerpo_2' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="titular_bajada_c1_bajada_c2 ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		//$return_html .= '			<p>'.html_entity_decode($bajada).'</p>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-6">';
	$return_html .= '		<div class="content">';
	
	if(!empty($subtitulo_1))
	{
		$return_html .= '			<aside>'.html_entity_decode($subtitulo_1).'</aside>';
	}
	
	$return_html .= '			<p>'.html_entity_decode($cuerpo_1).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-6">';
	$return_html .= '		<div class="content">';
	
	if(!empty($subtitulo_2))
	{
		$return_html .= '			<aside>'.html_entity_decode($subtitulo_2).'</aside>';
	}
	
	$return_html .= '			<p>'.html_entity_decode($cuerpo_2).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_subtitulo_c1_subtitulo_c2', 'ppb_module_titular_subtitulo_c1_subtitulo_c2_func');

function ppb_module_titular_cuerpo_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'cuerpo' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="module_titular_bajada_c1_img ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	//$cuerpo = trim(str_replace($scapes, '', html_entity_decode($cuerpo)));
	//$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo) || !empty($bajada))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if(!empty($titulo))
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			if(empty($cuerpo))
			{
				$return_html .= '			<aside style="margin:0;">'.html_entity_decode($bajada).'</aside>';
			}else{
				$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
			}
		}
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	if(!empty($cuerpo))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<p>'.html_entity_decode($cuerpo).'</p>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_cuerpo', 'ppb_module_titular_cuerpo_func');











function ppb_module_header_full_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 				=> '',
		'bajada' 				=> '',
		'contacto_titulo' 		=> '',
		'contacto_telefono' 	=> '',
		'contacto_horario' 		=> '',
		'contacto_direccion' 	=> '',
		'contacto_email' 		=> '',
		'contacto_twitter_url' 	=> '',
		'contacto_facebook_url' => '',
    ), $atts));

	$return_html = '<div class="bilder_modul_full ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$bajada = trim(str_replace($scapes, '', html_entity_decode($bajada)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
	$return_html .= '			<p>'.html_entity_decode($bajada).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_header_full', 'ppb_module_header_full_func');

function ppb_module_subtitle_bajada_search_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'subtitulo' 		=> '',
		'bajada' 			=> '',
		'url_redirect' 		=> '',
    ), $atts));
	
	//wp_enqueue_style("search_form_css", get_template_directory_uri() . "/js/mediaelement/mediaelementplayer.css", false, THEMEVERSION, "all");
    wp_enqueue_script("search_form_js", get_template_directory_uri() . "/js/jquery.validate.js", false, THEMEVERSION);
	wp_enqueue_script("search_form_script_js", get_template_directory_uri() . "/js/search/search_script.js", false, THEMEVERSION);
		
	$return_html = '<div class="ppb_module_subtitle_bajada_search ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$bajada = trim(str_replace($scapes, '', html_entity_decode($bajada)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<h2>'.$subtitulo.'</h2>';
	$return_html .= '			<p>'.html_entity_decode($bajada).'</p>';
		
	$return_html .= '			<form name="form_consultar" id="form_consultar" class="style_form" action="'.$url_redirect.'">';
	$return_html .= '			  <div class="row">';
	$return_html .= '			    <div class="col-md-10">';
	$return_html .= '			      <input type="text" class="form-control" id="consulta" name="seg" tabindex="1" placeholder="consulta" />';
	$return_html .= '			    </div>';
	$return_html .= '			    <div class="col-md-2">';
	$return_html .= '			      <input value="CONSULTAR" class="btn btn-xl" tabindex="2" type="submit">';
	$return_html .= '			    </div>';
	$return_html .= '			  </div>';
	$return_html .= '			</form>';
	
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_subtitle_bajada_search', 'ppb_module_subtitle_bajada_search_func');

function ppb_module_tramites_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'subtitulo' 	=> '',
		
		'seccion_1_icono' 	=> '',
		'seccion_1_text'	=> '',
		'seccion_1_url' 	=> '',
        
		'seccion_2_icono' 	=> '',
		'seccion_2_text'	=> '',
		'seccion_2_url' 	=> '',
		
		'seccion_3_icono' 	=> '',
		'seccion_3_text'	=> '',
		'seccion_3_url' 	=> '',
		
		'seccion_4_icono' 	=> '',
		'seccion_4_text'	=> '',
		'seccion_4_url' 	=> '',
		
		'seccion_5_icono' 	=> '',
		'seccion_5_text'	=> '',
		'seccion_5_url' 	=> '',
		
		'seccion_6_icono' 	=> '',
		'seccion_6_text'	=> '',
		'seccion_6_url' 	=> '',
		
        ), $atts));

	$return_html = '<div class="ppb_module_tramites ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '			<h2>'.$subtitulo.'</h2>';
	$return_html .= '		<div class="content">';
	
	
	if(!empty($seccion_1_text))
	{
		$return_html.= '<a href="'.$seccion_1_url.'" class="bt">';
		$return_html.= '<img src="'.$seccion_1_icono.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_1_text.'</h3>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_2_text))
	{
		$return_html.= '<a href="'.$seccion_2_url.'" class="bt">';
		$return_html.= '<img src="'.$seccion_2_icono.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_2_text.'</h3>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_3_text))
	{
		$return_html.= '<a href="'.$seccion_3_url.'" class="bt">';
		$return_html.= '<img src="'.$seccion_3_icono.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_3_text.'</h3>';
		$return_html.= '</a>';
	}
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '		<div class="content">';
	if(!empty($seccion_4_text))
	{
		$return_html.= '<a href="'.$seccion_4_url.'" class="bt">';
		$return_html.= '<img src="'.$seccion_4_icono.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_4_text.'</h3>';
		$return_html.= '</a>';
	}
	if(!empty($seccion_5_text))
	{
		$return_html.= '<a href="'.$seccion_5_url.'" class="bt">';
		$return_html.= '<img src="'.$seccion_5_icono.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_5_text.'</h3>';
		$return_html.= '</a>';
	}
	
	if(!empty($seccion_6_text))
	{
		$return_html.= '<a href="'.$seccion_6_url.'" class="bt">';
		$return_html.= '<img src="'.$seccion_6_icono.'" class="image"/>';
		$return_html.= '<h3>'.$seccion_6_text.'</h3>';
		$return_html.= '</a>';
	}
	
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul

    return $return_html;
}
add_shortcode('ppb_module_tramites', 'ppb_module_tramites_func');

function ppb_module_blog_titular_nota_3_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		
		'show_items'		=> '3',
		'hubspot_topics' 	=> '',
		
         ), $atts));
	
	$pp_hubspot_api_key = get_option('pp_hubspot_api_key');
	
	$hubspot_topics = str_replace('a','',$hubspot_topics);
	$return_html = '<div class="ppb_content_blog ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html.= '<div class="title">'.html_entity_decode($titulo).'</div>';
	

	/*$url_post = 'https://api.hubapi.com/content/api/v2/blog-posts?state=PUBLISHED&hapikey='.$pp_hubspot_api_key.'&limit=30';  
	$ch = curl_init($url_post);                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	$result = curl_exec($ch);
	
	$return_data = json_decode($result, true);
	$data = $return_data['objects'];*/
	
	# JSON DE HUBSPOT
	$name_file 	= dirname(__FILE__).'/json/data_hubspot_'.$hubspot_topics.'.json';
	$url_post = 'https://api.hubapi.com/content/api/v2/blog-posts?state=PUBLISHED&hapikey='.$pp_hubspot_api_key.'&limit=100';
	
	# Si el archivo no existe lo cre por primera vez
	if(!file_exists($name_file))
	{
		$data = MRG_make_file_hubspot_blog_filter($url_post,$name_file,$hubspot_topics);
		$status = 'Init';
	}
	else
	{
		date_default_timezone_set('UTC');
		date_default_timezone_set("America/Argentina/Ushuaia");
		setlocale(LC_ALL,"es_ES");
		
		$hora 					= getdate();
		$segundos_menos 		= 3600*3; 									// Diferencia horaria (3hs Argentina)
		$segundos_validos 		= 3600*5; 										// Segundos validos para el archivo (1hs)
		$hora_actual 			= gmdate("H:i:s", ($hora[0]-$segundos_menos));	// Formateamos hora de sistema
		$hora_archivo 			= date("H:i:s.", filemtime($name_file));	// Formateamos hora de sistema
		$horas_resta 			= MRG_normalice_fecha($hora_actual)-MRG_normalice_fecha($hora_archivo);
		
		if($horas_resta<=$segundos_validos){
			$data = json_decode(file_get_contents($name_file), true);
			$status = 'On time';
		}
		else
		{
			$data = MRG_make_file_hubspot_blog_filter($url_post,$name_file,$hubspot_topics);
			$status = 'Off time';
		}
	}
	
	
	
	
	/*
	echo $hubspot_topics;
	print_r($data);
	*/
	$elements_to_show = $show_items-1;
	$data_length = count($data)-1;
	
	$return_html.= '<div class="row" data-state="'.$status.'|'.$hubspot_topics.'">';
	$count_search = 0;
	
	for($i=0; $i<=$data_length; $i++)
	{
		if($count_search<=2)
		{
			//if(!empty($data[$i]['tag_ids']['0']) && $data[$i]['tag_ids']['0']==$hubspot_topics)
			if(!empty($data[$i]['tag_ids']['0']) && in_array($hubspot_topics, $data[$i]['tag_ids']))
			{
				$return_html .= '<div class="col-md col-md-4">';
				$return_html .= '	<div class="box-flex">';
				$return_html .= '		<div class="image" style="background-image:url(\''.rawurldecode($data[$i]['featured_image']).'\')">';
				$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_small.gif" alt="image" width="100%">';
				$return_html .= '		</div>';
				$return_html .= '		<div class="content-middle">';
				$return_html .= '			<div class="title">';
				$return_html .= '				<a href="'.$data[$i]['absolute_url'].'"><h3>'.$data[$i]['html_title'].'</h3></a>';
				$return_html .= '			</div>';
				
				if(!empty($data[$i]['tag_ids']['0']))
				{
					$return_html .= '			<div class="category">';
				
					$url_tags_ids = 'https://api.hubapi.com/blogs/v3/topics/'.$data[$i]['tag_ids']['0'].'?hapikey='.$pp_hubspot_api_key;
					$ch2 = curl_init($url_tags_ids);                                                                      
					curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");                                                                     
					curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);                                                                      
					$result_tags_ids = curl_exec($ch2);
					$return_data_tags_ids = json_decode($result_tags_ids, true);
					
					if(is_array($return_data_tags_ids) && !empty($return_data_tags_ids['name']))
					{
						$return_html .= '				<a class="button_categoria_select w-button" href="//info.riogrande.gob.ar/topic/'.$return_data_tags_ids['name'].'">'.$return_data_tags_ids['name'].'</a>';
					}
				
					$return_html .= '			</div>';
				}
				$return_html .= '		</div>';
				$return_html .= '	</div>';
				$return_html .= '</div>'."\r";
				
				$count_search = $count_search+1;
			}
		}
	}
		
	$return_html .= '</div>'; //close row
	
	$return_html .= '<div class="icon_blog">';
	$return_html .= '	<a class="button_blog" href="//info.riogrande.gob.ar/" target="_blank"><img src="'. get_template_directory_uri() .'/images/globa_blog.svg" alt="Blog" width="73"></a>';
	$return_html .= '</div>';
	
	
	$return_html .= '</div>';
    $return_html .= '</div>';
	
    return $return_html;
}
add_shortcode('ppb_module_blog_titular_nota_3', 'ppb_module_blog_titular_nota_3_func');



function ppb_module_titular_bajada_subtitulo_copete_subtitulo_c1_subtitulo_c2_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'subtitulo' 		=> '',
		'copete' 			=> '',
		'subtitulo_1' 		=> '',
		'cuerpo_1' 			=> '',
		'subtitulo_2' 		=> '',
		'cuerpo_2' 			=> '',
		'custom_class' => '',
		
    ), $atts));

	
	if (!empty($custom_class)) {
        $return_html = '<div id="'.$ancla.'" class="titular_bajada_c1_bajada_c2_2 ' . urldecode(esc_attr($custom_class)) . ' ';
    } else {
        $return_html = '<div id="'.$ancla.'" class="titular_bajada_c1_bajada_c2_2 ';
    }
	
    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		//$return_html .= '			<p>'.html_entity_decode($bajada).'</p>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	if(!empty($bajada))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	if(!empty($subtitulo))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<h3>'.$subtitulo.'</h3>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	if(!empty($copete))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		if(empty($titulo))
		{
			$return_html .= '			<p class="fixed">'.html_entity_decode($copete).'</p>';
		}else{
			$return_html .= '			<p>'.html_entity_decode($copete).'</p>';
		}
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '<div class="row">';
	if(!empty($copete) && !empty($subtitulo))
	{
		$return_html .= '	<div class="col-md col-md-6 in-mobile-fix-margin-top-30">';
	}else{
		$return_html .= '	<div class="col-md col-md-6">';
	}
	$return_html .= '		<div class="content">';
	
	if(!empty($subtitulo_1))
	{
		$return_html .= '			<h5>'.html_entity_decode($subtitulo_1).'</h5>';
	}
	/*else
	{
		$return_html .= '			<h5 class="not-mobile">&nbsp;</h5>';
	}*/
	
	$return_html .= '			<p>'.html_entity_decode($cuerpo_1).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-6 in-mobile-fix-margin-top-30">';
	$return_html .= '		<div class="content">';
	
	if(!empty($subtitulo_2))
	{
		$return_html .= '			<h5>'.html_entity_decode($subtitulo_2).'</h5>';
	}
	/*else
	{
		$return_html .= '			<h5 class="not-mobile">&nbsp;</h5>';
	}*/
	
	$return_html .= '			<p>'.html_entity_decode($cuerpo_2).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	$return_html .= '</div>'; // close row
	
	
	
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_subtitulo_copete_subtitulo_c1_subtitulo_c2', 'ppb_module_titular_bajada_subtitulo_copete_subtitulo_c1_subtitulo_c2_func');

function ppb_module_titular_recuadro_1_recuadro_1_grey_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		//'bajada' 			=> '',
		'recuadro_1' 			=> '',
		'recuadro_2' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_recuadro_1_recuadro_1_grey ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$recuadro_1 = trim(str_replace($scapes, '', html_entity_decode($recuadro_1)));
	$recuadro_2 = trim(str_replace($scapes, '', html_entity_decode($recuadro_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '<div class="row">';
	
	if (!empty($recuadro_1)) {
		$return_html .= '	<div class="col-md col-md-6">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="box-inner">';
		$return_html .= '			'.html_entity_decode($recuadro_1);
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	if (!empty($recuadro_2)) {
		$return_html .= '	<div class="col-md col-md-6">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="box-inner">';
		$return_html .= '			'.html_entity_decode($recuadro_2);
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_recuadro_1_recuadro_1_grey', 'ppb_module_titular_recuadro_1_recuadro_1_grey_func');

function ppb_module_titular_bajada_cta_2_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		
		'cta_1_imagen' 		=> '',
		'cta_1_titulo' 		=> '',
		'cta_1_detalle' 	=> '',
		'cta_1_url' 		=> '',
		'cta_1_texto' 		=> '',
		'cta_1_use_cta' 	=> '',
		'cta_1_code' 		=> '',
		
		'cta_2_imagen' 		=> '',
		'cta_2_titulo' 		=> '',
		'cta_2_detalle' 	=> '',
		'cta_2_url' 		=> '',
		'cta_2_texto' 		=> '',
		'cta_2_use_cta' 	=> '',
		'cta_2_code' 		=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_cta_2 ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cta_1_detalle = trim(str_replace($scapes, '', html_entity_decode($cta_1_detalle)));
	$cta_2_detalle = trim(str_replace($scapes, '', html_entity_decode($cta_2_detalle)));
	$bajada = trim(str_replace($scapes, '', html_entity_decode($bajada)));
	

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		if (!empty($bajada)) {
			$return_html .= '			<p>'.html_entity_decode($bajada).'</p>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '<div class="row">';
	
	if(!empty($cta_1_use_cta) && $cta_1_use_cta==3)
	{
		$return_html .= '	<div class="col-md col-md-6">';
		$return_html .= '		<div class="content">';
		$return_html .= '			' . urldecode($cta_1_code);
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	elseif(!empty($cta_1_use_cta) && $cta_1_use_cta==2)
	{
		if (!empty($cta_1_titulo))
		{
			$return_html .= '	<div class="col-md col-md-6">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<div class="box-cta">';
			$return_html .= '				<div class="image" style="background-image:url(' . esc_attr($cta_1_imagen) . '); background-size:cover;"></div>';
			$return_html .= '				<div class="box-content">';
			$return_html .= '					<h3>'.html_entity_decode($cta_1_titulo).'</h3>';
			$return_html .= '					<p>'.html_entity_decode($cta_1_detalle).'</p>';
			$return_html .= '				' . urldecode($cta_1_code);
			$return_html .= '				</div>';
			$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
	}
	elseif(!empty($cta_1_use_cta) && $cta_1_use_cta==1)
	{
		if (!empty($cta_1_titulo))
		{
			$return_html .= '	<div class="col-md col-md-6">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<div class="box-cta">';
			$return_html .= '				<div class="image" style="background-image:url(' . esc_attr($cta_1_imagen) . '); background-size:cover;"></div>';
			$return_html .= '				<div class="box-content">';
			$return_html .= '					<h3>'.html_entity_decode($cta_1_titulo).'</h3>';
			$return_html .= '					<p>'.html_entity_decode($cta_1_detalle).'</p>';
			$return_html .= '					<a href="' . $cta_1_url . '" class="button-cta w-button">'.$cta_1_texto.'</a>';
			$return_html .= '				</div>';
			$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
	}
	else
	{
		$return_html .= '	<div class="col-md col-md-6">';
		$return_html .= '		<div class="content">';
		$return_html .= '			 Falta definir CTA';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	//2
	if(!empty($cta_2_use_cta) && $cta_2_use_cta==3)
	{
		$return_html .= '	<div class="col-md col-md-6">';
		$return_html .= '		<div class="content">';
		$return_html .= '			' . urldecode($cta_2_code);
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	elseif(!empty($cta_2_use_cta) && $cta_2_use_cta==2)
	{
		if (!empty($cta_2_titulo))
		{
			$return_html .= '	<div class="col-md col-md-6">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<div class="box-cta">';
			$return_html .= '				<div class="image" style="background-image:url(' . esc_attr($cta_2_imagen) . '); background-size:cover;"></div>';
			$return_html .= '				<div class="box-content">';
			$return_html .= '					<h3>'.html_entity_decode($cta_2_titulo).'</h3>';
			$return_html .= '					<p>'.html_entity_decode($cta_2_detalle).'</p>';
			$return_html .= '				' . urldecode($cta_2_code);
			$return_html .= '				</div>';
			$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
	}
	elseif(!empty($cta_2_use_cta) && $cta_2_use_cta==1)
	{
		if (!empty($cta_2_titulo))
		{
			$return_html .= '	<div class="col-md col-md-6">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<div class="box-cta">';
			$return_html .= '				<div class="image" style="background-image:url(' . esc_attr($cta_2_imagen) . '); background-size:cover;"></div>';
			$return_html .= '				<div class="box-content">';
			$return_html .= '					<h3>'.html_entity_decode($cta_2_titulo).'</h3>';
			$return_html .= '					<p>'.html_entity_decode($cta_2_detalle).'</p>';
			$return_html .= '					<a href="' . $cta_2_url . '" class="button-cta w-button">'.$cta_2_texto.'</a>';
			$return_html .= '				</div>';
			$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
	}
	else
	{
		$return_html .= '	<div class="col-md col-md-6">';
		$return_html .= '		<div class="content">';
		$return_html .= '			 Falta definir CTA';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	$return_html .= '</div>'; // close row
	
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_cta_2', 'ppb_module_titular_bajada_cta_2_func');

function ppb_header_module_mapa_sube_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'title' => '',
		'titulo' => '',
        'bajada' => '',
		'ancla' => '',
        'codigo_goggle_map' => '',
        'order' => 'default',
                    ), $atts));
	
	//Get Google Map API Key
	$pp_googlemap_api_key = get_option('pp_googlemap_api_key');
	
	wp_enqueue_style("jquery_map_css", get_template_directory_uri()."/js/map/jquery.map.css", false, THEMEVERSION, "all");
	wp_enqueue_script("jquery_map_module_script", get_template_directory_uri()."/js/map/jquery.map.module.php", false, THEMEVERSION, true);
	
	$return_html = '<div id="'.$ancla.'" class="ppb_module_mapa_sube ';

	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$bajada = trim(str_replace($scapes, '', html_entity_decode($bajada)));
	
    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		if (!empty($bajada)) {
			$return_html .= '			<p>'.html_entity_decode($bajada).'</p>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	/*$sube_order = 'ASC';
    $sube_order_by = 'menu_order';
    switch ($order) {
        case 'default':
            $sube_order = 'ASC';
            $sube_order_by = 'menu_order';
            break;

        case 'newest':
            $sube_order = 'DESC';
            $sube_order_by = 'post_date';
            break;

        case 'oldest':
            $ssube_order = 'ASC';
            $sube_order_by = 'post_date';
            break;

        case 'title':
            $sube_order = 'ASC';
            $sube_order_by = 'title';
            break;

        case 'random':
            $sube_order = 'ASC';
            $sube_order_by = 'rand';
            break;
    }

    //Get habitacion items
    $args = array(
        //'numberposts' => $items,
        'order' => $sube_order,
        'orderby' => $sube_order_by,
        'post_type' => array('sube'),
        'suppress_filters' => 0,
    );

    $subes_arr = get_posts($args);
	
    if (!empty($subes_arr) && is_array($subes_arr)) {
		
		foreach ($subes_arr as $key => $sube) {
			
            $image_url = '';
            $sube_ID = $sube->ID;

            if (has_post_thumbnail($sube_ID, 'large')) {
                $image_id = get_post_thumbnail_id($sube_ID);
                $image_url = wp_get_attachment_image_src($image_id, 'full', true);
                $small_image_url = wp_get_attachment_image_src($image_id, 'img_grid_habitaciones', true);
            }
			
            //Get slider Meta
            $sube_permalink_url 	= get_permalink($sube_ID);
            $sube_title 			= $sube->post_title;
			$sube_content			= $sube->post_content;
			$sube_show_button 		= get_post_meta($sube_ID, 'slider_show_button', true);

			if(!empty($sube_title))
			{
				
			}
			/*
			$return_html .= '	<div class="col-md col-md-6">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<div id="mapa" class="mapa"></div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
			$return_html .= '</div>'; // close row
			*/
        /*}

    }*/
	
	$return_html .= '<div class="row">';
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<div id="main_content_google" class="main_content_google"></div>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	$return_html .= '</div>'; // close row
	
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_header_module_mapa_sube', 'ppb_header_module_mapa_sube_func');

function ppb_module_cta_imagen_texto_boton_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		'cta_imagen' 		=> '',
		'cta_titulo' 		=> '',
		'cta_lineas' 		=> '',
		'cta_url' 			=> '',
		'cta_boton_text' 	=> '',
		'cta_use_cta' 		=> '',
		'cta_code' 			=> '',
    ), $atts));

	$return_html = '<div class="ppb_module_cta_imagen_texto_boton ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	//$cta_1_detalle = trim(str_replace($scapes, '', html_entity_decode($cta_1_detalle)));
	//$cta_2_detalle = trim(str_replace($scapes, '', html_entity_decode($cta_2_detalle)));
	//$bajada = trim(str_replace($scapes, '', html_entity_decode($bajada)));
	
    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	$return_html .= '<div class="row">';
	
	
	if(!empty($cta_use_cta) && $cta_use_cta==3)
	{
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="col-md col-md-12">';
		
		if(!empty($cta_code))
		{
			$return_html .= '					' . urldecode($cta_code);
		}
		else
		{
			$return_html .= '					falta codigo CTA de HubSpot!.';
		}
		
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	elseif(!empty($cta_use_cta) && $cta_use_cta==2)
	{
		if (!empty($cta_titulo))
		{
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			
			if($cta_lineas==6){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 382px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 382px;">';
			}elseif($cta_lineas==5){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 338px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 338px;">';
			}elseif($cta_lineas==4){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 288px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 288px;">';
			}elseif($cta_lineas==3){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 250px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 250px;">';
			}elseif($cta_lineas==2){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 202px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 202px;">';
			}elseif($cta_lineas==1){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 158px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 158px;">';
			}else{
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;"></div>';
				$return_html .= '			<div class="box-cta">';
			}
			$return_html .= '					<div class="box-content">';
			
			if($cta_lineas==2 || $cta_lineas==3){
				$return_html .= '						<h3>'.html_entity_decode($cta_titulo).'</h3>';
			}else{
				$return_html .= '						<h3>'.html_entity_decode($cta_titulo).'</h3>';
			}
			
			if(!empty($cta_code))
			{
				$return_html .= '					' . urldecode($cta_code);
			}
			else
			{
				$return_html .= '					falta codigo CTA de HubSpot!';
			}
						
			$return_html .= '					</div>';
			$return_html .= '				</div>';
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
	}
	elseif(!empty($cta_use_cta) && $cta_use_cta==1)
	{
		if (!empty($cta_titulo))
		{
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			
			if($cta_lineas==6){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 382px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 382px;">';
			}elseif($cta_lineas==5){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 338px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 338px;">';
			}elseif($cta_lineas==4){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 288px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 288px;">';
			}elseif($cta_lineas==3){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 250px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 250px;">';
			}elseif($cta_lineas==2){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 202px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 202px;">';
			}elseif($cta_lineas==1){
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;height: 158px;"></div>';
				$return_html .= '			<div class="box-cta" style="height: 158px;">';
			}else{
				$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($cta_imagen) . '); background-size:cover;"></div>';
				$return_html .= '			<div class="box-cta">';
			}
			$return_html .= '					<div class="box-content">';
			
			if($cta_lineas==2 || $cta_lineas==3){
				$return_html .= '					<h3>'.html_entity_decode($cta_titulo).'</h3>';
			}else{
				$return_html .= '					<h3>'.html_entity_decode($cta_titulo).'</h3>';
			}
			
			if(!empty($cta_url))
			{
				$return_html .= '					<a href="' . $cta_url . '" class="button-cta w-button">'.$cta_boton_text.'</a>';
			}
			else
			{
				$return_html .= '					falta url de boton';
			}
			
			$return_html .= '					</div>';
			$return_html .= '				</div>';
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
	}
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_cta_imagen_texto_boton', 'ppb_module_cta_imagen_texto_boton_func');

function ppb_module_titular_bajada_full_c3_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'cuerpo_1' 			=> '',
		'cuerpo_2' 			=> '',
		'cuerpo_3' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_full_c3 ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-12">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
	$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<p>'.html_entity_decode($cuerpo_1).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<p>'.html_entity_decode($cuerpo_2).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	$return_html .= '			<p>'.html_entity_decode($cuerpo_3).'</p>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_full_c3', 'ppb_module_titular_bajada_full_c3_func');

function ppb_module_imagen_torta_bajada_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		'titulo' 			=> '',
		'imagen' 			=> '',
		'bajada' 			=> '',
		'valor' 			=> '',
		'detail' 			=> '',
    ), $atts));
	
	wp_enqueue_style("jquery_donuth_css", get_template_directory_uri()."/js/donuth/donuth.css", false, THEMEVERSION, "all");
	wp_enqueue_script("jquery_donuth_lib_script", get_template_directory_uri()."/js/donuth/jquery.circliful.min.js", false, THEMEVERSION, true);
	wp_enqueue_script("jquery_donuth_module_script", get_template_directory_uri()."/js/donuth/jquery.donuth.module.php", false, THEMEVERSION, true);
	
	$return_html = '<div class="ppb_module_imagen_torta_bajada ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$bajada = trim(str_replace($scapes, '', html_entity_decode($bajada)));
	

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	$return_html .= '<div class="row">';
	
	
	if(!empty($titulo))
	{
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="col-md col-md-12">';
		$return_html .= '				<h3>' . $titulo . '</h3>';
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	if (!empty($imagen) && !empty($valor) && !empty($bajada))
	{
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($imagen) . '); background-size:cover;height: 267px;"></div>';
		$return_html .= '			<div class="box-cta" style="height: 267px;">';
		
		$return_html .= '				<div class="box-content">';
		$return_html .= '					<div class="donuth" valor="'.$valor.'">';
		$return_html .= '						<div id="ss_donuth_chart" class="ss_donuth_chart" valor="'.$valor.'"></div>';
		$return_html .= '						<div class="detail">'.$detail.'</div>';
		$return_html .= '					</div>';
		$return_html .= '					<div class="text">';
		$return_html .= '						<p>'.$bajada.'</p>';
		$return_html .= '					</div>';
		$return_html .= '				</div>';
		$return_html .= '			</div>';
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_imagen_torta_bajada', 'ppb_module_imagen_torta_bajada_func');

function ppb_cta_100_imagen_cuerpo_boton_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'ancla' => '',
		'title' => '',
        'bajada' => '',
        'background' => '',
        'background_parallax' => 'none',
		'cta_url' => '',
		'cta_texto' => '',
		'cta_use_cta' => '',
		'cta_code' => '',
    ), $atts));

    $return_html = '<div class="ppb_cta_100_imagen_cuerpo_boton ';
	
    if (!empty($background_parallax) && $background_parallax != 'none') {
        $return_html .= 'parallax ';
    }
	
    $return_html .= '" ';

    //Get image width and height
    $background = esc_url($background);
    $pp_background_image_id = pp_get_image_id($background);
    $background = esc_url($background);
    if (!empty($pp_background_image_id)) {
        $background_image_arr = wp_get_attachment_image_src($pp_background_image_id, 'original');

        $background_image = $background_image_arr[0];
        $background_image_width = $background_image_arr[1];
        $background_image_height = $background_image_arr[2];
    } else {
        $background_image = $background;
        $background_image_width = '';
        $background_image_height = '';
    }
	
	if (!empty($background))
	{
        //$return_html .= 'style="background-image:url(' . $background_image . ');background-size:cover;" ';
		$return_html .= 'style="background-image: -webkit-linear-gradient(270deg, rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(' . $background_image . '); ';
		$return_html .= 'background-image: linear-gradient(180deg, rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(' . $background_image . '); "';
    }
    $return_html .= '>';
    $return_html .= '<div class="page_content_wrapper fullwidth" style="text-align:center">';
	$return_html .= '<div class="row">';
	
	if(!empty($bajada))
	{
		if(!empty($cta_use_cta) && $cta_use_cta==3)
		{
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<h3>'.html_entity_decode($bajada).'</h3>';
			$return_html .= '			' . urldecode($cta_code);
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
		elseif(!empty($cta_use_cta) && $cta_use_cta==2)
		{
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<h3>'.html_entity_decode($bajada).'</h3>';
			
			if(!empty($cta_use_cta) && $cta_use_cta==1)
			{
				$return_html .= '			' . urldecode($cta_code);
			}
			else
			{
				$return_html .= '			falta url de boton o codigo de HubSpot!';
			}
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
		elseif(!empty($cta_use_cta) && $cta_use_cta==1)
		{	
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<h3>'.html_entity_decode($bajada).'</h3>';
			
			if(!empty($cta_url))
			{
				$return_html .= '			<a href="' . $cta_url . '" class="button-cta w-button">'.$cta_texto.'</a>';
			}
			else
			{
				$return_html .= '			falta url de boton';
			}
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
		else
		{
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<div class="col-md col-md-12">falta configurar el CTA</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
	}
	else
	{
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="col-md col-md-12">Agregue una bajada!</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	$return_html .= '</div>'; // close row
	
	$return_html .= '</div></div>';

    return $return_html;
}
add_shortcode('ppb_cta_100_imagen_cuerpo_boton', 'ppb_cta_100_imagen_cuerpo_boton_func');

function ppb_cta_imagen_cuerpo_boton_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'ancla' => '',
		'title' => '',
        'bajada' => '',
        'background' => '',
        'background_parallax' => 'none',
		'cta_url' => '',
		'cta_texto' => '',
		'cta_use_cta' => '',
		'cta_code' => '',
    ), $atts));

    $return_html = '<div class="ppb_cta_imagen_cuerpo_boton ">';
    $return_html .= '<div class="page_content_wrapper fullwidth ';
	
	 if (!empty($background_parallax) && $background_parallax != 'none') {
        $return_html .= 'parallax ';
    }
	
    $return_html .= '" ';

    $parallax_data = '';

    //Get image width and height
    $background = esc_url($background);
    $pp_background_image_id = pp_get_image_id($background);
    $background = esc_url($background);
    if (!empty($pp_background_image_id)) {
        $background_image_arr = wp_get_attachment_image_src($pp_background_image_id, 'original');

        $background_image = $background_image_arr[0];
        $background_image_width = $background_image_arr[1];
        $background_image_height = $background_image_arr[2];
    } else {
        $background_image = $background;
        $background_image_width = '';
        $background_image_height = '';
    }
	
	$return_html .= 'style="';
	
	if (!empty($background))
	{
		$return_html .= 'background-image: -webkit-linear-gradient(270deg, rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(' . $background_image . '); ';
		$return_html .= 'background-image: linear-gradient(180deg, rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(' . $background_image . '); ';
    }
	
	$return_html .= 'text-align:center"';
	
    $return_html .= '>';
	
	
	$return_html .= '<div class="row">';
	
	if(!empty($bajada))
	{
		if(!empty($cta_use_cta) && $cta_use_cta==3)
		{
					$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<h3>' . $bajada . '</h3>';
			$return_html .= '			' . urldecode($cta_code);
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
		elseif(!empty($cta_use_cta) && $cta_use_cta==2)
		{	
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<h3>' . $bajada . '</h3>';
			
			if(!empty($cta_use_cta) && $cta_use_cta==1)
			{
				$return_html .= '			' . urldecode($cta_code);
			}
			else
			{
				$return_html .= '			falta url de boton o codigo de HubSpot!';
			}
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
		elseif(!empty($cta_use_cta) && $cta_use_cta==1)
		{	
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<h3>' . $bajada . '</h3>';
			
			if(!empty($cta_url))
			{
				$return_html .= '			<a href="' . $cta_url . '" class="button-cta w-button">'.$cta_texto.'</a>';
			}
			else
			{
				$return_html .= '			falta url de boton o codigo de HubSpot!';
			}
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
		else
		{
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<div class="col-md col-md-12">Falta configurar CTA</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
		}
	}
	else
	{
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="col-md col-md-12">Agregue una bajada!</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	$return_html .= '</div>'; // close row
	
	$return_html .= '</div></div>';

    return $return_html;
}
add_shortcode('ppb_cta_imagen_cuerpo_boton', 'ppb_cta_imagen_cuerpo_boton_func');

function ppb_module_grilla_imagen_6_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'bajada' 			=> '',
		'ancla' 			=> '',
		'titulo_1' 			=> '',
		'imagen_1' 			=> '',
		'titulo_2' 			=> '',
		'imagen_2' 			=> '',
		'titulo_3' 			=> '',
		'imagen_3' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_grilla_imagen_6 ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if( !empty($titulo) ||!empty($bajada) )
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if( !empty($titulo) )
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '<div class="row">';
	
	if(!empty($imagen_1))
	{
		$imagen_1 = esc_url($imagen_1);
		$pp_imagen_1_id = pp_get_image_id($imagen_1);
		
		if (!empty($pp_imagen_1_id)) {
			$imagen_1_arr = wp_get_attachment_image_src($pp_imagen_1_id, 'original');
	
			$background_1_image 		= $imagen_1_arr[0];
			$background_1_image_width 	= $imagen_1_arr[1];
			$background_1_image_height 	= $imagen_1_arr[2];
		} else {
			$background_1_image 		= $imagen_1;
			$background_1_image_width 	= '';
			$background_1_image_height 	= '';
		}
	
		$return_html .= '	<div class="col-md col-md-4">';
		$return_html .= '		<div class="content" style="';
		$return_html .= 'background-image: url(' . $imagen_1 . '); ';
		$return_html .= 'background-image: url(' . $imagen_1 . '); ';
		$return_html .= '">';
		
		if(!empty($titulo_1))
		{
			$return_html .= '			<p>'.$titulo_1.'</p>';
		}
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	if(!empty($imagen_2))
	{
		$imagen_2 = esc_url($imagen_2);
		$pp_imagen_2_id = pp_get_image_id($imagen_2);
		
		if (!empty($pp_imagen_2_id)) {
			$imagen_2_arr = wp_get_attachment_image_src($pp_imagen_2_id, 'original');
	
			$background_2_image 		= $imagen_2_arr[0];
			$background_2_image_width 	= $imagen_2_arr[1];
			$background_2_image_height 	= $imagen_2_arr[2];
		} else {
			$background_2_image 		= $imagen_2;
			$background_2_image_width 	= '';
			$background_2_image_height 	= '';
		}
	
		$return_html .= '	<div class="col-md col-md-4">';
		$return_html .= '		<div class="content" style="';
		$return_html .= 'background-image: url(' . $imagen_2 . '); ';
		$return_html .= 'background-image: url(' . $imagen_2 . '); ';
		$return_html .= '">';
		
		if(!empty($titulo_2))
		{
			$return_html .= '			<p>'.$titulo_2.'</p>';
		}
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	if(!empty($imagen_3))
	{
		$imagen_3 = esc_url($imagen_3);
		$pp_imagen_3_id = pp_get_image_id($imagen_3);
		
		if (!empty($pp_imagen_3_id)) {
			$imagen_3_arr = wp_get_attachment_image_src($pp_imagen_3_id, 'original');
	
			$background_3_image 		= $imagen_3_arr[0];
			$background_3_image_width 	= $imagen_3_arr[1];
			$background_3_image_height 	= $imagen_3_arr[2];
		} else {
			$background_3_image 		= $imagen_3;
			$background_3_image_width 	= '';
			$background_3_image_height 	= '';
		}
	
		$return_html .= '	<div class="col-md col-md-4">';
		$return_html .= '		<div class="content" style="';
		$return_html .= 'background-image: url(' . $imagen_3 . '); ';
		$return_html .= 'background-image: url(' . $imagen_3 . '); ';
		$return_html .= '">';
		
		if(!empty($titulo_3))
		{
			$return_html .= '			<p>'.$titulo_3.'</p>';
		}
		
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		
	}
	
	$return_html .= '</div>'; // close row
	
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_grilla_imagen_6', 'ppb_module_grilla_imagen_6_func');

function ppb_module_titular_bajada_full_c3_grey_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'numero_1' 			=> '',
		'cuerpo_1' 			=> '',
		'numero_2' 			=> '',
		'cuerpo_2' 			=> '',
		'numero_3' 			=> '',
		'cuerpo_3' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_full_c3_grey ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo) || !empty($bajada))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if(!empty($titulo))
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '<div class="row">';
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	
	if(!empty($numero_1))
	{
		$return_html .= '			<div class="data"><span>'.html_entity_decode($numero_1).'</span></div>';
	}
	
	$return_html .= '			<div class="data"><p>'.html_entity_decode($cuerpo_1).'</p></div>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	
	if(!empty($numero_2))
	{
		$return_html .= '			<div class="data"><span>'.html_entity_decode($numero_2).'</span></div>';
	}
	
	$return_html .= '			<div class="data"><p>'.html_entity_decode($cuerpo_2).'</p></div>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '	<div class="col-md col-md-4">';
	$return_html .= '		<div class="content">';
	
	if(!empty($numero_3))
	{
		$return_html .= '			<div class="data"><span>'.html_entity_decode($numero_3).'</span></div>';
	}
	
	$return_html .= '			<div class="data"><p>'.html_entity_decode($cuerpo_3).'</p></div>';
	$return_html .= '		</div>';
	$return_html .= '	</div>'."\r";
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_full_c3_grey', 'ppb_module_titular_bajada_full_c3_grey_func');

function ppb_module_titular_bajada_full_c3_titulo_bajada_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'titulo_1' 			=> '',
		'cuerpo_1' 			=> '',
		'titulo_2' 			=> '',
		'cuerpo_2' 			=> '',
		'titulo_3' 			=> '',
		'cuerpo_3' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_full_c3_titulo_bajada ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo) || !empty($bajada))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if(!empty($titulo))
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	if(!empty($titulo_1) || !empty($titulo_2) || !empty($titulo_3))
	{
		$return_html .= '<div class="row">';
		
		$return_html .= '	<div class="col-md col-md-4">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="title">';
		$return_html .= '				'.html_entity_decode($titulo_1);
		$return_html .= '			</div>';
		$return_html .= '			<div class="detail">';
		$return_html .= '				'.html_entity_decode($cuerpo_1);
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		
		$return_html .= '	<div class="col-md col-md-4">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="title">';
		$return_html .= '				'.html_entity_decode($titulo_2);
		$return_html .= '			</div>';
		$return_html .= '			<div class="detail">';
		$return_html .= '				'.html_entity_decode($cuerpo_2);
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		
		$return_html .= '	<div class="col-md col-md-4">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="title">';
		$return_html .= '				'.html_entity_decode($titulo_3);
		$return_html .= '			</div>';
		$return_html .= '			<div class="detail">';
		$return_html .= '				'.html_entity_decode($cuerpo_3);
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_full_c3_titulo_bajada', 'ppb_module_titular_bajada_full_c3_titulo_bajada_func');

function ppb_module_titular_bajada_full_c4_titulo_bajada_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'column_number' 	=> '4',
		'titulo_1' 			=> '',
		'cuerpo_1' 			=> '',
		'titulo_2' 			=> '',
		'cuerpo_2' 			=> '',
		'titulo_3' 			=> '',
		'cuerpo_3' 			=> '',
		'titulo_4' 			=> '',
		'cuerpo_4' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_full_c4_titulo_bajada ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo) || !empty($bajada))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if(!empty($titulo))
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$css_columns = '';
	
	switch($column_number){
		
		case '1':
			$css_columns = 'col-md-12';
		break;
		
		case '2':
			$css_columns = 'col-md-6';
		break;
		
		case '3':
			$css_columns = 'col-md-4';
		break;
		
		case '4':
			$css_columns = 'col-md-3';
		break;
		
		default:
			$css_columns = 'col-md-6';
		break;
	}
	
	$return_html .= '<div class="row">';
	
	for($i=1; $i<=$column_number; $i++){
		
		if(!empty($column_number)){
			
			$return_html .= '	<div class="col-md '.$css_columns.'"">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<div class="title">';
			$return_html .= '				'.html_entity_decode(${'titulo_'.$i});
			$return_html .= '			</div>';
			$return_html .= '			<div class="detail">';
			$return_html .= '				'.html_entity_decode(${'cuerpo_'.$i});
			$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
			
		}
	}

	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_full_c4_titulo_bajada', 'ppb_module_titular_bajada_full_c4_titulo_bajada_func');

function ppb_module_titular_bajada_full_c2_bajada_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'titulo_1' 			=> '',
		'cuerpo_1' 			=> '',
		'titulo_2' 			=> '',
		'cuerpo_2' 			=> '',
		'titulo_3' 			=> '',
		'cuerpo_3' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_full_c3_titulo_bajada ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo) || !empty($bajada))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if(!empty($titulo))
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	if(!empty($titulo_1) || !empty($titulo_2) || !empty($titulo_3))
	{
		$return_html .= '<div class="row">';
		
		$return_html .= '	<div class="col-md col-md-4">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="title">';
		$return_html .= '				'.html_entity_decode($titulo_1);
		$return_html .= '			</div>';
		$return_html .= '			<div class="detail">';
		$return_html .= '				'.html_entity_decode($cuerpo_1);
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		
		$return_html .= '	<div class="col-md col-md-4">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="title">';
		$return_html .= '				'.html_entity_decode($titulo_2);
		$return_html .= '			</div>';
		$return_html .= '			<div class="detail">';
		$return_html .= '				'.html_entity_decode($cuerpo_2);
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		
		$return_html .= '	<div class="col-md col-md-4">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="title">';
		$return_html .= '				'.html_entity_decode($titulo_3);
		$return_html .= '			</div>';
		$return_html .= '			<div class="detail">';
		$return_html .= '				'.html_entity_decode($cuerpo_3);
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_full_c3_titulo_bajada', 'ppb_module_titular_bajada_full_c3_titulo_bajada_func');

function ppb_module_titular_bajada_full_box_image_bajada_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'column_number' 	=> '',
		'imagen_1' 			=> '',
		'cuerpo_1' 			=> '',
		'imagen_2' 			=> '',
		'cuerpo_2' 			=> '',
		'imagen_3' 			=> '',
		'cuerpo_3' 			=> '',
		'imagen_4' 			=> '',
		'cuerpo_4' 			=> '',
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_full_box_image_bajada ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo) || !empty($bajada))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		if(!empty($titulo))
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$css_columns = '';
	
	switch($column_number){
		
		case '1':
			$css_columns = 'col-md-12';
		break;
		
		case '2':
			$css_columns = 'col-md-6';
		break;
		
		case '3':
			$css_columns = 'col-md-4';
		break;
		
		case '4':
			$css_columns = 'col-md-3';
		break;
		
		default:
			$css_columns = 'col-md-6';
		break;
	}
	
	$return_html .= '<div class="row">';
	
	for($i=1; $i<=$column_number; $i++){
		
		if(!empty($column_number)){
			
			$return_html .= '	<div class="col-md '.$css_columns.'">';
			$return_html .= '		<div class="content">';
		
			if(!empty( ${'imagen_'.$i} ))
			{
				${'imagen_'.$i} = esc_url(${'imagen_'.$i});
				/*${'pp_imagen_'.$i.'_id'} = pp_get_image_id(${'imagen_'.$i});
				
				if (!empty(${'pp_imagen_'.$i.'_id'})) {
					${'imagen_'.$i.'_arr'}= wp_get_attachment_image_src(${'pp_imagen_'.$i.'_id'}, 'original');
			
					$background_1_image 		= ${'imagen_'.$i.'_arr'}[0];
					$background_1_image_width 	= ${'imagen_'.$i.'_arr'}[1];
					$background_1_image_height 	= ${'imagen_'.$i.'_arr'}[2];
				} else {
					$background_1_image 		= ${'imagen_'.$i};
					$background_1_image_width 	= '';
					$background_1_image_height 	= '';
				}*/
			
				$return_html .= '			<div class="image" style="background-image: url(' . ${'imagen_'.$i} . '); "></div>';
			}
			
			$return_html .= '			<div class="detail">';
			$return_html .= '				'.html_entity_decode(${'cuerpo_'.$i});
			$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
			
		}
	}

	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_full_box_image_bajada', 'ppb_module_titular_bajada_full_box_image_bajada_func');

function ppb_module_imagen_formulario_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
		'titulo' 			=> '',
		'imagen' 			=> '',
		'cta_code' 			=> '',
		'ancla' 			=> '',
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_imagen_formulario ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	//$scapes   = array("\r\n", "\n", "\r", "<br/>", "<br />");
	//$if_titulo = trim(str_replace($scapes, '', html_entity_decode($if_titulo)));
	
    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	$return_html .= '<div class="row">';
	
	
	if (!empty($imagen))
	{
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr($imagen) . '); background-size:cover;/*height: 765px;*/"></div>';
		$return_html .= '			<div class="box-cta" style="/*height: 765px;*/">';
		$return_html .= '				<div class="box-content">';
		
		if(!empty($titulo))
		{
			$return_html .= '					<h3>'.$titulo.'</h3>';
		}
		else
		{
			$return_html .= '					FALTA: Titulo.';
		}
		
		if(!empty($cta_code))
		{
			$return_html .= '					' . urldecode($cta_code);
		}
		else
		{
			$return_html .= '					FALTA: Codigo del formulario de HubSpot.';
		}
		
		$return_html .= '				</div>';
		$return_html .= '			</div>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}else{
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			FALTA: Imagen';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
	}
	
	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_imagen_formulario', 'ppb_module_imagen_formulario_func');

function ppb_module_peoplesocial_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'column_number' 	=> '3',
		
		'thumbnail_1' 		=> '',
		'nombre_1' 			=> '',
		'facebook_1' 		=> '',
		'twitter_1' 		=> '',
		'linkedin_1' 		=> '',
		'Instagram_1' 		=> '',
		
		'thumbnail_2' 		=> '',
		'nombre_2' 			=> '',
		'facebook_2' 		=> '',
		'twitter_2' 		=> '',
		'linkedin_2' 		=> '',
		'instagram_2' 		=> '',
		
		'thumbnail_3' 		=> '',
		'nombre_3' 			=> '',
		'facebook_3' 		=> '',
		'twitter_3' 		=> '',
		'linkedin_3' 		=> '',
		'instagram_3' 		=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_people_social ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo) || !empty($bajada))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if(!empty($titulo))
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$css_columns = '';
	
	switch($column_number){
		
		case '1':
			$css_columns = 'col-md-12';
		break;
		
		case '2':
			$css_columns = 'col-md-6';
		break;
		
		case '3':
			$css_columns = 'col-md-4';
		break;
		
		case '4':
			$css_columns = 'col-md-3';
		break;
		
		default:
			$css_columns = 'col-md-6';
		break;
	}
	
	$return_html .= '<div class="row">';
	
	for($i=1; $i<=$column_number; $i++){
		
		if(!empty($column_number)){
			
			$return_html .= '	<div class="col-md '.$css_columns.'"">';
			$return_html .= '		<div class="content">';
			
			if(!empty( ${'thumbnail_'.$i} ))
			{
				${'thumbnail_'.$i} = esc_url(${'thumbnail_'.$i});
				//$return_html .= '			<div class="image" style="background-image: url(' . ${'thumbnail_'.$i} . '); "></div>';
				$return_html .= '	<div class="content_image">';
				$return_html .= '		<div class="image" style="background-image:url(\'' . ${'thumbnail_'.$i} . '\')">';
				$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_social.png" alt="image" width="150">';
				$return_html .= '		</div>';
				$return_html .= '	</div>';
			}
			
			/*if(!empty($thumbnail))
			{
				$thumbnail_1 = esc_url($thumbnail);
				$pp_thumbnail_1_id = pp_get_image_id($imagen_1);
				
				if (!empty($pp_thumbnail_1_id)) {
					$thumbnail_1_arr = wp_get_attachment_image_src($pp_thumbnail_1_id, 'original');
					$background_1_image 		= $thumbnail_1_arr[0];
				} else {
					$background_1_image 		= $thumbnail_1;
				}

				//$return_html .= '		<div class="image" style="background-image:url(\''.rawurldecode($data[$i]['featured_image']).'\')">';
				$return_html .= '	<div class="content_image">';
				$return_html .= '		<div class="image" style="background-image:url(\''.rawurldecode($thumbnail).'\')">';
				$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_social.png" alt="image" width="150">';
				$return_html .= '		</div>';
				$return_html .= '	</div>';
				
			}*/
			
			$return_html .= '			<div class="title">';
			$return_html .= '				'.${'nombre_'.$i};
			//$return_html .= '				'.html_entity_decode(${'titulo_'.$i});
			$return_html .= '			</div>';
			
			$return_html .= '			<div class="text-socials">';
            $return_html .= '			    <ul class="list-inline social-buttons">';
			
			if(!empty(${'facebook_'.$i})){
            	$return_html .= '			        <li><a href="'.${'facebook_'.$i}.'" target="_blank"><i class="fa fa-facebook"></i></a></li>';
			}
			
			if(!empty(${'twitter_'.$i})){
				$return_html .= '					<li><a href="'.${'twitter_'.$i}.'" target="_blank"><i class="fa fa-twitter"></i></a></li>';
			}
			
			if(!empty(${'linkedin_'.$i})){
				$return_html .= '			        <li><a href="'.${'linkedin_'.$i}.'" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
			}
			
			if(!empty(${'instagram_'.$i})){
				$return_html .= '					<li><a href="'.${'instagram_'.$i}.'" target="_blank"><i class="fa fa-instagram"></i></a></li>';
			}
			
			$return_html .= '			    </ul>';
            $return_html .= '			</div>';
			
			//$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
			
		}
	}

	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_peoplesocial', 'ppb_module_peoplesocial_func');

function ppb_module_titular_bajada_full_c4_titulo_imagen_bajada_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'titulo' 			=> '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'column_number' 	=> '4',
		'titulo_1' 			=> '',
		'foto_1' 			=> '',
		'cuerpo_1' 			=> '',
		'titulo_2' 			=> '',
		'foto_2' 			=> '',
		'cuerpo_2' 			=> '',
		'titulo_3' 			=> '',
		'foto_3' 			=> '',
		'cuerpo_3' 			=> '',
		'titulo_4' 			=> '',
		'foto_4' 			=> '',
		'cuerpo_4' 			=> '',
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_titular_bajada_full_c4_titulo_imagen_bajada ';

    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
	$scapes   = array("\r\n", "\n", "\r");
	$cuerpo_1 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_1)));
	$cuerpo_2 = trim(str_replace($scapes, '', html_entity_decode($cuerpo_2)));

    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($titulo) || !empty($bajada))
	{
		$return_html .= '<div class="row">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		
		if(!empty($titulo))
		{
			$return_html .= '			<h2>'.html_entity_decode($titulo).'</h2>';
		}
		if(!empty($bajada))
		{
			$return_html .= '			<aside>'.html_entity_decode($bajada).'</aside>';
		}
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$css_columns = '';
	
	switch($column_number){
		
		case '1':
			$css_columns = 'col-md-12';
		break;
		
		case '2':
			$css_columns = 'col-md-6';
		break;
		
		case '3':
			$css_columns = 'col-md-4';
		break;
		
		case '4':
			$css_columns = 'col-md-3';
		break;
		
		default:
			$css_columns = 'col-md-6';
		break;
	}
	
	$return_html .= '<div class="row">';
	
	for($i=1; $i<=$column_number; $i++){
		
		if(!empty($column_number)){
			
			$return_html .= '	<div class="col-md '.$css_columns.'"">';
			$return_html .= '		<div class="content">';
			$return_html .= '			<div class="title">';
			$return_html .= '				'.html_entity_decode(${'titulo_'.$i});
			$return_html .= '			</div>';
			$return_html .= '			<div class="box-image" style="background-image:url(' . esc_attr(${'foto_'.$i}) . '); background-size:cover; background-position:center center;">';
			$return_html .= '			<img src="'. get_template_directory_uri() .'/images/img_bg_small_grid.gif" alt="image" width="100%">';
			$return_html .= '			</div>';
			$return_html .= '			<div class="detail">';
			$return_html .= '				'.html_entity_decode(${'cuerpo_'.$i});
			$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
			
		}
	}

	$return_html .= '</div>'; // close row
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_titular_bajada_full_c4_titulo_imagen_bajada', 'ppb_module_titular_bajada_full_c4_titulo_imagen_bajada_func');

/*-----------------------------------------------------------------------*/
/*---------------------------- WORK AREA { ------------------------------*/
/*-----------------------------------------------------------------------*/

function ppb_module_eventbrite_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        'layout' 			=> 'fixedwidth',
        'eventbrite_token' 	=> '',	
		'titulo' 			=> '',
		'estado_del_evento' => '',
		'ancla' 			=> '',
		'bajada' 			=> '',
		'numero_de_eventos' => '3',
		'column_number' 	=> '3',
		'leer_mas' 			=> get_site_url().'/eventos',
		'leer_mas_string' 	=> 'LEER MÁS',
		'target' 			=> '_blank',
		'seconds_expire' 	=> 3600,
		
    ), $atts));

	$return_html = '<div id="'.$ancla.'" class="ppb_module_eventbrite ';
	
    if (!empty($layout) && $layout == 'fullwidth') {
        $return_html .= 'fullwidth ';
    }
		
    $return_html .= '" ';
    $return_html .= '><div class="page_content_wrapper">';
	
	if(!empty($eventbrite_token))
	{
		
		# Traemos eventos de Eventbrite
		require_once('eventbrite/eventbrite-sdk-php-master/HttpClient.php');
		
		# OBTENEMOS DATOS DEL USUARIO
		$client = new HttpClient($eventbrite_token, $seconds_expire);//OSJHICU36WBCDNXCFW4M//NA323OU6DZOHFY32DXOE
		$client->setTimeUpdate($seconds_expire);
		$user = $client->get('/users/me/');
		
		# OBTENEMOS DIRECCIONES
		$my_venues = $client->get_user_venues($user['id'], $expand=array());
		$venues = $my_venues['venues'];
		
		# OBTENEMOS EVENTOS
		if(!empty($estado_del_evento)){
			$arguments = array('status'=>$estado_del_evento);
		}else{
			$arguments = array('order_by'=>'created_asc');
		}
		$client->setArguments($arguments);
		
		$my_events = $client->get_user_owned_events($user['id'], $expand=array());
		$make_file_status = $client->getStatus();
		
		//print_r($my_events['events']);
			
		if(!empty($titulo) || !empty($bajada))
		{
			$return_html .= '<div class="row">';
			$return_html .= '	<div class="col-md col-md-12">';
			$return_html .= '		<div class="content">';
			
			if(!empty($titulo))
			{
				$return_html .= '			<h2 data-user-id="'.$user['id'].'" data-status="'.$estado_del_evento.'" data-expire="'.$seconds_expire.'" data-file-status="'.$make_file_status.'">'.html_entity_decode($titulo).'</h2>';
			}
			
			$return_html .= '		</div>';
			$return_html .= '	</div>'."\r";
			$return_html .= '</div>'; // close row
		}
		
		$css_columns = '';
		
		switch($column_number){
			
			case '1':
				$css_columns = 'col-md-12';
			break;
			
			case '2':
				$css_columns = 'col-md-6';
			break;
			
			case '3':
				$css_columns = 'col-md-4';
			break;
			
			case '4':
				$css_columns = 'col-md-3';
			break;
			
			default:
				$css_columns = 'col-md-6';
			break;
		}
		
		date_default_timezone_set('UTC');
		date_default_timezone_set("America/Argentina/Ushuaia");
		setlocale(LC_ALL,"es_ES");
		
		//print_r($my_events);
		
		$counter_column = 1;
		$total_row = $numero_de_eventos / $column_number;
		
		$return_html .= '<div class="row">';
		//setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
		setlocale(LC_TIME, 'es_ES.utf8',"es_ES","esp");
		foreach($my_events['events'] as $eventos){
			
			$direccion = MRG_getSegmentOffArrayByIndice($venues,'id',$eventos['venue_id']);
			$direccion_address = $direccion['address']['localized_address_display'];
			$status = $eventos['status'];
			
			if($status == $estado_del_evento)
			{
				if($counter_column<=$numero_de_eventos){
					
					$return_html .= '	<div class="col col-md '.$css_columns.'">';
					$return_html .= '	<a href="'.$eventos['url'].'" target="_blank">';
					$return_html .= '		<div class="content">';
					$return_html .= '			<div class="title">';
					$return_html .= '				<h4>'.str_replace('- Municipio de Rio Grande','',html_entity_decode($eventos['name']['text'])).'</h4>';
					$return_html .= '			</div>';
					$return_html .= '			<div class="image" style="background-image:url(\''.$eventos['logo']['url'].'\')">';
					$return_html .= '				<img src="'. get_template_directory_uri() .'/images/img_bg_small.gif" alt="image" width="100%">';
					$return_html .= '			</div>';
					$return_html .= '			<div class="detail">'; 
					$return_html .= '				<strong>Inicio:</strong> <span class="capitalize">' . strftime("%A %d/%m",strtotime($eventos['start']['local'])) . '</span> ' . date("H:i", strtotime($eventos['start']['local'])) .'<br>';
					$return_html .= '				<strong>Duración:</strong> ' . date("d/m/Y", strtotime($eventos['start']['local'])) . ' a ' . date("d/m/Y", strtotime($eventos['end']['local'])) .'<br>';
					$return_html .= '				<strong>Horario:</strong> ' . date("H:i", strtotime($eventos['start']['local'])) . ' a ' . date("H:i", strtotime($eventos['end']['local'])) .'<br>';
					$return_html .= '				<strong>Cupo:</strong> '.$eventos['capacity']. '<br>';
					$return_html .= '				<strong>Sede:</strong> '.$direccion_address . '<br>';
					$return_html .= '				Más info <span class="orange">aquí</span>';
					$return_html .= '			</div>';
					$return_html .= '		</div>';
					$return_html .= '	</a>'."\r";
					$return_html .= '	</div>'."\r";
					
					if ($counter_column % 3 == 0) {
						$return_html .= '</div>';
						$return_html .= '<div class="row">';
					}
					
					$counter_column = $counter_column + 1;
				}
			}
		}
		
		$return_html .= '</div>'; // close row
		
		$return_html .= '<div class="row read">';
		$return_html .= '	<div class="col-md col-md-12">';
		$return_html .= '		<div class="content">';
		$return_html .= '			<a href="'.$leer_mas.'" class="button" target="'.$target.'">'.$leer_mas_string.'</a>';
		$return_html .= '		</div>';
		$return_html .= '	</div>'."\r";
		$return_html .= '</div>'; // close row
	}
	
	$return_html .= '</div>'; // close page_content_wrapper
    $return_html .= '</div>'; // close bilder_modul
	
    return $return_html;
}
add_shortcode('ppb_module_eventbrite', 'ppb_module_eventbrite_func');


/*-----------------------------------------------------------------------*/
/*---------------------------- } WORK AREA ------------------------------*/
/*-----------------------------------------------------------------------*/


function ppb_social_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        //'size' => 'one',
        'title' => '',
		
		'instagram_user_id' => '',
        'instagram_user_token' => '',
		'instagram_muestra_seguidores' => '',
		
		'linkedin_frace' => '',
        'linkedin_hashtag' => '',
		'linkedin_url' => '',
		
        'custom_css' => '',
        'custom_class' => '',
        'layout' => 'fullwidth',
                    ), $atts));
	
	wp_enqueue_script("script-debug", get_stylesheet_directory_uri() . "/js/social/debug.js", false, THEMEVERSION, true);
	wp_enqueue_style("script-social-css", get_template_directory_uri()."/js/social/social.css", false, THEMEVERSION, "all");			
    wp_enqueue_script("script-social", get_stylesheet_directory_uri() . "/js/social/social.php", false, THEMEVERSION, true);
	
	
	$return_html = '<div class="ppb_social ';
    if (!empty($custom_class)) {
        $return_html .= urldecode(esc_attr($custom_class)) . ' ';
    }
    $columns_class = 'fullwidth';
    if ($layout == 'fullwidth') {
        $columns_class .= ' fullwidth';
    }

    if (empty($content) && empty($title)) {
        $return_html .= 'nopadding ';
    }
    $return_html .= '" ';
    if (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode($custom_css) . '" ';
    }
    $return_html .= '>';

    $return_html .= '<div class="page_content_wrapper ';
    $return_html .= $columns_class;
    $return_html .= '" style="text-align:center">';

    //Display Title
    if (!empty($title)) {
		
		
		$return_html .= '<div class="social_content fifty_percent linkeding" data-parse="">';
		$return_html .= '	<div class="border">';
		$return_html .= '		<div class="icon">';
		$return_html .= '			<i class="fa fa-linkedin-square" aria-hidden="true"></i>';
		$return_html .= '		</div>';
		$return_html .= '		<div class="title">';
		$return_html .= '			<h2>'.$linkedin_frace.'</h2>';
		$return_html .= '			<h4>'.$linkedin_hashtag.'</h4>';
		$return_html .= '		</div>';
		$return_html .= '		<div class="cta_content">';
		$return_html .= '			<a href="'.$linkedin_url.'" target="_blank">';
		$return_html .= '				<div class="cta_button_black">'.__('SHARE', THEMEDOMAIN).'</div>';
		$return_html .= '			</a>';
		$return_html .= '		</div>';
		$return_html .= '	</div>';
		$return_html .= '</div>';
		
		$return_html .= '<div class="social_content fifty_percent instagram">';
		$return_html .= '	<div class="social_bg">';
		$return_html .= '		<div class="icon">';
		$return_html .= '			<i class="fa fa-instagram" aria-hidden="true"></i>';
		$return_html .= '		</div>';
		$return_html .= '		<div class="followers"></div>';
		$return_html .= '		<div class="title">';
		$return_html .= '			<h2>'.__('FOLLOWERS', THEMEDOMAIN).'</h2>';
		$return_html .= '		</div>';
		$return_html .= '		<div class="cta_content"></div>';
		$return_html .= '	</div>';
		$return_html .= '</div>';
    }
    $return_html .= '</div></div>';

    return $return_html;
}
add_shortcode('ppb_social', 'ppb_social_func');

function ppb_modulecontact_func($atts, $content) {

    //extract short code attr
    extract(shortcode_atts(array(
        //'size' => 'one',
        'title' => '',
		
		'contact_disposition' => '',
        'contact_phrase' => '',
		'contact_cta_text' => '',
		'contact_cta_url' => '',
        'contact_image' => '',
		
        'custom_css' => '',
        'custom_class' => '',
        'layout' => 'fullwidth',
                    ), $atts));
	
	$return_html = '<div class="ppb_modulecontact ';
    if (!empty($custom_class)) {
        $return_html .= urldecode(esc_attr($custom_class)) . ' ';
    }
    $columns_class = 'fullwidth';
    if ($layout == 'fullwidth') {
        $columns_class .= ' fullwidth';
    }

    if (empty($content) && empty($title)) {
        $return_html .= 'nopadding ';
    }
    $return_html .= '" ';
    if (!empty($custom_css)) {
        $return_html .= 'style="' . urldecode($custom_css) . '" ';
    }
    $return_html .= '>';

    $return_html .= '<div class="page_content_wrapper ';
    $return_html .= $columns_class;
    $return_html .= '" style="text-align:center">';

    //Display Title
    if (!empty($title)) {
		
		if($contact_disposition=='left')
		{
			$return_html .= '<div class="modulecontact_content fifty_percent right" style="margin: 0 0 0 2%;">';
			$return_html .= '	<div class="modulecontact_bg" style="background-image: url('.$contact_image.');"><img src="'.get_site_url().'/wp-content/themes/mrg/images/contact/contact_dot.gif" alt="" width="100%"></div>';
			$return_html .= '</div>';
			$return_html .= '<div class="modulecontact_content fifty_percent left" style="margin: 0 0 0 0;">';
			$return_html .= '	<div class="border">';
			$return_html .= '		<div class="border-box">';
			$return_html .= '			<div class="title">';
			$return_html .= '				<h2>'.$contact_phrase.'</h2>';
			$return_html .= '				<div class="cta_content">';
			$return_html .= '					<a href="'.$contact_cta_url.'">';
			$return_html .= '						<div class="cta_button_black">'.$contact_cta_text.'</div>';
			$return_html .= '					</a>';
			$return_html .= '				</div>';
			$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>';
			$return_html .= '</div>';
			
		}else{
			$return_html .= '<div class="modulecontact_content fifty_percent left" data-parse="">';
			$return_html .= '	<div class="border">';
			$return_html .= '		<div class="border-box">';
			$return_html .= '			<div class="title">';
			$return_html .= '				<h2>'.$contact_phrase.'</h2>';
			$return_html .= '				<div class="cta_content">';
			$return_html .= '					<a href="'.$contact_cta_url.'">';
			$return_html .= '						<div class="cta_button_black">'.$contact_cta_text.'</div>';
			$return_html .= '					</a>';
			$return_html .= '				</div>';
			$return_html .= '			</div>';
			$return_html .= '		</div>';
			$return_html .= '	</div>';
			$return_html .= '</div>';
			$return_html .= '<div class="modulecontact_content fifty_percent right">';
			$return_html .= '	<div class="modulecontact_bg" style="background-image: url('.$contact_image.');"><img src="'.get_site_url().'/wp-content/themes/mrg/images/contact/contact_dot.gif" alt="" width="100%"></div>';
			$return_html .= '</div>';
		}
    }
    $return_html .= '</div></div>';

    return $return_html;
}
add_shortcode('ppb_modulecontact', 'ppb_modulecontact_func');
/* } THISNEW MRG */


//Check if Layer slider is installed	
$revslider = ABSPATH . '/wp-content/plugins/revslider/revslider.php';

// Check if the file is available to prevent warnings
$pp_revslider_activated = file_exists($revslider);

if ($pp_revslider_activated) {

    function ppb_revslider_func($atts, $content) {

        //extract short code attr
        extract(shortcode_atts(array(
            'size' => 'one',
            'slider_id' => '',
                        ), $atts));

        $return_html = '<div class="' . $size . ' fullwidth">';
        $return_html .= do_shortcode('[rev_slider ' . $slider_id . ']');
        $return_html .= '</div>';

        return $return_html;
    }

    add_shortcode('ppb_revslider', 'ppb_revslider_func');
}
?>