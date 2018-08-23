/**
 * @author     Garda Informatica <info@gardainformatica.it>
 * @copyright  Copyright (C) 2015 Garda Informatica. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License version 3
 * @package    giWeather Wordpress Widget
 * @link       http://www.gardainformatica.it
 */


function OnGIWAllSourceChange(){
	jQuery('.widget-giweather-start').each(function(){
		jQuery('.giw-bgcolor').wpColorPicker();
		var widget=jQuery(this).parent();
		var source=jQuery('.giw-source',widget);
		var meteoam_id=jQuery('.giw-meteoam_id',widget);
		var owm_appid=jQuery('.giw-owm_appid',widget);
		var owm_id=jQuery('.giw-owm_id',widget);
		var owm_lang=jQuery('.giw-owm_lang',widget);
		
		
		var nws_lat=jQuery('.giw-nws_lat',widget);
		var nws_lon=jQuery('.giw-nws_lon',widget);
		
		if (source.val()=='owm'){
			meteoam_id.closest('p').hide();
			owm_id.closest('p').show();
			owm_appid.closest('p').show();
			owm_lang.closest('p').show();

			nws_lat.closest('p').hide();
			nws_lon.closest('p').hide();
		}else if (source.val()=='meteoam'){
			meteoam_id.closest('p').show();
			owm_id.closest('p').hide();
			owm_appid.closest('p').hide();
			owm_lang.closest('p').hide();

			nws_lat.closest('p').hide();
			nws_lon.closest('p').hide();
		}else if (source.val()=='nws'){
			meteoam_id.closest('p').hide();
			owm_id.closest('p').hide();
			owm_appid.closest('p').hide();
			owm_lang.closest('p').hide();
			
			nws_lat.closest('p').show();
			nws_lon.closest('p').show();
		}
		
	});
}	


jQuery( document ).ready(function($) {
	OnGIWAllSourceChange();
	jQuery(document).ajaxSuccess(function(){
		OnGIWAllSourceChange();
	});
});
