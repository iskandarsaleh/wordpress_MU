<?php get_header(); ?>
		
	<div id="content_box">


		<div id="content" class="posts">
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("cutline-top"); } ?>
		<?php if (have_posts()) : ?>

			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	
			<?php /* If this is a category archive */ if (is_category()) { ?>				
			<h2 class="archive_head"><?php _e('Entries Tagged as');?> '<?php echo single_cat_title(); ?>'</h2>
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h2 class="archive_head"><?php _e('Entries from');?> <?php the_time('F Y'); ?></h2>
			
			<?php /* If this is a search */ } elseif (is_search()) { ?>
			<h2 class="archive_head"><?php _e('Search Results');?></h2>

			<?php } ?>

			<?php while (have_posts()) : the_post(); ?>
			
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<h4><?php the_time(__('F jS, Y')) ?><!-- by <?php the_author() ?> --> &middot; <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></h4>
			<div class="entry">
				
				<?php the_content() ?>
				
			</div>
			<p class="tagged"><strong><?php _e('Tags');?>:</strong> <?php the_category(' &middot; ') ?></p>
			
			<?php endwhile; ?>
			
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>

		<?php else : ?>
		
			<h2 class="page_header"><?php _e("Welp, we couldn't find that...try again?");?></h2>
			<div class="entry">
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
			
		<?php endif; ?>
			
		</div>
	
		<?php get_sidebar(); ?>
		
	</div>
		
<?php get_footer(); ?>
