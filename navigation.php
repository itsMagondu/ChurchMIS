<?php 
require_once('Connections/church.php');
require_once('functions.php'); 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<link href="/st_peters/tms.css" rel="stylesheet" type="text/css"/>

</head>

<body>
<table width="100%" border="0" cellspacing="5" cellpadding="2" class="navigation">
  <tr>
  
    <?php 
	  if (!isset($_SESSION['msmname']) && !isset($_SESSION['stpetersadminname'])) {?>
        
     <td><a href="index.php?login=true"><img src="images/key.png" alt="" name="departments" width="24" height="24" align="absmiddle" />User Login</a></td>
   
       <?php }?>   

 <?php 
  if (isset($_SESSION['stpetersadminname'])  && (($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='clerk'))){ 
  ?>
  
  
  
  <td><a  title="Registation" href="index.php?member=true"><img src="images/questionnaire.png" alt="" name="apply" width="25" height="25" align="absmiddle" />REGISTRATION</a></td>
   
      <?php }?> 
      
      
      
            <?php 
  if(isset($_SESSION['msmname']) || (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='admin'))) ){ ?>  

    <td><a title="Sacraments" href="index.php?sacraments=true"><img src="/st_peters/images/sacraments_icon.jpg" alt="" name="departments" width="20" height="20" align="absmiddle" />SACRAMENTS & OTHER MINISTRIES  </a></td>
    
    
       <?php }?>  
      
      <?php 
  if (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='treasurer') || ($_SESSION['smsadmin_level']=='admin')) ){ ?> 
  
  
      <td><a title="FINANCE" href="index.php?tithe=true"><img src="/st_peters/images/yen coins.ico" alt="" name="approvals" width="24" height="24" align="absmiddle" />FINANCE</a></td>
      
       <?php }?>  
       
 
       
       
            <?php 
  if  (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='clergy ') || ($_SESSION['smsadmin_level']=='admin')) ){ ?>  
    
              <td><a title="Parish Council" href="index.php?leader=true"><img src="/st_peters/images/leadership.jpg" alt="" name="approvals" width="24" height="24" align="absmiddle" />PARISH COUNCIL</a></td>
  
  
  
       <?php }?>  
       
       
         
       
       <?php 
  if(isset($_SESSION['msmname']) || (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='admin') || ($_SESSION['smsadmin_level']=='clergy'))) ){ ?> 
      
        <td><a href="index.php?search=true"><img src="images/search_48.png" alt="" name="search" width="24" height="24" align="absmiddle" />SEARCH</a></td>
          <?php }?>   

     
            

     
         
	 
	  <?php 
  if (isset($_SESSION['msmname']) || (isset($_SESSION['stpetersadminname']) && (($_SESSION['smsadmin_level']=='clerk') || ($_SESSION['smsadmin_level']=='secretary ') || ($_SESSION['smsadmin_level']=='admin')|| ($_SESSION['smsadmin_level']=='clergy')|| ($_SESSION['smsadmin_level']=='treasurer')))){ 
  ?> 
     <td><a href="logout.php"><img src="images/cancel_48.png" alt="" name="logout" width="24" height="24" align="absmiddle" />Logout</a></td>
     
      <?php }?> 
     
         <?php 
	  if (!isset($_SESSION['msmname']) && !isset($_SESSION['stpetersadminname'])) {?>
 <td><a href="index.php?loginadmin=true"><img src="images/lock_open_48.png" alt="" name="admin" width="24" height="24" align="absmiddle" />Admin</a></td>
     
            <?php }?> 
 
  </tr>
</table>
</body>
</html>
