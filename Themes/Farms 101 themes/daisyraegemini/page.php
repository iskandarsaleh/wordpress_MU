<?php get_header(); ?>

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-daisy-rae-top"); } ?>

	<div id="static">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post">
		<h3 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h3>
			<div class="entrytext">
			
				<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?>

				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
	
			</div>
		</div>
	  <?php endwhile; endif; ?>
	
	</div>



<?php get_footer(); ?>
