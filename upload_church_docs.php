<?php 
include ('Connections/church.php');

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
  mysql_select_db($database_church, $church);
$query_member = "SELECT * FROM member_details  ORDER BY firstname";
$member  = mysql_query($query_member , $church) or die(mysql_error());
$row_member  = mysql_fetch_assoc($member );
$totalRows_member  = mysql_num_rows($member );

mysql_select_db($database_church, $church);
if ((isset($_GET['church_doc_id'])) && ($_GET['church_doc_id'] != "")) {

$query_thisdocument = "SELECT * FROM church_doc cd  WHERE cd.church_doc_id=".$_GET['church_doc_id']."";
$thisdocument = mysql_query($query_thisdocument, $church) or die(mysql_error());
$row_thisdocument = mysql_fetch_assoc($thisdocument);
$totalRows_thisdocument = mysql_num_rows($thisdocument);
}

 
 //Pic upload Сheck that we have a file
 if ((isset($_POST["Savepic"])) || (isset($_POST["Updatepic"]))) {
$whereto="index.php?church=true & #tabs-3";
if((!empty($_FILES["photo"])) && ($_FILES['photo']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 350Kb
  $filename = basename($_FILES['photo']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);
  
    //Determine the path to which we want to save this file
      $newname = dirname(__FILE__).'/church_docs/'.$filename;
      //Check if the file with the same name is already exists on the server
      if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($_FILES['photo']['tmp_name'],$newname))) {

			 $acad_id=$_GET['church_doc_id'];
			 $doc_title=$_POST['doc_title'];
 
if ((isset($_GET['church_doc_id'])) && ($_GET['church_doc_id'] != "")) {
  mysql_query("UPDATE church_doc SET church_doc_name='$filename', doc_title='$doc_title' WHERE church_doc_id=".$acad_id."");

           echo "It's done! The file has been Updated as: ".$newname;
		    

}else{	 mysql_query("INSERT INTO church_doc (doc_title, church_doc_name) VALUES ( $acad_id, '$doc_title')") ; 

				echo "Document successfully uploaded";
						     
           //echo "It's done! The file has been saved as: ".$newname;
}
header("Location:$whereto");
        } else {
           echo "Error: A problem occurred during file upload!";
		   ?>
		   <script type="text/javascript">
           alert('Error: A problem occurred during file upload!');
           </script>
		   <?php
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
	
if ((isset($_GET['church_doc_id'])) && ($_GET['church_doc_id'] != "") && isset($_POST['Deletepic'])) {
	$acad_id=$_GET['church_doc_id'];
$whereto="index.php?church=true & #tabs-3";
$image=$_POST['kakufutwo'];
    $full  = "scanned_docs/";
            if(file_exists($full.$image)){
                unlink($full.$image);
                $msg="file deleted";
        }else{$msg="file not found";}
 $delpic=@mysql_query("DELETE FROM church_docs WHERE church_doc_id=".$acad_id."")or die(mysql_error());

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
<?php 	if ((!isset($_GET['church_doc_id'])) && (!$_GET['church_doc_id'] != "")) {
?>
<table width="100%" border="1">
  <tr>
    <td>Document Title</td>
    <td><label>
      <input type="text" name="doc_title" id="doc_title" value="<?php echo $_POST['doc_title'];?>
" />
      </label></td>
  </tr>
  <tr>
    <td>Upload Document</td>
    <td><input type="file" name="photo" value="<?php echo $row_thispic['church_doc_name'];?>
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
      <td nowrap="nowrap" align="right">Document Title</td>
      <td><label>
      <input type="text" name="doc_title" id="doc_title" value="<?php echo $row_thispic['doc_title']?>;
" />
    </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Document:</td>
      <td><?php echo htmlentities($row_thispic['photo'], ENT_COMPAT, 'utf-8'); ?><input type="file" name="photo" value="<?php echo $row_thispic['church_doc_name'];?>
"/>
      <input name="kakufutwo" type="text" id="kakufutwo" value="<?php echo $row_thispic['church_doc_name'];?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update Photo" name="Updatepic" id="Updatepic" /> <input type="submit" value="Delete Photo" name="Deletepic" id="Deletepic" /></td>
    </tr>
  </table>
 
<?php }?></form> 

<p>&nbsp;</p>
</body>
</html>
<?php
@mysql_free_result($employees);

@mysql_free_result($thispic);
?>
