<?php 
if(!isset($_SESSION))
{
session_start();
} 
require_once('Connections/church.php');
require_once('functions.php');  ?>
<?php
$errorMessage='';
if(isset($_POST['login']))
  { 		$errorMessage = '&nbsp;';
			$username = $_POST['name'];
			$password = $_POST['password'];
			
			$result = doLogin($username,$password);
	
	if ($result != '') {
		$errorMessage = $result;
	}
	
	
   }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<link href="/st_peters/tms.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellpadding="1" cellspacing="2" class="bodytext">
    <tr>
      <td colspan="2"><strong>USER LOGIN </strong></td>
    </tr>
    <tr>
      <td colspan="2">
       </td>
    <td id="changeplace" class="hiddenstuff"><?php if(isset($_SESSION['msm_logged'])){ include("forgot_password.php"); }?>
    </td>
 
       
       
       
    </tr>
    <tr>
      <td><div align="right">Login  Name:</div></td>
      <td><div align="left"><span id="sprytextfield1">
      <input name="name" type="text" id="name" value="<?php echo $_POST['name']; ?>" />
      <span class="textfieldRequiredMsg">Enter User  Name</span></span></div></td>
    </tr>
    <tr>
      <td><div align="right">Password:</div></td>
      <td><div align="left"><span id="sprytextfield2">
        <input type="password" name="password" id="password" />
        <span class="textfieldRequiredMsg">Enter your password</span></span></div></td>
    </tr>
    <tr>
      <td><div align="right"></div></td>
      <td><div align="left">
         <input type="submit" name="login" id="login" value="Login" />
         <input type="reset" name="clear" id="clear" value="Reset" />
      </div></td>
    </tr>
  </table>
</form>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur", "change"], hint:"0100"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
//-->
</script>
</body>
</html>
