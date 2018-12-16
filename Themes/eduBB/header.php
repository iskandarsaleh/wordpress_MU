<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php bb_language_attributes( '1.1' ); ?>>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php bb_title() ?></title>
<?php bb_feed_head(); ?>
<link rel="stylesheet" href="<?php bb_stylesheet_uri(); ?>" type="text/css" />

<script type="text/javascript" src="<?php bb_active_theme_uri(); ?>js/quicktags.js"></script>
<script type="text/javascript" src="<?php bb_active_theme_uri(); ?>js/simple-code.php"></script>

<?php bb_head(); ?>

</head>

<body>

<div id="top-header">
<div class="h-content">

<div class="top-h-content">
<div class="site-logo">
<a href="<?php bb_option('uri'); ?>"><img src="<?php bb_active_theme_uri(); ?>images/logo.jpg" alt="edublogs homepage" width="519" height="87" /></a>
</div>
</div>

<div class="bottom-h-content">
<div class="navigation">

<!-- since BBPRESS did not have paged..page can be hardcoded -->
<ul class="pg-nav">
<li id="home"><a href="http://edublogs.org/forums/" title="Edublogs Forums homepage">Forums Home</a></li>
<li><a href="http://edublogs.org/" title="Edublogs.org homepage">Edublogs.org Home</a></li>
<li><a href="http://help.edublogs.org/" title="Our help and support overview area">Help &amp; Support</a></li>
<li><a href="http://edublogs.org/videos/" title="Check out our range of useful videos">Videos</a></li>
<li><a href="http://help.edublogs.org/faq/" title="Frequently Asked Questions">FAQ</a></li>
</ul>
<!-- end -->


</div>
</div>

</div>
</div>

<div id="main-header">
<div id="main-header-content">
<div id="main-header-inner">
<div id="main-header-inner-content">



<h4>Welcome to the Edublogs forums - search, browse or post away!</h4>


<?php login_form(); ?>


</div>
</div>
</div>
</div>

<div id="wraps">
<div id="container">

<?php search_form(); ?>

<div id="eduforum">