<?php 
require_once('Connections/church.php');
require_once('functions.php');

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
?>
<?php 
require_once('Connections/church.php');
require_once('functions.php');

$currentPage = $_SERVER["PHP_SELF"];





$maxRows_allbirthdays = 100;
$pageNum_allbirthdays = 0;
if (isset($_GET['pageNum_allbirthdays'])) {
  $pageNum_allbirthdays = $_GET['pageNum_allbirthdays'];
}
$startRow_allbirthdays = $pageNum_allbirthdays * $maxRows_allbirthdays;


$date =date('Y-m-d');

$month =date("m",strtotime($date))."";
$day=date("d",strtotime($date))."";





mysql_select_db($database_church, $church);
$query_allbirthdays = "SELECT * FROM member_details ms LEFT JOIN member_contacts mc ON ms.memberid=mc.memberid where ms.birthdaymonth=".$month." AND ms.birthdate=".$day."  ORDER BY ms.firstname ASC";
$query_limit_allbirthdays = sprintf("%s LIMIT %d, %d", $query_allbirthdays, $startRow_allbirthdays, $maxRows_allbirthdays);
$allbirthdays = mysql_query($query_limit_allbirthdays, $church) or die(mysql_error());
$row_allbirthdays = mysql_fetch_assoc($allbirthdays);

if (isset($_GET['totalRows_allbirthdays'])) {
  $totalRows_allbirthdays = $_GET['totalRows_allbirthdays'];
} else {
  $all_allbirthdays = mysql_query($query_allbirthdays);
  $totalRows_allbirthdays = mysql_num_rows($all_allbirthdays);
}
$totalPages_allbirthdays = ceil($totalRows_allbirthdays/$maxRows_allbirthdays)-1;
$queryString_allbirthdays = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_allbirthdays") == false && 
        stristr($param, "totalRows_allbirthdays") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_allbirthdays = "&" . htmlentities(implode("&", $newParams));
	
  }
}
$queryString_allbirthdays = sprintf("&totalRows_allbirthdays=%d%s", $totalRows_allbirthdays, $queryString_allbirthdays);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Birthday Alerts</title>

<link href="tms.css" rel="stylesheet" type="text/css"/>
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
<script src="jquery.js" type="text/javascript"></script>

	<script src="jquery.table_navigation.js" type="text/javascript"></script>
    <script type="text/javascript">
	jQuery.tableNavigation({
	table_selector: 'table.navigateable',
	row_selector: 'table.navigateable tbody tr',
	selected_class: 'selected',
	activation_selector: 'a.activation',
	bind_key_events_to_links: true,
	focus_links_on_select: true,
	select_event: 'click',
	activate_event: 'dblclick',
	activation_element_activate_event: 'click',
	cookie_name: 'last_selected_row_index',
	focus_tables: true,
	focused_table_class: 'focused',
	jump_between_tables: true,
	disabled: false,
	on_activate: null,
	on_select: null
});
</script>
</head>

<body> 
<div class="popup">
  <div id="output_div2">
  <?php if($totalRows_allbirthdays>0){ ?>
 
      <table border="1" align="center" class="bodytextmembers" >
  <thead>
      <tr>
        <td colspan="10" align="center" class="tableheader">MEMBERS WITH BIRTHDAYS TODAY</td>
      </tr>
      <tr class="header2">
        <td>No.</td>
        <td>Member Name</td>
        <td>Phone Number</td>
        <td>Email Address</td>
        <td>Alternative Contact</td> 
        <td>Physical Address</td>
       
        
      </tr>
      <?php $rownum = $startRow_allbirthdays; do {

	  
	  $rownum++;  ?>
      
     <tr  <?php if ($rownum%2==0) { echo 'class="othereven"'; }else{echo 'class="otherodd"';}?> > 
        <td><a><?php echo $rownum; ?></a></td>
        <td><?php echo $row_allbirthdays['firstname']; ?>&nbsp;<?php echo $row_allbirthdays['middlename']; ?>&nbsp;<?php echo $row_allbirthdays['lastname']; ?></td>
           <td><?php echo $row_allbirthdays['phonenumber']; ?></td>
           <td><?php echo $row_allbirthdays['emailaddress']; ?></td>
             <td><?php echo $row_allbirthdays['alternative_contact']; ?></td>
             <td><?php echo $row_allbirthdays['physical_address']; ?></td>
              <td><?php echo $row_allbirthdays['physical_address']; ?></td>
       
      </tr>
   
      <?php } while ($row_allbirthdays = mysql_fetch_assoc($allbirthdays)); ?>
      
        <td colspan="2"><?php if ($totalRows_allbirthdays > 0) { // Show if recordset not empty ?>
          <?php echo ($startRow_allbirthdays + 1) ?>
          <?php } // Show if recordset not empty ?>
          <strong>TO</strong> <?php echo min($startRow_allbirthdays + $maxRows_allbirthdays, $totalRows_allbirthdays) ?> <strong>OF</strong> <?php echo $totalRows_allbirthdays ?></td>
        <td colspan="3"><?php if ($pageNum_allbirthdays > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_allbirthdays=%d%s", $currentPage, max(0, $pageNum_allbirthdays - 1), $queryString_allbirthdays); ?>">First</a> ||
          <?php } // Show if not first page ?>
          <?php if ($pageNum_allbirthdays > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_allbirthdays=%d%s", $currentPage, max(0, $pageNum_allbirthdays - 1), $queryString_allbirthdays); ?>">Previous</a> ||
            <?php } // Show if not first page ?>
          <?php if ($pageNum_allbirthdays < $totalPages_allbirthdays) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_allbirthdays=%d%s", $currentPage, min($totalPages_allbirthdays, $pageNum_allbirthdays + 1), $queryString_allbirthdays); ?>">Next</a> ||
            <?php } // Show if not last page ?>
          <?php if ($pageNum_allbirthdays < $totalPages_allbirthdays) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_allbirthdays=%d%s", $currentPage, $totalPages_allbirthdays, $queryString_allbirthdays); ?>">Last</a>
          <?php } // Show if not last page ?></td>
      </tr>
    </table>
    <?php }else { echo "No Birthdays Today";} ?>
    
  </div>
</div>
<script type="text/javascript">
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script>
</body>
</html>
<?php
@mysql_free_result($allbirthdays);

mysql_free_result($overduefiles);

@mysql_free_result($property);

@mysql_free_result($departments);

@mysql_free_result($locations);

@mysql_free_result($jobtitles);

@mysql_free_result($thissupervisor11);

@mysql_free_result($thissupervisor12);

@mysql_free_result($thissupervisor1);
?>
