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

if ((isset($_POST["savesermon"]))) {
  $insertSQL = sprintf("INSERT INTO church_program (church_program_id, church_service_id, hymns, book_id, readingone_chapter, readingone_verse, lesson_reader1, secondreading_book, readingtwo_chapter, readingtwo_verse, lesson_reader2, sermon_topic, service_leader, Preacher, sermon_date, communicant) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['church_program_id'], "int"),
                       GetSQLValueString($_POST['church_service_id'], "int"),
                       GetSQLValueString($_POST['hymns'], "text"),
                       GetSQLValueString($_POST['book_id'], "int"),
                       GetSQLValueString($_POST['readingone_chapter'], "int"),
                       GetSQLValueString($_POST['readingone_verse'], "int"),
                       GetSQLValueString($_POST['lesson_reader1'], "int"),
                       GetSQLValueString($_POST['secondreading_book'], "int"),
                       GetSQLValueString($_POST['readingtwo_chapter'], "text"),
                       GetSQLValueString($_POST['readingtwo_verse'], "text"),
                       GetSQLValueString($_POST['lesson_reader2'], "int"),
                       GetSQLValueString($_POST['sermon_topic'], "text"),
                       GetSQLValueString($_POST['service_leader'], "int"),
                       GetSQLValueString($_POST['Preacher'], "text"),
                       GetSQLValueString($_POST['sermon_date'], "text"),
                       GetSQLValueString($_POST['communicant'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}

if ((isset($_POST["updatesermon"]))) {
	
	
	
if((isset($_GET['church_service_id']) && ($_GET['church_service_id']!==""))){
  $updateSQL = sprintf("UPDATE church_program SET church_service_id=%s, hymns=%s, book_id=%s, readingone_chapter=%s, readingone_verse=%s, lesson_reader1=%s, secondreading_book=%s, readingtwo_chapter=%s, readingtwo_verse=%s, lesson_reader2=%s, sermon_topic=%s, service_leader=%s, Preacher=%s, sermon_date=%s, communicant=%s WHERE church_program_id=".$_GET['church_service_id']."",
                       GetSQLValueString($_POST['church_service_id'], "int"),
                       GetSQLValueString($_POST['hymns'], "text"),
                       GetSQLValueString($_POST['book_id'], "int"),
                       GetSQLValueString($_POST['readingone_chapter'], "int"),
                       GetSQLValueString($_POST['readingone_verse'], "int"),
                       GetSQLValueString($_POST['lesson_reader1'], "int"),
                       GetSQLValueString($_POST['secondreading_book'], "int"),
                       GetSQLValueString($_POST['readingtwo_chapter'], "text"),
                       GetSQLValueString($_POST['readingtwo_verse'], "text"),
                       GetSQLValueString($_POST['lesson_reader2'], "int"),
                       GetSQLValueString($_POST['sermon_topic'], "text"),
                       GetSQLValueString($_POST['service_leader'], "int"),
                       GetSQLValueString($_POST['Preacher'], "text"),
                       GetSQLValueString($_POST['sermon_date'], "text"),
                       GetSQLValueString($_POST['communicant'], "text"),
                       GetSQLValueString($_POST['church_program_id'], "int"));

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
$query_addbible = "SELECT * FROM bible";
$addbible = mysql_query($query_addbible, $church) or die(mysql_error());
$row_addbible = mysql_fetch_assoc($addbible);
$totalRows_addbible = mysql_num_rows($addbible);

mysql_select_db($database_church, $church);
$query_addprogram = "SELECT * FROM church_program";
$addprogram = mysql_query($query_addprogram, $church) or die(mysql_error());
$row_addprogram = mysql_fetch_assoc($addprogram);
$totalRows_addprogram = mysql_num_rows($addprogram);

if((isset($_GET['church_program_id'])) &&($_GET['church_program_id']!="")){
mysql_select_db($database_church, $church);
$query_editprogram = "SELECT * FROM church_program cp  INNER JOIN bible b ON cp.book_id=b.book_id
 INNER JOIN church_service cs ON cp.church_service_id=cs.church_service_id INNER JOIN member_details md ON cp.lesson_reader1=md.memberid WHERE church_program_id=".$_GET['church_program_id']."";
$editprogram = mysql_query($query_editprogram, $church) or die(mysql_error());
$row_editprogram = mysql_fetch_assoc($editprogram);
$totalRows_editprogram = mysql_num_rows($editprogram);
}


$maxRows_viewprogram = 10;
$pageNum_viewprogram = 0;
if (isset($_GET['pageNum_viewprogram'])) {
  $pageNum_viewprogram = $_GET['pageNum_viewprogram'];
}
$startRow_viewprogram = $pageNum_viewprogram * $maxRows_viewprogram;

mysql_select_db($database_church, $church);
$query_viewprogram = "SELECT * FROM church_program cp  INNER JOIN bible b ON cp.book_id=b.book_id
 INNER JOIN church_service cs ON cp.church_service_id=cs.church_service_id INNER JOIN member_details md ON cp.lesson_reader1=md.memberid ";
$query_limit_viewprogram = sprintf("%s LIMIT %d, %d", $query_viewprogram, $startRow_viewprogram, $maxRows_viewprogram);
$viewprogram = mysql_query($query_limit_viewprogram, $church) or die(mysql_error());
$row_viewprogram = mysql_fetch_assoc($viewprogram);

if (isset($_GET['totalRows_viewprogram'])) {
  $totalRows_viewprogram = $_GET['totalRows_viewprogram'];
} else {
  $all_viewprogram = mysql_query($query_viewprogram);
  $totalRows_viewprogram = mysql_num_rows($all_viewprogram);
}
$totalPages_viewprogram = ceil($totalRows_viewprogram/$maxRows_viewprogram)-1;

mysql_select_db($database_church, $church);
$query_addservice = "SELECT * FROM church_service";
$addservice = mysql_query($query_addservice, $church) or die(mysql_error());
$row_addservice = mysql_fetch_assoc($addservice);
$totalRows_addservice = mysql_num_rows($addservice);

$queryString_viewprogram = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewprogram") == false && 
        stristr($param, "totalRows_viewprogram") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewprogram = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewprogram = sprintf("&totalRows_viewprogram=%d%s", $totalRows_viewprogram, $queryString_viewprogram);
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
<link type="text/css" href="/st_peters/assets/css/tablecloth.css" rel="stylesheet"/>
<link type="text/css" href="/st_peters/assets/css/bootstrap-tables.css" rel="stylesheet"/>
<link type="text/css" href="/st_peters/assets/css/bootstrap.css" rel="stylesheet"/>
<link type="text/javascript" href="/st_peters/assets/js/bootstrap.js" />
<link type="text/javascript" href="tms.css"/>
<script type="text/javascript" src="/st_peters/search.js"></script>
<script type="text/javascript">
function getbyevaluation(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "member_results.php?smember=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		
</script>


<script type="text/javascript">
	$(function() {
		$('#sermon_date').datepicker({
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

<link rel="stylesheet" href="/st_peters/print.css" type="text/css" media="print"/>

</head>

</head><div class="mainbodyview">
<body>

<div id="tabs">
<ul>
		<li><a href="#tabs-1">Service Program</a></li>

</ul>
<div id="tabs-1">
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
    <table align="center">
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Church:</td>
        <td><select name="church_service_id">
      <option value="-1" <?php if (!(strcmp(-1, $row_editprogram['church_program_id']))) {echo "selected=\"selected\"";} ?> >Select Service </option>     
        
        
          <?php 
do {  
?>
  <option value="<?php echo $row_addservice['memberid']?>"<?php if (!(strcmp($row_addservice['memberid'], $row_editprogram['church_service_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_addservice['service_name']?> </option> 
          
          
          
          
          
          <?php
} while ($row_addservice = mysql_fetch_assoc($addservice));
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Hymns:</td>
        <td><input type="text" name="hymns" value="<?php echo htmlentities($row_editprogram['hymns'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Book Name:</td>
        <td><select name="book_id">
          <option value="-1" <?php if (!(strcmp(-1, $row_editprogram['church_program_id']))) {echo "selected=\"selected\"";} ?> >Select Book</option> 
          <?php 
do {  
?>
          <option value="<?php echo $row_addbible['book_id']?>" ><?php echo $row_addbible['book_name']?></option>
          <?php
} while ($row_addbible = mysql_fetch_assoc($addbible));
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Readingone_chapter:</td>
        <td><input type="text" name="readingone_chapter" value="<?php echo htmlentities($row_editprogram['readingone_chapter'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Readingone_verse:</td>
        <td><input type="text" name="readingone_verse" value="<?php echo htmlentities($row_editprogram['readingone_verse'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Lesson Reader:</td>
        <td><select name="lesson_reader1">
        <option value="-1" <?php if (!(strcmp(-1, $row_editprogram['church_program_id']))) {echo "selected=\"selected\"";} ?> >First Lesson Leader</option> 
        
          <?php 
do {  
?>
          <option value="<?php echo $row_addmember['memberid']?>" ><?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
          <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));
?>
        </select></td>
      </tr>
      
     <?php mysql_select_db($database_church, $church);
$query_addbible = "SELECT * FROM bible";
$addbible = mysql_query($query_addbible, $church) or die(mysql_error());
$row_addbible = mysql_fetch_assoc($addbible);
$totalRows_addbible = mysql_num_rows($addbible);?> 
      
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Book Name:</td>
        <td><select name="secondreading_book">
           <option value="-1" <?php if (!(strcmp(-1, $row_editprogram['church_program_id']))) {echo "selected=\"selected\"";} ?> >Select Book</option>   
          <?php 
do {  
?>
          
          
  <option value="<?php echo $row_addbible['book_id']?>"<?php if (!(strcmp($row_addbible['book_id'], $row_editprogram['book_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_addbible['book_name']?> </option>   
          
          
          <?php
} while ($row_addbible = mysql_fetch_assoc($addbible));
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Readingtwo_chapter:</td>
        <td><input type="text" name="readingtwo_chapter" value="<?php echo htmlentities($row_editprogram['readingtwo_chapter'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Readingtwo_verse:</td>
        <td><input type="text" name="readingtwo_verse" value="<?php echo htmlentities($row_editprogram['readingtwo_verse'], ENT_COMPAT, 'utf-8'); ?>" size="15" /></td>
      </tr>
      
      <?php mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
      
      
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Second Lesson Leader:</td>
        <td><select name="lesson_reader2">
            <option value="-1" <?php if (!(strcmp(-1, $row_editprogram['church_program_id']))) {echo "selected=\"selected\"";} ?> >Second Lesson Leader</option>  
        
          <?php 
do {  


?>

          <option value="<?php echo $row_addmember['memberid']?>" ><?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
          <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Sermon_topic:</td>
        <td><input type="text" name="sermon_topic" value="" size="32" /></td>
      </tr>
      <?php mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
      
      
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Service_leader:</td>
        <td><select name="service_leader">
          <option value="-1" <?php if (!(strcmp(-1, $row_editprogram['church_program_id']))) {echo "selected=\"selected\"";} ?> >Select Service Leader</option>
          <?php 
do {  
?>
          <option value="<?php echo $row_addmember['memberid']?>" ><?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
          <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));
?>
        </select></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Preacher:</td>
        <td><input type="text" name="Preacher" value="<?php echo htmlentities($row_editprogram['Preacher'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Sermon_date:</td>
        <td><input type="text" name="sermon_date" id="sermon_date" value="<?php echo htmlentities($row_editprogram['sermon_date'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
      </tr>
      <tr valign="baseline">
        <td nowrap="nowrap" align="right">Holy Comuunion Sunday :</td>
        <td>Yes
          <input name="communicant" type="radio" value="Yes" />
        No<input name="communicant" type="radio" value="No" /></td>
      </tr>
      <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['church_program_id'])) &&($_GET['church_program_id']!="")) {?>
          <input type="submit" value="Update" name="updatesermon">
		<?php } else  {?><input type="submit" value="Save" name="savesermon"><?php }?>
      </td>
    </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  
 
  <table border="1" align="center">
    <tr>
      <td width="2%">No</td>
       <td width="2%">Service</td>
       <td width="8%">hymns</td>
       <td width="8%"> Book Name</td>
       <td width="10%">1st lesson Reader</td>
       <td width="8%">Book Name</td>
       <td width="10%">2nd Lesson Reader</td>
      <td width="2%">Sermon Topic</td>
       <td width="10%">Service Leader</td>
      <td width="6%">Preacher</td>
       <td width="2%">Sermon Date</td>
      <td width="2%">Holy Communion</td>
     <td width="2%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
    </tr>
    <?php do { $program++; 
	
	mysql_select_db($database_church, $church);
$query_leaderservice = "SELECT * FROM church_program cp  
INNER JOIN member_details ms ON cp.service_leader=ms.memberid  WHERE ms.memberid=".$row_viewprogram['service_leader']."";
$query_limit_leaderservice = sprintf("%s LIMIT %d, %d", $query_leaderservice , $startRow_leaderservice, $maxRows_leaderservice);
$leaderservice  = mysql_query($query_limit_leaderservice , $church) or die(mysql_error());
$row_leaderservice  = mysql_fetch_assoc($leaderservice );	
	
	
	
 mysql_select_db($database_church, $church);
$query_viewreadingtwo = "SELECT * FROM church_program cp  INNER JOIN bible b ON cp.secondreading_book=b.book_id
  ";
$query_limit_viewreadingtwo  = sprintf("%s LIMIT %d, %d", $query_viewreadingtwo , $startRow_viewprogram, $maxRows_viewprogram);
$viewreadingtwo  = mysql_query($query_limit_viewreadingtwo , $church) or die(mysql_error());
$row_viewreadingtwo  = mysql_fetch_assoc($viewreadingtwo );	
	
	
	
	
mysql_select_db($database_church, $church);
$query_viewlessonleadertwo = "SELECT * FROM church_program cp  
INNER JOIN member_details md ON cp.lesson_reader2=md.memberid ";
$query_limit_viewlessonleadertwo= sprintf("%s LIMIT %d, %d", $query_viewlessonleadertwo, $startRow_viewprogram, $maxRows_viewprogram);
$viewlessonleadertwo = mysql_query($query_limit_viewlessonleadertwo, $church) or die(mysql_error());
$row_viewlessonleadertwo = mysql_fetch_assoc($viewlessonleadertwo);

mysql_select_db($database_church, $church);
$query_viewprogramleader = "SELECT * FROM church_program cp  
LEFT JOIN member_details md ON cp.service_leader=md.memberid ";
$query_limit_viewprogramleader= sprintf("%s LIMIT %d, %d", $query_viewprogramleader, $startRow_vviewprogramleader, $maxRows_viewprogramleader);
$viewlessonleadertwo = mysql_query($query_limit_viewprogramleader, $church) or die(mysql_error());
$row_viewprogramleader = mysql_fetch_assoc($viewprogramleader);

	
	mysql_select_db($database_church, $church);
$query_viewprogramleader= "SELECT * FROM church_program cp  INNER JOIN member_details md ON md.memberid=cp.service_leader WHERE md.memberid=". $row_viewprogram['service_leader']." ";
$viewprogramleader = mysql_query($query_viewprogramleader, $church) or die(mysql_error());
$row_viewprogramleader = mysql_fetch_assoc($viewprogramleader);
$totalRows_viewprogramleader = mysql_num_rows($viewprogramleader);	
	
	
	

	
	
	?>
      <tr>
         <td><?php echo $program; ?></td>
        <td><?php echo $row_viewprogram['service_name']; ?>&nbsp; </td>
        <td><?php echo $row_viewprogram['hymns']; ?>&nbsp; </td>
        <td><?php echo $row_viewprogram['book_name']; ?> &nbsp;Chapter:&nbsp;<?php echo $row_viewprogram['readingone_chapter']; ?>Verse<?php echo $row_viewprogram['readingone_verse']; ?> </td>
        <td><?php echo $row_viewprogram['firstname']; ?>&nbsp;<?php echo $row_viewprogram['middlename']; ?>&nbsp;<?php echo $row_viewprogram['lastname']; ?> </td>
        <td><?php echo $row_viewreadingtwo['book_name']; ?> Chapter<?php echo $row_viewreadingtwo['readingtwo_chapter']; ?>&nbsp;Verse<?php echo $row_viewreadingtwo['readingtwo_verse']; ?></td>
       
        <td><?php echo $row_viewlessonleadertwo['firstname']; ?>&nbsp;<?php echo $row_viewlessonleadertwo['middlename']; ?>&nbsp;<?php echo $row_viewlessonleadertwo['lastname']; ?> </td>
        <td><?php echo $row_viewprogram['sermon_topic']; ?>&nbsp; </td>
        <td><?php echo $row_viewprogramleader['firstname']; ?>&nbsp;<?php echo $row_viewprogramleader['middlename']; ?>&nbsp;<?php echo $row_viewprogramleader['lastname']; ?> </td>
        <td><?php echo $row_viewprogram['Preacher']; ?>&nbsp; </td>
        <td><?php echo $row_viewprogram['sermon_date']; ?>&nbsp; </td>
        <td><?php echo $row_viewprogram['communicant']; ?>&nbsp; </td>
         <td><a href="index.php?sermons=show&church_program_id=<?php echo $row_viewprogram['church_program_id']; ?>"> Edit </a></td> 
           
 <td><a href="index.php?sermons=show&church_program_id=<?php echo $row_viewprogram['church_program_id'];?> & Delete=1" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
        
      </tr>
      <?php } while ($row_viewprogram = mysql_fetch_assoc($viewprogram)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewprogram > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewprogram=%d%s", $currentPage, 0, $queryString_viewprogram); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewprogram > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewprogram=%d%s", $currentPage, max(0, $pageNum_viewprogram - 1), $queryString_viewprogram); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewprogram < $totalPages_viewprogram) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewprogram=%d%s", $currentPage, min($totalPages_viewprogram, $pageNum_viewprogram + 1), $queryString_viewprogram); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewprogram < $totalPages_viewprogram) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewprogram=%d%s", $currentPage, $totalPages_viewprogram, $queryString_viewprogram); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewprogram + 1) ?> to <?php echo min($startRow_viewprogram + $maxRows_viewprogram, $totalRows_viewprogram) ?> of <?php echo $totalRows_viewprogram ?> </div>

<?php 
mysql_free_result($addmember);

mysql_free_result($addleader);

mysql_free_result($addbible);

mysql_free_result($addprogram);

mysql_free_result($editprogram);

mysql_free_result($viewprogram);

mysql_free_result($addservice);
?>
