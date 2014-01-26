<?php 
if(!isset($_SESSION))
{
session_start();
} 
include ('Connections/church.php');
require_once('functions.php');  ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_GET['Delete']) &&(isset($_GET['baptismid'])) && ($_GET['baptismid'] != ""))) {
	
	   $tab="index.php?sacraments=true#tabs-1";
	$whereto=$tab;	
	
	
  $deleteSQL = sprintf("DELETE FROM baptism WHERE baptismid=".($_GET['baptismid'])."", 
                       GetSQLValueString($_GET['baptismid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}





if ((isset($_POST["savebaptism"]))) {
	
		$tab="index.php?sacraments=true#tabs-1";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO baptism (baptismid, memberid, date_baptised,officiating_clergy,geust_leader,male_god_parent,female_god_parent,baptism_venue, baptismcert_no) VALUES (%s, %s, %s, %s, %s, %s,%s,%s,%s)",
                       GetSQLValueString($_POST['baptismid'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['date_baptised'], "text"),
                       GetSQLValueString($_POST['officiating_clergy'], "text"),
                       GetSQLValueString($_POST['geust_leader'], "text"),
					   GetSQLValueString($_POST['male_god_parent'], "text"),                      GetSQLValueString($_POST['female_god_parent'], "text"),
					   GetSQLValueString($_POST['baptism_venue'], "text"),
                       GetSQLValueString($_POST['baptismcert_no'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
}

if ((isset($_POST["updatebaptism"]))) {
	
	
		$tab="index.php?sacraments=true#tabs-1";
	$whereto=$tab;
	
	
	
if ((isset($_GET['baptismid'])) && ($_GET['baptismid']!="")){
	
  $updateSQL = sprintf("UPDATE baptism SET memberid=%s, date_baptised=%s,officiating_clergy=%s, geust_leader=%s,male_god_parent=%s,female_god_parent=%s,baptism_venue=%s, baptismcert_no=%s WHERE baptismid=".$_GET['baptismid']."",
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['date_baptised'], "text"),
                        GetSQLValueString($_POST['officiating_clergy'], "text"),
                       GetSQLValueString($_POST['geust_leader'], "text"),
					   GetSQLValueString($_POST['male_god_parent'], "text"),
					   GetSQLValueString($_POST['female_god_parent'], "text"),
					     GetSQLValueString($_POST['baptism_venue'], "text"),
                       GetSQLValueString($_POST['baptismcert_no'], "int"),
                       GetSQLValueString($_POST['baptismid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}
}



if ((isset($_GET['archive']) &&(isset($_GET['sacraments'])) && ($_GET['sacraments'] != ""))) {

  $uPdateSQL1= sprintf("UPDATE  baptism  SET baptism_status=2 
  WHERE baptismid=".$_GET['sacraments']."",
   GetSQLValueString($_GET['sacraments'], "int"));

   mysql_select_db($database_church, $church);
  $Result1= mysql_query($uPdateSQL1, $church) or die('cannot archive baptism');
}



mysql_select_db($database_church, $church);
$query_addleader = "SELECT * FROM baptism";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);

mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM baptism";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

if((isset($_GET['baptismid']) && ($_GET['baptismid']!=""))){
mysql_select_db($database_church, $church);
$query_editbaptism = "SELECT * FROM baptism b INNER JOIN member_details m ON b.memberid=m.memberid  WHERE baptismid=".$_GET['baptismid']."";
$editbaptism = mysql_query($query_editbaptism, $church) or die(mysql_error());
$row_editbaptism = mysql_fetch_assoc($editbaptism);
$totalRows_editbaptism = mysql_num_rows($editbaptism);
}
mysql_select_db($database_church, $church);
$query_addbaptism = "SELECT * FROM baptism";
$addbaptism = mysql_query($query_addbaptism, $church) or die(mysql_error());
$row_addbaptism = mysql_fetch_assoc($addbaptism);
$totalRows_addbaptism = mysql_num_rows($addbaptism);

$maxRows_viewbaptism = 10;
$pageNum_viewbaptism = 0;
if (isset($_GET['pageNum_viewbaptism'])) {
  $pageNum_viewbaptism = $_GET['pageNum_viewbaptism'];
}
$startRow_viewbaptism = $pageNum_viewbaptism * $maxRows_viewbaptism;

mysql_select_db($database_church, $church);
$query_viewbaptism = "SELECT * FROM baptism b INNER JOIN member_details m ON b.memberid=m.memberid ";
$query_limit_viewbaptism = sprintf("%s LIMIT %d, %d", $query_viewbaptism, $startRow_viewbaptism, $maxRows_viewbaptism);
$viewbaptism = mysql_query($query_limit_viewbaptism, $church) or die(mysql_error());
$row_viewbaptism = mysql_fetch_assoc($viewbaptism);

if (isset($_GET['totalRows_viewbaptism'])) {
  $totalRows_viewbaptism = $_GET['totalRows_viewbaptism'];
} else {
  $all_viewbaptism = mysql_query($query_viewbaptism);
  $totalRows_viewbaptism = mysql_num_rows($all_viewbaptism);
}
$totalPages_viewbaptism = ceil($totalRows_viewbaptism/$maxRows_viewbaptism)-1;

$queryString_viewbaptism = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewbaptism") == false && 
        stristr($param, "totalRows_viewbaptism") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewbaptism = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewbaptism = sprintf("&totalRows_viewbaptism=%d%s", $totalRows_viewbaptism, $queryString_viewbaptism);





if ((isset($_GET['archive']) &&(isset($_GET['sacraments'])) && ($_GET['sacraments'] != ""))) {

  $uPdateSQL2= sprintf("UPDATE  first_confirmation  SET first_confirmation_status=2 
  WHERE first_confirmationid=".$_GET['sacraments']."",
   GetSQLValueString($_GET['sacraments'], "int"));

   mysql_select_db($database_church, $church);
  $Result2= mysql_query($uPdateSQL2, $church) or die('cannot archive baptism');
}




if ((isset($_POST["confirmation"]))) {
	
	
	$tab="index.php?sacraments=true#tabs-2";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO first_confirmation (firstconfirmation_date, memberid,male_god_parent,female_god_parent,officiating_clergy,preconfirmation_venue, first_confirmationcert_no) VALUES (%s, %s, %s, %s, %s,%s,%s)",
                     
                            GetSQLValueString($_POST['firstconfirmation_date'], "text"),
                            GetSQLValueString($_POST['memberid'], "int"),
					        GetSQLValueString($_POST['male_god_parent'], "text"),
					        GetSQLValueString($_POST['female_god_parent'], "text"),
                            GetSQLValueString($_POST['officiating_clergy'], "text"),
					        GetSQLValueString($_POST['preconfirmation_venue'], "text"),
                           GetSQLValueString($_POST['first_confirmationcert_no'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
  
}

if ((isset($_POST["updateconfirmation"]))) {
	
		$tab="index.php?sacraments=true#tabs-2";
	$whereto=$tab;
	
	
	
if ((isset($_GET['first_confirmationid'])) && ($_GET['first_confirmationid']!="")){
	
	
  $updateSQL = sprintf("UPDATE first_confirmation SET firstconfirmation_date=%s, memberid=%s,male_god_parent=%s,female_god_parent=%s,officiating_clergy=%s, geust_leader=%s, preconfirmation_venue=%s,first_confirmationcert_no=%s WHERE first_confirmationid=".$_GET['first_confirmationid']."",
                       GetSQLValueString($_POST['firstconfirmation_date'], "text"),
                       GetSQLValueString($_POST['memberid'], "int"),
					  GetSQLValueString($_POST['male_god_parent'], "text"),
					  GetSQLValueString($_POST['female_god_parent'], "text"),
                       GetSQLValueString($_POST['officiating_clergy'], "text"),
                       GetSQLValueString($_POST['geust_leader'], "text"),
					     GetSQLValueString($_POST['preconfirmation_venue'], "text"),
                      GetSQLValueString($_POST['first_confirmationcert_no'], "int"),
                       GetSQLValueString($_POST['first_confirmationid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}

}

$maxRows_addmember = 10;
$pageNum_addmember = 0;
if (isset($_GET['pageNum_addmember'])) {
  $pageNum_addmember = $_GET['pageNum_addmember'];
}
$startRow_addmember = $pageNum_addmember * $maxRows_addmember;



mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$query_limit_addmember = sprintf("%s LIMIT %d, %d", $query_addmember, $startRow_addmember, $maxRows_addmember);
$addmember = mysql_query($query_limit_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);

if (isset($_GET['totalRows_addmember'])) {
  $totalRows_addmember = $_GET['totalRows_addmember'];
} else {
  $all_addmember = mysql_query($query_addmember);
  $totalRows_addmember = mysql_num_rows($all_addmember);
}
$totalPages_addmember = ceil($totalRows_addmember/$maxRows_addmember)-1;

mysql_select_db($database_church, $church);
$query_addleader = "SELECT * FROM first_confirmation";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);

mysql_select_db($database_church, $church);
$query_addfirstconfirmation = "SELECT * FROM first_confirmation";
$addfirstconfirmation = mysql_query($query_addfirstconfirmation, $church) or die(mysql_error());
$row_addfirstconfirmation = mysql_fetch_assoc($addfirstconfirmation);
$totalRows_addfirstconfirmation = mysql_num_rows($addfirstconfirmation);

if((isset($_GET['first_confirmationid'])) &&($_GET['first_confirmationid']!="")){
mysql_select_db($database_church, $church);
$query_editfirstconfirmation = "SELECT * FROM first_confirmation f INNER JOIN member_details m ON f.memberid=m.memberid  WHERE first_confirmationid=".$_GET['first_confirmationid']." ";
$editfirstconfirmation = mysql_query($query_editfirstconfirmation, $church) or die(mysql_error());
$row_editfirstconfirmation = mysql_fetch_assoc($editfirstconfirmation);
$totalRows_editfirstconfirmation = mysql_num_rows($editfirstconfirmation);
}



$maxRows_viewfirstconfirmation = 10;
$pageNum_viewfirstconfirmation = 0;
if (isset($_GET['pageNum_viewfirstconfirmation'])) {
  $pageNum_viewfirstconfirmation = $_GET['pageNum_viewfirstconfirmation'];
}
$startRow_viewfirstconfirmation = $pageNum_viewfirstconfirmation * $maxRows_viewfirstconfirmation;


mysql_select_db($database_church, $church);
$query_viewfirstconfirmation = "SELECT * FROM first_confirmation f INNER JOIN member_details m ON f.memberid=m.memberid WHERE f.first_confirmation_status='1' ";
$query_limit_viewfirstconfirmation = sprintf("%s LIMIT %d, %d", $query_viewfirstconfirmation, $startRow_viewfirstconfirmation, $maxRows_viewfirstconfirmation);
$viewfirstconfirmation = mysql_query($query_limit_viewfirstconfirmation, $church) or die(mysql_error());
$row_viewfirstconfirmation = mysql_fetch_assoc($viewfirstconfirmation);



if (isset($_GET['totalRows_viewfirstconfirmation'])) {
  $totalRows_viewfirstconfirmation = $_GET['totalRows_viewfirstconfirmation'];
} else {
  $all_viewfirstconfirmation = mysql_query($query_viewfirstconfirmation);
  $totalRows_viewfirstconfirmation = mysql_num_rows($all_viewfirstconfirmation);
}
$totalPages_viewfirstconfirmation = ceil($totalRows_viewfirstconfirmation/$maxRows_viewfirstconfirmation)-1;


$queryString_viewfirstconfirmation = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewfirstconfirmation") == false && 
        stristr($param, "totalRows_viewfirstconfirmation") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewfirstconfirmation = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewfirstconfirmation = sprintf("&totalRows_viewfirstconfirmation=%d%s", $totalRows_viewfirstconfirmation, $queryString_viewfirstconfirmation);

$queryString_viewfirstconfirmation = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewfirstconfirmation") == false && 
        stristr($param, "totalRows_viewfirstconfirmation") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewfirstconfirmation = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewfirstconfirmation = sprintf("&totalRows_viewfirstconfirmation=%d%s", $totalRows_viewfirstconfirmation, $queryString_viewfirstconfirmation);




if ((isset($_GET['archive']) &&(isset($_GET['sacraments'])) && ($_GET['sacraments'] != ""))) {

  $uPdateSQL3= sprintf("UPDATE  second_confirmation  SET second_confirmation_status=2 
  WHERE second_confirmationid=".$_GET['sacraments']."",
   GetSQLValueString($_GET['sacraments'], "int"));

   mysql_select_db($database_church, $church);
  $Result3= mysql_query($uPdateSQL3, $church) or die('cannot archive baptism');
}



if ((isset($_POST["secondconfirmation"]))) {
	
		$tab="index.php?sacraments=true#tabs-3";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO second_confirmation (memberid,male_god_parent,female_god_parent, secondconfirmation_date, leader, geust_leader, second_confirmationcert_no) VALUES (%s, %s, %s, %s, %s,%s,%s)",
                     
                       GetSQLValueString($_POST['memberid'], "int"),
					   GetSQLValueString($_POST['male_god_parent'], "text"),
						GetSQLValueString($_POST['female_god_parent'], "text"),
                       GetSQLValueString($_POST['secondconfirmation_date'], "text"),
                       GetSQLValueString($_POST['leader'], "text"),
                       GetSQLValueString($_POST['geust_leader'], "text"),
                       GetSQLValueString($_POST['second_confirmationcert_no'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
	 
  
}

if ((isset($_POST["updatesecondconfirmation"]))) {
	
	
	$tab="index.php?sacraments=true#tabs-3";
	$whereto=$tab;
	
	
	if((isset($_GET['second_confirmationid']) && ($_GET['second_confirmationid']!==""))){
  $updateSQL = sprintf("UPDATE second_confirmation SET memberid=%s,male_god_parent=%s,female_god_parent=%s, secondconfirmation_date=%s, leader=%s, geust_leader=%s, second_confirmationcert_no=%s WHERE second_confirmationid=".$_GET['second_confirmationid']."",
                       GetSQLValueString($_POST['memberid'], "int"),
					   GetSQLValueString($_POST['male_god_parent'], "text"),
				        GetSQLValueString($_POST['female_god_parent'], "text"),
                       GetSQLValueString($_POST['secondconfirmation_date'], "text"),
                       GetSQLValueString($_POST['leader'], "text"),
                       GetSQLValueString($_POST['geust_leader'], "text"),
                       GetSQLValueString($_POST['second_confirmationcert_no'], "int"),
                       GetSQLValueString($_POST['second_confirmationid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
  
     header("Location:$whereto");
  
}
}

mysql_select_db($database_church, $church);
$query_addleader1 ="SELECT * FROM leader l LEFT JOIN member_details md ON md.memberid=l.memberid ";
$addleader1 = mysql_query($query_addleader1, $church) or die(mysql_error());
$row_addleader1 = mysql_fetch_assoc($addleader1);
$totalRows_addleader1 = mysql_num_rows($addleader1);

mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);



mysql_select_db($database_church, $church);
$query_addsecondconfirmation = "SELECT * FROM second_confirmation";
$addsecondconfirmation = mysql_query($query_addsecondconfirmation, $church) or die(mysql_error());
$row_addsecondconfirmation = mysql_fetch_assoc($addsecondconfirmation);
$totalRows_addsecondconfirmation = mysql_num_rows($addsecondconfirmation);


	if((isset($_GET['second_confirmationid']) && ($_GET['second_confirmationid']!==""))){
mysql_select_db($database_church, $church);
$query_editsecondconfirmation = "SELECT * FROM second_confirmation sn INNER JOIN member_details m ON sn.memberid=m.memberid  WHERE second_confirmationid=".$_GET['second_confirmationid']."";
$editsecondconfirmation = mysql_query($query_editsecondconfirmation, $church) or die(mysql_error());
$row_editsecondconfirmation = mysql_fetch_assoc($editsecondconfirmation);
$totalRows_editsecondconfirmation = mysql_num_rows($editsecondconfirmation);

	}
	


	
	
$maxRows_viewsecondconfirmation = 20;
$pageNum_viewsecondconfirmation = 0;
if (isset($_GET['pageNum_viewsecondconfirmation'])) {
  $pageNum_viewsecondconfirmation = $_GET['pageNum_viewsecondconfirmation'];
}
$startRow_viewsecondconfirmation = $pageNum_viewsecondconfirmation * $maxRows_viewsecondconfirmation;

mysql_select_db($database_church, $church);
$query_viewsecondconfirmation = "SELECT * FROM second_confirmation s   
 LEFT JOIN member_details md ON md.memberid=s.memberid WHERE s.second_confirmation_status='1'
";
$query_limit_viewsecondconfirmation = sprintf("%s LIMIT %d, %d", $query_viewsecondconfirmation, $startRow_viewsecondconfirmation, $maxRows_viewsecondconfirmation);
$viewsecondconfirmation = mysql_query($query_limit_viewsecondconfirmation, $church) or die(mysql_error());
$row_viewsecondconfirmation = mysql_fetch_assoc($viewsecondconfirmation);

if (isset($_GET['totalRows_viewsecondconfirmation'])) {
  $totalRows_viewsecondconfirmation = $_GET['totalRows_viewsecondconfirmation'];
} else {
  $all_viewsecondconfirmation = mysql_query($query_viewsecondconfirmation);
  $totalRows_viewsecondconfirmation = mysql_num_rows($all_viewsecondconfirmation);
}
$totalPages_viewsecondconfirmation = ceil($totalRows_viewsecondconfirmation/$maxRows_viewsecondconfirmation)-1;

$queryString_viewsecondconfirmation = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewsecondconfirmation") == false && 
        stristr($param, "totalRows_viewsecondconfirmation") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewsecondconfirmation = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewsecondconfirmation = sprintf("&totalRows_viewsecondconfirmation=%d%s", $totalRows_viewsecondconfirmation, $queryString_viewsecondconfirmation);








if ((isset($_GET['archive']) &&(isset($_GET['sacraments'])) && ($_GET['sacraments'] != ""))) {

  $uPdateSQL4= sprintf("UPDATE  marriage  SET status_id=2 
  WHERE marriageid=".$_GET['sacraments']."",
   GetSQLValueString($_GET['sacraments'], "int"));

   mysql_select_db($database_church, $church);
  $Result4= mysql_query($uPdateSQL4, $church) or die('cannot archive marriage');
}









if ((isset($_POST["updatemarriage"]))) {
	
	$tab="index.php?sacraments=true#tabs-4";
	$whereto=$tab;
	
	
	if((isset($_GET['marriageid']) && ($_GET['marriageid']!=""))){
		
$updateSQL = sprintf("UPDATE marriage SET husbandname=%s, wifenameid=%s,best_man=%s,best_maid=%s, marriage_date=%s, leaderid=%s,solemnization_venue=%s, marriagecert_no=%s WHERE marriageid=".$_GET['marriageid']."",
                       GetSQLValueString($_POST['husbandname'], "int"),
                       GetSQLValueString($_POST['wifenameid'], "int"),
					   GetSQLValueString($_POST['best_man'], "text"),
					GetSQLValueString($_POST['best_maid'], "text"),
                       GetSQLValueString($_POST['marriage_date'], "text"),
                       GetSQLValueString($_POST['leaderid'], "int"),
					    GetSQLValueString($_POST['solemnization_venue'], "text"),
                       GetSQLValueString($_POST['marriagecert_no'], "int"),
                       GetSQLValueString($_POST['marriageid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}



}



if ((isset($_POST["savemarriage"]))) {
	
	$tab="index.php?sacraments=true#tabs-4";
	$whereto=$tab;	
	
  $insertSQL = sprintf("INSERT INTO marriage (husbandname,husband, wifenameid,wife, marriage_date,marriage_type, leader_name,solemnization_venue, marriagecert_no) VALUES (%s, %s, %s, %s, %s, %s,%s,%s,%s)",
                      
                       GetSQLValueString($_POST['husbandname'], "int"),
					    GetSQLValueString($_POST['husband'], "text"),
                       GetSQLValueString($_POST['wifenameid'], "int"),
		               GetSQLValueString($_POST['wife'], "text"),
					   GetSQLValueString($_POST['marriage_date'], "text"), 
					    GetSQLValueString($_POST['marriage_type'], "text"),
                       GetSQLValueString($_POST['leader_name'], "text"),
					   GetSQLValueString($_POST['solemnization_venue'], "text"),
                       GetSQLValueString($_POST['marriagecert_no'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
}

mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

mysql_select_db($database_church, $church);
$query_addmarriage = "SELECT * FROM marriage";
$addmarriage = mysql_query($query_addmarriage, $church) or die(mysql_error());
$row_addmarriage = mysql_fetch_assoc($addmarriage);
$totalRows_addmarriage = mysql_num_rows($addmarriage);

mysql_select_db($database_church, $church);
$query_addleader = "SELECT * FROM leader";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);


if((isset($_GET['marriageid']) && ($_GET['marriageid']!=""))){

mysql_select_db($database_church, $church);
$query_editmarriage = "SELECT * FROM marriage m LEFT JOIN member_details md ON m.wifenameid=md.memberid WHERE m.marriageid=".$_GET['marriageid']."";
$editmarriage = mysql_query($query_editmarriage, $church) or die(mysql_error());
$row_editmarriage = mysql_fetch_assoc($editmarriage);
$totalRows_editmarriage = mysql_num_rows($editmarriage);

	}
	
if((isset($_GET['marriageid']) && ($_GET['marriageid']!=""))){

mysql_select_db($database_church, $church);
$query_editmarriagehusband = "SELECT * FROM marriage m LEFT JOIN member_details md ON m.husbandname=md.memberid WHERE m.marriageid=".$_GET['marriageid']."";
$editmarriagehusband = mysql_query($query_editmarriagehusband, $church) or die(mysql_error());
$row_editmarriagehusband = mysql_fetch_assoc($editmarriagehusband);
$totalRows_editmarriagehusband = mysql_num_rows($editmarriagehusband);

	}	
	
	
$maxRows_viewmarriage = 25;
$pageNum_viewmarriage = 0;
if (isset($_GET['pageNum_viewmarriage'])) {
  $pageNum_viewmarriage = $_GET['pageNum_viewmarriage'];
}
$startRow_viewmarriage = $pageNum_viewmarriage * $maxRows_viewmarriage;

mysql_select_db($database_church, $church);
$query_viewmarriage = "SELECT * FROM marriage m where m.status_id='1'";
$query_limit_viewmarriage = sprintf("%s LIMIT %d, %d", $query_viewmarriage, $startRow_viewmarriage, $maxRows_viewmarriage);
$viewmarriage = mysql_query($query_limit_viewmarriage, $church) or die(mysql_error());
$row_viewmarriage = mysql_fetch_assoc($viewmarriage);





if (isset($_GET['totalRows_viewmarriage'])) {
  $totalRows_viewmarriage = $_GET['totalRows_viewmarriage'];
} else {
  $all_viewmarriage = mysql_query($query_viewmarriage);
  $totalRows_viewmarriage = mysql_num_rows($all_viewmarriage);
}
$totalPages_viewmarriage = ceil($totalRows_viewmarriage/$maxRows_viewmarriage)-1;

$queryString_viewmarriage = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewmarriage") == false && 
        stristr($param, "totalRows_viewmarriage") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewmarriage = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewmarriage = sprintf("&totalRows_viewmarriage=%d%s", $totalRows_viewmarriage, $queryString_viewmarriage);




if ((isset($_POST["save"]))) {
	
	$tab="index.php?sacraments=true#tabs-5";
	$whereto=$tab;	
	(departedid);
  $insertSQL = sprintf("INSERT INTO departed (departedid, memberid,leaderid, deathcert_no, `date`, cause) VALUES (%s, %s, %s, %s, %s,%S)",
                       GetSQLValueString($_POST['departedid'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
					   GetSQLValueString($_POST['leaderid'], "int"),
                       GetSQLValueString($_POST['deathcert_no'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['cause'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}

if ((isset($_POST["update"]))) {
	
	if(isset($_GET['departedid']) && ($_GET['departedid']!="")){	
  $updateSQL = sprintf("UPDATE departed SET memberid=%s,leaderid=%s, deathcert_no=%s, `date`=%s, cause=%s WHERE departedid=".($_GET['departedid'])."",
                       GetSQLValueString($_POST['memberid'], "int"),
					   GetSQLValueString($_POST['leaderid'], "int"),
                       GetSQLValueString($_POST['deathcert_no'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['cause'], "text"),
                       GetSQLValueString($_POST['departedid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

}
mysql_select_db($database_church, $church);
$query_addmember = "SELECT md.memberid,md.lastname,md.middlename,md.firstname FROM member_details md ";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);



mysql_select_db($database_church, $church);
$query_addleader = "SELECT * FROM leader l INNER JOIN member_details ms ON l.memberid=ms.memberid";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);



mysql_select_db($database_church, $church);
$query_adddeceased = "SELECT * FROM departed";
$adddeceased = mysql_query($query_adddeceased, $church) or die(mysql_error());
$row_adddeceased = mysql_fetch_assoc($adddeceased);
$totalRows_adddeceased = mysql_num_rows($adddeceased);

if((isset($_GET['departedid'])) &&($_GET['departedid']!="")){
mysql_select_db($database_church, $church);
$query_editdeceased = "SELECT * FROM departed d INNER JOIN member_details md ON d.memberid=md.memberid WHERE departedid=".$_GET['departedid']."";
$editdeceased = mysql_query($query_editdeceased, $church) or die(mysql_error());
$row_editdeceased = mysql_fetch_assoc($editdeceased);
$totalRows_editdeceased = mysql_num_rows($editdeceased);
}
$maxRows_viewdeceased = 50;
$pageNum_viewdeceased = 0;
if (isset($_GET['pageNum_viewdeceased'])) {
  $pageNum_viewdeceased = $_GET['pageNum_viewdeceased'];
}
$startRow_viewdeceased = $pageNum_viewdeceased * $maxRows_viewdeceased;



if (isset($_GET['totalRows_viewdeceased'])) {
  $totalRows_viewdeceased = $_GET['totalRows_viewdeceased'];
} else {
  $all_viewdeceased = mysql_query($query_viewdeceased);
  $totalRows_viewdeceased = mysql_num_rows($all_viewdeceased);
}
$totalPages_viewdeceased = ceil($totalRows_viewdeceased/$maxRows_viewdeceased)-1;

$queryString_viewdeceased = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewdeceased") == false && 
        stristr($param, "totalRows_viewdeceased") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewdeceased = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewdeceased = sprintf("&totalRows_viewdeceased=%d%s", $totalRows_viewdeceased, $queryString_viewdeceased);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SACRAMENTS</title>
<link type="text/css" href="/st_peters/js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />

<script type="text/javascript" src="/st_peters/js/jquery-ui/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.sortable.js"></script>
	<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.effects.blind.js"></script>
<script src="/st_peters/SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="/st_peters/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link type="text/css" href="/st_peters/js/jquery-ui/demos/demos.css" rel="stylesheet" />
<link type="text/css" href="/st_peters/assets/css/tablecloth.css" rel="stylesheet"/>
<link type="text/css" href="/st_peters/assets/css/bootstrap-tables.css" rel="stylesheet"/>
<link type="text/css" href="/st_peters/assets/css/bootstrap.css" rel="stylesheet"/>
<link type="text/javascript" href="/st_peters/assets/js/bootstrap.js" />
<link type="text/javascript" href="tms.css"/>


<script type="text/javascript">
function ConfirmArchive()
{
  var x = confirm("Are you sure you want to Archive ?");
  if (x)
      return true;
  else
    return false;
}
</script>

<script type="text/javascript">
	$(function() {
		$('#date_baptised').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
			
		}); 
		$('#firstconfirmation_date').datepicker({
			inline: true,
            //minDate: new Date(), 
            //maxDate: '-120m',	  
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#secondconfirmation').datepicker({
			inline: true,
            //minDate: new Date(), 
            //maxDate: '-120m',	  
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#marriage_date').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#datedeceased').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob3').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob4').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#secondconfirmation_date').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#trainto').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#promodate').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#awarddate').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#acad_from').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#acad_to').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#emp_from').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dateofbirth').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		

	});
	</script>
            <script type="text/javascript">
	$(function() {
		$("#tabs").tabs().find(".ui-tabs-nav").sortable({axis:'x'});
	});
	</script>
    <link href="/st_peters/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="/st_peters/SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

</head>
<body>
<div class="bodytext">
<div id="tabs">
<ul>
		<li><a href="#tabs-1">Baptism</a></li>
		<li><a href="#tabs-2">Pre Confirmation</a></li>
		<li><a href="#tabs-3">Confirmation</a></li>
        <li><a href="#tabs-4">Marriage</a></li>
        <li><a href="#tabs-5">Deceased</a></li>
     
        </ul>
        </head>

<body>

	<div id="tabs-1" class="datataable">
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="mainbodyview">
      <table align="center">
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member:</td>
      <td>
    <input name="memberid" value="<?php echo $row_editbaptism['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['baptismid'])) && ($_GET['baptismid'] != "")){ echo $row_editbaptism['lastname'] ;?>&nbsp;<?php echo $row_editbaptism['middlename'] ;?> &nbsp;<?php echo $row_editbaptism['firstname'] ; } else {?><span id="spryselect2">
      <select name="memberid">
        <option value="-1">Select Member</option>
        <?php 
do {  
?>
        <option value="<?php echo $row_addmember['memberid']?>" ><?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));
?>
      </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></td><?php }?>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date:</td>
      <td><input type="text" name="date_baptised"  id="date_baptised"value="<?php echo htmlentities($row_editbaptism['date_baptised'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
     <tr valign="baseline">
      <td nowrap="nowrap" align="right"> Male god Parent:</td>
      <td><input type="text" name="male_god_parent" value="<?php echo htmlentities($row_editbaptism['male_god_parent'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
     <tr valign="baseline">
      <td nowrap="nowrap" align="right"> Female god Parent:</td>
      <td><input type="text" name="female_god_parent" value="<?php echo htmlentities($row_editbaptism['female_god_parent'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
 
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Officiating Clergy:</td>
      <td><input type="text" name="officiating_clergy" value="<?php echo htmlentities($row_editbaptism['officiating_clergy'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
     <tr valign="baseline">
      <td nowrap="nowrap" align="right">Baptism Venue:</td>
      <td><span id="sprytextfield1">
        <input type="text" name="baptism_venue" value="<?php echo htmlentities($row_editbaptism['baptism_venue'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Baptism cert No:</td>
      <td><input type="text" name="baptismcert_no" value="<?php echo htmlentities($row_editbaptism['baptismcert_no'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
     <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['baptismid'])) &&($_GET['baptismid']!="")) {?><input type="submit" value="Update" name="updatebaptism"><?php } else  {?><input type="submit" value="Save" name="savebaptism"><?php }?>
      </td>
    </tr>
</table>
  <input type="hidden" name="MM_insert" value="form1" />
  <div class="datataable">
  <table border="1" align="center">
  
      <tr class="tableheader">
      <td width="2%">No</td>
      <td width="15%">Member Names</td>
     
      <td width="15%">Officiating  Clergy</td>
      <td>Male god parent</td>
      <td>Female god parent</td>
      <td width="8%">Certificate Number </td>
      <td width="8%">&nbsp;</td>
      <td width="8%">&nbsp;</td>
    </tr>
    <?php    ?>
    
    <?php do { $numb++; 
	
	
mysql_select_db($database_church, $church);
$query_viewleaderbaptism = "SELECT * FROM leader l INNER JOIN member_details ms ON l.memberid=ms.memberid WHERE l.memberid='".$row_viewbaptism['memberid']."'";
$viewleaderbaptism = mysql_query($query_viewleaderbaptism, $church) or die(mysql_error());
$row_viewleaderbaptism = mysql_fetch_assoc($viewleaderbaptism);
$totalRows_viewleaderbaptism = mysql_num_rows($viewleaderbaptism);
	
?>
      <tr>
        <td><?php  echo $numb;?></td>
        <td><?php echo $row_viewbaptism['firstname']; ?>&nbsp;<?php echo $row_viewbaptism['middlename']; ?>&nbsp;<?php echo $row_viewbaptism['lastname']; ?> </td>
        
        <td><?php echo $row_viewbaptism['officiating_clergy']; ?>&nbsp; </td>
        <td><?php echo $row_viewbaptism['male_god_parent']; ?>&nbsp; </td>
          <td><?php echo $row_viewbaptism['female_god_parent']; ?>&nbsp; </td>
        
        <td><?php echo $row_viewbaptism['baptismcert_no']; ?></td>
        
             <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='clerk'))){ 
  ?>
        
                <td><a href="index.php?sacraments=show&baptismid=<?php echo $row_viewbaptism['baptismid']; ?>& #tabs-1"> Edit </a></td>   
               
 <td><a href="index.php?sacraments=<?php echo $row_viewbaptism['baptismid'];?> & archive=1 & #tabs-1 " onclick="return ConfirmArchive()">Archive  </a></td>
     
       <?php }?> </tr>
      <?php } while ($row_viewbaptism = mysql_fetch_assoc($viewbaptism)); ?>
  </table></div>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewbaptism > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewbaptism=%d%s", $currentPage, 0, $queryString_viewbaptism); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewbaptism > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewbaptism=%d%s", $currentPage, max(0, $pageNum_viewbaptism - 1), $queryString_viewbaptism); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewbaptism < $totalPages_viewbaptism) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewbaptism=%d%s", $currentPage, min($totalPages_viewbaptism, $pageNum_viewbaptism + 1), $queryString_viewbaptism); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewbaptism < $totalPages_viewbaptism) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewbaptism=%d%s", $currentPage, $totalPages_viewbaptism, $queryString_viewbaptism); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewbaptism + 1) ?> to <?php echo min($startRow_viewbaptism + $maxRows_viewbaptism, $totalRows_viewbaptism) ?> of <?php echo $totalRows_viewbaptism ?>
</form>
  </div>
    
    <div id="tabs-2">
    
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="mainbodyview">
  <table align="center" class="datataable">
  
  
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member:</td>
      <td>
  <?php  mysql_select_db($database_church, $church);
$query_addmemberfirst = "SELECT  * FROM  member_details ";
$addmemberfirst = mysql_query($query_addmemberfirst, $church) or die(mysql_error());
$row_addmemberfirst = mysql_fetch_assoc($addmemberfirst);
$totalRows_addmemberfirst= mysql_num_rows($addmemberfirst);?>
<input name="memberid" value="<?php echo $row_editfirstconfirmation['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['first_confirmationid'])) && ($_GET['first_confirmationid'] != "")){ echo $row_editfirstconfirmation['lastname'] ;?>&nbsp;<?php echo $row_editfirstconfirmation['middlename'] ;?> &nbsp;<?php echo $row_editfirstconfirmation['firstname'] ; } else {?>
      
     <select name="memberid"> 
      
       <option value="-1">Select Member</option>
        <?php 
do {  
?>
        <option value="<?php echo $row_addmemberfirst['memberid']?>" ><?php echo $row_addmemberfirst['firstname']?>&nbsp;<?php echo $row_addmemberfirst['middlename']?>&nbsp;<?php echo $row_addmemberfirst['lastname']?></option>
        <?php
} while ($row_addmemberfirst = mysql_fetch_assoc($addmemberfirst));
?>
      </select><?php }?></td>
    </tr>
  
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date:</td>
      <td><input type="text" name="firstconfirmation_date" id="firstconfirmation_date" value="<?php echo htmlentities($row_editfirstconfirmation['firstconfirmation_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"> Male god Parent:</td>
      <td><input type="text" name="male_god_parent" value="<?php echo htmlentities($row_editfirstconfirmation['male_god_parent'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
     <tr valign="baseline">
      <td nowrap="nowrap" align="right"> Female god Parent:</td>
      <td><input type="text" name="female_god_parent" value="<?php echo htmlentities($row_editfirstconfirmation['female_god_parent'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Officiating Clergy:</td>
      <td><input type="text" name="officiating_clergy" value="<?php echo htmlentities($row_editfirstconfirmation['officiating_clergy'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
       <tr valign="baseline">
      <td nowrap="nowrap" align="right">Pre Confirmation Venue:</td>
      <td><input type="text" name="preconfirmation_venue" value="<?php echo htmlentities($row_editfirstconfirmation['preconfirmation_venue'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Confirmation Certificate No.</td>
      <td><input type="text" name="first_confirmationcert_no" value="<?php echo htmlentities($row_editfirstconfirmation['first_confirmationcert_no'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['first_confirmationid'])) &&($_GET['first_confirmationid']!="")) {?><input type="submit" value="Update" name="updateconfirmation"><?php } else  {?><input type="submit" value="Save" name="confirmation"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center" class="datataable">
    <tr>
      <td width="2%">No</td>
      <td width="15%">Member Names</td>
      
      <td width="15%">Offiiating  Clergy</td>
      <td>Male god parent</td>
      <td>Female god parent</td>
      <td width="8%">Certificate Number </td>
      <td width="8%">&nbsp;</td>
      <td width="8%">&nbsp;</td>
    </tr>
    <?php do { $rawnum++; 
	
	/**mysql_select_db($database_church, $church);
$query_leaderfirstconfirmation= "SELECT * FROM first_confirmation fc INNER JOIN leader l ON fc.leaderid=l.leaderid INNER JOIN member_details md ON md.memberid=l.memberid WHERE fc.leaderid=". $row_viewfirstconfirmation['leaderid']." ";
$leaderfirstconfirmation = mysql_query($query_leaderfirstconfirmation, $church) or die(mysql_error());
$row_leaderfirstconfirmation = mysql_fetch_assoc($leaderfirstconfirmation);
$totalRows_leaderfirstconfirmation = mysql_num_rows($leaderfirstconfirmation);
	**/
	?>
      <tr>
        <td><?php echo  $rawnum; ?></td>
            <td><?php echo $row_viewfirstconfirmation['firstname']; ?>&nbsp; <?php echo $row_viewfirstconfirmation['middlename']; ?>&nbsp;<?php echo $row_viewfirstconfirmation['lastname']; ?></td>
       
         <td><?php echo $row_viewfirstconfirmation['officiating_clergy']; ?>&nbsp; </td>
        <td><?php echo $row_viewfirstconfirmation['male_god_parent']; ?>&nbsp; </td>
          <td><?php echo $row_viewfirstconfirmation['female_god_parent']; ?>&nbsp; </td>
        
        <td><?php echo $row_viewfirstconfirmation['first_confirmationcert_no']; ?></td>
        
                <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='clerk'))){ 
  ?>
        
        
               <td><a href="index.php?sacraments=show&first_confirmationid=<?php echo $row_viewfirstconfirmation['first_confirmationid']; ?>& #tabs-2"> Edit </a></td>
 
 <td><a href="index.php?sacraments=<?php echo $row_viewfirstconfirmation['first_confirmationid'];?> & archive=1 & #tabs-2 " onclick="return ConfirmArchive()">Archive  </a></td>
     
   
   
   
   <?php }?>
      </tr>
      <?php } while ($row_viewfirstconfirmation = mysql_fetch_assoc($viewfirstconfirmation)); ?>
  </table>
  <br />
  <table border="0" >
    <tr>
      <td><?php if ($pageNum_viewfirstconfirmation > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewfirstconfirmation=%d%s", $currentPage, 0, $queryString_viewfirstconfirmation); ?>& #tabs-2">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewfirstconfirmation > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewfirstconfirmation=%d%s", $currentPage, max(0, $pageNum_viewfirstconfirmation - 1), $queryString_viewfirstconfirmation); ?>& #tabs-2">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewfirstconfirmation < $totalPages_viewfirstconfirmation) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewfirstconfirmation=%d%s", $currentPage, min($totalPages_viewfirstconfirmation, $pageNum_viewfirstconfirmation + 1), $queryString_viewfirstconfirmation); ?>& #tabs-2">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewfirstconfirmation < $totalPages_viewfirstconfirmation) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewfirstconfirmation=%d%s", $currentPage, $totalPages_viewfirstconfirmation, $queryString_viewfirstconfirmation); ?>& #tabs-2">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewfirstconfirmation + 1) ?> to <?php echo min($startRow_viewfirstconfirmation + $maxRows_viewfirstconfirmation, $totalRows_viewfirstconfirmation) ?> of <?php echo $totalRows_viewfirstconfirmation ?>
</form>
 </div>
    
 <div id="tabs-3">
    
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="mainbodyview">
      <table align="center" class="datataable">
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member:</td>
          <?php  mysql_select_db($database_church, $church);
$query_addmember = "SELECT  *  FROM  member_details ";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember= mysql_num_rows($addmember);
?>
     <td>
<input name="memberid" value="<?php echo $row_editsecondconfirmation['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['second_confirmationid'])) && ($_GET['second_confirmationid'] != "")){ echo $row_editsecondconfirmation['lastname'] ;?>&nbsp;<?php echo $row_editsecondconfirmation['middlename'] ;?> &nbsp;<?php echo $row_editsecondconfirmation['firstname'] ; } else {?>
      <select name="memberid">
        <option value="-1">Select Member</option>
        <?php 
do {  
?>
        <option value="<?php echo $row_addmember['memberid']?>" ><?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));
?>
      </select><?php }?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date:</td>
      <td><input type="text" name="secondconfirmation_date" id="secondconfirmation_date" value="<?php echo htmlentities($row_editsecondconfirmation['secondconfirmation_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right"> Male god Parent:</td>
      <td><input type="text" name="male_god_parent" value="<?php echo htmlentities($row_editsecondconfirmation['male_god_parent'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
     <tr valign="baseline">
      <td nowrap="nowrap" align="right"> Female god Parent:</td>
      <td><input type="text" name="female_god_parent" value="<?php echo htmlentities($row_editsecondconfirmation['female_god_parent'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
  
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Officiating Bishop:</td>
     <td><input type="text" name="leader" value="<?php echo htmlentities($row_editsecondconfirmation['leader'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Confirmation Venue:</td>
      <td><input type="text" name="confirmation_venue" value="<?php echo htmlentities($row_editsecondconfirmation['confirmation_venue'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Confirmation Certificate No:</td>
      <td><input type="text" name="second_confirmationcert_no" value="<?php echo htmlentities($row_editsecondconfirmation['second_confirmationcert_no'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['second_confirmationid'])) &&($_GET['second_confirmationid']!="")) {?><input type="submit" value="Update" name="updatesecondconfirmation"><?php } else  {?><input type="submit" value="Save" name="secondconfirmation"><?php }?>
      </td>
    </tr>
</table>
  <input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center">
    <tr>
      <td width="2%">No</td>
      <td width="15%">Member Names</td>
     
      <td width="15%">Officiating Bishop</td>
      <td>Male god parent</td>
      <td>Female god parent</td>
      <td width="8%">Certificate Number </td>
      <td width="8%">&nbsp;</td>
      <td width="8%">&nbsp;</td>
    </tr>
    <?php do { $numcon++;
?>

<tr>
        <td><?php  echo $numcon; ?></td>
        <td><?php echo $row_viewsecondconfirmation['firstname']; ?>&nbsp;<?php echo $row_viewsecondconfirmation['middlename']; ?>&nbsp;<?php echo $row_viewsecondconfirmation['lastname']; ?> </td>
        
        <td><?php echo $row_viewsecondconfirmation['leader']; ?>&nbsp; </td>
        <td><?php echo $row_viewsecondconfirmation['male_god_parent']; ?>&nbsp; </td>
          <td><?php echo $row_viewsecondconfirmation['female_god_parent']; ?>&nbsp; </td>
        
        <td><?php echo $row_viewsecondconfirmation['second_confirmationcert_no']; ?></td>
             <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='clerk'))){ 
  ?>
    
        <td><a href="index.php?sacraments=show&second_confirmationid=<?php echo $row_viewsecondconfirmation['second_confirmationid']; ?>& #tabs-3"> Edit </a></td>
                  
<td><a href="index.php?sacraments=<?php echo $row_viewsecondconfirmation['second_confirmationid'];?> & archive=1 & #tabs-3 " onclick="return ConfirmArchive()">Archive  </a></td>
   
      </tr>
	  <?php }?>
      <?php } while ($row_viewsecondconfirmation = mysql_fetch_assoc($viewsecondconfirmation)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewsecondconfirmation > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewsecondconfirmation=%d%s", $currentPage, 0, $queryString_viewsecondconfirmation); ?>& #tabs-3">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewsecondconfirmation > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewsecondconfirmation=%d%s", $currentPage, max(0, $pageNum_viewsecondconfirmation - 1), $queryString_viewsecondconfirmation); ?>& #tabs-3">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewsecondconfirmation < $totalPages_viewsecondconfirmation) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewsecondconfirmation=%d%s", $currentPage, min($totalPages_viewsecondconfirmation, $pageNum_viewsecondconfirmation + 1), $queryString_viewsecondconfirmation); ?>& #tabs-3">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewsecondconfirmation < $totalPages_viewsecondconfirmation) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewsecondconfirmation=%d%s", $currentPage, $totalPages_viewsecondconfirmation, $queryString_viewsecondconfirmation); ?>& #tabs-3">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewsecondconfirmation + 1) ?> to <?php echo min($startRow_viewsecondconfirmation + $maxRows_viewsecondconfirmation, $totalRows_viewsecondconfirmation) ?> of <?php echo $totalRows_viewsecondconfirmation ?>
</form>
 </div>
  <div id="tabs-4">
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="mainbodyview">
      <?php  mysql_select_db($database_church, $church);
$query_addmemberhusband = "SELECT *  FROM  member_details m
 INNER JOIN gender g ON g.genderid=m.genderid INNER JOIN marital_status  s ON m.statusid=s.statusid WHERE g.genderid='1'" ;
$addmemberhusband = mysql_query($query_addmemberhusband, $church) or die(mysql_error());
$row_addmemberhusband = mysql_fetch_assoc($addmemberhusband);
$totalRows_addmemberhusband= mysql_num_rows($addmemberhusband);
?>
 <table align="center" class="datataable">
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Husband Name:</td>
      <td>
      <input name="memberid" value="<?php echo $row_editmarriage['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['marriageid'])) && ($_GET['marriageid'] != "")){ echo $row_editmarriagehusband['firstname'] ;?>&nbsp;<?php echo $row_editmarriagehusband['middlename'] ;?> &nbsp;<?php echo $row_editmarriagehusband['lastname'] ; } else {?>
      
      
      <select name="husbandname">
        <option value="-1">Select Husband</option>
            <?php 
do {  
?>
            <option value="<?php echo $row_addmemberhusband['memberid']?>" ><?php echo $row_addmemberhusband['firstname']?>&nbsp;<?php echo $row_addmemberhusband['middlename']?> &nbsp;<?php echo $row_addmemberhusband['lastname']?></option>
            <?php
} while ($row_addmemberhusband = mysql_fetch_assoc($addmemberhusband));
?>
        </select><?php }?></td>
    </tr>
    
    
     <tr valign="baseline">
      <td nowrap="nowrap" align="right">Husband:</td>
      <td>
      
      
      <input type="text" name="husband"  value="<?php echo htmlentities($row_editmarriage['husband'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>  
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Wife Name:</td>
      <td>
      <?php  mysql_select_db($database_church, $church);
$query_addwife = "SELECT *  FROM  member_details m
 INNER JOIN gender g ON g.genderid=m.genderid INNER JOIN marital_status  s ON m.statusid=s.statusid WHERE g.genderid='2' " ;
$addwife = mysql_query($query_addwife, $church) or die(mysql_error());
$row_addwife = mysql_fetch_assoc($addwife);
$totalRows_addwife= mysql_num_rows($addwife);
?>

     <input name="memberid" value="<?php echo $row_editmarriage['marriageid']; ?>" type="hidden">
      <?php if ((isset($_GET['marriageid'])) && ($_GET['marriageid'] != "")){ echo $row_editmarriage['lastname'] ;?>&nbsp;<?php echo $row_editmarriage['middlename'] ;?> &nbsp;<?php echo $row_editmarriage['firstname'] ; } else {?>
 <select name="wifenameid">
            <option value="-1">Select Wife</option>
            <?php 
do {  
?>
            <option value="<?php echo $row_addwife['memberid']?>" ><?php echo $row_addwife['firstname']?>&nbsp;<?php echo $row_addwife['middlename']?> &nbsp;<?php echo $row_addwife['lastname']?></option>
            <?php
} while ($row_addwife = mysql_fetch_assoc($addwife));
?>
          </select><?php }?></td>
    </tr>
    
       <tr valign="baseline">
      <td nowrap="nowrap" align="right">Wife:</td>
      <td><input type="text" name="wife"  value="<?php echo htmlentities($row_editmarriage['wife'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr> 
     
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date:</td>
      <td><input type="text" name="marriage_date" id="marriage_date" value="<?php echo htmlentities($row_editmarriage['marriage_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    
    
     <tr valign="baseline">
      <td nowrap="nowrap" align="right">Marriage Type:</td>
      <td>  <select name="marriage_type" id="marriage_type">
        <option value="Traditional" <?php if (!(strcmp("Traditional", $row_editmember['marriage_type']))) {echo "selected=\"selected\"";} ?>>Traditional</option>
        
           <option value="Civil" <?php if (!(strcmp("Civil", $row_editmember['marriage_type']))) {echo "selected=\"selected\"";} ?>>Civil</option>
        
          <option value="Church" <?php if (!(strcmp("Church", $row_editmember['marriage_type']))) {echo "selected=\"selected\"";} ?>>Church</option>
          
</select>
     </td>
    </tr>
    
   
   
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Officiating Clergy:</td>
         <td><input type="text" name="leader_name" id="leader_name" value="<?php echo htmlentities($row_editmarriage['leader_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Solemnization Venue:</td>
      <td><input type="text" name="solemnization_venue" id="solemnization_venue" value="<?php echo htmlentities($row_editmarriage['solemnization_venue'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Marriage Cert No:</td>
      <td><input type="text" name="marriagecert_no" value="<?php echo htmlentities($row_editmarriage['marriagecert_no'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
      <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['marriageid'])) &&($_GET['marriageid']!="")) {?><input type="submit" value="Update" name="updatemarriage"><?php } else  {?><input type="submit" value="Save" name="savemarriage"><?php }?>
      </td>
    </tr>
</table>
 <table border="1" align="center">
    <tr>
           <td width="2%">No</td>
       <td width="6%">Husband Name</td>
     <td width="8%">Wife Name</td>
       <td width="8%">Husband </td>
       <td width="8%">Wife </td>
      <td width="8%">Marriage Type </td>
     
        <td width="8%">leader Name</td>
        <td width="8%">Certificate Number</td>
        <td width="2%">&nbsp;</td>
        <td width="2%">&nbsp;</td>
    </tr>
    
    	  <?php  do { $marriage1 ++; 

/*mysql_select_db($database_church, $church);
$query_leadersmarriage= "SELECT * FROM marriage m INNER JOIN leader l ON l.leaderid=m.leaderid  INNER JOIN member_details md ON md.memberid=l.memberid WHERE m.leaderid=".$row_viewmarriage['leaderid']."";
$leadersmarriage= mysql_query($query_leadersmarriage, $church) or die('maad');
$row_leadersmarriage= mysql_fetch_assoc($leadersmarriage);
$totalRows_leadersmarriage = mysql_num_rows($leadersmarriage); */

mysql_select_db($database_church, $church);
$query_marriagehusband= "SELECT * FROM marriage m  INNER JOIN member_details md ON md.memberid=m.husbandname WHERE m.husbandname=". $row_viewmarriage['husbandname']." ";
$marriagehusband= mysql_query($query_marriagehusband, $church) or die('error view 1');
$row_marriagehusband= mysql_fetch_assoc($marriagehusband);
$totalRows_marriagehusband = mysql_num_rows($marriagehusband);

mysql_select_db($database_church, $church);
$query_marriagewife= "SELECT * FROM marriage m  INNER JOIN member_details md ON md.memberid=m.wifenameid WHERE m.wifenameid=". $row_viewmarriage['wifenameid']." ";
$marriagewife= mysql_query($query_marriagewife, $church) or die('error view 2');
$row_marriagewife= mysql_fetch_assoc($marriagewife);
$totalRows_marriagewife = mysql_num_rows($marriagewife);

	
	
   ?>
    
    
      <tr>
        <td><?php echo $marriage1 ; ?></td>
        <td><?php echo $row_marriagehusband['firstname']; ?>&nbsp;<?php echo $row_marriagehusband['middlename']; ?>&nbsp;<?php echo $row_marriagehusband['lastname']; ?> </td>
        
     <td><?php echo $row_marriagewife['firstname']; ?>&nbsp;<?php echo $row_marriagewife['middlename']; ?>&nbsp;<?php echo $row_marriagewife['lastname']; ?> </td>
        <td><?php echo $row_viewmarriage['husband']; ?></td>
        <td><?php echo $row_viewmarriage['wife']; ?></td> 
        <td><?php echo $row_viewmarriage['marriage_type']; ?></td> 
       
        <td><?php echo $row_leadersmarriage['firstname']; ?>&nbsp;<?php echo $row_leadersmarriage['middlename']; ?>&nbsp;<?php echo $row_leadersmarriage['lastname']; ?></td>
        <td><?php echo $row_viewmarriage['marriagecert_no']; ?></td>
        
                       <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='clerk'))){ 
  ?>
           <td><a href="index.php?sacraments=show& marriageid=<?php echo $row_viewmarriage['marriageid']; ?>& #tabs-4"> Edit </a></td>          


<td><a href="index.php?sacraments=<?php echo $row_viewmarriage['marriageid'];?> & archive=1 & #tabs-4 " onclick="return ConfirmArchive()">Archive  </a></td>

      </tr>
      
      <?php }?>
      <?php } while ($row_viewmarriage = mysql_fetch_assoc($viewmarriage)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewmarriage > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewmarriage=%d%s", $currentPage, 0, $queryString_viewmarriage); ?>& #tabs-4">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewmarriage > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewmarriage=%d%s", $currentPage, max(0, $pageNum_viewmarriage - 1), $queryString_viewmarriage); ?>& #tabs-4">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewmarriage < $totalPages_viewmarriage) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewmarriage=%d%s", $currentPage, min($totalPages_viewmarriage, $pageNum_viewmarriage + 1), $queryString_viewmarriage); ?>& #tabs-4">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewmarriage < $totalPages_viewmarriage) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewmarriage=%d%s", $currentPage, $totalPages_viewmarriage, $queryString_viewmarriage); ?>& #tabs-4">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewmarriage + 1) ?> to <?php echo min($startRow_viewmarriage + $maxRows_viewmarriage, $totalRows_viewmarriage) ?> of <?php echo $totalRows_viewmarriage ?>
