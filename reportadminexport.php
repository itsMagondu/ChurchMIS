<?php ob_start()?>

<?php session_start();
header("Content-Type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Member_Information_Report.doc");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");


require_once('Connections/church.php');
require_once('functions.php');
if (!isset($_SESSION['stpetersadminname'])) {

checkAdmin(); }?> 

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

if ((isset($_GET['alldetailsid'])) && ($_GET['alldetailsid'] != "")) {
	
mysql_select_db($database_church, $church);
$query_memberdeatils = "SELECT * FROM member_details  md   
LEFT JOIN member_contacts  mc ON md.memberid=mc.memberid LEFT JOIN first_confirmation fc  ON md.memberid=fc.memberid
 LEFT JOIN second_confirmation sc ON md.memberid=sc.memberid  
LEFT JOIN locality l ON md.localityid=l.localityid LEFT JOIN hobbies  h ON md.memberid=h.memberid 
LEFT JOIN member_photo mp ON md.memberid=mp.memberid LEFT JOIN gender g ON md.genderid=g.genderid LEFT JOIN marital_status ms ON md.statusid=ms.statusid
LEFT JOIN baptism b ON b.memberid=md.memberid LEFT JOIN church ch ON md.church_id=ch.church_id  WHERE md.memberid=".$_GET['alldetailsid']."";
$memberdeatils = mysql_query($query_memberdeatils, $church) or die(mysql_error());
$row_memberdeatils = mysql_fetch_assoc($memberdeatils);
$totalRows_memberdeatils = mysql_num_rows($memberdeatils);

}
											

if ((isset($_GET['alldetailsid'])) && ($_GET['alldetailsid'] != "")) {
mysql_select_db($database_church, $church);
$query_memberprofession = "SELECT * FROM member_details  md   
LEFT JOIN profession pn ON pn.memberid=md.memberid  WHERE md.memberid=".$_GET['alldetailsid']."";
$memberprofession = mysql_query($query_memberprofession, $church) or die(mysql_error());
$row_memberprofession = mysql_fetch_assoc($memberprofession);
$totalRows_memberprofession = mysql_num_rows($memberprofession);


mysql_select_db($database_church, $church);
$query_memberhobby = "SELECT * FROM hobbies   hs  LEFT JOIN member_details md  ON hs.memberid=md.memberid  WHERE md.memberid=".$_GET['alldetailsid']."";
$memberhobby = mysql_query($query_memberhobby, $church) or die(mysql_error());
$row_memberhobby = mysql_fetch_assoc($memberhobby);
$totalRows_memberhobby = mysql_num_rows($memberhobby);




mysql_select_db($database_church, $church);
$query_viewbaptism = "SELECT * FROM baptism b LEFT JOIN member_details m ON b.memberid=m.memberid WHERE m.memberid=".$_GET['alldetailsid']."";
$viewbaptism = mysql_query($query_viewbaptism, $church) or die(mysql_error());
$row_viewbaptism = mysql_fetch_assoc($viewbaptism);
$totalRows_viewbaptism = mysql_num_rows($viewbaptism);



mysql_select_db($database_church, $church);
$query_viewfirstconfirmation = "SELECT * FROM first_confirmation fn LEFT JOIN member_details m ON fn.memberid=m.memberid WHERE m.memberid=".$_GET['alldetailsid']."";
$viewfirstconfirmation = mysql_query($query_viewfirstconfirmation, $church) or die(mysql_error());
$row_viewfirstconfirmation = mysql_fetch_assoc($viewfirstconfirmation);
$totalRows_viewfirstconfirmation = mysql_num_rows($viewfirstconfirmation);


mysql_select_db($database_church, $church);
$query_viewconfirmation = "SELECT * FROM second_confirmation sn LEFT JOIN member_details m ON sn.memberid=m.memberid WHERE m.memberid=".$_GET['alldetailsid']."";
$viewconfirmation = mysql_query($query_viewconfirmation, $church) or die(mysql_error());
$row_viewconfirmation = mysql_fetch_assoc($viewconfirmation);
$totalRows_viewconfirmation = mysql_num_rows($viewconfirmation);

/* the listed below query quite the headache hope it works */
/*to view husband where wedding type is traditional*/
mysql_select_db($database_church, $church);
$query_viewmarriage = "select * from marriage me INNER JOIN member_details md ON me.wifenameid=md.memberid WHERE md.memberid=".$_GET['alldetailsid']."";
$viewmarriage = mysql_query($query_viewmarriage, $church) or die(mysql_error());
$row_viewmarriage = mysql_fetch_assoc($viewmarriage);
$totalRows_viewmarriage = mysql_num_rows($viewmarriage);

/*to view wife where wedding type is traditional*/
mysql_select_db($database_church, $church);
$query_viewmarriagewife = "select * from marriage me INNER JOIN member_details md ON me.husbandname=md.memberid WHERE md.memberid=".$_GET['alldetailsid']."";
$viewmarriagewife = mysql_query($query_viewmarriagewife, $church) or die(mysql_error());
$row_viewmarriagewife = mysql_fetch_assoc($viewmarriagewife);
$totalRows_viewmarriagewife = mysql_num_rows($viewmarriagewife);

/*to view wife where marriage type is church and both are members of the church */





}


