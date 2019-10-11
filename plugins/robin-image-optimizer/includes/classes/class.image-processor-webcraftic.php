<?php

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}
	
	/**
	 * Класс для оптимизации изображений через API сервиса webcraftic.com
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_Image_Processor_Webcraftic extends WIO_Image_Processor_Abstract {

		/**
		 * @var string
		 */
		protected $api_url;


		public function __construct() {
			// Получаем ссылку на сервер 3
			$this->api_url = wbcr_rio_get_server_url('server_3');
		}
		
		/**
		 * Оптимизация изображения
		 *
		 * @param array $params входные параметры оптимизации изображения
		 * @return array|WP_Error
		 */
		public function process($params)
		{
			/**
			 * @var array параметры оптимизации по умолчанию
			 */
			$default_params = array(
				'image_url' => '', // ссылка на исходное изображение
				'quality' => 100, // качество сжатия: 100 - максимальное, 0 - минимум
				'save_exif' => false, // сохранять ли EXIF данные
			);
			$params = wp_parse_args($params, $default_params);

			$query = array(
				'quality' => $params['quality']
			);
			
			if( !$params['save_exif'] ) {
				$query['strip'] = 'info';
			}

			// Создаем временное изображение с уникальным именем
			$backup = new WIO_Backup();
			$temp_attachment = $backup->createTempAttachment($params['image_path']);

			if( is_wp_error($temp_attachment) ) {
				return new WP_Error('create_temp_attachment_error', __('It is not possible to create a temporary file. Throw error ' . $temp_attachment->get_error_message(), 'robin-image-optimizer'));
			}

			$img_url = $temp_attachment['image_url'];

			$img_url = str_replace(array('http://', 'https://'), '', $img_url);
			$img_url = $this->api_url . '/' . $img_url . '?' . http_build_query($query);
			$responce = $this->request($img_url);
			
			$optimized_image_data = array();
			if( is_wp_error($responce) ) {
				$optimized_image_data = $responce;
			} else {
				$optimized_image_data = array(
					'optimized_img_url' => $responce,
					'src_size' => 0,
					'optimized_size' => 0,
					'optimized_percent' => 0,
					'not_need_download' => true,
				);
			}

			// Удаляем временное изображение
			if( file_exists($temp_attachment['image_path']) && !unlink($temp_attachment['image_path']) ) {
				$logger = new WIO_Logger();
				$logger->add(__('Failed to delete temporary file ' . $temp_attachment['image_path'], 'robin-image-optimizer'));
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
		public function quality($quality = 100)
		{
			if( $quality == 'normal' ) {
				return 90;
			}
			if( $quality == 'aggresive' ) {
				return 75;
			}
			if( $quality == 'ultra' ) {
				return 50;
			}

			return 100;
		}
	}
