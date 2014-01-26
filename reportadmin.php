<?php 
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


  mysql_select_db($database_church, $church);

mysql_select_db($database_church, $church);
$query_comanyinfo = "SELECT * FROM company_info";
$comanyinfo = mysql_query($query_comanyinfo, $church) or die(mysql_error());
$row_comanyinfo = mysql_fetch_assoc($comanyinfo);
$totalRows_comanyinfo = mysql_num_rows($comanyinfo);

if ((isset($_GET['detailsid'])) && ($_GET['detailsid'] != "")) {
mysql_select_db($database_church, $church);
$query_empalldetails = "SELECT * FROM employees e LEFT JOIN departments d ON e.department_id=d.department_id LEFT JOIN contacts c ON e.employee_id=c.employee_id LEFT JOIN banks b ON e.bank_id=b.bank_id LEFT JOIN bank_branches br ON e.branch_id=br.branch_id  LEFT JOIN titles t ON e.title_id=t.title_id LEFT JOIN location l ON e.location_id=l.location_id LEFT JOIN spouse s ON e.employee_id=s.employee_id LEFT JOIN employee_photo ph ON e.employee_id=ph.employee_id WHERE e.employee_id=".$_GET['detailsid']."";
$empalldetails = mysql_query($query_empalldetails, $church) or die(mysql_error());
$row_empalldetails = mysql_fetch_assoc($empalldetails);
$totalRows_empalldetails = mysql_num_rows($empalldetails);
}else if((isset($_SESSION['msm_logged']))) {
	mysql_select_db($database_church, $church);
$query_empalldetails = "SELECT * FROM employees e LEFT JOIN departments d ON e.department_id=d.department_id LEFT JOIN contacts c ON e.employee_id=c.employee_id LEFT JOIN banks b ON e.bank_id=b.bank_id LEFT JOIN bank_branches br ON e.branch_id=br.branch_id  LEFT JOIN titles t ON e.title_id=t.title_id LEFT JOIN location l ON e.location_id=l.location_id LEFT JOIN spouse s ON e.employee_id=s.employee_id LEFT JOIN employee_photo ph ON e.employee_id=ph.employee_id WHERE e.employee_id=".$_SESSION['msm_logged']."";
$empalldetails = mysql_query($query_empalldetails, $church) or die(mysql_error());
$row_empalldetails = mysql_fetch_assoc($empalldetails);
$totalRows_empalldetails = mysql_num_rows($empalldetails);
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
$query_academics = "SELECT * FROM academics  WHERE employee_id=".$_GET['detailsid']."  ORDER BY acad_from";
$academics = mysql_query($query_academics, $church) or die(mysql_error());
$row_academics = mysql_fetch_assoc($academics);
$totalRows_academics = mysql_num_rows($academics);

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
<div class="mainbody">
<body>

<div class="demo">
<div align="left"><a href="reportadminexport.php?detailsid=<?php echo $_GET['alldetailsid']; ?>">Export to Word</a></div>
<div align="left"><h2>  <img src="photos/<?php echo $row_empalldetails['photo']; ?>" alt="<?php echo $row_empalldetails['photo']; ?>" name="picholder" width="20%" height="20%" id="picholder" /> <?php echo $row_empalldetails['first_name']; ?> <?php echo $row_empalldetails['middle_name']; ?> <?php echo  $row_empalldetails['last_name']?> - <?php echo $row_empalldetails['title']; ?> - <?php
		$leave=$row_personleaves1['leavetype'];
		$endleave = $row_personleaves1['enddate']; 
		$todays_date = date("Y-m-d"); 
		$today = strtotime($todays_date); 
		$endleave_date = strtotime($endleave);?><font color="#FF0000" size="+2"><?php 
		if ($endleave_date >= $today) { echo " is on ".$leave." upto  ". $endleave ; } ?></font></h2></div>
<div id="accordion">

	<h3><a href="#">EMPLOYEE PERSONAL INFORMATION</a></h3>
	<div class="pane">
        <table width="100%" class="content">
  <tr>
    <th width="88%" scope="col">

    <table width="100%" class="listcontent">
      <tr>
        <th colspan="4" scope="row"><div align="left" class="tableheader">
          EMPLOYEES DETAILS
        </div></th>
        </tr>
      <tr>
        <th width="12%" bgcolor="#CCCCCC" scope="row"><div align="left"><strong>NAME</strong></div></th>
        <td width="32%"><div align="left"><?php echo $row_empalldetails['first_name']; ?> <?php echo $row_empalldetails['middle_name']; ?> <?php echo $row_empalldetails['last_name']; ?> </div></td>
        <td width="21%" bgcolor="#CCCCCC"><div align="left">ID NUMBER</div></td>
        <td width="35%"><div align="left"><?php echo $row_empalldetails['id_no']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>JOB NUMBER</strong></div></th>
        <td><div align="left"><?php echo $row_empalldetails['employee_no']; ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left">PIN NUMBER</div></td>
        <td><div align="left"><?php echo $row_empalldetails['pin_no']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>JOB TITLE</strong></div></th>
        <td><div align="left"><?php echo $row_empalldetails['title']; ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left">NSSF NUMBER</div></td>
        <td><div align="left"><?php echo $row_empalldetails['nssf_no']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>JOB GRADE</strong></div></th>
        <td><div align="left"><?php echo $row_grade['level']; ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left">NHIF NUMBER</div></td>
        <td><div align="left"><?php echo $row_empalldetails['nhif_no']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>DEPARTMENT</strong></div></th>
        <td><div align="left"><?php echo $row_empalldetails['department']; ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left">BANK ACCOUNT NUMBER</div></td>
        <td><div align="left"><?php echo $row_empalldetails['account_no']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>SUPERVISOR</strong></div></th>
        <td><div align="left"><?php echo $row_supervisor['first_name']; ?> <?php echo $row_supervisor['middle_name']; ?> <?php echo $row_supervisor['last_name']; ?> </div></td>
        <td bgcolor="#CCCCCC"><div align="left">BANK NAME</div></td>
        <td><div align="left"><?php echo $row_empalldetails['bank_name']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left"><strong>HIRED ON</strong></div></th>
        <td><div align="left"><?php $realdate =$row_empalldetails['hire_date']; if(($realdate !='') && ($realdate !='0000-00-00')) { echo date("l, jS F Y", strtotime($realdate));} else { echo 'No Hire Date';} ?> </div></td>
        <td bgcolor="#CCCCCC"><div align="left">BRANCH NAME</div></td>
        <td><div align="left"><?php echo $row_empalldetails['branch_name']; ?></div></td>
      </tr>
      <tr>
        <th bgcolor="#CCCCCC" scope="row"><div align="left">BASIC SALARY</div></th>
        <td><div align="left"> <?php //echo "Ksh. ".number_format($row_empalldetails['basic_pay'], 2, '.', ','); ?></div></td>
        <td bgcolor="#CCCCCC"><div align="left"></div></td>
        <td>&nbsp;</td>
      </tr>
    </table>  </th>
  </tr>
 
  <tr>
    <td><table width="100%" border="0" class="listcontent">
      <tr>
        <th colspan="9" scope="col"><div class="tableheader">
          PERSONAL INFORMATION
        </div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div>          <div align="left"></div></th>
        </tr>
      <tr class="tableheader">
      
        <td><div align="left">DOB</div></td>
        <td>BLOOD gROUP</td>
        <td><div align="left"><strong>GENDER</strong></div></td>
        <td><div align="left"><strong>MARITAL STATUS</strong></div></td>
        <td><div align="left"><strong>NATIONALITY</strong></div></td>
        <td><div align="left"><strong>PLACE OF BIRTH</strong></div></td>
        <td><div align="left"><strong>LANGUAGE SPOKE</strong>N</div></td>
        <td><div align="left">HEIGHT</div></td>
        <td><div align="left">WEIGHT</div></td>
      </tr>
      <tr>
        <td><?php $dob=$row_empalldetails['dob']; if(($dob !='0000-00-00') && ($dob !="") ) { echo date("D, jS M Y", strtotime($row_empalldetails['dob']));} else {echo 'No Date Of Birth';} ?></td>
        <td><div align="left"><?php echo $row_empalldetails['blood_group']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['gender']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['marital_status']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['nationality']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['birth_place']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['language']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['height']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['weight']; ?></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="8"><div class="tableheader">
          CONTACT DETAILS
        </div>          </td>
        </tr>
      <tr class="tableheader">
        <td><div align="left"> Physical Address</div></td>
        <td><div align="left">MOBILE NO.</div></td>
        <td><div align="left">TELEPHONE</div></td>
        <td><div align="left">EMAIL</div></td>
        <td><div align="left">TOWN</div></td>
        <td><div align="left">COUNTY</div></td>
        <td><div align="left">POSTAL CODE</div></td>
      </tr>
      <tr>
        <td><div align="left"><?php echo $row_empalldetails['address']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['mobile']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['telephone']; ?></div></td>
        <td><div align="left"><a href="mailto:<?php echo $row_empalldetails['email'];?>"><?php echo $row_empalldetails['email']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['town']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['county']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['code']; ?></div></td>
      </tr>
      <tr>
        <td colspan="8"><table width="100%"><tr><td colspan="5"><div class="tableheader">
          EMERGENCY CONTACT DETAILS
        </div>          </td>
        </tr>
      <tr class="tableheader">
      
        <td><div align="left">CONTACT PERSON</div></td>
        <td><div align="left">PHYSICAL ADDRESS</div></td>
        <td><div align="left">MOBILE NO.</div></td>
        <td><div align="left">EMAIL</div></td>
        <td><div align="left">TOWN</div></td>
      </tr>
      <tr> 
             <td><div align="left"><?php echo $row_empalldetails['em_person']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['em_address']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['em_mobile']; ?></div></td>        
        <td><div align="left"><?php echo $row_empalldetails['em_email']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['em_town']; ?></div></td>
      </tr>
      
    </table></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader">BANK ACCOUNTS DETAILS</td>
        <td>&nbsp;</td>
      </tr>
      <tr class="tableheader">
        <td><div align="left"><strong>BANK ACCOUNT NO.</strong></div></td>
        <td><div align="left"><strong>BANK</strong></div></td>
        <td><div align="left"><strong>BRANCH</strong></div></td>
        <td><div align="left"><strong>PIN NO.</strong></div></td>
        <td><div align="left"><strong>NHIF NO.</strong></div></td>
        <td><div align="left"><strong>NSSF NO.</strong></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left"><?php echo $row_empalldetails['account_no']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['bank_name']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['branch_name']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['pin_no']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['nhif_no']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['nssf_no']; ?></div></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?php if($row_empalldetails['spouse_name']!="") {?><table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="7" class="tableheader">SPOUSE DETAILS</td>
        </tr>
      <tr class="tableheader">
        <td><div align="left"><strong>SPOUSE NAME</strong></div></td>
        <td><div align="left"><strong>ID NO</strong></div></td>
        <td><div align="left"><strong>Physical Address</strong></div></td>
        <td><div align="left"><strong>MOBILE</strong></div></td>
        <td><div align="left"><strong>TELEPHONE</strong></div></td>
        <td><div align="left"><strong>DOB</strong></div></td>
        <td><div align="left"><strong>WORK PLACE</strong></div></td>
      </tr>
      <tr>
        <td><div align="left"><?php echo $row_empalldetails['spouse_name']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['sp_idno']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['sp_Address']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['sp_mobile']; ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['sp_telephone']; ?></div></td>
        <td><div align="left"><?php $spdob=$row_empalldetails['sp_dob']; if(($spdob!='') && ($spdob='0000-00-00')) { echo date("D, jS M Y", strtotime($row_empalldetails['sp_dob']));} else { echo 'No Date of Birth';} ?></div></td>
        <td><div align="left"><?php echo $row_empalldetails['work_place']; ?></div></td>
      </tr>
    </table><div class="tableheader"><?php } else {echo "No Spouse Details";}  ?></div></td>
  </tr>
  <tr>
    <td><?php if($totalRows_dependants>0) { ?><table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="4" class="tableheader">DEPENDANTS DETAILS</td>
        </tr>
            <tr class="tableheader">
            <td>No.</td>
  		<td><strong>NAME</strong></td>
        <td><strong>RELATIONSHIP</strong></td>
        <td><strong>DOB</strong></td>
        <td>&nbsp;</td>
        <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
        <td><?php echo $row_dependants['dep_names']; ?></td>
        <td><?php echo $row_dependants['dep_relationship']; ?></td>
        <td><?php $deddob=$row_dependants['dep_dob']; echo date("D, jS M Y", strtotime($row_dependants['dep_dob'])); ?></td>
        <td>&nbsp;</td>
      </tr>    <?php } while ($row_dependants = mysql_fetch_assoc($dependants)); ?>

      
    </table><?php } else { echo "No Dependants Details";  }?></td>
  </tr>
  <tr>
    <td><?php if($totalRows_nokin>0) { ?><table width="100%" border="0" class="listcontent">
      <tr>
        <td colspan="6" class="tableheader">NEXT OF KIN</td>
        </tr>
      <tr class="tableheader">
      <td>No.</td>
        <td>NAME</td>
        <td>RELATIONSHIP</td>
        <td>Physical Address</td>
        <td>MOBILE</td>
        <td>TELEPHONE</td>
        <td>&nbsp;</td>
      </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>

        <td><?php echo $row_nokin['contact_name']; ?></td>
        <td><?php echo $row_nokin['nk_relationship']; ?></td>
        <td><?php echo $row_nokin['nk_Address']; ?></td>
        <td><?php echo $row_nokin['nk_mobile']; ?></td>
        <td><?php echo $row_nokin['nk_telephone']; ?></td>
        <td>&nbsp;</td>
      </tr>
       <?php } while ($row_nokin = mysql_fetch_assoc($nokin)); ?>
      
    </table><?php } else { echo "No Next of Kin Details";} ?></td>
  </tr>
  
