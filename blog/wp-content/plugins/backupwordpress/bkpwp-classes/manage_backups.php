<?php



class BKPWP_BACKUP_ARCHIVE {
    
    function BKPWP_BACKUP_ARCHIVE() {
    }
    
    function bkpwp_view_backup_info($backup,$values="") {
	    $ret = "";
	    $backup = base64_decode($backup);
	    $ret .= "<h5>".__("BackUp Archive Path and Filename","bkpwp")."</h5>";
	    $ret .= $backup;
	    $ret .= "<h5>".__("BackUp Logfile","bkpwp")."</h5>";
	    $backuplog = eregi_replace(get_option("bkpwppath"),get_option("bkpwppath")."/logs",$backup).".txt";
	    if (!empty($values)) {
		    $values = array();
		    if(file_exists($backup)) {
			    $values['filesize'] = bkpwp_size_readable(filesize($backup));
		    } else {
		        $values['filesize'] = $backup." ".__("does not exist.","bkpwp");
		    }
		    if(file_exists($backuplog)) {
			    $lines = file($backuplog);
			    foreach($lines as $line_num => $line) {
				    if (eregi("Preset:",$line)) {
					    $p=explode(":",$line);
					    $values['preset'] = $p[1];
				    }
				    if (eregi("Schedule:",$line)) {
					    $p=explode(":",$line);
					    $values['runby'] = $p[1];
				    }
			    }
		    }
		    return $values;
	    }
	    if(file_exists($backuplog)) {
		    $lines = file($backuplog);
		    foreach($lines as $line_num => $line) {
			    $ret .= __("Line","bkpwp")."# ".sprintf("%02d",$line_num)." ".$line."<br />";
		    }
	    } else {
		    $ret = __("BackUpWordPress Logfile does not exist:","bkpwp")." ".$backuplog;
	    }
	    return $ret;
    }
    
    function bkpwp_get_backup_row($f,$alternate) {
	$backup->options = new BKPWP_OPTIONS();
	$info = new BKPWP_BACKUP_ARCHIVE();
	$info = $info->bkpwp_view_backup_info(base64_encode($f['file']),1);
	$type = $backup->options->bkpwp_get_backup_type($f['filename']);
	if ($alternate != "new_row") {
	?>
	<tr id="bkpwp_manage_backups_row_<?php echo base64_encode($f['file']); ?>" class="bkpwp_manage_backups_row <?php echo $alternate; ?>">
	<?php
	}
	?>
		<th scope="row"><?php
		echo date(get_option('date_format'),filemtime($f['file']))." ".date("H:i",filemtime($f['file']));
		?></th>
		<td>
		<?php
		echo " <b>".$type."</b>";
		if (!empty($info['runby'])) {
			echo " - ".$info['runby'];
		}
		?>
		</td>
		<?php if (!$backup->options->bkpwp_easy_mode()) { ?>
		<td>
		<?php
		echo " <b>".$info['preset']."</b>";
		?>
		</td>
		<?php } ?>
		<td>
		<?php
		echo bkpwp_size_readable(filesize($f['file']))."";
		?>
		</td>
		<td style="text-align: center;">
		<?php
		echo " <a href=\"admin.php?page=backupwordpress/backupwordpress.php&amp;bkpwp_download=".base64_encode($f['file'])."\">".__("download","bkpwp")."</a>";
		?>
		</td>
		<td style="text-align: center;">
		<?php if (!empty($info['preset'])) { ?>
			<?php if (!$backup->options->bkpwp_easy_mode()) { ?>
				<?php
				echo " <a href=\"javascript:void(0)\"
				onclick=\"bkpwp_js_loading('".__("View Backup Information","bkpwp")."');
				ajax =  new Ajax.Updater(
				 'bkpwp_action_buffer',        // DIV id must be declared before the method was called
				 '".get_bloginfo("wpurl")."/wp-admin/admin.php?page=backupwordpress/backupwordpress.php"."',
				 {
				 method:'post',
				 postBody:'bkpwp_view_backup=".base64_encode($f['file'])."'
				     });\">".__("view","bkpwp")."</a>";
				?>
				</td>
				<td style="text-align: center;">
				<?php
				echo " <a href=\"admin.php?page=backupwordpress/backupwordpress.php&amp;bkpwp_mail=".base64_encode($f['file'])."\">".__("mail","bkpwp")."</a>";
				?>
				</td>
			<?php } ?>
			<td style="text-align: center;">
			<?php
			echo " <a href=\"admin.php?page=backupwordpress/backupwordpress.php&amp;bkpwp_restore=".base64_encode($f['file'])."\">".__("restore","bkpwp")."</a>";
			?>
			</td>
			<?php if (!$backup->options->bkpwp_easy_mode()) { ?>
				<td style="text-align: center;">
				<?php
				echo " <a href=\"admin.php?page=backupwordpress/backupwordpress.php&amp;bkpwp_delete=".base64_encode($f['file'])."\">".__("delete","bkpwp")."</a>";
				?>
				</td>
			<?php } ?>
		<?php } else { ?>
		<?php echo "".__("Your Backup is being processed.","bkpwp").""; ?>
		<?php } ?>
		<?php
		if ($alternate != "new_row") {
		?>
		</tr>
		<?php
		}
    }
    
}

class BKPWP_BACKUP {
    
    function BKPWP_BACKUP() {
    }
    
    function bkpwp_backquote($a_name)
    {
    	/*
    		Add backquotes to tables and db-names in
    		SQL queries. Taken from phpMyAdmin.
    	*/
        if (!empty($a_name) && $a_name != '*') {
            if (is_array($a_name)) {
                 $result = array();
                 reset($a_name);
                 while(list($key, $val) = each($a_name)) {
                     $result[$key] = '`' . $val . '`';
                 }
                 return $result;
            } else {
                return '`' . $a_name . '`';
            }
        } else {
            return $a_name;
        }
    } // function backquote($a_name, $do_it = TRUE)
    
