<?php 
 require_once('Connections/church.php');
require_once('functions.php');  


			FUNCTION createSalt() {
					$text = md5(uniqid(rand(), TRUE));
					RETURN substr($text, 0, 3);
					}

				$salt = createSalt();
				$password = hash('sha256', $salt . $hash);
?>
 <?php
$errorMessage='';
if(isset($_POST['login']))
  { 		$errorMessage = '&nbsp;';
			$username =$_POST['name'];
			$password =$_POST['password'];
			
   $result = loginAdmin($username,$password);
	if ($result != '') {
		$errorMessage = $result;
	}
	//$qry="SELECT * FROM member WHERE username='$username' AND password='$hashed'";
	
   }
ob_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="/st_peters/tms.css" rel="stylesheet" type="text/css" />

<link href="assets/css/signin.css" rel="stylesheet" type="text/css"/>
</head>

<body>



      <form class="form-signin" role="form" method="post" action="">
      
       <input name="name" type="text" id="name" value="<?php echo $_POST['name']; ?>" required="" autofocus="" placeholder="User Name">
       <input type="password" name="password" id="password" class="form-control" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="" type="submit" name="login" id="login">Sign in</button>
      </form>





</body>
</html>
<?php ob_end_flush()?>