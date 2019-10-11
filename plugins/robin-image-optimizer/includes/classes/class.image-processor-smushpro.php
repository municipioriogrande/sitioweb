<?php

	// Exit if accessed directly
	if( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Класс для оптимизации изображений через API сервиса smushpro.wpmudev.org
	 * @see https://smushpro.wpmudev.org/
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_Image_Processor_Smushpro extends WIO_Image_Processor_Abstract {
		
		/**
		* @var string
		*/
		protected $api_url = 'https://smushpro.wpmudev.org/1.0/';
		
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
				'save_exif'   => false, // сохранять ли EXIF данные
			);
			$params = wp_parse_args( $params, $default_params );
			$headers = array();
			if ( $params['save_exif'] ) {
				$headers[] = 'exif: true';
			}
			if ( function_exists( 'curl_version' ) ) {
				if ( ! is_file( $params['image_path'] ) ) {
					return new WP_Error( 'api_error', __( 'file not found', 'robin-image-optimizer' ) );
				}
				$img_file = file_get_contents( $params['image_path'] );
				$responce = $this->request( $this->api_url, $img_file, $headers );
			} else {
				return new WP_Error( 'curl_error', __( 'curl not work', 'robin-image-optimizer' ) );
			}
			$optimized_image_data = array();
			if ( is_wp_error( $responce ) ) {
				$optimized_image_data = $responce;
			} else {
				$responce = json_decode( $responce );
				if ( ! isset( $responce->success ) or ! $responce->success ) {
					$optimized_image_data = new WP_Error( 'api_error', $responce->data );
				} else {
					$image_data = isset( $responce->data->image ) ? base64_decode( $responce->data->image ) : false;
					$optimized_image_data = array(
						'optimized_img_url' => $image_data,
						'src_size'          => $responce->data->before_size,
						'optimized_size'    => $responce->data->after_size,
						'optimized_percent' => $responce->data->compression,
						'not_need_download' => true,
					);
					if ( ! $image_data ) {
						$optimized_image_data['not_need_replace'] = true;
					}
				}
			}
			
			return $optimized_image_data;
		}
		
		/**
		 * Качество изображения
		 * Для этого провайдера оно не применяется
		 *
		 * @param mixed $quality качество
		 * @return int
		 */
		public function quality( $quality = 100 ) {
			return 100;
		}
	}