    function bkpwp_make_sql($path,$sql_file,$table,$status,$log)
    {
    	/*
    		Reads the Database table in $table and creates
    		SQL Statements for recreating structure and data
    		Taken partially from phpMyAdmin and partially from
    		Alain Wolf, Zurich - Switzerland
    		Website: http://restkultur.ch/personal/wolf/scripts/db_backup/
    	*/
    
    		$sql_file  = "";
    
    		// Add SQL statement to drop existing table
    		$sql_file .= "\n";
    		$sql_file .= "\n";
    		$sql_file .= "#\n";
    		$sql_file .= "# Delete any existing table " . $this->bkpwp_backquote($table) . "\n";
    		$sql_file .= "#\n";
    		$sql_file .= "\n";
    		$sql_file .= "DROP TABLE IF EXISTS " . $this->bkpwp_backquote($table) . ";\n";
    
    		// Table structure
    
    		// Comment in SQL-file
    		$sql_file .= "\n";
    		$sql_file .= "\n";
    		$sql_file .= "#\n";
    		$sql_file .= "# Table structure of table " . $this->bkpwp_backquote($table) . "\n";
    		$sql_file .= "#\n";
    		$sql_file .= "\n";
    
    		// Get table structure
    		$query = "SHOW CREATE TABLE " . $this->bkpwp_backquote($table);
    		$result = mysql_query($query, $GLOBALS["db_connect"]);
    		if ($result == FALSE) {
			$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Error getting table structure of ","bkpwp").$table."! ".mysql_errno() . ": " . mysql_error()." ".$this->bkpwp_logtimestamp();
			$this->bkpwp_write_log($log); unset($log['logfile']);
    		} else {
    			if (mysql_num_rows($result) > 0) {
    				$sql_create_arr = mysql_fetch_array($result);
    				$sql_file .= $sql_create_arr[1];
    			}
    			mysql_free_result($result);
    			$sql_file .= " ;";
    		} // ($result == FALSE)
    
    		// Table data contents
    
    		// Get table contents
    		$query = "SELECT * FROM " . $this->bkpwp_backquote($table);
    		$result = mysql_query($query, $GLOBALS["db_connect"]);
    		if ($result == FALSE) {
			$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Error getting records of ","bkpwp").$table."! ".mysql_errno() . ": " . mysql_error()." ".$this->bkpwp_logtimestamp();
			$this->bkpwp_write_log($log); unset($log['logfile']);
    		} else {
    			$fields_cnt = mysql_num_fields($result);
    			$rows_cnt   = mysql_num_rows($result);
    		} // if ($result == FALSE)
    
    		// Comment in SQL-file
    		$sql_file .= "\n";
    		$sql_file .= "\n";
    		$sql_file .= "#\n";
    		$sql_file .= "# Data contents of table " . $table . " (" . $rows_cnt . " records)\n";
    		$sql_file .= "#\n";
    
    		// Checks whether the field is an integer or not
    		for ($j = 0; $j < $fields_cnt; $j++) {
    			$field_set[$j] = $this->bkpwp_backquote(mysql_field_name($result, $j));
    			$type          = mysql_field_type($result, $j);
    			if ($type == 'tinyint' || $type == 'smallint' || $type == 'mediumint' || $type == 'int' ||
    				$type == 'bigint'  ||$type == 'timestamp') {
    				$field_num[$j] = TRUE;
    			} else {
    				$field_num[$j] = FALSE;
    			}
    		} // end for
    
    		// Sets the scheme
    		$entries = 'INSERT INTO ' . $this->bkpwp_backquote($table) . ' VALUES (';
    		$search			= array("\x00", "\x0a", "\x0d", "\x1a"); 	//\x08\\x09, not required
    		$replace		= array('\0', '\n', '\r', '\Z');
    		$current_row	= 0;
		$batch_write = 0;
    		while ($row = mysql_fetch_row($result)) {
    			$current_row++;
			
			//test
// 			if (empty($status) && ($table == "crawlt_ip_data") && ($current_row == 287)) {
// 			  sleep(200);
// 			}
			
			// if we have to continue an unfinished backup
			if (!empty($status) && empty($continue_backup)) {
				$statusarr = get_option("bkpwp_status");
				if ($statusarr['type'] == "sqltable_row") {
					if ($statusarr['point'] == $table."-".$current_row) {
						$continue_backup = 1;
						continue;
					} else {
						continue;
					}
				}
			}
			
			// build the statement
    			for ($j = 0; $j < $fields_cnt; $j++) {
    				if (!isset($row[$j])) {
    					$values[]     = 'NULL';
    				} else if ($row[$j] == '0' || $row[$j] != '') {
    					// a number
    					if ($field_num[$j]) {
    						$values[] = $row[$j];
    					}
    					else {
    						$values[] = "'" . str_replace($search, $replace, $this->bkpwp_sql_addslashes($row[$j])) . "'";
    					} //if ($field_num[$j])
    			} else {
    					$values[]     = "''";
    				} // if (!isset($row[$j]))
    			} // for ($j = 0; $j < $fields_cnt; $j++)
    			$sql_file .= " \n" . $entries . implode(', ', $values) . ') ;';
			
				
			// write the rows in batches of 100
			if ($batch_write == 100) {
				$batch_write = 0;
				$this->bkpwp_write_sql($path,$sql_file);
				$sql_file = "";
				$name = str_replace(get_option("bkpwppath")."/","",$path);
				$this->bkpwp_set_status($name,'sqltable_row',$table."-".$current_row);
				unset($status);
			}
			$batch_write++;
			
    			unset($values);
    		} // while ($row = mysql_fetch_row($result))
    		mysql_free_result($result);
    
    		// Create footer/closing comment in SQL-file
    		$sql_file .= "\n";
    		$sql_file .= "#\n";
    		$sql_file .= "# End of data contents of table " . $table . "\n";
    		$sql_file .= "# --------------------------------------------------------\n";
    		$sql_file .= "\n";
		
		if (empty($status) || !empty($continue_backup)) {
			$this->bkpwp_write_sql($path,$sql_file);
			$sql_file = "";
			$name = str_replace(get_option("bkpwppath")."/","",$path);
			$this->bkpwp_set_status($name,'sqltable',$table);
		}
    } //function make_sql($table)
    
