<?php get_header(); ?>

	<div id="content" class="widecolumn">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
		<?php if (have_posts()) : ?>

		 <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="title"><?php printf(__("Archive for the '%s' Category", 'chaoticsoul'), single_cat_title('', false)); ?></h2>

 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="title"><?php printf(__('Archive for %s', 'chaoticsoul'), get_the_time('F jS, Y')); ?></h2>

	 <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="title"><?php printf(__('Archive for %s', 'chaoticsoul'), get_the_time('F, Y')); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="title"><?php printf(__('Archive for %s', 'chaoticsoul'), get_the_time('Y')); ?></h2>

	  <?php /* If this is a search */ } elseif (is_search()) { ?>
		  <h2 class="title"><?php _e('Search Results', 'chaoticsoul'); ?></h2>

	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		  <h2 class="title"><?php _e('Author Archive', 'chaoticsoul'); ?></h2>

		<?php /* If this is a paged archive */ } elseif (is_paged()) { ?>
		<h2 class="title"><?php _e('Blog Archives', 'chaoticsoul'); ?></h2>

		<?php } ?>

		<?php while (have_posts()) : the_post(); ?>
		<div class="post">
			<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'chaoticsoul'), get_the_title()); ?>"><?php the_title(); ?></a></h3>
			&bull; <?php the_time(get_option('date_format')) ?>
			<p class="postmetadata"><?php printf(__('Posted in %s', 'chaoticsoul'), get_the_category_list(', ')); ?> | <?php edit_post_link(__('Edit', 'chaoticsoul'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;', 'chaoticsoul'), __('1 Comment &#187;', 'chaoticsoul'), __('% Comments &#187;', 'chaoticsoul')); ?></p> 
		</div>
		
		<br />

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries', 'chaoticsoul')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;', 'chaoticsoul')) ?></div>
		</div>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found', 'chaoticsoul'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
