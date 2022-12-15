<?php
function select_login($login1, $db)
{
	$query = mysql_query("SELECT * FROM accounts WHERE login='" . sqlPrep($login1) . "'", $db) or die(mysql_error());
	$queryaccrow = mysql_fetch_array($query);

		if ($query == TRUE)
		{
			return $queryaccrow;
		}

}


?>