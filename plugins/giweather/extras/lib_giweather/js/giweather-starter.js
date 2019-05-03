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

function giweather_starter_ajax(giweather_ajax_object){
	var giw_data = {
		'action': 'giweather_load_forecast_json',
		'number': giweather_ajax_object.number
	};	
	if (!giweather_ajax_object.options.show_credits){
		jQuery(giweather_ajax_object.widgetid+' > .giw-copyright > a:first').hide();
	}
	
	jQuery.ajax({
		type: "POST",
		url: giweather_ajax_object.ajax_url,
		data: giw_data,
		dataType: "json"})
		.done(function(rdata) {
			if (rdata.messages){
				for (var i=0;i<rdata.messages.length;i++){
					var msg_map=rdata.messages[i];
					var div_alert=jQuery('<div class="error giweather-error"></div>').text(msg_map['msg']);
					jQuery(giweather_ajax_object.widgetid).before(div_alert);
				}
			}

			if (!rdata.html.length)
			{
				return;
			}
			
			jQuery(giweather_ajax_object.widgetid+' > .giweather-widget').removeClass('giw-loading');
			jQuery(giweather_ajax_object.widgetid+' > .giweather-widget').append(rdata.html);
			var giww = new GIWeatherWidget(giweather_ajax_object.widgetid,giweather_ajax_object.options);
		})
		.fail(function() {
			var div_alert=jQuery('<div class="error giweather-error"></div>').text(giweather_ajax_object.ajax_fail_msg);
			jQuery(giweather_ajax_object.widgetid).before(div_alert);
		});			
		

}

