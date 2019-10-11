<?php

	// Exit if accessed directly
	if( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Класс для работы со статистическими данными по оптимизации изображений
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_Image_Statistic {
		
		/**
		 * @var array
		 */
		protected $statistic;
		
		/**
		 * Инициализация статистики
		 */
		public function __construct() {
			$this->statistic = $this->load();
		}
		
		/**
		 * Возвращает статистические данные
		 * 
		 * @return array
		 */
		public function get() {
			return $this->statistic;
		}
		
		/**
		 * Добавляет новые данные к текущей статистике
		 * К текущим числам добавляются новые
		 * 
		 * @param string $field Поле, к которому добавляем значение
		 * @param int $value добавляемое значение
		 */
		public function addToField( $field, $value ) {
			if ( isset( $this->statistic[ $field ] ) ) {
				$this->statistic[ $field ] = $this->statistic[ $field ] + $value;
			}
		}
		
		/**
		 * Вычитает данные из текущей статистики
		 * Из текущего числа вычитается
		 * 
		 * @param string $field Поле, из которого вычитается значение
		 * @param int $value вычитаемое значение
		 */
		public function deductFromField( $field, $value ) {
			$value = (int)$value;
			if ( isset( $this->statistic[ $field ] ) ) {
				$this->statistic[ $field ] = $this->statistic[ $field ] - $value;
				if ( $this->statistic[ $field ] < 0 ) {
					$this->statistic[ $field ] = 0;
				}
			}
		}
		
		/**
		 * Сохранение статистики
		 */
		public function save() {
			WIO_Plugin::app()->updateOption( 'optimized_count', $this->statistic['optimized'] );
			WIO_Plugin::app()->updateOption( 'error_count', $this->statistic['error'] );
			WIO_Plugin::app()->updateOption( 'original_size', $this->statistic['original_size'] );
			WIO_Plugin::app()->updateOption( 'optimized_size', $this->statistic['optimized_size'] );
		}
		
		/**
		 * Загрузка статистики и расчёт некоторых параметров
		 * 
		 * @return array 
		 */
		public function load() {
			$original_size = WIO_Plugin::app()->getOption( 'original_size', 0 );
			$optimized_size = WIO_Plugin::app()->getOption( 'optimized_size', 0 );
			$args = array( 
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post_mime_type' => array( 'image/jpeg', 'image/gif', 'image/png' ),
				'numberposts'    => 1,
			);
			$unoptimized_args = array( 
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post_mime_type' => array( 'image/jpeg', 'image/gif', 'image/png' ),
				'posts_per_page' => 1,
				'meta_query'     => array(
					array(
						'key'     => 'wio_optimized',
						'compare' => 'NOT EXISTS',
					),
				)
			);
			$error_args = array( 
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post_mime_type' => array( 'image/jpeg', 'image/gif', 'image/png' ),
				'posts_per_page' => 1,
				'meta_query'     => array(
					array(
						'key'     => 'wio_error',
						'compare' => 'EXISTS',
					),
				)
			);
			$unoptimized_args = apply_filters( 'wio_unoptimized_args', $unoptimized_args );
			$total_query = new WP_Query( $args );
			$unoptimized_query = new WP_Query( $unoptimized_args );
			$error_query = new WP_Query( $error_args );
			$error_count = $error_query->found_posts;
			$total_images = $total_query->found_posts;
			$unoptimized = $unoptimized_query->found_posts;
			if ( $optimized_size and $original_size ) {
				$percent_diff = round( ( $original_size - $optimized_size ) * 100 / $original_size, 1 );
				$percent_diff_line = round( $optimized_size * 100 / $original_size, 0 );
			} else {
				$percent_diff = 0;
				$percent_diff_line = 100;
			}
			$optimized_exists_images_count = $total_images - $unoptimized - $error_count; // оптимизированные картинки, которые сейчас есть в медиабиблиотеке
			if ( $total_images ) {
				$optimized_images_percent = round( $optimized_exists_images_count * 100 / $total_images );
			} else {
				$optimized_images_percent = 0;
			}
			
			return array(
				'original'            => $total_images,
				'optimized'           => $optimized_exists_images_count,
				'optimized_percent'   => $optimized_images_percent,
				'percent_line'        => $percent_diff_line,
				'unoptimized'         => $unoptimized,
				'optimized_size'      => $optimized_size,
				'original_size'       => $original_size,
				'save_size_percent'   => $percent_diff,
				'error'               => $error_count,
			);
		}
		
		/**
		 * Пересчёт размера файла в байтах на человекопонятный вид
		 * 
		 * Пример: вводим 67894 байт, получаем 67.8 KB
		 * Пример: вводим 6789477 байт, получаем 6.7 MB
		 * @param int $size размер файла в байтах
		 * @return string 
		 */
		public function convertToReadableSize( $size ){
			if ( ! $size ) return 0;
			$base = log( $size ) / log( 1024 );
			$suffix = array( '', 'KB', 'MB', 'GB', 'TB' );
			$f_base = floor( $base );
			return round( pow( 1024, $base - floor( $base ) ), 2 ) . ' ' . $suffix[ $f_base ];
		}
		
	}
