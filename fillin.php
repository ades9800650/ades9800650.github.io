<?php require_once('Connections/curriculum.php'); ?>
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

$maxRows_curriculum = 10;
$pageNum_curriculum = 0;
if (isset($_GET['pageNum_curriculum'])) {
  $pageNum_curriculum = $_GET['pageNum_curriculum'];
}
$startRow_curriculum = $pageNum_curriculum * $maxRows_curriculum;

$colname_curriculum = "-1";
if (isset($_GET['1'])) {
  $colname_curriculum = $_GET['1'];
}
mysql_select_db($database_curriculum, $curriculum);
$query_curriculum = sprintf("SELECT * FROM course WHERE `Section` >= %s", GetSQLValueString($colname_curriculum, "int"));
$query_limit_curriculum = sprintf("%s LIMIT %d, %d", $query_curriculum, $startRow_curriculum, $maxRows_curriculum);
$curriculum = mysql_query($query_limit_curriculum, $curriculum) or die(mysql_error());
$row_curriculum = mysql_fetch_assoc($curriculum);

if (isset($_GET['totalRows_curriculum'])) {
  $totalRows_curriculum = $_GET['totalRows_curriculum'];
} else {
  $all_curriculum = mysql_query($query_curriculum);
  $totalRows_curriculum = mysql_num_rows($all_curriculum);
}
$totalPages_curriculum = ceil($totalRows_curriculum/$maxRows_curriculum)-1;

mysql_select_db($database_curriculum, $curriculum);
$query_Recordset1 = "SELECT * FROM class_record";
$Recordset1 = mysql_query($query_Recordset1, $curriculum) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-Hant-TW">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NCKU</title>
<link href =“ https://fonts.googleapis.com/css2？family = Acme＆ display = swap” rel =“ stylesheet”>
<link href="bootstrap.css" rel="stylesheet" type="text/css" />
<link href="ufo.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css2?family=Secular+One&display=swap" rel="stylesheet">
<!--google fonts-->
<link href="https://dabuttonfactory.com/button.png?t=text&f=Vollkorn-Bold&ts=40&tc=fff&hp=56&vp=26&c=19&bgt=unicolored&bgc=15d798" />
</head>

<body>
<header>
  <nav class="nav-head"> <a href="#">
    <h1>E化教室日誌</h1>
    </a> </nav>
</header>
<div class="fillin-title">
  <p><strong>國立成功大學附設高級工業職業進修學校</strong><br />
    教室日誌</p>
</div>
<form id="form1">
  <div class="w80-mc">
    <div class="fillin-content">
      <p>請選擇年級: <font color="#FF0000">*</font></p>
      <select required id="level">
        <option selected="selected"></option>
        <option>一</option>
        <option>二</option>
        <option>三</option>
      </select>
    </div>
    <div class="fillin-content">
      <p>請選擇班級: <font color="#FF0000">*</font></p>
      <select required id="class" >
        <option selected="selected"></option>
        <option>資訊</option>
        <option>建築</option>
        <option>室內設計</option>
        <option>機械</option>
        <option>製圖</option>
        <option>機電</option>
        <option>電機</option>
        <option>電子</option>
      </select>
    </div>
    <p>&nbsp;</p>
    <div class="fillin-content">
      <p style="font-size:14px;">填寫人: <font color="#FF0000">*</font>
      <input style="width:50%;" type="text" readonly="readonly" value="#" id="fillinname"/></p>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>
  <div class="w80-mc">
  <div class="Number">
    <p>第<input style="width:30px;color:#FFF;background-color:#333;border-color:#333;text-align:center;" type="text" readonly="readonly" value="1" />節</p>
  </div>
  <div class="courseName">
    <p>課程名稱:</p>
  </div>
  <div class="teacher">
    <p>任課老師:</p>
  </div>
  <div class="w100">
    <div>
      <p>&nbsp;</p>
    </div>
    <div class="fillin-content-1">
      <p>請選擇教學類別 <font color="#FF0000">*</font></p>
      <select name="class1" id="progressClass1" required>
        <option selected="selected">無</option>
        <option>教學進度</option>
        <option>班會</option>
        <option>週會</option>
        <option>代課</option>
        <option>調課</option>
        <option>段考</option>
        <option>自修</option>
        <option>隨堂測驗</option>
      </select>
    </div>
    <div class="fillin-content-2">
      <p>請填寫教學進度 <font color="#FF0000">*</font></p>
      <textarea name="schedule1" id="schedule1" class="textwh" required></textarea>
    </div>
    <div class="fillin-content-3">
      <p>指定作業</p>
      <textarea name="homework1" class="textwh" id="homework"></textarea>
    </div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div style="width:50%; float:left;line-height:20px">
      <p>遲到早退</p>
      <table width="100%">
        <tr>
          <td><label>
              <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_0" />
              核取方塊</label></td>
        </tr>
        <tr>
          <td><label>
              <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_1" />
              核取方塊</label></td>
        </tr>
      </table>
    </div>
    <div style="width:50%; float:left;line-height:20px;">
      <p>缺席學生</p>
      <table width="100%">
        <tr>
          <td><label>
              <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_0" />
              核取方塊</label></td>
        </tr>
        <tr>
          <td><label>
              <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_1" />
              核取方塊</label></td>
        </tr>
      </table>
    </div>
    <div class="w100">
    <p>備註:</p>
      <textarea name="ex" style="width:100%;"></textarea>
    </div>
  </div>
