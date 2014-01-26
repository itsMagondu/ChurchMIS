<?php ob_start()?>

<?php session_start();
require_once('Connections/eims.php');
require_once('functions.php');
checkAdmin(); 


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

if ((isset($_POST["Updatemember"]))) {
	$tab="index.php?membership=true";
	$whereto=$tab;
	if ((isset($_GET['membershipid'])) && ($_GET['membershipid'] != "")) {

  $updateSQL = sprintf("UPDATE membership SET clubs=%s, prof_bodies=%s, societies=%s, others=%s,start_date=%s,end_date=%s WHERE membership_id=".$_GET['membershipid']."",
                       GetSQLValueString($_POST['clubs'], "text"),
                       GetSQLValueString($_POST['prof_bodies'], "text"),
                       GetSQLValueString($_POST['societies'], "text"),
                       GetSQLValueString($_POST['others'], "text"),
					   GetSQLValueString($_POST['start_date'], "text"),
						 GetSQLValueString($_POST['end_date'], "text"));

  mysql_select_db($database_eims, $eims);
  $Result1 = mysql_query($updateSQL, $eims) or die(mysql_error());
}
header("Location:$whereto");

}

if ((isset($_GET['delete']) && isset($_GET['membershipid'])) && ($_GET['membershipid'] != "")) {
	$tab="index.php?membership=true";
	$whereto=$tab;
  $deleteSQL = sprintf("DELETE FROM membership WHERE membership_id=".$_GET['membershipid']."",
                       GetSQLValueString($_GET['membershipid'], "int"));

  mysql_select_db($database_eims, $eims);
  $Result1 = mysql_query($deleteSQL, $eims) or die(mysql_error());

  header("Location:$whereto");

}


if ((isset($_POST["Savemember"]))) {
	$tab="index.php?membership=true";
	$whereto=$tab;

  $insertSQL = sprintf("INSERT INTO membership (employee_id, clubs, prof_bodies, societies, others) VALUES (%s, %s, %s, %s,%s,%s,%s)",
                       GetSQLValueString($_POST['employee_id'], "int"),
                       GetSQLValueString($_POST['clubs'], "text"),
                       GetSQLValueString($_POST['prof_bodies'], "text"),
                       GetSQLValueString($_POST['societies'], "text"),
                       GetSQLValueString($_POST['others'], "text"),
					    GetSQLValueString($_POST['start_date'], "text"),
						 GetSQLValueString($_POST['end_date'], "text"));

  mysql_select_db($database_eims, $eims);
  $Result1 = mysql_query($insertSQL, $eims) or die(mysql_error());
header("Location:$whereto");

}

if ((isset($_GET['membershipid'])) && ($_GET['membershipid'] != "")) {
mysql_select_db($database_eims, $eims);
$query_thismembership = "SELECT * FROM membership m INNER JOIN employees e ON m.employee_id=e.employee_id WHERE membership_id=".$_GET['membershipid']."";
$thismembership = mysql_query($query_thismembership, $eims) or die(mysql_error());
$row_thismembership = mysql_fetch_assoc($thismembership);
$totalRows_thismembership = mysql_num_rows($thismembership);
}



mysql_select_db($database_eims, $eims);
$query_allemployees = "SELECT * FROM employees  ORDER BY employees.first_name";
$allemployees = mysql_query($query_allemployees, $eims) or die(mysql_error());
$row_allemployees = mysql_fetch_assoc($allemployees);
$totalRows_allemployees = mysql_num_rows($allemployees);

$maxRows_membership = 1000;
$pageNum_membership = 0;
if (isset($_GET['pageNum_membership'])) {
  $pageNum_membership = $_GET['pageNum_membership'];
}
$startRow_membership = $pageNum_membership * $maxRows_membership;





if(isset($_POST['empmembr_rec']) || isset($_POST['club_rec']) ||  isset($_POST['Prof_rec']) || isset($_POST['club_rec']) ){
	
$_SESSION['rpt_empmembr']=$_POST['empmembr_rec'];
$_SESSION['rpt_club']=$_POST['club_rec'];
$_SESSION['rpt_Prof']=$_POST['Prof_rec'];
$_SESSION['rpt_society']=$_POST['society_rec'];

header("Location: index.php?membership=true");
}

$empmembr_rec=$_SESSION['rpt_empmembr'];
$club_rec=$_SESSION['rpt_club'];
$Prof_rec=$_SESSION['rpt_Prof'];
$society_rec=$_SESSION['rpt_society'];



mysql_select_db($database_eims, $eims);
$query_membership = "SELECT * FROM membership m INNER JOIN employees e ON m.employee_id=e.employee_id WHERE 1";

