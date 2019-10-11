(function($) {
	var checkServersStatus = {
		init: function() {
			this.checkStatus();

			$('.wbcr-rio-select-server-button').click(function() {
				var serverName = $(this).data('server'),
					nonce = $(this).data('nonce'),
					self = $(this);

				if( self.hasClass('wbcr-rio-selected') ) {
					return false;
				}

				if( !serverName ) {
					alert('Undefined error, no server selected');
					return;
				}

				var data = {
					'action': 'wbcr_rio_select_server',
					'server_name': serverName,
					'_wpnonce': nonce
				};

				self.addClass('wbcr-rio-loading');

				$.post(ajaxurl, data, function(response) {
					$('.wbcr-rio-servers-list-item').removeClass('wbcr-rio-servers-list-item-selected');
					$('.wbcr-rio-select-server-button').removeClass('wbcr-rio-selected');

					self.addClass('wbcr-rio-selected').removeClass('wbcr-rio-loading');
					self.closest('tr').addClass('wbcr-rio-servers-list-item-selected');
				});
			});
		},

		checkStatus: function() {
			var data = {
				'action': 'wbcr_rio_check_servers_status'
			};

			var servers = ['server_1', 'server_2', /*'server_4',*/ 'server_3'];

			for( var i = 0; i < servers.length; i++ ) {

				data['server_name'] = servers[i];

				$('.wbcr-rio-' + servers[i]).find('.wbcr-rio-server-status').html('<div class="wbcr-rio-server-check-proccess"></div>');

				$.post(ajaxurl, data, function(response) {
					var serverName = response.data.server_name,
						serverElement = $('.wbcr-rio-' + serverName).find('.wbcr-rio-server-status');

					if( !response || !response.data || !response.success ) {
						if( !response || !response.data ) {
							console.log('[Error]: Response error');
							console.log(response);
							return;
						}

						serverElement.removeClass('wbcr-rio-server-warning').removeClass('wbcr-rio-server-success');
						serverElement.addClass('wbcr-rio-server-error').html('Down');
						return;
					}

					serverElement.removeClass('wbcr-rio-server-warning').removeClass('wbcr-rio-server-error');
					serverElement.addClass('wbcr-rio-server-success').html('Stable');
				});
			}
		}
	};

	$(document).ready(function() {
		checkServersStatus.init();
	});
})(jQuery);





