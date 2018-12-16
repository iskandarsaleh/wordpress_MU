<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

		<?php if (have_posts()) : ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for the');?> '<?php echo single_cat_title(); ?>' <?php _e('Category');?></h2>

 	 	 <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time(__('F jS, Y')); ?></h2>

	 	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('F, Y'); ?></h2>

		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle"><?php _e('Archive for');?>
    <?php the_time('Y'); ?></h2>

	  	<?php /* If this is a search */ } elseif (is_search()) { ?>
		<h2 class="pagetitle"><?php _e('Search Results');?></h2>

	  	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle"><?php _e('Author Archive');?></h2>

		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle"><?php _e('Blog Archives');?></h2>
		<?php } ?>


		<?php while (have_posts()) : the_post(); ?>
		<div class="post">

				<h3 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<h4><?php the_time(__('F jS, Y')) ?> <!-- by <?php the_author() ?> --></h4>

				<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
					<?php the_excerpt() ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>
				</div>

				<p class="postmetadata">
				<?php _e('Posted by');?> <?php the_author() ?> at <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_time() ?></a>
				& <?php _e('Filed under');?> <?php the_category(', ') ?> <strong>|</strong> <?php edit_post_link(__('Edit'), '','<strong>|</strong>'); ?>  <?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?>
				</p>

				<!--
				<?php trackback_rdf(); ?>
				--><br />
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php posts_nav_link('','',__('&laquo; Previous Entries')) ?></div>
			<div class="alignright"><?php posts_nav_link('',__('Next Entries &raquo;'),'') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found');?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>