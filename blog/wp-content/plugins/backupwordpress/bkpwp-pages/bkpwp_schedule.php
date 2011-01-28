<?php
function bkpwp_schedulelist($bkpwppath) {
	$backups = new BKPWP_MANAGE();	
	$backups->options = new BKPWP_OPTIONS();
	
	echo "<h2>".__("Manage Backup Schedules","bkpwp")."</h2>";
	echo "<p>".__("Info: Creating custom schedules is on the wishlist for BackUpWordPress 2.0.","bkpwp")."</p>";
	?>
	<script type="text/javascript">
	
	<!-- ajax call for calculating disk space usage -->
	function calculate2() {
		var preset;
		<?php if (!$backups->options->bkpwp_easy_mode()) { ?>
			preset = document.getElementById('bkpwp_preset').value;
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
	<div id="bkpwp_actions" style="display:none;">
	<div id="bkpwp_action_title"></div>
	<div id="bkpwp_action_buffer"></div>
	</div>
	<input type="hidden" name="bkpwp_preset" id="bkpwp_preset" value="" />
				
	<form name="form1" method="post" action="admin.php?page=<?php echo $_REQUEST['page']; ?>">
	  <fieldset>
	  <input class="button" type="submit" name="bkpwp_reset_schedules" value="<?php _e("reset default schedules","bkpwp"); ?> &raquo;" />
	  <input class="button" type="submit" name="bkpwp_test_schedule" value="<?php _e("test schedules","bkpwp"); ?> &raquo;" />
	  </fieldset>
	</form>
	<?php
	$schedules = get_option("bkpwp_schedules");
	?>
	<table class="widefat">
		<thead>
		<tr>
		<th style="text-align: center;" scope="col"><?php _e("Last run","bkpwp"); ?></th>
		<th style="text-align: center;" scope="col"><?php _e("Next run","bkpwp"); ?></th>
		<th style="text-align: center;" scope="col"><?php _e("Countdown","bkpwp"); ?></th>
		<th scope="col"><?php _e("Backup Preset","bkpwp"); ?></th>
		<th scope="col"><?php _e("Reccurrence","bkpwp"); ?></th>
		<th style="text-align: center;" colspan="3" scope="col"><?php _e("Action","bkpwp"); ?></th>
		</tr>
		</thead>
		<tbody id="the-list">
		<?php
		$alternate = "alternate";
		$i=1;
		foreach ($schedules as $options) {
			$timestamp = wp_next_scheduled("bkpwp_schedule_bkpwp_hook",$options);
			if ($alternate == "") { $alternate = "alternate"; } else { $alternate = ""; }
			?>
			<tr class="<?php echo $alternate; ?>">
				<th style="text-align: center;" scope="row"><?php
				$preset = $backups->bkpwp_get_preset($options['preset']);
				if (!empty($preset['bkpwp_preset_options']['bkpwp_lastrun'])) {
					echo date(get_option('date_format'),$preset['bkpwp_preset_options']['bkpwp_lastrun'])." ".date("H:i",$preset['bkpwp_preset_options']['bkpwp_lastrun']);
				} else {
					_e("Not Yet","bkpwp");
				}
				?></th>
				<td>
				<?php
				if (!empty($timestamp)) {
					echo date(get_option('date_format'),$timestamp)." ".date("H:i",$timestamp);
				}
				?>
				</td>
				<td>
				<?php 
				$now = time();
				$d = $timestamp - $now;
				if (!empty($timestamp)) { ?>
					<div id="countdowncontainer<?php echo $timestamp; ?>"></div>
					<script type="text/javascript">
					var futuredate=new cdtime("countdowncontainer<?php echo $timestamp; ?>", "<?php echo date("F j, Y H:i:s",$timestamp); ?>")
					<?php
					if ($d > "90000") {
					?>
					futuredate.displaycountdown("days", formatresultsd)
					<?php
					} else {
					?>
					futuredate.displaycountdown("hours", formatresultsh)
					<?php
					}
					?>
					</script>
				<?php } else { 
					if ($options['status'] == "inactive") {
						_e("Backup inactive.","bkpwp"); 
					} else {
						_e("Backup done.","bkpwp"); 
					}
				} ?>
				</td>
				<td>
				<?php
				echo $options['preset'];
				?>
				<a title="<?php _e("Recalculate Backup size","bkpwp"); ?>" 
				href="javascript:void(0);"
				onclick="document.getElementById('bkpwp_preset').value='<?php echo $options['preset'];  ?>'; bkpwp_js_loading('<?php _e("Calculating file sizes","bkpwp"); ?>'); calculate2(); return false;">&raquo;</a>
				</td>
				<td>
				<?php
				echo $options['info'];
				?>
				</td>
				<td style="text-align: center;">
				<?php
				if (!empty($options['status'])) {
					if ($options['status'] == "inactive") {
						echo " <a href=\"admin.php?page=".$_REQUEST['page']."&amp;bkpwp_toggle_schedule_active=".$options['created']."\">".__("activate","bkpwp")."</a>";
					} else {
						echo " <a href=\"admin.php?page=".$_REQUEST['page']."&amp;bkpwp_toggle_schedule_active=".$options['created']."\">".__("deactivate","bkpwp")."</a>";
					}
				}
				?>
				</td>
				<?php
				/* 
				wishlist for 2.0
				if (!empty($options['status'])) {
					echo " <a href=\"admin.php?page=".$_REQUEST['page']."&amp;bkpwp_edit_schedule=".$i."\">".__("edit","bkpwp")."</a>";
				} */
				?>
				<td style="text-align: center;">
				<?php
					echo " <a href=\"admin.php?page=".$_REQUEST['page']."&amp;bkpwp_delete_schedule=".$options['created']."\">".__("delete","bkpwp")."</a>";
				?>
				</td>
				<?php
			?>
			</tr>
			<?php
			if (!empty($options['status'])) {
				$i++;
			}
		}
	?>
	</tbody>
	</table>
	<?php
}

 $bkpwppath = get_option("bkpwppath");
	?>
        <div class="wrap">
	  <?php
	 if (!empty($_REQUEST['bkpwp_delete_schedule'])) {
		 ?>
		<div id="message" class="updated fade">
		<p><?php
		 $schedule = new BKPWP_SCHEDULE();
		 $ret = $schedule->bkpwp_delete_schedule_by_created($_REQUEST['bkpwp_delete_schedule']);
		 if($ret == 1) {
			 _e("Schedule deleted.","bkpwp");
		 } else {
			 _e("Schedule could not be deleted.","bkpwp");
		 }
		 ?></p>
		</div>
		<?php
	 }
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
		<?php
	 }
	 if (!empty($_REQUEST['bkpwp_reset_schedules'])) {
	 	// for some reason wp_clear_scheduled_hook("bkpwp_schedule_bkpwp_hook") doesn't work
		//wp_clear_scheduled_hook("bkpwp_schedule_bkpwp_hook");
	 	$schedule = new BKPWP_SCHEDULE();	
	   	$schedule->bkpwp_unset_schedules();
		
		delete_option("bkpwp_schedules");
		$options = new BKPWP_OPTIONS();
		$options->bkpwp_default_schedules();
		?>
		<div id="message" class="updated fade">
		<p><?php _e("Schedules reset to defaults. Please be patient, scheduling may take a few seconds to show up in the list below.","bkpwp"); ?></p>
		</div>
		<?php
	 }
	 if (!empty($_REQUEST['bkpwp_test_schedule'])) {
		$schedule = new BKPWP_SCHEDULE();
		?>
		<div id="message" class="updated fade">
		<p><?php 
		if ($schedule->bkpwp_test_schedule()) {
		_e("A schedule without reccurrence for one single Database Backup has been set up 
			and should execute with the first hit your Blog receives after 30 Seconds from now.","bkpwp");
		} else {
		_e("Testing schedules failed.","bkpwp");
		}
		?></p>
		</div>
		<?php
	 }
	 
	 if (!empty($_REQUEST['bkpwp_delete'])) {
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
			<input type="submit" name="bkpwp_delete_now" value="&raquo; <?php _e("go on, delete","bkpwp"); ?>" />
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
	  
	  if (!empty($bkpwppath) && is_dir($bkpwppath)) {
		  bkpwp_schedulelist($bkpwppath);
	  }
	  
	?>
        </div>
