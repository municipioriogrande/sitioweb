<?php
	/**
	 * Admin boot
	 * @author Webcraftic <wordpress.webraftic@gmail.com>
	 * @copyright Webcraftic 25.05.2017
	 * @version 1.0
	 */

	// Exit if accessed directly
	if( !defined('ABSPATH') ) {
		exit;
	}

	/**
	 * Widget with the offer to buy Clearfy Business
	 *
	 * @param array $widgets
	 * @param string $position
	 * @param Wbcr_Factory409_Plugin $plugin
	 */
	add_filter('wbcr/factory/pages/impressive/widgets', function ($widgets, $position, $plugin) {
		if( $plugin->getPluginName() == WIO_Plugin::app()->getPluginName() ) {
			if( $position == 'right' ) {
				unset($widgets['donate_widget']);
				unset($widgets['info_widget']);
				//unset($widgets['businnes_suggetion']);
			}
		}

		return $widgets;
	}, 20, 3);

	/***
	 * Flush configuration after saving the settings
	 *
	 * @param WHM_Plugin $plugin
	 * @param Wbcr_FactoryPages410_ImpressiveThemplate $obj
	 * @return bool
	 */
	/*add_action('wbcr_factory_409_imppage_after_form_save', function ($plugin, $obj) {
		$is_rio = WIO_Plugin::app()->getPluginName() == $plugin->getPluginName();

		if( $is_rio ) {
			WIO_Cron::check();
		}
	}, 10, 2);*/

	/**
	 * Виджет отзывов
	 *
	 * @param string $page_url
	 * @param string $plugin_name
	 * @return string
	 */
	function wio_rating_widget_url($page_url, $plugin_name)
	{
		if( !defined('LOADING_ROBIN_IMAGE_OPTIMIZER_AS_ADDON') && ($plugin_name == WIO_Plugin::app()->getPluginName())
		) {
			return 'https://wordpress.org/support/plugin/robin-image-optimizer/reviews/#new-post';
		}

		return $page_url;
	}

	add_filter('wbcr_factory_pages_410_imppage_rating_widget_url', 'wio_rating_widget_url', 10, 2);

	/**
	 * Widget with the offer to buy Clearfy Business
	 *
	 * @param array $widgets
	 * @param string $position
	 * @param Wbcr_Factory409_Plugin $plugin
	 */
	function wio_donate_widget($widgets, $position, $plugin)
	{
		if( $plugin->getPluginName() == WIO_Plugin::app()->getPluginName() ) {
			$buy_premium_url = 'https://clearfy.pro/pricing/?utm_source=wordpress.org&utm_campaign=wbcr_robin_image_optimizer&utm_content=widget';

			ob_start();
			?>
			<div id="wbcr-clr-go-to-premium-widget" class="wbcr-factory-sidebar-widget">
				<p>
					<strong><?php _e('Donation', 'clearfy'); ?></strong>
				</p>

				<div class="wbcr-clr-go-to-premium-widget-body">
					<p><?php _e('<b>Clearfy Business</b> is a paid package of components for the popular free WordPress plugin named Clearfy. You get access to all paid components at one price.', 'clearfy') ?></p>

					<p><?php _e('Paid license guarantees that you can download and update existing and future paid components of the plugin.', 'clearfy') ?></p>
					<a href="<?= $buy_premium_url ?>" class="wbcr-clr-purchase-premium" target="_blank" rel="noopener">
                        <span class="btn btn-gold btn-inner-wrap">
                        <i class="fa fa-star"></i> <?php printf(__('Upgrade to Clearfy Business for $%s', 'clearfy'), 19) ?>
	                        <i class="fa fa-star"></i>
                        </span>
					</a>
				</div>
			</div>
			<?php

			$widgets['donate_widget'] = ob_get_contents();
			ob_end_clean();
		}

		return $widgets;
	}

	add_filter('wbcr/factory/pages/impressive/widgets', 'wio_donate_widget', 10, 3);



