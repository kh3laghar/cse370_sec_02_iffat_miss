<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_user_info = "192.168.0.107";
$database_user_info = "rent_a_car_cse370";
$username_user_info = "kh3laghar";
$password_user_info = "104607";
$user_info = mysql_pconnect($hostname_user_info, $username_user_info, $password_user_info) or trigger_error(mysql_error(),E_USER_ERROR); 
?>