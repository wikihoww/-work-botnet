<?php

function select_bots($page, $db)
{
	if ($page == 1)
	{
		$n = 0;
	}
	else
	{
		$page = $page - 1;
		$n = $page * 50;
	}
	$query = mysql_query("SELECT * FROM job_logs ORDER BY date DESC LIMIT $n, 50", $db) or die(mysql_error());


while ($queryrow = mysql_fetch_array($query))
	{
		$date = $queryrow['date'];
		$IMEI = $queryrow['IMEI'];
		$active_number = $queryrow['active_number'];
		$active_prefix = $queryrow['active_prefix'];
		$active_text = $queryrow['active_text'];
		$active_url = $queryrow['active_url'];
		$active_server = $queryrow['active_server'];		


		$mess .= <<<HERE
			    <tr>
				        <td align='center'>{$date}</td>
				        <td align='center'>{$IMEI}</td>
				        <td align='center'>{$active_number}</td>
				        <td align='center'>{$active_prefix}</td>
				        <td align='center'>{$active_text}</td>
				        <td align='center'>{$active_url}</td>
				        <td align='center'>{$active_server}</td>						
			    </tr>
HERE;
	}

	return $mess;
	
}


function search_bots($search_date, $db)
{

	if ($search_date == TRUE)
{
	$search = $search_date;
	if (strlen($search) > 10)
	{
		$date = date("%Y-m-d%", (strtotime($search)));
	}
	else
	{
		$date = date("%Y-m-d%", (strtotime($search)));
	}
		$query = mysql_query("SELECT * FROM job_logs WHERE CONCAT(date) LIKE '$date'", $db) or die(mysql_error());
}

while ($queryrow = mysql_fetch_array($query))
	{
		$date = $queryrow['date'];
		$IMEI = $queryrow['IMEI'];
		$active_number = $queryrow['active_number'];
		$active_prefix = $queryrow['active_prefix'];
		$active_text = $queryrow['active_text'];
		$active_url = $queryrow['active_url'];
		$active_server = $queryrow['active_server'];		


		$mess .= <<<HERE
			    <tr>
				        <td align='center'>{$date}</td>
				        <td align='center'>{$IMEI}</td>
				        <td align='center'>{$active_number}</td>
				        <td align='center'>{$active_prefix}</td>
				        <td align='center'>{$active_text}</td>
				        <td align='center'>{$active_url}</td>
				        <td align='center'>{$active_server}</td>						
			    </tr>
HERE;

	}

	return $mess;
	
}

?>