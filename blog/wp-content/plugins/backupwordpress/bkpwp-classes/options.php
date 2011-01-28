<?php

class BKPWP_OPTIONS {
	
    var $bkpwp_default_backup_path = '/wp-content/backup';
    
    function BKPWP_OPTIONS() {
    }
    
    function bkpwp_easy_mode() {
	  $easy_mode = get_option("bkpwp_easy_mode");
	  $user = $GLOBALS['userdata']->user_login;
	  if(empty($user)) { $user = "admin"; }
	  if ($easy_mode[$user] == 1) { 
	  	return true; 
	  } else {
		  return false;
	  }
    }
    
    function bkpwp_handle_modeswitch() {
	    if (!empty($_REQUEST['bkpwp_modeswitch'])) {
		    $user = $GLOBALS['userdata']->user_login;
		    if(empty($user)) { $user = "admin"; }
		    if (!$this->bkpwp_easy_mode()) {
			    $easy_mode[$user] = 1;
		    } else {
			    $easy_mode[$user] = "";
		    }
		    
		    update_option("bkpwp_easy_mode",$easy_mode);
	    }
    }
    
    function bkpwp_path() {
	    return get_option("bkpwppath");
    }
    
    function bkpwp_options_edit() {
	    if (!current_user_can('manage bkpwp')) {
		    return false;
	    }
	    return true;
    }
    
    function bkpwp_delete_option($option) {
	    delete_option($option);
    }
    
    function bkpwp_update_option($name,$value) {
	    update_option($name,$value);
    }
    
    function bkpwp_handle_backup_path($suppress_msg=0) {
	  if (!$this->bkpwp_options_edit()) {
		  bkpwp_display_message(__("You do not have sufficent privileges to do Full Backups.","bkpwp"));
		  return;
	  }
	  if (!empty($_REQUEST['bkpwppath'])) {
		  if ($this->bkpwp_easy_mode()){
			  $_REQUEST['bkpwppath'] = bkpwp_conform_dir(ABSPATH).$_REQUEST['bkpwppath'];
		  }
		  if (!eregi(bkpwp_conform_dir(ABSPATH),$_REQUEST['bkpwppath'])) {
			  delete_option("bkpwppath");
			  $msg = __("Path is not within your webroot. Please specify a writable directory inside ","bkpwp").bkpwp_conform_dir(ABSPATH).".";
			  bkpwp_display_message($msg);
		  } elseif (bkpwp_conform_dir($_REQUEST['bkpwppath']) == bkpwp_conform_dir(ABSPATH)."/wp-content") {
			  delete_option("bkpwppath");
			  $msg = __("Do not use your wp-content directory for backup storage. Specify a writable directory inside ","bkpwp").bkpwp_conform_dir(ABSPATH)." that doen't need to be accessible by unauthenticated users.";
			  bkpwp_display_message($msg);
		  } else {
			  if (!is_dir($_REQUEST['bkpwppath'])) {
				  if (!mkdir($_REQUEST['bkpwppath'],0777))  {
					$this->bkpwp_delete_option("bkpwppath");
					$msg = __("Wrong Backup Path. Directory does not exist and this script was not able to create it.","bkpwp");
					bkpwp_display_message($msg);
				  } else {
					$this->bkpwp_update_option("bkpwppath",$_REQUEST['bkpwppath']);
					$msg = __("Directory did not exist but this script was able to create it.","bkpwp");
					bkpwp_display_message($msg." <a href=\"admin.php?page=".$_REQUEST['page']."\">".__("Continue","bkpwp")." &raquo;</a>");
				  }
			  } elseif (!is_writable($_REQUEST['bkpwppath'])) {
				$this->bkpwp_delete_option("bkpwppath");
				$msg = __("Directory does exist but is not writable by the webserver. Check directory permissions (e.g.: chmod 777).","bkpwp");
				bkpwp_display_message($msg);
			  }  else {
				$this->bkpwp_update_option("bkpwppath",$_REQUEST['bkpwppath']);
					bkpwp_display_message(__("Backup Path saved.","bkpwp")." <a href=\"admin.php?page=".$_REQUEST['page']."\">".__("Continue","bkpwp")." &raquo;</a>");
					
			  }
		  }
	  }
	  if (!is_writable($this->bkpwp_path()) && empty($_REQUEST['bkpwppath'])) {
		$msg = __("Please configure the Backup path first. The field below should allready be filled with a recommendation for that option.","bkpwp");
		if ($suppress_msg == 0) {
		bkpwp_display_message($msg);
		}
	  }
    }
    
    function bkpwp_check_path() {
	    if (!$this->bkpwp_easy_mode()){
		    echo $this->bkpwp_path();
	    } else {
		if (!is_writable($this->bkpwp_path())) {
			echo $this->bkpwp_default_backup_path;
		} else {
			echo eregi_replace(bkpwp_conform_dir(ABSPATH),"",$this->bkpwp_path());
		}
	    }
    }
    
