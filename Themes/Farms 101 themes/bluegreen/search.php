<?php get_header(); ?>



	<div id="content">



	<?php if (have_posts()) : ?>



		<h2 class="pagetitle"><?php _e('Search Results');?></h2>



		<?php while (have_posts()) : the_post(); ?>



			<div class="entry">

				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>

				<small><?php the_time('l, F jS, Y') ?></small>

<br /><br /><?php the_content_rss('', TRUE, '', 50); ?><br /><br />

				<p class="postmetadata"><?php _e('Posted in ');?> <?php the_category(', ') ?> | <?php edit_post_link(__('Edit'), '', ' | '); ?>  <?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></p>

			</div>



		<?php endwhile; ?>



		<div class="navigation">

			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>

			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>

		</div>



	<?php else : ?>

	<div class="entry">

		<h2 class="center"><?php _e('No posts found. Try a different search?');?></h2>



</div>

	<?php endif; ?>



	</div>



<?php get_sidebar(); ?>



<?php get_footer(); ?>