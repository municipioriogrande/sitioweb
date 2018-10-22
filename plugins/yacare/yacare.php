<?php
/*
Plugin Name: Yacaré
Description: Conexión de WordPress con Yacaré para Municipio de Río Grande.
Version: 1.0
Author: Ernesto Carrea
License: GPL2
*/

defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

define( 'YACARE_ABSPATH', plugin_dir_path( __FILE__ ) );
require_once YACARE_ABSPATH . 'classes/class-yacare.php';

add_action( 'init', array( 'Yacare', 'run' ) );

