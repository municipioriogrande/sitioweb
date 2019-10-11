<?php
	/**
	 * Основной класс плагина
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright (c) 19.02.2018, Webcraftic
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	if( !class_exists('WIO_Plugin') ) {
		if( !class_exists('WIO_PluginFactory') ) {
			// Этот плагин может быть аддоном плагина Clearfy, если он загружен, как аддон, то мы не подключаем фреймворк,
			// а наследуем функции фреймворка от плагина Clearfy. Если плагин скомпилирован, как отдельный плагин, то он использует собственный фреймворк для работы.
			// Константа LOADING_ROBIN_IMAGE_OPTIMIZER_AS_ADDON утсанавливается в классе libs/factory/core/includes/Wbcr_Factory409_Plugin

			if( defined('LOADING_ROBIN_IMAGE_OPTIMIZER_AS_ADDON') ) {
				class WIO_PluginFactory {
					
				}
			} else {
				class WIO_PluginFactory extends Wbcr_Factory409_Plugin {
					
				}
			}
		}
		
		class WIO_Plugin extends WIO_PluginFactory {

			/**
			 * @var Wbcr_Factory409_Plugin
			 */
			private static $app;
			
			/**
			 * @var bool
			 */
			private $as_addon;

			
			/**
			 * @param string $plugin_path
			 * @param array $data
			 * @throws Exception
			 */
			public function __construct($plugin_path, $data)
			{
				$this->as_addon = isset($data['as_addon']) ? true : false;
				
				if( $this->as_addon ) {
					$plugin_parent = isset($data['plugin_parent']) ? $data['plugin_parent'] : null;
					
					if( !($plugin_parent instanceof Wbcr_Factory409_Plugin) ) {
						throw new Exception(__('An invalid instance of the class was passed.', 'robin-image-optimizer'));
					}

					// Если плагин загружен, как аддон, то мы передаем в app ссылку на класс родителя
					self::$app = $plugin_parent;
				} else {
					// Если плагин самостоятельный, то записываем в app сслыку на текущий класс
					self::$app = $this;

					parent::__construct($plugin_path, $data);
				}

				// Для корректной работы с файлами имена которых в utf-8
				//setlocale(LC_ALL, "en_US.utf8");
				
				$this->init();

				$this->setModules();
				
				if( is_admin() ) {
					if( defined('DOING_AJAX') && DOING_AJAX ) {
						// Ajax files
						require_once(WIO_PLUGIN_DIR . '/admin/ajax/check-servers-status.php');
						require_once(WIO_PLUGIN_DIR . '/admin/ajax/select-server.php');
						require_once(WIO_PLUGIN_DIR . '/admin/ajax/backup.php');
						require_once(WIO_PLUGIN_DIR . '/admin/ajax/optimization.php');
					}

					$this->initActivation();
				}

				add_action('plugins_loaded', array($this, 'pluginsLoaded'));
			}


			/**
			 * Подключаем функции бекенда
			 */
			public function pluginsLoaded()
			{
				self::app()->setTextDomain('robin-image-optimizer', WIO_PLUGIN_DIR);

				if( is_admin() ) {
					require_once(WIO_PLUGIN_DIR . '/admin/boot.php');

					$this->registerPages();
				}
			}
			
			/**
			 * Подключение необходимых php файлов и инициализация
			 *
			 * @return void
			 */
			protected function init()
			{
				require_once(WIO_PLUGIN_DIR . '/includes/functions.php');
				require_once(WIO_PLUGIN_DIR . '/includes/classes/class.attachment.php');
				require_once(WIO_PLUGIN_DIR . '/includes/classes/class.media-library.php');
				require_once(WIO_PLUGIN_DIR . '/includes/classes/class.image-processor-abstract.php');
				require_once(WIO_PLUGIN_DIR . '/includes/classes/class.cron.php');
				require_once(WIO_PLUGIN_DIR . '/includes/classes/class.image-statistic.php');
				require_once(WIO_PLUGIN_DIR . '/includes/classes/class.backup.php');
				require_once(WIO_PLUGIN_DIR . '/includes/classes/class.logger.php');
				require_once(WIO_PLUGIN_DIR . '/includes/classes/class.optimization-tools.php');

				$cron = new WIO_Cron();
				$cron->initHooks();

				$media_library = new WIO_MediaLibrary();
				$media_library->initHooks();
			}
			
			/**
			 * Статический метод для быстрого доступа к информации о плагине, а также часто использумых методах.
			 *
			 * Пример:
			 * WIO_Plugin::app()->getOption()
			 * WIO_Plugin::app()->updateOption()
			 * WIO_Plugin::app()->deleteOption()
			 * WIO_Plugin::app()->getPluginName()
			 *
			 * @return Wbcr_Factory409_Plugin
			 */
			public static function app()
			{
				return self::$app;
			}

			/**
			 * Подключаем модули фреймворка
			 */
			protected function setModules()
			{
				if( !$this->as_addon ) {
					self::app()->load(array(
						// Модуль отвечает за подключение скриптов и стилей для интерфейса
						array('libs/factory/bootstrap', 'factory_bootstrap_409', 'admin'),
						// Модуль отвечает за создание форм и полей
						array('libs/factory/forms', 'factory_forms_410', 'admin'),
						// Модуль отвечает за создание шаблонов страниц плагина
						array('libs/factory/pages', 'factory_pages_410', 'admin'),
						// Модуль в котором хранится общий функционал плагина Clearfy и его аддонов
						array('libs/factory/clearfy', 'factory_clearfy_206', 'all')
					));
				}
			}

			/**
			 * Инициализируем активацию плагина
			 */
			protected function initActivation()
			{
				include_once(WIO_PLUGIN_DIR . '/admin/activation.php');
				self::app()->registerActivation('WIO_Activation');
			}

			/**
			 * Регистрируем страницы плагина
			 */
			private function registerPages()
			{

				$admin_path = WIO_PLUGIN_DIR . '/admin/pages';

				// Пример основной страницы настроек
				self::app()->registerPage('WIO_SettingsPage', $admin_path . '/settings.php');

				// Пример внутренней страницы настроек
				self::app()->registerPage('WIO_StatisticPage', $admin_path . '/statistic.php');
				
				if( self::app()->getOption('error_log', false) ) {
					self::app()->registerPage('WIO_LogPage', $admin_path . '/log.php');
				}
			}
		}
	}
