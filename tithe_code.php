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

if ((isset($_POST["savetithe"]))) {
	$tab="index.php?tithe=true#tabs-1";
	$whereto=$tab;	
  $insertSQL = sprintf("INSERT INTO tithe (titheid, memberid, leaderid, `date`, amount) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['titheid'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['leaderid'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['amount'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
    header("Location:$whereto");
}

if ((isset($_POST["updatetithe"]))) {
	
	   if ((isset($_GET['titheid'])) && ($_GET['titheid']!="")){
  $updateSQL = sprintf("UPDATE tithe SET memberid=%s, leaderid=%s, `date`=%s, amount=%s WHERE titheid=".$_GET['titheid']."",
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['leaderid'], "int"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['amount'], "text"),
                       GetSQLValueString($_POST['titheid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
     header("Location:$whereto");
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
$query_addtithe = "SELECT * FROM tithe";
$addtithe = mysql_query($query_addtithe, $church) or die(mysql_error());
$row_addtithe = mysql_fetch_assoc($addtithe);
$totalRows_addtithe = mysql_num_rows($addtithe);

mysql_select_db($database_church, $church);
$query_edittithe = "SELECT * FROM tithe";
$edittithe = mysql_query($query_edittithe, $church) or die(mysql_error());
$row_edittithe = mysql_fetch_assoc($edittithe);
$totalRows_edittithe = mysql_num_rows($edittithe);

$maxRows_viewtithe = 10;
$pageNum_viewtithe = 0;
if (isset($_GET['pageNum_viewtithe'])) {
  $pageNum_viewtithe = $_GET['pageNum_viewtithe'];
}
$startRow_viewtithe = $pageNum_viewtithe * $maxRows_viewtithe;

mysql_select_db($database_church, $church);
$query_viewtithe = "SELECT * FROM tithe";
$query_limit_viewtithe = sprintf("%s LIMIT %d, %d", $query_viewtithe, $startRow_viewtithe, $maxRows_viewtithe);
$viewtithe = mysql_query($query_limit_viewtithe, $church) or die(mysql_error());
$row_viewtithe = mysql_fetch_assoc($viewtithe);

if (isset($_GET['totalRows_viewtithe'])) {
  $totalRows_viewtithe = $_GET['totalRows_viewtithe'];
} else {
  $all_viewtithe = mysql_query($query_viewtithe);
  $totalRows_viewtithe = mysql_num_rows($all_viewtithe);
}
$totalPages_viewtithe = ceil($totalRows_viewtithe/$maxRows_viewtithe)-1;

$queryString_viewtithe = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewtithe") == false && 
        stristr($param, "totalRows_viewtithe") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewtithe = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewtithe = sprintf("&totalRows_viewtithe=%d%s", $totalRows_viewtithe, $queryString_viewtithe);
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
        <td nowrap="nowrap" align="right">Member Names </td>
        <td><input name="levelId" value="<?php echo $row_viewStndDetails['levelId']; ?>" type="hidden" />
          <?php if ((isset($_GET['memberid'])) && ($_GET['memberid'] != "")){ echo $row_edittithe['memberid'] ; } else { ?>
   
       <?php echo $row_viewmemeber['firstname']; ?>&nbsp;<?php echo $row_viewmemeber['middlename']; ?>&nbsp;<?php echo $row_viewmemeber['lastname']; ?> </td>  
          
          
          <?php } ?></td>
      </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Amount:</td>
      <td><input type="text" name="amount" id="amount" value="<?php echo htmlentities($row_edittithe['amount'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Leader:</td>
      <td><select name="leaderid">
           <select name="leaderid" selected="selected">
       <option value="-1"  <?php if (!(strcmp(-1,$row_edittithe['titheid']))) {echo "selected=\"selected\"";} ?>>Select Leader</option>
      
        <?php 
do {  
?>
        <option value="<?php echo $row_addleader['leaderid']?>" ><?php echo $row_addleader['leaderid']?></option>
        <?php
} while ($row_addleader = mysql_fetch_assoc($addleader));
?>
      </select></td>
    </tr>
    
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date:</td>
      <td><input type="text" name="date" value="<?php echo htmlentities($row_edittithe['date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
     <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['titheid'])) &&($_GET['titheid']!="")) {?><input type="submit" value="Update" name="updatetithe"><?php } else  {?><input type="submit" value="Save" name="savetithe"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center">
    <tr>
      <td>No</td>
      <td>memberid</td>
      <td>leaderid</td>
      <td>date</td>
      <td>amount</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <?php do { $rownum++; ?>
      <tr>
        <td><?php $rownum; ?></td>
        <td><?php echo $row_viewtithe['memberid']; ?>&nbsp; </td>
        <td><?php echo $row_viewtithe['leaderid']; ?>&nbsp; </td>
        <td><?php echo $row_viewtithe['date']; ?>&nbsp; </td>
        <td><?php echo $row_viewtithe['amount']; ?>&nbsp; </td>
         <td><a href="index.php?tithe=show&titheid=<?php echo $row_viewtithe['titheid']; ?>& #tabs-1">Edit </a></td>
                  
   <td><a href="index.php?tithe=show &titheid=<?php echo $row_viewtithe['church_service_id'];?> & Delete=1 &#tabs-1" onClick="return confirm('Are you sure you want to delete?')">Delete </a></td>
        
      </tr>
      <?php } while ($row_viewtithe = mysql_fetch_assoc($viewtithe)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewtithe > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewtithe=%d%s", $currentPage, 0, $queryString_viewtithe); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewtithe > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewtithe=%d%s", $currentPage, max(0, $pageNum_viewtithe - 1), $queryString_viewtithe); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewtithe < $totalPages_viewtithe) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewtithe=%d%s", $currentPage, min($totalPages_viewtithe, $pageNum_viewtithe + 1), $queryString_viewtithe); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewtithe < $totalPages_viewtithe) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewtithe=%d%s", $currentPage, $totalPages_viewtithe, $queryString_viewtithe); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewtithe + 1) ?> to <?php echo min($startRow_viewtithe + $maxRows_viewtithe, $totalRows_viewtithe) ?> of <?php echo $totalRows_viewtithe ?>
</form>

</body>
</html>
<?php
mysql_free_result($addmember);

mysql_free_result($addleader);

mysql_free_result($addtithe);

mysql_free_result($edittithe);

mysql_free_result($viewtithe);
?>
