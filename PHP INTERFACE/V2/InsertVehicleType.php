<?php require_once('webassist/framework/framework.php'); ?>
<?php require_once('webassist/framework/library.php'); ?>
<?php @session_start(); ?>
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "UpdateForm")) {
  $insertSQL = sprintf("INSERT INTO vehicle_type (name, Model, deposit, cost_per_mile, availbility_vechicle) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['VehicleName'], "text"),
                       GetSQLValueString($_POST['Model'], "text"),
                       GetSQLValueString($_POST['DepositMoney'], "int"),
                       GetSQLValueString($_POST['CostPerMile'], "int"),
                       GetSQLValueString($_POST['Avail'], "int"));

  mysql_select_db($database_user_info, $user_info);
  $Result1 = mysql_query($insertSQL, $user_info) or die(mysql_error());

  $insertGoTo = "InsertVehicleType.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
$query_VehicleType = "SELECT * FROM vehicle_type";
$VehicleType = mysql_query($query_VehicleType, $user_info) or die(mysql_error());
$row_VehicleType = mysql_fetch_assoc($VehicleType);
$totalRows_VehicleType = mysql_num_rows($VehicleType);
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Tamplate</title>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<?php echo((isset($WA_custom_search_1))?$WA_custom_search_1->Head:"") ?>
<script type="text/javascript" src="webassist/framework/javascript/ajax.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
  <h1>Car Hire Dorset</h1>
</div>
<div id="ContentLeft">
  <h3>Welcome to Dorset Car Rental Service </h3>
</div>
<div id="ContentRight">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="UpdateForm" id="UpdateForm">
    <table width="600" border="0">
      <tr>
        <td height="26">Account Info : <?php echo $row_user['FName']; ?>    User Name : <?php echo $row_user['user_id']; ?>
          <table width="400" border="0" align="center">
          <tr>            </tr>
          </table></td>
      </tr>
      <tr>
        <td><table width="500" border="0" align="center">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span id="sprytextfield1">
              <label for="VehicleName"></label>
Name of Vehicle : <br>
              <input name="VehicleName" type="text" class="styleTxtField" id="VehicleName">
              <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span id="sprytextfield4">
              <label for="Model"></label>
Model No : <br>
              <input name="Model" type="text" class="styleTxtField" id="Model">
              <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span id="sprytextfield2">
              <label for="DepositMoney"></label>
Deposit Money : <br>
              <input name="DepositMoney" type="text" class="styleTxtField" id="DepositMoney">
              <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span id="sprytextfield3">
              <label for="CostPerMile"></label>
Cost Per Mile : <br>
              <input name="CostPerMile" type="text" class="styleTxtField" id="CostPerMile">
              <span class="textfieldRequiredMsg">A value is required.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><span id="spryselect2">
              <label for="Avail"></label>
              <select name="Avail" class="styleTxtField" id="Avail">
                <option value="" <?php if (!(strcmp("", 1))) {echo "selected=\"selected\"";} ?>>Yes</option>
                <option value="" <?php if (!(strcmp("", 1))) {echo "selected=\"selected\"";} ?>>No</option>
                <?php
do {  
?>
                <option value="<?php echo $row_VehicleType['availbility_vechicle']?>"<?php if (!(strcmp($row_VehicleType['availbility_vechicle'], 1))) {echo "selected=\"selected\"";} ?>><?php echo $row_VehicleType['availbility_vechicle']?></option>
<?php
} while ($row_VehicleType = mysql_fetch_assoc($VehicleType));
  $rows = mysql_num_rows($VehicleType);
  if($rows > 0) {
      mysql_data_seek($VehicleType, 0);
	  $row_VehicleType = mysql_fetch_assoc($VehicleType);
  }
?>
              </select>
              <span class="selectRequiredMsg">Please select an item.</span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><input type="submit" name="Add" id="Add" value="Add"></td>
          </tr>
          <tr>
            <td><span id="spryselect1">
              <label for="Avail"></label>
              <span class="selectRequiredMsg">Please select an item.</span></span></td>
          </tr>
        </table></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="UpdateForm">
  </form>
</div> 
</div>
<div id="Footer" ></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
</script>
</body>
</html>
<?php
mysql_free_result($user);

mysql_free_result($VehicleType);
?>
