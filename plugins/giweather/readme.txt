=== giWeather ===
Contributors: GardaInformatica
Tags: weather, weather forecast, responsive, mobile ready, deferred load, open weather map, meteoam, meteo, multilanguage, ajax weather, ajax weather widget, beautiful weather, beautiful weather widget, big weather, cool weather, cute weather, cute weather widget, detail weather, easy install, forecast, forecast weather widget, get weather, hd weather, hd weather widget, hourly weather forecast, sidebar weather widget, sleek weather, sleek weather widget, small weather, small weather widget, weather widget, weather-forcast, weather-hourly-forecast, widget, wordpress weather, any city, celsius, customize, drag-and-drop, easy, fahrenheit, free, mobile responsive, prediction, responsive design, shortcode, sidebar, weather app, weather by location, weather channel, weather forecast, weather forecast app, weather forecast plugin, weather forecast widget, weather plugin, openweathermap, national weather service, weather.gov
Donate link: http://giweather.gardainformatica.it/
Requires at least: 3.5.1
Tested up to: 4.6
Stable tag: 1.5.1
License: GNU/GPL - http://www.gnu.org/licenses/gpl-3.0.html
License URI: http://giweather.gardainformatica.it/

giWeather is a Wordpress widget that shows the weather forecast with a clean, clear and responsive style inspired by Google.

== Description ==
giWeather is a Wordpress widget that shows the weather forecast with a clean, clear and responsive style inspired by Google.

