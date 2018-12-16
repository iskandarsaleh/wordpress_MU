<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php include (TEMPLATEPATH . '/right-sidebar.php'); ?>

<div id="content">
	<div id="page">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860nocolor"); } ?>
		<h1><?php the_title(); ?></h1>
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		<div class="entrytext">
			<?php the_content('<p class="serif">'.__('Read the rest of this page &raquo;','andreas09').'</p>'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
		</div>
		
		<?php link_pages('<p><strong>'.__('Pages','andreas09').':</strong> ', '</p>', 'number'); ?>
 		
		<?php endwhile; endif; ?>
	</div>

<?php comments_template(); ?>	
	<?php edit_post_link(__('Edit this entry.','andreas09'), '<p>', '</p>'); ?>

</div>

<?php get_footer(); ?>
