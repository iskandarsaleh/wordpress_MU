<?php get_header(); ?>

	<div id="content_box">
	
		<div id="content" class="pages">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("cutline-top"); } ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<h2><?php the_title(); ?></h2>	
			<div class="entry">		
				<p><?php the_content(__('Read the rest of this page &rarr;')); ?></p>
				
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
			</div>
	
			<h4><?php if ('open' == $post-> comment_status) { ?><a href="<?php the_permalink() ?>#comments"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a><?php } ?></h4>
				
			<?php endwhile; endif; ?>

			<?php if ( comments_open() ) comments_template(); ?>

		</div>

		<?php get_sidebar(); ?>

	</div>

<?php get_footer(); ?>