if($empmembr_rec!=-1 && $empmembr_rec!=''){$query_membership.= " AND  e.employee_id='$empmembr_rec'";}
if($club_rec!=-1 && $club_rec!=''){$query_membership.= " AND  m.clubs='$club_rec'";}
if($Prof_rec!=-1 && $Prof_rec!=''){$query_membership.=" AND m.prof_bodies='$Prof_rec'";} 
if($society_rec!=-1 && $society_rec!=''){$query_membership.=" AND m.societies='$society_rec'";}  
$membership  = mysql_query($query_membership , $eims) or die("error");
$row_membership = mysql_fetch_assoc($membership );
$totalRows_membership = mysql_num_rows($membership );

mysql_select_db($database_eims, $eims);
$query_viewmembership = "SELECT e.employee_id,e.last_name,e.first_name,e.middle_name,e.last_name FROM employees e ORDER BY e.first_name ";
$viewmembership   = mysql_query($query_viewmembership , $eims) or die(mysql_error());
$row_viewmembership = mysql_fetch_assoc($viewmembership  );
$totalRows_viewmembership  = mysql_num_rows($viewmembership  );

mysql_select_db($database_eims, $eims);
$query_clubs= "SELECT DISTINCT (clubs) FROM membership ";
$clubs   = mysql_query($query_clubs  , $eims) or die(mysql_error());
$row_clubs  = mysql_fetch_assoc($clubs  );
$totalRows_clubs  = mysql_num_rows($clubs  );


mysql_select_db($database_eims, $eims);
$query_profbodies= "SELECT DISTINCT (prof_bodies) FROM membership ";
$profbodies   = mysql_query($query_profbodies  , $eims) or die(mysql_error());
$row_profbodies  = mysql_fetch_assoc($profbodies  );
$totalRows_profbodies = mysql_num_rows($profbodies  );

mysql_select_db($database_eims, $eims);
$query_societies= "SELECT DISTINCT (societies) FROM membership ";
$societies   = mysql_query($query_societies  , $eims) or die(mysql_error());
$row_societies  = mysql_fetch_assoc($societies  );
$totalRows_societies = mysql_num_rows($societies  );


if (isset($_GET['totalRows_membership'])) {
  $totalRows_membership = $_GET['totalRows_membership'];
} else {
  $all_membership = mysql_query($query_membership);
  $totalRows_membership = mysql_num_rows($all_membership);
}
$totalPages_membership = ceil($totalRows_membership/$maxRows_membership)-1;

$queryString_membership = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_membership") == false && 
        stristr($param, "totalRows_membership") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_membership = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_membership = sprintf("&totalRows_membership=%d%s", $totalRows_membership, $queryString_membership);







?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employees</title>
<link type="text/css" href="js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-ui/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.mouse.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.sortable.js"></script>
<script type="text/javascript" src="js/jquery-ui/development-bundle/ui/ui.datepicker3.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.tabs.js"></script>
<script type="text/javascript" src="js/jquery-ui/ui/jquery.effects.blind.js"></script>
	<link type="text/css" href="eims.css" rel="stylesheet" />

	<link type="text/css" href="js/jquery-ui/demos/demos.css" rel="stylesheet" />
<script type="text/javascript">
	$(function() {
		$("#tabs").tabs().find(".ui-tabs-nav").sortable({axis:'x'});
	});
	</script>
<script type="text/javascript" src="search.js"></script>
<script type="text/javascript">
function getbyevaluation(div_id,content_id,get_count)
		{
			subject_id = div_id;
			
			
				content = document.getElementById(content_id).value;
			http.open("GET", "employees_results.php?semployee=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		
</script>

<script type="text/javascript">
	$(function() {
		$('#dob').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#hire').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#dob2').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#dob3').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#dob3').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#dob4').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#trainfrom').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#trainto').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#promodate').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#awarddate').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#acad_from').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#acad_to').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#emp_from').datepicker({
			changeMonth: true,
			changeYear: true
		});
		$('#emp_to').datepicker({
			changeMonth: true,
			changeYear: true
		});
		
		$('#start_date').datepicker({
			changeMonth: true,
			changeYear: true
		});
		
		$('#end_date').datepicker({
			changeMonth: true,
			changeYear: true
		});
		
		

	});
	</script>
<link type="text/css" href="js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
</head>
<div class="mainbody">
<body><div id="tabs">

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table width="100%" border="0" class="content">
  <tr>
    <td>Memberships</td>
  </tr>
  <div class="none">
    
  
