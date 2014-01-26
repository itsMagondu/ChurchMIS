<?php 
require_once('Connections/church.php');
require_once('functions.php');


checkAdmin();

$currentPage = $_SERVER["PHP_SELF"];



$maxRows_viewmember = 5;
$pageNum_viewmember = 0;
if (isset($_GET['pageNum_viewmember'])) {
  $pageNum_viewmember = $_GET['pageNum_viewmember'];
}
$startRow_viewmember = $pageNum_viewmember * $maxRows_viewmember;


mysql_select_db($database_church, $church);
$query_viewmember = "SELECT * FROM member_details 
m LEFT JOIN marital_status ms ON m.statusid=ms.statusid LEFT JOIN 
locality l ON m.localityid=l.localityid LEFT JOIN gender g ON m.genderid=g.genderid  LEFT JOIN church ch ON m.church_id=ch.church_id 
LEFT JOIN departments ds ON m.department_id=ds.department_id WHERE m.status='1' AND ( m.firstname LIKE '%".$_GET['smember']."%' OR m.middlename LIKE '%".$_GET['smember']."%' OR m.lastname LIKE '%".$_GET['smember']."%' ) ORDER BY m.firstname ASC";
$query_limit_viewmember = sprintf("%s LIMIT %d, %d", $query_viewmember, $startRow_viewmember, $maxRows_viewmember);
$viewmember = mysql_query($query_limit_viewmember, $church) or die(mysql_error());
$row_viewmember = mysql_fetch_assoc($viewmember);

if (isset($_GET['totalRows_viewmember'])) {
  $totalRows_viewmember = $_GET['totalRows_viewmember'];
} else {
  $all_viewmember = mysql_query($query_viewmember);
  $totalRows_viewmember = mysql_num_rows($all_viewmember);
}
$totalPages_viewmember = ceil($totalRows_viewmember/$maxRows_viewmember)-1;


mysql_select_db($database_church, $church);
$query_addstatus = "SELECT * FROM marital_status";
$addstatus = mysql_query($query_addstatus, $church) or die(mysql_error());
$row_addstatus = mysql_fetch_assoc($addstatus);
$totalRows_addstatus = mysql_num_rows($addstatus);




mysql_select_db($database_church, $church);
$query_addlocality = "SELECT * FROM locality";
$addlocality = mysql_query($query_addlocality, $church) or die(mysql_error());
$row_addlocality = mysql_fetch_assoc($addlocality);
$totalRows_addlocality = mysql_num_rows($addlocality);

$queryString_viewmember = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewmember") == false && 
        stristr($param, "totalRows_viewmember") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewmember = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewmember = sprintf("&totalRows_viewmember=%d%s", $totalRows_viewmember, $queryString_viewmember);







?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Members</title>
	<link type="text/css" href="jquery/themes/base/jquery.ui.all.css" rel="stylesheet" />
<script type="text/javascript" src="jquery/jquery-1.4.2.js"></script>
	<script type="text/javascript" src="jquery/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="jquery/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="jquery/ui/jquery.ui.mouse.js"></script>
	<script type="text/javascript" src="jquery/ui/jquery.ui.sortable.js"></script>
	<script type="text/javascript" src="jquery/ui/jquery.ui.accordion.js"></script>
    <script type="text/javascript" src="utilities.js"></script>

<link type="text/css" href="/st_peters/tms.css"/>
<script type="text/javascript" src="search.js"></script>
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
		var stop = false;
		$("#accordion h3").click(function(event) {
			if (stop) {
				event.stopImmediatePropagation();
				event.preventDefault();
				stop = false;
			}
		});
		$("#accordion").accordion({
			header: "> div > h3"
		}).sortable({
			axis: "y",
			handle: "h3",
			stop: function(event, ui) {
				stop = true;
			}
		});
	});
	</script>




<link href="/st_peters/tms.css" rel="stylesheet" type="text/css"/>
</head>


<div class="output-div-container">
<div id="output_div">
 <?php if($totalRows_viewmember>0){ ?>
    <table border="1" align="center" class="bodytextmembers">
      
    <tr class="tableheader">
       <td width="2%">No</td>
      <td width="2%">Member No</td>
      <td width="6%">Member Names</td>
      <td width="4%">Department</td>
      <td width="4%">Service Attended</td>
      <td width="4%">Cell Group</td>
      <td width="6%">Church</td>
      <td width="2%">&nbsp;</td>
       <td width="2%" align="left">&nbsp;</td>
      <td width="2%" align="left">&nbsp;</td>
       
     
    </tr>
    
    <?php do { $rownum++ ; ?>
      <tr>
        <td height="54"><?php echo $rownum;?></td>
        <td><?php echo $row_viewmember['member_no']; ?>&nbsp; </td>
        <td><?php echo $row_viewmember['firstname']; ?>&nbsp;<?php echo $row_viewmember['middlename']; ?>&nbsp;<?php echo $row_viewmember['lastname']; ?> </td>
       <td><?php echo $row_viewmember['department_name']; ?>&nbsp; </td>
     <td><?php echo $row_viewmember['service_attended']; ?>&nbsp; </td>
        <td><?php echo $row_viewmember['locationname']; ?>&nbsp; </td>
        <td><?php echo $row_viewmember['church_name']; ?>&nbsp; </td>
      <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='clerk'))){ 
  ?>
        <td><a href="index.php?member=show&memberid=<?php echo $row_viewmember['memberid']; ?>& #tabs-1"> Edit </a></td>
        <td><a href="index.php?member=<?php echo $row_viewmember['memberid'];?> & archive=1 " onclick="return ConfirmArchive()">Archive  </a></td>
        <?php }?>                 
 <td width="8%"><a href="index.php?alldetails=show &amp; alldetailsid=<?php echo $row_viewmember['memberid']?> ">All Details</a></td> 
   </tr>
      <?php } while ($row_viewmember = mysql_fetch_assoc($viewmember)); ?>
  </table>
    <?php }else { echo"No results";} ?>
            </div>
            <table border="0">
  <tr>
    <td><?php if ($pageNum_viewmember > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewmember=%d%s", $currentPage, 0, $queryString_viewmember); ?>">First</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewmember > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewmember=%d%s", $currentPage, max(0, $pageNum_viewmember - 1), $queryString_viewmember); ?>">Previous</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewmember < $totalPages_viewmember) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewmember=%d%s", $currentPage, min($totalPages_viewmember, $pageNum_viewmember + 1), $queryString_viewmember); ?>">Next</a>
      <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewmember < $totalPages_viewmember) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewmember=%d%s", $currentPage, $totalPages_viewmember, $queryString_viewmember); ?>">Last</a>
      <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewmember + 1) ?> to <?php echo min($startRow_viewmember + $maxRows_viewmember, $totalRows_viewmember) ?> of <?php echo $totalRows_viewmember?>
        
	</div>
   
	</div>

</body>
</html>


