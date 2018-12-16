

function createCookie(name,value,days)
{
	if (days)
	{
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name)
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function init() 
{
	var search = document.getElementById('s');
    if( search ) {
		search.onfocus = focusS;
		search.onblur = blurS;
	}
}

function focusS() {
if (this.value == search_phrase) { this.value = ''; }
document.getElementById('label').innerHTML = search_label;
}

function blurS() {
document.getElementById('label').innerHTML = "";
if (this.value == '') { this.value = search_phrase; }
}

function changebackground(button, number) 
{
    createCookie('vl_wallpaper',number,7000);
	var wallpaper = number;
	if( number == -1 )
	{
		wallpaper = (Math.round(Math.random() * vl_wallpaper_count)-2);
		if( wallpaper >= vl_wallpaper_current )
			++wallpaper;
		if( wallpaper < 0 )
			wallpaper += vl_wallpaper_count;
		else if( wallpaper >= vl_wallpaper_count )
			wallpaper -= vl_wallpaper_count;
		//button.className="loading";
	}
	current_thumb = document.getElementById( 'thumbnail' + vl_wallpaper_current );
	if( current_thumb )
		current_thumb.className = "";
	vl_wallpaper_current = number;
	button.firstChild.className = "selected";
    document.body.id ='wallpaper' + wallpaper;
}

window.onload = init;
