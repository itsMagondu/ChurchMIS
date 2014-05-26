<?php 
require_once('Connections/church.php');
require_once('functions.php');

?>
<?php 

if ((isset($_GET['membercardid'])) && ($_GET['membercardid'] != "")) {
	
mysql_select_db($database_church, $church);
$query_memberdeatils = "SELECT * FROM member_details  md   
LEFT JOIN member_contacts  mc ON md.memberid=mc.memberid LEFT JOIN locality ly ON md.localityid=ly.localityid 
LEFT JOIN profession p ON md.memberid=p.memberid LEFT JOIN member_photo mp ON md.memberid=mp.memberid WHERE md.memberid=".$_GET['membercardid']."";
$memberdeatils = mysql_query($query_memberdeatils, $church) or die(mysql_error());
$row_memberdeatils = mysql_fetch_assoc($memberdeatils);
$totalRows_memberdeatils = mysql_num_rows($memberdeatils);

mysql_select_db($database_church, $church);
$query_churchname = "SELECT company_name   FROM settings  s";
$churchname = mysql_query($query_churchname, $church) or die(mysql_error());
$row_churchname = mysql_fetch_assoc($churchname);
$totalRows_churchname = mysql_num_rows($churchname);
	}
			
?>

<html lang="en">
<head>
	<meta charset="utf-8" />
	
	<link rel="stylesheet" type="text/css" href="global.css" />
	  <link type="text/css" href="tms.css" rel="stylesheet"/>

<!------bootstrap prompt----->

<script type="text/javascript" src="js/bootstrap-prompts-alert.js"></script>
</head>

<div class="bodytext">	

	<div id="content" class="clearfix">
		<section id="left">
			<div id="userStats" class="clearfix">
				<div class="header">
					<table>
						<td><?php echo $row_churchname['company_name'];?></td>
						</table>
				</div>
			
				<div>
					<table>
						<td><h3>No: <b><?php echo $row_memberdeatils['member_no'];?></b></td>
					</table>
				</div>
				
				
					<div class="pic">
					<a href="#">
					<img src="photos/<?php echo $row_memberdeatils['photo']; ?>" alt="<?php echo $row_memberdeatils['photo']; ?>" name="picholder" width="130" height="130" id="picholder" /> 
					</div>
					<div class="data" style="width: 170px;">
				
						<h2><?php echo $row_memberdeatils['firstname'] ?> &nbsp; <?php echo $row_memberdeatils['middlename'] ?> &nbsp;<?php echo $row_memberdeatils['lastname'] ?></h2>
						<h2><?php echo $row_memberdeatils['locationname'] ?></h2>
						<h2><?php echo $row_memberdeatils['profession_name'] ?></h2>
						<h2><?php echo $row_memberdeatils['dateofbirth'] ?></h2>
					
				</div>
				
				</div>
					
				</div>
					
				
				
				</div>
			
		</section>
	</div>
	
</body>
</html>
