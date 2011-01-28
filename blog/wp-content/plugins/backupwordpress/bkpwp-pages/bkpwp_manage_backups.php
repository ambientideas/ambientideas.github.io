<?php
$backups = new BKPWP_MANAGE();
$backups->options = new BKPWP_OPTIONS();
$backup_archives = $backups->bkpwp_get_backups();

function bkpwp_restore() {
	if (empty($_REQUEST['bkpwp_restore_now'])) {
		?>
		<div id="message" class="updated fade">
		<p><?php 
		if (!eregi("-sql.tar.gz",base64_decode($_REQUEST['bkpwp_restore']))) {
		_e("For this version of BackUpWordPress it is only possible to restore the database itself.","bkpwp");
		echo "<br />";
		_e("For restoring uploaded Files, Plugins etc. we recommend downloading this archive and upload the respective files to your WordPress installations via FTP.","bkpwp");
		} else {
		_e("You are going to restore your database from the following archive now:","bkpwp")." ";
		_e("If you proceed, you will leave your WordPress Admin Area and enter the bigdump utility, where your entire database is beeing restored.","bkpwp");
		}
		?></p>
		<p>
		<?php
		echo base64_decode($_REQUEST['bkpwp_restore']);
		?>
		<form name="form1" method="post" action="">
		<input type="hidden" name="bkpwp_restore" value="<?php echo $_REQUEST['bkpwp_restore']; ?>" />
		<p style="text-align:left" class="submit">
		<input type="submit" name="bkpwp_restore_now" value="<?php _e("Restore the Database","bkpwp"); ?> &raquo;" />
		<?php
		if (!eregi("-sql.tar.gz",base64_decode($_REQUEST['bkpwp_restore']))) {
		?>
		<a href="admin.php?page=backupwordpress/backupwordpress.php&amp;bkpwp_download=<?php echo $_REQUEST['bkpwp_restore']; ?>"><?php _e("Download the Backup Archive for Files Recovery","bkpwp"); ?> &raquo;</a>
		<?php
		}
		?>
		</p>
		</form>
		</p><br />
		</div><br />
		<?php
	} else {
	  if(!eregi(get_option("bkpwppath"),base64_decode($_REQUEST['bkpwp_restore']))) {
		  // must be one of those in here!
		  return;
	  }
	  $source = File_Archive::read(base64_decode($_REQUEST['bkpwp_restore'])."/"); 
	  $error = array();
	  if (!empty($source)) {
		  $source->close();  //Move back to the begining of the source
		  while($source->next()) {
			  if (eregi(".sql",$source->getFilename())) {
				  //$filename = $source->getFilename();
		    		  $restoresql =  $source->getData();
				  	$bkpwppath = get_option("bkpwppath");
					$filename = $bkpwppath."/bkpwp_restore.sql";
					// delete an existing file
					if (is_readable($filename)) {
					 unlink($filename);
					}
					// write the new restore dump
					if (!$handle = fopen($filename, "a")) {
					    $error[] = $filename." ".__("cannot be opened from","bkpwp")." ".$bkpwppath."/";
					}
					if (!fwrite($handle, $restoresql)) {
					    $error[] = $filename." ".__("cannot be written to","bkpwp")." ".$bkpwppath."/";
					}
					// success
					fclose($handle);
				break;
			  }
		  }
	  }
	  if (is_readable($filename)) {
		 //restore with bigdump
		 ?>
		 <p><b><?php _e("Please do not reload the page until bigdump has done its job!","bkpwp"); ?></b></p>
		 <iframe width="100%" height="500" style="border:none;" src="<?php echo get_bloginfo("wpurl")."/wp-content/plugins/backupwordpress/bigdump/bigdump.php?start=1&fn=bkpwp_restore.sql&foffset=0&totalqueries=0"; ?>"></iframe>
		 <?php
		 exit;
	  }
	  
	  if (count($error) > 0) {
		?>
		<div id="message" class="updated fade">
		<p><?php _e("Some Errors occured while restoring from backup archive","bkpwp"); ?>:</p>
		<p>
		<?php
		foreach($error as $e) {
			echo $e."<br />";
		}
		?>
		</p>
		</div><br />
		<?php
	  } elseif (!empty($restoresql) && (count($error) < 1)) {
		?>
		<div id="message" class="updated fade">
		<p><?php _e("Backup file restored sucessfully from archive: ","bkpwp"); ?>:</p>
		<p>
		<?php
		echo base64_decode($_REQUEST['bkpwp_restore']);
		?>
		</p>
		</div><br />
		<?php
	  } else {
		?>
		<div id="message" class="updated fade">
		<p><?php _e("Recovery ERROR","bkpwp"); ?>:</p>
		<p>
		<?php _e("Backup Archive could not be read.","bkpwp"); ?>
		</p>
		</div><br />
		<?php
	  }
	}
}

