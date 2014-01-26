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

if ((isset($_POST["saveacademic"]))) {
  $insertSQL = sprintf("INSERT INTO academic (academics_id, memberid, acad_from, acad_to, institution_name, study_type, `level`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['academics_id'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['acad_from'], "text"),
                       GetSQLValueString($_POST['acad_to'], "text"),
                       GetSQLValueString($_POST['institution_name'], "text"),
                       GetSQLValueString($_POST['study_type'], "text"),
                       GetSQLValueString($_POST['level'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["updateacademic"]))) {
  $updateSQL = sprintf("UPDATE academic SET memberid=%s, acad_from=%s, acad_to=%s, institution_name=%s, study_type=%s, `level`=%s WHERE academics_id=".$_GET['academics_id']."",
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['acad_from'], "text"),
                       GetSQLValueString($_POST['acad_to'], "text"),
                       GetSQLValueString($_POST['institution_name'], "text"),
                       GetSQLValueString($_POST['study_type'], "text"),
                       GetSQLValueString($_POST['level'], "text"),
                       GetSQLValueString($_POST['academics_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

mysql_select_db($database_church, $church);
$query_addacademic = "SELECT * FROM academic";
$addacademic = mysql_query($query_addacademic, $church) or die(mysql_error());
$row_addacademic = mysql_fetch_assoc($addacademic);
$totalRows_addacademic = mysql_num_rows($addacademic);

$maxRows_viewacademic = 10;
$pageNum_viewacademic = 0;
if (isset($_GET['pageNum_viewacademic'])) {
  $pageNum_viewacademic = $_GET['pageNum_viewacademic'];
}
$startRow_viewacademic = $pageNum_viewacademic * $maxRows_viewacademic;

mysql_select_db($database_church, $church);
$query_viewacademic = "SELECT * FROM academic";
$query_limit_viewacademic = sprintf("%s LIMIT %d, %d", $query_viewacademic, $startRow_viewacademic, $maxRows_viewacademic);
$viewacademic = mysql_query($query_limit_viewacademic, $church) or die(mysql_error());
$row_viewacademic = mysql_fetch_assoc($viewacademic);

if (isset($_GET['totalRows_viewacademic'])) {
  $totalRows_viewacademic = $_GET['totalRows_viewacademic'];
} else {
  $all_viewacademic = mysql_query($query_viewacademic);
  $totalRows_viewacademic = mysql_num_rows($all_viewacademic);
}
$totalPages_viewacademic = ceil($totalRows_viewacademic/$maxRows_viewacademic)-1;

if((isset($_GET['academics_id'])) && ($_GET['academics_id']!="")){
mysql_select_db($database_church, $church);
$query_editacademic = " SELECT * FROM academic a INNER JOIN member_details md ON a.memberid=md.memberid WHERE academics_id=".$_GET['academics_id']."";
$editacademic = mysql_query($query_editacademic, $church) or die(mysql_error());
$row_editacademic = mysql_fetch_assoc($editacademic);
$totalRows_editacademic = mysql_num_rows($editacademic);

}
mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

$queryString_viewacademic = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewacademic") == false && 
        stristr($param, "totalRows_viewacademic") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewacademic = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewacademic = sprintf("&totalRows_viewacademic=%d%s", $totalRows_viewacademic, $queryString_viewacademic);
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
      <td nowrap="nowrap" align="right">Acad_from:</td>
      <td><input type="text" name="acad_from"  id="acad_from"value="<?php echo htmlentities($row_editacademic['acad_from'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Acad_to:</td>
      <td><input type="text" name="acad_to" id="acad_to" value="<?php echo htmlentities($row_editacademic['acad_to'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Institution_name:</td>
      <td><input type="text" name="institution_name" value="<?php echo htmlentities($row_editacademic['institution_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
   
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Level:</td>
      <td>
      <select>
        <option value="-1">Select Level</option>
        <option value="1">Primary School</option>
        <option value="2">Secondary School</option>
        <option value="3">College </option>
        <option value="4">University</option>
      </select></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Study_type:</td>
      <td><input type="text" name="study_type" value="<?php echo htmlentities($row_editacademic['study_type'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
     <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['academics_id'])) &&($_GET['academics_id']!="")) {?><input type="submit" value="Update" name="updateacademic"><?php } else  {?><input type="submit" value="Save" name="saveacademic"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>
    <td>No</td>
    <td>Member Names </td>
    <td>acad_from</td>
    <td>acad_to</td>
    <td>institution_name</td>
    <td>study_type</td>
    <td>level</td>
  </tr>
  <?php  $education=0; do{ $education ++; ?>
    <tr>
      <td><?php echo  $education ; ?></td>
      <td><?php echo $row_viewacademic['lastname']; ?>&nbsp;<?php echo $row_viewacademic['firstname']; ?>&nbsp;<?php echo $row_viewacademic['middlename']; ?> </td>
      <td><?php echo $row_viewacademic['acad_from']; ?>&nbsp; </td>
      <td><?php echo $row_viewacademic['acad_to']; ?>&nbsp; </td>
      <td><?php echo $row_viewacademic['institution_name']; ?>&nbsp; </td>
      <td><?php echo $row_viewacademic['study_type']; ?>&nbsp; </td>
      <td><?php echo $row_viewacademic['level']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_viewacademic = mysql_fetch_assoc($viewacademic)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewacademic > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewacademic=%d%s", $currentPage, 0, $queryString_viewacademic); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewacademic > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewacademic=%d%s", $currentPage, max(0, $pageNum_viewacademic - 1), $queryString_viewacademic); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewacademic < $totalPages_viewacademic) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewacademic=%d%s", $currentPage, min($totalPages_viewacademic, $pageNum_viewacademic + 1), $queryString_viewacademic); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewacademic < $totalPages_viewacademic) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewacademic=%d%s", $currentPage, $totalPages_viewacademic, $queryString_viewacademic); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewacademic + 1) ?> to <?php echo min($startRow_viewacademic + $maxRows_viewacademic, $totalRows_viewacademic) ?> of <?php echo $totalRows_viewacademic ?>
</body>
</html>
<?php
mysql_free_result($addacademic);

mysql_free_result($viewacademic);

mysql_free_result($editacademic);

mysql_free_result($addmember);
?>
