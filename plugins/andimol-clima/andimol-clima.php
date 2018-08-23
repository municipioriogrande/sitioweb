<?php
/*
Plugin Name: Andimol Clima
Plugin URI: http://andimol.co/#
Description: Clima is a Wordpress widget that shows the weather forecast with a clean, clear and responsive style inspired by Google.
Author: David Gustavo Fernandez (fernandezd@gmail.com)
Version: 1.0
Author URI: http://andimol.co/
*/

class Andimol_Clima extends WP_Widget {
	// class constructor
	public function __construct() {
		$widget_ops = array( 
		'classname' => 'andimol_clima',
		'description' => 'A plugin for blog readers',
		);
		parent::__construct( 'andimol_clima', 'Andimol Clima', $widget_ops );	
	}
	
	// output the widget content on the front-end
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		
		wp_enqueue_style("andimol-clima-styles-font", plugin_dir_url( __FILE__ ) . "assets/fonts/meteocons/stylesheet.css", false, THEMEVERSION, "all");
		wp_enqueue_style("andimol-clima-styles", plugin_dir_url( __FILE__ ) . "assets/stylesheet.css", false, THEMEVERSION, "all");
		

		if( !empty($instance['ac_appid']) && !empty($instance['ac_id']) && !empty($instance['ac_lat']) && !empty($instance['ac_lon']) && is_array($instance) ){ 
			
			date_default_timezone_set('UTC');
			date_default_timezone_set("America/Argentina/Ushuaia");
			//date_default_timezone_set("America/Argentina/Buenos_Aires");
			setlocale(LC_ALL,"es_ES");
			
			/* ID de ciudad */
			$openweathermap_id 		= $instance['ac_id'];
			$openweathermap_lang 	= 'es';
			$openweathermap_api_id 	= $instance['ac_appid'];
			$openweathermap_lat 	= $instance['ac_lat'];
			$openweathermap_long 	= $instance['ac_lon'];
			$segundos_menos 		= 3600*3; //-3hs
			$status = '';
			
			// CONSULTAMOS CLIMA
			//$json_file = file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat='.$openweathermap_lat.'&lon='.$openweathermap_long.'&lang='.$openweathermap_lang.'&appid='.$openweathermap_api_id.'&units=metric');
			$url_ws = 'http://api.openweathermap.org/data/2.5/weather?lat='.$openweathermap_lat.'&lon='.$openweathermap_long.'&appid='.$openweathermap_api_id.'&';

			# JSON DE CLIMA FISICO LOCAL
			$name_file 	= dirname(__FILE__).'/json/data_clima.json';
			
			# Preguntamos si NO existe el archivo, si NO existe lo creamos
			if(!file_exists($name_file))
			{
				$vars = $this->makeClimaFile($url_ws);
				$status = 'Init';
			}
			else
			{
				clearstatcache();
				$hora 					= getdate();
				$segundos_menos 		= 3600*3; 									// Diferencia horaria (-3hs Argentina)
				$segundos_validos 		= 3600; 										// Segundos validos para el archivo (5 horas)
				$hora_actual 			= gmdate("H:i:s", ($hora[0]-$segundos_menos));	// Formateamos hora de sistema
				$hora_archivo 			= date("H:i:s.", filemtime($name_file));	// Formateamos hora de sistema
				$horas_resta 			= $this->normaliceFecha($hora_actual)-$this->normaliceFecha($hora_archivo);
				
				//echo normaliceFecha($hora_actual).'-'.normaliceFecha($hora_archivo).'<br>'."\r";
				//echo $horas_resta.'<='.$segundos_validos.'<br>'."\r";
				
				if($horas_resta<=$segundos_validos){
					$vars = json_decode(file_get_contents($name_file));
					$status = 'On time';
					//echo $horas_resta.'<='.$segundos_validos.'<br>'."\r";
					//echo normaliceFecha($hora_actual).'-'.normaliceFecha($hora_archivo).'<br>'."\r";
				}
				else
				{
					$vars = $this->makeClimaFile($url_ws);
					$status = 'Off time';
				}
			}
			
				
			if(is_object($vars))
			{
				$main 					= !empty($vars->main) ? $vars->main : '';
				$main_temp 				= !empty($main->temp) ? $main->temp : '';
				$main_pressure 			= !empty($main->pressure) ? $main->pressure : '';
				$main_humidity 			= !empty($main->humidity) ? $main->humidity : '';
				$main_temp_min 			= !empty($main->temp_min) ? $main->temp_min : '';
				$main_temp_max 			= !empty($main->temp_max) ? $main->temp_max : '';
				$main_visibility 		= !empty($main->visibility) ? $main->visibility : '';
				
				$wind 					= !empty($vars->wind) ? $vars->wind : '';
				$wind_speed				= !empty($wind->speed) ? $wind->speed : '';
				$wind_deg				= !empty($wind->deg) ? $wind->deg : '';
				$wind_gust				= !empty($wind->gust) ? $wind->gust : '';
				
				$weather 				= !empty($vars->weather) ? $vars->weather : '';
				$weather_id 			= !empty($weather['0']->id) ? $weather['0']->id : '';
				$weather_main 			= !empty($weather['0']->main) ? $weather['0']->main : '';
				$weather_description 	= !empty($weather['0']->description) ? $weather['0']->description : '';
				$weather_description 	= !empty($weather['0']->icon) ? $weather['0']->icon : '';
				
				$icon_clima = array(
					'200' => 'thunderstorm',
					'201' => 'thunderstorm',
					'202' => 'thunderstorm',
					'210' => 'thunderstorm',
					'211' => 'thunderstorm',
					'212' => 'thunderstorm',
					'221' => 'thunderstorm',
					'230' => 'thunderstorm',
					'231' => 'thunderstorm',
					'232' => 'thunderstorm',
					
					'300' => 'rain',
					'301' => 'rain',
					'302' => 'rain',
					'310' => 'rain',
					'311' => 'rain',
					'312' => 'rain',
					'313' => 'rain',
					'314' => 'rain',
					'321' => 'rain',
					
					'500' => 'rain',
					'501' => 'rain',
					'502' => 'rain',
					'503' => 'rain',
					'504' => 'rain',
					'511' => 'rain_and_snow',
					'520' => 'rain',
					'521' => 'rain',
					'522' => 'rain',
					'531' => 'rain',
					
					'600' => 'snow',
					'601' => 'snow',
					'602' => 'snow',
					'611' => 'rain_and_snow',
					'612' => 'rain_and_snow',
					'615' => 'rain_and_snow',
					'616' => 'rain_and_snow',
					'620' => 'rain_and_snow',
					'621' => 'snow',
					'622' => 'snow',
					
					'701' => 'smoke',
					'711' => 'smoke',
					'721' => 'smoke',
					'731' => 'smoke',
					'741' => 'smoke',
					'751' => 'smoke',
					'761' => 'smoke',
					'762' => 'smoke',
					'771' => 'smoke',
					'781' => 'smoke',
					
					'800' => 'sunny',
					
					'801' => 'sunny',
					'802' => 'cloudy',
					'803' => 'cloudly',
					'804' => 'cloudly',
					
					'900' => 'other',
					'901' => 'other',
					'902' => 'other',
					'903' => 'other',
					'904' => 'other',
					'905' => 'other',
					'906' => 'other',
					
					'951' => 'other',
					'952' => 'other',
					'953' => 'other',
					'954' => 'other',
					'955' => 'other',
					'956' => 'other',
					'957' => 'other',
					'958' => 'other',
					'959' => 'other',
					'960' => 'other',
					'961' => 'other',
					'962' => 'other',
				);
				
			
				# DATOS DEL WEBSERVICES
				$main 				= $vars->main;
				$temperatura 		= $main->temp;
				$temp_c 			= $temperatura - 273.15;
				$temp_f 			= 1.8 * ($temperatura - 273.15) + 32;
				$sunrise 			= $vars->sys->sunrise; 									// Hora en que amanece
				$sunset 			= $vars->sys->sunset; 									// Hora en que anochece
				$sunrise_tho_show 	= ($vars->sys->sunrise)-$segundos_menos; 				// Hora en que amanece -3 horas
				$sunset_tho_show 	= ($vars->sys->sunset)-$segundos_menos;					// Hora en que anochece -3 horas
				
				$retun_clima = '<div class="anndimol-temp" data-state="'.$status.'">';
				$retun_clima .= '	<div class="icon">';
				$retun_clima .= '		<i class="meteocons-'.$icon_clima[$weather_id].' size-64"></i>';
				$retun_clima .= '	</div>';
				
				$retun_clima .= '	<div class="current-temp">';
				$retun_clima .= '		<div class="current-temp-val">';
				$retun_clima .= '			<span>'.round($temp_c).'</span>';
				$retun_clima .= '		</div>';
				$retun_clima .= '		<div class="current-temp-metric">';
				$retun_clima .= '			<span>°C</span>';
				$retun_clima .= '		</div>';
				$retun_clima .= '	</div>';
				
				$retun_clima .= '	<div class="current-right">';
				$retun_clima .= '		<div class="current-text">Humedad: <span>'.$main_humidity.'%</span></div>';
				$retun_clima .= '		<div class="current-text">Presión: <span>'.$main_pressure.' hPa</span></div>';
				$retun_clima .= '		<div class="current-text">Viento: <span>'.$wind_speed.' km/h W</span></div>';
				$retun_clima .= '	</div>';
				
				$retun_clima .= '</div>';
				
				echo $retun_clima;
				
			}
			/*else
			{
				echo 'no es objeto';
			}*/

			
			
		}else{
			echo esc_html__( 'Falta configurar widget', 'text_domain' );	
		}
	
