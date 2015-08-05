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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "Booking")) {
  $insertSQL = sprintf("INSERT INTO reserve (carModel, color, seat) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['MOdel'], "text"),
                       GetSQLValueString($_POST['Color'], "text"),
                       GetSQLValueString($_POST['Seat'], "int"));

  mysql_select_db($database_user_info, $user_info);
  $Result1 = mysql_query($insertSQL, $user_info) or die(mysql_error());

  $insertGoTo = "Order_Confirm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_Recordset1 = 5;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_user_info, $user_info);
$query_Recordset1 = "SELECT * FROM vehicle_type";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $user_info) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

mysql_select_db($database_user_info, $user_info);
$query_Reserv = "SELECT * FROM reserve";
$Reserv = mysql_query($query_Reserv, $user_info) or die(mysql_error());
$row_Reserv = mysql_fetch_assoc($Reserv);
$totalRows_Reserv = mysql_num_rows($Reserv);
 @session_start(); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="CSS/layout.css" rel="stylesheet" type="text/css" />
<link href="CSS/Menu.css" rel="stylesheet" type="text/css" />
<link href="CSS/jquery-ui.css" rel="stylesheet">
<link href="JS/DatePicker.js" type="text/javascript">
<script src="JS/jquery-ui.js"></script>
<script src="jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<style type="text/css">
#Content #ContentRight #UpdateForm table tr td table tr td table tr td table tr td {
	text-align: center;
}
#Content #ContentRight #UpdateForm table tr td table tr td table tr td {
	text-align: center;
}
</style>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Booking Your Car</title>
<?php echo((isset($WA_custom_search_1))?$WA_custom_search_1->Head:"") ?>
<script type="text/javascript" src="webassist/framework/javascript/ajax.js"></script>
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
	<<nav>
    	<ul>
        	
            <ul>
            <li><a href="BookingPageAdmin.php">Booking</a></li>
            
<li><a href="Logout.php">Logout</a></li>
           
            <ul>
<li><a href="Admin_ManageUser.php">Manage User </a></li></ul>
            
            
            <ul>
            <li><a href="#">Update</a>
            <ul>
            <li><a href="update.php">User Details </a></li>
            <li><a href="UpdateVehicleDetails.php">Vehicle Details</a></li>
            <li><a href="UpdateVehicleType.php">Vehicle Type</a></li>
            <li><a href="UpdateDriverDetails.php">Driver Details</a></li>
            <li><a href="UpdateBillingDetails.php">Billing Details</a></li>
            </ul>
            </li>
            
            <ul>
            <li><a href="#"> Insert</a>
            <ul>
            <li><a href="InsertVehicleType.php">Vehicle Type</a></li>
            <li><a href="InsertVehicleDetails.php">Vehicle Details</a></li>
            <li><a href="InsertDriverDetails.php">Driver Details</a></li>
            <li><a href="InsertBillingDetails.php">Billing Details</a></li>
            </ul>
            </li>
            <li><a href="index.php">Home</a></li></ul>
</nav>
  </div>
           
            
<div id="Content">
<div id="PageHeading">
  <h1>Car Hire Dorset</h1>
</div>
<div id="ContentLeft">
  <h3>Welcome to Dorset Car Rental Service </h3>
</div>
<div id="ContentRight">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="Booking" id="BookingCar">
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table width="600" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><span id="spryselect1">
          <select name="MOdel" class="styleTxtField" id="MOdel" title="<?php echo $row_Recordset1['Model']; ?>">
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['Model']?>"<?php if (!(strcmp($row_Recordset1['Model'], $row_Recordset1['Model']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['Model']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select>
          <span class="selectRequiredMsg">Please select an item.</span></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><span id="spryselect2">
          <select name="Color" class="styleTxtField" id="Color">
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['Color']?>"<?php if (!(strcmp($row_Recordset1['Color'], $row_Recordset1['Color']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['Color']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select>
          <span class="selectRequiredMsg">Please select an item.</span></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><span id="spryselect3">
          <select name="Seat" class="styleTxtField" id="Seat">
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['Seat Quantity']?>"<?php if (!(strcmp($row_Recordset1['Seat Quantity'], $row_Recordset1['Seat Quantity']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['Seat Quantity']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select>
          <span class="selectRequiredMsg">Please select an item.</span></span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input name="Confirm" type="submit" id="Confirm" formmethod="POST" value="Confim"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="<?php echo $row_Reserv['reservId']; ?>">
  </form>
</div> 
</div>
<div id="Footer" ></div>

</div> 
<script type="text/javascript">
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
</script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Reserv);
?>
