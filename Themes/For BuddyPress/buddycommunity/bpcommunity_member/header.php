<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bp_page_title() ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />


<?php
$get_current_scheme = get_option('tn_buddycom_custom_style');
$current_theme = strtolower(get_current_theme());
$site_directory = get_bloginfo('url');
$get_theme_option_dir = $site_directory . "/wp-content/themes/" . $current_theme;
?>

<?php

if(($get_current_scheme == '') || ($get_current_scheme == 'default.css')) { ?>
<link rel="stylesheet" href="<?php echo $get_theme_option_dir; ?>/theme-options.php" type="text/css" media="all" />

<?php } else { ?>

<link rel="stylesheet" href="<?php echo $get_theme_option_dir; ?>/styles/<?php echo $get_current_scheme; ?>" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo $get_theme_option_dir; ?>/theme-options-exclude.php" type="text/css" media="all" />

<?php } ?>

<?php if ( function_exists( 'bp_sitewide_activity_feed_link' ) ) : ?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php _e('Site Wide Activity RSS Feed', 'buddypress' ) ?>" href="<?php bp_sitewide_activity_feed_link() ?>" />
<?php endif; ?>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts RSS Feed', 'buddypress' ) ?>" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> <?php _e( 'Blog Posts Atom Feed', 'buddypress' ) ?>" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_head(); ?>

</head>


</head>

<body id="default" class="">

<div id="wrapper">
<div id="container">
<div id="content-main">
<div id="top-header">



<div id="site-title">
<?php
$tn_buddycom_header_logo = get_option('tn_buddycom_header_logo');
if($tn_buddycom_header_logo == '') { ?>
<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
<p><?php bloginfo('description'); ?></p>
<?php } else { ?>
<a href="<?php echo get_settings('home'); ?>" title="Click here to go to the site homepage">
<img src="<?php echo stripslashes($tn_buddycom_header_logo); ?>" alt="<?php bloginfo('name'); ?> homepage" /></a>
<?php } ?>
</div>



<div id="buddynav">

<div class="wp-page">
<ul class="wpnv">
<?php wp_list_pages('title_li=&depth=1'); ?>
</ul>
</div>


<ul class="pagenav">
<li<?php if ( is_home()) { ?> class="selected"<?php } ?>><a href="<?php echo get_option('home') ?>" title="<?php _e( 'Home', 'buddypress' ) ?>"><?php _e( 'Home', 'buddypress' ) ?></a></li>
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


<div id="searchbox">
<?php bp_search_form() ?>

<?php if (!is_user_logged_in() ) { ?>
<?php bp_login_bar() ?>
<?php } ?>

</div>


<?php include (TEMPLATEPATH . '/call-signup.php'); ?>


<div id="content">

<div id="post-entry">

<div id="member-content" class="member-class">