</table>

        
	</div>
	
	    <h3><a href="#"> <?php echo strtoupper($row_empalldetails['title']); ?> - JOB DESCRIPTION</a></h3>
	<div class="pane">
        <table width="100%" border="0" class="content">
 
  <tr>
    <td align="left" valign="top" class="tableheader"><?php echo $row_empalldetails['title']; ?>  - Job Description</td></tr> <tr><td>
     <table border="0" align="left" width="100%" class="listcontent">
        <tr>
        <td><?php if($row_empalldetails['jobdescription']!="") { ?><div align="left"><?php echo nl2p($row_empalldetails['jobdescription']); ?></div><?php } else echo "No Job Descriptions";?></td>
</tr></table></td></tr></table></div>
    
    <h3><a href="#">ACADEMICS QUALIFICATIONS & PROFILE</a></h3>
	<div class="pane">
        <table width="100%" border="0" class="content">
 
  <tr>
    <td align="left" valign="top" class="tableheader">ACADEMICS QUALIFICATIONS</td></tr> <tr><td>
      <?php if($totalRows_academics>0) { ?><table border="0" align="left" width="100%" class="listcontent">
        <tr class="tableheader">
        <td>No.</td>
          <td>From</td>
          <td>To</td>
          <td>Name of Institution</td>
          <td>Type of Study</td>
          <td>Level</td>
          <td>Performance</td>
        </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
            <td><?php $acadfrom=$row_academics['acad_from']; if(($acadfrom!='') && ($acadfrom!='0000-00-00')) { echo date("D, jS M Y", strtotime($row_academics['acad_from']));} else {'No Date';} ?>&nbsp;</td>
            <td><?php $acadto=$row_academics['acad_to']; if(($acadto!='') && ($acadto!='0000-00-00')) { echo date("D, jS M Y", strtotime($row_academics['acad_to']));} else {'No Date';} ?>&nbsp; </td>
            <td><?php echo $row_academics['institution_name']; ?>&nbsp; </td>
            <td><?php echo $row_academics['study_type']; ?>&nbsp; </td>
            <td><?php echo $row_academics['level']; ?>&nbsp; </td>
            <td><?php echo $row_academics['performance']; ?>&nbsp; </td>
          </tr>          <?php } while ($row_academics = mysql_fetch_assoc($academics)); ?>
