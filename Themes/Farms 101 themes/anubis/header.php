<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title>
<?php if ( function_exists('optimal_title') ) { optimal_title('|'); bloginfo('name'); } else { bloginfo('name'); wp_title('|'); } ?>
<?php if ( is_home() ) { ?> | <?php bloginfo('description'); } ?>
</title>

<!-- leave this for stats -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body>
<div id="top">
<div id="pager"><img src="<?php header_image() ?>" width="970" height="150" alt="" />
  <div id="headr">
    <h1><a href="<?php echo get_option('home'); ?>/">
      <?php bloginfo('name'); ?>
      </a></h1>
<div class="description">
     <?php bloginfo('description'); ?>
</div>
    </div>
</div>
</div>
<hr />
<div id="page">