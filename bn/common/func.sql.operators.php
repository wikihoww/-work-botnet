<?php
date_default_timezone_set('Europe/Moscow');
function select_operator_bots($db)
{
	$date = date("Y-m-d");
	$date_unix = (strtotime($date) - 86400);
	$query_1 = mysql_query("SELECT DISTINCT * FROM list GROUP BY operator", $db) or die(mysql_error());
	while ($queryrow_1 = mysql_fetch_array($query_1))
	{
		$operator = $queryrow_1['operator'];
		$query_2 = mysql_query("SELECT * FROM list WHERE operator='$operator'", $db) or die(mysql_error());
		$queryrow_2 = mysql_num_rows($query_2);
		$query = mysql_query("SELECT * FROM list WHERE operator='$operator'", $db) or die(mysql_error());
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
				<td>{$operator}</td>
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