if ((isset($_GET['alldetailsid'])) && ($_GET['alldetailsid'] != "")) {
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
<!doctype html>
<html lang="en">
<head>
	<title>The Report</title>
	<link type="text/css" href="/st_peters/js/jquery-ui/themes/base/jquery.ui.all.css" rel="stylesheet" />
	<script type="text/javascript" src="/st_peters/js/jquery-ui/jquery-1.4.2.js"></script>
	<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="/st_peters/js/jquery-ui/ui/jquery.ui.accordion.js"></script>
	<link type="text/css" href="/st_peters/js/jquery-ui/demos/demos.css" rel="stylesheet" />

    <link type="text/css" href="/st_peters/tms.css" rel="stylesheet"/>
  	

	<script type="text/javascript">
	$(function() {
			
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
		$("#accordion").accordion({
			icons: icons,
			autoHeight: false,
			navigation: true
		});
		$("#toggle").button().toggle(function() {
			$("#accordion").accordion("option", "icons", false);
		}, function() {
			$("#accordion").accordion("option", "icons", icons);
		});
		$("#accordion").tabs("#accordion div.pane", {tabs: 'h2', effect: 'slide', initialIndex: null});
		
		
		
	});
	</script>
    
</head>
<div class="bodytext">
<body>

<div class="demo">

<div align="left"><h2>   <img src="photos/<?php echo $row_memberdeatils['photo']; ?>" alt="<?php echo $row_memberdeatils['photo']; ?>" name="picholder" width="20%" height="20%" id="picholder" /> <?php echo $row_memberdeatils['firstname']; ?> <?php echo $row_memberdeatils['middlename']; ?> <?php echo  $row_memberdeatils['lastname']?> <?php
		$leave=$row_personleaves1['leavetype'];
		$endleave = $row_personleaves1['enddate']; 
		$todays_date = date("Y-m-d"); 
		$today = strtotime($todays_date); 
		$endleave_date = strtotime($endleave);?><font color="#FF0000" size="+2"><?php 
		if ($endleave_date >= $today) { echo " is on ".$leave." upto  ". $endleave ; } ?></font></h2></div>
<div id="accordion">

	<h3><a href="#">MEMBER PERSONAL INFORMATION</a></h3>
	<div class="pane">
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
        
        <td width="21%" bgcolor="#CCCCCC"><div align="left">DATE OF BIRTH </div></td>
        <td width="35%"><div align="left"><?php echo $row_memberdeatils['dateofbirth']; ?></div></td>
    </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>DEPARTMENT</strong></div></th>
        <td><div align="left"><?php echo $row_memberdeatils['department_name']; ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left">CHURCH ATTENDANCE</div></td>
        <td><div align="left"><?php echo $row_memberdeatils['churh_attendance']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>CELL GROUP</strong></div></th>
        <td><div align="left"><?php echo $row_memberdeatils['locationname']; ?></div></td>
        <td width="21%" bgcolor="#CCCCCC"><div align="left">ID NUMBER</div></td>
        <td width="35%"><div align="left"><?php echo $row_memberdeatils['identificationnumber']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>GENDER</strong></div></th>
        <td><div align="left"><?php echo $row_memberdeatils['gendername']; ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left">CHURCH </div></td>
        <td><div align="left"><?php echo $row_memberdeatils['church_name']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>DEPARTMENT</strong></div></th>
        <td><div align="left"><?php echo $row_memberdeatils['department']; ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left">MARITAL STATUS</div></td>
        <td><div align="left"><?php echo $row_memberdeatils['statusname']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>LANGUAGES SPOKEN</strong></div></th>
        <td><div align="left"><?php echo $row_memberdeatils['languages_spoken']; ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left">MEMBER NUMBER</div></td>
        <td><div align="left"><?php echo $row_memberdeatils['member_no']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>PREVIOUS CHURCH</strong></div></th>
        <td><div align="left"><?php echo $row_memberdeatils['previous_church']; ?> </div></td>
        <td bgcolor="#CCCCCC"><div align="left">LEADER NAME</div></td>
        <td><div align="left"><?php echo $row_memberdeatils['leader_name']; ?></div></td>
      </tr>
     
    </table>  </th>
  </tr>
 
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  
</table>

        
	</div>
	
<h3><a href="#">CONTACT DETAILS </a></h3>
	<div class="pane">
        <table width="100%" border="0" class="content">
 
  <tr>
    <td align="left" valign="top" class="tableheader">CONTACT DETAILS</td></tr> <tr><td>
      <?php if($totalRows_memberdeatils>0) { ?><table border="0" align="left" width="100%" class="listcontent">
        <tr class="tableheader">
        <td>No.</td>
          <td>Phone Number</td>
          <td>Email Address</td>
          <td>Alternative Contact</td>
          <td>Physical Address</td>
          <td>Postal Address</td>
         
        </tr>
              <?php $numrow=0; do { $numrow1++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow1; ?> </td>
            <td><?php echo $row_memberdeatils['phonenumber']; ?>&nbsp;</td>
            <td><?php echo $row_memberdeatils['emailaddress']; ?>&nbsp; </td>
            <td><?php echo $row_memberdeatils['alternative_contact']; ?>&nbsp; </td>
            <td><?php echo $row_memberdeatils['physical_address']; ?>&nbsp; </td>
            <td><?php echo $row_memberdeatils['postal_address']; ?>&nbsp; </td>
            
          </tr>          <?php } while ($row_memberdeatils = mysql_fetch_assoc($memberdeatils)); ?>
<tr><td>
      <?php echo $totalRows_memberdeatils ?> Records Total</td></tr>
      </table><?php } else {echo "No Contact  Details"; } ?>
       </td>
  </tr>
</table>

	</div>
    <h3><a href="#">PROFFESION</a></h3>
	<div class="pane">
		<table width="100%" border="0" align="left" class="content">
  <tr>
    <td valign="top" align="left" class="tableheader">PROFFESION</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <?php if($totalRows_memberprofession>0) { ?><table border="0" align="left" width="100%" class="listcontent">
      <tr class="tableheader">
      <td>No.</td>
        <td>Proffesion Name</td>
        
      </tr>
              <?php $numrow=0; do { $numrow2++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow2; ?> </td>
                     <td><?php echo $row_memberprofession['profession_name']; ?>&nbsp; </td>
         
        </tr><?php } while ($row_memberprofession = mysql_fetch_assoc($memberprofession)); ?>
        <tr><td>
      Total Proffesion : <?php echo $totalRows_memberprofession ?></td></tr>
    </table><?php } else { echo "No Training Details"; }  ?>
      </td>
  </tr>
</table>

</div>

    <h3><a href="#">HOBBIES & INTERESTS</a></h3>
	<div class="pane">

<table width="100%" border="0" class="content">
  <tr>
    <td valign="top" align="left" class="tableheader">HOBBIES & INTERESTS
</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <?php if($totalRows_memberhobby>0) { ?><table align="left" width="100%" class="listcontent">
      <tr class="tableheader">
      <td>No.</td>
        <td>Hobbies</td>
        <td>Interests</td>
        <td>Special Skills</td>
      </tr>
              <?php $numrow=0; do { $numrow3++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow3; ?> </td>
          <td><?php echo $row_memberhobby['hobby_name']; ?>&nbsp; </td>
          <td><?php echo $row_memberhobby['intrests']; ?>&nbsp; </td>
          <td><?php echo nl2br($row_memberhobby['special_skills']); ?>&nbsp;</td>
          </tr> 
          <?php } while ($row_memberhobby = mysql_fetch_assoc($memberhobby)); ?>
       <tr><td>
  <?php echo $totalRows_memberhobby ?> Records Total</td></tr>
    </table><?php } else { echo "No Hobby Details"; }  ?>
      </td>
  </tr>
 
</table>

</div>
    <h3><a href="#">BAPTISM DETAILS</a></h3>
	<div class="pane">

<table width="100%" border="0" class="content">
  <tr>
    <td valign="top" align="left" class="tableheader">BAPTISM DETAILS </td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <?php if($totalRows_viewbaptism>0) { ?><table border="0" align="left" class="listcontent" width="100%">
      <tr class="tableheader">
      <td>No.</td>
        <td>Baptism Date</td>
        <td>Officiating Clergy</td>
        <td>Male god Parent</td>
        <td>Female god Parent </td>
        <td>Baptism Venue</td>
        <td>Baptism Cert.NO</td>
      </tr>
              <?php $numrow=0; do { $numrow4++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow4; ?> </td>
          <td><?php echo $row_viewbaptism['date_baptised']; ?>&nbsp; </td>
          <td><?php echo $row_viewbaptism['officiating_clergy']; ?>&nbsp; </td>
          <td><?php echo $row_viewbaptism['male_god_parent']; ?>&nbsp; </td>
          <td><?php echo $row_viewbaptism['female_god_parent']; ?>&nbsp; </td>
          <td><?php echo $row_viewbaptism['baptism_venue']; ?>&nbsp; </td>
          <td><?php echo $row_viewbaptism['baptismcert_no']; ?>&nbsp; </td>
        </tr>        <?php } while ($row_viewbaptism = mysql_fetch_assoc($viewbaptism)); ?>
<tr><td>
      <?php echo $totalRows_viewbaptism ?> Records Total</td></tr>
    </table><?php } else { echo "No Baptism Details"; }  ?>
       </td>
  </tr>
  
</table>
</div>


<h3><a href="#">PRE CONFIRMATION</a></h3>
	<div class="pane">
        
        <table width="100%" border="0" class="content">
  <tr>
    <td valign="top" align="left" class="tableheader">PRE CONFIRMATION</td>
  </tr>
  <tr>
    <td valign="top" align="left"><?php if($totalRows_viewfirstconfirmation>0) { ?><table border="1" align="left" width="100%">
      <tr class="tableheader">
     <td>No.</td>
        <td>Date</td>
        <td>Officiating Clergy</td>
        <td>Male god Parent</td>
        <td>Female god Parent </td>
        <td>Venue</td>
        
      </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
          <td><?php echo $row_viewfirstconfirmation['firstconfirmation_date']; ?>&nbsp;  </td>
          <td><?php echo $row_viewfirstconfirmation['officiating_clergy']; ?>&nbsp; </td>
          <td><?php echo $row_viewfirstconfirmation['male_god_parent']; ?></td>
          <td><?php echo $row_viewfirstconfirmation['female_god_parent']; ?>&nbsp; </td>
          <td><?php echo $row_viewfirstconfirmation['preconfirmation_venue']; ?>&nbsp; </td>
          
         </tr>
        <?php } while ($row_viewfirstconfirmation = mysql_fetch_assoc($viewfirstconfirmation)); ?>
        <tr>
    <td valign="top" align="left">Total Confirmation <?php echo $totalRows_viewfirstconfirmation ?>  </td>
  </tr>
    </table><?php } else { echo "No Pre-Confirmation  Details"; }?>
      
      </td>
  </tr>
  <tr>
    <td valign="top" align="left">     
       
        
      </td>
  </tr>
