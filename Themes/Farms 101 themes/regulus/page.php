<?php get_header(); ?>

	<div id="content">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<h2><?php
		// get the page id
		global $id;
		$bm_pageID = $id;
		the_title(); ?></h2>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		<?php the_content(); ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>

	<?php endwhile; endif;

	comments_template();

	?>
	 
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