[giWeather Demo Site](http://giweather.gardainformatica.it/wp-demo/ "giWeather Demo Site")

Features:

  * Possibility to choose the source of weather forecast between OpenWeatherMap (Worldwide) and National Weather Service weather.gov (USA only)
  * **Endless colors**. Possibility to choose the color of the weather module with a simple color picker; 
  * **Unit of Measure** support: Imperial/British and Metric/International;
  * **TimeZone** support: possibility to choose the time zone of the weather forecast;
  * **Font Size** selection: Small, Medium, Large;
  * **Many iconset** (from near reality to flat icon): Iconvault Forecast (font), Meteocons (font/img) dark and light, gk4 (img), MeteoAM (img, external), OpenWeatherMap (img, external), Yahoo (img, external), Google (img, external);
  * **Deferred load** of module in order to speed up website loading;
  * **Data cache** for faster loading and reduce the demands on the forecast source;
  * **Fully responsive** - will adapt to any device;
  * **Advanced touch / swipe** support built-in;
  * **Wind icons** with intensity and direction;
  * Possibility to choose the **time horizon of the forecast**;
  * Possibility to show or hide the detail sections of the module: Locality, Date, Descriptive weather, Humidity , Pressure , Wind, Thumbnails Forecasts;
  * **Multilanguage forecast descriptive text** support (OpenWeatherMap): English, Russian, Italian, Spanish, Ukrainian, German, Portuguese, Romanian, Polish, Finnish, Dutch, French, Bulgarian, Swedish, Chinese Traditional, Chinese Simplified, Turkish, Croatian, Catalan;
  * Browser support: **Firefox, Chrome, Safari, iOS, Android, IE**.
  * Highly customizable with CSS;

For more information visit the giWeather home page at: http://giweather.gardainformatica.it/

== Installation ==
You can either install it automatically from the WordPress admin, or do it manually.

Install from WordPress admin:

   1. In the administrative interface of Wordpress go to **Plugin > Add New**;
   2. Search **giWeather** and choose **Install now**;
   3. Activate the plugin;
   4. Click on **Appearance > Widgets** from the main navigation menu in your Dashboard;
   5. Add giWeather widgets from the Available Widgets section by dragging it to the Sidebar you want to customize;
   6. Configure the widget and save it. 
   
For more information visit the documentation page at: http://giweather.gardainformatica.it/documentation-wordpress

OR
   
Install manually:

   1. Unzip the archive and put the giweather folder into your plugins folder (/wp-content/plugins/).
   2. In the administrative interface of Wordpress go to **Plugin** and activate giWeather;
   3. Click on **Appearance > Widgets** from the main navigation menu in your Dashboard;
   4. Add giWeather widgets from the Available Widgets section by dragging it to the Sidebar you want to customize;
   5. Configure the widget and save it. 

For more information visit the documentation page at: http://giweather.gardainformatica.it/documentation-wordpress

== Frequently Asked Questions ==

= Error: OpenWeatherMap: unable to decode json: url http://api.openweathermap.org/data/2.5/forecast =

Starting from **9 October 2015** OpenWeatherMap requires a valid APPID for access. <a href="http://home.openweathermap.org/users/sign_up" target="_blank">Register a free account on OpenWeatherMap to receive a free App Id</a>; Once you have your App Id enter it in the configuration of giWeather in the field **OpenWeatherMap App Id**;

= I obtained an API key from OpenWeatherMap. Where do I put that key? =

Starting from **9 October 2015** OpenWeatherMap requires a valid APPID for access. <a href="http://home.openweathermap.org/users/sign_up" target="_blank">Register a free account on OpenWeatherMap to receive a free App Id</a>; Once you have your App Id enter it in the configuration of giWeather in the field **OpenWeatherMap App Id**;

= How can I find an OpenWeatherMap Locality Id of a country or city? =

1. Go to http://openweathermap.org/find
2. Search for your city;
3. Click the result correpondig to your city;
4. The ID is the last part of the url. Eg. If the url is http://openweathermap.org/city/3181554 then the corresponding ID is 3181554.

For more information visit the documentation page at: http://giweather.gardainformatica.it/documentation-wordpress

= NWS Weather.gov: ERROR:Point with latitude XXX longitude XXX is not on an NDFD grid =

Weather.gov REST service works only with USA latitude and longitude. To obtain the latitude and longitude of an American city you can use the external service http://mynasadata.larc.nasa.gov/latitudelongitude-finder/

For more information visit the documentation page at: http://giweather.gardainformatica.it/documentation-wordpress

= How can I place giWeather inside an article or page of Wordpress ? =

You can use the plugin https://wordpress.org/plugins/amr-shortcode-any-widget/

For more information visit the documentation page at: http://giweather.gardainformatica.it/documentation-wordpress

== Screenshots ==

1. Example of display of meteorological forecasts of temperatures and winds with giWeather. Forecast source: OpenWeatherMap, Icons: Google.
2. Example of display of meteorological forecasts with giWeather. Forecast source: OpenWeatherMap, Icons: Yahoo and Gk4.
3. Configuration options of giWeather widget (v1.1.0). More options to come.

== Changelog ==

= 1.5.1 =
 * Bugfix (forgot to add white icons)
 
= 1.5.0 =
 * Added weather.gov forecast source (USA only)

= 1.3.0 =
 * Added Unit of Measure selection: Imperial/British and Metric/International;
 * Added TimeZone Support;
 * Added Wind White Iconset;
 * Added Font Size selection: Small, Medium, Large;
 * Hidden paging when all forecasts are visible without scrolling;

= 1.2.0 =
 * Added AppId for OpenWeatherMap;
 * Added Color;
 * Added complete Albanian language thanks to Festim Krasniqi;

= 1.1.0 =
 * First Release of Wordpress version;
 * Added complete Dutch (NL) language thanks to Bert Lammerts van Bueren www.webdiezain.nl
 * Added frontend language: Russian, Spanish, Ukrainian, German, Portuguese, Romanian, Polish, Finnish, French, Bulgarian, Swedish, Chinese Traditional, Chinese Simplified, Turkish, Croatian, Catalan;

= 1.0.0 =
 * First Release (only Joomla)


== Upgrade Notice ==

= 1.5.1 =
Bugfix (forgot to add white icons)

= 1.5.0 =
This version of giWeather added support for National Weather Service weather.gov (USA only) forecast source

= 1.2.0 =
This version of giWeather added color, AppId for OpenWeatherMap and Albanian translation.

= 1.1.0 =
This version of giWeather adds support for various languages.