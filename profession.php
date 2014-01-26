<?php virtual('/st_peters/Connections/church.php'); ?>
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

if ((isset($_POST["saveprofession"]))) {
  $insertSQL = sprintf("INSERT INTO profession (profession_id, memberid, profession_name, profession_start, profession_end, company_name) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['profession_id'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['profession_name'], "text"),
                       GetSQLValueString($_POST['profession_start'], "text"),
                       GetSQLValueString($_POST['profession_end'], "text"),
                       GetSQLValueString($_POST['company_name'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["updateprofession"]))) {
  $updateSQL = sprintf("UPDATE profession SET memberid=%s, profession_name=%s, profession_start=%s, profession_end=%s, company_name=%s WHERE profession_id=".$_GET['profession_id']."",
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['profession_name'], "text"),
                       GetSQLValueString($_POST['profession_start'], "text"),
                       GetSQLValueString($_POST['profession_end'], "text"),
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['profession_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

mysql_select_db($database_church, $church);
$query_addprofession = "SELECT * FROM profession";
$addprofession = mysql_query($query_addprofession, $church) or die(mysql_error());
$row_addprofession = mysql_fetch_assoc($addprofession);
$totalRows_addprofession = mysql_num_rows($addprofession);

mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM profession";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);
if((isset($_GET['profession_id'])) && ($_GET['profession_id']!="")){
mysql_select_db($database_church, $church);
$query_editprofession = "SELECT * FROM profession p INNER JOIN member_details md ON p.memberid=md.memberid WHERE profession_id=".$_GET['profession_id']."";
$editprofession = mysql_query($query_editprofession, $church) or die(mysql_error());
$row_editprofession = mysql_fetch_assoc($editprofession);
$totalRows_editprofession = mysql_num_rows($editprofession);
}
$maxRows_viewprofession = 10;
$pageNum_viewprofession = 0;
if (isset($_GET['pageNum_viewprofession'])) {
  $pageNum_viewprofession = $_GET['pageNum_viewprofession'];
}
$startRow_viewprofession = $pageNum_viewprofession * $maxRows_viewprofession;

mysql_select_db($database_church, $church);
$query_viewprofession = "SELECT * FROM profession p INNER JOIN member_details md ON p.memberid=md.memberid";
$query_limit_viewprofession = sprintf("%s LIMIT %d, %d", $query_viewprofession, $startRow_viewprofession, $maxRows_viewprofession);
$viewprofession = mysql_query($query_limit_viewprofession, $church) or die(mysql_error());
$row_viewprofession = mysql_fetch_assoc($viewprofession);

if (isset($_GET['totalRows_viewprofession'])) {
  $totalRows_viewprofession = $_GET['totalRows_viewprofession'];
} else {
  $all_viewprofession = mysql_query($query_viewprofession);
  $totalRows_viewprofession = mysql_num_rows($all_viewprofession);
}
$totalPages_viewprofession = ceil($totalRows_viewprofession/$maxRows_viewprofession)-1;

$queryString_viewprofession = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewprofession") == false && 
        stristr($param, "totalRows_viewprofession") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewprofession = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewprofession = sprintf("&totalRows_viewprofession=%d%s", $totalRows_viewprofession, $queryString_viewprofession);
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
      <td nowrap="nowrap" align="right">Member:</td>
      <td><select name="memberid" selected="selected">  
      <option value="-1" <?php if (!(strcmp(-1, $row_editcontact['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>
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
      <td nowrap="nowrap" align="right">Profession_name:</td>
      <td><input type="text" name="profession_name" value="<?php echo htmlentities($row_editprofession['profession_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Profession_start:</td>
      <td><input type="text" name="profession_start" id="profession_start" value="<?php echo htmlentities($row_editprofession['profession_start'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Profession_end:</td>
      <td><input type="text" name="profession_end" id="profession_end" value="<?php echo htmlentities($row_editprofession['profession_end'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Company_name:</td>
      <td><input type="text" name="company_name" value="<?php echo htmlentities($row_editprofession['company_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
      <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['profession_id'])) &&($_GET['profession_id']!="")) {?><input type="submit" value="Update" name="updateprofession"><?php } else  {?><input type="submit" value="Save" name="saveprofession"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>
    <td>No</td>
    <td>Member Names </td>
    <td>profession_name</td>
    <td>profession_start</td>
    <td>profession_end</td>
    <td>company_name</td>
  </tr>
  <?php $profession=0; do { $profession++; ?>
    <tr>
      <td><?php echo $profession ;  ?> </a></td>
      <td><?php echo $row_viewprofession['memberid']; ?>&nbsp; </td>
      <td><?php echo $row_viewprofession['profession_name']; ?>&nbsp; </td>
      <td><?php echo $row_viewprofession['profession_start']; ?>&nbsp; </td>
      <td><?php echo $row_viewprofession['profession_end']; ?>&nbsp; </td>
      <td><?php echo $row_viewprofession['company_name']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_viewprofession = mysql_fetch_assoc($viewprofession)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewprofession > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewprofession=%d%s", $currentPage, 0, $queryString_viewprofession); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewprofession > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewprofession=%d%s", $currentPage, max(0, $pageNum_viewprofession - 1), $queryString_viewprofession); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewprofession < $totalPages_viewprofession) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewprofession=%d%s", $currentPage, min($totalPages_viewprofession, $pageNum_viewprofession + 1), $queryString_viewprofession); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewprofession < $totalPages_viewprofession) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewprofession=%d%s", $currentPage, $totalPages_viewprofession, $queryString_viewprofession); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewprofession + 1) ?> to <?php echo min($startRow_viewprofession + $maxRows_viewprofession, $totalRows_viewprofession) ?> of <?php echo $totalRows_viewprofession ?>
</body>
</html>
<?php
mysql_free_result($viewprofession);

mysql_free_result($addprofession);

mysql_free_result($addmember);

mysql_free_result($editprofession);

mysql_free_result($viewprofession);
?>
