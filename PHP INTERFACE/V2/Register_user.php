<?php require_once('webassist/framework/framework.php'); ?>
<?php require_once('webassist/framework/library.php'); ?>
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="Register_user.php";
  $loginUsername = $_POST['UserName'];
  $LoginRS__query = sprintf("SELECT user_id FROM customer_datails WHERE user_id=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_user_info, $user_info);
  $LoginRS=mysql_query($LoginRS__query, $user_info) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "RegisterForm")) {
  $insertSQL = sprintf("INSERT INTO customer_datails (FName, LName, user_id, password, email_id, PhoneNo, address_user) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['FName'], "text"),
                       GetSQLValueString($_POST['LName'], "text"),
                       GetSQLValueString($_POST['UserName'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['Email2'], "text"),
                       GetSQLValueString($_POST['PhoneNo'], "int"),
                       GetSQLValueString($_POST['Address'], "text"));

  mysql_select_db($database_user_info, $user_info);
  $Result1 = mysql_query($insertSQL, $user_info) or die(mysql_error());

  $insertGoTo = "Admin_login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_user_info, $user_info);
$query_Registration_RecordSet_RentACar = "SELECT * FROM customer_datails";
$Registration_RecordSet_RentACar = mysql_query($query_Registration_RecordSet_RentACar, $user_info) or die(mysql_error());
$row_Registration_RecordSet_RentACar = mysql_fetch_assoc($Registration_RecordSet_RentACar);
$totalRows_Registration_RecordSet_RentACar = mysql_num_rows($Registration_RecordSet_RentACar);
?>
<?php
if("" == ""){
	$WA_custom_search_1 = new WA_Include("webassist/google/search/plugins/Register_user_custom_search.php");
	require($WA_custom_search_1->BaseName);
	$WA_custom_search_1->Initialize(true);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="CSS/layout.css" rel="stylesheet" type="text/css" />
<link href="CSS/Menu.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
<style type="text/css">
.Sign_up_Green {
	color: #0F0;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Registration</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<?php echo((isset($WA_custom_search_1))?$WA_custom_search_1->Head:"") ?>
<script type="text/javascript" src="webassist/framework/javascript/ajax.js"></script>
<script type="text/javascript">
function framework_load_plugin_url(plugin,form,div,framework_path)  {
  document.MM_returnValue = false;
  framework_ajax_plugin(form,plugin,div,framework_path); 
  return true;	
}
</script>
</head>

<body>
<div id="Holder">
  <div id="Header"></div>
<div id="NavBar">
	<nav>
    	<ul>
        	<li><a href="Admin_login.php">Login</a></li>
<li><a href="Logout.php">Logout</a></li>
            <li><a href="ForgotPassword.php">Forgot Password</a></li>
            <li><a href="Register_user.php">Register</a></li>
<li><a href="Contact_us.php">Contact Us</a></li>
      <li><a href="About_us.php">About Us </a></li></ul></nav>
  </div>
           
            
<div id="Content">
<div id="PageHeading">
  <h1><span class="Sign_up_Green">Sign Up </span>!</h1>
</div>
<div id="ContentLeft">
  <h3>Welcome to Dorset Car Rental Service </h3>
</div>
<div id="ContentRight">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="RegisterForm" id="RegisterForm">
    <table width="400" border="0" align="center">
      <tr>
        <td><table width="376" border="0">
          <tr>
            <td width="144"><span id="FullNameFieldFirstName">
              <label for="FName">First Name : 
                <input name="FName" type="text" class="styleTxtField" id="FName">
                <br>
              </label>
              <span class="textfieldRequiredMsg">First Name Missing .</span></span></td>
              
              
            <td width="168"><span id="FullNameFieldLastName">
              <label for="LName">Last Name :
                <input name="LName" type="text" class="styleTxtField" id="LName">
                <br>
              </label>
            
              <span class="textfieldRequiredMsg">Last Name Missing .</span></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><span id="UserNameRequied">User Name :<br>
          <input name="UserName" type="text" class="styleTxtField" id="UserName">
          
        <span class="textfieldRequiredMsg">User Name Required.</span></span></td>
      </tr>
      <tr>
        <td><table border="0">
          <tr>
            <td><span id="PasswordTest">
              <label for="password">Password :<br>
              </label>
              <input name="password" type="password" class="styleTxtField" id="password">
              <span class="textfieldRequiredMsg">Please Enter Password .</span></span></td>
            <td><span id="PasswordTestConfim">
              <label for="PasswordConfirm">Confirm Password :<br>
              </label>
              <input name="PasswordConfirm" type="password" class="styleTxtField" id="PasswordConfirm">
              <span class="confirmRequiredMsg">PLease Re-Type your Password.</span><span class="confirmInvalidMsg">The values don't match.</span></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
         
          
          <table border="0">
            <tr>
              <td><span id="EmailText">
              <label for="Email">Email :<br>
              </label>
              <input name="Email2" type="text" class="styleTxtField" id="Email">
              <span class="textfieldRequiredMsg">Please Enter Email.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
              <td><span id="EmailTextConfirm">
                <label for="EmailConfirm"> Confirm Email :<br>
                </label>
                <input name="EmailConfirm2" type="text" class="styleTxtField" id="EmailConfirm">
                <span class="confirmRequiredMsg">Please Re-Type your Email.</span><span class="confirmInvalidMsg">The values don't match.</span></span></td>
            </tr>
            <tr> </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><span id="PhoneNoSpan">Phone No :<br>
          <input name="PhoneNo" type="text" class="styleTxtField" id="PhoneNo">
          <span class="textfieldRequiredMsg">Phone No Required .</span></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p>Address : 
          </p>
          <p>
            <textarea name="Address" cols="50" rows="10" class="styleTxtField" id="Address"  ></textarea>
            </p></td>
      </tr>
      <tr>
        <td><input type="submit" name="RegisterButton" id="RegisterButton" value="Register"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="RegisterForm">
  </form>
</div> 
</div>
<div id="Footer" ></div>

</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("FullNameFieldFirstName");
var sprytextfield2 = new Spry.Widget.ValidationTextField("FullNameFieldLastName");
var spryconfirm2 = new Spry.Widget.ValidationConfirm("EmailTextConfirm", "Email");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("EmailText", "email");
var sprytextfield3 = new Spry.Widget.ValidationTextField("PasswordTest");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("PasswordTestConfim", "password");
var sprytextfield7 = new Spry.Widget.ValidationTextField("UserNameRequied");
var sprytextfield4 = new Spry.Widget.ValidationTextField("PhoneNoSpan");
</script>
</body>
</html>
<?php
mysql_free_result($Registration_RecordSet_RentACar);
?>
