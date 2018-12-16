<?php get_header(); ?>

	<div id="content" class="narrowcolumn"><br /><br /><br /><br />
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-contempt-top"); } ?>

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
			
				<?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>','contempt')); ?>
	
				<?php link_pages(__('<p><strong>'.__('Pages:').'</strong> ','contempt'), '</p>', 'number'); ?>
	
			</div>
		</div>
	  <?php endwhile; endif; ?>
	<?php edit_post_link(__('Edit this entry.','contempt'), '<p>', '</p>'); ?>

	<?php if ( comments_open() ) comments_template(); // Get wp-comments.php template ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-contempt-bottom"); } ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>