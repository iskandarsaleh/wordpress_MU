<?php get_header(); ?>

<div id="wrapper">
	<div id="content" class="narrowcolumn">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" class="post">
			<div class="post-header"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860nocolor"); } ?>
				<h2 class="post-title"><?php the_title(); ?></h2>
			</div><!-- END POST-HEADER  -->
			<div class="post-entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<?php the_content('<span class="more-link">Continue Reading &raquo;</span>'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<?php link_pages('<p class="pagination">'.__('Pages').': ', '</p>', 'number'); ?>
				<?php edit_post_link('Edit Page', '<p>', '</p>'); ?>
			</div><!-- END POST-ENTRY -->
		</div><!-- END POST -->
		<!-- <?php trackback_rdf(); ?> -->

<?php endwhile; endif; ?>

	</div><!-- END CONTENT -->
</div><!-- END WRAPPER -->

<?php
get_sidebar(); 
get_footer(); 
?>