<div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button1(1)">
  </div>
  <div class="Number">
    <p>第<input style="width:30px;color:#FFF;background-color:#333;border-color:#333;text-align:center;" type="text" readonly="readonly" value="2" />節</p>
  </div>
  <div class="courseName">
    <p>課程名稱:</p>
  </div>
  <div class="teacher">
    <p>任課老師:</p>
  </div>
  <div class="w100">
  <div>
    <p>&nbsp;</p>
  </div>
  <div class="fillin-content-1">
    <p>請選擇教學類別 <font color="#FF0000">*</font></p>
    <select name="class2" id="progressClass2" required>
      <option selected="selected">無</option>
      <option>教學進度</option>
      <option>班會</option>
      <option>週會</option>
      <option>代課</option>
      <option>調課</option>
      <option>段考</option>
      <option>自修</option>
      <option>隨堂測驗</option>
    </select>
  </div>
  <div class="fillin-content-2">
    <p>請填寫教學進度 <font color="#FF0000">*</font></p>
    <textarea name="schedule2" id="schedule22" class="textwh" required></textarea>
  </div>
  <div class="fillin-content-3">
    <p>指定作業</p>
    <textarea name="homework2" class="textwh" id="homework222"></textarea>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div style="width:50%; float:left;line-height:20px">
    <p>遲到早退</p>
    <table width="100%">
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_0" />
            核取方塊</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_1" />
            核取方塊</label></td>
      </tr>
    </table>
  </div>
  <div style="width:50%; float:left;line-height:20px;">
    <p>缺席學生</p>
    <table width="100%">
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_0" />
            核取方塊</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_1" />
            核取方塊</label></td>
      </tr>
    </table>
  </div>
  <div class="w100">
    <p>備註:</p>
      <textarea name="ex" style="width:100%;"></textarea>
  </div>
