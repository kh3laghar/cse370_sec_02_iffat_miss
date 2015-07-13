<?php
class WA_GoogleSearch  {
	public function __construct($searchID, $apiKey, $uniquID, $cref = "") {
	  @session_start();
	  $this->Query = false;
	  $this->APIKey = $apiKey;
	  $this->CREF = $cref;
	  $this->SearchID = $uniquID;
	  $this->Name = $searchID;
	  $this->NavMaxPages = 10;
	  $this->NavLastPage = 0;
	  $this->Rows = 10;
	  $this->MaxStart = 101-$this->Rows;
	  $this->RawResult = "";
	  $this->ResultSet = false;	
	  $this->StartIndex = 1;
	  $this->EndIndex = 0;
	  $this->TotalResults = 0;
	  $this->FormattedTotalResults = 0;
	  $this->SearchTime = 0;
	  $this->FormattedSearchTime = 0;
	  $this->Items = array();
	  $this->Index = 0;
	  $this->CurrentPage = 1;
	  $this->TotalPages = 0;
	  $this->NavMaxStart = 0;
	  $this->NavStartPage = 0;
	  $this->SiteSearch = "";
	}
	
	public function GetRealIpAddr() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		if (strpos($ip,",")) $ip = substr($ip,0,strpos($ip,","));
		return $ip;
	}
	
	public function SetRows($rows)  {
		$this->Rows = ($rows<10)?$rows:10;
	    $this->MaxStart = 101-$this->Rows;
	    if ($this->StartIndex > $this->MaxStart) $this->StartIndex = $this->MaxStart;
	}
	
	public function SetNavPages($pages)  {
	    $this->NavMaxPages = $pages;
	}
	
	public function SetStart($start)  {
		$this->StartIndex = $start;
	    if ($this->StartIndex > $this->MaxStart) $this->StartIndex = $this->MaxStart;
	}
	
	public function SetQuery($query)  {
		$this->Query = $query;
	}
	
	public function Execute()  {
	  if (!$this->Query) {
		  if (isset($_SESSION['WAGS_S_' . $this->Name]) && isset($_GET[$this->Name.'_start']))  {
			$this->Query = $_SESSION['WAGS_S_' . $this->Name];
		  } else {
		    return;
		  }
	  } else {
		  $_SESSION['WAGS_S_' . $this->Name] = $this->Query;
	  }
	  if ($this->Query === false && isset($_SESSION['last_WAGS_search_'.$this->StartIndex."_".$this->Rows])) $this->Query = $_SESSION['last_WAGS_search_'.$this->StartIndex."_".$this->Rows];
	  if (!isset($_SESSION['last_WAGS_result_'.$this->StartIndex."_".$this->Rows]) || $_SESSION['last_WAGS_search_'.$this->StartIndex."_".$this->Rows] != $this->Query)  {
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, "https://www.googleapis.com/customsearch/v1?userIp=" .$this->GetRealIpAddr() ."&key=" .$this->APIKey. (($this->CREF && !$this->SearchID)?"&cref=" .$this->CREF:"&cx=" .$this->SearchID) .(($this->SiteSearch)?"&siteSearch=" .$this->SiteSearch:"") ."&num=" .$this->Rows ."&start=" .$this->StartIndex ."&q=" .((strpos($this->Query," ") !== false)?urlencode($this->Query):$this->Query). "&alt=json");
		/*https://www.googleapis.com/customsearch/v1?
		q={searchTerms}						Search Query
		&num={count?}						Number of Rows to return
		&start={startIndex?}				Start Row
		&lr={language?}						Language (https://developers.google.com/custom-search/docs/xml_results#countryCollections)
		&safe={safe?}						high, medium, off  (default:off)
		&cx={cx?}							Unique ID of your search defined on google.com				
		&cref={cref?}						Hosted ID in place of cx  (http://www.google.com/cse/samples/vegetarian.xml)
		&sort={sort?}						Sort based on structured data  submitted through a page map
		&filter={filter?}					Duplicate content filter (0 turns off)
		&gl={gl?}							GeoLocation of results (https://developers.google.com/custom-search/docs/xml_results#countryCollections)
		&cr={cr?}							Country Restrictions (https://developers.google.com/custom-search/docs/xml_results#countryCollections)
		&googlehost={googleHost?}			Google domain (for example, google.com, google.de, or google.fr)
		&c2coff={disableCnTwTranslation?}	Enabled by default "1" will disable chinese search
		&hq={hq?}							Appends the specified query terms to the query, as if they were combined with a logical AND operator
		&hl={hl?}							The interface language.(https://developers.google.com/custom-search/docs/xml_results#wsInterfaceLanguages)
		&siteSearch={?}						Restricts results to URLs from a specified site.

		&siteSearchFilter={?}				Specifies whether to include or exclude results from the site named in the sitesearch parameter.  (i or e)
		&exactTerms={exactTerms?}			Identifies a phrase that all documents in the search results must contain
		&excludeTerms={excludeTerms?}		Identifies a word or phrase that should not appear in any documents in the search results.
		&linkSite={linkSite?}				Specifies that all search results should contain a link to a particular URL.
		&orTerms={orTerms?}					Provides additional search terms to check for in a document
		&relatedSite={relatedSite?}			A URL to a page to which all search results should be related.
		&dateRestrict={dateRestrict?}		Restricts results to URLs based on date. Supported values include: d[number],w[number],m[number],y[number]
		&lowRange={lowRange?}				use both lowrange and highrange to specify a search range
		&highRange={highRange?}				use both lowrange and highrange to specify a search range		
		&searchType={searchType}			Specifies image search by setting to "image"
		&fileType={fileType?}				Set to only return results from a particular file type. example: "pdf"
		&rights={rights?}					Filters search results based on licensing: cc_publicdomain, cc_attribute, cc_sharealike, cc_noncommercial, cc_nonderived
		&imgSize={imgSize?}					Restricts results to images of a specified size: icon ,small|medium|large|xlarge ,xxlarge ,huge
		&imgType={imgType?}					clipart (clipart), face (face), lineart (lineart), news (news), photo (photo)
		&imgColorType={imgColorType?}		mono (black and white),gray (grayscale), color
		&imgDominantColor={?}				yellow, green, teal, blue, purple, pink, white, gray, black, brown
		*/
		curl_setopt($c, CURLOPT_TIMEOUT, 90);
		curl_setopt($c, CURLOPT_POST, 0);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$_SESSION['last_WAGS_search_'.$this->StartIndex."_".$this->Rows] = $this->Query;
		$_SESSION['last_WAGS_result_'.$this->StartIndex."_".$this->Rows] = curl_exec($c);
	  }
	  $this->RawResult = $_SESSION['last_WAGS_result_'.$this->StartIndex."_".$this->Rows];
	  $this->ResultSet = json_decode($this->RawResult);
	  if (!isset($this->ResultSet->queries)) return;
	  $this->StartIndex = $this->ResultSet->queries->request[0]->startIndex;
	  $this->EndIndex = $this->ResultSet->queries->request[0]->startIndex + $this->ResultSet->queries->request[0]->count - 1;
	  $this->TotalResults = $this->ResultSet->searchInformation->totalResults;
	  $this->ReturnedRows = (($this->TotalResults<100)?$this->TotalResults:100);
      $this->NavLastPage = ceil($this->ReturnedRows/$this->Rows);
	  $this->FormattedTotalResults = $this->ResultSet->searchInformation->formattedTotalResults;
	  $this->SearchTime = $this->ResultSet->searchInformation->searchTime;
	  $this->FormattedSearchTime = $this->ResultSet->searchInformation->formattedSearchTime;
	  if (isset($this->ResultSet->items)) $this->Items = $this->ResultSet->items;
	  $this->Index = 0;
	  $this->CurrentPage = ceil($this->StartIndex/$this->Rows);
	  $this->TotalPages = ceil($this->TotalResults/$this->Rows);
	  $this->NavMaxStart = floor(100/$this->Rows) - $this->NavMaxPages + 1;
	  $this->NavStartPage = 1;
	  if ($this->CurrentPage > ceil(($this->NavMaxPages+1)/2)) $this->NavStartPage = $this->CurrentPage - ceil(($this->NavMaxPages - 1)/2);
	  if ($this->NavStartPage != 1 && $this->NavStartPage > $this->NavMaxStart) $this->NavStartPage = $this->NavMaxStart;
	}
	
	public function GoToPage($pageNum)  {
       $pageURL = "";
	   $startRow = $this->Rows * ($pageNum-1) + 1;
	   $oldQS = false;
	   if ($_SERVER["QUERY_STRING"])  {
		   $oldQS = preg_replace("/[\&\?]?".$this->Name."_start=\d*/","",$_SERVER["QUERY_STRING"]);
	   }
	   if ($oldQS) {
		   $pageURL .= $oldQS."&".$this->Name."_start=".$startRow;
	   } else {
		   $pageURL .= $this->Name."_start=".$startRow;
	   }
	   return $pageURL;
	}
	
	public function SetSite($site)  {
       $this->SiteSearch = $site;
	}
	
	public function MoveNext()  {
       $this->Index ++;
	   if ($this->Index >= $this->ResultSet->queries->request[0]->count) $this->Index = $this->ResultSet->queries->request[0]->count;
	}
	
	public function MovePrevious() {
	  $this->Index --;
	  if ($this->Index < 0) $this->Index = 0;
	}
	
	public function MoveTo($index) {
	  $this->Index = $index;
	}
	
	public function MoveFirst() {
	  $this->Index = 0;
	}
	
	public function UseCREF($cref) {
	  $this->CREF = $cref;
	  $this->SearchID = "";
	}
	
	public function GetItem() {
	  return (isset($this->Items[$this->Index])?$this->Items[$this->Index]:false);
	  /*
	  kind
      title
      htmlTitle
      link
	  displayLink
	  snippet
	  htmlSnippet
	  cacheId
	  formattedUrl
	  htmlFormattedUrl
	  pagemap=>
        cse_image[0]=>
            src
        cse_thumbnail[0]=>
            width
			height
			src
	  */
	}
}
?>