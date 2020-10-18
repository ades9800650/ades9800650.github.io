<?php error_reporting(E_ERROR | E_PARSE);?>
<?php session_start(); ?>
<?php 
$datey = date("Y");
$datem = date("m");
$dated = date("d");
$datel = date("l");
$datetotal=date('Y/m/d');
if ($datel == "Monday"){
	$datel = "1";
	$d="一";
	}elseif ($datel == "Tuesday"){
		$datel = "2";
		$d="二";
		}
	elseif ($datel == "Wednesday"){
		$datel = "3";
		$d="三";
		}
	elseif ($datel == "Thursday"){
		$datel = "4";
		$d="四";
		}
	elseif ($datel == "Friday"){
		$datel = "5";
		$d="五";
		}
	elseif ($datel == "Saturday"){
		$datel = "6";
		$d="六";
		}
	elseif ($datel == "Sunday"){
		$datel = "7";
		$d="日";
		};
?>
<?php require_once('Connections/localhost.php'); ?>
<?php

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE class_record SET weektime=%s, classname=%s, `level`=%s, fillinname=%s, usertotal=%s, int01=%s, int02=%s, int03=%s, int04=%s, int05=%s, course1=%s, course2=%s, course3=%s, course4=%s, course5=%s, teacher1=%s, teacher2=%s, teacher3=%s, teacher4=%s, teacher5=%s, class1=%s, class2=%s, class3=%s, class4=%s, class5=%s, record1=%s, record2=%s, record3=%s, record4=%s, record5=%s, homework1=%s, homework2=%s, homework3=%s, homework4=%s, homework5=%s, remarks1=%s, remarks2=%s, remarks3=%s, remarks4=%s, remarks5=%s, fillintime=%s WHERE `datetime`=%s",
                       GetSQLValueString($_POST['weektime'], "text"),
                       GetSQLValueString($_POST['class'], "text"),
                       GetSQLValueString($_POST['level'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['user_total'], "text"),
                       GetSQLValueString($_POST['int1'], "text"),
                       GetSQLValueString($_POST['int2'], "text"),
                       GetSQLValueString($_POST['int3'], "text"),
                       GetSQLValueString($_POST['int4'], "text"),
                       GetSQLValueString($_POST['int5'], "text"),
                       GetSQLValueString($_POST['courseName1'], "text"),
                       GetSQLValueString($_POST['courseName2'], "text"),
                       GetSQLValueString($_POST['courseName3'], "text"),
                       GetSQLValueString($_POST['courseName4'], "text"),
                       GetSQLValueString($_POST['courseName5'], "text"),
                       GetSQLValueString($_POST['teacherName1'], "text"),
                       GetSQLValueString($_POST['teacherName2'], "text"),
                       GetSQLValueString($_POST['teacherName3'], "text"),
                       GetSQLValueString($_POST['teacherName4'], "text"),
                       GetSQLValueString($_POST['teacherName5'], "text"),
                       GetSQLValueString($_POST['class1'], "text"),
                       GetSQLValueString($_POST['class2'], "text"),
                       GetSQLValueString($_POST['class3'], "text"),
                       GetSQLValueString($_POST['class4'], "text"),
                       GetSQLValueString($_POST['class5'], "text"),
                       GetSQLValueString($_POST['schedule2'], "text"),
                       GetSQLValueString($_POST['schedule2'], "text"),
                       GetSQLValueString($_POST['schedule3'], "text"),
                       GetSQLValueString($_POST['schedule4'], "text"),
                       GetSQLValueString($_POST['schedule5'], "text"),
                       GetSQLValueString($_POST['homework1'], "text"),
                       GetSQLValueString($_POST['homework2'], "text"),
                       GetSQLValueString($_POST['homework3'], "text"),
                       GetSQLValueString($_POST['homework4'], "text"),
                       GetSQLValueString($_POST['homework5'], "text"),
                       GetSQLValueString($_POST['ex1'], "text"),
                       GetSQLValueString($_POST['ex2'], "text"),
                       GetSQLValueString($_POST['ex3'], "text"),
                       GetSQLValueString($_POST['ex4'], "text"),
                       GetSQLValueString($_POST['ex'], "text"),
                       GetSQLValueString($_POST['hiddenField'], "text"),
                       GetSQLValueString($_POST['datet'], "text"));

  mysql_select_db($database_localhost, $localhost);
  $Result1 = mysql_query($updateSQL, $localhost) or die(mysql_error());

  $updateGoTo = "up.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
$agd=$row_Recordset1['class'];
$lev=$row_Recordset1['level'];
$user_ID=$row_Recordset1['user_ID'];

mysql_select_db($database_localhost, $localhost);
$query_Recordset2 = "SELECT * FROM course";
$Recordset2 = mysql_query($query_Recordset2, $localhost) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_localhost, $localhost);
$query_Recordset3 = "SELECT course.course_name, course.course_teacher FROM course WHERE course.week = $datel ORDER BY course.`Section`";
$Recordset3 = mysql_query($query_Recordset3, $localhost) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);