</table>
 

	</div>
    
    
    
    
   <h3><a href="#">CONFIRMATION</a></h3>
	<div class="pane">
        
        <table width="100%" border="0" class="content">
  <tr>
    <td valign="top" align="left" class="tableheader">CONFIRMATION</td>
  </tr>
  <tr>
    <td valign="top" align="left"><?php if($totalRows_viewconfirmation>0) { ?><table border="1" align="left" width="100%">
      <tr class="tableheader">
     <td>No.</td>
        <td>Date</td>
        <td>Officiating Bishop</td>
        <td>Male god Parent</td>
        <td>Female god Parent </td>
        <td>Venue</td>
        <td>Cert Number</td>
        
      </tr>
              <?php $numrow=0; do { $numrow6++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow6; ?> </td>
          <td><?php echo $row_viewconfirmation['secondconfirmation_date']; ?>&nbsp;  </td>
          <td><?php echo $row_viewconfirmation['leader']; ?>&nbsp; </td>
          <td><?php echo $row_viewconfirmation['male_god_parent']; ?></td>
          <td><?php echo $row_viewconfirmation['female_god_parent']; ?>&nbsp; </td>
          <td><?php echo $row_viewconfirmation['confirmation_venue']; ?>&nbsp; </td>
            <td><?php echo $row_viewconfirmation['second_confirmationcert_no']; ?>&nbsp; </td>
         </tr>
        <?php } while ($row_viewconfirmation = mysql_fetch_assoc($viewconfirmation)); ?>
        <tr>
    <td valign="top" align="left">Total Confirmation <?php echo $totalRows_viewconfirmation ?>  </td>
  </tr>
    </table><?php } else { echo "No Confirmation  Details"; }?>
      
      </td>
  </tr>
  <tr>
    <td valign="top" align="left">     
       
        
      </td>
  </tr>