<tr><td>
      <?php echo $totalRows_academics ?> Records Total</td></tr>
      </table><?php } else {echo "No Academic Details"; } ?>
       </td>
  </tr>
  <tr>
    <td align="left" valign="top" class="tableheader">PERSONAL PROFILE</td></tr><tr><td><?php if($totalRows_profile>0) { ?>
      <table border="0" align="left " width="100%" class="listcontent">
        <tr class="tableheader">
        <TD>No.</TD>
          <td>Strengths</td>
          <td>Development Areas</td>
          <td>Carrier Aspirations</td>
          <td>Prepared Successor1</td>
          <td>Prepared Successor2</td>
          <td>Prepared Successor3</td>
        </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
            <td> <?php echo $row_profile['strengths']; ?>&nbsp;</td>
            <td><?php echo $row_profile['dev_areas']; ?>&nbsp; </td>
            <td><?php echo $row_profile['carrier_aspirations']; ?>&nbsp; </td>
            <td><?php echo $row_profile['successor1']; ?>&nbsp; </td>
            <td><?php echo $row_profile['successor2']; ?></td>
            <td><?php echo $row_profile['successor3']; ?></td>
          </tr>
          <?php } while ($row_profile = mysql_fetch_assoc($profile)); ?>
          <tr><td>     
      <?php echo $totalRows_profile ?> Records Total 
