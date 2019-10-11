jQuery(function($){
	var ajaxUrl = ajaxurl;
	var ai_data;
	$('#wio-start-optimization').on('click', function(){
		if ( $(this).hasClass( 'wio-nobackup' ) ) {
			result = confirm( $(this).attr('data-confirm') );
			if ( ! result ) {
				return false;
			}
		}
		$(this).toggleClass( 'wio-running' );
		var cron_mode = 0;
		if ( $(this).hasClass( 'wio-cron-mode' ) ) {
			cron_mode = 1;
		}
		if ( ! cron_mode ) {
			$('#wio-start-msg-top').show();
		}
		
		if ( typeof(ai_data) === 'undefined' ) {
			var ai_data = {
				'action': 'wio_process_images',
				'_wpnonce': $('#wio-iph-nonce').val(),
				'cron_mode': 0,
				'reset_current_errors': 1
			};
		}
		if ( ! cron_mode ) {
			send_post_data(ai_data);
		} else {
			ai_data.cron_mode = 1;
			toggle_cron(ai_data);
		}
		
		if ( $(this).hasClass( 'wio-running' ) ) {
			$(this).text( $(this).attr('data-stop') );
			if ( ! cron_mode ) {
				$('#wio-start-msg-top').show();
			}
		} else {
			$(this).text( $(this).attr('data-start') );
			if ( ! cron_mode ) {
				$('#wio-start-msg-top').hide();
			}
		}
	});
	
	function send_post_data(data){
		if ( $('#wio-start-optimization').hasClass( 'wio-running' ) ) {
			data.reset_current_errors = 0; // текущие ошибки сбрасываем только
			$.post(ajaxUrl, data, function(response) {

				if ( ! response.end ) {
					$('#wio-total-unoptimized').text( response.remain );
					send_post_data(data);
				} else {
					if ( response.msg ) {
						alert( response.msg );
						$('#wio-start-msg-top').hide();
						$('#wio-start-optimization').hide();
						return false;
					}
					$('#wio-total-unoptimized').text( response.remain );
					$('#wio-start-msg-complete').show();
					$('#wio-start-msg-top').hide();
					$('#wio-start-optimization').hide();
				}
				redraw_statistics( response.statistic );
			});
		}
	}
	
	function toggle_cron(data) {
		$.post(ajaxUrl, data, function(response) {

		});
	}
	
	function redraw_statistics( statistic ) {
		$('#wio-main-chart').attr('data-unoptimized', statistic.unoptimized )
							.attr('data-optimized', statistic.optimized )
							.attr('data-errors', statistic.error );
		$('#wio-total-optimized-attachments').text(statistic.optimized); // optimized
		$('#wio-original-size').text( bytesToSize( statistic.original_size ) );
		$('#wio-optimized-size').text( bytesToSize( statistic.optimized_size ) );
		$('#wio-total-optimized-attachments-pct').text(statistic.save_size_percent + '%');
		$('#wio-overview-chart-percent').html(statistic.optimized_percent + '<span>%</span>');
		$('.wio-total-percent').text(statistic.optimized_percent + '%');
		$('#wio-optimized-bar').css('width', statistic.percent_line + '%');
		
		$('#wio-unoptimized-num').text( statistic.unoptimized );
		$('#wio-optimized-num').text( statistic.optimized );
		$('#wio-error-num').text( statistic.error );
		
		window.wio_chart.data.datasets[0].data[0] = statistic.unoptimized; // unoptimized
		window.wio_chart.data.datasets[0].data[1] = statistic.optimized; // optimized
		window.wio_chart.data.datasets[0].data[2] = statistic.error; // errors
		window.wio_chart.update();
	}

	function bytesToSize(bytes) {
		var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
		if (bytes == 0) return '0 Byte';
		var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
		if (i == 0) return bytes + ' ' + sizes[i]; 
		return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
	}
	
	$('#wio-level-buttons button').on('click', function() {
		var ai_data = {
			'action': 'wio_settings_update_level',
			'_wpnonce': $('#wio-iph-nonce').val(),
			'level': $(this).attr('data-level')
		};
		$.post(ajaxUrl, ai_data, function(response) {

		});
	});
	
	
});
