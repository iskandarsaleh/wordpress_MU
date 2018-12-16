<?php include("pagefunctions.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title>
<?php bloginfo('name'); ?>
<?php wp_title(); ?>
</title>
<link rel="shortcut icon" href="/favicon.ico" >
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php //comments_popup_script(); // off by default ?>
<?php if (is_single() and ('open' == $post-> comment_status) or ('comment' == $post-> comment_type) ) { ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/prototype.js.php"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/effects.js.php"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/ajax_comments.js"></script>
<?php } ?>
<?php if (is_page() and ('open' == $post-> comment_status)) { ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/prototype.js.php"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/effects.js.php"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/ajax_comments.js"></script>
<?php } ?>
<style type="text/css" media="screen">
		<!-- @import url( <?php bloginfo('stylesheet_url'); ?> ); -->
		</style>
<?php wp_head(); ?>
</head>
<body id="home" class="log">
<div id="header">
    <div id="blogname"><a href="<?php bloginfo('siteurl'); ?>"><?php  bloginfo('name'); ?></a> <span class="description"> &nbsp;&nbsp;<?php bloginfo('description'); ?></span><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890graphite"); } ?></div></div>
  <div class="navwidthbg">
<div class="navwidth">
    <ul class="navigation">
      <?php
if (is_home()) {$pg_li .="current_page_item";}
?>
      <li class="<?php echo $pg_li; ?>"><a href="<?php bloginfo('siteurl'); ?>" title="Blog"><span>Blog</span></a></li>
      <?php wp_list_page('depth=1&title_li=&exclude=143&sort_column=menu_order' ); ?>
    </ul>
  </div></div>
<div id="wrap">