jQuery(function($){
	var ajaxUrl = ajaxurl;
	
	$('#wio-restore-backup-btn').on('click', function() {
		result = confirm( $(this).attr('data-confirm') );
		if ( ! result ) {
			return false;
		}
		$(this).hide();
		$('#wio-restore-backup-progress').show();
		var ai_data = {
			'total' : '?',
			'action': 'wio_restore_backup',
			'_wpnonce': $('#wio-iph-nonce').val()
		};
		send_post_data(ai_data);
		return false;
	});
	
	$('#wio-clear-backup-btn').on('click', function() {
		$('#wio-restore-backup-msg').hide();
		result = confirm( $(this).attr('data-confirm') );
		if ( ! result ) {
			return false;
		}
		var data = {
			'action': 'wio_clear_backup',
			'_wpnonce': $('#wio-iph-nonce').val()
		};
		$.post(ajaxUrl, data, function(response) {
			$('#wio-clear-backup-msg').show();
		});
	});
	
	function send_post_data(data){
		$.post(ajaxUrl, data, function(response) {
			if ( ! response.end ) {
				data.total = response.total;
				send_post_data(data);
				$('#wio-restore-backup-progress').find('.progress-bar').css( 'width', response.percent + '%' );
			} else {
				$('#wio-restore-backup-progress').find('.progress-bar').css( 'width', '100%' );
				$('#wio-restore-backup-msg').show();
			}
		});
	}
});