    function bkpwp_handle_backup_settings() {
	  if (!empty($_REQUEST['bkpwp_backup_options'])) {
		  $this->bkpwp_update_option("bkpwp_max_backups",$_REQUEST['bkpwp_max_backups']);
		  bkpwp_display_message(__("Settings saved.","bkpwp"));
	  }
    }
    
    function bkpwp_handle_backup_automail() {
	  if (!empty($_REQUEST['bkpwp_automailsettings'])) {
		  if (!empty($_REQUEST['bkpwp_automail'])) {
			  $this->bkpwp_update_option("bkpwp_automail",$_REQUEST['bkpwp_automail']);
			  if (empty($_REQUEST['bkpwp_automail_address'])) {
				  $_REQUEST['bkpwp_automail_address'] = $GLOBALS['userdata']->user_email;
			  }
			  $this->bkpwp_update_option("bkpwp_automail_address",$_REQUEST['bkpwp_automail_address']);
			  $this->bkpwp_update_option("bkpwp_automail_from",$GLOBALS['userdata']->user_email);
			  $this->bkpwp_update_option("bkpwp_automail_receiver",$GLOBALS['userdata']->user_nicename);
			  if (!empty($_REQUEST['bkpwp_automail_maxsize'])) {
				  $this->bkpwp_update_option("bkpwp_automail_maxsize",$_REQUEST['bkpwp_automail_maxsize']);
			  }
			  bkpwp_display_message(__("Settings saved.","bkpwp"));
		  } else {
			  $this->bkpwp_delete_option("bkpwp_automail_maxsize");
			  $this->bkpwp_delete_option("bkpwp_automail_address");
			  $this->bkpwp_delete_option("bkpwp_automail_receiver");
			  $this->bkpwp_delete_option("bkpwp_automail");
		  }
	  }
    }
    
    function bkpwp_handle_backup_excludelists() {
	  if (!empty($_REQUEST['nobackup']) && !empty($_REQUEST['excludelist'])) {
	  	$this->bkpwp_excludelist();
		bkpwp_display_message(__("New Backup Exclude List saved:","bkpwp")." ".$_REQUEST['excludelistname']);
	  } elseif (!empty($_REQUEST['nobackupchange']) && !empty($_REQUEST['excludelist'])) {
	  	$this->bkpwp_excludelist();
		bkpwp_display_message(__("Backup Exclude List saved:","bkpwp")." ".$_REQUEST['excludelistname']);
	  } elseif (!empty($_REQUEST['nobackupdelete']) && !empty($_REQUEST['excludelist'])) {
	  	$this->bkpwp_delete_excludelist($_REQUEST['excludelistname']);
		bkpwp_display_message(__("Backup Exclude List deleted:","bkpwp")." ".$_REQUEST['excludelistname']);
	  }
    }
    
    function bkpwp_ls_exclusions($dir,$files=array()) {
    	$d = opendir($dir);
    	while ($file = readdir($d)) {
    		if ($file == '.' || $file == '..') { continue; }
    		$getfile = $this->bkpwp_match_excludelist($dir,$file);
    		if (!empty($getfile)) {
    			$files[] = $getfile;
    		}
    		if (is_dir($dir.'/'.$file)) {
    			if (!empty($getfile)) {
    				continue;
    			}
    			$files = $this->bkpwp_ls_exclusions($dir.'/'.$file, $files);
    		}
    	}
    	return $files;
    }
    
    function bkpwp_ajax_shownobfiles($listname,$dir="") {
    	if (empty($dir)) {
    		$dir = bkpwp_conform_dir(ABSPATH);
    	}
	$this->excludelist = urldecode($listname);
    	$ret = "";
    	$files = $this->bkpwp_ls_exclusions($dir);
    	$stringmatches = array();
	
	
	$ret .= "<p>";
	$ret .= __("Folders","bkpwp")."<br />";
    	foreach($files as $f) {
    		if (is_dir($f['file'])) {
			$ret .= "<b>".$f['file']."</b>: ".__("matched by","bkpwp")." ".$f['match']." -> ".$f['value']."<br />";
    		} else {
    			if ($f['match'] == "string") {
    				$t = $f['value'];
    				$stringmatches[$t]++;
    			}
    		}
    	}
	$ret .= "</p>";
	
	if (count($stringmatches) > 0) {
		$ret .= "<p>";
		$ret .= __("Files","bkpwp")."<br />";
		foreach($stringmatches as $s=>$t) {
			$ret .= "<b>".$t."</b> ".__("files matched by","bkpwp")." ".$s."<br />";
		}
		$ret .= "</p>";
    	}
	
    	return $ret;
    }

