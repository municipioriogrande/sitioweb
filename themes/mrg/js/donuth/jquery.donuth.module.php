<?php 
header("content-type: application/x-javascript");
$absolute_path = __FILE__;
$path_to_file = explode( 'wp-content', $absolute_path );
$path_to_wp = $path_to_file[0];
require_once( $path_to_wp.'/wp-load.php' );
?>

jQuery( document ).ready(function() {
    var valor = jQuery("#ss_donuth_chart").attr("valor");
    console.log(valor);
    jQuery("#ss_donuth_chart").circliful({
		foregroundColor: '#ff6a00',
		backgroundColor: '#ffffff',
		fontColor: '#ff6a00',
		animation: 1,
        animationStep: 5,
        foregroundBorderWidth: 18,
        backgroundBorderWidth: 20,
        percent: valor
    });
});