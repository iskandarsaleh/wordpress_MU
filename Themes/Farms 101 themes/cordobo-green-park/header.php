<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">


<head profile="http://gmpg.org/xfn/11">





<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php _e('Blog Archive');?> <?php } ?> <?php wp_title(); ?></title>





<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />






<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />


<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />


<link rel="shortcut icon" type="image/ico" href="<?php bloginfo('template_url'); ?>/favicon.ico" />





<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />





<?php wp_get_archives('type=monthly&format=link'); ?>


<?php //comments_popup_script(); // off by default ?>


<?php wp_head(); ?>





</head>





<body>


	





<div id="container">








<div id="skip">


	<p><a href="#content" title="Skip to site content">Skip to content</a></p>


	<p><a href="#search" title="Skip to search" accesskey="s">Skip to search - Accesskey = s</a></p>


</div> <!-- /skip -->








<div id="header">


	<div id="header_left_bg">


		<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>


	</div>


</div> <!-- /header -->








<?php /** To remove the grey bar beyond the green header, delete the following 5 lines (switch off wrapping of long lines) **/ ?>





<div id="single_post_right">


	<div id="single_post_left">


		<ul id="navlist"><li class="page_item"><a href="<?php bloginfo('url'); ?>"><?php _e('Home');?></a></li><?php wp_list_pages('title_li='); ?></ul>


	</div>


</div>





<?php /** Stop deleting here **/ ?>








<div id="wrapper">