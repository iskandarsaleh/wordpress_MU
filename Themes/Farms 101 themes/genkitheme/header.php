<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php if (wp_version()=='21') language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php _e('Blog Archive');?> <?php } ?> <?php wp_title(); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
</head>

<body>

<!-- 
show static sidetab if javascript is off.
edit line 15 in footer.php for the scrolling sidetab
-->
<noscript>
<div id="sidetab" style="left:5px;position:absolute;top: 15px;">
    <ul id="navlist">
    <li><a href="<?php bloginfo('home'); ?>" title="Home"><img onMouseOver="this.style.src='contact_on.gif'" src="<?php bloginfo('template_url') ?>/images/home.gif" width="25" height="60" /></a></li>
  
    <li class="sidetab_alt"><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to Feed"><img src="<?php bloginfo('template_url') ?>/images/blank.gif" width="25" height="25" /></a></li>
    </ul>
</div>
</noscript>

<div id="wrap">