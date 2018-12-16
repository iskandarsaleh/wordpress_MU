// added this function because the function in quicktags.js
// puts "close tags" and "dictionary" buttons on the bar I find
// to be unnecessary
function edToolbar2() {
	document.write('<div id="ed_toolbar">');
	for (i = 0; i < edButtons.length; i++) {
		edShowButton(edButtons[i], i);
	}
	document.write('</div>');
}

var edButtons = new Array();

edButtons[edButtons.length] = 
new edButton('ed_strong'
,'B'
,'<strong>'
,'</strong>'
,'b'
);

edButtons[edButtons.length] = 
new edButton('ed_em'
,'I'
,'<em>'
,'</em>'
,'i'
);

edButtons[edButtons.length] = 
new edButton('ed_link'
,'link'
,''
,'</a>'
,'a'
); // special case

edButtons[edButtons.length] = 
new edButton('ed_block'
,'blockquote'
,'<blockquote>'
,'</blockquote>'
,'q'
);
