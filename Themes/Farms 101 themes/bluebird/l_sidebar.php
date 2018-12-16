<!-- begin l_sidebar -->

<div id="l_sidebar">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-bgb-bluebird"); } ?>
	<ul id="l_sidebarwidgeted">
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
	
	
	<h5><?php ('Recently Written');?></h5>
		<ul>
			<?php get_archives('postbypost', 10); ?>
		</ul>
	</li>

	
	<h5><?php _e('Categories');?></h5>
		<ul>
			<?php wp_list_cats('sort_column=name'); ?>
		</ul>
	</li>
		
	
	<h5><?php ('Archives');?></h5>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>

	
	
	<?php endif; ?>
	</ul>
	
</div>

<!-- end l_sidebar -->