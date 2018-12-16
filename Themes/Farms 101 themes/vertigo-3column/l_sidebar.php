<!-- begin l_sidebar -->

<div id="l_sidebar">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
	<ul id="l_sidebarwidgeted">
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
	
	<li id="Recent">
	<h2>Recently Written</h2>
		<ul>
			<?php get_archives('postbypost', 10); ?>
		</ul>
	</li>

	<li id="Categories">
	<h2><?php _e('Categories');?></h2>
		<ul>
			<?php wp_list_cats('sort_column=name'); ?>
		</ul>
	</li>
		
	<li id="Archives">
	<h2><?php _e('Archives');?></h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>

	<li id="Admin">
	<h2>Admin</h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="http://wordpress.org/">WordPress</a></li>
			<?php wp_meta(); ?>
			<li><a href="http://validator.w3.org/check?uri=referer">XHTML</a></li>
		</ul>

	<?php endif; ?>
	</ul>
	
</div>

<!-- end l_sidebar -->