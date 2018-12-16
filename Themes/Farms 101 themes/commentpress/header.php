<?php /*if($_GET['function']){ include('backend.php');}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?><?php } ?> <?php wp_title(); ?></title>
<base href="<?php bloginfo('wpurl'); ?>/wp-content/themes/<?php echo get_template(); ?>" />

<script type="text/javascript">var siteurl = "<?php bloginfo('wpurl'); ?>";</script> 
<script type="text/javascript" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/<?php echo get_template(); ?>/javascript/utilities.js"></script> 
<script type="text/javascript" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/<?php echo get_template(); ?>/javascript/jquery.js"></script> 
<script type="text/javascript" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/<?php echo get_template(); ?>/javascript/frivolous.js"></script> 
<script type="text/javascript" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/<?php echo get_template(); ?>/javascript/threading.js"></script> 

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/<?= get_template(); ?>/reset.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/<?= get_template(); ?>/master.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/<?= get_template(); ?>/style.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/<?= get_template(); ?>/skins/<?= get_option('skin') ?>/style.css"  />
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('wpurl'); ?>/wp-content/themes/commentpress/style_ie.css" />
<![endif]-->
<?php wp_head(); ?>
</head>



<body>
<div id="container"> 
	<div id="header"> 
		<h1><a href="<?php bloginfo('url'); ?>"><? bloginfo('name'); ?></a></h1> 
		<h3 class="smLight">&nbsp;<?php bloginfo('description'); ?></h3>
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
		
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
