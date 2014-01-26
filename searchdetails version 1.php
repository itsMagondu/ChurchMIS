<?php ob_start()?>

<?php session_start();
require_once('Connections/church.php');
require_once('functions.php');
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


if (isset($_GET['searchdetailsid'])) {

mysql_select_db($database_church, $church);
$query_memberdeatils = "SELECT * FROM member_details  md   
LEFT JOIN member_contacts  mc ON md.memberid=mc.memberid LEFT JOIN first_confirmation fc  ON md.memberid=fc.memberid
 LEFT JOIN second_confirmation sc ON md.memberid=sc.memberid  
LEFT JOIN locality l ON md.localityid=l.localityid LEFT JOIN hobbies  h ON md.memberid=h.memberid 
LEFT JOIN member_photo mp ON md.memberid=mp.memberid LEFT JOIN gender g ON md.genderid=g.genderid LEFT JOIN marital_status ms ON md.statusid=ms.statusid
LEFT JOIN baptism b ON b.memberid=md.memberid WHERE md.memberid=".$_GET['searchdetailsid']."";
$memberdeatils = mysql_query($query_memberdeatils, $church) or die(mysql_error());
$row_memberdeatils = mysql_fetch_assoc($memberdeatils);
$totalRows_memberdeatils = mysql_num_rows($memberdeatils);


mysql_select_db($database_church, $church);
$query_memberfirstconfirmation = "SELECT * FROM member_details  md   
LEFT JOIN first_confirmation f ON f.memberid=md.memberid  WHERE md.memberid=".$_GET['searchdetailsid']."";
$memberfirstconfirmation = mysql_query($query_memberfirstconfirmation, $church) or die(mysql_error());
$row_memberfirstconfirmation = mysql_fetch_assoc($memberfirstconfirmation);
$totalRows_memberfirstconfirmation = mysql_num_rows($memberfirstconfirmation);

mysql_select_db($database_church, $church);
$query_membersecondconfirmation = "SELECT * FROM member_details  md   
LEFT JOIN second_confirmation s ON s.memberid=md.memberid  WHERE md.memberid=".$_GET['searchdetailsid']."";
$membersecondconfirmation = mysql_query($query_membersecondconfirmation, $church) or die(mysql_error());
$row_membersecondconfirmation = mysql_fetch_assoc($membersecondconfirmation);
$totalRows_membersecondconfirmation = mysql_num_rows($membersecondconfirmation);

mysql_select_db($database_church, $church);
$query_membersecondconfirmation = "SELECT * FROM member_details  md   
LEFT JOIN second_confirmation s ON s.memberid=md.memberid  WHERE md.memberid=".$_GET['searchdetailsid']."";
$membersecondconfirmation = mysql_query($query_membersecondconfirmation, $church) or die(mysql_error());
$row_membersecondconfirmation = mysql_fetch_assoc($membersecondconfirmation);
$totalRows_membersecondconfirmation = mysql_num_rows($membersecondconfirmation);

mysql_select_db($database_church, $church);
$query_memberhobby = "SELECT * FROM hobbies   hs   
INNER  JOIN member_details md   ON hs.memberid=md.memberid  WHERE md.memberid=".$_GET['searchdetailsid']."";
$memberhobby = mysql_query($query_memberhobby, $church) or die(mysql_error());
$row_memberhobby = mysql_fetch_assoc($memberhobby);
$totalRows_memberhobby = mysql_num_rows($memberhobby);



mysql_select_db($database_church, $church);
$query_memberacademic = "SELECT * FROM academic   a   
INNER  JOIN member_details md   ON a.memberid=md.memberid  WHERE md.memberid=".$_GET['searchdetailsid']."";
$memberacademic = mysql_query($query_memberacademic, $church) or die(mysql_error());
$row_memberacademic = mysql_fetch_assoc($memberacademic);
$totalRows_memberacademic = mysql_num_rows($memberacademic);

mysql_select_db($database_church, $church);
$query_memberprofession = "SELECT * FROM profession   p   
INNER  JOIN member_details md   ON p.memberid=md.memberid  WHERE md.memberid=".$_GET['searchdetailsid']."";
$memberprofession = mysql_query($query_memberprofession, $church) or die(mysql_error());
$row_memberprofession = mysql_fetch_assoc($memberprofession);
$totalRows_memberprofession = mysql_num_rows($memberprofession);



mysql_select_db($database_church, $church);
$query_viewbaptism = "SELECT * FROM baptism b INNER JOIN member_details m ON b.memberid=m.memberid LEFT JOIN leader l on b.leaderid=l.leaderid WHERE m.memberid=".$_GET['searchdetailsid'].""; 
$query_limit_viewbaptism = sprintf("%s LIMIT %d, %d", $query_viewbaptism, $startRow_viewbaptism, $maxRows_viewbaptism);
$viewbaptism = mysql_query($query_limit_viewbaptism, $church) or die(mysql_error());
$row_viewbaptism = mysql_fetch_assoc($viewbaptism);


					
}

