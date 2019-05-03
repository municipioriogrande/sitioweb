<?php defined('GIW_JEXEC') or die('Restricted access');

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

class ModgiWeatherHelper
{



	public $icon2gk4=array (
	  'other' => array('other','other'),
	  'clear' => array('sunny','sunny_night'),
	  'mist'=> array('foggy','foggy_night'),
	  'covered' => array('cloudy','cloudy'),
	  'covered_snow' => array('snow','snow'),
	  'covered_rain' => array('rain','rain'),
	  'covered_mist' => array('foggy','foggy_night'),
	  'covered_thunder' => array('thunderstorm','thunderstorm'),
	  'partlycloudy' => array('partly_cloudy','partly_cloudy_night'),
	  'partlycloudy_snow' => array('chance_of_snow','chance_of_snow_night'),
	  'partlycloudy_rain' => array('chance_of_rain','chance_of_rain_night'),
	  'partlycloudy_mist' => array('mist','mist_night'),
	  'partlycloudy_thunder' => array('chance_of_storm','chance_of_storm_night'),
	  'cloudy' => array('mostly_cloudy','mostly_cloudy_night'),
	  'cloudy_snow' => array('chance_of_snow','chance_of_snow_night'),
	  'cloudy_rain' => array('showers','showers_night'),
	  'cloudy_mist' => array('foggy','foggy_night'),
	  'cloudy_thunder' => array('chance_of_storm','chance_of_storm_night'),
	  'mostlycloudy' => array('mostly_cloudy','mostly_cloudy_night'),
	  'mostlycloudy_snow' => array('snow','snow'),
	  'mostlycloudy_rain' =>  array('rain','rain'),
	  'mostlycloudy_mist' => array('foggy','foggy_night'),
	  'mostlycloudy_thunder' => array('thunderstorm','thunderstorm'),
	);

	public $icon2forecastfont=array (
	  'other' => array('giw-icon-cloud','giw-icon-cloud'),
	  'clear' => array('giw-icon-sun','giw-icon-moon'),
	  'mist'=> array('giw-icon-mist','giw-icon-mist'),
	  'covered' => array('giw-icon-cloud','giw-icon-cloud'),
	  'covered_snow' => array('giw-basecloud+giw-icon-snowy','giw-basecloud+giw-icon-snowy'),
	  'covered_rain' => array('giw-basecloud+giw-icon-rainy','giw-basecloud+giw-icon-rainy'),
	  'covered_mist' => array('giw-icon-mist','giw-icon-mist'),
	  'covered_thunder' => array('giw-basethundercloud+giw-icon-thunder','giw-basethundercloud+giw-icon-thunder'),
	  
	  'partlycloudy' => array('giw-basecloudy+giw-icon-sunny','giw-basecloudy+giw-icon-night'),
	  'partlycloudy_snow' => array('giw-basecloud+giw-icon-snowy giw-icon-sunny','giw-basecloud+giw-icon-snowy giw-icon-night'),
	  'partlycloudy_rain' => array('giw-basecloud+giw-icon-rainy giw-icon-sunny','giw-basecloud+giw-icon-rainy giw-icon-night'),
	  'partlycloudy_mist' => array('giw-icon-mist','giw-icon-mist'),
	  'partlycloudy_thunder' => array('giw-basethundercloud+giw-icon-thunder giw-icon-sunny','giw-basethundercloud+giw-icon-thunder giw-icon-night'),

	  'cloudy' => array('giw-basecloudy+giw-icon-sunny','giw-basecloudy+giw-icon-night'),
	  'cloudy_snow' => array('giw-basecloud+giw-icon-snowy giw-icon-sunny','giw-basecloud+giw-icon-snowy giw-icon-night'),
	  'cloudy_rain' => array('giw-basecloud+giw-icon-rainy giw-icon-sunny','giw-basecloud+giw-icon-rainy giw-icon-night'),
	  'cloudy_mist' => array('giw-icon-mist','giw-icon-mist'),
	  'cloudy_thunder' => array('giw-basethundercloud+giw-icon-thunder giw-icon-sunny','giw-basethundercloud+giw-icon-thunder giw-icon-night'),

	  'mostlycloudy' => array('giw-icon-cloud','giw-icon-cloud'),
	  'mostlycloudy_snow' => array('giw-basecloud+giw-icon-snowy','giw-basecloud+giw-icon-snowy'),
	  'mostlycloudy_rain' => array('giw-basecloud+giw-icon-rainy','giw-basecloud+giw-icon-rainy'),
	  'mostlycloudy_mist' => array('giw-icon-mist','giw-icon-mist'),
	  'mostlycloudy_thunder' => array('giw-basethundercloud+giw-icon-thunder','giw-basethundercloud+giw-icon-thunder'),

	);
	public $icon2owm=array (
	  'other' => '03',
	  'clear' => '01',
	  'partlycloudy' => '02',
	  'mostlycloudy' => '03',
	  'covered' => '04',
	  'covered_rain' => '09',
	  'partlycloudy_rain' => '10',
	  'covered_thunder' => '11',
	  'covered_snow' => '13',
	  'mist' => '50',
	  
	  'covered_mist' => '50',
	  'cloudy_mist' => '50',
	  'mostlycloudy_mist' => '50',
	  'partlycloudy_mist' => '50',

	  'cloudy' => '03',

	  'cloudy_rain' => '10',
	  'mostlycloudy_rain' => '09',

	  'partlycloudy_snow' => '13',
	  'cloudy_snow' => '13',
	  'mostlycloudy_snow' => '13',

	  'partlycloudy_thunder' => '11',
	  'mostlycloudy_thunder' => '11',
	  'cloudy_thunder' => '11',

	  
	);

	public $icon2meteoam=array (
	  'other' => 'coperto',
	  'clear' => 'sereno',
	  'mist'=> 'coperto_foschia',
	  'covered' => 'coperto',
	  'covered_snow' => 'coperto_neve',
	  'covered_rain' => 'coperto_pioggia',
	  'covered_mist' => 'coperto_foschia',
	  'covered_thunder' => 'coperto_temporale',
	  'partlycloudy' => 'poco_nuvoloso',
	  'partlycloudy_snow' => 'poco_nuvoloso_neve',
	  'partlycloudy_rain' => 'poco_nuvoloso_pioggia',
	  'partlycloudy_mist' => 'poco_nuvoloso_foschia',
	  'partlycloudy_thunder' => 'poco_nuvoloso_temporale',
	  'cloudy' => 'nuvoloso',
	  'cloudy_snow' => 'nuvoloso_neve',
	  'cloudy_rain' => 'nuvoloso_pioggia',
	  'cloudy_mist' => 'nuvoloso_foschia',
	  'cloudy_thunder' => 'nuvoloso_temporale',
	  'mostlycloudy' => 'molto_nuvoloso',
	  'mostlycloudy_snow' => 'molto_nuvoloso_neve',
	  'mostlycloudy_rain' => 'molto_nuvoloso_pioggia',
	  'mostlycloudy_mist' => 'molto_nuvoloso_foschia',
	  //'mostlycloudy_thunder' => 'molto_nuvoloso_temporale',
	  'mostlycloudy_thunder' => 'nuvoloso_temporale',
	);

	public $icon2yahoo=array (
	  'other' => '44',
	  'clear' => '32',
	  'mist'=> '21',//20 white 
	  'covered' => '26',
	  'covered_snow' => '41',
	  'covered_rain' => '40',
	  'covered_mist' => '21',
	  'covered_thunder' => '35',
	  'partlycloudy' => '34',
	  'partlycloudy_snow' => '14',
	  'partlycloudy_rain' => '39',
	  'partlycloudy_mist' => '21',
	  'partlycloudy_thunder' => '37',
	  'cloudy' => '28',
	  'cloudy_snow' => '14',
	  'cloudy_rain' => '39',
	  'cloudy_mist' => '21',
	  'cloudy_thunder' => '37',
	  'mostlycloudy' => '26',
	  'mostlycloudy_snow' => '41',
	  'mostlycloudy_rain' => '40',
	  'mostlycloudy_mist' => '21',
	  'mostlycloudy_thunder' => '35',
	);


	public $icon2google=array (
	  'other' => 'partly_cloudy',
	  'clear' => 'sunny',
	  'mist'=> 'fog',
	  'covered' => 'cloudy',
	  'covered_snow' => 'snow_s_cloudy',
	  'covered_rain' => 'rain_s_cloudy',
	  'covered_mist' => 'fog',
	  'covered_thunder' => 'rain_s_cloudy',
	  'partlycloudy' => 'partly_cloudy',
	  'partlycloudy_snow' => 'snow',
	  'partlycloudy_rain' => 'rain',
	  'partlycloudy_mist' => 'fog',
	  'partlycloudy_thunder' => 'rain',
	  'cloudy' => 'cloudy',
	  'cloudy_snow' => 'snow',
	  'cloudy_rain' => 'rain',
	  'cloudy_mist' => 'fog',
	  'cloudy_thunder' => 'rain',
	  'mostlycloudy' => 'cloudy',
	  'mostlycloudy_snow' => 'snow_s_cloudy',
	  'mostlycloudy_rain' => 'rain_s_cloudy',
	  'mostlycloudy_mist' => 'fog',
	  'mostlycloudy_thunder' => 'rain_s_cloudy',
	);
	
