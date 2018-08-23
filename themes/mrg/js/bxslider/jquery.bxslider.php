<?php 
header("content-type: application/x-javascript");
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );
?>

jQuery(document).ready(function(){
    
    jQuery('.bxslider').bxSlider({
    	mode: 'fade',
        auto: true,
        pager:true,
        autoStart:true,
        autoControls: false
    });
    
});