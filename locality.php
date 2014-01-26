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

if ((isset($_POST["savelocation"]))) {
	
	$tab="index.php?locality=true#tabs-1";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO locality (locationname, locationdescription,locationmission) VALUES (%s, %s,%s)",                         
                      GetSQLValueString($_POST['locationname'], "text"),
                      GetSQLValueString($_POST['locationdescription'], "text"),
					  GetSQLValueString($_POST['locationmission'], "text"));
					   

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
}

if ((isset($_POST["updatelocation"]))) {
	
if(isset($_GET['localityid']) && ($_GET['localityid']=!"")){
 
     
		$tab="index.php?locality=true#tabs-1";
	$whereto=$tab;
	

  $updateSQL = sprintf("UPDATE locality SET locationname=%s, locationdescription=%s,locationmission=%s WHERE localityid=".($_GET['localityid'])."",
                       GetSQLValueString($_POST['locationname'], "text"),
                       GetSQLValueString($_POST['locationdescription'], "text"),
					     GetSQLValueString($_POST['locationmission'], "text"),
                       GetSQLValueString($_POST['localityid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

 header("Location:$whereto");

}

if (($_GET['Delete']) && (isset($_GET['localityid'])) && ($_GET['localityid'] != "")) {
	
  $deleteSQL = sprintf("DELETE FROM locality WHERE localityid=".$_GET['localityid']."",
                       GetSQLValueString($_GET['localityid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());

  header("Location:$whereto");

}

mysql_select_db($database_church, $church);
$query_addlocality = "SELECT * FROM locality";
$addlocality = mysql_query($query_addlocality, $church) or die(mysql_error());
$row_addlocality = mysql_fetch_assoc($addlocality);
$totalRows_addlocality = mysql_num_rows($addlocality);

if(isset($_GET['localityid']) && ($_GET['localityid']=!"")){
mysql_select_db($database_church, $church);
$query_editlocality = "SELECT * FROM locality WHERE localityid=".$_GET['localityid']."";
$editlocality = mysql_query($query_editlocality, $church) or die(mysql_error());
$row_editlocality = mysql_fetch_assoc($editlocality);
$totalRows_editlocality = mysql_num_rows($editlocality);
}
$maxRows_viewlocality = 10;
$pageNum_viewlocality = 0;
if (isset($_GET['pageNum_viewlocality'])) {
  $pageNum_viewlocality = $_GET['pageNum_viewlocality'];
}
$startRow_viewlocality = $pageNum_viewlocality * $maxRows_viewlocality;

mysql_select_db($database_church, $church);
$query_viewlocality = "SELECT * FROM locality";
$query_limit_viewlocality = sprintf("%s LIMIT %d, %d", $query_viewlocality, $startRow_viewlocality, $maxRows_viewlocality);
$viewlocality = mysql_query($query_limit_viewlocality, $church) or die(mysql_error());
$row_viewlocality = mysql_fetch_assoc($viewlocality);

if (isset($_GET['totalRows_viewlocality'])) {
  $totalRows_viewlocality = $_GET['totalRows_viewlocality'];
} else {
  $all_viewlocality = mysql_query($query_viewlocality);
  $totalRows_viewlocality = mysql_num_rows($all_viewlocality);
}
$totalPages_viewlocality = ceil($totalRows_viewlocality/$maxRows_viewlocality)-1;

$queryString_viewlocality = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewlocality") == false && 
        stristr($param, "totalRows_viewlocality") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewlocality = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewlocality = sprintf("&totalRows_viewlocality=%d%s", $totalRows_viewlocality, $queryString_viewlocality);






if ((isset($_GET['representative_id'])) && ($_GET['representative_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM representative WHERE representative_id=%s",
                       GetSQLValueString($_GET['representative_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_GET['Delete']) &&(isset($_GET['representative_id'])) && ($_GET['representative_id'] != ""))) {
	
	   $tab="index.php?locality=true#tabs-2";
	$whereto=$tab;	
	
  $deleteSQL = sprintf("DELETE FROM representative WHERE representative_id=".($_GET['representative_id'])."",
                       GetSQLValueString($_GET['representative_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
   header("Location:$whereto");
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["saverep"]))) {
	
	 
		$tab="index.php?locality=true#tabs-2";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO representative (representative_id, localityid, residence_chair, residence_secretary, residence_treasurer) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['representative_id'], "int"),
                       GetSQLValueString($_POST['localityid'], "int"),
                       GetSQLValueString($_POST['residence_chair'], "text"),
                       GetSQLValueString($_POST['residence_secretary'], "text"),
                       GetSQLValueString($_POST['residence_treasurer'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}

if ((isset($_POST["updaterep"]))) {
	
	
		$tab="index.php?locality=true#tabs-2";
	$whereto=$tab;
	
if ((isset($_GET['representative_id'])) && ($_GET['representative_id']!="")){	
	
  $updateSQL = sprintf("UPDATE representative SET localityid=%s, residence_chair=%s, residence_secretary=%s, residence_treasurer=%s WHERE representative_id=".$_GET['representative_id']."",
                       GetSQLValueString($_POST['localityid'], "int"),
                       GetSQLValueString($_POST['residence_chair'], "text"),
                       GetSQLValueString($_POST['residence_secretary'], "text"),
                       GetSQLValueString($_POST['residence_treasurer'], "text"),
                       GetSQLValueString($_POST['representative_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}

}

mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

mysql_select_db($database_church, $church);
$query_addlocality = "SELECT * FROM locality";
$addlocality = mysql_query($query_addlocality, $church) or die(mysql_error());
$row_addlocality = mysql_fetch_assoc($addlocality);
$totalRows_addlocality = mysql_num_rows($addlocality);

if((isset($_GET['representative_id']) && ($_GET['representative_id']!=""))){	
	
mysql_select_db($database_church, $church);
$query_editrepresentative = "SELECT * FROM representative r  WHERE r.representative_id=".($_GET['representative_id'])."";
$editrepresentative = mysql_query($query_editrepresentative, $church) or die(mysql_error());
$row_editrepresentative = mysql_fetch_assoc($editrepresentative);
$totalRows_editrepresentative = mysql_num_rows($editrepresentative);
}
$maxRows_viewrepresentative = 10;
$pageNum_viewrepresentative = 0;
if (isset($_GET['pageNum_viewrepresentative'])) {
  $pageNum_viewrepresentative = $_GET['pageNum_viewrepresentative'];
}
$startRow_viewrepresentative = $pageNum_viewrepresentative * $maxRows_viewrepresentative;

mysql_select_db($database_church, $church);
$query_viewrepresentative = "SELECT * FROM representative r INNER JOIN locality l ON l.localityid=r.localityid";
$query_limit_viewrepresentative = sprintf("%s LIMIT %d, %d", $query_viewrepresentative, $startRow_viewrepresentative, $maxRows_viewrepresentative);
$viewrepresentative = mysql_query($query_limit_viewrepresentative, $church) or die(mysql_error());
$row_viewrepresentative = mysql_fetch_assoc($viewrepresentative);

if (isset($_GET['totalRows_viewrepresentative'])) {
  $totalRows_viewrepresentative = $_GET['totalRows_viewrepresentative'];
} else {
  $all_viewrepresentative = mysql_query($query_viewrepresentative);
  $totalRows_viewrepresentative = mysql_num_rows($all_viewrepresentative);
}
$totalPages_viewrepresentative = ceil($totalRows_viewrepresentative/$maxRows_viewrepresentative)-1;

$queryString_viewrepresentative = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewrepresentative") == false && 
        stristr($param, "totalRows_viewrepresentative") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewrepresentative = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewrepresentative = sprintf("&totalRows_viewrepresentative=%d%s", $totalRows_viewrepresentative, $queryString_viewrepresentative);





?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

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
		$('#service_date').datepicker({
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

<div class="mainbodyview">
<body>

<div id="tabs">
<ul>
		<li><a href="#tabs-1">CELL GROUP</a></li>
		<li><a href="#tabs-2">CELL GROUP REPRESENTATIVE</a></li>
	
      


</ul>
<div id="tabs-1">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="mainbodyview">
  <table align="center" >
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CELL  NAME:</td>
      <td><input type="text" name="locationname" value="<?php echo htmlentities($row_editlocality['locationname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td valign="top">CELL DESCRIPTION:</td>
      <td> <textarea name="locationdescription" id="locationdescription" cols="45" rows="5"><?php echo $row_editlocality['locationdescription'] ?></textarea>
      </td>
    </tr>
    
    
      <tr valign="baseline">
      <td valign="top"> CELL MISSION :</td>
      <td><textarea name="locationmission" id="locationmission" cols="45" rows="5"><?php echo $row_editlocality['locationmission'] ?></textarea></td>
    </tr>
    
     <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['localityid'])) &&($_GET['localityid']!="")) {?><input type="submit" value="Update" name="updatelocation"><?php } else  {?><input type="submit" value="Save" name="savelocation"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center">
    <tr>
      <td width="2%">No</td>
     <td width="10%">Cell  Name </td>
      <td width="10%">Cell  Description </td>
      <td width="10%">Cell  Mission</td>
     <td width="4%">&nbsp;</td>
      <td width="4%">&nbsp;</td>
    </tr>
    <?php do { $loacity ++;?>
      <tr>
        <td><?php echo $loacity;  ?></td>
        <td><?php echo $row_viewlocality['locationname']; ?>&nbsp; </td>
        <td><?php echo $row_viewlocality['locationdescription']; ?></td>
         <td><?php echo $row_viewlocality['locationmission']; ?></td>
        
           <td><a href="index.php?locality=show&localityid=<?php echo $row_viewlocality['localityid']; ?>& #tabs-1"> Edit </a></td> 
           
 <td><a href="index.php?locality= show & localityid=<?php echo $row_viewlocality['localityid'];?> & Delete=1" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
 
 
 

  
 
      </tr>
      <?php } while ($row_viewlocality = mysql_fetch_assoc($viewlocality)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewlocality > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewlocality=%d%s", $currentPage, 0, $queryString_viewlocality); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewlocality > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewlocality=%d%s", $currentPage, max(0, $pageNum_viewlocality - 1), $queryString_viewlocality); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewlocality < $totalPages_viewlocality) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewlocality=%d%s", $currentPage, min($totalPages_viewlocality, $pageNum_viewlocality + 1), $queryString_viewlocality); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewlocality < $totalPages_viewlocality) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewlocality=%d%s", $currentPage, $totalPages_viewlocality, $queryString_viewlocality); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewlocality + 1) ?> to <?php echo min($startRow_viewlocality + $maxRows_viewlocality, $totalRows_viewlocality) ?> of <?php echo $totalRows_viewlocality ?>
</form>
</div>
<div id="tabs-2">


<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Locality:</td>
      <td><select name="localityid">
          <option value="-1" <?php if (!(strcmp(-1, $row_editrepresentative['representative_id']))) {echo "selected=\"selected\"";} ?> >Select Residence</option>
      
      
        <?php 
do {  
?>
       
<option value="<?php echo $row_addlocality['localityid']?>" <?php if (!(strcmp($row_addlocality['localityid'], $row_editrepresentative['localityid']))) {echo "selected=\"selected\"";} ?>>&nbsp;<?php echo $row_addlocality['locationname']?></option>      
        
        
        
        
        <?php
} while ($row_addlocality = mysql_fetch_assoc($addlocality));

 $rows = mysql_num_rows($addlocality);
  if($rows > 0) {
      mysql_data_seek($addlocality, 0);
	  $row_addlocality = mysql_fetch_assoc($addlocality);
  }
?>
      </select></td>
    </tr>
    <?php 
	mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Residence_Chairman:</td>
      <td><select name="residence_chair">
       <option value="-1" <?php if (!(strcmp(-1, $row_editrepresentative['representative_id']))) {echo "selected=\"selected\"";} ?> >Select Chairman</option>
      
        <?php 
do {  
?>
        <option value="<?php echo $row_addmember['memberid']?>" <?php if (!(strcmp($row_addmember['memberid'], $row_editrepresentative['residence_chair']))) {echo "selected=\"selected\"";} ?>>&nbsp;<?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
        
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
    
  <?php 
	mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Residence Secretary:</td>
      <td><select name="residence_secretary">
      <option value="-1" <?php if (!(strcmp(-1, $row_editrepresentative['representative_id']))) {echo "selected=\"selected\"";} ?> >Select Secretary</option>   
      
        <?php 
do {  
?>
           <option value="<?php echo $row_addmember['memberid']?>" <?php if (!(strcmp($row_addmember['memberid'], $row_editrepresentative['residence_secretary']))) {echo "selected=\"selected\"";} ?>>&nbsp;<?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option> 
          
      
          
          
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
    
      <?php 
	mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Residence Treasurer:</td>
      <td><select name="residence_treasurer">
      
     <option value="-1" <?php if (!(strcmp(-1, $row_editrepresentative['representative_id']))) {echo "selected=\"selected\"";} ?> >Select Treasurer</option>    
      
        <?php 
do {  
?>
          <option value="<?php echo $row_addmember['memberid']?>" <?php if (!(strcmp($row_addmember['memberid'], $row_editrepresentative['residence_treasurer']))) {echo "selected=\"selected\"";} ?>>&nbsp;<?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option> 
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
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['representative_id'])) &&($_GET['representative_id']!="")) {?><input type="submit" value="Update" name="updaterep"><?php } else  {?><input type="submit" value="Save" name="saverep"><?php }?>
      </td>
    </tr>
  </table>
  
  <p>&nbsp;</p>
  <table border="1" align="center">
  <tr>
     <td width="2%">No</td>
    <td width="10%">Residence Name</td>
    <td width="10%">Cell Group Chairman</td>
    <td width="10%">Cell Group Secretary</td>
    <td width="10%">Cell Group Treasurer</td>
    <td width="2%">&nbsp;</td>
     <td width="2%">&nbsp;</td>
  </tr>
  <?php do { $rep++;
  
  mysql_select_db($database_church, $church);
$query_viewchairman= "SELECT * FROM representative r INNER JOIN  member_details md ON md.memberid=r.residence_chair ";
$viewchairman= mysql_query($query_viewchairman, $church) or die('maad');
$row_viewchairman= mysql_fetch_assoc($viewchairman);
$totalRows_viewchairman = mysql_num_rows($viewchairman);

mysql_select_db($database_church, $church);
$query_viewsecretary= "SELECT * FROM representative re INNER JOIN  member_details md ON md.memberid=re.residence_secretary   ";
$viewsecretary= mysql_query($query_viewsecretary, $church) or die('error');
$row_viewsecretary= mysql_fetch_assoc($viewsecretary);
$totalRows_viewsecretary = mysql_num_rows($viewsecretary);

mysql_select_db($database_church, $church);
$query_viewtreasurer="SELECT * FROM representative rp INNER JOIN  member_details md ON md.memberid=rp.residence_treasurer ";
$viewtreasurer= mysql_query($query_viewtreasurer, $church) or die('error');
$row_viewtreasurer= mysql_fetch_assoc($viewtreasurer);
$totalRows_viewtreasurer = mysql_num_rows($viewtreasurer);
  
  
  
  
  
  
   ?>
    <tr>
      <td><?php echo $rep;  ?></td>
      <td><?php echo $row_viewrepresentative['locationname']; ?>&nbsp; </td>
      <td><?php echo $row_viewchairman['firstname']; ?>&nbsp;<?php echo $row_viewchairman['middlename']; ?>&nbsp;<?php echo $row_viewchairman['lastname']; ?> </td>
      <td><?php echo $row_viewsecretary['firstname']; ?>&nbsp;<?php echo $row_viewsecretary['middlename']; ?>&nbsp;<?php echo $row_viewsecretary['lastname']; ?> </td>
      <td><?php echo $row_viewtreasurer['firstname']; ?>&nbsp;<?php echo $row_viewtreasurer['middlename']; ?>&nbsp;<?php echo $row_viewtreasurer['lastname']; ?> </td>
            <td><a href="index.php?locality=show&representative_id=<?php echo $row_viewrepresentative['representative_id']; ?>& #tabs-2"> Edit </a>
           </td> 
           
      <td><a href="index.php?locality=show & representative_id=<?php echo $row_viewrepresentative['representative_id'];?> & Delete=1 &#tabs-2" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
 
</tr>
    <?php } while ($row_viewrepresentative = mysql_fetch_assoc($viewrepresentative)); ?>
</table>
  
</form>


<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewrepresentative > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewrepresentative=%d%s", $currentPage, 0, $queryString_viewrepresentative); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewrepresentative > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewrepresentative=%d%s", $currentPage, max(0, $pageNum_viewrepresentative - 1), $queryString_viewrepresentative); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewrepresentative < $totalPages_viewrepresentative) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewrepresentative=%d%s", $currentPage, min($totalPages_viewrepresentative, $pageNum_viewrepresentative + 1), $queryString_viewrepresentative); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewrepresentative < $totalPages_viewrepresentative) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewrepresentative=%d%s", $currentPage, $totalPages_viewrepresentative, $queryString_viewrepresentative); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewrepresentative + 1) ?> to <?php echo min($startRow_viewrepresentative + $maxRows_viewrepresentative, $totalRows_viewrepresentative) ?> of <?php echo $totalRows_viewrepresentative ?>



</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($addlocality);

mysql_free_result($editlocality);

mysql_free_result($viewlocality);
?>