    function bkpwp_sql_addslashes($a_string = '', $is_like = FALSE)
    {
    	/*
    		Better addslashes for SQL queries.
    		Taken from phpMyAdmin.
    	*/
        if ($is_like) {
            $a_string = str_replace('\\', '\\\\\\\\', $a_string);
        } else {
            $a_string = str_replace('\\', '\\\\', $a_string);
        }
        $a_string = str_replace('\'', '\\\'', $a_string);
    
        return $a_string;
    } // function sql_addslashes($a_string = '', $is_like = FALSE)
    
    function bkpwp_mysql($path,$status="",$log) {
	if (!$GLOBALS['db_connect'] = @mysql_pconnect(DB_HOST, DB_USER, DB_PASSWORD)) {
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Could not connect to MySQL server! ","bkpwp"). mysql_error()." ".$this->bkpwp_logtimestamp();
		$this->bkpwp_write_log($log); unset($log['logfile']);
	}
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("MySQL server connected successfully ","bkpwp")." ".$this->bkpwp_logtimestamp();
	$this->bkpwp_write_log($log); unset($log['logfile']);
	mysql_select_db(DB_NAME,$GLOBALS['db_connect']);
	
	//Begin new backup of MySql
	$tables = mysql_list_tables(DB_NAME);
	if (!isset($tables) > 0) {
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Could not select db ","bkpwp").DB_NAME." ".$this->bkpwp_logtimestamp();
		$this->bkpwp_write_log($log); unset($log['logfile']);
	}
	$sql_file  = "# WordPress : ".get_bloginfo("url")." MySQL database backup\n";
	$sql_file .= "#\n";
	$sql_file .= "# Generated: " . date("l j. F Y H:i T") . "\n";
	$sql_file .= "# Hostname: " . DB_HOST . "\n";
	$sql_file .= "# Database: " . $this->bkpwp_backquote(DB_NAME) . "\n";
	$sql_file .= "# --------------------------------------------------------\n";
	if (empty($status)) {
		$this->bkpwp_write_sql($path,$sql_file);
		$sql_file = "";
	}
	for ($i = 0; $i < mysql_num_rows($tables); $i++) {
		$curr_table = mysql_tablename($tables, $i);
		if (!empty($status) && empty($continue_backup)) {
			$statusarr = get_option("bkpwp_status");
			if ($statusarr['type'] == "sqltable_row") {
				$continue_backup = 1;
			} elseif ($statusarr['point'] == $curr_table) {
				$continue_backup = 1;
				continue;
			} else {
				continue;
			}
		}
		// Increase script execution time-limit to 15 min for every table.
		if ( !ini_get('safe_mode')) @set_time_limit(15*60);
		// Create the SQL statements
		$sql_file .= "# --------------------------------------------------------\n";
		$sql_file .= "# Table: " . $this->bkpwp_backquote($curr_table) . "\n";
		$sql_file .= "# --------------------------------------------------------\n";
		$this->bkpwp_make_sql($path,$sql_file,$curr_table,$status,$log);
		
		$log['logfile'][] = $this->bkpwp_logtimestamp().": sql-dump for ".$curr_table." created ".$this->bkpwp_logtimestamp();
		$this->bkpwp_write_log($log); unset($log['logfile']);
	}
    }
    
    function bkpwp_calculate($preset) {
	$sql = 'SHOW TABLE STATUS FROM ' . DB_NAME;
	$res = @$GLOBALS['wpdb']->get_results($sql, ARRAY_A);
	$sum_free = 0;
	$sum_data = 0;
	foreach($res as $r) {
		$sum_free = $sum_free + $r['Data_free'];
		$sum_data = $sum_data + $r['Data_length'];
	}
	$ret = "<p>";
	$ret .= __("Your Database holds.","bkpwp")." "
		.bkpwp_size_readable($sum_data)." "
		.__("of Data","dprx_opt").".<br />";
		
		
	if ($preset['bkpwp_preset_options']['bkpwp_sql_only'] == 1) {
	$ret .= __("The resulting Backup Archive will be about","dprx_opt")." <b> ".bkpwp_size_readable(($sum_data/2.5))."</b>.</p>";
	$ret .= "<p>".__("Database Only Backup with this Preset. No Disk Files will be backed up.","bkpwp")."</p>";
	return $ret;
	}
	
	$options = new BKPWP_OPTIONS();
	clearstatcache(); //get rid of cached filesizes...
	$dir = bkpwp_conform_dir(ABSPATH);
	$options->excludelist = $preset['bkpwp_preset_options']['bkpwp_excludelist'];
	$files = $options->bkpwp_ls($dir);
	$filesize = 0;
	foreach($files as $f) {
		$str = bkpwp_conform_dir($f,true);
		$thisf = filesize($f);
		$filesize = $filesize+$thisf;
		//echo $str.": ".bkpwp_size_readable($thisf)." (".bkpwp_size_readable($filesize).")\\n";
	}
	update_option("bkpwp_calculation",bkpwp_size_readable($filesize));
	$ret .= __("Your Wordpress files in this backup use","bkpwp")." ";
	$ret .= bkpwp_size_readable($filesize)." ".__("of disk space.","bkpwp")."<br />";
	$ret .= "".__("Your Backup Archive filesize saved with preset","bkpwp")." <b>".$preset['bkpwp_preset_name']."</b> ".__("will be about","bkpwp")." <b>".bkpwp_size_readable((($sum_data+$filesize)/1.9))."</b>.</p>";
	return $ret;
    }
    
