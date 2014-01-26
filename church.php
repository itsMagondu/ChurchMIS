<?php include ('Connections/church.php'); ?>
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


if ((isset($_GET['Delete']) &&(isset($_GET['church_service_id'])) && ($_GET['church_service_id'] != ""))) {
	
	   $tab="index.php?church=true#tabs-1";
	$whereto=$tab;	
	
	
  $deleteSQL = sprintf("DELETE FROM church_service WHERE church_service_id=".($_GET['church_service_id'])."", 
                       GetSQLValueString($_GET['church_service_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}



if ((isset($_POST["saveservice"]))) {
	
	
	 $tab="index.php?church=true#tabs-1";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO church_service (church_service_id, service_name, service_description, service_start_time, service_end_time) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['church_service_id'], "int"),
                       GetSQLValueString($_POST['service_name'], "text"),
                       GetSQLValueString($_POST['service_description'], "text"),
                       GetSQLValueString($_POST['service_start_time'], "text"),
                       GetSQLValueString($_POST['service_end_time'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
    header("Location:$whereto");
}

if ((isset($_POST["updateservice"]))) {
	
	 $tab="index.php?church=true#tabs-1";
	$whereto=$tab;
  if ((isset($_GET['church_service_id'])) && ($_GET['church_service_id']!="")){
	
  $updateSQL = sprintf("UPDATE church_service SET service_name=%s, service_description=%s, service_start_time=%s, service_end_time=%s WHERE church_service_id=".$_GET['church_service_id']."",
                       GetSQLValueString($_POST['service_name'], "text"),
                       GetSQLValueString($_POST['service_description'], "text"),
                       GetSQLValueString($_POST['service_start_time'], "text"),
                       GetSQLValueString($_POST['service_end_time'], "text"),
                       GetSQLValueString($_POST['church_service_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
 header("Location:$whereto");
}

mysql_select_db($database_church, $church);
$query_addservice = "SELECT * FROM church_service";
$addservice = mysql_query($query_addservice, $church) or die(mysql_error());
$row_addservice = mysql_fetch_assoc($addservice);
$totalRows_addservice = mysql_num_rows($addservice);

if((isset($_GET['church_service_id'])) &&($_GET['church_service_id']!="")){
mysql_select_db($database_church, $church);
$query_editservice = "SELECT * FROM church_service WHERE church_service_id=".$_GET['church_service_id']."";
$editservice = mysql_query($query_editservice, $church) or die(mysql_error());
$row_editservice = mysql_fetch_assoc($editservice);
$totalRows_editservice = mysql_num_rows($editservice);
}
$maxRows_viewservice = 10;
$pageNum_viewservice = 0;
if (isset($_GET['pageNum_viewservice'])) {
  $pageNum_viewservice = $_GET['pageNum_viewservice'];
}
$startRow_viewservice = $pageNum_viewservice * $maxRows_viewservice;

mysql_select_db($database_church, $church);
$query_viewservice = "SELECT * FROM church_service";
$query_limit_viewservice = sprintf("%s LIMIT %d, %d", $query_viewservice, $startRow_viewservice, $maxRows_viewservice);
$viewservice = mysql_query($query_limit_viewservice, $church) or die(mysql_error());
$row_viewservice = mysql_fetch_assoc($viewservice);

if (isset($_GET['totalRows_viewservice'])) {
  $totalRows_viewservice = $_GET['totalRows_viewservice'];
} else {
  $all_viewservice = mysql_query($query_viewservice);
  $totalRows_viewservice = mysql_num_rows($all_viewservice);
}
$totalPages_viewservice = ceil($totalRows_viewservice/$maxRows_viewservice)-1;

$queryString_viewservice = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewservice") == false && 
        stristr($param, "totalRows_viewservice") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewservice = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewservice = sprintf("&totalRows_viewservice=%d%s", $totalRows_viewservice, $queryString_viewservice);


if ((isset($_GET['Delete']) &&(isset($_GET['church_id'])) && ($_GET['church_id'] != ""))) {
	
	   $tab="index.php?church=true#tabs-2";
	$whereto=$tab;	
	
	
  $deleteSQL = sprintf("DELETE FROM church_info WHERE church_id=".($_GET['church_id'])."", 
                       GetSQLValueString($_GET['church_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}



if ((isset($_POST["savechurch"]))) {
	$tab="index.php?church=true#tabs-2";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO church_info (church_id, church_name, church_vision, church_mission, strategic_objectives, address, town, telephone, mobile) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['church_id'], "int"),
                       GetSQLValueString($_POST['church_name'], "text"),
                       GetSQLValueString($_POST['church_vision'], "text"),
                       GetSQLValueString($_POST['church_mission'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['town'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['mobile'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}

if ((isset($_POST["updatechurch"]))) {
	
	 $tab="index.php?church=true#tabs-2";
	$whereto=$tab;
	
	
	 if ((isset($_GET['church_id'])) && ($_GET['church_id']!="")){
	
	
  $updateSQL = sprintf("UPDATE church_info SET church_name=%s, church_vision=%s, church_mission=%s,address=%s, town=%s, telephone=%s, mobile=%s WHERE church_id=".$_GET['church_id']."",
                       GetSQLValueString($_POST['church_name'], "text"),
                       GetSQLValueString($_POST['church_vision'], "text"),
                       GetSQLValueString($_POST['church_mission'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['town'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['mobile'], "text"),
                       GetSQLValueString($_POST['church_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

   header("Location:$whereto");
}

mysql_select_db($database_church, $church);
$query_addinfo = "SELECT * FROM church_info";
$addinfo = mysql_query($query_addinfo, $church) or die(mysql_error());
$row_addinfo = mysql_fetch_assoc($addinfo);
$totalRows_addinfo = mysql_num_rows($addinfo);

mysql_select_db($database_church, $church);
$query_editinfo = "SELECT * FROM church_info";
$editinfo = mysql_query($query_editinfo, $church) or die(mysql_error());
$row_editinfo = mysql_fetch_assoc($editinfo);
$totalRows_editinfo = mysql_num_rows($editinfo);

$maxRows_viewinfo = 10;
$pageNum_viewinfo = 0;
if (isset($_GET['pageNum_viewinfo'])) {
  $pageNum_viewinfo = $_GET['pageNum_viewinfo'];
}
$startRow_viewinfo = $pageNum_viewinfo * $maxRows_viewinfo;

mysql_select_db($database_church, $church);
$query_viewinfo = "SELECT * FROM church_info";
$query_limit_viewinfo = sprintf("%s LIMIT %d, %d", $query_viewinfo, $startRow_viewinfo, $maxRows_viewinfo);
$viewinfo = mysql_query($query_limit_viewinfo, $church) or die(mysql_error());
$row_viewinfo = mysql_fetch_assoc($viewinfo);

if (isset($_GET['totalRows_viewinfo'])) {
  $totalRows_viewinfo = $_GET['totalRows_viewinfo'];
} else {
  $all_viewinfo = mysql_query($query_viewinfo);
  $totalRows_viewinfo = mysql_num_rows($all_viewinfo);
}
$totalPages_viewinfo = ceil($totalRows_viewinfo/$maxRows_viewinfo)-1;

$queryString_viewinfo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewinfo") == false && 
        stristr($param, "totalRows_viewinfo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewinfo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewinfo = sprintf("&totalRows_viewinfo=%d%s", $totalRows_viewinfo, $queryString_viewinfo);


if ((isset($_GET['Delete']) &&(isset($_GET['objectives_id'])) && ($_GET['objectives_id'] != ""))) {
	
	   $tab="index.php?church=true#tabs-4";
	$whereto=$tab;	
	
	
  $deleteSQL = sprintf("DELETE FROM church_objective WHERE objectives_id=".($_GET['objectives_id'])."", 
                       GetSQLValueString($_GET['objectives_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}




if ((isset($_POST["saveobjective"]))) {
	
		 $tab="index.php?church=true#tabs-4";
	$whereto=$tab;
	
	
  $insertSQL = sprintf("INSERT INTO church_objective (objectives_id, objective_name, date_stipulated, date_achieved, department_id) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['objectives_id'], "int"),
                       GetSQLValueString($_POST['objective_name'], "text"),
                       GetSQLValueString($_POST['date_stipulated'], "text"),
                       GetSQLValueString($_POST['date_achieved'], "text"),
                       GetSQLValueString($_POST['department_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}

if ((isset($_POST["updateobjective"]))) {
	


  	 $tab="index.php?church=true#tabs-4";
	$whereto=$tab;	
 if ((isset($_GET['objectives_id'])) && ($_GET['objectives_id']!="")){
	
  $updateSQL = sprintf("UPDATE church_objective SET objective_name=%s, date_stipulated=%s, date_achieved=%s, department_id=%s WHERE objectives_id=".$_GET['objectives_id']."",
                       GetSQLValueString($_POST['objective_name'], "text"),
                       GetSQLValueString($_POST['date_stipulated'], "text"),
                       GetSQLValueString($_POST['date_achieved'], "text"),
                       GetSQLValueString($_POST['department_id'], "int"),
                       GetSQLValueString($_POST['objectives_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
   header("Location:$whereto");
}

}

mysql_select_db($database_church, $church);
$query_addobjective = "SELECT * FROM church_objective";
$addobjective = mysql_query($query_addobjective, $church) or die(mysql_error());
$row_addobjective = mysql_fetch_assoc($addobjective);
$totalRows_addobjective = mysql_num_rows($addobjective);

mysql_select_db($database_church, $church);
$query_editobjective = "SELECT * FROM church_objective";
$editobjective = mysql_query($query_editobjective, $church) or die(mysql_error());
$row_editobjective = mysql_fetch_assoc($editobjective);
$totalRows_editobjective = mysql_num_rows($editobjective);

$maxRows_viewobjective = 10;
$pageNum_viewobjective = 0;
if (isset($_GET['pageNum_viewobjective'])) {
  $pageNum_viewobjective = $_GET['pageNum_viewobjective'];
}
$startRow_viewobjective = $pageNum_viewobjective * $maxRows_viewobjective;

mysql_select_db($database_church, $church);
$query_viewobjective = "SELECT * FROM church_objective";
$query_limit_viewobjective = sprintf("%s LIMIT %d, %d", $query_viewobjective, $startRow_viewobjective, $maxRows_viewobjective);
$viewobjective = mysql_query($query_limit_viewobjective, $church) or die(mysql_error());
$row_viewobjective = mysql_fetch_assoc($viewobjective);

if (isset($_GET['totalRows_viewobjective'])) {
  $totalRows_viewobjective = $_GET['totalRows_viewobjective'];
} else {
  $all_viewobjective = mysql_query($query_viewobjective);
  $totalRows_viewobjective = mysql_num_rows($all_viewobjective);
}
$totalPages_viewobjective = ceil($totalRows_viewobjective/$maxRows_viewobjective)-1;

$queryString_viewobjective = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewobjective") == false && 
        stristr($param, "totalRows_viewobjective") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewobjective = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewobjective = sprintf("&totalRows_viewobjective=%d%s", $totalRows_viewobjective, $queryString_viewobjective);


if ((isset($_POST["savedepartment"]))) {
	
	 $tab="index.php?church=true#tabs-3";
	$whereto=$tab;
	
	
  $insertSQL = sprintf("INSERT INTO departments (department_id, department_name, department_head, department_objective) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['department_id'], "int"),
                       GetSQLValueString($_POST['department_name'], "text"),
                       GetSQLValueString($_POST['department_head'], "text"),
                       GetSQLValueString($_POST['department_objective'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}

if ((isset($_POST["updatedepartment"]))) {
	
	 $tab="index.php?church=true#tabs-3";
	$whereto=$tab;
	
	 if ((isset($_GET['memberid'])) && ($_GET['memberid']!="")){
  $updateSQL = sprintf("UPDATE departments SET department_name=%s, department_head=%s, department_objective=%s WHERE department_id=".$_GET['department_id']."",
                       GetSQLValueString($_POST['department_name'], "text"),
                       GetSQLValueString($_POST['department_head'], "text"),
                       GetSQLValueString($_POST['department_objective'], "text"),
                       GetSQLValueString($_POST['department_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());

     header("Location:$whereto");
}


}
mysql_select_db($database_church, $church);
$query_adddeparrtment = "SELECT * FROM departments";
$adddeparrtment = mysql_query($query_adddeparrtment, $church) or die(mysql_error());
$row_adddeparrtment = mysql_fetch_assoc($adddeparrtment);
$totalRows_adddeparrtment = mysql_num_rows($adddeparrtment);

if((isset($_GET['department_id'])) &&($_GET['department_id']!="")){
mysql_select_db($database_church, $church);
$query_editdepartment = "SELECT * FROM departments  WHERE department_id=".$_GET['department_id']."";
$editdepartment = mysql_query($query_editdepartment, $church) or die(mysql_error());
$row_editdepartment = mysql_fetch_assoc($editdepartment);
$totalRows_editdepartment = mysql_num_rows($editdepartment);
}
$maxRows_viewdepartment = 10;
$pageNum_viewdepartment = 0;
if (isset($_GET['pageNum_viewdepartment'])) {
  $pageNum_viewdepartment = $_GET['pageNum_viewdepartment'];
}
$startRow_viewdepartment = $pageNum_viewdepartment * $maxRows_viewdepartment;

mysql_select_db($database_church, $church);
$query_viewdepartment = "SELECT * FROM departments";
$query_limit_viewdepartment = sprintf("%s LIMIT %d, %d", $query_viewdepartment, $startRow_viewdepartment, $maxRows_viewdepartment);
$viewdepartment = mysql_query($query_limit_viewdepartment, $church) or die(mysql_error());
$row_viewdepartment = mysql_fetch_assoc($viewdepartment);

if (isset($_GET['totalRows_viewdepartment'])) {
  $totalRows_viewdepartment = $_GET['totalRows_viewdepartment'];
} else {
  $all_viewdepartment = mysql_query($query_viewdepartment);
  $totalRows_viewdepartment = mysql_num_rows($all_viewdepartment);
}
$totalPages_viewdepartment = ceil($totalRows_viewdepartment/$maxRows_viewdepartment)-1;

$queryString_viewdepartment = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewdepartment") == false && 
        stristr($param, "totalRows_viewdepartment") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewdepartment = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewdepartment = sprintf("&totalRows_viewdepartment=%d%s", $totalRows_viewdepartment, $queryString_viewdepartment);






if ((isset($_GET['policyid'])) && ($_GET['policyid'] != "")) {

mysql_select_db($database_church, $church);
$query_thispic = "SELECT * FROM policy WHERE p.policyid=".$_GET['policyid']."";
$thispic = mysql_query($query_thispic, $church) or die(mysql_error());
$row_thispic = mysql_fetch_assoc($thispic);
$totalRows_thispic = mysql_num_rows($thispic);
}


if ((isset($_POST["saveprofile"]))) {
  $insertSQL = sprintf("INSERT INTO policy (policy_doc_title, policy_doc_name) VALUES (%s, %s)",
                       GetSQLValueString($_POST['policy_doc_title'], "text"),
                       GetSQLValueString($_POST['policy_doc_name'], "text"));
                     

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
}
 
 //Pic upload Сheck that we have a file
 if ((isset($_POST["updateprofile"]))) {
$whereto="index.php?church=true & #tabs-5";
if((!empty($_FILES["photo"])) && ($_FILES['photo']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 350Kb
  $filename = basename($_FILES['photo']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);
  
    //Determine the path to which we want to save this file
      $newname = dirname(__FILE__).'/policy_docs/'.$filename;
      //Check if the file with the same name is already exists on the server
      if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($_FILES['photo']['tmp_name'],$newname))) {
			
		 
			 $acad_id=$_GET['policyid'];
			 $doc_title=$_POST['policy_doc_title'];
			 $filename=$_POST['policy_doc_name'];
 
if ((isset($_GET['policyid'])) && ($_GET['policyid'] != "")) {
  mysql_query("UPDATE policy SET policy_doc_name='$filename', policy_doc_title='$policytitle' WHERE policyid=".$policyid."");

           echo "It's done! The file has been Updated as: ".$newname;
		    }else{  

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
	
if ((isset($_GET['policyid'])) && ($_GET['policyid'] != "") && isset($_POST['Deletepic'])) {
	$acad_id=$_GET['policyid'];
$whereto="index.php?church=true & #tabs-5";
$image=$_POST['kakufutwo'];
    $full  = "scanned_docs/";
            if(file_exists($full.$image)){
                unlink($full.$image);
                $msg="file deleted";
        }else{$msg="file not found";}
 $delpic=@mysql_query("DELETE FROM policy WHERE policyid=".$acad_id."")or die(mysql_error());

           echo $msg;
		     header("Location:$whereto");

 }



if ((isset($_POST["savelocation"]))) {
	
	$tab="index.php?locality=true#tabs-6";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO locality (locationname, locationdescription,locationmission) VALUES (%s, %s,%s)",                         
                      GetSQLValueString($_POST['locationname'], "text"),
                      GetSQLValueString($_POST['locationdescription'], "text"),
					  GetSQLValueString($_POST['locationmission'], "text"));
					   

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
}

if ((isset($_POST["updatelocation"]))) {
	
if(isset($_GET['localityid']) && ($_GET['localityid']=!"")){
 
     
		$tab="index.php?locality=true#tabs-6";
	$whereto=$tab;
	

  $updateSQL = sprintf("UPDATE locality SET locationname=%s, locationdescription=%s,locationmission=%s WHERE localityid=".($_GET['localityid'])."",
                       GetSQLValueString($_POST['locationname'], "text"),
                       GetSQLValueString($_POST['locationdescription'], "text"),
					     GetSQLValueString($_POST['locationmission'], "text"),
                       GetSQLValueString($_POST['localityid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

 header("Location:$whereto");

}

if (($_GET['Delete']) && (isset($_GET['localityid'])) && ($_GET['localityid'] != "")) {
	
  $deleteSQL = sprintf("DELETE FROM locality WHERE localityid=".$_GET['localityid']."",
                       GetSQLValueString($_GET['localityid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());

  header("Location:$whereto");

}

mysql_select_db($database_church, $church);
$query_addlocality = "SELECT * FROM locality";
$addlocality = mysql_query($query_addlocality, $church) or die(mysql_error());
$row_addlocality = mysql_fetch_assoc($addlocality);
$totalRows_addlocality = mysql_num_rows($addlocality);

if(isset($_GET['localityid']) && ($_GET['localityid']=!"")){
mysql_select_db($database_church, $church);
$query_editlocality = "SELECT * FROM locality WHERE localityid=".$_GET['localityid']."";
$editlocality = mysql_query($query_editlocality, $church) or die(mysql_error());
$row_editlocality = mysql_fetch_assoc($editlocality);
$totalRows_editlocality = mysql_num_rows($editlocality);
}
$maxRows_viewlocality = 10;
$pageNum_viewlocality = 0;
if (isset($_GET['pageNum_viewlocality'])) {
  $pageNum_viewlocality = $_GET['pageNum_viewlocality'];
}
$startRow_viewlocality = $pageNum_viewlocality * $maxRows_viewlocality;

mysql_select_db($database_church, $church);
$query_viewlocality = "SELECT * FROM locality";
$query_limit_viewlocality = sprintf("%s LIMIT %d, %d", $query_viewlocality, $startRow_viewlocality, $maxRows_viewlocality);
$viewlocality = mysql_query($query_limit_viewlocality, $church) or die(mysql_error());
$row_viewlocality = mysql_fetch_assoc($viewlocality);

if (isset($_GET['totalRows_viewlocality'])) {
  $totalRows_viewlocality = $_GET['totalRows_viewlocality'];
} else {
  $all_viewlocality = mysql_query($query_viewlocality);
  $totalRows_viewlocality = mysql_num_rows($all_viewlocality);
}
$totalPages_viewlocality = ceil($totalRows_viewlocality/$maxRows_viewlocality)-1;

$queryString_viewlocality = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewlocality") == false && 
        stristr($param, "totalRows_viewlocality") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewlocality = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewlocality = sprintf("&totalRows_viewlocality=%d%s", $totalRows_viewlocality, $queryString_viewlocality);






if ((isset($_GET['representative_id'])) && ($_GET['representative_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM representative WHERE representative_id=%s",
                       GetSQLValueString($_GET['representative_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_GET['Delete']) &&(isset($_GET['representative_id'])) && ($_GET['representative_id'] != ""))) {
	
	   $tab="index.php?locality=true#tabs-7";
	$whereto=$tab;	
	
  $deleteSQL = sprintf("DELETE FROM representative WHERE representative_id=".($_GET['representative_id'])."",
                       GetSQLValueString($_GET['representative_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($deleteSQL, $church) or die(mysql_error());
   header("Location:$whereto");
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["saverep"]))) {
	
	 
		$tab="index.php?locality=true#tabs-7";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO representative (representative_id, localityid, residence_chair, residence_secretary, residence_treasurer) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['representative_id'], "int"),
                       GetSQLValueString($_POST['localityid'], "int"),
                       GetSQLValueString($_POST['residence_chair'], "text"),
                       GetSQLValueString($_POST['residence_secretary'], "text"),
                       GetSQLValueString($_POST['residence_treasurer'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}

if ((isset($_POST["updaterep"]))) {
	
	
		$tab="index.php?locality=true#tabs-7";
	$whereto=$tab;
	
if ((isset($_GET['representative_id'])) && ($_GET['representative_id']!="")){	
	
  $updateSQL = sprintf("UPDATE representative SET localityid=%s, residence_chair=%s, residence_secretary=%s, residence_treasurer=%s WHERE representative_id=".$_GET['representative_id']."",
                       GetSQLValueString($_POST['localityid'], "int"),
                       GetSQLValueString($_POST['residence_chair'], "text"),
                       GetSQLValueString($_POST['residence_secretary'], "text"),
                       GetSQLValueString($_POST['residence_treasurer'], "text"),
                       GetSQLValueString($_POST['representative_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}

}

mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

mysql_select_db($database_church, $church);
$query_addlocality = "SELECT * FROM locality";
$addlocality = mysql_query($query_addlocality, $church) or die(mysql_error());
$row_addlocality = mysql_fetch_assoc($addlocality);
$totalRows_addlocality = mysql_num_rows($addlocality);

if((isset($_GET['representative_id']) && ($_GET['representative_id']!=""))){	
	
mysql_select_db($database_church, $church);
$query_editrepresentative = "SELECT * FROM representative r  WHERE r.representative_id=".($_GET['representative_id'])."";
$editrepresentative = mysql_query($query_editrepresentative, $church) or die(mysql_error());
$row_editrepresentative = mysql_fetch_assoc($editrepresentative);
$totalRows_editrepresentative = mysql_num_rows($editrepresentative);
}
$maxRows_viewrepresentative = 10;
$pageNum_viewrepresentative = 0;
if (isset($_GET['pageNum_viewrepresentative'])) {
  $pageNum_viewrepresentative = $_GET['pageNum_viewrepresentative'];
}
$startRow_viewrepresentative = $pageNum_viewrepresentative * $maxRows_viewrepresentative;

mysql_select_db($database_church, $church);
$query_viewrepresentative = "SELECT * FROM representative r INNER JOIN locality l ON l.localityid=r.localityid";
$query_limit_viewrepresentative = sprintf("%s LIMIT %d, %d", $query_viewrepresentative, $startRow_viewrepresentative, $maxRows_viewrepresentative);
$viewrepresentative = mysql_query($query_limit_viewrepresentative, $church) or die(mysql_error());
$row_viewrepresentative = mysql_fetch_assoc($viewrepresentative);

if (isset($_GET['totalRows_viewrepresentative'])) {
  $totalRows_viewrepresentative = $_GET['totalRows_viewrepresentative'];
} else {
  $all_viewrepresentative = mysql_query($query_viewrepresentative);
  $totalRows_viewrepresentative = mysql_num_rows($all_viewrepresentative);
}
$totalPages_viewrepresentative = ceil($totalRows_viewrepresentative/$maxRows_viewrepresentative)-1;

$queryString_viewrepresentative = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewrepresentative") == false && 
        stristr($param, "totalRows_viewrepresentative") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewrepresentative = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewrepresentative = sprintf("&totalRows_viewrepresentative=%d%s", $totalRows_viewrepresentative, $queryString_viewrepresentative);





 mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember)



  
  






?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CHURCH DETAILS</title>

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
<link rel="stylesheet" href="/st_peters/jquery-ui-timepicker/jquery.ui.timepicker.css?v=0.3.0" type="text/css"/>

 <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery-1.5.1.min.js"></script>
  
 <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery.ui.core.min.js"></script>
    
  <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery.ui.widget.min.js"></script>
    
   <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery.ui.tabs.min.js"></script>
    
    
 <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/include/jquery.ui.position.min.js"></script>
     
   <script type="text/javascript" src="/st_peters/jquery-ui-timepicker/jquery.ui.timepicker.js?v=0.3.0"></script>
    <link type="text/css" href="/st_peters/js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet"/>

<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.core.js"></script>
    
   <script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.datepicker.js"></script>
    
 

    

<script type="text/javascript">
            $(document).ready(function() {
                $('#timepicker_start').timepicker({
                    showLeadingZero: false,
					showNowButton: true,
					
                });
                $('#timepicker_end').timepicker({
                    showLeadingZero: false,
					showNowButton: true,
					onHourShow: tpEndOnHourShowCallback,
                    onMinuteShow: tpEndOnMinuteShowCallback

                });
            });

            function tpStartOnHourShowCallback(hour) {
                var tpEndHour = $('#timepicker_end').timepicker('getHour');
                // Check if proposed hour is prior or equal to selected end time hour
                if (hour <= tpEndHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpStartOnMinuteShowCallback(hour, minute) {
                var tpEndHour = $('#timepicker_end').timepicker('getHour');
                var tpEndMinute = $('#timepicker_end').timepicker('getMinute');
                // Check if proposed hour is prior to selected end time hour
                if (hour < tpEndHour) { return true; }
                // Check if proposed hour is equal to selected end time hour and minutes is prior
                if ( (hour == tpEndHour) && (minute < tpEndMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
            }

            function tpEndOnHourShowCallback(hour) {
                var tpStartHour = $('#timepicker_start').timepicker('getHour');
                // Check if proposed hour is after or equal to selected start time hour
                if (hour >= tpStartHour) { return true; }
                // if hour did not match, it can not be selected
                return false;
            }
            function tpEndOnMinuteShowCallback(hour, minute) {
                var tpStartHour = $('#timepicker_start').timepicker('getHour');
                var tpStartMinute = $('#timepicker_start').timepicker('getMinute');
                // Check if proposed hour is after selected start time hour
                if (hour > tpStartHour) { return true; }
                // Check if proposed hour is equal to selected start time hour and minutes is after
                if ( (hour == tpStartHour) && (minute > tpStartMinute) ) { return true; }
                // if minute did not match, it can not be selected
                return false;
            }
				function OnHourShowCallback(hour) {
    if ((hour > 18) || (hour < 7)) {
        return false; // not valid
    }
    return true; // valid
}
function OnMinuteShowCallback(hour, minute) {
    if ((hour == 18) && (minute >= 30)) { return false; } // not valid
    if ((hour == 7) && (minute < 30)) { return false; }   // not valid
    return true;  // valid
}

        </script>



<script type="text/javascript">
	$(function() {
		$('#date_stipulated').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
			
		});
		$('#date_achieved').datepicker({
		  
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#fire').datepicker({
            //minDate: '+120m',	  
	         //   minDate: new Date(), 

			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob2').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob3').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob3').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#dob4').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#trainfrom').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#trainto').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#promodate').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#awarddate').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#acad_from').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#acad_to').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#emp_from').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
		});
		$('#emp_to').datepicker({
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
</head>

</head>
<body>
<div class="bodytext">
<div id="tabs">
<ul>    <li><a href="#tabs-1">Church  Service</a></li> 
		<li><a href="#tabs-2">Church  Details</a></li>
        <li><a href="#tabs-3">Departments</a></li>
        <li><a href="#tabs-4">Important Documents</a></li>
        <li><a href="#tabs-5">Cell Group</a></li> 
        <li><a href="#tabs-6">Cell Group Representative</a></li> 
     


</ul>


<div id="tabs-1">

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service_name:</td>
      <td><input type="text" name="service_name" value="<?php echo htmlentities($row_editservice['service_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" Valign="top">Service_description:</td>
      <td><textarea name="service_description" id="service_description" cols="45" rows="5"><?php echo $row_editservice['service_description'] ?></textarea>
      
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service_start_time:</td>
      <td><input type="text" name="service_start_time" id="timepicker_start"  value="<?php echo htmlentities($row_editservice['service_start_time'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service_end_time:</td>
      <td><input type="text" name="service_end_time" id="timepicker_end" value="<?php echo htmlentities($row_editservice['service_end_time'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['church_service_id'])) &&($_GET['church_service_id']!="")) {?><input type="submit" value="Update" name="updateservice"><?php } else  {?><input type="submit" value="Save" name="saveservice"><?php }?>
      </td>
    </tr>
  </table>
  
  <p>&nbsp;
  <table border="1" align="center">
    <tr>
   
     <td width="2%">No</td>
       <td width="10%">Service Name</td>
       <td width="8%">Service Description</td>
      <td width="6%">Service Start Time</td>
      <td width="6%">Service End Time</td>
       <td width="2%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
    </tr>
    <?php do { $service++; ?>
      <tr>
        <td><?php echo $service; ?></td>
        <td><?php echo $row_viewservice['service_name']; ?>&nbsp; </td>
        <td><?php echo $row_viewservice['service_description']; ?>&nbsp; </td>
        <td><?php echo $row_viewservice['service_start_time']; ?>&nbsp; </td>
        <td><?php echo $row_viewservice['service_end_time']; ?>&nbsp; </td>
        
       <td><a href="index.php?church=show&church_service _id=<?php echo $row_viewservice['church_service_id']; ?>"> Edit </a></td>
                  
   <td><a href="index.php?church=show & church_service _id=<?php echo $row_viewservice['church_service_id'];?> & Delete=1" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
      </tr>
      <?php } while ($row_viewservice = mysql_fetch_assoc($viewservice)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewservice > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewservice=%d%s", $currentPage, 0, $queryString_viewservice); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewservice > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewservice=%d%s", $currentPage, max(0, $pageNum_viewservice - 1), $queryString_viewservice); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewservice < $totalPages_viewservice) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewservice=%d%s", $currentPage, min($totalPages_viewservice, $pageNum_viewservice + 1), $queryString_viewservice); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewservice < $totalPages_viewservice) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewservice=%d%s", $currentPage, $totalPages_viewservice, $queryString_viewservice); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewservice + 1) ?> to <?php echo min($startRow_viewservice + $maxRows_viewservice, $totalRows_viewservice) ?> of <?php echo $totalRows_viewservice ?>
</p>
</form>
</div>

<div id="tabs-2">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Church Name:</td>
      <td><input type="text" name="church_name" value="<?php echo htmlentities($row_editinfo['church_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
       <td valign="top" nowrap="nowrap" align="right">Church Vision:</td>
      <td>
      <textarea name="church_vision" id="church_vision" cols="45" rows="5"><?php echo $row_editinfo['church_vision'] ?></textarea>  
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" Valign="top">Church Mission:</td>
      <td>
      
            <textarea name="church_mission" id="church_mission" cols="45" rows="5"><?php echo $row_editinfo['church_mission'] ?></textarea>  
      
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Address:</td>
      <td><input type="text" name="address" value="<?php echo htmlentities($row_editinfo['address'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Town:</td>
      <td><input type="text" name="town" value="<?php echo htmlentities($row_editinfo['town'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Telephone:</td>
      <td><input type="text" name="telephone" value="<?php echo htmlentities($row_editinfo['telephone'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Mobile:</td>
      <td><input type="text" name="mobile" value="<?php echo htmlentities($row_editinfo['mobile'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['church_id'])) &&($_GET['church_id']!="")) {?><input type="submit" value="Update" name="updatechurch"><?php } else  {?><input type="submit" value="Save" name="savechurch"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>
  
  
 
       <td width="2%">No</td>
       <td width="8%">Church Name</td>
       <td width="8%">Church Vision</td>
      <td width="8%">Church Mission</td>
    
       <td width="8%">Address</td>
       <td width="8%">Town</td>
       <td width="8%">Telephone</td>
       <td width="8%">Mobile</td>
     <td width="2%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
  </tr>
  <?php  $church=0; do { $church++; ?>
    <tr>
      <td> <?php echo $church; ?></td>
      <td><?php echo $row_viewinfo['church_name']; ?>&nbsp; </td>
      <td><?php echo $row_viewinfo['church_vision']; ?>&nbsp; </td>
      <td><?php echo $row_viewinfo['church_mission']; ?>&nbsp; </td>
    
      <td><?php echo $row_viewinfo['address']; ?>&nbsp; </td>
      <td><?php echo $row_viewinfo['town']; ?>&nbsp; </td>
      <td><?php echo $row_viewinfo['telephone']; ?>&nbsp; </td>
      <td><?php echo $row_viewinfo['mobile']; ?>&nbsp; </td>
            
         <td><a href="index.php?church=show&church_id=<?php echo $row_viewcontact['church_id']; ?>& #tabs-2"> Edit </a></td> 
           
 <td><a href="index.php?church=show & church_id=<?php echo $row_viewcontact['church_id'];?> & Delete=1 &#tabs-2" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
      
    </tr>
    <?php } while ($row_viewinfo = mysql_fetch_assoc($viewinfo)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewinfo > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewinfo=%d%s", $currentPage, 0, $queryString_viewinfo); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewinfo > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewinfo=%d%s", $currentPage, max(0, $pageNum_viewinfo - 1), $queryString_viewinfo); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewinfo < $totalPages_viewinfo) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewinfo=%d%s", $currentPage, min($totalPages_viewinfo, $pageNum_viewinfo + 1), $queryString_viewinfo); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewinfo < $totalPages_viewinfo) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewinfo=%d%s", $currentPage, $totalPages_viewinfo, $queryString_viewinfo); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewinfo + 1) ?> to <?php echo min($startRow_viewinfo + $maxRows_viewinfo, $totalRows_viewinfo) ?> of <?php echo $totalRows_viewinfo ?>
</div>

<div id="tabs-3">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Department Name:</td>
      <td><input type="text" name="department_name" value="<?php echo htmlentities($row_editdepartment['department_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Department Head:</td>
       
      
      <td>
      <input name="memberid" value="<?php echo $row_editdepartment['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['contactid'])) && ($_GET['contactid'] != "")){ echo $row_editdepartment['lastname'] ;?>&nbsp;<?php echo $row_editdepartment['middlename'] ;?> &nbsp;<?php echo $row_editdepartment['firstname'] ; } else {?>
      <select name="memberid" selected="selected">  
      <option value="-1" <?php if (!(strcmp(-1, $row_editdepartment['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>
  <?php
do {  
?>
  <option  size="32"value="<?php echo $row_addmember['memberid']?>"><?php echo $row_addmember['lastname']?>&nbsp;<?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?></option>
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));
  $rows = mysql_num_rows($addmember);
  if($rows > 0) {
      mysql_data_seek($addmember, 0);
	  $row_addmember = mysql_fetch_assoc($addmember);
  }
?>         
</select><?php }?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top">Department Objective:</td>
      <td><textarea name="department_objective" id="department_objective" cols="45" rows="5"><?php echo $row_editdepartment['department_objective'] ?></textarea>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['department_id'])) &&($_GET['department_id']!="")) {?><input type="submit" value="Update" name="updatedepartment"><?php } else  {?><input type="submit" value="Save" name="savedepartment"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>
     <td width="2%">No</td>
    <td width="8%">Department Name</td>
    <td width="8%">Department Head</td>
    <td width="8%">Department Objective</td>
     <td width="4%">&nbsp;</td>
     <td width="4%">&nbsp;</td>
  </tr>
  <?php  do { $department++; ?>
    <tr>
      <td><?php echo $department ; ?></td>
      <td><?php echo $row_viewdepartment['department_name']; ?>&nbsp; </td>
      <td><?php echo $row_viewdepartment['department_head']; ?>&nbsp; </td>
      <td><?php echo $row_viewdepartment['department_objective']; ?>&nbsp; </td>
               <td><a href="index.php?church=show&department_id=<?php echo $row_viewdepartment['memberid']; ?>& #tabs-3"> Edit </a></td> 
           
 <td><a href="index.php?church=show & department_id=<?php echo $row_viewdepartment['memberid'];?> & Delete=1 &#tabs-3" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
      
      
    </tr>
    <?php } while ($row_viewdepartment = mysql_fetch_assoc($viewdepartment)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewdepartment > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewdepartment=%d%s", $currentPage, 0, $queryString_viewdepartment); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewdepartment > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewdepartment=%d%s", $currentPage, max(0, $pageNum_viewdepartment - 1), $queryString_viewdepartment); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewdepartment < $totalPages_viewdepartment) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewdepartment=%d%s", $currentPage, min($totalPages_viewdepartment, $pageNum_viewdepartment + 1), $queryString_viewdepartment); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewdepartment < $totalPages_viewdepartment) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewdepartment=%d%s", $currentPage, $totalPages_viewdepartment, $queryString_viewdepartment); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewdepartment + 1) ?> to <?php echo min($startRow_viewdepartment + $maxRows_viewdepartment, $totalRows_viewdepartment) ?> of <?php echo $totalRows_viewdepartment ?>

</div>



	<div id="tabs-4">
		<p>Upload Church Documents</p>
        
        <table width="100%" class="content">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td> <?php include('upload_church_docs.php'); ?></td>
  </tr>
  <tr>
    <td> <?php include('display_church_docs.php'); ?></td>
  </tr>
</table>

	</div>
 <div id="tabs-5">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="mainbodyview">
  <table align="center" >
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">CELL  NAME:</td>
      <td><input type="text" name="locationname" value="<?php echo htmlentities($row_editlocality['locationname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td valign="top">CELL DESCRIPTION:</td>
      <td> <textarea name="locationdescription" id="locationdescription" cols="45" rows="5"><?php echo $row_editlocality['locationdescription'] ?></textarea>
      </td>
    </tr>
    
    
      <tr valign="baseline">
      <td valign="top"> CELL MISSION :</td>
      <td><textarea name="locationmission" id="locationmission" cols="45" rows="5"><?php echo $row_editlocality['locationmission'] ?></textarea></td>
    </tr>
    
     <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['localityid'])) &&($_GET['localityid']!="")) {?><input type="submit" value="Update" name="updatelocation"><?php } else  {?><input type="submit" value="Save" name="savelocation"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <table border="1" align="center">
    <tr>
      <td width="2%">No</td>
     <td width="10%">Cell  Name </td>
      <td width="10%">Cell  Description </td>
      <td width="10%">Cell  Mission</td>
     <td width="4%">&nbsp;</td>
      <td width="4%">&nbsp;</td>
    </tr>
    <?php do { $loacity ++;?>
      <tr>
        <td><?php echo $loacity;  ?></td>
        <td><?php echo $row_viewlocality['locationname']; ?>&nbsp; </td>
        <td><?php echo $row_viewlocality['locationdescription']; ?></td>
         <td><?php echo $row_viewlocality['locationmission']; ?></td>
        
           <td><a href="index.php?locality=show&localityid=<?php echo $row_viewlocality['localityid']; ?>& #tabs-1"> Edit </a></td> 
           
 <td><a href="index.php?locality= show & localityid=<?php echo $row_viewlocality['localityid'];?> & Delete=1" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
 
 
 

  
 
      </tr>
      <?php } while ($row_viewlocality = mysql_fetch_assoc($viewlocality)); ?>
  </table>
  <br />
  <table border="0">
    <tr>
      <td><?php if ($pageNum_viewlocality > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewlocality=%d%s", $currentPage, 0, $queryString_viewlocality); ?>">First</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewlocality > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_viewlocality=%d%s", $currentPage, max(0, $pageNum_viewlocality - 1), $queryString_viewlocality); ?>">Previous</a>
          <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_viewlocality < $totalPages_viewlocality) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewlocality=%d%s", $currentPage, min($totalPages_viewlocality, $pageNum_viewlocality + 1), $queryString_viewlocality); ?>">Next</a>
          <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_viewlocality < $totalPages_viewlocality) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_viewlocality=%d%s", $currentPage, $totalPages_viewlocality, $queryString_viewlocality); ?>">Last</a>
          <?php } // Show if not last page ?></td>
    </tr>
  </table>
Records <?php echo ($startRow_viewlocality + 1) ?> to <?php echo min($startRow_viewlocality + $maxRows_viewlocality, $totalRows_viewlocality) ?> of <?php echo $totalRows_viewlocality ?>
</form>
</div>   

<div id="tabs-6">


<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Locality:</td>
      <td><select name="localityid">
          <option value="-1" <?php if (!(strcmp(-1, $row_editrepresentative['representative_id']))) {echo "selected=\"selected\"";} ?> >Select Residence</option>
      
      
        <?php 
do {  
?>
       
<option value="<?php echo $row_addlocality['localityid']?>" <?php if (!(strcmp($row_addlocality['localityid'], $row_editrepresentative['localityid']))) {echo "selected=\"selected\"";} ?>>&nbsp;<?php echo $row_addlocality['locationname']?></option>      
        
        
        
        
        <?php
} while ($row_addlocality = mysql_fetch_assoc($addlocality));

 $rows = mysql_num_rows($addlocality);
  if($rows > 0) {
      mysql_data_seek($addlocality, 0);
	  $row_addlocality = mysql_fetch_assoc($addlocality);
  }
?>
      </select></td>
    </tr>
    <?php 
	mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Residence_Chairman:</td>
      <td><select name="residence_chair">
       <option value="-1" <?php if (!(strcmp(-1, $row_editrepresentative['representative_id']))) {echo "selected=\"selected\"";} ?> >Select Chairman</option>
      
        <?php 
do {  
?>
        <option value="<?php echo $row_addmember['memberid']?>" <?php if (!(strcmp($row_addmember['memberid'], $row_editrepresentative['residence_chair']))) {echo "selected=\"selected\"";} ?>>&nbsp;<?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
        
   <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));


 $rows = mysql_num_rows($addmember);
  if($rows > 0) {
      mysql_data_seek($addmember, 0);
	  $row_addmember = mysql_fetch_assoc($addmember);
  }


?>
      </select></td>
    </tr>
    
  <?php 
	mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Residence Secretary:</td>
      <td><select name="residence_secretary">
      <option value="-1" <?php if (!(strcmp(-1, $row_editrepresentative['representative_id']))) {echo "selected=\"selected\"";} ?> >Select Secretary</option>   
      
        <?php 
do {  
?>
           <option value="<?php echo $row_addmember['memberid']?>" <?php if (!(strcmp($row_addmember['memberid'], $row_editrepresentative['residence_secretary']))) {echo "selected=\"selected\"";} ?>>&nbsp;<?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option> 
          
      
          
          
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));


 $rows = mysql_num_rows($addmember);
  if($rows > 0) {
      mysql_data_seek($addmember, 0);
	  $row_addmember = mysql_fetch_assoc($addmember);
  }



?>
      </select></td>
    </tr>
    
      <?php 
	mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Residence Treasurer:</td>
      <td><select name="residence_treasurer">
      
     <option value="-1" <?php if (!(strcmp(-1, $row_editrepresentative['representative_id']))) {echo "selected=\"selected\"";} ?> >Select Treasurer</option>    
      
        <?php 
do {  
?>
          <option value="<?php echo $row_addmember['memberid']?>" <?php if (!(strcmp($row_addmember['memberid'], $row_editrepresentative['residence_treasurer']))) {echo "selected=\"selected\"";} ?>>&nbsp;<?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option> 
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));

 $rows = mysql_num_rows($addmember);
  if($rows > 0) {
      mysql_data_seek($addmember, 0);
	  $row_addmember = mysql_fetch_assoc($addmember);
  }

?>
      </select></td>
    </tr>
       <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['representative_id'])) &&($_GET['representative_id']!="")) {?><input type="submit" value="Update" name="updaterep"><?php } else  {?><input type="submit" value="Save" name="saverep"><?php }?>
      </td>
    </tr>
  </table>
  
  <p>&nbsp;</p>
  <table border="1" align="center">
  <tr>
     <td width="2%">No</td>
    <td width="10%">Residence Name</td>
    <td width="10%">Cell Group Chairman</td>
    <td width="10%">Cell Group Secretary</td>
    <td width="10%">Cell Group Treasurer</td>
    <td width="2%">&nbsp;</td>
     <td width="2%">&nbsp;</td>
  </tr>
  <?php do { $rep++;
  
  mysql_select_db($database_church, $church);
$query_viewchairman= "SELECT * FROM representative r INNER JOIN  member_details md ON md.memberid=r.residence_chair ";
$viewchairman= mysql_query($query_viewchairman, $church) or die('maad');
$row_viewchairman= mysql_fetch_assoc($viewchairman);
$totalRows_viewchairman = mysql_num_rows($viewchairman);

mysql_select_db($database_church, $church);
$query_viewsecretary= "SELECT * FROM representative re INNER JOIN  member_details md ON md.memberid=re.residence_secretary   ";
$viewsecretary= mysql_query($query_viewsecretary, $church) or die('error');
$row_viewsecretary= mysql_fetch_assoc($viewsecretary);
$totalRows_viewsecretary = mysql_num_rows($viewsecretary);

mysql_select_db($database_church, $church);
$query_viewtreasurer="SELECT * FROM representative rp INNER JOIN  member_details md ON md.memberid=rp.residence_treasurer ";
$viewtreasurer= mysql_query($query_viewtreasurer, $church) or die('error');
$row_viewtreasurer= mysql_fetch_assoc($viewtreasurer);
$totalRows_viewtreasurer = mysql_num_rows($viewtreasurer);
  
  
  
  
  
  
   ?>
    <tr>
      <td><?php echo $rep;  ?></td>
      <td><?php echo $row_viewrepresentative['locationname']; ?>&nbsp; </td>
      <td><?php echo $row_viewchairman['firstname']; ?>&nbsp;<?php echo $row_viewchairman['middlename']; ?>&nbsp;<?php echo $row_viewchairman['lastname']; ?> </td>
      <td><?php echo $row_viewsecretary['firstname']; ?>&nbsp;<?php echo $row_viewsecretary['middlename']; ?>&nbsp;<?php echo $row_viewsecretary['lastname']; ?> </td>
      <td><?php echo $row_viewtreasurer['firstname']; ?>&nbsp;<?php echo $row_viewtreasurer['middlename']; ?>&nbsp;<?php echo $row_viewtreasurer['lastname']; ?> </td>
            <td><a href="index.php?locality=show&representative_id=<?php echo $row_viewrepresentative['representative_id']; ?>& #tabs-2"> Edit </a>
           </td> 
           
      <td><a href="index.php?locality=show & representative_id=<?php echo $row_viewrepresentative['representative_id'];?> & Delete=1 &#tabs-2" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
 
</tr>
    <?php } while ($row_viewrepresentative = mysql_fetch_assoc($viewrepresentative)); ?>
</table>
  
</form>


<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewrepresentative > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewrepresentative=%d%s", $currentPage, 0, $queryString_viewrepresentative); ?>">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewrepresentative > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewrepresentative=%d%s", $currentPage, max(0, $pageNum_viewrepresentative - 1), $queryString_viewrepresentative); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewrepresentative < $totalPages_viewrepresentative) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewrepresentative=%d%s", $currentPage, min($totalPages_viewrepresentative, $pageNum_viewrepresentative + 1), $queryString_viewrepresentative); ?>">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewrepresentative < $totalPages_viewrepresentative) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewrepresentative=%d%s", $currentPage, $totalPages_viewrepresentative, $queryString_viewrepresentative); ?>">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewrepresentative + 1) ?> to <?php echo min($startRow_viewrepresentative + $maxRows_viewrepresentative, $totalRows_viewrepresentative) ?> of <?php echo $totalRows_viewrepresentative ?>



</div>


    </div>
</div>
</body>
</div>
</html>
    
    

     


 <script>   
$("#showhisto").click(function () {
$("#histo").toggle("slow");
});    
</script>
     <script>   
$("#showtdev").click(function () {
$("#tdev").toggle("slow");
});    
</script>
     <script>   
$("#showad").click(function () {
$("#ad").toggle("slow");
});    
</script>