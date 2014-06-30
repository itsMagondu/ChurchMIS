<?php 
require_once('../Connections/church.php');
require_once('../functions.php');


		$dateofbirth;

		mysql_select_db($database_church, $church);
		$query = "SELECT phonenumber,memberid,internationalnumber FROM member_contacts;";		
		$result = mysql_query($query, $church) or die(mysql_error());
		$row = mysql_fetch_assoc($result);

		while ($row = mysql_fetch_assoc($result)) { 
    		 $rows[] = $row; 
    		 	
		//print_r ($row) ."<br/>";
		
		} 
			for($i=0;$i<=count($rows);$i++) { 


	
				$phonenumber = ltrim($rows[$i]["phonenumber"],0);
					
					
				print $phonenumber ."<br/>";

				

				}
	






?>