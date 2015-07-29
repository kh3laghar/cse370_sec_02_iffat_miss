<?php require_once('Connections/user_info.php'); ?>
<?php require_once('Connections/user_info.php'); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO customer_datails (name, user_id, password, email_id, re_enter_email, address_user) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fullname'], "text"),
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['address'], "text"));

  mysql_select_db($database_user_info, $user_info);
  $Result1 = mysql_query($insertSQL, $user_info) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_user_info, $user_info);
$query_User_information = "SELECT * FROM customer_datails";
$User_information = mysql_query($query_User_information, $user_info) or die(mysql_error());
$row_User_information = mysql_fetch_assoc($User_information);
$totalRows_User_information = mysql_num_rows($User_information);
$query_User_information = "SELECT * FROM customer_datails";
$User_information = mysql_query($query_User_information, $user_info) or die(mysql_error());
$row_User_information = mysql_fetch_assoc($User_information);
$totalRows_User_information = mysql_num_rows($User_information);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>
<style type="text/css">
.hh {
	color: #396;
}
.purple{
	background-color:#909
}
</style>
</head>

<body>
<table width="300" border="" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="hh">
<tr>
  <form name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <td><table width="300" border="" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="hh">
    <tr>
      <td><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
        <tr>
          <td colspan="3"><strong>Member Registration </strong></td>
        </tr>
        <tr>
          <td width="78">Full Name </td>
          <td width="6">:</td>
          <td width="294"><input name="fullname" type="text" id="fullname" autofocus="autofocus" required="required" /></td>
        </tr>
        <tr>
          <td width="78">Username</td>
          <td width="6">:</td>
          <td width="294"><input name="user" type="text" id="user" autofocus="autofocus" required="required" /></td>
        </tr>
        <tr>
          <td>Password</td>
          <td>:</td>
          <td><input name="password" type="password" id="password" autofocus="autofocus" required="required" /></td>
        </tr>
         <tr>
          <td>Email : </td>
          <td>:</td>
          <td><input name="email" type="email" autofocus="autofocus" required="required"  /></td>
        </tr>
          <tr>
          <td>Re-Enter Email : </td>
          <td>:</td>
          <td><input name="email" type="email" autofocus="autofocus" required="required"  /></td>
        </tr>
        <tr>
          <td>Address : </td>
          <td>:</td>
          <td><input name="address" type="text" autofocus="autofocus" required="required"  /></td>
        </tr>
        
        
        
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td><input type="submit" name="Submit" value="Register" /></td>
        </tr>
      </table></td>
    </tr>
  </table></td>
  <input type="hidden" name="MM_insert" value="form1" />
  </form>

</tr>

</table>
<p align="center">
Already Have a account? <a href="login.php"> Login</a>
</p>
</body>
</html>
<?php
mysql_free_result($User_information);

?>