    function bkpwp_logtimestamp() {
	    return date(get_option('date_format'))." ".date("H:i:s");
    }
    
    function bkpwp_set_status($name,$type,$point) {
	$new_backup_status = array("name" => $name, "time" => time(), "type" => $type, "point" => $point);
	update_option("bkpwp_status",$new_backup_status);
    }
    
    function bkpwp_do_backup($preset,$status="") {
	$options = new BKPWP_OPTIONS();
	$presets = new BKPWP_MANAGE();
	$log = array();
	// get the desired archive type from preset
	if (!empty($status)) {
		$preset = get_option("bkpwp_status_config");
	}
	
	// load the full backup preset if none is set
	if (empty($preset)) {
		$preset = $presets->bkpwp_get_preset("full backup");
	}
		
	$type = $preset['bkpwp_preset_options']['bkpwp_archive_type'];
	$sqlonly = $preset['bkpwp_preset_options']['bkpwp_sql_only'];
	$options->excludelist = $preset['bkpwp_preset_options']['bkpwp_excludelist'];
	update_option("bkpwp_status_config",$preset);
	
	$datestamp = date("Y-m-d-H-i-s");
	// or: load the name of the unfinished backup's temporary directory
	if (!empty($status)) {
		$datestamp = $status;
		if (!is_dir(get_option("bkpwppath")."/".$datestamp)) {
			return;
		}
	}
	// temporary directory name
	$backup_tmp_dir = get_option("bkpwppath")."/".$datestamp;
	
	// filename for the backup archive
	if ($sqlonly == 1) {
		$backup_filename .= "-sql";
	} else {
		$backup_filename .= "-full";
	}
	
	$backup_filename .= ".".$type;
	$backup_filename_short = $datestamp.$backup_filename;
	$backup_filename = $backup_tmp_dir.$backup_filename;
	$log['filename'] = $backup_filename_short;
	$log['logfile'] = array();
	$log['preset'] = $preset['bkpwp_preset_name'];
	$log['schedule'] = $preset['bkpwp_schedule'];
	if ($preset['bkpwp_schedule'] != __("manually","bkpwp")) {
		$preset['bkpwp_preset_options']['bkpwp_lastrun'] = time();
		$presets->bkpwp_update_preset($preset);
	}
	$time_start = microtime(true);
	
	// count milliseconds
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("BackUpWordPress starting at","bkpwp")." ".$this->bkpwp_logtimestamp();
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("BackUpWordPress using Preset","bkpwp")." ".$log['preset'];
	
	// create a temporary directory
	if (!is_dir($backup_tmp_dir)) {
		if (!mkdir($backup_tmp_dir,0777)) {
			$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("BackUpWordPress temporary Directory","bkpwp")." '".$backup_tmp_dir."' ".__("could not be created","bkpwp");
		} else {
			$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("BackUpWordPress temporary Directory","bkpwp")." '".$backup_tmp_dir."' ".__("created","bkpwp");
		}
	} else {
			$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("BackUpWordPress temporary Directory","bkpwp")." '".$backup_tmp_dir."' ".__("exists. Proceeding with unfinished backup.","bkpwp");
	}
	$this->bkpwp_write_log($log); unset($log['logfile']);
	
	if ($sqlonly != 1) {
		// subdirectory of wordpress files
		$wordpress_files = $backup_tmp_dir."/wordpress_files";
		if (!is_dir($wordpress_files)) {
			if (!mkdir($wordpress_files,0777)) {
				$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("BackUpWordPress temporary Directory","bkpwp")." '".$wordpress_files."' ".__("could not be created","bkpwp");
			} else {
				$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("BackUpWordPress temporary Directory","bkpwp")." '".$wordpress_files."' ".__("created","bkpwp");
			}
		$this->bkpwp_write_log($log); unset($log['logfile']);
		}
	}
	
	$this->bkpwp_mysql($backup_tmp_dir,$status,$log);
	
	if(!file_exists($backup_tmp_dir."/wordpress.sql")) {
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("SQL Dump could not be created.","bkpwp");
	} else {
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("SQL Dump created.","bkpwp");
	}
	$this->bkpwp_write_log($log); unset($log['logfile']);
	if ($sqlonly != 1) {
		// create a temporary directory of files to backup
		$dir = bkpwp_conform_dir(ABSPATH);
		$files = $options->bkpwp_ls($dir);
		$files_copied = 0;
		$batch = 0;
		$subdirs_created = 0;
		$i=1; // the sql at least
		foreach ($files as $f) {
			if (is_dir($f)) {
				if (!mkdir($wordpress_files.bkpwp_conform_dir($f, true),0777)) {
					if (!is_dir($wordpress_files.bkpwp_conform_dir($f, true))) {
						$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Failed to make directory","bkpwp").": ".$f;
					}
				} else {
					$subdirs_created++;
				}
			} elseif(file_exists($f)) {
				// where did we leave?
				if (!empty($status) && empty($continue_backup)) {
					$statusarr = get_option("bkpwp_status");
					if ($statusarr['point'] == $f) {
						$continue_backup = 1;
						continue;
					} else {
						continue;
					}
				}
				
				// set a marker ever 100 
				if ($batch == 100) { 
					$this->bkpwp_set_status($datestamp,'file',$f);
					$batch = 0;
				}
				$files_copied++;
				if (file_exists($wordpress_files.bkpwp_conform_dir($f, true))) {
					unlink($wordpress_files.bkpwp_conform_dir($f, true));
				}
				// now copy...
				if (!copy($f,$wordpress_files.bkpwp_conform_dir($f, true))) {
					$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Failed to copy file","bkpwp").": ".$f;
				}
				$batch++;
				//test
				/*
				if (empty($status) && ($files_copied == 135)) {	
					sleep(200);
				}
				*/

			}
			$i++;
		}
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".$subdirs_created." ".__("Temporary Subdirectories copied sucessfully","bkpwp");
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".$files_copied." ".__("Temporary Files copied sucessfully","bkpwp");
	}
	// create backup archive file
	$archive_backup = new File_Archive();
	$archive_backup->setOption("tmpDirectory",get_option("bkpwppath"));
	$archive_backup->extract($backup_tmp_dir,File_Archive::toArchive($backup_filename, File_Archive::toFiles()));
	if (!chmod($backup_filename, 0777)) {
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Backup Archive Permissions changed to 0777","bkpwp")." ".$backup_filename;
	} else {
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Failed to change backup archive permissions","bkpwp")." ".$backup_filename;
	}
	if (!file_exists($backup_filename)) {
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Failed to create backup archive","bkpwp")." ".$backup_filename;
	} else {
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("Archive File created/compressed successfully:","bkpwp")." ".$backup_filename;
	}
	
	$deleted_files_count = $this->bkpwp_rmdirtree($backup_tmp_dir);
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".count($deleted_files_count)." ".__("Temporary Directories and Files deleted successfully","bkpwp");
	
	$deleted_oldarchives_count = $this->bkpwp_delete_old();
	if ($deleted_oldarchives_count > 0) {
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".$deleted_oldarchives_count." ".__("Old BackUpWordPress Archives deleted successfully","bkpwp");
	} else {
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("No old BackUpWordPress Archives to delete","bkpwp");
	}
	
	$deleted_oldlogfiles_count = $this->bkpwp_delete_oldlogs();
	if ($deleted_oldlogfiles_count > 0) {
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".$deleted_oldlogfiles_count." ".__("Old BackUpWordPress Log Files deleted successfully","bkpwp");
	} else {
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("No old BackUpWordPress Log Files to delete","bkpwp");
	}
	
	
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("BackUpWordPress done at","bkpwp")." ".$this->bkpwp_logtimestamp();
	$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("BackUpWordPress was running for","bkpwp")." ".round($time,2)." ".__("Seconds","bkpwp");
	
	// write the log
	$this->bkpwp_write_log($log); unset($log['logfile']);
	
	// dont need the status anymore
	delete_option("bkpwp_status");
	delete_option("bkpwp_status_config");
		
		
	$backup = array("file" => $backup_filename,
			"filename" => $backup_filename_short);
	// start the output
	$backuprow = new BKPWP_BACKUP_ARCHIVE();
	$out = "<table class=\"widefat\">";
	ob_start();
	$backuprow->bkpwp_get_backup_row($backup,"new_row");
	$out .= ob_get_contents();
	ob_end_clean();
	$out .= "</table>";
	
	// mail it if bkpwp_automail is set
	$bkpwp_automail = get_option("bkpwp_automail");
	$bkpwp_automail_maxsize = get_option("bkpwp_automail_maxsize");
	if (!empty($bkpwp_automail)) {
		$allowed_bytes = $bkpwp_automail_maxsize*1024*1024;
			$logdump = nl2br($this->bkpwp_write_log($log,1));
			$logdump .= $allowed_bytes.":".filesize($backup_filename)." - ".$backup_filename."<br />\n";
			if ($this->is_readable_for_mailout($backup_filename)) {
			$logdump .= "Backup file is readable.<br />\n";
			}
		if ($allowed_bytes >= filesize($backup_filename)) {
			bkpwp_mail_now(base64_encode($backup_filename), $logdump);
		} else {
			bkpwp_mail_now("", $logdump);
		}
	}
	// send autput
	return $out;
    }
    
