<?php
	/**
	 * Optimization
	 *
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 22.10.2018, Webcraftic
	 * @version 1.0
	 */

	/**
	 * AJAX обработчик массовой оптимизации изображений со страницы статистики
	 */
	add_action('wp_ajax_wio_process_images', function () {
		check_admin_referer('wio-iph');

		$cron_mode = (bool)WIO_Plugin::app()->request->request('cron_mode');
		$reset_current_error = (bool)WIO_Plugin::app()->request->request('reset_current_error');

		$media_library = new WIO_MediaLibrary();
		if ( $reset_current_error ) {
			$media_library->resetCurrentErrors(); // сбрасываем текущие ошибки оптимизации
		}

		if( $cron_mode ) {
			$cron_running = WIO_Plugin::app()->getOption('cron_running', false);
			if( $cron_running ) {
				WIO_Plugin::app()->updateOption('cron_running', false);
				WIO_Cron::stop();
			} else {
				WIO_Plugin::app()->updateOption('cron_running', true);
				WIO_Cron::start();
			}

			wp_send_json(true);
			die();
		}
		$max_process_per_request = 1;
		$optimized_data = $media_library->processUnoptimizedAttachments($max_process_per_request);

		// если изображения закончились - посылаем команду завершения
		if( $optimized_data['remain'] <= 0 ) {
			$optimized_data['end'] = true;
		}

		wp_send_json($optimized_data);
	});
