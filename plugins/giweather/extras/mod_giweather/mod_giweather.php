<?php
defined('GIW_JEXEC') or die;

/**
 * @author     Garda Informatica <info@gardainformatica.it>
 * @copyright  Copyright (C) 2015 Garda Informatica. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License version 3
 * @package    giWeather Wordpress Widget
 * @link       http://www.gardainformatica.it
 */

/*

This file is part of "giWeather Wordpress Widget".

"giWeather Wordpress Widget" is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

"giWeather Wordpress Widget" is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with "giWeather Wordpress Widget".  If not, see <http://www.gnu.org/licenses/>.

*/

// Avoid multiple instances of the same module when called by both template and content (using loadposition)
if (isset($GLOBALS["giweather_mid_" . $module->id])) return;
else $GLOBALS["giweather_mid_" . $module->id] = true;


$options=array();

$options['source'] = $params->get('source','owm');
$options['city_name'] = $params->get('city_name','');

$GLOBALS["giwoptions"]=$options;

// Load shared language files for frontend side
require_once(GIW_PLUGIN_PATH . "extras/lib_giweather/language/giweather.inc");

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

//mod_giweather.php
if (empty($GLOBALS["giweather"]["loaded_css"])){
	$GLOBALS["giweather"]["loaded_css"]=true;
	wp_enqueue_style( 'meteocons_font', plugins_url( '/extras/mod_giweather/tmpl/css/meteocons_font/stylesheet.css',GIW_PLUGIN_FILE ),array(), '1.0');
	wp_enqueue_style( 'giweather', plugins_url( '/extras/mod_giweather/tmpl/css/giweather.css',GIW_PLUGIN_FILE ),array('meteocons_font'),GIWEATHER_VERSION );
}

if (empty($GLOBALS["giweather"]["loaded_js"])){
	$GLOBALS["giweather"]["loaded_js"]=true;
	
	wp_enqueue_script('hammer',plugins_url( '/extras/mod_giweather/tmpl/js/hammer.min.js' , GIW_PLUGIN_FILE ), array(), '2.0.4' );
	wp_enqueue_script('giweather',plugins_url( '/extras/mod_giweather/tmpl/js/giweather.js' , GIW_PLUGIN_FILE ),	array( 'jquery','hammer' ),GIWEATHER_VERSION);
	wp_enqueue_script('giweather-starter',plugins_url( '/extras/lib_giweather/js/giweather-starter.js' , GIW_PLUGIN_FILE ),	array( 'giweather' ),GIWEATHER_VERSION);
}


$options = array();
$options['widget_align']=$params->get('widget_align','center');
$options['show_head_details']=intval($params->get("show_head_details", '1'))==1;
$options['show_right_details']=intval($params->get("show_right_details", '1'))==1;
$options['show_forecasts']=intval($params->get("show_forecasts", '1'))==1;
$options['show_forecasts_tempwind']=intval($params->get("show_forecasts_tempwind", '1'))==1;
$options['show_credits']=intval($params->get("show_credits", '0'))==1;
$options['unitofmeasure']=$params->get('unitofmeasure','metric');

$ajax_object=array( 
	'ajax_url' => admin_url( 'admin-ajax.php' ), 
	'widgetid' => "#giweather-module-".$module->id,
	'options' => $options,
	'ajax_fail_msg' => __("Connection error", 'giweather'),
	'number' => $module->number
);

//wp_localize_script('giweather-starter', 'giweather_ajax_object', $ajax_object );//don't work for multi widget!

echo '
<script type="text/javascript">
jQuery( document ).ready(function($) {
	giweather_starter_ajax('.json_encode($ajax_object).');
});
</script>
';



//$jvers=explode('.',JVERSION);
//$jv=array($jvers[0],$jvers[1]);
echo "<!-- mod_giweather " . $GLOBALS["giweather"]["version"] . " wp -->";

require GIW_PLUGIN_PATH . "extras/mod_giweather/tmpl/" . $params->get('layout', 'default').".php";
$icons = gw_load_icons_fonts_path(GIW_PLUGIN_PATH . '/' . "extras".'/'."lib_giweather".'/'."media" ) . '/' . "images" . '/' . "icons";