if ((isset($_GET['detailsid'])) && ($_GET['detailsid'] != "")) {
mysql_select_db($database_church, $church);
$query_supervisor = "SELECT * FROM supervision s INNER JOIN employees e ON s.supervisor=e.employee_id WHERE supervisee=".$_GET['detailsid']."";
$supervisor = mysql_query($query_supervisor, $church) or die(mysql_error());
$row_supervisor = mysql_fetch_assoc($supervisor);
$totalRows_supervisor = mysql_num_rows($supervisor);

mysql_select_db($database_church, $church);
$query_promotions = "SELECT * FROM promotions p RIGHT JOIN employees e ON e.employee_id=p.employee_id INNER JOIN departments d ON e.department_id=d.department_id WHERE p.employee_id=".$_GET['detailsid']." ORDER BY p.promotion_date";
$promotions = mysql_query($query_promotions, $church) or die(mysql_error());
$row_promotions = mysql_fetch_assoc($promotions);
$totalRows_promotions = mysql_num_rows($promotions);

mysql_select_db($database_church, $church);
$query_awards = "SELECT * FROM awards a RIGHT JOIN employees e ON a.employee_id=e.employee_id WHERE a.employee_id=".$_GET['detailsid']."  ORDER BY a.date_awarded";
$awards = mysql_query($query_awards, $church) or die(mysql_error());
$row_awards = mysql_fetch_assoc($awards);
$totalRows_awards = mysql_num_rows($awards);

mysql_select_db($database_church, $church);
$query_hobbies = "SELECT * FROM hobbies   WHERE memberid=".$_GET['detailsid']."  ORDER BY acad_from";
$hobbies = mysql_query($query_hobbies, $church) or die(mysql_error());
$row_hobbies = mysql_fetch_assoc($hobbies);
$totalRows_hobbies = mysql_num_rows($hobbies);

mysql_select_db($database_church, $church);
$query_profile = "SELECT * FROM profile WHERE employee_id=".$_GET['detailsid']." ";
$profile = mysql_query($query_profile, $church) or die(mysql_error());
$row_profile = mysql_fetch_assoc($profile);
$totalRows_profile = mysql_num_rows($profile);

mysql_select_db($database_church, $church);
$query_thisgrade = "SELECT * FROM interview WHERE interviewee=".$_GET['detailsid']."";
$thisgrade = mysql_query($query_thisgrade, $church) or die(mysql_error());
$row_thisgrade = mysql_fetch_assoc($thisgrade);
$totalRows_thisgrade = mysql_num_rows($thisgrade);

if($row_thisgrade['points']){
mysql_select_db($database_church, $church);
$query_grade = "SELECT level FROM grading WHERE ".$row_thisgrade['points']." BETWEEN  lowerlimit AND  upperlimit" ;
$grade = mysql_query($query_grade, $church) or die(mysql_error());
$row_grade = mysql_fetch_assoc($grade);
$totalRows_grade = mysql_num_rows($grade);

}



mysql_select_db($database_church, $church);
$query_training = "SELECT * FROM training WHERE employee_id=".$_GET['detailsid']." ORDER BY train_date_from";
$training = mysql_query($query_training, $church) or die(mysql_error());
$row_training = mysql_fetch_assoc($training);
$totalRows_training = mysql_num_rows($training);

mysql_select_db($database_church, $church);
$query_emphistory = "SELECT * FROM employment_history WHERE employee_id=".$_GET['detailsid']."";
$emphistory = mysql_query($query_emphistory, $church) or die(mysql_error());
$row_emphistory = mysql_fetch_assoc($emphistory);
$totalRows_emphistory = mysql_num_rows($emphistory);

mysql_select_db($database_church, $church);
$query_hobbies = "SELECT * FROM hobbies WHERE employee_id=".$_GET['detailsid']."";
$hobbies = mysql_query($query_hobbies, $church) or die(mysql_error());
$row_hobbies = mysql_fetch_assoc($hobbies);
$totalRows_hobbies = mysql_num_rows($hobbies);

mysql_select_db($database_church, $church);
$query_referees = "SELECT * FROM referees WHERE employee_id=".$_GET['detailsid']."";
$referees = mysql_query($query_referees, $church) or die(mysql_error());
$row_referees = mysql_fetch_assoc($referees);
$totalRows_referees = mysql_num_rows($referees);

mysql_select_db($database_church, $church);
$query_nokin = "SELECT * FROM next_of_keen WHERE employee_id=".$_GET['detailsid']."";
$nokin = mysql_query($query_nokin, $church) or die(mysql_error());
$row_nokin = mysql_fetch_assoc($nokin);
$totalRows_nokin = mysql_num_rows($nokin);

mysql_select_db($database_church, $church);
$query_dependants = "SELECT * FROM dependants WHERE employee_id=".$_GET['detailsid']."";
$dependants = mysql_query($query_dependants, $church) or die(mysql_error());
$row_dependants = mysql_fetch_assoc($dependants);
$totalRows_dependants = mysql_num_rows($dependants);


mysql_select_db($database_church, $church);
$query_personleaves1 = "SELECT * FROM leave_applicants WHERE employee_id=".$_GET['detailsid']." AND lstatus=2 ORDER BY appliedon DESC LIMIT 1";
$personleaves1 = mysql_query($query_personleaves1, $church) or die('Cannot Perform the Calculations on Leave Days');
$row_personleaves1 = mysql_fetch_assoc($personleaves1);
$totalRows_personleaves1 = mysql_num_rows($personleaves1);

mysql_select_db($database_church, $church);
$query_disciplinary = "SELECT * FROM disciplinary WHERE employee_id=".$_GET['detailsid']."";
$disciplinary = mysql_query($query_disciplinary, $church) or die(mysql_error());
$row_disciplinary = mysql_fetch_assoc($disciplinary);
$totalRows_disciplinary = mysql_num_rows($disciplinary);
}else if ((isset($_SESSION['eims_logged']))) {
mysql_select_db($database_church, $church);
$query_supervisor = "SELECT * FROM supervision s INNER JOIN employees e ON s.supervisor=e.employee_id WHERE supervisee=".$_SESSION['eims_logged']."";
$supervisor = mysql_query($query_supervisor, $church) or die(mysql_error());
$row_supervisor = mysql_fetch_assoc($supervisor);
$totalRows_supervisor = mysql_num_rows($supervisor);

mysql_select_db($database_church, $church);
$query_promotions = "SELECT * FROM promotions p RIGHT JOIN employees e ON e.employee_id=p.employee_id INNER JOIN departments d ON e.department_id=d.department_id WHERE p.employee_id=".$_SESSION['eims_logged']." ORDER BY p.promotion_date";
$promotions = mysql_query($query_promotions, $church) or die(mysql_error());
$row_promotions = mysql_fetch_assoc($promotions);
$totalRows_promotions = mysql_num_rows($promotions);

mysql_select_db($database_church, $church);
$query_awards = "SELECT * FROM awards a RIGHT JOIN employees e ON a.employee_id=e.employee_id WHERE a.employee_id=".$_SESSION['eims_logged']."  ORDER BY a.date_awarded";
$awards = mysql_query($query_awards, $church) or die(mysql_error());
$row_awards = mysql_fetch_assoc($awards);
$totalRows_awards = mysql_num_rows($awards);

mysql_select_db($database_church, $church);
$query_academics = "SELECT * FROM academics  WHERE employee_id=".$_SESSION['eims_logged']."  ORDER BY acad_from";
$academics = mysql_query($query_academics, $church) or die(mysql_error());
$row_academics = mysql_fetch_assoc($academics);
$totalRows_academics = mysql_num_rows($academics);

mysql_select_db($database_church, $church);
$query_profile = "SELECT * FROM profile WHERE employee_id=".$_SESSION['eims_logged']." ";
$profile = mysql_query($query_profile, $church) or die(mysql_error());
$row_profile = mysql_fetch_assoc($profile);
$totalRows_profile = mysql_num_rows($profile);

mysql_select_db($database_church, $church);
$query_training = "SELECT * FROM training WHERE employee_id=".$_SESSION['eims_logged']." ORDER BY train_date_from";
$training = mysql_query($query_training, $church) or die(mysql_error());
$row_training = mysql_fetch_assoc($training);
$totalRows_training = mysql_num_rows($training);

mysql_select_db($database_church, $church);
$query_emphistory = "SELECT * FROM employment_history WHERE employee_id=".$_SESSION['eims_logged']."";
$emphistory = mysql_query($query_emphistory, $church) or die(mysql_error());
$row_emphistory = mysql_fetch_assoc($emphistory);
$totalRows_emphistory = mysql_num_rows($emphistory);

mysql_select_db($database_church, $church);
$query_hobbies = "SELECT * FROM hobbies WHERE employee_id=".$_SESSION['eims_logged']."";
$hobbies = mysql_query($query_hobbies, $church) or die(mysql_error());
$row_hobbies = mysql_fetch_assoc($hobbies);
$totalRows_hobbies = mysql_num_rows($hobbies);

mysql_select_db($database_church, $church);
$query_referees = "SELECT * FROM referees WHERE employee_id=".$_SESSION['eims_logged']."";
$referees = mysql_query($query_referees, $church) or die(mysql_error());
$row_referees = mysql_fetch_assoc($referees);
$totalRows_referees = mysql_num_rows($referees);

mysql_select_db($database_church, $church);
$query_nokin = "SELECT * FROM next_of_keen WHERE employee_id=".$_SESSION['eims_logged']."";
$nokin = mysql_query($query_nokin, $church) or die(mysql_error());
$row_nokin = mysql_fetch_assoc($nokin);
$totalRows_nokin = mysql_num_rows($nokin);

mysql_select_db($database_church, $church);
$query_dependants = "SELECT * FROM dependants WHERE employee_id=".$_SESSION['eims_logged']."";
$dependants = mysql_query($query_dependants, $church) or die(mysql_error());
$row_dependants = mysql_fetch_assoc($dependants);
$totalRows_dependants = mysql_num_rows($dependants);

mysql_select_db($database_church, $church);

mysql_select_db($database_church, $church);

$query_disciplinary = "SELECT * FROM disciplinary WHERE employee_id=".$_SESSION['eims_logged']."";
$disciplinary = mysql_query($query_disciplinary, $church) or die(mysql_error());
$row_disciplinary = mysql_fetch_assoc($disciplinary);
$totalRows_disciplinary = mysql_num_rows($disciplinary);



mysql_select_db($database_church, $church);
$query_grade = "SELECT * FROM interview WHERE interviewee=".$_SESSION['eims_logged']."";
$grade = mysql_query($query_grade, $church) or die(mysql_error());
$row_grade = mysql_fetch_assoc($grade);
$totalRows_grade = mysql_num_rows($grade);


}



