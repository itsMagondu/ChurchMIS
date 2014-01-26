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

if ((isset($_POST["savedepartment"]))) {
	
	 $tab="index.php?church=true#tabs-3";
	$whereto=$tab;
	
	
  $insertSQL = sprintf("INSERT INTO departments (department_id, department_name, department_head, department_objective) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['department_id'], "int"),
                       GetSQLValueString($_POST['department_name'], "text"),
                       GetSQLValueString($_POST['department_head'], "text"),
                       GetSQLValueString($_POST['department_objective'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}

if ((isset($_POST["updatedepartment"]))) {
	
	 $tab="index.php?church=true#tabs-3";
	$whereto=$tab;
	
	 if ((isset($_GET['memberid'])) && ($_GET['memberid']!="")){
  $updateSQL = sprintf("UPDATE departments SET department_name=%s, department_head=%s, department_objective=%s WHERE department_id=".$_GET['department_id']."",
                       GetSQLValueString($_POST['department_name'], "text"),
                       GetSQLValueString($_POST['department_head'], "text"),
                       GetSQLValueString($_POST['department_objective'], "text"),
                       GetSQLValueString($_POST['department_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());

     header("Location:$whereto");
}


}
mysql_select_db($database_church, $church);
$query_adddeparrtment = "SELECT * FROM departments";
$adddeparrtment = mysql_query($query_adddeparrtment, $church) or die(mysql_error());
$row_adddeparrtment = mysql_fetch_assoc($adddeparrtment);
$totalRows_adddeparrtment = mysql_num_rows($adddeparrtment);

mysql_select_db($database_church, $church);
$query_editdepartment = "SELECT * FROM departments";
$editdepartment = mysql_query($query_editdepartment, $church) or die(mysql_error());
$row_editdepartment = mysql_fetch_assoc($editdepartment);
$totalRows_editdepartment = mysql_num_rows($editdepartment);

$maxRows_viewdepartment = 10;
$pageNum_viewdepartment = 0;
if (isset($_GET['pageNum_viewdepartment'])) {
  $pageNum_viewdepartment = $_GET['pageNum_viewdepartment'];
}
$startRow_viewdepartment = $pageNum_viewdepartment * $maxRows_viewdepartment;

mysql_select_db($database_church, $church);
$query_viewdepartment = "SELECT * FROM departments";
$query_limit_viewdepartment = sprintf("%s LIMIT %d, %d", $query_viewdepartment, $startRow_viewdepartment, $maxRows_viewdepartment);
$viewdepartment = mysql_query($query_limit_viewdepartment, $church) or die(mysql_error());
$row_viewdepartment = mysql_fetch_assoc($viewdepartment);

if (isset($_GET['totalRows_viewdepartment'])) {
  $totalRows_viewdepartment = $_GET['totalRows_viewdepartment'];
} else {
  $all_viewdepartment = mysql_query($query_viewdepartment);
  $totalRows_viewdepartment = mysql_num_rows($all_viewdepartment);
}
$totalPages_viewdepartment = ceil($totalRows_viewdepartment/$maxRows_viewdepartment)-1;

$queryString_viewdepartment = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewdepartment") == false && 
        stristr($param, "totalRows_viewdepartment") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewdepartment = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewdepartment = sprintf("&totalRows_viewdepartment=%d%s", $totalRows_viewdepartment, $queryString_viewdepartment);



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
      <td nowrap="nowrap" align="right">Department Name:</td>
      <td><input type="text" name="department_name" value="<?php echo htmlentities($row_editdepartment['department_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Department Head:</td>
       
        <?php mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
      <td>
      <input name="memberid" value="<?php echo $row_editdepartment['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['contactid'])) && ($_GET['contactid'] != "")){ echo $row_editdepartment['lastname'] ;?>&nbsp;<?php echo $row_editdepartment['middlename'] ;?> &nbsp;<?php echo $row_editdepartment['firstname'] ; } else {?>
      <select name="memberid" selected="selected">  
      <option value="-1" <?php if (!(strcmp(-1, $row_editdepartment['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>
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
</select><?php }?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Department Objective:</td>
      <td><textarea name="department_objective" id="department_objective" cols="45" rows="5"><?php echo $row_editdepartment['department_objective'] ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['department_id'])) &&($_GET['department_id']!="")) {?><input type="submit" value="Update" name="updatedepartment"><?php } else  {?><input type="submit" value="Save" name="savedepartment"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>
     <td width="2%">No</td>
    <td width="8%">Department Name</td>
    <td width="8%">Department Head</td>
    <td width="8%">Department Objective</td>
     <td width="4%">&nbsp;</td>
     <td width="4%">&nbsp;</td>
  </tr>
  <?php  do { $department++; ?>
    <tr>
      <td><?php echo $department ; ?></td>
      <td><?php echo $row_viewdepartment['department_name']; ?>&nbsp; </td>
      <td><?php echo $row_viewdepartment['department_head']; ?>&nbsp; </td>
      <td><?php echo $row_viewdepartment['department_objective']; ?>&nbsp; </td>
               <td><a href="index.php?church=show&department_id=<?php echo $row_viewdepartment['memberid']; ?>& #tabs-3"> Edit </a></td> 
           
 <td><a href="index.php?church=show & department_id=<?php echo $row_viewdepartment['memberid'];?> & Delete=1 &#tabs-3" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
      
      
    </tr>
    <?php } while ($row_viewdepartment = mysql_fetch_assoc($viewdepartment)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewdepartment > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewdepartment=%d%s", $currentPage, 0, $queryString_viewdepartment); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewdepartment > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewdepartment=%d%s", $currentPage, max(0, $pageNum_viewdepartment - 1), $queryString_viewdepartment); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewdepartment < $totalPages_viewdepartment) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewdepartment=%d%s", $currentPage, min($totalPages_viewdepartment, $pageNum_viewdepartment + 1), $queryString_viewdepartment); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewdepartment < $totalPages_viewdepartment) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewdepartment=%d%s", $currentPage, $totalPages_viewdepartment, $queryString_viewdepartment); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewdepartment + 1) ?> to <?php echo min($startRow_viewdepartment + $maxRows_viewdepartment, $totalRows_viewdepartment) ?> of <?php echo $totalRows_viewdepartment ?>
</body>
</html>
<?php
mysql_free_result($adddeparrtment);

mysql_free_result($editdepartment);

mysql_free_result($viewdepartment);
?>
