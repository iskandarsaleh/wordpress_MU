<?php get_header(); ?>

	<div id="content" class="narrowcolumn">
<div id="headerimg">
		<a href="<?php echo get_settings('home'); ?>"><img src="<?php header_image() ?>" width="480" height="200" /></a>
	</div>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-jakarta-top"); } ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post">
		<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
			<div class="entrytext">
				<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?>
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
	
			</div>
		</div>
	  <?php endwhile; endif; ?>
	<?php edit_post_link(__('Edit this entry.'), '<p>', '</p>'); ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>