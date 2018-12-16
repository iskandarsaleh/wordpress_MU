// Scarlet Blaze Article Tool 
// By: Jose Mulia
// http://www.scarletblaze.com
// Version: 1.1

ns4 = document.layers;
ie = document.all;
moz = document.getElementById && !document.all;
	 
function changeFontSize (id, isIncrease) {
// 1 = increase
// 0 = decrease
var obj;
var size; 

if (ns4) { alert ("Sorry, but NS4 does not allow font changes."); return false;

} else if (ie) { 
 	// tested on ie6
	// the font value is increased/decreased in em;
	obj = document.getElementById(id);
	size = obj.currentStyle.fontSize;
	
	if (isIncrease) { size = parseFloat(size) + .1;	// increase 
	} else { size = parseFloat(size) - .1;  // decrease 
	}  
	obj.style.fontSize = size + "em";

} else if (moz) {
 	// only tested on firefox
 	// The next 2 lines work, but only return font size in px!
 	// So the font value is increased/decreased in px;
	obj = window.getComputedStyle(document.getElementById(id), ''); 
	size = obj.getPropertyValue('font-size');  // value only in px
	
	 if (isIncrease) { size = size = parseFloat(size) + 1; // increase 	
	 } else { size = size = parseFloat(size) - 1; // decrease
	 }

	document.getElementById(id).style['fontSize'] = size + "px";
}

if (!obj) { alert("unrecognized ID"); return false; }
   
return true;
}

function changeAlignment (id, alignment) {
// align: "right", "left", "justify"	
var obj;

if (ns4) { alert ("Sorry, but NS4 does not allow alignment change."); return false;

} else if (ie) { 
 	// tested on ie6
	// the font value is increased/decreased in em;
	obj = document.getElementById(id);
	obj.style.textAlign = alignment;

} else if (moz) {
 	// only tested on firefox
	obj = window.getComputedStyle(document.getElementById(id), ''); 
	document.getElementById(id).style['textAlign'] = alignment;
}

if (!obj) { alert("unrecognized ID"); return false; }
  
return true;
}

function Bookmark(docUrl, docTitle) {
	if(document.all) 
	{
		window.external.AddFavorite(docUrl, docTitle);
	}
	else
	{
		alert ("I'm sorry.  Your browser: "+navigator.appName+" "+navigator.appVersion+ "\n doesn't support automatic bookmarking.\n  You have to manually bookmark this page.");
	}
}

function toPrint() {
	window.print();
}