		echo $args['after_widget'];
		
	}

	// output the option form field in admin Widgets screen
	public function form( $instance ) {
		
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Title', 'text_domain' );
		
		echo $this->field_generic($instance,"ac_appid","",__("AC_GIWEATHER_OWM_APPID_LBL","giweather"),__("AC_GIWEATHER_OWM_APPID_DSC","giweather"),"text",'','','giw-ac_appid');

		echo $this->field_generic($instance,"ac_id","3833367",__("AC_GIWEATHER_OWM_ID_LBL","giweather"),__("AC_GIWEATHER_OWM_ID_DSC","giweather"),"text",'','<a style="margin-left:10px;" target="_blank" href="http://openweathermap.org/find">'.esc_html__("AC_GIWEATHER_FINDID",'giweather').'</a>','giw-ac_id');
		
		echo $this->field_generic($instance,"ac_lat","-54.801912",__("GIWEATHER_NWS_LAT_LBL","giweather"),__("GIWEATHER_NWS_LAT_DSC","giweather"),"text",'','<a style="margin-left:10px;" target="_blank" href="http://mynasadata.larc.nasa.gov/latitudelongitude-finder/">'.esc_html__("GIWEATHER_LATFINDER",'giweather').'</a>','giw-ac_lat');
		
		echo $this->field_generic($instance,"ac_lon","-68.302951",__("GIWEATHER_NWS_LON_LBL","giweather"),__("GIWEATHER_NWS_LON_DSC","giweather"),"text",'','','giw-ac_lon');
		
		$instance["amr_shortcode_any_widget"]='[do_widget id='.$this->id.' wrap=div]';
		echo $this->field_generic($instance,"amr_shortcode_any_widget",$instance["amr_shortcode_any_widget"],"amr shortcode any widget","amr shortcode any widget","text",' readonly="readonly" ','<a  target="_blank" href="https://wordpress.org/plugins/amr-shortcode-any-widget/">amr shortcode any widget</a>');

		
		
		/*?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
		<?php esc_attr_e( 'Title:', 'text_domain' ); ?>
		</label> 
		
		<input 
			class="widefat" 
			id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
			name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" 
			type="text" 
			value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php*/
	}

	// save options
	//public function update( $new_instance, $old_instance ) {}
	
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $new_instance;
		
		$new_instance_title = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance_title['title']);

		return $instance;		
	}
	
	// AUXILIARES
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
	
	public function makeClimaFile($url_ws)
	{
		$json_data 	= file_get_contents($url_ws);
		$vars 		= json_decode($json_data);
		$name_file 	= dirname(__FILE__).'/json/data_clima.json';
			
		if(is_object($vars))
		{
			# Eliminamos archivo
			if(file_exists($name_file)){
				@unlink($name_file);
			}
	
			# Creamos archivo
			$fp = fopen($name_file,"w");
			if($fp != false){
				fwrite($fp, $json_data);
				fclose($fp);
			}
			
			return $vars;
		}
	}
	
	public function normaliceFecha($valor)
	{
		list($h, $m, $s) 			= array_pad(preg_split('/[^\d]+/', $valor), 3, 0);
		$retorno 					= 3600*$h + 60*$m + $s;
		
		return $retorno;
	}
}

// register Andimo_Clima
add_action( 'widgets_init', function(){
	register_widget( 'Andimol_Clima' );
});

?>