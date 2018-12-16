<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head profile="http://gmpg.org/xfn/11">
	
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		
		<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php _e('Blog Archive');?> <?php } ?> <?php wp_title(); ?></title>
		
		
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
		<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		
		<style type="text/css" media="screen">
			@import url("<?php bloginfo('stylesheet_url'); ?>");
			
			/* Styling Info if you've selected the green colour scheme! */
			
			<?php if (get_option('dd_colour_scheme') == "Green") { ?>
			
			
				.tags_page h2, a, .post h2, .post .data, .post h3, .sanda h2, h2, h3, #commentformarea h3, h4, #commentform input#submit, .aside a, .aside p.postmetadata a { color: #006600; }
				a:hover, .post h2 a:hover, .post .data a:hover, .post .postmetadata a:hover, #content .postmetadata a:hover, .sanda h3 a:hover, .entry a:hover, .aside a:hover, #content .aside p.postmetadata a:hover, #sidebar a:hover { color: #003300; }
				
				ol.commentlist div.cmntmeta, .aside .entry, #sidebar li h2, #sidebar a  { color: #339900; }
				ol.commentlist li {	border-top: 1px solid #C0DFB0; }
					
				#header { background: #010300 url("<?php bloginfo('template_directory'); ?>/images/header_green.jpg"); }
				
				#topbar { background: #006600; border-bottom: 2px solid #339900; }
				#topbar ul li a:hover { background: #339900; }
				
				blockquote { border-left: 3px solid #5CAD33; }
				
				#topbar .feedicon {	background: url("<?php bloginfo('template_directory'); ?>/images/feedicon_green_bg.png") no-repeat; }
			
			
			<?php } else if (get_option('dd_colour_scheme') == "Pink") { ?>
			
			
				.tags_page h2, a, .post h2, .post .data, .post h3, .sanda h2, h2, h3, #commentformarea h3, h4, #commentform input#submit, .aside a, #content .aside p.postmetadata a { color: #FF66CC; }
				a:hover, .post h2 a:hover, .post .data a:hover, .post .postmetadata a:hover, #content .postmetadata a:hover, .sanda h3 a:hover, .entry a:hover, .aside a:hover, #content .aside p.postmetadata a:hover, #sidebar a:hover { color: #CC0066; }
				
				ol.commentlist div.cmntmeta, .aside .entry, #sidebar li h2, #sidebar a { color: #FF33FF; }
				ol.commentlist li {	border-top: 1px solid #FFD6FF; }
					
				#header { background: #F98BB3 url("<?php bloginfo('template_directory'); ?>/images/header_pink.jpg"); }
				
				#topbar { background: #D02A57; border-bottom: 2px solid #FF66CC; }
				#topbar ul li a:hover { background: #FF66CC; }
				
				blockquote { border-left: 3px solid #FF94DB; }
				
				#topbar .feedicon {	background: url("<?php bloginfo('template_directory'); ?>/images/feedicon_pink_bg.png") no-repeat; }
		
			
			<?php } else if (get_option('dd_colour_scheme') == "Grey") { ?>
			
				.tags_page h2, a, .post h2, .post .data, .post h3, .sanda h2, h2, h3, #commentformarea h3, h4, #commentform input#submit, .aside a, #content .aside p.postmetadata a { color: #333; }
				a:hover, .post h2 a:hover, .post .data a:hover, .post .postmetadata a:hover, #content .postmetadata a:hover, .sanda h3 a:hover, .entry a:hover, .aside a:hover, #content .aside p.postmetadata a:hover, #sidebar a:hover { color: #999; }
				
				.entry a { color: #666; }
				
				ol.commentlist div.cmntmeta, .aside .entry, #sidebar li h2, #sidebar a { color: #707070; }
				ol.commentlist li {	border-top: 1px solid #E5E5E5; }
					
				#header { background: #333; }
				
				#topbar { background: #333; border-bottom: 2px solid #666; }
				#topbar ul li a:hover { background: #666; }
				
				blockquote { border-left: 3px solid #707070; }
				
				#topbar .feedicon {	background: url("<?php bloginfo('template_directory'); ?>/images/feedicon_grey_bg.png") no-repeat; }
			
			<?php } ?>
			
			
			
				<?php if (get_option('dd_title') == "centre") { ?>
					
					h1, .description { text-align: center; }
				
				<?php } else if (get_option('dd_title') == "right") { ?>
				
					h1, .description { text-align: right; }
				
				<?php } ?>
				
				
			
		</style>
		
		<?php wp_head(); ?>
	
	</head>
	
	
	<body>
	
		<div id="wrapper">
	
	
		<div id="header">

				<h1><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
				<div class="description"><?php bloginfo('description'); ?></div>
			
		</div>
		
		<div id="topbar">
			<ul>
				<li>
				<?php if (get_option('dd_menu_home') == "yes") {
				?> <a href="<?php bloginfo('url'); ?>"><?php _e('Home');?></a> <?php
				} ?>
				</li>
				<?php 
					if (get_option('dd_menu_order') == "alpha") { 
						wp_list_pages('sort_column=post_title&title_li=' );
					} else if (get_option('dd_menu_order') == "by_id") {
						wp_list_pages('sort_column=ID&title_li=' );
					} else if (get_option('dd_menu_order') == "menu_order") {
						wp_list_pages('sort_column=menu_order&title_li=' );
					} else {
						wp_list_pages('title_li=' );
					}					
				?>	
			</ul>
			<a href="<?php bloginfo('rss2_url'); ?>" class="feedicon"></a>
		</div>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860nocolor"); } ?>