</form>
</div>
 <div id="tabs-5">
 
 <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="mainbodyview">
   <table align="center">
     <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member:</td>
      <td>
       <input name="memberid" value="<?php echo $row_editdeceased['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['departedid'])) && ($_GET['departedid'] != "")){ echo $row_editdeceased['lastname'] ;?>&nbsp;<?php echo $row_editdeceased['middlename'] ;?> &nbsp;<?php echo $row_editdeceased['firstname'] ; } else {?>
      
      <?php  mysql_select_db($database_church, $church);
$query_addmember = "SELECT  m.memberid,m.firstname,m.middlename,m.lastname  FROM  member_details m";
$query_limit_addmember = sprintf("%s LIMIT %d, %d", $query_addmember, $startRow_addmember, $maxRows_addmember);
$addmember = mysql_query($query_limit_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember); 
?>    
       <?php }?></td>
    </tr>
        <?php  

mysql_select_db($database_church, $church);
$query_leaderdeceased= "SELECT * FROM leader l INNER JOIN member_details ms ON l.memberid=ms.memberid";
$leaderdeceased = mysql_query($query_leaderdeceased, $church) or die(mysql_error());
$row_leaderdeceased = mysql_fetch_assoc($leaderdeceased);
$totalRows_leaderdeceased = mysql_num_rows($leaderdeceased);



    ?> 
    
    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Officiating Clergy:</td>
      <td><select name="leaderid">
      
      <option value="-1">Select Leader</option>
        <?php 
