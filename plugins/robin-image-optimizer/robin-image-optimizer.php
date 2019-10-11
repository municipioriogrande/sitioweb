<?php
	/**
	 * Plugin Name: Webcraftic Robin image optimizer
	 * Plugin URI: https://wordpress.org/plugins/robin-image-optimizer/
	 * Description: Optimize images without losing quality, speed up your website load, improve SEO and save money on server and CDN bandwidth.
	 * Author: Webcraftic <wordpress.webraftic@gmail.com>
	 * Version: 1.1.5
	 * Text Domain: image-optimizer
	 * Domain Path: /languages/
	 * Author URI: https://clearfy.pro
	 * Framework Version: FACTORY_409_VERSION
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	define('WIO_PLUGIN_VERSION', '1.1.5');

	// Директория плагина
	define('WIO_PLUGIN_DIR', dirname(__FILE__));

	// Относительный путь к плагину
	define('WIO_PLUGIN_BASE', plugin_basename(__FILE__));

	// Ссылка к директории плагина
	define('WIO_PLUGIN_URL', plugins_url(null, __FILE__));

	// Fix for ithemes sync. When the ithemes sync plugin accepts the request, set the WP_ADMIN constant,
	// after which the plugin Clearfy begins to create errors, and how the logic of its work is broken.
	// Solution to simply terminate the plugin if there is a request from ithemes sync
	// --------------------------------------
	if( defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && $_REQUEST['action'] == 'ithemes_sync_request' ) {
		return;
	}

	if( isset($_GET['ithemes-sync-request']) && !empty($_GET['ithemes-sync-request']) ) {
		return;
	}
	// ----------------------------------------

	

	if( !defined('LOADING_ROBIN_IMAGE_OPTIMIZER_AS_ADDON') ) {
		require_once(WIO_PLUGIN_DIR . '/libs/factory/core/includes/check-compatibility.php');
		require_once(WIO_PLUGIN_DIR . '/libs/factory/clearfy/includes/check-clearfy-compatibility.php');
	}

	$plugin_info = array(
		'prefix' => 'wbcr_io_',
		// префикс для базы данных и полей формы
		'plugin_name' => 'wbcr_image_optimizer',
		// имя плагина, как уникальный идентификатор
		'plugin_title' => __('Webcraftic Robin image optimizer', 'robin-image-optimizer'),
		// заголовок плагина
		'plugin_version' => WIO_PLUGIN_VERSION,
		// текущая версия плагина
		'required_php_version' => '5.3',
		// минимальная версия php для работы плагина
		'required_wp_version' => '4.2',
		// минимальная версия wp для работы плагина
		'plugin_build' => 'free',
		// сборка плагина
		'updates' => WIO_PLUGIN_DIR . '/updates/'
	);

	/**
	 * Проверяет совместимость с Wordpress, php и другими плагинами.
	 */
	$compatibility = new Wbcr_FactoryClearfy_Compatibility(array_merge($plugin_info, array(
		'plugin_already_activate' => defined('WIO_PLUGIN_ACTIVE'),
		'plugin_as_component' => defined('LOADING_ROBIN_IMAGE_OPTIMIZER_AS_ADDON'),
		'plugin_dir' => WIO_PLUGIN_DIR,
		'plugin_base' => WIO_PLUGIN_BASE,
		'plugin_url' => WIO_PLUGIN_URL,
		'required_php_version' => '5.3',
		'required_wp_version' => '4.2.0',
		'required_clearfy_check_component' => false
	)));

	/**
	 * Если плагин совместим, то он продолжит свою работу, иначе будет остановлен,
	 * а пользователь получит предупреждение.
	 */
	if( !$compatibility->check() ) {
		return;
	}

	// Устанавливаем контстанту, что плагин уже используется
	define('WIO_PLUGIN_ACTIVE', true);

	// Этот плагин может быть аддоном плагина Clearfy, если он загружен, как аддон, то мы не подключаем фреймворк,
	// а наследуем функции фреймворка от плагина Clearfy. Если плагин скомпилирован, как отдельный плагин, то он использует собственный фреймворк для работы.
	// Константа LOADING_ROBIN_IMAGE_OPTIMIZER_AS_ADDON утсанавливается в классе libs/factory/core/includes/Wbcr_Factory409_Plugin

	if( !defined('LOADING_ROBIN_IMAGE_OPTIMIZER_AS_ADDON') ) {
		// Фреймворк - отвечает за интерфейс, содержит общие функции для серии плагинов и готовые шаблоны для быстрого развертывания плагина.
		require_once(WIO_PLUGIN_DIR . '/libs/factory/core/boot.php');
	}

	// Основной класс плагина
	require_once(WIO_PLUGIN_DIR . '/includes/class.plugin.php');

	// Класс WIO_Plugin создается только, если этот плагин работает, как самостоятельный плагин.
	// Если плагин работает, как аддон, то класс создается родительским плагином.

	if( !defined('LOADING_ROBIN_IMAGE_OPTIMIZER_AS_ADDON') ) {
		new WIO_Plugin(__FILE__, $plugin_info);
	}

