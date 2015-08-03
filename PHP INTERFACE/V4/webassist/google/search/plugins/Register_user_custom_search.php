<?php require_once("../../../../webassist/google/search/object/wa_google_search.php"); ?>
<?php
$WAGS_custom_search = new WA_GoogleSearch("custom_search","AIzaSyBVpdpOi8oTmukYWfwbIYvYCLdsKMrydoM","002762403214923538351:ryajnu0zfxs","");
$WAGS_custom_search->SetRows(10);
$WAGS_custom_search->SetNavPages(10);
$WAGS_custom_search->SetStart((isset($_GET['custom_search_start']))?$_GET['custom_search_start']:1);
if (((isset($_GET["WAGS_custom_search_search"])?"1":"") != "")) $WAGS_custom_search->SetQuery("".($_GET["WAGS_custom_search_search"])  ."");
if (""  != "") $WAGS_custom_search->SetSite("");
$WAGS_custom_search->Execute();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
<title>Google Custom Search Results</title>
<link rel="stylesheet" type="text/css" href="../css/default_en.css"/>
<link rel="stylesheet" type="text/css" href="../css/bubblegum.css"/>
</head>

<body>
<?php
  if ("".($WAGS_custom_search->Query)  ."" != "") {  // WebAssist Show If
?>
      <div CLASS="gsc-above-wrapper-area">
        <table CELLSPACING="0" CELLPADDING="0" CLASS="gsc-above-wrapper-area-container">
          <tbody>
            <tr>
              <td CLASS="gsc-result-info-container"><div CLASS="gsc-result-info" id="resInfo-0">About <?php echo($WAGS_custom_search->FormattedTotalResults); ?> results (<?php echo($WAGS_custom_search->FormattedSearchTime); ?> seconds)</div></td>
            </tr>
          </tbody>
        </table>
      </div>
<?php
  } // ("".($WAGS_custom_search->Query)  ."" != "")
