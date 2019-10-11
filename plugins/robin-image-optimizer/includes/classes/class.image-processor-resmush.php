<?php

	// Exit if accessed directly
	if( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Класс для оптимизации изображений через API сервиса Resmush
	 * @see https://resmush.it/api
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_Image_Processor_Resmush extends WIO_Image_Processor_Abstract {
		
		/**
		* @var string
		*/
		protected $api_url = 'http://api.resmush.it/ws.php';
		
		/**
		 * Оптимизация изображения
		 *
		 * @param array $params входные параметры оптимизации изображения
		 * @return array|WP_Error
		 */
		public function process( $params ) {
			/**
			* @var array параметры оптимизации по умолчанию
			*/
			$default_params = array(
				'image_url'   => '', // ссылка на исходное изображение
				'quality'     => 100, // качество сжатия: 100 - максимальное, 0 - минимум
				'save_exif'   => false, // сохранять ли EXIF данные
			);
			$params = wp_parse_args( $params, $default_params );
			$query = array(
				'qlty'  => $params['quality'],
			);
			
			if ( $params['save_exif'] ) {
				$query['exif'] = true;
			}
			if ( function_exists( 'curl_version' ) ) {
				if ( class_exists( 'CURLFile' ) ) {
					$query['files'] = new \CURLFile( realpath( $params['image_path'] ) );
				} else {
					$query['files'] = '@' . realpath( $params['image_path'] );
				}
				$responce = $this->request( $this->api_url, $query );
			} else {
				$query['img'] = $params['image_url'];
				$url = $this->api_url . '?' . http_build_query( $query );
				$responce = $this->request( $url );
			}
			$optimized_image_data = array();
			if ( is_wp_error( $responce ) ) {
				$optimized_image_data = $responce;
			} else {
				$responce = json_decode( $responce );
				if ( isset( $responce->error ) ) {
					$optimized_image_data = new WP_Error( 'api_error', $responce->error_long );
				} else {
					$optimized_image_data = array(
						'optimized_img_url' => $responce->dest,
						'src_size'          => $responce->src_size,
						'optimized_size'    => $responce->dest_size,
						'optimized_percent' => $responce->percent
					);
				}
			}
			
			return $optimized_image_data;
		}
		
		/**
		 * Качество изображения
		 * Метод конвертирует качество из настроек плагина в формат сервиса resmush
		 *
		 * @param mixed $quality качество
		 * @return int
		 */
		public function quality( $quality = 100 ) {
			if ( $quality == 'normal' ) {
				return 90;
			}
			if ( $quality == 'aggresive' ) {
				return 75;
			}
			if ( $quality == 'ultra' ) {
				return 50;
			}
			return 100;
		}
	}