mysql_select_db($database_localhost, $localhost);
$query_test = "SELECT `user`.`class`, `user`.`level` FROM `user` WHERE `user`.`class`='$agd' AND `user`.`level`='$lev'";
$test = mysql_query($query_test, $localhost) or die(mysql_error());
$row_test = mysql_fetch_assoc($test);
$totalRows_test = mysql_num_rows($test);

mysql_select_db($database_localhost, $localhost);
$query_course_name = "SELECT course.course_name, course.course_teacher FROM course WHERE course.week = '$d' AND course.`class` = '$agd' AND course.`Section` = '一'";
$course_name = mysql_query($query_course_name, $localhost) or die(mysql_error());
$row_course_name = mysql_fetch_assoc($course_name);
$totalRows_course_name = mysql_num_rows($course_name);

mysql_select_db($database_localhost, $localhost);
$query_course_name2 = "SELECT course.course_name, course.course_teacher FROM course WHERE course.week = '$d' AND course.`class` = '$agd' AND course.`Section` = '二'";
$course_name2 = mysql_query($query_course_name2, $localhost) or die(mysql_error());
$row_course_name2 = mysql_fetch_assoc($course_name2);
$totalRows_course_name2 = mysql_num_rows($course_name2);

mysql_select_db($database_localhost, $localhost);
$query_course_name3 = "SELECT course.course_name, course.course_teacher FROM course WHERE course.week = '$d' AND course.`class` = '$agd' AND course.`Section` = '三'";
$course_name3 = mysql_query($query_course_name3, $localhost) or die(mysql_error());
$row_course_name3 = mysql_fetch_assoc($course_name3);
$totalRows_course_name3 = mysql_num_rows($course_name3);

mysql_select_db($database_localhost, $localhost);
$query_course_name4 = "SELECT course.course_name, course.course_teacher FROM course WHERE course.week = '$d' AND course.`class` = '$agd' AND course.`Section` = '四'";
$course_name4 = mysql_query($query_course_name4, $localhost) or die(mysql_error());
$row_course_name4 = mysql_fetch_assoc($course_name4);
$totalRows_course_name4 = mysql_num_rows($course_name4);

mysql_select_db($database_localhost, $localhost);
$query_course_name5 = "SELECT course.course_name, course.course_teacher FROM course WHERE course.week = '$d' AND course.`class` = '$agd' AND course.`Section` = '五'";
$course_name5 = mysql_query($query_course_name5, $localhost) or die(mysql_error());
$row_course_name5 = mysql_fetch_assoc($course_name5);
$totalRows_course_name5 = mysql_num_rows($course_name5);
$clas=$row_Recordset1['class'];
$leve=$row_Recordset1['level'];
mysql_select_db($database_localhost, $localhost);
$query_Recordset4 = "SELECT `user`.`class`, `user`.`level`, `user`.user_ID, `user`.user_Password, `user`.user_Name FROM `user` WHERE `user`.`class` = '$clas' AND `user`.`level`='$leve'";
$Recordset4 = mysql_query($query_Recordset4, $localhost) or die(mysql_error());
$row_Recordset4 = mysql_fetch_assoc($Recordset4);
$totalRows_Recordset4 = mysql_num_rows($Recordset4);

mysql_select_db($database_localhost, $localhost);
$query_username13 = "SELECT SUBSTR(`user`.user_ID,5), `user`.user_Name, `user`.`class`, `user`.`level` FROM `user` WHERE `user`.`class` ='$agd' AND `user`.`level`='$lev'";
$username13 = mysql_query($query_username13, $localhost) or die(mysql_error());
$row_username13 = mysql_fetch_assoc($username13);
$totalRows_username13 = mysql_num_rows($username13);

mysql_select_db($database_localhost, $localhost);
$query_username46 = "SELECT `user`.`class`, `user`.`level`, SUBSTR(`user`.user_ID,5), `user`.user_Name FROM `user` WHERE `user`.`class`= '$agd' AND `user`.`level`='$lev' AND  SUBSTR(`user`.user_ID,5)>03";
$username46 = mysql_query($query_username46, $localhost) or die(mysql_error());
$row_username46 = mysql_fetch_assoc($username46);
$totalRows_username46 = mysql_num_rows($username46);