?>
<?php 

 function nl2li($str,$ordered = 1, $type = "1", $cssClass=" ") {
	 
// Return if there are no line breaks

if (!strstr($str, "\n")) {
return $str;
}

// Add Optional css class
if (!empty($cssClass)) {
$cssClass = ' class="' . $cssClass . '" ';
}	 

//check if its ordered or unordered list, set tag accordingly

if ($ordered)
{
$tag="ol";
//specify the type
$tag_type="type=$type";
}
else
{
$tag="ul";
//set $type as NULL
$tag_type=NULL;
}

// add ul / ol tag
// add tag type
// add first list item starting tag
// add last list item ending tag
$str = '<p' . $cssClass . '>' . $str . '</p>';

$str = "<$tag $tag_type><li>" . $str ."</li></$tag>";


//replace /n with adding two tags
// add previous list item ending tag
// add next list item starting tag
$str = str_replace("\n","</li><br />\n<li>",$str);

// remove empty paragraph tags & any cariage return characters
$str = str_replace(array("<p" . $cssClass . "></p>", "<p></p>", "\r"), " ", $str);

//spit back the modified string
return $str;
}

function nl2p($text, $cssClass=""){

// Return if there are no line breaks

if (!strstr($text, "\n")) {
return $text;
}

// Add Optional css class
if (!empty($cssClass)) {
$cssClass = ' class="' . $cssClass . '" ';
}

// put all text into <p> tags
$text = '<p' . $cssClass . '>' . $text . '</p>';

// replace all newline characters with paragraph
// ending and starting tags
$text = str_replace("\n", "</p>\n<p" . $cssClass . '>', $text);

// remove empty paragraph tags & any cariage return characters
$text = str_replace(array("<p" . $cssClass . "></p>", "<p></p>", "\r"), "", $text);

return $text;

} // end nl2p

