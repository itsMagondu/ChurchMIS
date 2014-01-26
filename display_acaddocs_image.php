<?php require_once('Connections/eims.php'); ?>
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

if ((isset($_GET['docid'])) && ($_GET['docid'] != "")) {
mysql_select_db($database_eims, $eims);
$query_thispic = "SELECT * FROM academic_docs WHERE acad_doc_id=".$_GET['docid']."";
$thispic = mysql_query($query_thispic, $eims) or die(mysql_error());
$row_thispic = mysql_fetch_assoc($thispic);
$totalRows_thispic = mysql_num_rows($thispic);
}
 


$currentPage = $_SERVER["PHP_SELF"];

$maxRows_pics = 1000;
$pageNum_pics = 0;
if (isset($_GET['pageNum_pics'])) {
  $pageNum_pics = $_GET['pageNum_pics'];
}
$startRow_pics = $pageNum_pics * $maxRows_pics;

mysql_select_db($database_eims, $eims);
$query_pics = "SELECT * FROM academic_docs ad INNER JOIN employees e ON e.employee_id=ad.employee_id";
$query_limit_pics = sprintf("%s LIMIT %d, %d", $query_pics, $startRow_pics, $maxRows_pics);
$pics = mysql_query($query_limit_pics, $eims) or die(mysql_error());
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
<title>Untitled Document</title>
</head>

<body>
<?php  if ((!isset($_GET['docid'])) && (!$_GET['docid'] != "")){
?><div class="allemployees">
<table border="1" align="center" width="100%">
  <tr>
    <td width="5%">No.</td>
    <td width="37%">Document Title</td>
    <td width="19%">Document</td>
    <td>&nbsp;</td>
   <td width="5%">&nbsp;</td>
  </tr>
        <?php $numrow=$startRow_pics; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
      <td><?php echo $row_pics['doc_title']; ?></td>
      <td><a href="scanned_docs/<?php echo $row_pics['acad_doc_name'];?>" >open</a></td>
            <td><a href="index.php?docid=<?php echo $row_pics['acad_doc_id']?>&pageNum_pics=<?php echo  $pageNum_pics ?> &member=true & #tabs-3">Edit</a></td>
            

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
        <a href="<?php printf("%s?pageNum_pics=%d%s", $currentPage, min($totalPages_pics, $pageNum_pics + 1), $queryString_pics); ?>& #tabs-3">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_pics < $totalPages_pics) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_pics=%d%s", $currentPage, $totalPages_pics, $queryString_pics); ?> & #tabs-3">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table></div>
Records <?php echo ($startRow_pics + 1) ?> to <?php echo min($startRow_pics + $maxRows_pics, $totalRows_pics) ?> of <?php echo $totalRows_pics ?><?php }else{echo "Uploadng Updates. . .. . . ";}?>
</body>
</html>
<?php
@mysql_free_result($pics);
@mysql_free_result($thispic);

?>
