<?php 
require_once('Connections/church.php');
require_once('functions.php');

checkUser();?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$error="";
if (isset($_POST["change"])) {
 
  $pass=md5(($_POST['password']));
/*  
  if($pass!=$_POST['password0']){
   $error="Please input the correct password.\n Your old password is the one you used to log in."; }else{*/
   $updateSQL = sprintf("UPDATE leader SET password=md5('$pass') WHERE leaderid=%s",
                         GetSQLValueString($_POST['leaderid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
 
    	return('Password Changed Successfully');    


  /* }*/
	  
}

mysql_select_db($database_church, $church);
$query_password = "SELECT * FROM leader WHERE leaderid=".$_SESSION['msm_logged']."";
$password = mysql_query($query_password, $church) or die(mysql_error());
$row_password = mysql_fetch_assoc($password);
$totalRows_password = mysql_num_rows($password);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css" />

<link href="/st_peters/tms.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<form action="" method="post" name="form1" id="form1">
  <table align="center" class="changepass">
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">New Password</td>
      <td><span id="sprypassword1">
        <input type="password" name="password" id="password" />
      <span class="passwordRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Confirm Password</td>
      <td><span id="spryconfirm1">
        <label for="confirmpwd"></label>
        <input type="password" name="confirmpwd" id="confirmpwd" />
      <span class="confirmRequiredMsg">A value is required.</span><span class="confirmInvalidMsg">The values don't match.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input name="change" type="submit" id="change" value="Change password" />
      <input type="button" name="cancel" id="cancel" value="Cancel" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="employee_id" value="<?php echo $row_password['employee_id']; ?>" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">
<!--
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password", {validateOn:["change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($password);
?>
