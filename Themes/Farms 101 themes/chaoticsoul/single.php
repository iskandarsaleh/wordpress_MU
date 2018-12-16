<?php get_header(); ?>

	<div id="content" class="widecolumn">

	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">
		<h2 class="title"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'chaoticsoul'), get_the_title()); ?>"><?php the_title(); ?></a></h2>

			<div class="entrytext">
				<?php the_content('<p class="serif">'.__('Read the rest of this entry &raquo;', 'chaoticsoul').'</p>'); ?>
				<?php link_pages('<p><strong>'.__('Pages:', 'chaoticsoul').'</strong> ', '</p>', 'number'); ?>
				<p class="authormeta">~ <?php _e('by', 'chaoticsoul'); ?> <?php the_author() ?> <?php _e('on'); ?> <? the_time(get_option("date_format")); ?>. <?php the_tags( ' ' . __( 'Tagged:' ) . ' ', ', ', ''); ?></p>
			</div>
		</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria.', 'chaoticsoul'); ?></p>

<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
