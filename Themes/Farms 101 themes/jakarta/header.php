<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php _e('Blog Archive');?> <?php } ?> <?php wp_title(); ?></title>

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_get_archives('type=monthly&format=link'); ?>

	<?php wp_head(); ?>
	<script language="javascript" src="<?php bloginfo('stylesheet_directory'); ?>/sb.js"></script>

</head>
<body>

<div id="page">
<div id="header">
<div id="toolbar-top">
<h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
		<div class="description"><?php bloginfo('description'); ?></div>
		</div>
	
		<div id="toolbar-right">
		<a href="#" class="tooltip" onClick="changeFontSize('content', 1); return false;"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/ibigger.jpg" alt="Bigger"/><span>Bigger Font Size</span></a>
		<a href="#" class="tooltip" onClick="changeFontSize('content', 0); return false;"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/ismaller.jpg" alt="Smaller"/><span>Smaller Font Size</span></a>
		<a href="#" class="tooltip" onClick="changeAlignment('content', 'left'); return false;"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/ileft.jpg" alt="Left Align"/><span>Left Align</span></a>
		<a href="#" class="tooltip" onClick="changeAlignment('content', 'justify'); return false;"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/ijustify.jpg" alt="Justify"/><span>Justify Align</span></a>
		<a href="#" class="tooltip" onClick="changeAlignment('content', 'right'); return false;"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/iright.jpg" alt="Right Align"/><span>Right Align</span></a>
		<a href="#" class="tooltip" onClick="Bookmark(window.document.location,window.document.title); return false;"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/ibookmark.jpg" alt="Bookmark"/><span>Bookmark This Page</span></a>
		<a href="#" class="tooltip" onClick="toPrint(); return false;"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/iprint.jpg" alt="Print"/><span>Print This Page</span></a>
		</div>
</div>
<hr />
