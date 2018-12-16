<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>



<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />



<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php _e('Blog Archive');?> <?php } ?> <?php wp_title(); ?></title>




<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/fonts.php" type="text/css" media="screen" />
<!--[if !IE]>deleted this if you want the indexing for archives<![endif]-->
<?php if(is_archive()) { ?><meta name="robots" content="noindex"><?php } ?>
<!--[if !IE]>seo goodies only<![endif]-->

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />



<?php wp_get_archives('type=monthly&format=link'); ?>
<?php wp_head(); ?>

<script src="<?php bloginfo('stylesheet_directory');?>/js/jquery.js" type="text/javascript"></script>
<script src="<?php bloginfo('stylesheet_directory'); ?>/js/cycle.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
$('#header_center').cycle({
    fx:    'fade',
	speed:    3000,
    timeout:  4000,
	pause: 0

 });
 });

</script>

</head>



<body>

<div id="wrap">




<div id="page">

<?php include (TEMPLATEPATH . '/options.php'); ?>

<div id="header">

<div id="header_top"></div> 

<div id="header-navigation">
<ul class="nav">
<li id="<?php if (is_home()) { ?>home<?php } else { ?>page_item<?php } ?>"><a href="<?php bloginfo('url'); ?>" title="Home">Home</a></li>
<?php wp_list_pages('title_li=&depth=1'); ?>
</ul>
</div>




<div id="header-custom">

<?php $show_image_rotate = "$oc_ow_image_rotate_status"; ?>
<?php if($show_image_rotate==yes): ?>

<div id="header_center">
<?php include (TEMPLATEPATH . '/rotate.php'); ?>
</div>

<?php else: ?>

<div id="header_center_original">


<?php $show_header_title = "$oc_ow_titlename_status"; ?>
<?php if($show_header_title==yes): ?>

<?php $show_image_rotate = "$oc_ow_image_rotate_status"; ?>
<?php if($show_image_rotate==no): ?>
<div id="header-sitename">
<h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
<p><?php bloginfo('description'); ?></p>
</div>
<?php endif; ?>

<?php endif; ?>  

<img src="<?php header_image(); ?>" alt="this is a header image" />



</div>
<?php endif; ?>



</div>




    
</div>




<div id="header_end">

<?php $show_image_rotate = "$oc_ow_image_rotate_status"; ?>
<?php if($show_image_rotate==yes): ?>
<div id="header-sitetitle">
<h1><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></h1>
<p><?php bloginfo('description'); ?></p>
</div>
<?php endif; ?>


		<div id="menu_search_box">

			<form method="get" id="searchform" style="display:inline;" action="<?php bloginfo('home'); ?>/">

			<span>Search:&nbsp;</span>

			<input type="text" class="s" value="<?php the_search_query(); ?>" name="s" id="s" />&nbsp;

			<input type="image" src="<?php bloginfo('stylesheet_directory'); ?>/images/go.gif" value="Submit" class="sub"   />

			</form>

		</div>

	</div>



<div id="blog">

	<div id="blog_left">

		<?php get_sidebar(); ?>

	</div>

	<div id="blog_center">

