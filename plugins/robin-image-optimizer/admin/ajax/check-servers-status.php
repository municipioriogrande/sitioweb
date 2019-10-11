<?php
	/**
	 * Ajax действие, которое выполняется для проверки статуса серверов
	 *
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 2018 Webraftic Ltd
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	function wbcr_rio_check_servers_status()
	{
		$server_name = WIO_Plugin::app()->request->post('server_name');

		if( empty($server_name) || !in_array($server_name, array('server_1', 'server_2', 'server_3', 'server_4')) ) {
			wp_send_json_error(array('error' => 'Server name is empty!'));
		}

		$return_data = array('server_name' => $server_name);

		$server_url = wbcr_rio_get_server_url($server_name);

		$method = 'POST';
		if( $server_name == 'server_4' ) {
			$api_url = $server_url . '/upload/' . wbcr_rio_generate_random_string(16) . '/';
		} else if($server_name == 'server_3') {
			$api_url = $server_url . '/s.w.org/images/home/screen-themes.png';
			$method = 'GET';
		} else {
			$api_url = $server_url;
		}

		$request = wp_remote_request($api_url, array(
			'method' => $method
		));

		if( is_wp_error($request) ) {
			$return_data['error'] = $request->get_error_message();
			wp_send_json_error($return_data);
		}

		$response_code = wp_remote_retrieve_response_code($request);

		if( $response_code != 200 ) {
			$return_data['error'] = 'Server response ' . $response_code;
			wp_send_json_error($return_data);
		}

		wp_send_json_success($return_data);
	}

	add_action('wp_ajax_wbcr_rio_check_servers_status', 'wbcr_rio_check_servers_status');