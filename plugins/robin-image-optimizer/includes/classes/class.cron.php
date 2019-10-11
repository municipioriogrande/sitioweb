<?php

	// Exit if accessed directly
	if( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Класс для работы оптимизации по расписанию
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_Cron {
		
		/**
		 * Инициализация оптимизации по расписанию
		 */ 
		//public function __construct() {
			//$this->hooks();
			//$this->check();
		//}
		
		/**
		 * Подключение хуков
		 */
		public function initHooks() {
			add_filter( 'cron_schedules', array( $this, 'intervals' ) );
			add_action( 'wio_optimize_images', array( $this, 'process' ) );
		}
		
		/**
		 * Проверка текущего статуса cron задачи и синхронизация с кнопкой в настройках.
		 * Включение и выключение cron задачи в зависимости от настроек
		 */
		public static function check() {
			$is_cron_mode = WIO_Plugin::app()->getOption( 'image_autooptimize_mode', false );
			$cron_running = WIO_Plugin::app()->getOption( 'cron_running', false );

			if ( $is_cron_mode and $cron_running ) {
				self::start();
			} else {
				self::stop();
			}
		}
		
		/**
		 * Кастомные интервалы выполнения cron задачи
		 * 
		 * @param array $intervals Зарегистророванные интервалы
		 * 
		 * @return array $intervals Новые интервалы
		 */
		public function intervals( $intervals ) {
			$intervals['wio_1_min'] = array(
				'interval' => 60, 
				'display' => __( '1 min', 'robin-image-optimizer' ),
			);
			$intervals['wio_2_min'] = array(
				'interval' => 60 * 2, 
				'display' => __( '2 min', 'robin-image-optimizer' ),
			);
			$intervals['wio_5_min'] = array(
				'interval' => 60 * 5, 
				'display' => __( '5 min', 'robin-image-optimizer' ),
			);
			$intervals['wio_10_min'] = array(
				'interval' => 60 * 10, 
				'display' => __( '10 min', 'robin-image-optimizer' ),
			);
			$intervals['wio_30_min'] = array(
				'interval' => 60 * 30, 
				'display' => __( '30 min', 'robin-image-optimizer' ),
			);
			$intervals['wio_hourly'] = array(
				'interval' => 60 * 60, 
				'display' => __( '60 min', 'robin-image-optimizer' ),
			);
			$intervals['wio_daily'] = array(
				'interval' => 60 * 60 * 24, 
				'display' => __( 'daily', 'robin-image-optimizer' ),
			);
			return $intervals;
		}
		
		/**
		 * Запуск задачи
		 */
		public static function start() {
			$interval = WIO_Plugin::app()->getOption( 'image_autooptimize_shedule_time' , 'wio_5_min' );

			if ( ! wp_next_scheduled( 'wio_optimize_images' ) ) {
				wp_schedule_event( time(), $interval, 'wio_optimize_images' );
			}
		}
		
		/**
		 * Остановка задачи
		 */
		public static function stop() {
			if ( wp_next_scheduled( 'wio_optimize_images' ) ) {
				wp_clear_scheduled_hook( 'wio_optimize_images' );
			}
		}
		
		/**
		 * Метод оптимизирует изображения при выполнении cron задачи
		 */
		public function process() {
			$max_process_per_request = WIO_Plugin::app()->getOption( 'image_autooptimize_items_number_per_interation' , 5 );
			$media_library = new WIO_MediaLibrary();
			$media_library->processUnoptimizedAttachments( $max_process_per_request );
		}
		
	}
