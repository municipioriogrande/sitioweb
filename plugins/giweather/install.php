<?php defined('GIW_INSTALL_JEXEC') or die('Restricted access');

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


add_action('admin_notices', 'giweather_admin_notices');
function giweather_admin_notices() {
	
	$version= get_option('giweather_version');
	if ($version===false){
		//INSTALL
		add_option('giweather_version', GIWEATHER_VERSION);
		
		$obj = new stdClass;
		$obj->event='install';//uninstall/update
		$obj->extension_name='GIWEATHER';
		$obj->results = array(
			'com_giweather'=>array('type'=>'COMPONENT','result'=>'INSTALLED'),//NOT_INSTALLED
			'lib_giweather'=>array('type'=>'LIBRARY','result'=>'INSTALLED'),//NOT_INSTALLED
			'mod_giweather'=>array('type'=>'MODULE','result'=>'INSTALLED'),//NOT_INSTALLED
			'lan_giweather'=>array('type'=>'LANGUAGES','result'=>'INSTALLED'),//NOT_INSTALLED
			//'plg_giweather'=>array('type'=>'PLUGIN','result'=>'INSTALLED'),//NOT_INSTALLED
		);
		giweather_logo($obj);
		
	}else if ($version!=GIWEATHER_VERSION){
		//UPGRADE
		update_option('giweather_version', GIWEATHER_VERSION);

		$obj = new stdClass;
		$obj->event='update';//uninstall/update
		$obj->extension_name='GIWEATHER';
		$obj->results = array(
			'com_giweather'=>array('type'=>'COMPONENT','result'=>'INSTALLED'),//NOT_INSTALLED
			'lib_giweather'=>array('type'=>'LIBRARY','result'=>'INSTALLED'),//NOT_INSTALLED
			'mod_giweather'=>array('type'=>'MODULE','result'=>'INSTALLED'),//NOT_INSTALLED
			'lan_giweather'=>array('type'=>'LANGUAGES','result'=>'INSTALLED'),//NOT_INSTALLED
			//'plg_giweather'=>array('type'=>'PLUGIN','result'=>'INSTALLED'),//NOT_INSTALLED
		);
		giweather_logo($obj);
	}
	
	
	
}

register_deactivation_hook(GIW_INSTALL_PLUGIN_FILE, 'giweather_deactivation');
function giweather_deactivation() {
	delete_option('giweather_version'); 
	$obj = new stdClass;
	$obj->event='uninstall';
	$obj->results = array();
	$obj->extension_name='GIWEATHER';
	giweather_logo($obj);
}


function giweather_logo($obj){
	$a=__('GIWEATHER_COMPONENT','giweather');
	$a=__('GIWEATHER_INSTALLED','giweather');
	$a=__('GIWEATHER_NOT_INSTALLED','giweather');
	$a=__('GIWEATHER_LIBRARY','giweather');
	$a=__('GIWEATHER_MODULE','giweather');
	$a=__('GIWEATHER_LANGUAGES','giweather');
	$a=__('GIWEATHER_PLUGIN','giweather');
	
	
	wp_enqueue_style( 'giweather_install', plugins_url( '/css/install.css',GIW_INSTALL_PLUGIN_FILE ), array(), GIWEATHER_VERSION );
	
	//$this->event=install/uninstall/update.
	
	$src=plugins_url( '/logo/giweather-install-logo.jpg' , GIW_INSTALL_PLUGIN_FILE );
	
	echo(
	'<img ' .
	'class="install_logo" width="128" height="128" ' .
	//'src="http://www.gardainformatica.it/logo/giweather-' . $obj->event . '-logo.jpg" ' .
	'src="'.esc_attr($src).'" ' .
	'alt="giWeather Logo" ' .
	'/>' .
	'<div class="install_container">' .
	'<div class="install_row">' .
	'<h2 class="install_title">giWeather</h2>' .
	'</div>');

	foreach ($obj->results as $name => $extension)
	{
		echo(
		'<div class="install_row">' .
		'<div class="install_' . strtolower($extension["type"]) . ' install_icon">' . esc_html__(strtoupper($obj->extension_name) . "_" . $extension["type"],'giweather') . '</div>' .
		'<div class="install_' . strtolower($extension["result"]) . ' install_icon">' . esc_html__(strtoupper($obj->extension_name) . "_" . $extension["result"],'giweather') . '</div>' .
		'</div>'
		);

	}
	echo('</div>');
}