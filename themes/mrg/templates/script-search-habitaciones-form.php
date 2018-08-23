<?php 
header("content-type: application/x-javascript"); 
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );

//Get contact form ID
$contact_form_id = 'tour_search_form';
$response_id = 'reponse_msg';

if(isset($_GET['form']))
{
	$contact_form_id.= '_'.$_GET['form'];
	$response_id.= '_'.$_GET['form'];
}
?>

jQuery(document).ready(function() {
	jQuery('#<?php echo $contact_form_id; ?>').submit(function() {
		jQuery('#<?php echo $contact_form_id; ?> .error').remove();
		
        var hasError = false;
		
        jQuery('.required_field').each(function() {
			if(jQuery.trim(jQuery(this).val()) == '') {
				var labelText = jQuery(this).prev('label').text();
                jQuery(this).css('border-color','#c9007c');
				/*jQuery('#<?php echo $response_id; ?> ul').append('<li class="error"><?php echo _e( 'Please enter', THEMEDOMAIN ); ?> '+labelText+'</li>');*/
				hasError = true;
			} 
		});
		
        if(!hasError) {
             var form_url_destiny 	= jQuery('#<?php echo $contact_form_id; ?> #urldestiny').val();
            var for_hotel_id 		= jQuery('#<?php echo $contact_form_id; ?> #hotelId').val();
            var for_language_id 	= jQuery('#<?php echo $contact_form_id; ?> #languageid').val();
            var for_date_in 		= jQuery('#<?php echo $contact_form_id; ?> #datein').val();
            var for_date_out 		= jQuery('#<?php echo $contact_form_id; ?> #dateout').val();
            var for_promotioncode 	= jQuery('#<?php echo $contact_form_id; ?> #promotioncode').val();
            var url_request 		= form_url_destiny + '?hotelId=' + for_hotel_id + '&languageid=' + for_language_id + '&dateIn=' + for_date_in + '&dateOut=' + for_date_out + '&promotioncode=' + for_promotioncode + '&';
            window.open(url_request, '_blank');
		}
        
		return false;
		
	});
});