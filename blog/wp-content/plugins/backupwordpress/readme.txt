=== BackUpWordPress ===
Contributors: wpdprx
Donate link: http://wordpress.designpraxis.at/
Tags: Backup, database, diectory, uploads, images, db, recovery
Requires at least: 2.1
Tested up to: 2.3.1
Stable tag: trunk

BackUpWordPress is a Backup & Recovery Suite for your WordPress website. This Plugin allows you to backup database as well as files and comes with a rich set of options.

== Features ==

EasyMode:
	
+ Switch between EasyMode and AdvancedMode
+ Database backup as well as directory structure including uploaded files, plugins, etc.
+ Set up Mail notification on new backups
+ Trigger backup manually
+ Set basic schedules for your backups
+ restore backups
+ staggered SQL import when restoring
+ automatically continue unfinished backups in background
+ download backups
+ Help page
+ Language Support for english and german(deutsch)

more option in AdvancedMode:
	
+ Set and manage custom schedules
+ Check disk space
+ View backup Logs
+ Delete backups manually
+ Manage backup presets
+ Manage exclude-lists for use with these presets

== Installation ==

1. Download, unzip and upload to your WordPress plugins directory
2. activate the plugin within you WordPress Administration Backend
3. Go to BackUpWordPress in your Administration Backend

== Support Forum ==

For support questions, please search and post at our Support forum:
[WordPress Designpraxis Forum](http://wpforum.designpraxis.at)

== Screenshots ==

1. Manage your Backups
2. Switch between EasyMode and AdvancedMode
3. Activate scheduling of your backups
4. Receive email notifications on new backups
5. Dashboard activity box view

== Notes ==

BackUpWordPress utilizes several Open Source Tools:
	
+ [PEAR](http://pear.php.net/package/PEAR/)
+ [FILE_ARCHIVE](http://pear.php.net/package/File_Archive) for compression/decompression
+ [bigdump](http://www.ozerov.de/bigdump.php) for staggered sql import

Some pieces of code have been modified:

+ backupwordpress\Archive\Writer\Tar.php has been debugged around line 80 to handle long filenames according to http://pear.php.net/bugs/bug.php?id=10144&edit=3

== Changelog ==


Changelog:

Changes in 0.4.5
+ fix prevents users from setting wp-content as backup repository. The directory must be one that can be secured with .htaccess.
+ fixes the default admin issue reported here: http://wpforum.designpraxis.at/topic/error-invalid-argument-supplied-for-foreach-?replies=2#post-322

Changes in 0.4.4
+ another even more important security fix.

Changes in 0.4.3
+ security fix for RFI vulnerability reported on http://www.milw0rm.com/exploits/4593

Changes in 0.4.2
+ prevent unpriviledged users from seeing the BackUpWordPress Dashboard

Changes in 0.4.1
+ added test for empty array in bkpwp_get_excludelist()
+ all mkdir() calls use mode 0777
+ backup archive permissions chage to 0777 (should solve issues with users not being able to delete archive files)

	
Changes in 0.3.2:
+ added capabilities manage_backups and download_backups
+ backup repository secured by .htaccess
	
Changes in 0.2.7:

+ manage presets. link to configure excludelists corrected
+ require_once instead of require for class-phpmailer.php
+ Sajax is replaces by prototype. this resolves the "backup hangs" bug on hosts with hardened php (register_globals: off, safe_mode: on, etc.)
	
Changes in 0.2.6:

+ unable to delete backup presets bug fixed
	
Changes in 0.2.5:

+ some smaller improvements

Changes in 0.2.4:
	
+ Internet Explorer ajax issue with not being able to do backups manually fixed
	
Changes in 0.2.3:
	
+ Mailing options: multiple email addresses supported
+ Backup file size reports also display the size of the database
+ Backup archive filesize is estimated
+ schedule table rows display the lastrun-timestamp of the last running backup
	
Changes in 0.2.2:
	
+ Manage Backups now display the type, either scheduled or manual for Advanced as well as EasyMode
+ logfile prints out WordPress and BackUpWordPress version for easier posting at http://wpforum.designpraxis.at/
+ BackUpWordPress displays "Your backup is being processed" instead of the actions links on the Manage Backups screen as long as archiving is not finished
	
Changes in 0.2.1:
	
+ old Logfiles are deleted. 10 times the amount of the configured amount of backups to keep is kept.
+ feature: backups are done in kind of a staggered process: if BackUpWordPress runs into a server side time-out, BackUpWordPress tries to trigger an single scheduled event for finishing the task. Corresponding dialoques appear on the *Manage Backups* - screen. 
	
Changes in 0.1.4:
	
+ @set_time_limit(0) in functions.php line 277 supresses the 'Cannot set time limit in safe mode' warning
+ dialoques streamlined: e.g. when you click "delete" on a backup archive, you just need to hit enter to delete it
	
Changes in 0.1.3:
	
+ ajax problems fixed
+ schedules last run timestamp fixed

Changes in 0.1.2:
	
+ bug fixed: Backup-Now doesn't call Sajax
+ bkpwp_delete_old() refactored
+ bug fixed: table data is not dumped