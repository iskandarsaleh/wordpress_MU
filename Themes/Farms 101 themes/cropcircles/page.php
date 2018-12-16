<?php get_header(); ?>
	<div id="content" class="widecolumn">


    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
		<h2 class="posttitle" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
			<div class="entrytext"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
	<br />
				<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>

	<div class="navigation">

			<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">« Return Home</a></div>
	
			</div>
		</div>
	  <?php endwhile; endif; ?>
	</div>

<?php get_footer(); ?>