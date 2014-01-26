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

if ((isset($_POST["savehire"]))) {
	
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
$query_viewequipmenthire = "SELECT * FROM equipment_hire";
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
      <td nowrap="nowrap" align="right">Equipment Name:</td>
      <td><select name="equipment_id">
        <?php 
do {  
?>
        <option value="<?php echo $row_addequipment['equipment_id']?>" ><?php echo $row_addequipment['equipment_id']?></option>
        <?php
} while ($row_addequipment = mysql_fetch_assoc($addequipment));
?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Hire_date:</td>
      <td><input type="text" name="hire_date" value="<?php echo htmlentities($row_editequipmenthire['hire_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Return_date:</td>
      <td><input type="text" name="return_date" value="<?php echo htmlentities($row_editequipmenthire['return_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">No Of Days Hired:</td>
      <td><?php echo $noofdays  ?></td>
    </tr>
    <?php
	 mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

?>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Billed_by:</td>
      <td><select name="billed_by">
      
      <option value="-1" <?php if (!(strcmp(-1, $row_editsermon['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>  
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
</select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Number_hired:</td>
      <td><input type="text" name="number_hired" value="<?php echo htmlentities($row_editequipmenthire['number_hired'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
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
      <td>No</td>
      <td>Equipment Name</td>
      <td>hire_date</td>
      <td>return_date</td>
      <td>billed_by</td>
      <td>number_hired</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php do { $hire++; ?>
      <tr>
        <td><?php echo $hire; ?></td>
        <td><?php echo $row_viewequipmenthire['equipment_id']; ?>&nbsp; </td>
        <td><?php echo $row_viewequipmenthire['hire_date']; ?>&nbsp; </td>
        <td><?php echo $row_viewequipmenthire['return_date']; ?>&nbsp; </td>
        <td><?php echo $row_viewequipmenthire['billed_by']; ?>&nbsp; </td>
        <td><?php echo $row_viewequipmenthire['number_hired']; ?>&nbsp; </td>
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
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($addequipment);

mysql_free_result($addequipmenthire);

mysql_free_result($editequipmenthire);

mysql_free_result($viewequipmenthire);
?>