</td></tr>
      </table><?php } else {echo "No Profile Details"; }  ?></td>
  </tr>
  
</table>

	</div>
    <h3><a href="#">TRAINING & DEVELOPMENT</a></h3>
	<div class="pane">
		<table width="100%" border="0" align="left" class="content">
  <tr>
    <td valign="top" align="left" class="tableheader">TRAINING</td>
  </tr>
  <tr>
    <td valign="top" align="left">
    <?php if($totalRows_training>0) { ?><table border="0" align="left" width="100%" class="listcontent">
      <tr class="tableheader">
      <td>No.</td>
        <td>From</td>
        <td>To</td>
        <td>Type of Training</td>
        <td>Training Conducted By</td>
        <td>Comment</td>
      </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
          <td><?php $trainfrom=$row_training['train_date_from'];if(($trainfrom!='') && ($trainfrom!='0000-00-00')) { echo date("D, jS M Y", strtotime($row_training['train_date_from']));} else {echo 'No Date';} ?>&nbsp;</td>
          <td><?php $trainto=$row_training['train_date_to'];if(($trainto!='') && ($trainto!='0000-00-00')) { echo date("D, jS M Y", strtotime($row_training['train_date_to']));} else {echo 'No Date';} ?>&nbsp; </td>
          <td><?php echo $row_training['train_type']; ?>&nbsp; </td>
          <td><?php echo $row_training['conducted_by']; ?>&nbsp; </td>
          <td><?php echo $row_training['train_comment']; ?>&nbsp; </td>
        </tr><?php } while ($row_training = mysql_fetch_assoc($training)); ?>
        <tr><td>
      Total Trainings : <?php echo $totalRows_training ?></td></tr>
    </table><?php } else { echo "No Training Details"; }  ?>
      </td>
  </tr>
