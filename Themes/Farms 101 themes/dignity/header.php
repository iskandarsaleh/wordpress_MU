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

<style type="text/css">

 /*
  USAGE: All you have to do is include this one line in your CSS file, with the
  tag names to which you want the script applied:
 */

 img, div { behavior: url(<?php bloginfo('template_directory'); ?>/images/fix/iepngfix.htc) }

 /*
  Alternatively, you can specify that this will apply to all tags like so:
   * { behavior: url(<?php bloginfo('template_directory'); ?>/images/fix/iepngfix.htc) }
 */

 </style>

 <script type="text/javascript">
 //<![CDATA[

 // If you don't want to put unstandard properties in your stylesheet, here's yet
 // another means of activating the script. This assumes that you have at least one
 // stylesheet included already. Remove the /* and */ lines to activate.

 /*
 if (document.all && document.styleSheets && document.styleSheets[0] &&
  document.styleSheets[0].addRule)
 {
  // Feel free to add rules for specific tags only, you just have to call it several times.
  document.styleSheets[0].addRule('*', 'behavior: url(<?php bloginfo('template_directory'); ?>/images/fix/iepngfix.htc)');
 }
 */

 //]]>
 </script>

</head>
<body>
<div id="top"></div>
<div id="page">
<div id="pages">
<div class="p1">
<h1><a href="<?php echo get_option('home'); ?>/">
      <?php bloginfo('name'); ?></h1>
</div>
<div id="navr">
  <ul class="menu">
 <li <?php if(is_home()){echo 'class="current_page_item"';} else { echo 'class="page_item"'; } ?>><a href="<?php bloginfo('siteurl'); ?>/" title="Home">Home</a></li>
    <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
	<?php wp_register('<li class="admintab">','</li>'); ?>
	</ul>
</div>
</div>
<div id="pager">
<div class="p2">
      <?php bloginfo('description'); ?>
</div>
<div class="pix">
</div>
</div>
<hr />
<div id="wrapr">
