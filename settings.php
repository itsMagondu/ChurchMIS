<?php 
if(!isset($_SESSION))
{
session_start();
} 
require_once('Connections/church.php');
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

mysql_select_db($database_church, $church);
$query_settings = "SELECT * FROM settings";
$settings = mysql_query($query_settings, $church) or die(mysql_error());
$row_settings = mysql_fetch_assoc($settings);
$totalRows_settings = mysql_num_rows($settings);

$cosettings=$row_settings['setting_id'];
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["Savep"])) && ($_POST["Savep"] == "Save")) {
  $insertSQL = sprintf("INSERT INTO period (start_date, end_date, period_name, individual_performance, company_performance,competencies) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['start_date'], "date"),
                       GetSQLValueString($_POST['end_date'], "date"),
                       GetSQLValueString($_POST['period_name'], "text"),
                       GetSQLValueString($_POST['individual_performance'], "int"),
                       GetSQLValueString($_POST['company_performance'], "int"),
					   GetSQLValueString($_POST['kca'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["Updatep"])) && ($_POST["Updatep"]=="Update")) {
  $updateSQL = sprintf("UPDATE period SET start_date=%s, end_date=%s, period_name=%s, individual_performance=%s, company_performance=%s, competencies=%s WHERE period.period_id=".$_GET['period']."",
                       GetSQLValueString($_POST['start_date'], "date"),
                       GetSQLValueString($_POST['end_date'], "date"),
                       GetSQLValueString($_POST['period_name'], "text"),
                       GetSQLValueString($_POST['individual_performance'], "int"),
                       GetSQLValueString($_POST['company_performance'], "int"),
					   GetSQLValueString($_POST['kca'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
if (isset($_GET['period'])){
$period=$_GET['period'];	
mysql_select_db($database_church, $church);
$query_period = "SELECT * FROM period WHERE period.period_id='$period'";
$period = mysql_query($query_period, $church) or die(mysql_error());
$row_period = mysql_fetch_assoc($period);
$totalRows_period = mysql_num_rows($period);
}
if ((isset($_POST["Update"])) && ($_POST["Update"] == "Update")) {
  $updateSQL = sprintf("UPDATE settings SET company_name=%s, company_vision=%s, company_mission=%s, company_strategy=%s WHERE setting_id=".$cosettings."",
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['company_vision'], "text"),
                       GetSQLValueString($_POST['company_mission'], "text"),
                       GetSQLValueString($_POST['company_strategy'], "text"),
                       GetSQLValueString($_POST['company_name'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
    $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["Save"])) && ($_POST["Save"] == "Save")) {
  $insertSQL = sprintf("INSERT INTO settings (company_name, company_vision, company_mission, company_strategy) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['company_vision'], "text"),
                       GetSQLValueString($_POST['company_mission'], "text"),
                       GetSQLValueString($_POST['company_strategy'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link href="/st_peters/tms.css" rel="stylesheet" type="text/css"/>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.sortable.js"></script>

<script type="text/javascript" src="/st_peters/js/jquery-ui/development-bundle/jquery-1.3.2.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/development-bundle/ui/ui.core.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/development-bundle/ui/ui.datepicker3.js"></script>

<link type="text/css" href="/st_peters/js/jquery-ui/development-bundle/demos/demos.css" rel="stylesheet" />
<link type="text/css" href="/st_peters/js/jquery-ui/development-bundle/themes/base/ui.all.css" rel="stylesheet" />
<script type="text/javascript">
	$(function() {
		$('#start_date').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#end_date').datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
</head>

<body>

<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="0" cellspacing="1" cellpadding="1">
    <tr valign="top">
      <td colspan="2" class="header"><div align="center">Church Settings</div></td>
    </tr>
    <tr>
      <td width="22%" valign="top">Organization  Name:</td>
      <td width="78%"><span id="sprytextfield1">
        <input name="company_name" type="text" id="company_name" value="<?php echo $row_settings['company_name']; ?>" size="45" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td valign="top">Our Goals</td>
      <td><span id="sprytextarea1">
        <textarea name="company_mission" id="company_mission" cols="40" rows="3"><?php echo $row_settings['company_mission']; ?></textarea>
        <span class="textareaRequiredMsg">A value is required.</span>      </span></td>
    </tr>
    <tr>
      <td valign="top">Our Vision</td>
      <td><span id="sprytextarea2">
        <textarea name="company_vision" id="company_vision" cols="40" rows="3"><?php echo $row_settings['company_vision']; ?></textarea>
        <span class="textareaRequiredMsg">A value is required.</span>      </span></td>
    </tr>
    <tr>
      <td valign="top">StrategicObjectives:</td>
      <td><span id="sprytextarea3">
        <textarea name="company_strategy" id="company_strategy" cols="40" rows="5"><?php echo $row_settings['company_strategy']; ?></textarea>
      <span class="textareaRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td><?php if($totalRows_settings>1){?><input name="Save" type="submit" id="Save" value="Save" />
        <?php }else{?>
      <input type="submit" name="Update" id="Update" value="Update" /><?php }?></td>
    </tr>
  </table></form>
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2");
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3");
//-->
</script>
</body>
</html>
<?php
@mysql_free_result($settings);

@mysql_free_result($period);
?>
