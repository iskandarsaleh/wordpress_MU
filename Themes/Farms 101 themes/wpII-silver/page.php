<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entrybody"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>

			<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>
		</div>
		<?php endwhile; endif; ?>
		<?php edit_post_link(__('Edit this entry.'), '<p>', '</p>'); ?>
		</div>
</div>

<?php get_footer(); ?>