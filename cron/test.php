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
		$phonenumber = ltrim($rows[$i]["phonenumber"],0);
		$countryCode = '254';
		$newNumber = str_replace('0', '+'.$countryCode, $phoneNumber)
		
		

		//echo $getid;
		echo $myid."<br>";
		echo $phonenumber."<br>";
		echo $countryCode."<br>";
		echo $newNumber."<br>";


      	$update = mysql_query("UPDATE member_contacts 
                        SET internationalnumber = '$newNumber' WHERE memberid = '$myid'");

		//$result1 = mysql_query($update, $church) or die('canot update');
		//$row4 = mysql_fetch_assoc($result1);
		//print_r($row4);

		//$update = "update member_info_date  set birthdayyear = ".$year." and birthdaymonth = ".$month." and  birthdate = ".$day." where memberid = ".$myid.";*/
	} 




?>