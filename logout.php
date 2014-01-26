<?php 
if(!isset($_SESSION))
{
session_start();
} 
require_once('Connections/church.php');
require_once('functions.php');  ?>

<?
doLogout();

?>


