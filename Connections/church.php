<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_church = "localhost";
$database_church = "stpeters_kirangari";
$username_church = "root";
$password_church = "bitnami";
$church = mysql_pconnect($hostname_church, $username_church, $password_church) or trigger_error(mysql_error(),E_USER_ERROR);
$dbselect=mysql_select_db ($database_church,$church) or trigger_error (mysql_error(),E_USER_ERROR);
?>