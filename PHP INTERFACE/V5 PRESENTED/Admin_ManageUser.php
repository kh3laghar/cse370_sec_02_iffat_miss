<?php require_once('Connections/user_info.php'); ?>
<?php @session_start(); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_POST['DeleteUserForm'])) && ($_POST['DeleteUserForm'] != "")) {
  $deleteSQL = sprintf("DELETE FROM customer_datails WHERE cust_id=%s",
                       GetSQLValueString($_POST['DeleteUserForm'], "int"));

  mysql_select_db($database_user_info, $user_info);
  $Result1 = mysql_query($deleteSQL, $user_info) or die(mysql_error());

  $deleteGoTo = "Admin_ManageUser.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_ManageUser = 3;
$pageNum_ManageUser = 0;
if (isset($_GET['pageNum_ManageUser'])) {
  $pageNum_ManageUser = $_GET['pageNum_ManageUser'];
}
$startRow_ManageUser = $pageNum_ManageUser * $maxRows_ManageUser;

mysql_select_db($database_user_info, $user_info);
$query_ManageUser = "SELECT * FROM customer_datails";
$query_limit_ManageUser = sprintf("%s LIMIT %d, %d", $query_ManageUser, $startRow_ManageUser, $maxRows_ManageUser);
$ManageUser = mysql_query($query_limit_ManageUser, $user_info) or die(mysql_error());
$row_ManageUser = mysql_fetch_assoc($ManageUser);

if (isset($_GET['totalRows_ManageUser'])) {
  $totalRows_ManageUser = $_GET['totalRows_ManageUser'];
} else {
  $all_ManageUser = mysql_query($query_ManageUser);
  $totalRows_ManageUser = mysql_num_rows($all_ManageUser);
}
$totalPages_ManageUser = ceil($totalRows_ManageUser/$maxRows_ManageUser)-1;

$queryString_ManageUser = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ManageUser") == false && 
        stristr($param, "totalRows_ManageUser") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ManageUser = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ManageUser = sprintf("&totalRows_ManageUser=%d%s", $totalRows_ManageUser, $queryString_ManageUser);

$colname_user = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_user = $_SESSION['MM_Username'];
}
mysql_select_db($database_user_info, $user_info);
$query_user = sprintf("SELECT * FROM customer_datails WHERE user_id = %s", GetSQLValueString($colname_user, "text"));
$user = mysql_query($query_user, $user_info) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="CSS/layout.css" rel="stylesheet" type="text/css" />
<link href="CSS/Menu.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Manage User</title>
</head>

<body>
<div id="Holder">
<div id="Header"></div>
<div id="NavBar">
	<nav>
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
  <h1>&nbsp;</h1>
  <h1>Wecome <?php echo $row_user['FName']; ?> <?php echo $row_user['LName']; ?> !</h1>
</div>
<div id="ContentLeft">
  <h3>Account Link </h3>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div id="ContentRight">
  <table width="670" border="0" align="center">
    <tr>
      <td align="right" valign="top">Showing :&nbsp;<?php echo ($startRow_ManageUser + 1) ?>to <?php echo min($startRow_ManageUser + $maxRows_ManageUser, $totalRows_ManageUser) ?>of <?php echo $totalRows_ManageUser ?></td>
    </tr>
    <tr>
      <td><?php if ($totalRows_ManageUser > 0) { // Show if recordset not empty ?>
        <?php do { ?>
            <table width="500" border="0" align="center">
              <tr>
                <td><?php echo $row_ManageUser['FName']; ?> <?php echo $row_ManageUser['LName']; ?> <?php echo $row_ManageUser['email_id']; ?></td>
                </tr>
              <tr>
                <td><form action="" method="post" name="DeleteUserForm" id="DeleteUserForm">
                  <input name="DeleteUser" type="hidden" id="DeleteUser" value="<?php echo $row_ManageUser['cust_id']; ?>">
                  <input type="button" name="button" id="button" value="Delete User">
                  </form></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                </tr>
            </table>
            <?php } while ($row_ManageUser = mysql_fetch_assoc($ManageUser)); ?>
        <?php } // Show if recordset not empty ?></td>
    </tr>
    <tr>
      <td align="right" valign="top"><p>
        <?php if ($pageNum_ManageUser > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_ManageUser=%d%s", $currentPage, max(0, $pageNum_ManageUser - 1), $queryString_ManageUser); ?>">Previous </a>
          <?php } // Show if not first page ?>
<a href="<?php printf("%s?pageNum_ManageUser=%d%s", $currentPage, min($totalPages_ManageUser, $pageNum_ManageUser + 1), $queryString_ManageUser); ?>">Next</a></p></td>
    </tr>
  </table>
</div> 
</div>
<div id="Footer" ></div>

</div> 
</body>
</html>
<?php
mysql_free_result($ManageUser);
?>
