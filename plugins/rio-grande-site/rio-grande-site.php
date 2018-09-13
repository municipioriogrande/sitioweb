<?php 

/*
Plugin Name: Río Grande plugin
Description: Agrega funcionalidad extra para el sitio
*/

//include('form-submissions-check.php');

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}


include "centros-salud.php";

?>