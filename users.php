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


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["Save"])) && ($_POST["Save"] == "Save")) {
	$password=md5($_POST['password']);
  $insertSQL = sprintf("INSERT INTO users (username, password,EmailAddress, user_level) VALUES (%s,%s, %s, %s)",
                       GetSQLValueString($_POST['username'], "text"),
					      GetSQLValueString($password, "text"),
				     GetSQLValueString($_POST['EmailAddress'], "text"),  
                       GetSQLValueString($_POST['user_level'], "text"));


  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if (isset($_POST['Update'])) {
	$password=md5($_POST['password']);
  $updateSQL = sprintf("UPDATE users SET username=%s, password=%s,EmailAddress=%s, user_level=%s WHERE user_id=".$_GET['user_id']."",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($password, "text"),
					   GetSQLValueString($_POST['EmailAddress'], "text"),
                       GetSQLValueString($_POST['user_level'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
if ((isset($_POST["Reset"])) && ($_POST["Reset"] == "Reset Password")) {
$password=md5($_POST['password']);
  $updateSQL = sprintf("UPDATE users SET password='$password' WHERE user_id=".$_GET['user_id']."");

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

if (isset($_POST['Delete'])){
  $deleteSQL = sprintf("DELETE FROM users WHERE user_id=%s",
                       GetSQLValueString($_GET['user_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
}

mysql_select_db($database_church, $church);
$query_allusers = "SELECT * FROM users ORDER BY username ASC";
$allusers = mysql_query($query_allusers, $church) or die(mysql_error());
$row_allusers = mysql_fetch_assoc($allusers);
$totalRows_allusers = mysql_num_rows($allusers);

$colname_users = "-1";
if (isset($_GET['user_id'])) {
  $colname_users = $_GET['user_id'];
}
mysql_select_db($database_church, $church);
$query_users = sprintf("SELECT * FROM users WHERE user_id = %s", GetSQLValueString($colname_users, "int"));
$users = mysql_query($query_users, $church) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>USERS</title>




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



<link href="/st_peters/SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />



<script type="text/javascript">
	$(function() {
		$('#date_baptised').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
			
		}); 
		$('#firstconfirmation_date').datepicker({
			inline: true,
            //minDate: new Date(), 
            //maxDate: '-120m',	  
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#secondconfirmation').datepicker({
			inline: true,
            //minDate: new Date(), 
            //maxDate: '-120m',	  
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#marriage_date').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#datedeceased').datepicker({
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
		$('#dateofbirth').datepicker({
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
    <link href="/st_peters/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

</head>
<body>
<div>
<div id="tabs">
<ul>
		<li><a href="#tabs-1">Users</a></li>
		<li><a href="#tabs-2">Logged In Users</a></li>
        <li><a href="#tabs-3">Logged In Admin</a></li>
	
     
</ul>
        </head>

<body>

	<div id="tabs-1"> 
    <form method="POST" name="form" action="<?php echo $editFormAction; ?>">
<table width="100%" border="0" >
  <tr>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="60%" valign="top"><table width="100%" border="0" >
  <tr>
    <td colspan="2" align="center">MANAGING USER</td>
  </tr>
  <tr>
    <td>User Name</td>
    <td><span id="sprytextfield1"><span id="sprytextfield3">
      <label>
        <input type="text" value="<?php echo $row_users['username']; ?>" name="username" id="username" />
      </label>
      <span class="textfieldRequiredMsg">A value is required.</span></span><span class="textfieldRequiredMsg">A value is required.</span></span></td>
  </tr>
  <tr>
    <td>Password</td>
    <td><span id="sprytextfield2"><span id="sprytextfield4">
      <label>
        <input type="password" value="<?php echo $row_users['password']; ?>"  name="password" id="password" />
      </label>
      <span class="textfieldRequiredMsg">A value is required.</span></span><span class="textfieldRequiredMsg">A value is required.</span></span></td>
  </tr>
  
  
    <tr>
    <td>Email Address </td>
    <td><span id="sprytextfiel4d">
      <label>
        <input type="email" value="<?php echo $row_users['EmailAddress']; ?>"  name="EmailAddress" id="EmailAddress" />
      </label>
      <span class="textfieldRequiredMsg">A value is required.</span></span></td>
  </tr>
  
  <tr>
    <td>User Level</td>
    <td><span id="spryselect1">
     
      <span class="selectRequiredMsg">Please select an item.</span></span><span id="spryselect2">
      
          <select name="user_level" id="user_level">
        <option value="secretary" <?php if (!(strcmp("secretary", $row_users['user_level']))) {echo "selected=\"selected\"";} ?>>Secretary</option>
        
        <option value="admin" <?php if (!(strcmp("admin", $row_users['user_level']))) {echo "selected=\"selected\"";} ?>>Administrator</option>
        
          <option value="clerk" <?php if (!(strcmp("clerk", $row_users['user_level']))) {echo "selected=\"selected\"";} ?>>Clerk</option>
          
            <option value="clergy" <?php if (!(strcmp("clergy", $row_users['user_level']))) {echo "selected=\"selected\"";} ?>>Clergy</option>
            
                   <option value="treasurer" <?php if (!(strcmp("treasurer", $row_users['user_level']))) {echo "selected=\"selected\"";} ?>>Treasurer</option>
      </select>
    
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php if (isset($_GET['user_id'])&&($_GET['user_id']!="")) {?><input type="submit" name="Update" id="Update" value="Update" />
      <input type="submit" name="Reset" id="Reset" value="Reset Password" onclick="ConfirmDelete()"/>
<input type="submit" name="Delete" id="Delete" value="Delete" onclick="ConfirmDelete()"/><?php }else{?><input type="submit" name="Save" id="Save" value="Save" />
      <?php }?></td>
  </tr>
</table>
</td>
    <td width="40%" valign="top"><table width="100%" border="0" align="center" class="viewpane" >
  <tr>
    <td colspan="5" align="center">All Users</td>
  </tr>
  <tr>
    <td width="28%">No.</td>
    <td width="33%">User Name</td>
    <td width="26%">User Level</td>
    <td width="26%">&nbsp;</td>
  </tr>
  <?php $rownum=0; do { $rownum++; ?><tr <?php if ($rownum%2==0) { echo 'class="othereven"'; }else{echo 'class="otherodd"';}?>>
    <td><?php echo $rownum; ?></td>
    <td><?php echo $row_allusers['username']; ?></td>
    <td width="26%"><?php echo $row_allusers['user_level']; ?></td>
    <td bgcolor="#9999FF"><a href="index.php?user_id=<?php echo $row_allusers['user_id']; ?> ">edit</a></td>
  </tr><?php } while ($row_allusers = mysql_fetch_assoc($allusers));   ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table></td>
  </tr>
    <tr>
    <td colspan="2">&nbsp;</td>
  </tr>

</table>
<input type="hidden" name="MM_insert" value="form" />
</form>
</div>
<div id="tabs-2">

<?php 
$maxRows_viewlogged = 10;
$pageNum_viewlogged= 0;
if (isset($_GET['pageNum_viewlogged'])) {
  $pageNum_viewlogged= $_GET['pageNum_viewlogged'];
}
$startRow_viewlogged = $pageNum_viewlogged * $maxRows_viewlogged;

mysql_select_db($database_church, $church);
$query_viewlogged= "SELECT * FROM loggedin  ln WHERE ln.user_level='user' ORDER BY ln.whenloggedin DESC";
$query_limit_viewlogged = sprintf("%s LIMIT %d, %d", $query_viewlogged, $startRow_viewlogged, $maxRows_viewlogged);
$viewlogged = mysql_query($query_limit_viewlogged, $church) or die(mysql_error());
$row_viewlogged = mysql_fetch_assoc($viewlogged);

if (isset($_GET['totalRows_viewlogged'])) {
  $totalRows_viewlogged = $_GET['totalRows_viewlogged'];
} else {
  $all_viewlogged = mysql_query($query_viewlogged);
  $totalRows_viewlogged = mysql_num_rows($all_viewlogged);
}
$totalPages_viewlogged = ceil($totalRows_viewlogged/$maxRows_viewlogged)-1;

$queryString_viewlogged = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewlogged") == false && 
        stristr($param, "totalRows_viewlogged") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewlogged = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewlogged = sprintf("&totalRows_viewlogged=%d%s", $totalRows_viewlogged, $queryString_viewlogged);

 ?>
<input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center">
    <tr>
      <td width="%">No</td>
   <td width="%">LOGGED IN USERS </td>
      <td width="%">Time Logged In </td>
      <td width="%">Time Logged Out</td>
      
    </tr>
    <?php   
    
     do { $logged++;
	
		
mysql_select_db($database_church, $church);
$query_viewleaderlogged = "SELECT * FROM loggedin ln  INNER JOIN leader l ON l.leaderid=ln.user_id WHERE l.leaderid='".$row_viewlogged['user_id']."'";  
$viewleaderlogged = mysql_query($query_viewleaderlogged, $church) or die(mysql_error());
$row_viewleaderlogged = mysql_fetch_assoc($viewleaderlogged);
$totalRows_viewleaderlogged = mysql_num_rows($viewleaderlogged);

	
	 ?>

      <tr>
        <td><?php  echo $logged;?></td>
        <td><?php echo $row_viewleaderlogged['user_name']; ?>&nbsp;</td>
        <td><?php echo $row_viewlogged['whenloggedin']; ?>&nbsp; </td>
       <td><?php echo $row_viewlogged['whenloggedout']; ?>&nbsp; </td>
       
     
     </tr>
      <?php } while ($row_viewlogged = mysql_fetch_assoc($viewlogged)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewlogged > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewlogged=%d%s", $currentPage, 0, $queryString_viewlogged); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewlogged > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewlogged=%d%s", $currentPage, max(0, $pageNum_viewlogged - 1), $queryString_viewlogged); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewlogged < $totalPages_viewlogged) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewlogged=%d%s", $currentPage, min($totalPages_viewlogged, $pageNum_viewlogged + 1), $queryString_viewlogged); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewlogged < $totalPages_viewlogged) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewlogged=%d%s", $currentPage, $totalPages_viewlogged, $queryString_viewlogged); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewlogged + 1) ?> to <?php echo min($startRow_viewlogged + $maxRows_viewlogged, $totalRows_viewlogged) ?> of <?php echo $totalRows_viewlogged ?>









</form>
</div>


<div id="tabs-3">


<?php 
$maxRows_viewloggedadmin = 10;
$pageNum_viewloggedadmin= 0;
if (isset($_GET['pageNum_viewlogged'])) {
  $pageNum_viewlogged= $_GET['pageNum_viewloggedadmin'];
}
$startRow_viewloggedadmin = $pageNum_viewloggedadmin * $maxRows_viewloggedadmin;

mysql_select_db($database_church, $church);
$query_viewloggedadmin= "SELECT * FROM loggedin l   INNER JOIN users u ON u.user_id=l.user_id WHERE l.user_level='admin' OR l.user_level='secretary'
 OR l.user_level='treasurer' OR l.user_level='clerk' ORDER BY l.whenloggedin DESC";    

$query_limit_viewloggedadmin= sprintf("%s LIMIT %d, %d", $query_viewloggedadmin, $startRow_viewloggedadmin, $maxRows_viewloggedadmin);
$viewloggedadmin = mysql_query($query_limit_viewloggedadmin, $church) or die('error');
$row_viewloggedadmin = mysql_fetch_assoc($viewloggedadmin);

if (isset($_GET['totalRows_viewloggedadmin'])) {
  $totalRows_viewloggedadmin = $_GET['totalRows_viewloggedadmin'];
} else {
  $all_viewloggedadmin = mysql_query($query_viewloggedadmin);
  $totalRows_viewloggedadmin = mysql_num_rows($all_viewloggedadmin);
}
$totalPages_viewloggedadmin = ceil($totalRows_viewloggedadmin/$maxRows_viewloggedadmin)-1;

$queryString_viewloggedadmin = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewloggedadmin") == false && 
        stristr($param, "totalRows_viewloggedadmin") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewloggedadmin = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewloggedadmin = sprintf("&totalRows_viewloggedadmin=%d%s", $totalRows_viewloggedadmin, $queryString_viewloggedadmin);

 ?>
<input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center">
    <tr>
      <td width="%">No</td>
   <td width="%">LOGGED IN Admin</td>
       <td width="%">Admin Level </td>
      <td width="%">Time Logged In </td>
      <td width="%">Time Logged Out</td>
      
    </tr>
    <?php    do { $loggedadmin++;?>
	
      <tr>
        <td><?php  echo $loggedadmin;?></td>
        <td><?php echo $row_viewloggedadmin['username']; ?>&nbsp;</td>
        <td><?php echo $row_viewloggedadmin['user_level']; ?>&nbsp;</td>
        <td><?php echo $row_viewloggedadmin['whenloggedin']; ?>&nbsp; </td>
       <td><?php echo $row_viewloggedadmin['whenloggedout']; ?>&nbsp; </td>
       
     
     </tr>
      <?php } while ($row_viewloggedadmin = mysql_fetch_assoc($viewloggedadmin)); ?>
  </table>
  <br />
  <table border="0">
  <tr>
    <td><?php if ($pageNum_viewloggedadmin> 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewloggedadmin=%d%s", $currentPage, 0, $queryString_viewloggedadmin); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewloggedadmin > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewloggedadmin=%d%s", $currentPage, max(0, $pageNum_viewloggedadmin- 1), $queryString_viewloggedadmin); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewloggedadmin< $totalPages_viewloggedadmin) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewloggedadmin=%d%s", $currentPage, min($totalPages_viewloggedadmin, $pageNum_viewloggedadmin + 1), $queryString_viewloggedadmin); ?>">Next</a>
    <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewloggedadmin < $totalPages_viewloggedadmin) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewloggedadmin=%d%s", $currentPage, $totalPages_viewloggedadmin, $queryString_viewloggedadmin); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewloggedadmin + 1) ?>   of <?php echo $totalRows_viewloggedadmin; ?>



<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
//-->
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
</script>
</body>
</html>
<?php
mysql_free_result($allusers);

mysql_free_result($users);
?>