    function bkpwp_ls($dir,$files=array()) {
    	$d = opendir($dir);
    	$j=0;
    	while ($file = readdir($d)) {
    		if ($file == '.' || $file == '..') { continue; }
    		$getfile = $this->bkpwp_match_excludelist($dir,$file);
    		if (!empty($getfile)) {
    			continue;
    		}
    		$files[] = $dir.'/'.$file;
    		if (is_dir($dir.'/'.$file)) {
    			if (!empty($getfile)) {
    				continue;
    			}
    			$files = $this->bkpwp_ls($dir.'/'.$file,$files); $j++;
    		}
    	}
    	return $files;
    }
    
    function bkpwp_match_excludelist($dir,$file) {
	$nobfiles = $this->bkpwp_get_excludelist($this->excludelist);
	$nobfiles['list'][] = get_option("bkpwppath");
    	if (is_array($nobfiles['list'])) {
    	    foreach($nobfiles['list'] as $n) {
	    	if (empty($n)) { continue; }
	    	$ifpath = str_replace("\\","/",$n);
		$absolutefilepath = str_replace("\\","/",$dir.'/'.$file);
		$relativefilepath = str_replace(ABSPATH,"",$absolutefilepath);
    		if (($ifpath == $absolutefilepath) || ($ifpath == $relativefilepath)) { 
    		    return array('file' => $dir.'/'.$file, 'match' => 'path', 'value' => $n);
    		} elseif (!strpos("/",$ifpath) && stristr($file,$n)) { 
    		    return array('file' => $dir.'/'.$file, 'match' => 'string', 'value' => $n);
    		}
    	    }
    	}
    	return false;
    }

    function bkpwp_get_excludelists() {
	    $allnobs = get_option("bkpwp_excludelists");
	    $user = $GLOBALS['userdata']->user_login;
	    if(empty($user)) { $user = "admin"; }
	    return $allnobs[$user];
    }
    
    function bkpwp_get_excludelist($listname) {
	    $usernoblists = $this->bkpwp_get_excludelists();
	    if(!is_array($usernoblists)) { return; }
	    foreach($usernoblists as $f) {
		    if ($f['listname'] == $listname) {
			    return $f;
		    }
	    }
    }
    
    function bkpwp_excludelist_tochange() {
	    if (!empty($_REQUEST['excludelist_to_change'])) {
		    return $this->bkpwp_get_excludelist($_REQUEST['excludelist_to_change']);
	    }
    
	    if (!empty($_REQUEST['excludelistname'])) {
		    return $this->bkpwp_get_excludelist($_REQUEST['excludelistname']);
	    }
    }
    
    function bkpwp_delete_excludelist($listname) {
	    $allnobst = get_option("bkpwp_excludelists");
	    $user = $GLOBALS['userdata']->user_login;
	    if(empty($user)) { $user = "admin"; }
	    $allnobs = array();
	    if (!is_array($allnobst[$user])) {
		    $allnobst[$user] = array();
	    }
	    foreach ($allnobst[$user] as $a) {
		    if ($a['listname'] != $listname) {
			    $allnobs[$user][] = $a;
		    }
	    }
	    
	    update_option("bkpwp_excludelists",$allnobs);
    }
    
    function bkpwp_save_excludelist($list,$listname,$listtype) {
	    $allnobst = get_option("bkpwp_excludelists");
	    $user = $GLOBALS['userdata']->user_login;
	    if(empty($user)) { $user = "admin"; }
	    $allnobs = array();
	    if (!is_array($allnobst[$user])) {
		    $allnobst[$user] = array();
	    }
	    foreach ($allnobst[$user] as $a) {
		    if ($a['listname'] != $listname) {
		    $allnobs[$user][] = $a;
		    }
	    }
	    $allnobs[$user][] = array("listname" => $listname,
	    			      "listtype" => $listtype,
	    			      "list" => $list);
				      
	    update_option("bkpwp_excludelists",$allnobs);
    }

    function bkpwp_excludelist($excludelist="",$excludelistname="",$excludelisttype="") {
	$list = array();
	$list[] = $this->bkpwp_path();
	if (!empty($_REQUEST['excludelist'])) {
		$excludelist = $_REQUEST['excludelist'];
	}
	foreach($excludelist as $r) {
		if (eregi(",",$r)) {
			$re=explode(",",$r);
			foreach($re as $e) {
				if (!empty($e)) {
				$list[] = $e;
				}
			}
		} else {
			if (!empty($r)) {
			$list[] = $r;
			}
		}
	}
	$list = array_unique($list);
	if (!empty($_REQUEST['excludelistname'])) {
		$excludelistname = $_REQUEST['excludelistname'];
	}
	if (empty($excludelistname)) {
		$excludelistname = "excl_".date("Y-m-d-H-i-s");
	}
	$this->bkpwp_save_excludelist($list,$excludelistname,$excludelisttype);
    }