function bkpwp_delete() {
	if (empty($_REQUEST['bkpwp_delete_now'])) {
	?>
	<div id="message" class="updated fade">
	<p><?php _e("Do you want to delete the backup archive","bkpwp"); ?></p>
	<p>
	<?php
	echo base64_decode($_REQUEST['bkpwp_delete']);
	?>
	<form name="form1" method="post" action="">
	<input type="hidden" name="bkpwp_delete" value="<?php echo $_REQUEST['bkpwp_delete']; ?>" />
	<p style="text-align:left" class="submit">
	<input type="submit" name="bkpwp_delete_now" id="bkpwp_delete_submit" value="<?php _e("delete","bkpwp"); ?> &raquo;" />
	<script type="text/javascript">
	 document.getElementById('bkpwp_delete_submit').focus();
	</script>
	</p>
	</form>
	</p><br />
	</div><br />
	<?php
	} else {
	  if(!eregi(get_option("bkpwppath"),base64_decode($_REQUEST['bkpwp_delete']))) {
		  // must be one of those in here!
		  return;
	  }
	  if (unlink(base64_decode($_REQUEST['bkpwp_delete']))) {
		?>
		<div id="message" class="updated fade">
		<p><?php _e("Backup file deleted sucessfully","bkpwp"); ?>:</p>
		<p>
		<?php
		echo base64_decode($_REQUEST['bkpwp_delete']);
		?>
		</p>
		</div><br />
		<?php
	  } else {
		?>
		<div id="message" class="updated fade">
		<p><?php _e("Backup file deletion failed","bkpwp"); ?>:</p>
		<p>
		<?php
		echo base64_decode($_REQUEST['bkpwp_delete']);
		?>
		</p>
		</div><br />
		<?php
	  }
	}
}

function bkpwp_mail() {
		
	$backupinfo = new BKPWP_BACKUP_ARCHIVE();
	$info = $backupinfo->bkpwp_view_backup_info($_REQUEST['bkpwp_mail'],1);
	$bkpwp_automail = get_option("bkpwp_automail");
	$bkpwp_automail_maxsize = get_option("bkpwp_automail_maxsize");
	if (empty($_REQUEST['bkpwp_mail_now']) && eregi("MB",$info['filesize'])) {
	?>
	<div id="message" class="updated fade">
	<p><?php _e("The BackUp Archive File you want to send is","bkpwp");  echo " <b>".$info['filesize']."</b> "; _e("large","bkpwp"); echo ".<br />"; ?>
	<?php _e("Do you really want to send this file by email?","bkpwp"); ?></p>
	<p>
	<?php
	echo base64_decode($_REQUEST['bkpwp_mail']);
	?>
	<form name="form1" method="post" action="">
	<input type="hidden" name="bkpwp_mail" value="<?php echo $_REQUEST['bkpwp_mail']; ?>" />
	<p style="text-align:left" class="submit">
	<input type="submit" name="bkpwp_mail_now" value="<?php _e("send","bkpwp"); ?> &raquo;" />
	</p>
	</form>
	</p><br />
	</div><br />
	<?php
	} else {
		if (!empty($bkpwp_automail)) {
			if ($bkpwp_automail_maxsize <= filesize(base64_decode($_REQUEST['bkpwp_mail']))) {
				$mailed = bkpwp_mail_now($_REQUEST['bkpwp_mail']);
			} else {
				$mailed = bkpwp_mail_now("");
			}
		}
		 if(isset($mailed)) {
			?>
			<div id="message" class="updated fade">
			<p><?php _e("Backup has been sent","bkpwp"); ?></p>
			<p>
			<?php
			echo base64_decode($_REQUEST['bkpwp_mail']);
			?>
			</p>
			</div><br />
			<?php
		 } else {
			?>
			<div id="message" class="updated fade">
			<p><?php _e("Error sending Backup by mail","bkpwp"); ?></p>
			<p>
			<?php
			echo base64_decode($_REQUEST['bkpwp_mail']);
			?>
			</p>
			</div><br />
			<?php
		 }
	}
}

?>
<div class="wrap">
  <?php
