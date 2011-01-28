<?php

class BKPWP_SCHEDULE {
    
    function BKPWP_SCHEDULE() {
    }
    
    function bkpwp_get_options_by_created($created) {
	   $schedules = get_option("bkpwp_schedules");
	   if (is_array($schedules)) {
		   foreach($schedules as $s) {
			   if ($s['created'] == $created) {
				   return $s;
			   }
		   }
	   }
    }	
    
    function bkpwp_update_schedule($options) {
	   $schedules = get_option("bkpwp_schedules");
	   $newschedules = array();
	   foreach($schedules as $s) {
		if ($s['created'] == $options['created']) {
			$s = $options;
		}
	   	$newschedules = $s;
	   }
	   update_option("bkpwp_schedules",$newschedules);
    }
    
    function bkpwp_delete_schedule_by_created($created) {
	   $schedules = get_option("bkpwp_schedules");
	   $newschedules = array();
	   foreach($schedules as $s) {
		   if ($s['created'] == $created) {
			   $timestamp = wp_next_scheduled("bkpwp_schedule_bkpwp_hook",$s);
			   if(!empty($timestamp)) {
				   wp_unschedule_event($timestamp,"bkpwp_schedule_bkpwp_hook",$s);
			   }
			   $ret = 1;
		   } else {
			   $newschedules[] = $s;
		   }
	   }
	   update_option("bkpwp_schedules",$newschedules);
	   if (empty($ret)) { return false; }
	   return $ret;
    }
    
    
    function bkpwp_unset_schedules() {
	$crons = get_option("cron");
	if (is_array($crons)) {
		foreach($crons as $timestamp => $cron) {
			if (!is_array($cron)) { continue; }
			foreach($cron as $hook => $options) {
				if($hook == "bkpwp_schedule_bkpwp_hook") {
					foreach ($options as $key=>$value) {
					wp_unschedule_event($timestamp,$hook,$value['args']);
					}
				}
			}
		}
	}
    }
    
    
    function bkpwp_toggle_schedule($created) {
	   $schedules = get_option("bkpwp_schedules");
	   $newschedules = array();
	   $bkpwp_reccurrences = get_option("bkpwp_reccurrences");
	   foreach($schedules as $s) {
		   if ($s['created'] == $created) {
			   if ($s['status'] == "active") {
				   $timestamp = wp_next_scheduled("bkpwp_schedule_bkpwp_hook",$s);
				   if(!empty($timestamp)) {
					   wp_unschedule_event($timestamp,"bkpwp_schedule_bkpwp_hook",$s);
					   $s['status'] = "inactive";
					   $ret = "inactive";
				   } else {
					   return false;
				   }
			   } else {
				   $recc = $s['reccurrence'];
				   $s['status'] = "active";
				   wp_schedule_event(time()+$bkpwp_reccurrences[$recc]['interval'], $s['reccurrence'], 'bkpwp_schedule_bkpwp_hook',$s);
				   $ret = "active";
			   }
		   }
		   $newschedules[] = $s;
	   }
	   update_option("bkpwp_schedules",$newschedules);
	   if (empty($ret)) { return false; }
	   return $ret;
    }
    
    function bkpwp_test_schedule() {
	   $schedules = get_option("bkpwp_schedules");
		$test = array("preset" => "sql only",
				  "status" => "active",
				  "reccurrence" => '',
				  "info" => __("Test schedule running in 30 seconds","bkpwp"),
				  "default" => '',
				  "created" => date("Y-m-d-H-i-s"));
		$schedules[] = $test;	  
	if (!wp_next_scheduled('bkpwp_schedule_bkpwp_hook', $test)) {
		wp_schedule_single_event(time()+30, 'bkpwp_schedule_bkpwp_hook', $test);
		update_option("bkpwp_schedules",$schedules);
	   return true;
	} else {
	   return false;
	}
    }
}

?>
