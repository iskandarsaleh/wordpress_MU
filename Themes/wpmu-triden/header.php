<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
<?php
if (is_home()) { echo bloginfo('name'); echo (' - '); bloginfo('description');}
elseif (is_404()) { bloginfo('name'); echo ' - Oops, this is a 404 page'; }
else if ( is_search() ) { bloginfo('name'); echo (' - Search Results');}
else { bloginfo('name'); echo (' - '); wp_title(''); }
?>
</title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/global.css" type="text/css" media="screen" />

<!-- wp 2.8 comment style -->
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/wp-comments.css" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/fonts.php" type="text/css" media="screen" />

<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="icon" href="<?php bloginfo('stylesheet_directory');?>/favicon.ico" type="images/x-icon" />

<?php remove_action( 'wp_head', 'wp_generator' ); ?>
<?php /*wp_get_archives('type=monthly&format=link');*/ ?>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

<script src="<?php bloginfo('template_directory'); ?>/js/drop_down.js" type="text/javascript"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/tabber.js" type="text/javascript"></script>

<script type="text/javascript">
/* Optional: Temporarily hide the "tabber" class so it does not "flash"
   on the page as plain HTML. After tabber runs, the class is changed
   to "tabberlive" and it will appear. */
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>


</head>

<body>
<div id="wrapper">
<div id="container">

<div id="top-header">
<h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
<p><?php bloginfo('description'); ?></p>
</div>

<?php include (TEMPLATEPATH . '/options.php'); ?>

<?php
if(($tn_wpmu_tri_header_on == 'enable') || ($tn_wpmu_tri_header_on  == '')){ ?>
<div id="custom-img-header"><img src="<?php header_image(); ?>" alt="<?php bloginfo('name'); ?>" /></div>
<?php } else { ?>

<!-- something else -->

<?php } ?>


<div id="navigation">
<ul id="nav">
<li><a href="<?php bloginfo('url'); ?>" title="Home">Home</a></li>
<?php wp_list_pages('title_li=&depth=0'); ?>
</ul>
<div class="rss-feeds"><a href="<?php bloginfo('rss2_url'); ?>">RSS Feeds</a></div>
</div>


<div id="content">