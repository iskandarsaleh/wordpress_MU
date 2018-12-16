<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


	
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php _e('Blog Archive');?> <?php } ?> <?php wp_title(); ?></title>

<?php global $letoprime; // Grab options from options page ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style type="text/css" media="screen">

	#header {

		<?php if ($letoprime->option['header_url'] && $letoprime->option['header_url'] != "") { ?>
		background: #fff url(<?php echo $letoprime->option['header_url']; ?>);
		<?php } else if ($letoprime->option['header'] && $letoprime->option['header'] != "none") { ?>
		background: #fff url(<?php bloginfo('stylesheet_directory'); ?>/header/header-<?php echo $letoprime->option['header']; ?>.jpg);
		<?php } else if ($letoprime->option['header'] == "none") { ?>
		height: 0 !important;
		margin: 0 !important;
		<?php } else { ?>
		background: #fff url(<?php bloginfo('stylesheet_directory'); ?>/header/header-cactus.jpg);
		<?php } ?>
	}
	
	
	#header h1 	{
		<?php if ($letoprime->option['header'] =="cactus") { ?>
<!--cactus header - adjust here -->	
	margin: 0;	
	font-size: 2.2em;	
	padding:20px 0 0 20px;
	text-align:left;}
	#header h1 a {color: white; text-decoration:none; }
	#header .description { color:black; text-align:left; padding-left: 20px;
	}
		<?php } else if ($letoprime->option['header'] =="mountain") { ?>
<!--mountain header - adjust here -->	
	margin: 0;	
	font-size: 1.6em;	
	padding:20px 20px 0 0;
	text-align:right;}
	#header h1 a {color: blue; text-decoration:none; }
	#header .description { color:black; text-align:right; padding-right: 20px;
	}
<!--flower header - adjust here -->
		<?php } else if ($letoprime->option['header'] =="flower") { ?>
	margin: 0;	
	font-size: 1.6em;	
	padding:20px 20px 0 0;
	text-align:right;}
	#header h1 a {color:blue; text-decoration:none; }
	#header .description { color:black; text-align:right; padding-right: 20px;
	 }
<!--leaf in light) header - adjust here -->
		<?php } else if ($letoprime->option['header'] =="leafinlight") { ?>
			margin: 0;	
	font-size: 2.0em;	
	width: 250px;
	padding:20px 0 0 25px  ;
	text-align:left; }
	#header h1 a {color: white; text-decoration:none; }
	#header .description { color:white; text-align:left; padding-left: 20px;
	 }
<!--meadow(tree) header - adjust here -->
		<?php } else if ($letoprime->option['header'] =="meadow") { ?>
			margin: 0;	
	font-size: 2.3em;	
	padding:80px 20px 0 0;
	text-align:right; }
	#header h1 a {color: white; text-decoration:none; }
	#header .description { color:white; text-align:right; padding-right: 20px;
	 }
<!--shark header - adjust here -->
		<?php } else if ($letoprime->option['header'] =="shark") { ?>
			margin: 0;	
	font-size: 2.3em;	
	padding:20px 20px 0 0;
	text-align:right; }
	#header h1 a {color:white; text-decoration:none; }
	#header .description { color:white; text-align:right; padding-right: 20px;
	 }
<!--very large array header - adjust here -->
		<?php } else if ($letoprime->option['header'] =="vla") { ?>
			margin: 0;	
	font-size: 1.6em;
	font-weight:bold;	
	padding:20px 20px 0 0;
	text-align:right; }
	#header h1 a {color:#0000ff; text-decoration:none; }
	#header .description { color:white; text-align:right; padding-right: 20px;
	 }
<?php } else { ?>
	margin: 0;	
	font-size: 2.2em;	
	padding:20px 0 0 20px;
	text-align:left;}
	#header h1 a {color: white; text-decoration:none; }
	#header .description { color:black; text-align:left; padding-left: 20px;
	} <?php } ?>
 </style>
<?php if (is_single() and ('open' == $post-> comment_status) or ('comment' == $post-> comment_type) ) { ?>
 	
<?php } ?>
<?php wp_head(); ?>

</head>
<body>
<div id="page">


<div id="header">
	<div id="headerimg">
	
		<h1><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div class="description"><?php bloginfo('description'); ?></div>
	</div>
<ul id="topnav"><li><a href="<?php echo get_settings('home'); ?>/">Home</a></ul>
</div>
<hr />
