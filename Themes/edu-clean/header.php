<?php include (TEMPLATEPATH . '/options.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
<?php
if (is_home()) { echo bloginfo('name'); }
elseif (is_404()) { bloginfo('name'); echo ' - Oops, this is a 404 page'; }
else if ( is_search() ) { bloginfo('name'); echo (' - Search Results');}
else { bloginfo('name'); echo (' - '); wp_title(''); }
?>
</title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/wp-comments.css" type="text/css" />

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/tabber.css" type="text/css" />

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/theme-options.php" type="text/css" />


<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="icon" href="<?php bloginfo('stylesheet_directory');?>/favicon.ico" type="images/x-icon" />



<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/tabber.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/quicktags.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/simple-code.php"></script>


<script type="text/javascript">
/*
Optional: Temporarily hide the "tabber" class so it does not "flash" on the page as plain HTML.
After tabber runs, the class is changed to "tabberlive" and it will appear. this code will cause
invalid xhtml in code but it is necessary for optimal perfomance
*/
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
</script>


<!--[if IE 6]>
<style type="text/css">
#list-benefits ul li, .site-logo img {
behavior: url(<?php bloginfo('template_directory'); ?>/js/iepngfix.htc);
}
</style>
<![endif]-->


<?php remove_action( 'wp_head', 'wp_generator' ); ?>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>


</head>

<body id="edubody">

<div id="top-header">
<div class="h-content">

<div class="top-h-content">
<div class="site-logo">

<?php if($tn_edus_header_logo == ""){ ?>
<h1><a href="<?php echo get_settings('home'); ?>" title="Click here to go to the site homepage"><?php bloginfo('name'); ?></a></h1>
<?php } else { ?>
<a href="<?php echo get_settings('home'); ?>" title="Click here to go to the site homepage">
<img src="<?php echo stripslashes($tn_edus_header_logo); ?>" alt="edublogs homepage" /></a>
<?php } ?>

</div>

<div class="site-stats"><span>Currently powering <?php
$stats = get_sitestats();
$tmp_user_count = number_format ($stats[ 'users' ] );
$tmp_blog_count = number_format ($stats[ 'blogs' ] );
print "<strong>" . $tmp_blog_count . " blogs" . "</strong>";
;?></span></div>


</div>

<div class="bottom-h-content">
<div class="navigation">

<ul class="pg-nav">
<li id="<?php if (is_home() || is_single() && str_replace("/","",$_SERVER['REQUEST_URI']) != 'wp-signup.php') { ?>home<?php } else { ?>page_item<?php } ?>"><a href="<?php bloginfo('url'); ?>" title="The homepage">Home</a></li>
<?php wp_list_pages('title_li=&depth=1'); ?>
<li><a href="<?php bloginfo('url'); ?>/forums" title="Get help and support " target="_blank">Forums</a></li>

</ul>

</div>
</div>

</div>
</div>

<?php
if (is_home() && str_replace("/","",$_SERVER['REQUEST_URI']) != 'wp-signup.php'){
?>

<div id="main-header">
<div id="main-header-content">
<div id="main-header-inner">
<div id="main-header-inner-content">
<h4><?php echo stripslashes($tn_edus_header_text); ?></h4>
<br /><br />
<div id="intro-log">
<div id="list-benefits">
<?php echo stripslashes($tn_edus_header_listing); ?>
</div>


<div id="intro-package">
<div id="edublog-free"><h3>Get started in seconds for free</h3><p><a href="<?php bloginfo('url'); ?>/wp-signup.php" title="Get yourself a free blog">Join Here!</a></p></div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php
} else {
?>

<div id="main-header">
<div id="main-header-content">
<div id="main-header-inner">
<div id="main-header-inner-content">
<h4><?php echo stripslashes($tn_edus_header_text); ?></h4>

</div>
</div>
</div>
</div>

<?php
}
?>

<div id="wraps">
<div id="container">