	public $owm2icon=array(
		'01'=>'clear',
		'02'=>'partlycloudy',
		'03'=>'mostlycloudy',
		'04'=>'covered',
		'09'=>'covered_rain',
		'10'=>'partlycloudy_rain',
		'11'=>'covered_thunder',
		'13'=>'covered_snow',
		'50'=>'mist',
	);

	public $meteoam2icon=array(
		"sereno"=>'clear',
		"coperto"=>'covered',
		"coperto_neve"=>'covered_snow',
		"coperto_pioggia"=>'covered_rain',
		"coperto_foschia"=>'covered_mist',
		"coperto_temporale"=>'covered_thunder',
		"poco_nuvoloso"=>'partlycloudy',
		"poco_nuvoloso_neve"=>'partlycloudy_snow',
		"poco_nuvoloso_pioggia"=>'partlycloudy_rain',
		"poco_nuvoloso_foschia"=>'partlycloudy_mist',
		"poco_nuvoloso_temporale"=>'partlycloudy_thunder',
		"nuvoloso"=>'cloudy',
		"nuvoloso_neve"=>'cloudy_snow',
		"nuvoloso_pioggia"=>'cloudy_rain',
		"nuvoloso_foschia"=>'cloudy_mist',
		"nuvoloso_temporale"=>'cloudy_thunder',
		"molto_nuvoloso"=>'mostlycloudy',
		"molto_nuvoloso_neve"=>'mostlycloudy_snow',
		"molto_nuvoloso_pioggia"=>'mostlycloudy_rain',
		"molto_nuvoloso_foschia"=>'mostlycloudy_mist',
		"molto_nuvoloso_temporale"=>'mostlycloudy_thunder',

		
	);
	

	public $nws2icon = array(
		"skc" => array("clear", "day"),
		"nskc" => array("clear", "night"),
		"few" => array("partlycloudy", "day"),
		"nfew" => array("partlycloudy", "night"),
		"sct" => array("cloudy", "day"),
		"nsct" => array("cloudy", "night"),
		"bkn" => array("mostlycloudy", "day"),
		"nbkn" => array("mostlycloudy", "night"),
		"ovc" => array("covered", "day"),
		"novc" => array("covered", "night"),
		"sn" => array("covered_snow", "day"),
		"nsn" => array("covered_snow", "night"),
		"ra_sn" => array("partlycloudy_snow", "day"),
		"nra_sn" => array("partlycloudy_snow", "night"),
		"raip" => array("covered_rain", "day"),
		"nraip" => array("covered_rain", "night"),
		"fzra" => array("covered_rain", "day"),
		"nfzra" => array("covered_rain", "night"),
		"ra_fzra" => array("covered_rain", "day"),
		"nra_fzra" => array("covered_rain", "night"),
		"fzra_sn" => array("covered_snow", "day"),
		"nfzra_sn" => array("covered_snow", "night"),
		"ip" => array("covered_rain", "day"),
		"nip" => array("covered_rain", "night"),
		"snip" => array("covered_rain", "day"),
		"nsnip" => array("covered_rain", "night"),
		"minus_ra" => array("partlycloudy_rain", "day"),
		"nra" => array("cloudy_rain", "night"),
		"ra" => array("cloudy_rain", "day"),
		"shra" => array("covered_rain", "day"),
		"nshra" => array("covered_rain", "night"),
		"hi_shwrs" => array("cloudy_rain", "day"),
		"hi_nshwrs" => array("cloudy_rain", "night"),
		"tsra" => array("covered_thunder", "day"),
		"ntsra" => array("covered_thunder", "night"),
		"scttsra" => array("mostlycloudy_thunder", "day"),
		"nscttsra" => array("mostlycloudy_thunder", "night"),
		"hi_tsra" => array("cloudy_thunder", "day"),
		"hi_ntsra" => array("cloudy_thunder", "night"),
		"fc" => array("covered_thunder", "day"),
		"nfc" => array("covered_thunder", "night"),
		"tor" => array("other", "day"),
		"ntor" => array("other", "night"),
		"hur_warn" => array("other", "day"),
		"null" => array("clear", "night"),
		"hur_watch" => array("other", "day"),
		"ts_warn" => array("other", "day"),
		"ts_watch" => array("other", "day"),
		"ts_nowarn" => array("other", "day"),
		"wind_skc" => array("clear", "day"),
		"nwind_skc" => array("clear", "night"),
		"wind_few" => array("partlycloudy", "day"),
		"nwind_few" => array("partlycloudy", "night"),
		"wind_sct" => array("cloudy", "day"),
		"nwind_sct" => array("cloudy", "night"),
		"wind_bkn" => array("mostlycloudy", "day"),
		"nwind_bkn" => array("mostlycloudy", "night"),
		"wind_ovc" => array("covered", "day"),
		"nwind_ovc" => array("covered", "night"),
		"du" => array("mist", "day"),
		"ndu" => array("mist", "night"),
		"fu" => array("mist", "day"),
		"nfu" => array("mist", "night"),
		"hz" => array("mist", "day"),
		"hot" => array("clear", "day"),
		"cold" => array("clear", "day"),
		"ncold" => array("clear", "night"),
		"blizzard" => array("covered_snow", "day"),
		"nblizzard" => array("covered_snow", "night"),
		"fg" => array("mist", "day"),
		"nfg" => array("mist", "night")
	);


