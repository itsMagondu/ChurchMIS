<?php virtual('/st_peters/Connections/church.php'); ?>
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

if ((isset($_POST["saverecord"]))) {
  $insertSQL = sprintf("INSERT INTO service_attended (service_attendedid, memberid, service_name, church_attendance) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['service_attendedid'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['service_name'], "text"),
                       GetSQLValueString($_POST['church_attendance'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE service_attended SET memberid=%s, service_name=%s, church_attendance=%s WHERE service_attendedid=%s",
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['service_name'], "text"),
                       GetSQLValueString($_POST['church_attendance'], "text"),
                       GetSQLValueString($_POST['service_attendedid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM service_attended";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

mysql_select_db($database_church, $church);
$query_addservice = "SELECT * FROM service_attended";
$addservice = mysql_query($query_addservice, $church) or die(mysql_error());
$row_addservice = mysql_fetch_assoc($addservice);
$totalRows_addservice = mysql_num_rows($addservice);

mysql_select_db($database_church, $church);
$query_editservice = "SELECT * FROM service_attended";
$editservice = mysql_query($query_editservice, $church) or die(mysql_error());
$row_editservice = mysql_fetch_assoc($editservice);
$totalRows_editservice = mysql_num_rows($editservice);

$maxRows_viewservice = 100;
$pageNum_viewservice = 0;
if (isset($_GET['pageNum_viewservice'])) {
  $pageNum_viewservice = $_GET['pageNum_viewservice'];
}
$startRow_viewservice = $pageNum_viewservice * $maxRows_viewservice;

mysql_select_db($database_church, $church);
$query_viewservice = "SELECT * FROM service_attended";
$query_limit_viewservice = sprintf("%s LIMIT %d, %d", $query_viewservice, $startRow_viewservice, $maxRows_viewservice);
$viewservice = mysql_query($query_limit_viewservice, $church) or die(mysql_error());
$row_viewservice = mysql_fetch_assoc($viewservice);

if (isset($_GET['totalRows_viewservice'])) {
  $totalRows_viewservice = $_GET['totalRows_viewservice'];
} else {
  $all_viewservice = mysql_query($query_viewservice);
  $totalRows_viewservice = mysql_num_rows($all_viewservice);
}
$totalPages_viewservice = ceil($totalRows_viewservice/$maxRows_viewservice)-1;

$queryString_viewservice = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewservice") == false && 
        stristr($param, "totalRows_viewservice") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewservice = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewservice = sprintf("&totalRows_viewservice=%d%s", $totalRows_viewservice, $queryString_viewservice);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td width="120" align="right" nowrap="nowrap">Member Names</td>
      <td width="367">
       <select name="memberid" selected="selected">  
      <option value="-1" <?php if (!(strcmp(-1, $row_editservice['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>
  <?php
do {  
?>
  <option  size="32"value="<?php echo $row_addmember['memberid']?>"><?php echo $row_addmember['lastname']?>&nbsp;<?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?></option>
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));
  $rows = mysql_num_rows($addmember);
  if($rows > 0) {
      mysql_data_seek($addmember, 0);
	  $row_addmember = mysql_fetch_assoc($addmember);
  }
?>         
</select>
      
      
      
      
      
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service_name:</td>
      <td>
        <input type="radio" name="radio" id="1st service" value="1st service" />
      <label for="1st service">1 st Service</label>
      <input type="radio" name="radio" id="2nd service" value="2nd service" />
      <label for="2nd service">2nd service</label>
      <input type="radio" name="radio" id="both services" value="both services" />
      <label for="both services">Both Services</label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Church_attendance:</td>
      <td>
        <input type="checkbox" name="everysunday" id="everysunday" />
      <label for="everysunday">Every Sunday</label>
      <input type="checkbox" name="twiceamonth" id="twiceamonth" />
      <label for="twiceamonth">Twice a Month</label>
      <input type="checkbox" name="onceamonth" id="onceamonth" />
      <label for="onceamonth">Once a Month</label>
      <input type="checkbox" name="irregular" id="irregular" />
      <label for="irregular">Irregular</label></td>
    </tr>
     <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['service_attendedid'])) &&($_GET['service_attendedid']!="")) {?><input type="submit" value="Update"        name="updateattendance"><?php } else  {?><input type="submit" value="Add"           name="saveattendance"><?php }?>
        </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>
    <td>No</td>
    <td>Member Name</td>
    <td>service_name</td>
    <td>church_attendance</td>
  </tr>
  <?php do {$attended++; ?>
    <tr>
      <td><?php  echo $attended; ?></td>
      <td><?php echo $row_viewservice['memberid']; ?>&nbsp; </td>
      <td><?php echo $row_viewservice['service_name']; ?>&nbsp; </td>
      <td><?php echo $row_viewservice['church_attendance']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_viewservice = mysql_fetch_assoc($viewservice)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewservice > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewservice=%d%s", $currentPage, 0, $queryString_viewservice); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewservice > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewservice=%d%s", $currentPage, max(0, $pageNum_viewservice - 1), $queryString_viewservice); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewservice < $totalPages_viewservice) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewservice=%d%s", $currentPage, min($totalPages_viewservice, $pageNum_viewservice + 1), $queryString_viewservice); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewservice < $totalPages_viewservice) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewservice=%d%s", $currentPage, $totalPages_viewservice, $queryString_viewservice); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewservice + 1) ?> to <?php echo min($startRow_viewservice + $maxRows_viewservice, $totalRows_viewservice) ?> of <?php echo $totalRows_viewservice ?>
</body>
</html>
<?php
mysql_free_result($addmember);

mysql_free_result($addservice);

mysql_free_result($editservice);

mysql_free_result($viewservice);
?>
