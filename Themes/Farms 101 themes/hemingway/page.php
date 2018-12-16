<?php get_header(); ?>

	<div id="primary">
	<div class="inside">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
	<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>

	
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
	  <?php endwhile; endif; ?>
	<?php edit_post_link(__('Edit this entry.'), '<p>', '</p>'); ?>
	</div>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>