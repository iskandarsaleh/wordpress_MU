<?php get_header(); ?>
<?php get_sidebar(); ?>
	<div id="main">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
	    <h1><?php the_title(); ?></h1>
		<p><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			<?php the_content('<p>Read the rest of this page &raquo;</p>'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>
		</p>
		<?php endwhile; endif; ?>
	    <?php edit_post_link(__('Edit'), '<p class="post-footer align-right">','</p>'); ?>
	  
	</div>
<?php include (TEMPLATEPATH . '/rbar.php'); ?>
<?php get_footer(); ?>