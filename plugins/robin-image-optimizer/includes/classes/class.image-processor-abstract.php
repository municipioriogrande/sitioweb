<?php

	// Exit if accessed directly
	if( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Базовый класс для обработки изображений через API сторонних сервисов
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	abstract class WIO_Image_Processor_Abstract {

		/**
		 * Оптимизация изображения
		 *
		 * @param array $params параметры оптимизации изображения
		 */
		abstract function process( $params );
		
		/**
		 * Качество изображения
		 * Метод конвертирует качество из настроек плагина в формат сервиса оптимизации
		 *
		 * @param mixed $quality качество
		 */
		abstract function quality( $quality );
		
		/**
		 * HTTP запрос к API стороннего сервиса
		 *
		 * @param $url URL для запроса
		 * @return string
		 */
		protected function request( $url, $post_fields = false, $headers = false ) {
			// проверяем, доступен ли CURL
			if ( function_exists( 'curl_version' ) ) {
				return $this->curlRequest( $url, $post_fields, $headers );
			} else {
				return file_get_contents( $url );
			}
		}
		
		/**
		 * HTTP запрос к API стороннего сервиса с использованием библиотеки CURL
		 *
		 * @param $url URL для запроса
		 * @return string|WP_Error
		 */
		protected function curlRequest( $url, $post_fields = false, $headers = false ) {
			$ch = curl_init();
			$timeout = 10;
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
			if ( $post_fields ) {
				curl_setopt( $ch, CURLOPT_POST, 1 );
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_fields );
			}
			if ( $headers ) {
				curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
			}
			$responce = curl_exec( $ch );

			if( curl_errno( $ch ) ) { 
				$responce = new WP_Error( 'http_error', curl_error( $ch ) );
			}
			$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
			if( $http_code != 200 ) {
				$responce = new WP_Error( 'http_error', 'http error code ' . $http_code );
			}
			curl_close( $ch );
			return $responce;
		}
		
	}