    function is_readable_for_mailout($file,$count=0) {
	    if ($count > 24) {
		    return false;
	    }
	    if (!is_readable($file)) {
		    $count++;
		    sleep(2);
		    is_readable_for_mailout($file,$count);
	    }
	    return true;
    }
    
    //Since looks like the Windows ACLs bug "wont fix" (see http://bugs.php.net/bug.php?id=27609) 
    function is__writable($path) {

	if ($path{strlen($path)-1}=='/')
	    return $this->is__writable($path.uniqid(mt_rand()).'.tmp');
	
	if (file_exists($path)) {
	    if (!($f = @fopen($path, 'r+')))
		return false;
	    fclose($f);
	    return true;
	}
	
	if (!($f = @fopen($path, 'w')))
	    return false;
	fclose($f);
	unlink($path);
	return true;
    }

    function bkpwp_write_sql($sqldir,$sql) {
	$sqlname = $sqldir."/wordpress.sql";
	// actually write the sql file
	if ($this->is__writable($sqlname)) {
		if (!$handle = fopen($sqlname, "a")) {
			$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("SQLfile could not be opened for writing: ","bkpwp").$sqlname;
			$this->bkpwp_write_log($log); unset($log['logfile']);
			return;
		}
		if (!fwrite($handle, $sql)) {
			$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("SQLfile not writable: ","bkpwp").$sqlname;
			$this->bkpwp_write_log($log); unset($log['logfile']);
		return;
		}
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("successfully written to SQLfile: ","bkpwp").$sqlname;
		$this->bkpwp_write_log($log); unset($log['logfile']);
		fclose($handle);
		return true;
	} else {
		$log['logfile'][] = $this->bkpwp_logtimestamp().": ".__("SQLfile not writable: ","bkpwp").$sqlname;
		$this->bkpwp_write_log($log); unset($log['logfile']);
	}
    }

