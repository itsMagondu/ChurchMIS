<?php include ('Connections/church.php'); ?>
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

if ((isset($_POST["saveservice"]))) {
  $insertSQL = sprintf("INSERT INTO church_service (church_service_id, service_name, service_description, service_start_time, service_end_time) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['church_service_id'], "int"),
                       GetSQLValueString($_POST['service_name'], "text"),
                       GetSQLValueString($_POST['service_description'], "text"),
                       GetSQLValueString($_POST['service_start_time'], "text"),
                       GetSQLValueString($_POST['service_end_time'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["updateservice"]))) {
  $updateSQL = sprintf("UPDATE church_service SET service_name=%s, service_description=%s, service_start_time=%s, service_end_time=%s WHERE church_service_id=".$_GET['church_service_id']."",
                       GetSQLValueString($_POST['service_name'], "text"),
                       GetSQLValueString($_POST['service_description'], "text"),
                       GetSQLValueString($_POST['service_start_time'], "text"),
                       GetSQLValueString($_POST['service_end_time'], "text"),
                       GetSQLValueString($_POST['church_service_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

mysql_select_db($database_church, $church);
$query_addservice = "SELECT * FROM church_service";
$addservice = mysql_query($query_addservice, $church) or die(mysql_error());
$row_addservice = mysql_fetch_assoc($addservice);
$totalRows_addservice = mysql_num_rows($addservice);

if((isset($_GET['church_service_id'])) &&($_GET['church_service_id']!="")){
mysql_select_db($database_church, $church);
$query_editservice = "SELECT * FROM church_service WHERE church_service=".$_GET['church_service_id']."";
$editservice = mysql_query($query_editservice, $church) or die(mysql_error());
$row_editservice = mysql_fetch_assoc($editservice);
$totalRows_editservice = mysql_num_rows($editservice);
}
$maxRows_viewservice = 10;
$pageNum_viewservice = 0;
if (isset($_GET['pageNum_viewservice'])) {
  $pageNum_viewservice = $_GET['pageNum_viewservice'];
}
$startRow_viewservice = $pageNum_viewservice * $maxRows_viewservice;

mysql_select_db($database_church, $church);
$query_viewservice = "SELECT * FROM church_service";
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
<link rel="stylesheet" type="text/css" href="/st_peters/tms.css"/>
<link rel="stylesheet" href="/st_peters/jquery-ui-timepicker/jquery.ui.timepicker.css?v=0.3.0" type="text/css"/>

 <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery-1.5.1.min.js"></script>
  
 <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery.ui.core.min.js"></script>
    
  <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery.ui.widget.min.js"></script>
    
   <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery.ui.tabs.min.js"></script>
    
    
 <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery.ui.position.min.js"></script>
     
   <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/jquery.ui.timepicker.js?v=0.3.0"></script>
    <link type="text/css" href="/st_peters/js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet"/>

<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.core.js"></script>
    
   <script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.datepicker.js"></script>
    
 <link type="text/css" href="/st_peters/js/jquery-ui/demos/demos.css" rel="stylesheet"/> 
    
    

<script type="text/javascript">
            $(document).ready(function() {
                $('#timepicker_start').timepicker({
                    showLeadingZero: false,
					showNowButton: true,
					
                });
                $('#timepicker_end').timepicker({
                    showLeadingZero: false,
					showNowButton: true,
					onHourShow: tpEndOnHourShowCallback,
                    onMinuteShow: tpEndOnMinuteShowCallback

                });
            });

            function tpStartOnHourShowCallback(hour) {
                var tpEndHour = $('#timepicker_end').timepicker('getHour');
                // Check if proposed hour is prior or equal to selected end time hour
                if (hour <= tpEndHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpStartOnMinuteShowCallback(hour, minute) {
                var tpEndHour = $('#timepicker_end').timepicker('getHour');
                var tpEndMinute = $('#timepicker_end').timepicker('getMinute');
                // Check if proposed hour is prior to selected end time hour
                if (hour < tpEndHour) { return true; }
                // Check if proposed hour is equal to selected end time hour and minutes is prior
                if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
            }

            function tpEndOnHourShowCallback(hour) {
                var tpStartHour = $('#timepicker_start').timepicker('getHour');
                // Check if proposed hour is after or equal to selected start time hour
                if (hour >= tpStartHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpEndOnMinuteShowCallback(hour, minute) {
                var tpStartHour = $('#timepicker_start').timepicker('getHour');
                var tpStartMinute = $('#timepicker_start').timepicker('getMinute');
                // Check if proposed hour is after selected start time hour
                if (hour > tpStartHour) { return true; }
                // Check if proposed hour is equal to selected start time hour and minutes is after
                if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
            }
				function OnHourShowCallback(hour) {
    if ((hour > 18) || (hour < 7)) {
        return false; // not valid
    }
    return true; // valid
}
function OnMinuteShowCallback(hour, minute) {
    if ((hour == 18) && (minute >= 30)) { return false; } // not valid
    if ((hour == 7) && (minute < 30)) { return false; }   // not valid
    return true;  // valid
}

        </script>
        <script type="text/javascript">
	$(function() {
		$("#tabs").tabs().find(".ui-tabs-nav").sortable({axis:'x'});
	});
	</script>



</head>

<body>
<div id="tabs">
<ul>
		<li><a href="#tabs-1">Service</a></li>



</ul>
<div id="tabs-1">

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service_name:</td>
      <td><input type="text" name="service_name" value="<?php echo htmlentities($row_editservice['service_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" Valign="top">Service_description:</td>
      <td><textarea name="service_description" id="service_description" cols="45" rows="5"><?php echo $row_editservice['service_description'] ?></textarea>
      
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service_start_time:</td>
      <td><input type="text" name="service_start_time" id="timepicker_start"  value="<?php echo htmlentities($row_editservice['service_start_time'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service_end_time:</td>
      <td><input type="text" name="service_end_time" id="timepicker_end" value="<?php echo htmlentities($row_editservice['service_end_time'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['church_service_id'])) &&($_GET['church_service_id']!="")) {?><input type="submit" value="Update" name="updateservice"><?php } else  {?><input type="submit" value="Save" name="saveservice"><?php }?>
      </td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
  </p>
  <p>&nbsp;
  <table border="1" align="center">
    <tr>
      <td>No</td>
      <td>Service Name</td>
      <td>Service Description</td>
      <td>Service Start Time</td>
      <td>Service End Time</td>
      <td>&nbsp;</td>
       <td>&nbsp;</td>
    </tr>
    <?php do { $service++; ?>
      <tr>
        <td><?php echo $service; ?></td>
        <td><?php echo $row_viewservice['service_name']; ?>&nbsp; </td>
        <td><?php echo $row_viewservice['service_description']; ?>&nbsp; </td>
        <td><?php echo $row_viewservice['service_start_time']; ?>&nbsp; </td>
        <td><?php echo $row_viewservice['service_end_time']; ?>&nbsp; </td>
       <td><a href="index.php?service=show&church_service _id=<?php echo $row_viewservice['church_service_id']; ?>"> Edit </a></td>
                  
   <td><a href="index.php?service=show & church_service _id=<?php echo $row_viewservice['church_service_id'];?> & Delete=1" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
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
</p>
</form>
</div>
<div id="tabs-2">
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($addservice);

mysql_free_result($editservice);

mysql_free_result($viewservice);
?>
