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

if ((isset($_POST["updateequipment"]))) {
  $insertSQL = sprintf("INSERT INTO equipment (equipment_id, equipment_name, equipment_hirecost) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['equipment_id'], "int"),
                       GetSQLValueString($_POST['equipment_name'], "text"),
                       GetSQLValueString($_POST['equipment_hirecost'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
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

}

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
$maxRows_viewequipment = 10;
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
    <td>No</td>
    <td>equipment_name</td>
    <td>equipment_hirecost</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php do { $equipment++; ?>
    <tr>
      <td><?php echo $equipment ; ?></td>
      <td><?php echo $row_viewequipment['equipment_name']; ?>&nbsp; </td>
    <td><?php echo $row_viewequipment['equipment_hirecost']; ?>&nbsp; </td>
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
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($addequipment);

mysql_free_result($editequipment);

mysql_free_result($viewequipment);
?>
