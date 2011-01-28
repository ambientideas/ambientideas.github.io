<?php
$options = new BKPWP_OPTIONS();
?>
<div class="wrap">
	<a name="help_top"></a>
	<h2><?php _e("BackUpWordPress Help","bkpwp"); ?></h2>
	
		<?php if (!$options->bkpwp_easy_mode()) { ?>
		<?php bkpwp_help_zeitgeist(); ?>
		<a name="help_manage_backups"></a>
		<?php } ?>
		
		<h3><?php _e("Manage Backups","bkpwp"); ?></h3>
		<?php if (!$options->bkpwp_easy_mode()) { ?>
		<a href="#help_top"><?php _e("Help Index","bkpwp"); ?></a>
		<?php } ?>
			<p>
			<?php _e("BackUpWordPress creates backup archives within a backup repository. 
				It saves all your WordPress files as well as your Database for recovery purposes.","bkpwp"); ?>
			</p>
		<?php if ($options->bkpwp_easy_mode()) { ?>
			<p>
			<?php
			_e("BackUpWordPress keeps a number of","bkpwp");
			echo " ".get_option("bkpwp_max_backups")." ";
			_e("backup archives in the backup repository.","bkpwp");
			echo " ";
			_e("As soon as this amount of backup archives in the repository is reached, 
				every next backup will cause the oldest backup archive to be deleted.","bkpwp");
			?>
			</p>
			<p>
			<?php _e("There are two ways of doing backups:","bkpwp"); ?>
			<ol>
				<li><?php _e("You can run BackUpWordPress manually by hitting the \"BackUpWordPress Now\" button.","bkpwp"); ?></li>
				<p><?php _e("This will create a full backup of your WordPress installation. Depending on the amount and size of your files it might take a while.","bkpwp"); ?></p>
				<li><?php _e("You can download your backups for archiving purposes","bkpwp"); ?></li>
				<li><?php _e("You can restore your database and/or files","bkpwp"); ?></li>
			</ol>
			</p>
			<p>
			<?php _e("For more information, please swith to ","bkpwp"); ?>
			<a href="admin.php?page=<?php echo $_REQUEST['page']; ?>&bkpwp_modeswitch=1"><?php _e("AdvancedMode","bkpwp"); ?> &raquo;</a>
			</p>
		<?php } else { ?>
			<p>
			<?php
			_e("By default, BackUpWordPress keeps a number of","bkpwp");
			echo " ".get_option("bkpwp_max_backups")." ";
			_e("backup archives in the backup repository. You can alter this number within the Advanced Backup Settings. ","bkpwp");?>
			<br /><a href="admin.php?page=bkpwp_options#backup_options"><?php _e("Configure","bkpwp"); ?> &raquo;</a>
			</p>
			<p>
			<?php _e("As soon as this amount of backup archives in the repository is reached, 
				every next backup will cause the oldest backup archive to be deleted.","bkpwp");
			?>
			</p>
			<p>
			<?php _e("Basically, there are two ways of doing backups:","bkpwp"); ?>
			<ol>
				<li><?php _e("You can run BackUpWordPress manually by hitting the \"BackUpWordPress Now\" button.","bkpwp"); ?></li>
				<li><?php _e("You can activate scheduling, which will run weekly backups of your databse and monthly backups of your WordPress installations directory and file structure automatically.","bkpwp"); ?></li>
			</ol>
			</p>
			<p>
			<?php _e("Both methods allow you to use Presets. 
				BackUpWordPress comes preconfigured with two Presets. 
				One for a Database-only Backup, the other for a full backup including your WordPress file structure.
				BackUpWordPress makes use of these two Presets when running in EasyMode.","bkpwp");
			?>
			</p>
			<p>
			<?php _e("What can you do with your BackUpWordPress backup archives?","bkpwp"); ?>
			<ul>
			<li><?php _e("You can download BackUpWordPress archives","bkpwp"); ?></li>
				<p><?php _e("For security reasons, not all of your WordPress files and directories are writeable by the webserver.
					Therefore, for a full recovery, you might have to unpack a downloaded backup archive and upload the containig files via FTP, 
					just as you did when installing WordPress for the first time. Overwriting existing files on the webserver will set your 
					Wordpress installation back to the state when your backup archive was saved.","bkpwp"); ?></p>
			 <li><?php _e("\"view\" gives you extended information about the archive file and Backup Process (Log).","bkpwp"); ?></li>
			 <li><?php _e("You can send yourself an email containing Backup Archive Files.","bkpwp"); ?></li>
			 <li><?php _e("You can restore your WordPress Blog or parts of it.","bkpwp"); ?></li>
			 <li><?php _e("And you can simply delete unused Backup archive files.","bkpwp"); ?></li>
			</ul>
			<?php _e("Is your Wordpress installation getting really big?
				Does your wp-content/uploads directory hold a huge amount of Files?","bkpwp");
			?>
			<br />
			<?php _e("Consider hitting the \"Recalculate Used Disk Space\" button! 
			This way you can estimate how long BackUpWordPress will run and how big the resulting backup archive file will be.","bkpwp"); ?>
			</p>
			<p>
			<?php _e("This plugin my give you a better overview:","bkpwp"); ?> <a href="http://wordpress.designpraxis.at/plugins/disk-usage/">Disk Usage</a>
			</p>
			<p>
			<?php _e("Looking for a less komplex Solution? Please swith to ","bkpwp"); ?>
			<br /><a href="admin.php?page=<?php echo $_REQUEST['page']; ?>&bkpwp_modeswitch=1"><?php _e("EasyMode","bkpwp"); ?> &raquo;</a>
			</p>
		<?php } ?>
		
		
		<?php if (!$options->bkpwp_easy_mode()) { ?>
		<a name="help_manage_presets"></a>
		<h3><?php _e("Manage Backup Presets","bkpwp"); ?></h3>
		<a href="#help_top"><?php _e("Help Index","bkpwp"); ?></a>
		
			<p>
			<?php _e("BackUpWordPress Presets consist of a handful of options:","bkpwp"); ?>
			<ol>
				<li><?php _e("Archive Type","bkpwp"); ?></li>
				<p><?php _e("Sets the archive file type and compression.","bkpwp"); ?></p>
				<li><?php _e("Exclude List","bkpwp"); ?></li>
				<p><?php _e("Exclude Lists can be configured seperately.","bkpwp"); ?></p>
				<li><?php _e("SQL only","bkpwp"); ?></li>
				<p><?php _e("Database backup. Files and Folders (and thus Exclude Lists) are ignored.","bkpwp"); ?></p>
			</ol>
			</p>
			<p>
			<?php _e("At install, BackUpWordPress checks for available compression types available on your webserver.
				If you are missing archiv file types there, contact your webserver's admin.","bkpwp");
			?>
			<br />
			<?php _e("Note: .tgz, .tar and .tar.gz archive file types store Unix file and directory Permissions. 
				If your WordPress installation is hosted on a *nix system and you need resulting BackUpWodPress archives
				for recovering purposes ther or want to migrate to another *nix host, .zip is not an option.","bkpwp");
			?>
			<br />
			<?php _e("You cannot delete default Presets, but you can alter them and save with a new Preset name.","bkpwp");
			?>
			<br />
			<?php _e("The \"view\" action will give you a preview on what will be backed up with this preset.","bkpwp");
			?>
			</p>
			<p>
			<?php _e("Satisfied with Defaults? Consider switching to ","bkpwp"); ?>
			<br /><a href="admin.php?page=<?php echo $_REQUEST['page']; ?>&bkpwp_modeswitch=1"><?php _e("EasyMode","bkpwp"); ?> &raquo;</a>
			</p>
		<?php } ?>
			
		<?php if (!$options->bkpwp_easy_mode()) { ?>
		<a name="help_manage_schedules"></a>
		<h3><?php _e("Manage Backup Schedules","bkpwp"); ?></h3>
		<a href="#help_top"><?php _e("Help Index","bkpwp"); ?></a>
			
			<p>
			<?php _e("BackUpWordPress Schedules gives you the following options:","bkpwp"); ?>
			<ol>
				<li><?php _e("Reset Default Schedules","bkpwp"); ?></li>
				<p><?php _e("Resets all schedules to default.","bkpwp"); ?></p>
				<li><?php _e("Test Schedules","bkpwp"); ?></li>
				<p><?php _e("You can set a single shedule without recurrence doing a SQL-only Backup just to test Scheduling.","bkpwp"); ?></p>
				<li><?php _e("Activate/Deactivate Schedules","bkpwp"); ?></li>
				<p><?php _e("Activation status can be set on any Schedule.","bkpwp"); ?></p>
				<li><?php _e("Delete Schedules","bkpwp"); ?></li>
			</ol>
			</p>
			<p>
			<?php _e("Note for WordPress plugin developers: Try and analyze","bkpwp"); ?> <a href="http://wordpress.designpraxis.at/plugins/cron-demo/">Cron Developers Demo</a>. <?php _e("Cron Developers Demo is a plugin created for the sole purpose of demonstrationg the pseudo-cron feature built into WordPress","bkpwp"); ?>.
			</p>
			<p>
			<p>
			<?php _e("Satisfied with default Schedules? Consider switching to ","bkpwp"); ?>
			<br /><a href="admin.php?page=<?php echo $_REQUEST['page']; ?>&bkpwp_modeswitch=1"><?php _e("EasyMode","bkpwp"); ?> &raquo;</a>
			</p>
			
		<?php } ?>
			
		<a name="help_options"></a>
		<h3><?php _e("BackUpWordPress Settings","bkpwp"); ?></h3>
			
		<?php if ($options->bkpwp_easy_mode()) { ?>
			<p>
			<ol>
				<li><?php _e("Backup Path","bkpwp"); ?></li>
				<p><?php _e("Set the directory where your backups will be stored.","bkpwp"); ?></p>
				<li><?php _e("Basic Scheduling","bkpwp"); ?></li>
				<p><?php _e("Turn scheduled Backups on or off.","bkpwp"); ?></p>
				<li><?php _e("Mail Setup","bkpwp"); ?></li>
				<p><?php _e("Activate or deactivate Backup email notification.","bkpwp"); ?></p>
			</ol>
			</p>
			<p>
			<?php _e("For more options, please swith to ","bkpwp"); ?>
			<a href="admin.php?page=<?php echo $_REQUEST['page']; ?>&bkpwp_modeswitch=1"><?php _e("AdvancedMode","bkpwp"); ?> &raquo;</a>
			</p>
			
		<?php } else { ?>
			<a href="#help_top"><?php _e("Help Index","bkpwp"); ?></a>
			<p>
			<ol>
				<li><?php _e("Backup Path","bkpwp"); ?></li>
				<p><?php _e("Set the directory where your backups will be stored.","bkpwp"); ?></p>
				<li><?php _e("Basic Scheduling","bkpwp"); ?></li>
				<p><?php _e("is a shortcut for scheduling defaults.","bkpwp"); ?></p>
				<li><?php _e("Mail Setup","bkpwp"); ?></li>
				<p><?php _e("Activate or deactivate Backup email notification.","bkpwp"); ?></p>
				<li><?php _e("Backup Storage","bkpwp"); ?></li>
				<p><?php _e("Set the number of Backups to keep.","bkpwp"); ?></p>
				<li><?php _e("Exclude Lists","bkpwp"); ?></li>
				<p><?php _e("Configure Exclude Lists for use with your presets.","bkpwp"); ?></p>
			</ol>
			</p>
			<p>
			<?php _e("Too many Settings? Consider switching to ","bkpwp"); ?>
			<br /><a href="admin.php?page=<?php echo $_REQUEST['page']; ?>&bkpwp_modeswitch=1"><?php _e("EasyMode","bkpwp"); ?> &raquo;</a>
			</p>
			
		<?php } ?>
</div>
