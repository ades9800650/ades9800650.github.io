<?php session_start(); ?>
<?php require_once('Connections/localhost.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_Recordset1 = sprintf("SELECT * FROM `user` WHERE user_ID = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $localhost) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['studentuser'])) {
  $loginUsername=$_POST['studentuser'];
  $password=$_POST['studentpassword'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "to.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_localhost, $localhost);
  
  $LoginRS__query=sprintf("SELECT user_ID, user_Password FROM `user` WHERE user_ID=%s AND user_Password=%s",
    GetSQLValueString($loginUsername, "int"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $localhost) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NCKU</title>


<link href="bootstrap.css" rel="stylesheet" type="text/css" />
<link href="ufo.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet"><!--google fonts-->
<link href="https://dabuttonfactory.com/button.png?t=text&f=Vollkorn-Bold&ts=40&tc=fff&hp=56&vp=26&c=19&bgt=unicolored&bgc=15d798" />
</head>

<body>
<nav class="nav-head">
<a href="#"><h1>E化教室日誌</h1></a>
</nav>
<div class="div-head">
	<div class="remind-1">
        	<p style="line-height:50px;">學生登入</p>
      <div>
            	<form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" id="studentLogin">
                	<p>
                	  <input name="studentuser" type="text" style="margin:1%; width:60%" placeholder="帳號"/>
                	  <br />
                	  <input name="studentpassword" type="password" style="margin:1%; width:60%" placeholder="密碼"/>
               	  </p>
                	<p>
                	  <input name="" type="submit" value="送出" class="teacherLogin" />
              	  </p>
          </form>
            </div>
    </div>
</div>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