	public $nws2desc = array(
		"skc" => array("Fair", "Clear", "Fair with Haze", "Clear with Haze", "Fair and Breezy", "Clear and Breezy"),
		"nskc" => array("Fair", "Clear", "Fair with Haze", "Clear with Haze", "Fair and Breezy", "Clear and Breezy"),
		"few" => array("A Few Clouds", "A Few Clouds with Haze", "A Few Clouds and Breezy"),
		"nfew" => array("A Few Clouds", "A Few Clouds with Haze", "A Few Clouds and Breezy"),
		"sct" => array("Partly Cloudy", "Partly Cloudy with Haze", "Partly Cloudy and Breezy"),
		"nsct" => array("Partly Cloudy", "Partly Cloudy with Haze", "Partly Cloudy and Breezy"),
		"bkn" => array("Mostly Cloudy", "Mostly Cloudy with Haze", "Mostly Cloudy and Breezy"),
		"nbkn" => array("Mostly Cloudy", "Mostly Cloudy with Haze", "Mostly Cloudy and Breezy"),
		"ovc" => array("Overcast", "Overcast with Haze", "Overcast and Breezy"),
		"novc" => array("Overcast", "Overcast with Haze", "Overcast and Breezy"),
		"sn" => array("Snow", "Light Snow", "Heavy Snow", "Snow Showers", "Light Snow Showers", "Heavy Snow Showers", "Showers Snow", "Light Showers Snow", "Heavy Showers Snow", "Snow Fog/Mist", "Light Snow Fog/Mist", "Heavy Snow Fog/Mist", "Snow Showers Fog/Mist", "Light Snow Showers Fog/Mist", "Heavy Snow Showers Fog/Mist", "Showers Snow Fog/Mist", "Light Showers Snow Fog/Mist", "Heavy Showers Snow Fog/Mist", "Snow Fog", "Light Snow Fog", "Heavy Snow Fog", "Snow Showers Fog", "Light Snow Showers Fog", "Heavy Snow Showers Fog", "Showers in Vicinity Snow", "Snow Showers in Vicinity", "Snow Showers in Vicinity Fog/Mist", "Snow Showers in Vicinity Fog", "Low Drifting Snow", "Blowing Snow", "Snow Low Drifting Snow", "Snow Blowing Snow", "Light Snow Low Drifting Snow", "Light Snow Blowing Snow", "Light Snow Blowing Snow Fog/Mist", "Heavy Snow Low Drifting Snow", "Heavy Snow Blowing Snow", "Thunderstorm Snow", "Light Thunderstorm Snow", "Heavy Thunderstorm Snow", "Snow Grains", "Light Snow Grains", "Heavy Snow Grains", "Heavy Blowing Snow", "Blowing Snow in Vicinity"),
		"nsn" => array("Snow", "Light Snow", "Heavy Snow", "Snow Showers", "Light Snow Showers", "Heavy Snow Showers", "Showers Snow", "Light Showers Snow", "Heavy Showers Snow", "Snow Fog/Mist", "Light Snow Fog/Mist", "Heavy Snow Fog/Mist", "Snow Showers Fog/Mist", "Light Snow Showers Fog/Mist", "Heavy Snow Showers Fog/Mist", "Showers Snow Fog/Mist", "Light Showers Snow Fog/Mist", "Heavy Showers Snow Fog/Mist", "Snow Fog", "Light Snow Fog", "Heavy Snow Fog", "Snow Showers Fog", "Light Snow Showers Fog", "Heavy Snow Showers Fog", "Showers in Vicinity Snow", "Snow Showers in Vicinity", "Snow Showers in Vicinity Fog/Mist", "Snow Showers in Vicinity Fog", "Low Drifting Snow", "Blowing Snow", "Snow Low Drifting Snow", "Snow Blowing Snow", "Light Snow Low Drifting Snow", "Light Snow Blowing Snow", "Light Snow Blowing Snow Fog/Mist", "Heavy Snow Low Drifting Snow", "Heavy Snow Blowing Snow", "Thunderstorm Snow", "Light Thunderstorm Snow", "Heavy Thunderstorm Snow", "Snow Grains", "Light Snow Grains", "Heavy Snow Grains", "Heavy Blowing Snow", "Blowing Snow in Vicinity"),
		"ra_sn" => array("Rain Snow", "Light Rain Snow", "Heavy Rain Snow", "Snow Rain", "Light Snow Rain", "Heavy Snow Rain", "Drizzle Snow", "Light Drizzle Snow", "Heavy Drizzle Snow", "Snow Drizzle", "Light Snow Drizzle", "Heavy Drizzle Snow"),
		"nra_sn" => array("Rain Snow", "Light Rain Snow", "Heavy Rain Snow", "Snow Rain", "Light Snow Rain", "Heavy Snow Rain", "Drizzle Snow", "Light Drizzle Snow", "Heavy Drizzle Snow", "Snow Drizzle", "Light Snow Drizzle", "Heavy Drizzle Snow"),
		"raip" => array("Rain Ice Pellets", "Light Rain Ice Pellets", "Heavy Rain Ice Pellets", "Drizzle Ice Pellets", "Light Drizzle Ice Pellets", "Heavy Drizzle Ice Pellets", "Ice Pellets Rain", "Light Ice Pellets Rain", "Heavy Ice Pellets Rain", "Ice Pellets Drizzle", "Light Ice Pellets Drizzle", "Heavy Ice Pellets Drizzle"),
		"nraip" => array("Rain Ice Pellets", "Light Rain Ice Pellets", "Heavy Rain Ice Pellets", "Drizzle Ice Pellets", "Light Drizzle Ice Pellets", "Heavy Drizzle Ice Pellets", "Ice Pellets Rain", "Light Ice Pellets Rain", "Heavy Ice Pellets Rain", "Ice Pellets Drizzle", "Light Ice Pellets Drizzle", "Heavy Ice Pellets Drizzle"),
		"fzra" => array("Freezing Rain", "Freezing Drizzle", "Light Freezing Rain", "Light Freezing Drizzle", "Heavy Freezing Rain", "Heavy Freezing Drizzle", "Freezing Rain in Vicinity", "Freezing Drizzle in Vicinity"),
		"nfzra" => array("Freezing Rain", "Freezing Drizzle", "Light Freezing Rain", "Light Freezing Drizzle", "Heavy Freezing Rain", "Heavy Freezing Drizzle", "Freezing Rain in Vicinity", "Freezing Drizzle in Vicinity"),
		"ra_fzra" => array("Freezing Rain Rain", "Light Freezing Rain Rain", "Heavy Freezing Rain Rain", "Rain Freezing Rain", "Light Rain Freezing Rain", "Heavy Rain Freezing Rain", "Freezing Drizzle Rain", "Light Freezing Drizzle Rain", "Heavy Freezing Drizzle Rain", "Rain Freezing Drizzle", "Light Rain Freezing Drizzle", "Heavy Rain Freezing Drizzle"),
		"nra_fzra" => array("Freezing Rain Rain", "Light Freezing Rain Rain", "Heavy Freezing Rain Rain", "Rain Freezing Rain", "Light Rain Freezing Rain", "Heavy Rain Freezing Rain", "Freezing Drizzle Rain", "Light Freezing Drizzle Rain", "Heavy Freezing Drizzle Rain", "Rain Freezing Drizzle", "Light Rain Freezing Drizzle", "Heavy Rain Freezing Drizzle"),
		"fzra_sn" => array("Freezing Rain Snow", "Light Freezing Rain Snow", "Heavy Freezing Rain Snow", "Freezing Drizzle Snow", "Light Freezing Drizzle Snow", "Heavy Freezing Drizzle Snow", "Snow Freezing Rain", "Light Snow Freezing Rain", "Heavy Snow Freezing Rain", "Snow Freezing Drizzle", "Light Snow Freezing Drizzle", "Heavy Snow Freezing Drizzle"),
		"nfzra_sn" => array("Freezing Rain Snow", "Light Freezing Rain Snow", "Heavy Freezing Rain Snow", "Freezing Drizzle Snow", "Light Freezing Drizzle Snow", "Heavy Freezing Drizzle Snow", "Snow Freezing Rain", "Light Snow Freezing Rain", "Heavy Snow Freezing Rain", "Snow Freezing Drizzle", "Light Snow Freezing Drizzle", "Heavy Snow Freezing Drizzle"),
		"ip" => array("Ice Pellets", "Light Ice Pellets", "Heavy Ice Pellets", "Ice Pellets in Vicinity", "Showers Ice Pellets", "Thunderstorm Ice Pellets", "Ice Crystals", "Hail", "Small Hail/Snow Pellets", "Light Small Hail/Snow Pellets", "Heavy small Hail/Snow Pellets", "Showers Hail", "Hail Showers"),
		"nip" => array("Ice Pellets", "Light Ice Pellets", "Heavy Ice Pellets", "Ice Pellets in Vicinity", "Showers Ice Pellets", "Thunderstorm Ice Pellets", "Ice Crystals", "Hail", "Small Hail/Snow Pellets", "Light Small Hail/Snow Pellets", "Heavy small Hail/Snow Pellets", "Showers Hail", "Hail Showers"),
		"snip" => array("Snow Ice Pellets"),
		"nsnip" => array("Snow Ice Pellets"),
		"minus_ra" => array("Light Rain", "Drizzle", "Light Drizzle", "Heavy Drizzle", "Light Rain Fog/Mist", "Drizzle Fog/Mist", "Light Drizzle Fog/Mist", "Heavy Drizzle Fog/Mist", "Light Rain Fog", "Drizzle Fog", "Light Drizzle Fog", "Heavy Drizzle Fog"),
		"nra" => array("Rain", "Heavy Rain", "Rain Fog/Mist", "Heavy Rain Fog/Mist", "Rain Fog", "Heavy Rain Fog"),
		"ra" => array("Rain", "Heavy Rain", "Rain Fog/Mist", "Heavy Rain Fog/Mist", "Rain Fog", "Heavy Rain Fog"),
		"shra" => array("(w/cloud cover > 60%)", "Rain Showers", "Light Rain Showers", "Light Rain and Breezy", "Heavy Rain Showers", "Rain Showers in Vicinity", "Light Showers Rain", "Heavy Showers Rain", "Showers Rain", "Showers Rain in Vicinity", "Rain Showers Fog/Mist", "Light Rain Showers Fog/Mist", "Heavy Rain Showers Fog/Mist", "Rain Showers in Vicinity Fog/Mist", "Light Showers Rain Fog/Mist", "Heavy Showers Rain Fog/Mist", "Showers Rain Fog/Mist", "Showers Rain in Vicinity Fog/Mist"),
		"nshra" => array("(w/cloud cover > 60%)", "Rain Showers", "Light Rain Showers", "Light Rain and Breezy", "Heavy Rain Showers", "Rain Showers in Vicinity", "Light Showers Rain", "Heavy Showers Rain", "Showers Rain", "Showers Rain in Vicinity", "Rain Showers Fog/Mist", "Light Rain Showers Fog/Mist", "Heavy Rain Showers Fog/Mist", "Rain Showers in Vicinity Fog/Mist", "Light Showers Rain Fog/Mist", "Heavy Showers Rain Fog/Mist", "Showers Rain Fog/Mist", "Showers Rain in Vicinity Fog/Mist"),
		"hi_shwrs" => array("(w/cloud cover < 60%)", "Showers in Vicinity", "Showers in Vicinity Fog/Mist", "Showers in Vicinity Fog", "Showers in Vicinity Haze"),
		"hi_nshwrs" => array("(w/cloud cover < 60%)", "Showers in Vicinity", "Showers in Vicinity Fog/Mist", "Showers in Vicinity Fog", "Showers in Vicinity Haze"),
		"tsra" => array("(w/cloud cover > 75%)", "Thunderstorm", "Thunderstorm Rain", "Light Thunderstorm Rain", "Heavy Thunderstorm Rain", "Thunderstorm Rain Fog/Mist", "Light Thunderstorm Rain Fog/Mist", "Heavy Thunderstorm Rain Fog and Windy", "Heavy Thunderstorm Rain Fog/Mist", "Thunderstorm Showers in Vicinity", "Light Thunderstorm Rain Haze", "Heavy Thunderstorm Rain Haze", "Thunderstorm Fog", "Light Thunderstorm Rain Fog", "Heavy Thunderstorm Rain Fog", "Thunderstorm Light Rain", "Thunderstorm Heavy Rain", "Thunderstorm Rain Fog/Mist", "Thunderstorm Light Rain Fog/Mist", "Thunderstorm Heavy Rain Fog/Mist", "Thunderstorm in Vicinity Fog/Mist", "Thunderstorm Showers in Vicinity", "Thunderstorm in Vicinity Haze", "Thunderstorm Haze in Vicinity", "Thunderstorm Light Rain Haze", "Thunderstorm Heavy Rain Haze", "Thunderstorm Fog", "Thunderstorm Light Rain Fog", "Thunderstorm Heavy Rain Fog", "Thunderstorm Hail", "Light Thunderstorm Rain Hail", "Heavy Thunderstorm Rain Hail", "Thunderstorm Rain Hail Fog/Mist", "Light Thunderstorm Rain Hail Fog/Mist", "Heavy Thunderstorm Rain Hail Fog/Hail", "Thunderstorm Showers in Vicinity Hail", "Light Thunderstorm Rain Hail Haze", "Heavy Thunderstorm Rain Hail Haze", "Thunderstorm Hail Fog", "Light Thunderstorm Rain Hail Fog", "Heavy Thunderstorm Rain Hail Fog", "Thunderstorm Light Rain Hail", "Thunderstorm Heavy Rain Hail", "Thunderstorm Rain Hail Fog/Mist", "Thunderstorm Light Rain Hail Fog/Mist", "Thunderstorm Heavy Rain Hail Fog/Mist", "Thunderstorm in Vicinity Hail", "Thunderstorm in Vicinity Hail Haze", "Thunderstorm Haze in Vicinity Hail", "Thunderstorm Light Rain Hail Haze", "Thunderstorm Heavy Rain Hail Haze", "Thunderstorm Hail Fog", "Thunderstorm Light Rain Hail Fog", "Thunderstorm Heavy Rain Hail Fog", "Thunderstorm Small Hail/Snow Pellets", "Thunderstorm Rain Small Hail/Snow Pellets", "Light Thunderstorm Rain Small Hail/Snow Pellets", "Heavy Thunderstorm Rain Small Hail/Snow Pellets"),
		"ntsra" => array("(w/cloud cover > 75%)", "Thunderstorm", "Thunderstorm Rain", "Light Thunderstorm Rain", "Heavy Thunderstorm Rain", "Thunderstorm Rain Fog/Mist", "Light Thunderstorm Rain Fog/Mist", "Heavy Thunderstorm Rain Fog and Windy", "Heavy Thunderstorm Rain Fog/Mist", "Thunderstorm Showers in Vicinity", "Light Thunderstorm Rain Haze", "Heavy Thunderstorm Rain Haze", "Thunderstorm Fog", "Light Thunderstorm Rain Fog", "Heavy Thunderstorm Rain Fog", "Thunderstorm Light Rain", "Thunderstorm Heavy Rain", "Thunderstorm Rain Fog/Mist", "Thunderstorm Light Rain Fog/Mist", "Thunderstorm Heavy Rain Fog/Mist", "Thunderstorm in Vicinity Fog/Mist", "Thunderstorm Showers in Vicinity", "Thunderstorm in Vicinity Haze", "Thunderstorm Haze in Vicinity", "Thunderstorm Light Rain Haze", "Thunderstorm Heavy Rain Haze", "Thunderstorm Fog", "Thunderstorm Light Rain Fog", "Thunderstorm Heavy Rain Fog", "Thunderstorm Hail", "Light Thunderstorm Rain Hail", "Heavy Thunderstorm Rain Hail", "Thunderstorm Rain Hail Fog/Mist", "Light Thunderstorm Rain Hail Fog/Mist", "Heavy Thunderstorm Rain Hail Fog/Hail", "Thunderstorm Showers in Vicinity Hail", "Light Thunderstorm Rain Hail Haze", "Heavy Thunderstorm Rain Hail Haze", "Thunderstorm Hail Fog", "Light Thunderstorm Rain Hail Fog", "Heavy Thunderstorm Rain Hail Fog", "Thunderstorm Light Rain Hail", "Thunderstorm Heavy Rain Hail", "Thunderstorm Rain Hail Fog/Mist", "Thunderstorm Light Rain Hail Fog/Mist", "Thunderstorm Heavy Rain Hail Fog/Mist", "Thunderstorm in Vicinity Hail", "Thunderstorm in Vicinity Hail Haze", "Thunderstorm Haze in Vicinity Hail", "Thunderstorm Light Rain Hail Haze", "Thunderstorm Heavy Rain Hail Haze", "Thunderstorm Hail Fog", "Thunderstorm Light Rain Hail Fog", "Thunderstorm Heavy Rain Hail Fog", "Thunderstorm Small Hail/Snow Pellets", "Thunderstorm Rain Small Hail/Snow Pellets", "Light Thunderstorm Rain Small Hail/Snow Pellets", "Heavy Thunderstorm Rain Small Hail/Snow Pellets"),
		"scttsra" => array("(Cloud cover 60 - 75%)", "Thunderstorm in Vicinity"),
		"nscttsra" => array("(Cloud cover 60 - 75%)", "Thunderstorm in Vicinity"),
		"hi_tsra" => array("(Cloud cover < 60%)", "Thunderstorm in Vicinity", "Thunderstorm in Vicinity Fog", "Thunderstorm in Vicinity Haze"),
		"hi_ntsra" => array("(Cloud cover < 60%)", "Thunderstorm in Vicinity", "Thunderstorm in Vicinity Fog", "Thunderstorm in Vicinity Haze"),
		"fc" => array("Funnel Cloud", "Funnel Cloud in Vicinity", "Tornado/Water Spout"),
		"nfc" => array("Funnel Cloud", "Funnel Cloud in Vicinity", "Tornado/Water Spout"),
		"tor" => array("Tornado"),
		"ntor" => array("Tornado"),
		"hur_warn" => array("Hurricane Warning"),
		"null" => array("Hot"),
		"hur_watch" => array("Hurricane Watch"),
		"ts_warn" => array("Tropical Storm Warning"),
		"ts_watch" => array("Tropical Storm Watch"),
		"ts_nowarn" => array("Tropical Storm Conditions presently exist w/Hurricane Warning in effect"),
		"wind_skc" => array("Windy", "Breezy", "Fair and Windy"),
		"nwind_skc" => array("Windy", "Breezy", "Fair and Windy"),
		"wind_few" => array("A Few Clouds and Windy"),
		"nwind_few" => array("A Few Clouds and Windy"),
		"wind_sct" => array("Partly Cloudy and Windy"),
		"nwind_sct" => array("Partly Cloudy and Windy"),
		"wind_bkn" => array("Mostly Cloudy and Windy"),
		"nwind_bkn" => array("Mostly Cloudy and Windy"),
		"wind_ovc" => array("Overcast and Windy"),
		"nwind_ovc" => array("Overcast and Windy"),
		"du" => array("Dust", "Low Drifting Dust", "Blowing Dust", "Sand", "Blowing Sand", "Low Drifting Sand", "Dust/Sand Whirls", "Dust/Sand Whirls in Vicinity", "Dust Storm", "Heavy Dust Storm", "Dust Storm in Vicinity", "Sand Storm", "Heavy Sand Storm", "Sand Storm in Vicinity"),
		"ndu" => array("Dust", "Low Drifting Dust", "Blowing Dust", "Sand", "Blowing Sand", "Low Drifting Sand", "Dust/Sand Whirls", "Dust/Sand Whirls in Vicinity", "Dust Storm", "Heavy Dust Storm", "Dust Storm in Vicinity", "Sand Storm", "Heavy Sand Storm", "Sand Storm in Vicinity"),
		"fu" => array("Smoke"),
		"nfu" => array("Smoke"),
		"hz" => array("Haze"),
		"hot" => array("Hot"),
		"cold" => array("Cold"),
		"ncold" => array("Cold"),
		"blizzard" => array("Blizzard"),
		"nblizzard" => array("Blizzard"),
		"fg" => array("Fog/Mist", "Freezing Fog", "Shallow Fog", "Partial Fog", "Patches of Fog", "Fog in Vicinity", "Freezing Fog in Vicinity", "Shallow Fog in Vicinity", "Partial Fog in Vicinity", "Patches of Fog in Vicinity", "Showers in Vicinity Fog", "Light Freezing Fog", "Heavy Freezing Fog"),
		"nfg" => array("Fog/Mist", "Freezing Fog", "Shallow Fog", "Partial Fog", "Patches of Fog", "Fog in Vicinity", "Freezing Fog in Vicinity", "Shallow Fog in Vicinity", "Partial Fog in Vicinity", "Patches of Fog in Vicinity", "Showers in Vicinity Fog", "Light Freezing Fog", "Heavy Freezing Fog")
	);	

	