    function bkpwp_write_log($log,$return="") {
	    if (!is_array($log)) { return; }
	    	$logdir = get_option("bkpwppath")."/logs";
		if (!is_dir($logdir)) {
			mkdir($logdir,0777);
		}
	    	$logname = $logdir."/".$log['filename'].".txt";
		$logfile = "";
		if (!file_exists($logname)) {
			if (!empty($log['preset'])) {
				$logfile .= "Preset: ".$log['preset']."\n";
			}
			if (!empty($log['schedule'])) {
				$logfile .= "Schedule: ".$log['schedule']."\n";
			}
			// write some environmental information for debuging purposes
			$logfile .= "WordPress Version: ".$GLOBALS['wp_version']."\n";
			$logfile .= "BackUpWordPress Version: ".BKPWP_VERSION."\n";
		}
		if (is_array($log['logfile'])) {
			foreach($log['logfile'] as $l) {
				if (is_array($l)) { $l = serialize($l);}
				$logfile .= "## ".$l."\n";
			}
			if (!empty($return)) {
				return $logfile;
			}
			// actually write the log
			if ($this->is__writable($logname)) {
			    if (!$handle = fopen($logname, "a")) {
				 return __("Logfile could not be opened for writing: ","bkpwp").$logname;
			    }
			    if (!fwrite($handle, $logfile)) {
				return __("Logfile not writable: ","bkpwp").$logname;
			    }
			    fclose($handle);
			    return true;
			} else {
			    return __("Logfile not writable: ","bkpwp").$logname;
			}
		}
    }
    
    function bkpwp_rmdirtree($dirname) {
        if (!eregi(bkpwp_conform_dir(ABSPATH),bkpwp_conform_dir($dirname))) {
    	return;
        }
        if (is_dir($dirname)) {    //Operate on dirs only
    	$result=array();
    	if (substr($dirname,-1)!='/') {$dirname.='/';}    //Append slash if necessary
    	$handle = opendir($dirname);
    	while (false !== ($file = readdir($handle))) {
    	    if ($file!='.' && $file!= '..') {    //Ignore . and ..
    		$path = $dirname.$file;
    		if (is_dir($path)) {    //Recurse if subdir, Delete if file
    		    $result=array_merge($result,$this->bkpwp_rmdirtree($path));
    		}else{
    		    unlink($path);
    		    $result[].=$path;
    		}
    	    }
    	}
    	closedir($handle);
    	rmdir($dirname);    //Remove dir
    	$result[] .= $dirname;
    		return $result;    //Return array of deleted items
        } else {
		return false;    //Return false if attempting to operate on a file
        }
    }
    
    function bkpwp_delete_old() {
    	$backups = new BKPWP_MANAGE();
	$unlinkcount = 0;
	$files = $backups->bkpwp_get_backups();
    	if (count($files) <= get_option('bkpwp_max_backups')) {
    		return;
    	} else {
    		$i = 1;
    		foreach($files as $f) {
    			if ($i > get_option('bkpwp_max_backups')) {
    				unlink($f['file']);
				$unlinkcount++;
    			}
    			$i++;
    		}
    	}
    if ($unlinkcount > 0) {
	    return $unlinkcount;
    }
    return false;
    }
    
    function bkpwp_delete_oldlogs() {
    	$backups = new BKPWP_MANAGE();
	$unlinkcount = 0;
	$files = $backups->bkpwp_get_logs();
	$num = get_option('bkpwp_max_backups')*10;
    	if (count($files) <= $num) {
    		return;
    	} else {
    		$i = 1;
    		foreach($files as $f) {
    			if ($i > $num) {
    				unlink($f['file']);
				$unlinkcount++;
    			}
    			$i++;
    		}
    	}
    if ($unlinkcount > 0) {
	    return $unlinkcount;
    }
    return false;
    }

}

class BKPWP_MANAGE {
    
    function BKPWP_MANAGE() {
    }
    
    function bkpwp_get_presets() {
	$user = $GLOBALS['userdata']->user_login;
	if(empty($user)) { $user = "admin"; }
	$presets = get_option("bkpwp_presets");
	if(!is_array($presets[$user]['bkpwp_presets'])) {
		return array();
	} else {
		return $presets[$user]['bkpwp_presets'];
	}
    }
    
    function bkpwp_update_presets($userpresets) {
    	$presets = get_option("bkpwp_presets");
    	$user = $GLOBALS['userdata']->user_login;
    	if(empty($user)) { $user = "admin"; }
    	$presets[$user]['bkpwp_presets'] = $userpresets;
    	update_option("bkpwp_presets",$presets);
    }
    
