
<script type="text/javascript" src="/st_peters/js/jquery-ui/jquery-1.4.2_2.js"></script>

<link type="text/css" href="/st_peters/tms.css" rel="stylesheet"/>

<script type="text/javascript" src="/st_peters/utilities.js"></script>

<script type="text/javascript">
    	$(document).ready(function(){
		$('#changer').click(function(){
		$('#changeplace').toggleClass('hiddenstuff');
			});
		$('#cancel').click(function(){
		$('#changeplace').addClass('hiddenstuff');
			});
		});
    
    </script>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td> <div>
      <div align="left">
  <IMG src="images/parish_header1.png" width="100%"></div>
    </div></td>
</tr>
  <tr>
    <td><?php include("navigation.php");?></td>
  </tr> 
 <tr>
 <td>
 
<div align="left"><?php if(isset($_SESSION['msm_logged']) && !isset($_SESSION['namedisplay'])){
  mysql_select_db($database_church, $church);		
$query_naniyukohapa = "SELECT * FROM leader l LEFT JOIN member_details md ON md.leaderidrt=l.leaderid  WHERE l.leaderid=".$_SESSION['msm_logged']."";
$naniyukohapa = mysql_query($query_naniyukohapa,  $church) or die(mysql_error());
$row_naniyukohapa = mysql_fetch_assoc($naniyukohapa);
$totalRows_naniyukohapa = mysql_num_rows($naniyukohapa);

$_SESSION['namedisplay']=$row_naniyukohapa['firstname'].'&nbsp;'.$row_naniyukohapa['middlename'].'&nbsp;'.$row_naniyukohapa['lastname'];
	}else if (isset($_SESSION['msm_logged']) && isset($_SESSION['namedisplay'])){
		echo "You are Logged in as ".$_SESSION['msmname']."";echo $row_naniyukohapa['user_name'];?>
</div><div align="right"><a href="#" id="changer">Change Password?</a></div><?php }?></td>
</tr>
   <tr>
    <td id="changeplace" class="hiddenstuff"><?php
	 if(isset($_SESSION['msm_logged'])){ include("changepassword.php"); }?></td>
  </tr>
  <tr>
    <td id="notifications"><?php //if(isset($_SESSION['ginadinhrname'])){ include("notifications.php"); }
	?></td>
  </tr>
</table>
<?php
@mysql_free_result($naniyukohapa);
?>