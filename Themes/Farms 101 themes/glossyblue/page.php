<?php get_header(); ?>
  <div id="content">
  <?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-glossyblue-top"); } ?>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
    <div class="post" id="post-<?php the_ID(); ?>">
        <h2><?php the_title(); ?></h2>
        <div class="post-content">
			<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?>

			<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>
        </div>
    </div>
	
  <?php endwhile; endif; ?>

  </div><!--/content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>