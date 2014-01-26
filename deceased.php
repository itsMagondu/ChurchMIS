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

if ((isset($_POST["save"]))) {
  $insertSQL = sprintf("INSERT INTO departed (departedid, memberid, deathcert_no, `date`, cause) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['departedid'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['deathcert_no'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['cause'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["update"]))) {
	
	if(isset($_GET['departedid']) && ($_GET['departedid']!="")){	
  $updateSQL = sprintf("UPDATE departed SET memberid=%s, deathcert_no=%s, `date`=%s, cause=%s WHERE departedid=".($_GET['departedid'])."",
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['deathcert_no'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['cause'], "text"),
                       GetSQLValueString($_POST['departedid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

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
$query_adddeceased = "SELECT * FROM departed";
$adddeceased = mysql_query($query_adddeceased, $church) or die(mysql_error());
$row_adddeceased = mysql_fetch_assoc($adddeceased);
$totalRows_adddeceased = mysql_num_rows($adddeceased);

mysql_select_db($database_church, $church);
$query_editdeceased = "SELECT * FROM departed";
$editdeceased = mysql_query($query_editdeceased, $church) or die(mysql_error());
$row_editdeceased = mysql_fetch_assoc($editdeceased);
$totalRows_editdeceased = mysql_num_rows($editdeceased);

$maxRows_viewdeceased = 50;
$pageNum_viewdeceased = 0;
if (isset($_GET['pageNum_viewdeceased'])) {
  $pageNum_viewdeceased = $_GET['pageNum_viewdeceased'];
}
$startRow_viewdeceased = $pageNum_viewdeceased * $maxRows_viewdeceased;

mysql_select_db($database_church, $church);
$query_viewdeceased = "SELECT * FROM departed";
$query_limit_viewdeceased = sprintf("%s LIMIT %d, %d", $query_viewdeceased, $startRow_viewdeceased, $maxRows_viewdeceased);
$viewdeceased = mysql_query($query_limit_viewdeceased, $church) or die(mysql_error());
$row_viewdeceased = mysql_fetch_assoc($viewdeceased);

if (isset($_GET['totalRows_viewdeceased'])) {
  $totalRows_viewdeceased = $_GET['totalRows_viewdeceased'];
} else {
  $all_viewdeceased = mysql_query($query_viewdeceased);
  $totalRows_viewdeceased = mysql_num_rows($all_viewdeceased);
}
$totalPages_viewdeceased = ceil($totalRows_viewdeceased/$maxRows_viewdeceased)-1;

$queryString_viewdeceased = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewdeceased") == false && 
        stristr($param, "totalRows_viewdeceased") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewdeceased = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewdeceased = sprintf("&totalRows_viewdeceased=%d%s", $totalRows_viewdeceased, $queryString_viewdeceased);
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
      <td><select name="memberid">
      
      <option value="-1">Select Deceased</option>
      
        <?php 
do {  
?>
        <option value="<?php echo $row_addmember['memberid']?>" ><?php echo $row_addmember['memberid']?></option>
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));
?>
      </select></td>
    </tr>
    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Leader:</td>
      <td><select name="leaderid">
      
      <option value="-1">Select Leader</option>
        <?php 
do {  
?>
        <option value="<?php echo $row_addleader['leaderid']?>" ><?php echo $row_addleader['memberid']?></option>
        <?php
} while ($row_addleader = mysql_fetch_assoc($addleader));
?>
      </select></td>
    </tr>  
    
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Deathcert_no:</td>
      <td><input type="text" name="deathcert_no" value="<?php echo htmlentities($row_editdeceased['deathcert_no'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date:</td>
      <td><input type="text" name="date" value="<?php echo htmlentities($row_editdeceased['date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cause:</td>
      <td><textarea  type="text" name="cause" value="<?php echo htmlentities($row_editdeceased['cause'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></textarea></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['departedid'])) &&($_GET['departedid']!="")) {?><input type="submit" value="Update"   name="update"><?php } else  {?><input type="submit" value="Save"    name="save"><?php }?>
      </td>
    </tr>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />  
  <table border="1" align="center">
    <tr>
      <td>No</td>
      <td>member</td>
       <td>Leader</td>
      <td>deathcert_no</td>
      <td>date</td>
      <td>cause</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php do { $deceasednum ++ ; ?>
      <tr>
        <td><?php  echo $deceasednum; ?></td>
        <td><?php echo $row_viewdeceased['middlename']; ?>&nbsp;<?php echo $row_viewdeceased['firstname']; ?>&nbsp;<?php echo $row_viewdeceased['lastname']; ?> </td>
          <td><?php echo $row_viewdeceased['middlename']; ?>&nbsp;<?php echo $row_viewdeceased['firstname']; ?>&nbsp;<?php echo $row_viewdeceased['lastname']; ?> </td>
        
        <td><?php echo $row_viewdeceased['deathcert_no']; ?>&nbsp; </td>
        <td><?php echo $row_viewdeceased['date']; ?>&nbsp; </td>
        <td><?php echo $row_viewdeceased['cause']; ?>&nbsp; </td>
            <td><a href="index.php?leader=show&leaderid=<?php echo $row_viewdeceased['departedid']; ?>& #tabs-5"> Edit </a></td> 
            
       <td><a href="index.php?leader=show & leaderid=<?php echo $row_viewdeceased['departedid'];?> & Delete=1 &#tabs-5" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
      </tr>
      <?php } while ($row_viewdeceased = mysql_fetch_assoc($viewdeceased)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewdeceased > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewdeceased=%d%s", $currentPage, 0, $queryString_viewdeceased); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewdeceased > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewdeceased=%d%s", $currentPage, max(0, $pageNum_viewdeceased - 1), $queryString_viewdeceased); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewdeceased < $totalPages_viewdeceased) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewdeceased=%d%s", $currentPage, min($totalPages_viewdeceased, $pageNum_viewdeceased + 1), $queryString_viewdeceased); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewdeceased < $totalPages_viewdeceased) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewdeceased=%d%s", $currentPage, $totalPages_viewdeceased, $queryString_viewdeceased); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewdeceased + 1) ?> to <?php echo min($startRow_viewdeceased + $maxRows_viewdeceased, $totalRows_viewdeceased) ?> of <?php echo $totalRows_viewdeceased ?>
</p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($addmember);

mysql_free_result($adddeceased);

mysql_free_result($editdeceased);

mysql_free_result($viewdeceased);
?>
