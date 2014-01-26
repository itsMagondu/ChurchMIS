<?php ob_start()?>
<?php if(!isset($_SESSION))
{
session_start();
} 
require_once('Connections/church.php');
require_once('functions.php');


  
  ?>


<!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Information Management System</title>



<link href="/st_peters/tms.css" rel="stylesheet" type="text/css"/>
<link rel="shortcut icon" href="/st_peters/images/logo.png"/>
<link type="text/css" href="/st_peters/bootstrap.css" rel="stylesheet""/>
<link type="text/css" href="/st_peters/bootstrap.min.css"/>
<link type="text/css" href="/st_peters/bootstrap-responsive.css" rel="stylesheet"/>
<link type="text/css" href="/st_peters/bootstrap-responsive.min.css" rel="stylesheet"/>

<script type="text/javascript" src="utilities.js"></script>
</head>
<div class="mainbody">
<body><table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr valign="top">
  <tr>
    <td><?php include("header.php"); ?></td>
  </tr>
  <tr>
    <td><div class="bodytext">
    <?php 
	    if(isset($_GET['member']) || isset($_GET['memberid'])){
		include("member_details.php");
		}
		else if(isset($_GET['alldetails']) ||  isset($_GET['alldetailsid'])){
		include("alldetails.php");  
		}
		else if(isset($_GET['searchdetails']) ||  isset($_GET['searchdetailsid'])){
		include("searchdetails.php");  
		}
		else if(isset($_GET['sacraments'])){
		include("sacraments.php");  
		}
		else if(isset($_GET['education'])){
		include("education.php");  
		}
		else if(isset($_GET['sermons'])){
		include("sermons.php");  
		}
			else if(isset($_GET['tithe'])){
		include("tithe.php");  
		}
		else if(isset($_GET['details']))
	      {   
	     include_once("reportadmin.php");
	     }
		
		
		else if(isset($_GET['locality'])){
	    include("locality.php");
		}
		else if(isset($_GET['search'])){
		include("search_admin.php");}
		else if(isset($_GET['search_user'])){
		include("search_user.php");}
		
		else if(isset($_GET['church'])){
	    include("church.php");
		}
		else if(isset($_GET['membercard'])){
	    include("membercard.php");
		}
        else if(isset($_GET['leader']) ||  isset($_GET['leaderid'])){
		include("leadership.php");
		}
		else if(isset($_GET['upload_pic'])){
	    include("upload_pic.php");
		}
		else if(isset($_GET['department'])){
	    include("department.php");
		}
		
		else  if(isset($_GET['settings'])){   
	    include ("settings.php");
	     } 
		
		else if(isset($_GET['users']) || isset($_GET['user_id'])){
		include("users.php");}
		
		else if(isset($_GET['service']) || isset($_GET['serviceid'])){
		include("service_settings.php");}
		

		
		else if(isset($_GET['history'])){
		include("history.php");}
	 
	    else if(isset($_GET['logout'])){
		include("logout.php");}
		else if(isset($_GET['login'])){
		include("login.php");}
		else if(isset($_GET['loginadmin'])){
		include("loginadmin.php");}
		
		
	
		
		?>
    
    </div>
    </td>
   <td class="rightpane"><div class="content">

    </td>
  </tr>
    
  
  <tr>
    <td><?php include("footer.php"); ?></td>
  </tr>
  
     <?php 
  if (isset($_SESSION['msm_logged'])) { 
  $userid=$_SESSION['msm_logged'];
    $insertSQL2 = sprintf("INSERT INTO loggedin (user_id) VALUES (%s)",
                      
                     GetSQLValueString($userid, "int")
                    );
                     

  mysql_select_db($database_church, $church);
  $Result12 = mysql_query($insertSQL2, $church) or die(mysql_error());



 
	   } else 
	   
	   
	   
  if (isset($_SESSION['msm_logged'])) { 
  $userid=$_SESSION['msm_logged'];
  $user_level4='user';
 $insertSQL2 = sprintf("INSERT INTO loggedin (user_id,user_level) VALUES (%s,%s)",
                      
            GetSQLValueString($userid,"int"),
            GetSQLValueString($user_level4,"text")
                    );
                                

  mysql_select_db($database_church, $church);
  $Result12 = mysql_query($insertSQL2, $church) or die(mysql_error());



 
	   }else   
	   if (isset($_SESSION['smsadmin_logged'])) { 
  $userid2=$_SESSION['smsadmin_logged'];
  $user_level1=$_SESSION['smsadmin_level'];
    $insertSQL4 = sprintf("INSERT INTO loggedin (user_id,user_level) VALUES (%s,%s)",
                      
                     GetSQLValueString($userid2, "int"),
                    GetSQLValueString($user_level1, "text"));
                       
                 

  mysql_select_db($database_church, $church);
  $Result14 = mysql_query($insertSQL4, $church) or die(mysql_error());



 
	  } 
	  

   


    ?>
	   
	   
	   
	   

   



  
  
</table>
</div>
</html>
<?php ob_end_flush()?>