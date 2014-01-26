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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


mysql_select_db($database_church, $church);
$query_employees = "SELECT * FROM member_details ORDER BY firstname";
$employees = mysql_query($query_employees, $church) or die(mysql_error());
$row_employees = mysql_fetch_assoc($employees);
$totalRows_employees = mysql_num_rows($employees);

if ((isset($_GET['memberid'])) && ($_GET['memberid'] != "")) {
mysql_select_db($database_church, $church);
$query_thispic = "SELECT * FROM member_photo mp INNER JOIN member_details md ON md.memberid=mp.memberid WHERE mp.member_photoid=".$_GET['memberid']."";
$thispic = mysql_query($query_thispic, $church) or die(mysql_error());
$row_thispic = mysql_fetch_assoc($thispic);
$totalRows_thispic = mysql_num_rows($thispic);
}
 
 //Pic upload Сheck that we have a file
 if ((isset($_POST["Savepic"])) || (isset($_POST["Updatepic"]))) {
	$whereto="index.php?member=true & #tabs-3";
if((!empty($_FILES["photo"])) && ($_FILES['photo']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 350Kb
  $filename = basename($_FILES['photo']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);
      //Determine the path to which we want to save this file
      $newname = dirname(__FILE__).'/photos/'.$filename;
      //Check if the file with the same name is already exists on the server
      if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($_FILES['photo']['tmp_name'],$newname))) {
			 $emp_id=$_POST['memberid']; 
 
 		if ((isset($_GET['memberid'])) && ($_GET['memberid'] != "")) {

  mysql_query("UPDATE member_photo SET photo='$filename' WHERE member_photoid=".$_GET['empid']."");

           echo "It's done! The file has been Updated as: ".$newname;
		     header("Location:$whereto");


}else{	 mysql_query("INSERT INTO member_photo (memberid, photo) VALUES ( $emp_id, '$filename')") ; 

				echo "Photo successfully uploaded";
           //echo "It's done! The file has been saved as: ".$newname;
}
 header("Location:$whereto");
        } else {
           echo "Error: A problem occurred during file upload!";
		    ?>
		   <script type="text/javascript">
           alert('Error: A problem occurred during file upload!');
           </script><?php
        }
      } else {
         echo "Error: File ".$_FILES["photo"]["name"]." already exists";
		  ?>
		   <script type="text/javascript">
           alert('Error: File <?php $_FILES["photo"]["name"]?> already exists. The file names have to be unique');
           </script>
		   <?php
      }
 
} else {
 echo "Error: No file uploaded";
  ?>
		   <script type="text/javascript">
           alert('Error: No file uploaded');
           </script>
		   <?php
}

}

//deleting
	
if ((isset($_GET['empid'])) && ($_GET['empid'] != "") && isset($_POST['Deletepic'])) {
	$acad_id=$_GET['empid'];
$whereto="index.php?upload_pic=true & #tabs-3";
$image=$_POST['kakufutwo'];
    $full  = "photos/";
            if(file_exists($full.$image)){
                unlink($full.$image);
                $msg="file deleted";
        }else{$msg="file not found";}
 $delpic=@mysql_query("DELETE FROM member_photo WHERE member_photoid=".$acad_id."")or die(mysql_error());

           echo $msg;
		     header("Location:$whereto");

 }


 ?> 



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>



<form enctype="multipart/form-data" action="" method="post">
<?php 	if ((!isset($_GET['member_photoid'])) && (!$_GET['member_photoid'] != "")) {
?>
<table width="100%" border="1">
  <tr>
    <td>Member</td>
    <td><label>
      <select name="memberid" id="memberid">
        <option value="-1" <?php if (!(strcmp(-1, $row_thispic['memberid']))) {echo "selected=\"selected\"";} ?>>Select Member</option>
        <?php
do {  
?>
        <option value="<?php echo $row_employees['memberid']?>"<?php if (!(strcmp($row_employees['memberid'], $row_thispic['memberid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_employees['firstname']?> <?php echo $row_employees['middlename']?> <?php echo $row_employees['lastname']?></option>
        <?php
} while ($row_employees = mysql_fetch_assoc($employees));
  $rows = mysql_num_rows($employees);
  if($rows > 0) {
      mysql_data_seek($employees, 0);
	  $row_employees = mysql_fetch_assoc($employees);
  }
?>
      </select>
    </label></td>
  </tr>
  <tr>
    <td>Upload photo</td>
    <td><input type="file" name="photo" value="<?php echo $row_thispic['photo'];?>;
"/></td>
  </tr>
  <tr>
    <td><input name="Savepic" type="submit" value="Savepic" id="Savepic"></td>
    <td>&nbsp;</td>
  </tr>
</table>


<?php 	}else {
?>
  <table align="center" width="100%">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Employee</td>
      <td><?php echo $row_thispic['lastname'];?> <?php echo $row_thispic['firstname'];?> <?php echo $row_thispic['middlename'];?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Photo:</td>
      <td><?php echo htmlentities($row_thispic['photo'], ENT_COMPAT, 'utf-8'); ?><input type="file" name="photo" value="<?php echo $row_thispic['photo'];?>;
"/>
      <input name="kakufutwo" type="text" id="kakufutwo" value="<?php echo $row_thispic['photo'];?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update Photo" name="Updatepic" id="Updatepic" />
      <input type="submit" value="Delete Photo" name="Deletepic" id="Deletepic" /></td>
    </tr>
  </table>
  <input type="hidden" name="memberid" value="<?php echo $row_thispic['memberid']; ?>" />
<?php }?>

</form> 
<p>&nbsp;</p>
</body>
</html>
<?php
@mysql_free_result($employees);

@mysql_free_result($thispic);
?>
