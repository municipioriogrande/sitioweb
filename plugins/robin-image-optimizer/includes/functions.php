<?php

	/**
	 * Get size information for all currently-registered image sizes.
	 *
	 * @global $_wp_additional_image_sizes
	 * @uses   get_intermediate_image_sizes()
	 * @return array $sizes Data for all currently-registered image sizes.
	 */
	function wio_get_image_sizes()
	{
		global $_wp_additional_image_sizes;

		$sizes = array();

		foreach(get_intermediate_image_sizes() as $_size) {
			if( in_array($_size, array('thumbnail', 'medium', 'medium_large', 'large')) ) {
				$sizes[$_size]['width'] = get_option("{$_size}_size_w");
				$sizes[$_size]['height'] = get_option("{$_size}_size_h");
				$sizes[$_size]['crop'] = (bool)get_option("{$_size}_crop");
			} elseif( isset($_wp_additional_image_sizes[$_size]) ) {
				$sizes[$_size] = array(
					'width' => $_wp_additional_image_sizes[$_size]['width'],
					'height' => $_wp_additional_image_sizes[$_size]['height'],
					'crop' => $_wp_additional_image_sizes[$_size]['crop'],
				);
			}
		}

		return $sizes;
	}

	/**
	 * Пересчёт размера файла в байтах на человекопонятный вид
	 *
	 * Пример: вводим 67894 байт, получаем 67.8 KB
	 * Пример: вводим 6789477 байт, получаем 6.7 MB
	 * @param int $size размер файла в байтах
	 * @return string
	 */
	function wio_convert_bytes($size)
	{
		if( !$size ) {
			return 0;
		}
		$base = log($size) / log(1024);
		$suffix = array('', 'KB', 'MB', 'GB', 'TB');
		$f_base = floor($base);

		return round(pow(1024, $base - floor($base)), 2) . ' ' . $suffix[$f_base];
	}

	/**
	 * Генерирует хеш строку
	 *
	 * @param int $length
	 * @return string
	 */
	function wbcr_rio_generate_random_string($length = 10)
	{
		$characters = '0123456789abcdefghiklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;
	}

	/**
	 * @param string $url
	 * @param string $schema
	 * @return string
	 */
	function wbcr_rio_get_server_url($server_name)
	{
		$servers = array(
			'server_4' => 'https://clearfy.pro/oimg.php',
			'server_2' => 'https://smushpro.wpmudev.org/1.0/',
			'server_1' => 'http://api.resmush.it/ws.php',
			'server_3' => 'https://webcraftic.com/smush_images.php'
		);

		$servers = apply_filters('wbcr/rio/allow_servers', $servers);

		if( isset($servers[$server_name]) ) {
			return $servers[$server_name];
		}

		return null;
	}