?>
<?php
  if ("".($WAGS_custom_search->TotalResults)  ."" > "0") {  // WebAssist Show If
?>
      <div CLASS="gsc-wrapper">
        <div CLASS="gsc-resultsbox-visible">
          <div CLASS="gsc-resultsRoot gsc-tabData gsc-tabdActive">
            <table CELLSPACING="0" CELLPADDING="0" CLASS="gsc-resultsHeader">
              <tbody>
                <tr>
                  <td CLASS="gsc-twiddleRegionCell gsc-twiddle-opened"><div CLASS="gsc-twiddle">
                      <div CLASS="gsc-title">Web</div>
                    </div>
                    <div CLASS="gsc-stats">(8)</div>
                    <div CLASS="gsc-results-selector gsc-all-results-active">
                      <div CLASS="gsc-result-selector gsc-one-result" title="show one result">&nbsp;</div>
                      <div CLASS="gsc-result-selector gsc-more-results" title="show more results">&nbsp;</div>
                      <div CLASS="gsc-result-selector gsc-all-results" title="show all results">&nbsp;</div>
                    </div></td>
                  <td CLASS="gsc-configLabelCell"></td>
                </tr>
              </tbody>
            </table>
            <div CLASS="gsc-results gsc-webResult" STYLE="display: block;">
<?php
while ($WAGS_custom_search->GetItem())  {
?>
<?php
  if ("".($WAGS_custom_search->Index)  ."" == "1") {  // WebAssist Show If
?>
<?php echo('<div class="gsc-expansionArea">'); ?>
<?php
  } // ("".($WAGS_custom_search->Index)  ."" == "1")
?>
			  <div CLASS="gsc-webResult gsc-result">
                <div CLASS="gs-webResult gs-result">
                  <div CLASS="gsc-thumbnail-inside">
                    <div CLASS="gs-title"><a CLASS="gs-title" HREF="<?php echo($WAGS_custom_search->GetItem()->link); ?>" TARGET="[target]" DIR="ltr"><?php echo($WAGS_custom_search->GetItem()->htmlTitle); ?></a></div>
                  </div>
                  <div CLASS="gsc-url-top">
                    <div CLASS="gs-bidi-start-align gs-visibleUrl gs-visibleUrl-short" DIR="ltr"><?php echo($WAGS_custom_search->GetItem()->formattedUrl); ?></div>
                    <div CLASS="gs-bidi-start-align gs-visibleUrl gs-visibleUrl-long" DIR="ltr" STYLE=""><?php echo($WAGS_custom_search->GetItem()->htmlFormattedUrl); ?></div>
                  </div>
                  <table CLASS="gsc-table-result">
                    <tbody>
                      <tr>
                        <td STYLE="display: none;" CLASS="gsc-table-cell-thumbnail gsc-thumbnail">
<?php
  if ("".isset($WAGS_custom_search->GetItem()->pagemap->cse_thumbnail)  ."" == "1") {  // WebAssist Show If
?>
                        <div CLASS="gs-image-box gs-web-image-box gs-web-image-box-landscape"><a CLASS="gs-image" HREF="<?php echo($WAGS_custom_search->GetItem()->link); ?>" TARGET="[target]" ><img onLoad="if (this.parentNode &amp;&amp; this.parentNode.parentNode &amp;&amp; this.parentNode.parentNode.parentNode) { this.parentNode.parentNode.parentNode.style.display = ''; this.parentNode.parentNode.className = 'gs-image-box gs-web-image-box gs-web-image-box-landscape'; } " CLASS="gs-image" SRC="<?php echo($WAGS_custom_search->GetItem()->pagemap->cse_thumbnail[0]->src); ?>"></a></div>
<?php
  } // ("".isset($WAGS_custom_search->GetItem()->pagemap)  ."" == "1")
?>
                        </td>
                        <td onClick="if (this.className == 'gsc-table-cell-snippet-close gsc-collapsable') { this.className = 'gsc-table-cell-snippet-open gsc-collapsable'; } else if (this.className == 'gsc-table-cell-snippet-open gsc-collapsable') { this.className = 'gsc-table-cell-snippet-close gsc-collapsable'; };" CLASS="gsc-table-cell-snippet-close"><div CLASS="gs-title gsc-table-cell-thumbnail gsc-thumbnail-left"><a CLASS="gs-title" HREF="<?php echo($WAGS_custom_search->GetItem()->link); ?>" TARGET="[target]" DIR="ltr"><?php echo($WAGS_custom_search->GetItem()->htmlTitle); ?></a></div>
                          <div CLASS="gs-bidi-start-align gs-snippet" DIR="ltr"><?php echo($WAGS_custom_search->GetItem()->htmlSnippet); ?></div>
                          <div CLASS="gsc-url-bottom">
                            <div CLASS="gs-bidi-start-align gs-visibleUrl gs-visibleUrl-short" DIR="ltr"><?php echo($WAGS_custom_search->GetItem()->formattedUrl); ?></div>
<?php
  if ("".isset($WAGS_custom_search->GetItem()->htmlFormattedUrl)  ."" == "1") {  // WebAssist Show If
?>
                            <div CLASS="gs-bidi-start-align gs-visibleUrl gs-visibleUrl-long" DIR="ltr" STYLE=""><?php echo($WAGS_custom_search->GetItem()->htmlFormattedUrl); ?></div>
<?php
  } // ("".isset($WAGS_custom_search->GetItem()->htmlFormattedUrl)  ."" == "1")
?>
                          </div></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

<?php
  $WAGS_custom_search->MoveNext();
}
$WAGS_custom_search->MoveTo(0);
?>
<?php
  if ("".($WAGS_custom_search->Index)  ."" > "1") {  // WebAssist Show If
?>
<?php echo("</div>"); ?>
<?php
  } // ("".($WAGS_custom_search->Index)  ."" > "1")
?>
              <div CLASS="gsc-adBlockInvisible" STYLE="height: 0px;"></div>
                <div CLASS="gsc-cursor-box gs-bidi-start-align" DIR="ltr">
                  <div CLASS="gsc-cursor">
<?php
for ($pageLoop = 0; $pageLoop < $WAGS_custom_search->NavMaxPages && ($pageLoop + $WAGS_custom_search->NavStartPage) <= $WAGS_custom_search->NavLastPage; $pageLoop++)  {
	$searchNav = $pageLoop + $WAGS_custom_search->NavStartPage;
?>
                    <div CLASS="gsc-cursor-page<?php echo(($searchNav == $WAGS_custom_search->CurrentPage)?" gsc-cursor-current-page":""); ?>" TABINDEX="0"><a HREF="#" onClick="if (this.parentNode.parentNode.parentNode.parentNode.className == 'gsc-results gsc-webResult') this.parentNode.parentNode.parentNode.parentNode.className='gsc-results gsc-webResult gsc-loading-resultsRoot';framework_load_plugin_url('Register_user_custom_search.php?<?php echo($WAGS_custom_search->GoToPage($searchNav)) ?>',document.getElementById('WAGS_custom_search_form'),'custom_search_1_wrapper','');return document.MM_returnValue"><?php echo($searchNav); ?></a></div>
<?php
}
?>
                  </div>
                </div>
    </div>
              <div CLASS="gcsc-branding">
                <table CELLSPACING="0" CELLPADDING="0" CLASS="gcsc-branding">
                  <tbody>
                    <tr>
                      <td CLASS="gcsc-branding-text"><div CLASS="gcsc-branding-text">powered by</div></td>
                      <td CLASS="gcsc-branding-img-noclear"><a HREF="http://www.google.com/cse/?hl=en" TARGET="[target]" CLASS="gcsc-branding-clickable"><img SRC="http://www.google.com/uds/css/small-logo.png" CLASS="gcsc-branding-img-noclear"></a></td>
                      <td CLASS="gcsc-branding-text gcsc-branding-text-name"><div CLASS="gcsc-branding-text gcsc-branding-text-name">Custom Search</div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
      </div>
<?php
  } // ("".($WAGS_custom_search->TotalResults)  ."" > "0")
?>
</body>
</html>