<?php
	/**
	 * Ajax действие, которое выполняется для выбора нового сервера оптимизации
	 *
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2018 Webraftic Ltd
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	function wbcr_rio_select_server()
	{
		$server_name = WIO_Plugin::app()->request->post('server_name');

		if( empty($server_name) ) {
			wp_send_json_error(array('error' => 'Server name is empty!'));
		}

		check_ajax_referer('wbcr_rio_select_' . $server_name);

		WIO_Plugin::app()->updateOption('image_optimization_server', $server_name);

		wp_send_json_success();
	}

	add_action('wp_ajax_wbcr_rio_select_server', 'wbcr_rio_select_server');

