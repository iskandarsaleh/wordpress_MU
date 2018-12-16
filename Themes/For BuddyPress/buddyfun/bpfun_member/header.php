<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bp_page_title() ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->


<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<?php
$current_theme = strtolower(get_current_theme());
$site_directory = get_bloginfo('url');
$get_theme_option_dir = $site_directory . "/wp-content/themes/" . $current_theme;
?>


<?php if($current_theme == 'buddypress-fun') { ?>
<link rel="stylesheet" href="<?php echo $get_theme_option_dir; ?>/theme-options.php" type="text/css" media="all" />
<?php } ?>


<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

</head>

<body>

<div id="wrapper">

<div id="container">

<div id="top-header">

<div class="top-h">
<div class="site-title">
<?php
$tn_buddyfun_header_logo = get_option('tn_buddyfun_header_logo');
if($tn_buddyfun_header_logo == '') { ?>
<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
<p><?php bloginfo('description'); ?></p>
<?php } else { ?>
<a href="<?php echo get_settings('home'); ?>" title="Click here to go to the site homepage">
<img src="<?php echo stripslashes($tn_buddyfun_header_logo); ?>" alt="edublogs homepage" /></a>
<?php } ?>

</div>


<div class="header-nav">
<ul class="pagenav">
<li<?php if ( bp_is_page( BP_HOME_BLOG_SLUG ) ) {?> class="selected"<?php } ?>><a href="<?php echo get_option('home') ?>/<?php echo BP_HOME_BLOG_SLUG ?>" title="<?php _e( 'Blog', 'buddypress' ) ?>"><?php _e( 'Blog', 'buddypress' ) ?></a></li>
<li<?php if ( bp_is_page( BP_MEMBERS_SLUG ) ) {?> class="selected"<?php } ?>><a href="<?php echo get_option('home') ?>/<?php echo BP_MEMBERS_SLUG ?>" title="<?php _e( 'Members', 'buddypress' ) ?>"><?php _e( 'Members', 'buddypress' ) ?></a></li>
<?php if ( function_exists( 'groups_install' ) ) { ?>
<li<?php if ( bp_is_page( BP_GROUPS_SLUG ) ) {?> class="selected"<?php } ?>><a href="<?php echo get_option('home') ?>/<?php echo BP_GROUPS_SLUG ?>" title="<?php _e( 'Groups', 'buddypress' ) ?>"><?php _e( 'Groups', 'buddypress' ) ?></a></li>
<?php } ?>
<?php if ( function_exists( 'bp_blogs_install' ) ) { ?>
<li<?php if ( bp_is_page( BP_BLOGS_SLUG ) ) {?> class="selected"<?php } ?>><a href="<?php echo get_option('home') ?>/<?php echo BP_BLOGS_SLUG ?>" title="<?php _e( 'Blogs', 'buddypress' ) ?>"><?php _e( 'Blogs', 'buddypress' ) ?></a></li>
<?php } ?>
<?php do_action( 'bp_nav_items' ); ?>
</ul>
</div>


</div>

<div class="navigation">
<ul>
<li<?php if ( is_home()) { ?> class="selected"<?php } ?>><a href="<?php echo get_option('home') ?>" title="<?php _e( 'Home', 'buddypress' ) ?>"><?php _e( 'Home', 'buddypress' ) ?></a></li>
<?php wp_list_pages('title_li=&depth=1'); ?>
</ul>
</div>


</div>


<?php
$tn_buddyfun_header_on = get_option('tn_buddyfun_header_on');
if($tn_buddyfun_header_on == 'enable') { ?>
<div id="header">
<div class="custom-img-header"><img src="<?php header_image(); ?>" alt="<?php bloginfo('name'); ?>" /></div>
</div>
<?php } ?>


<?php
$tn_buddyfun_call_signup_on = get_option('tn_buddyfun_call_signup_on');
?>

<?php if($tn_buddyfun_call_signup_on != ""){ ?>
<?php } else { ?>
<?php include (TEMPLATEPATH . '/call-signup.php'); ?>
<?php } ?>


<?php load_template ( TEMPLATEPATH . '/userbar.php' ) ?>


<div id="content">

<?php load_template( TEMPLATEPATH . '/left-box.php' ) ?>

<div class="member-entry" id="post-entry">