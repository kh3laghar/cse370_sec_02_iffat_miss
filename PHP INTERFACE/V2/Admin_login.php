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

mysql_select_db($database_user_info, $user_info);
$query_Login = "SELECT * FROM customer_datails";
$Login = mysql_query($query_Login, $user_info) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);
$query_Login = "SELECT * FROM customer_datails ORDER BY cust_id ASC";
$Login = mysql_query($query_Login, $user_info) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);
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

if (isset($_POST['UserName'])) {
  $loginUsername=$_POST['UserName'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "UserLevel";
  $MM_redirectLoginSuccess = "Account.php";
  $MM_redirectLoginFailed = "access_denied.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_user_info, $user_info);
  	
  $LoginRS__query=sprintf("SELECT user_id, password, UserLevel FROM customer_datails WHERE user_id=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $user_info) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'UserLevel');
    
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
<?php require_once('webassist/framework/framework.php'); ?>
<?php require_once('webassist/framework/library.php'); ?>
<?php
if("" == ""){
	$WA_custom_search_1 = new WA_Include("webassist/google/search/plugins/Admin_login_custom_search.php");
	require($WA_custom_search_1->BaseName);
	$WA_custom_search_1->Initialize(true);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="CSS/layout.css" rel="stylesheet" type="text/css" />
<link href="CSS/Menu.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>LOGIN</title>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<?php echo((isset($WA_custom_search_1))?$WA_custom_search_1->Head:"") ?>
<script type="text/javascript" src="webassist/framework/javascript/ajax.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
function framework_load_plugin_url(plugin,form,div,framework_path)  {
  document.MM_returnValue = false;
  framework_ajax_plugin(form,plugin,div,framework_path); 
  return true;	
}
</script>
</head>

<body>
<div style="width: 100%;" id="cse">
  <div class="gsc-control-cse gsc-control-cse-en">
    <div class="gsc-control-wrapper-cse" dir="ltr">
      <form class="gsc-search-box" id="WAGS_custom_search_form" onsubmit="framework_load_plugin_url('webassist/google/search/plugins/Admin_login_custom_search.php',document.getElementById('WAGS_custom_search_form'),'custom_search_1_wrapper','');return document.MM_returnValue" accept-charset="utf-8" action="" method="get">
        <table cellspacing="0" cellpadding="0" class="gsc-search-box">
          <tbody>
            <tr>
              <td class="gsc-input"><input type="text" autocomplete="off" size="10" class="gsc-input" name="WAGS_custom_search_search" title="search" id="WAGS_custom_search_search" dir="ltr" spellcheck="false" onfocus="this.style.backgroundImage = 'none';" onblur="if (this.value=='') this.style.backgroundImage = ' url(http://www.google.com/cse/intl/en/images/google_custom_search_watermark.gif)'; else this.style.backgroundImage = 'none';" style="outline: medium none; background: <?php echo(($WAGS_custom_search->Query)?"none":"url(http://www.google.com/cse/intl/en/images/google_custom_search_watermark.gif)"); ?> no-repeat scroll left center rgb(255, 255, 255);" value="<?php echo($WAGS_custom_search->Query); ?>"></td>
              <td class="gsc-search-button">
              <input type="submit" value="Search" class="gsc-search-button" title="search"></td>
              <td class="gsc-clear-button" onclick="document.getElementById('WAGS_custom_search_search').value='';framework_load_plugin_url('webassist/google/search/plugins/Admin_login_custom_search.php',document.getElementById('WAGS_custom_search_form'),'custom_search_1_wrapper','');document.getElementById('WAGS_custom_search_search').onblur();return document.MM_returnValue"><div class="gsc-clear-button" title="clear results">&nbsp;</div></td>
            </tr>
          </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" class="gsc-branding">
          <tbody>
            <tr>
              <td class="gsc-branding-user-defined"></td>
              <td class="gsc-branding-text"><div class="gsc-branding-text">powered by</div></td>
              <td class="gsc-branding-img"><img src="http://www.google.com/uds/css/small-logo.png" class="gsc-branding-img"></td>
            </tr>
          </tbody>
        </table>
      </form>
      <div id="custom_search_1_wrapper">
	  <?php echo((isset($WA_custom_search_1))?$WA_custom_search_1->Body:"") ?>
      </div>
    </div>
  </div>
</div><div id="Holder">
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
  <h1>Login !</h1>
</div>
<div id="ContentLeft">
  <h3>Welcome to Dorset Car Rental Service </h3>
</div>
<div id="ContentRight">
  <form action="<?php echo $loginFormAction; ?>" method="POST" name="LoginForm" id="LoginForm">
    <table width="400" border="0" align="center">
      <tr>
        <td><span id="LoginUserName"> Username : <br>
          <input name="UserName" type="text" class="styleTxtField" id="UserName">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><span id="LoginPassword"> Password : <br>
          <input name="password" type="password" class="styleTxtField" id="password">
          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><label for="Login"></label>
          <input type="submit" name="Login" id="Login" value="Login"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div> 
</div>
<div id="Footer" ></div>

</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("LoginUserName");
var sprytextfield2 = new Spry.Widget.ValidationTextField("LoginPassword");
</script>
</body>
</html>
<?php
mysql_free_result($Login);
?>