<div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button2(1)">
  </div>
  <div class="Number">
    <p>第<input style="width:30px;color:#FFF;background-color:#333;border-color:#333;text-align:center;" type="text" readonly="readonly" value="3" />節</p>
  </div>
  <div class="courseName">
    <p>課程名稱:</p>
  </div>
  <div class="teacher">
    <p>任課老師:</p>
  </div>
  <div class="w100">
  <div>
    <p>&nbsp;</p>
  </div>
  <div class="fillin-content-1">
    <p>請選擇教學類別 <font color="#FF0000">*</font></p>
    <select name="class3" id="progressClass3" required>
      <option selected="selected">無</option>
      <option>教學進度</option>
      <option>班會</option>
      <option>週會</option>
      <option>代課</option>
      <option>調課</option>
      <option>段考</option>
      <option>自修</option>
      <option>隨堂測驗</option>
    </select>
  </div>
  <div class="fillin-content-2">
    <p>請填寫教學進度 <font color="#FF0000">*</font></p>
    <textarea name="schedule3" id="schedule3" class="textwh" required></textarea>
  </div>
  <div class="fillin-content-3">
    <p>指定作業</p>
    <textarea name="homework3" class="textwh" id="homework3"></textarea>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div style="width:50%; float:left;line-height:20px">
    <p>遲到早退</p>
    <table width="100%">
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_0" />
            核取方塊</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_1" />
            核取方塊</label></td>
      </tr>
    </table>
  </div>
  <div style="width:50%; float:left;line-height:20px;">
    <p>缺席學生</p>
    <table width="100%">
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_0" />
            核取方塊</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_1" />
            核取方塊</label></td>
      </tr>
    </table>
  </div>
  <div class="w100">
    <p>備註:</p>
      <textarea name="ex" style="width:100%;"></textarea>
  </div>
  <div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button3(1)">
  </div>
  <div class="Number">
    <p>第<input style="width:30px;color:#FFF;background-color:#333;border-color:#333;text-align:center;" type="text" readonly="readonly" value="4" />節</p>
  </div>
  <div class="courseName">
    <p>課程名稱:</p>
  </div>
  <div class="teacher">
    <p>任課老師:</p>
  </div>
  <div class="w100">
  <div>
    <p>&nbsp;</p>
  </div>
  <div class="fillin-content-1">
    <p>請選擇教學類別 <font color="#FF0000">*</font></p>
    <select name="class4" id="progressClass4" required>
      <option selected="selected">無</option>
      <option>教學進度</option>
      <option>班會</option>
      <option>週會</option>
      <option>代課</option>
      <option>調課</option>
      <option>段考</option>
      <option>自修</option>
      <option>隨堂測驗</option>
    </select>
  </div>
  <div class="fillin-content-2">
    <p>請填寫教學進度 <font color="#FF0000">*</font></p>
    <textarea name="schedule4" id="schedule4" class="textwh" required></textarea>
  </div>
  <div class="fillin-content-3">
    <p>指定作業</p>
    <textarea name="homework4" class="textwh" id="homework4"></textarea>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div style="width:50%; float:left;line-height:20px">
    <p>遲到早退</p>
    <table width="100%">
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_0" />
            核取方塊</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_1" />
            核取方塊</label></td>
      </tr>
    </table>
  </div>
  <div style="width:50%; float:left;line-height:20px;">
    <p>缺席學生</p>
    <table width="100%">
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_0" />
            核取方塊</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_1" />
            核取方塊</label></td>
      </tr>
    </table>
  </div>
  <div class="w100">
    <p>備註:</p>
      <textarea name="ex" style="width:100%;"></textarea>
  </div>
  <div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button4(1)">
  </div>
  <div class="Number">
    <p>第<input style="width:30px;color:#FFF;background-color:#333;border-color:#333;text-align:center;" type="text" readonly="readonly" value="5" />節</p>
  </div>
  <div class="courseName">
    <p>課程名稱:</p>
  </div>
  <div class="teacher">
    <p>任課老師:</p>
  </div>
  <div class="w100">
  <div>
    <p>&nbsp;</p>
  </div>
  <div class="fillin-content-1">
    <p>請選擇教學類別 <font color="#FF0000">*</font></p>
    <select name="class5" id="progressClass5" required>
      <option selected="selected">無</option>
      <option>教學進度</option>
      <option>班會</option>
      <option>週會</option>
      <option>代課</option>
      <option>調課</option>
      <option>段考</option>
      <option>自修</option>
      <option>隨堂測驗</option>
    </select>
  </div>
  <div class="fillin-content-2">
    <p>請填寫教學進度 <font color="#FF0000">*</font></p>
    <textarea name="schedule5" id="schedule5" class="textwh" required></textarea>
  </div>
  <div class="fillin-content-3">
    <p>指定作業</p>
    <textarea name="homework5" class="textwh" id="homework5"></textarea>
  </div>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <div style="width:50%; float:left;line-height:20px">
    <p>遲到早退</p>
    <table width="100%">
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_0" />
            核取方塊</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup1" value="核取方塊" id="CheckboxGroup1_1" />
            核取方塊</label></td>
      </tr>
    </table>
  </div>
  <div style="width:50%; float:left;line-height:20px;">
    <p>缺席學生</p>
    <table width="100%">
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_0" />
            核取方塊</label></td>
      </tr>
      <tr>
        <td><label>
            <input type="checkbox" name="CheckboxGroup2" value="核取方塊" id="CheckboxGroup2_1" />
            核取方塊</label></td>
      </tr>
    </table>
  </div>
  <div class="w100">
    <p>備註:</p>
      <textarea name="ex" style="width:100%;"></textarea>
    </div>
  <div style="text-align:right;margin:2%;">
    <input type="button" value='填寫完成' onclick="button5(1)"> <p>&nbsp;</p>
    <p>
      <input type="submit" name="button" id="button" value="教室日誌送出" />
    </p>
  </div>
  
  
<div>

</div>
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
mysql_free_result($curriculum);

mysql_free_result($Recordset1);
?>
