<?php require_once('Connections/church.php'); ?>
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

if ((isset($_GET['member_photoid'])) && ($_GET['member_photoid'] != "")) {
mysql_select_db($database_church, $church);


$query_thispic = "SELECT * FROM member_photo WHERE member_photoid=".$_GET['member_photoid']."";
$thispic = mysql_query($query_thispic, $church) or die(mysql_error());
$row_thispic = mysql_fetch_assoc($thispic);
$totalRows_thispic = mysql_num_rows($thispic);
}
 


$currentPage = $_SERVER["PHP_SELF"];

$maxRows_pics = 5;
$pageNum_pics = 0;
if (isset($_GET['pageNum_pics'])) {
  $pageNum_pics = $_GET['pageNum_pics'];
}
$startRow_pics = $pageNum_pics * $maxRows_pics;

mysql_select_db($database_church, $church);
$query_pics = "SELECT * FROM member_photo mp INNER JOIN member_details md ON md.memberid=mp.memberid INNER JOIN locality l ON md.localityid=l.localityid ";
$query_limit_pics = sprintf("%s LIMIT %d, %d", $query_pics, $startRow_pics, $maxRows_pics);
$pics = mysql_query($query_limit_pics, $church) or die(mysql_error());
$row_pics = mysql_fetch_assoc($pics);

if (isset($_GET['totalRows_pics'])) {
  $totalRows_pics = $_GET['totalRows_pics'];
} else {
  $all_pics = mysql_query($query_pics);
  $totalRows_pics = mysql_num_rows($all_pics);
}
$totalPages_pics = ceil($totalRows_pics/$maxRows_pics)-1;

$queryString_pics = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_pics") == false && 
        stristr($param, "totalRows_pics") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_pics = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_pics = sprintf("&totalRows_pics=%d%s", $totalRows_pics, $queryString_pics);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Pics</title>

<!--<script type="text/javascript" src="lightbox2.05/js/prototype.js"></script>
<script type="text/javascript" src="lightbox2.05/js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="lightbox2.05/js/lightbox.js"></script>
<link rel="stylesheet" href="lightbox2.05/css/lightbox.css" type="text/css" media="screen" />-->

<link href="eims.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table border="0" width="100%">
  <tr>
    <td>No.</td>
    <td>Member Names</td>
    <td>photo</td>
    <td>Locality</td>
     <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
        <?php $numrow=$startRow_pics; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
      <td width="20%"><?php echo $row_pics['lastname']; ?>  <?php echo $row_pics['firstname']; ?>  <?php echo $row_pics['middlename']; ?>   </td>
      <td><a href="photos/<?php echo $row_pics['photo']; ?>" id="header" rel="lightbox[staff]" title="<?php echo $row_pics['lastname']; ?>  <?php echo $row_pics['firstname']; ?>   <?php echo $row_pics['middlename']; ?> - <?php echo $row_pics['payroll_no']; ?> - <?php echo $row_pics['locationname']; ?> -  <?php echo $row_pics['department']; ?>"> <img src="photos/<?php echo $row_pics['photo']; ?>" alt="" name="picholder" width="150" height="150" />      
    </a>
            
       </td>
      <td><?php echo $row_pics['locationname']; ?></td>
     
            <td><a href="index.php?memberid=<?php echo $row_pics['member_photoid']?>&pageNum_pics=<?php echo  $pageNum_pics ?> & member=true & #tabs-3">Edit</a></td>
           <td><a href="index.php?memberid=<?php echo $row_pics['member_photoid']?>&pageNum_pics=<?php echo  $pageNum_pics ?> & member=true & #tabs-3">Delete</a></td>        

    </tr>
    <?php } while ($row_pics = mysql_fetch_assoc($pics)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_pics > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_pics=%d%s", $currentPage, 0, $queryString_pics); ?> & #tabs-3">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_pics > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_pics=%d%s", $currentPage, max(0, $pageNum_pics - 1), $queryString_pics); ?> & #tabs-3">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_pics < $totalPages_pics) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_pics=%d%s", $currentPage, min($totalPages_pics, $pageNum_pics + 1), $queryString_pics); ?> & #tabs-3">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_pics < $totalPages_pics) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_pics=%d%s", $currentPage, $totalPages_pics, $queryString_pics); ?>  & #tabs-3">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_pics + 1) ?> to <?php echo min($startRow_pics + $maxRows_pics, $totalRows_pics) ?> of <?php echo $totalRows_pics ?>
</body>
</html>
<?php
@mysql_free_result($pics);
@mysql_free_result($thispic);

?>
