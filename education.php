<?php include ('Connections/church.php'); 

checkAdmin();
?>
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

if ((isset($_GET['academics_id'])) && ($_GET['academics_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM academic WHERE academics_id=".$_GET['academics_id']."",
                       GetSQLValueString($_GET['academics_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}






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


if ((isset($_POST["saveprofession"]))) {
	
	$tab="index.php?education=true#tabs-1";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO profession (profession_id, memberid, profession_name, profession_start, profession_end, company_name) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['profession_id'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['profession_name'], "text"),
                       GetSQLValueString($_POST['profession_start'], "text"),
                       GetSQLValueString($_POST['profession_end'], "text"),
                       GetSQLValueString($_POST['company_name'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}

if ((isset($_POST["updateprofession"]))) {
	
	$tab="index.php?education=true#tabs-1";
	$whereto=$tab;
	
	 if ((isset($_GET['profession_id'])) && ($_GET['profession_id']!="")){
  $updateSQL = sprintf("UPDATE profession SET memberid=%s, profession_name=%s, profession_start=%s, profession_end=%s, company_name=%s WHERE profession_id=".$_GET['profession_id']."",
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['profession_name'], "text"),
                       GetSQLValueString($_POST['profession_start'], "text"),
                       GetSQLValueString($_POST['profession_end'], "text"),
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['profession_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
       header("Location:$whereto");
  
}
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


<link type="text/css" href="/st_peters/tms.css" rel="stylesheet" />


<script type="text/javascript">
	$(function() {
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
		$('#profession_start').datepicker({
            //minDate: '+120m',	  
	         //   minDate: new Date(), 

			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#profession_end').datepicker({
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
</head>
<body class="mainbobyview">
<div id="tabs">
<ul>

		<li><a href="#tabs-1">Profession</a></li>
		


</ul>

<div id="tabs-1" class="mainbobyview">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="mainbobyview">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member:</td>
      <?php mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
<td><input name="memberid" value="<?php echo $row_editprofession['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['academics_id'])) && ($_GET['academics_id'] != "")){ echo $row_editprofession['lastname'] ;?>&nbsp;<?php echo $row_editprofession['middlename'] ;?> &nbsp;<?php echo $row_editprofession['firstname'] ; } else {?>
    
     <select name="memberid" selected="selected">  
      <option value="-1" <?php if (!(strcmp(-1, $row_editprofession['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>
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

   <td width="2%">No</td>
    <td width="15%">Member Names </td>
    <td width="15%">Profession Name</td>
    <td width="2%">Status</td>
    <td width="2%">&nbsp;</td>
   <td width="2%">&nbsp;</td>
  </tr>
  <?php $todaydate=date("Y-m-d");?>
  <?php $profession=0; do { $profession++; ?>
    <tr>
      <td><?php echo $profession ;  ?> </a></td>
      <td><?php echo $row_viewprofession['lastname']; ?>&nbsp;<?php echo $row_viewprofession['firstname']; ?>&nbsp;<?php echo $row_viewprofession['middlename']; ?> </td>
      <td><?php echo $row_viewprofession['profession_name']; ?>&nbsp; </td>
      <td><?php echo $status;
	  
	  
	 
	if($row_viewprofession['profession_start']!='' && $row_viewprofession['profession_end']>$todaydate){echo $status="<b> <font color='#FF0000'>".'Inactive'."</b></font>";} else
		  { echo $status="<b> <font color='#FF0000'>".'Active'."</b></font>";} 
		  
		 
		?>
		 </td>
             <td><a href="index.php?education=show&memberid=<?php echo $row_viewprofession['memberid']; ?>& #tabs-1"> Edit </a></td>                 
 
      <td><a href="index.php?education=show&memberid=<?php echo $row_viewprofession['memberid']; ?>& #tabs-1"> Delete </a></td> 
      
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











</div>



</body>
</html>
<?php
mysql_free_result($addacademic);
?>
