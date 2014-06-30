<?php 
require_once('Connections/church.php');
require_once('functions.php');

$dateentry = dateofbirth ; 

$date =date('Y-m-d');
$month =date("m",strtotime($date))."";
$day=date("d",strtotime($date))."";

foreach ($dateentry as $key => $entry) {
	split($dateofbirth, '$year','$month','$day')
	# code...
		mysql_select_db($database_church, $church);
		$query_allbirthdays = "UPDATE * FROM member_details ms LEFT JOIN member_contacts mc ON ms.memberid=mc.memberid where ms.birthdaymonth=".$month." AND ms.birthdate=".$day."  ORDER BY ms.firstname ASC";
		$query_limit_allbirthdays = sprintf("%s LIMIT %d, %d", $query_allbirthdays, $startRow_allbirthdays, $maxRows_allbirthdays);
		$allbirthdays = mysql_query($query_limit_allbirthdays, $church) or die(mysql_error());
		$row_allbirthdays = mysql_fetch_assoc($allbirthdays);

}


?>