	public function getList(&$params)
	{
		$source=$params->get('source','owm');
		
		
		if ($source=='owm'){
			$owmid=trim($params->get('owm_id','2643743'));
			$owmappid=trim($params->get('owm_appid',''));
			$lang=$params->get('owm_lang','en');
			$forecast=$this->getOpenWeatherMapForecast($owmid,$owmappid,$lang);
		}else if ($source=='meteoam'){
			$meteoam_id=trim($params->get('meteoam_id','91/brescia'));
			$forecast=$this->getMeteoAMForecast($meteoam_id);
		}else if ($source=='nws'){
			$nws_lat=floatval(trim($params->get('nws_lat','37.465578')));
			$nws_lon=floatval(trim($params->get('nws_lon','-122.186121')));
			$forecast=$this->getNWSForecast($nws_lat,$nws_lon);
		}
		$city_name=trim($params->get('city_name',''));
		if (!empty($forecast) && !empty($city_name)){
			$forecast['text']=$city_name;
		}
		
		$num_forecast=max(1,intval($params->get('num_forecast','23')));
		if (!empty($forecast) && !empty($forecast['forecasts'])){
			$forecast['forecasts']=array_slice($forecast['forecasts'],0,$num_forecast);
		}

		
		return array($forecast,$this->messages);
	}

