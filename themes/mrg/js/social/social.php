<?php 
header("content-type: application/x-javascript");
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );
?>
<?php

global $wpdb;
$mid = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->postmeta WHERE post_id = %d AND meta_key = %s", '3093', '1497554472994_data') );
//print_r($mid[0]->meta_value);
if($mid[0]->meta_value)
{
	$colector = json_decode($mid[0]->meta_value);
	//print_r($colector);
	if($colector->shortcode=='ppb_social')
	{
		$instagram_user_id 				= $colector->ppb_social_instagram_user_id;
		$instagram_user_token 			= $colector->ppb_social_instagram_user_token;
		$instagram_muestra_seguidores 	= $colector->ppb_social_instagram_muestra_seguidores;
	}
}

?>

jQuery(document).ready(function() {	
    
    var instagram_user 			= '<?php echo $instagram_user_id; ?>';
    var instagram_access_token 	= '<?php echo $instagram_user_token; ?>';
    
    jQuery(function() {
        jQuery.ajax({
          type: "GET",
          dataType: "jsonp",
          cache: false,
          url: "https://api.instagram.com/v1/users/"+instagram_user+"/?access_token="+instagram_access_token+"",
          success: function(data) {
            <?php if($instagram_muestra_seguidores!=false){ ?>
            jQuery(".followers").append('<h2>'+data.data.counts.follows+'</h2>');
            <?php } ?>
            jQuery(".instagram .cta_content").append('<a href="https://www.instagram.com/' + data.data.username + '/" target="_blank"><div class="cta_button_white"><?php echo __('FOLLOW', THEMEDOMAIN); ?></div></a>');
          }
        });
    });
    
    jQuery(function() {
        jQuery.ajax({
          type: "GET",
          dataType: "jsonp",
          cache: false,
          url: "https://api.instagram.com/v1/users/"+instagram_user+"/media/recent/?access_token="+instagram_access_token+"",
          success: function(data) {
            jQuery('.social_content.instagram').css('background-image', 'url(' + data.data[0].images.standard_resolution.url + ')');
          }
        });
    });
});