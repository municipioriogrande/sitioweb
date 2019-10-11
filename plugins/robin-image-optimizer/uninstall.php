<?php

	// if uninstall.php is not called by WordPress, die
	if( !defined('WP_UNINSTALL_PLUGIN') ) {
		die;
	}

	// remove plugin options
	global $wpdb;

	$wpdb->query("DELETE FROM {$wpdb->prefix}options WHERE option_name LIKE 'wbcr_io_%';");
	$wpdb->query("DELETE FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE 'wio_%';");

	// remove backup dir
	require_once( dirname( __FILE__ ) . '/includes/classes/class.backup.php' );
	$backup = new WIO_Backup();
	$backup->removeBackupDir();
