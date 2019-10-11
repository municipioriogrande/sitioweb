<?php
	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * Инструменты для оптмизации изображений
	 *
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 22.09.2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_OptimizationTools {

		/**
		 * Метод возвращает объект, отвечающий за оптимизацию изображений через API сторонних сервисов
		 *
		 * @return WIO_Image_Processor_Resmush
		 */
		public static function getImageProcessor()
		{
			$server = WIO_Plugin::app()->getOption('image_optimization_server', 'server_1');

			switch( $server ) {
				case 'server_1':
					require_once(WIO_PLUGIN_DIR . '/includes/classes/class.image-processor-resmush.php'); // resmush api
					return new WIO_Image_Processor_Resmush();
					break;
				case 'server_2':
					require_once(WIO_PLUGIN_DIR . '/includes/classes/class.image-processor-smushpro.php'); // smushpro api
					return new WIO_Image_Processor_Smushpro();
					break;
				/*case 'server_4':
					require_once(WIO_PLUGIN_DIR . '/includes/classes/class.image-processor-clearfy1.php'); // clearfy1 api
					return new WIO_Image_Processor_Clearfy1();
					break;*/
				case 'server_3':
					require_once(WIO_PLUGIN_DIR . '/includes/classes/class.image-processor-webcraftic.php'); // webcraftic api
					return new WIO_Image_Processor_Webcraftic();
					break;
			}
			
			require_once(WIO_PLUGIN_DIR . '/includes/classes/class.image-processor-resmush.php'); // resmush api
			return new WIO_Image_Processor_Resmush();
		}
	}