	private function enqueueMessage($msg,$type){
		$this->messages[]=array('msg'=>$msg,'type'=>$type);
	}
	/*
	public function getYahooForecast($woeid){
		$woeid=intval($woeid);
		$forecast=$this->getForecasts(array('yahoo',$woeid));
		if ($forecast!==FALSE){
			return $forecast;
		}
	
		$forecast=array();

		$BASE_URL = "http://query.yahooapis.com/v1/public/yql";
		
		
		$yql_query = 'select * from weather.forecast where woeid = '.$woeid.' ';
		$yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
	
		if(version_compare(JVERSION, '3.0', 'ge')){
			$http = JHttpFactory::getHttp();
		}else{
			jimport( 'joomla.client.http' );
			$http = new JHttp();
		}
        $resp = $http->get($yql_query_url);
		
		//$http->code==404
		if (substr($resp->code,0,1)==4){
			$this->enqueueMessage('Yahoo: error code: '.$resp->code.' yql query '.$yql_query, 'error');
			return false;
		}
		if ($resp->code!="200"){
			$this->enqueueMessage('Yahoo: unknown result code: '.$resp->code.' yql query '.$yql_query, 'error');
			return false;
		}
		
		$data=json_decode($resp->body,true);
		
		if ($data===NULL){
			$this->enqueueMessage('Yahoo: unable to decode json: yql query '.$yql_query, 'error');
			return false;
			
		}
		
		if ($data['query']['count']==0){
			$this->enqueueMessage('Yahoo: no forecast for woeid '.$woeid, 'error');
			return false;
		}
		
		$channel=$data['query']['results']['channel'];
		
		
		$title_parts=explode('-',$channel['title']);
		//Yahoo! Weather - Brescia, IT
		$city_name='';
		$city_region='';
		if (preg_match("/^.*Yahoo! Weather - ([^,]+), ([^ ]+).*$/i",$channel['title'],$matches)){
			$city_name=$matches[1];
			$city_region=$matches[2];
		}
		
		
		$forecast = array(
			'city_name'=>$city_name,
			'city_region'=>$city_region,
			'text'=>$city_name.' '.$city_region,
			'forecasts'=>array()
		);
		
		
		foreach ($channel['item']['forecast'] as $fc){
			$day_parts=explode(' ',$fc['date']);
			
			if ($channel['units']['temperature']=='F'){
				$fc['low']=5.0/9.0*($fc['low']-32);
				$fc['high']=5.0/9.0*($fc['high']-32);
			}
			
			$forecast['forecasts'][] = array(
				'day' => $fc['day'].','.$day_parts[0],
				'time' => '',
				'text' => $fc['text'],
				'temp' => round($fc['low']),
				'perc_temp' => round($fc['high']),
				'icona_url' => "http://l.yimg.com/os/mit/media/m/weather/images/icons/l/27n-100567.png",//TODO
				
				
				'wind_url' => "",
				'wind_text'=> "",
				'wind_dir'=>"",
				'wind_knots'=>0,
				'wind_f'=>0,
				'wind_kmh'=>0,
			);
			
			
			
		}
		
		
		$this->saveForecasts($forecast,array('yahoo',$woeid));
		return $forecast;
		
	}
	*/
	public function getOpenWeatherMapForecast($owmid,$owmappid, $lang){
		if (empty($owmid)){
			$this->enqueueMessage('OpenWeatherMap: locality ID is empty', 'error');
			return false;
		}
		$owmappid=trim($owmappid);
		if (empty($owmappid)){
			$this->enqueueMessage('OpenWeatherMap: App ID is empty', 'error');
			return false;
		}
		$owmid=intval($owmid);
		$forecast=$this->getForecasts(array('openweathermap',$owmid,$lang),array($owmappid));
		if ($forecast!==FALSE){
			return $forecast;
		}
	
		$forecast=array();
		
		/*
		English - en, 
		Russian - ru, 
		Italian - it, 
		Spanish - es (or sp), 
		Ukrainian - uk (or ua), 
		German - de, 
		Portuguese - pt, 
		Romanian - ro, 
		Polish - pl, 
		Finnish - fi, 
		Dutch - nl, 
		French - fr, 
		Bulgarian - bg, 
		Swedish - sv (or se), 
		Chinese Traditional - zh_tw, 
		Chinese Simplified - zh (or zh_cn), 
		Turkish - tr, 
		Croatian - hr, 
		Catalan - ca
		*/
		
		$url="http://api.openweathermap.org/data/2.5/forecast?id=".$owmid."&units=metric&lang=".$lang."&appid=".$owmappid;

		
		$response = wp_remote_get( $url, array(
			'timeout'     => 30,
			'user-agent'  => 'giWeather',
			'sslverify'   => false
		) );
			
		if ( is_wp_error( $response ) ) {
			$this->enqueueMessage('OpenWeatherMap: error code: '.$response->get_error_code().' msg:'.$response->get_error_message().' url: '.$url, 'error');
			return false;
		}
		$data=json_decode($response['body'],true);
		
		if ($data===NULL){
			$this->enqueueMessage('OpenWeatherMap: unable to decode json: url '.$url, 'error');
			return false;
			
		}
		
		if ($data['cod']!=200){
			$this->enqueueMessage('OpenWeatherMap: error '.$data['message'].' for url '.$url, 'error');
			return false;
		}
		
		
		$city_name=$data['city']['name'];
		$city_region=$data['city']['country'];
		
		
		$forecast = array(
			'city_name'=>$city_name,
			'city_region'=>$city_region,
			'text'=>$city_name.' '.$city_region,
			'forecasts'=>array(),
			'source'=>'owm'
		);
		
		//error_log(var_export($data['list'],true),3,'/wamp/workspace/php-errors.log');
		
		foreach ($data['list'] as $fc){
			
			$f_float=1.94384449*$fc['wind']['speed'];
			$f=round($f_float/5)*5;
			if ($f_float<0.5){
				$f=0;
			}else{
				$f=max(1,$f);
			}
			$f=min(65,$f);
			
			$directions=array('N','NE','E','SE','S','SW','W','NW','N');
			
			//352.5
			//0
			
			$dir_indx=round(($fc['wind']['deg']%360)/45);
			
			
			
			$icode=substr($fc['weather'][0]['icon'],0,2);
			$idn=substr($fc['weather'][0]['icon'],2,1);

			$icon_code='other';
			if (isset($this->owm2icon[$icode])){
				$icon_code=$this->owm2icon[$icode];
			}
			$icon_is_day=$idn=='d';
			
			$forecast['forecasts'][] = array(
				'dt' => $fc['dt'],
				//'day' => date('D, d',$fc['dt']),
				//'time' => date('H:i',$fc['dt']),
				'text' => $fc['weather'][0]['description'],
				'temp' => $fc['main']['temp_min'],
				'perc_temp' => $fc['main']['temp_max'],
				'icon_code' => $icon_code,
				'icon_is_day' => $icon_is_day,
				'wind_text'=> "",
				'wind_dir'=>$f==0?'':$directions[$dir_indx],
				'wind_knots'=>1.94384449*$fc['wind']['speed'],
				'wind_f'=>$f,
				'wind_kmh'=>3.6*$fc['wind']['speed'],
				'humidity'=>$fc['main']['humidity'],//%
				'pressure'=>$fc['main']['pressure'],//hpa
				
			);
			
			
			
		}
		
		
		$this->saveForecasts($forecast,array('openweathermap',$owmid,$lang),array($owmappid));
		return $forecast;
		
	}
		
