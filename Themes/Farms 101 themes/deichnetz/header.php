<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
<style type="text/css" media="screen">@import url( <?php bloginfo('stylesheet_url'); ?> );</style>
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php //comments_popup_script(); // off by default ?>
<?php wp_head(); ?>
</head>

<body>
<div id="all">
<div id="menu"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860nocolor"); } ?>
<ul id="navlist">
<?php wp_list_pages('title_li='); ?>
</ul>
</div><!-- menu -->

<div id="topper"><a href="<?php echo get_settings('siteurl'); ?>/wp-login.php"><?php _e('&nbsp;&nbsp;'); ?>
</a>
</div>
<div id="rap">

<h1 id="header"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>

<div id="searchbox">
<div id="searchfield">
<form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="text" name="s" id="s" size="20" />
<input class="such" type="submit" value="<?php _e('search'); ?>" />
</form>
</div><!-- searchfield -->
</div><!-- searchbox -->


<div id="content">
<!-- end header -->