</table>
 

	</div> 
    

<h3><a href="#">MARRIAGE</a></h3>
	<div class="pane">
        
        <table width="100%" border="0" class="content">
  <tr>
    <td valign="top" align="left" class="tableheader">MARRIAGE  <?php echo $row_memberdeatils['firstname']; ?> <?php echo $row_memberdeatils['middlename']; ?> <?php echo $row_memberdeatils['lastname']; ?></td>
  </tr>
  <tr>
    <td valign="top" align="left"><?php if($totalRows_viewmarriage>0) { ?><table border="1" align="left" width="100%">
        <tr class="tableheader">
     <td>No.</td>
        <td>Date</td>
        <td>Spouse Name</td>
        <td>Marriage Type</td>
        <td>Officiating Clergy </td>
        <td>Solemnization Venue</td>  
        <td>Marriage Cert No</td>
        
        
      </tr>
               <?php $numrow=0; do { $numrow7++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow7; ?> </td>
          <td><?php echo $row_viewmarriage['marriage_date']; ?>&nbsp;  </td>
          <td><?php echo $row_viewmarriage['husband']; ?>&nbsp; </td>
          <td><?php echo $row_viewmarriage['marriage_type']; ?></td>
          <td><?php echo $row_viewmarriage['leader_name']; ?>&nbsp; </td>
          <td><?php echo $row_viewmarriage['solemnization_venue']; ?>&nbsp; </td>
             <td><?php echo $row_viewmarriage['marriagecert_no']; ?>&nbsp; </td>
         </tr>
        <?php } while ($row_viewmarriage = mysql_fetch_assoc($viewmarriage)); ?>
        <tr>
    <td valign="top" align="left">Total Marriage <?php echo $totalRows_viewmarriage ?>  </td>
  </tr>
    
    </table><?php } else { echo " No Marriage Results"; }?>
      
      </td>
  </tr>
  <tr>
    <td valign="top" align="left">     
       
        
       <table width="100%" border="0"  align="left" class="listcontent">
  <tr>
    <td valign="top" class="tableheader">MARRIAGE <?php echo $row_memberdeatils['firstname']; ?> <?php echo $row_memberdeatils['middlename']; ?> <?php echo $row_memberdeatils['lastname']; ?> </td>
  </tr>
  <tr>
    <td valign="top" align="left"><?php if($totalRows_viewmarriagewife>0) { ?><table border="1" align="left" width="100%">
        <tr class="tableheader">
     <td>No.</td>
        <td>Date</td>
        <td>Spouse Name</td>
        <td>Marriage Type</td>
        <td>Officiating Clergy </td>
        <td>Solemnization Venue</td>  
        <td>Marriage Cert No</td>
        
        
      </tr>
               <?php $numrow=0; do { $numrow7++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow7; ?> </td>
          <td><?php echo $row_viewmarriagewife['marriage_date']; ?>&nbsp;  </td>
          <td><?php echo $row_viewmarriagewife['wife']; ?>&nbsp;</td>
          <td><?php echo $row_viewmarriagewife['marriage_type']; ?></td>
          <td><?php echo $row_viewmarriagewife['leader_name']; ?>&nbsp; </td>
          <td><?php echo $row_viewmarriagewife['solemnization_venue']; ?>&nbsp; </td>
             <td><?php echo $row_viewmarriagewife['marriagecert_no']; ?>&nbsp; </td>
         </tr>
        <?php } while ($row_viewmarriagewife = mysql_fetch_assoc($viewmarriagewife)); ?>
        <tr>
    <td valign="top" align="left">Total Marriage <?php echo $totalRows_viewmarriagewife ?>  </td>
  </tr>
    </table><?php } else { echo "No Marriage  Details"; }?>
      
      </td>
  </tr>
  
</table>

      

</table>
</div>
    
</div> 
    </div>

</div><!-- End demo -->





</body>
</div>
</html>
<?php
@mysql_free_result($comanyinfo);

@mysql_free_result($empalldetails);

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