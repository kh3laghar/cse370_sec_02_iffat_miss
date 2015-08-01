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
  $insertSQL = sprintf("INSERT INTO billing_details (advance_amount, total_amount) VALUES (%s, %s)",
                       GetSQLValueString($_POST['AdvanceAmount'], "int"),
                       GetSQLValueString($_POST['TotalAmount'], "int"));

  mysql_select_db($database_user_info, $user_info);
  $Result1 = mysql_query($insertSQL, $user_info) or die(mysql_error());

  $insertGoTo = "InsertBillingDetails.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_user_info, $user_info);
$query_BillingInsert = "SELECT * FROM billing_details";
$BillingInsert = mysql_query($query_BillingInsert, $user_info) or die(mysql_error());
$row_BillingInsert = mysql_fetch_assoc($BillingInsert);
$totalRows_BillingInsert = mysql_num_rows($BillingInsert);

$colname_BillingDetails = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_BillingDetails = $_SESSION['MM_Username'];
}
mysql_select_db($database_user_info, $user_info);
$query_BillingDetails = sprintf("SELECT * FROM customer_datails WHERE cust_id = %s", GetSQLValueString($colname_BillingDetails, "int"));
$BillingDetails = mysql_query($query_BillingDetails, $user_info) or die(mysql_error());
$row_BillingDetails = mysql_fetch_assoc($BillingDetails);
$totalRows_BillingDetails = mysql_num_rows($BillingDetails);

mysql_select_db($database_user_info, $user_info);
$query_User = "SELECT * FROM customer_datails";
$User = mysql_query($query_User, $user_info) or die(mysql_error());
$row_User = mysql_fetch_assoc($User);
$totalRows_User = mysql_num_rows($User);
$query_BillingInsert = "SELECT * FROM billing_details";
$BillingInsert = mysql_query($query_BillingInsert, $user_info) or die(mysql_error());
$row_BillingInsert = mysql_fetch_assoc($BillingInsert);
$totalRows_BillingInsert = mysql_num_rows($BillingInsert);
?>
<?php require_once('webassist/framework/framework.php'); ?>
<?php require_once('webassist/framework/library.php'); ?>
<?php @session_start(); ?>
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
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Insert Billing Details</title>
<?php echo((isset($WA_custom_search_1))?$WA_custom_search_1->Head:"") ?><script type="text/javascript" src="webassist/framework/javascript/ajax.js"></script>
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
<li><a href="Logout.php">Logout</a></li></nav>
            </div>
           
            
<div id="Content">
<div id="PageHeading">
  <h1>Car Hire Dorset</h1>
</div>
<div id="ContentLeft">
  <h3>Welcome to Dorset Car Rental Service</h3>
</div>
<div id="ContentRight">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="UpdateForm" id="UpdateForm">
    <table width="600" border="0">
      <tr>
        <td>Account Info : <?php echo $row_User['FName']; ?> User Name : <?php echo $row_User['user_id']; ?>
<table width="400" border="0" align="center">
  <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span id="sprytextfield1">
                Total Amount :<br>
                <input name="TotalAmount" type="text" class="styleTxtField" id="TotalAmount" value="<?php echo $row_BillingInsert['total_amount']; ?>">
                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span id="sprytextfield2"> Advance Amount : <br>
                <input name="AdvanceAmount" type="text" class="styleTxtField" id="AdvanceAmount" value="<?php echo $row_BillingInsert['advance_amount']; ?>">
                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input name="UpadateDate" type="submit" id="UpadateDate" value="Insert"></td>
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
              <td><input name="UserIDHidded" type="hidden" id="UserIDHidded" value="<?php echo $row_user['cust_id']; ?>"></td>
            </tr>
  </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="UpdateForm">
  </form>
</div> 
</div>
<div id="Footer" ></div>

</div>
<div style="width: 100%;" id="cse">
  <div class="gsc-control-cse gsc-control-cse-en"></div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php
mysql_free_result($BillingInsert);

mysql_free_result($BillingDetails);

mysql_free_result($User);
?>