</table>

</div>
<h2><a href="#">RECORD OF EMPLOYMENT</a></h2>
	<div class="pane">

<table width="100%" class="content">
  <tr>        

    <td valign="top" align="left" class="tableheader">EMPLOYMENT HISTORY</td></tr><tr><td>
       <?php if($totalRows_emphistory>0) { ?><table border="0" align="left" width="100%" class="listcontent">
        <tr class="tableheader">
        <td>No.</td>
          <td>From</td>
          <td>To</td>
          <td>Employer</td>
          <td>Position Held</td>
          <td>Major Responsibilities</td>
          <td>Reason for Termination </td>
        </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
            <td><?php $empfrom=$row_emphistory['from']; if(($empfrom!='') && ($empfrom!='0000-00-00')) {echo date("D, jS M Y", strtotime($row_emphistory['from']));} else {echo 'No Date';} ?>&nbsp; </td>
            <td><?php $empto=$row_emphistory['to']; if(($empto!='') && ($empto!='0000-00-00')) {echo date("D, jS M Y", strtotime($row_emphistory['to']));} else {echo 'No Date';} ?>&nbsp; </td>
            <td><?php echo $row_emphistory['employer']; ?>&nbsp; </td>
            <td><?php echo $row_emphistory['position_held']; ?>&nbsp; </td>
            <td><?php echo nl2br($row_emphistory['major_duties']); ?>&nbsp; </td>
            <td><?php echo $row_emphistory['end_reason']; ?>&nbsp; </td>
          </tr><?php } while ($row_emphistory = mysql_fetch_assoc($emphistory)); ?>
          <tr><td>
      <?php echo $totalRows_emphistory ?> Records Total</td></tr>
      </table><?php } else { echo "No Employment Details"; }  ?> </div>
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
    <td valign="top" align="left"><?php if($totalRows_hobbies>0) { ?>
    <table align="left" width="100%" class="listcontent">
      <tr class="tableheader">
      <td>No.</td>
        <td>Hobbies</td>
        <td>Interests</td>
        <td>Special Skills</td>
      </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
          <td><?php echo $row_hobbies['hobby_type']; ?>&nbsp; </td>
          <td><?php echo $row_hobbies['interest_type']; ?>&nbsp; </td>
          <td><?php echo nl2br($row_hobbies['special_skills']); ?>&nbsp;</td>
          </tr> 
          <?php } while ($row_hobbies = mysql_fetch_assoc($hobbies)); ?>
       <tr><td>
      <?php echo $totalRows_hobbies ?> Records Total </td></tr>
    </table><?php } { echo"No Hobbies and Interest Details"; }  ?>
      </td>
  </tr>
 
