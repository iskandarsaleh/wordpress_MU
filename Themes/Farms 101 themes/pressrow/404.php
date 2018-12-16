<?php get_header(); ?>

		<div id="content_box">
		
			<div id="content">
				<div class="post entry">
			<h2><?php _e('Easy, tiger. This is a 404 page.');?></h2>
				<p><?php _e('You are <em>totally</em> in the wrong place. Do not pass GO; do not collect $200.');?></p>
				<p><?php _e('Instead, try one of the following:');?></p>
				<ul>
					<li><?php _e('Hit the "back" button on your browser.');?></li>
					<li><?php _e('Head on over to the');?> <a href="<?php bloginfo('url'); ?>"><?php _e('front page');?></a>.</li>
				</div>
			</div>

			<?php get_sidebar(); ?>
			
		</div>

<?php get_footer(); ?>