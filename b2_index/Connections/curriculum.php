<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_curriculum = "127.0.0.1:3306";
$database_curriculum = "nckufk";
$username_curriculum = "ufo";
$password_curriculum = "a78459032";
$curriculum = mysql_pconnect($hostname_curriculum, $username_curriculum, $password_curriculum) or trigger_error(mysql_error(),E_USER_ERROR); 
?>