</table>

</div>
    <h3><a href="#">REFEREES</a></h3>
	<div class="pane">

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
<h3 align="left"><a href="#">EMPLOYEE PERFORMANCE HISTORY</a></h3>
	<div class="pane">	<table width="100%" border="0" class="content"><tr><td class="tableheader">PERFORMANCE</td></tr><tr><td><?php // include("../pms/historytoinfo.php"); ?></td></tr>
    </table>
</div>
<h3><a href="#">PROMOTIONS & RECOGNITIONS</a></h3>
	<div class="pane">
        
        <table width="100%" border="0" class="content">
  <tr>
    <td valign="top" align="left" class="tableheader">PROMOTIONS</td>
  </tr>
  <tr>
    <td valign="top" align="left"><?php if($totalRows_promotions>0) { ?><table border="1" align="left" width="100%">
      <tr class="tableheader">
      <td>NO.</td>
        <td>Promotion Date</td>
        <td>Employee</td>
        <td>Department</td>
        <td>Previous Position</td>
        <td>Current Position</td>
        <td>Comment</td>
      </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
          <td><?php $promdate=$row_promotions['promotion_date']; if(($promdate!='') && ($promdate!='0000-00-00')) {echo date("D, jS M Y", strtotime($row_promotions['promotion_date']));} else {echo 'No Date';} ?>&nbsp; </td>
          <td><?php echo $row_promotions['first_name']; ?> <?php echo $row_promotions['middle_name']; ?> <?php echo $row_promotions['last_name']; ?> </td>
          <td><?php echo $row_promotions['department']; ?>&nbsp; </td>
          <td><?php echo $row_promotions['previous_position']; ?>&nbsp; </td>
          <td><?php echo $row_promotions['current_position']; ?>&nbsp; </td>
          <td><?php echo $row_promotions['comment']; ?>&nbsp; </td>
        </tr>
        <?php } while ($row_promotions = mysql_fetch_assoc($promotions)); ?>
        <tr>
    <td valign="top" align="left">Total Promotions <?php echo $totalRows_promotions ?>  </td>
  </tr>
    </table><?php } else { echo "No Promotions Details"; }?>
      
      </td>
  </tr>
  <tr>
    <td valign="top" align="left">     
       
        
       <table width="100%" border="0"  align="left" class="listcontent">
  <tr>
    <td valign="top" class="tableheader">AWARDS &amp; RECOGNITIONS for <?php echo $row_awards['first_name']; ?> <?php echo $row_awards['middle_name']; ?> <?php echo $row_awards['last_name']; ?> </td>
  </tr>
  <tr>
    <td valign="top" align="left"><?php if($totalRows_awards>0) { ?><table border="1" align="left" width="100%">
      <tr class="tableheader">
      <td>No.</td>
        <td>Date Awarded</td>
        <td>Type of Award</td>
        <td>Awarded For</td>
        <td>Comment</td>
      </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
          <td><?php $awarddate=$row_awards['date_awarded']; if(($awarddate!='') && ($awarddate!='0000-00-00')) {echo date("D, jS M Y", strtotime($row_awards['date_awarded']));} else {echo 'No Date';} ?>&nbsp;</td>
          <td><?php echo $row_awards['award_type']; ?>&nbsp; </td>
          <td><?php echo $row_awards['awarded_for']; ?>&nbsp; </td>
          <td><?php echo $row_awards['award_comment']; ?>&nbsp; </td>
        </tr>  <?php } while ($row_awards = mysql_fetch_assoc($awards)); ?>
        <tr><td>Total Awards <?php echo $totalRows_awards ?> </td></tr>

    </table><?php  } else { echo "No Awards and Recognitions";}  ?>
      
      </td>
  </tr>
  
