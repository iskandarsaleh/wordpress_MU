<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php //comments_popup_script(); // off by default ?>
<?php wp_head(); ?>
</head>
<body>
<div id="body-container">
<div id="header">
<h1><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><span><?php bloginfo('name'); ?></span></a></h1>
<div id="feed">
<ul class="feed">
<li><a href="<?php bloginfo('rss_url'); ?>" title="Entries Feed">Entries RSS</a></li>
<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="Comments Feed">Comments RSS</a></li>
</ul>
</div><!-- feed -->
</div><!-- header -->

<div id="top-nav">
<?php include (TEMPLATEPATH . '/top-nav.php'); ?>
</div>

<div id="container">
<div id="content">

<!-- END HEADER.PHP -->