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

if ((isset($_POST["saveobjective"]))) {
  $insertSQL = sprintf("INSERT INTO church_objective (objectives_id, objective_name, date_stipulated, date_achieved, department_id) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['objectives_id'], "int"),
                       GetSQLValueString($_POST['objective_name'], "text"),
                       GetSQLValueString($_POST['date_stipulated'], "text"),
                       GetSQLValueString($_POST['date_achieved'], "text"),
                       GetSQLValueString($_POST['department_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["updateobjective"]))) {
  $updateSQL = sprintf("UPDATE church_objective SET objective_name=%s, date_stipulated=%s, date_achieved=%s, department_id=%s WHERE objectives_id=".$_GET['objectives_id']."",
                       GetSQLValueString($_POST['objective_name'], "text"),
                       GetSQLValueString($_POST['date_stipulated'], "text"),
                       GetSQLValueString($_POST['date_achieved'], "text"),
                       GetSQLValueString($_POST['department_id'], "int"),
                       GetSQLValueString($_POST['objectives_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

mysql_select_db($database_church, $church);
$query_addobjective = "SELECT * FROM church_objective";
$addobjective = mysql_query($query_addobjective, $church) or die(mysql_error());
$row_addobjective = mysql_fetch_assoc($addobjective);
$totalRows_addobjective = mysql_num_rows($addobjective);

mysql_select_db($database_church, $church);
$query_editobjective = "SELECT * FROM church_objective";
$editobjective = mysql_query($query_editobjective, $church) or die(mysql_error());
$row_editobjective = mysql_fetch_assoc($editobjective);
$totalRows_editobjective = mysql_num_rows($editobjective);

$maxRows_viewobjective = 10;
$pageNum_viewobjective = 0;
if (isset($_GET['pageNum_viewobjective'])) {
  $pageNum_viewobjective = $_GET['pageNum_viewobjective'];
}
$startRow_viewobjective = $pageNum_viewobjective * $maxRows_viewobjective;

mysql_select_db($database_church, $church);
$query_viewobjective = "SELECT * FROM church_objective";
$query_limit_viewobjective = sprintf("%s LIMIT %d, %d", $query_viewobjective, $startRow_viewobjective, $maxRows_viewobjective);
$viewobjective = mysql_query($query_limit_viewobjective, $church) or die(mysql_error());
$row_viewobjective = mysql_fetch_assoc($viewobjective);

if (isset($_GET['totalRows_viewobjective'])) {
  $totalRows_viewobjective = $_GET['totalRows_viewobjective'];
} else {
  $all_viewobjective = mysql_query($query_viewobjective);
  $totalRows_viewobjective = mysql_num_rows($all_viewobjective);
}
$totalPages_viewobjective = ceil($totalRows_viewobjective/$maxRows_viewobjective)-1;

$queryString_viewobjective = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewobjective") == false && 
        stristr($param, "totalRows_viewobjective") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewobjective = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewobjective = sprintf("&totalRows_viewobjective=%d%s", $totalRows_viewobjective, $queryString_viewobjective);





$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["savedepartment"]))) {
  $insertSQL = sprintf("INSERT INTO departments (department_id, department_name, department_head, department_objective) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['department_id'], "int"),
                       GetSQLValueString($_POST['department_name'], "text"),
                       GetSQLValueString($_POST['department_head'], "text"),
                       GetSQLValueString($_POST['department_objective'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["updatedepartment"]))) {
  $updateSQL = sprintf("UPDATE departments SET department_name=%s, department_head=%s, department_objective=%s WHERE department_id=".$_GET['department_id']."",
                       GetSQLValueString($_POST['department_name'], "text"),
                       GetSQLValueString($_POST['department_head'], "text"),
                       GetSQLValueString($_POST['department_objective'], "text"),
                       GetSQLValueString($_POST['department_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
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
<title>MEMBER DETAILS</title>
<link type="text/css" href="/st_peters/js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />

<script type="text/javascript" src="/st_peters/js/jquery-ui/jquery-1.4.2.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.sortable.js"></script>
	<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.effects.blind.js"></script>
<script src="/st_peters/SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="/st_peters/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link type="text/css" href="/st_peters/js/jquery-ui/demos/demos.css" rel="stylesheet" />





<script type="text/javascript">
	$(function() {
		$('#admissiondate').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
			
		});
		$('#dateofbirth').datepicker({
		  
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#fire').datepicker({
            //minDate: '+120m',	  
	         //   minDate: new Date(), 

			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob2').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob3').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob3').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob4').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#trainfrom').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#trainto').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#promodate').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#awarddate').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#acad_from').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#acad_to').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#emp_from').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#emp_to').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		

	});
	</script>
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs().find(".ui-tabs-nav").sortable({axis:'x'});
	});
	</script>
<link href="/st_peters/SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="/st_peters/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

</head><div class="mainbodyview">
<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Objective_name:</td>
      <td><input type="text" name="objective_name" value="<?php echo htmlentities($row_editobjective['objective_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date_stipulated:</td>
      <td><input type="text" name="date_stipulated" id="date_stipulated" value="<?php echo htmlentities($row_editobjective['date_stipulated'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date_achieved:</td>
      <td><input type="text" name="date_achieved" id="date_achieved" value="<?php echo htmlentities($row_editobjective['date_achieved'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Department_id:</td>
      <td><input type="text" name="department_id" value="<?php echo htmlentities($row_editobjective['department_id'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
   <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['objectives_id'])) &&($_GET['objectives_id']!="")) {?><input type="submit" value="Update" name="updateobjective"><?php } else  {?><input type="submit" value="Save" name="saveobjective"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>
    <td>No</td>
    <td>objective_name</td>
    <td>date_stipulated</td>
    <td>date_achieved</td>
    <td>department_id</td>
  </tr>
  <?php $objective=0; do { $objective++;?>
    <tr>
      <td><?php echo $objective ; ?></td>
      <td><?php echo $row_viewobjective['objective_name']; ?>&nbsp; </td>
      <td><?php echo $row_viewobjective['date_stipulated']; ?>&nbsp; </td>
      <td><?php echo $row_viewobjective['date_achieved']; ?>&nbsp; </td>
      <td><?php echo $row_viewobjective['department_id']; ?>&nbsp; </td>
    </tr>
    <?php } while ($row_viewobjective = mysql_fetch_assoc($viewobjective)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewobjective > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewobjective=%d%s", $currentPage, 0, $queryString_viewobjective); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewobjective > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewobjective=%d%s", $currentPage, max(0, $pageNum_viewobjective - 1), $queryString_viewobjective); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewobjective < $totalPages_viewobjective) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewobjective=%d%s", $currentPage, min($totalPages_viewobjective, $pageNum_viewobjective + 1), $queryString_viewobjective); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewobjective < $totalPages_viewobjective) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewobjective=%d%s", $currentPage, $totalPages_viewobjective, $queryString_viewobjective); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewobjective + 1) ?> to <?php echo min($startRow_viewobjective + $maxRows_viewobjective, $totalRows_viewobjective) ?> of <?php echo $totalRows_viewobjective ?>
</body>
</html>

