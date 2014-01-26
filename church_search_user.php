<?php 
require_once('Connections/church.php'); 
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
if (isset($_SERVER['QUERY_STRING'])) {
  $currentPage .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$maxRows_memberdetails = 1000;
$pageNum_memberdetails = 0;
if (isset($_GET['pageNum_memberdetails'])) {
  $pageNum_memberdetails = $_GET['pageNum_memberdetails'];
}


mysql_select_db($database_church, $church);
if (isset($_SESSION['msm_logged'])){
	
$query_memberdetails = "SELECT DISTINCT (md.memberid),md.genderid,md.localityid,md.firstname,md.lastname,md.middlename,md.leaderidrt,lr.leaderid
g.gendername,l.locationname,ms.statusname,ll.level_name,p.profession_name
FROM member_details md LEFT JOIN marital_status  ms ON md.statusid=ms.statusid INNER JOIN leaeder lr ON md.leaderidrt=lr.leaderid
LEFT JOIN locality  l  ON md.localityid=l.localityid  LEFT JOIN gender g ON md.genderid=g.genderid
LEFT JOIN departments d ON md.department_id=d.department_id LEFT JOIN baptism b ON md.memberid=b.memberid LEFT JOIN marriage m ON md.memberid=m.marriageid LEFT JOIN second_confirmation  sc  ON md.memberid=sc.memberid LEFT JOIN profession p ON md.memberid=p.memberid LEFT JOIN academic a ON md.memberid=a.memberid LEFT JOIN level ll ON a.level_id=ll.level_id   WHERE l.leaderid=".$_SESSION['msm_logged']."";	
	
	
}else{



$query_memberdetails = "SELECT DISTINCT (md.memberid),md.genderid,md.localityid,md.firstname,md.lastname,md.middlename,g.gendername,l.locationname,ms.statusname,ll.level_name,p.profession_name
FROM member_details md LEFT JOIN marital_status  ms ON md.statusid=ms.statusid 
LEFT JOIN locality  l  ON md.localityid=l.localityid  LEFT JOIN gender g ON md.genderid=g.genderid
LEFT JOIN departments d ON md.department_id=d.department_id LEFT JOIN baptism b ON md.memberid=b.memberid LEFT JOIN marriage m ON md.memberid=m.marriageid LEFT JOIN second_confirmation  sc  ON md.memberid=sc.memberid LEFT JOIN profession p ON md.memberid=p.memberid LEFT JOIN academic a ON md.memberid=a.memberid LEFT JOIN level ll ON a.level_id=ll.level_id  WHERE 1";


$memberdetails  = mysql_query($query_memberdetails , $church) or die(mysql_error());
$row_memberdetails  = mysql_fetch_assoc($memberdetails );
$totalRows_memberdetails  = mysql_num_rows($memberdetails );


 echo "Results for ";
if(isset($_GET['memberid']) && $_GET['memberid']!=''){
$query_memberdetails .= " AND md.memberid LIKE '".$_GET['memberid']."%'";
	echo "Member Number : ".$_GET['memberid']." ";
	}
if(isset($_GET['member_names']) && $_GET['member_names']!=''){
	
$query_memberdetails .= " AND (md.firstname LIKE '%" .$_GET['member_names']."%' ||  md.middlename LIKE '%".$_GET['member_names']."%'|| md.lastname LIKE '%".$_GET['member_names']."%')";
echo "Member Name: ".$_GET['member_names']." ";

	}
if(isset($_GET['gender_name']) && $_GET['gender_name']!=-1){
$query_memberdetails .= " AND g.genderid=".$_GET['gender_name']."";
echo "Gender: ".$_GET['gender_name']." ";


	}		
if(isset($_GET['department_name']) && $_GET['department_name']!='-1'){
	$query_memberdetails .= " AND a.department_name=".$_GET['department_name']."";
echo " Department  : ".$_GET['department_name']." ";

	}	
if(isset($_GET['location_name']) && $_GET['location_name']!='-1'){
$query_memberdetails .= " AND l.localityid=".$_GET['location_name']."";
	
echo "Residence  Name: ".$_GET['locationname']." ";
}

if(isset($_GET['marital_status']) && $_GET['marital_status']!=-1){
$query_memberdetails .= " AND ms.statusid=".$_GET['marital_status']."";
echo "Marital Status : ".$_GET['marital_status']." ";
	}
if(isset($_GET['profession_name']) && $_GET['profession_name']!=-1){
$query_memberdetails .= " AND p.profession_id=".$_GET['profession_name']."";
echo "Profession Name : ".$_GET['profession_name']." ";
	}

if(isset($_GET['baptsim_date']) && $_GET['baptsim_date']!=''){
$query_memberdetails .= " AND b.date='".$_GET['baptsim_date']."'";
echo " Baptism Date  : ".$_GET['marriage_date']." ";
	}
if(isset($_GET['marriage_date']) && $_GET['marriage_date']!=''){
$query_memberdetails .= " AND m.date='".$_GET['marriage_date']."'";
	echo " Marriage Date  : ".$_GET['marriage_date']." ";

	}
if(isset($_GET['confirmation_date']) && $_GET['confirmation_date']!=''){
	$query_memberdetails .= " AND sc.date='".$_GET['confirmation_date']."'";
	echo " Confirmation Date  : ".$_GET['confirmation_date']." ";

	}
	
if(isset($_GET['edu_level']) && $_GET['edu_level']!='-1'){
	$query_memberdetails .= " AND a.level_id=".$_GET['edu_level']."";
echo " Education Level    : ".$_GET['edu_level
']." ";

	}	

$query_memberdetails .= " AND 1 ORDER BY md.firstname ASC";

$query_limit_memberdetails = sprintf("%s LIMIT %d, %d", $query_memberdetails, $startRow_memberdetails, $maxRows_memberdetails);
$memberdetails = mysql_query($query_limit_memberdetails, $church) or die(mysql_error());
$row_memberdetails = mysql_fetch_assoc($memberdetails);
if (isset($_GET['totalRows_memberdetails'])) {
  $totalRows_memberdetails = $_GET['totalRows_memberdetails'];
} else {
  $all_memberdetails = mysql_query($query_memberdetails);
  $totalRows_memberdetails = mysql_num_rows($all_memberdetails);
}


$query_limit_memberdetails= sprintf("%s LIMIT %d, %d", $query_memberdetails, $startRow_memberdetails, $maxRows_memberdetails);
$memberdetails = mysql_query($query_limit_memberdetails, $church) or die(mysql_error());
$row_memberdetails = mysql_fetch_assoc($memberdetails);
}

if (isset($_GET['totalRows_memberdetails'])) {
  $totalRows_memberdetails = $_GET['totalRows_viewcatresults'];
} else {
  $all_memberdetails = mysql_query($query_memberdetails);
  $totalRows_memberdetails = mysql_num_rows($all_memberdetails);
}
$totalPages_memberdetails = ceil($totalRows_memberdetails/$maxRows_memberdetails)-1;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View Results</title>

<link href="/st_peters/tms.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="/st_peters/print.css" type="text/css" media="print"/>
<script type="text/javascript">
    function fetch_afresh(){
		var url="index.php?search_admin=true";
		window.location.assign(url);
		}
    </script>
</head>
<body>
<div class="appraisalreport">
<?php if ($totalRows_memberdetails<1){ echo "No Records Matches your search criteria found.";}else{

	?>
    <div class="none" align="left"><button onclick="window.print()">Print this document</button></div>

<table width="100%" border="0" cellpadding="0" cellspacing="0">

 <tr>
    <td colspan="12"><div align="center" class="header">Search Results</div></td>
  </tr>
  <tr class="header2">
    <td>No.</td>
    <td>Member Names</td>
    <td>Locality </td>
    <td> Status</td>
    <td>Gender</td>
    <td>Profession</td>
    <td>Education Level</td>
    <td>&nbsp;</td>
    
    
    

  
  </tr>
 <?php $rownoo=$startrow_memberdetails; 

if (isset($_GET['searchdetailsid'])) {
mysql_select_db($database_church, $church);
$query_viewmemberdetails="SELECT *FROM member_details md  ";
$query_limit_viewmemberdetails  = sprintf("%s LIMIT %d, %d", $query_viewmemberdetails , $startRow_viewmemberdetails , $viewmemberdetails );
$viewmemberdetails  = mysql_query($query_limit_viewmemberdetails , $church) or die(mysql_error());
$row_viewmemberdetails = mysql_fetch_assoc($viewmemberdetails );

}
 
 
 
 
 
 do { 

$rownoo++;?> <tr  <?php if ($rownoo%2==0) { echo 'class="othereven"'; }else{echo 'class="otherodd"';}?> >
    
      <td><?php echo $rownoo; ?></td>
      <td><?php echo $row_memberdetails['lastname']; ?> <?php echo $row_memberdetails['firstname']; ?> <?php echo $row_memberdetails['middlename']; ?></td>
      <td><?php echo $row_memberdetails['locationname']; ?></td>
      <td><?php echo $row_memberdetails['statusname']; ?></td>
      <td><?php echo $row_memberdetails['gendername']; ?></td>
      <td><?php echo $row_memberdetails['profession_name']; ?> </td>
      <td><?php echo $row_memberdetails['level_name']; ?> </td>
<td width="10%"><a href="index.php?searchdetails=show &amp; searchdetailsid=<?php echo $row_memberdetails['memberid']?> ">All Details</a></td> 
     
</tr> <?php 
} while ($row_memberdetails = mysql_fetch_assoc($memberdetails)); ?>

 <tr>
   <td>&nbsp;</td>
   <td colspan="5">Viewing <strong><?php echo ($startrow_memberdetails + 1) ?></strong> to <strong><?php echo min($startrow_memberdetails + $maxRows_memberdetails, $totalRows_memberdetails) ?></strong> of <strong><?php echo $totalRows_memberdetails ?></strong> </td>
   <td>&nbsp;</td>
   <td colspan="3"><table width="100%" border="0" cellpadding="1" cellspacing="1">
     <tr>
     </tr>
   </table></td>
 
  
 </tr>
</table>
<?php } ?>
</div>
</body>
</html>
