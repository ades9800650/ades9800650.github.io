<?php
error_reporting(E_ERROR | E_PARSE);
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_localhost = "127.0.0.1";
$database_localhost = "web";
$username_localhost = "web";
$password_localhost = "cXwcO{2CoT";
$localhost = mysql_pconnect($hostname_localhost, $username_localhost, $password_localhost) or trigger_error(mysql_error(),E_USER_ERROR); 
?>