    function bkpwp_check_compression_type($archive_types_wishlist) {
    	$a = array();
    	foreach($archive_types_wishlist as $at) {
    		if (function_exists($at['func']) || empty($at['func'])) {
    			$a[] = $at['ext'];
    		}
    	}
    	return $a;
    }

	function bkpwp_add_capabilities() { 
	      global $wp_roles; 
	      $wp_roles->add_cap('administrator','manage_backups', true);
	      $wp_roles->add_cap('administrator','download_backups', true);
	} 
	
    function bkpwp_default_archive_types() {
	    // a wishlist of compression types
	$archive_types_wishlist = array();
	$archive_types_wishlist[] = array("ext" => "zip",	"func" => ""); // pear package file_archive's own
	$archive_types_wishlist[] = array("ext" => "tgz",	"func" => "gzopen");
	$archive_types_wishlist[] = array("ext" => "tar.gz",	"func" => "gzopen");
	$archive_types_wishlist[] = array("ext" => "tar",	"func" => ""); // pear package file_archive's own
	$archive_types_wishlist[] = array("ext" => "tar.bz2",	"func" => "bzopen");
	
	// run a check if the respective compression is supported by this php installation
	$archive_types = $this->bkpwp_check_compression_type($archive_types_wishlist);
	update_option("bkpwp_archive_types",$archive_types);
    }
    
    function bkpwp_get_backup_type($f) {
    	$ex = explode(".",$f);
    	$ex = explode("-",$ex[0]);
    	$type = $ex[6];
    	if (eregi("_adv",$type)) {
    		$type = eregi_replace("_adv","",$type);
    		$type .= " - advanced";
    	}
    	return $type;
    }

    function bkpwp_default_excludelists() {
        $defaults = new BKPWP_OPTIONS();
	$presetso = new BKPWP_MANAGE();
	// Excludelists Defaults
	$excludelist[] = ".tmp,~,.bak,#";
	$excludelistname = "temporary and autosave files";
	$excludelisttype = "default";
	$defaults->bkpwp_excludelist($excludelist,$excludelistname,$excludelisttype);
    }
    
    function bkpwp_default_presets() {
	// Preset defaults
	// is set for the current user.
	//update_option("bkpwp_presets","");
	$presetso = new BKPWP_MANAGE();
	$presets = $presetso->bkpwp_get_presets();
	if (count($presets) < 1) {
		$presets = array();
		// full backup
		$options = array("bkpwp_archive_type" => 'tar.gz',
			         "default" => 1,
				 "bkpwp_excludelist" => $excludelistname);
		$presets[] = array("bkpwp_preset_name" => "full backup",
				   "bkpwp_preset_options" => $options);
		// sql only
		$options = array("bkpwp_sql_only" => 1,
				 "bkpwp_archive_type" => 'tar.gz',
			         "default" => 1);
		$presets[] = array("bkpwp_preset_name" => "sql only",
				   "bkpwp_preset_options" => $options);
		$presetso->bkpwp_update_presets($presets);
	}
    }
    
    function bkpwp_default_schedules() {
	
	// scheduling defaults
	$schedules = get_option("bkpwp_schedules");
	if (!is_array($schedules)) {
		$schedules = array();
		$schedules[] = array("preset" => "full backup",
					"status" => "inactive",
					"reccurrence" => 'bkpwp_weekly',
					"info" => __("Full Backup Weekly","bkpwp"),
					"default" => 1,
					"created" => date("Y-m-d-H-i-s"));
				sleep(2);
		$schedules[] = array("preset" => "sql only",
					"status" => "inactive",
					"reccurrence" => 'bkpwp_daily',
					"info" => __("SQL Only Backup Daily","bkpwp"),
					"default" => 1,
					"created" => date("Y-m-d-H-i-s"));
		update_option("bkpwp_schedules",$schedules);
	}
    }
    
    function bkpwp_set_defaults() {
	// set a few options
	update_option('bkpwp_listmax_backups',15);
	update_option('bkpwp_max_backups',10);
	update_option("bkpwp_domain","bkpwp");
	update_option("bkpwp_install_user",$GLOBALS['userdata']->user_login);
	update_option("bkpwp_domain_path","wp-content/plugins/bkpwp/locale");
	
	 $user = $GLOBALS['userdata']->user_login;
	 if(empty($user)) { $user = "admin"; }
	 if (!$this->bkpwp_easy_mode()) {
	    $easy_mode[$user] = 1;
	 } else {
	    $easy_mode[$user] = "";
	 }
	 
	 update_option("bkpwp_easy_mode",$easy_mode);
	
	$this->bkpwp_default_archive_types();
	$this->bkpwp_default_excludelists();
	$this->bkpwp_default_presets();
	$this->bkpwp_default_schedules();
	$this->bkpwp_add_capabilities();
    }
}
?>