	public function getNWSForecast($lat,$lon){
		if (empty($lat) || empty($lon)){
			$this->enqueueMessage('NWS Weather.gov: latitude or longitude is empty', 'error');
			return false;
		}
		$forecast=$this->getForecasts(array('nws',$lat,$lon));
		if ($forecast!==FALSE){
			return $forecast;
		}
	
		$forecast=array();
		

		
		$url="http://graphical.weather.gov/xml/sample_products/browser_interface/ndfdXMLclient.php?lat=".$lat."&lon=".$lon."&product=time-series&maxt=maxt&mint=mint&appt=appt&pop12=pop12&rh=rh&wspd=wspd&wdir=wdir&wx=wx&wwa=wwa&icons=icons&Unit=m";


		$response = wp_remote_get( $url, array(
			'timeout'     => 30,
			'user-agent'  => 'giWeather',
			'sslverify'   => false
		) );
			
		if ( is_wp_error( $response ) ) {
			$this->enqueueMessage('NWS Weather.gov: error code: '.$response->get_error_code().' msg:'.$response->get_error_message().' url: '.$url, 'error');
			return false;
		}


		
		$xml =$response['body'];
		//parse XML
		
		$doc = new DOMDocument();
		@$doc->loadXML($xml);
		$errors = $doc->getElementsByTagName('error');
		foreach ($errors as $e){
			$this->enqueueMessage('NWS Weather.gov: '.$e->getElementsByTagName('h2')->item(0)->textContent.':'.$e->getElementsByTagName('pre')->item(0)->textContent, 'error');
			return false;
		}

		$data = $doc->getElementsByTagName('data')->item(0);
		
		$time_layouts = array();
		
		$time_layouts_xml = $data->getElementsByTagName('time-layout');
		foreach ($time_layouts_xml as $tl){
			$tlk = $tl->getElementsByTagName('layout-key')->item(0)->textContent;
			$time_layouts[$tlk] = array();
			
			$starts = $tl->getElementsByTagName('start-valid-time');
			foreach ($starts as $s){
				$time_layouts[$tlk][]=array('s'=>$s->textContent);
			}
		}
		
		$forecasts_values = array();
		
		$temperature_xml = $data->getElementsByTagName('temperature');
		foreach ($temperature_xml as $temp){
			//type="maximum" units="Celsius" time-layout="k-p24h-n7-1"
			$type = $temp->getAttribute('type');
			$tlk = $temp->getAttribute('time-layout');
			
			$value_xml = $temp->getElementsByTagName('value');
			$i = 0;
			foreach ($value_xml as $val){
				$fdate = $time_layouts[$tlk][$i]['s'];
				if (!isset($forecasts_values[$fdate])){
					$forecasts_values[$fdate] = array();
				}
				$forecasts_values[$fdate]['t_'.$type] = $val->textContent;
				
				$i++;
			}
		}
		
		
		$windspeed_xml = $data->getElementsByTagName('wind-speed');
		foreach ($windspeed_xml as $ws){
			$tlk = $ws->getAttribute('time-layout');
			
			$value_xml = $ws->getElementsByTagName('value');
			$i = 0;
			foreach ($value_xml as $val){
				$fdate = $time_layouts[$tlk][$i]['s'];
				if (!isset($forecasts_values[$fdate])){
					$forecasts_values[$fdate] = array();
				}
				$forecasts_values[$fdate]['windspeed'] = $val->textContent;
				
				$i++;
			}
		}
		
		
		$winddir_xml = $data->getElementsByTagName('direction');
		foreach ($winddir_xml as $wd){
			$tlk = $wd->getAttribute('time-layout');
			
			$value_xml = $wd->getElementsByTagName('value');
			$i = 0;
			foreach ($value_xml as $val){
				$fdate = $time_layouts[$tlk][$i]['s'];
				if (!isset($forecasts_values[$fdate])){
					$forecasts_values[$fdate] = array();
				}
				$forecasts_values[$fdate]['winddir'] = $val->textContent;
				
				$i++;
			}
		}
		
		
		
		//probability-of-precipitation
		$probp_xml = $data->getElementsByTagName('probability-of-precipitation');
		foreach ($probp_xml as $pp){
			$tlk = $pp->getAttribute('time-layout');
			
			$value_xml = $pp->getElementsByTagName('value');
			$i = 0;
			foreach ($value_xml as $val){
				$fdate = $time_layouts[$tlk][$i]['s'];
				if (!isset($forecasts_values[$fdate])){
					$forecasts_values[$fdate] = array();
				}
				$forecasts_values[$fdate]['probp'] = $val->textContent;
				
				$i++;
			}
		}
		
		
		
		//humidity 
		$humidity_xml = $data->getElementsByTagName('humidity');
		foreach ($humidity_xml as $hu){
			$tlk = $hu->getAttribute('time-layout');
			
			$value_xml = $hu->getElementsByTagName('value');
			$i = 0;
			foreach ($value_xml as $val){
				$fdate = $time_layouts[$tlk][$i]['s'];
				if (!isset($forecasts_values[$fdate])){
					$forecasts_values[$fdate] = array();
				}
				$forecasts_values[$fdate]['humidity'] = $val->textContent;
				
				$i++;
			}
		}
		
		
		
		//weather
		$weather_xml = $data->getElementsByTagName('weather');
		foreach ($weather_xml as $wd){
			$tlk = $wd->getAttribute('time-layout');
			
			$value_xml = $wd->getElementsByTagName('weather-conditions');
			$i = 0;
			foreach ($value_xml as $val){
				$fdate = $time_layouts[$tlk][$i]['s'];
				if (!isset($forecasts_values[$fdate])){
					$forecasts_values[$fdate] = array();
				}
				$wc = array();
				
				$last_coverage = '';
				//determino la wc se presente
				$subval_xml = $val->getElementsByTagName('value');
				foreach ($subval_xml as $sv){
					$intensity = $sv->getAttribute('intensity');
					$additive = $sv->getAttribute('additive');
					$coverage = $sv->getAttribute('coverage');
					$weather_type = $sv->getAttribute('weather-type');
					
					if (!empty($additive)){
						$wc[] = $additive;
					}
					if (!empty($coverage) && $coverage!=$last_coverage){
						$wc[] = $coverage;
						$last_coverage = $coverage;
					}
					if (!empty($intensity) && $intensity!='none'){
						$wc[] = $intensity;
					}
					if (!empty($weather_type)){
						$wc[] = $weather_type;
					}
					
				}
				
				$forecasts_values[$fdate]['weather'] = implode(' ',$wc);
				
				$i++;
			}
		}
		
		//conditions-icon
		$icon_xml = $data->getElementsByTagName('conditions-icon');
		foreach ($icon_xml as $icon){
			$tlk = $icon->getAttribute('time-layout');
			
			$value_xml = $icon->getElementsByTagName('icon-link');
			$i = 0;
			foreach ($value_xml as $val){
				$fdate = $time_layouts[$tlk][$i]['s'];
				if (!isset($forecasts_values[$fdate])){
					$forecasts_values[$fdate] = array();
				}
				$forecasts_values[$fdate]['icon'] = $val->textContent;
				
				$i++;
			}
		}
		
		
		//'t_maximum'
		//'t_minimum'
		//'windspeed'
		//'winddir'
		//'probp'
		//'humidity'
		//'weather'
		//'icon'
		$propagate_values = array('t_maximum','t_minimum','t_apparent','windspeed','winddir','probp','humidity','weather','icon');
		
		//propago a quello più vicino
		ksort($forecasts_values);
		
		$last_fc = array();
		
		foreach ($forecasts_values as $day => &$fc){
			foreach ($propagate_values as $p){
				if (!isset($fc[$p]) && isset($last_fc[$p])){
					$fc[$p] = $last_fc[$p];
				}
			}
			$last_fc = $fc;
		}
		unset($fc);
		
		
		//error_log(var_export($forecasts_values,true),3,'/workspace/php-errors.log');
		
		//die();

		
		
		$forecast = array(
			'city_name'=>"Geo ${lat}, ${lon}",
			'city_region'=>"Geo ${lat}, ${lon}",
			'text'=>"Geo ${lat}, ${lon}",
			'forecasts'=>array(),
			'source'=>'nws'
		);
		
		//error_log(var_export($data['list'],true),3,'/wamp/workspace/php-errors.log');
		
		$find_first = true;
		
		$last_time = 0;
		foreach ($forecasts_values as $day => $fc){
			if ($find_first){
				$found = true;
				foreach ($propagate_values as $p){
					if (!isset($fc[$p])){
						$found = false;
						break;
					}
				}
				
				if($found){
					$find_first = false;
				}else{
					continue;
				}
			}
			
			$time = strtotime($day);
			//una previsione ogni 4 ore
			if (($time-$last_time)< (4*60*60)){
				continue;
			}
			//if (empty($fc['weather'])){
			//	continue;
			//}
			
			$last_time = $time;
			
			
			$icode = rtrim(preg_replace("/\.[^.]+$/", "", basename($fc['icon'])),"0123456789");
			
			$icon_code='other';
			$icon_is_day=true;
			if (isset($this->nws2icon[$icode])){
				$icon_code=$this->nws2icon[$icode][0];
				$icon_is_day=$this->nws2icon[$icode][1]=='day';
			}
			
			if (empty($fc['weather'])){
				if (isset($this->nws2desc[$icode])){
					$fc['weather'] = $this->nws2desc[$icode][0];
				}
			}
			
			$f_float=1.94384449*$fc['windspeed'];
			$f=round($f_float/5)*5;
			if ($f_float<0.5){
				$f=0;
			}else{
				$f=max(1,$f);
			}
			$f=min(65,$f);
			
			$directions=array('N','NE','E','SE','S','SW','W','NW','N');
			
			//352.5
			//0
			
			$dir_indx=round(($fc['winddir']%360)/45);
			
			
			
			
			$forecast['forecasts'][] = array(
				'dt' => $time,
				'text' => $fc['weather'],
				'temp' => $fc['t_minimum'],
				'perc_temp' => $fc['t_apparent'],
				
				
				'wind_text'=> "",
				'wind_dir'=>$f==0?'':$directions[$dir_indx],
				'wind_knots'=>1.94384449*$fc['windspeed'],
				'wind_f'=>$f,
				'wind_kmh'=>3.6*$fc['windspeed'],
				'humidity'=>$fc['humidity'],//%

				'prec_prob'=>$fc['probp'],//%
				
				
				'icon_code' => $icon_code,
				'icon_is_day' => $icon_is_day,
			);
			
			
			
		}
		
		
		$this->saveForecasts($forecast,array('nws',$lat,$lon));
		return $forecast;
		
	}				
		
