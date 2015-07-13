var last_ajax_container = "";
var pluginxmlHttp = new Array();  // object, inProgress, startPage, lastContent, lastContainer

var silent_form = false;
function silent_submit(form,onsuccess,url,synch)  {
  if (silent_form)  silent_form[0].abort();
  silent_form = new Array();
  try
  {
  // Firefox, Opera 8.0+, Safari
  silent_form[0]=new XMLHttpRequest();
  }
  catch (e)
  {
  // Internet Explorer
  try
	{
	silent_form[0]=new ActiveXObject("Msxml2.XMLHTTP");
	}
  catch (e)
	{
	try
	  {
	  silent_form[0]=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	catch (e)
	  {
	  return false;
	  }
	}
  }
  silent_form[0].onreadystatechange=function() {
    if(silent_form[0].readyState==4)  {
	   silent_form[1] = silent_form[0].responseText;
	   if (onsuccess) {
		   onsuccess();
	   }
	   if (window.WADFP_jQuery) {
		   WADFP_jQuery.unblockUI();
	   }
	   if (window.WADFP_jQuery) {
		   setTimeout("window.WADFP_jQuery.unblockUI()",800);
	   }
	}
  }
  var getparams = "";
  var postparams = "";
  var postmethod = "GET";
  var formAction = false;
  if (form) {
	getparams = getParamsFromForm(form);
    if (form.getAttribute("method") && form.getAttribute("method").toLowerCase() == "post")  {
      postparams = getparams;
	  getparams = "";
	  postmethod = "POST";
    }
    formAction = form.getAttribute("action");
  }
  if (url) formAction = url;
  if (!formAction) formAction = document.location.href;
  silent_form[0].open(postmethod,formAction+((getparams)?(formAction.indexOf("?")>0?"&":"?")+getparams:""),!synch);
  if (postmethod == "POST") {
      silent_form[0].setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  }
  silent_form[0].send(postparams);
}

function framework_ajax_plugin(form,plugin,div,framework_folder,append,on_success_start,on_success_end)  {
  var pluginRef = div;
  last_ajax_container = div;
  if (!pluginxmlHttp[pluginRef]) {
	pluginxmlHttp[pluginRef] = new Array(false,false,0,"","");
	try
	{
	// Firefox, Opera 8.0+, Safari
	pluginxmlHttp[pluginRef][0]=new XMLHttpRequest();
	}
	catch (e)
	{
	// Internet Explorer
	try
	  {
	  pluginxmlHttp[pluginRef][0]=new ActiveXObject("Msxml2.XMLHTTP");
	  }
	catch (e)
	  {
	  try
		{
		pluginxmlHttp[pluginRef][0]=new ActiveXObject("Microsoft.XMLHTTP");
		}
	  catch (e)
		{
		return false;
		}
	  }
	}
  }
  pluginxmlHttp[pluginRef][0].abort();
  pluginxmlHttp[pluginRef][0].onreadystatechange=function() {
    if(pluginxmlHttp[pluginRef][0].readyState==4)  {
	   pluginxmlHttp[pluginRef][3] = pluginxmlHttp[pluginRef][0].responseText;
	   if (on_success_start) {
		   on_success_start();
	   }
	   pluginxmlHttp[pluginRef][4] = div;
	   setInner(div,pluginxmlHttp[pluginRef][0].responseText,append);
	   pluginxmlHttp[pluginRef][2][1] = true;
	   pluginxmlHttp[pluginRef][1] = false;
	   if (on_success_end) {
		   on_success_end();
	   }
	   if (window.WADFP_jQuery) {
		   setTimeout("window.WADFP_jQuery.unblockUI()",800);
	   }
	 }
  }
  var getparams = "";
  var postparams = "";
  var postmethod = "GET";
  if (form) {
	getparams = getParamsFromForm(form);
    if (form.getAttribute("method") && form.getAttribute("method").toLowerCase() == "post")  {
      postparams = getparams;
	  getparams = "";
	  postmethod = "POST";
    }
  }
  var fromPage = document.location.href;
  if (document.getElementsByTagName('base') && document.getElementsByTagName('base')[0]) {
	 fromPage =  document.getElementsByTagName('base')[0].getAttribute("href");
  }
  if (fromPage.indexOf("#") > 0) fromPage = fromPage.substring(0,fromPage.indexOf("#"));
  pluginxmlHttp[pluginRef][0].open(postmethod,(framework_folder?framework_folder:"") + "webassist/framework/ajax_wrapper.php?plugin_from="+escape(fromPage)+"&plugin_file="+escape(plugin)+((getparams)?"&"+getparams:""),true);
  if (postmethod == "POST") {
      pluginxmlHttp[pluginRef][0].setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  }
  pluginxmlHttp[pluginRef][1] = true;
  pluginxmlHttp[pluginRef][0].send(postparams);
}

function setInner(div,inner,append)  {
  var insertTo = document.getElementById(div);
  if (!insertTo) alert(div + " could not be found.  Please use the feedback link to report this error.");
  if (insertTo.tagName.toLowerCase() == "table")  {
	if (!append) {
		while( insertTo.hasChildNodes() ){
    		insertTo.removeChild(insertTo.lastChild);
		}
	}
	addRowsFromString(inner,insertTo);
  } else  {
	   if (append)  {
		   document.getElementById(div).innerHTML += inner;
	   } else {
		   document.getElementById(div).innerHTML = inner;
	   }
  }
}

function addRowsFromString(inner,insertTo,pos)  {
	var RowStart = inner.match(/<tr[^>]*>/i);
	var startPos = insertTo.rows.length;
	if (pos) startPos = pos;
	while (RowStart)  {
		var inner = inner.substring(inner.indexOf(RowStart[0]));
		var RowEnd = inner.match(/<\/tr/i);
		var CurRow = inner.substring(0,inner.indexOf(RowEnd[0]));
		inner = inner.substring(CurRow.length);
		addRowFromString(CurRow,insertTo,startPos);
		startPos++;
		RowStart = inner.match(/<tr[^>]*>/i);
	}
}

function addRowFromString(CurRow,insertTo,pos)  {
  var RowTag = CurRow.match(/<tr[^>]*>/i);
  if (RowTag)  {
	var RowClassName = RowTag[0].match(/ class=['"]([^'"]*)["']/i);
	var RowStyleName = RowTag[0].match(/ style=["]([^"]*)["]/i);
	var RowIDName = RowTag[0].match(/ id=["]([^"]*)["]/i);
	var CellStart = CurRow.match(/<t[hd][^>]*>/i);
	var NewRow = insertTo.insertRow(pos);
	if (RowClassName) NewRow.setAttribute("class",RowClassName[1]);
	if (RowStyleName) NewRow.setAttribute("style",RowStyleName[1]);
	if (RowIDName) NewRow.setAttribute("id",RowIDName[1]);
	var CellPos = 0;
	while (CellStart)  {
	  CurRow = CurRow.substring(CurRow.indexOf(CellStart[0]));
	  var CellClassName = CellStart[0].match(/ class=['"]([^'"]*)["']/i);
	  var CellColSpan = CellStart[0].match(/ colspan=['"]([^'"]*)["']/i);
	  var CellStyle = CellStart[0].match(/ style=["]([^"]*)["]/i);
	  var CellWidth = CellStart[0].match(/ width=["]([^"]*)["]/i);
	  var CellAlign = CellStart[0].match(/ align=["]([^"]*)["]/i);
	  CellEnd = CurRow.match(/<\/t[dh]/i);
	  CurCell = CurRow.substring(0,CurRow.indexOf(CellEnd[0]));
	  if (CellStart[0].search(/<th/i) >= 0)  {
		NewCell = document.createElement("th");
		NewRow.appendChild(NewCell);
	  } else {
		NewCell = NewRow.insertCell(CellPos);
	  }
	  CellPos++;
	  if (CellColSpan) NewCell.setAttribute("colspan",CellColSpan[1]);
	  if (CellClassName) NewCell.setAttribute("class",CellClassName[1]);
	  if (CellStyle) NewCell.setAttribute("style",CellStyle[1]);
	  if (CellWidth) NewCell.setAttribute("width",CellWidth[1]);
	  if (CellAlign) NewCell.setAttribute("align",CellAlign[1]);
	  NewCell.innerHTML=CurCell.substring(CurCell.indexOf(">")+1);
	  CurRow = CurRow.substring(CurCell.length);
	  CellStart = CurRow.match(/<t[hd][^>]*>/i);
	}
  }
}
	
function getParamsFromForm(form)  {
  var retval = "";
  for(var i=0; i<form.elements.length; i++)  {
	var field = form.elements[i];
	var fieldName = field.getAttribute("name");
	var fieldVal = "";
	if (fieldName)  {
	  if (field.tagName.toLowerCase() == "input")  {
		  var fieldType = "text";
		  if (field.getAttribute("type")) fieldType = field.getAttribute("type").toLowerCase();
		  if (fieldType == "text" || fieldType == "hidden" || fieldType == "submit")  {
			  fieldVal = field.value;
		  } else if (fieldType == "checkbox" || fieldType == "radio") {
			  if (!field.checked) continue;
			  fieldVal = field.value;
		  } else if (fieldType == "image") {
			  fieldName+= "_x=1&" + fieldName +"_y";
			  fieldVal = "1";
		  }
	  }
	  if (field.tagName.toLowerCase() == "select")  {
		  for (var x=0; x<field.options.length; x++)  {
		    if (field.options[x].selected) {
				if (fieldVal != "")  {
				  fieldName += "=" + escape(fieldVal) + "&" + field.getAttribute("name");
				}
			    fieldVal = field.options[field.selectedIndex].value;
			}
		  }
	  }
	  if (field.tagName.toLowerCase() == "textarea")  {
		  fieldVal = field.value;
	  }
	  retval += ((retval=="")?"":"&") + fieldName + "=" + encodeURIComponent(fieldVal);
	}
  }
  return retval;
}

function findPos(obj) {
	var curleft = curtop = 0;
	if (obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
	return [curleft,curtop];
}

function loadNextIfShowing(plugin,plugindiv,relpath,onreturn,oncomplete)  {
	if (!pluginxmlHttp[plugindiv]) {
	  pluginxmlHttp[plugindiv] = new Array(false,false,0,"","");
	}
	if (!pluginxmlHttp[plugindiv][1] && document.getElementById("infinite_processing"))  {
	  pluginxmlHttp[plugindiv][1] = true;
	  var theScroll = window.scrollY;
	  if (!theScroll) theScroll = document.body.parentNode.scrollTop;
	  if (!theScroll) theScroll = document.body.scrollTop;
      if (!theScroll) theScroll = 0;
	  var pageBottom = theScroll + window.outerHeight;
	  var table = document.getElementById(plugindiv);
	  var tableBottom =  findPos(table)[1] + table.offsetHeight;
	  if (pageBottom >= tableBottom)  {
		pluginxmlHttp[plugindiv][1] = true;
		
		if (!pluginxmlHttp[plugindiv][2]) pluginxmlHttp[plugindiv][2] = new Array(0,true);
		var theCount = pluginxmlHttp[plugindiv][2][0];
		var theComplete = pluginxmlHttp[plugindiv][2][1];
		if (theComplete) {
		  theCount++;
		  pluginxmlHttp[plugindiv][2] = new Array(theCount,false);
		}
		framework_ajax_plugin(false,plugin+theCount,plugindiv,relpath,true,onreturn,oncomplete);
	  } else {
		pluginxmlHttp[plugindiv][1] = false;  
	  }
	}
}

function removeElementById(elementId,div) {
  element = document.getElementById(elementId);
  if (!element) return;
  element.parentNode.removeChild(element);
  if (window.pluginxmlHttp && pluginxmlHttp[div]) pluginxmlHttp[div][1] = false;
}

function wa_addEvent(element, evnt, funct){
  if (element.attachEvent)
   return element.attachEvent('on'+evnt, funct);
  else
   return element.addEventListener(evnt, funct, false);
}

function wa_removeEvent(element, evnt, funct){
  if (element.detachEvent)
   return element.detachEvent('on'+evnt, funct);
  else
   return element.removeEventListener(evnt, funct, false);
}

function wa_removeElementById(elementId,div) {
  element = document.getElementById(elementId);
  element.parentNode.removeChild(element);
}