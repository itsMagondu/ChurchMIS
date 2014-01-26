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

if ((isset($_POST["saverole"]))) {
  $insertSQL = sprintf("INSERT INTO role (roleid, rolename, roledescription) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['roleid'], "int"),
                       GetSQLValueString($_POST['rolename'], "text"),
                       GetSQLValueString($_POST['roledescription'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["updaterole"]))) {
	if(isset($_GET['roleid']) && ($_GET['roleid']!="")){
		
  $updateSQL = sprintf("UPDATE role SET rolename=%s, roledescription=%s WHERE roleid=".$_GET['roleid']."",
                       GetSQLValueString($_POST['rolename'], "text"),
                       GetSQLValueString($_POST['roledescription'], "text"),
                       GetSQLValueString($_POST['roleid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
}

mysql_select_db($database_church, $church);
$query_addrole = "SELECT * FROM role";
$addrole = mysql_query($query_addrole, $church) or die(mysql_error());
$row_addrole = mysql_fetch_assoc($addrole);
$totalRows_addrole = mysql_num_rows($addrole);

mysql_select_db($database_church, $church);
$query_editroles = "SELECT * FROM role";
$editroles = mysql_query($query_editroles, $church) or die(mysql_error());
$row_editroles = mysql_fetch_assoc($editroles);
$totalRows_editroles = mysql_num_rows($editroles);

$maxRows_viewroles = 10;
$pageNum_viewroles = 0;
if (isset($_GET['pageNum_viewroles'])) {
  $pageNum_viewroles = $_GET['pageNum_viewroles'];
}
$startRow_viewroles = $pageNum_viewroles * $maxRows_viewroles;

mysql_select_db($database_church, $church);
$query_viewroles = "SELECT * FROM role";
$query_limit_viewroles = sprintf("%s LIMIT %d, %d", $query_viewroles, $startRow_viewroles, $maxRows_viewroles);
$viewroles = mysql_query($query_limit_viewroles, $church) or die(mysql_error());
$row_viewroles = mysql_fetch_assoc($viewroles);

if (isset($_GET['totalRows_viewroles'])) {
  $totalRows_viewroles = $_GET['totalRows_viewroles'];
} else {
  $all_viewroles = mysql_query($query_viewroles);
  $totalRows_viewroles = mysql_num_rows($all_viewroles);
}
$totalPages_viewroles = ceil($totalRows_viewroles/$maxRows_viewroles)-1;

$queryString_viewroles = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewroles") == false && 
        stristr($param, "totalRows_viewroles") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewroles = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewroles = sprintf("&totalRows_viewroles=%d%s", $totalRows_viewroles, $queryString_viewroles);
?>










<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link type="text/css" href="/st_peters/tms.css" />
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Rolename:</td>
      <td><input type="text" name="rolename" value="<?php echo htmlentities($row_editroles['rolename'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Roledescription:</td>
      <td><textarea  type="text" name="roledescription" value="<?php echo htmlentities($row_editroles['roledescription'], ENT_COMPAT, 'utf-8'); ?>" cols="30" /></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['roleid'])) &&($_GET['roleid']!="")) {?><input type="submit" value="Update" name="updaterole"><?php } else  {?><input type="submit" value="Save" name="saverole"><?php }?>
      </td>
    </tr>
  </table>
 
  <p>&nbsp;</p>
  <table border="1" align="center">
    <tr>
      <td>No</td>
      <td>rolename</td>
      <td>roledescription</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php do { $numroles ++; ?>
      <tr>
        <td><?php echo $numroles;  ?></td>
        <td><?php echo $row_viewroles['rolename']; ?>&nbsp; </td>
        <td class="maxwidthcomment"><?php echo $row_viewroles['roledescription']; ?></td>
        <td>Edit</td>
        <td>Delete </td>
      </tr>
      <?php } while ($row_viewroles = mysql_fetch_assoc($viewroles)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewroles > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewroles=%d%s", $currentPage, 0, $queryString_viewroles); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewroles > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewroles=%d%s", $currentPage, max(0, $pageNum_viewroles - 1), $queryString_viewroles); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewroles < $totalPages_viewroles) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewroles=%d%s", $currentPage, min($totalPages_viewroles, $pageNum_viewroles + 1), $queryString_viewroles); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewroles < $totalPages_viewroles) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewroles=%d%s", $currentPage, $totalPages_viewroles, $queryString_viewroles); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewroles + 1) ?> to <?php echo min($startRow_viewroles + $maxRows_viewroles, $totalRows_viewroles) ?> of <?php echo $totalRows_viewroles ?>
<input type="hidden" name="MM_insert" value="form1" />
 
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($addrole);

mysql_free_result($editroles);

mysql_free_result($viewroles);
?>
