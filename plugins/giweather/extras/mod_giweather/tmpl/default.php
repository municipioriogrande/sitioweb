<?php

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

defined('GIW_JEXEC') or die;



if (!function_exists('giw_hex2rgb')){
	function giw_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   return $rgb; // returns an array with the rgb values
	}
	
}


$bgcolor=$params->get('bgcolor','');

$giw_class="light";

$bgcolor_style='';
if (!empty($bgcolor)){
	$bgcolor_style='background-color: '.$bgcolor.';';
	
	$rgb=giw_hex2rgb($bgcolor);
	if ( (($rgb[0]+$rgb[1]+$rgb[2])/3.0)<180.0){
		$giw_class="dark";
	}
	
}

$giw_class_font='giw-'.$params->get('font_size','medium');

$custom_css=$params->get('custom_css','');
if (!empty($custom_css)){
	echo '<style>'.$custom_css.'</style>';
}

$widget_max_width=intval($params->get('widget_max_width','475')).$params->get('widget_max_width_mu','px');

$widget_align=$params->get('widget_align','center');
$style="";
if ($widget_align=='center'){
	$style="margin: 0 auto;";
}



?>

<noscript><div class="alert"><?php echo esc_html__("GIWEATHER_JAVASCRIPT_REQUIRED", 'giweather'); ?></div></noscript>
<div style="display:none;">giweather wordpress widget</div>
<div id="giweather-module-<?php echo $module->id;?>" class="giweather<?php echo $moduleclass_sfx; echo " ".$giw_class." ".$giw_class_font;?>" style="<?php echo $style;?>max-width:<?php echo $widget_max_width; ?>"><div class="giweather-widget giw-loading"  style="<?php echo $bgcolor_style;?>">	
</div>

