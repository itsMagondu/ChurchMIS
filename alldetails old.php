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


if (isset($_GET['alldetailsid'])) {

mysql_select_db($database_church, $church);
$query_memberdeatils = "SELECT * FROM member_details  md   
LEFT JOIN member_contacts  mc ON md.memberid=mc.memberid LEFT JOIN first_confirmation fc  ON md.memberid=fc.memberid
 LEFT JOIN second_confirmation sc ON md.memberid=sc.memberid  
LEFT JOIN locality l ON md.localityid=l.localityid LEFT JOIN hobbies  h ON md.memberid=h.memberid 
LEFT JOIN member_photo mp ON md.memberid=mp.memberid LEFT JOIN gender g ON md.genderid=g.genderid LEFT JOIN marital_status ms ON md.statusid=ms.statusid
LEFT JOIN baptism b ON b.memberid=md.memberid   WHERE md.memberid=".$_GET['alldetailsid']."";
$memberdeatils = mysql_query($query_memberdeatils, $church) or die(mysql_error());
$row_memberdeatils = mysql_fetch_assoc($memberdeatils);
$totalRows_memberdeatils = mysql_num_rows($memberdeatils);


mysql_select_db($database_church, $church);
$query_memberfirstconfirmation = "SELECT * FROM member_details  md   
LEFT JOIN first_confirmation f ON f.memberid=md.memberid  WHERE md.memberid=".$_GET['alldetailsid']."";
$memberfirstconfirmation = mysql_query($query_memberfirstconfirmation, $church) or die(mysql_error());
$row_memberfirstconfirmation = mysql_fetch_assoc($memberfirstconfirmation);
$totalRows_memberfirstconfirmation = mysql_num_rows($memberfirstconfirmation);

mysql_select_db($database_church, $church);
$query_membersecondconfirmation = "SELECT * FROM member_details  md   
LEFT JOIN second_confirmation s ON s.memberid=md.memberid  WHERE md.memberid=".$_GET['alldetailsid']."";
$membersecondconfirmation = mysql_query($query_membersecondconfirmation, $church) or die(mysql_error());
$row_membersecondconfirmation = mysql_fetch_assoc($membersecondconfirmation);
$totalRows_membersecondconfirmation = mysql_num_rows($membersecondconfirmation);

mysql_select_db($database_church, $church);
$query_membersecondconfirmation = "SELECT * FROM member_details  md   
LEFT JOIN second_confirmation s ON s.memberid=md.memberid  WHERE md.memberid=".$_GET['alldetailsid']."";
$membersecondconfirmation = mysql_query($query_membersecondconfirmation, $church) or die(mysql_error());
$row_membersecondconfirmation = mysql_fetch_assoc($membersecondconfirmation);
$totalRows_membersecondconfirmation = mysql_num_rows($membersecondconfirmation);

mysql_select_db($database_church, $church);
$query_memberhobby = "SELECT * FROM hobbies   hs   
INNER  JOIN member_details md   ON hs.memberid=md.memberid  WHERE md.memberid=".$_GET['alldetailsid']."";
$memberhobby = mysql_query($query_memberhobby, $church) or die(mysql_error());
$row_memberhobby = mysql_fetch_assoc($memberhobby);
$totalRows_memberhobby = mysql_num_rows($memberhobby);



mysql_select_db($database_church, $church);
$query_memberacademic = "SELECT * FROM academic   a   
INNER  JOIN member_details md   ON a.memberid=md.memberid  WHERE md.memberid=".$_GET['alldetailsid']."";
$memberacademic = mysql_query($query_memberacademic, $church) or die(mysql_error());
$row_memberacademic = mysql_fetch_assoc($memberacademic);
$totalRows_memberacademic = mysql_num_rows($memberacademic);

mysql_select_db($database_church, $church);
$query_memberprofession = "SELECT * FROM profession   p   
INNER  JOIN member_details md   ON p.memberid=md.memberid  WHERE md.memberid=".$_GET['alldetailsid']."";
$memberprofession = mysql_query($query_memberprofession, $church) or die(mysql_error());
$row_memberprofession = mysql_fetch_assoc($memberprofession);
$totalRows_memberprofession = mysql_num_rows($memberprofession);



mysql_select_db($database_church, $church);
$query_viewbaptism = "SELECT * FROM baptism b INNER JOIN member_details m ON b.memberid=m.memberid WHERE m.memberid=".$_GET['alldetailsid'].""; 
$query_limit_viewbaptism = sprintf("%s LIMIT %d, %d", $query_viewbaptism, $startRow_viewbaptism, $maxRows_viewbaptism);
$viewbaptism = mysql_query($query_limit_viewbaptism, $church) or die(mysql_error());
$row_viewbaptism = mysql_fetch_assoc($viewbaptism);

					




	
/*
	mysql_select_db($database_church, $church);
$query_marriage= "SELECT * FROM marriage m  INNER  JOIN member_details md ON md.memberid=m.husbandname WHERE  md.memberid=".$_GET['alldetailsid']." AND m.husbandname= ".$_GET['husbandname']."";
$marriagehusband= mysql_query($query_marriagehusband, $church) or die('error2');
$row_marriagehusband= mysql_fetch_assoc($marriagehusband);
$totalRows_marriagehusband = mysql_num_rows($marriagehusband);
	

	mysql_select_db($database_church, $church);
$query_marriagewife= "SELECT * FROM marriage m  INNER  JOIN member_details md ON md.memberid=m.wifenameid WHERE  md.memberid=".$_GET['alldetailsid']." AND m.wifenameid= ".$_GET['wifenameid']."";
$marriagewife= mysql_query($query_marriagewife, $church) or die('error3');
$row_marriagewife= mysql_fetch_assoc($marriagewife);
$totalRows_marriagewife = mysql_num_rows($marriagewife);
*/
	
	
	
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


<div align="left"><h2>  <img src="photos/<?php echo $row_memberdeatils['photo']; ?>" alt="<?php echo $row_memberdeatils['photo']; ?>" name="picholder" width="20%" height="20%" id="picholder" /> <?php echo $row_memberdeatils['firstname']; ?> <?php echo $row_memberdeatils['middlename']; ?> <?php echo  $row_memberdeatils['lastname']?>
		</font></h2></div>
<div id="accordion">
<table width="100%" class="content">
  <tr>
    <th width="88%" scope="col">

    <table width="100%" class="listcontent">
      <tr>
        <th colspan="4" scope="row"></th>
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
  
</table>

        
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
        <td><div align="left"><?php echo $row_memberdeatils['date_baptised']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['officiating_clergy']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['male_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['female_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_memberdeatils['baptismcert_no']; ?></div></td>
        
        <td>&nbsp;</td>
      </tr>
    </table> 
        
</td></tr></table></div>

      <h3></a></h3>
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <tr><td>
    
        
</td></tr></table></div>

      <h3><a href="#"><strong>CONFIRMATION</strong> </a></h3>
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <td>
     <table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
    <td><div align="left"><strong>Confirmation Date</strong></div></td>
        <td><div align="left"><strong>Officiating Bishop</strong></div></td>
        <td><div align="left"><strong>Male god Parent.</strong></div></td>
        <td><div align="left"><strong>Female god Parent.</strong></div></td>
        <td><div align="left"><strong>Confirmation Cert No.</strong></div></td>  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <tr>
        <td><div align="left"><?php echo $row_membersecondconfirmation['secondconfirmation_date']; ?></div></td>
        <td><div align="left"><?php echo $row_membersecondconfirmation['leader']; ?></div></td>
        <td><div align="left"><?php echo $row_membersecondconfirmation['male_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_membersecondconfirmation['female_god_parent']; ?></div></td>
        <td><div align="left"><?php echo $row_membersecondconfirmation['second_confirmationcert_no']; ?></div></td>
        </tr>
   
    </table> 
        
</td></tr></table></div>
      
    <h3><a href="#"><strong>MARRIAGE</strong> </a></h3>
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <td>
     <table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader"></td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
    <td><div align="left"><strong>Spouse Name</strong></div></td>
        <td><div align="left"><strong>Marriage Type</strong></div></td>
        <td><div align="left"><strong>Marriage Date.</strong></div></td>
        <td><div align="left"><strong>Officiating Clergy.</strong></div></td>
     <td><div align="left"><strong>Marriage Cert No.</strong></div></td>
       <td><div align="left"><strong>Solemnization Venue.</strong></div></td>  
        <td>&nbsp;</td>
      </tr>
      <tr>
        <tr>
   <td><div align="left"><?php echo $row_marriagehusband['firstname']; ?>&nbsp;<?php echo $row_marriagehusband['middlename']; ?>&nbsp;<?php echo $row_marriagehusband['lastname']; ?></div></td>
         <td><div align="left"><?php echo $row_marriagewife['firstname']; ?>&nbsp;<?php echo $row_marriagewife['middlename']; ?>&nbsp;<?php echo $row_marriagewife['lastname']; ?></div></td>
        <td><div align="left"><?php echo $row_membermarriage['marriage_type']; ?></div></td>
      <td><div align="left"><?php echo $row_membermarriage['marriage_date']; ?></div></td>
        <td><div align="left"><?php echo $row_membermarriage['leader_name']; ?></div></td>
        <td><div align="left"><?php echo $row_membermarriage['marriagecert_no']; ?></div></td>
        
        <td><div align="left"><?php echo $row_membermarriage['solemnization_venue']; ?></div></td>  
        </tr>
     
    </table> 
        
</td></tr></table></div>
        
      
      
      
      
    <h3><a href="#"><strong>INTERESTS</strong></a></h3>
	
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
        <td><div align="left"><strong>Intrests</strong></div></td>
        <td><div align="left"><strong>Special Skills</strong></div></td>
    
  
        <td>&nbsp;</td>
      </tr>
      <tr>
       
        <td><div align="left"><?php echo $row_memberhobby['intrests']; ?></div></td>
        <td><div align="left"><?php echo $row_memberhobby['special_skills']; ?></div></td>
       
        
        <td>&nbsp;</td>
      </tr>
    </table> 
        
</td></tr></table></div>

 <h3><a href="#"><strong>PROFESSIONS</strong></a></h3>
	
	<div>
      <table width="100%" border="0" class="content">
 
  <tr>
    <tr>
      <td><table width="100%" border="0" class="listcontent">
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




   
	<div>

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