mysql_select_db($database_localhost, $localhost);
$query_coru = "SELECT * FROM class_record";
$coru = mysql_query($query_coru, $localhost) or die(mysql_error());
$row_coru = mysql_fetch_assoc($coru);
$totalRows_coru = mysql_num_rows($coru);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-Hant-TW">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NCKU</title>
<link href =“ https://fonts.googleapis.com/css2？family = Acme＆ display = swap” rel =“ stylesheet”>
<link href="bootstrap.css" rel="stylesheet" type="text/css" />
<!--<link href="ufo.css" rel="stylesheet" type="text/css" />
--><link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
<!--google fonts-->
<link href="https://dabuttonfactory.com/button.png?t=text&f=Vollkorn-Bold&ts=40&tc=fff&hp=56&vp=26&c=19&bgt=unicolored&bgc=15d798" />
</head>
<style type="text/css">
.in_none {
	border-style: none;
	text-align: center;
	width: 65%;
	float:left;
}
.level {
	width: 30%;
	float: left;
}
.cen{
	text-align:center;
	}

.bu {
	background: #6fa8dc;
	border-radius: 11px;
	padding: 9px 18px;
	color: #ffffff;
	display: inline-block;
	font: normal bold 26px/1 "Open Sans", sans-serif;
	text-align: center;
}
.w100 {
	width: 100%;
}
.w80-mc {
	width: 80%;
	height: auto;
	margin: 0 auto;
}
.line {
	border-style: solid;
	border-width: 1px;
}
.test {
	background-color: #666;
}
a {
	text-decoration: none;
	color: #22AA36;
}
a:hover {
	text-decoration: none;
	color: #22AA36;
}
 @media (min-width: 1200px) {
.fillin-content-1 {
	width: 20%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 14px;
}
.fillin-content-2 {
	width: 50%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 16px;
}
.level {
	width: 100%;
}
.levelz {
	width: 20%;
	float:left;
}
.fillin-content-3 {
	width: 20%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 16px;
}
.textwh {
	width: 100%;
}
.teacher {
	width: 28%;
	float: left;
	font-size: 20px;
	text-align: center;
	font-family: 'Acme', sans-serif;
	padding: 1px;
}
.courseName {
	width: 48%;
	float: left;
	font-size: 20px;
	text-align: center;
	font-family: 'Acme', sans-serif;
	padding: 1px 5px;
}
.Number {
	width: 20%;
	font-size: 21px;
	text-align: center;
	float: left;
	background-color: #333;
	font-family: 'Acme', sans-serif;
	padding: 1px;
	color: #FFF;
}
.nav-head {
	width: 100%;
	height: auto;
	padding: 2px;
	text-align: center;
	color: #22AA36;
	box-shadow: 0px 0px 0px 1px #CCCCCC;
	font-family: 'Secular One', sans-serif;
}
.fillin-content {
	width: 32%;
	margin: 0 auto;
	margin-top: 2%;
	margin-right: 1%;
	height: auto;
	float: left;
	padding: 4px 0px;
	text-align: left;
	font-size: 20px;
}
.remind {
	width: 100%;
	margin: 1%;
	background: #eaea40;
	float: left;
	border-radius: 19px;
	padding: 26px 56px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.test {
	border-style: solid;
	border-width: 1px;
}
.remind-1 {
	width: 100%;
	margin: 1%;
	background: #00a8ea;
	float: left;
	border-radius: 19px;
	padding: 2px 3px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.remind-1-1 {
	width: 48%;
	margin: 1%;
	padding: 2%;
	background: #fba040;
	float: left;
	border-radius: 10px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.remind-1-2 {
	width: 48%;
	margin: 1%;
	padding: 2%;
	background: #31c546;
	float: left;
	border-radius: 10px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.inputmargin {
	width: 40%;
	margin-bottom: 1%;
}
.teacherLogin {
	background: #000000;
	border-radius: 11px;
	padding: 2px 45px;
	color: #ffffff;
	display: inline-block;
	font: normal bold 26px/1 "Open Sans", sans-serif;
	text-align: center;
	margin-bottom: 1%;
}
.studentLogin {
	background: #efc959;
	border-radius: 11px;
	padding: 20px 45px;
	color: #ffffff;
	display: inline-block;
	font: normal bold 26px/1 "Open Sans", sans-serif;
	text-align: center;
	margin-bottom: 1%;
}
.fillin-title {
	width: 80%;
	margin: 0 auto;
	margin-top: 2%;
	height: auto;
	padding: 4px 0px;
	text-align: center;
	font-size: 24px;
}
}
 @media (max-width: 767px) {
.font {
	font-size: 12px;
}.in_none {
	border-style: none;
	text-align: center;
	width: 50%;
	float:left;
}
.teacher {
	width: 30%;
	float: left;
	font-size: 14px;
	text-align: center;
	font-family: 'Acme', sans-serif;
	padding: 1px 5px;
}
.courseName {
	width: 50%;
	float: left;
	font-size: 14px;
	text-align: center;
	font-family: 'Acme', sans-serif;
	float: left;
	padding: 1px 5px;
}
.Number {
	width: 20%;
	text-align: center;
	float: left;
	background-color: #333;
	font-size: 16px;
	font-family: 'Acme', sans-serif;
	padding: 1px;
	color: #FFF;
}
.nav-head {
	width: 100%;
	height: auto;
	padding: 2px;
	text-align: center;
	color: #22AA36;
	box-shadow: 0px 0px 0px 1px #CCCCCC;
	font-family: 'Secular One', sans-serif;
}
.remind {
	width: 100%;
	margin: 1%;
	background: #eaea40;
	float: left;
	border-radius: 19px;
	padding: 26px 56px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.test {
	border-style: solid;
	border-width: 1px;
}
.fillin-title {
	width: 80%;
	margin: 0 auto;
	margin-top: 2%;
	height: auto;
	padding: 4px 0px;
	text-align: center;
	font-size: 20px;
}
.fillin-content {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 14px;
}.level {
	width: 100%;
}.levelz {
	width: 30%;
	float:left;
}
.fillin-content-1 {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 14px;
}
.fillin-content-2 {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 16px;
}
.fillin-content-3 {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 16px;
}
.textwh {
	width: 100%;
}
.remind-1 {
	width: 100%;
	margin: 1%;
	background: #00a8ea;
	float: left;
	border-radius: 19px;
	padding: 2px 3px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.remind-1-1 {
	width: 98%;
	padding: 2%;
	margin: 1%;
	background: #fba040;
	/*	float: left;
*/	border-radius: 10px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.remind-1-2 {
	width: 98%;
	margin: 1%;
	padding: 2%;
	background: #31c546;
	/*	float: left;
*/	border-radius: 10px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.inputmargin {
	width: 40%;
	margin-bottom: 1%;

}
.teacherLogin {
	background: #000000;
	border-radius: 11px;
	padding: 2px 45px;
	color: #ffffff;
	display: inline-block;
	font: normal bold 26px/1 "Open Sans", sans-serif;
	text-align: center;
	margin-bottom: 1%;
}
.studentLogin {
	background: #efc959;
	border-radius: 11px;
	padding: 20px 45px;
	color: #ffffff;
	display: inline-block;
	font: normal bold 26px/1 "Open Sans", sans-serif;
	text-align: center;
	margin-bottom: 1%;
}
}
 @media (min-width: 992px) {
	 .textwh {
	width: 100%;
}
.teacher {
	width: 30%;
	float: left;
	font-size: 20px;
	text-align: center;
	font-family: 'Acme', sans-serif;
	padding: 1px 5px;
}
.courseName {
	width: 50%;
	float: left;
	font-size: 20px;
	text-align: center;
	font-family: 'Acme', sans-serif;
	padding: 1px 5px;
}
.Number {
	width: 20%;
	float: left;
	font-size: 21px;
	text-align: center;
	background-color: #333;
	font-family: 'Acme', sans-serif;
	padding: 1px;
	color: #FFF;
}
.fillin-content {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	height: auto;
	float: left;
	padding: 4px 0px;
	text-align: left;
	font-size: 20px;
}
.fillin-content-1 {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 14px;
}
.fillin-content-2 {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 16px;
}
.fillin-content-3 {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 16px;
}
.nav-head {
	width: 100%;
	height: auto;
	padding: 2px;
	text-align: center;
	color: #22AA36;
	box-shadow: 0px 0px 0px 1px #CCCCCC;
	font-family: 'Secular One', sans-serif;
}
.remind {
	width: 100%;
	margin: 1%;
	background: #eaea40;
	float: left;
	border-radius: 19px;
	padding: 26px 56px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.test {
	border-style: solid;
	border-width: 1px;
}
.remind-1 {
	width: 100%;
	margin: 1%;
	background: #00a8ea;
	float: left;
	border-radius: 19px;
	padding: 2px 3px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.remind-1-1 {
	width: 48%;
	margin: 1%;
	padding: 2%;
	background: #fba040;
	float: left;
	border-radius: 10px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.remind-1-2 {
	width: 48%;
	margin: 1%;
	padding: 2%;
	background: #31c546;
	float: left;
	border-radius: 10px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.inputmargin {
	width: 60%;
	margin-bottom: 1%;
}
.teacherLogin {
	background: #000000;
	border-radius: 11px;
	padding: 2px 45px;
	color: #ffffff;
	display: inline-block;
	font: normal bold 26px/1 "Open Sans", sans-serif;
	text-align: center;
	margin-bottom: 1%;
}
.studentLogin {
	background: #efc959;
	border-radius: 11px;
	padding: 20px 45px;
	color: #ffffff;
	display: inline-block;
	font: normal bold 26px/1 "Open Sans", sans-serif;
	text-align: center;
	margin-bottom: 1%;
}
.fillin-title {
	width: 80%;
	margin: 0 auto;
	margin-top: 2%;
	height: auto;
	padding: 4px 0px;
	text-align: center;
	font-size: 24px;
}
}
 @media (min-width: 768px) {
	 .textwh {
	width: 100%;
}
.teacher {
	width: 30%;
	float: left;
	font-size: 20px;
	text-align: center;
	font-family: 'Acme', sans-serif;
	padding: 1px 5px;
}
.courseName {
	width: 50%;
	float: left;
	font-size: 20px;
	text-align: center;
	font-family: 'Acme', sans-serif;
	padding: 1px 5px;
}
.Number {
	width: 20%;
	float: left;
	font-size: 21px;
	text-align: center;
	background-color: #333;
	font-family: 'Acme', sans-serif;
	padding: 1px;
	color: #FFF;
}
.fillin-content {
	width: 32%;
	margin-right: 1%;
	margin: 0 auto;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 20px;
}
.fillin-content-1 {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 14px;
}
.fillin-content-2 {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 16px;
}
.fillin-content-3 {
	width: 32%;
	margin: 0 auto;
	margin-right: 1%;
	margin-top: 2%;
	float: left;
	height: auto;
	padding: 4px 0px;
	text-align: left;
	font-size: 16px;
}
.nav-head {
	width: 100%;
	height: auto;
	padding: 2px;
	text-align: center;
	color: #22AA36;
	box-shadow: 0px 0px 0px 1px #CCCCCC;
	font-family: 'Secular One', sans-serif;
}
.fillin-title {
	width: 80%;
	margin: 0 auto;
	margin-top: 2%;
	height: auto;
	padding: 4px 0px;
	text-align: center;
	font-size: 24px;
}
.remind {
	width: 100%;
	margin: 1%;
	background: #eaea40;
	float: left;
	border-radius: 19px;
	padding: 26px 56px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.test {
	border-style: solid;
	border-width: 1px;
}
.remind-1 {
	width: 100%;
	margin: 1%;
	background: #00a8ea;
	float: left;
	border-radius: 19px;
	padding: 2px 3px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.remind-1-1 {
	width: 48%;
	margin: 1%;
	padding: 2%;
	background: #fba040;
	float: left;
	border-radius: 10px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.remind-1-2 {
	width: 48%;
	margin: 1%;
	padding: 2%;
	background: #31c546;
	float: left;
	border-radius: 10px;
	color: #000;
	display: inline-block;
	font: normal bold 40px/1 "Vollkorn", serif;
	text-align: center;
}
.inputmargin {
	width: 60%;
	margin-bottom: 1%;
}
.teacherLogin {
	background: #000000;
	border-radius: 11px;
	padding: 2px 45px;
	color: #ffffff;
	display: inline-block;
	font: normal bold 26px/1 "Open Sans", sans-serif;
	text-align: center;
	margin-bottom: 1%;
}
.studentLogin {
	background: #efc959;
	border-radius: 11px;
	padding: 20px 45px;
	color: #ffffff;
	display: inline-block;
	font: normal bold 26px/1 "Open Sans", sans-serif;
	text-align: center;
	margin-bottom: 1%;
}
}
</style>
<body>
<header>
  <nav class="nav-head"> <a href="	">
    <h1>E化教室日誌</h1>
    </a> <a href="<?php echo $logoutAction ?>">
    <h3 style="text-align:right">登出</h3>
    </a> </nav>
</header>
<div class="fillin-title">
  <p><strong>國立成功大學附設高級工業職業進修學校</strong><br />
    教室日誌</p>
  <br /><form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
  <input name="datet" type="text" id="datet" style="border-style:none;width:12%;text-align:center;background-color: #FFF; display:none;" value="<?php echo $datetotal; ?>" readonly="readonly" /><?php echo $datetotal; ?>星期<?php echo $d;?>
  <input name="weektime" type="text" id="weektime" style="border-style:none;width:3.5%;text-align:center;background-color: #FFF;display:none;" value="<?php echo $d;?>"/>
</div>

  <div class="w80-mc">
    <div class="fillin-content">
      <p class="levelz">班級</p><p class="in_none"><?php echo $row_Recordset1['class']; ?></p>
      <input name="class" type="text" class="in_none" id="level" style="background-color: #FFF;display:none;" value="<?php echo $row_Recordset1['class']; ?>" readonly="readonly"/>
    </div>
    <div class="fillin-content">
      <p class="levelz">年級</p><p class="in_none"><?php echo $row_Recordset1['level']; ?></p>
      <input name="level" type="text" class="in_none" id="class" style="background-color: #FFF;display:none;" value="<?php echo $row_Recordset1['level']; ?>" readonly="readonly"/>
    </div>
    <div class="fillin-content">
      <p class="levelz">填寫</p><p class="in_none"><?php echo $row_Recordset1['user_Name']; ?></p>
      <input name="name" type="text" class="in_none" id="name" style="background-color: #FFF;display:none;" value="<?php echo $row_Recordset1['user_Name']; ?>" readonly="readonly"/>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <h3>缺席學生</h3>
    <div id="username">
    <table width="80%" border="1" align="center" cellpadding="10" bordercolor="#FFFFFF">
        
        <tr>
		<?php do { ?>
          <td valign="middle"><input name="fruit" type="checkbox" id="user_name-1-2-3" value="<?php echo $row_username13['user_Name']; ?>"/>
            <label for="user_name-1-2-3"><?php echo $row_username13['user_Name']; ?></label>
            </td>
			<?php } while ($row_username13 = mysql_fetch_assoc($username13)); ?>
        </tr>
      </table>
      </div>
    <p>&nbsp;    </p>
    
    <p style="text-align:right;">
      <input type="button" value="完成" onclick="check(this.form)" >
    </p>
    
    <p style="display:none;">
      <label for="user_total"></label>
      <input type="text" name="user_total" id="user_total"/>
    </p>
  </div>
  <script language="Javascript">
    function check(formObj) {
      var obj=formObj.fruit;
      var selected=[];
      for (var i=0; i<obj.length; i++) {
        if (obj[i].checked) {
          selected.push(obj[i].value);
          }
        }
		document.getElementById("user_total").value=selected.join();
      }
  </script>
  <div class="w80-mc">
  <div class="Number">
    <p>第 1
      <input name="int1" type="text" id="int1" style="width:30px;color:#FFF;background-color:#333;text-align:center;border-style:none;display:none;" value="1" readonly="readonly"/>
      節</p>
  </div>
  <div class="courseName" id="courseName1">
    <p class="level">課程名稱: <?php echo $row_coru['course1']; ?></p>
    <input name="courseName1" id="courseName1" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name['course_name']; ?>"/>
  </div>
  <div class="teacher">
    <p class="level">任課老師:<?php echo $row_coru['teacher1']; ?></p>
    <input name="teacherName1" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name['course_teacher']; ?>"/>
  </div>
  <div class="w100">
    <div>
      <p>&nbsp;</p>
    </div>
    <div class="fillin-content-1">
      <p>請選擇教學類別 <font color="#FF0000">*</font></p>
      <select name="class1" id="progressClass1" required>
        <option selected="selected" value="" <?php if (!(strcmp("", $row_url['class1']))) {echo "selected=\"selected\"";} ?>>教學進度</option>
        <option value="" <?php if (!(strcmp("", $row_url['class1']))) {echo "selected=\"selected\"";} ?>>班會</option>
        <option value="" <?php if (!(strcmp("", $row_url['class1']))) {echo "selected=\"selected\"";} ?>>週會</option>
        <option value="" <?php if (!(strcmp("", $row_url['class1']))) {echo "selected=\"selected\"";} ?>>代課</option>
        <option value="" <?php if (!(strcmp("", $row_url['class1']))) {echo "selected=\"selected\"";} ?>>調課</option>
        <option value="" <?php if (!(strcmp("", $row_url['class1']))) {echo "selected=\"selected\"";} ?>>段考</option>
        <option value="" <?php if (!(strcmp("", $row_url['class1']))) {echo "selected=\"selected\"";} ?>>自修</option>
        <option value="" <?php if (!(strcmp("", $row_url['class1']))) {echo "selected=\"selected\"";} ?>>隨堂測驗</option>
      </select>
    </div>
    <div class="fillin-content-2">
      <p>請填寫教學進度 <font color="#FF0000">*</font></p>
      <textarea name="schedule1" required="required" class="textwh" id="schedule1"><?php echo $row_coru['record1']; ?></textarea>
    </div>
    <div class="fillin-content-3">
      <p>指定作業</p>
      <textarea name="homework1" class="textwh" id="homework"><?php echo $row_coru['homework1']; ?></textarea>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div class="w100">
      <p>備註:</p>
      <textarea name="ex1" style="width:100%;" id="ex1"><?php echo $row_coru['remarks1']; ?></textarea>
    </div>
  </div>
  <div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button1(1)">
  </div>
  <div class="Number">
    <p>第 2
      <input name="int2" type="text" id="int2" style="width:30px;color:#FFF;background-color:#333;text-align:center;border-style:none;display:none;" value="2" readonly="readonly" />
      節</p>
  </div>
  <div class="courseName">
    <p class="level">課程名稱：<?php echo $row_coru['course2']; ?></p>
    <input name="courseName2" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name2['course_name']; ?>"/>
  </div>
  <div class="teacher">
    <p class="level">任課老師:<?php echo $row_coru['teacher2']; ?></p>
    <input name="teacherName2" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name2['course_teacher']; ?>"/>
  </div>
  <div class="w100">
  <div>
    <p>&nbsp;</p>
  </div>
  <div class="fillin-content-1">
    <p>請選擇教學類別 <font color="#FF0000">*</font></p>
    <select name="class2" id="progressClass2" required>
      <option selected="selected" value="" <?php if (!(strcmp("", $row_coru['class2']))) {echo "selected=\"selected\"";} ?>>教學進度</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class2']))) {echo "selected=\"selected\"";} ?>>班會</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class2']))) {echo "selected=\"selected\"";} ?>>週會</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class2']))) {echo "selected=\"selected\"";} ?>>代課</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class2']))) {echo "selected=\"selected\"";} ?>>調課</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class2']))) {echo "selected=\"selected\"";} ?>>段考</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class2']))) {echo "selected=\"selected\"";} ?>>自修</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class2']))) {echo "selected=\"selected\"";} ?>>隨堂測驗</option>
    </select>
  </div>
  <div class="fillin-content-2">
    <p>請填寫教學進度 <font color="#FF0000">*</font></p>
    <textarea name="schedule2" id="schedule22" class="textwh" required><?php echo $row_coru['record2']; ?></textarea>
  </div>
  <div class="fillin-content-3">
    <p>指定作業</p>
    <textarea name="homework2" class="textwh" id="homework222"><?php echo $row_coru['homework2']; ?></textarea>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div class="w100">
    <p>備註:</p>
    <textarea name="ex2" style="width:100%;" id="ex2"><?php echo $row_coru['remarks2']; ?></textarea>
  </div>
  <div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button2(1)">
  </div>
  <div class="Number">
    <p>第 3
      <input name="int3" type="text" id="int3" style="width:30px;color:#FFF;background-color:#333;text-align:center;border-style:none;display:none;" value="3" readonly="readonly" />
      節</p>
  </div>
  <div class="courseName">
    <p class="level">課程名稱:<?php echo $row_coru['course3']; ?></p>
    <input name="courseName3" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name3['course_name']; ?>"/>
  </div>
  <div class="teacher">
    <p class="level">任課老師:<?php echo $row_coru['teacher3']; ?></p>
    <input name="teacherName3" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name3['course_teacher']; ?>"/>
  </div>
  <div class="w100">
  <div>
    <p>&nbsp;</p>
  </div>
  <div class="fillin-content-1">
    <p>請選擇教學類別 <font color="#FF0000">*</font></p>
    <select name="class3" id="progressClass3" required>
      <option selected="selected" value="" <?php if (!(strcmp("", $row_coru['class3']))) {echo "selected=\"selected\"";} ?>>教學進度</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class3']))) {echo "selected=\"selected\"";} ?>>班會</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class3']))) {echo "selected=\"selected\"";} ?>>週會</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class3']))) {echo "selected=\"selected\"";} ?>>代課</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class3']))) {echo "selected=\"selected\"";} ?>>調課</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class3']))) {echo "selected=\"selected\"";} ?>>段考</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class3']))) {echo "selected=\"selected\"";} ?>>自修</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class3']))) {echo "selected=\"selected\"";} ?>>隨堂測驗</option>
    </select>
  </div>
  <div class="fillin-content-2">
    <p>請填寫教學進度 <font color="#FF0000">*</font></p>
    <textarea name="schedule3" id="schedule3" class="textwh" required><?php echo $row_coru['record3']; ?></textarea>
  </div>
  <div class="fillin-content-3">
    <p>指定作業</p>
    <textarea name="homework3" class="textwh" id="homework3"><?php echo $row_coru['homework3']; ?></textarea>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div class="w100">
    <p>備註:</p>
    <textarea name="ex3" style="width:100%;" id="ex3"><?php echo $row_coru['remarks3']; ?></textarea>
  </div>
  <div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button3(1)">
  </div>
  <div class="Number">
    <p>第 4
      <input name="int4" type="text" id="int4" style="width:30px;color:#FFF;background-color:#333;text-align:center;border-style:none;display:none;" value="4" readonly="readonly" />
      節</p>
  </div>
  <div class="courseName">
    <p class="level">課程名稱:<?php echo $row_coru['course4']; ?></p>
    <input name="courseName4" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name4['course_name']; ?>"/>
  </div>
  <div class="teacher">
    <p class="level">任課老師:<?php echo $row_coru['teacher4']; ?></p>
    <input name="teacherName4" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name4['course_teacher']; ?>"/>
  </div>
  <div class="w100">
  <div>
    <p>&nbsp;</p>
  </div>
  <div class="fillin-content-1">
    <p>請選擇教學類別 <font color="#FF0000">*</font></p>
    <select name="class4" id="progressClass4" required>
      <option selected="selected" value="" <?php if (!(strcmp("", $row_coru['class4']))) {echo "selected=\"selected\"";} ?>>教學進度</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class4']))) {echo "selected=\"selected\"";} ?>>班會</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class4']))) {echo "selected=\"selected\"";} ?>>週會</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class4']))) {echo "selected=\"selected\"";} ?>>代課</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class4']))) {echo "selected=\"selected\"";} ?>>調課</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class4']))) {echo "selected=\"selected\"";} ?>>段考</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class4']))) {echo "selected=\"selected\"";} ?>>自修</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class4']))) {echo "selected=\"selected\"";} ?>>隨堂測驗</option>
    </select>
  </div>
  <div class="fillin-content-2">
    <p>請填寫教學進度 <font color="#FF0000">*</font></p>
    <textarea name="schedule4" id="schedule4" class="textwh" required><?php echo $row_coru['record4']; ?></textarea>
  </div>
  <div class="fillin-content-3">
    <p>指定作業</p>
    <textarea name="homework4" class="textwh" id="homework4"><?php echo $row_coru['homework4']; ?></textarea>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div class="w100">
    <p>備註:</p>
    <textarea name="ex4" style="width:100%;" id="ex4"><?php echo $row_coru['remarks4']; ?></textarea>
  </div>
  <div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button4(1)">
  </div>
  <div class="Number">
    <p>第 5
      <input name="int5" type="text" id="int5" style="width:30px;color:#FFF;background-color:#333;text-align:center;border-style:none;display:none;" value="5" readonly="readonly" />
      節</p>
  </div>
  <div class="courseName">
    <p class="level">課程名稱:<?php echo $row_coru['course5']; ?></p>
    <input name="courseName5" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name5['course_name']; ?>"/>
  </div>
  <div class="teacher">
    <p class="level">任課老師:<?php echo $row_coru['teacher5']; ?></p>
    <input name="teacherName5" type="text" readonly="readonly" class="in_none" style="width:60%;background-color: #FFF;display:none;" value="<?php echo $row_course_name5['course_teacher']; ?>"/>
  </div>
  <div class="w100">
  <div>
    <p>&nbsp;</p>
  </div>
  <div class="fillin-content-1">
    <p>請選擇教學類別 <font color="#FF0000">*</font></p>
    <select name="class5" id="progressClass5" required>
      <option selected="selected" value="" <?php if (!(strcmp("", $row_coru['class5']))) {echo "selected=\"selected\"";} ?>>教學進度</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class5']))) {echo "selected=\"selected\"";} ?>>班會</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class5']))) {echo "selected=\"selected\"";} ?>>週會</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class5']))) {echo "selected=\"selected\"";} ?>>代課</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class5']))) {echo "selected=\"selected\"";} ?>>調課</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class5']))) {echo "selected=\"selected\"";} ?>>段考</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class5']))) {echo "selected=\"selected\"";} ?>>自修</option>
      <option value="" <?php if (!(strcmp("", $row_coru['class5']))) {echo "selected=\"selected\"";} ?>>隨堂測驗</option>
    </select>
  </div>
  <div class="fillin-content-2">
    <p>請填寫教學進度 <font color="#FF0000">*</font></p>
    <textarea name="schedule5" id="schedule5" class="textwh" required><?php echo $row_coru['record5']; ?></textarea>
  </div>
  <div class="fillin-content-3">
    <p>指定作業</p>
    <textarea name="homework5" class="textwh" id="homework5"><?php echo $row_coru['homework5']; ?></textarea>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div class="w100">
    <p>備註:</p>
    <textarea name="ex" style="width:100%;"><?php echo $row_coru['remarks5']; ?></textarea>
  </div>
  <div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button5(1)">
    <p>&nbsp;</p>
    <p>
      <input name="hiddenField2" type="hidden" id="hiddenField2" value="<?php echo $row_url['corid']; ?>" />
      <input type="hidden" name="hiddenField" id="hiddenField" value="<?php 
	echo date("Y/m/d")," 星期", $d; ?>"/>
      <input type="submit" name="button" id="button" value="教室日誌送出" />
    </p>
  </div>
  <div> </div>
  <input type="hidden" name="MM_update" value="form1" />
  </form>
