<?php

	// Exit if accessed directly
	if( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Класс для работы с wordpress attachment
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_Attachment {
		
		/**
		 * @var int 
		 */
		private $id;
		
		/**
		 * @var array meta-данные
		 */
		private $attachment_meta;
		
		/**
		 * @var array массив с данными о папке uploads
		 */
		private $wp_upload_dir;
		
		/**
		 * @var string
		 */
		private $url;
		
		/**
		 * @var string
		 */
		private $path;
		
		/**
		 * @var string
		 */
		private $backup_path = '';
		/**
		 * @var string
		 */
		private $backup_dir = '';
		
		/**
		 * Инициализация аттачмента
		 * 
		 * @param int $attachment_id Номер аттачмента из медиабиблиотеки
		 * @param array|false $attachment_meta метаданные аттачмента
		 */
		public function __construct( $attachment_id, $attachment_meta = false ) {
			$this->id = $attachment_id;
			$this->wp_upload_dir = wp_upload_dir();
			$this->attachment_meta = $attachment_meta;
			if ( ! $attachment_meta ) {
				$this->attachment_meta = wp_get_attachment_metadata( $this->id );
			}
			$this->url = $this->wp_upload_dir['baseurl'] . '/' . $this->attachment_meta['file'];
			$this->path = $this->wp_upload_dir['basedir'] . '/' . $this->attachment_meta['file'];
		}

		public function writeLog($message) {
			$error = PHP_EOL.'============================================'. PHP_EOL;
			$error .= $message. PHP_EOL;
			$error .= "[is_optimized] ". ($this->isOptimized() ? 'true' : 'false'). PHP_EOL;
			$error .= "[is_need_resize] ". ($this->isNeedResize() ? 'true' : 'false'). PHP_EOL;
			$error .= "[attachment_id] ".$this->id. PHP_EOL;
			$error .= "[image size] ".$this->attachment_meta['width'].'x'.$this->attachment_meta['height']. PHP_EOL;
			$error .= "[file] ".$this->attachment_meta['file']. PHP_EOL;

			foreach($this->attachment_meta['sizes'] as $size_type => $size_info) {
				$message .= "['.$size_type.'] ".$size_info['width'].'x'.$size_info['height']. PHP_EOL;
				$message .= "['.$size_type.'] ".$size_info['mime-type']. PHP_EOL;
			}
			$error .= PHP_EOL.'============================================'. PHP_EOL;

			$logger = new WIO_Logger();
			$logger->add( $error );
		}
		
		/**
		 * Оптимизация аттачмента
		 * 
		 * @param string $optimization_level уровень оптимизации изображения
		 */
		public function optimize( $optimization_level = '' ) {
			$errors_count    = 0;
			$optimized_count = 0;
			$original_size   = 0;
			$optimized_size  = 0;
			// сначала бекапим
			$is_image_backuped = $this->backup();
			
			if ( is_wp_error( $is_image_backuped ) ) {
				$error_msg = $is_image_backuped->get_error_message() . PHP_EOL;
				$this->writeLog( $error_msg );
				update_post_meta( $this->get( 'id' ), 'wio_backuped', 0 );
				
				return array(
					'errors_count'    => 1,
					'original_size'   => 0,
					'optimized_size'  => 0,
					'optimized_count' => 0,
				);
			}
			update_post_meta( $this->get( 'id' ), 'wio_backuped', $is_image_backuped );

			$original_main_size = filesize( $this->get( 'path' ) );
			// если файл большой - изменяем размер
			if ( $this->isNeedResize() ) {
				$this->resize();
			}

			$image_processor = WIO_OptimizationTools::getImageProcessor();

			if ( ! $optimization_level ) {
				$optimization_level = WIO_Plugin::app()->getOption( 'image_optimization_level' , 'normal' );
			}

			clearstatcache(); // на всякий случай очистим кеш файловой статистики

			$optimized_img_data = $image_processor->process( array(
				'image_url'   => $this->get( 'url' ), 
				'image_path'  => $this->get( 'path' ), 
				'quality'     => $image_processor->quality( $optimization_level ),
				'save_exif'   => WIO_Plugin::app()->getOption( 'save_exif_data' , false ),
			) );

			// проверяем на ошибку
			if ( is_wp_error( $optimized_img_data ) ) {
				$errors_count++;
				$error_msg = $optimized_img_data->get_error_message();
				$this->writeLog( $error_msg );
				update_post_meta( $this->get( 'id' ), 'wio_error', $error_msg );
				update_post_meta( $this->get( 'id' ), 'wio_current_error', 1 ); // флаг временной ошибки в пределах текущего цикла
				delete_post_meta( $this->get( 'id' ), 'wio_optimization_level' );
			} else {
				//скачиваем и заменяем картинку
				$image_downloaded = $this->replaceOriginalFile( $optimized_img_data );
				// некоторые провайдеры не отдают оптимизированный размер, поэтому после замены файла получаем его сами
				if ( ! $optimized_img_data['optimized_size'] ) {
					clearstatcache();
					$optimized_img_data['optimized_size'] = filesize( $this->get( 'path' ) );
				}
				if ( $image_downloaded ) {
					// оптимизируем дополнительные размеры
					$optimized_img_sizes_data = $this->optimizeImageSizes();
					//просчитываем статистику
					$original_size += $original_main_size;
					$optimized_size += $optimized_img_data['optimized_size'];
					$thumbnails_count = 0;
					
					// добавляем к статистике данные по оптимизации доп размеров
					if ( $optimized_img_sizes_data ) {
						$original_size += $optimized_img_sizes_data['original_size'];
						$optimized_size += $optimized_img_sizes_data['optimized_size'];
						$thumbnails_count = $optimized_img_sizes_data['thumbnails_count'];
					}
					update_post_meta( $this->get( 'id' ), 'wio_thumbnails_count', $thumbnails_count );
					update_post_meta( $this->get( 'id' ), 'wio_optimized_size', $optimized_size );
					update_post_meta( $this->get( 'id' ), 'wio_original_size', $original_size );
					update_post_meta( $this->get( 'id' ), 'wio_original_main_size', $original_main_size );
					update_post_meta( $this->get( 'id' ), 'wio_optimization_level', $optimization_level );
					
					delete_post_meta( $this->get( 'id' ), 'wio_error' );
					delete_post_meta( $this->get( 'id' ), 'wio_current_error' );
				} else {
					$errors_count++;
					$error_msg = __( 'Failed to get optimized image from remote server', 'robin-image-optimizer' );
					$this->writeLog( $error_msg );
					update_post_meta( $this->get( 'id' ), 'wio_error', $error_msg );
				}
			}
			update_post_meta( $this->get( 'id' ), 'wio_optimized', 1 );
			
			return array(
				'errors_count'    => $errors_count,
				'original_size'   => $original_size,
				'optimized_size'  => $optimized_size,
				'optimized_count' => $optimized_count,
			);
		}
		
		/**
		 * Метод проверяет, оптимизирован ли аттачмент
		 * 
		 * @return bool
		 */
		public function isOptimized() {
			$optimized = get_post_meta( $this->get( 'id' ), 'wio_optimized', true );
			if ( ! $optimized ) {
				return false;
			}
			return true;
		}
		
		/**
		 * Возвращает все размеры аттачмента, которые нужно оптимизировать
		 * 
		 * @return array
		 */
		public function getAllowedSizes() {
			$allowed_sizes = WIO_Plugin::app()->getOption( 'allowed_sizes_thumbnail' , 'thumbnail,medium' );
			if ( ! $allowed_sizes ) {
				return false;
			}
			$allowed_sizes = explode( ',', $allowed_sizes );
			return $allowed_sizes;
		}
		
		/**
		 * Оптимизация других размеров аттачмента
		 */
		public function optimizeImageSizes() {
			$allowed_sizes = $this->getAllowedSizes();
			if ( ! $allowed_sizes ) {
				return false;
			}
			
			$image_processor = WIO_OptimizationTools::getImageProcessor();
			$quality = WIO_Plugin::app()->getOption( 'image_optimization_level' , 'normal' );
			$exif = WIO_Plugin::app()->getOption( 'save_exif_data' , false );
			
			$original_size  = 0;
			$optimized_size = 0;
			$errors_count   = 0;
			$optimized_count = 0;
			foreach ( $allowed_sizes as $image_size ) {
				$url = $this->getImageSizeUrl( $image_size );
				$path = $this->getImageSizePath( $image_size );
				if ( ! $url or ! $path ) {
					continue;
				}
				$original_file_size = 0;
				if ( is_file( $path ) ) {
					$original_file_size = filesize( $path );
				}
				$optimized_img_data = $image_processor->process( array(
					'image_url'   => $url, 
					'image_path'  => $path, 
					'quality'     => $image_processor->quality( $quality ),
					'save_exif'   => $exif,
				) );
				// проверяем на ошибку
				if ( is_wp_error( $optimized_img_data ) ) {
					$errors_count++;
				} else {
					//скачиваем и заменяем картинку
					$this->replaceOriginalFile( $optimized_img_data, $image_size );
					// некоторые провайдеры не отдают оптимизированный размер, поэтому после замены файла получаем его сами
					if ( ! $optimized_img_data['optimized_size'] ) {
						clearstatcache();
						$optimized_img_data['optimized_size'] = filesize( $path );
					}
					if ( ! $optimized_img_data['src_size'] ) {
						$optimized_img_data['src_size'] = $original_file_size;
					}
					
					//просчитываем статистику
					$original_size += $optimized_img_data['src_size'];
					$optimized_size += $optimized_img_data['optimized_size'];
					$optimized_count++;
				}
			}
			return array(
				'errors_count'    => $errors_count,
				'original_size'   => $original_size,
				'optimized_size'  => $optimized_size,
				'thumbnails_count' => $optimized_count
			);
		}
		
		/**
		 * Возвращает путь
		 * 
		 * @param string $image_size Размер(thumbnail, medium ... )
		 * @return string
		 */
		public function getPath( $image_size = '' ) {
			if ( ! $image_size ) {
				$path = $this->path;
			} else {
				$path = $this->getImageSizePath( $image_size );
			}
			return $path;
		}
		
		/**
		 * Заменяет оригинальный файл на оптимизированный
		 * 
		 * @param array $optimized_img_data результат оптимизации ввиде массива данных
		 * @param string $image_size Размер(thumbnail, medium ... )
		 */
		public function replaceOriginalFile( $optimized_img_data, $image_size = '' ) {
			$optimized_img_url = $optimized_img_data['optimized_img_url'];
			if ( isset( $optimized_img_data['not_need_download'] ) and $optimized_img_data['not_need_download'] ) {
				$optimized_file = $optimized_img_url;
			} else {
				$optimized_file = $this->remoteDownloadImage( $optimized_img_url );
			}
			if ( isset( $optimized_img_data['not_need_replace'] ) and $optimized_img_data['not_need_replace'] ) {
				// если картинка уже оптимизирована и провайдер её не может уменьшить - он может вернуть положительный ответ, но без самой картинки. В таком случае ничего заменять не надо
				return true; 
			}
			if ( ! $optimized_file ) {
				return false;
			}
			$attachment_size_path = $this->getPath( $image_size );
			if ( ! is_file( $attachment_size_path ) ) {
				return false;
			}

			file_put_contents( $attachment_size_path, $optimized_file );
			return true;
		}
		
		protected function remoteDownloadImage( $url ) {
			if ( ! function_exists( 'curl_version' ) ) {
				return file_get_contents( $url );
			}
			
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_HEADER, 0 );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_URL, $url );
			
			$image_body = curl_exec( $ch );
			$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
			if ( $http_code != '200' ) {
				$image_body = false;
			}
			curl_close( $ch );
			
			return $image_body;
		}
		
		/**
		 * Возвращает свойство аттачмента
		 * 
		 * @param string $property имя свойства
		 * @return mixed
		 */
		public function get( $property ) {
			if ( isset( $this->$property ) ) {
				return $this->$property;
			}
			return false;
		}
		
		/**
		 * Возвращает URL изображения по указанному размеру
		 * 
		 * @param string $size - размер изображения(thumbnail,medium,large...)
		 * @return string
		 */
		public function getImageSizeUrl( $size = 'thumbnail' ) {
			if ( ! isset( $this->attachment_meta['sizes'][ $size ] ) ) {
				return false;
			}
			$exploded = explode( '/', $this->url );
			$basename = array_pop( $exploded );
			$url = str_replace( $basename, $this->attachment_meta['sizes'][ $size ]['file'], $this->url );
			return $url;
		}
		
		/**
		 * Возвращает путь к изображению по указанному размеру
		 * 
		 * @param string $size - размер изображения(thumbnail,medium,large...)
		 * @return string
		 */
		public function getImageSizePath( $size = 'thumbnail' ) {
			if ( ! isset( $this->attachment_meta['sizes'][ $size ] ) ) {
				return false;
			}
			$exploded = explode( DIRECTORY_SEPARATOR, $this->path );
			$basename = array_pop( $exploded );
			$path = str_replace( $basename, $this->attachment_meta['sizes'][ $size ]['file'], $this->path );
			return $path;
		}
		
		/**
		 * Проверка необходимости делать рисайз
		 * 
		 */
		protected function isNeedResize() {
			$resize_large_images = WIO_Plugin::app()->getOption( 'resize_larger' , true );
			if ( ! $resize_large_images ) {
				return false;
			}
			$larger_side = 0;
			$resize_larger_side = WIO_Plugin::app()->getOption( 'resize_larger_w' , 1600 );
			
			if ( $this->attachment_meta['width'] >= $this->attachment_meta['height'] ) {
				$larger_side = $this->attachment_meta['width'];
			} else {
				$larger_side = $this->attachment_meta['height'];
			}
			// если большая сторона картинки меньше, чем задано в настройках, то не ризайзим.
			if ( $larger_side <= $resize_larger_side ) {
				return false;
			}
			return true;
		}
		
		/**
		 * Изменяет размер изображения
		 * 
		 */
		protected function resize() {
			$resize_larger_side = WIO_Plugin::app()->getOption( 'resize_larger_w' , 1600 );
			$image = wp_get_image_editor( $this->path );
			if ( ! is_wp_error( $image ) ) {
				$current_size = $image->get_size();
				$new_width = 0;
				$new_height = 0;
				// определяем большую сторону и по ней маштабируем
				if ( $current_size['width'] >= $current_size['height'] ) {
					$new_width = $resize_larger_side;
					$new_height = round( $current_size['height'] * $new_width / $current_size['width'] );
				} else {
					$new_height = $resize_larger_side;
					$new_width = round( $current_size['width'] * $new_height / $current_size['height'] );
				}

				// Информация для логирование ошибок
				// ---------
				$resize_error_log_info = '-----'. PHP_EOL;
				$resize_error_log_info .= '[origin_size: '.$current_size['width'].'x'.$current_size['height'].']'. PHP_EOL;
				$resize_error_log_info .= '[new_size: '.$new_width.'x'.$new_height.']'. PHP_EOL;
				$resize_error_log_info .= '[resize_larger_w: '.$resize_larger_side.']'. PHP_EOL;
				$resize_error_log_info .= '[path:'.$this->path.']'. PHP_EOL;
				$resize_error_log_info .= '-----'. PHP_EOL;
				// ---------

				$resize_result = $image->resize( $new_width, $new_height, false );

				if(is_wp_error($resize_result)) {
					$this->writeLog( 'Image resize error ('.$resize_result->get_error_messages().')' . PHP_EOL . $resize_error_log_info );
					return false;
				}

				$save_result = $image->save( $this->path );

				if(is_wp_error($save_result)) {
					$this->writeLog( 'Image resize error ('.$save_result->get_error_messages().')' . PHP_EOL . $resize_error_log_info );
					return false;
				}

				$this->attachment_meta['width'] = $new_width;
				$this->attachment_meta['height'] = $new_height;
				$this->attachment_meta['old_width'] = $current_size['width'];
				$this->attachment_meta['old_height'] = $current_size['height'];

				wp_update_attachment_metadata( $this->id, $this->attachment_meta );
			}
		}
		
		/**
		 * Делает резервную копию
		 * 
		 * @return true|WP_Error
		 */
		protected function backup() {
			$backup = new WIO_Backup();
			return $backup->backupAttachment( $this );
		}

		/**
		 * Восстанавливает файлы из резервной копии
		 * 
		 * @return true|WP_Error
		 */
		public function restore() {
			$backup = new WIO_Backup();
			return $backup->restoreAttachment( $this );
		}
		
		public function getMetaData() {
			return $this->attachment_meta;
		}
		
	}
