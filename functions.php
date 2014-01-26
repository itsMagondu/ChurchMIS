<?php
session_start();
require_once('Connections/church.php');

	/*Check if a session user id exist or not. If not set redirect
	to login page. If the user session id exist and there's found
	$_GET['logout'] in the query string logout the user**/
	


function checkUser()
{

// if the session id is not set, redirect to login page

$username = isset($_POST['name']) ? $_POST['name'] : $_SESSION['msmname'];
$password = isset($_POST['password']) ? $_POST['password'] : $_SESSION['password'];
 
if (!isset($username))
	 {
		
	?>
	<script type = "text/javascript">
				<!-- user feedback						 
				var myurl="index.php?login=true"
				window.location.assign(myurl);
				//alert('Please Login first');
                // -->
                </script>
	<?
exit;
	}
	
	// the user want to logout
	if (isset($_GET['logout'])) {
		doLogout();


	}
}

function doLogin($username,$password)
{

	$errorMessage='';
	// first, make sure the username & password are not empty
	if ($username == '') {
		$errorMessage = 'You must enter your Login Name';
	} else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} else {
		// check the database and see if the username and password combo do match
		$sqlog =@mysql_query("SELECT leaderid
		        FROM leader 
		WHERE user_name = '$username' AND password= md5('$password')");
		#$result = dbQuery($sql);
	if (@mysql_num_rows($sqlog) >1) { $errorMessage='Password Conflict. Contact the System Administrator';}
		else if (@mysql_num_rows($sqlog) ==1) {
		$row = @mysql_fetch_array($sqlog);
		session_start();	
		
$_SESSION['msmname'] = $username;
$_SESSION['password'] = $password; 
$_SESSION['msm_logged']=$row['leaderid'];




		
				header('Location: index.php?index=true');
			
		} else {
			$errorMessage = 'Wrong loginName or password';
		}		
			
	}
	
	return $errorMessage;
}

function checkAdmin()
{

// if the session id is not set, redirect to login page

$admin =isset($_POST['name']) ? $_POST['name'] : $_SESSION['stpetersadminname'];
$adminpassword =isset($_POST['password']) ? $_POST['password'] : $_SESSION['adminpassword'];
 
if (!isset($admin))
	 {
		
	?>
	<script type = "text/javascript">
				<!-- user feedback						 
				var myurl="index.php?loginadmin=true"
				if(confirm('This are requires Administrative rights!\n Do you want to Login as Admin?')){
				
				window.location.assign(myurl);
				}
                // -->
                </script>
	<?
exit;
	}
	
	// the user want to logout
	if (isset($_GET['logout'])) {
		doLogout();


	}
}


function Loginadmin($username,$password)
{
   $errorMessage='';
	// first, make sure the username & password are not empty
	if ($username == '') {
		$errorMessage = 'You must enter your username';
	} else if ($password == '') {
		$errorMessage = 'You must enter the password';
	} else {
		// check the database and see if the username and password combo do match
 mysql_select_db($database_church, $church);
 
	 $sql=@mysql_query("SELECT user_id, user_level  FROM users 
				WHERE username='$username' AND password= md5('$password')");
			
		if (@mysql_num_rows($sql)>1) { $errorMessage='Password Conflict. Contact the System Administrator';}
		else if (@mysql_num_rows($sql)) {
		$row = @mysql_fetch_array($sql);
		
		session_start();	
$_SESSION['stpetersadminname'] = $username;
$_SESSION['adminpassword'] = $password;
$_SESSION['smsadmin_logged']=$row['user_id'];
$_SESSION['smsadmin_level']=$row['user_level'];	 
			
		
     header('Location: index.php?index');	
			
		} else {
			$errorMessage = 'Wrong username or password';
		}		
			
	}
	
	return $errorMessage;
}




/*
	Logout a user
*/
function doLogout()
{

  

	 if (isset($_SESSION['msmname'])) {
		unset($_SESSION['msmname']);
		//session_unregister();
	}
	
	 if (isset($_SESSION['msm_logged'])) {
		unset($_SESSION['msm_logged']

		
		);
		//session_unregister();
	}
	
	if (isset($_SESSION['stpetersadminname'])) {
		unset($_SESSION['stpetersadminname']);
		//session_unregister();
	}
	if (isset($_SESSION['adminpassword'])) {
		unset($_SESSION['adminpassword']);
		//session_unregister();
	}
	if (isset($_SESSION['password'])) {
		unset($_SESSION['password']);
		//session_unregister();
	}
	
	if (isset($_SESSION['smsadmin_logged'])) {
		unset($_SESSION['smsadmin_logged']);
		//session_unregister();
	}
	if (isset($_SESSION['smsadmin_level'])) {
		unset($_SESSION['smsadmin_level']);
		//session_unregister();
	}

	
		if (isset($_SESSION['smsname'])) {
		unset($_SESSION['smsname']);
		//session_unregister();
	}
	 if (isset($_SESSION['issubjecthead'])) {
		unset($_SESSION['issubjecthead']);
		//session_unregister();
	}
	
	?>
	<script type = "text/javascript">
				<!-- user feedback						 
				var myurl="index.php?login=true"
				window.location.assign(myurl);
				
                // -->
                </script>
	<?
	exit;
	
	

}

?>