<hr />
<script type="text/javascript">
function button1(x){
	if(x == '1')
		document.getElementById('progressClass1').disabled = true;
		document.getElementById('schedule1').disabled = true;
		document.getElementById('homework').disabled = true;
	};
	
	
	function button2(x){
	if(x == '1')
		document.getElementById('progressClass2').disabled = true;
		document.getElementById('schedule22').disabled = true;
		document.getElementById('homework222').disabled = true;
	};
	
	function button3(x){
	if(x == '1')
		document.getElementById('progressClass3').disabled = true;
		document.getElementById('schedule3').disabled = true;
		document.getElementById('homework3').disabled = true;
	};
	
	function button4(x){
	if(x == '1')
		document.getElementById('progressClass4').disabled = true;
		document.getElementById('schedule4').disabled = true;
		document.getElementById('homework4').disabled = true;
	};
	function button5(x){
	if(x == '1')
		document.getElementById('progressClass5').disabled = true;
		document.getElementById('schedule5').disabled = true;
		document.getElementById('homework5').disabled = true;
	};
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);

mysql_free_result($test);

mysql_free_result($course_name);

mysql_free_result($course_name2);

mysql_free_result($course_name3);

mysql_free_result($course_name4);

mysql_free_result($course_name5);

mysql_free_result($Recordset4);

mysql_free_result($username13);

mysql_free_result($username46);

mysql_free_result($coru);
?>
