<?php get_header(); ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div class="entry" id="post-<?php the_ID(); ?>">

		<h2><?php the_title(); ?></h2>
			<div align="center">	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?></div>	<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?><div align="center">	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?></div>	
	
				<?php link_pages('<p><strong>'.__('Pages').':</strong> ', '</p>', 'number'); ?>

  <?php endwhile; endif; ?>
	<?php edit_post_link(__('Edit this entry.'), '<p>', '</p>'); ?>
	
			</div>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>