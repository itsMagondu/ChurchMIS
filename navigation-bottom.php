<?php session_start();
?>

<div class="navigation">
<link href="ijet.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" cellspacing="1" cellpadding="1">

  <tr>
  
 <?php  if (isset($_SESSION['stpetersadminname'])|| (isset($_SESSION['msmname']))){?>

 
<?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='clergy') || ($_SESSION['smsadmin_level']=='admin'))) { ?>  
      
        <td><a title="Search" href="index.php?church=true"><img src="/st_peters/images/spanner_48.png" alt="" name="departments" width="24" height="24" align="absmiddle" />Church Settings</a></td>
          
  
  <?php }?>
  
   <?php 
 /* if(isset($_SESSION['msmname']) || (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='clergy'))) ){ ?> 

  <td><a href="index.php?history=show"><img src="/st_peters/images/scroll.png" width="24" height="24" align="middle">Church History</a></td>
   <?php }*/?>
 
         <?php 
 /* if(isset($_SESSION['msmname']) || (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='clergy'))) ){ ?> 
      
     <td><a title="Sermons" href="index.php?sermons=true"><img src="/st_peters/images/bible.png" alt="" name="approvals" width="24" height="24" align="absmiddle" />SERVICE PROGRAM</a></td>
     
     
         <?php } */?>  
  
              <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='clergy') || ($_SESSION['smsadmin_level']=='admin')) ){ ?>  
     
  <td><a title="Users" href="index.php?users=true"><img src="images/users_two_48.png" alt="" name="departments" width="24" height="24" align="absmiddle" />Users</a></td>
  
  
      <?php }?>  
  

 
  
  <?php }?>
  </tr>
</table>
</div>