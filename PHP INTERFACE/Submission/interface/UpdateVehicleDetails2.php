<?php @session_start(); ?>
<?php require_once('webassist/framework/framework.php'); ?>
<?php require_once('webassist/framework/library.php'); ?>
<?php @session_start(); ?>
<?php require_once('Connections/user_info.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

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
    if (($strUsers == "") && false) { 
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "UpdateForm")) {
  $updateSQL = sprintf("UPDATE vehicle_details SET vehicle_id=%s, vechicle_status=%s WHERE vehicle_reg_no=%s",
                       GetSQLValueString($_POST['UserIDHidded'], "int"),
                       GetSQLValueString($_POST['select1'], "int"),
                       GetSQLValueString($_POST['RegNo'], "int"));

  mysql_select_db($database_user_info, $user_info);
  $Result1 = mysql_query($updateSQL, $user_info) or die(mysql_error());

  $updateGoTo = "UpdateVehicleDetails.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_user = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_user = $_SESSION['MM_Username'];
}
mysql_select_db($database_user_info, $user_info);
$query_user = sprintf("SELECT * FROM customer_datails WHERE user_id = %s", GetSQLValueString($colname_user, "text"));
$user = mysql_query($query_user, $user_info) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);

mysql_select_db($database_user_info, $user_info);
$query_VehicleDetailsUpdate = "SELECT * FROM vehicle_details";
$VehicleDetailsUpdate = mysql_query($query_VehicleDetailsUpdate, $user_info) or die(mysql_error());
$row_VehicleDetailsUpdate = mysql_fetch_assoc($VehicleDetailsUpdate);
$totalRows_VehicleDetailsUpdate = mysql_num_rows($VehicleDetailsUpdate);
?>
<?php
if("" == ""){
	$WA_custom_search_1 = new WA_Include("webassist/google/search/plugins/update_custom_search.php");
	require($WA_custom_search_1->BaseName);
	$WA_custom_search_1->Initialize(true);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="CSS/layout.css" rel="stylesheet" type="text/css" />
<link href="CSS/Menu.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Update Vehicle Details</title>
<?php echo((isset($WA_custom_search_1))?$WA_custom_search_1->Head:"") ?>
<script type="text/javascript" src="webassist/framework/javascript/ajax.js"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
<div id="Holder">
<div id="Header"></div>
<div id="NavBar">
	<nav>
    	<ul>
        	
            <ul>
            <li><a href="index.php">Home</a></li></ul>
            
           
            <ul>
            <li><a href="Admin_ManageUser.php">Manage User </a></li></ul>
            
            
            <ul>
            <li><a href="">Update</a>
            <ul>
            <li><a href="update.php">User Details </a></li>
            <li><a href="UpdateVehicleDetails.php">Vehicle Details</a></li>
            <li><a href="UpdateVehicleType.php">Vehicle Type</a></li>
            <li><a href="UpdateDriverDetails.php">Driver Details</a></li>
            <li><a href="UpdateBillingDetails.php">Billing Details</a></li>
            </ul>
            </li>
            
            <ul>
            <li><a href=""> Insert</a>
            <ul>
            <li><a href="InsertVehicleType.php">Vehicle Type</a></li>
            <li><a href="InsertVehicleDetails.php">Vehicle Details</a></li>
            <li><a href="InsertDriverDetails.php">Driver Details</a></li>
            <li><a href="InsertBillingDetails.php">Billing Details</a></li>
            </ul>
            </li>
<li><a href="Logout.php">Logout</a></li>
        </nav>
            </div>
           
            
<div id="Content">
<div id="PageHeading">
  <h1>Car Hire Dorset</h1>
</div>
<div id="ContentLeft">
  <h3>Welcome to Dorset Car Rental Service </h3>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div id="ContentRight">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="UpdateForm" id="UpdateForm">
    <table width="600" border="0">
      <tr>
        <td>Account Info : <?php echo $row_user['FName']; ?>   User Name : <?php echo $row_user['user_id']; ?>
          <table width="400" border="0" align="center">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span id="sprytextfield2">
                Vehicle ID : <br>
                <input name="text1" type="text" class="styleTxtField" id="text1" value="<?php echo $row_VehicleDetailsUpdate['vehicle_id']; ?>">
                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span id="sprytextfield1"> Vehicle Registration No :<br>
                <input name="RegNo" type="text" class="styleTxtField" id="RegNo" value="<?php echo $row_VehicleDetailsUpdate['vehicle_reg_no']; ?>">
                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span id="spryselect2">
                Available :<br>
                <select name="select1" class="styleTxtField" id="select1">
                  <option value="1" <?php if (!(strcmp(1, $row_VehicleDetailsUpdate['vechicle_status']))) {echo "selected=\"selected\"";} ?>>Yes</option>
                  <option value="0" <?php if (!(strcmp(0, $row_VehicleDetailsUpdate['vechicle_status']))) {echo "selected=\"selected\"";} ?>>No</option>
</select>
                <span class="selectRequiredMsg">Please select an item.</span></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input name="UpadateDate" type="submit" id="UpadateDate" formmethod="POST" value="Update">
                <input name="UserIDHidded" type="hidden" id="UserIDHidded" value="<?php echo $row_VehicleDetailsUpdate['vehicle_id']; ?>"></td>
            </tr>
      </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="MM_update" value="UpdateForm">
  </form>
</div> 
</div>
<div id="Footer" ></div>

</div>
<div style="width: 100%;" id="cse">
  <div class="gsc-control-cse gsc-control-cse-en">
    <div class="gsc-control-wrapper-cse" dir="ltr"></div>
  </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php
mysql_free_result($user);

mysql_free_result($VehicleDetailsUpdate);
?>
