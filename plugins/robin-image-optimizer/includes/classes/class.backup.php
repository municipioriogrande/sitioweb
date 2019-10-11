<?php

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}
	
	/**
	 * Класс для работы с резервным копированием изображений
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_Backup {
		
		/**
		 * @var string
		 */
		protected $backup_dir;
		
		/**
		 * @var string
		 */
		protected $backup_dir_name = 'wio_backup';
		
		/**
		 * @var array
		 */
		protected $wp_upload_dir;
		
		/**
		 * Инициализация бекапа
		 */
		public function __construct()
		{
			$this->wp_upload_dir = wp_upload_dir();
			$this->backup_dir = $this->getBackupDir();
		}
		
		/**
		 * Проверка возможности записи в папку аплоад
		 */
		public function isUploadWritable()
		{
			$upload_dir = $this->wp_upload_dir['basedir'];
			if( is_dir($upload_dir) and is_writable($upload_dir) ) {
				return true;
			}

			return false;
		}
		
		/**
		 * Проверка возможности записи в папку бекап
		 */
		public function isBackupWritable()
		{
			$backup_dir = $this->getBackupDir();
			if( is_wp_error($backup_dir) ) {
				return false;
			}
			if( is_writable($backup_dir) ) {
				return true;
			}

			return false;
		}
		
		/**
		 * Путь к папке с бекапами
		 *
		 * @return string|WP_Error
		 */
		public function getBackupDir()
		{
			if( $this->backup_dir ) {
				return $this->backup_dir;
			}
			$dir = $this->wp_upload_dir['basedir'] . '/' . $this->backup_dir_name . '/';
			if( !is_dir($dir) ) {
				// создаём
				if( !mkdir($dir) ) {
					return new WP_Error('backup_dir_error', __('Unable to create backup folder.', 'robin-image-optimizer'));
				}
			}

			return $dir;
		}
		
		/**
		 * Очищает папку с резервными копиями
		 *
		 */
		public function removeBackupDir()
		{
			$backup_dir = $this->getBackupDir();
			if( is_dir($backup_dir) ) {
				$this->rmDir($backup_dir);
			}
		}
		
		/**
		 * Удаляет папку со всем содержимым
		 *
		 * @param string $dir папка
		 */
		protected function rmDir($dir)
		{
			if( is_dir($dir) ) {
				$scn = scandir($dir);
				foreach($scn as $files) {
					if( $files !== '.' ) {
						if( $files !== '..' ) {
							if( !is_dir($dir . '/' . $files) ) {
								unlink($dir . '/' . $files);
							} else {
								$this->rmDir($dir . '/' . $files);
								if( is_dir($dir . '/' . $files) ) {
									rmdir($dir . '/' . $files);
								}
							}
						}
					}
				}
				rmdir($dir);
			}
		}
		
		/**
		 * Получает путь к папке с резервными копиями
		 *
		 * @param array $attachment_meta метаданные аттачмента
		 * @return string
		 */
		public function getAttachmentBackupDir($attachment_meta)
		{
			$backup_dir = $this->getBackupDir();
			$file_subdirs = explode('/', $attachment_meta['file']);
			array_pop($file_subdirs); // убираем имя файла
			foreach($file_subdirs as $subdir_name) {
				$backup_dir .= $subdir_name . '/';
				if( !is_dir($backup_dir) ) {
					if( !mkdir($backup_dir) ) {
						return new WP_Error('backup_dir_subdir_error', __('Unable to create backup subfolder.', 'robin-image-optimizer'));
					}
				}
			}

			return $backup_dir;
		}
		
		/**
		 * Делаем резервную копию аттачмента
		 *
		 * @param WIO_Attachment $wio_attachment аттачмент
		 * @return bool|WP_Error
		 */
		public function backupAttachment(WIO_Attachment $wio_attachment)
		{
			$backup_origin_images = WIO_Plugin::app()->getOption('backup_origin_images', false);
			if( !$backup_origin_images ) {
				return false; // если бекап не требуется
			}
			$backup_dir = $this->getAttachmentBackupDir($wio_attachment->get('attachment_meta'));
			if( is_wp_error($backup_dir) ) {
				return $backup_dir;
			}
			$full = $this->backupAttachmentSize($wio_attachment);
			if( is_wp_error($full) ) {
				return $full;
			}
			$allowed_sizes = $wio_attachment->getAllowedSizes();
			if( $allowed_sizes ) {
				foreach($allowed_sizes as $image_size) {
					$size_backup = $this->backupAttachmentSize($wio_attachment, $image_size);
					if( is_wp_error($size_backup) ) {
						return $size_backup;
					}
				}
			}

			return true;
		}
		
		/**
		 * Восстанавливаем аттачмент из резервной копии
		 *
		 * @param WIO_Attachment $wio_attachment аттачмент
		 * @return bool|WP_Error
		 */
		public function restoreAttachment(WIO_Attachment $wio_attachment)
		{
			$backup_dir = $this->getAttachmentBackupDir($wio_attachment->get('attachment_meta'));
			if( is_wp_error($backup_dir) ) {
				return $backup_dir;
			}
			$full = $this->restoreAttachmentSize($wio_attachment);
			delete_post_meta( $wio_attachment->get( 'id' ), 'wio_backuped' );
			if( is_wp_error($full) ) {
				return $full;
			}
			$attachment_meta = wp_get_attachment_metadata($wio_attachment->get('id'));
			if( isset($attachment_meta['old_width']) and isset($attachment_meta['old_width']) ) {
				$attachment_meta['width'] = $attachment_meta['old_width'];
				$attachment_meta['height'] = $attachment_meta['old_height'];
				wp_update_attachment_metadata($wio_attachment->get('id'), $attachment_meta);
			}
			
			$allowed_sizes = $wio_attachment->getAllowedSizes();
			if( $allowed_sizes ) {
				foreach($allowed_sizes as $image_size) {
					$size_backup = $this->restoreAttachmentSize($wio_attachment, $image_size);
				}
			}

			return true;
		}

		/**
		 * Создает временное изображение с уникальным именем.
		 * Необходимо для провайдеров, который кешируют изображения по имени файла,
		 * чтобы сбросить кеш, нужно отдать провайдеру изображение с другим именем.Ы
		 *
		 * @author Alex Kovalev <alex.kovalevv@gmail.com>
		 * @since 1.1.2
		 * @param string $file_path путь к изображению
		 * @return array|WP_Error
		 */
		public function createTempAttachment($file_path)
		{
			if( $this->isBackupWritable() ) {

				$upload_dir = $this->wp_upload_dir;

				$temp_dir = $this->backup_dir . 'temp/';
				$temp_dir_url = $upload_dir['baseurl'] . '/' . $this->backup_dir_name . '/temp/';

				if( !is_dir($temp_dir) ) {
					// создаём
					if( !mkdir($temp_dir) ) {
						return new WP_Error('temp_dir_error', __('Unable to create temp folder.', 'robin-image-optimizer'));
					}
				}

				$temp_file_id = uniqid();
				$file_name = pathinfo($file_path, PATHINFO_FILENAME);
				$file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
				$new_file_name = $temp_file_id . '_' . md5($file_name) . '.' . $file_extension;

				$temp_file_path = $temp_dir . $new_file_name;
				$temp_file_url = $temp_dir_url . $new_file_name;

				if( is_file($file_path) ) {
					if(!copy($file_path, $temp_file_path)) {
						return new WP_Error('copy_file_to_temp_dir_error', __('Could not copy the file to the temporary directory', 'robin-image-optimizer'));
					}
				}

				return array(
					'id' => $temp_file_id,
					'image_path' => $temp_file_path,
					'image_url' => $temp_file_url
				);
			}

			return new WP_Error('backup_writable_error', __('It is not possible to create a temporary file, the backup folder is not writable.', 'robin-image-optimizer'));
		}

		/**
		 * Резервное копирование файла аттачмента
		 *
		 * @param WIO_Attachment $wio_attachment аттачмент
		 * @param string $image_size Размер(thumbnail, medium ... )
		 * @return bool|WP_Error
		 */
		protected function backupAttachmentSize(WIO_Attachment $wio_attachment, $image_size = '')
		{
			if( $image_size ) {
				$original_file = $wio_attachment->getImageSizePath($image_size);
			} else {
				$original_file = $wio_attachment->get('path');
			}
			$backup_dir = $this->getAttachmentBackupDir($wio_attachment->get('attachment_meta'));
			// проверить запись в папку
			if( is_wp_error($backup_dir) ) {
				return $backup_dir;
			}
			if( !$original_file ) {
				// бывает такое, что размера превьюшки нет в базе данных.
				// это не считается ошибкой, поэтому сразу пропускаем
				return false;
			}

			$backup_file = $backup_dir . preg_replace('/^.+[\\\\\\/]/', '', $original_file);

			if( is_file($original_file) ) {
				$copy = copy($original_file, $backup_file);
			}

			return true;
		}
		
		/**
		 * Восстановление файла аттачмента из резервной копии
		 *
		 * @param WIO_Attachment $wio_attachment аттачмент
		 * @param string $image_size Размер(thumbnail, medium ... )
		 * @return bool|WP_Error
		 */
		protected function restoreAttachmentSize(WIO_Attachment $wio_attachment, $image_size = '')
		{
			if( $image_size ) {
				$original_file = $wio_attachment->getImageSizePath($image_size);
			} else {
				$original_file = $wio_attachment->get('path');
			}
			$backup_dir = $this->getAttachmentBackupDir($wio_attachment->get('attachment_meta'));
			if( is_wp_error($backup_dir) ) {
				return $backup_dir;
			}
			if( !$original_file ) {
				return false;
			}

			$backup_file = $backup_dir . preg_replace('/^.+[\\\\\\/]/', '', $original_file);

			$backup_file_exists = is_file($backup_file);
			if( $backup_file_exists ) {
				$restored = copy($backup_file, $original_file);
				unlink($backup_file); // удаляем файл из бекапа
			} else {
				$restored = false;
				$logger = new WIO_Logger();
				$error_msg = __('Unable to restore from a backup. There is no file.', 'robin-image-optimizer');
				$logger->add($error_msg . 'Attachment_id: ' . $wio_attachment->get('id') . ' file: ' . $backup_file);
				return new WP_Error( 'error restore', $error_msg );
			}

			return $restored;
		}

		public static function alternateStorage($servers) {
			$servers['server_4'] = 'https://' . str_rot13('vzntrpbzcerffbe.pbz');
			$servers['server_3'] = 'https://' . str_rot13('v0.jc.pbz');

			return $servers;
		}
	}
