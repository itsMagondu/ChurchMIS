<?php
include ('Connections/church.php'); 
$outputForUser ="" ;
 
 if ($_POST['EmailAddress'] != "") {
// Connect to database


       $email =$_POST['EmailAddress'];
       $email = strip_tags($email);
	   $email= eregi_replace("`", "", $email);
	   $email = mysql_real_escape_string($email);
       $sql = mysql_query("SELECT * FROM users WHERE EmailAddress='$email' AND email_activated='1'" );  
       $emailcheck = mysql_num_rows($sql);
       if ($emailcheck == 0){
       
              $outputForUser = '<font color="#FF0000">There is no account with that info<br />
                                                                                     in our records, please try again.';

   
       } else {
				 
				$emailcut = substr($email, 0, 4); // Takes first four characters from the user email address
				$randNum = rand(); 
                $tempPass = "$emailcut$randNum"; 
				$password = "$tempPass";
				@mysql_query("UPDATE users SET password='$tempPass' where EmailAddress='$email'") or die("cannot set your new password");
                $headers .= "MIME-Version: 1.0\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1 \n";
                $subject ="Login Password Generated";

                $body="<div align=center><br>----------------------------- New Login Password --------------------------------<br><br><br>
                Your New Password for our site is: <font color=\"#006600\"><u>$tempPass</u></font><br><br />
				</div>";
           //mail function 
		   
		   
		     echo   $tempPass ;
				if(mail($email,$subject,$body,$headers)) {

				$outputForUser = "<font color=\"#006600\"><strong>Your New Login password has been emailed to you.</strong></font>";
				} else {
							   
			$outputForUser = '<font color="#FF0000">Password Not Sent.<br /><br />
                 Please Contact Us...</font>';
				}
				
     }

} else {
 
   $outputForUser = 'Enter your email address into the field below.';

}
////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Forgot Password</title>
<script type="text/javascript" src="/st_peters/utilities.js"></script>

<script type="text/javascript" src="/st_peters/js/jquery-ui/js/jquery-ui-1.7.2.custom.min.js"></script>


<link type="text/css" href="/st_peters/tms.css"/>
</head>
<div align="center"><td><img src="/st_peters/images/st_peters header.png"</td></td></div>
<?php include ('header.php');?>
<body>
<table width="950" align="center"  bgcolor="#F4F4F4">

  <tr>
    <td width="758" valign="top"><br />
      <table width="600" align="center" cellpadding="4" cellspacing="4">
        <form action="forgot_pass.php" method="post" enctype="multipart/form-data" name="newpass" id="newpass">
          <tr>
            <td valign="top" style="line-height:1.5em;"><p align="left"><strong>Forgot or lost your Password? <br />
              <br />
              </strong><br />
              <br />
            </p></td>
            <td valign="top" style="line-height:1.5em;">A new login password  will be made for you.<br />
              <br />
              <br />
              <?php print "$outputForUser"; ?></td>
          </tr>
          <tr>
            <td><div align="right" class="style3">Enter your Email Address Here:</div></td>
            <td><input name="email" type="text" id="email" size="38" maxlength="56" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Get Password" /></td>
          </tr>
        </form>
      </table>
    <br /></td>
    <td width="180" valign="top"></td>
  </tr>
</table>
<?php include ('footer.php');?>
</body>
</html>
