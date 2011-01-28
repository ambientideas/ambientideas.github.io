<?php

class BKPWP_INIT {
	
	function BKPWP_INIT() {
	}
	
	function bkpwp_check_prerequisites() {
		if (!current_user_can('manage bkpwp')) {
			return false;
		} 
		
		 $bkpwppath = get_option("bkpwppath");
		 if (!is_writable($bkpwppath)) {
			$notconfigured = 1;
		 }
		if (!isset($notconfigured)) {
			return false;
		} else {
			return true;
		}
	}
}

class BKPWP_INTERFACE {
	
	function BKPWP_INTERFACE() {
	}
	
	function menu() {
		$init = new BKPWP_INIT();
		$options = new BKPWP_OPTIONS();
		if($init->bkpwp_check_prerequisites()) {
			add_menu_page(__("BackUpWordPress","bkpwp"), __("BackUpWordPress","bkpwp"), 9, 'backupwordpress/backupwordpress.php', 'bkpwp_load_menu_page');
			add_submenu_page('backupwordpress/backupwordpress.php', __("Options","bkpwp"), __("Options","bkpwp"), 9, 'bkpwp_options', 'bkpwp_load_menu_page' ); 
			add_submenu_page('backupwordpress/backupwordpress.php', __("Help","bkpwp"), __("Help","bkpwp"), 9, 'bkpwp_help', 'bkpwp_load_menu_page' ); 
		} else {
			add_menu_page(__("BackUpWordPress","bkpwp"), __("BackUpWordPress","bkpwp"), 9, 'backupwordpress/backupwordpress.php', 'bkpwp_load_menu_page');
			if(!$options->bkpwp_easy_mode()) {
				add_submenu_page('backupwordpress/backupwordpress.php', __("Backup Presets","bkpwp"), __("Backup Presets","bkpwp"), 9, 'bkpwp_manage_presets', 'bkpwp_load_menu_page');
				add_submenu_page('backupwordpress/backupwordpress.php', __("Scheduled Backups","bkpwp"), __("Scheduled Backups","bkpwp"), 9, 'bkpwp_schedule', 'bkpwp_load_menu_page');
			}
			add_submenu_page('backupwordpress/backupwordpress.php', __("Options","bkpwp"), __("Options","bkpwp"), 9, 'bkpwp_options', 'bkpwp_load_menu_page' ); 
			add_submenu_page('backupwordpress/backupwordpress.php', __("Help","bkpwp"), __("Help","bkpwp"), 9, 'bkpwp_help', 'bkpwp_load_menu_page' ); 
		}
	}
}

?>
