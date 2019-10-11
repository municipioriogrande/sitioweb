<?php
	
	/**
	 * The page Settings.
	 *
	 * @since 1.0.0
	 */
	
	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}
	
	/**
	 * Class WIO_StatisticPage
	 * Класс отвечает за работу страницы статистики
	 * @author Eugene Jokerov <jokerov@gmail.com>
	 * @copyright (c) 2018, Webcraftic
	 * @version 1.0
	 * @method string getDonateWidget() - get widget content donate
	 */
	class WIO_StatisticPage extends Wbcr_FactoryClearfy206_PageBase {
		
		/**
		 * The id of the page in the admin menu.
		 *
		 * Mainly used to navigate between pages.
		 * @see FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public $id = 'io_general'; // Уникальный идентификатор страницы
		public $type = 'page'; // Этот произвольный тип страницы
		public $plugin;

		/**
		 * @var int
		 */
		public $page_menu_position = 20;
		public $page_parent_page = null; // Уникальный идентификатор родительской страницы
		public $page_menu_dashicon = 'dashicons-chart-line'; // Иконка для закладки страницы, дашикон


		/**
		 * @var bool
		 */
		//public $available_for_multisite = true;

		/**
		 * @var bool
		 */
		public $clearfy_collaboration = false;

		/**
		 * Показывать правый сайдбар?
		 * Сайдбар будет показан на внутренних страницах шаблона.
		 *
		 * @var bool
		 */
		public $show_right_sidebar_in_options = false;
		
		/**
		 * @param Wbcr_Factory409_Plugin $plugin
		 */
		public function __construct(Wbcr_Factory409_Plugin $plugin)
		{
			$this->menu_title = __('Robin image optimizer', 'robin-image-optimizer');
			$this->page_menu_short_description = __('Compress bulk of images', 'robin-image-optimizer');

			// Если плагин загружен, как самостоятельный, то мы меняем настройки страницы и делаем ее внешней,
			// а не внутренней страницей родительского плагина. Внешнии страницы добавляются в Wordpress меню "Общие"

			if( !defined('LOADING_ROBIN_IMAGE_OPTIMIZER_AS_ADDON') ) {
				// true - внутреняя, false- внешняя страница
				$this->internal = false;
				// меню к которому, нужно прикрепить ссылку на страницу
				$this->menu_target = 'options-general.php';
				// Если true, добавляет ссылку "Настройки", рядом с действиями активации, деактивации плагина, на странице плагинов.
				$this->add_link_to_plugin_actions = true;
			}

			if( is_multisite() && defined('WBCR_CLEARFY_PLUGIN_ACTIVE') ) {
				$clearfy_is_active_for_network = is_plugin_active_for_network(Wbcr_FactoryClearfy_Compatibility::getClearfyBasePath());

				if( WIO_Plugin::app()->isNetworkActive() && $clearfy_is_active_for_network ) {
					$this->clearfy_collaboration = true;
				}
			} else if( defined('WBCR_CLEARFY_PLUGIN_ACTIVE') ) {
				$this->clearfy_collaboration = true;
			}

			$this->plugin = $plugin;
			$this->hooks();

			parent::__construct($plugin);
		}

		/**
		 * Подменяем простраинство имен для меню плагина, если активирован плагин Clearfy
		 * Меню текущего плагина будет добавлено в общее меню Clearfy
		 * @return string
		 */
		public function getMenuScope()
		{
			if( $this->clearfy_collaboration ) {
				$this->internal = true;

				return 'wbcr_clearfy';
			}

			return $this->plugin->getPluginName();
		}

		public function getPageTitle()
		{
			return $this->clearfy_collaboration ? __('Image optimizer', 'robin-image-optimizer') : __('General', 'robin-image-optimizer');
		}

		/**
		 * Метод позволяет менять заголовок меню, в зависимости от сборки плагина.
		 * @return string|void
		 */
		public function getMenuTitle()
		{
			return $this->clearfy_collaboration ? __('Image optimizer', 'robin-image-optimizer') : __('Robin image optimizer', 'robin-image-optimizer');
		}

		/**
		 * Устанавливаем хуки
		 */
		public function hooks()
		{
			if( defined('WBCR_CLEARFY_PLUGIN_VERSION') && version_compare(WBCR_CLEARFY_PLUGIN_VERSION, '1.4.2', '>=') ) {
				add_action('wbcr_clearfy_quick_boards', array($this, 'widget'));
			}

			add_action('wbcr/clearfy/page_assets', array($this, 'registerWidgetScripts'), 10, 3);
		}

		/**
		 * Подключаем скрипты и стили для страницы
		 *
		 * @see Wbcr_FactoryPages410_AdminPage
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function assets($scripts, $styles)
		{
			parent::assets($scripts, $styles);

			$this->styles->add(WIO_PLUGIN_URL . '/admin/assets/css/base-statistic.css');

			$this->scripts->add(WIO_PLUGIN_URL . '/admin/assets/js/Chart.min.js');
			$this->scripts->add(WIO_PLUGIN_URL . '/admin/assets/js/statistic.js');
			$this->scripts->add(WIO_PLUGIN_URL . '/admin/assets/js/bulk-optimozation.js');

			$this->scripts->add(WIO_PLUGIN_URL . '/admin/assets/js/check-servers-status.js');

			// Add Clearfy styles for HMWP pages
			if( defined('WBCR_CLEARFY_PLUGIN_ACTIVE') ) {
				$this->styles->add(WCL_PLUGIN_URL . '/admin/assets/css/general.css');
			}
		}

		public function printServersTable()
		{
			$selected_server = $this->plugin->getOption('image_optimization_server', 'server_1');

			$servers = array(
				'server_1' => 'Server 1',
				'server_2' => 'Server 2',
				'server_3' => 'Server 3',
				//'server_4' => 'Server 4'
			);
			?>

			<div class="wbcr-rio-servers">
				<div class="wbcr-factory-page-group-header" style="margin-bottom:0;">
					<strong><?php _e('Servers', 'image-optimizer'); ?></strong>

					<p><?php _e('Please, find the list of available servers for image optimization below. If the server has a state “<b style="color:red">Down</b>”, it means that the server is not available, and you should choose another one. “<b style="color:green">Stable</b>” means that the server is available and you can use it.', 'image-optimizer') ?></p>
				</div>
				<div class="wbcr-factory-page-group-body">
					<table class="wbcr-rio-servers-list">
						<tr>
							<th><?php _e('Server', 'image-optimizer'); ?></th>
							<th><?php _e('Status', 'image-optimizer'); ?></th>
							<th><?php _e('Limits', 'image-optimizer'); ?></th>
							<th><?php _e('Actions', 'image-optimizer'); ?></th>
						</tr>
						<?php foreach($servers as $server_name => $server_title): ?>
							<?php
							$server_list_item_classes = $server_name == $selected_server ? ' wbcr-rio-servers-list-item-selected' : '';
							$server_button_classes = $server_name == $selected_server ? ' wbcr-rio-selected' : '';
							?>
							<tr class="wbcr-rio-servers-list-item wbcr-rio-<?= $server_name ?><?= $server_list_item_classes ?>">
								<td><?= $server_title ?></td>
								<td class="wbcr-rio-server-status wbcr-rio-server-success"><?php _e('Stable', 'image-optimizer'); ?></td>
								<td>
									<?php if( $server_name == 'server_1' ): ?>
										<?php _e('IMG > 5MB', 'image-optimizer'); ?>
									<?php elseif( $server_name == 'server_2' ): ?>
										<?php _e('IMG > 1MB', 'image-optimizer'); ?>
									<?php else: ?>
										<?php _e('No limits', 'image-optimizer'); ?>
									<?php endif; ?>
								</td>
								<td>
									<button class="wbcr-rio-select-server-button<?= $server_button_classes ?>" data-nonce="<?= wp_create_nonce('wbcr_rio_select_' . $server_name) ?>" data-server="<?= $server_name ?>">
										<?php _e('Select', 'image-optimizer'); ?>
									</button>
								</td>
							</tr>
						<?php endforeach; ?>
					</table>
					<div class="wbcr-rio-warning-message">
						<?php
							$server = $this->plugin->getOption('image_optimization_server', 'server_1');

							if( $server == 'server_1' ) {
								echo __('There are limitations for the specified server (server 1) – you can’t optimize images with the size greater than <span style="color:red">5MB</span>. But you can enable the “Resizing large images” feature to reduce the image weight due to the proportional resizing before sending the file to the optimization server. ', 'robin-image-optimizer');
							} else if( $server == 'server_2' ) {
								echo __('There are limitations for the specified server (server 2) – you can’t optimize images with the size greater than <span style="color:red">1MB</span>. But you can enable the “Resizing large images” feature to reduce the image weight due to the proportional resizing before sending the file to the optimization server. Note: this server supports only one compression mode – “Normal”.', 'robin-image-optimizer');
							} else if( $server == 'server_3' ) {
								echo __("There are limitations for the specified server (server 3) – you can't use it on a localhost.", 'robin-image-optimizer');
							} else {
								echo __("This server has no limitations.", 'robin-image-optimizer');
							}
						?>
					</div>
				</div>
			</div>
		<?php
		}

		/**
		 * Prints the content of the page
		 *
		 * @see libs\factory\pages\themplates\FactoryPages410_ImpressiveThemplate
		 */
		public function showPageContent()
		{
			$statistics = new WIO_Image_Statistic();
			$image_statistics = $statistics->get();
			?>
			<div class="wbcr-factory-page-group-header" style="margin-top:0;">
				<strong><?php _e('Image optimization dashboard', 'robin-image-optimizer') ?></strong>
				
				<p>
					<?php _e('Monitor image optimization statistics and run on demand or scheduled optimization.', 'robin-image-optimizer') ?>
				</p>
			</div>
			
			<div class="wbcr-factory-page-group-body" style="padding:20px">
				<div class="wio-columns wio-page-statistic">
					<div>
						<div class="wio-chart-container wio-overview-chart-container">
							<canvas id="wio-main-chart" width="180" height="180" data-unoptimized="<?php echo esc_attr($image_statistics['unoptimized']); ?>" data-optimized="<?php echo esc_attr($image_statistics['optimized']); ?>" data-errors="<?php echo esc_attr($image_statistics['error']); ?>" style="display: block;"></canvas>
							<div id="wio-overview-chart-percent" class="wio-chart-percent"><?php echo esc_attr($image_statistics['optimized_percent']); ?>
								<span>%</span></div>
							<p class="wio-global-optim-phrase wio-clear">
								<?php _e('You optimized', 'robin-image-optimizer'); ?>
								<span class="wio-total-percent"><?php echo esc_attr($image_statistics['optimized_percent']); ?>
									%</span> <?php _e("of your website's images", 'robin-image-optimizer'); ?>
							</p>
						</div>
						<div style="margin-left:200px;">
							<div id="wio-overview-chart-legend">
								<ul class="wio-doughnut-legend">
									<li>
										<span style="background-color:#d6d6d6"></span><?php _e('Unoptimized', 'robin-image-optimizer'); ?>
										-
										<span class="wio-num" id="wio-unoptimized-num"><?php echo esc_attr($image_statistics['unoptimized']); ?></span>
									</li>
									<li>
										<span style="background-color:#8bc34a"></span><?php _e('Optimized', 'robin-image-optimizer'); ?>
										-
										<span class="wio-num" id="wio-optimized-num"><?php echo esc_attr($image_statistics['optimized']); ?></span>
									</li>
									<li>
										<span style="background-color:#f1b1b6"></span><?php _e('Error', 'robin-image-optimizer'); ?>
										-
										<span class="wio-num" id="wio-error-num"><?php echo esc_attr($image_statistics['error']); ?></span>
									</li>
								</ul>
							</div>
							<h3 class="screen-reader-text"><?php _e('Statistics', 'robin-image-optimizer'); ?></h3>
							<!--<div class="wio-number-you-optimized">
								<p>
									<span id="wio-total-optimized-attachments" class="wio-number"><?php echo esc_attr($image_statistics['optimized']); ?></span>
								<span class="wio-text">
									<?php _e("that's the number of original images<br> you optimized with Image Optimizer", 'robin-image-optimizer'); ?>
								</span>
								</p>
							</div>-->
							<div class="wio-bars" style="width: 90%">
								<p><?php _e('Original size', 'robin-image-optimizer'); ?></p>

								<div class="wio-bar-negative base-transparent wio-right-outside-number">
									<div id="wio-original-bar" class="wio-progress" style="width: 100%">
										<span class="wio-barnb" id="wio-original-size"><?php echo esc_attr($statistics->convertToReadableSize($image_statistics['original_size'])); ?></span>
									</div>
								</div>
								<p><?php _e('Optimized size', 'robin-image-optimizer'); ?></p>

								<div class="wio-bar-primary base-transparent wio-right-outside-number">
									<div id="wio-optimized-bar" class="wio-progress" style="width: <?php echo ($image_statistics['percent_line']) ? esc_attr($image_statistics['percent_line']) : 100; ?>%">
										<span class="wio-barnb" id="wio-optimized-size"><?php echo esc_attr($statistics->convertToReadableSize($image_statistics['optimized_size'])); ?></span>
									</div>
								</div>
							</div>
							<div class="wio-number-you-optimized">
								<p>
									<span id="wio-total-optimized-attachments-pct" class="wio-number"><?php echo esc_attr($image_statistics['save_size_percent']); ?>
										%</span>
								<span class="wio-text">
									<?php _e("that's the size you saved <br>by using Image Optimizer", 'robin-image-optimizer'); ?>
								</span>
								</p>
							</div>
						</div>
					</div>
					<div>
						<input type="hidden" value="<?php echo wp_create_nonce('wio-iph') ?>" id="wio-iph-nonce">

						<p>
							<?php $this->button(); ?>
							<span id="wio-start-msg-complete"><?php _e('All images from the media library are optimized.', 'robin-image-optimizer'); ?></span>
						</p>

						<p id="wio-start-msg-top"><?php _e('Optimization in progress. Remained', 'robin-image-optimizer'); ?>
							<span id="wio-total-unoptimized"><?php echo esc_attr($image_statistics['unoptimized']); ?></span> <?php _e('images.', 'robin-image-optimizer'); ?>
						</p>
					</div>
				</div>
			</div>
			<?php $this->printServersTable(); ?>
		<?php
		}
		
		/**
		 * Кнопка запуска оптимизации
		 *
		 */
		public function button()
		{
			$backup_origin_images = WIO_Plugin::app()->getOption('backup_origin_images', false);
			$is_cron_mode = WIO_Plugin::app()->getOption('image_autooptimize_mode', false);
			$button_classes = array(
				'wio-optimize-button'
			);
			if( !$backup_origin_images ) {
				$button_classes[] = 'wio-nobackup';
			}
			$button_name = __('Run', 'robin-image-optimizer');
			if( $is_cron_mode ) {
				$button_classes[] = 'wio-cron-mode';
				$cron_running = WIO_Plugin::app()->getOption('cron_running', false);
				if( $cron_running ) {
					$button_classes[] = 'wio-running';
					$button_name = __('Stop', 'robin-image-optimizer');
				} else {
					$button_name = __('Run', 'robin-image-optimizer');
				}
			}
			?>
			<button type="button" id="wio-start-optimization" data-confirm="<?php _e('Do you want to start optimization without backup?', 'robin-image-optimizer'); ?>" data-start="<?php _e('Resume', 'robin-image-optimizer'); ?>" data-stop="<?php _e('Stop', 'robin-image-optimizer'); ?>" class="<?php echo join(' ', $button_classes); ?>"><?php echo esc_attr($button_name); ?></button>
		<?php
		}

		/**
		 * @param string $page_id
		 * @param Wbcr_Factory409_ScriptList $scripts
		 * @param Wbcr_Factory409_StyleList $styles
		 */
		public function registerWidgetScripts($page_id, $scripts, $styles)
		{
			if( $page_id == 'quick_start-wbcr_clearfy' ) {
				// Add scripts
				$scripts->add(WIO_PLUGIN_URL . '/admin/assets/js/Chart.min.js');
				$scripts->add(WIO_PLUGIN_URL . '/admin/assets/js/bulk-optimozation.js');
				$scripts->add(WIO_PLUGIN_URL . '/admin/assets/js/statistic.js');

				// Add styles
				$styles->add(WIO_PLUGIN_URL . '/admin/assets/css/base-statistic.css');
			}
		}
		
		/**
		 * Виджет для clearfy
		 *
		 */
		public function widget()
		{

			$statistics = new WIO_Image_Statistic();
			$image_statistics = $statistics->get();

			$default_level = WIO_Plugin::app()->getOption('image_optimization_level', 'normal');
			?>

			<div class="col-sm-12">
				<div class="wio-image-optimize-board wbcr-clearfy-board">
					<h4 class="wio-text-left"><?php _e('Images optimization', 'robin-image-optimizer'); ?></h4>

					<div class="wio-columns wio-widget">
						<div class="wio-col col-chart">
							<div class="wio-chart-container wio-overview-chart-container">
								<canvas id="wio-main-chart" width="130" height="130" data-unoptimized="<?php echo esc_attr($image_statistics['unoptimized']); ?>" data-optimized="<?php echo esc_attr($image_statistics['optimized']); ?>" data-errors="<?php echo esc_attr($image_statistics['error']); ?>" style="display: block;"></canvas>
								<div id="wio-overview-chart-percent" class="wio-chart-percent"><?php echo esc_attr($image_statistics['optimized_percent']); ?>
									<span>%</span></div>
							</div>
							<div id="wio-overview-chart-legend">
								<ul class="wio-doughnut-legend">
									<li>
										<span style="background-color:#d6d6d6"></span><?php _e('Unoptimized', 'robin-image-optimizer'); ?>
										-
										<span class="wio-num" id="wio-unoptimized-num"><?php echo esc_attr($image_statistics['unoptimized']); ?></span>
									</li>
									<li>
										<span style="background-color:#8bc34a"></span><?php _e('Optimized', 'robin-image-optimizer'); ?>
										-
										<span class="wio-num" id="wio-optimized-num"><?php echo esc_attr($image_statistics['optimized']); ?></span>
									</li>
									<li>
										<span style="background-color:#f1b1b6"></span><?php _e('Error', 'robin-image-optimizer'); ?>
										-
										<span class="wio-num" id="wio-error-num"><?php echo esc_attr($image_statistics['error']); ?></span>
									</li>
								</ul>
							</div>
							<div class="wio-bars">
								<p><?php _e('Original size', 'robin-image-optimizer'); ?></p>

								<div class="wio-bar-negative base-transparent wio-right-outside-number">
									<div id="wio-original-bar" class="wio-progress" style="width: 100%">
										<span class="wio-barnb" id="wio-original-size"><?php echo esc_attr($statistics->convertToReadableSize($image_statistics['original_size'])); ?></span>
									</div>
								</div>
								<p><?php _e('Optimized size', 'robin-image-optimizer'); ?></p>

								<div class="wio-bar-primary base-transparent wio-right-outside-number">
									<div id="wio-optimized-bar" class="wio-progress" style="width: <?php echo ($image_statistics['percent_line']) ? esc_attr($image_statistics['percent_line']) : 100; ?>%">
										<span class="wio-barnb" id="wio-optimized-size"><?php echo esc_attr($statistics->convertToReadableSize($image_statistics['optimized_size'])); ?></span>
									</div>
								</div>
							</div>
						</div>
						<ul class="wio-widget-bottom">
							<li>
								<input type="hidden" value="<?php echo wp_create_nonce('wio-iph') ?>" id="wio-iph-nonce">

								<p>
									<?php $this->button(); ?>
									<span id="wio-start-msg-complete"><?php _e('All images from the media library are optimized.', 'robin-image-optimizer'); ?></span>
								</p>

								<p id="wio-start-msg-top"><?php _e('Optimization in progress. Remained', 'robin-image-optimizer'); ?>
									<span id="wio-total-unoptimized"><?php echo esc_attr($image_statistics['unoptimized']); ?></span>
								</p>
							</li>
							<li>
								<div class="factory-dropdown factory-from-control-dropdown factory-buttons-way" data-way="buttons">
									<div id="wio-level-buttons" class="btn-group factory-buttons-group">
										<button type="button" data-level="normal" class="btn btn-default btn-small <?php if( $default_level == 'normal' ) : ?>active<?php endif; ?>"><?php _e('Normal', 'robin-image-optimizer'); ?></button>
										<button type="button" data-level="aggresive" class="btn btn-default btn-small <?php if( $default_level == 'aggresive' ) : ?>active<?php endif; ?>"><?php _e('Medium', 'robin-image-optimizer'); ?></button>
										<button type="button" data-level="ultra" class="btn btn-default btn-small <?php if( $default_level == 'ultra' ) : ?>active<?php endif; ?>"><?php _e('High', 'robin-image-optimizer'); ?></button>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<?php
		}
	}