do {  
?>
        <option value="<?php echo $row_addleader['leaderid']?>" ><?php echo $row_addleader['firstname']?>&nbsp;<?php echo $row_addleader['middlename']?>&nbsp;<?php echo $row_addleader['lastname']?></option>
        <?php
} while ($row_addleader = mysql_fetch_assoc($addleader));
?>
      </select></td>
    </tr>  
    
    

    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date Of Birth:</td>
      <td><input type="text" name="dateofbirth" value="<?php echo htmlentities($row_editdeceased['dateofbirth'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Demise Date:</td>
      <td><input type="text" name="date" id="datedeceased" value="<?php echo htmlentities($row_editdeceased['date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
        
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Deathcert_no:</td>
      <td><input type="text" name="deathcert_no" value="<?php echo htmlentities($row_editdeceased['deathcert_no'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
     <td nowrap="nowrap" Valign="top"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cause</td>
      <td>
      <textarea name="cause" id="cause" cols="45" rows="5"><?php echo $row_editdeceased['cause'] ?></textarea>
      
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['departedid'])) &&($_GET['departedid']!="")) {?><input type="submit" value="Update"   name="update"><?php } else  {?><input type="submit" value="Save"    name="save"><?php }?>
      </td>
    </tr>
</table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />  
  <table border="1" align="center">
    <tr>
      <td>No</td>
      <td width="30%">Member Names </td>
       <td width="15%">Officiating Clergy</td>
       <td width="8%">Date Of Birth</td>
       <td width="7%">Demise Date</td> 
       <td width="10%">Death Cert No</td>
      <td width="20%">cause</td>
     
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
<?php
mysql_select_db($database_church, $church);
$query_viewdeceased = "SELECT * FROM members_departed ";
$query_limit_viewdeceased = sprintf("%s LIMIT %d, %d", $query_viewdeceased, $startRow_viewdeceased, $maxRows_viewdeceased);
$viewdeceased = mysql_query($query_limit_viewdeceased, $church) or die(mysql_error());
$row_viewdeceased = mysql_fetch_assoc($viewdeceased);



 do { $deceasednum ++ ; 
 
 
/* 
 mysql_select_db($database_church, $church);
$query_leaderservicedeath= "SELECT * FROM members_departed mdd INNER JOIN leader l ON l.leaderid=mdd.leaderid  INNER JOIN member_details md ON md.memberid=mdd.memberid WHERE mdd.leaderid=".$row_viewdeceased['leaderid']."";
$leaderservicedeath= mysql_query($query_leaderservicedeath, $church) or die('maad');
$row_leaderservicedeath= mysql_fetch_assoc($leaderservicedeath);
$totalRows_leaderservicedeath = mysql_num_rows($leaderservicedeath);
 
 
 **/
 
 
 
 ?>
      <tr>
        <td><?php  echo $deceasednum; ?></td>
        <td><?php echo $row_viewdeceased['middlename']; ?>&nbsp;<?php echo $row_viewdeceased['firstname']; ?>&nbsp;<?php echo $row_viewdeceased['lastname']; ?> </td>
          <td><?php echo $row_leaderservicedeath['firstname']; ?> &nbsp;<?php echo $row_leaderservicedeath['middlename']; ?>&nbsp;<?php echo $row_leaderservicedeath['lastname']; ?></td>
         <td><?php echo $row_viewdeceased['dateofbirth']; ?>&nbsp; </td>
              <td><?php echo $row_viewdeceased['date']; ?>&nbsp; </td>
        <td><?php echo $row_viewdeceased['deathcert_no']; ?>&nbsp; </td>
   
        <td><?php echo $row_viewdeceased['cause']; ?>&nbsp; </td>
              <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='clerk'))){ 
  ?> 
            <td><a href="index.php?sacraments=show&departedid=<?php echo $row_viewdeceased['departedid']; ?>& #tabs-5"> Edit </a></td> 
            
       <td><a href="index.php?sacraments=show & departedid=<?php echo $row_viewdeceased['departedid'];?> & Delete=1 &#tabs-5" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
       <?php }?>
      </tr>
      <?php } while ($row_viewdeceased = mysql_fetch_assoc($viewdeceased)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewdeceased > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewdeceased=%d%s", $currentPage, 0, $queryString_viewdeceased); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewdeceased > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewdeceased=%d%s", $currentPage, max(0, $pageNum_viewdeceased - 1), $queryString_viewdeceased); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewdeceased < $totalPages_viewdeceased) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewdeceased=%d%s", $currentPage, min($totalPages_viewdeceased, $pageNum_viewdeceased + 1), $queryString_viewdeceased); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewdeceased < $totalPages_viewdeceased) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewdeceased=%d%s", $currentPage, $totalPages_viewdeceased, $queryString_viewdeceased); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewdeceased + 1) ?> to <?php echo min($startRow_viewdeceased + $maxRows_viewdeceased, $totalRows_viewdeceased) ?> of <?php echo $totalRows_viewdeceased ?>
</p>
</form>
 
 
 
 
    
    
 </div>
    
    
    
    
    

</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
</script>
</body>
</html>