    function bkpwp_load_preset($preset) {
	    $options = new BKPWP_OPTIONS();
	    $ret = "<div style=\"border: 1px solid #ccc; padding:10px; margin-bottom:20px;\">";
	    $ret .= "<form  method=\"post\" action=\"admin.php?page=bkpwp_manage_presets\">";
	    /*if ($preset['bkpwp_preset_options']['default'] == 1) {
	     	$ret .= "<div id=\"message\" class=\"updated fade\"><p>".__("You can not overwrite this default preset. Please save changes with a new Preset Name.","bkpwp")."</p></div>";
	    }
	    */
	    $ret .= "<h4>Configure or Create Backup Preset</h4><p>";
	    $ret .= "<label for=\"mod_bkpwp_preset_name\">".__("Preset Name","bkpwp")." </label>";
	    $ret .= "<input type=\"text\" name=\"mod_bkpwp_preset_name\" id=\"mod_bkpwp_preset_name\" value=\"".$preset['bkpwp_preset_name']."\" /></p>";
	    
	    $ret .= "<p><label for=\"mod_bkpwp_archive_type\">".__("Archive Type","bkpwp")." </label><select name=\"mod_bkpwp_archive_type\" id=\"mod_bkpwp_archive_type\">";
	    $archive_types = get_option("bkpwp_archive_types");
	    if (is_array($archive_types)) {
		    foreach ($archive_types as $type) {
			    $ret .= "<option value=\"".$type."\" ";
			    if ($preset['bkpwp_preset_options']['bkpwp_archive_type'] == $type) {
				    $ret .= " selected";
			    }
			    $ret .= ">".$type."</option>";
		    }
	    }
	    $ret .= "</select></p>";
	    
	    if($preset['bkpwp_preset_options']['bkpwp_sql_only'] == 1) {
		    $fullinit = " style=\"display: none;\"";
	    }
	    $ret .= "<div id=\"full_only\"".$fullinit.">";
	    $lists = $options->bkpwp_get_excludelists();
	    if (is_array($lists)) {
	    $ret .= "<p>".__("Exclude List","bkpwp")." <select name=\"mod_bkpwp_excludelist\" id=\"mod_bkpwp_excludelist\">";
		    $ret .= "<option value=\"\">".__("None","bkpwp")."</option>";
	    foreach ($lists as $l) {
		    $ret .= "<option value=\"".$l['listname']."\" ";
		    if ($preset['bkpwp_preset_options']['bkpwp_excludelist'] == $l['listname']) {
			    $ret .= " selected";
		    }
		    $ret .= ">".$l['listname']."</option>";
	    }
	    $ret .= "</select>";
	    $ret .= " <a href=\"admin.php?page=bkpwp-backup-options&excludelistname=".$preset['bkpwp_preset_options']['bkpwp_excludelist']."#excludelist\">".__("Configure","bkpwp")." &raquo;</a>";
	    $ret .= "</p>";
	    }
	    $ret .= "</div>";
	    
	    $ret .= "<p><label for=\"mod_bkpwp_sql_only\"><input type=\"checkbox\" name=\"mod_bkpwp_sql_only\" id=\"mod_bkpwp_sql_only\" value=\"1\"";
	    if ($preset['bkpwp_preset_options']['bkpwp_sql_only'] == 1) {
	    $ret .= " checked";
	    } 
	    $ret .= "  onclick=\"if (document.getElementById('mod_bkpwp_sql_only').checked == false) { document.getElementById('mod_bkpwp_sql_only').value=''; document.getElementById('full_only').style.display='block'; } else { document.getElementById('mod_bkpwp_sql_only').value=1; document.getElementById('full_only').style.display='none'; }\" /> ".__("SQL only","bkpwp")."</label></p>";
	    $ret .= "<p><input type=\"submit\" class=\"button\" value=\"".__("Save Preset","bkpwp")."\" /></p>";
	    $ret .= "</form></div>";
	    return $ret;
    }
    
    function bkpwp_view_preset($preset) {
	    $backup = new BKPWP_BACKUP();
	    $options = new BKPWP_OPTIONS();
	    $ret = "<div>";
	    if (!empty($preset['bkpwp_preset_options']['bkpwp_excludelist'])) {
		    $ret .= "<p>".__("Omitted Folders and Files when using","bkpwp")." <b>".$preset['bkpwp_preset_name']."</b></p>";
		    $ret .= "<p>";
		    $ret .= $options->bkpwp_ajax_shownobfiles($preset['bkpwp_preset_options']['bkpwp_excludelist']);
		    $ret .= "</p>";
	    }
	    $ret .= $backup->bkpwp_calculate($preset);
	    $ret .= "</div>";
	    return $ret;
    }
    
    function bkpwp_delete_preset($name) {
    	$apresets = $this->bkpwp_get_presets();
    	$presets= array();
	foreach($apresets as $p) {
    		if ($p['bkpwp_preset_name'] != $name) {
    			$presets[] = $p;
    		} else {
			if ($p['bkpwp_preset_options']['default'] == 1) {
				return __("You can not delete this default preset.","bkpwp");
			}
		}
    	}
    	$this->bkpwp_update_presets($presets);
    	return "<div id=\"message\" class=\"updated fade\"><p>".__("Preset deleted.","bkpwp")."</p></div>";
    }
    
    function bkpwp_update_preset($preset) {
    	$apresets = $this->bkpwp_get_presets();
    	$presets= array();
    	foreach($apresets as $p) {
    		if ($p['bkpwp_preset_name'] != $preset['bkpwp_preset_name']) {
    			$presets[] = $p;
    		} else {
    			$presets[] = $preset;
		}
    	}
    	$this->bkpwp_update_presets($presets);
    }
    
