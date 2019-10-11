<?php #comp-page builds: premium

	/**
	 * Updates for altering the table used to store statistics data.
	 * Adds new columns and renames existing ones in order to add support for the new social buttons.
	 */
	class WIOUpdate010009 extends Wbcr_Factory409_Update {

		public function install()
		{
			//WIO_Plugin::app()->updateOption('image_optimization_server', 'server_3');
		}
	}