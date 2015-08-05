<?php @session_start(); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "UpdateForm")) {
  $insertSQL = sprintf("INSERT INTO driver_details (name, gender, dob, email_id, address_driver) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Update_name'], "text"),
                       GetSQLValueString(isset($_POST['Gender']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString($_POST['Update_date'], "date"),
                       GetSQLValueString($_POST['Update_Email'], "text"),
                       GetSQLValueString($_POST['UserIDHidded'], "text"));

  mysql_select_db($database_user_info, $user_info);
  $Result1 = mysql_query($insertSQL, $user_info) or die(mysql_error());

  $insertGoTo = "InsertDriverDetails.php";
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

$maxRows_VehcileDetails = 10;
$pageNum_VehcileDetails = 0;
if (isset($_GET['pageNum_VehcileDetails'])) {
  $pageNum_VehcileDetails = $_GET['pageNum_VehcileDetails'];
}
$startRow_VehcileDetails = $pageNum_VehcileDetails * $maxRows_VehcileDetails;

mysql_select_db($database_user_info, $user_info);
$query_VehcileDetails = "SELECT * FROM vehicle_type";
$query_limit_VehcileDetails = sprintf("%s LIMIT %d, %d", $query_VehcileDetails, $startRow_VehcileDetails, $maxRows_VehcileDetails);
$VehcileDetails = mysql_query($query_limit_VehcileDetails, $user_info) or die(mysql_error());
$row_VehcileDetails = mysql_fetch_assoc($VehcileDetails);

if (isset($_GET['totalRows_VehcileDetails'])) {
  $totalRows_VehcileDetails = $_GET['totalRows_VehcileDetails'];
} else {
  $all_VehcileDetails = mysql_query($query_VehcileDetails);
  $totalRows_VehcileDetails = mysql_num_rows($all_VehcileDetails);
}
$totalPages_VehcileDetails = ceil($totalRows_VehcileDetails/$maxRows_VehcileDetails)-1;

$queryString_VehcileDetails = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_VehcileDetails") == false && 
        stristr($param, "totalRows_VehcileDetails") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_VehcileDetails = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_VehcileDetails = sprintf("&totalRows_VehcileDetails=%d%s", $totalRows_VehcileDetails, $queryString_VehcileDetails);
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
<link href="CSS/jquery-ui.css" rel="stylesheet">

<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css">
<link href="JS/DatePicker.js" type="text/javascript">
<script src="JS/jquery-ui.js"></script>
<script src="jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<style type="text/css">
#Content #ContentRight #UpdateForm table tr td table tr td table tr td table tr td {
	text-align: center;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Booking Your Car</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<?php echo((isset($WA_custom_search_1))?$WA_custom_search_1->Head:"") ?>
<script type="text/javascript" src="webassist/framework/javascript/ajax.js"></script>
<script src="SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
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
            <li><a href="Contact_us.php">Contact Us</a></li>
            <li><a href="About_us.php">About Us</a></li>
            
<li><a href="Logout.php">Logout</a></li>
<li><a href="login.php">Login</a></li>
<li><a href="Register_user.php">Register</a></li>
<li><a href="index.php">Home</a></li>
</nav>
  </div>
           
            
<div id="Content">
<div id="PageHeading">
  <h1>Car Hire Dorset</h1>
</div>
<div id="ContentLeft">
  <h3>Please Book your car Here </h3>
</div>
<div id="ContentRight">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="UpdateForm" id="UpdateForm">
    <table width="600" border="0" align="center">
      <tr>
        <td><table width="537" border="0" align="center">
          <tr>
              <td width="531">&nbsp;</td>
            </tr>
            <tr>
              <td><span id="sprytextfield1">
                <label for="Update_name"></label>
                Name : <br>
                <span class="textfieldRequiredMsg">A value is required.</span></span>
                <input name="Update_name" type="text" class="styleTxtField" id="Update_name" value=""></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span id="spryradio1">
                <label>
                  Gender :<br>
                  <input name="Gender" type="radio" id="Gender_0" value="radio">
                  Male</label>
                <br>
                <label>
                  <input name="Gender" type="radio" id="Gender_1" value="radio">
                  Female</label>
                <br>
                <span class="radioRequiredMsg">Please make a selection.</span></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span id="sprytextfield3"> Date :<br>
                <input name="date" type="date" class="styleTxtField" id="date" value="">
                <script>
				$('#date').datepicker();
				defaultDate: +5
				maxDate : +3
			
				</script>
                <span class="textfieldRequiredMsg">A value is required.</span></span>
                
                </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Phone <span id="sprytextfield4"> :<br>
                <input name="Update_Email" type="text" class="styleTxtField" id="Update_Email" value="">
                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span id="sprytextfield2">Address :<br>
                <input name="text1" type="text" class="styleTxtField" id="text1" value="">
                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span id="sprytextfield5">
                Seat : <br>
                <input name="text2" type="text" class="styleTxtField" id="text2">
                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
            </tr>
            <tr>
              <td><table width="500" border="0">
                <tr>
                  <td width="147"><table width="197" border="0">
                    <tr>
                      <td width="191">Model</td>
                    </tr>
                  </table></td>
                  <td width="158"><table width="158" border="0">
                    <tr>
                      <td>Color</td>
                    </tr>
                  </table></td>
                  <td width="181"><table width="206" border="0">
                    <tr>
                      <td width="200">Seat</td>
                    </tr>
                  </table></td>
                </tr>
                <?php do { ?>
                  <tr>
                    <td><table width="158" border="0">
                      <tr>
                        <td><span id="sprytextfield6">
                          <input name="text3" type="text" class="styleTxtField" id="text3" value="<?php echo $row_VehcileDetails['name']; ?>">
                          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
                      </tr>
                    </table></td>
                    <td><table width="158" border="0">
                      <tr>
                        <td><span id="sprytextfield7">
                          <input name="text4" type="text" class="styleTxtField" id="text4" value="<?php echo $row_VehcileDetails['Model']; ?>">
                          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
                      </tr>
                    </table></td>
                    <td><table width="173" border="0">
                      <tr>
                        <td width="167"><span id="sprytextfield8">
                          <input name="text5" type="text" class="styleTxtField" id="text5" value="<?php echo $row_VehcileDetails['Seat Quantity']; ?>">
                          <span class="textfieldRequiredMsg">A value is required.</span></span></td>
                      </tr>
                    </table></td>
                  </tr>
                  <?php } while ($row_VehcileDetails = mysql_fetch_assoc($VehcileDetails)); ?>
              </table></td>
            </tr>
            <tr>
              <td><a href="<?php printf("%s?pageNum_VehcileDetails=%d%s", $currentPage, min($totalPages_VehcileDetails, $pageNum_VehcileDetails + 1), $queryString_VehcileDetails); ?>">Next</a></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><input type="submit" name="UpadateDate" id="UpadateDate" value="Confirm">
                <input name="UserIDHidded" type="hidden" id="UserIDHidded" value="<?php echo $row_user['cust_id']; ?>"></td>
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
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
</script><div style="width: 100%;" id="cse">
  <div class="gsc-control-cse gsc-control-cse-en">
    <div class="gsc-control-wrapper-cse" dir="ltr"></div>
  </div>
</div>
<script type="text/javascript">
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryradio1 = new Spry.Widget.ValidationRadio("spryradio1");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
</script>
</body>
</html>
<?php
mysql_free_result($user);

mysql_free_result($VehcileDetails);
?>
