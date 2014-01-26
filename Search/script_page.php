<?php require_once('../Connections/pms.php'); ?>
<link rel="stylesheet" type="text/css" href="style.css" />
<?php
	// You can do anything with the data. Just think of the possibilities!

	$strlen = strlen($_GET['content']);
	$display_count = $_GET['count'];

	$select = "select * from appraisals a INNER JOIN employees e ON a.appraisee=e.employee_id where e.first_name like '%".$_GET['content']."%' || e.middle_name like '%".$_GET['content']."%'|| e.last_name like '%".$_GET['content']."%'";
	$res = @mysql_query($select);
	$rec_count = @mysql_num_rows($res);
    if($display_count)
	{
	  echo "There are <font color='red' size='3'>".$rec_count."</font> matching records found.Click Search to view result.";
	}
	else
	{
?>
    <left>   
	<table class="sofT" cellspacing="0" border="1" width="75">
	<tr>
		<td colspan="5" class="helpHed" align="center">Search Result</td>
	</tr>
	<tr>
	   <td class='helpHed'>Date</td>
	   <td class='helpHed'>Type of Appraisal</td>
	   <td class='helpHed'>Employee</td>
       
    </tr>
<?php
	if($rec_count > 0)
	{
		while($data=mysql_fetch_array($res))
		{ 
			echo "<tr align = 'left' width = '100%'>
			
				  <td class='sup'>".$data['appraisal_date']."</td>
				   <td class='sup'>".$data['status']."</td>
				  <td class='sup'>".$data['first_name']."&nbsp;".$data['middle_name']."&nbsp;".$data['last_name']."</td>
				   <td class='sup'>".$data['first_name']."&nbsp;".$data['middle_name']."&nbsp;".$data['last_name']."</td>
				   <td><font face='tahoma' size='2'> <a href='index.php?app_id=".$data['appraisal_id']."'>View Details</a></font></td>
			     </tr>";
		}
	}
	else
		echo '<tr><td colspan="5" align="left"><FONT SIZE="2" COLOR="red">No matching records found....!</FONT></td></tr>';
  }
?>
</table>