	public function getMeteoAMForecast($locality){
		if (empty($locality)){
			$this->enqueueMessage('MeteoAM: locality ID is empty', 'error');
			return false;
		}
		
		$forecast=$this->getForecasts(array('meteoam',$locality));
		if ($forecast!==FALSE){
			return $forecast;
		}
	
		$forecast=array();
		
		$url='http://www.meteoam.it/?q=ta/previsione/'.$locality;
		

		$response = wp_remote_get( $url, array(
			'timeout'     => 30,
			'user-agent'  => 'giWeather',
			'sslverify'   => false
		) );
			
		if ( is_wp_error( $response ) ) {
			$this->enqueueMessage('MeteoAM: error code: '.$response->get_error_code().' msg:'.$response->get_error_message().' url: '.$url, 'error');
			return false;
		}		
		
		
			
		$doc = new DOMDocument();
		@$doc->loadHTML($response['body']);
		$table = $doc->getElementById('previsioniOverlTable');
		if ($table===NULL){
			$this->enqueueMessage('MeteoAM: changed html structure of page: '.$url.'  missing previsioniOverlTable', 'error');
			return false;
		}
		
		$br=$table->previousSibling;
		if ($br===NULL){
			$this->enqueueMessage('MeteoAM: changed html structure of page: '.$url.'  missing previousSibling', 'error');
			return false;
		}
		$table_name=$br->previousSibling;
		if ($table_name===NULL){
			$this->enqueueMessage('MeteoAM: changed html structure of page: '.$url.'  missing table name', 'error');
			return false;
		}
		
		
		$trs = $table_name->getElementsByTagName('tr');
		$tr=$trs->item(1);
		$tds = $tr->getElementsByTagName('td');
		$city_name=$tds->item(0)->textContent;
		
		$city_name_parts=explode(' ',$city_name);
		foreach ($city_name_parts as &$p){
			$p=$this->ucfirst($p);
		}
		unset($p);
		$city_name=implode(' ',$city_name_parts);
		
		$city_region=mb_strtoupper($tds->item(1)->textContent);
		
		$forecast = array(
			'city_name'=>$city_name,
			'city_region'=>$city_region,
			'text'=>$city_name.' '.$city_region,
			'forecasts'=>array(),
			'source'=>'meteoam'
		);
			
		$trs = $table->getElementsByTagName('tr');
		
		$last_ts=0;
		
		for ($i = 1; $i < $trs->length; $i++) {
			$tr = $trs->item($i);
			$tds = $tr->getElementsByTagName('td');
			$img = $tds->item(2)->getElementsByTagName('img')->item(0);

			$wind_img = $tds->item(5)->getElementsByTagName('img')->item(0);

			
			
			$temp=intval($tds->item(3)->textContent);
			$perc_temp=intval($tds->item(4)->textContent);
			
			$wind_name=basename(strtolower($wind_img->getAttribute('src')),'.png');//images/iconeventoblu/vento_f5_ne.png
			if ($wind_name=='ventovariabile'){
				$wind_direction='';
				$wind_f=0;
				
			}else{
				//vento_f5_ne
				$wind_name_parts=explode('_',$wind_name);
				$wind_direction=strtoupper($wind_name_parts[2]);//NE
				$wind_f=intval(trim($wind_name_parts[1],'f'));//5
			}
			//Direzione : NEIntensità media : 17 Nodi (31 Km/h)

			$wind_kmh=0;
			$wind_knots=0;
			$wind_text=$tds->item(6)->textContent;
			$matches=array();
			if (preg_match("/^.* ([0-9]+) Nodi \(([0-9]+) Km\/h\).*$/i",$wind_text,$matches)){
				$wind_kmh=$matches[2];
				$wind_knots=$matches[1];
			}
			//if (preg_match("/^.* ([0-9]+) Nodi \(([0-9]+) Km\/h\).*$/i","Calma",$matches)){
			//	error_log("Calma".var_export($matches,true),3,'/wamp/workspace/php-errors.log');
			//}
			
			// /images/iconemeteo/notte/64x64/molto_nuvoloso_temporale.png
			$url_parts=explode('/',$img->getAttribute('src'));
			$num_url_parts=count($url_parts);
			
			
			$icode=basename($img->getAttribute('src'),'.png');
			$icon_code='other';
			if (isset($this->meteoam2icon[$icode])){
				$icon_code=$this->meteoam2icon[$icode];
			}
			$icon_is_day=$url_parts[$num_url_parts-3]=='giorno';
			
			//$dt = gmdate('Y-m-d') . ' ' . $tds->item(1)->textContent;
			//$h = $this->gi_date_from_to_timezone($dt, 'UTC', 'Europe/Rome')->format('H:i');

			//Lun, 02 15:00
			$date_toparse=trim($tds->item(0)->textContent,chr(0xC2).chr(0xA0)).' '.$tds->item(1)->textContent;
			$date_toparse=str_replace(array("Lun","Mar","Mer","Gio","Ven","Sab","Dom"),array("Mon","Tue","Wed","Thu","Fri","Sat","Sun"),$date_toparse);
			//Mon, 02 15:00
			
			$timezone = date_default_timezone_get();
			date_default_timezone_set('UTC');

			$a_ts=$this->gi_date_parse_from_format( 'D, d H:i' , $date_toparse );
			$a_ts['month']=date('n');
			$a_ts['year']=date('Y');
			
			$ts = mktime($a_ts['hour'], $a_ts['minute'], $a_ts['second'], $a_ts['month'], $a_ts['day'], $a_ts['year']);
			if ($ts<$last_ts){
				if ($a_ts['day']==28 || $a_ts['day']==29 || $a_ts['day']==30  || $a_ts['day']==31){
					if ($a_ts['month']==12){
						//changed year
						$a_ts['month']=1;
						$a_ts['year']+=1;
					}else{
						//changed month
						$a_ts['month']+=1;
					}
				}
				
				$ts = mktime($a_ts['hour'], $a_ts['minute'], $a_ts['second'], $a_ts['month'], $a_ts['day'], $a_ts['year']);
			}
			
			date_default_timezone_set($timezone);
			$last_ts=$ts;
			
			$forecast['forecasts'][] = array(
				'dt' => $ts,
				//'day' => trim($tds->item(0)->textContent,chr(0xC2).chr(0xA0)),
				//'time' => $h,
				'text' => $img->getAttribute('title'),
				'wind_text'=> $tds->item(6)->textContent,
				'temp' => $temp,
				'perc_temp' => $perc_temp,
				'wind_dir'=>$wind_direction,
				'wind_knots'=>$wind_knots,
				'wind_f'=>$wind_f,
				'wind_kmh'=>$wind_kmh,
				'icon_code' => $icon_code,
				'icon_is_day' => $icon_is_day,
				
			);
		}		
		
		$this->saveForecasts($forecast,array('meteoam',$locality));
		return $forecast;
		
	}
	
