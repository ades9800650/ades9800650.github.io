<?php require_once('Connections/localhost.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$colname_loginout = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_loginout = $_SESSION['MM_Username'];
}
mysql_select_db($database_localhost, $localhost);
$query_loginout = sprintf("SELECT * FROM `user` WHERE user_ID = %s", GetSQLValueString($colname_loginout, "int"));
$loginout = mysql_query($query_loginout, $localhost) or die(mysql_error());
$row_loginout = mysql_fetch_assoc($loginout);
$totalRows_loginout = mysql_num_rows($loginout);
$clas=$row_loginout['class'];
$leve=$row_loginout['level'];
mysql_select_db($database_localhost, $localhost);
$query_cor = "SELECT * FROM class_record WHERE class_record.classname='$clas' AND class_record.`level`='$leve'";
$cor = mysql_query($query_cor, $localhost) or die(mysql_error());
$row_cor = mysql_fetch_assoc($cor);
$totalRows_cor = mysql_num_rows($cor);
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
<style type="text/css">
body,td,th {
	font-size: 18px;
}
</style>
</head>

<body>
<nav class="nav-head">
<a href="#"><h1>E化教室日誌</h1></a>
</nav>

<div style="
width:80%;
margin:0 auto;
">
<h2 style="text-align:center;"><?php echo $row_loginout['class']; ?><?php echo $row_loginout['level']; ?>填寫紀錄</h2>
<p>&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td>日期</td>
    <td>星期</td>
    <td>填寫日期</td>
    <td>填寫人</td>
    </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_cor['datetime']; ?></td>
      <td><?php echo $row_cor['weektime']; ?></td>
      <td><?php echo $row_cor['fillintime']; ?></td>
      <td><?php echo $row_cor['fillinname']; ?></td>
      <td><a href="Update.php?colid=<?php echo $row_cor['corid']; ?>">修改</a></td>
      </tr>
    <?php } while ($row_cor = mysql_fetch_assoc($cor)); ?>
</table>

 
</div>
</body>
</html>
<?php
mysql_free_result($loginout);

mysql_free_result($cor);
?>
