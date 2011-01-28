<?php	
$options = new BKPWP_OPTIONS();
$bkpwppath = get_option("bkpwppath");
?>
<div class="wrap">
	<?php 
	 if (!empty($_REQUEST['bkpwp_toggle_schedule_active'])) {
		 ?>
		<div id="message" class="updated fade">
		<p><?php
		 $schedule = new BKPWP_SCHEDULE();
		 $ret = $schedule->bkpwp_toggle_schedule($_REQUEST['bkpwp_toggle_schedule_active']);
		 if($ret) {
			 _e("Schedule activity status set to","bkpwp");
			 echo " <b>";
			 if ($ret == "active") {
				 _e("active","bkpwp");
			 } else {
				 _e("inactive","bkpwp");
			 }
			 echo "</b>";
		 } else {
			 _e("Schedule activity status could not be set","bkpwp");
		 }
		 ?></p>
		</div>
		<p />
		<?php
	 }
	if (!empty($bkpwppath)) {
		if ($options->bkpwp_easy_mode()) { ?>
		<?php _e("You are running BackUpWordPress in ","bkpwp"); ?>
		<h2><?php _e("EasyMode","bkpwp"); ?>.</h2>
		<?php _e("Configuration options below","bkpwp"); ?>.
		<?php _e("For more options, please swith to ","bkpwp"); ?>
		<a href="admin.php?page=<?php echo $_REQUEST['page']; ?>&bkpwp_modeswitch=1"><?php _e("AdvancedMode","bkpwp"); ?> &raquo;</a>
	<?php } else { ?>
		<?php _e("You are running BackUpWordPress in ","bkpwp"); ?>
		<h2><?php _e("AdvancedMode","bkpwp"); ?>.</h2>
		<?php _e("Configuration options below","bkpwp"); ?>.
		<?php _e("For less options, please swith to ","bkpwp"); ?>
		<a href="admin.php?page=<?php echo $_REQUEST['page']; ?>&bkpwp_modeswitch=1"><?php _e("EasyMode","bkpwp"); ?> &raquo;</a>
	<?php }
	}
	?>
	<?php $options->bkpwp_handle_backup_path(); ?>
	<h2><?php _e("Backup Path","bkpwp"); ?></h2>
	<p>
	  <?php _e("This is where all your backups go","bkpwp"); ?>
	<form name="form1" method="post" action="admin.php?page=<?php echo $_REQUEST['page']; ?>">
	  <fieldset>
	  <?php  if ($options->bkpwp_easy_mode()) { echo bkpwp_conform_dir(ABSPATH); } ?>
	  <input type="text" size="50" value="<?php $options->bkpwp_check_path(); ?>" name="bkpwppath" />
	  <input type="submit" class="button" value="<?php _e("save","bkpwp"); ?>" />
	  </fieldset>
	</form>
	</p>
	<?php
	if (!empty($bkpwppath)) {
	?>
	<a name="backup_options"></a>
	<?php $options->bkpwp_handle_backup_settings(); ?>
	<h2><?php _e("Basic Scheduling","bkpwp"); ?></h2>
	<p>
	  <?php _e("Do you want BackUpWordPress to be scheduled and run automatically?","bkpwp"); ?>
	 </p>
	  <p>
	  <?php
	  $schedules = get_option("bkpwp_schedules");
	  if (is_array($schedules)) {
		  foreach($schedules as $s) {
			  if ($s['default'] != 1) { continue; }
				if (!empty($s['status'])) {
					echo __("Backup Type","bkpwp").": ".$s['info'].": ";
					if ($s['status'] == "inactive") {
						echo __("is not activated","bkpwp")." <a href=\"admin.php?page=".$_REQUEST['page']."&amp;bkpwp_toggle_schedule_active=".$s['created']."\">".__("activate","bkpwp")." &raquo;</a>";
					} else {
						echo __("is currently set to active","bkpwp")." <a href=\"admin.php?page=".$_REQUEST['page']."&amp;bkpwp_toggle_schedule_active=".$s['created']."\">".__("deactivate","bkpwp")." &raquo;</a>";
					}
				}
				echo "<br />";
		  }
	  }
	  ?>
	</p>
	<a name="backup_automail"></a>
	<?php 
	$options->bkpwp_handle_backup_automail();
	$bkpwp_automail = get_option("bkpwp_automail");
	$bkpwp_automail_address = get_option("bkpwp_automail_address");
	?>
	<h2><?php _e("Mail Setup","bkpwp"); ?></h2>
	<p>
	  <?php _e("Do you want to receive your backups automatically by email?","bkpwp"); ?>
	<form name="form1" method="post" action="admin.php?page=<?php echo $_REQUEST['page']; ?>">
	  <fieldset>
	  <?php  if ($options->bkpwp_easy_mode()) {  } ?>
	  <p><?php _e("Mail to:","bkpwp"); ?><b> <?php _e("Please seperate multiple email addresses with kommas.","bkpwp"); ?></p>
	  <p><input type="text" size="55" value="<?php if (empty($bkpwp_automail_address)) { echo $GLOBALS['userdata']->user_email; } else { echo $bkpwp_automail_address; } ?>" name="bkpwp_automail_address" /></b></p>
	  <p><input type="checkbox" size="50" value="1" name="bkpwp_automail" <?php if(!empty($bkpwp_automail)) { echo " checked"; } ?> />
	  <?php _e("Yes, send me my backups","bkpwp"); ?></p>
	  <p><?php _e("as long as they are smaller than","bkpwp"); ?> 
	  <input type="text" size="4" value="<?php echo get_option("bkpwp_automail_maxsize"); ?>" name="bkpwp_automail_maxsize" />
	  <?php _e("MB (megabytes)","bkpwp"); ?></p>
	  <input type="submit" class="button" name="bkpwp_automailsettings" value="<?php _e("save","bkpwp"); ?>" />
	  </fieldset>
	</form>
	</p>
	<?php
	  }
	  ?>
	
