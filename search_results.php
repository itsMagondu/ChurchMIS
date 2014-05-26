<?php 
require_once('Connections/church.php');
require_once('functions.php');


checkAdmin();

$currentPage = $_SERVER["PHP_SELF"];



$maxRows_viewmemberdetails = 100;
$pageNum_viewmemberdetails = 0;
if (isset($_GET['pageNum_viewmemberdetails'])) {
  $pageNum_viewmemberdetails = $_GET['pageNum_viewmemberdetails'];
}
$startRow_viewmemberdetails = $pageNum_viewmemberdetails * $maxRows_viewmemberdetails;


mysql_select_db($database_church, $church);
$query_viewmemberdetails =  "SELECT * FROM member_details 
m LEFT JOIN marital_status ms ON m.statusid=ms.statusid LEFT JOIN 
locality l ON m.localityid=l.localityid LEFT JOIN gender g ON m.genderid=g.genderid  LEFT JOIN church ch ON m.church_id=ch.church_id 
LEFT JOIN departments ds ON m.department_id=ds.department_id WHERE m.status='1' AND ( m.firstname LIKE '%".$_GET['smember']."%' OR m.middlename LIKE '%".$_GET['smember']."%' OR m.lastname LIKE '%".$_GET['smember']."%' ) ORDER BY m.firstname ASC";
$query_limit_viewmemberdetails = sprintf("%s LIMIT %d, %d", $query_viewmemberdetails, $startRow_viewmemberdetails, $maxRows_viewmemberdetails);
$viewmemberdetails = mysql_query($query_limit_viewmemberdetails, $church) or die('cannot list members haha ');
$row_viewmemberdetails = mysql_fetch_assoc($viewmemberdetails);





if (isset($_GET['totalRows_viewmemberdetails'])) {
  $totalRows_viewmemberdetails = $_GET['totalRows_viewmemberdetails'];
} else {
  $all_viewmemberdetails = mysql_query($query_viewmemberdetails);
  $totalRows_viewmemberdetails = mysql_num_rows($all_viewmemberdetails);
}
$totalPages_viewmemberdetails = ceil($totalRows_viewmemberdetails/$maxRows_viewmemberdetails)-1;




$queryString_viewmemberdetails = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewmemberdetails") == false && 
        stristr($param, "totalRows_viewmemberdetails") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewmemberdetails = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewmemberdetails = sprintf("&totalRows_viewmemberdetails=%d%s", $totalRows_viewmemberdetails, $queryString_viewmemberdetails);







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
<script type="text/javascript" src="/st_peters/search.js"></script>

<script>
function getbysearchname(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "member_result.php?smembername=" + escape(content)+"&count="+get_count, true);
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


<div class="output-div-container1">
<div id="output_div1">
 <?php if($totalRows_viewmemberdetails>0){ ?>
    <table border="1" align="center" class="bodytextmembers" >
      
     <tr class="header">
      <td>No</td>
      <td>Member No</td>
      <td>Member Names</td>
      <td>Group/ Itura</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
       
     
    </tr>
    
   <?php


do { 
	 $rownum7++ ; ?>
      <tr>
      
         <td width="2%"><?php echo $rownum7;?></td>
         <td width="4%"><?php echo $row_viewmemberdetails['member_no']; ?>&nbsp; </td>
         <td width="15%"><?php echo $row_viewmemberdetails['firstname']; ?>&nbsp;<?php echo $row_viewmemberdetails['lastname']; ?>&nbsp; <?php echo $row_viewmemberdetails['middlename']; ?></td>
        <td width="15%"><?php echo $row_viewmemberdetails['locationname']; ?>&nbsp; </td>
        
        
                          
  <td width="2%"><a href="index.php?alldetails=show &amp; alldetailsid=<?php echo $row_viewmemberdetails['memberid']?> ">View</a></td>
  <td width="2%"><a href="index.php?membercard=show&membercardid=<?php echo $row_viewmemberdetails['memberid']; ?>">Preview  </a></td> 
  
                 
    </tr>
      <?php } while ($row_viewmemberdetails = mysql_fetch_assoc($viewmemberdetails)); ?>
  </table>
    <?php }else { echo"No results";} ?>
  </div>
            <table border="0">
  <tr>
    <td><?php if ($pageNum_viewmemberdetails > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewmemberdetails=%d%s", $currentPage, 0, $queryString_viewmemberdetails); ?>">First</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewmemberdetails > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewmember=%d%s", $currentPage, max(0, $pageNum_viewmemberdetails - 1), $queryString_viewmemberdetails); ?>">Previous</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewmemberdetails < $totalPages_viewmemberdetails) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewmemberdetails=%d%s", $currentPage, min($totalPages_viewmemberdetails, $pageNum_viewmemberdetails + 1), $queryString_viewmemberdetails); ?>">Next</a>
      <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewmemberdetails < $totalPages_viewmemberdetails) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewmemberdetails=%d%s", $currentPage, $totalPages_viewmemberdetails, $queryString_viewmemberdetails); ?>">Last</a>
      <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewmemberdetails + 1) ?> to <?php echo min($startRow_viewmemberdetails + $maxRows_viewmemberdetails, $totalRows_viewmemberdetails) ?> of <?php echo $totalRows_viewmemberdetails?>
        
</div>
   
	</div>

</body>
</html>


