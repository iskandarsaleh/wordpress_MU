<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Typ!" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php _e('Blog Archive');?> <?php } ?> <?php wp_title(); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style type="text/css" media="screen">

</style>

<?php wp_head(); ?>
</head>
<body id="top">

<div id="container">

<div id="main">
<h1 id="head"><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
<h2 id="tag"><?php bloginfo('description'); ?></h2>
<div style="clear:both;"></div>
<ul id="menu">
    <li><a href="<?php echo get_settings('home'); ?>">Blog</a></li><?php wp_list_pages('sort_column=menu_order&title_li='); ?> 
<li style="float:right"><?php include (TEMPLATEPATH . '/searchform.php'); ?></li>
</ul>