<select name="empmembr_rec" id="empmembr_rec" onChange="submit()" >

  <option value="-1" <?php if (!(strcmp(-1, $empmembr_rec))) {echo "selected=\"selected\"";} ?>>Select Employee </option>
 <?php
do {  
?>
<option value="<?php echo $row_viewmembership['employee_id']?>"<?php if (!(strcmp($row_viewmembership['employee_id'],$empmembr_rec))) {echo "selected=\"selected\"";} ?>><?php echo $row_viewmembership['first_name']?> <?php echo $row_viewmembership['middle_name']?> <?php echo $row_viewmembership['last_name']?></option>

        <?php
} while ($row_viewmembership = mysql_fetch_assoc($viewmembership ));
  $rows = mysql_num_rows($viewmembership );
  if($rows > 0) {
      mysql_data_seek($viewmembership , 0);
	  $row_viewmembership= mysql_fetch_assoc($viewmembership );
  }
?>
</select>
  <select name="club_rec" id="club_rec" onchange="submit()">
    <option value="-1" <?php if (!(strcmp(-1, $club_rec))) {echo "selected=\"selected\"";} ?>> Select Club</option>
    <?php
do {  
?>
    <option value="<?php echo $row_clubs['clubs']?>"<?php if (!(strcmp($row_clubs['clubs'],$club_rec))) {echo "selected=\"selected\"";} ?>><?php echo $row_clubs['clubs']?></option>
    <?php
} while ($row_clubs= mysql_fetch_assoc($clubs));
  $rows = mysql_num_rows($clubs);
  if($rows > 0) {
      mysql_data_seek($clubs, 0);
	  $row_clubs= mysql_fetch_assoc($clubs);
  }
?>
  </select>
  
  
  <select name="Prof_rec" id="Prof_rec" onchange="submit()">
    <option value="-1" <?php if (!(strcmp(-1, $Prof_rec))) {echo "selected=\"selected\"";} ?>> Select Professional Bodies</option>
    <?php
do {  
?>
    <option value="<?php echo $row_profbodies['prof_bodies']?>"<?php if (!(strcmp($row_profbodies['prof_bodies'],$Prof_rec))) {echo "selected=\"selected\"";} ?>><?php echo $row_profbodies['prof_bodies']?></option>
    <?php
} while ($row_profbodies= mysql_fetch_assoc($profbodies));
  $rows = mysql_num_rows($profbodies);
  if($rows > 0) {
      mysql_data_seek($profbodies, 0);
	  $row_profbodies= mysql_fetch_assoc($profbodies);
  }
?>
  </select>
  
  <select name="society_rec" id="society_rec" onchange="submit()">
    <option value="-1" <?php if (!(strcmp(-1, $society_rec))) {echo "selected=\"selected\"";} ?>> Select Societies</option>
    <?php
do {  
?>
    <option value="<?php echo $row_societies['societies']?>"<?php if (!(strcmp($row_societies['societies'],$club_rec))) {echo "selected=\"selected\"";} ?>><?php echo $row_societies['societies']?></option>
    <?php
} while ($row_societies= mysql_fetch_assoc($societies));
  $rows = mysql_num_rows($societies);
  if($rows > 0) {
      mysql_data_seek($societies, 0);
	  $row_societies= mysql_fetch_assoc($societies);
  }
?>
  </select>
  </div>
  <tr>
    <td>
      <table align="center" bgcolor="#F4F4F4" border="0">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Employee:</td>
 <td><select name="employee_id">
   <option value="-1" <?php if (!(strcmp(-1, $row_thismembership['employee_id']))) {echo "selected=\"selected\"";} ?>> Employee</option>
   <?php