	public function gi_date_parse_from_format( $format , $date ){
		$a_ts=date_parse_from_format($format, $date);
		if ($a_ts['hour']===FALSE){
			$a_ts['hour']=0;
		}
		if ($a_ts['minute']===FALSE){
			$a_ts['minute']=0;
		}
		if ($a_ts['second']===FALSE){
			$a_ts['second']=0;
		}
		if ($a_ts['month']===FALSE){
			$a_ts['month']=1;
		}
		if ($a_ts['day']===FALSE){
			$a_ts['day']=1;
		}
		if ($a_ts['year']===FALSE){
			$a_ts['year']='1999';
		}
		return $a_ts;
	}
	
	public function weather_icon($fc,$icon_set){
		$baselocalurl=plugins_url( '/extras/lib_giweather/media/',GIW_PLUGIN_FILE );
		
		
		if ($icon_set=='meteocons_dark' || $icon_set=='meteocons_light' || $icon_set=='gk4' || $icon_set=='meteoam' || $icon_set=='owm' || $icon_set=='yahoo' || $icon_set=='google'){
			$img_url=$baselocalurl. 'images/icons/'.$icon_set.'/64/' .$this->icon2gk4[$fc['icon_code']][$fc['icon_is_day']?0:1].'.png';
			$img_url_t=$img_url;
			if ($icon_set=='meteoam'){
				$img_url='http://www.meteoam.it/images/iconemeteo/'.($fc['icon_is_day']?'giorno':'notte').'/64x64/'.$this->icon2meteoam[$fc['icon_code']].'.png';
				$img_url_t=$img_url;
			}else if ($icon_set=='owm'){
				$img_url='http://openweathermap.org/img/w/'.$this->icon2owm[$fc['icon_code']].($fc['icon_is_day']?'d':'n').'.png';
				$img_url_t=$img_url;
			}else if ($icon_set=='yahoo'){
				$img_url='http://l.yimg.com/os/mit/media/m/weather/images/icons/l/'.$this->icon2yahoo[$fc['icon_code']].($fc['icon_is_day']?'d':'n').'-100567.png';
				$img_url_t=$img_url;
			}else if ($icon_set=='google'){
				$img_url='https://ssl.gstatic.com/onebox/weather/64/'.$this->icon2google[$fc['icon_code']].'.png';
				$img_url_t='https://ssl.gstatic.com/onebox/weather/48/'.$this->icon2google[$fc['icon_code']].'.png';
			}
		
			return '<img class="giw-fc-thumb-img giw-is-'.$icon_set.'" title="'.$this->gi_escape_html($fc['text']).'" alt="'.$this->gi_escape_html($fc['text']).'" src="'.$this->gi_escape_html($img_url_t).'"><img class="giw-fc-full-img  giw-is-'.$icon_set.'" title="'.$this->gi_escape_html($fc['text']).'" alt="'.$this->gi_escape_html($fc['text']).'" src="'.$this->gi_escape_html($img_url).'">';
			
		}else{
			$htmlfull=array();
			$html=array();
			$html[]='<span class="giw-fc-thumb-img giw-is-'.$icon_set.'" title="'.$this->gi_escape_html($fc['text']).'" alt="'.$this->gi_escape_html($fc['text']).'">';
			$htmlfull[]='<span class="giw-fc-full-img  giw-is-'.$icon_set.'" title="'.$this->gi_escape_html($fc['text']).'" alt="'.$this->gi_escape_html($fc['text']).'">';
			
			if ($icon_set=='meteocons_font'){
				$iconclass_parts=array('meteocons-'.$this->icon2gk4[$fc['icon_code']][$fc['icon_is_day']?0:1]);
				foreach ($iconclass_parts as $iclass){
					$html[]='<i class="'.$iclass.' size-32 dark"></i>';
					$htmlfull[]='<i class="'.$iclass.' size-64 dark"></i>';
				}
			}else{
				//forecast font
				$iconclass=$this->icon2forecastfont[$fc['icon_code']][$fc['icon_is_day']?0:1];
				$iconclass_parts=explode('+',$iconclass);
				foreach ($iconclass_parts as $iclass){
					$html[]='<span class="'.$iclass.'"></span>';
					$htmlfull[]='<span class="'.$iclass.'"></span>';
				}
			}
			
			$html[]='</span>';
			$htmlfull[]='</span>';
			return implode("\n",$html).implode("\n",$htmlfull);
		}
			
	}
	
	public function wind_icon($fc,$wind_icon_set){
		$baselocalurl=plugins_url( '/extras/lib_giweather/media/',GIW_PLUGIN_FILE );

		$img_url=$baselocalurl. 'images/wind_icons/'.$wind_icon_set.'/64/F'.$fc['wind_f'].'_'.$fc['wind_dir'].'.png';
		if ($fc['wind_f']==0){
			$img_url=$baselocalurl. 'images/wind_icons/'.$wind_icon_set.'/64/F'.$fc['wind_f'].'.png';
		}

		if ($wind_icon_set=='meteoam'){
			if ($fc['wind_f']==0){
				$img_url='http://www.meteoam.it/images/iconeventoblu/ventoVariabile.png';
			}else{
				$img_url='http://www.meteoam.it/images/iconeventoblu/vento_F'.min($fc['wind_f'],60).'_'.$fc['wind_dir'].'.png';
			}
		}
		
		
		return '<img class="giw-fc-thumb-windimg giw-is-'.$wind_icon_set.'" title="'.$this->gi_escape_html($fc['wind_text']).'" alt="'.$this->gi_escape_html($fc['wind_text']).'" src="'.$this->gi_escape_html($img_url).'">';
	}
	
	/*
	public function gi_date_from_to_timezone($date, $from_tz, $to_tz) {
		$date_to = new DateTime($date, new DateTimeZone($from_tz));
		$date_to->setTimezone(new DateTimeZone($to_tz));
		return $date_to;
	}
	*/



	private function getHash($public_array,$pivate_array=array()){
		$parts=array();
		$parts[]=preg_replace('/[^a-zA-Z0-9]/', '', '1.5.1');//versione giWeather
		foreach($public_array as $p){
			$parts[]=substr(preg_replace('/[^a-zA-Z0-9-]/', '_', "$p"),0,4);
		}
		$parts[]=substr(md5(implode('',array_merge($public_array,$pivate_array))),0,10);
		$hash=implode('-',$parts);
		
		return $hash;
	}
	
	private function saveForecasts($forecast,$public_array,$pivate_array=array()){
		//error_log('save '.var_export($forecast,true)."\n");
		//wp_cache_set( $this->getHash($public_array,$pivate_array), $forecast, 'giWeather', $this->CacheLifetime );
		set_transient( substr('giw-'.$this->getHash($public_array,$pivate_array),0,40), $forecast, $this->CacheLifetime );
	}
	private function getForecasts($public_array,$pivate_array=array()){
		//$forecast=wp_cache_get( $this->getHash($public_array,$pivate_array), 'giWeather' );
		$forecast=get_transient( substr('giw-'.$this->getHash($public_array,$pivate_array),0,40));
		//error_log('get '.var_export($forecast,true)."\n");
		return $forecast;
	}


	
	public $CacheLifetime;
	protected $messages;

	public function __construct()
	{
		$this->messages=array();
		
	}
	
	public function gi_escape_html($value){
		//<div>...ESCAPE UNTRUSTED DATA BEFORE PUTTING HERE...</div>
		$quote_style = ENT_QUOTES;
		if (version_compare(PHP_VERSION, '5.4') >= 0) {
			$quote_style = ENT_QUOTES | ENT_SUBSTITUTE;
		}	
		return htmlspecialchars($value,$quote_style,'UTF-8');
	}
	public function gi_undo_escape_html($value){
		$quote_style = ENT_QUOTES;
		return html_entity_decode($value,$quote_style,'UTF-8');
	}
	
    public function ucfirst($string, $e ='utf-8') { 
        if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) { 
            $string = mb_strtolower($string, $e); 
            $upper = mb_strtoupper($string, $e); 
            preg_match('#(.)#us', $upper, $matches); 
            $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e); 
        } else { 
            $string = ucfirst($string); 
        } 
        return $string; 
    } 	
	public function round($val){
		$val=round($val);
		if ("$val"=='-0'){
			$val=0;
		}
		return $val;
	}

	
}
