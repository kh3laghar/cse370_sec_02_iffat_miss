<?php require_once('../../webassist/framework/framework.php'); ?>
<?php require_once('../../webassist/framework/library.php'); ?>
<?php
$from = $_GET['plugin_from'];
$from = substr($from,strpos($from,$_SERVER['SERVER_NAME']) + strlen($_SERVER['SERVER_NAME']));
if (strpos($from,"?") !== false) $from = substr($from,0,strpos($from,"?"));
$page = $_GET['plugin_file'];
if (strpos($page,"?") !== false) {
	$params = substr($page,strpos($page,"?")+1);
	$params = explode("&",$params);
	for ($x=0; $x<sizeof($params); $x++)   {
	  $vals = explode("=",$params[$x]);
	  $_GET[$vals[0]] = $vals[1];
	}
	$page = substr($page,0,strpos($page,"?"));
}

if (strrpos($from,".") && strrpos($from,"/") < strrpos($from,".")) {
	$from = dirname($from);
}

chdir($site_root.($from));

if (strpos($page,"/")===0)  {
  $page = abs2rel($page,getcwd());
}

?>
<?php
if("" == ""){
	$WA_StaticFrameworkPlugin_1343153630587 = new WA_Include("".($page)  ."");
	require($WA_StaticFrameworkPlugin_1343153630587->BaseName);
	$WA_StaticFrameworkPlugin_1343153630587->Initialize(true);
}
?>
<?php echo((isset($WA_StaticFrameworkPlugin_1343153630587))?$WA_StaticFrameworkPlugin_1343153630587->Body:"") ?>