if (count($backup_archives) < 1) { 
	echo "<h4>".__("No Backups yet","bkpwp").".</h4>";
	$bwpwp_path = $backups->options->bkpwp_path();
	if (empty($bwpwp_path)) {
	echo "<a href=\"admin.php?page=bkpwp_options\">".__("Start by configuring the Options","bkpwp")."</a>";
	return; 
	}
}
?>
	<h2><?php _e("Manage Backups","bkpwp"); ?></h2>
	<script type="text/javascript">
	
	<!-- ajax call to the actual backup function -->
	function do_create2() {
		var preset;
		<?php if (!$backups->options->bkpwp_easy_mode()) { ?>
			preset = document.getElementById('bkpwp_preset').options[document.getElementById('bkpwp_preset').selectedIndex].value;
		<?php } else { ?>
			preset = "full backup";
		<?php } ?>
		 ajax =  new Ajax.Updater(
			 'bkpwp_action_buffer',        // DIV id must be declared before the method was called
			 '<?php echo get_bloginfo("wpurl")."/wp-admin/admin.php?page=backupwordpress/backupwordpress.php"; ?>',        // URL
			 {                // options
			 method:'post',
			 postBody:'bkpwp_docreate_preset='+preset
			     });
	}
	
	<!-- ajax call for calculating disk space usage -->
	function calculate2() {
		var preset;
		<?php if (!$backups->options->bkpwp_easy_mode()) { ?>
			preset = document.getElementById('bkpwp_preset').options[document.getElementById('bkpwp_preset').selectedIndex].value;
		<?php } else { ?>
			preset = "full backup";
		<?php } ?>
		 ajax =  new Ajax.Updater(
			 'bkpwp_action_buffer',        // DIV id must be declared before the method was called
			 '<?php echo get_bloginfo("wpurl")."/wp-admin/admin.php?page=backupwordpress/backupwordpress.php"; ?>',        // URL
			 {                // options
			 method:'post',
			 postBody:'bkpwp_calculate_preset='+preset
			     });
	}
	
	<!-- displays a loading text information while doing ajax requests -->	
	function bkpwp_js_loading(str) {
		document.getElementById('bkpwp_actions').style.display = 'block';
		is_loading('bkpwp_action_buffer');
		document.getElementById('bkpwp_action_title').innerHTML="<h4>" + str + "</h4>";
	}
	</script>
	<?php
	
	if (bkpwp_check_unfinished_backup()) {
	$status = get_option("bkpwp_status");
	?>
	<div id="message" class="updated fade">
		<p>
	<?php
		_e("Last Action of BackUpWordPress: ","bkpwp");
		_e("Creating Backup Archive: ","bkpwp");
		echo " ".$status['name'].". ";
		if ($status['type'] == "sqltable") {
			_e("Saving Database Table ","bkpwp");
			echo $status['point']." ";
		} elseif ($status['type'] == "sqltable_row") {
			$d = explode("-",$status['point']);
			_e("Saving data rows from table ","bkpwp");
			echo $d[0].". ";
			_e("Currently saving entries from row number","bkpwp");
			echo " ".$d[1]." ";
		} elseif ($status['type'] == "file") {
			_e("Saving File ","bkpwp");
			echo str_replace(get_option("bkpwp_path"),"",$status['point'])." ";
		}
		_e("at ","bkpwp");
		echo date(get_option('date_format'),$status['time'])." ".date("H:i:s",$status['time'])."</p><p>";
		
		$sincet = bkpwp_date_diff($status['time'],time());
		$since .= $sincet['days']." ".__("days","bkpwp")." ";
		$since .= $sincet['hours']." ".__("hours","bkpwp")." ";
		$since .= $sincet['minutes']." ".__("minutes","bkpwp")." ";
		$since .= $sincet['seconds']." ".__("seconds","bkpwp");
		_e("BackUpWordPress did not proceed with the current task since","bkpwp");
		echo " ".$since;
		?>
		</p>
		<p>
		<?php
		if (($status['time']+30) < time()) {
			_e("BackUpWordPress tries to proceed with this unfinished backup.");
			echo " ";
			_e("On a WordPress website with low traffic, reload the page a few times, to trigger the action.");
			echo "</p><p>";
			_e("If nothing happens for more than 5 minutes, deaktivate the plugin, install the newest version and activate again.","bkpwp");
		} else {
			_e("Please be patient.","bkpwp");
		}
		?>
		</p>
		<p>
		</p>
	</div>
	<?php
	} else {
	?>
		<div id="bkpwp_actions" style="display:none;">
		<div id="bkpwp_action_title"></div>
		<div id="bkpwp_action_buffer"></div>
		</div>
		<?php if (!$backups->options->bkpwp_easy_mode()) { ?>
		<?php $presets = $backups->bkpwp_get_presets();
		 if (is_array($presets)) { ?>
		 <p>
		<?php _e("Select a Preset.","bkpwp");  ?>
			<select name="bkpwp_preset" id="bkpwp_preset">
			<?php
			foreach ($presets as $p) {
				echo "<option value=\"".$p['bkpwp_preset_name']."\">".$p['bkpwp_preset_name']."</option>";
			}
			?>
			</select> <a href="admin.php?page=bkpwp_manage_presets"><?php _e("Configure","bkpwp"); ?> &raquo;</a>
		</p>
		<?php }
		} ?>
		<button class="button" onclick="bkpwp_js_loading('<?php _e("Your backup is being processed.","bkpwp"); ?>'); do_create2(); return false;"><?php _e("BackUp WordPress Now","bkpwp"); ?> &raquo;</button>
		<?php if (!$backups->options->bkpwp_easy_mode()) { ?>
			<button class="button" onclick="bkpwp_js_loading('<?php _e("Calculating used disk space","bkpwp"); ?>'); calculate2(); return false;"><?php _e("Recalculate Used Disk Space","bkpwp"); ?> &raquo;</button>
		<?php }
	} ?>
		
		
	<?php
  	/* delete the backup (but leave the logfile for a while!) */
	if (!empty($_REQUEST['bkpwp_delete'])) {
		bkpwp_delete();
	}
	/* mail the backup to someone */
	if (!empty($_REQUEST['bkpwp_mail'])) {
		bkpwp_mail();
	}
	if (!empty($_REQUEST['bkpwp_restore'])) {
		bkpwp_restore();
	}
	
	?>
		
	  	<br /><br />
		<?php if (!$backups->options->bkpwp_easy_mode()) { ?>
			<?php _e("Your configuration is set to a maximum of","bkpwp"); ?>
			<?php echo get_option('bkpwp_max_backups'); ?>
			<?php _e("Backups.","bkpwp"); ?>
			<a href="admin.php?page=bkpwp_options#backup_options"><?php _e("Configure","bkpwp"); ?> &raquo;</a>
			<br /><br />
		<?php } ?>
		<?php if (count($backup_archives) > $backups->bkpwp_max_views()) { ?>
			<?php _e("displaying the last","bkpwp"); ?>
			<?php echo $backups->bkpwp_max_views(); ?>
			<?php _e("Backups.","bkpwp"); ?>
			<?php echo count($backup_archives); ?>
			<?php _e("Backups at all.","bkpwp"); ?>
			<a href="admin.php?page=<?php echo $_REQUEST['page']; ?>&amp;bkpwp_show_all=1"><?php _e("Show all","bkpwp"); ?> &raquo;</a>
			<br /><br />
		<?php } ?>
		<table class="widefat" id="bkpwp_manage_backups_table">
			<thead>
			<tr>
			<th scope="col"><?php _e("Date/Time","bkpwp"); ?></th>
			<th scope="col"><?php _e("Type","bkpwp"); ?></th>
			<?php if (!$backups->options->bkpwp_easy_mode()) { ?>
			<th scope="col"><?php _e("Preset","bkpwp"); ?></th>
			<?php } ?>
			<th scope="col"><?php _e("Size","bkpwp"); ?></th>
			<th style="text-align: center;" colspan="5" scope="col"><?php _e("Action","bkpwp"); ?></th>
			</tr>
			</thead>
			<tbody id="the-list">
			<?php
			$alternate = "alternate";
			?>
			<tr class="<?php echo $alternate; ?> bkpwp_manage_backups_newrow" id="bkpwp_manage_backups_newrow" style="display:none;">
				<td colspan="7">
				</td>
			</tr>
			<?php
			$i=0;
			if (is_array($backup_archives)) {
				foreach ($backup_archives as $f) {
					if (!file_exists($f['file'])) {
						continue;
					}
					if ($i > $backups->bkpwp_max_views()) {
						break;
					}
					if ($alternate == "") { $alternate = "alternate"; } else { $alternate = ""; }
					$backup = new BKPWP_BACKUP_ARCHIVE();
					$backup->bkpwp_get_backup_row($f,$alternate);
					$i++;
				}
			}
			?>
		</tbody>
		</table>
</div>