</table></td>
  </tr>
</table>
 

	</div>
    <h2><a href="#">EMPLOYEE LEAVE HISTORY</a></h2>
	<div class="pane">
    <table width="100%" border="0" class="content"><tr><td class="tableheader">LEAVE HISTORY</td></tr><tr><td>	 <?php //include("../leave/personal_report_eims.php");?>
</td></tr>
    </table>
	</div>
    <?php if (isset($_SESSION['eimsadminname'])) { ?>

    <h2><a href="#">DISCIPLINARY HISTORY</a></h2>
	<div class="pane"> 
    <table width="100%" border="0" class="listcontent">
  <tr>
    <td valign="top" align="left" class="tableheader">DISCIPLINARY HISTORY
</td>
  </tr>
  <tr>
    <td valign="top" align="left">
        <?php if($totalRows_disciplinary>0) { ?><table width="100%" border="0" class="content">
  <tr>
    <td colspan="5" class="tableheader">DISCIPLINARY HISTORY</td>
    </tr>
  <tr class="tableheader">
  <td>No.</td>
    <td><strong>DATE</strong></td>
    <td><strong>TYPE OF DISCIPLINARY</strong></td>
    <td><strong>ACTION TAKEN</strong></td>
    <td><strong>COMMENT</strong></td>
    <td>&nbsp;</td>
  </tr>
              <?php $numrow=0; do { $numrow++; ?>
          <tr <?php if ($numrow%2==0){  echo 'class = "otherodd"'; }else{echo  'class="othereven"';}?>>
                    <td><?php echo $numrow; ?> </td>
    <td><?php $dispdate = $row_disciplinary['disciplinary_date']; if(($dispdate!='') && ($dispdate!='0000-00-00')) {echo date("D, jS M Y", strtotime($row_disciplinary['disciplinary_date'])); } else { echo 'No Date';}?></td>
    <td><?php echo $row_disciplinary['disciplinary_type']; ?></td>
    <td><?php echo $row_disciplinary['disciplinary_action']; ?></td>
    <td><?php echo $row_disciplinary['comment']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <?php } while ($row_disciplinary = mysql_fetch_assoc($disciplinary)); ?>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
</table><?php } else { echo "No Disciplinary Details"; }  ?>
 </td></tr>
</table>
	</div><?php }?>
    
    <?php if (isset($_SESSION['eimsadminname'])) { ?>

    <h2><a href="#">EXIT & CLEARANCE</a></h2>
	<div class="pane">
<table width="100%"  align="left" class="content">
<tr><td class="tableheader">EXIT</td></tr>
  <tr>
    <td align="left" valign="top">
    <?php if($row_empalldetails['termination_date']!="") { ?><table width="100%" class="listcontent">
  <tr class="tableheader">
    <th scope="col">Termination Date</th>
    <th scope="col">Termination Type</th>
    <th scope="col">Reason</th>
  </tr>
  <tr>
    <td><?php echo date("D, jS M Y", strtotime($row_empalldetails['termination_date'])); ?></td>
    <td><?php echo $row_empalldetails['termination_type']; ?></td>
    <td><?php echo $row_empalldetails['termination_reason']; ?></td>
  </tr>
</table><?php } else { echo "No Termination Details"; } ?>
</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="tableheader">EXIT INTERVIEW</td>
  </tr>
 </table>
</div>

	<?php }?>
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