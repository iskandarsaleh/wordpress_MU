</div>

<!-- please leave footer links intact -->
<div id="footer">design &raquo; <a href="http://ericulous.com" title="GenkiTheme by Ericulous">ericulous</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</div>

<?php wp_footer(); ?>

<script language="javascript">
if (!document.layers)
document.write('<div id="divStayTopLeft" style="position:absolute">')
</script>

<layer id="divStayTopLeft">

<script language="javascript">
document.write('<div id="sidetab"><ul id="navlist"><li><a href="<?php bloginfo("home"); ?>" title="Home"><img onMouseOver="this.style.src=\'contact_on.gif\'" src="<?php bloginfo("template_url") ?>/images/home.gif" width="25" height="60" /></a></li><li class="sidetab_alt"><a href="<?php bloginfo("rss2_url"); ?>" title="Subscribe to Feed"><img src="<?php bloginfo("template_url") ?>/images/blank.gif" width="25" height="25" /></a></li></ul></div>')
</script>

</layer>


<script type="text/javascript">

/*
Floating Menu script-  Roy Whittle (http://www.javascript-fx.com/)
Script featured on/available at http://www.dynamicdrive.com/
This notice must stay intact for use
*/

//Enter "frombottom" or "fromtop"
var verticalpos="fromtop"

if (!document.layers)
document.write('</div>')

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body;
}

function JSFX_FloatTopDiv()
{
	var startX = 5,
	startY =15;
	var PX='px', d = document;
	function ml(id)
	{
		var el=d.getElementById?d.getElementById(id):d.all?d.all[id]:d.layers[id];
		if(d.layers){el.style=el,PX='';}
		el.sP=function(x,y){el.style.left=x+PX;el.style.top=y+PX;};
		el.x = startX;
		if (verticalpos=="fromtop")
		el.y = startY;
		else{
		el.y = window.innerHeight ? pageYOffset + window.innerHeight : ietruebody().scrollTop + ietruebody().clientHeight;
		el.y -= startY;
		}
		return el;
	}
	window.stayTopLeft=function()
	{
		if (verticalpos=="fromtop"){
		var pY = window.innerHeight ? pageYOffset : ietruebody().scrollTop;
		ftlObj.y += (pY + startY - ftlObj.y)/8;
		}
		else{
		var pY = window.innerHeight ? pageYOffset + window.innerHeight : ietruebody().scrollTop + ietruebody().clientHeight;
		ftlObj.y += (pY - startY - ftlObj.y)/8;
		}
		ftlObj.sP(ftlObj.x, ftlObj.y);
		setTimeout("stayTopLeft()", 10);
	}
	ftlObj = ml("divStayTopLeft");
	stayTopLeft();
}
JSFX_FloatTopDiv();
</script>

</body>
</html>