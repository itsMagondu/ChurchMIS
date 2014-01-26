<?php include ('Connections/church.php'); 


checkAdmin();
?>
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


if ((isset($_GET['Delete']) &&(isset($_GET['offering_id'])) && ($_GET['offering_id'] != ""))) {
	
	$tab="index.php?tithe=true#tabs-2";
	$whereto=$tab;	
	
  $deleteSQL = sprintf("DELETE FROM offering WHERE offering_id=".($_GET['offering_id'])."", 
                       GetSQLValueString($_GET['offering_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}




if ((isset($_POST["saveoffering"]))) {
	
	
	$tab="index.php?tithe=true#tabs-2";
	$whereto=$tab;	
	
  $insertSQL = sprintf("INSERT INTO offering (offering_id, church_service_id, service_date, tallied_by, amount_collected) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['offering_id'], "int"),
                       GetSQLValueString($_POST['church_service_id'], "int"),
                       GetSQLValueString($_POST['service_date'], "text"),
                       GetSQLValueString($_POST['tallied_by'], "int"),
                       GetSQLValueString($_POST['amount_collected'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
  header("Location:$whereto");
}

if ((isset($_POST["updateoffering"]))) {
	
		
	$tab="index.php?tithe=true#tabs-2";
	$whereto=$tab;	
	
	 if ((isset($_GET['offering_id'])) && ($_GET['offering_id']!="")){
	
  $updateSQL = sprintf("UPDATE offering SET church_service_id=%s, service_date=%s, tallied_by=%s, amount_collected=%s WHERE offering_id=".$_GET['offering_id']."",
                       GetSQLValueString($_POST['church_service_id'], "int"),
                       GetSQLValueString($_POST['service_date'], "text"),
                       GetSQLValueString($_POST['tallied_by'], "int"),
                       GetSQLValueString($_POST['amount_collected'], "text"),
                       GetSQLValueString($_POST['offering_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

  header("Location:$whereto");
}


if ((isset($_POST["saveequipment"]))) {
	
	
	$tab="index.php?tithe=true#tabs-5";
	$whereto=$tab;	
	
  $insertSQL = sprintf("INSERT INTO equipment (equipment_id, equipment_name, equipment_hirecost) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['equipment_id'], "int"),
                       GetSQLValueString($_POST['equipment_name'], "text"),
                       GetSQLValueString($_POST['equipment_hirecost'], "text"));
					   
					   
	  $insertSQL1 = sprintf("INSERT INTO equipment_hire ( equipment_id, equipment_hirecost) VALUES (%s, %s)",
                      
                  GetSQLValueString($_POST['equipment_id'], "int"),
                 GetSQLValueString($_POST['equipment_hirecost'], "text"));			   
  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  $Result2 = mysql_query($insertSQL1, $church) or die(mysql_error());
  
  header("Location:$whereto");
}



if ((isset($_POST["updateequipment"]))) {
	
	$tab="index.php?tithe=true#tabs-5";
	$whereto=$tab;	
	
	 if ((isset($_GET['offering_id'])) && ($_GET['offering_id']!="")){	
  $updateSQL = sprintf("UPDATE equipment SET equipment_name=%s, equipment_hirecost=%s WHERE equipment_id=".$_GET['equipment_id']."",
                       GetSQLValueString($_POST['equipment_name'], "text"),
                       GetSQLValueString($_POST['equipment_hirecost'], "text"),
                       GetSQLValueString($_POST['equipment_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
header("Location:$whereto");
}




mysql_select_db($database_church, $church);
$query_addleader = "SELECT * FROM leader";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);



mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

mysql_select_db($database_church, $church);
$query_addoffering = "SELECT * FROM offering";
$addoffering = mysql_query($query_addoffering, $church) or die(mysql_error());
$row_addoffering = mysql_fetch_assoc($addoffering);
$totalRows_addoffering = mysql_num_rows($addoffering);


if ((isset($_GET['offering_id'])) && ($_GET['offering_id']!="")){

mysql_select_db($database_church, $church);
$query_editoffering = "SELECT * FROM offering";
$editoffering = mysql_query($query_editoffering, $church) or die(mysql_error());
$row_editoffering = mysql_fetch_assoc($editoffering);
$totalRows_editoffering = mysql_num_rows($editoffering);

}

$maxRows_viewoffering = 50;
$pageNum_viewoffering = 0;
if (isset($_GET['pageNum_viewoffering'])) {
  $pageNum_viewoffering = $_GET['pageNum_viewoffering'];
}
$startRow_viewoffering = $pageNum_viewoffering * $maxRows_viewoffering;

mysql_select_db($database_church, $church);
$query_viewoffering = "SELECT * FROM offering o INNER JOIN member_details md ON o.tallied_by=md.memberid INNER JOIN church_service cs ON o.church_service_id=cs.church_service_id ";
$query_limit_viewoffering = sprintf("%s LIMIT %d, %d", $query_viewoffering, $startRow_viewoffering, $maxRows_viewoffering);
$viewoffering = mysql_query($query_limit_viewoffering, $church) or die(mysql_error());
$row_viewoffering = mysql_fetch_assoc($viewoffering);

if (isset($_GET['totalRows_viewoffering'])) {
  $totalRows_viewoffering = $_GET['totalRows_viewoffering'];
} else {
  $all_viewoffering = mysql_query($query_viewoffering);
  $totalRows_viewoffering = mysql_num_rows($all_viewoffering);
}
$totalPages_viewoffering = ceil($totalRows_viewoffering/$maxRows_viewoffering)-1;

$queryString_viewoffering = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewoffering") == false && 
        stristr($param, "totalRows_viewoffering") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewoffering = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewoffering = sprintf("&totalRows_viewoffering=%d%s", $totalRows_viewoffering, $queryString_viewoffering);




mysql_select_db($database_church, $church);
$query_addequipment = "SELECT * FROM equipment";
$addequipment = mysql_query($query_addequipment, $church) or die(mysql_error());
$row_addequipment = mysql_fetch_assoc($addequipment);
$totalRows_addequipment = mysql_num_rows($addequipment);



 if ((isset($_GET['equipment_id'])) && ($_GET['equipment_id']!="")){	
mysql_select_db($database_church, $church);
$query_editequipment = "SELECT * FROM equipment WHERE equipment_id=".$_GET['equipment_id']." ";
$editequipment = mysql_query($query_editequipment, $church) or die(mysql_error());
$row_editequipment = mysql_fetch_assoc($editequipment);
$totalRows_editequipment = mysql_num_rows($editequipment);
 }
$maxRows_viewequipment = 50;
$pageNum_viewequipment = 0;
if (isset($_GET['pageNum_viewequipment'])) {
  $pageNum_viewequipment = $_GET['pageNum_viewequipment'];
}
$startRow_viewequipment = $pageNum_viewequipment * $maxRows_viewequipment;

mysql_select_db($database_church, $church);
$query_viewequipment = "SELECT * FROM equipment";
$query_limit_viewequipment = sprintf("%s LIMIT %d, %d", $query_viewequipment, $startRow_viewequipment, $maxRows_viewequipment);
$viewequipment = mysql_query($query_limit_viewequipment, $church) or die(mysql_error());
$row_viewequipment = mysql_fetch_assoc($viewequipment);

if (isset($_GET['totalRows_viewequipment'])) {
  $totalRows_viewequipment = $_GET['totalRows_viewequipment'];
} else {
  $all_viewequipment = mysql_query($query_viewequipment);
  $totalRows_viewequipment = mysql_num_rows($all_viewequipment);
}
$totalPages_viewequipment = ceil($totalRows_viewequipment/$maxRows_viewequipment)-1;

$queryString_viewequipment = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewequipment") == false && 
        stristr($param, "totalRows_viewequipment") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewequipment = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewequipment = sprintf("&totalRows_viewequipment=%d%s", $totalRows_viewequipment, $queryString_viewequipment);



$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["savehire"]))) {
	
	$returndate=$_POST['return_date'];
	$hiredate=$_POST['hire_date'];
	$noofdays=$returndate-$hiredate;
	
	$tab="index.php?tithe=true#tabs-6";
	$whereto=$tab;	
  $insertSQL = sprintf("INSERT INTO equipment_hire (hire_id, equipment_id, hire_date, return_date, billed_by, number_hired) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['hire_id'], "int"),
                       GetSQLValueString($_POST['equipment_id'], "int"),
                       GetSQLValueString($_POST['hire_date'], "text"),
                       GetSQLValueString($_POST['return_date'], "text"),
                       GetSQLValueString($_POST['billed_by'], "int"),
                       GetSQLValueString($_POST['number_hired'], "int"));
					   
					   
  
					   

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}

if ((isset($_POST["updatehire"]))) {
	
	$tab="index.php?tithe=true#tabs-6";
	$whereto=$tab;
	     if ((isset($_GET['memberid'])) && ($_GET['memberid']!="")){
  $updateSQL = sprintf("UPDATE equipment_hire SET equipment_id=%s, hire_date=%s, return_date=%s, billed_by=%s, number_hired=%s WHERE hire_id=".$_GET['hire_id']."",
                       GetSQLValueString($_POST['equipment_id'], "int"),
                       GetSQLValueString($_POST['hire_date'], "text"),
                       GetSQLValueString($_POST['return_date'], "text"),
                       GetSQLValueString($_POST['billed_by'], "int"),
                       GetSQLValueString($_POST['number_hired'], "int"),
                       GetSQLValueString($_POST['hire_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
 header("Location:$whereto");
}

mysql_select_db($database_church, $church);
$query_addequipment = "SELECT * FROM equipment";
$addequipment = mysql_query($query_addequipment, $church) or die(mysql_error());
$row_addequipment = mysql_fetch_assoc($addequipment);
$totalRows_addequipment = mysql_num_rows($addequipment);

mysql_select_db($database_church, $church);
$query_addequipmenthire = "SELECT * FROM equipment_hire";
$addequipmenthire = mysql_query($query_addequipmenthire, $church) or die(mysql_error());
$row_addequipmenthire = mysql_fetch_assoc($addequipmenthire);
$totalRows_addequipmenthire = mysql_num_rows($addequipmenthire);
if((isset($_GET['hire_id'])) && ($_GET['hire_id'])){
mysql_select_db($database_church, $church);
$query_editequipmenthire = "SELECT * FROM equipment_hire WHERE hire_id=".$_GET['hire_id']."";
$editequipmenthire = mysql_query($query_editequipmenthire, $church) or die(mysql_error());
$row_editequipmenthire = mysql_fetch_assoc($editequipmenthire);
$totalRows_editequipmenthire = mysql_num_rows($editequipmenthire);
}
$maxRows_viewequipmenthire = 50;
$pageNum_viewequipmenthire = 0;
if (isset($_GET['pageNum_viewequipmenthire'])) {
  $pageNum_viewequipmenthire = $_GET['pageNum_viewequipmenthire'];
}
$startRow_viewequipmenthire = $pageNum_viewequipmenthire * $maxRows_viewequipmenthire;

mysql_select_db($database_church, $church);
$query_viewequipmenthire = "SELECT * FROM equipment_hire eh INNER JOIN equipment et ON  eh.equipment_id=et.equipment_id";
$query_limit_viewequipmenthire = sprintf("%s LIMIT %d, %d", $query_viewequipmenthire, $startRow_viewequipmenthire, $maxRows_viewequipmenthire);
$viewequipmenthire = mysql_query($query_limit_viewequipmenthire, $church) or die(mysql_error());
$row_viewequipmenthire = mysql_fetch_assoc($viewequipmenthire);

if (isset($_GET['totalRows_viewequipmenthire'])) {
  $totalRows_viewequipmenthire = $_GET['totalRows_viewequipmenthire'];
} else {
  $all_viewequipmenthire = mysql_query($query_viewequipmenthire);
  $totalRows_viewequipmenthire = mysql_num_rows($all_viewequipmenthire);
}
$totalPages_viewequipmenthire = ceil($totalRows_viewequipmenthire/$maxRows_viewequipmenthire)-1;

$queryString_viewequipmenthire = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewequipmenthire") == false && 
        stristr($param, "totalRows_viewequipmenthire") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewequipmenthire = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewequipmenthire = sprintf("&totalRows_viewequipmenthire=%d%s", $totalRows_viewequipmenthire, $queryString_viewequipmenthire);

if ((isset($_POST['equipment_id'])) && ($_POST['equipment_id'] != "")){ 
mysql_select_db($database_church, $church);
$query_viewviewequipment ="SELECT * FROM equipment e INNER JOIN equipment_hire  eh ON eh.equipment_id=e.equipment_id  WHERE eh.equipment_id=".$_POST['equipment_id']."  ";
$viewviewequipment = mysql_query($query_viewviewequipment, $church) or die('cannot view equipment');
$row_viewviewequipment = mysql_fetch_assoc($viewviewequipment);

} 

if ((isset($_POST["savetithe"]))) {
	$tab="index.php?tithe=true#tabs-1";
	$whereto=$tab;	
  $insertSQL = sprintf("INSERT INTO tithe (titheid, memberid, leaderid, `date`, amount) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['titheid'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['leaderid'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['amount'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
    header("Location:$whereto");
}

if ((isset($_POST["updatetithe"]))) {
	
	   if ((isset($_GET['titheid'])) && ($_GET['titheid']!="")){
  $updateSQL = sprintf("UPDATE tithe SET memberid=%s, leaderid=%s, `date`=%s, amount=%s WHERE titheid=".$_GET['titheid']."",
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['leaderid'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['amount'], "text"),
                       GetSQLValueString($_POST['titheid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
     header("Location:$whereto");
}

mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

mysql_select_db($database_church, $church);
$query_addleader = "SELECT * FROM leader";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);

mysql_select_db($database_church, $church);
$query_addtithe = "SELECT * FROM tithe";
$addtithe = mysql_query($query_addtithe, $church) or die(mysql_error());
$row_addtithe = mysql_fetch_assoc($addtithe);
$totalRows_addtithe = mysql_num_rows($addtithe);

mysql_select_db($database_church, $church);
$query_edittithe = "SELECT * FROM tithe";
$edittithe = mysql_query($query_edittithe, $church) or die(mysql_error());
$row_edittithe = mysql_fetch_assoc($edittithe);
$totalRows_edittithe = mysql_num_rows($edittithe);

$maxRows_viewtithe = 50;
$pageNum_viewtithe = 0;
if (isset($_GET['pageNum_viewtithe'])) {
  $pageNum_viewtithe = $_GET['pageNum_viewtithe'];
}
$startRow_viewtithe = $pageNum_viewtithe * $maxRows_viewtithe;

mysql_select_db($database_church, $church);
$query_viewtithe = "SELECT * FROM tithe";
$query_limit_viewtithe = sprintf("%s LIMIT %d, %d", $query_viewtithe, $startRow_viewtithe, $maxRows_viewtithe);
$viewtithe = mysql_query($query_limit_viewtithe, $church) or die(mysql_error());
$row_viewtithe = mysql_fetch_assoc($viewtithe);

if (isset($_GET['totalRows_viewtithe'])) {
  $totalRows_viewtithe = $_GET['totalRows_viewtithe'];
} else {
  $all_viewtithe = mysql_query($query_viewtithe);
  $totalRows_viewtithe = mysql_num_rows($all_viewtithe);
}
$totalPages_viewtithe = ceil($totalRows_viewtithe/$maxRows_viewtithe)-1;

$queryString_viewtithe = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewtithe") == false && 
        stristr($param, "totalRows_viewtithe") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewtithe = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewtithe = sprintf("&totalRows_viewtithe=%d%s", $totalRows_viewtithe, $queryString_viewtithe);



?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

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
<script type="text/javascript">
	$(function() {
		$('#hire_date').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
			
		});
		$('#return_date').datepicker({
		  
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#amount').datepicker({
            //minDate: '+120m',	  
	         //   minDate: new Date(), 

			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#profession_end').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob3').datepicker({
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
		$('#datecollected').datepicker({
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
		$('#emp_to').datepicker({
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

<div class="mainbodyview">
<body>

<div id="tabs">
<ul>
		<li><a href="#tabs-1">TITHE </a></li>
		<li><a href="#tabs-2">OFFERING</a></li>
		<li><a href="#tabs-3">CONTRIBUTION</a></li>
        <li><a href="#tabs-4">THANKS GIVING </a></li>
        <li><a href="#tabs-5">EQUIPMENT </a></li>
        <li><a href="#tabs-6">EQUIPMENT HIRE</a></li>

</ul>
<div id="tabs-1">
<?php 

if ((isset($_POST['memberid'])) && ($_POST['memberid'] != "")){ 

mysql_select_db($database_church, $church);
$query_viewmemberdetails ="SELECT * FROM  member_details   WHERE memberid=".$_POST['memberid']."";
$viewmemberdetails = mysql_query($query_viewmemberdetails, $church) or die('cannot view member');
$row_viewmemberdetails = mysql_fetch_assoc($viewmemberdetails);

	}?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member:</td>
      <td>
      <?php if ((isset($_GET['titheid'])) && ($_GET['titheid'] != "")){ echo $row_edittithe['titheid'] ;?><?php }?>
     <select name="memberid" selected="selected" onchange="submit()" >
           <option value="-1"  <?php if (!(strcmp(-1,$row_edittithe['titheid']))) {echo "selected=\"selected\"";} ?>>Select Tithe Number</option>  
      
        <?php 
do {  
?>
       <option value="<?php echo $row_addmember['memberid']?>"<?php if (!(strcmp($row_addmember['memberid'], $row_viewmemberdetails['memberid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_addmember['memberid']?></option>
  <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));

echo "<option value=\"{$row_addstudent['-1']}\"";
echo (!empty($_POST['-1'])&&$_POST['-1']== $row_addmember['-1']  ? ' selected="selected"' :'');
echo ">{$row_addstudent['-1']}</option>\n";								   
								   
  $rows = mysql_num_rows($addmember);
  if($rows > 0) {
      mysql_data_seek($addmember, 0);
	  $row_addmember = mysql_fetch_assoc($addmember);
  }



?>
      </select></td>
    </tr>
    
        <tr valign="baseline">
        <td nowrap="nowrap" align="right">Member Names </td>
        <td><input name="levelId" value="<?php echo $row_viewStndDetails['levelId']; ?>" type="hidden" />
         <?php if ((isset($_GET['memberid'])) && ($_GET['memberid'] != "")){ echo $row_edittithe['memberid'] ; } else { ?>
   
       <?php echo $row_viewmemberdetails['firstname']; ?>&nbsp;<?php echo $row_viewmemberdetails['middlename']; ?>&nbsp;<?php echo $row_viewmemberdetails['lastname']; ?> </td>  
          
          
          <?php } ?></td>
      </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Amount:</td>
      <td><input type="text" name="amount" id="amount" value="<?php echo htmlentities($row_edittithe['amount'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
         <?php mysql_select_db($database_church, $church);
$query_addleader ="SELECT * FROM leader l LEFT JOIN member_details md ON md.memberid=l.memberid ";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Leader:</td>
      <td><select name="leaderid" selected="selected">
       <option value="-1"  <?php if (!(strcmp(-1,$row_edittithe['titheid']))) {echo "selected=\"selected\"";} ?>>Select Leader</option>
       <?php
do {  
?>
       <option value="<?php echo $row_addleader['memberid']?>"<?php if (!(strcmp($row_addleader['memberid'], $row_edittithe['titheid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_addleader['firstname']?> <?php echo $row_addleader['middlename']?> <?php echo $row_addleader['lastname']?></option>
       <?php
} while ($row_addleader = mysql_fetch_assoc($addleader));
  $rows = mysql_num_rows($addleader);
  if($rows > 0) {
      mysql_data_seek($addleader, 0);
	  $row_addleader = mysql_fetch_assoc($addleader);
  }
?>
     </select></td>
    </tr>
    
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date:</td>
      <td><input type="text" name="date" id="datecollected" value="<?php echo htmlentities($row_edittithe['date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
     <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['titheid'])) &&($_GET['titheid']!="")) {?><input type="submit" value="Update" name="updatetithe"><?php } else  {?><input type="submit" value="Save" name="savetithe"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center">
    <tr>
      <td width="2%">No</td>
      <td width="6%">memberid</td>
     <td width="10%">Member Names </td>
      <td width="10%">Leader Names </td>
      <td width="4%">date</td>
      <td width="10%">amount</td>
       <td width="2%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
    </tr>
    <?php do { $rownum++; ?>
      <tr>
        <td><?php echo  $rownum; ?></td>
        <td><?php echo $row_viewtithe['memberid']; ?>&nbsp; </td>
     <td><?php echo $row_viewtithe['firstname']; ?>&nbsp<?php echo $row_viewtithe['middelname'];?>&nbsp<?php echo $row_viewtithe['lastname']; ?> </td>
        <td><?php echo $row_viewtithe['leaderid']; ?>&nbsp; </td>
        <td><?php echo $row_viewtithe['date']; ?>&nbsp; </td>
       <td><?php echo "Ksh. ".number_format($row_viewtithe['amount'], 2, '.', ','); ?> </td>
        
         <td><a href="index.php?tithe=show&titheid=<?php echo $row_viewtithe['titheid']; ?>& #tabs-1">Edit </a></td>
                  
   <td><a href="index.php?tithe=show &titheid=<?php echo $row_viewtithe['church_service_id'];?> & Delete=1 &#tabs-1" onClick="return confirm('Are you sure you want to delete?')">Delete </a></td>
        
      </tr>
      <?php } while ($row_viewtithe = mysql_fetch_assoc($viewtithe)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewtithe > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewtithe=%d%s", $currentPage, 0, $queryString_viewtithe); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewtithe > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewtithe=%d%s", $currentPage, max(0, $pageNum_viewtithe - 1), $queryString_viewtithe); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewtithe < $totalPages_viewtithe) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewtithe=%d%s", $currentPage, min($totalPages_viewtithe, $pageNum_viewtithe + 1), $queryString_viewtithe); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewtithe < $totalPages_viewtithe) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewtithe=%d%s", $currentPage, $totalPages_viewtithe, $queryString_viewtithe); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewtithe + 1) ?> to <?php echo min($startRow_viewtithe + $maxRows_viewtithe, $totalRows_viewtithe) ?> of <?php echo $totalRows_viewtithe ?>
</form>

</div>

<div id="tabs-2">

<?php mysql_select_db($database_church, $church);
$query_addservice = "SELECT * FROM church_service";
$addservice = mysql_query($query_addservice, $church) or die(mysql_error());
$row_addservice = mysql_fetch_assoc($addservice);
$totalRows_addservice = mysql_num_rows($addservice);?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Church Service :</td>
      <td><select name="church_service_id">
      <option value="-1" <?php if (!(strcmp(-1, $row_editsermon['church_service_id']))) {echo "selected=\"selected\"";} ?> >Select Service</option>  
 <?php
do {  
?>
 <option value="<?php echo $row_addservice['church_service_id']?>" ><?php echo $row_addservice['service_name']?></option>
        <?php
} while ($row_addservice = mysql_fetch_assoc($addservice));
  $rows = mysql_num_rows($addservice);
  if($rows > 0) {
      mysql_data_seek($addservice, 0);
	  $row_addservice = mysql_fetch_assoc($addservice);
  }
?>         
</select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date:</td>
      <td><input type="text" name="service_date" id="service_date" value="<?php echo htmlentities($row_editoffering['service_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
       <?php mysql_select_db($database_church, $church);
$query_addleader ="SELECT * FROM leader l LEFT JOIN member_details md ON md.memberid=l.memberid ";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);?>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tallied  By:</td>
      <td><select name="tallied_by" selected="selected">
       <option value="-1"  <?php if (!(strcmp(-1,$row_editoffering['offering_id']))) {echo "selected=\"selected\"";} ?>>Select Leader</option>
       <?php
do {  
?>
       <option value="<?php echo $row_addleader['memberid']?>"<?php if (!(strcmp($row_addleader['memberid'], $row_editequipmenthire['offering_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_addleader['firstname']?> <?php echo $row_addleader['middlename']?> <?php echo $row_addleader['lastname']?></option>
       <?php
} while ($row_addleader = mysql_fetch_assoc($addleader));
  $rows = mysql_num_rows($addleader);
  if($rows > 0) {
      mysql_data_seek($addleader, 0);
	  $row_addleader = mysql_fetch_assoc($addleader);
  }
?>
     </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Amount_collected:</td>
      <td><input type="text" name="amount_collected" value="<?php echo htmlentities($row_editoffering['amount_collected'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
      <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['offering_id'])) &&($_GET['offering_id']!="")) {?><input type="submit" value="Update" name="updateoffering"><?php } else  {?><input type="submit" value="Save" name="saveoffering"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>
    <td width="2%">No</td>
   <td width="12%">Service Name</td>
  <td width="8%">Service Date</td>
    <td width="15%">Tallied By</td>
    <td width="15%">Amount Collected</td>
   <td width="2%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
  </tr>
  <?php do { $offering ++;?>
    <tr>
      <td> <?php echo $offering;  ?></td>
      <td><?php echo $row_viewoffering['service_name']; ?>&nbsp; </td>
      <td><?php echo $row_viewoffering['service_date']; ?>&nbsp; </td>
      <td><?php echo $row_viewoffering['firstname']; ?>&nbsp;<?php echo $row_viewoffering['middlename']; ?>&nbsp;<?php echo $row_viewoffering['lastname']; ?> </td>
      <td><?php echo "Ksh. ".number_format($row_viewoffering['amount_collected'], 2, '.', ','); ?> </td>
      <td><a href="index.php?sermons=show&church_service_id=<?php echo $row_viewoffering['church_service_id']; ?>& #tabs-3"> Edit </a></td>
                  
   <td><a href="index.php?sermons=show &church_service_id=<?php echo $row_viewoffering['church_service_id'];?> & Delete=1 &#tabs-3" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
      
    </tr>
    <?php } while ($row_viewoffering = mysql_fetch_assoc($viewoffering)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewoffering > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewoffering=%d%s", $currentPage, 0, $queryString_viewoffering); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewoffering > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewoffering=%d%s", $currentPage, max(0, $pageNum_viewoffering - 1), $queryString_viewoffering); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewoffering < $totalPages_viewoffering) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewoffering=%d%s", $currentPage, min($totalPages_viewoffering, $pageNum_viewoffering + 1), $queryString_viewoffering); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewoffering < $totalPages_viewoffering) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewoffering=%d%s", $currentPage, $totalPages_viewoffering, $queryString_viewoffering); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewoffering + 1) ?> to <?php echo min($startRow_viewoffering + $maxRows_viewoffering, $totalRows_viewoffering) ?> of <?php echo $totalRows_viewoffering ?>
</div>

<div id="tabs-3">
</div>
<div id="tabs-4">
</div>
<div id="tabs-5">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Equipment_name:</td>
      <td><input type="text" name="equipment_name" value="<?php echo htmlentities($row_editequipment['equipment_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Equipment_hirecost:</td>
      <td><input type="text" name="equipment_hirecost" value="<?php echo htmlentities($row_editequipment['equipment_hirecost'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['equipment_id'])) &&($_GET['equipment_id']!="")) {?><input type="submit" value="Update" name="updateequipment"><?php } else  {?><input type="submit" value="Save" name="saveequipment"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>
   <td width="2%">No</td>
    <td width="10%">Equipment Name</td>
    <td width="10%">Equipment Hirecost</td>
      <td width="4%">&nbsp;</td>
       <td width="4%">&nbsp;</td>
  </tr>
  <?php do { $equipment++; ?>
    <tr>
      <td><?php echo $equipment ; ?></td>
      <td><?php echo $row_viewequipment['equipment_name']; ?>&nbsp; </td>
      <td><?php echo "Ksh. ".number_format($row_viewequipment['equipment_hirecost'], 2, '.', ','); ?> </td>
    
    
     <td><a href="index.php?tithe=show&equipment_id=<?php echo $row_viewequipment['equipment_id']; ?>& #tabs-5"> Edit </a></td>
                  
   <td><a href="index.php?tithe=show &equipment_id=<?php echo $row_viewequipment['equipment_id'];?> & Delete=1 &#tabs-5" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
    </tr>
    <?php } while ($row_viewequipment = mysql_fetch_assoc($viewequipment)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewequipment > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewequipment=%d%s", $currentPage, 0, $queryString_viewequipment); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewequipment > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewequipment=%d%s", $currentPage, max(0, $pageNum_viewequipment - 1), $queryString_viewequipment); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewequipment < $totalPages_viewequipment) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewequipment=%d%s", $currentPage, min($totalPages_viewequipment, $pageNum_viewequipment + 1), $queryString_viewequipment); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewequipment < $totalPages_viewequipment) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewequipment=%d%s", $currentPage, $totalPages_viewequipment, $queryString_viewequipment); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewequipment + 1) ?> to <?php echo min($startRow_viewequipment + $maxRows_viewequipment, $totalRows_viewequipment) ?> of <?php echo $totalRows_viewequipment ?>





</div>
<div id="tabs-6">

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
  
  <?php 

if ((isset($_POST['equipment_id'])) && ($_POST['equipment_id'] != "")){
	 
$tab="index.php?tithe=true#tabs-6";
	$whereto=$tab;	
	
mysql_select_db($database_church, $church);
$query_viewcostequipment ="SELECT * FROM equipment  WHERE equipment_id=".$_POST['equipment_id']."";
$viewcostequipment = mysql_query($query_viewcostequipment, $church) or die('cannot view equipment');
$row_viewcostequipment = mysql_fetch_assoc($viewcostequipment);

  

	}?>
  
  
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Equipment Name:</td>
      <td>
      <select name="equipment_id" selected="selected" onchange="submit()" >
        <option value="-1" <?php if (!(strcmp(-1, $row_editequipmenthire['equipment_id']))) {echo "selected=\"selected\"";} ?> >Select Equipment</option>  
      
  <?php 
do {  
?>
      <option value="<?php echo $row_addequipment['equipment_id']?>"<?php if (!(strcmp($row_addequipment['equipment_id'], $row_viewcostequipment['equipment_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_addequipment['equipment_name']?></option>
        
         <?php
} while ($row_addequipment = mysql_fetch_assoc($addequipment));

echo "<option value=\"{$row_addstudent['-1']}\"";
echo (!empty($_POST['-1'])&&$_POST['-1']== $row_addequipment['-1']  ? ' selected="selected"' :'');
echo ">{$row_addstudent['-1']}</option>\n";								   
								   
  $rows = mysql_num_rows($addequipment);
  if($rows > 0) {
      mysql_data_seek($addequipment, 0);
	  $row_addequipment = mysql_fetch_assoc($addequipment);
  }



?>
      </select></td>
    </tr>
    <tr valign="baseline">
        <td nowrap="nowrap" align="right">Equipment Cost</td>
        <td><input name="equipment_hirecost" value="<?php echo $row_viewcostequipment['equipment_hirecost']; ?>" type="hidden" />
          </td>
      </tr>
      
      
      
      
      </td>
    </tr> 
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Hire Date:</td>
      <td><input type="text" name="hire_date" id="hire_date" value="<?php echo htmlentities($row_editequipmenthire['hire_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Return Date:</td>
      <td><input type="text" name="return_date" id="return_date" value="<?php echo htmlentities($row_editequipmenthire['return_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    	<?php 
		$returndate=$_POST['return_date'];
	$hiredate=$_POST['hire_date'];
	$noofdays=$returndate-$hiredate; 
	?>
    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">No Of Days Hired:</td>
      <td><?php echo $noofdays;  ?></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Number Hired:</td>
      <td><input type="text" name="number_hired" value="<?php echo htmlentities($row_editequipmenthire['number_hired'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr> 
    
        <tr valign="baseline">
      <td nowrap="nowrap" align="right">Amount:</td>
      <td><?php echo $totalamount;  ?></td>
    </tr>
    
     <?php mysql_select_db($database_church, $church);
$query_addleader ="SELECT * FROM leader l LEFT JOIN member_details md ON md.memberid=l.memberid ";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);?>

    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Billed By:</td>
      <td><select name="billed_by" selected="selected">
       <option value="-1"  <?php if (!(strcmp(-1,                 $row_editfirstconfirmation['hire_id']))) {echo "selected=\"selected\"";} ?>>Select Leader</option>
       <?php
do {  
?>
       <option value="<?php echo $row_addleader['memberid']?>"<?php if (!(strcmp($row_addleader['memberid'], $row_editequipmenthire['hire_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_addleader['firstname']?> <?php echo $row_addleader['middlename']?> <?php echo $row_addleader['lastname']?></option>
       <?php
} while ($row_addleader = mysql_fetch_assoc($addleader));
  $rows = mysql_num_rows($addleader);
  if($rows > 0) {
      mysql_data_seek($addleader, 0);
	  $row_addleader = mysql_fetch_assoc($addleader);
  }
?>
     </select></td>
    </tr>
   
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['hire_id'])) &&($_GET['hire_id']!="")) {?><input type="submit" value="Update" name="updatehire"><?php } else  {?><input type="submit" value="Save" name="savehire"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center">
    <tr>
    

    
       <td width="2%">No</td>
      <td width="10%">Equipment Name</td>
       <td width="4%">hire_date</td>
     <td width="4%">return_date</td>
     <td width="10%">Leader </td>
     <td width="10%">number_hired</td>
     <td width="4%">Total</td>
     <td width="4%">&nbsp;</td>
     <td width="4%">&nbsp;</td>
    </tr>
    <?php do { $hire++; ?>
      <tr>
        <td><?php echo $hire; ?></td>
        <td><?php echo $row_viewequipmenthire['equipment_name']; ?>&nbsp; </td>
        <td><?php echo $row_viewequipmenthire['hire_date']; ?>&nbsp; </td>
        <td><?php echo $row_viewequipmenthire['return_date']; ?>&nbsp; </td>
        <td><?php echo $row_viewequipmenthire['firstname']; ?>&nbsp<?php echo $row_viewequipmenthire['middlename']; ?>&nbsp;<?php echo $row_viewequipmenthire['lastname']; ?> </td>
      <td><?php echo $row_viewequipmenthire['number_hired']; ?>&nbsp; </td>
     <td><?php echo "Ksh. ".number_format($total, 2, '.', ','); ?> </td>
        
          <td><a href="index.php?tithe=show&hire_id=<?php echo $row_viewequipmenthire['hire_id']; ?>& #tabs-5"> Edit </a></td> 
           
 <td><a href="index.php?tithe=show&hire_id=<?php echo $row_viewequipmenthire['hire_id'];?> & Delete=1 &#tabs-5" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
      </tr>
      <?php } while ($row_viewequipmenthire = mysql_fetch_assoc($viewequipmenthire)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewequipmenthire > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewequipmenthire=%d%s", $currentPage, 0, $queryString_viewequipmenthire); ?>">First</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewequipmenthire > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewequipmenthire=%d%s", $currentPage, max(0, $pageNum_viewequipmenthire - 1), $queryString_viewequipmenthire); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewequipmenthire < $totalPages_viewequipmenthire) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewequipmenthire=%d%s", $currentPage, min($totalPages_viewequipmenthire, $pageNum_viewequipmenthire + 1), $queryString_viewequipmenthire); ?>">Next</a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewequipmenthire < $totalPages_viewequipmenthire) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewequipmenthire=%d%s", $currentPage, $totalPages_viewequipmenthire, $queryString_viewequipmenthire); ?>">Last</a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewequipmenthire + 1) ?> to <?php echo min($startRow_viewequipmenthire + $maxRows_viewequipmenthire, $totalRows_viewequipmenthire) ?> of <?php echo $totalRows_viewequipmenthire ?>
</form>
</div>



<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($addleader);

mysql_free_result($addservice);

mysql_free_result($addmember);

mysql_free_result($addoffering);

mysql_free_result($editoffering);

mysql_free_result($viewoffering);
?>