do {  
?>
   <optionvalue="<?php echo $row_allemployees['employee_id']?>"<?php if (!(strcmp($row_allemployees['employee_id'], $row_thismembership['employee_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_allemployees['first_name']?> <?php echo $row_allemployees['middle_name']?> <?php echo $row_allemployees['last_name']?></option>
   <?php
} while ($row_allemployees = mysql_fetch_assoc($allemployees));
  $rows = mysql_num_rows($allemployees);
  if($rows > 0) {
      mysql_data_seek($allemployees, 0);
	  $row_allemployees = mysql_fetch_assoc($allemployees);
  }
?>
 </select></td>    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Clubs:</td>
      <td><input type="text" name="clubs" value="<?php echo htmlentities($row_thismembership['clubs'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Proffessional Bodies:</td>
      <td><input type="text" name="prof_bodies" value="<?php echo htmlentities($row_thismembership['prof_bodies'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Societies:</td>
      <td><input type="text" name="societies" value="<?php echo htmlentities($row_thismembership['societies'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Others:</td>
      <td><input type="text" name="others" value="<?php echo htmlentities($row_thismembership['others'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
          <td nowrap="nowrap" align="right">From</td>
          <td><label>
            <input type="text" name="start_date" id="start_date" value="<?php echo $row_thismembership['start_date']; ?>" size="32" />
            </label></td>
          
        </tr>
    
    
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">To</td>
      <td><input type="text" name="end_date" id="end_date" value="<?php echo $row_thismembership['end_date']; ?>" size="32" /></td>
    </tr>
   <tr><td colspan="2"> <?php if (isset($_GET['membershipid'])&&($_GET['membershipid']!="")) {?>
              <input type="submit" name="Updatemember" id="Updatemember" value="Update" />
              <input type="submit" name="Deletemember" id="Deletemember" value="Delete" onclick="return ConfirmDelete()"/>
              <?php }else{?>
              <input type="submit" name="Savemember" id="Savemember" value="Save" />
              <?php }?></td></tr>
  </table>
</form>

</td>
  </tr>
  <tr>
    <td height="149"> <div class="allemployees"><table border="0" align="left" width="100%">
  <tr class="tableheader">
  <td>No.</td>
    <td>Employee</td>
    <td>clubs</td>
    <td>Professional Bodies</td>
    <td>Societies</td>
    <td>Start_date</td> 
    <td>End_date</td>
    <td>Status</td>
    <td>Others</td> 
    <td>Remaining Days</td> 
    <td></td>
    <td></td>

  </tr>
        <?php
		$todaydate=date("Y-m-d");

		 if($row_membership['end_date']!='' && $row_membership['end_date']>=$todaydate){
			 $fromDate1=date("Y-m-d");

      $toDate1=$row_membership['end_date']; 
	        $arrFrom=explode('-',$fromDate1);
      $arrTo=explode('-',$toDate1);

$startdaycal= mktime(0,0,0,$arrFrom[2],$arrFrom[0],$arrFrom[1]);
$enddaycal=mktime(0,0,0,$arrTo[2],$arrTo[0],$arrTo[1]);
	  
$totaldiff=1+($startdaycal-$enddaycal)/(60*60*24);
			   				

					// End of date range  
	  
$remainder=mktime($toDate1-$fromDate1)/(60*60*24);

}

			 $numrow=$startRow_membership; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
      <td width="18%"><?php echo $row_membership['first_name']; ?> <?php echo $row_membership['middle_name']; ?> <?php echo $row_membership['last_name']; ?>&nbsp;</td>
      <td><?php echo $row_membership['clubs']; ?>&nbsp;</td>
      <td><?php echo $row_membership['prof_bodies']; ?>&nbsp;</td>
      <td><?php echo $row_membership['societies']; ?>&nbsp;</td>
      <td><?php echo $row_membership['start_date']; ?></td>
        <td><?php echo $row_membership['end_date']; ?></td>
          <td><?php if($row_membership['end_date']!='' && $row_membership['end_date']>$todaydate){echo $status="Active";} else
		  { echo $status="<b> <font color='#FF0000'>".'Inactive'."</b></font>";}  
		?></td>
           <td>&nbsp;<?php echo $row_membership['others']; ?></td>
           <td><?php 
		  
		   
		    echo $remainder  ; ?>
		   
		    </td>
      <td><a href="index.php?membershipid=<?php echo $row_membership['membership_id']; ?> & membership=true">Edit</a></td>
      <td><a href="index.php?membershipid=<?php echo $row_membership['membership_id']; ?> & delete=1 & membership=true" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
    </tr>
    <?php } while ($row_membership = mysql_fetch_assoc($membership)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_membership > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_membership=%d%s", $currentPage, 0, $queryString_membership); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_membership > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_membership=%d%s", $currentPage, max(0, $pageNum_membership - 1), $queryString_membership); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_membership < $totalPages_membership) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_membership=%d%s", $currentPage, min($totalPages_membership, $pageNum_membership + 1), $queryString_membership); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_membership < $totalPages_membership) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_membership=%d%s", $currentPage, $totalPages_membership, $queryString_membership); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table></div>
Records<?php echo ($startRow_membership + 1) ?>to<?php echo min($startRow_membership + $maxRows_membership, $totalRows_membership) ?>of<?php echo $totalRows_membership ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</div>
</body>
</div>
</html>

<script>   
$("#showmem").click(function () {
$("#mem").toggle("slow");
});    
</script>
     <script>   
$("#showtdev").click(function () {
$("#tdev").toggle("slow");
});    
</script>

<?php 
@mysql_free_result($allemployees);
@mysql_free_result($thismembership);

@mysql_free_result($membership);
?>

<?php ob_end_flush()?>
