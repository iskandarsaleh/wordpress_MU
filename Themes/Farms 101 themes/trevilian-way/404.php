<?php get_header(); ?>

<body id="body-404">

<div id="intro">
	
	<span id="page-id">404</span>
	
	<div id="identity">
		
		<h1><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
		<div id="main-nav">
			<ul>
			<?php
				wp_list_pages('title_li=&sort_column=menu_order&depth=1');
			?>
			</ul>
		</div>
		
	</div>
		
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	
	<span class="clearer"></span>

</div>

<div id="summary">

	<div class="post-summary">
		<h2 class="page-title">Error: Not Found</h2>
	</div>	
	
	<span class="clearer"></span>

</div>	

<div id="post-content">

	<p>Sorry, what you are looking for can't be found, try searching for it.</p>
	
</div>

<?php get_footer(); ?>
