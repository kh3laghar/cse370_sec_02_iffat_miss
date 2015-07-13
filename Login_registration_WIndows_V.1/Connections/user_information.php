<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_user_information = "localhost";
$database_user_information = "user_registration";
$username_user_information = "root";
$password_user_information = "104607";
$user_information = mysql_pconnect($hostname_user_information, $username_user_information, $password_user_information) or trigger_error(mysql_error(),E_USER_ERROR); 
?>