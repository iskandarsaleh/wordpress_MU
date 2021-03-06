<?php get_header(); ?>

	<div id="content_box">
	
		<?php include (TEMPLATEPATH . '/l_sidebar.php'); ?>
	
		<div id="content" class="pages">
			<h2><?php _e('Easy, tiger. This is a 404 page.');?></h2>
			<div class="entry">
				<p><?php _e('You are <em>totally</em> in the wrong place. Do not pass GO; do not collect $200.');?></p>
				<p><?php _e('Instead, try one of the following:');?></p>
				<ul>
					<li><?php _e('Hit the "back" button on your browser.');?></li>
					<li><?php _e('Head on over to the');?> <a href="<?php bloginfo('url'); ?>"><?php _e('front page');?></a>.</li>
					<li><?php _e('Try searching using the form in the sidebar.');?></li>
					<li><?php _e('Click on a link in the sidebar.');?></li>
					<li><?php _e('Use the navigation menu at the top of the page.');?></li>
					<li><?php _e('Punt.');?></li>
				</ul>
			</div>
		</div>
		
		<?php include (TEMPLATEPATH . '/r_sidebar.php'); ?>
		
	</div>

<?php get_footer(); ?>