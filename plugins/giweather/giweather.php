<?php
/**
 * Plugin Name: giWeather
 * Plugin URI: htto://giweather.gardainformatica.it
 * Description: giWeather is a Wordpress widget that shows the weather forecast with a clean, clear and responsive style inspired by Google.
 * Version: 1.5.1
 * Author: Garda Informatica
 * Author URI: http://www.gardainformatica.it
 * License: GPL3
 */

/*  Copyright 2015  Garda Informatica  (email: info@gardainformatica.it)

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

if( ! defined( 'GIWEATHER_VERSION' ) ) {
	define( 'GIWEATHER_VERSION', '1.5.1' );
}


define('GIW_INSTALL_JEXEC',true);
define('GIW_INSTALL_PLUGIN_PATH',plugin_dir_path( __FILE__ ));
define('GIW_INSTALL_PLUGIN_FILE', __FILE__ );
require_once GIW_INSTALL_PLUGIN_PATH.'install.php';

add_action( 'widgets_init', 'register_giweather_widget' );
add_action('plugins_loaded', 'giweather_plugins_loaded');
function giweather_plugins_loaded(){
	load_plugin_textdomain('giweather', FALSE, dirname(plugin_basename(__FILE__)).'/extras/lib_giweather/language');
	load_textdomain('giweather', plugin_dir_path( __FILE__ ) .'extras/lib_giweather/language/giweather-en_GB.mo');//fallback to english
}

function register_giweather_widget() {
    register_widget( 'giWeather' );
}

class giWeather extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		
		parent::__construct(
					'giweather', // Base ID
					__( 'COM_GIWEATHER', 'giweather' ), // Name
					array( 'description' => __( 'COM_GIWEATHER_DESCRIPTION', 'giweather' ), ) // Args
				);
				
				
		if ( is_admin() ) {
			add_action( 'wp_ajax_giweather_load_forecast_json',  array($this,'giweather_load_forecast_json_callback') );
			add_action( 'wp_ajax_nopriv_giweather_load_forecast_json', array($this, 'giweather_load_forecast_json_callback') );
		}

	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		$module = new stdClass;
		$module->id=$args['widget_id'];
		$module->number=$this->number;
		$params= new giWeatherParams($instance);
		
		define('GIW_JEXEC',true);
		define('GIW_PLUGIN_PATH',plugin_dir_path( __FILE__ ));
		define('GIW_PLUGIN_FILE', __FILE__ );
		
		
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		
		require GIW_PLUGIN_PATH."extras/mod_giweather/mod_giweather.php";
		
		echo $args['after_widget'];		
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		wp_enqueue_style( 'wp-color-picker' ); 
		wp_enqueue_script('giweather-form',plugins_url( '/extras/lib_giweather/js/giweather-form.js' , __FILE__ ),	array( 'jquery', 'wp-color-picker' ),GIWEATHER_VERSION);
		
		echo '<div class="widget-giweather-start"></div>';
		
		//Title
		$instance_title = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance_title['title'];
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
		
		//End Title
		
		echo $this->field_list($instance,"source","owm",__("GIWEATHER_SOURCE_LBL","giweather"),__("GIWEATHER_SOURCE_DSC","giweather"),array(
			'owm'=>'OpenWeatherMap (Worldwide)',
			'nws'=>'National Weather Service weather.gov (only USA)',
			//'meteoam'=>'Meteo Aeronautica Militare (only Italy)'
		),' onchange="OnGIWAllSourceChange()" ','','giw-source');
		
		echo $this->field_generic($instance,"meteoam_id","91/brescia",__("GIWEATHER_METEOAM_ID_LBL","giweather"),__("GIWEATHER_METEOAM_ID_DSC","giweather"),"text",'','<a style="margin-left:10px;" target="_blank" href="http://www.meteoam.it/?regione=italia&amp;timespread=prev">'.esc_html__("GIWEATHER_FINDID",'giweather').'</a>','giw-meteoam_id');

		echo $this->field_generic($instance,"nws_lat","37.465578",__("GIWEATHER_NWS_LAT_LBL","giweather"),__("GIWEATHER_NWS_LAT_DSC","giweather"),"text",'','<a style="margin-left:10px;" target="_blank" href="http://mynasadata.larc.nasa.gov/latitudelongitude-finder/">'.esc_html__("GIWEATHER_LATFINDER",'giweather').'</a>','giw-nws_lat');
		
		echo $this->field_generic($instance,"nws_lon","-122.186121",__("GIWEATHER_NWS_LON_LBL","giweather"),__("GIWEATHER_NWS_LON_DSC","giweather"),"text",'','','giw-nws_lon');
		
		echo $this->field_generic($instance,"owm_appid","",__("GIWEATHER_OWM_APPID_LBL","giweather"),__("GIWEATHER_OWM_APPID_DSC","giweather"),"text",'','','giw-owm_appid');

		echo $this->field_generic($instance,"owm_id","2643743",__("GIWEATHER_OWM_ID_LBL","giweather"),__("GIWEATHER_OWM_ID_DSC","giweather"),"text",'','<a style="margin-left:10px;" target="_blank" href="http://openweathermap.org/find">'.esc_html__("GIWEATHER_FINDID",'giweather').'</a>','giw-owm_id');

		echo $this->field_list($instance,"owm_lang","en",__("GIWEATHER_OWM_LANG_LBL","giweather"),__("GIWEATHER_OWM_LANG_DSC","giweather"),array(
			'en'=>'English',
			'ru'=>'Russian',
			'it'=>'Italian',
			'es'=>'Spanish', 
			'uk'=>'Ukrainian',
			'de'=>'German',
			'pt'=>'Portuguese',
			'ro'=>'Romanian',
			'pl'=>'Polish',
			'fi'=>'Finnish',
			'nl'=>'Dutch',
			'fr'=>'French',
			'bg'=>'Bulgarian',
			'sv'=>'Swedish',
			'zh_tw'=>'Chinese Traditional',
			'zh'=>'Chinese Simplified',
			'tr'=>'Turkish',
			'hr'=>'Croatian',
			'ca'=>'Catalan'
		),'','','giw-owm_lang');
		
		
		echo $this->field_list($instance,"unitofmeasure","metric",__("GIWEATHER_UNIT_OF_MEASURE_LBL","giweather"),__("GIWEATHER_UNIT_OF_MEASURE_DSC","giweather"),array(
			'metric'=>__('GIWEATHER_UNIT_OF_MEASURE_METRIC','giweather'),
			'imperial'=>__('GIWEATHER_UNIT_OF_MEASURE_IMPERIAL','giweather'),
		));
		
		$timezones_list=timezone_identifiers_list();
		$associative_tz=array(
			''=>__('JOPTION_USE_DEFAULT','giweather'),
		);
		foreach ($timezones_list as $tz) {
			$associative_tz[$tz]=$tz;
		}
		
		echo $this->field_list($instance,"timezone","",__("GIWEATHER_TIMEZONE_LBL","giweather"),__("GIWEATHER_TIMEZONE_DSC","giweather"),$associative_tz);
				
		echo $this->field_generic($instance,"bgcolor","",__("GIWEATHER_BG_COLOR_LBL","giweather"),__("GIWEATHER_BG_COLOR_DSC","giweather"),"text",'','','giw-bgcolor');

		echo $this->field_list($instance,"font_size","medium",__("GIWEATHER_FONT_SIZE_LBL","giweather"),__("GIWEATHER_FONT_SIZE_DSC","giweather"),array(
			'small'=>__('GIWEATHER_FONT_SIZE_SMALL','giweather'),
			'medium'=>__('GIWEATHER_FONT_SIZE_MEDIUM','giweather'),
			'large'=>__('GIWEATHER_FONT_SIZE_LARGE','giweather'),
		));
		
		echo $this->field_list($instance,"show_head_details","1",__("GIWEATHER_SHOW_HEAD_DETAILS_LBL","giweather"),__("GIWEATHER_SHOW_HEAD_DETAILS_DSC","giweather"),array('1'=>__("JSHOW","giweather"),'0'=>__("JHIDE","giweather")));
		echo $this->field_list($instance,"show_right_details","1",__("GIWEATHER_SHOW_RIGHT_DETAILS_LBL","giweather"),__("GIWEATHER_SHOW_RIGHT_DETAILS_DSC","giweather"),array('1'=>__("JSHOW","giweather"),'0'=>__("JHIDE","giweather")));
		echo $this->field_list($instance,"show_forecasts","1",__("GIWEATHER_SHOW_FORECASTS_LBL","giweather"),__("GIWEATHER_SHOW_FORECASTS_DSC","giweather"),array('1'=>__("JSHOW","giweather"),'0'=>__("JHIDE","giweather")));
		echo $this->field_list($instance,"show_forecasts_tempwind","1",__("GIWEATHER_SHOW_FORECASTS_TEMPWIND_LBL","giweather"),__("GIWEATHER_SHOW_FORECASTS_TEMPWIND_DSC","giweather"),array('1'=>__("JSHOW","giweather"),'0'=>__("JHIDE","giweather")));

		echo $this->field_generic($instance,"widget_max_width","475",__("GIWEATHER_WIDGET_MAX_WIDTH_LBL","giweather"),__("GIWEATHER_WIDGET_MAX_WIDTH_DSC","giweather"));
		
		echo $this->field_list($instance,"widget_max_width_mu","px",__("GIWEATHER_WIDGET_MAX_WIDTH_MU_LBL","giweather"),__("GIWEATHER_WIDGET_MAX_WIDTH_MU_DSC","giweather"),array(
			'px'=>'px',
			'%'=>'%'
		));
		echo $this->field_list($instance,"widget_align","center",__("GIWEATHER_WIDGET_ALIGN_LBL","giweather"),__("GIWEATHER_WIDGET_ALIGN_DSC","giweather"),array(
			'center'=>__('GIWEATHER_WIDGET_ALIGN_CENTER','giweather'),
			'left'=>__('GIWEATHER_WIDGET_ALIGN_LEFT','giweather'),
			'right'=>__('GIWEATHER_WIDGET_ALIGN_RIGHT','giweather')
		));

		echo $this->field_generic($instance,"city_name","",__("GIWEATHER_CITY_NAME_LBL","giweather"),__("GIWEATHER_CITY_NAME_DSC","giweather"));
		echo $this->field_generic($instance,"cache_lifetime","60",__("GIWEATHER_CACHE_LIFETIME_LBL","giweather"),__("GIWEATHER_CACHE_LIFETIME_DSC","giweather"));
		
		
		echo $this->field_list($instance,"iconset","forecast_font",__("GIWEATHER_ICONSET_LBL","giweather"),__("GIWEATHER_ICONSET_DSC","giweather"),array(
			'forecast_font'=>'Iconvault Forecast (font)',
			'meteocons_font'=>'Meteocons (font)',
			'meteocons_dark'=>'Meteocons dark (img)',
			'meteocons_light'=>'Meteocons light (img)',
			'gk4'=>'gk4 (img)',
			'meteoam'=>'MeteoAM (img, external)',
			'owm'=>'OpenWeatherMap (img, external)',
			'yahoo'=>'Yahoo (img, external)',
			'google'=>'Google (img, external)'
		));
		
		echo $this->field_list($instance,"wind_iconset","giweather",__("GIWEATHER_WIND_ICONSET_LBL","giweather"),__("GIWEATHER_WIND_ICONSET_DSC","giweather"),array(
			'giweather'=>'giWeather Black (img)',
			'giweather-white'=>'giWeather White (img)',
			'meteoam'=>'MeteoAM (img, external)'
		));
	
		echo $this->field_generic($instance,"num_forecast","23",__("GIWEATHER_NUM_FORECAST_LBL","giweather"),__("GIWEATHER_NUM_FORECAST_DSC","giweather"));

		$instance["amr_shortcode_any_widget"]='[do_widget id='.$this->id.' wrap=div]';
		echo $this->field_generic($instance,"amr_shortcode_any_widget",$instance["amr_shortcode_any_widget"],"amr shortcode any widget","amr shortcode any widget","text",' readonly="readonly" ','<a  target="_blank" href="https://wordpress.org/plugins/amr-shortcode-any-widget/">amr shortcode any widget</a>');


		echo $this->field_generic($instance,"custom_css","",__("GIWEATHER_CUSTOM_CSS_LBL","giweather"),__("GIWEATHER_CUSTOM_CSS_DSC","giweather"),"textarea");
		echo $this->field_generic($instance,"moduleclass_sfx","",__("COM_MODULES_FIELD_MODULECLASS_SFX_LABEL","giweather"),__("COM_MODULES_FIELD_MODULECLASS_SFX_DESC","giweather"));

		//[do_widget id=giweather-3]
		//echo '<p><a target="_blank" href="https://wordpress.org/plugins/amr-shortcode-any-widget/">amr shortcode any widget</a>:<br/> [do_widget id='.$this->id.']</p>';

		
		echo $this->field_list($instance,"show_credits","0",__("GIWEATHER_SHOWCREDITS_LBL","giweather"),__("GIWEATHER_SHOWCREDITS_DSC","giweather"),array(
			'1'=>__("JSHOW","giweather"),
			'0'=>__("JHIDE","giweather")
		));
		
		
	}
	public function field_generic($instance, $name, $default, $label, $desc, $type="text",$other='', $html_after='',$class=''){
		$current_value=isset($instance[$name])?$instance[$name]:$default;
		
		$html=array();
		$html[]='<p>';
		$html[]='<label title="'.esc_attr($desc).'" for="'.$this->get_field_id($name).'">'.esc_html($label).'</label> ';
		if ($type=='textarea'){
			$class_html='';
			if (!empty($class)){
				$class_html=' class="'.$class.'" ';
			}
			
			$html[]='<textarea '.$class_html.' row="5" cols="10" class="widefat" id="'.$this->get_field_id($name).'" name="'.$this->get_field_name($name).'" type="'.$type.'" '.$other.'>'.esc_html($current_value).'</textarea>';
		}else{
			$class_html=' class="widefat" ';
			if (!empty($class)){
				$class_html=' class="widefat '.$class.'" ';
			}
			$html[]='<input '.$class_html.' id="'.$this->get_field_id($name).'" name="'.$this->get_field_name($name).'" type="'.$type.'" value="'.esc_attr( $current_value ).'" '.$other.'>';
		}
		
		//$html[]='<p class="howto">'.esc_html($desc).'</p>';		
		$html[]=$html_after;
		$html[]='</p>';
		return implode("\n",$html);
	}
	public function field_list($instance, $name, $default, $label, $desc, $options, $other='', $html_after='',$class=''){
		$current_value=isset($instance[$name])?$instance[$name]:$default;
		
		$html=array();
		$html[]='<p>';
		$html[]='<label title="'.esc_attr($desc).'" for="'.$this->get_field_id($name).'">'.esc_html($label).'</label> ';
		$class_html='';
		if (!empty($class)){
			$class_html=' class="'.$class.'" ';
		}
		$html[]='<select '.$class_html.' id="'.$this->get_field_id($name).'" name="'.$this->get_field_name($name).'" '.$other.'>';
		
		foreach($options as $key=>$val){
			$selected='';
			if ($key==$current_value){
				$selected=' selected="selected" ';
			}
			$html[]='<option '.$selected.' value="'.esc_attr($key).'">'.esc_html($val).'</option>';
		}
		
		$html[]='</select>';
		//$html[]='<p class="howto">'.esc_html($desc).'</p>';		
		$html[]=$html_after;
		$html[]='</p>';
		return implode("\n",$html);
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $new_instance;
		
		$new_instance_title = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance_title['title']);

		return $instance;		
	}
	
	

	public function giweather_load_forecast_json_callback() {
		define('GIW_JEXEC',true);
		define('GIW_PLUGIN_PATH',plugin_dir_path( __FILE__ ));
		define('GIW_PLUGIN_FILE', __FILE__ );
		
		$number=intval($_POST['number']);
		
		$widget_options_all = get_option($this->option_name);
		if (!isset($widget_options_all[ $number ])){
			wp_die();
		}
		$options = $widget_options_all[ $number ];

		$params= new giWeatherParams($options);
		
		header('Content-type: application/json');

		require GIW_PLUGIN_PATH."extras/lib_giweather/json/giweather.php";

		wp_die(); // this is required to terminate immediately and return a proper response
	}	
}

class giWeatherParams{
	protected $options=array();
	public function __construct($options)
	{
		$this->options = $options;
		
	}
	public function get($name,$def=''){
		if (isset($this->options[$name])){
			return $this->options[$name];
		}
		return $def;
	}


}



