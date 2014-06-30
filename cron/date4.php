<?php 
require_once('../Connections/church.php');
require_once('../functions.php');

		mysql_select_db($database_church, $church);
		$query = "select dateofbirth from member_info_date;";		
		$result = mysql_query($query, $church) or die(mysql_error());
		$row = mysql_fetch_array($result);

		foreach ($colors as $dateofbirth) {

   		echo "$dateofbirth <br>";
   		
		}

?>