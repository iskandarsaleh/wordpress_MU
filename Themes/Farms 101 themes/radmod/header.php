<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />

	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php wp_head(); ?>

<?php
    /*
    You can uncomment the below lines, which will give you a function to call for
    a comment preview IF you're not using the Live Preview: Admin Panel, Comments
    plug-in by Chris Davis, on which the code is based but modified from for my purposes
    Also, you'll need to uncomment a bunch of stuff in comments.php
    */
    // $javascript = "<script type=\"text/javascript\">\n<!--\nfunction ReloadTextDiv()\n{\nvar NewText = document.getElementById(\"comment\").value;\nsplitText = NewText.split(/\\n/).join(\"<br />\");\nvar DivElement = document.getElementById(\"TextDisplay\");\nDivElement.innerHTML = splitText;\n}\n//-->\n</script>\n";
    // echo $javascript;
?>
<script language="JavaScript" type="text/javascript">
<!--
// this is to open photo galleries
function openGallery(url) {
 window.open(url,'gallery','width=640,height=480, screenX=100,screenY=100,top=100,left=100,menubar=no,scrollbars=yes,resizable=yes,status=no,toolbar=no,location=no');
}
//-->
</script>

<?php /*
You can uncomment these two lines to enable buttons quicktags on the comment form
IF you're not using Owen Winkler's quicktags plugin <http://www.asymptomatic.net/wp-hacks>,
on which the buttons.js code is based, but slightly modified from

ob_start();
get_template_directory_uri();
$temp = ob_get_contents();
ob_end_clean();

print(
	 '<script src="'.get_settings('siteurl').'/wp-admin/quicktags.js" type="text/javascript"></script>'."\n"
	.'<script src="'.$temp.'/buttons.js" type="text/javascript"></script>'."\n"
);
*/ ?>

</head>

<?php
// if you want to insert line breaks between words in the blog's title...
// doing this means you're going to have to adjust the #header field
// in style.css
//$wpTitle = get_settings('blogname');
//$formatedWpTitle = str_replace(' ','<br />',$wpTitle)

// if you don't want line breaks in your title, comment out the above two lines
// and uncomment this line
$formatedWpTitle = get_settings('blogname');
?>

<body>
<h1 id="header"><a href="<?php bloginfo('url'); ?>"><?php echo $formatedWpTitle ?></a></h1>