<?php if (!$options->bkpwp_easy_mode()) { // AdvancedMode
	?>
	<a name="backup_options"></a>
	<?php $options->bkpwp_handle_backup_settings(); ?>
	<legend><h2><?php _e("Backup Storage","bkpwp"); ?></h2></legend>
	<p>
	  <?php _e("How many Backups do you want to keep?","bkpwp"); ?>
	<form name="form1" method="post" action="admin.php?page=<?php echo $_REQUEST['page']; ?>">
	  <fieldset>
	  <label for"bkpwp_max_backups">
	  <?php _e("maximum Backups","bkpwp"); ?> <input type="text" size="3" value="<?php 
	  echo get_option("bkpwp_max_backups"); ?>" name="bkpwp_max_backups" id="bkpwp_max_backups" />
	  </label>
	  <p style="text-align:left" class="submit">
	  <input type="submit" name="bkpwp_backup_options" value="<?php _e("save","bkpwp"); ?>" />
	  </p>
	  </fieldset>
	</form>
	</p>
	  
	<a name="excludelist"></a>
	<legend><h2><?php _e("Exclude Lists","bkpwp"); ?></h2></legend>
	</p>
	<?php $options->bkpwp_handle_backup_excludelists(); ?>
	  <?php
	  if (is_array($options->bkpwp_get_excludelists())) {
		  if (!empty($_REQUEST['excludelist_to_change'])) {
		  $listn = $_REQUEST['excludelist_to_change'];
		  }
		  if (!empty($_REQUEST['excludelistname'])) {
		  $listn = $_REQUEST['excludelistname'];
		  }
	  ?>
		<script type="text/javascript">
		function do_show_nobfiles() {
			x_bkpwp_ajax_shownobfiles('<?php echo urlencode($listn); ?>',"","");
		}
		function do_show_nobfiles2() {
		 ajax =  new Ajax.Updater(
			 'bkpwp_action_buffer',        // DIV id must be declared before the method was called
			 '<?php echo get_bloginfo("wpurl")."/wp-admin/admin.php?page=backupwordpress/backupwordpress.php"; ?>',        // URL
			 {                // options
			 method:'post',
			 postBody:'bkpwp_view_excludelist=<?php echo $listn; ?>'
			     });
		}
		function loading_shownobfiles() {
			document.getElementById('bkpwp_actions').style.display="block";
			document.getElementById('bkpwp_action_title').innerHTML="<br /><?php _e("Files &amp; Folders that will NOT (!) be included in the Backup when using ","bkpwp"); echo $_REQUEST['excludelist_to_change']; ?><br /><br />";
			document.getElementById('bkpwp_action_buffer').innerHTML="<img src='<?php bloginfo("wpurl"); ?>/wp-content/plugins/backupwordpress/images/loading.gif' />";
		}
		</script>
		<div id="bkpwp_actions" style="display:none;">
		<div id="bkpwp_action_title"></div>
		<div id="bkpwp_action_buffer"></div>
		<br /><br />
		</div>
	 <?php
	  }
	  ?>
	  <?php if (is_array($options->bkpwp_get_excludelists())) { ?>
          <form name="form_excl_lists" method="post" action="admin.php?page=<?php echo $_REQUEST['page']; ?>#excludelist">
	  <?php } ?>
	  <form name="form1" method="post" action="admin.php?page=<?php echo $_REQUEST['page']; ?>#excludelist">
	<fieldset>
	  <?php _e("Edit an existing Exclude List","bkpwp"); ?>
	  <select name="excludelist_to_change" onchange="document.form_excl_lists.submit();">
	  	<option value=""><?php _e("Please select","bkpwp"); ?></option>
	  	  <?php foreach($options->bkpwp_get_excludelists() as $f) { ?>
			  <option value="<?php echo $f['listname']; ?>"<?php
			  if ($listn == $f['listname']) {
				  echo " selected";
			  }
			  ?>><?php echo $f['listname']; ?></option>
		  <?php } ?>
	  </select> 
          </form><br /><br />
	  <?php if (!empty($_REQUEST['excludelist_to_change']) || !empty($_REQUEST['excludelistname'])) { 
		  $list = $options->bkpwp_excludelist_tochange();
	  ?>
	  
		  <?php if ($list['listtype'] != "default") { ?>
		  <b><?php _e("Exclude List Name","bkpwp"); ?></b> 
		  <p><input type="text" value="<?php echo $list['listname']; ?>" name="excludelistname" size="20" /></p>
		  <?php
		  }
		  if (is_array($list['list'])) {
			_e("Files to exclude","bkpwp");
			?><br /><?php
		  foreach($list['list'] as $f) {
			  if ($f != $options->bkpwp_path()) {
			  ?>
			  <input type="text" name="excludelist[]" value="<?php echo $f; ?>" size="50" />*<br />
			  <?php }
		   }
		  }?>
		  <?php if ($list['listtype'] != "default") { ?>
		  <p style="text-align:left" class="submit"><input name="nobackupchange" type="submit" value="<?php _e("save","bkpwp"); ?>" /> <input name="nobackupdelete" type="submit" value="<?php _e("delete","bkpwp"); ?>" />
		  <?php } else { ?>
			  <p><?php _e("this is a Default Exclude List","bkpwp"); ?>
		  <?php } ?>
		  <button class="button" onclick="loading_shownobfiles(); do_show_nobfiles2(); return false;">&raquo; <?php _e("Show excluded files","bkpwp"); ?></button>
		  </p>
	  <?php } else { ?>
		  <h4><?php _e("New Exclude List","bkpwp"); ?></h4>
		  <?php _e("Name","bkpwp"); ?> <input type="text" name="excludelistname" size="20" /><br />
		  <?php _e("Files to exclude","bkpwp"); ?> <input type="text" name="excludelist[]" size="50" />*<br />
		  <p style="text-align:left" class="submit"><input name="nobackup" type="submit" value="<?php _e("save","bkpwp"); ?>" /></p>
	  <?php } ?>
	  </fieldset>
          </form>
	  *<?php _e("enter an <b>absolute or relative path</b> to your folders/ files not to backup","bkpwp"); ?><br />
	  <?php _e("or <b>just names or file-extensions (.php, .txt) which should match files</b>","bkpwp"); ?>,<br />
	  <?php _e("no need to take care of the <b>backup folder</b>, it <b>will be excluded anyways","bkpwp"); ?></b>.<br />
	  <?php _e("Seperate with commas.","bkpwp"); ?><br/><br/>
	</p>
<?php } ?>
</div>

