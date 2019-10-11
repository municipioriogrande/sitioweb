<?php
	/**
	 * Backup
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 22.10.2018, Webcraftic
	 * @version 1.0
	 */

	/**
	 * AJAX обработчик массовой оптимизации изображений со страницы статистики
	 */
	add_action('wp_ajax_wio_restore_backup', function () {
		check_admin_referer('wio-iph');

		$max_process_per_request = 5;
		$total = $_POST['total'];

		$media_library = new WIO_MediaLibrary();

		if( $total == '?' ) {
			$total = $media_library->getOptimizedCount();
		}
		$restored_data = $media_library->restoreAllFromBackup($max_process_per_request);

		$restored_data['total'] = $total;
		if( $total ) {
			$restored_data['percent'] = 100 - ($restored_data['remain'] * 100 / $total);
		} else {
			$restored_data['percent'] = 0;
		}

		// если изображения закончились - посылаем команду завершения
		if( $restored_data['remain'] <= 0 ) {
			$restored_data['end'] = true;
		}
		wp_send_json($restored_data);
	});

	/**
	 * AJAX обработчик очистки папки с бекапами
	 */
	add_action('wp_ajax_wio_clear_backup', function () {
		check_admin_referer('wio-iph');

		$backup = new WIO_Backup();
		$backup->removeBackupDir();
		wp_send_json(true);
	});

	/**
	 * AJAX обработчик массовой сохранения уровня сжатия
	 */
	add_action('wp_ajax_wio_settings_update_level', function () {
		check_admin_referer('wio-iph');

		$level = $_POST['level'];

		if( !$level ) {
			die();
		}
		if( !in_array($level, array('normal', 'aggresive', 'ultra')) ) {
			die();
		}
		WIO_Plugin::app()->updateOption('image_optimization_level', $level);
		die();
	});