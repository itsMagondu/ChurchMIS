<?php 
require_once('Connections/church.php');
require_once('functions.php');


checkAdmin();?>
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

?>
<?php 

mysql_select_db($database_church, $church);
$query_viewmemberadded = "SELECT * FROM member_details 
m LEFT JOIN marital_status ms ON m.statusid=ms.statusid LEFT JOIN 
locality l ON m.localityid=l.localityid LEFT JOIN gender g ON m.genderid=g.genderid  LEFT JOIN church ch ON m.church_id=ch.church_id 
LEFT JOIN departments ds ON m.department_id=ds.department_id WHERE m.status=1";
$query_limit_viewmember = sprintf("%s LIMIT %d, %d", $query_viewmemberadded, $startRow_viewmemberadded, $maxRows_viewmemberadded);
$viewmemberadded = mysql_query($query_viewmemberadded, $church) or die(mysql_error());
$row_viewmemberadded = mysql_fetch_assoc($viewmemberadded);


?>







 <?php if ((isset($_POST["savemember"]))) { 
	mysql_select_db($database_church, $church);
$query_viewsavedmember= "SELECT * from member_details ms  WHERE  ms.member_no=".$_POST['member_no']."";
$viewsavedmember = mysql_query($query_viewsavedmember, $church) or die('cannot view member details');
$row_viewsavedmember = mysql_fetch_assoc($viewsavedmember);
$totalRows_viewsavedmember = mysql_num_rows($viewsavedmember);
if($totalRows_viewsavedmember>0){ ?>
<script type="text/javascript">
			alert('Pre-existing Record!!');
			var goto='index.php?member=true &&  memberid=<?php echo $row_viewsavedmember['memberid']?>';
			window.location.assign(goto);
			</script>	

 


		 
<?php
}else {?>

	  <script type=text/javascript>
var ans = confirm("save the Form");
var f=document.forms(0);
function savemember(){
	

					 if (ans)
				 f.submit();				  
				
}</script>	 
<?php  
	
	$tab="index.php?member=true#tabs-1";
	$whereto=$tab;	
  $insertSQL = sprintf("INSERT INTO member_details (member_no,lastname, middlename, firstname,languages_spoken, dateofbirth, identificationnumber,genderid , localityid,department_id, statusid,church_id,service_attended,churh_attendance,placeofbirth) VALUES (%s, %s, %s, %s, %s, %s, %s, %s,%s,%s,%s,%s,%s,%s,%s)",
                       
					   GetSQLValueString($_POST['member_no'], "text"),
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['middlename'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
					    GetSQLValueString($_POST['languages_spoken'], "text"),
                       GetSQLValueString($_POST['dateofbirth'], "text"),
					   GetSQLValueString($_POST['identificationnumber'], "int"),
                       GetSQLValueString($_POST['genderid'], "int"),
                       GetSQLValueString($_POST['localityid'], "int"),
					   GetSQLValueString($_POST['department_id'], "int"),
                       GetSQLValueString($_POST['statusid'], "int"),
		                GetSQLValueString($_POST['church_id'], "int"),
					    GetSQLValueString($_POST['service_attended'], "text"),
						GetSQLValueString($_POST['churh_attendance'], "text"),
					    GetSQLValueString($_POST['placeofbirth'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
 

 }
}
 

if ((isset($_POST["updatemember"]))) { 

  	 $tab="index.php?member=true#tabs-1";
	$whereto=$tab;
   
     if ((isset($_GET['memberid'])) && ($_GET['memberid']!="")){
      
  $updateSQL = sprintf("UPDATE member_details SET  member_no=%s,lastname =%s, middlename=%s, firstname=%s,languages_spoken=%s, dateofbirth=%s,  identificationnumber=%s,genderid=%s, localityid=%s,department_id=%s, statusid=%s,church_id=%s ,service_attended=%s,churh_attendance=%s,placeofbirth=%s WHERE memberid=".($_GET['memberid'])."", 
  
  
                       GetSQLValueString($_POST['member_no'], "text"),
					   GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['middlename'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
					      GetSQLValueString($_POST['languages_spoken'], "text"),
                       GetSQLValueString($_POST['dateofbirth'], "text"),
					   GetSQLValueString($_POST['identificationnumber'], "int"),
                       GetSQLValueString($_POST['genderid'], "int"),
  
                      GetSQLValueString($_POST['localityid'], "int"),
					    GetSQLValueString($_POST['department_id'], "int"),
                       GetSQLValueString($_POST['statusid'], "int"),
					    GetSQLValueString($_POST['church_id'], "int"),
					    GetSQLValueString($_POST['service_attended'], "text"),
						 GetSQLValueString($_POST['churh_attendance'], "text"),
						  GetSQLValueString($_POST['placeofbirth'], "text"),
                       GetSQLValueString($_POST['memberid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
 header("Location:$whereto");

}
if((isset($_GET['memberid'])) && ($_GET['memberid'] !="") && (isset($_POST['delete']))) {
$movesql=mysql_query("INSERT INTO members_departed SELECT * FROM  member_details WHERE memberid=".$_GET['memberid']."");
if(!$movesql){exit("Member not deleted");}else{
$deleteSQL = sprintf("DELETE FROM member_details WHERE memberid=%s",

   GetSQLValueString($_GET['memberid'], "int"));
					   
  mysql_select_db($database_church, $church);
  $Result1= mysql_query($deleteSQL, $church) or die(mysql_error());

  $deleteGoTo = "index.php?member=true";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));}
}





if ((isset($_GET['archive']) &&(isset($_GET['member'])) && ($_GET['member'] != ""))) {

  $uPdateSQL1 = sprintf("UPDATE  member_details  SET status=2 
  WHERE memberid=".$_GET['member']."",
   GetSQLValueString($_GET['member'], "int"));

 mysql_select_db($database_church, $church);
  $Result1 = mysql_query($uPdateSQL1, $church) or die('cannot archive');
}








mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);



mysql_select_db($database_church, $church);
$query_addchurch = "SELECT * FROM church";
$addchurch = mysql_query($query_addchurch, $church) or die(mysql_error());
$row_addchurch= mysql_fetch_assoc($addchurch);
$totalRows_addchurch = mysql_num_rows($addchurch);



if((isset($_GET['memberid'])) &&($_GET['memberid']!="")){
mysql_select_db($database_church, $church);
$query_editmember = "SELECT * FROM member_details m LEFT JOIN marital_status ms ON m.statusid=ms.statusid LEFT JOIN locality l ON m.localityid=l.localityid LEFT JOIN gender g ON m.genderid=g.genderid LEFT JOIN departments ds ON m.department_id=ds.department_id LEFT JOIN church ch ON m.church_id=ch.church_id WHERE m.memberid=".$_GET['memberid']."";
$editmember = mysql_query($query_editmember, $church) or die(mysql_error());
$row_editmember = mysql_fetch_assoc($editmember);
$totalRows_editmember = mysql_num_rows($editmember);
}



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
LEFT JOIN departments ds ON m.department_id=ds.department_id WHERE m.status=1";
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










$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_GET['archive']) &&(isset($_GET['member'])) && ($_GET['member'] != ""))) {

  $uPdateSQL1 = sprintf("UPDATE  member_contacts  SET contact_status=2 
  WHERE contactid=".$_GET['member']."",
   GetSQLValueString($_GET['member'], "int"));

   mysql_select_db($database_church, $church);
  $Result1 = mysql_query($uPdateSQL1, $church) or die('cannot archive');
}



if ((isset($_POST["savecontact"]))) {
	
	$tab="index.php?member=true#tabs-2";
	$whereto=$tab;	
  $insertSQL = sprintf("INSERT INTO member_contacts ( memberid, phonenumber, emailaddress, alternative_contact, physical_address,postal_address) VALUES (%s, %s, %s, %s, %s,%s)",
                    
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['phonenumber'], "text"),
                       GetSQLValueString($_POST['emailaddress'], "text"),
                       GetSQLValueString($_POST['alternative_contact'], "text"),
                    GetSQLValueString($_POST['physical_address'], "text"),
                    GetSQLValueString($_POST['postal_address'], "text"));
  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
  header("Location:$whereto");
  
}

if ((isset($_POST["updatecontact"]))) {
	
	$alldetailsid=$_GET['alldetailsid'];
	
	$tab="index.php?member=true#tabs-2";
	$whereto=$tab;	
	
	
     if ((isset($_GET['contactid'])) &&   ($_GET['contactid']!="")){
	
  $updateSQL = sprintf("UPDATE member_contacts SET memberid=%s, phonenumber=%s, emailaddress=%s, alternative_contact=%s, physical_address=%s,postal_address=%s WHERE contactid=".($_GET['contactid'])."", 
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['phonenumber'], "text"),
                       GetSQLValueString($_POST['emailaddress'], "text"),
                       GetSQLValueString($_POST['alternative_contact'], "text"),
                     GetSQLValueString($_POST['physical_address'], "text"),
					  GetSQLValueString($_POST['postal_address'], "text"),
                       GetSQLValueString($_POST['contactid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}

 header("Location:$whereto");

}


mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_contacts";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

mysql_select_db($database_church, $church);
$query_addcontact = "SELECT * FROM member_contacts";
$addcontact = mysql_query($query_addcontact, $church) or die(mysql_error());
$row_addcontact = mysql_fetch_assoc($addcontact);
$totalRows_addcontact = mysql_num_rows($addcontact);

if((isset($_GET['contactid'])) && ($_GET['contactid']!="")){
mysql_select_db($database_church, $church);
$query_editcontact = "SELECT * FROM member_contacts ms INNER JOIN member_details m on m.memberid=ms.memberid WHERE contactid=".$_GET['contactid']."";
$editcontact = mysql_query($query_editcontact, $church) or die(mysql_error());
$row_editcontact = mysql_fetch_assoc($editcontact);
$totalRows_editcontact = mysql_num_rows($editcontact);
}




$maxRows_viewcontact = 5;
$pageNum_viewcontact = 0;
if (isset($_GET['pageNum_viewcontact'])) {
  $pageNum_viewcontact = $_GET['pageNum_viewcontact'];
}
$startRow_viewcontact = $pageNum_viewcontact * $maxRows_viewcontact;


mysql_select_db($database_church, $church);
$query_viewcontact = "SELECT * FROM member_contacts ms INNER JOIN member_details md ON md.memberid=ms.memberid ";
$query_limit_viewcontact = sprintf("%s LIMIT %d, %d", $query_viewcontact, $startRow_viewcontact, $maxRows_viewcontact);
$viewcontact = mysql_query($query_limit_viewcontact, $church) or die(mysql_error());
$row_viewcontact = mysql_fetch_assoc($viewcontact);

if (isset($_GET['totalRows_viewcontact'])) {
  $totalRows_viewcontact = $_GET['totalRows_viewcontact'];
} else {
  $all_viewcontact = mysql_query($query_viewcontact);
  $totalRows_viewcontact = mysql_num_rows($all_viewcontact);
}
$totalPages_viewcontact = ceil($totalRows_viewcontact/$maxRows_viewcontact)-1;

$queryString_viewcontact = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewcontact") == false && 
        stristr($param, "totalRows_viewcontact") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewcontact = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewcontact = sprintf("&totalRows_viewcontact=%d%s", $totalRows_viewcontact, $queryString_viewcontact);







$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}






$queryString_viewacademic = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewacademic") == false && 
        stristr($param, "totalRows_viewacademic") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewacademic = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewacademic = sprintf("&totalRows_viewacademic=%d%s", $totalRows_viewacademic, $queryString_viewacademic);


if ((isset($_GET['archive']) &&(isset($_GET['member'])) && ($_GET['member'] != ""))) {

  $uPdateSQL4 = sprintf("UPDATE  profession  SET profession_status=2 
  WHERE profession_id=".$_GET['member']."",
   GetSQLValueString($_GET['member'], "int"));

   mysql_select_db($database_church, $church);
  $Result4 = mysql_query($uPdateSQL4, $church) or die('cannot archive proffession');
}



if ((isset($_POST["saveprofession"]))) {
	
	 $tab="index.php?member=true#tabs-4";
	$whereto=$tab;	
	
  $insertSQL = sprintf("INSERT INTO profession (profession_id, memberid, profession_name, profession_start, profession_end, company_name) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['profession_id'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['profession_name'], "text"),
                       GetSQLValueString($_POST['profession_start'], "text"),
                       GetSQLValueString($_POST['profession_end'], "text"),
                       GetSQLValueString($_POST['company_name'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
     header("Location:$whereto");
  
}

if ((isset($_POST["updateprofession"]))) {
	
	 $tab="index.php?member=true#tabs-4";
	$whereto=$tab;	
	
	 if ((isset($_GET['profession_id'])) && ($_GET['profession_id']!="")){
  $updateSQL = sprintf("UPDATE profession SET memberid=%s, profession_name=%s, profession_start=%s, profession_end=%s, company_name=%s WHERE profession_id=".$_GET['profession_id']."",
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['profession_name'], "text"),
                       GetSQLValueString($_POST['profession_start'], "text"),
                       GetSQLValueString($_POST['profession_end'], "text"),
                       GetSQLValueString($_POST['company_name'], "text"),
                       GetSQLValueString($_POST['profession_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
       header("Location:$whereto");
  
}
}
mysql_select_db($database_church, $church);
$query_addprofession = "SELECT * FROM profession";
$addprofession = mysql_query($query_addprofession, $church) or die(mysql_error());
$row_addprofession = mysql_fetch_assoc($addprofession);
$totalRows_addprofession = mysql_num_rows($addprofession);

mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM profession";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);
if((isset($_GET['profession_id'])) && ($_GET['profession_id']!="")){
mysql_select_db($database_church, $church);
$query_editprofession = "SELECT * FROM profession p INNER JOIN member_details md ON p.memberid=md.memberid WHERE profession_id=".$_GET['profession_id']."";
$editprofession = mysql_query($query_editprofession, $church) or die(mysql_error());
$row_editprofession = mysql_fetch_assoc($editprofession);
$totalRows_editprofession = mysql_num_rows($editprofession);
}
$maxRows_viewprofession = 10;
$pageNum_viewprofession = 0;
if (isset($_GET['pageNum_viewprofession'])) {
  $pageNum_viewprofession = $_GET['pageNum_viewprofession'];
}
$startRow_viewprofession = $pageNum_viewprofession * $maxRows_viewprofession;

mysql_select_db($database_church, $church);
$query_viewprofession = "SELECT * FROM profession p INNER JOIN member_details md ON p.memberid=md.memberid WHERE p.profession_status='1'";
$query_limit_viewprofession = sprintf("%s LIMIT %d, %d", $query_viewprofession, $startRow_viewprofession, $maxRows_viewprofession);
$viewprofession = mysql_query($query_limit_viewprofession, $church) or die(mysql_error());
$row_viewprofession = mysql_fetch_assoc($viewprofession);

if (isset($_GET['totalRows_viewprofession'])) {
  $totalRows_viewprofession = $_GET['totalRows_viewprofession'];
} else {
  $all_viewprofession = mysql_query($query_viewprofession);
  $totalRows_viewprofession = mysql_num_rows($all_viewprofession);
}
$totalPages_viewprofession = ceil($totalRows_viewprofession/$maxRows_viewprofession)-1;

$queryString_viewprofession = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewprofession") == false && 
        stristr($param, "totalRows_viewprofession") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {

    $queryString_viewprofession = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewprofession = sprintf("&totalRows_viewprofession=%d%s", $totalRows_viewprofession, $queryString_viewprofession);





if ((isset($_GET['archive']) &&(isset($_GET['member'])) && ($_GET['member'] != ""))) {

  $uPdateSQL2 = sprintf("UPDATE  hobbies  SET hobby_status=2 
  WHERE hobby_id=".$_GET['member']."",
   GetSQLValueString($_GET['member'], "int"));

   mysql_select_db($database_church, $church);
  $Result1 = mysql_query($uPdateSQL2, $church) or die('cannot archive');
}




if ((isset($_POST["savehobby"]))) {
	
	$tab="index.php?member=true#tabs-5";
	$whereto=$tab;
	
  $insertSQL = sprintf("INSERT INTO hobbies (memberid, hobby_name, intrests, special_skills) VALUES (%s, %s, %s, %s)",
                      
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['hobby_name'], "text"),
                       GetSQLValueString($_POST['intrests'], "text"),
                       GetSQLValueString($_POST['special_skills'], "text"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
  header("Location:$whereto");
}

if ((isset($_POST["updatehobby"]))) {
	
	$tab="index.php?member=true#tabs-5";
	$whereto=$tab;
	
	
	if((isset($_GET['hobby_id']))  &&  (isset($_GET['hobby_id']))){
  $updateSQL = sprintf("UPDATE hobbies SET memberid=%s, hobby_name=%s, intrests=%s, special_skills=%s  WHERE hobby_id=".($_GET['hobby_id'])."",
  
  
                       GetSQLValueString($_POST['memberid'], "int"),
                       GetSQLValueString($_POST['hobby_name'], "text"),
                       GetSQLValueString($_POST['intrests'], "text"),
                       GetSQLValueString($_POST['special_skills'], "text"),
                       GetSQLValueString($_POST['hobby_id'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
  
}

 header("Location:$whereto");

}
mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM hobbies";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);

mysql_select_db($database_church, $church);
$query_addhobby = "SELECT * FROM hobbies";
$addhobby = mysql_query($query_addhobby, $church) or die(mysql_error());
$row_addhobby = mysql_fetch_assoc($addhobby);
$totalRows_addhobby = mysql_num_rows($addhobby);

$maxRows_viewhobby = 10;
$pageNum_viewhobby = 0;
if (isset($_GET['pageNum_viewhobby'])) {
  $pageNum_viewhobby = $_GET['pageNum_viewhobby'];
}
$startRow_viewhobby = $pageNum_viewhobby * $maxRows_viewhobby;

mysql_select_db($database_church, $church);
$query_viewhobby = "SELECT * FROM hobbies h INNER JOIN member_details m ON m.memberid=h.memberid WHERE h.hobby_status=1";
$query_limit_viewhobby = sprintf("%s LIMIT %d, %d", $query_viewhobby, $startRow_viewhobby, $maxRows_viewhobby);
$viewhobby = mysql_query($query_limit_viewhobby, $church) or die(mysql_error());
$row_viewhobby = mysql_fetch_assoc($viewhobby);

if (isset($_GET['totalRows_viewhobby'])) {
  $totalRows_viewhobby = $_GET['totalRows_viewhobby'];
} else {
  $all_viewhobby = mysql_query($query_viewhobby);
  $totalRows_viewhobby = mysql_num_rows($all_viewhobby);
}
$totalPages_viewhobby = ceil($totalRows_viewhobby/$maxRows_viewhobby)-1;

if((isset($_GET['hobby_id'])) &&($_GET['hobby_id']!="")){
mysql_select_db($database_church, $church);
$query_edithobby = "SELECT * FROM hobbies h INNER JOIN member_details m ON m.memberid=h.hobby_id WHERE hobby_id=".$_GET['hobby_id']."";
$edithobby = mysql_query($query_edithobby, $church) or die(mysql_error());
$row_edithobby = mysql_fetch_assoc($edithobby);
$totalRows_edithobby = mysql_num_rows($edithobby);
}
$queryString_viewhobby = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewhobby") == false && 
        stristr($param, "totalRows_viewhobby") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewhobby = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewhobby = sprintf("&totalRows_viewhobby=%d%s", $totalRows_viewhobby, $queryString_viewhobby);



mysql_select_db($database_church, $church);
$query_memberreg = "SELECT m.memberid,m.middlename,m.firstname,m.lastname  FROM  member_details m ";
$memberreg  = mysql_query($query_memberreg , $church) or die(mysql_error());
$row_memberreg = mysql_fetch_assoc($memberreg );
$totalRows_memberreg  = mysql_num_rows($memberreg );


mysql_select_db($database_church, $church);
$query_gender = "SELECT g.genderid,g.gendername FROM gender g ";
$gender=mysql_query($query_gender, $church) or die(mysql_error());
$row_gender= mysql_fetch_assoc($gender );
$totalRows_memberreg  = mysql_num_rows($gender );


  mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);







$maxRows_viewmemberdetails = 5;
$pageNum_viewmemberdetails = 0;
if (isset($_GET['pageNum_viewmemberdetails'])) {
  $pageNum_viewmemberdetails = $_GET['pageNum_viewmemberdetails'];
}
$startRow_viewmemberdetails = $pageNum_viewmemberdetails * $maxRows_viewmemberdetails;


mysql_select_db($database_church, $church);
$query_viewmemberdetails="SELECT * FROM member_details ms WHERE ms.status=1 ";
$query_limit_viewmemberdetails = sprintf("%s LIMIT %d, %d", $query_viewmemberdetails, $startRow_viewmemberdetails, $maxRows_viewmemberdetails);
$viewmemberdetails = mysql_query($query_limit_viewmemberdetails, $church) or die(mysql_error());
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
    $queryString_viewmemberdetails= "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewmemberdetails = sprintf("&totalRows_viewmemberdetailst=%d%s", $totalRows_viewmemberdetails, $queryString_viewmemberdetails);


	
if ((isset($_POST["savenewmember"]))) {
	
	$tab="index.php?member=true#tabs-6";
	$whereto=$tab;	
  $insertSQL = sprintf("INSERT INTO member_details ( lastname, middlename, firstname, dateofbirth, genderid, identificationnumber, localityid, statusid) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                      
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['middlename'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['dateofbirth'], "text"),
                       GetSQLValueString($_POST['genderid'], "text"),
                       GetSQLValueString($_POST['identificationnumber'], "int"),
                       GetSQLValueString($_POST['localityid'], "int"),
                       GetSQLValueString($_POST['statusid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($insertSQL, $church) or die(mysql_error());
  
   header("Location:$whereto");
  
}

if ((isset($_POST["updatenewmember"]))) { 

  	 $tab="index.php?member=true#tabs-6";
	$whereto=$tab;
   
     if ((isset($_GET['memberid'])) && ($_GET['memberid']!="")){
      
  $updateSQL = sprintf("UPDATE member_details SET lastname =%s, middlename=%s, firstname=%s, dateofbirth=%s, genderid=%s, identificationnumber=%s, localityid=%s, statusid=%s WHERE memberid=".($_GET['memberid'])."", 
                       GetSQLValueString($_POST['lastname'], "text"),
                       GetSQLValueString($_POST['middlename'], "text"),
                       GetSQLValueString($_POST['firstname'], "text"),
                       GetSQLValueString($_POST['dateofbirth'], "text"),
                       GetSQLValueString($_POST['genderid'], "int"),
                       GetSQLValueString($_POST['identificationnumber'], "int"),
                      GetSQLValueString($_POST['localityid'], "int"),
                       GetSQLValueString($_POST['statusid'], "int"),
                       GetSQLValueString($_POST['memberid'], "int"));

  mysql_select_db($database_church, $church);
  $Result1 = mysql_query($updateSQL, $church) or die(mysql_error());
}
 header("Location:$whereto");

}	


mysql_select_db($database_church, $church);
$query_addnewmember = "SELECT * FROM member_details";
$addnewmember = mysql_query($query_addnewmember, $church) or die(mysql_error());
$row_addnewmember = mysql_fetch_assoc($addnewmember);
$totalRows_addnewmember = mysql_num_rows($addnewmember);
if((isset($_GET['member_id'])) &&($_GET['member_id']!="")){
mysql_select_db($database_church, $church);
$query_editnewmember = "SELECT * FROM member_details ms  WHERE ms.member_id=".$_GET['member_id']." ";
$editnewmember = mysql_query($query_editnewmember, $church) or die(mysql_error());
$row_editnewmember = mysql_fetch_assoc($editnewmember);
$totalRows_editnewmember = mysql_num_rows($editnewmember);
}
$maxRows_viewnewmember = 50;
$pageNum_viewnewmember = 0;
if (isset($_GET['pageNum_viewnewmember'])) {
  $pageNum_viewnewmember = $_GET['pageNum_viewnewmember'];
}
$startRow_viewnewmember = $pageNum_viewnewmember * $maxRows_viewnewmember;

mysql_select_db($database_church, $church);
$query_viewnewmember = "SELECT * FROM member_details 
m LEFT JOIN marital_status ms ON m.statusid=ms.statusid LEFT JOIN 
locality l ON m.localityid=l.localityid LEFT JOIN gender g ON m.genderid=g.genderid WHERE 1  ";
$query_limit_viewnewmember = sprintf("%s LIMIT %d, %d", $query_viewnewmember, $startRow_viewnewmember, $maxRows_viewnewmember);
$viewnewmember = mysql_query($query_limit_viewnewmember, $church) or die(mysql_error());
$row_viewnewmember = mysql_fetch_assoc($viewnewmember);

if (isset($_GET['totalRows_viewnewmember'])) {
  $totalRows_viewnewmember = $_GET['totalRows_viewnewmember'];
} else {
  $all_viewnewmember = mysql_query($query_viewnewmember);
  $totalRows_viewnewmember = mysql_num_rows($all_viewnewmember);
}
$totalPages_viewnewmember = ceil($totalRows_viewnewmember/$maxRows_viewnewmember)-1;

$queryString_viewnewmember = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_viewnewmember") == false && 
        stristr($param, "totalRows_viewnewmember") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_viewnewmember = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_viewnewmember = sprintf("&totalRows_viewnewmember=%d%s", $totalRows_viewnewmember, $queryString_viewnewmember);

mysql_select_db($database_church, $church);
$query_viewsearchmember = "SELECT * FROM member_details ";
$viewsearchmember = mysql_query($query_viewsearchmember   , $church) or die(mysql_error());
$row_viewsearchmember =  mysql_fetch_assoc($viewsearchmember    );
$totalRows_viewsearchmember = mysql_num_rows($viewsearchmember    );


mysql_select_db($database_church, $church);
$query_viewsearchcontact = "SELECT * FROM member_details ";
$viewsearchcontact = mysql_query($query_viewsearchcontact, $church) or die(mysql_error());
$row_viewsearchcontact=  mysql_fetch_assoc($viewsearchcontact);
$totalRows_viewsearchcontact = mysql_num_rows($viewsearchcontact);
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
function getbymembername(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "member_results.php?smember=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		
</script>

<script type="text/javascript">
function getbysearchname(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "member_result.php?smembername=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		
</script>
<script>
function numbermember_onblur()
{
   var numbermember = document.form1.txtAge;
   if (isNaN(numbermember.value) == true)
   {
      alert("Member Number  must be a number.");
      numbermember.focus();
      numbermember.select();
   }
}
</script>

<script type="text/javascript">
function ConfirmArchive()
{
  var x = confirm("Are you sure you want to Archive ?");
  if (x)
      return true;
  else
    return false;
}
</script>

<script type="text/javascript">
	$(function() {
		$('#admissiondate').datepicker({
			changeMonth: true,
			dateFormat: "yy-mm-dd",
			changeYear: true
			
		});
		$('#dateofbirth').datepicker({
		  
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
		$('#dateofbirthadmn').datepicker({
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

<script type="text/javascript" src="/st_peters/search.js"></script>
    
<link href="/st_peters/SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="/st_peters/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/st_peters/js/tablecloth.js"></script>
</head>

</head><div class="bodytext">
<body>

<div id="tabs" class="datataable">
<ul>
		<li class="ol.linenums li "><a href="#tabs-1">Registration</a></li>
		<li><a href="#tabs-2">Contact Details</a></li>
         <li><a href="#tabs-3">Upload Photo</a></li>
         <li><a href="#tabs-4">Proffesion</a></li>
         <li><a href="#tabs-5">Intrests/Hobbies</a></li>
        <li><a href="#tabs-6">New  Admissions</a></li>
        <li><a href="#tabs-7">Members</a></li>
   	    
</ul>
<div id="tabs-1" class="datataable">

<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
    
   <table width="100%" class="bodytextmembers">
   <tr>
    <td valign="top" align="left">
    
 <?php ?>
    
      
      <table width="100%" border="0" bgcolor="F4F4F4" cellspacing="1" cellpadding="1" class="datataable" >
   
    <td align="right"> <strong>Search Member</strong>:
 <input name="smember" type="text" id="smember" onKeyUp="getbyevaluation('output_div','smember','0')" size="30"></td>

        <tr>
        
        <?php mysql_select_db($database_church, $church);
$query_addgender = "SELECT * FROM gender";
$addgender  = mysql_query($query_addgender , $church) or die(mysql_error());
$row_addgender  = mysql_fetch_assoc($addgender );
$totalRows_addgender  = mysql_num_rows($addgender );?>
        <td>
<tr valign="baseline">

        <td><table align="center" bgcolor="F4F4F4" >
        
        
         <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member Number:</td>
      <td>
 <span id="sprytextfield3">
  <input  name="member_no" type="number"  id="member_no" onChange="if(!Number(this.value)){alert('Please Enter Number for Member Number');}" value="<?php echo htmlentities($row_editmember['member_no'], ENT_COMPAT, 'utf-8'); ?>"  />
   <span class="textfieldRequiredMsg">.</span></span></td>
    </tr>
        
         <tr valign="baseline">
      <td nowrap="nowrap" align="right">First Name:</td>
      <td><input type="text" name="firstname" value="<?php echo htmlentities($row_editmember['firstname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
        
            <tr valign="baseline">
      <td nowrap="nowrap" align="right">Middle Name:</td>
      <td><span id="sprytextfield2">
        <input type="text" name="middlename" value="<?php echo htmlentities($row_editmember['middlename'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
        
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Last Name:</td>
      <td><span id="sprytextfield1">
        <input type="text" name="lastname" value="<?php echo htmlentities($row_editmember['lastname'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
     </tr>
  
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Languages Spoken:</td>
      <td><span id="sprytextfield1">
        <input type="text" name="languages_spoken" value="<?php echo htmlentities($row_editmember['languages_spoken'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
     </tr>
     
     <tr valign="baseline">
      <td nowrap="nowrap" align="right">Identification Number(I.D.):</td>
      <td>
    <input type="text" name="identificationnumber" value="<?php echo htmlentities($row_editmember['identificationnumber'], ENT_COMPAT, 'utf-8'); ?>" maxlength="8" /></td>
    </tr>
    
  
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Date of birth:</td>
      <td><input type="text" name="dateofbirth" id="dateofbirth" value="<?php echo htmlentities($row_editmember['dateofbirth'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    
    
  
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Gender:</td>
      <td>  <span id="spryselect1">
        <select name="genderid" selected="selected">
 <option value="-1"  <?php if (!(strcmp(-1, $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?>>Select Gender</option>
          <?php 
do {  
?>
<option value="<?php echo $row_addgender['genderid']?>"<?php if (!(strcmp($row_addgender['genderid'], $row_editmember['genderid']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_addgender['gendername']?></option>
   <?php
} while ($row_addgender = mysql_fetch_assoc($addgender));
?>
        </select>
         <span class="selectRequiredMsg">Please select a Gender.</span></span></td>
    </tr>
     
    
 
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cell Group</td>
      <td>
      <?php
	  
	  mysql_select_db($database_church, $church);
$query_addgroup = "SELECT * FROM locality";
$addgroup = mysql_query($query_addgroup, $church) or die(mysql_error());
$row_addgroup = mysql_fetch_assoc($addgroup);
$totalRows_addgroup = mysql_num_rows($addgroup);
	  
       ?>
       <span id="spryselect2">
      <select name="localityid" selected="selected">
        <option value="-1">Select Group</option>
        <?php 
do {  
?>
        <option value="<?php echo $row_addgroup['localityid']?>" <?php if (!(strcmp($row_addgroup['localityid'], $row_editmember['localityid']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_addgroup['locationname']?></option>
     <?php
} while ($row_addgroup = mysql_fetch_assoc($addgroup));


  $rows = mysql_num_rows($addgroup);
  if($rows > 0) {
      mysql_data_seek($addgroup, 0);
	  $row_addgroup = mysql_fetch_assoc($addgroup);
  }
?>

      </select>
      
      
       <span class="selectRequiredMsg">Please select Residence.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status:</td>
      <td>
         <span id="spryselect3">
         
        <select name="statusid" selected="selected">
           <option value="-1"  <?php if (!(strcmp(-1, $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?>>Select Status</option>
          <?php 
do {  
?>
          <option value="<?php echo $row_addstatus['statusid']?>" <?php if (!(strcmp($row_addstatus['statusid'], $row_editmember['statusid']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_addstatus['statusname']?></option>
  <?php
} while ($row_addstatus = mysql_fetch_assoc($addstatus));
  $rows = mysql_num_rows($addstatus);
  if($rows > 0) {
      mysql_data_seek($addstatus, 0);
	  $row_addstatus = mysql_fetch_assoc($addstatus);
  }
?>





        </select>
     <span class="selectRequiredMsg">Please select Residence.</span></span></td>
    </tr>
    

 <tr valign="baseline">
      <td nowrap="nowrap" align="right">Church:</td>
      <td>
      
<span id="spryselect3">
 <select name="church_id" selected="selected">
           <option value="-1"  <?php if (!(strcmp(-1, $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?>>Select Church</option>
          <?php 
do {  
?>
 <option value="<?php echo $row_addchurch['church_id']?>" <?php if (!(strcmp($row_addchurch['church_id'], $row_editmember['church_id']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_addchurch['church_name']?></option> 
          
          
          
  <?php
} while ($row_addchurch = mysql_fetch_assoc($addchurch));
$rows = mysql_num_rows($addchurch);
  if($rows > 0) {
      mysql_data_seek($addchurch, 0);
	  $row_addchurch = mysql_fetch_assoc($addchurch);
  }

?>





        </select>
     <span class="selectRequiredMsg">Please select Residence.</span></span></td>
    </tr>

       
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Service Attended:</td>
      <td>  <select name="service_attended" id="service_attended">
        <option value="firstservice" <?php if (!(strcmp("firstservice", $row_editmember['service_attended']))) {echo "selected=\"selected\"";} ?>>1st Service</option>
        
           <option value="secondservice" <?php if (!(strcmp("secondservice", $row_editmember['service_attended']))) {echo "selected=\"selected\"";} ?>>2nd Service</option>
        
          <option value="bothservices" <?php if (!(strcmp("bothservices", $row_editmember['service_attended']))) {echo "selected=\"selected\"";} ?>>Both Services</option>
          
</select>
     </td>
    </tr>
    
      
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Church Attendance:</td>
      <td><select name="churh_attendance" id="churh_attendance">
        <option value="everysunday" <?php if (!(strcmp("everysunday", $row_editmember['churh_attendance']))) {echo "selected=\"selected\"";} ?>> Every Sunday </option>
        
           <option value="twiceamonth" <?php if (!(strcmp("twiceamonth", $row_editmember['churh_attendance']))) {echo "selected=\"selected\"";} ?>> Twice a Month </option>
        
          <option value="onceamonth" <?php if (!(strcmp("onceamonth", $row_editmember['churh_attendance']))) {echo "selected=\"selected\"";} ?>> Once a Month</option>
          
        <option value="irregular" <?php if (!(strcmp("irregular", $row_editmember['churh_attendance']))) {echo "selected=\"selected\"";} ?>> Irregular</option>   
          
</select>
        </td>
    </tr> 
    
  <tr valign="baseline">
       <?php
	  
	  mysql_select_db($database_church, $church);
$query_adddepartment = "SELECT * FROM departments";
$adddepartment = mysql_query($query_adddepartment, $church) or die(mysql_error());
$row_adddepartment = mysql_fetch_assoc($adddepartment);
$totalRows_adddepartment = mysql_num_rows($adddepartment);
	  
       ?>
  
  
      <td nowrap="nowrap" align="right">Department:</td>
      <td><select name="department_id" selected="selected">  
      <option value="-1" <?php if (!(strcmp(-1, $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?> >Select Department</option>
  <?php
do {  
?>
<option value="<?php echo $row_adddepartment['department_id']?>"<?php if (!(strcmp($row_adddepartment['department_id'], $row_editmember['department_id']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_adddepartment['department_name']?></option>
  
  
        <?php
} while ($row_adddepartment = mysql_fetch_assoc($adddepartment));

?>         
</select>
        </td>
    </tr>   
    
    
    
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['memberid'])) &&($_GET['memberid']!="")) {?>
          <input type="submit" value="Update" name="updatemember">
	    <input type="submit" name="delete" id="delete" value="Deceased" />
		<?php } else  {?><input type="submit" value="Save" id="savemember" name="savemember" onClick="savemember();"><?php }?>
      </td>
    </tr>
  </table>
</table>
      <p>Members Registered:<?php echo $totalRows_viewmemberdetails ;?>    Date:<?php echo date("Y/m/d") ;?> </p>
  </form>
     </td>
</tr>
<tr>
    <td colspan="2"><?php include('member_results.php');?></td>
  </tr>

</table>

</div>
<script>   
$("#showcomp").click(function () {
$("#comp").toggle("slow");
});    
</script>
	<div id="tabs-2">
    <form action="<?php echo $editFormAction; ?>" method="post" name="form12" id="form12">
        <table width="100%" >
 
  <tr>
    <td  valign="top" align="left">
      <table width="100%" class=""  >
      
      
      
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member:</td>
      <td><input name="memberid" value="<?php echo $row_editcontact['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['contactid'])) && ($_GET['contactid'] != "")){ echo $row_editcontact['lastname'] ;?>&nbsp;<?php echo $row_editcontact['middlename'] ;?> &nbsp;<?php echo $row_editcontact['firstname'] ; } else {?>
     
      <select name="memberid" selected="selected">  
      <option value="-1" <?php if (!(strcmp(-1, $row_editcontact['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>
  <?php
do {  
?>
  <option  size="32"value="<?php echo $row_addmember['memberid']?>"><?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember));
  $rows = mysql_num_rows($addmember);
  if($rows > 0) {
      mysql_data_seek($addmember, 0);
	  $row_addmember = mysql_fetch_assoc($addmember);
  }
?>         
</select><?php }?>
     </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Phone  number:</td>
      <td>    
       <span id="sprytextfield1">
      <label for="phonenumber"></label>
        <input type="text" name="phonenumber" value="<?php echo htmlentities($row_editcontact['phonenumber'], ENT_COMPAT, 'utf-8'); ?>" maxlength="10" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email address:</td>
      <td><input type="email" name="emailaddress" value="<?php echo htmlentities($row_editcontact['emailaddress'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Alternative_contact:</td>
      <td><span id="sprytextfield4">
   <input type="text" name="alternative_contact" value="<?php echo htmlentities($row_editcontact['alternative_contact'], ENT_COMPAT, 'utf-8'); ?>" maxlength="10"/>

 
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Physical_address:</td>
      <td><span id="sprytextfield5">
        <input type="text" name="physical_address" value="<?php echo htmlentities($row_editcontact['physical_address'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Postal Address:</td>
      <td><span id="sprytextfield5">
        <input type="text" name="postal_address" value="<?php echo htmlentities($row_editcontact['postal_address'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    
    
      <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['contactid'])) &&($_GET['contactid']!="")) {?><input type="submit" value="Update" name="updatecontact"><?php } else  {?><input type="submit" value="Save" name="savecontact"><?php }?>
      </td>
    </tr>
  </table>
    </form>
     </td>
    <script>   
$("#showhisto").click(function () {
$("#histo").toggle("slow");
});    
</script>
  </tr>
  <div class="bodytext">
  <tr>
    <td> 
      <table border="1" align="center">
     <tr class="tableheader">
       <td width="2%">No</td>
     <td width="6%">Member Names </td>
     <td width="4%">phone Number</td>
     <td width="6%">email Address</td>
     <td width="4%">Alternative No.</td>
     <td width="6%">Physical Address</td>
     <td width="5%">Postal Address</td>
       <td width="1%">&nbsp;</td>
      <td width="1%">&nbsp;</td>
      

      
      
    </tr>
    <?php do { $rownum1 ++; ?>
      <tr>
        <td><?php echo $rownum1  ?></td>
        <td><?php echo $row_viewcontact['firstname']; ?>&nbsp;<?php echo $row_viewcontact['middlename']; ?>&nbsp;<?php echo $row_viewcontact['lastname']; ?></td>
        <td><?php echo $row_viewcontact['phonenumber']; ?>&nbsp; </td>
        <td><?php echo $row_viewcontact['emailaddress']; ?>&nbsp; </td>
        <td><?php echo $row_viewcontact['alternative_contact']; ?>&nbsp; </td>
        <td><?php echo $row_viewcontact['physical_address']; ?>&nbsp; </td>
       <td><?php echo $row_viewcontact['postal_address']; ?>&nbsp; </td>
              <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='clerk'))){ 
  ?>
         <td><a href="index.php?member=show&contactid=<?php echo $row_viewcontact['contactid']; ?>& #tabs-2"> Edit </a></td> 
           
<td><a href="index.php?member=<?php echo $row_viewcontact['contactid'];?> & archive=1 & #tabs-2 " onClick="return ConfirmArchive()">Archive  </a></td>
 
         <?php }?>    
        
      </tr>
      <?php } while ($row_viewcontact = mysql_fetch_assoc($viewcontact)); ?>
  </table></div></td>
  
  
  
  </tr>
</div>

<table border="0">
  <tr>
    <td><?php if ($pageNum_viewcontact > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewcontact=%d%s", $currentPage, 0, $queryString_viewcontact); ?> & #tabs-2">First</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewcontact > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewcontact=%d%s", $currentPage, max(0, $pageNum_viewcontact - 1), $queryString_viewcontact); ?> & #tabs-2">Previous</a>
      <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewcontact < $totalPages_viewcontact) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewcontact=%d%s", $currentPage, min($totalPages_viewcontact, $pageNum_viewcontact + 1), $queryString_viewcontact); ?>& #tabs-2">Next</a>
      <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewcontact < $totalPages_viewcontact) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewcontact=%d%s", $currentPage, $totalPages_viewcontact, $queryString_viewcontact); ?>& #tabs-2">Last</a>
      <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewcontact + 1) ?> to <?php echo min($startRow_viewcontact + $maxRows_viewcontact, $totalRows_viewcontact) ?> of <?php echo $totalRows_viewcontact?>
  



</div>

<div id="tabs-3">
        <p>Upload Member Photo</p>        
        <table width="100%" class="">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"> <?php include('upload_pic.php'); ?>

</td>
  </tr>
<tr>
    <td align="left" valign="top"><div class="mainbodyview"> <?php include('display_image.php'); ?> </div> </td>
  </tr>
</table>
    

</div>
<div id="tabs-4">
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" class="">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member:</td>
      <?php mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
<td><input name="memberid" value="<?php echo $row_editprofession['memberid']; ?>" type="hidden">
      <?php if ((isset($_GET['academics_id'])) && ($_GET['academics_id'] != "")){ echo $row_editprofession['firstname'] ;?>&nbsp;<?php echo $row_editprofession['middlename'] ;?> &nbsp;<?php echo $row_editprofession['lastname'] ; } else {?>
    
     <select name="memberid" selected="selected">  
      <option value="-1" <?php if (!(strcmp(-1, $row_editprofession['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>
  <?php
do {  
?>
  <option  size="32"value="<?php echo $row_addmember['memberid']?>"><?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
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
      <td nowrap="nowrap" align="right">Profession_name:</td>
      <td><input type="text" name="profession_name" value="<?php echo htmlentities($row_editprofession['profession_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
   
      <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['profession_id'])) &&($_GET['profession_id']!="")) {?><input type="submit" value="Update" name="updateprofession"><?php } else  {?><input type="submit" value="Save" name="saveprofession"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<table border="1" align="center">
  <tr>

   <td width="2%">No</td>
    <td width="15%">Member Names </td>
    <td width="15%">Profession Name</td>
    
    <td width="2%">&nbsp;</td>
   <td width="2%">&nbsp;</td>
  </tr>
  <?php $todaydate=date("Y-m-d");?>
  <?php $profession=0; do { $profession++; ?>
    <tr>
      <td><?php echo $profession ;  ?> </a></td>
      <td><?php echo $row_viewprofession['lastname']; ?>&nbsp;<?php echo $row_viewprofession['firstname']; ?>&nbsp;<?php echo $row_viewprofession['middlename']; ?> </td>
      <td><?php echo $row_viewprofession['profession_name']; ?>&nbsp; </td>
      
             <td><a href="index.php?member=show&profession_id=<?php echo $row_viewprofession['profession_id']; ?>& #tabs-4"> Edit </a></td>                 <td><a href="index.php?member=<?php echo $row_viewprofession['profession_id'];?> & archive=1 & #tabs-4  " onClick="return ConfirmArchive()">Archive  </a></td>
 </tr>
    <?php } while ($row_viewprofession = mysql_fetch_assoc($viewprofession)); ?>
</table>
<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewprofession > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewprofession=%d%s", $currentPage, 0, $queryString_viewprofession); ?>& #tabs-4">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewprofession > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewprofession=%d%s", $currentPage, max(0, $pageNum_viewprofession - 1), $queryString_viewprofession); ?>& #tabs-4">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewprofession < $totalPages_viewprofession) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewprofession=%d%s", $currentPage, min($totalPages_viewprofession, $pageNum_viewprofession + 1), $queryString_viewprofession); ?>& #tabs-4">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewprofession < $totalPages_viewprofession) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewprofession=%d%s", $currentPage, $totalPages_viewprofession, $queryString_viewprofession); ?>& #tabs-4">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewprofession + 1) ?> to <?php echo min($startRow_viewprofession + $maxRows_viewprofession, $totalRows_viewprofession) ?> of <?php echo $totalRows_viewprofession ?>
</form>
</div>
<div id="tabs-5">
 <form action="<?php echo $editFormAction; ?>" method="post" name="form13" id="form13">
        <table width="100%">
 <tr>
    <td valign="top" align="left">
     <table align="center" bgcolor="F4F4F4">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Member Name:</td>
      
        <?php mysql_select_db($database_church, $church);
$query_addmember = "SELECT * FROM member_details";
$addmember = mysql_query($query_addmember, $church) or die(mysql_error());
$row_addmember = mysql_fetch_assoc($addmember);
$totalRows_addmember = mysql_num_rows($addmember);?>
<td><input name="memberid" value="<?php echo $row_editmember['memberid']; ?>" type="hidden">

   <?php if ((isset($_GET['contactid'])) && ($_GET['contactid'] != "")){ echo $row_editcontact['lastname'] ;?>&nbsp;<?php echo $row_editcontact['middlename'] ;?> &nbsp;<?php echo $row_editcontact['firstname'] ; } else {?>
      <select name="memberid" selected="selected">
        <option value="-1" <?php if (!(strcmp(-1, $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?> >Select Member</option>
        <?php
do {  
?>
        <option  size="32"value="<?php echo $row_addmember['memberid']?>"><?php echo $row_addmember['firstname']?>&nbsp;<?php echo $row_addmember['middlename']?>&nbsp;<?php echo $row_addmember['lastname']?></option>
        <?php
} while ($row_addmember = mysql_fetch_assoc($addmember ));
  $rows = mysql_num_rows($addmember );
  if($rows > 0) {
      mysql_data_seek($addmember , 0);
	  $row_addmember = mysql_fetch_assoc($addmember );
  }
?>
      </select><?php }?>
      <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Hobby_name:</td>
      <td><input type="text" name="hobby_name" value="<?php echo htmlentities($row_edithobby['hobby_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" Valign="top">Interests :</td>
      <td><textarea name="intrests" id="intrests" cols="45" rows="5"><?php echo $row_edithobby['intrests'] ?></textarea>
      </td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['hobby_id'])) &&($_GET['hobby_id']!="")) {?><input type="submit" value="Update" name="updatehobby"><?php } else  {?><input type="submit" value="Save" name="savehobby"><?php }?>
      </td>
    </tr>
  </table>
    </form>
      </td>
   <script> 
$("#showhob").click(function () {
$("#hob").toggle("slow");
});    
</script>
  </tr>
  <tr>
    <td><div class="allemployees">
      <table border="1" align="center">
    <tr>
    
       <td width="2%">No</td>
      <td width="15%">Member Names</td>
       <td width="15%">Hobby Name</td>
      <td width="15%">Interests</td>
     
       <td width="2%">&nbsp;</td>
      <td width="2%">&nbsp;</td>
    </tr>
    <?php do { $nub++;
	

	
	
	
	?>
      <tr>
        <td><?php echo $nub;?></td>
          <td><?php echo $row_viewhobby['firstname']; ?>&nbsp;<?php echo $row_viewhobby['middlename']; ?>&nbsp;<?php echo $row_viewhobby['lastname']; ?></td>
       <td><?php echo $row_viewhobby['hobby_name']; ?>&nbsp; </td>
        <td><?php echo $row_viewhobby['intrests']; ?>&nbsp; </td>
        
        
                   <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='clerk'))){ 
  ?> 
        
        <td><a href="index.php?member=show&hobby_id=<?php echo $row_viewhobby['hobby_id']; ?>& #tabs-5"> Edit </a></td> 
        <td><a href="index.php?member=<?php echo $row_viewhobby['hobby_id'];?> & archive=1 & #tabs-5  " onClick="return ConfirmArchive()" >Archive  </a></td>

 <?php }?>
      </tr>
      <?php } while ($row_viewhobby = mysql_fetch_assoc($viewhobby)); ?>
  </table></div></td>
  </tr>
  <table border="0">
  <tr>
    <td><?php if ($pageNum_viewhobby > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewnewmember=%d%s", $currentPage, 0, $queryString_viewhobby); ?>& #tabs-5">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewhobby > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewhobby=%d%s", $currentPage, max(0, $pageNum_viewhobby - 1), $queryString_viewhobby); ?>& #tabs-5">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewhobby < $totalPages_viewhobby) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewhobby=%d%s", $currentPage, min($totalPages_viewhobby, $pageNum_viewhobby + 1), $queryString_viewhobby); ?>& #tabs-5">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewhobby < $totalPages_viewhobby) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewhobby=%d%s", $currentPage, $totalPages_viewhobby, $queryString_viewhobby); ?>& #tabs-5">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewhobby + 1) ?> to <?php echo min($startRow_viewhobby + $maxRows_viewhobby, $totalRows_viewhobby) ?> of <?php echo $totalRows_viewhobby ?>
  
  </div>

 <div id="tabs-6"> 
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
  
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Firstname:</td>
      <td><input type="text" name="firstname" value="<?php echo htmlentities($row_editnewmember['firstname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Middlename:</td>
      <td><input type="text" name="middlename" value="<?php echo htmlentities($row_editnewmember['middlename'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
  
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Lastname:</td>
      <td><input type="text" name="lastname" value="<?php echo htmlentities($row_editnewmember['lastname'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
  
  
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Dateofbirth:</td>
      <td><input type="text" name="dateofbirth" id="dateofbirthadmn" value="<?php echo htmlentities($row_editnewmember['dateofbirth'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    
    
       <?php
	  
	  mysql_select_db($database_church, $church);
$query_addgender = "SELECT * FROM gender";
$addgender = mysql_query($query_addgender, $church) or die(mysql_error());
$row_addgender = mysql_fetch_assoc($addgender);
$totalRows_addgender = mysql_num_rows($addgender);
	  
       ?>
    
   <tr valign="baseline">
      <td nowrap="nowrap" align="right">Gender:</td>
      <td>  <span id="spryselect1">
        <select name="genderid" selected="selected">
           <option value="-1"  <?php if (!(strcmp(-1, $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?>>Select Gender</option>
          <?php 
do {  
?>
          <option value="<?php echo $row_addgender['genderid']?>"<?php if (!(strcmp($row_addgender['genderid'], $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_addgender['gendername']?></option>
 <?php
} while ($row_addgender = mysql_fetch_assoc($addgender));
?>
        </select>
         <span class="selectRequiredMsg">Please select a Gender.</span></span></td>
    </tr>
     
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Admissiondate:</td>
      <td><input type="text" name="admissiondate"  id="admissiondate"value="<?php echo htmlentities($row_editnewmember['admissiondate'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Identificationnumber:</td>
      <td><input type="text" name="identificationnumber" value="<?php echo htmlentities($row_editnewmember['identificationnumber'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
   <tr valign="baseline">
      <td nowrap="nowrap" align="right">Cell Group</td>
      <td>
      <?php
	  
	  mysql_select_db($database_church, $church);
$query_addgroup = "SELECT * FROM locality";
$addgroup = mysql_query($query_addgroup, $church) or die(mysql_error());
$row_addgroup = mysql_fetch_assoc($addgroup);
$totalRows_addgroup = mysql_num_rows($addgroup);
	  
       ?>
       <span id="spryselect2">
      <select name="localityid" selected="selected">
        <option value="-1">Select Group</option>
        <?php 
do {  
?>
        <option value="<?php echo $row_addgroup['localityid']?>" <?php if (!(strcmp($row_addgroup['localityid'], $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_addgroup['locationname']?></option>
     <?php
} while ($row_addgroup = mysql_fetch_assoc($addgroup));


  $rows = mysql_num_rows($addgroup);
  if($rows > 0) {
      mysql_data_seek($addgroup, 0);
	  $row_addgroup = mysql_fetch_assoc($addgroup);
  }
?>

      </select>
      
      
       <span class="selectRequiredMsg">Please select Residence.</span></span></td>
    </tr>
     <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status:</td>
      <td>
         <span id="spryselect3">
         
        <select name="statusid" selected="selected">
           <option value="-1"  <?php if (!(strcmp(-1, $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?>>Select Status</option>
          <?php 
do {  
?>
          <option value="<?php echo $row_addstatus['statusid']?>" <?php if (!(strcmp($row_addstatus['statusid'], $row_editmember['memberid']))) {echo "selected=\"selected\"";} ?> ><?php echo $row_addstatus['statusname']?></option>
  <?php
} while ($row_addstatus = mysql_fetch_assoc($addstatus));
  $rows = mysql_num_rows($addstatus);
  if($rows > 0) {
      mysql_data_seek($addstatus, 0);
	  $row_addstatus = mysql_fetch_assoc($addstatus);
  }
?>





        </select>
     <span class="selectRequiredMsg">Please select Residence.</span></span></td>
    </tr>
  <?php 
  mysql_select_db($database_church, $church);
$query_addleader1 ="SELECT * FROM leader l LEFT JOIN member_details md ON md.memberid=l.memberid ";
$addleader1 = mysql_query($query_addleader1, $church) or die(mysql_error());
$row_addleader1 = mysql_fetch_assoc($addleader1);
$totalRows_addleader1 = mysql_num_rows($addleader1);
  
  
  ?>  
  
      <tr valign="baseline">
      <td nowrap="nowrap" align="right">Previous Church:</td>
      <td><input type="text" name="previous_church" value="<?php echo htmlentities($row_editnewmember['previous_church'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
  
    
    
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Admitted By:</td>
      <td><span id="spryselect1">
        <select name="leaderid" selected="selected">
          <option value="-1"  <?php if (!(strcmp(-1, $row_editbaptism['baptismid']))) {echo "selected=\"selected\"";} ?>>Select Leader</option>
          <?php
do {  
?>
          <option value="<?php echo $row_addleader1['memberid']?>"<?php if (!(strcmp($row_addleader1['memberid'], $row_editbaptism['baptismid']))) {echo "selected=\"selected\"";} ?>><?php echo $row_addleader1['firstname']?> <?php echo $row_addleader1['middlename']?> <?php echo $row_addleader1['lastname']?></option>
          <?php
} while ($row_addleader1 = mysql_fetch_assoc($addleader1));
  $rows = mysql_num_rows($addleader1);
  if($rows > 0) {
      mysql_data_seek($addleader1, 0);
	  $row_addleader1 = mysql_fetch_assoc($addleader1);
  }
?>
        </select>
        <span class="selectRequiredMsg">Please select an item.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><?php if((isset($_GET['memberid'])) &&($_GET['memberid']!="")) {?>
          <input type="submit" value="Update" name="updatenewmember">
	 <?php } else  {?><input type="submit" value="Save" name="savenewmember"><?php }?>
      </td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

<table border="1" align="center">
  <tr>
  <td></td>
     <td>No</td>
    <td>memberid</td>
    <td>lastname</td>
    <td>middlename</td>
    <td>firstname</td>
    <td>dateofbirth</td>
    <td>genderid</td>
    <td>admissiondate</td>
    <td>identificationnumber</td>
    <td>Cell Group</td>
    <td>Previous Church</td>
    <td>statusid</td>
    <td>Admitted By</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  
  </tr>
  <?php do { $newmember++; ?>
    <tr>
      <td><?php  echo  $newmember;  ?></td>
      <td> <?php echo $row_viewnewmember['memberid']; ?>&nbsp;</td>

      <td><?php echo $row_viewnewmember['lastname']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['middlename']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['firstname']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['dateofbirth']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['gendername']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['admissiondate']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['identificationnumber']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['locationname']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['previous_church']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['statusname']; ?>&nbsp; </td>
      <td><?php echo $row_viewnewmember['leaderidrt']; ?>&nbsp; </td>
         <td><a href="index.php?member=show&memberid=<?php echo $row_viewnewmember['memberid']; ?>& #tabs-6"> Edit </a></td>
                    
 <td><a href="index.php?member=show&memberid=<?php echo $row_viewnewmember['memberid'];?> & Delete=4 &#tabs-6" onClick="return confirm('Are you sure you want to delete?')"> Delete </a></td>
    
    </tr>
    <?php } while ($row_viewnewmember = mysql_fetch_assoc($viewnewmember)); ?>
</table>

<br />
<table border="0">
  <tr>
    <td><?php if ($pageNum_viewnewmember > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewnewmember=%d%s", $currentPage, 0, $queryString_viewnewmember); ?>& #tabs-6">First</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewnewmember > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_viewnewmember=%d%s", $currentPage, max(0, $pageNum_viewnewmember - 1), $queryString_viewnewmember); ?>& #tabs-6">Previous</a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_viewnewmember < $totalPages_viewnewmember) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewnewmember=%d%s", $currentPage, min($totalPages_viewnewmember, $pageNum_viewnewmember + 1), $queryString_viewnewmember); ?>& #tabs-6">Next</a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_viewnewmember < $totalPages_viewnewmember) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_viewnewmember=%d%s", $currentPage, $totalPages_viewnewmember, $queryString_viewnewmember); ?>& #tabs-6">Last</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
Records <?php echo ($startRow_viewnewmember + 1) ?> to <?php echo min($startRow_viewnewmember + $maxRows_viewnewmember, $totalRows_viewnewmember) ?> of <?php echo $totalRows_viewnewmember ?>

</div>
 <div id="tabs-7">
 <table> <strong>Search Member</strong>:
 <input name="smembername" type="text" id="smembername" onKeyUp="getbysearchname('output_div1','smembername','0')" size="30">
</table>
     <table border="1" align="center" bgcolor="F4F4F4">
     
  
  <td> <?php include('search_results.php');?></td>
 </table></div>
</div> 
  </div> 
  </div> 
  </body>



</html>
<script type="text/javascript">

var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");


</script>

<?php
@mysql_free_result($emphisto);

@mysql_free_result($academic);

@mysql_free_result($thisacademic);


@mysql_free_result($profile);

@mysql_free_result($thisprofile);

@mysql_free_result($emphisto);

@mysql_free_result($thisemphisto);

@mysql_free_result($hobbies);

@mysql_free_result($thishobby);

@mysql_free_result($referees);

@mysql_free_result($thisreferee);


?>
<?php
@mysql_free_result($allemployees);

@mysql_free_result($thisskill);

?>

<?php ob_end_flush()?>