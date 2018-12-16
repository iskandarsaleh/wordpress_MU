<?php load_theme_textdomain('contempt');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>
</head>
<body style="background: url(<?php bloginfo('stylesheet_directory'); ?>/images/blue_flower/bg.jpg) repeat-y top center #aaa fixed;">

<div id="page">

<div id="header">
	<div id="headerimg" onclick="location.href='<?php bloginfo('url'); ?>';" style="cursor: pointer;">
		<h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
		<div class="description"><?php bloginfo('description'); ?></div>
	</div>
</div>

<ul id="pagebar" style="background: url(<?php bloginfo('stylesheet_directory'); ?>/images/blue_flower/pagebar.jpg);">
	<?php
		if (is_home()) {$pg_li .="current_page_item";}
	?>
	<li class="page_item <?php echo $pg_li; ?>"><a href="<?php echo get_settings('home'); ?>"><?php _e('Home','contempt'); ?></a></li>
	<?php wp_list_pages('depth=1&title_li='); ?> 
</ul>

<div id="grad" style="height: 65px; width: 100%; background: url(<?php bloginfo('stylesheet_directory'); ?>/images/blue_flower/topgrad.jpg);">&nbsp;</div>