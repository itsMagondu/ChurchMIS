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
    		 //	 $i++;
		//	print_r ($row);
		} 

	for($i=0;$i<=count($rows);$i++) { 
     //do something with $rows[$i]['field_name'] 
		//print_r ($rows[$i])."<br>";
		//$getid = $rows['memberid'];
		$myid = $rows[$i]["memberid"];
		//$phonenumber = $rows[$i]["phonenumber"];
		$phonenumber = ltrim($rows[$i]["phonenumber"],0);
		
		$newnumber = '+254'.$phonenumber;
		//echo $getid;
		echo $myid."<br>";
		//echo $phonenumber."<br>";
		echo $newnumber."<br>";

			
					$update = mysql_query("UPDATE member_contacts 
                        SET internationalnumber = '$newnumber' WHERE memberid = '$myid'");
			
		
		
			
	} 




?>