<?php

	// Exit if accessed directly
	if( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Класс для логирования ошибок
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_Logger {
		
		/**
		 * @var string
		 */
		private $log_file;
		
		/**
		 * @var string
		 */
		private $upload_dir;
		
		/**
		 * Инициализация логгера
		 */
		public function __construct() {
			$wp_upload_dir = wp_upload_dir();
			$this->upload_dir = $wp_upload_dir['basedir'];
			$this->log_file = $wp_upload_dir['basedir'] . '/wio.log';
		}
		
		/**
		 * Получает строку со всеми логами
		 *
		 * @return string
		 */
		public function get() {
			$log = '';
			if ( is_file( $this->log_file ) ) {
				$log = file_get_contents( $this->log_file );
			}
			return $log;
		}
		
		/**
		 * Добавляет сообщение в лог
		 *
		 * @param string $msg сообщение
		 */
		public function add( $msg ) {
			if ( ! $this->is_writable() ) {
				return false;
			}
			$msg = trim( $msg );
			$msg = date( 'd-m-Y H:i' ) . ' '. PHP_EOL . $msg;
			$msg .= PHP_EOL;
			file_put_contents( $this->log_file, $msg, FILE_APPEND );
			return true;
		}
		
		/**
		 * Очищает лог
		 */
		public function clear() {
			if ( ! $this->is_writable() ) {
				return false;
			}
			file_put_contents( $this->log_file, '' );
		}
		
		/**
		 * Проверка возможности записи в лог
		 *
		 * @return bool
		 */
		public function is_writable() {
			if ( is_file( $this->log_file ) and ! is_writable( $this->log_file ) ) {
				return false;
			}
			if ( ! is_writable( $this->upload_dir ) ) {
				return false;
			}
			return true;
		}
	}