    function bkpwp_save_preset($name="",$archive_type="",$excludelist="",$sql_only="", $lastrun="") {
    	if (empty($name)) {
    		$name = "Preset".date("Y-m-d-H-i-s");
    	}
    	$apresets = $this->bkpwp_get_presets();
    	$presets= array();
    	foreach($apresets as $p) {
    		if ($p['bkpwp_preset_name'] != $name) {
    			$presets[] = $p;
    		} else {
			if ($p['bkpwp_preset_options']['default'] == 1) {
				return "<div id=\"message\" class=\"updated fade\"><p>".__("You can not overwrite this default preset. Please save changes with a new Preset Name.","bkpwp")."</p></div>";
			}
		}
    	}
	
	$options = array("bkpwp_archive_type" => $archive_type,
			 "bkpwp_sql_only" => $sql_only,
			 "bkpwp_excludelist" => $excludelist,
			 "bkpwp_lastrun" => $lastrun);
	$presets[] = array("bkpwp_preset_name" => $name,
			   "bkpwp_preset_options" => $options);
    	
    	$this->bkpwp_update_presets($presets);
    	return "<div id=\"message\" class=\"updated fade\"><p>".__("Preset saved.","bkpwp")."</p></div>";
    }

    function bkpwp_get_preset($name="") {
	if (empty($name)) {
	    $name = "full backup";
	}
	$user = $GLOBALS['userdata']->user_login;
	if(empty($user)) { $user = get_option("bkpwp_install_user"); }
	$presets = get_option("bkpwp_presets");
	$apresets = $presets[$user]['bkpwp_presets'];
	foreach($apresets as $p) {
		if ($p['bkpwp_preset_name'] == $name) {
		 return $p;
		}
	}
    }
    
    function bkpwp_max_views() {
	    $maxview = get_option('bkpwp_listmax_backups');
	    if (!empty($_REQUEST['bkpwp_show_all'])) {
		$maxview = 999;
	    }
	    return $maxview;
    }
    
    function bkpwp_get_backups() {
	$files = array();
	$bkpwppath = get_option("bkpwppath");
	if (!is_writable($bkpwppath)) {
		return;
	}
	$restorefile = $bkpwppath."/bkpwp_restore.sql";
	if (file_exists($restorefile)) {
		unlink($restorefile);
	}
	if ($handle = opendir($bkpwppath)) {
	      while (false !== ($file = readdir($handle))) {
	  	    if ((substr($file,0,1) != ".") && !is_dir($bkpwppath."/".$file)) {
			    $files[] = array("file" => $bkpwppath."/".$file,
			    			"filename" => $file);
	  	    }
	      }
	      closedir($handle);
	  }
	if (count($files) < 1) { return; }
	foreach ($files as $key => $row) {
	$filename[$key]  = $row['filename'];
	}
	array_multisort($filename, SORT_DESC, $files);
	return $files;
    }
    
    function bkpwp_get_logs() {
	$files = array();
	$bkpwppath = get_option("bkpwppath")."/logs";
	if (!is_writable($bkpwppath)) {
		return;
	}
	if ($handle = opendir($bkpwppath)) {
	      while (false !== ($file = readdir($handle))) {
	  	    if (($file != ".") && ($file != "..") && !is_dir($bkpwppath."/".$file)) {
			    $files[] = array("file" => $bkpwppath."/".$file,
			    			"filename" => $file);
	  	    }
	      }
	      closedir($handle);
	  }
	if (count($files) < 1) { return; }
	foreach ($files as $key => $row) {
	$filename[$key]  = $row['filename'];
	}
	array_multisort($filename, SORT_DESC, $files);
	return $files;
    }
}


require(ABSPATH."wp-includes/class-phpmailer.php");
class backupwordpressMailer extends PHPMailer {
    // Set default variables for all new objects
    //var $From     = $GLOBALS['userdata']->user_email;
    var $FromName = "BackUpWordPress";
    /* 
    var $Host     = "";
    var $Username = '';  // SMTP username
    var $Password = ''; // SMTP password 
    var $SMTPAuth = true; */
    var $Mailer   = "mail";
    var $WordWrap = 75;
}

function bkpwp_mail_now($file="", $bkpwpinfo="") {
	ob_start();
	include_once(BKPWP_PLUGIN_PATH."bkpwp-pages/bkpwp_footer.php");
	$text_html = ob_get_contents();
	ob_end_clean();
	
	ob_start();
	include_once(BKPWP_PLUGIN_PATH."bkpwp-pages/bkpwp_mail_footer.php");
	$text_plain = ob_get_contents();
	ob_end_clean();
	
	// Instantiate your new class
	$mail = new backupwordpressMailer;
	$mail->IsHTML(true);
	
	// Now you only need to add the necessary stuff
	
	$email = get_option("bkpwp_automail_address");
	$em = explode (",",$email);
	foreach($em as $e) {
		$mail->AddAddress(trim($e), "Backup Admin");
	}
	$mail->From = get_option("bkpwp_automail_from");
	$mail->FromName = __("BackUpWordPress","bkpwp")." ".get_bloginfo("url");
	$mail->Subject = __("BackUpWordPress","bkpwp")." ".get_bloginfo("url");
	$mail->Body    = "<html><body>";
	$mail->Body    .= __("Your requested Backup","bkpwp");
	if (empty($file)) {
		$mail->Body    .= __("This Backup exceeded","bkpwp")." ".get_option("bkpwp_automail_maxsize")." ".__("MB (megabytes)","bkpwp")."<br /><br />\n\n";
		$mail->Body    .= __("Please download it from your WordPress administration backend.","bkpwp")."<br /><br />\n\n";
	}
	
	$mail->Body .= $bkpwpinfo;
	$mail->Body .= $text_html;
	$mail->Body .= "</body></html>";
	$mail->AltBody = strip_tags($text_plain);
	
	if (!empty($file)) {
		$mail->AddAttachment(base64_decode($file));  // optional name
	}
	
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
		return false;
	} else {
		return true;
	}
}
?>