?>
<!doctype html>
<html lang="en">
<head>
	<title>The Report</title>
	<link type="text/css" href="js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
	
   <script type="text/javascript" src="/st_peters/js/jquery-ui/jquery-1.4.2.js"></script> 
 <script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.core.js"></script>  
    
   <script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.widget.js"></script>
  
  <script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.widget.js"></script> 
   
   
	<script type="text/javascript" src="js/jquery-ui/ui/jquery.ui.accordion.js"></script>
    
 <script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.accordion.js"></script>   
    
   
<link type="text/css" href="/st_peters/tms.css" rel="stylesheet">
  	

	<script type="text/javascript">
	$(function() {
		$("#accordion").accordion({
			autoHeight: false,
			navigation: true
		});
	});
	</script>
</head>
<div class="mainbodyview">
<body>

<div class="demo">


<div align="left"><h2>  <img src="photos/<?php echo $row_memberdeatils['photo']; ?>" alt="<?php echo $row_memberdeatils['photo']; ?>" name="picholder" width="20%" height="20%" id="picholder" /> <?php echo $row_memberdeatils['firstname']; ?> <?php echo $row_memberdeatils['middlename']; ?> <?php echo  $row_memberdeatils['lastname']?> - <?php echo $row_memberdeatils['title']; ?> - <?php
		$leave=$row_personleaves1['leavetype'];
		$endleave = $row_personleaves1['enddate']; 
		$todays_date = date("Y-m-d"); 
		$today = strtotime($todays_date); 
		$endleave_date = strtotime($endleave);?><font color="#FF0000" size="+2"><?php 
		if ($endleave_date >= $today) { echo " is on ".$leave." upto  ". $endleave ; } ?></font></h2></div>
