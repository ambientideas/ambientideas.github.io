<?php

function bkpwp_presetlist() {
	
$backups = new BKPWP_MANAGE();
$backups->options = new BKPWP_OPTIONS();

$presets = $backups->bkpwp_get_presets();

	if ($backups->options->bkpwp_easy_mode()) { return; }
	if (!is_array($presets)) { return; }
	
	if (!empty($_REQUEST['mod_bkpwp_preset_name'])) {
		$preset = $backups->bkpwp_get_preset($_REQUEST['mod_bkpwp_preset_name']);
		echo $backups->bkpwp_load_preset($preset);
	}
	
  	/* delete the backup (but leave the logfile for a while!) */
	if (!empty($_REQUEST['bkpwp_delete_preset'])) {
		 $backups->bkpwp_delete_preset(urldecode($_REQUEST['bkpwp_delete_preset']));
	}
	
	if (!empty($_REQUEST['mod_bkpwp_preset_name'])) {
		 echo $backups->bkpwp_save_preset($_REQUEST['mod_bkpwp_preset_name'],$_REQUEST['mod_bkpwp_archive_type'],$_REQUEST['mod_bkpwp_excludelist'],$_REQUEST['mod_bkpwp_sql_only']);
		$backups = new BKPWP_MANAGE();
		$backups->options = new BKPWP_OPTIONS();
		$presets = $backups->bkpwp_get_presets();
	}
	?>
	<table class="widefat">
		<thead>
		<tr>
		<th scope="col"><?php _e("Preset Name","bkpwp"); ?></th>
		<th scope="col"><?php _e("Archive Type","bkpwp"); ?></th>
		<th scope="col"><?php _e("Exclude List","bkpwp"); ?></th>
		<th scope="col"><?php _e("SQL/Full","bkpwp"); ?></th>
		<th style="text-align: center;" colspan="3" scope="col"><?php _e("Action","bkpwp"); ?></th>
		</tr>
		</thead>
		<tbody id="the-list">
		<?php
		$alternate = "alternate";
		$i=0;
		
	foreach($presets as $p) {
		
		if ($alternate == "") { $alternate = "alternate"; } else { $alternate = ""; }
		?>
		<tr class="<?php echo $alternate; ?>">
			<th scope="row"><?php
		echo $p['bkpwp_preset_name'];
			?></th>
			<td>
			<?php
		echo $p['bkpwp_preset_options']['bkpwp_archive_type'];
			?>
			</td>
			<td>
			<?php
		if ($p['bkpwp_preset_options']['bkpwp_sql_only'] != 1) {
			echo $p['bkpwp_preset_options']['bkpwp_excludelist'];
		} else {
			echo "&nbsp;";
		}
			?>
			</td>
			<td>
			<?php
		if ($p['bkpwp_preset_options']['bkpwp_sql_only'] == 1) {
			echo "sql";
		} else {
			echo "full";
		}
			?>
			</td>
			<td style="text-align: center;">
			<?php
		echo " <a href=\"javascript:void(0)\"
			onclick=\"is_loading('bkpwp_action_buffer'); 
			ajax =  new Ajax.Updater(
				 'bkpwp_action_buffer', 
				 '".get_bloginfo("wpurl")."/wp-admin/admin.php?page=backupwordpress/backupwordpress.php"."',
				 {
				 method:'post',
				 postBody:'bkpwp_load_preset=".$p['bkpwp_preset_name']."'
				     });\">".__("edit","bkpwp")."</a>";
			?>
			</td>
			<td style="text-align: center;">
			<?php
		echo " <a href=\"javascript:void(0)\"
			onclick=\"is_loading('bkpwp_action_buffer'); 
			ajax =  new Ajax.Updater(
				 'bkpwp_action_buffer', 
				 '".get_bloginfo("wpurl")."/wp-admin/admin.php?page=backupwordpress/backupwordpress.php"."',
				 {
				 method:'post',
				 postBody:'bkpwp_view_preset=".$p['bkpwp_preset_name']."'
				     });\">".__("view","bkpwp")."</a>";
			?>
			</td>
			<td style="text-align: center;">
			<?php
			if ($p['bkpwp_preset_options']['default'] != 1) {
				echo " <a href=\"admin.php?page=bkpwp_manage_presets&amp;bkpwp_delete_preset=".$p['bkpwp_preset_name']."\">".__("delete","bkpwp")."</a>";
			} else {
				echo __("default","bkpwp");
			}
			?>
			</td>
			<?php
		?>
		</tr>
		<?php
		$i++;
	}
	?>
	</tbody>
	</table>
	<?php
}

	?>
        <div class="wrap">
	<script type="text/javascript">
		function is_loading(divid) {
			document.getElementById('bkpwp_actions').style.display = 'block';
			document.getElementById(divid).innerHTML="<img src='<?php bloginfo("url"); ?>/wp-content/plugins/backupwordpress/images/loading.gif' />";
		}
		<!-- displays a loading text information while doing ajax requests -->	
		function bkpwp_js_loading(str) {
			is_loading('bkpwp_action_buffer');
			document.getElementById('bkpwp_action_title').innerHTML="<h4>" + str + "</h4>";
		}
		</script>
	  <?php                                  
	  
	echo "<h2>".__("Manage Backup Presets","bkpwp")."</h2>";
	?>
	<p><?php _e("To create a new backup preset, edit one of the defaults and save with a new preset name.","bkpwp"); ?></p>
		<div id="bkpwp_actions" style="display:none;">
		<div id="bkpwp_action_title"></div>
		<div id="bkpwp_action_buffer"></div>
		</div>
	<div id="bkpwp_preset_options" style="display:block; margin-bottom: 10px;">
	</div>
	<?php
	bkpwp_presetlist();
	  
	?>
        </div>
