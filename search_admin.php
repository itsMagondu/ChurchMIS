<?php if(!isset($_SESSION))
{
session_start();
} 
require_once('Connections/church.php'); ?>
<?php require_once('functions.php'); ?>
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head>
<link rel="stylesheet" type="text/css" href="tms.css"/>
<title>Search Enquiry</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script type="text/javascript" src="/st_peters/Search/ajax.js"></script>

<script type="text/javascript">

     		function getbymemberid(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?memberid=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}

      function getbymember_name(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?member_names=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function getbygenderid(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?gender_name=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function getbylocalityid(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?location_name=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function getbystatusid(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?marital_status=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function getbydepartment_id(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?department_name=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function getbylevelid(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?level=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function getbyprofession_name(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?profession_name=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function getbybaptsim_date(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?baptsim_date=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function getbymarriage_date(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?marriage_date=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}
		function getbyconfirmation_date(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?confirmation_date=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}	
		
			function getbylevel_id(div_id,content_id,get_count)
		{
			subject_id = div_id;
			content = document.getElementById(content_id).value;
			http.open("GET", "church_search_admin.php?edu_level=" + escape(content)+"&count="+get_count, true);
			http.onreadystatechange = handleHttpResponse;
			http.send(null);
		}	
		
				
</script>



   
  

 <script type="text/javascript">


        $(function() { 
		
                
				
				$("#baptsim_date").datepicker({
                        inline: true,
                     	changeMonth: true,
						changeYear: true,
						showWeek: true, 
						dateFormat: 'yy-mm-dd',
						firstDay: 1,
						showOtherMonths: true,
                        altField: '#alternate',
                }); 
				$("#marriage_date").datepicker({
                        inline: true,
                     	changeMonth: true,
						changeYear: true,
						showWeek: true, 
						dateFormat: 'yy-mm-dd',
						firstDay: 1,
						showOtherMonths: true,
                        altField: '#alternate',
                }); $("#confirmation_date").datepicker({
                        inline: true,
                     	changeMonth: true,
						 beforeShow: customRange,
						changeYear: true,
						showWeek: true, 
						dateFormat: 'yy-mm-dd',
						firstDay: 1,
						showOtherMonths: true,
                        altField: '#alternate',
                }); 
        });	
		function customRange(input) { 
    return {minDate: (input.id == 'end_date' ? 
        $('#start_date').datepicker('getDate') : null), 
        maxDate: '+12m'}; 
}	
		     

    </script>


<!--<link href="Search/.css" rel="stylesheet" type="text/css"></link>	
<link href="Styles/BluePrint/Style.css" rel="stylesheet" type="text/css">-->
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

<form id="form1" name="form1" method="GET" action="<?php echo $editFormAction; ?>">
    


	
  <table width="100%" border="0" align="center">
  <th align="center" colspan="4">Search </th>
    <tr>
    <td>Member No.</td>
    <td><input name="memberid" type="text" id="memberid" onkeyup="getbymemberid('output_div','memberid','0')" size="30"></td>
   
  </tr>
  <tr>
    <td width="29%">
      Member Name:</td><td width="66%">
        <input name="member_names" type="text" id="member_names" onkeyup="getbymember_name('output_div','member_names','0')" size="30">
        </td>
  
</tr>

       <?php
	  
	  mysql_select_db($database_church, $church);
$query_gender = "SELECT * FROM gender";
$gender = mysql_query($query_gender, $church) or die(mysql_error());
$row_gender = mysql_fetch_assoc($gender);
$totalRows_gender= mysql_num_rows($gender);
	  
       ?>

  <tr>
    <td>Gender</td>
    <td>
  <select name="gender_name" id="gender_name" onchange="getbygenderid('output_div','gender_name','0')">
   
        <option value="-1">Select Gender</option>
        <?php
do {  
?>
        <option value="<?php echo $row_gender['genderid']?>"><?php echo $row_gender['gendername']?></option>
        <?php
} while ($row_gender = mysql_fetch_assoc($gender));
  $rows = mysql_num_rows($gender);
  if($rows > 0) {
      mysql_data_seek($gender, 0);
	  $row_gender = mysql_fetch_assoc($gender);
  }
?>
      </select></td>
   
  </tr>
          <?php
	  
	 mysql_select_db($database_church, $church);
$query_locality = "SELECT * FROM locality";
$locality = mysql_query($query_locality, $church) or die(mysql_error());
$row_locality = mysql_fetch_assoc($locality);
$totalRows_locality= mysql_num_rows($locality);
	  
       ?>
  
  
  <tr>
    <td>Locality (Itura)</td>
    <td>
      <select name="location_name" id="location_name" onchange="getbylocalityid('output_div','location_name','0')">>
    <option value="-1">Select Locality</option>
        <?php
do {  
?>
        <option value="<?php echo $row_locality['localityid']?>"><?php echo $row_locality['locationname']?></option>
        <?php
} while ($row_locality = mysql_fetch_assoc($locality));
  $rows = mysql_num_rows($locality);
  if($rows > 0) {
      mysql_data_seek($locality, 0);
	  $row_locality = mysql_fetch_assoc($locality);
  }
?>
      </select></td>
  
  </tr>
        <?php
	  
	  mysql_select_db($database_church, $church);
$query_status = "SELECT * FROM marital_status";
$status = mysql_query($query_status, $church) or die(mysql_error());
$row_status = mysql_fetch_assoc($status);
$totalRows_status = mysql_num_rows($status);
	  
       ?>
  <tr>
    <td>Marital Status </td>
    <td>
      <select name="marital_status" id="marital_status" onchange="getbystatusid('output_div','marital_status','0')">>
        <option value="-1">Select Marital Status</option>
        <?php
do {  
?>
        <option value="<?php echo $row_status['statusid']?>"><?php echo $row_status['statusname']?></option>
        <?php
} while ($row_status = mysql_fetch_assoc($status ));
  $rows = mysql_num_rows($status );
  if($rows > 0) {
      mysql_data_seek($status , 0);
	  $row_status = mysql_fetch_assoc($status );
  }
?>
      </select></td>
 
  </tr>
  
      <?php
	  
	  mysql_select_db($database_church, $church);
$query_departments = "SELECT * FROM departments";
$departments = mysql_query($query_departments, $church) or die(mysql_error());
$row_departments = mysql_fetch_assoc($departments);
$totalRows_departments = mysql_num_rows($departments);
	  
       ?>
  
  
  
  
<tr>
  <td>Department :</td><td><select name="department_name" id="department_name" onchange="getbydepartment_id('output_div','department','0')">
    <option value="-1">Select Department</option>
    <?php
do {  
?>
    <option value="<?php echo $row_departments['department_id']?>"><?php echo $row_departments['department_name']?></option>
    <?php
} while ($row_departments = mysql_fetch_assoc($departments));
  $rows = mysql_num_rows($departments);
  if($rows > 0) {
      mysql_data_seek($departments, 0);
	  $row_departments = mysql_fetch_assoc($departments);
  }
?>
    </select></td>
 
</tr>

      <?php
	  
	  mysql_select_db($database_church, $church);
$query_level = "SELECT * FROM level";
$level = mysql_query($query_level, $church) or die(mysql_error());
$row_level = mysql_fetch_assoc($level);
$totalRows_level = mysql_num_rows($level);
	  
       ?>



  
<tr>
  <td>Education Level</td><td>
  <select name="edu_level" id="edu_level" onchange="getbylevel_id('output_div','edu_level','0')">>
        <option value="-1">Select  Level</option>
        <?php
do {  
?>
        <option value="<?php echo $row_level['level_id']?>"><?php echo $row_level['level_name']?></option>
        <?php
} while ($row_level = mysql_fetch_assoc($level ));
  $rows = mysql_num_rows($level );
  if($rows > 0) {
      mysql_data_seek($level , 0);
	  $row_level = mysql_fetch_assoc($level );
  }
?>
      </select>
       </td>
       
</tr>

<?php mysql_select_db($database_church, $church);
$query_addprofession="SELECT * FROM profession ";
$addprofession = mysql_query($query_addprofession, $church) or die(mysql_error());
$row_addprofession = mysql_fetch_assoc($addprofession);
$totalRows_addprofession = mysql_num_rows($addprofession);?>
       <tr>
         <td>
        Profession</td><td>
          <select name="profession_name" id="profession_name" onchange="getbyprofession_name('output_div','profession_name','0')">
    <option value="-1">Select Profession</option>
    <?php
do {  
?>

       <option value="<?php echo $row_addprofession['profession_id']?>"><?php echo $row_addprofession['profession_name']?></option>
          <?php
} while ($row_addprofession = mysql_fetch_assoc($addprofession));
  $rows = mysql_num_rows($addprofession);
  if($rows > 0) {
      mysql_data_seek($addprofession, 0);
	  $row_addprofession= mysql_fetch_assoc($addprofession);
  }
?>
        </select>
       </td>
      
       </tr>
       <tr>
         <td>Baptism Date</td>
         <td>         
           <input name="baptsim_date" type="text" id="baptsim_date"  onChange="getbybaptsim_date('output_div','baptsim_date','0')" size="20"> 
          
       </tr>
       
       <tr>
         <td>Marriage Date</td>
         <td>
            <input name="marriage_date" type="text" id="marriage_date"  onChange=   "getbymarriage_date('output_div','marriage_date','0')" size="20"> 
       </tr>
       <tr>
         <td>
           Confirmation Date</td><td>
             <input name="confirmation_date" type="text" id="confirmation_date" onchange="getbyconfirmation_date('output_div','confirmation_date','0')" size="30">
             </td>
     
       </tr>   
       
       <tr>
         <td>&nbsp;</td>
         <td>
           <input type="submit" name="search" id="search" value="Search">
           </td>
       
       </tr>
  </table>
       

	  
	  <?php include('church_search_admin.php'); ?>
    </div>
    
  </div>
</div>
</div>
</div>

</form>
</body>
</html>
</body>
</html>
<?php
@mysql_free_result($departments);


@mysql_free_result($client);

@mysql_free_result($typeofwork);
?>