<div id="accordion">

	<h3><a href="#">MEMBER INFORMATION</a></h3>
	<div>
        <table width="100%" class="content">
  <tr>
    <th width="88%" scope="col">

    <table width="100%" class="listcontent">
      <tr>
        <th colspan="4" scope="row"><div align="left" class="tableheader">
          MEMBER DETAILS
        </div></th>
        </tr>
      <tr>
        <th width="12%" bgcolor="#CCCCCC" scope="row"><div align="left"><strong>NAME</strong></div></th>
        <td width="32%"><div align="left"><?php echo $row_memberdeatils['firstname']; ?> <?php echo $row_memberdeatils['middlename']; ?> <?php echo $row_memberdeatils['lastname']; ?> </div></td>
        <td width="21%" bgcolor="#CCCCCC"><div align="left">ID NUMBER</div></td>
        <td width="35%"><div align="left"><?php echo $row_memberdeatils['identificationnumber']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>LOCALITY</strong></div></th>
        <td><div align="left"><?php echo $row_memberdeatils['locationname']; ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left">STATUS</div></td>
        <td><div align="left"><?php echo $row_memberdeatils['statusname']; ?></div></td>
      </tr>
    </table>  </th>
  </tr>
 <hr>&nbsp;</hr>
  <tr>
    <td><table width="100%" border="0" class="listcontent">
      <tr>
        <th colspan="9" align="left" scope="col"><div class="tableheader">
          <strong><hr>PERSONAL INFORMATION</hr></strong>
        </div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div></th>
        </tr>
      <tr class="tableheader">
      
        <td><div align="left"><strong>GENDER</strong></div></td>
        <td><strong>MARITAL STATUS</strong></td>
        <td><div align="left"><strong>DATE  OF BIRTH</strong></div></td>
        </tr>
         <tr>
        
        <td><div align="left"><?php echo $row_memberdeatils['gendername']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['statusname']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['dateofbirth']; ?></div></td>
      
      </tr>
    </table></td>
  </tr>

  <tr>
    <td><table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="8"><div class="tableheader">
         <h3> CONTACT DETAILS</h3>
        </div>          </td>
        </tr>
      <tr class="tableheader">
       
        <td><div align="left"><strong>MOBILE NO.</strong></div></td>
        <td><div align="left"><strong>EMAIL</strong></div></td>
        <td><div align="left"><strong>ALTERNATIVE CONTACT</strong></div></td>
        <td><div align="left"><strong>PHYSICAL ADDRESS</strong></div></td>
       
      </tr>
      <tr>
        <td><div align="left"><?php echo $row_memberdeatils['phonenumber']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['emailaddress']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['alternative_contact']; ?></div></td>      <td><div align="left"><?php echo $row_memberdeatils['physical_address']; ?></div></td>
        
      </tr>
      <tr>
        <td colspan="8">&nbsp;</td>
        </tr>
    </table></td>
  </tr><hr>&nbsp;</hr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php ?><table width="100%" border="0" class="listcontent">
      <tr>
        
        </tr>
   

    </table><div class="tableheader"></div></td>
  </tr></table>

        
	</div>
    
    <h3><a href="#"><strong>BAPTISM  DETAILS</strong> </a></h3>
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <tr><td>
     <table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
        <td><div align="left"><strong>Baptism Date</strong></div></td>
        <td><div align="left"><strong>Leader Name</strong></div></td>
        <td><div align="left"><strong>Male god Parent.</strong></div></td>
        <td><div align="left"><strong>Female god Parent.</strong></div></td>
        <td><div align="left"><strong>Baptism Cert No.</strong></div></td>
  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left"><?php echo $row_memberdeatils['date']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['leaderid']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['male_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['female_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['baptismcert_no']; ?></div></td>
        
        <td>&nbsp;</td>
      </tr>
    </table> 
        
