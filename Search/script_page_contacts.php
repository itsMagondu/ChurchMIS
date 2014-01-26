<link rel="stylesheet" type="text/css" href="style.css" />
<?php
	// You can do anything with the data. Just think of the possibilities!
	include('conn.php');

	$strlen = strlen($_GET['content']);
	$display_count = $_GET['count'];

	$select = "select ContCode,ContName,PostalAddress,ContTypeName from contacts,contacttypes where Contacts.ContName like '%".$_GET['content']."%' and contacts.ContTypeCode =contacttypes.ContTypeCode order by ContCode ";
	$res = mysql_query($select);
	$rec_count = mysql_num_rows($res);
    if($display_count)
	{
	  echo "There are <font color='red' size='3'>".$rec_count."</font> matching records found.Click Search to view result.";
	}
	else
	{
?>
    <left>   
	<table class="sofT" cellspacing="0" border="1" width="75%">
	<tr>
		<td colspan="5" class="helpHed" align="center">Search Result</td>
	</tr>
	<tr>
	   <td class='helpHed'>Contact Code</td>
	   <td class='helpHed'>Contact Name</td>	   
	   <td class='helpHed'>Postal Address</td>	   
	   <td class='helpHed'>Type</td>	   
    </tr>
<?php
	if($rec_count > 0)
	{
		while($data=mysql_fetch_array($res))
		{ 
			
			echo "<tr align = 'left' width = '50%'>
				  <td class='sup'>".$data['ContCode']."</td>
				  <td class='sup'>".$data['ContName']."</td>			
				  <td class='sup'>".$data['PostalAddress']."</td>			
				  <td class='sup'>".$data['ContTypeName']."</td>			
			     </tr>";
		}
	}
	else
		echo '<td colspan="5" align="left"><FONT SIZE="2" COLOR="red">No matching records found....!</FONT></td>';
  }
?>
</center>