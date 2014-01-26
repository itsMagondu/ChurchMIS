<?php 
if(!isset($_SESSION))
{
session_start();
} 
require_once('Connections/church.php');
require_once('functions.php');  ?>
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
	
		
	$tab="index.php?leader=true#tabs-1";
	$whereto=$tab;	
	
	
  $insertSQL = sprintf("INSERT INTO role (roleid, rolename, roledescription) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['roleid'], "int"),
                       GetSQLValueString($_POST['rolename'], "text"),
                       GetSQLValueString($_POST['roledescription'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}

if ((isset($_POST["updaterole"]))) {
	if(isset($_GET['roleid']) && ($_GET['roleid']!="")){
		
		$tab="index.php?leader=true#tabs-1";
	$whereto=$tab;
		
  $updateSQL = sprintf("UPDATE role SET rolename=%s, roledescription=%s WHERE roleid=".$_GET['roleid']."",
                       GetSQLValueString($_POST['rolename'], "text"),
                       GetSQLValueString($_POST['roledescription'], "text"),
                       GetSQLValueString($_POST['roleid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}
}

mysql_select_db($database_church, $church);
$query_addrole = "SELECT  r.roleid,r.rolename FROM role r";
$addrole = mysql_query($query_addrole, $church) or die(mysql_error());
$row_addrole = mysql_fetch_assoc($addrole);
$totalRows_addrole = mysql_num_rows($addrole);


if ((isset($_GET['Delete']) &&(isset($_GET['roleid'])) && ($_GET['roleid'] != ""))) {
	
	   $tab="index.php?leader=true#tabs-1";
	$whereto=$tab;	
	
	
  $deleteSQL = sprintf("DELETE FROM role WHERE roleid=".($_GET['roleid'])."", 
                       GetSQLValueString($_GET['roleid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}



if((isset($_GET['roleid'])) && ($_GET['roleid']!="")){
mysql_select_db($database_church, $church);
$query_editroles = "SELECT * FROM role r WHERE r.roleid=".$_GET['roleid']."" ;
$editroles = mysql_query($query_editroles, $church) or die(mysql_error());
$row_editroles = mysql_fetch_assoc($editroles);
$totalRows_editroles = mysql_num_rows($editroles);
}
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


if ((isset($_POST["saveleader"]))) {
	
		$tab="index.php?leader=true#tabs-2";
	$whereto=$tab;
	
	
$password=md5($_POST['password']);	
$insertSQL = sprintf("INSERT INTO leader (leaderid, memberid,user_name,password,email_address, roleid, comission_date,end_date) VALUES (%s, %s, %s, %s,%s,%s,%s,%s)",
                       GetSQLValueString($_POST['leaderid'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
					    GetSQLValueString($_POST['user_name'], "text"),
						GetSQLValueString($password, "text"),
					    GetSQLValueString($_POST['email_address'], "text"),
                       GetSQLValueString($_POST['roleid'], "int"),
                       GetSQLValueString($_POST['comission_date'], "text"),
					    GetSQLValueString($_POST['end_date'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}

if ((isset($_POST["updateleader"]))) {
	
	$tab="index.php?leader=true#tabs-2";
	$whereto=$tab;
	
if(isset($_GET['leaderid']) && ($_GET['leaderid']!="")){
	
	
	
  $updateSQL = sprintf("UPDATE leader SET memberid=%s, user_name=%s,password=%s,email_address=%s,roleid=%s, comission_date=%s,end_date=%s WHERE leaderid=".$_GET['leaderid']."",
  
                       GetSQLValueString($_POST['memberid'], "int"),
					   GetSQLValueString($_POST['user_name'], "text"),
					    GetSQLValueString($password, "text"),
						GetSQLValueString($_POST['email_address'], "text"),
                       GetSQLValueString($_POST['roleid'], "int"),
                       GetSQLValueString($_POST['comission_date'], "text"),
					    GetSQLValueString($_POST['end_date'], "text"),
                       GetSQLValueString($_POST['leaderid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}
}

mysql_select_db($database_church, $church);
$query_addleader = "SELECT * FROM leader";
$addleader = mysql_query($query_addleader, $church) or die(mysql_error());
$row_addleader = mysql_fetch_assoc($addleader);
$totalRows_addleader = mysql_num_rows($addleader);

$maxRows_viewleader = 20;
$pageNum_viewleader = 0;
if (isset($_GET['pageNum_viewleader'])) {
  $pageNum_viewleader = $_GET['pageNum_viewleader'];
}
$startRow_viewleader = $pageNum_viewleader * $maxRows_viewleader;

mysql_select_db($database_church, $church);
$query_viewleader = "SELECT * FROM leader l INNER JOIN member_details md ON md.memberid=l.memberid LEFT JOIN role r ON r.roleid=l.roleid";
$query_limit_viewleader = sprintf("%s LIMIT %d, %d", $query_viewleader, $startRow_viewleader, $maxRows_viewleader);
$viewleader = mysql_query($query_limit_viewleader, $church) or die(mysql_error());
$row_viewleader = mysql_fetch_assoc($viewleader);

if (isset($_GET['totalRows_viewleader'])) {
  $totalRows_viewleader = $_GET['totalRows_viewleader'];
} else {
  $all_viewleader = mysql_query($query_viewleader);
  $totalRows_viewleader = mysql_num_rows($all_viewleader);
}
$totalPages_viewleader = ceil($totalRows_viewleader/$maxRows_viewleader)-1;

if((isset($_GET['leaderid'])) && ($_GET['leaderid']!="")){
mysql_select_db($database_church, $church);
$query_editleader = "SELECT * FROM leader l INNER JOIN member_details md ON md.memberid=l.memberid LEFT JOIN role r ON r.roleid=l.roleid WHERE leaderid=".$_GET['leaderid']."";
$editleader = mysql_query($query_editleader, $church) or die(mysql_error());
$row_editleader = mysql_fetch_assoc($editleader);
$totalRows_editleader = mysql_num_rows($editleader);

}

mysql_select_db($database_church, $church);
$query_addmember = "SELECT m.memberid,m.lastname,m.middlename,m.firstname FROM member_details m";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

mysql_select_db($database_church, $church);
$query_addrole = "SELECT  r.roleid,r.rolename FROM role r";
$addrole = mysql_query($query_addrole, $church) or die(mysql_error());
$row_addrole = mysql_fetch_assoc($addrole);
$totalRows_addrole = mysql_num_rows($addrole);

$queryString_viewleader = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewleader") == false && 
        stristr($param, "totalRows_viewleader") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewleader = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewleader = sprintf("&totalRows_viewleader=%d%s", $totalRows_viewleader, $queryString_viewleader);






?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Leadership</title>
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
<link type="text/css" href="/st_peters/assets/css/tablecloth.css" rel="stylesheet"/>
<link type="text/css" href="/st_peters/assets/css/bootstrap-tables.css" rel="stylesheet"/>
<link type="text/css" href="/st_peters/assets/css/bootstrap.css" rel="stylesheet"/>
<link type="text/javascript" href="/st_peters/assets/js/bootstrap.js" />
<link type="text/javascript" href="tms.css"/>

<script type="text/javascript">
	$(function() {
		$('#comission_date').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
			
		});
		$('#firstconfirmationdate').datepicker({
			inline: true,
            //minDate: new Date(), 
            //maxDate: '-120m',	  
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#secondconfirmation').datepicker({
            //minDate: '+120m',	  
	         //   minDate: new Date(), 

			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#marriage').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#end_date').datepicker({
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
		
		
		

	});
	</script>
            <script type="text/javascript">
	$(function() {
		$("#tabs").tabs().find(".ui-tabs-nav").sortable({axis:'x'});
	});
	</script>
    <link href="/st_peters/SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="bodytext">
<div id="tabs">
<ul>
		<li><a href="#tabs-1">Role Stipulation</a></li>
		<li><a href="#tabs-2">Leader Assignment</a></li>
	

</ul>

	<div id="tabs-1">
    
    
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Role Name:</td>
      <td><input type="text" name="rolename" value="<?php echo htmlentities($row_editroles['rolename'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" Valign="top">Role Description:</td>
      <td>
       <textarea name="roledescription" id="roledescription" cols="45" rows="5"><?php echo $row_editroles['roledescription'] ?></textarea>
      
      
      </td>
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
        <td width="2%">No</td>
       <td width="10%">Role name</td>
      <td width="15%">Role Description</td>
      <td width="4%">&nbsp;</td>
      <td width="4%">&nbsp;</td>
    </tr>
    <?php do { $numroles ++; ?>
      <tr>
        <td><?php echo $numroles;  ?></td>
        <td><?php echo $row_viewroles['rolename']; ?>&nbsp; </td>
        <td class="maxwidthcomment"><?php echo $row_viewroles['roledescription']; ?></td>
               
           <td><a href="index.php?leader=show&roleid=<?php echo $row_viewroles['roleid']; ?>& #tabs-1"> Edit </a></td> 
           
 <td><a href="index.php?leader=show&roleid=<?php echo $row_viewroles['roleid'];?> & Delete=1 &#tabs-1" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td> 
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
    
    
    
    
    
    
    
    </div>

<div id="tabs-2">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="mainbodyview">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member:</td>
      <td><input name="memberid" value="<?php echo $row_editleader['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['leaderid'])) && ($_GET['leaderid'] != "")){ echo $row_editleader['lastname'] ;?>&nbsp;<?php echo $row_editleader['middlename'] ;?> &nbsp;<?php echo $row_editleader['firstname'] ; } else {?>
      <select name="memberid" selected="selected">  
      <option value="-1" <?php if (!(strcmp(-1, $row_editleader['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>
  <?php
do {  
?>
  <option  size="32"value="<?php echo $row_addmember['memberid']?>"><?php echo $row_addmember['lastname']?>&nbsp;<?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?></option>
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember ));
  $rows = mysql_num_rows($addmember );
  if($rows > 0) {
      mysql_data_seek($addmember , 0);
	  $row_addmember = mysql_fetch_assoc($addmember );
  }
?>         
</select><?php }?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Role:</td>
      <td><span id="spryselect1">
        <select name="roleid" selected="selected">
          <option value="-1" <?php if (!(strcmp(-1, $row_editleader['leaderid']))) {echo "selected=\"selected\"";} ?> >Select Role</option>
          <?php
do {  
?>
            <option value="<?php echo $row_addrole['roleid']?>"<?php if (!(strcmp($row_addrole['roleid'], $row_editleader['leaderid']))) {echo "selected=\"selected\"";} ?>> <?php echo $row_addrole['rolename']?></option> 
          
          
          
          <?php
} while ($row_addrole = mysql_fetch_assoc($addrole ));
  $rows = mysql_num_rows($addrole );
  if($rows > 0) {
      mysql_data_seek($addrole , 0);
	  $row_addrole = mysql_fetch_assoc($addrole );
  }
?>
        </select>
        <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">user_name:</td>
      <td><input type="text" name="user_name" id="user_name" value="<?php echo htmlentities($row_editleader['user_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr> 
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">password:</td>
      <td><input type="password" name="password" id="password" value="<?php echo htmlentities($row_editleader['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email Address:</td>
      <td><input type="email" name="email_address" id="email_address" value="<?php echo htmlentities($row_editleader['email_address'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr> 
     
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Commission_date:</td>
      <td><input type="text" name="comission_date" id="comission_date" value="<?php echo htmlentities($row_editleader['comission_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Termination_date:</td>
      <td><input type="text" name="end_date" id="end_date" value="<?php echo htmlentities($row_editleader['end_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
        <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['leaderid'])) &&($_GET['leaderid']!="")) {?><input type="submit" value="Update" name="updateleader"><?php } else  {?><input type="submit" value="Save" name="saveleader"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center">
    <tr>
       <td width="2%">No</td>
     <td width="10%">Full Names</td>
      <td width="10%">User Name</td>
      <td width="10%">Roles Name</td>
      <td width="10%">Comission Date</td>
      <td width="10%">Retirement Date</td>
       <td width="10%">Status</td>
      <td width="2%">&nbsp;</td>
       <td width="2%">&nbsp;</td>
    </tr>
    	<?php $todaydate=date("Y-m-d");?>
    
    <?php echo $todaydate;  ?>
    <?php do { $numleader ++;?>
      <tr>
        <td><?php echo $numleader;  ?></td>
        <td><?php echo $row_viewleader['firstname']; ?>&nbsp;<?php echo $row_viewleader['middlename']; ?>&nbsp;<?php echo $row_viewleader['lastname']; ?> </td>
        <td><?php echo $row_viewleader['user_name']; ?>&nbsp; </td>
        <td><?php echo $row_viewleader['rolename']; ?>&nbsp; </td>
        <td><?php echo $row_viewleader['comission_date']; ?>&nbsp; </td>
        <td><?php echo $row_viewleader['end_date']; ?>&nbsp; </td>
        <td><?php echo  $status ;
		if($row_viewleader['comission_date']!='' && $row_viewleader['end_date']< $todaydate){echo $status="<b> <font color='#FF0000'>".'Active'."</b></font>";} else  
		  { echo $status="<b> <font color='#FF0000'>".'Inctive'."</b></font>";}  
		?>
    </td>
          <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']==' clerk'))){ 
  ?>
 <td><a href="index.php?leader=show&leaderid=<?php echo $row_viewleader['leaderid']; ?>& #tabs-2"> Edit </a></td> 
      <?php }?>     
 <td><a href="index.php?leader=show & leaderid=<?php echo $row_viewleader['leaderid'];?> & Delete=1 &#tabs-2" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td> 
 
 
      </tr>
      <?php } while ($row_viewleader = mysql_fetch_assoc($viewleader)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewleader > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewleader=%d%s", $currentPage, 0, $queryString_viewleader); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewleader > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewleader=%d%s", $currentPage, max(0, $pageNum_viewleader - 1), $queryString_viewleader); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewleader < $totalPages_viewleader) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewleader=%d%s", $currentPage, min($totalPages_viewleader, $pageNum_viewleader + 1), $queryString_viewleader); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewleader < $totalPages_viewleader) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewleader=%d%s", $currentPage, $totalPages_viewleader, $queryString_viewleader); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewleader + 1) ?> to <?php echo min($startRow_viewleader + $maxRows_viewleader, $totalRows_viewleader) ?> of <?php echo $totalRows_viewleader ?>
</form>  
    
    </div>
    </div>
    </div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>
<?php
mysql_free_result($addleader);

mysql_free_result($viewleader);

mysql_free_result($editleader);

mysql_free_result($addmember);

mysql_free_result($addrole);
?>