</td></tr></table></div>

      <h3><a href="#"><strong>PRE CONFIRMATION </strong> </a></h3>
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <tr><td>
     <table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
    <td><div align="left"><strong>Confirmation Date</strong></div></td>
        <td><div align="left"><strong>Leader Name</strong></div></td>
        <td><div align="left"><strong>Male god Parent.</strong></div></td>
        <td><div align="left"><strong>Female god Parent.</strong></div></td>
        <td><div align="left"><strong>Confirmation Cert No.</strong></div></td>  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <tr>
        <td><div align="left"><?php echo $row_memberfirstconfirmation['date']; ?></div></td>
        <td><div align="left"><?php echo $row_memberfirstconfirmation['leaderid']; ?></div></td>
        <td><div align="left"><?php echo $row_memberfirstconfirmation['male_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_memberfirstconfirmation['female_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_memberfirstconfirmation['first_confirmationcert_no']; ?></div></td>
        </tr>
       </tr>
    </table> 
        
</td></tr></table></div>

      <h3><a href="#"><strong>CONFIRMATION DETAILS</strong> </a></h3>
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <tr><td>
     <table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
    <td><div align="left"><strong>Confirmation Date</strong></div></td>
        <td><div align="left"><strong>Leader Name</strong></div></td>
        <td><div align="left"><strong>Male god Parent.</strong></div></td>
        <td><div align="left"><strong>Female god Parent.</strong></div></td>
        <td><div align="left"><strong>Confirmation Cert No.</strong></div></td>  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <tr>
        <td><div align="left"><?php echo $row_membersecondconfirmation['date']; ?></div></td>
        <td><div align="left"><?php echo $row_membersecondconfirmation['leaderid']; ?></div></td>
        <td><div align="left"><?php echo $row_membersecondconfirmation['male_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_membersecondconfirmation['female_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_membersecondconfirmation['second_confirmationcert_no']; ?></div></td>
        </tr>
       </tr>
    </table> 
        
</td></tr></table></div>


 <h3><a href="#"><strong>HOLY MATRIMONY</strong> </a></h3>
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <tr><td>
     <table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
    <td><div align="left"><strong>Husband Name</strong></div></td>
     <td><div align="left"><strong>Wife Name</strong></div></td>
        <td><div align="left"><strong>Best Man </strong></div></td>
        <td><div align="left"><strong>Best Maid.</strong></div></td>
        <td><div align="left"><strong>Wedding Date.</strong></div></td>
    <td><div align="left"><strong>Registrar Officiating.</strong></div></td>    <td><div align="left"><strong>Solemnization Venue.</strong></div></td> 
   <td><div align="left"><strong>Marriage Cert No.</strong></div></td> 
    <td><div align="left"><strong>Marriage Cert No.</strong></div></td> 
     <td><div align="left"><strong>Marriage Cert No.</strong></div></td>   
  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <tr>
        <td><div align="left"><?php echo $row_viewhusband['firstname']; ?>&nbsp;<?php echo $row_viewhusband['middlename']; ?>&nbsp;<?php echo $row_viewhusband['lastname']; ?></div></td>
        <td><div align="left"><?php echo $row_viewmatrimony['husband']; ?></div></td>
        <td><div align="left"><?php echo $row_viewwife['firstname']; ?>&nbsp;<?php echo $row_viewwife['middlename']; ?>&nbsp;<?php echo $row_viewwife['lastname']; ?></div></td>
        <td><div align="left"><?php echo $row_viewmatrimony['wife']; ?></div></td>
        <td><div align="left"><?php echo $row_viewmatrimony['best_man']; ?></div></td>
    <td><div align="left"><?php echo $row_viewmatrimony['best_maid']; ?></div></td>
     <td><div align="left"><?php echo $row_viewmatrimony['marriage_date']; ?></div></td>     
  <td><div align="left"><?php echo $row_viewmatrimonyleader['firstname']; ?>&nbsp;<?php echo $row_viewmatrimonyleader['middlename']; ?>&nbsp;<?php echo $row_viewmatrimonyleader['lastname']; ?></div></td>
   <td><div align="left"><?php echo $row_viewmatrimony['solemnization_venue']; ?></div></td>
    <td><div align="left"><?php echo $row_viewmatrimony['marriagecert_no']; ?></div></td>       
        </tr>
       </tr>
    </table> 
        
</td></tr></table></div>

      
    <h3><a href="#"><strong>HOBBIES & INTERESTS</strong></a></h3>
	
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <tr><td>
     <table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
        <td><div align="left"><strong>Hobby Name</strong></div></td>
        <td><div align="left"><strong>Intrests</strong></div></td>
        <td><div align="left"><strong>Special Skills</strong></div></td>
    
  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left"><?php echo $row_memberhobby['hobby_name']; ?></div></td>
        <td><div align="left"><?php echo $row_memberhobby['intrests']; ?></div></td>
        <td><div align="left"><?php echo $row_memberhobby['special_skills']; ?></div></td>
       
        
        <td>&nbsp;</td>
      </tr>
    </table> 
        
</td></tr></table></div>

 <h3><a href="#"><strong>EDUCATION &&& PROFESSIONS</strong></a></h3>
	
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <tr><td>
     <table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
        <td><div align="left"><strong>Insitution Name</strong></div></td>
        <td><div align="left"><strong>Study Type</strong></div></td>
        <td><div align="left"><strong>Date Started</strong></div></td>
       <td><div align="left"><strong>Date Ended </strong></div></td>
        <td><div align="left"><strong>Level</strong></div></td>
    
  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left"><?php echo $row_memberacademic['institution_name']; ?></div></td>
        <td><div align="left"><?php echo $row_memberacademic['study_type']; ?></div></td>
        <td><div align="left"><?php echo $row_memberacademic['acad_from']; ?></div></td>
        <td><div align="left"><?php echo $row_memberacademic['acad_to']; ?></div></td>
        <td><div align="left"><?php echo $row_memberacademic['level']; ?></div></td>
       
        
        <td>&nbsp;</td>
      </tr>
    </table> 
    
    
       <table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
        <td><div align="left"><strong>Profession Name</strong></div></td>
        <td><div align="left"><strong>Profession Start</strong></div></td>
        <td><div align="left"><strong>Profession End</strong></div></td>
        <td><div align="left"><strong>Company Name</strong></div></td>
        
    
  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left"><?php echo $row_memberprofession['profession_name']; ?></div></td>
        <td><div align="left"><?php echo $row_memberprofession['profession_start']; ?></div></td>
        <td><div align="left"><?php echo $row_memberprofession['profession_end']; ?></div></td>
        <td><div align="left"><?php echo $row_memberprofession['company_name']; ?></div></td>
       
        
        <td>&nbsp;</td>
      </tr>
    </table> 
    
    
    
        
</td></tr></table></div>




    <h3><a href="#">REFEREES</a></h3>
	<div>

<table width="100%" border="0" class="content">
  <tr>
    <td valign="top" align="left" class="tableheader">REFEREES
</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <?php if($totalRows_referees>0) { ?><table border="0" align="left" class="listcontent" width="100%">
      <tr class="tableheader">
      <td>No.</td>
        <td>Referee Names</td>
        <td>Job Ttitle</td>
        <td>Company</td>
        <td>Physical Address</td>
        <td>Mobile</td>
        <td>Telephone</td>
      </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
          <td><?php echo $row_referees['ref_names']; ?>&nbsp; </td>
          <td><?php echo $row_referees['ref_job_title']; ?>&nbsp; </td>
          <td><?php echo $row_referees['ref_company']; ?>&nbsp; </td>
          <td><?php echo $row_referees['ref_Address']; ?>&nbsp; </td>
          <td><?php echo $row_referees['ref_mobile']; ?>&nbsp; </td>
          <td><?php echo $row_referees['ref_telephone']; ?>&nbsp; </td>
        </tr>        <?php } while ($row_referees = mysql_fetch_assoc($referees)); ?>
<tr><td>
      <?php echo $totalRows_referees ?> Records Total</td></tr>
    </table><?php } else { echo "No referees Details"; }  ?>
       </td>
  </tr>
  
</table>
</div>
<h3 align="left">&nbsp;</h3>
<h3>&nbsp;</h3>
<h2>&nbsp;</h2>
</div>

</div><!-- End demo -->





</body>
</div>
</html>
<?php
@mysql_free_result($comanyinfo);

@mysql_free_result($memberdeatils);

@mysql_free_result($supervisor);

@mysql_free_result($promotions);

@mysql_free_result($awards);

@mysql_free_result($academics);

@mysql_free_result($profile);

@mysql_free_result($training);

@mysql_free_result($emphistory);

@mysql_free_result($hobbies);

@mysql_free_result($referees);

@mysql_free_result($nokin);

@mysql_free_result($dependants);

@mysql_free_result($disciplinary);
?>

<?php ob_end_flush()?>