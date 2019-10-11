<?php

	// Exit if accessed directly
	if( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Класс для оптимизации изображений через API сервиса clearfy.pro
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_Image_Processor_Clearfy1 extends WIO_Image_Processor_Abstract {
		
		/**
		* @var string
		*/
		protected $api_url;

		public function __construct() {
			// Получаем ссылку на сервер 4
			$this->api_url = wbcr_rio_get_server_url('server_4');
		}
		
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
			
			$session_id = $this->generateRandomString( 16 );
			$file_id = 'o_' . $this->generateRandomString( 28 );
			$upload_url = $this->api_url . '/upload/' . $session_id . '/';
			$query = array(
				'id' => $file_id,
				// preg_replace('/^.+[\\\\\\/]/', '', $original_file)
				'name' => basename( $params['image_path'] ),
			);
			if ( function_exists( 'curl_version' ) ) {
				$filename = $params['image_path'];
				$finfo = new \finfo(FILEINFO_MIME_TYPE);
				$mimetype = $finfo->file($filename);

				$ch = curl_init($upload_url);
				//preg_replace('/^.+[\\\\\\/]/', '', $original_file)
				$cfile = curl_file_create($filename, $mimetype, basename($filename));
				//preg_replace('/^.+[\\\\\\/]/', '', $original_file)
				$data = ['file' => $cfile, 'name' => basename($filename), 'id' => $file_id];

				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				//curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$responce = curl_exec($ch);
				$r = curl_getinfo($ch);
				if( $r["http_code"] != 200 ) {
					$responce = new WP_Error( 'http_error', 'http error' );
				} else {
					
				}
			} else {
				return new WP_Error( 'http_error', 'curl need' );
			}
			$optimized_image_data = array();
			if ( is_wp_error( $responce ) ) {
				$optimized_image_data = $responce;
			} else {
				//$responce = json_decode( $responce );
				$compress_url = $this->api_url . '/compress/' . $session_id . '/' . $file_id . '?quality=' . $params['quality' ] . '&rnd=0.' . rand(11111111, 99999999);
				$status_url = $this->api_url . '/status/' . $session_id . '/' . $file_id . '?rnd=0.' . rand(11111111, 99999999);
				$compr = $this->request( $compress_url );
				if ( is_wp_error( $responce ) ) {
					return $responce;
				}
				sleep(3); // даём время на конвертацию
				$optimized_url = '';
				for( $i = 0; $i <= 3; $i++ ) {
					$req = $this->request( $status_url );
					$r = json_decode( $req );
					if ( isset( $r->compress_progress ) and $r->compress_progress == 100 ) {
						$optimized_url = $this->api_url . $r->compressed_url;
						break;
					}
					sleep(1); // ждём ещё секунду
				}
				$optimized_image_data = array(
					'optimized_img_url' => $optimized_url,
					'src_size'          => 0,
					'optimized_size'    => 0,
					'optimized_percent' => 0,
				);
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
		
		public function generateRandomString( $length = 10 ) {
			$characters = '0123456789abcdefghiklmnopqrstuvwxyz';
			$charactersLength = strlen( $characters );
			$randomString = '';
			for ( $i = 0; $i < $length; $i++ ) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
	}
